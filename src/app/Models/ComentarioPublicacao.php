<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Publicacao;
use App\Models\Usuarios;
class ComentarioPublicacao extends Model
{
    protected $table = 'tbl_comentarios_publicacao';

    protected $primaryKey = 'id_comentario_publicacao';

    public $timestamps = true;

    const CREATED_AT = 'criado_em_comentario_publicacao';
    const UPDATED_AT = 'atualizado_em_comentario_publicacao';

    protected $fillable = [
        'id_publicacao',
        'id_usuario',
        'texto_comentario_publicacao',
        'status_comentario_publicacao',
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