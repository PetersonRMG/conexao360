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
        Schema::create('tbl_depoimentos', function (Blueprint $table) {
            $table->integer('id_depoimentos', true);
            $table->integer('id_usuario');
            $table->integer('id_evento');
            $table->string('status_depoimento', 10);
            $table->text('descricao_depoimento');
            $table->dateTime('criado_em_depoimento')->useCurrent();
            $table->dateTime('atualizado_em_depoimento')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_depoimentos');
    }
};
