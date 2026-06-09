<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evento; // Certifique-se de que este é o nome do seu Model

class EventoController extends Controller
{
    public function update(Request $request)
    {
        // 1. Validação dos campos
        $request->validate([
            'data_evento'  => 'required|string|max:255',
            'local_evento' => 'required|string|max:255',
            'link_maps'    => 'nullable|string',
        ]);

        // 2. Busca o primeiro registro de evento ou cria um se não existir
        $evento = Evento::first() ?? new Evento();

        // 3. Atualiza os dados com o que veio do formulário
        $evento->data_evento  = $request->data_evento;
        $evento->local_evento = $request->local_evento;
        $evento->link_maps    = $request->link_maps;

        // 4. Salva no banco de dados
        $evento->save();

        // 5. Retorna com mensagem de sucesso
        return redirect()->back()->with('success', 'Informações do evento atualizadas com sucesso!');
    }
}