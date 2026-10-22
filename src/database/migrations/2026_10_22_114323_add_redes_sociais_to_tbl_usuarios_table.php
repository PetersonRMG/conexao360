<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $campos = [
            'instagram_usuario',
            'linkedin_usuario',
            'youtube_usuario',
            'tiktok_usuario',
            'facebook_usuario',
            'site_usuario',
        ];

        // Adiciona somente as colunas que ainda não existem.
        $faltantes = array_filter(
            $campos,
            fn ($campo) => !Schema::hasColumn('tbl_usuarios', $campo)
        );

        if (empty($faltantes)) {
            return;
        }

        Schema::table('tbl_usuarios', function (Blueprint $table) use ($faltantes) {
            foreach ($faltantes as $campo) {
                $table->string($campo, 255)->nullable();
            }
        });
    }

    public function down(): void
    {
        // Não remover colunas automaticamente para evitar
        // perda de dados dos perfis existentes.
    }
};