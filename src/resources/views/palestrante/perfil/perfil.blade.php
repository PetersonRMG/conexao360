@extends('layout.palestrante')

@section('title', 'Meu Perfil')
@section('pg-titulo', 'Meu Perfil')
@section('link-topo', 'Meu Perfil')

@section('content')

    @php
        $nomePerfil = trim($perfil->nome_usuario ?? 'Palestrante');

        $partesNome = preg_split('/\s+/', $nomePerfil);

        $inicial1 = mb_substr($partesNome[0] ?? '', 0, 1);

        $inicial2 = isset($partesNome[1])
            ? mb_substr($partesNome[1], 0, 1)
            : mb_substr($partesNome[0] ?? '', 1, 1);

        $iniciaisPerfil = strtoupper($inicial1 . $inicial2);

        $fotoPerfilPath = !empty($perfil->foto_usuario)
            ? 'dash/assets/img/' . $perfil->foto_usuario
            : null;

        $fotoPerfilExiste = $fotoPerfilPath
            && file_exists(public_path($fotoPerfilPath));

        $statusPerfil = strtoupper(
            trim($perfil->status_usuario ?? '')
        );
    @endphp


    <main class="app-main admin-standard-main speaker-admin-main">

        <div class="app-content container-fluid admin-standard-content">

            <div class="admin-standard-page speaker-profile-page">

                <section class="admin-standard-panel speaker-profile-panel">

                    <header class="admin-standard-panel-header">

                        <div class="admin-standard-heading">

                            <span class="admin-standard-heading-icon">
                                <i class="bi bi-person-vcard"></i>
                            </span>

                            <div class="admin-standard-heading-copy">

                                <h2 class="admin-standard-title">
                                    Meu Perfil Público
                                </h2>

                                <p class="admin-standard-description">
                                    As informações abaixo alimentam sua apresentação
                                    no site do Conexão 360º e poderão ser reutilizadas
                                    pelo aplicativo.
                                </p>

                            </div>

                        </div>

                    </header>


                    <div class="speaker-profile-body">

                        <form action="{{ route('admin.palestrante.perfil.update') }}" method="POST"
                            enctype="multipart/form-data" class="speaker-profile-layout">
                            @csrf
                            @method('PUT')


                            {{-- IDENTIDADE / FOTO --}}
                            <aside class="speaker-profile-identity">

                                <div class="speaker-profile-avatar-wrap">

                                    @if ($fotoPerfilExiste)

                                        <img src="{{ asset($fotoPerfilPath) }}" alt="{{ $nomePerfil }}"
                                            class="speaker-profile-avatar" id="profileAvatarPreview">

                                    @else

                                        <div class="speaker-profile-avatar-fallback" id="profileAvatarFallback"
                                            aria-label="{{ $nomePerfil }}">
                                            {{ $iniciaisPerfil }}
                                        </div>

                                        <img src="" alt="{{ $nomePerfil }}" class="speaker-profile-avatar d-none"
                                            id="profileAvatarPreview">

                                    @endif

                                </div>


                                <div class="speaker-profile-identity-copy">

                                    <strong>
                                        {{ $nomePerfil }}
                                    </strong>

                                    <span>
                                        {{ $perfil->email_usuario }}
                                    </span>

                                </div>


                                <div class="speaker-profile-meta">

                                    <div>
                                        <span>Perfil</span>
                                        <strong>
                                            {{ $perfil->perfil_usuario ?? 'Palestrante' }}
                                        </strong>
                                    </div>

                                    <div>
                                        <span>Status</span>

                                        <strong
                                            class="speaker-account-status {{ $statusPerfil === 'ATIVO' ? 'is-active' : '' }}">
                                            {{ $perfil->status_usuario ?? 'Não informado' }}
                                        </strong>
                                    </div>

                                </div>


                                <div class="speaker-profile-photo-field">

                                    <label class="form-label" for="foto_usuario">
                                        Alterar Foto
                                    </label>

                                    <input type="file" class="form-control" name="foto_usuario" id="foto_usuario"
                                        accept="image/png,image/jpeg,image/webp">

                                    <small>
                                        JPG, PNG ou WEBP. Máximo de 4 MB.
                                    </small>

                                </div>

                            </aside>


                            {{-- FORMULÁRIO --}}
                            <section class="speaker-profile-form">

                                @if (session('success'))

                                    <div class="alert speaker-profile-alert speaker-profile-alert--success" role="alert">
                                        <i class="bi bi-check-circle"></i>
                                        {{ session('success') }}
                                    </div>

                                @endif


                                @if ($errors->any())

                                    <div class="alert alert-danger speaker-profile-alert" role="alert">
                                        <strong>ATENÇÃO:</strong>
                                        verifique os campos do formulário.

                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $erro)
                                                <li>{{ $erro }}</li>
                                            @endforeach
                                        </ul>
                                    </div>

                                @endif


                                <div class="speaker-profile-form-heading">

                                    <div>
                                        <strong>
                                            Informações pessoais
                                        </strong>

                                        <span>
                                            Nome, foto, área de atuação e apresentação
                                            são utilizados nas páginas públicas de palestrantes.
                                        </span>
                                    </div>

                                    <span class="speaker-profile-public-badge">
                                        <i class="bi bi-globe2"></i>
                                        Conteúdo público
                                    </span>

                                </div>


                                <div class="speaker-profile-grid">

                                    <div class="speaker-profile-field speaker-profile-field--full">

                                        <label class="form-label" for="nome_usuario">
                                            Nome Completo
                                        </label>

                                        <input type="text" class="form-control" name="nome_usuario" id="nome_usuario"
                                            value="{{ old('nome_usuario', $perfil->nome_usuario) }}" required>

                                    </div>


                                    <div class="speaker-profile-field speaker-profile-field--full">

                                        <label class="form-label" for="email_usuario">
                                            E-mail
                                        </label>

                                        <input type="email" class="form-control" name="email_usuario" id="email_usuario"
                                            value="{{ old('email_usuario', $perfil->email_usuario) }}" required>

                                        <small>
                                            Usado também para acesso à conta.
                                        </small>

                                    </div>


                                    <div class="speaker-profile-field">

                                        <label class="form-label" for="area_atuacao_usuario">
                                            Área de Atuação
                                        </label>

                                        <input type="text" class="form-control" name="area_atuacao_usuario"
                                            id="area_atuacao_usuario"
                                            value="{{ old('area_atuacao_usuario', $perfil->area_atuacao_usuario) }}"
                                            placeholder="Ex.: Direito Empresarial">

                                    </div>


                                    <div class="speaker-profile-field">

                                        <label class="form-label" for="estado_usuario">
                                            Estado
                                        </label>

                                        <input type="text" class="form-control" name="estado_usuario" id="estado_usuario"
                                            value="{{ old('estado_usuario', $perfil->estado_usuario) }}"
                                            placeholder="Ex.: São Paulo">

                                    </div>


                                    <div class="speaker-profile-field speaker-profile-field--full">

                                        <div class="speaker-profile-label-row">

                                            <label class="form-label" for="sobre_usuario">
                                                Sobre mim
                                            </label>

                                            <span id="sobreUsuarioCounter">
                                                0 / 2500
                                            </span>

                                        </div>

                                        <textarea class="form-control" name="sobre_usuario" id="sobre_usuario" rows="8"
                                            maxlength="2500"
                                            placeholder="Conte sua experiência, especialidade e trajetória profissional...">{{ old('sobre_usuario', $perfil->sobre_usuario) }}</textarea>

                                        <small>
                                            Este texto aparece na apresentação pública
                                            do palestrante.
                                        </small>

                                    </div>


                                    {{-- =================================================
                                    REDES SOCIAIS
                                    ================================================== --}}
                                    <div class="speaker-profile-social-section speaker-profile-field--full">

                                        <div class="speaker-profile-social-heading">

                                            <div>
                                                <strong>
                                                    Redes sociais e presença digital
                                                </strong>

                                                <span>
                                                    Informe apenas as redes que deseja exibir
                                                    publicamente no seu perfil de palestrante.
                                                </span>
                                            </div>

                                            <i class="bi bi-share"></i>

                                        </div>


                                        <div class="speaker-profile-social-grid">

                                            <div class="speaker-profile-field">

                                                <label class="form-label" for="instagram_usuario">
                                                    <i class="bi bi-instagram"></i>
                                                    Instagram
                                                </label>

                                                <input type="url" class="form-control" name="instagram_usuario"
                                                    id="instagram_usuario"
                                                    value="{{ old('instagram_usuario', $perfil->instagram_usuario) }}"
                                                    placeholder="https://instagram.com/seuusuario">

                                            </div>


                                            <div class="speaker-profile-field">

                                                <label class="form-label" for="linkedin_usuario">
                                                    <i class="bi bi-linkedin"></i>
                                                    LinkedIn
                                                </label>

                                                <input type="url" class="form-control" name="linkedin_usuario"
                                                    id="linkedin_usuario"
                                                    value="{{ old('linkedin_usuario', $perfil->linkedin_usuario) }}"
                                                    placeholder="https://linkedin.com/in/seuperfil">

                                            </div>


                                            <div class="speaker-profile-field">

                                                <label class="form-label" for="youtube_usuario">
                                                    <i class="bi bi-youtube"></i>
                                                    YouTube
                                                </label>

                                                <input type="url" class="form-control" name="youtube_usuario"
                                                    id="youtube_usuario"
                                                    value="{{ old('youtube_usuario', $perfil->youtube_usuario) }}"
                                                    placeholder="https://youtube.com/@seucanal">

                                            </div>


                                            <div class="speaker-profile-field">

                                                <label class="form-label" for="tiktok_usuario">
                                                    <i class="bi bi-tiktok"></i>
                                                    TikTok
                                                </label>

                                                <input type="url" class="form-control" name="tiktok_usuario"
                                                    id="tiktok_usuario"
                                                    value="{{ old('tiktok_usuario', $perfil->tiktok_usuario) }}"
                                                    placeholder="https://tiktok.com/@seuusuario">

                                            </div>


                                            <div class="speaker-profile-field">

                                                <label class="form-label" for="facebook_usuario">
                                                    <i class="bi bi-facebook"></i>
                                                    Facebook
                                                </label>

                                                <input type="url" class="form-control" name="facebook_usuario"
                                                    id="facebook_usuario"
                                                    value="{{ old('facebook_usuario', $perfil->facebook_usuario) }}"
                                                    placeholder="https://facebook.com/seuperfil">

                                            </div>


                                            <div class="speaker-profile-field">

                                                <label class="form-label" for="site_usuario">
                                                    <i class="bi bi-globe2"></i>
                                                    Site profissional
                                                </label>

                                                <input type="url" class="form-control" name="site_usuario" id="site_usuario"
                                                    value="{{ old('site_usuario', $perfil->site_usuario) }}"
                                                    placeholder="https://seusite.com.br">

                                            </div>

                                        </div>

                                        <small class="speaker-profile-social-help">
                                            Use a URL completa, começando por https://.
                                            Campos vazios não aparecem no site.
                                        </small>

                                    </div>

                                </div>


                                <div class="speaker-profile-info-box">

                                    <i class="bi bi-shield-check"></i>

                                    <div>
                                        <strong>
                                            Dados controlados pela organização
                                        </strong>

                                        <span>
                                            Perfil de acesso e status da conta continuam
                                            sob controle administrativo e não podem ser
                                            alterados por esta tela.
                                        </span>
                                    </div>

                                </div>


                                <div class="speaker-profile-actions">

                                    <a href="{{ route('admin.palestrante.dash') }}" class="admin-secondary-action">
                                        Cancelar
                                    </a>

                                    <button type="submit" class="admin-primary-action">
                                        <i class="bi bi-check2-circle"></i>
                                        Salvar Alterações
                                    </button>

                                </div>

                            </section>

                        </form>

                    </div>

                </section>

            </div>

        </div>

    </main>


    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const inputFoto =
                document.getElementById('foto_usuario');

            const preview =
                document.getElementById('profileAvatarPreview');

            const fallback =
                document.getElementById('profileAvatarFallback');

            const sobre =
                document.getElementById('sobre_usuario');

            const counter =
                document.getElementById('sobreUsuarioCounter');


            if (sobre && counter) {

                const atualizarContador = () => {
                    counter.textContent =
                        `${sobre.value.length} / 2500`;
                };

                atualizarContador();

                sobre.addEventListener(
                    'input',
                    atualizarContador
                );
            }


            if (!inputFoto || !preview) {
                return;
            }


            inputFoto.addEventListener('change', () => {

                const arquivo =
                    inputFoto.files?.[0];

                if (!arquivo) {
                    return;
                }

                const urlTemporaria =
                    URL.createObjectURL(arquivo);

                preview.src =
                    urlTemporaria;

                preview.classList.remove(
                    'd-none'
                );

                if (fallback) {
                    fallback.classList.add(
                        'd-none'
                    );
                }

                preview.onload = () => {
                    URL.revokeObjectURL(
                        urlTemporaria
                    );
                };

            });

        });
    </script>

@endsection