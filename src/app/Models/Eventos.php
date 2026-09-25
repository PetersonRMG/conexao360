<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\Publicacao;
use App\Models\Ingresso;
use App\Models\Conteudo;

class Eventos extends Model
{
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
        'hora_termino_evento',
    ];

    public function publicacoes()
    {
        return $this->hasMany(
            Publicacao::class,
            'id_evento',
            'id_evento'
        );
    }

    public function ingressos()
    {
        return $this->hasMany(
            Ingresso::class,
            'id_evento',
            'id_evento'
        );
    }

    public function conteudos()
    {
        return $this->hasMany(
            Conteudo::class,
            'id_evento',
            'id_evento'
        );
    }

    public function getDataFormatadaAttribute()
    {
        Carbon::setLocale('pt_BR');

        $inicio = Carbon::parse(
            $this->data_inicial_evento . ' ' . $this->hora_inicial_evento
        );

        $fim = Carbon::parse(
            $this->data_termino_evento . ' ' . $this->hora_termino_evento
        );

        return $inicio->format('d')
            . ' e '
            . $fim->format('d')
            . ' de '
            . ucfirst($inicio->translatedFormat('F'))
            . ' de '
            . $inicio->format('Y')
            . ', às '
            . $inicio->format('H\hi');
    }
}