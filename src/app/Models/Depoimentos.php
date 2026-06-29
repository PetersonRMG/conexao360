<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Eventos;
use App\Models\Usuarios;

class Depoimentos extends Model
{    //
    protected $table = 'tbl_depoimentos';
    
    protected $primaryKey = 'id_depoimentos';
    
    public $timestamps = true;

    const CREATED_AT = 'criado_em_depoimento';
    const UPDATED_AT = 'atualizado_em_depoimento'; 
    
    protected $fillable = [
        'id_usuario',
        'id_evento',
        'status_depoimento',
        'descricao_depoimento',        
    ];

    public function evento(){
        return $this->belongsTo(Eventos::class, 'id_evento', 'id_evento');
    }

    public function usuario(){
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id_usuario');
    }
}
