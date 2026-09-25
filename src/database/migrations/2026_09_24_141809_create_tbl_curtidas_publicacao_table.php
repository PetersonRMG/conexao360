<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_curtidas_publicacao', function (Blueprint $table) {
            $table->integer('id_curtida_publicacao', true);

            $table->integer('id_publicacao');
            $table->integer('id_usuario');

            $table->dateTime('criado_em_curtida_publicacao')
                ->useCurrent();

            $table->foreign('id_publicacao')
                ->references('id_publicacao')
                ->on('tbl_publicacoes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('tbl_usuarios')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique([
                'id_publicacao',
                'id_usuario'
            ]);

            $table->index('id_usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_curtidas_publicacao');
    }
};