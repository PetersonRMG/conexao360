@extends('layout.admin')

@section('pg-titulo', 'Conteúdos')
@section('link-topo', 'Conteúdos')

@section('content')

<div class="site-editor-main content-manager-page">
    <div class="site-editor-page">
        <div class="site-editor">

            <div class="site-editor-tabs-header mb-4">
                <div class="site-editor-tabs-title">
                    <i class="bi bi-collection-play-fill"></i>

                    <div>
                        <strong>Conteúdos da rede</strong>
                        <span>
                            Gerencie os vídeos das palestras e as enquetes exibidas aos membros do Conexão 360°.
                        </span>
                    </div>
                </div>
            </div>

            <div class="content-manager-summary-grid">
                <article class="content-manager-summary-card">
                    <div class="content-manager-summary-icon content-manager-summary-icon--video">
                        <i class="bi bi-play-btn-fill"></i>
                    </div>

                    <div class="content-manager-summary-copy">
                        <span>Vídeos cadastrados</span>
                        <strong>{{ $totalVideos }}</strong>
                        <small>{{ $videosAtivos }} ativos no momento</small>
                    </div>
                </article>

                <article class="content-manager-summary-card">
                    <div class="content-manager-summary-icon content-manager-summary-icon--poll">
                        <i class="bi bi-bar-chart-fill"></i>
                    </div>

                    <div class="content-manager-summary-copy">
                        <span>Enquetes cadastradas</span>
                        <strong>{{ $totalEnquetes }}</strong>
                        <small>Respostas: Sim, Não e Outro</small>
                    </div>
                </article>
            </div>

            <section class="content-manager-options">
                <a href="{{ route('admin.conteudos.videos') }}" class="content-manager-option-card">
                    <div class="content-manager-option-head">
                        <span class="content-manager-option-icon">
                            <i class="bi bi-camera-reels-fill"></i>
                        </span>

                        <span class="content-manager-option-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>

                    <div>
                        <h3>Vídeos das palestras</h3>
                        <p>
                            Cadastre links de vídeos publicados no Instagram, YouTube, Vimeo ou outra plataforma externa.
                        </p>
                    </div>

                    <span class="content-manager-option-action">
                        Gerenciar vídeos
                    </span>
                </a>

                <a href="{{ route('admin.enquetes.index') }}" class="content-manager-option-card">
                    <div class="content-manager-option-head">
                        <span class="content-manager-option-icon content-manager-option-icon--poll">
                            <i class="bi bi-ui-checks-grid"></i>
                        </span>

                        <span class="content-manager-option-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>

                    <div>
                        <h3>Enquetes</h3>
                        <p>
                            Crie perguntas rápidas para os membros e acompanhe os votos em Sim, Não e Outro.
                        </p>
                    </div>

                    <span class="content-manager-option-action">
                        Gerenciar enquetes
                    </span>
                </a>
            </section>

        </div>
    </div>
</div>

@endsection
