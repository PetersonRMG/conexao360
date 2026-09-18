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
        Schema::create('tbl_respostas', function (Blueprint $table) {
            $table->integer('id_resposta', true);
            $table->integer('id_usuario');
            $table->integer('id_enquete');
            $table->tinyInteger('resposta_resposta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_respostas');
    }
};
