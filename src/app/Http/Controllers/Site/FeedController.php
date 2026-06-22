<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Feed;
use App\Models\FeedComentario;
use App\Models\FeedCurtida;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class FeedController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            'conteudo_feed' => [
                'required',
                'string',
                'max:5000'
            ],

            'foto_feed' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120'
            ]
        ]);

        $foto = null;

        if ($request->hasFile('foto_feed')) {

            $arquivo = $request->file('foto_feed');

            $nomeArquivo =
                time()
                .'_'
                .uniqid()
                .'.'
                .$arquivo->getClientOriginalExtension();

            $diretorio =
                public_path('uploads/feed');

            if (!File::exists($diretorio)) {

                File::makeDirectory(
                    $diretorio,
                    0777,
                    true
                );
            }

            file_put_contents(
                $diretorio.'/'.$nomeArquivo,
                file_get_contents(
                    $arquivo->getRealPath()
                )
            );

            $foto =
                'uploads/feed/'
                .$nomeArquivo;
        }

        Feed::create([

            'id_usuario' => 1,

            'id_evento' => 1,

            'conteudo_feed' =>
                $request->conteudo_feed,

            'foto_feed' =>
                $foto,

            'tipo_feed' =>
                $foto
                ? 'FOTO'
                : 'TEXTO',

            'status_feed' =>
                'ATIVO',

            'curtidas_feed' => 0,

            'total_comentarios_feed' => 0,

            'compartilhamentos_feed' => 0
        ]);

        return redirect()
            ->route('network')
            ->with(
                'success',
                'Publicação criada com sucesso.'
            );
    }

    public function edit($id)
    {
        $feed = Feed::findOrFail($id);

        return view(
            'site.network.feed-edit',
            compact('feed')
        );
    }

    public function update(
        Request $request,
        $id
    ) {
        $feed = Feed::findOrFail($id);

        $request->validate([

            'conteudo_feed' => [
                'required',
                'string',
                'max:5000'
            ],

            'foto_feed' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120'
            ]
        ]);

        $feed->conteudo_feed =
            $request->conteudo_feed;

        if ($request->hasFile('foto_feed')) {

            if (
                !empty($feed->foto_feed)
                &&
                File::exists(
                    public_path(
                        $feed->foto_feed
                    )
                )
            ) {
                File::delete(
                    public_path(
                        $feed->foto_feed
                    )
                );
            }

            $arquivo =
                $request->file(
                    'foto_feed'
                );

            $nomeArquivo =
                time()
                .'_'
                .uniqid()
                .'.'
                .$arquivo
                ->getClientOriginalExtension();

            $diretorio =
                public_path(
                    'uploads/feed'
                );

            if (
                !File::exists(
                    $diretorio
                )
            ) {

                File::makeDirectory(
                    $diretorio,
                    0777,
                    true
                );
            }

            file_put_contents(
                $diretorio
                .'/'
                .$nomeArquivo,

                file_get_contents(
                    $arquivo
                    ->getRealPath()
                )
            );

            $feed->foto_feed =
                'uploads/feed/'
                .$nomeArquivo;
        }

        $feed->save();

        return redirect()
            ->route('network')
            ->with(
                'success',
                'Publicação atualizada com sucesso.'
            );
    }

    public function destroy($id)
    {
        $feed = Feed::findOrFail($id);

        FeedComentario::where(
            'id_feeds',
            $feed->id_feeds
        )->delete();

        FeedCurtida::where(
            'id_feeds',
            $feed->id_feeds
        )->delete();

        if (
            !empty($feed->foto_feed)
            &&
            File::exists(
                public_path(
                    $feed->foto_feed
                )
            )
        ) {

            File::delete(
                public_path(
                    $feed->foto_feed
                )
            );
        }

        $feed->delete();

        return redirect()
            ->route('network')
            ->with(
                'success',
                'Publicação removida com sucesso.'
            );
    }
}