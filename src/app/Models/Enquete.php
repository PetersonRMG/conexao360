<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquete extends Model
{
    protected $table = 'tbl_enquetes';

    protected $primaryKey = 'id_enquete';

    public $timestamps = false;

    protected $fillable = [
        'pergunta_enquete',
    ];

    public function respostas()
    {
        return $this->hasMany(
            Resposta::class,
            'id_enquete',
            'id_enquete'
        );
    }
}
