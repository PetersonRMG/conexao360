<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_ingressos', function (Blueprint $table) {
            $table->integer('id_ingresso', true);
            $table->integer('id_usuario');
            $table->integer('id_evento');
            $table->string('codigo_acesso_ingresso');
            $table->string('status_ingresso', 10);
            $table->dateTime('pagamento_compra_ingresso');
            $table->dateTime('compra_em_ingresso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_ingressos');
    }
};
