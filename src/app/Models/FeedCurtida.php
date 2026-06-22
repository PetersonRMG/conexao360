<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedCurtida extends Model
{
    protected $table = 'tbl_feed_curtidas';

    protected $primaryKey = 'id_curtida';

    public $timestamps = false;

    protected $fillable = [

        'id_feeds',

        'id_usuario'
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