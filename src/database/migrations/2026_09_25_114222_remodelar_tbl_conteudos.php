<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_conteudos', function (Blueprint $table) {

            $table->string('nivel_acesso_conteudo', 20)
                ->default('PUBLICO')
                ->after('tipo_conteudo');

            $table->string('url_conteudo', 255)
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('tbl_conteudos', function (Blueprint $table) {

            $table->dropColumn('nivel_acesso_conteudo');

            $table->string('url_conteudo', 255)
                ->nullable(false)
                ->change();
        });
    }
};