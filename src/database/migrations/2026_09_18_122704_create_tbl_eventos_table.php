<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_eventos', function (Blueprint $table) {
            $table->integer('id_evento', true);
            $table->string('banner_evento');
            $table->string('titulo_evento', 200);
            $table->integer('edicao_evento');
            $table->text('descricao_evento');
            $table->date('data_inicial_evento');
            $table->time('hora_inicial_evento');
            $table->string('endereco_evento', 80);
            $table->string('url_evento', 2000)->nullable();
            $table->string('status_evento', 10);
            $table->dateTime('criado_em_evento')->useCurrent();
            $table->dateTime('atualizado_em_evento')->useCurrentOnUpdate()->useCurrent();
            $table->date('data_termino_evento');
            $table->time('hora_termino_evento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_eventos');
    }
};
