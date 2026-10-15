<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Route as LaravelRoute;
use Illuminate\Support\Facades\Route;

class ApiDocumentationController extends Controller
{
    public function index()
    {
        $rotas = collect(Route::getRoutes()->getRoutes())
            ->filter(
                fn (LaravelRoute $route) =>
                    str_starts_with($route->uri(), 'api/v1')
            )
            ->flatMap(function (LaravelRoute $route) {
                return collect($route->methods())
                    ->reject(
                        fn (string $metodo) =>
                            in_array($metodo, ['HEAD', 'OPTIONS'], true)
                    )
                    ->map(
                        fn (string $metodo) =>
                            $this->montarEndpoint($route, $metodo)
                    );
            })
            ->sortBy([
                ['grupo_ordem', 'asc'],
                ['uri', 'asc'],
                ['metodo_ordem', 'asc'],
            ])
            ->values();

        $totalRotas = $rotas->count();
        $rotasProtegidas = $rotas->where('autenticado', true)->count();
        $rotasPublicas = $totalRotas - $rotasProtegidas;
        $grupos = $rotas->groupBy('grupo');
        $recursos = $this->montarStatusRecursos($rotas);

        return view(
            'api.documentacao',
            compact(
                'rotas',
                'totalRotas',
                'rotasProtegidas',
                'rotasPublicas',
                'grupos',
                'recursos'
            )
        );
    }

    private function montarEndpoint(
        LaravelRoute $route,
        string $metodo
    ): array {
        $uri = '/' . ltrim($route->uri(), '/');
        $chave = $metodo . ' ' . $route->uri();
        $meta = $this->metadados()[$chave] ?? [];

        $middlewares = collect($route->gatherMiddleware());

        $autenticado = $middlewares->contains(
            fn ($middleware) =>
                is_string($middleware)
                && str_contains($middleware, 'auth:sanctum')
        );

        $controller = $route->getActionName();

        if (str_contains($controller, '\\')) {
            $controllerClass = str($controller)->before('@')->toString();
            $controllerMethod = str_contains($controller, '@')
                ? str($controller)->after('@')->toString()
                : null;

            $controller = class_basename($controllerClass)
                . ($controllerMethod ? '@' . $controllerMethod : '');
        }

        $grupo = $meta['grupo'] ?? $this->detectarGrupo($route->uri());

        return [
            'metodo' => $metodo,
            'metodo_ordem' => $this->ordemMetodo($metodo),
            'uri' => $uri,
            'autenticado' => $autenticado,
            'autenticacao' => $autenticado ? 'Bearer Token' : 'Pública',
            'controller' => $controller,
            'descricao' => $meta['descricao']
                ?? 'Endpoint disponível na API Conexão 360°.',
            'grupo' => $grupo,
            'grupo_ordem' => $this->ordemGrupo($grupo),
            'body' => $meta['body'] ?? [],
            'content_type' => $meta['content_type'] ?? 'application/json',
            'response' => $meta['response'] ?? [
                'success' => true,
                'data' => [],
            ],
            'erros' => $meta['erros'] ?? [],
            'regras' => $meta['regras'] ?? [],
            'parametros' => $this->extrairParametros($route->uri()),
            'curl' => $this->montarCurl(
                $metodo,
                $uri,
                $autenticado,
                $meta['body'] ?? [],
                $meta['content_type'] ?? 'application/json'
            ),
        ];
    }

    private function metadados(): array
    {
        return [
            'GET api/v1/status' => [
                'grupo' => 'Visão geral',
                'descricao' => 'Consulta o estado básico da API.',
                'response' => [
                    'success' => true,
                ],
            ],

            'POST api/v1/auth/login' => [
                'grupo' => 'Autenticação',
                'descricao' => 'Autentica um usuário do aplicativo e retorna um token Laravel Sanctum.',
                'body' => [
                    'email' => 'email@exemplo.com',
                    'senha' => 'senha_exemplo',
                    'device_name' => 'app-conexao360',
                ],
                'response' => [
                    'success' => true,
                    'message' => 'Login realizado com sucesso.',
                    'data' => [
                        'token' => 'SEU_TOKEN',
                        'usuario' => [
                            'id_usuario' => 'ID_USUARIO',
                            'nome_usuario' => 'Usuário Exemplo',
                            'email_usuario' => 'email@exemplo.com',
                            'perfil_usuario' => 'usuario',
                        ],
                    ],
                ],
                'regras' => [
                    'O usuário precisa existir.',
                    'A senha é validada contra senha_usuario.',
                    'O usuário precisa estar ativo.',
                ],
            ],

            'POST api/v1/auth/logout' => [
                'grupo' => 'Autenticação',
                'descricao' => 'Revoga o token de acesso atual do usuário autenticado.',
                'response' => [
                    'success' => true,
                    'message' => 'Logout realizado com sucesso.',
                ],
            ],

            'GET api/v1/usuario' => [
                'grupo' => 'Usuários',
                'descricao' => 'Retorna os dados do usuário atualmente autenticado.',
                'response' => [
                    'success' => true,
                    'data' => [
                        'id_usuario' => 'ID_USUARIO',
                        'nome_usuario' => 'Usuário Exemplo',
                        'foto_usuario' => null,
                        'email_usuario' => 'email@exemplo.com',
                        'perfil_usuario' => 'usuario',
                    ],
                ],
            ],

            'GET api/v1/usuarios/{idUsuario}' => [
                'grupo' => 'Perfis',
                'descricao' => 'Retorna o perfil público de um usuário e o estado da conexão com o usuário autenticado.',
                'response' => [
                    'success' => true,
                    'data' => [
                        'usuario' => [
                            'id_usuario' => 'ID_USUARIO',
                            'nome_usuario' => 'Usuário Exemplo',
                            'foto_usuario' => null,
                        ],
                        'conexoes_count' => 0,
                        'status_conexao' => 'SEM_CONEXAO',
                        'id_conexao' => null,
                        'pode_conectar' => true,
                    ],
                ],
            ],

            'GET api/v1/publicacoes' => [
                'grupo' => 'Publicações',
                'descricao' => 'Lista as publicações que podem aparecer no feed do usuário autenticado.',
                'response' => [
                    'success' => true,
                    'data' => [
                        [
                            'id_publicacao' => 'ID_PUBLICACAO',
                            'texto_publicacao' => 'Exemplo de publicação',
                            'tipo_midia_publicacao' => null,
                            'midia_publicacao' => null,
                            'status_publicacao' => 'ATIVO',
                            'curtidas_count' => 0,
                            'comentarios_count' => 0,
                            'curtido_por_mim' => false,
                        ],
                    ],
                ],
                'regras' => [
                    'Exibe publicações ATIVO.',
                    'O próprio usuário pode visualizar as próprias publicações.',
                    'Publicações de administradores e palestrantes podem compor o feed.',
                    'Publicações de usuários comuns dependem da regra de conexão aplicada pelo controller.',
                ],
            ],

            'POST api/v1/publicacoes' => [
                'grupo' => 'Publicações',
                'descricao' => 'Cria uma publicação de texto e/ou imagem para o usuário autenticado.',
                'content_type' => 'multipart/form-data',
                'body' => [
                    'texto_publicacao' => 'Texto da publicação',
                    'midia_publicacao' => 'arquivo.jpg',
                ],
                'response' => [
                    'success' => true,
                    'message' => 'Publicação criada com sucesso.',
                    'data' => [
                        'id_publicacao' => 'ID_PUBLICACAO',
                        'status_publicacao' => 'ATIVO',
                    ],
                ],
                'regras' => [
                    'Texto e mídia seguem as validações atuais do PublicacaoController.',
                    'O upload utiliza multipart/form-data.',
                    'A publicação é associada ao usuário autenticado.',
                ],
            ],

            'POST api/v1/publicacoes/{id}/curtidas' => [
                'grupo' => 'Curtidas',
                'descricao' => 'Registra a curtida do usuário autenticado em uma publicação.',
                'response' => [
                    'success' => true,
                    'data' => [
                        'curtido_por_mim' => true,
                        'curtidas_count' => 1,
                    ],
                ],
            ],

            'DELETE api/v1/publicacoes/{id}/curtidas' => [
                'grupo' => 'Curtidas',
                'descricao' => 'Remove a curtida do usuário autenticado de uma publicação.',
                'response' => [
                    'success' => true,
                    'data' => [
                        'curtido_por_mim' => false,
                        'curtidas_count' => 0,
                    ],
                ],
            ],

            'GET api/v1/publicacoes/{id}/comentarios' => [
                'grupo' => 'Comentários',
                'descricao' => 'Lista os comentários disponíveis para uma publicação.',
                'response' => [
                    'success' => true,
                    'data' => [],
                ],
            ],

            'POST api/v1/publicacoes/{id}/comentarios' => [
                'grupo' => 'Comentários',
                'descricao' => 'Cria um comentário na publicação informada.',
                'body' => [
                    'texto' => 'Comentário de exemplo',
                ],
                'response' => [
                    'success' => true,
                    'message' => 'Comentário criado com sucesso.',
                    'data' => [
                        'comentario' => [
                            'id_comentario_publicacao' => 'ID_COMENTARIO',
                            'texto_comentario_publicacao' => 'Comentário de exemplo',
                        ],
                        'comentarios_count' => 1,
                    ],
                ],
            ],

            'GET api/v1/conexoes' => [
                'grupo' => 'Conexões',
                'descricao' => 'Lista as conexões aceitas do usuário autenticado.',
                'response' => [
                    'success' => true,
                    'data' => [],
                ],
                'regras' => [
                    'A conexão precisa possuir status ACEITA.',
                    'O usuário autenticado precisa participar da conexão.',
                ],
            ],

            'GET api/v1/conexoes/enviadas' => [
                'grupo' => 'Conexões',
                'descricao' => 'Lista solicitações de conexão pendentes enviadas pelo usuário autenticado.',
                'response' => [
                    'success' => true,
                    'data' => [],
                ],
            ],

            'GET api/v1/conexoes/solicitacoes' => [
                'grupo' => 'Conexões',
                'descricao' => 'Lista solicitações de conexão pendentes recebidas pelo usuário autenticado.',
                'response' => [
                    'success' => true,
                    'data' => [],
                ],
            ],

            'POST api/v1/conexoes/{idUsuario}' => [
                'grupo' => 'Conexões',
                'descricao' => 'Envia uma solicitação de conexão para outro usuário.',
                'response' => [
                    'success' => true,
                    'message' => 'Solicitação de conexão enviada.',
                    'data' => [
                        'id_conexao' => 'ID_CONEXAO',
                        'id_usuario_destino' => 'ID_USUARIO',
                        'status_conexao' => 'PENDENTE',
                    ],
                ],
                'erros' => [
                    404 => 'Usuário de destino não encontrado ou inativo.',
                    409 => 'Já existe uma conexão ou solicitação pendente.',
                    422 => 'Tentativa de conexão consigo mesmo.',
                ],
                'regras' => [
                    'O usuário não pode se conectar consigo mesmo.',
                    'O destinatário precisa existir e estar ativo.',
                    'Não é criada outra solicitação enquanto houver uma pendente.',
                    'Uma conexão anteriormente recusada pode ser reutilizada para uma nova solicitação.',
                ],
            ],

            'PATCH api/v1/conexoes/{idConexao}/aceitar' => [
                'grupo' => 'Conexões',
                'descricao' => 'Aceita uma solicitação de conexão pendente recebida pelo usuário autenticado.',
                'response' => [
                    'success' => true,
                    'message' => 'Conexão aceita com sucesso.',
                ],
                'regras' => [
                    'Somente o destinatário da solicitação pendente pode aceitar.',
                    'O status da conexão passa para ACEITA.',
                ],
            ],

            'PATCH api/v1/conexoes/{idConexao}/recusar' => [
                'grupo' => 'Conexões',
                'descricao' => 'Recusa uma solicitação de conexão pendente recebida pelo usuário autenticado.',
                'response' => [
                    'success' => true,
                    'message' => 'Solicitação recusada.',
                ],
                'regras' => [
                    'Somente o destinatário da solicitação pendente pode recusar.',
                    'O status da conexão passa para RECUSADA.',
                ],
            ],

            'DELETE api/v1/conexoes/{idConexao}' => [
                'grupo' => 'Conexões',
                'descricao' => 'Remove uma conexão da qual o usuário autenticado participa.',
                'response' => [
                    'success' => true,
                    'message' => 'Conexão removida com sucesso.',
                ],
            ],

            'GET api/v1/notificacoes' => [
                'grupo' => 'Notificações',
                'descricao' => 'Lista as notificações destinadas ao usuário autenticado.',
                'response' => [
                    'success' => true,
                    'data' => [],
                ],
            ],

            'GET api/v1/notificacoes/nao-lidas' => [
                'grupo' => 'Notificações',
                'descricao' => 'Retorna a quantidade de notificações não lidas do usuário autenticado.',
                'response' => [
                    'success' => true,
                    'data' => [
                        'quantidade' => 0,
                    ],
                ],
            ],

            'PATCH api/v1/notificacoes/ler-todas' => [
                'grupo' => 'Notificações',
                'descricao' => 'Marca todas as notificações do usuário autenticado como lidas.',
                'response' => [
                    'success' => true,
                    'message' => 'Notificações marcadas como lidas.',
                ],
            ],

            'PATCH api/v1/notificacoes/{idNotificacao}/ler' => [
                'grupo' => 'Notificações',
                'descricao' => 'Marca uma notificação específica do usuário autenticado como lida.',
                'response' => [
                    'success' => true,
                    'message' => 'Notificação marcada como lida.',
                ],
            ],
        ];
    }

    private function detectarGrupo(string $uri): string
    {
        return match (true) {
            str_contains($uri, '/auth/') => 'Autenticação',
            str_contains($uri, '/notificacoes') => 'Notificações',
            str_contains($uri, '/conexoes') => 'Conexões',
            str_contains($uri, '/comentarios') => 'Comentários',
            str_contains($uri, '/curtidas') => 'Curtidas',
            str_contains($uri, '/publicacoes') => 'Publicações',
            str_contains($uri, '/usuarios/') => 'Perfis',
            str_ends_with($uri, '/usuario') => 'Usuários',
            default => 'Visão geral',
        };
    }

    private function ordemGrupo(string $grupo): int
    {
        return [
            'Visão geral' => 1,
            'Autenticação' => 2,
            'Usuários' => 3,
            'Perfis' => 4,
            'Publicações' => 5,
            'Curtidas' => 6,
            'Comentários' => 7,
            'Conexões' => 8,
            'Notificações' => 9,
        ][$grupo] ?? 99;
    }

    private function ordemMetodo(string $metodo): int
    {
        return [
            'GET' => 1,
            'POST' => 2,
            'PATCH' => 3,
            'PUT' => 4,
            'DELETE' => 5,
        ][$metodo] ?? 99;
    }

    private function extrairParametros(string $uri): array
    {
        preg_match_all('/\{([^}]+)\}/', $uri, $matches);

        return collect($matches[1] ?? [])
            ->map(
                fn ($nome) => [
                    'nome' => $nome,
                    'tipo' => 'integer',
                    'obrigatorio' => true,
                ]
            )
            ->values()
            ->all();
    }

    private function montarCurl(
        string $metodo,
        string $uri,
        bool $autenticado,
        array $body,
        string $contentType
    ): string {
        $base = 'http://localhost:8081';

        $linhas = [
            'curl -X ' . $metodo . ' \\',
            '"' . $base . $uri . '" \\',
            '-H "Accept: application/json"'
                . (($autenticado || !empty($body)) ? ' \\' : ''),
        ];

        if ($autenticado) {
            $linhas[] = '-H "Authorization: Bearer SEU_TOKEN"'
                . (!empty($body) ? ' \\' : '');
        }

        if (!empty($body) && $contentType === 'multipart/form-data') {
            $ultimoIndice = count($body) - 1;

            foreach (array_values(array_keys($body)) as $indice => $campo) {
                $valor = $body[$campo];

                if ($campo === 'midia_publicacao') {
                    $valor = '@/caminho/arquivo.jpg';
                }

                $linhas[] = '-F "'
                    . $campo
                    . '='
                    . $valor
                    . '"'
                    . ($indice < $ultimoIndice ? ' \\' : '');
            }
        } elseif (!empty($body)) {
            $json = json_encode(
                $body,
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );

            $linhas[] = '-H "Content-Type: application/json" \\';
            $linhas[] = "-d '" . $json . "'";
        }

        return implode(PHP_EOL, $linhas);
    }

    private function montarStatusRecursos($rotas): array
    {
        $tem = fn (string $trecho) =>
            $rotas->contains(
                fn ($rota) => str_contains($rota['uri'], $trecho)
            );

        $quantidadeNotificacoes = $rotas
            ->filter(
                fn ($rota) => str_contains($rota['uri'], '/notificacoes')
            )
            ->count();

        return [
            [
                'nome' => 'Login',
                'status' => $tem('/auth/login') ? 'Implementado' : 'Não exposto',
            ],
            [
                'nome' => 'Usuário autenticado',
                'status' => $tem('/usuario') ? 'Implementado' : 'Não exposto',
            ],
            [
                'nome' => 'Perfil',
                'status' => $tem('/usuarios/') ? 'Implementado' : 'Não exposto',
            ],
            [
                'nome' => 'Feed e publicações',
                'status' => $tem('/publicacoes') ? 'Implementado' : 'Não exposto',
            ],
            [
                'nome' => 'Curtidas',
                'status' => $tem('/curtidas') ? 'Implementado' : 'Não exposto',
            ],
            [
                'nome' => 'Comentários',
                'status' => $tem('/comentarios') ? 'Implementado' : 'Não exposto',
            ],
            [
                'nome' => 'Conexões',
                'status' => $tem('/conexoes') ? 'Implementado' : 'Não exposto',
            ],
            [
                'nome' => 'Notificações',
                'status' => match (true) {
                    $quantidadeNotificacoes >= 4 => 'Implementado',
                    $quantidadeNotificacoes > 0 => 'Parcial',
                    default => 'Planejado',
                },
            ],
            [
                'nome' => 'Enquetes pelo app',
                'status' => $tem('/enquetes') ? 'Implementado' : 'Não exposto',
            ],
            [
                'nome' => 'Vídeos pelo app',
                'status' => ($tem('/videos') || $tem('/conteudos'))
                    ? 'Implementado'
                    : 'Não exposto',
            ],
            [
                'nome' => 'Chat',
                'status' => ($tem('/convers') || $tem('/chat'))
                    ? 'Implementado'
                    : 'Planejado',
            ],
        ];
    }
}
