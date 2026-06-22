<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedCompartilhamento extends Model
{
    protected $table = 'tbl_feed_compartilhamentos';

    protected $primaryKey = 'id_compartilhamento';

    public $timestamps = false;

    protected $fillable = [

        'id_feeds',

        'id_usuario'
    ];

    public function feed()
    {
        return $this->belongsTo(
            Feed::class,
            'id_feeds',
            'id_feeds'
        );
    }
}