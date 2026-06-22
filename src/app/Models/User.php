<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define a tabela real da tua base de dados
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
        'conexoes_usuario',
        'curtidas_usuario'
    ];

    protected $hidden = [
        'senha_usuario',
    ];

    public function getAuthPassword()
    {
        return $this->senha_usuario;
    }

    // Relacionamento: Um utilizador possui muitas publicações no feed
    public function feeds()
    {
        return $this->hasMany(Feed::class, 'id_usuario', 'id_usuario');
    }

    public function curtidas()
{
    return $this->hasMany(
        FeedCurtida::class,
        'id_usuario',
        'id_usuario'
    );
}
}