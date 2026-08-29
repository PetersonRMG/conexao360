<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Exibe o perfil do administrador logado.
     */
    public function indexAdmin()
    {
        $perfil = Usuarios::findOrFail(
            Auth::guard('admin')->id()
        );

        return view(
            'admin.dash.editar-perfil',
            compact('perfil')
        );
    }


    /**
     * Atualiza o perfil do administrador logado.
     */
    public function updateAdmin(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | USUÁRIO LOGADO
        |--------------------------------------------------------------------------
        */

        $usuario = Usuarios::findOrFail(
            Auth::guard('admin')->id()
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDAÇÃO
        |--------------------------------------------------------------------------
        */

        $dados = $request->validate([

            'nome_usuario' => [
                'required',
                'string',
                'max:255',
            ],

            'email_usuario' => [
                'required',
                'email',
                'max:255',

                Rule::unique(
                    'tbl_usuarios',
                    'email_usuario'
                )->ignore(
                    $usuario->id_usuario,
                    'id_usuario'
                ),
            ],

            'foto_usuario' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | DADOS BÁSICOS
        |--------------------------------------------------------------------------
        */

        $usuario->nome_usuario =
            $dados['nome_usuario'];

        $usuario->email_usuario =
            $dados['email_usuario'];


        /*
        |--------------------------------------------------------------------------
        | FOTO
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_usuario')) {

            $foto = $request->file('foto_usuario');


            /*
             * Nome único para a imagem.
             */
            $nomeFoto =
                time()
                . '_'
                . uniqid()
                . '.'
                . $foto->getClientOriginalExtension();


            /*
             * Pasta onde as fotos do projeto
             * já estão sendo utilizadas.
             */
            $diretorio = public_path(
                'dash/assets/img'
            );


            /*
             * Cria a pasta caso ela não exista.
             */
            if (!is_dir($diretorio)) {

                mkdir(
                    $diretorio,
                    0755,
                    true
                );
            }


            /*
             * Move a imagem.
             */
            $foto->move(
                $diretorio,
                $nomeFoto
            );


            /*
             * Salva apenas o nome da imagem
             * na tbl_usuarios.
             */
            $usuario->foto_usuario =
                $nomeFoto;
        }


        /*
        |--------------------------------------------------------------------------
        | SALVAR
        |--------------------------------------------------------------------------
        */

        $usuario->save();


        /*
        |--------------------------------------------------------------------------
        | RETORNO
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.perfil')
            ->with(
                'success',
                'Perfil atualizado com sucesso!'
            );
    }
}
