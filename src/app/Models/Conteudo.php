<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuarios;
use App\Models\Eventos;

class Conteudo extends Model
{
    protected $table = 'tbl_conteudos';

    protected $primaryKey = 'id_conteudos';

    public $timestamps = true;

    const CREATED_AT = 'criado_em_conteudo';
    const UPDATED_AT = 'atualizado_em_conteudo';

    protected $fillable = [
        'id_usuario',
        'id_evento',
        'titulo_conteudo',
        'tipo_conteudo',
        'nivel_acesso_conteudo',
        'descricao_conteudo',
        'liberado_em_conteudo',
        'url_conteudo',
        'status_conteudo',
    ];

    protected $casts = [
        'liberado_em_conteudo' => 'datetime',
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

    public function getPlataformaAttribute(): string
    {
        $host = strtolower((string) parse_url((string) $this->url_conteudo, PHP_URL_HOST));

        if (str_contains($host, 'instagram.com')) {
            return 'Instagram';
        }

        if (str_contains($host, 'youtube.com') || str_contains($host, 'youtu.be')) {
            return 'YouTube';
        }

        if (str_contains($host, 'vimeo.com')) {
            return 'Vimeo';
        }

        return 'Outro';
    }
}