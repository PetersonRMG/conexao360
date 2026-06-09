<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conexao360; // Certifique-se que este é o nome correto do seu Model
use Illuminate\Support\Facades\Storage;

class ConexaoController extends Controller
{
    public function update(Request $request)
    {
        // 1. Busca o primeiro registro da seção (ou cria um novo se não existir)
        $conexao = Conexao360::first() ?? new Conexao360();

        // 2. Validação básica
        $request->validate([
            'titulo_edicao' => 'required|string|max:255',
            'slogan'        => 'required|string|max:255',
            'logo_conexao'  => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // 3. Processamento da imagem (se o usuário enviou uma nova)
        if ($request->hasFile('logo_conexao')) {
            // Remove a imagem antiga se existir
            if ($conexao->logo_conexao) {
                Storage::disk('public')->delete($conexao->logo_conexao);
            }
            // Salva a nova imagem
            $path = $request->file('logo_conexao')->store('logos', 'public');
            $conexao->logo_conexao = $path;
        }

        // 4. Atualiza os textos
        $conexao->titulo_edicao = $request->titulo_edicao;
        $conexao->slogan = $request->slogan;

        // 5. Salva no banco
        $conexao->save();

        // 6. Retorna com mensagem de sucesso
        return redirect()->back()->with('success', 'Seção Conexão 360 atualizada com sucesso!');
    }
}