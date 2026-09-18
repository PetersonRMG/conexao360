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
        Schema::create('tbl_temas', function (Blueprint $table) {
            $table->integer('id_tema', true);
            $table->string('titulo_tema', 200)->nullable();
            $table->string('subtitulo_tema', 200)->nullable();
            $table->string('breve_descricao_tema', 80);
            $table->string('foto_tema');
            $table->integer('id_evento')->default(1)->index('fk_temas_eventos');
            $table->string('status_tema', 10);
            $table->dateTime('criado_em_tema')->useCurrent();
            $table->dateTime('atualizado_em_tema')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_temas');
    }
};
