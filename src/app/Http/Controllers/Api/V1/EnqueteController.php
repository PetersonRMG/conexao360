<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Enquete;
use App\Models\Resposta;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnqueteController extends Controller
{
    // =============================================================
    // LISTAR ENQUETES
    // =============================================================

    public function index(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'filtro' => [
                'nullable',
                Rule::in([
                    'todas',
                    'nao_respondidas',
                    'respondidas',
                ]),
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:20',
            ],

            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ]);


        $idUsuario =
            (int) $request->user()->id_usuario;


        $filtro =
            $dados['filtro'] ?? 'todas';


        $porPagina =
            (int) ($dados['per_page'] ?? 20);


        $query = Enquete::query()
            ->where(
                'status_enquete',
                'ATIVA'
            )
            ->with([
                'usuario:id_usuario,nome_usuario,foto_usuario,perfil_usuario',

                'respostas' => function ($query) use ($idUsuario) {
                    $query
                        ->select([
                            'id_resposta',
                            'id_usuario',
                            'id_enquete',
                            'resposta_resposta',
                        ])
                        ->where(
                            'id_usuario',
                            $idUsuario
                        );
                },
            ])
            ->withCount([
                'respostas as votos_sim' =>
                    fn ($query) =>
                        $query->where(
                            'resposta_resposta',
                            1
                        ),

                'respostas as votos_nao' =>
                    fn ($query) =>
                        $query->where(
                            'resposta_resposta',
                            2
                        ),

                'respostas as votos_outro' =>
                    fn ($query) =>
                        $query->where(
                            'resposta_resposta',
                            3
                        ),

                'respostas as total_votos',
            ]);


        // =========================================================
        // FILTROS
        // =========================================================

        if ($filtro === 'respondidas') {

            $query->whereHas(
                'respostas',
                fn ($query) =>
                    $query->where(
                        'id_usuario',
                        $idUsuario
                    )
            );

        }


        if ($filtro === 'nao_respondidas') {

            $query->whereDoesntHave(
                'respostas',
                fn ($query) =>
                    $query->where(
                        'id_usuario',
                        $idUsuario
                    )
            );

        }


        // As enquetes novas possuem data.
        // As antigas continuam disponíveis,
        // mas ficam depois das novas.

        $enquetes = $query
            ->orderByRaw(
                'criado_em_enquete IS NULL ASC'
            )
            ->orderByDesc(
                'criado_em_enquete'
            )
            ->orderByDesc(
                'id_enquete'
            )
            ->paginate(
                $porPagina
            );


        $itens = collect(
            $enquetes->items()
        )
            ->map(
                fn (Enquete $enquete) =>
                    $this->formatarEnquete(
                        $enquete
                    )
            )
            ->values()
            ->all();


        return response()->json([
            'success' => true,

            'data' =>
                $itens,

            'meta' => [
                'current_page' =>
                    $enquetes->currentPage(),

                'last_page' =>
                    $enquetes->lastPage(),

                'per_page' =>
                    $enquetes->perPage(),

                'total' =>
                    $enquetes->total(),
            ],
        ]);
    }


    // =============================================================
    // RESPONDER ENQUETE
    // =============================================================

    public function responder(
        Request $request,
        int $idEnquete
    ): JsonResponse {

        $dados = $request->validate([
            'resposta' => [
                'required',
                'integer',
                Rule::in([
                    1,
                    2,
                    3,
                ]),
            ],
        ]);


        $idUsuario =
            (int) $request->user()->id_usuario;


        $enquete = Enquete::query()
            ->where(
                'id_enquete',
                $idEnquete
            )
            ->where(
                'status_enquete',
                'ATIVA'
            )
            ->first();


        if (!$enquete) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Enquete não encontrada ou encerrada.',
            ], 404);

        }


        // =========================================================
        // VERIFICA SE JÁ RESPONDEU
        // =========================================================

        $respostaExistente =
            Resposta::query()
                ->where(
                    'id_usuario',
                    $idUsuario
                )
                ->where(
                    'id_enquete',
                    $idEnquete
                )
                ->first();


        if ($respostaExistente) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Você já respondeu esta enquete.',
            ], 409);

        }


        // =========================================================
        // GRAVA RESPOSTA
        // =========================================================

        try {

            Resposta::create([
                'id_usuario' =>
                    $idUsuario,

                'id_enquete' =>
                    $idEnquete,

                'resposta_resposta' =>
                    (int) $dados['resposta'],
            ]);

        } catch (QueryException $exception) {

            // O banco também possui UNIQUE:
            // id_usuario + id_enquete.
            //
            // Isso protege contra duas requisições
            // simultâneas tentando votar duas vezes.

            if (
                (string) $exception->getCode()
                === '23000'
            ) {

                return response()->json([
                    'success' => false,
                    'message' =>
                        'Você já respondeu esta enquete.',
                ], 409);

            }


            throw $exception;

        }


        // =========================================================
        // RETORNA ENQUETE ATUALIZADA
        // =========================================================

        $enqueteAtualizada =
            $this->buscarEnquete(
                $idEnquete,
                $idUsuario
            );


        return response()->json([
            'success' => true,

            'message' =>
                'Resposta registrada com sucesso.',

            'data' =>
                $this->formatarEnquete(
                    $enqueteAtualizada
                ),
        ], 201);
    }


    // =============================================================
    // BUSCAR UMA ENQUETE COMPLETA
    // =============================================================

    private function buscarEnquete(
        int $idEnquete,
        int $idUsuario
    ): Enquete {

        return Enquete::query()
            ->where(
                'id_enquete',
                $idEnquete
            )
            ->with([
                'usuario:id_usuario,nome_usuario,foto_usuario,perfil_usuario',

                'respostas' => function ($query) use ($idUsuario) {
                    $query
                        ->select([
                            'id_resposta',
                            'id_usuario',
                            'id_enquete',
                            'resposta_resposta',
                        ])
                        ->where(
                            'id_usuario',
                            $idUsuario
                        );
                },
            ])
            ->withCount([
                'respostas as votos_sim' =>
                    fn ($query) =>
                        $query->where(
                            'resposta_resposta',
                            1
                        ),

                'respostas as votos_nao' =>
                    fn ($query) =>
                        $query->where(
                            'resposta_resposta',
                            2
                        ),

                'respostas as votos_outro' =>
                    fn ($query) =>
                        $query->where(
                            'resposta_resposta',
                            3
                        ),

                'respostas as total_votos',
            ])
            ->firstOrFail();
    }


    // =============================================================
    // FORMATA RESPOSTA PARA O APP
    // =============================================================

    private function formatarEnquete(
        Enquete $enquete
    ): array {

        $minhaResposta =
            $enquete->respostas
                ->first()
                ?->resposta_resposta;


        $respondida =
            $minhaResposta !== null;


        $total =
            (int) $enquete->total_votos;


        $resultados =
            null;


        // Resultado só é liberado
        // depois que o usuário vota.

        if ($respondida) {

            $votosSim =
                (int) $enquete->votos_sim;

            $votosNao =
                (int) $enquete->votos_nao;

            $votosOutro =
                (int) $enquete->votos_outro;


            $resultados = [
                'sim' => [
                    'votos' =>
                        $votosSim,

                    'percentual' =>
                        $this->calcularPercentual(
                            $votosSim,
                            $total
                        ),
                ],

                'nao' => [
                    'votos' =>
                        $votosNao,

                    'percentual' =>
                        $this->calcularPercentual(
                            $votosNao,
                            $total
                        ),
                ],

                'outro' => [
                    'votos' =>
                        $votosOutro,

                    'percentual' =>
                        $this->calcularPercentual(
                            $votosOutro,
                            $total
                        ),
                ],
            ];

        }


        return [
            'id_enquete' =>
                $enquete->id_enquete,

            'pergunta_enquete' =>
                $enquete->pergunta_enquete,

            'status_enquete' =>
                $enquete->status_enquete,

            'criado_em_enquete' =>
                $enquete->criado_em_enquete
                    ?->toISOString(),

            'criador' =>
                $enquete->usuario
                    ? [
                        'id_usuario' =>
                            $enquete
                                ->usuario
                                ->id_usuario,

                        'nome_usuario' =>
                            $enquete
                                ->usuario
                                ->nome_usuario,

                        'foto_usuario' =>
                            $enquete
                                ->usuario
                                ->foto_usuario,

                        'perfil_usuario' =>
                            $enquete
                                ->usuario
                                ->perfil_usuario,
                    ]
                    : null,

            'total_votos' =>
                $total,

            'respondida' =>
                $respondida,

            'minha_resposta' =>
                $minhaResposta !== null
                    ? (int) $minhaResposta
                    : null,

            'resultados' =>
                $resultados,
        ];
    }


    // =============================================================
    // CALCULAR PERCENTUAL
    // =============================================================

    private function calcularPercentual(
        int $votos,
        int $total
    ): int {

        if ($total === 0) {
            return 0;
        }


        return (int) round(
            ($votos / $total) * 100
        );
    }
}