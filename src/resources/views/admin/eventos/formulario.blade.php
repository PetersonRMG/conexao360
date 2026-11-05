@extends('layout.admin')

@php($editando = $eventoEditando !== null)
@section('title', $editando ? 'Editar Evento' : 'Novo Evento')
@section('pg-titulo', $editando ? 'Editar Evento' : 'Novo Evento')
@section('link-topo', 'Eventos / Cadastro')

@section('content')
@include('admin.eventos._estilos')
<main class="app-main eventos-admin">
    <div class="ev-shell">
        <header class="ev-top">
            <div>
                <a href="{{ route('admin.eventos.index') }}" class="ev-eyebrow text-decoration-none"><i class="bi bi-arrow-left me-2"></i>Voltar para Eventos</a>
                <h2>{{ $editando ? 'Editar evento' : 'Cadastrar evento' }}</h2>
                <p class="ev-description">{{ $editando ? 'Atualize os dados principais desta edição. Os conteúdos vinculados não serão apagados.' : 'Informe os dados desta edição. Após salvar, você poderá adicionar galeria, vídeos, enquetes e programação.' }}</p>
            </div>
            @if($editando)
                <a class="ev-btn ev-btn--outline" href="{{ route('admin.eventos.conteudo', ['idEvento' => $eventoEditando->id_evento]) }}"><i class="bi bi-collection"></i> Gerenciar conteúdo</a>
            @endif
        </header>

        @if(session('success'))<div class="ev-flash" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>@endif
        @if($errors->any())
            <div class="ev-errors" role="alert"><strong>Verifique os dados do evento:</strong><ul class="mt-2">@foreach($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach</ul></div>
        @endif

        <form class="ev-form-panel" enctype="multipart/form-data" method="POST"
              action="{{ $editando ? route('admin.evento.update', $eventoEditando->id_evento) : route('admin.evento.create') }}">
            @csrf
            @method('PUT')
            <div class="ev-form-grid">
                <h3 class="ev-form-heading ev-col-12">Informações principais</h3>
                <div class="ev-col-8">
                    <label for="ev-titulo">Título do evento *</label>
                    <input id="ev-titulo" type="text" name="titulo_evento" maxlength="200" required value="{{ old('titulo_evento', $eventoEditando?->titulo_evento) }}" placeholder="Ex.: Advocacia Exponencial 360°">
                </div>
                <div class="ev-col-4">
                    <label for="ev-edicao">Edição (número) *</label>
                    <input id="ev-edicao" type="number" min="1" name="edicao_evento" required value="{{ old('edicao_evento', $eventoEditando?->edicao_evento) }}" placeholder="Ex.: 3">
                </div>
                <div class="ev-col-12">
                    <label for="ev-descricao">Descrição *</label>
                    <textarea id="ev-descricao" name="descricao_evento" required placeholder="Descreva a proposta do evento">{{ old('descricao_evento', $eventoEditando?->descricao_evento) }}</textarea>
                </div>
                <h3 class="ev-form-heading ev-col-12 mt-2">Imagem do evento</h3>
                <div class="ev-col-6">
                    <label for="ev-banner">Banner do evento {{ $editando ? '(enviar outra imagem para substituir)' : '*' }}</label>
                    <img id="ev-banner-preview" class="ev-preview" alt="Prévia do banner do evento"
                         @if($editando && $eventoEditando->banner_evento)
                             src="{{ asset('conexao360/img/' . $eventoEditando->banner_evento) }}"
                         @else
                             hidden
                         @endif>
                    <input id="ev-banner" type="file" name="banner_evento" accept="image/png,image/jpeg,image/webp" @required(!$editando)>
                    <div class="ev-help" id="ev-banner-help">JPG, PNG ou WebP · até 2 MB. {{ $editando ? 'Sem selecionar outro arquivo, o banner atual permanece.' : 'Selecione a imagem que aparecerá no site e no aplicativo.' }}</div>
                    @error('banner_evento')<div class="ev-errors mt-2" role="alert">{{ $message }}</div>@enderror
                </div>
                <div class="ev-col-6">
                    <label for="ev-status">Status *</label>
                    <select id="ev-status" name="status_evento" required>
                        <option value="ATIVO" @selected(old('status_evento', $eventoEditando?->status_evento ?? 'INATIVO') === 'ATIVO')>Ativo</option>
                        <option value="INATIVO" @selected(old('status_evento', $eventoEditando?->status_evento ?? 'INATIVO') === 'INATIVO')>Inativo</option>
                    </select>
                    <div class="ev-help">Somente uma edição pode permanecer ativa por vez. Ativar esta edição desativa as demais.</div>
                </div>
                <h3 class="ev-form-heading ev-col-12 mt-2">Datas e horários</h3>
                <div class="ev-col-6">
                    <label for="ev-inicio">Data de início *</label>
                    <input id="ev-inicio" type="date" name="data_inicial_evento" required value="{{ old('data_inicial_evento', $eventoEditando?->data_inicial_evento ? substr((string) $eventoEditando->data_inicial_evento, 0, 10) : '') }}">
                </div>
                <div class="ev-col-6">
                    <label for="ev-hora-inicio">Hora de início *</label>
                    <input id="ev-hora-inicio" type="time" name="hora_inicial_evento" required value="{{ old('hora_inicial_evento', $eventoEditando?->hora_inicial_evento ? substr((string) $eventoEditando->hora_inicial_evento, 0, 5) : '') }}">
                </div>
                <div class="ev-col-6">
                    <label for="ev-termino">Data de término *</label>
                    <input id="ev-termino" type="date" name="data_termino_evento" required value="{{ old('data_termino_evento', $eventoEditando?->data_termino_evento ? substr((string) $eventoEditando->data_termino_evento, 0, 10) : '') }}">
                </div>
                <div class="ev-col-6">
                    <label for="ev-hora-fim">Hora de término *</label>
                    <input id="ev-hora-fim" type="time" name="hora_termino_evento" required value="{{ old('hora_termino_evento', $eventoEditando?->hora_termino_evento ? substr((string) $eventoEditando->hora_termino_evento, 0, 5) : '') }}">
                </div>
                <h3 class="ev-form-heading ev-col-12 mt-2">Local e acesso</h3>
                <div class="ev-col-12">
                    <label for="ev-endereco">Local ou endereço *</label>
                    <input id="ev-endereco" type="text" maxlength="80" name="endereco_evento" required value="{{ old('endereco_evento', $eventoEditando?->endereco_evento) }}">
                </div>
                <div class="ev-col-12">
                    <label for="ev-mapa">Mapa do local do evento — iframe (opcional)</label>
                    <textarea id="ev-mapa" name="url_evento" maxlength="2000" rows="3"
                        placeholder='Cole aqui o código &lt;iframe ...&gt;&lt;/iframe&gt; do Google Maps, ou a URL de incorporação'>{{ old('url_evento', $eventoEditando?->url_evento) }}</textarea>
                    <div class="ev-help">No Google Maps, use <strong>Compartilhar → Incorporar um mapa → Copiar HTML</strong>. O sistema salva só o endereço do iframe, e o site usa esse campo para mostrar o mapa. O banner é independente.</div>
                    @error('url_evento')<div class="ev-errors mt-2" role="alert">{{ $message }}</div>@enderror
                    @if($editando && $eventoEditando->url_evento && str_starts_with($eventoEditando->url_evento, 'https://'))
                        <div class="mt-3" style="max-width:620px;">
                            <div class="ev-help mb-2">Mapa cadastrado atualmente:</div>
                            <iframe title="Mapa atual do evento" src="{{ $eventoEditando->url_evento }}" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" style="width:100%;height:260px;border:1px solid var(--ev-border);border-radius:10px;" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
                <div class="ev-col-12 d-flex justify-content-between gap-3 align-items-center flex-wrap mt-3">
                    <a href="{{ route('admin.eventos.index') }}" class="ev-btn ev-btn--neutral">Cancelar</a>
                    <button class="ev-btn" type="submit"><i class="bi bi-check2-circle"></i>{{ $editando ? 'Salvar alterações' : 'Criar evento' }}</button>
                </div>
            </div>
        </form>
    </div>
</main>
<script>
    (() => {
        const input = document.getElementById('ev-banner');
        const preview = document.getElementById('ev-banner-preview');
        let enderecoTemporario = null;
        if (!input || !preview) return;

        input.addEventListener('change', () => {
            if (enderecoTemporario) URL.revokeObjectURL(enderecoTemporario);
            const arquivo = input.files?.[0];
            if (!arquivo) return;
            if (!arquivo.type.startsWith('image/')) return;
            enderecoTemporario = URL.createObjectURL(arquivo);
            preview.src = enderecoTemporario;
            preview.hidden = false;
        });
    })();
</script>
@endsection
