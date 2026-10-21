<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use App\Models\Publicacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DenunciaPublicacaoController extends Controller
{
    private const LIMITE_DENUNCIAS = 3;

    public function store(Request $request, int $id): JsonResponse
    {
        $dados = $request->validate([
            'motivo_denuncia' => ['required', 'string', 'max:30'],
            'descricao_denuncia' => ['nullable', 'string', 'max:2000'],
        ]);

        $idDenunciante = (int) $request->user()->id_usuario;

        // Bloqueia a publicação durante a checagem e criação da denúncia.
        // Assim, denúncias simultâneas não ultrapassam o limite global.
        $resultado = DB::transaction(function () use ($id, $idDenunciante, $dados) {
            $publicacao = Publicacao::whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ((int) $publicacao->id_usuario === $idDenunciante) {
                return [
                    'codigo' => 403,
                    'message' => 'Você não pode denunciar sua própria publicação.',
                ];
            }

            $total = Denuncia::where('id_publicacao', $id)->count();

            if ($total >= self::LIMITE_DENUNCIAS) {
                return [
                    'codigo' => 409,
                    'message' => 'Esta publicação já atingiu o limite de 3 denúncias.',
                    'total_denuncias' => $total,
                ];
            }

            // A tabela de denúncias deve ter UNIQUE(id_publicacao, id_usuario_denunciante).
            if (Denuncia::where('id_publicacao', $id)
                ->where('id_usuario_denunciante', $idDenunciante)
                ->exists()) {
                return [
                    'codigo' => 409,
                    'message' => 'Você já denunciou esta publicação.',
                    'total_denuncias' => $total,
                ];
            }

            if ($publicacao->status_publicacao !== 'ATIVO') {
                return [
                    'codigo' => 409,
                    'message' => 'Esta publicação não está disponível para denúncias.',
                    'total_denuncias' => $total,
                ];
            }

            $denuncia = Denuncia::create([
                'id_publicacao' => $publicacao->id_publicacao,
                'id_usuario_denunciante' => $idDenunciante,
                'motivo_denuncia' => $dados['motivo_denuncia'],
                'descricao_denuncia' => $dados['descricao_denuncia'] ?? null,
                'status_denuncia' => 'PENDENTE',
            ]);

            $publicacao->update(['status_publicacao' => 'OCULTO']);

            return [
                'codigo' => 201,
                'message' => 'Denúncia registrada. A publicação foi retirada do feed para análise.',
                'data' => [
                    'id_denuncia' => $denuncia->id_denuncia,
                    'id_publicacao' => $publicacao->id_publicacao,
                    'total_denuncias' => $total + 1,
                    'limite_denuncias' => self::LIMITE_DENUNCIAS,
                    'status_publicacao' => 'OCULTO',
                ],
            ];
        }, 3);

        return response()->json([
            'success' => $resultado['codigo'] === 201,
            'message' => $resultado['message'],
            'data' => $resultado['data'] ?? null,
        ], $resultado['codigo']);
    }
}
