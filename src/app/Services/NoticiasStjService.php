<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class NoticiasStjService
{
    private const URL_RSS = 'https://res.stj.jus.br/hrestp-c-portalp/RSS.xml';

    private const CACHE_NOTICIAS = 'site_noticias_stj_v2_imagens';

    private const CACHE_RESERVA = 'site_noticias_stj_reserva_v2_imagens';

    public function listar(): Collection
    {
        $noticias = Cache::get(self::CACHE_NOTICIAS);

        if (!is_array($noticias)) {
            try {
                $noticias = $this->consultarNoticiasDoStj();

                // Atualiza a lista a cada 60 minutos, sem requisitar o RSS por visitante.
                Cache::put(self::CACHE_NOTICIAS, $noticias, now()->addHour());

                // Preserva notícias reais da última consulta bem-sucedida.
                Cache::put(self::CACHE_RESERVA, $noticias, now()->addDays(7));
            } catch (Throwable $erro) {
                Log::warning('Não foi possível atualizar as notícias do STJ.', [
                    'mensagem' => $erro->getMessage(),
                ]);

                $noticias = Cache::get(self::CACHE_RESERVA, []);

                if (!is_array($noticias)) {
                    $noticias = [];
                }

                // Em caso de falha, nova tentativa em cinco minutos.
                Cache::put(self::CACHE_NOTICIAS, $noticias, now()->addMinutes(5));
            }
        }

        // As duas páginas consomem a mesma coleção e as mesmas imagens em cache.
        return collect($noticias);
    }

    private function consultarNoticiasDoStj(): array
    {
        if (!function_exists('simplexml_load_string')) {
            throw new RuntimeException(
                'A extensão PHP SimpleXML não está habilitada no container.'
            );
        }

        $resposta = Http::timeout(15)
            ->retry(2, 400)
            ->get(self::URL_RSS);

        if (!$resposta->successful()) {
            throw new RuntimeException(
                'O feed RSS retornou HTTP ' . $resposta->status()
            );
        }

        $estadoAnterior = libxml_use_internal_errors(true);

        try {
            $xml = simplexml_load_string(
                $resposta->body(),
                \SimpleXMLElement::class,
                LIBXML_NONET | LIBXML_NOCDATA
            );
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($estadoAnterior);
        }

        if ($xml === false || !isset($xml->channel->item)) {
            throw new RuntimeException('O STJ retornou um RSS inválido ou vazio.');
        }

        $noticias = [];
        $urlsUtilizadas = [];

        foreach ($xml->channel->item as $item) {
            $titulo = $this->limparTexto((string) $item->title);
            $url = trim((string) $item->link);
            $host = strtolower((string) parse_url($url, PHP_URL_HOST));
            $protocolo = strtolower((string) parse_url($url, PHP_URL_SCHEME));

            // Só apresenta links de notícias do domínio oficial do STJ.
            if (
                $titulo === '' ||
                !filter_var($url, FILTER_VALIDATE_URL) ||
                !in_array($protocolo, ['http', 'https'], true) ||
                !($host === 'stj.jus.br' || str_ends_with($host, '.stj.jus.br')) ||
                isset($urlsUtilizadas[$url])
            ) {
                continue;
            }

            $urlsUtilizadas[$url] = true;

            $resumo = $this->limparTexto((string) $item->description);
            $categoria = $this->limparTexto((string) $item->category);

            if ($categoria === '') {
                $categoria = 'Notícias STJ';
            }

            $data = 'Data não informada';
            $dataOriginal = trim((string) $item->pubDate);

            if ($dataOriginal !== '') {
                try {
                    $data = Carbon::parse($dataOriginal)
                        ->locale('pt_BR')
                        ->translatedFormat('d \\d\\e F \\d\\e Y');
                } catch (Throwable $erro) {
                    // Datas inválidas não impedem a exibição das demais notícias.
                }
            }

            $noticias[] = [
                'id' => sha1($url),
                'categoria' => Str::limit($categoria, 45),
                'titulo' => $titulo,
                'resumo' => $resumo !== ''
                    ? Str::limit($resumo, 190)
                    : 'Acesse a notícia completa no portal oficial do STJ.',
                'data' => $data,
                // Prioriza imagem da notícia no próprio feed RSS.
                'imagem' => $this->buscarImagemNoRss($item, $url)
                    ?? 'conexao360/img/vista.png',
                'url' => $url,
            ];

            if (count($noticias) >= 30) {
                break;
            }
        }

        if ($noticias === []) {
            throw new RuntimeException('Nenhuma notícia válida foi encontrada no feed STJ.');
        }

        // Apenas notícias sem foto no RSS precisam consultar a página original.
        $this->completarImagensDasNoticias($noticias);

        return $noticias;
    }

    /**
     * Procura a imagem nas tags oficiais usuais do RSS:
     * media:content, media:thumbnail, enclosure e HTML da description.
     */
    private function buscarImagemNoRss(\SimpleXMLElement $item, string $pagina): ?string
    {
        $namespaces = $item->getNamespaces(true);

        if (isset($namespaces['media'])) {
            $media = $item->children($namespaces['media']);

            foreach (['content', 'thumbnail'] as $tag) {
                foreach ($media->{$tag} as $node) {
                    $atributos = $node->attributes();
                    $imagem = $this->validarImagem((string) ($atributos['url'] ?? ''), $pagina);

                    if ($imagem !== null) {
                        return $imagem;
                    }
                }
            }
        }

        foreach ($item->enclosure as $enclosure) {
            $atributos = $enclosure->attributes();
            $tipo = strtolower((string) ($atributos['type'] ?? ''));

            if (str_starts_with($tipo, 'image/')) {
                $imagem = $this->validarImagem((string) ($atributos['url'] ?? ''), $pagina);

                if ($imagem !== null) {
                    return $imagem;
                }
            }
        }

        $descricao = (string) $item->description;

        if (preg_match('~<img\\b[^>]*\\bsrc\\s*=\\s*["\\\']([^"\\\']+)["\\\']~i', $descricao, $match)) {
            return $this->validarImagem($match[1], $pagina);
        }

        return null;
    }

    /**
     * Procura og:image e twitter:image nas matérias que vieram sem foto no RSS.
     * Processa até 5 páginas por lote para reduzir o tempo do primeiro carregamento.
     * Cada imagem fica em cache, evitando novos acessos ao site de origem.
     */
    private function completarImagensDasNoticias(array &$noticias): void
    {
        $padrao = 'conexao360/img/vista.png';
        $pendentes = [];

        foreach ($noticias as $indice => &$noticia) {
            if ($noticia['imagem'] !== $padrao) {
                continue;
            }

            $chave = 'stj_imagem_v2_' . sha1($noticia['url']);
            $imagemSalva = Cache::get($chave);

            if (is_string($imagemSalva)) {
                $noticia['imagem'] = $imagemSalva;
            } else {
                $pendentes[$indice] = [
                    'url' => $noticia['url'],
                    'chave' => $chave,
                ];
            }
        }
        unset($noticia);

        foreach (array_chunk($pendentes, 5, true) as $lote) {
            try {
                $respostas = Http::pool(function (Pool $pool) use ($lote) {
                    $requisicoes = [];

                    foreach ($lote as $indice => $dados) {
                        $requisicoes[] = $pool
                            ->as((string) $indice)
                            ->timeout(8)
                            ->withHeaders(['Accept' => 'text/html'])
                            ->get($dados['url']);
                    }

                    return $requisicoes;
                });
            } catch (Throwable $erro) {
                Log::warning('Falha ao consultar imagens das matérias do STJ.', [
                    'erro' => $erro->getMessage(),
                ]);
                $respostas = [];
            }

            foreach ($lote as $indice => $dados) {
                $resposta = $respostas[(string) $indice] ?? null;
                $imagem = null;

                if ($resposta instanceof Response && $resposta->successful()) {
                    $imagem = $this->imagemDosMetadados($resposta->body(), $dados['url']);
                }

                $imagemFinal = $imagem ?? $padrao;
                $noticias[$indice]['imagem'] = $imagemFinal;

                Cache::put(
                    $dados['chave'],
                    $imagemFinal,
                    $imagem !== null ? now()->addDays(7) : now()->addHour()
                );
            }
        }
    }

    /**
     * Lê somente metadados de imagem do artigo original.
     * Se não existir og:image/twitter:image, deixa o fallback local.
     */
    private function imagemDosMetadados(string $html, string $url): ?string
    {
        if (!class_exists(\DOMDocument::class)) {
            return null;
        }

        $anterior = libxml_use_internal_errors(true);

        try {
            $documento = new \DOMDocument();

            if (!$documento->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING)) {
                return null;
            }

            $xpath = new \DOMXPath($documento);
            $metas = $xpath->query(
                '//meta[@property="og:image" or @property="og:image:url" ' .
                'or @name="twitter:image" or @name="twitter:image:src"]'
            );

            foreach ($metas ?: [] as $meta) {
                $imagem = $this->validarImagem($meta->getAttribute('content'), $url);

                if ($imagem !== null) {
                    return $imagem;
                }
            }

            $links = $xpath->query('//link[@rel="image_src"]');

            foreach ($links ?: [] as $link) {
                $imagem = $this->validarImagem($link->getAttribute('href'), $url);

                if ($imagem !== null) {
                    return $imagem;
                }
            }
        } catch (Throwable $erro) {
            return null;
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($anterior);
        }

        return null;
    }

    /**
     * Aceita apenas imagens hospedadas em HTTPS nos domínios oficiais do STJ.
     * Também transforma endereços relativos em URLs absolutas.
     */
    private function validarImagem(string $imagem, string $pagina): ?string
    {
        $imagem = trim(html_entity_decode($imagem, ENT_QUOTES | ENT_HTML5, 'UTF-8'));

        if ($imagem === '' || str_starts_with($imagem, 'data:')) {
            return null;
        }

        $hostPagina = strtolower((string) parse_url($pagina, PHP_URL_HOST));

        if (str_starts_with($imagem, '//')) {
            $imagem = 'https:' . $imagem;
        } elseif (str_starts_with($imagem, '/')) {
            $imagem = 'https://' . $hostPagina . $imagem;
        } elseif (!preg_match('~^https?://~i', $imagem)) {
            $caminho = dirname((string) parse_url($pagina, PHP_URL_PATH));
            $imagem = 'https://' . $hostPagina . rtrim($caminho, '/') . '/' . $imagem;
        }

        $host = strtolower((string) parse_url($imagem, PHP_URL_HOST));
        $protocolo = strtolower((string) parse_url($imagem, PHP_URL_SCHEME));

        if (
            !filter_var($imagem, FILTER_VALIDATE_URL) ||
            !in_array($protocolo, ['http', 'https'], true) ||
            !($host === 'stj.jus.br' || str_ends_with($host, '.stj.jus.br'))
        ) {
            return null;
        }

        return $imagem;
    }

    private function limparTexto(string $texto): string
    {
        $texto = html_entity_decode(
            strip_tags($texto),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        return trim(preg_replace('/\s+/u', ' ', $texto) ?? $texto);
    }
}
