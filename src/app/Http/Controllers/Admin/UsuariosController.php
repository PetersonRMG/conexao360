<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        // =========================================================
        // FILTROS RECEBIDOS PELA TELA
        // =========================================================

        $busca = trim(
            (string) $request->query(
                'busca',
                ''
            )
        );

        $perfil = trim(
            (string) $request->query(
                'perfil',
                ''
            )
        );

        $status = trim(
            (string) $request->query(
                'status',
                ''
            )
        );

        $periodo = trim(
            (string) $request->query(
                'periodo',
                ''
            )
        );


        // =========================================================
        // PERFIS EXISTENTES
        // =========================================================

        $perfisDisponiveis =
            Usuarios::query()
                ->whereNotNull(
                    'perfil_usuario'
                )
                ->where(
                    'perfil_usuario',
                    '<>',
                    ''
                )
                ->select(
                    'perfil_usuario'
                )
                ->distinct()
                ->orderBy(
                    'perfil_usuario'
                )
                ->pluck(
                    'perfil_usuario'
                );


        // =========================================================
        // STATUS EXISTENTES
        // =========================================================

        $statusDisponiveis =
            Usuarios::query()
                ->whereNotNull(
                    'status_usuario'
                )
                ->where(
                    'status_usuario',
                    '<>',
                    ''
                )
                ->select(
                    'status_usuario'
                )
                ->distinct()
                ->orderBy(
                    'status_usuario'
                )
                ->pluck(
                    'status_usuario'
                );


        // =========================================================
        // MÉTRICAS
        // =========================================================

        $totalUsuarios =
            Usuarios::query()
                ->count();


        $usuariosAtivos =
            Usuarios::query()
                ->where(
                    'status_usuario',
                    'ATIVO'
                )
                ->count();


        $usuariosNaoAtivos =
            $totalUsuarios
            - $usuariosAtivos;


        $novosEsteMes =
            Usuarios::query()
                ->whereYear(
                    'criado_em_usuario',
                    now()->year
                )
                ->whereMonth(
                    'criado_em_usuario',
                    now()->month
                )
                ->count();


        // =========================================================
        // CONSULTA DOS USUÁRIOS
        // =========================================================

        $query =
            Usuarios::query()
                ->select([
                    'id_usuario',
                    'nome_usuario',
                    'foto_usuario',
                    'email_usuario',
                    'area_atuacao_usuario',
                    'perfil_usuario',
                    'estado_usuario',
                    'status_usuario',
                    'criado_em_usuario',
                    'atualizado_em_usuario',
                ]);


        // =========================================================
        // BUSCA POR NOME, E-MAIL OU ÁREA
        // =========================================================

        if ($busca !== '') {

            $query->where(
                function ($subQuery) use ($busca) {

                    $subQuery
                        ->where(
                            'nome_usuario',
                            'like',
                            '%' . $busca . '%'
                        )
                        ->orWhere(
                            'email_usuario',
                            'like',
                            '%' . $busca . '%'
                        )
                        ->orWhere(
                            'area_atuacao_usuario',
                            'like',
                            '%' . $busca . '%'
                        );

                }
            );

        }


        // =========================================================
        // FILTRO POR PERFIL
        // =========================================================

        if (
            $perfil !== ''
            &&
            $perfisDisponiveis->contains(
                $perfil
            )
        ) {

            $query->where(
                'perfil_usuario',
                $perfil
            );

        }


        // =========================================================
        // FILTRO POR STATUS
        // =========================================================

        if (
            $status !== ''
            &&
            $statusDisponiveis->contains(
                $status
            )
        ) {

            $query->where(
                'status_usuario',
                $status
            );

        }


        // =========================================================
        // FILTRO POR PERÍODO
        // =========================================================

        if ($periodo === 'hoje') {

            $query->whereDate(
                'criado_em_usuario',
                today()
            );

        } elseif ($periodo === '7dias') {

            $query->where(
                'criado_em_usuario',
                '>=',
                now()
                    ->subDays(7)
                    ->startOfDay()
            );

        } elseif ($periodo === 'mes') {

            $query
                ->whereYear(
                    'criado_em_usuario',
                    now()->year
                )
                ->whereMonth(
                    'criado_em_usuario',
                    now()->month
                );

        }


        // =========================================================
        // LISTAGEM
        // =========================================================

        $usuarios =
            $query
                ->orderByDesc(
                    'criado_em_usuario'
                )
                ->paginate(20)
                ->withQueryString();


        // =========================================================
        // VIEW
        // =========================================================

        return view(
            'admin.cadastro.usuarios',
            compact(
                'usuarios',
                'totalUsuarios',
                'usuariosAtivos',
                'usuariosNaoAtivos',
                'novosEsteMes',
                'perfisDisponiveis',
                'statusDisponiveis',
                'busca',
                'perfil',
                'status',
                'periodo'
            )
        );
    }
}