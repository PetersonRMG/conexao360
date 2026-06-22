<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function show($id)
    {
        $usuario = User::findOrFail($id);

        $feeds = Feed::with([
            'usuario',
            'comentarios.usuario'
        ])
        ->where('id_usuario', $id)
        ->orderByDesc('id_feeds')
        ->get();

        return view(
            'site.network.profile',
            compact(
                'usuario',
                'feeds'
            )
        );
    }

    public function edit()
    {
        $usuario = User::findOrFail(1);

        return view(
            'site.network.profile-edit',
            compact('usuario')
        );
    }

    public function update(Request $request)
    {
        $usuario = User::findOrFail(1);

        $request->validate([
            'nome_usuario' => [
                'required',
                'string',
                'max:100'
            ],

            'area_atuacao_usuario' => [
                'nullable',
                'string',
                'max:150'
            ],

            'estado_usuario' => [
                'nullable',
                'string',
                'max:2'
            ],

            'sobre_usuario' => [
                'nullable',
                'string',
                'max:500'
            ],

            'foto_usuario' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120'
            ]
        ]);

        if ($request->hasFile('foto_usuario')) {

            if (
                !empty($usuario->foto_usuario)
                &&
                File::exists(
                    public_path($usuario->foto_usuario)
                )
            ) {
                File::delete(
                    public_path($usuario->foto_usuario)
                );
            }

            $arquivo = $request->file('foto_usuario');

            $nomeArquivo =
                time()
                . '_'
                . uniqid()
                . '.'
                . $arquivo->getClientOriginalExtension();

            $diretorio = public_path(
                'uploads/usuarios'
            );

            if (!File::exists($diretorio)) {

                File::makeDirectory(
                    $diretorio,
                    0777,
                    true
                );
            }

            $arquivo->move(
                $diretorio,
                $nomeArquivo
            );

            $usuario->foto_usuario =
                'uploads/usuarios/'
                . $nomeArquivo;
        }

        $usuario->nome_usuario =
            $request->nome_usuario;

        $usuario->area_atuacao_usuario =
            $request->area_atuacao_usuario;

        $usuario->estado_usuario =
            $request->estado_usuario;

        $usuario->sobre_usuario =
            $request->sobre_usuario;

        $usuario->save();

        return redirect()
            ->route(
                'network.profile',
                $usuario->id_usuario
            )
            ->with(
                'success',
                'Perfil atualizado com sucesso.'
            );
    }
}