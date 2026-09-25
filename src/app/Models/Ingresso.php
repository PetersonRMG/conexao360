<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuarios;
use App\Models\Eventos;

class Ingresso extends Model
{
    protected $table = 'tbl_ingressos';

    protected $primaryKey = 'id_ingresso';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_evento',
        'codigo_acesso_ingresso',
        'status_ingresso',
        'presenca_ingresso',
        'forma_validacao_ingresso',
        'validado_em_ingresso',
        'pagamento_compra_ingresso',
        'compra_em_ingresso',
    ];

    protected $casts = [
        'presenca_ingresso' => 'boolean',
        'validado_em_ingresso' => 'datetime',
        'compra_em_ingresso' => 'datetime',
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
}