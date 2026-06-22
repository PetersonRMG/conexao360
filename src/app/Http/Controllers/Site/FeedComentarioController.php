<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Feed;
use App\Models\FeedComentario;
use Illuminate\Http\Request;

class FeedComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([

            'id_feeds' => [
                'required'
            ],

            'comentario' => [
                'required',
                'string',
                'max:1000'
            ]
        ]);

        FeedComentario::create([

            'id_feeds' => $request->id_feeds,

            'id_usuario' => 1,

            'comentario' => $request->comentario,

            'status_comentario' => 'ATIVO'
        ]);

        Feed::where(
            'id_feeds',
            $request->id_feeds
        )->increment(
            'total_comentarios_feed'
        );

        return back()
            ->with(
                'success',
                'Comentário publicado.'
            );
    }

    public function destroy($id)
    {
        $comentario = FeedComentario::findOrFail($id);

        Feed::where(
            'id_feeds',
            $comentario->id_feeds
        )->decrement(
            'total_comentarios_feed'
        );

        $comentario->delete();

        return back()
            ->with(
                'success',
                'Comentário removido.'
            );
    }
}