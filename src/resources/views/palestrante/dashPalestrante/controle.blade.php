@extends('layout.palestrante')
@section('title', 'Home ')
@section('pg-titulo', 'Home')
@section('link-topo', 'Home')

@section('content')
<div class="content-wrapper" style="background-color: #0d0f14; min-height: 100vh;">
    
    <div style="padding: 2rem 1.5rem 0.5rem 1.5rem; font-family: 'Source Sans 3', sans-serif;">
        <div style="margin-bottom: 2rem;">
            <h3 style="font-family: 'Cinzel', serif; color: #dfcaa0; letter-spacing: 1px; font-weight: 600; margin: 0 0 0.25rem 0; font-size: 1.8rem;">
                Visão Geral do Ecossistema PALESTRANTE
            </h3>
            <p style="color: #94a3b8; margin: 0; font-size: 0.9rem;">Monitore as métricas, engajamento e solicitações pendentes da rede privada.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
            
            <div style="background-color: #11141a; border: 1px solid #1e2330; border-radius: 10px; padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                <div style="background-color: rgba(223, 202, 160, 0.1); color: #dfcaa0; min-width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <span style="color: #94a3b8; font-size: 0.85rem; display: block; margin-bottom: 0.15rem; font-weight: 500;">Membros Ativos</span>
                    <h3 style="color: #ffffff; margin: 0; font-weight: 700; font-size: 1.6rem; letter-spacing: -0.5px;">1,248</h3>
                </div>
            </div>

            <div style="background-color: #11141a; border: 1px solid #1e2330; border-radius: 10px; padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                <div style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107; min-width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div>
                    <span style="color: #94a3b8; font-size: 0.85rem; display: block; margin-bottom: 0.15rem; font-weight: 500;">Aguardando Moderação</span>
                    <h3 style="color: #ffffff; margin: 0; font-weight: 700; font-size: 1.6rem; letter-spacing: -0.5px;">7</h3>
                </div>
            </div>

            <div style="background-color: #11141a; border: 1px solid #1e2330; border-radius: 10px; padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                <div style="background-color: rgba(34, 197, 94, 0.1); color: #22c55e; min-width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div>
                    <span style="color: #94a3b8; font-size: 0.85rem; display: block; margin-bottom: 0.15rem; font-weight: 500;">Novos este Mês</span>
                    <h3 style="color: #ffffff; margin: 0; font-weight: 700; font-size: 1.6rem; letter-spacing: -0.5px;">+84</h3>
                </div>
            </div>

            <div style="background-color: #11141a; border: 1px solid #1e2330; border-radius: 10px; padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                <div style="background-color: rgba(13, 148, 136, 0.1); color: #0d9488; min-width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                    <i class="bi bi-chat-quote-fill"></i>
                </div>
                <div>
                    <span style="color: #94a3b8; font-size: 0.85rem; display: block; margin-bottom: 0.15rem; font-weight: 500;">Depoimentos no Site</span>
                    <h3 style="color: #ffffff; margin: 0; font-weight: 700; font-size: 1.6rem; letter-spacing: -0.5px;">15</h3>
                </div>
            </div>

        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; flex-wrap: wrap; align-items: start;">
            
            <div style="background-color: #11141a; border: 1px solid #1e2330; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.25); overflow: hidden;">
                <div style="padding: 1.25rem 1.5rem; background-color: #0d0f14; border-bottom: 1px solid #1e2330; display: flex; justify-content: space-between; align-items: center;">
                    <h5 style="color: #dfcaa0; font-family: 'Cinzel', serif; margin: 0; font-size: 1.05rem; letter-spacing: 0.5px; font-weight: 600;">
                        Publicações Recentes pendentes
                    </h5>
                    <span style="background-color: rgba(223, 202, 160, 0.15); color: #dfcaa0; font-size: 0.75rem; padding: 0.2rem 0.6rem; border-radius: 20px; font-weight: 600;">Feed de Atividade</span>
                </div>
                
                <div style="padding: 1rem; overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; color: #cbd5e1; font-size: 0.9rem;">
                        <thead>
                            <tr style="border-bottom: 1px solid #1e2330; color: #64748b; font-size: 0.8rem; text-transform: uppercase;">
                                <th style="padding: 0.75rem 1rem;">Autor</th>
                                <th style="padding: 0.75rem 1rem;">Título / Tópico</th>
                                <th style="padding: 0.75rem 1rem;">Data</th>
                                <th style="padding: 0.75rem 1rem; text-align: right;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-row-hover" style="border-bottom: 1px solid #161a23;">
                                <td style="padding: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 32px; height: 32px; background-color: #dfcaa0; border-radius: 50%; color: #0d0f14; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem;">MC</div>
                                        <div>
                                            <span style="color: #ffffff; font-weight: 600; display: block; font-size: 0.85rem;">Dra. Maria Costa</span>
                                            <small style="color: #64748b; font-size: 0.75rem;">Direito Digital</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1rem; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 500;">
                                    Bastidores: Preparativos para a minha palestra de amanhã 👑
                                </td>
                                <td style="padding: 1rem; color: #64748b; font-size: 0.8rem;">Hoje às 10:32</td>
                                <td style="padding: 1rem; text-align: right;">
                                    <a href="#" style="background-color: rgba(223, 202, 160, 0.1); color: #dfcaa0; border: 1px solid rgba(223, 202, 160, 0.2); padding: 0.35rem 0.75rem; border-radius: 6px; font-size: 0.75rem; text-decoration: none; font-weight: 600; transition: all 0.2s;">Moderar</a>
                                </td>
                            </tr>
                            <tr class="table-row-hover" style="border-bottom: 1px solid #161a23;">
                                <td style="padding: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 32px; height: 32px; background-color: #262d3d; border-radius: 50%; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem;">AR</div>
                                        <div>
                                            <span style="color: #ffffff; font-weight: 600; display: block; font-size: 0.85rem;">Dra. Amanda Rodrigues</span>
                                            <small style="color: #64748b; font-size: 0.75rem;">Trabalhista</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1rem; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 500;">
                                    Estratégias de precificação com base em valor e autoridade
                                </td>
                                <td style="padding: 1rem; color: #64748b; font-size: 0.8rem;">Ontem às 18:15</td>
                                <td style="padding: 1rem; text-align: right;">
                                    <a href="#" style="background-color: rgba(223, 202, 160, 0.1); color: #dfcaa0; border: 1px solid rgba(223, 202, 160, 0.2); padding: 0.35rem 0.75rem; border-radius: 6px; font-size: 0.75rem; text-decoration: none; font-weight: 600; transition: all 0.2s;">Moderar</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="background-color: #11141a; border: 1px solid #1e2330; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.25); overflow: hidden;">
                <div style="padding: 1.25rem 1.5rem; background-color: #0d0f14; border-bottom: 1px solid #1e2330;">
                    <h5 style="color: #dfcaa0; font-family: 'Cinzel', serif; margin: 0; font-size: 1.05rem; letter-spacing: 0.5px; font-weight: 600;">
                        Novos Membros
                    </h5>
                </div>
                
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #1e2330; border: 1px solid #dfcaa0; display: flex; align-items: center; justify-content: center; color: #dfcaa0; font-weight: bold; font-size: 0.85rem;">
                            BC
                        </div>
                        <div>
                            <h6 style="color: #ffffff; margin: 0 0 0.15rem 0; font-size: 0.88rem; font-weight: 600;">Dr. Bruno Cantanhêde</h6>
                            <small style="color: #94a3b8; font-size: 0.75rem;">Membro VIP • RJ</small>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #1e2330; border: 1px solid #262d3d; display: flex; align-items: center; justify-content: center; color: #cbd5e1; font-weight: bold; font-size: 0.85rem;">
                            JS
                        </div>
                        <div>
                            <h6 style="color: #ffffff; margin: 0 0 0.15rem 0; font-size: 0.88rem; font-weight: 600;">Dr. João Silva</h6>
                            <small style="color: #94a3b8; font-size: 0.75rem;">Membro Premium • SP</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .table-row-hover:hover {
        background-color: rgba(223, 202, 160, 0.02) !important;
    }
    .table-row-hover a:hover {
        background-color: #dfcaa0 !important;
        color: #0d0f14 !important;
    }
</style>
@endsection