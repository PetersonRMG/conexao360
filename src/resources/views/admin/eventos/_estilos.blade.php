<style>
    /* Área de eventos: reaproveita as cores existentes do Dashboard. */
    .eventos-admin {
        --ev-bg: var(--site-editor-bg, #0b0b0b);
        --ev-surface: var(--site-editor-surface, #121212);
        --ev-surface-2: var(--site-editor-surface-2, #171717);
        --ev-border: var(--site-editor-border, rgba(255,255,255,.1));
        --ev-text: var(--site-editor-text, #f1eee8);
        --ev-muted: var(--site-editor-text-soft, #c7c1b8);
        --ev-gold: var(--site-editor-primary, #d6b26a);
        color: var(--ev-text);
        background: var(--ev-bg);
        min-height: calc(100vh - 70px);
    }
    /* Ocupa toda a coluna principal do dashboard; sem centralizacao limitada a 1330px. */
    .eventos-admin .ev-shell { width: 100%; max-width: none; margin: 0; padding: 24px clamp(16px, 2vw, 32px) 60px; box-sizing: border-box; }
    .eventos-admin .ev-shell--fluid { width: 100%; max-width: none; }
    .eventos-admin .ev-top { display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap; margin-bottom:25px; }
    .eventos-admin .ev-eyebrow { text-transform:uppercase; letter-spacing:.12em; color:var(--ev-gold); font-size:.75rem; font-weight:700; }
    .eventos-admin h2 {font-size:clamp(1.55rem,3vw,2.1rem);font-weight:750;color:var(--ev-text);margin:7px 0 8px;}
    .eventos-admin .ev-description {color:var(--ev-muted);max-width:730px;margin:0;line-height:1.55;}
    .eventos-admin .ev-btn {display:inline-flex; align-items:center; justify-content:center; gap:9px; text-decoration:none; font-weight:650; border:1px solid var(--ev-gold); background:var(--ev-gold); color:#17120b; padding:11px 18px; border-radius:10px; transition:background .16s,border-color .16s; cursor:pointer;}
    .eventos-admin .ev-btn:hover {background:#efd18d;border-color:#efd18d;color:#17120b;}
    .eventos-admin .ev-btn--outline {background:transparent;color:var(--ev-gold);}
    .eventos-admin .ev-btn--outline:hover {background:rgba(214,178,106,.1);color:var(--ev-gold);}
    .eventos-admin .ev-btn--neutral {background:var(--ev-surface-2);color:var(--ev-text);border-color:var(--ev-border);}
    .eventos-admin .ev-btn--neutral:hover {background:var(--ev-surface);color:var(--ev-text);border-color:var(--ev-gold);}
    .eventos-admin .ev-summary {display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin:22px 0;}
    .eventos-admin .ev-stat {padding:18px 20px;background:var(--ev-surface);border:1px solid var(--ev-border);border-radius:14px;}
    .eventos-admin .ev-stat small{color:var(--ev-muted);display:block;font-size:.86rem;}
    .eventos-admin .ev-stat strong {display:block;font-size:1.7rem;font-weight:800;color:var(--ev-text);margin-top:3px;}
    .eventos-admin .ev-stat i {color:var(--ev-gold);margin-right:8px;}
    .eventos-admin .ev-filter {display:flex;gap:10px;align-items:end;flex-wrap:wrap;background:var(--ev-surface);border:1px solid var(--ev-border);border-radius:14px;padding:16px;margin-bottom:17px;}
    .eventos-admin label {color:var(--ev-muted);font-size:.88rem;font-weight:600;display:block;margin-bottom:6px;}
    .eventos-admin .ev-field {flex:1;min-width:220px;}
    .eventos-admin input:not([type=file]),.eventos-admin textarea,.eventos-admin select,.eventos-admin input[type=file] {color:var(--ev-text);background:var(--ev-surface-2);border:1px solid rgba(214,178,106,.23);border-radius:9px;padding:11px 12px;width:100%;min-height:44px;color-scheme:inherit;}
    .eventos-admin input:focus,.eventos-admin textarea:focus,.eventos-admin select:focus {outline:0;border-color:var(--ev-gold);box-shadow:0 0 0 3px rgba(214,178,106,.14);}
    .eventos-admin input::placeholder,.eventos-admin textarea::placeholder {color:var(--ev-muted);opacity:.85;}
    .eventos-admin textarea {min-height:125px;resize:vertical;}
    .eventos-admin .ev-card {display:grid;grid-template-columns:185px minmax(0,1fr);border:1px solid var(--ev-border);background:var(--ev-surface);border-radius:16px;overflow:hidden;margin-bottom:13px;}
    .eventos-admin .ev-cover {background:linear-gradient(135deg,var(--ev-surface-2),var(--ev-bg));min-height:185px;display:flex;align-items:center;justify-content:center;}
    .eventos-admin .ev-cover img {width:100%;height:100%;object-fit:cover;}
    .eventos-admin .ev-cover i {font-size:3rem;color:var(--ev-gold);opacity:.7;}
    .eventos-admin .ev-card-body {padding:20px 24px;min-width:0;}
    .eventos-admin .ev-card-title{font-size:1.17rem;font-weight:730;margin:0;color:var(--ev-text);overflow-wrap:anywhere;}
    .eventos-admin .ev-card-sub{color:var(--ev-muted);font-size:.9rem;margin:6px 0 14px;}
    .eventos-admin .ev-badge {display:inline-block;border-radius:20px;padding:4px 10px;font-size:.72rem;font-weight:700;white-space:nowrap;border:1px solid var(--ev-border);color:var(--ev-muted);}
    .eventos-admin .ev-badge--active{color:#84d9aa;background:rgba(45,160,100,.09);border-color:rgba(45,160,100,.3);}
    .eventos-admin .ev-meta {display:flex;gap:12px 20px;flex-wrap:wrap;color:var(--ev-muted);font-size:.84rem;margin-bottom:16px;}
    .eventos-admin .ev-meta i{color:var(--ev-gold);margin-right:4px;}
    .eventos-admin .ev-card-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .eventos-admin .ev-card-actions .ev-btn{padding:8px 13px;font-size:.84rem;}
    .eventos-admin .ev-empty {text-align:center;padding:50px 16px;color:var(--ev-muted);border:1px dashed var(--ev-border);border-radius:14px;}
    .eventos-admin .ev-empty i{color:var(--ev-gold);font-size:2rem;display:block;margin-bottom:10px;}
    .eventos-admin .ev-form-panel {background:var(--ev-surface);border:1px solid var(--ev-border);border-radius:15px;padding:24px;}
    .eventos-admin .ev-form-grid{display:grid;grid-template-columns:repeat(12,minmax(0,1fr));gap:20px;}
    .eventos-admin .ev-col-12{grid-column:span 12;}.eventos-admin .ev-col-8{grid-column:span 8;}.eventos-admin .ev-col-6{grid-column:span 6;}.eventos-admin .ev-col-4{grid-column:span 4;}
    .eventos-admin .ev-help{font-size:.8rem;color:var(--ev-muted);margin-top:6px;}
    .eventos-admin .ev-form-heading{font-size:1rem;font-weight:750;color:var(--ev-gold);margin:6px 0 0;}
    .eventos-admin .ev-preview {width:100%;max-width:320px;max-height:160px;object-fit:cover;border-radius:9px;border:1px solid var(--ev-border);margin-bottom:12px;}
    .eventos-admin .ev-flash {border:1px solid rgba(65,185,112,.38);background:rgba(65,185,112,.09);color:#9be0b6;padding:13px 16px;border-radius:9px;margin-bottom:16px;}
    .eventos-admin .ev-errors {border:1px solid rgba(214,87,93,.36);background:rgba(214,87,93,.10);color:#ffb3b8;padding:14px 17px;border-radius:9px;margin-bottom:16px;}
    .eventos-admin .ev-errors ul {margin-bottom:0;}
    .eventos-admin .ev-pagination {margin-top:20px;}
    .eventos-admin .ev-pagination nav {max-width:100%;overflow-x:auto;}
    .eventos-admin .page-link {background:var(--ev-surface-2);color:var(--ev-gold);border-color:var(--ev-border);}
    .eventos-admin .page-item.active .page-link {background:var(--ev-gold);color:#17120b;border-color:var(--ev-gold);}
    .eventos-admin .page-item.disabled .page-link {background:var(--ev-surface);color:var(--ev-muted);border-color:var(--ev-border);}
    /* Contraste e controles nativos coerentes com o tema global do painel. */
    [data-bs-theme="light"] .eventos-admin .ev-badge--active {color:#147c4a;background:#e6f4eb;border-color:#a7d9ba;}
    [data-bs-theme="light"] .eventos-admin .ev-flash {color:#146a3f;background:#e8f6ed;border-color:#8acfa8;}
    [data-bs-theme="light"] .eventos-admin .ev-errors {color:#a12b35;background:#fff0f1;border-color:#e5adb3;}
    @media (max-width:860px) {.eventos-admin .ev-card{grid-template-columns:130px 1fr;}.eventos-admin .ev-col-8,.eventos-admin .ev-col-4{grid-column:span 6;}}
    @media (max-width:600px) {.eventos-admin .ev-summary{grid-template-columns:1fr 1fr;}.eventos-admin .ev-card{display:block;}.eventos-admin .ev-cover{min-height:140px;height:160px;}.eventos-admin .ev-card-body{padding:17px;}.eventos-admin .ev-col-6,.eventos-admin .ev-col-8,.eventos-admin .ev-col-4{grid-column:span 12;}.eventos-admin .ev-shell{padding:20px 15px 50px;}}

    /* Acoes no lado direito dos cards em telas amplas, preservando a estrutura original. */
    @media (min-width: 1280px) {
        .eventos-admin .ev-card-body {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            grid-template-rows: auto auto auto;
            align-content: center;
            column-gap: 24px;
        }
        .eventos-admin .ev-card-body > .d-flex,
        .eventos-admin .ev-card-body > .ev-card-sub,
        .eventos-admin .ev-card-body > .ev-meta {
            grid-column: 1;
        }
        .eventos-admin .ev-card-actions {
            grid-column: 2;
            grid-row: 1 / 4;
            align-self: center;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            max-width: 300px;
        }
    }
</style>
