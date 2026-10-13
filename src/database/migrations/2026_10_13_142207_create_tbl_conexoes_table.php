<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_conexoes', function (Blueprint $table) {

            $table->increments('id_conexao');

            // tbl_usuarios.id_usuario é INT assinado
            $table->integer('id_usuario_solicitante');
            $table->integer('id_usuario_destino');

            $table
                ->string('status_conexao', 20)
                ->default('PENDENTE');

            $table
                ->timestamp('criado_em_conexao')
                ->useCurrent();

            $table
                ->timestamp('atualizado_em_conexao')
                ->useCurrent()
                ->useCurrentOnUpdate();


            $table->foreign('id_usuario_solicitante')
                ->references('id_usuario')
                ->on('tbl_usuarios')
                ->cascadeOnDelete();

            $table->foreign('id_usuario_destino')
                ->references('id_usuario')
                ->on('tbl_usuarios')
                ->cascadeOnDelete();


            $table->unique(
                [
                    'id_usuario_solicitante',
                    'id_usuario_destino',
                ],
                'uq_conexao_usuarios'
            );

            $table->index(
                'status_conexao'
            );
        });
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'tbl_conexoes'
        );
    }
};