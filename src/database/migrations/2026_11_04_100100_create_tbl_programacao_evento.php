<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_programacao_evento', function (Blueprint $table) {
            $table->increments('id_programacao');
            // tbl_eventos.id_evento é INTEGER assinado no projeto existente.
            $table->integer('id_evento');
            $table->string('titulo_programacao', 150);
            $table->text('descricao_programacao')->nullable();
            $table->dateTime('inicio_programacao');
            $table->dateTime('fim_programacao')->nullable();
            $table->string('local_programacao', 150)->nullable();
            $table->string('palestrante_programacao', 150)->nullable();
            $table->string('status_programacao', 10)->default('ATIVO');
            $table->timestamps();

            $table->index(['id_evento', 'inicio_programacao'], 'idx_programacao_evento_inicio');
            $table->foreign('id_evento', 'fk_programacao_evento')
                ->references('id_evento')->on('tbl_eventos')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_programacao_evento');
    }
};
