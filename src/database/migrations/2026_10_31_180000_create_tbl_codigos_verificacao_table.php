<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_codigos_verificacao', function (Blueprint $table) {
            $table->id();
            $table->string('email', 80);
            $table->string('finalidade', 32);
            $table->string('codigo_hash');
            $table->unsignedTinyInteger('tentativas')->default(0);
            $table->timestamp('expira_em');
            $table->timestamps();

            $table->unique(['email', 'finalidade'], 'uq_codigo_email_finalidade');
            $table->index('expira_em');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_codigos_verificacao');
    }
};
