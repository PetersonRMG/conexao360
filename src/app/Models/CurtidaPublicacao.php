<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Publicacao;
use App\Models\Usuarios;

class CurtidaPublicacao extends Model
{
    protected $table = 'tbl_curtidas_publicacao';

    protected $primaryKey = 'id_curtida_publicacao';

    public $timestamps = false;

    protected $fillable = [
        'id_publicacao',
        'id_usuario',
    ];

    public function publicacao()
    {
        return $this->belongsTo(
            Publicacao::class,
            'id_publicacao',
            'id_publicacao'
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