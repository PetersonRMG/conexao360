<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_ingressos', function (Blueprint $table) {

            $table->boolean('presenca_ingresso')
                ->default(false)
                ->after('status_ingresso');

            $table->string('forma_validacao_ingresso', 20)
                ->nullable()
                ->after('presenca_ingresso');

            $table->dateTime('validado_em_ingresso')
                ->nullable()
                ->after('forma_validacao_ingresso');

            $table->index(
                [
                    'id_usuario',
                    'id_evento',
                    'status_ingresso',
                    'presenca_ingresso'
                ],
                'idx_ingresso_acesso_evento'
            );
        });
    }

    public function down(): void
    {
        Schema::table('tbl_ingressos', function (Blueprint $table) {

            $table->dropIndex('idx_ingresso_acesso_evento');

            $table->dropColumn([
                'presenca_ingresso',
                'forma_validacao_ingresso',
                'validado_em_ingresso'
            ]);
        });
    }
};