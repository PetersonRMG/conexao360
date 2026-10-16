<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'tbl_mensagens',
            function (Blueprint $table) {

                $table->increments(
                    'id_mensagem'
                );


                // =====================================
                // CONVERSA
                // =====================================

                $table->unsignedInteger(
                    'id_conversa'
                );


                // =====================================
                // REMETENTE
                // =====================================
                //
                // tbl_usuarios.id_usuario é INT
                // assinado.
                // =====================================

                $table->integer(
                    'id_usuario_remetente'
                );


                // =====================================
                // CONTEÚDO
                // =====================================

                $table->text(
                    'texto_mensagem'
                );


                // =====================================
                // LEITURA
                // =====================================

                $table->boolean(
                    'lida_mensagem'
                )->default(false);


                // =====================================
                // DATAS
                // =====================================

                $table->dateTime(
                    'criado_em_mensagem'
                )->useCurrent();

                $table->dateTime(
                    'atualizado_em_mensagem'
                )
                    ->useCurrent()
                    ->useCurrentOnUpdate();


                // =====================================
                // RELACIONAMENTOS
                // =====================================

                $table->foreign(
                    'id_conversa'
                )
                    ->references(
                        'id_conversa'
                    )
                    ->on(
                        'tbl_conversas'
                    )
                    ->cascadeOnDelete();


                $table->foreign(
                    'id_usuario_remetente'
                )
                    ->references(
                        'id_usuario'
                    )
                    ->on(
                        'tbl_usuarios'
                    );


                // =====================================
                // ÍNDICES
                // =====================================

                $table->index(
                    [
                        'id_conversa',
                        'criado_em_mensagem',
                    ],
                    'idx_mensagens_conversa_data'
                );


                $table->index(
                    'id_usuario_remetente'
                );


                $table->index(
                    'lida_mensagem'
                );
            }
        );
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'tbl_mensagens'
        );
    }
};