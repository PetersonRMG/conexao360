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
        Schema::create('tbl_dra', function (Blueprint $table) {
            $table->integer('id_dra', true);
            $table->integer('id_evento')->default(1)->index('fk_dra_eventos');
            $table->string('foto_dra');
            $table->string('titulo_dra', 100);
            $table->string('sub_titulo_dra', 100);
            $table->text('descricao_dra');
            $table->string('status_dra', 10);
            $table->dateTime('criado_em_dra')->useCurrent();
            $table->dateTime('atualizado_em_dra')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_dra');
    }
};
