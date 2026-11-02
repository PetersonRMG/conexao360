<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_codigos_verificacao', function (Blueprint $table) {
            $table->string('canal', 12)->default('email');
            $table->string('telefone', 16)->nullable();
        });

        Schema::table('tbl_usuarios', function (Blueprint $table) {
            $table->string('telefone_usuario', 16)->nullable()->unique('uq_usuarios_telefone');
            $table->timestamp('telefone_verificado_em')->nullable();
            $table->timestamp('email_verificado_em')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tbl_usuarios', function (Blueprint $table) {
            $table->dropUnique('uq_usuarios_telefone');
            $table->dropColumn(['telefone_usuario', 'telefone_verificado_em', 'email_verificado_em']);
        });
        Schema::table('tbl_codigos_verificacao', function (Blueprint $table) {
            $table->dropColumn(['canal', 'telefone']);
        });
    }
};
