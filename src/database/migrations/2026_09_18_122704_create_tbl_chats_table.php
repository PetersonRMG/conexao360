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
        Schema::create('tbl_chats', function (Blueprint $table) {
            $table->integer('id_chat', true);
            $table->integer('id_usuario');
            $table->text('mensagem_chat');
            $table->string('status_entregue_chat', 10);
            $table->string('status_remetente_chat', 10);
            $table->dateTime('data_envio_chat');
            $table->dateTime('data_receb_chat');
            $table->dateTime('criado_em_chat')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_chats');
    }
};
