<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquete extends Model
{
    protected $table = 'tbl_enquetes';

    protected $primaryKey = 'id_enquete';

    public $timestamps = true;

    const CREATED_AT = 'criado_em_enquete';
    const UPDATED_AT = 'atualizado_em_enquete';

    protected $fillable = [
        'id_usuario',
        'pergunta_enquete',
        'status_enquete',
    ];

    protected $casts = [
        'criado_em_enquete' => 'datetime',
        'atualizado_em_enquete' => 'datetime',
    ];

    public function respostas()
    {
        return $this->hasMany(
            Resposta::class,
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