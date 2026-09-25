<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $table = 'tbl_denuncias';

    protected $primaryKey = 'id_denuncia';

    public $timestamps = true;

    const CREATED_AT = 'criado_em_denuncia';
    const UPDATED_AT = 'atualizado_em_denuncia';

    protected $fillable = [
        'id_publicacao',
        'id_usuario_denunciante',
        'id_usuario_moderador',
        'motivo_denuncia',
        'descricao_denuncia',
        'status_denuncia',
        'decisao_denuncia',
        'observacao_moderador',
        'analisado_em_denuncia',
    ];

    public function publicacao()
    {
        return $this->belongsTo(
            Publicacao::class,
            'id_publicacao',
            'id_publicacao'
        );
    }

    public function denunciante()
    {
        return $this->belongsTo(
            Usuarios::class,
            'id_usuario_denunciante',
            'id_usuario'
        );
    }

    public function moderador()
    {
        return $this->belongsTo(
            Usuarios::class,
            'id_usuario_moderador',
            'id_usuario'
        );
    }
}