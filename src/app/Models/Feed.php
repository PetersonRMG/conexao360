<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\FeedComentario;
use App\Models\FeedCurtida;
use App\Models\FeedCompartilhamento;
class Feed extends Model
{
    protected $table = 'tbl_feeds';

    protected $primaryKey = 'id_feeds';

    public $timestamps = true;

    const CREATED_AT = 'criado_em_feed';
    const UPDATED_AT = 'atualizado_em_feed';

    protected $fillable = [

        'id_usuario',

        'id_evento',

        'conteudo_feed',

        'tipo_feed',

        'foto_feed',

        'video_feed',

        'curtidas_feed',

        'total_comentarios_feed',

        'compartilhamentos_feed',

        'status_feed'
    ];

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'id_usuario',
            'id_usuario'
        );
    }

    public function comentarios()
    {
        return $this->hasMany(
            FeedComentario::class,
            'id_feeds',
            'id_feeds'
        );
    }

    public function curtidas()
    {
        return $this->hasMany(
            FeedCurtida::class,
            'id_feeds',
            'id_feeds'
        );
    }

    public function compartilhamentos()
{
    return $this->hasMany(
        FeedCompartilhamento::class,
        'id_feeds',
        'id_feeds'
    );
}
}