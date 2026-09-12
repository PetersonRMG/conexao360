<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PerfilPalestranteController extends Controller
{
    public function index()
    {
        $perfil = auth('admin')->user();

        abort_unless(
            $perfil && $perfil->perfil_usuario === 'palestrante',
            403
        );

        return view(
            'palestrante.perfil.perfil',
            compact('perfil')
        );
    }

    public function update(Request $request)
    {
        $perfil = auth('admin')->user();

        abort_unless(
            $perfil && $perfil->perfil_usuario === 'palestrante',
            403
        );

        $dados = $request->validate([

            // =========================================================
            // DADOS PRINCIPAIS
            // =========================================================

            'nome_usuario' => [
                'required',
                'string',
                'max:150'
            ],

            'email_usuario' => [
                'required',
                'email',
                'max:150',

                Rule::unique(
                    'tbl_usuarios',
                    'email_usuario'
                )->ignore(
                    $perfil->id_usuario,
                    'id_usuario'
                ),
            ],

            'area_atuacao_usuario' => [
                'nullable',
                'string',
                'max:150'
            ],

            'estado_usuario' => [
                'nullable',
                'string',
                'max:100'
            ],

            'sobre_usuario' => [
                'nullable',
                'string',
                'max:2500'
            ],


            // =========================================================
            // REDES SOCIAIS
            // =========================================================

            'instagram_usuario' => [
                'nullable',
                'url',
                'max:255'
            ],

            'linkedin_usuario' => [
                'nullable',
                'url',
                'max:255'
            ],

            'youtube_usuario' => [
                'nullable',
                'url',
                'max:255'
            ],

            'tiktok_usuario' => [
                'nullable',
                'url',
                'max:255'
            ],

            'facebook_usuario' => [
                'nullable',
                'url',
                'max:255'
            ],

            'site_usuario' => [
                'nullable',
                'url',
                'max:255'
            ],


            // =========================================================
            // FOTO
            // =========================================================

            'foto_usuario' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ]);


        // =============================================================
        // UPLOAD DA FOTO
        // =============================================================

        if ($request->hasFile('foto_usuario')) {

            $diretorio = public_path(
                'dash/assets/img/usuario'
            );


            // Cria a pasta caso ainda não exista
            if (!File::exists($diretorio)) {

                File::makeDirectory(
                    $diretorio,
                    0775,
                    true
                );
            }


            // Remove a foto antiga
            if (!empty($perfil->foto_usuario)) {

                $fotoAntiga = public_path(
                    'dash/assets/img/' .
                        $perfil->foto_usuario
                );


                if (
                    File::exists($fotoAntiga) &&
                    File::isFile($fotoAntiga)
                ) {
                    File::delete($fotoAntiga);
                }
            }


            // Nova foto
            $arquivo = $request->file(
                'foto_usuario'
            );


            $nomeBase = Str::slug(
                $request->nome_usuario
                    ?: 'palestrante'
            );


            $nomeFoto =
                $nomeBase .
                '-' .
                $perfil->id_usuario .
                '-' .
                time() .
                '.' .
                $arquivo->getClientOriginalExtension();


            $arquivo->move(
                $diretorio,
                $nomeFoto
            );


            $dados['foto_usuario'] =
                'usuario/' . $nomeFoto;
        }


        // =============================================================
        // ATUALIZA USUÁRIO
        // =============================================================

        $perfil->update($dados);


        return redirect()
            ->route(
                'admin.palestrante.perfil.index'
            )
            ->with(
                'success',
                'Perfil atualizado com sucesso.'
            );
    }
}
