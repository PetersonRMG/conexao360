<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuarios extends Authenticatable
{
    //
    protected $table = 'tbl_usuarios';
    
    protected $primaryKey = 'id_usuario';

    
    public $timestamps = true;
    
    const CREATED_AT = 'criado_em_usuario';
    const UPDATED_AT = 'atualizado_em_usuario'; 
    
    protected $fillable = [
        'nome_usuario',
        'foto_usuario',
        'email_usuario',
        'area_atuacao_usuario',
        'senha_usuario',
        'termos_usuario',
        'perfil_usuario',
        'estado_usuario',
        'sobre_usuario',
        'status_usuario' ,
                
    ];
    
    protected $hidden = ['senha_usuario'];


    public function getAuthPassword(){
        return $this->senha_usuario;
    }

        public function getAuthPasswordName()
    {
        return 'senha_usuario';
    }
}
