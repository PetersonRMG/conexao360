<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Publicacao;
use App\Models\CurtidaPublicacao;
use App\Models\ComentarioPublicacao;
use App\Models\Denuncia;
use App\Models\Ingresso;
use App\Models\Conteudo;

class Usuarios extends Authenticatable
{
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
        'status_usuario',
        'instagram_usuario',
        'linkedin_usuario',
        'youtube_usuario',
        'tiktok_usuario',
        'facebook_usuario',
        'site_usuario',
    ];

    protected $hidden = [
        'senha_usuario',
    ];

    public function getAuthPassword()
    {
        return $this->senha_usuario;
    }

    public function getAuthPasswordName()
    {
        return 'senha_usuario';
    }

    public function publicacoes()
    {
        return $this->hasMany(
            Publicacao::class,
            'id_usuario',
            'id_usuario'
        );
    }

    public function curtidasPublicacoes()
    {
        return $this->hasMany(
            CurtidaPublicacao::class,
            'id_usuario',
            'id_usuario'
        );
    }

    public function comentariosPublicacoes()
    {
        return $this->hasMany(
            ComentarioPublicacao::class,
            'id_usuario',
            'id_usuario'
        );
    }

    public function denunciasRealizadas()
    {
        return $this->hasMany(
            Denuncia::class,
            'id_usuario_denunciante',
            'id_usuario'
        );
    }

    public function denunciasModeradas()
    {
        return $this->hasMany(
            Denuncia::class,
            'id_usuario_moderador',
            'id_usuario'
        );
    }

    public function ingressos()
    {
        return $this->hasMany(
            Ingresso::class,
            'id_usuario',
            'id_usuario'
        );
    }

    public function conteudos()
    {
        return $this->hasMany(
            Conteudo::class,
            'id_usuario',
            'id_usuario'
        );
    }
}