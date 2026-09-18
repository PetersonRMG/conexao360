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
        Schema::create('tbl_feeds', function (Blueprint $table) {
            $table->integer('id_feeds', true);
            $table->integer('id_usuario');
            $table->integer('id_evento');
            $table->integer('curtidas_feed')->nullable();
            $table->string('foto_feed')->nullable();
            $table->string('comentario_feed', 100)->nullable();
            $table->string('status_feed', 10)->nullable();
            $table->dateTime('criado_em_feed')->useCurrent();
            $table->dateTime('atualizado_em_feed')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_feeds');
    }
};
