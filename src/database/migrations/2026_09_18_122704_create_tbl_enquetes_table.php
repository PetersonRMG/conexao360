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
        Schema::create('tbl_enquetes', function (Blueprint $table) {
            $table->integer('id_enquete', true);
            $table->string('pergunta_enquete', 80);
            $table->tinyInteger('resposta_um_enquete')->nullable();
            $table->tinyInteger('resposta_dois_enquete')->nullable();
            $table->tinyInteger('resposta_tres_enquete')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_enquetes');
    }
};
