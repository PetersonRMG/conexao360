<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tbl_programacao_evento')
            || Schema::hasColumn('tbl_programacao_evento', 'id_palestrante')) {
            return;
        }

        Schema::table('tbl_programacao_evento', function (Blueprint $table) {
            // Ligação opcional; texto do responsável continua disponível para convidados externos.
            // Usa INTEGER como o id_usuario já existente no projeto.
            $table->integer('id_palestrante')->nullable()->after('palestrante_programacao');
            $table->index('id_palestrante', 'idx_programacao_palestrante');
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('tbl_programacao_evento')
            && Schema::hasColumn('tbl_programacao_evento', 'id_palestrante')) {
            Schema::table('tbl_programacao_evento', function (Blueprint $table) {
                $table->dropIndex('idx_programacao_palestrante');
                $table->dropColumn('id_palestrante');
            });
        }
    }
};
