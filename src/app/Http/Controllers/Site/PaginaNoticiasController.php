<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class PaginaNoticiasController extends Controller
{
    public function index()
    {
        $noticias = collect([
            [
                'id' => 1,
                'categoria' => 'Tecnologia',
                'titulo' => 'Inteligência artificial e os novos desafios para a advocacia',
                'resumo' => 'Ferramentas de IA estão mudando a rotina jurídica e exigindo novas competências dos profissionais do Direito.',
                'data' => '11 de setembro de 2026',
                'imagem' => 'conexao360/img/Mídia (1).jpg',
                'url' => '#',
            ],
            [
                'id' => 2,
                'categoria' => 'Carreira',
                'titulo' => 'Como construir autoridade profissional sem depender apenas das redes sociais',
                'resumo' => 'Posicionamento, especialização e relacionamento seguem entre os pilares mais importantes para uma carreira jurídica sólida.',
                'data' => '10 de setembro de 2026',
                'imagem' => 'conexao360/img/captura.png',
                'url' => '#',
            ],
            [
                'id' => 3,
                'categoria' => 'Gestão',
                'titulo' => 'Escritórios jurídicos adotam novas estratégias de gestão e produtividade',
                'resumo' => 'Processos internos, tecnologia e análise de resultados ganham espaço na administração de escritórios de advocacia.',
                'data' => '09 de setembro de 2026',
                'imagem' => 'conexao360/img/vista.png',
                'url' => '#',
            ],
            [
                'id' => 4,
                'categoria' => 'Mercado',
                'titulo' => 'O que muda na relação entre clientes e escritórios jurídicos',
                'resumo' => 'Experiência, transparência e comunicação mais próxima estão redefinindo a forma como clientes escolhem serviços jurídicos.',
                'data' => '08 de setembro de 2026',
                'imagem' => 'conexao360/img/Mídia (1).jpg',
                'url' => '#',
            ],
            [
                'id' => 5,
                'categoria' => 'Legislação',
                'titulo' => 'Atualização legislativa: por que acompanhar mudanças se tornou ainda mais importante',
                'resumo' => 'Um cenário regulatório cada vez mais dinâmico exige acompanhamento constante e interpretação estratégica.',
                'data' => '07 de setembro de 2026',
                'imagem' => 'conexao360/img/captura.png',
                'url' => '#',
            ],
            [
                'id' => 6,
                'categoria' => 'Tecnologia',
                'titulo' => 'Automação jurídica: onde ela ajuda e onde a análise humana continua essencial',
                'resumo' => 'Soluções digitais reduzem tarefas repetitivas, mas decisões estratégicas ainda dependem de contexto e experiência.',
                'data' => '06 de setembro de 2026',
                'imagem' => 'conexao360/img/vista.png',
                'url' => '#',
            ],
        ]);

        return view('site.sessaoNoticias.sessao-noticias', compact('noticias'));
    }
}
