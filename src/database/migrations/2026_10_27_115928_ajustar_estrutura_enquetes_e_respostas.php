<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =========================================================
        // ENQUETES
        // =========================================================

        Schema::table('tbl_enquetes', function (Blueprint $table) {

            $table
                ->integer('id_usuario')
                ->nullable()
                ->after('id_enquete');

            $table
                ->string('status_enquete', 20)
                ->default('ATIVA')
                ->after('resposta_tres_enquete');

            $table
                ->dateTime('criado_em_enquete')
                ->nullable()
                ->after('status_enquete');

            $table
                ->dateTime('atualizado_em_enquete')
                ->nullable()
                ->after('criado_em_enquete');

        });


        // =========================================================
        // RESPOSTAS
        // =========================================================

        Schema::table('tbl_respostas', function (Blueprint $table) {

            $table
                ->dateTime('criado_em_resposta')
                ->nullable()
                ->after('resposta_resposta');

            $table->unique(
                [
                    'id_usuario',
                    'id_enquete',
                ],
                'uq_respostas_usuario_enquete'
            );

        });
    }


    public function down(): void
    {
        // =========================================================
        // RESPOSTAS
        // =========================================================

        Schema::table('tbl_respostas', function (Blueprint $table) {

            $table->dropUnique(
                'uq_respostas_usuario_enquete'
            );

            $table->dropColumn(
                'criado_em_resposta'
            );

        });


        // =========================================================
        // ENQUETES
        // =========================================================

        Schema::table('tbl_enquetes', function (Blueprint $table) {

            $table->dropColumn([
                'id_usuario',
                'status_enquete',
                'criado_em_enquete',
                'atualizado_em_enquete',
            ]);

        });
    }
};