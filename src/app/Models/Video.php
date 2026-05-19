<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
     protected $table = 'tbl_videos';
    
    protected $primaryKey = 'id_video';
    
    public $timestamps = true;

    const CREATED_AT = 'criado_em_video';
    const UPDATED_AT = 'atualizado_em_video'; 
    
    protected $fillable = [
        'titulo_video',
        'subtitulo_video',
        'breve_descricao_video', 
        'foto_tema',
        'status_video',  
        'url_video', 
        'capa_video' ,   
        
    ];
}
