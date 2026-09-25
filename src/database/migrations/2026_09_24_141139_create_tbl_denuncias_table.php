<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_denuncias', function (Blueprint $table) {
            $table->integer('id_denuncia', true);

            $table->integer('id_publicacao');

            $table->integer('id_usuario_denunciante');
            $table->integer('id_usuario_moderador')->nullable();

            $table->string('motivo_denuncia', 30);

            $table->text('descricao_denuncia')
                ->nullable();

            $table->string('status_denuncia', 20)
                ->default('PENDENTE');

            $table->string('decisao_denuncia', 20)
                ->nullable();

            $table->text('observacao_moderador')
                ->nullable();

            $table->dateTime('analisado_em_denuncia')
                ->nullable();

            $table->dateTime('criado_em_denuncia')
                ->useCurrent();

            $table->dateTime('atualizado_em_denuncia')
                ->useCurrent()
                ->useCurrentOnUpdate();

            $table->foreign('id_publicacao')
                ->references('id_publicacao')
                ->on('tbl_publicacoes')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_usuario_denunciante')
                ->references('id_usuario')
                ->on('tbl_usuarios')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_usuario_moderador')
                ->references('id_usuario')
                ->on('tbl_usuarios')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->unique([
                'id_publicacao',
                'id_usuario_denunciante'
            ]);

            $table->index([
                'status_denuncia',
                'criado_em_denuncia'
            ]);

            $table->index('id_publicacao');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_denuncias');
    }
};