<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Migration ADITIVA: não modifica tbl_eventos, tbl_conteudos ou publicações.
        Schema::create('tbl_albuns_evento', function (Blueprint $table) {
            $table->increments('id_album');
            // tbl_eventos.id_evento foi criado como INTEGER assinado.
            $table->integer('id_evento');
            $table->string('titulo_album', 150);
            $table->text('descricao_album')->nullable();
            $table->string('status_album', 10)->default('ATIVO');
            $table->timestamps();

            $table->index(['id_evento', 'status_album']);
            $table->foreign('id_evento')
                ->references('id_evento')->on('tbl_eventos')
                ->restrictOnDelete();
        });

        Schema::create('tbl_fotos_evento', function (Blueprint $table) {
            $table->increments('id_foto');
            $table->unsignedInteger('id_album');
            $table->string('titulo_foto', 150);
            $table->text('descricao_foto')->nullable();
            $table->string('arquivo_foto', 255);
            $table->string('status_foto', 10)->default('ATIVO');
            $table->timestamps();

            $table->index(['id_album', 'status_foto']);
            $table->foreign('id_album')
                ->references('id_album')->on('tbl_albuns_evento')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_fotos_evento');
        Schema::dropIfExists('tbl_albuns_evento');
    }
};
