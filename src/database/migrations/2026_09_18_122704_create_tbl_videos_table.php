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
        Schema::create('tbl_videos', function (Blueprint $table) {
            $table->integer('id_video', true);
            $table->integer('id_evento')->default(1)->index('fk_video_eventos');
            $table->string('titulo_video', 50);
            $table->string('subtitulo_video', 50);
            $table->string('breve_descricao_video', 80);
            $table->string('url_video');
            $table->string('status_video', 10);
            $table->string('legenda_video', 100);
            $table->string('capa_video');
            $table->dateTime('criado_em_video')->useCurrent();
            $table->dateTime('atualizado_em_video')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_videos');
    }
};
