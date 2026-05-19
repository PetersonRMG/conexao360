<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temas extends Model
{
    //
        
    protected $table = 'tbl_temas';
    
    protected $primaryKey = 'id_tema';
    
    public $timestamps = true;

    const CREATED_AT = 'criado_em_tema';
    const UPDATED_AT = 'atualizado_em_tema'; 
    
    protected $fillable = [
        'titulo_tema',
        'subtitulo_tema',
        'breve_descricao_tema', 
        'foto_tema',
        'status_tema',       
        
    ];
}
