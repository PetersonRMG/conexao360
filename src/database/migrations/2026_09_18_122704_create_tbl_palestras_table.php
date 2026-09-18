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
        Schema::create('tbl_palestras', function (Blueprint $table) {
            $table->integer('id_palestra', true);
            $table->integer('id_usuario');
            $table->integer('id_evento');
            $table->string('foto_palestra', 80);
            $table->string('titulo_palestra', 200);
            $table->string('video_palestra');
            $table->string('status_palestra', 10);
            $table->dateTime('criado_em_palestra')->useCurrent();
            $table->dateTime('atualizado_em_palestra')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_palestras');
    }
};
