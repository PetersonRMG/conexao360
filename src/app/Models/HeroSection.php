<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    // Força o modelo a usar o nome exato da tabela do seu banco de dados
    protected $table = 'tbl_hero_section';

    // Define a chave primária correta que você usou na rota e no formulário (id_hero)
    protected $primaryKey = 'id_hero';

    // Permite o preenchimento em massa dos campos no controlador
    protected $fillable = [
        'tagline',
        'titulo',
        'subtitulo',
        'texto_botao',
        'link_botao',
        'foto_banner',
        'status'
    ];
}