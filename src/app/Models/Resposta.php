<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    protected $table = 'tbl_respostas';

    protected $primaryKey = 'id_resposta';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_enquete',
        'resposta_resposta',
    ];

    public function enquete()
    {
        return $this->belongsTo(
            Enquete::class,
            'id_enquete',
            'id_enquete'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            Usuarios::class,
            'id_usuario',
            'id_usuario'
        );
    }
}
