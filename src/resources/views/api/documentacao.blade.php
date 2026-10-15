<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Documentação da API | Conexão 360°</title>

    <style>
        :root {
            --bg: #0a0b0e;
            --surface: #121419;
            --surface-2: #181b21;
            --border: #2b2f37;
            --gold: #d7b25e;
            --gold-soft: rgba(215, 178, 94, .12);
            --text: #f7f4ed;
            --text-soft: #c9c5bc;
            --muted: #8f949e;
            --green: #61d493;
            --blue: #78acf9;
            --orange: #efbb6b;
            --red: #ef7d7d;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background:
                radial-gradient(
                    circle at 85% 0%,
                    rgba(215, 178, 94, .08),
                    transparent 28%
                ),
                var(--bg);
            color: var(--text);
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        button,
        input {
            font: inherit;
        }

        code,
        pre {
            font-family:
                Consolas,
                "SFMono-Regular",
                Menlo,
                monospace;
        }

        .doc-container {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            padding: 32px 0 56px;
        }

        /* =====================================================
           CABEÇALHO
        ====================================================== */

        .doc-header {
            padding: 30px;
            border: 1px solid var(--border);
            border-radius: 20px;
            background: var(--surface);
        }

        .doc-header-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
        }

        .doc-eyebrow {
            display: inline-block;
            margin-bottom: 8px;
            color: var(--gold);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .09em;
            text-transform: uppercase;
        }

        .doc-header h1 {
            margin: 0;
            font-size: clamp(34px, 5vw, 58px);
            line-height: 1;
            letter-spacing: -.04em;
        }

        .doc-header p {
            max-width: 780px;
            margin: 14px 0 0;
            color: var(--text-soft);
            font-size: 15px;
            line-height: 1.65;
        }

        .doc-version {
            padding: 7px 10px;
            border: 1px solid rgba(215, 178, 94, .28);
            border-radius: 999px;
            background: var(--gold-soft);
            color: var(--gold);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .doc-identification {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-top: 24px;
        }

        .doc-info-card {
            padding: 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #0c0e11;
        }

        .doc-info-card span {
            display: block;
            margin-bottom: 5px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .doc-info-card strong,
        .doc-info-card code {
            color: var(--text);
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        /* =====================================================
           REQUISITOS
        ====================================================== */

        .doc-section {
            margin-top: 16px;
            padding: 22px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--surface);
        }

        .doc-section-title {
            margin-bottom: 16px;
        }

        .doc-section-title span {
            display: block;
            margin-bottom: 4px;
            color: var(--gold);
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .doc-section-title h2 {
            margin: 0;
            font-size: 23px;
        }

        .doc-section-title p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.55;
        }

        .doc-auth-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .doc-auth-card {
            padding: 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--surface-2);
        }

        .doc-auth-card h3 {
            margin: 0 0 6px;
            font-size: 13px;
        }

        .doc-auth-card p {
            margin: 0;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.55;
        }

        .doc-auth-code {
            margin-top: 9px;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: #080a0c;
            color: var(--gold);
            font-size: 11px;
            overflow-x: auto;
        }

        /* =====================================================
           RESUMO
        ====================================================== */

        .doc-summary {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            margin-top: 16px;
        }

        .doc-summary-card {
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--surface);
        }

        .doc-summary-card span {
            display: block;
            color: var(--muted);
            font-size: 10px;
            font-weight: 850;
            text-transform: uppercase;
        }

        .doc-summary-card strong {
            display: block;
            margin-top: 5px;
            font-size: 24px;
        }

        .doc-summary-card strong.is-text {
            color: var(--gold);
            font-size: 16px;
        }

        /* =====================================================
           BUSCA / FILTROS
        ====================================================== */

        .doc-toolbar {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 12px;
        }

        .doc-search {
            flex: 1;
        }

        .doc-search input {
            width: 100%;
            min-height: 42px;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 10px;
            outline: none;
            background: #0b0d10;
            color: var(--text);
        }

        .doc-filters {
            display: flex;
            gap: 6px;
            overflow-x: auto;
        }

        .doc-filter {
            padding: 8px 10px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: transparent;
            color: var(--muted);
            font-size: 10px;
            font-weight: 900;
            cursor: pointer;
            white-space: nowrap;
        }

        .doc-filter.active,
        .doc-filter:hover {
            border-color: rgba(215, 178, 94, .35);
            background: var(--gold-soft);
            color: var(--gold);
        }

        /* =====================================================
           TABELA
        ====================================================== */

        .doc-table-wrap {
            overflow-x: auto;
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .doc-table {
            width: 100%;
            min-width: 920px;
            border-collapse: collapse;
        }

        .doc-table th {
            padding: 11px 12px;
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
            color: var(--muted);
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .05em;
            text-align: left;
            text-transform: uppercase;
        }

        .doc-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            color: var(--text-soft);
            font-size: 11px;
            vertical-align: middle;
        }

        .doc-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .doc-table code {
            color: var(--text);
            font-size: 11px;
        }

        .method {
            display: inline-flex;
            justify-content: center;
            min-width: 58px;
            padding: 5px 7px;
            border-radius: 7px;
            font-size: 10px;
            font-weight: 900;
            font-family: monospace;
        }

        .method-get {
            color: var(--green);
            background: rgba(97, 212, 147, .12);
        }

        .method-post {
            color: var(--blue);
            background: rgba(120, 172, 249, .12);
        }

        .method-patch,
        .method-put {
            color: var(--orange);
            background: rgba(239, 187, 107, .12);
        }

        .method-delete {
            color: var(--red);
            background: rgba(239, 125, 125, .12);
        }

        .access {
            display: inline-flex;
            padding: 5px 8px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 850;
        }

        .access-public {
            color: var(--green);
            background: rgba(97, 212, 147, .1);
        }

        .access-protected {
            color: var(--gold);
            background: var(--gold-soft);
        }

        /* =====================================================
           DETALHES DAS ROTAS
        ====================================================== */

        .doc-route-group {
            margin-top: 18px;
        }

        .doc-route-group h3 {
            margin: 0 0 8px;
            font-size: 17px;
        }

        .doc-endpoint {
            overflow: hidden;
            margin-bottom: 8px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #0d0f13;
        }

        .doc-endpoint[open] {
            border-color: rgba(215, 178, 94, .28);
        }

        .doc-endpoint summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 13px;
            cursor: pointer;
            list-style: none;
        }

        .doc-endpoint summary::-webkit-details-marker {
            display: none;
        }

        .doc-endpoint-main {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .doc-endpoint-main code {
            color: var(--text);
            font-size: 12px;
            font-weight: 750;
            overflow-wrap: anywhere;
        }

        .doc-endpoint-body {
            padding: 0 14px 14px;
            border-top: 1px solid var(--border);
        }

        .doc-description {
            margin: 13px 0;
            color: var(--text-soft);
            font-size: 12px;
            line-height: 1.6;
        }

        .doc-params {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 9px;
        }

        .doc-param {
            display: grid;
            grid-template-columns: 1fr 90px 90px;
            gap: 8px;
            padding: 8px 9px;
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
        }

        .doc-param:last-child {
            border-bottom: 0;
        }

        .doc-param code,
        .doc-param span,
        .doc-param strong {
            font-size: 10px;
        }

        .doc-param code {
            color: var(--text);
        }

        .doc-param span,
        .doc-param strong {
            color: var(--muted);
        }

        .doc-detail-title {
            margin: 13px 0 7px;
            font-size: 12px;
        }

        .doc-code-box {
            position: relative;
            overflow: hidden;
            border: 1px solid #262a31;
            border-radius: 9px;
            background: #07090b;
        }

        .doc-code-box pre {
            margin: 0;
            padding: 38px 12px 12px;
            overflow-x: auto;
            color: #ece7dc;
            font-size: 10px;
            line-height: 1.6;
        }

        .doc-copy {
            position: absolute;
            top: 7px;
            right: 7px;
            padding: 5px 7px;
            border: 1px solid rgba(215, 178, 94, .28);
            border-radius: 7px;
            background: var(--gold-soft);
            color: var(--gold);
            font-size: 9px;
            font-weight: 850;
            cursor: pointer;
        }

        .doc-empty {
            padding: 10px;
            border: 1px dashed var(--border);
            border-radius: 9px;
            color: var(--muted);
            font-size: 10px;
        }

        .doc-hidden {
            display: none !important;
        }

        .doc-no-results {
            padding: 24px;
            text-align: center;
            color: var(--muted);
            font-size: 11px;
        }

        .doc-footer {
            margin-top: 18px;
            color: var(--muted);
            font-size: 10px;
            text-align: center;
        }

        @media (max-width: 900px) {
            .doc-identification,
            .doc-summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 760px) {
            .doc-auth-box {
                grid-template-columns: 1fr;
            }

            .doc-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .doc-header-top {
                flex-direction: column;
            }
        }

        @media (max-width: 540px) {
            .doc-container {
                width: min(100% - 20px, 1180px);
            }

            .doc-header,
            .doc-section {
                padding: 16px;
            }

            .doc-identification,
            .doc-summary {
                grid-template-columns: 1fr;
            }

            .doc-endpoint summary {
                align-items: flex-start;
            }

            .doc-endpoint-main {
                align-items: flex-start;
                flex-direction: column;
            }

            .doc-param {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

@php
    $sitePublico =
        'https://hardsettings.tipi5.smpsistema.com.br/conexao/';

    $baseApi =
        $sitePublico . 'api/v1';

    $urlDocumentacao =
        $sitePublico . 'api/documentacao';
@endphp

<div class="doc-container">

    {{-- =========================================================
         IDENTIFICAÇÃO DA API
    ========================================================== --}}
    <header class="doc-header">

        <div class="doc-header-top">

            <div>
                <span class="doc-eyebrow">
                    Documentação pública
                </span>

                <h1>
                    API Conexão 360°
                </h1>

                <p>
                    API responsável pela integração entre o aplicativo
                    React Native / Expo Conexão 360° e o back-end Laravel.
                    Esta página apresenta as rotas disponíveis, métodos HTTP,
                    nível de acesso e parâmetros necessários para consumo.
                </p>
            </div>

            <span class="doc-version">
                /api/v1
            </span>

        </div>


        <div class="doc-identification">

            <article class="doc-info-card">
                <span>
                    Nome da API
                </span>

                <strong>
                    API Conexão 360°
                </strong>
            </article>


            <article class="doc-info-card">
                <span>
                    URL pública do projeto
                </span>

                <code>
                    {{ $sitePublico }}
                </code>
            </article>


            <article class="doc-info-card">
                <span>
                    URL base da API
                </span>

                <code>
                    {{ $baseApi }}
                </code>
            </article>

        </div>

    </header>


    {{-- =========================================================
         AUTENTICAÇÃO
    ========================================================== --}}
    <section class="doc-section">

        <div class="doc-section-title">

            <span>
                Autenticação
            </span>

            <h2>
                Rotas públicas e autenticadas
            </h2>

            <p>
                A API utiliza Laravel Sanctum. Rotas protegidas exigem
                Bearer Token no cabeçalho Authorization.
            </p>

        </div>


        <div class="doc-auth-box">

            <article class="doc-auth-card">

                <h3>
                    Rota pública
                </h3>

                <p>
                    Pode ser acessada sem token. Exemplo:
                    <code>POST /api/v1/auth/login</code>.
                </p>

            </article>


            <article class="doc-auth-card">

                <h3>
                    Rota autenticada
                </h3>

                <p>
                    Exige um token Sanctum obtido após o login.
                </p>

                <div class="doc-auth-code">
                    Authorization: Bearer SEU_TOKEN
                </div>

            </article>

        </div>

    </section>


    {{-- =========================================================
         RESUMO
    ========================================================== --}}
    <section class="doc-summary">

        <article class="doc-summary-card">
            <span>
                Rotas encontradas
            </span>

            <strong>
                {{ $totalRotas }}
            </strong>
        </article>

        <article class="doc-summary-card">
            <span>
                Públicas
            </span>

            <strong>
                {{ $rotasPublicas }}
            </strong>
        </article>

        <article class="doc-summary-card">
            <span>
                Autenticadas
            </span>

            <strong>
                {{ $rotasProtegidas }}
            </strong>
        </article>

        <article class="doc-summary-card">
            <span>
                Versão
            </span>

            <strong class="is-text">
                API v1
            </strong>
        </article>

    </section>


    {{-- =========================================================
         ROTAS
    ========================================================== --}}
    <section class="doc-section">

        <div class="doc-section-title">

            <span>
                Recursos do back-end
            </span>

            <h2>
                Rotas disponíveis
            </h2>

            <p>
                A tabela abaixo apresenta o método HTTP, endpoint,
                tipo de acesso e finalidade de cada rota registrada
                atualmente no Laravel.
            </p>

        </div>


        <div class="doc-toolbar">

            <div class="doc-search">

                <input
                    type="search"
                    id="doc-search"
                    placeholder="Buscar rota, método ou recurso..."
                    autocomplete="off"
                >

            </div>


            <div class="doc-filters">

                @foreach (
                    [
                        'TODOS',
                        'GET',
                        'POST',
                        'PATCH',
                        'PUT',
                        'DELETE'
                    ]
                    as $filtro
                )

                    <button
                        type="button"
                        class="doc-filter {{ $filtro === 'TODOS' ? 'active' : '' }}"
                        data-filter="{{ $filtro }}"
                    >
                        {{ $filtro === 'TODOS' ? 'Todos' : $filtro }}
                    </button>

                @endforeach

            </div>

        </div>


        <div class="doc-table-wrap">

            <table class="doc-table">

                <thead>
                    <tr>
                        <th>Método</th>
                        <th>Rota</th>
                        <th>Acesso</th>
                        <th>Descrição</th>
                        <th>Parâmetros</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($rotas as $endpoint)

                        <tr
                            class="doc-filterable"
                            data-method="{{ $endpoint['metodo'] }}"
                            data-search="{{ strtolower(
                                $endpoint['metodo']
                                . ' '
                                . $endpoint['uri']
                                . ' '
                                . $endpoint['grupo']
                                . ' '
                                . $endpoint['descricao']
                            ) }}"
                        >

                            <td>
                                <span
                                    class="method method-{{ strtolower($endpoint['metodo']) }}"
                                >
                                    {{ $endpoint['metodo'] }}
                                </span>
                            </td>

                            <td>
                                <code>
                                    {{ $endpoint['uri'] }}
                                </code>
                            </td>

                            <td>
                                <span
                                    class="access {{ $endpoint['autenticado'] ? 'access-protected' : 'access-public' }}"
                                >
                                    {{ $endpoint['autenticado'] ? 'Autenticada' : 'Pública' }}
                                </span>
                            </td>

                            <td>
                                {{ $endpoint['descricao'] }}
                            </td>

                            <td>

                                @if (count($endpoint['parametros']))

                                    @foreach (
                                        $endpoint['parametros']
                                        as $parametro
                                    )

                                        <code>
                                            {{ $parametro['nome'] }}
                                        </code>

                                        @if (!$loop->last)
                                            ,
                                        @endif

                                    @endforeach

                                @elseif (!empty($endpoint['body']))

                                    @foreach (
                                        array_keys($endpoint['body'])
                                        as $campo
                                    )

                                        <code>
                                            {{ $campo }}
                                        </code>

                                        @if (!$loop->last)
                                            ,
                                        @endif

                                    @endforeach

                                @else

                                    <span style="color: var(--muted);">
                                        Nenhum
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        <div
            class="doc-no-results"
            id="doc-no-results"
            hidden
        >
            Nenhuma rota encontrada para o filtro informado.
        </div>

    </section>


    {{-- =========================================================
         PARÂMETROS POR ROTA
    ========================================================== --}}
    <section class="doc-section">

        <div class="doc-section-title">

            <span>
                Detalhamento
            </span>

            <h2>
                Parâmetros e exemplos
            </h2>

            <p>
                Clique em uma rota para visualizar seus parâmetros,
                dados enviados, autenticação e exemplo de resposta.
            </p>

        </div>


        @foreach ($grupos as $nomeGrupo => $itens)

            <div class="doc-route-group">

                <h3>
                    {{ $nomeGrupo }}
                </h3>


                @foreach ($itens as $endpoint)

                    @php
                        $endpointId =
                            'endpoint-'
                            . md5(
                                $endpoint['metodo']
                                . $endpoint['uri']
                            );
                    @endphp

                    <details
                        class="doc-endpoint doc-filterable"
                        data-method="{{ $endpoint['metodo'] }}"
                        data-search="{{ strtolower(
                            $endpoint['metodo']
                            . ' '
                            . $endpoint['uri']
                            . ' '
                            . $endpoint['grupo']
                            . ' '
                            . $endpoint['descricao']
                        ) }}"
                    >

                        <summary>

                            <div class="doc-endpoint-main">

                                <span
                                    class="method method-{{ strtolower($endpoint['metodo']) }}"
                                >
                                    {{ $endpoint['metodo'] }}
                                </span>

                                <code>
                                    {{ $endpoint['uri'] }}
                                </code>

                            </div>

                            <span
                                class="access {{ $endpoint['autenticado'] ? 'access-protected' : 'access-public' }}"
                            >
                                {{ $endpoint['autenticado'] ? 'Autenticada' : 'Pública' }}
                            </span>

                        </summary>


                        <div class="doc-endpoint-body">

                            <p class="doc-description">
                                <strong>Descrição:</strong>
                                {{ $endpoint['descricao'] }}
                            </p>


                            <h4 class="doc-detail-title">
                                Parâmetros da URL
                            </h4>

                            @if (count($endpoint['parametros']))

                                <div class="doc-params">

                                    @foreach (
                                        $endpoint['parametros']
                                        as $parametro
                                    )

                                        <div class="doc-param">

                                            <code>
                                                {{ $parametro['nome'] }}
                                            </code>

                                            <span>
                                                {{ $parametro['tipo'] }}
                                            </span>

                                            <strong>
                                                obrigatório
                                            </strong>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="doc-empty">
                                    Nenhum parâmetro na URL.
                                </div>

                            @endif


                            @if (!empty($endpoint['body']))

                                <h4 class="doc-detail-title">
                                    Parâmetros enviados no corpo
                                </h4>

                                <div class="doc-code-box">

                                    <button
                                        type="button"
                                        class="doc-copy"
                                        data-copy-target="{{ $endpointId }}-body"
                                    >
                                        Copiar
                                    </button>

                                    @if (
                                        $endpoint['content_type']
                                        ===
                                        'multipart/form-data'
                                    )

                                        <pre id="{{ $endpointId }}-body"><code>@foreach ($endpoint['body'] as $campo => $valor){{ $campo }}: {{ $valor }}
@endforeach</code></pre>

                                    @else

                                        <pre id="{{ $endpointId }}-body"><code>{{ json_encode(
                                            $endpoint['body'],
                                            JSON_PRETTY_PRINT
                                            | JSON_UNESCAPED_UNICODE
                                            | JSON_UNESCAPED_SLASHES
                                        ) }}</code></pre>

                                    @endif

                                </div>

                            @endif


                            <h4 class="doc-detail-title">
                                Cabeçalhos
                            </h4>

                            <div class="doc-code-box">

                                <button
                                    type="button"
                                    class="doc-copy"
                                    data-copy-target="{{ $endpointId }}-headers"
                                >
                                    Copiar
                                </button>

                                <pre id="{{ $endpointId }}-headers"><code>Accept: application/json{{ $endpoint['autenticado'] ? "\nAuthorization: Bearer SEU_TOKEN" : '' }}</code></pre>

                            </div>


                            <h4 class="doc-detail-title">
                                Exemplo de resposta
                            </h4>

                            <div class="doc-code-box">

                                <button
                                    type="button"
                                    class="doc-copy"
                                    data-copy-target="{{ $endpointId }}-response"
                                >
                                    Copiar
                                </button>

                                <pre id="{{ $endpointId }}-response"><code>{{ json_encode(
                                    $endpoint['response'],
                                    JSON_PRETTY_PRINT
                                    | JSON_UNESCAPED_UNICODE
                                    | JSON_UNESCAPED_SLASHES
                                ) }}</code></pre>

                            </div>

                        </div>

                    </details>

                @endforeach

            </div>

        @endforeach

    </section>


    <footer class="doc-footer">
        API Conexão 360° · {{ $urlDocumentacao }}
    </footer>

</div>


<script>
document.addEventListener(
    "DOMContentLoaded",
    function () {

        var input =
            document.getElementById(
                "doc-search"
            );

        var botoes =
            Array.prototype.slice.call(
                document.querySelectorAll(
                    "[data-filter]"
                )
            );

        var itens =
            Array.prototype.slice.call(
                document.querySelectorAll(
                    ".doc-filterable"
                )
            );

        var noResults =
            document.getElementById(
                "doc-no-results"
            );

        var metodoAtual =
            "TODOS";


        function normalizar(
            valor
        ) {
            return String(
                valor || ""
            )
                .normalize("NFD")
                .replace(
                    /[\u0300-\u036f]/g,
                    ""
                )
                .toLowerCase();
        }


        function filtrar() {

            var termo =
                normalizar(
                    input
                        ? input.value
                        : ""
                );

            var visiveis =
                0;


            itens.forEach(
                function (item) {

                    var metodo =
                        item.getAttribute(
                            "data-method"
                        ) || "";

                    var texto =
                        normalizar(
                            item.getAttribute(
                                "data-search"
                            ) || ""
                        );

                    var metodoOk =
                        metodoAtual === "TODOS"
                        || metodo === metodoAtual;

                    var termoOk =
                        !termo
                        || texto.indexOf(
                            termo
                        ) !== -1;


                    if (
                        metodoOk
                        && termoOk
                    ) {

                        item.classList.remove(
                            "doc-hidden"
                        );

                        if (
                            item.tagName === "TR"
                        ) {
                            visiveis++;
                        }

                    } else {

                        item.classList.add(
                            "doc-hidden"
                        );

                    }

                }
            );


            if (noResults) {
                noResults.hidden =
                    visiveis > 0;
            }
        }


        if (input) {
            input.addEventListener(
                "input",
                filtrar
            );
        }


        botoes.forEach(
            function (botao) {

                botao.addEventListener(
                    "click",
                    function () {

                        metodoAtual =
                            botao.getAttribute(
                                "data-filter"
                            ) || "TODOS";


                        botoes.forEach(
                            function (item) {

                                item.classList.remove(
                                    "active"
                                );

                            }
                        );


                        botao.classList.add(
                            "active"
                        );


                        filtrar();

                    }
                );

            }
        );


        var botoesCopiar =
            document.querySelectorAll(
                "[data-copy-target]"
            );


        Array.prototype.forEach.call(
            botoesCopiar,
            function (botao) {

                botao.addEventListener(
                    "click",
                    function () {

                        var id =
                            botao.getAttribute(
                                "data-copy-target"
                            );

                        var alvo =
                            document.getElementById(
                                id
                            );


                        if (!alvo) {
                            return;
                        }


                        var texto =
                            (
                                alvo.innerText
                                || alvo.textContent
                                || ""
                            ).trim();


                        if (
                            navigator.clipboard
                            && navigator.clipboard.writeText
                        ) {

                            navigator.clipboard
                                .writeText(
                                    texto
                                )
                                .then(
                                    function () {
                                        mostrarCopiado(
                                            botao
                                        );
                                    }
                                );

                        }

                    }
                );

            }
        );


        function mostrarCopiado(
            botao
        ) {

            var original =
                botao.textContent;

            botao.textContent =
                "Copiado";

            setTimeout(
                function () {
                    botao.textContent =
                        original;
                },
                1200
            );
        }


        filtrar();

    }
);
</script>

</body>
</html>
