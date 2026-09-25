<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Usuarios;
use App\Models\Eventos;
use App\Models\CurtidaPublicacao;
use App\Models\ComentarioPublicacao;
use App\Models\Denuncia;

class Publicacao extends Model
{
    protected $table = 'tbl_publicacoes';

    protected $primaryKey = 'id_publicacao';

    public $timestamps = true;

    const CREATED_AT = 'criado_em_publicacao';
    const UPDATED_AT = 'atualizado_em_publicacao';

    protected $fillable = [
        'id_usuario',
        'id_evento',
        'texto_publicacao',
        'tipo_midia_publicacao',
        'midia_publicacao',
        'status_publicacao',
    ];

    protected $casts = [
        'criado_em_publicacao' => 'datetime',
        'atualizado_em_publicacao' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(
            Usuarios::class,
            'id_usuario',
            'id_usuario'
        );
    }

    public function evento()
    {
        return $this->belongsTo(
            Eventos::class,
            'id_evento',
            'id_evento'
        );
    }

    public function curtidas()
    {
        return $this->hasMany(
            CurtidaPublicacao::class,
            'id_publicacao',
            'id_publicacao'
        );
    }

    public function comentarios()
    {
        return $this->hasMany(
            ComentarioPublicacao::class,
            'id_publicacao',
            'id_publicacao'
        );
    }

    public function denuncias()
    {
        return $this->hasMany(
            Denuncia::class,
            'id_publicacao',
            'id_publicacao'
        );
    }
}