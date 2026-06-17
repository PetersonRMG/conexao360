<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User; // Certifique-se de que o Model User existe no seu projeto

class ChatController extends Controller
{
    /**
     * Exibe a tela do Chat principal
     */
    public function index()
    {
        // Simulação: Puxa todos os usuários do sistema para listar na barra esquerda (exceto o Admin logado)
        // Se no seu projeto você tiver um model específico para a Dra, pode utilizá-lo aqui.
        $contatos = User::where('id', '!=', auth()->id())->get();

        return view('admin.dash.chat', compact('contatos'));
    }

    /**
     * Carrega o histórico de mensagens de uma conversa específica (Chamada AJAX)
     */
    public function getMessages($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    /**
     * Envia e salva uma nova mensagem no banco (Chamada AJAX do botão "Enviar")
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|integer',
            'message'         => 'required|string',
        ]);

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id'       => auth()->id() ?? 1, // Fallback para ID 1 caso não use auth nativo ainda
            'message'         => $request->message,
            'is_read'         => false
        ]);

        return response()->json(['success' => true, 'data' => $message]);
    }
}