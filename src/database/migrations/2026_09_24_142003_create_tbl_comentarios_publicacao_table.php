<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_comentarios_publicacao', function (Blueprint $table) {
            $table->integer('id_comentario_publicacao', true);

            $table->integer('id_publicacao');
            $table->integer('id_usuario');

            $table->text('texto_comentario_publicacao');

            $table->string('status_comentario_publicacao', 20)
                ->default('ATIVO');

            $table->dateTime('criado_em_comentario_publicacao')
                ->useCurrent();

            $table->dateTime('atualizado_em_comentario_publicacao')
                ->useCurrent()
                ->useCurrentOnUpdate();

            $table->foreign('id_publicacao')
                ->references('id_publicacao')
                ->on('tbl_publicacoes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('tbl_usuarios')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index(
                ['id_publicacao', 'criado_em_comentario_publicacao'],
                'idx_comentarios_publicacao_data'
            );

            $table->index('id_usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_comentarios_publicacao');
    }
};