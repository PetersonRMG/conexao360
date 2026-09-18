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
        Schema::create('tbl_conteudos', function (Blueprint $table) {
            $table->integer('id_conteudos', true);
            $table->integer('id_usuario');
            $table->integer('id_evento');
            $table->string('titulo_conteudo', 150);
            $table->string('tipo_conteudo', 10);
            $table->text('descricao_conteudo');
            $table->dateTime('liberado_em_conteudo');
            $table->string('url_conteudo');
            $table->string('status_conteudo', 10);
            $table->dateTime('criado_em_conteudo')->useCurrent();
            $table->dateTime('atualizado_em_conteudo')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_conteudos');
    }
};
