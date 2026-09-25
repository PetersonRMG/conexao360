<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('tbl_feeds');

        Schema::create('tbl_publicacoes', function (Blueprint $table) {
            $table->integer('id_publicacao', true);

            $table->integer('id_usuario');
            $table->integer('id_evento')->nullable();

            $table->text('texto_publicacao')->nullable();

            $table->string('tipo_midia_publicacao', 20)->nullable();
            $table->string('midia_publicacao', 255)->nullable();

            $table->string('status_publicacao', 20)
                ->default('ATIVO');

            $table->dateTime('criado_em_publicacao')
                ->useCurrent();

            $table->dateTime('atualizado_em_publicacao')
                ->useCurrent()
                ->useCurrentOnUpdate();

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('tbl_usuarios')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_evento')
                ->references('id_evento')
                ->on('tbl_eventos')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->index('id_usuario');
            $table->index('id_evento');
            $table->index([
                'status_publicacao',
                'criado_em_publicacao'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_publicacoes');

        Schema::create('tbl_feeds', function (Blueprint $table) {
            $table->integer('id_feeds', true);

            $table->integer('id_usuario');
            $table->integer('id_evento');

            $table->integer('curtidas_feed')->nullable();
            $table->string('foto_feed', 255)->nullable();
            $table->string('comentario_feed', 100)->nullable();
            $table->string('status_feed', 10)->nullable();

            $table->dateTime('criado_em_feed')
                ->useCurrent();

            $table->dateTime('atualizado_em_feed')
                ->useCurrent()
                ->useCurrentOnUpdate();
        });
    }
};