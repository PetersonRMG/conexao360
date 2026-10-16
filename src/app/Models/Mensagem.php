<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $table = 'tbl_mensagens';

    protected $primaryKey = 'id_mensagem';

    public $timestamps = true;

    const CREATED_AT = 'criado_em_mensagem';
    const UPDATED_AT = 'atualizado_em_mensagem';

    protected $fillable = [
        'id_conversa',
        'id_usuario_remetente',
        'texto_mensagem',
        'lida_mensagem',
    ];

    protected $casts = [
        'lida_mensagem' => 'boolean',
    ];


    // =============================================================
    // CONVERSA
    // =============================================================

    public function conversa()
    {
        return $this->belongsTo(
            Conversa::class,
            'id_conversa',
            'id_conversa'
        );
    }


    // =============================================================
    // REMETENTE
    // =============================================================

    public function remetente()
    {
        return $this->belongsTo(
            Usuarios::class,
            'id_usuario_remetente',
            'id_usuario'
        );
    }
}