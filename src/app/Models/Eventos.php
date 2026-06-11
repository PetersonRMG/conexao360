<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    //
     protected $table = 'tbl_eventos';
    
    protected $primaryKey = 'id_evento';
    
    public $timestamps = true;

    const CREATED_AT = 'criado_em_evento';
    const UPDATED_AT = 'atualizado_em_evento'; 
    
    protected $fillable = [
        'banner_evento',
        'titulo_evento',
        'edicao_evento',
        'descricao_evento',
        'data_inicial_evento',
        'hora_inicial_evento',
        'endereco_evento',
        'url_evento',
        'status_evento',
        'data_termino_evento',
        'hora_termino_evento'  
        
    ];
}
