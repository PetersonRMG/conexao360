<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Topico;
use App\Models\VotoTopico;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TopicoController extends Controller
{
    private const ICONES = [
        'chatbubbles', 'book', 'mic', 'briefcase',
        'bulb', 'calendar', 'school', 'color-palette',
    ];

    public function index(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:20'],
        ]);
        $usuarioId = (int) $request->user()->id_usuario;

        $topicos = Topico::query()
            ->where('status_topico', 'ATIVO')
            ->with(['usuario:id_usuario,nome_usuario,foto_usuario,perfil_usuario',
                'opcoes' => fn ($q) => $q->withCount('votos'),
            ])
            ->withCount('votos')
            ->orderByDesc('criado_em_topico')
            ->paginate((int) ($dados['per_page'] ?? 20));

        $ids = $topicos->getCollection()->pluck('id_topico')->all();
        $meusVotos = VotoTopico::query()
            ->where('id_usuario', $usuarioId)
            ->whereIn('id_topico', $ids)
            ->pluck('id_opcao_topico', 'id_topico');

        $itens = $topicos->getCollection()->map(function (Topico $topico) use ($meusVotos) {
            $topico->setAttribute('meu_voto_id', $meusVotos[$topico->id_topico] ?? null);
            return $topico;
        });

        return response()->json([
            'success' => true,
            'data' => $itens,
            'meta' => [
                'current_page' => $topicos->currentPage(),
                'last_page' => $topicos->lastPage(),
                'per_page' => $topicos->perPage(),
                'total' => $topicos->total(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if (!in_array(strtolower((string) $request->user()->perfil_usuario), ['administrador', 'palestrante'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Somente palestrantes e administradores podem criar tópicos.',
            ], 403);
        }

        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:55'],
            'descricao' => ['required', 'string', 'max:150'],
            'icone' => ['required', 'string', Rule::in(self::ICONES)],
            'opcoes' => ['required', 'array', 'min:2', 'max:8'],
            'opcoes.*' => ['required', 'string', 'max:40'],
        ]);

        $titulo = trim($dados['titulo']);
        $descricao = trim($dados['descricao']);
        $opcoes = array_map(fn ($texto) => trim($texto), $dados['opcoes']);
        if ($titulo === '' || $descricao === '' || in_array('', $opcoes, true)) {
            throw ValidationException::withMessages(['titulo' => 'Preencha o título, a descrição e todas as opções.']);
        }
        if (count(array_unique(array_map('mb_strtolower', $opcoes))) !== count($opcoes)) {
            throw ValidationException::withMessages(['opcoes' => 'As opções de votação não podem ser repetidas.']);
        }

        $topico = DB::transaction(function () use ($dados, $titulo, $descricao, $opcoes, $request) {
            $topico = Topico::create([
                'id_usuario' => (int) $request->user()->id_usuario,
                'titulo_topico' => $titulo,
                'descricao_topico' => $descricao,
                'icone_topico' => $dados['icone'],
                'status_topico' => 'ATIVO',
            ]);
            foreach ($opcoes as $indice => $texto) {
                $topico->opcoes()->create([
                    'texto_opcao' => $texto,
                    'ordem_opcao' => $indice + 1,
                ]);
            }
            return $topico;
        });

        $topico->load(['usuario:id_usuario,nome_usuario,foto_usuario,perfil_usuario', 'opcoes']);
        $topico->setAttribute('votos_count', 0);
        $topico->setAttribute('meu_voto_id', null);

        return response()->json([
            'success' => true,
            'message' => 'Tópico publicado com sucesso.',
            'data' => $topico,
        ], 201);
    }

    public function votar(Request $request, int $id): JsonResponse
    {
        $dados = $request->validate([
            'id_opcao' => ['required', 'integer'],
        ]);

        $topico = Topico::query()->where('status_topico', 'ATIVO')->findOrFail($id);
        $opcaoPertenceAoTopico = $topico->opcoes()
            ->where('id_opcao_topico', $dados['id_opcao'])->exists();
        if (!$opcaoPertenceAoTopico) {
            return response()->json(['success' => false, 'message' => 'Opção inválida para este tópico.'], 422);
        }

        $usuarioId = (int) $request->user()->id_usuario;
        if (VotoTopico::where('id_topico', $id)->where('id_usuario', $usuarioId)->exists()) {
            return response()->json(['success' => false, 'message' => 'Você já votou neste tópico.'], 409);
        }

        try {
            VotoTopico::create([
                'id_topico' => $id,
                'id_opcao_topico' => $dados['id_opcao'],
                'id_usuario' => $usuarioId,
            ]);
        } catch (QueryException $e) {
            // A constraint única impede o voto duplo em requisições simultâneas.
            if (in_array((string) $e->getCode(), ['23000', '23505'], true)) {
                return response()->json(['success' => false, 'message' => 'Você já votou neste tópico.'], 409);
            }
            throw $e;
        }

        return response()->json(['success' => true, 'message' => 'Voto registrado com sucesso.']);
    }
}
