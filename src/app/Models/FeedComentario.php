<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedComentario extends Model
{
    protected $table = 'tbl_feed_comentarios';

    protected $primaryKey = 'id_comentario';

    public $timestamps = true;

    const CREATED_AT = 'criado_em_comentario';
    const UPDATED_AT = 'atualizado_em_comentario';

    protected $fillable = [

        'id_feeds',
        'id_usuario',
        'comentario',
        'status_comentario'
    ];

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'id_usuario',
            'id_usuario'
        );
    }

    public function feed()
    {
        return $this->belongsTo(
            Feed::class,
            'id_feeds',
            'id_feeds'
        );
    }
}