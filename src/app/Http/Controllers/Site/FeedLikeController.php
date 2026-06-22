<?php

namespace App\Http\Controllers\Site;

use App\Models\Feed;
use App\Models\FeedCurtida;
use App\Http\Controllers\Controller;

class FeedLikeController extends Controller
{
    public function toggle($id)
    {
        $usuarioId = 1;

        $feed = Feed::findOrFail(
            $id
        );

        $curtida = FeedCurtida::where(
            'id_feeds',
            $feed->id_feeds
        )
        ->where(
            'id_usuario',
            $usuarioId
        )
        ->first();

        if ($curtida) {

            $curtida->delete();

        } else {

            FeedCurtida::create([

                'id_feeds' =>
                    $feed->id_feeds,

                'id_usuario' =>
                    $usuarioId
            ]);
        }

        $feed->curtidas_feed =
            FeedCurtida::where(
                'id_feeds',
                $feed->id_feeds
            )->count();

        $feed->save();

        return back();
    }
}