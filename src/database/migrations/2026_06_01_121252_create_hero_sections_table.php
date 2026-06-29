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
        Schema::create('tbl_hero_section', function (Blueprint $table) {
            $table->id('id_hero');
            $table->string('tagline')->nullable();
            $table->string('titulo');
            $table->text('subtitulo')->nullable();
            $table->string('texto_botao')->nullable();
            $table->string('link_botao')->nullable();
            $table->string('foto_banner')->nullable();
            $table->enum('status', ['ATIVO', 'INATIVO'])->default('ATIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_hero_section');
    }
};