<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conexao extends Model
{
    protected $table = 'tbl_conexoes';

    protected $primaryKey = 'id_conexao';

    public $timestamps = true;

    const CREATED_AT = 'criado_em_conexao';
    const UPDATED_AT = 'atualizado_em_conexao';


    protected $fillable = [
        'id_usuario_solicitante',
        'id_usuario_destino',
        'status_conexao',
    ];


    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(
            Usuarios::class,
            'id_usuario_solicitante',
            'id_usuario'
        );
    }


    public function destino(): BelongsTo
    {
        return $this->belongsTo(
            Usuarios::class,
            'id_usuario_destino',
            'id_usuario'
        );
    }
}