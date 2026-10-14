<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'tbl_notificacoes',
            function (Blueprint $table) {

                $table->increments(
                    'id_notificacao'
                );

                $table->integer(
                    'id_usuario_destino'
                );

                $table->integer(
                    'id_usuario_origem'
                )->nullable();

                $table->string(
                    'tipo_notificacao',
                    50
                );

                $table->string(
                    'titulo_notificacao',
                    255
                );

                $table->text(
                    'mensagem_notificacao'
                )->nullable();

                $table->integer(
                    'id_referencia'
                )->nullable();

                $table->string(
                    'tipo_referencia',
                    50
                )->nullable();

                $table->boolean(
                    'lida_notificacao'
                )->default(false);

                $table->timestamp(
                    'criado_em_notificacao'
                )->nullable();

                $table->timestamp(
                    'atualizado_em_notificacao'
                )->nullable();


                // USUÁRIO QUE RECEBE

                $table->foreign(
                    'id_usuario_destino'
                )
                    ->references(
                        'id_usuario'
                    )
                    ->on(
                        'tbl_usuarios'
                    )
                    ->cascadeOnDelete();


                // USUÁRIO QUE GEROU

                $table->foreign(
                    'id_usuario_origem'
                )
                    ->references(
                        'id_usuario'
                    )
                    ->on(
                        'tbl_usuarios'
                    )
                    ->nullOnDelete();


                $table->index([
                    'id_usuario_destino',
                    'lida_notificacao',
                ]);

                $table->index(
                    'tipo_notificacao'
                );

            }
        );
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'tbl_notificacoes'
        );
    }
};