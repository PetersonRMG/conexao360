<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $table =
        'tbl_notificacoes';

    protected $primaryKey =
        'id_notificacao';

    public $timestamps = true;

    const CREATED_AT =
        'criado_em_notificacao';

    const UPDATED_AT =
        'atualizado_em_notificacao';


    protected $fillable = [
        'id_usuario_destino',
        'id_usuario_origem',
        'tipo_notificacao',
        'titulo_notificacao',
        'mensagem_notificacao',
        'id_referencia',
        'tipo_referencia',
        'lida_notificacao',
    ];


    protected $casts = [
        'lida_notificacao' =>
            'boolean',

        'criado_em_notificacao' =>
            'datetime',

        'atualizado_em_notificacao' =>
            'datetime',
    ];


    public function usuarioOrigem()
    {
        return $this->belongsTo(
            Usuarios::class,
            'id_usuario_origem',
            'id_usuario'
        );
    }


    public function usuarioDestino()
    {
        return $this->belongsTo(
            Usuarios::class,
            'id_usuario_destino',
            'id_usuario'
        );
    }
}