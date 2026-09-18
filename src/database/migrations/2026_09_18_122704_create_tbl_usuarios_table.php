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
        Schema::create('tbl_usuarios', function (Blueprint $table) {
            $table->integer('id_usuario', true);
            $table->string('nome_usuario', 100);
            $table->string('foto_usuario', 80);
            $table->string('email_usuario', 80);
            $table->string('area_atuacao_usuario', 150);
            $table->string('senha_usuario');
            $table->tinyInteger('termos_usuario');
            $table->string('perfil_usuario', 45);
            $table->string('estado_usuario', 2);
            $table->integer('conexoes_usuario')->nullable();
            $table->string('comentario_usuario', 200)->nullable();
            $table->string('sobre_usuario', 200);
            $table->string('instagram_usuario')->nullable();
            $table->string('linkedin_usuario')->nullable();
            $table->string('youtube_usuario')->nullable();
            $table->string('tiktok_usuario')->nullable();
            $table->string('facebook_usuario')->nullable();
            $table->string('site_usuario')->nullable();
            $table->string('enquete_usuario', 10)->nullable();
            $table->integer('curtidas_usuario')->nullable();
            $table->dateTime('criado_em_usuario')->useCurrent();
            $table->dateTime('atualizado_em_usuario')->useCurrentOnUpdate()->useCurrent();
            $table->string('status_usuario', 15);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_usuarios');
    }
};
