<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'tbl_conversas',
            function (Blueprint $table) {

                $table->increments(
                    'id_conversa'
                );


                // =====================================
                // PARTICIPANTES DA CONVERSA
                // =====================================
                //
                // tbl_usuarios.id_usuario é INT
                // assinado, por isso usamos integer()
                // aqui também.
                // =====================================

                $table->integer(
                    'id_usuario_um'
                );

                $table->integer(
                    'id_usuario_dois'
                );


                // =====================================
                // DATAS
                // =====================================

                $table->dateTime(
                    'criado_em_conversa'
                )->useCurrent();

                $table->dateTime(
                    'atualizado_em_conversa'
                )
                    ->useCurrent()
                    ->useCurrentOnUpdate();


                // =====================================
                // CHAVES E ÍNDICES
                // =====================================

                $table->foreign(
                    'id_usuario_um'
                )
                    ->references(
                        'id_usuario'
                    )
                    ->on(
                        'tbl_usuarios'
                    );


                $table->foreign(
                    'id_usuario_dois'
                )
                    ->references(
                        'id_usuario'
                    )
                    ->on(
                        'tbl_usuarios'
                    );


                // =====================================
                // IMPEDIR CONVERSA DUPLICADA
                // =====================================
                //
                // A API sempre salvará o menor ID
                // em id_usuario_um e o maior ID
                // em id_usuario_dois.
                //
                // Assim:
                //
                // 8 | 12
                //
                // é a única combinação possível.
                // =====================================

                $table->unique(
                    [
                        'id_usuario_um',
                        'id_usuario_dois',
                    ],
                    'uq_conversa_usuarios'
                );


                $table->index(
                    'id_usuario_um'
                );

                $table->index(
                    'id_usuario_dois'
                );
            }
        );
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'tbl_conversas'
        );
    }
};