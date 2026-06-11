<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Eventos;

class Dra extends Model
{
    //
    protected $table = 'tbl_dra';
    
    protected $primaryKey = 'id_dra';
    
    public $timestamps = true;

    const CREATED_AT = 'criado_em_dra';
    const UPDATED_AT = 'atualizado_em_dra'; 
    
    protected $fillable = [
        'foto_dra',
        'titulo_dra',
        'sub_titulo_dra', 
        'descricao_dra',
        'status_dra',       
        
    ];

    public function eventos(){
        return $this->belongsTo(Eventos::class, 'id_evento', 'id_evento');
    }
}
