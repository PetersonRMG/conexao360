<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_enquetes', function (Blueprint $table) {
            // Nullable: preserve enquetes existentes sem associar à edição errada.
            $table->integer('id_evento')->nullable()->after('id_usuario');
            $table->index('id_evento', 'idx_enquetes_evento');
            $table->foreign('id_evento', 'fk_enquetes_evento')
                ->references('id_evento')->on('tbl_eventos')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tbl_enquetes', function (Blueprint $table) {
            $table->dropForeign('fk_enquetes_evento');
            $table->dropIndex('idx_enquetes_evento');
            $table->dropColumn('id_evento');
        });
    }
};
