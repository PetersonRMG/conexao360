<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversa extends Model
{
    protected $table = 'tbl_conversas';

    protected $primaryKey = 'id_conversa';

    public $timestamps = true;

    const CREATED_AT = 'criado_em_conversa';
    const UPDATED_AT = 'atualizado_em_conversa';

    protected $fillable = [
        'id_usuario_um',
        'id_usuario_dois',
    ];


    // =============================================================
    // USUÁRIO 1
    // =============================================================

    public function usuarioUm()
    {
        return $this->belongsTo(
            Usuarios::class,
            'id_usuario_um',
            'id_usuario'
        );
    }


    // =============================================================
    // USUÁRIO 2
    // =============================================================

    public function usuarioDois()
    {
        return $this->belongsTo(
            Usuarios::class,
            'id_usuario_dois',
            'id_usuario'
        );
    }


    // =============================================================
    // MENSAGENS
    // =============================================================

    public function mensagens()
    {
        return $this->hasMany(
            Mensagem::class,
            'id_conversa',
            'id_conversa'
        );
    }


    // =============================================================
    // ÚLTIMA MENSAGEM
    // =============================================================

    public function ultimaMensagem()
    {
        return $this->hasOne(
            Mensagem::class,
            'id_conversa',
            'id_conversa'
        )->latestOfMany(
            'criado_em_mensagem'
        );
    }
}