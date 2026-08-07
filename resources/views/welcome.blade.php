<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AquaGest — Gestion de la Facturation d'Eau</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink: #16302A;
            --paper: #F6F3EA;
            --paper-dim: #EFEADA;
            --teal-deep: #0B4F5C;
            --teal: #158C99;
            --teal-light: #56B4BF;
            --gold: #D9A441;
            --line: #D8D0BC;
            --white: #FFFFFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--paper);
            color: var(--ink);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3 { font-family: 'Fraunces', serif; font-weight: 600; letter-spacing: -0.01em; }

        .mono { font-family: 'IBM Plex Mono', monospace; }

        a { text-decoration: none; color: inherit; }

        .wrap { max-width: 1180px; margin: 0 auto; padding: 0 32px; }

        /* ---------- Header ---------- */
        header {
            position: sticky; top: 0; z-index: 50;
            background: rgba(246, 243, 234, 0.88);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }
        .nav {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 32px;
        }
        .brand { display: flex; align-items: center; gap: 10px; font-family: 'Fraunces', serif; font-weight: 600; font-size: 20px; color: var(--teal-deep); }
        .brand-mark {
            width: 34px; height: 34px; border-radius: 50%;
            background: conic-gradient(from 220deg, var(--teal-deep), var(--teal), var(--gold), var(--teal-deep));
            display: flex; align-items: center; justify-content: center;
            position: relative;
        }
        .brand-mark::after {
            content: ''; position: absolute; inset: 4px; border-radius: 50%; background: var(--paper);
        }
        .brand-mark svg { position: relative; z-index: 1; width: 16px; height: 16px; color: var(--teal-deep); }

        .nav-actions { display: flex; align-items: center; gap: 10px; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 10px 20px; border-radius: 999px; font-size: 14.5px; font-weight: 500;
            transition: all .2s ease; border: 1px solid transparent; cursor: pointer;
        }
        .btn-ghost { color: var(--teal-deep); }
        .btn-ghost:hover { background: var(--paper-dim); }
        .btn-solid { background: var(--teal-deep); color: var(--white); }
        .btn-solid:hover { background: var(--ink); transform: translateY(-1px); }

        /* ---------- Hero ---------- */
        .hero {
            display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 40px; align-items: center;
            padding: 84px 0 70px;
        }
        .eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            font-family: 'IBM Plex Mono', monospace; font-size: 12px; letter-spacing: 0.08em; text-transform: uppercase;
            color: var(--teal); margin-bottom: 22px;
        }
        .eyebrow::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--gold); }

        .hero h1 {
            font-size: clamp(2.4rem, 4.6vw, 3.6rem); line-height: 1.06; color: var(--ink);
            max-width: 620px;
        }
        .hero h1 em { font-style: italic; color: var(--teal-deep); }

        .hero p {
            margin-top: 22px; font-size: 17px; color: #4B5A54; max-width: 480px;
        }

        .hero-actions { display: flex; gap: 12px; margin-top: 34px; flex-wrap: wrap; }
        .btn-lg { padding: 14px 26px; font-size: 15px; }

        .hero-stats { display: flex; gap: 34px; margin-top: 48px; }
        .stat-num { font-family: 'IBM Plex Mono', monospace; font-size: 26px; color: var(--teal-deep); font-weight: 500; }
        .stat-label { font-size: 12.5px; color: #6B776F; margin-top: 2px; }

        /* ---------- Signature: Water meter gauge ---------- */
        .gauge-card {
            position: relative;
            background: linear-gradient(165deg, var(--teal-deep), var(--ink));
            border-radius: 28px;
            padding: 40px;
            box-shadow: 0 30px 60px -25px rgba(11, 79, 92, 0.45);
        }
        .gauge-label {
            font-family: 'IBM Plex Mono', monospace; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;
            color: rgba(255,255,255,0.55); display: flex; justify-content: space-between; margin-bottom: 20px;
        }
        .gauge-wrap { position: relative; width: 100%; aspect-ratio: 1; display: flex; align-items: center; justify-content: center; }
        .gauge-wrap svg { width: 100%; height: 100%; transform: rotate(-90deg); }
        .gauge-track { fill: none; stroke: rgba(255,255,255,0.12); stroke-width: 10; }
        .gauge-fill {
            fill: none; stroke: url(#gaugeGradient); stroke-width: 10; stroke-linecap: round;
            stroke-dasharray: 502; stroke-dashoffset: 502;
            animation: fillGauge 2.2s cubic-bezier(.2,.8,.2,1) 0.4s forwards;
        }
        @keyframes fillGauge { to { stroke-dashoffset: 118; } }

        .gauge-center { position: absolute; text-align: center; }
        .gauge-reading { font-family: 'IBM Plex Mono', monospace; font-size: 15px; color: rgba(255,255,255,0.5); letter-spacing: 0.08em; }
        .gauge-value {
            font-family: 'IBM Plex Mono', monospace; font-size: 42px; color: var(--white); font-weight: 500;
            display: flex; align-items: baseline; justify-content: center; gap: 4px;
        }
        .gauge-value span { font-size: 16px; color: var(--gold); }

        .gauge-footer { display: flex; justify-content: space-between; margin-top: 26px; }
        .gauge-tag {
            font-size: 12px; color: rgba(255,255,255,0.6); font-family: 'IBM Plex Mono', monospace;
            display: flex; align-items: center; gap: 6px;
        }
        .dot-live { width: 6px; height: 6px; border-radius: 50%; background: #6EE7B7; animation: pulse 1.8s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

        /* ---------- Wave divider ---------- */
        .wave { display: block; width: 100%; height: 70px; }
        .wave path { fill: var(--white); }

        /* ---------- Process ---------- */
        .process { background: var(--white); padding: 90px 0; }
        .section-head { max-width: 560px; margin-bottom: 56px; }
        .section-kicker {
            font-family: 'IBM Plex Mono', monospace; font-size: 12px; letter-spacing: 0.08em; text-transform: uppercase;
            color: var(--teal); margin-bottom: 12px; display: block;
        }
        .section-head h2 { font-size: clamp(1.8rem, 3vw, 2.3rem); color: var(--ink); }
        .section-head p { color: #5C6862; margin-top: 12px; font-size: 15.5px; }

        .steps { display: grid; grid-template-columns: repeat(5, 1fr); gap: 0; position: relative; }
        .steps::before {
            content: ''; position: absolute; top: 22px; left: 40px; right: 40px; height: 1px;
            background: repeating-linear-gradient(to right, var(--line) 0 6px, transparent 6px 12px);
        }
        .step { position: relative; padding-right: 18px; }
        .step-num {
            width: 44px; height: 44px; border-radius: 50%; background: var(--paper);
            border: 1.5px solid var(--teal-deep); color: var(--teal-deep);
            display: flex; align-items: center; justify-content: center;
            font-family: 'IBM Plex Mono', monospace; font-size: 14px; font-weight: 500;
            position: relative; z-index: 1; margin-bottom: 18px; background: var(--white);
        }
        .step:nth-child(5) .step-num { background: var(--teal-deep); color: var(--white); }
        .step h3 { font-size: 15.5px; font-family: 'Inter', sans-serif; font-weight: 600; margin-bottom: 6px; }
        .step p { font-size: 13.5px; color: #6B776F; }

        /* ---------- Features ---------- */
        .features { padding: 90px 0; }
        .grid-6 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .card {
            background: var(--white); border: 1px solid var(--line); border-radius: 18px;
            padding: 28px; transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
            position: relative; overflow: hidden;
        }
        .card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--teal), var(--gold));
            transform: scaleX(0); transform-origin: left; transition: transform .3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -20px rgba(22, 48, 42, 0.25);
            border-color: transparent;
        }
        .card:hover::before { transform: scaleX(1); }
        .card-icon {
            width: 42px; height: 42px; border-radius: 12px; background: var(--paper-dim);
            display: flex; align-items: center; justify-content: center; margin-bottom: 18px;
            color: var(--teal-deep); transition: background .25s ease, color .25s ease;
        }
        .card:hover .card-icon { background: var(--teal-deep); color: var(--white); }
        .card h3 { font-family: 'Inter', sans-serif; font-size: 16px; font-weight: 600; margin-bottom: 8px; }
        .card p { font-size: 13.5px; color: #6B776F; }

        /* ---------- CTA ---------- */
        .cta {
            margin: 0 32px 90px; border-radius: 28px; background: var(--ink); color: var(--paper);
            padding: 64px 48px; text-align: center; position: relative; overflow: hidden;
        }
        .cta h2 { color: var(--white); font-size: clamp(1.7rem, 3vw, 2.2rem); }
        .cta p { color: rgba(246,243,234,0.65); margin: 14px 0 30px; font-size: 15.5px; }

        /* ---------- Footer ---------- */
        footer { padding: 32px; text-align: center; font-size: 12.5px; color: #8A9490; }

        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; padding-top: 50px; }
            .steps { grid-template-columns: repeat(2, 1fr); gap: 28px; }
            .steps::before { display: none; }
            .grid-6 { grid-template-columns: 1fr 1fr; }
            .hero-stats { flex-wrap: wrap; }
        }
        @media (max-width: 560px) {
            .wrap { padding: 0 20px; }
            .nav { padding: 16px 20px; }
            .grid-6 { grid-template-columns: 1fr; }
            .steps { grid-template-columns: 1fr; }
            .cta { margin: 0 16px 60px; padding: 48px 24px; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { animation: none !important; transition: none !important; }
            .gauge-fill { stroke-dashoffset: 118; }
        }
    </style>
</head>
<body>

    <header>
        <div class="nav">
            <div class="brand">
                <span class="brand-mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 21c-4.97 0-9-4.03-9-9 0-4.418 4.03-8 9-13 4.97 5 9 8.582 9 13 0 4.97-4.03 9-9 9z"/>
                    </svg>
                </span>
                AquaGest
            </div>
            <div class="nav-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-solid">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost">Se connecter</a>
                    <a href="{{ route('register') }}" class="btn btn-solid">Créer un compte</a>
                @endauth
            </div>
        </div>
    </header>

    <section class="wrap hero">
        <div>
            <span class="eyebrow">Gestion de forages · Sénégal</span>
            <h1>Chaque goutte, <em>chaque index,</em><br>chaque facture — suivis.</h1>
            <p>AquaGest centralise vos abonnés, vos compteurs et votre facturation d'eau dans un seul outil, pensé pour les gestionnaires de forages.</p>

            <div class="hero-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-solid btn-lg">Accéder au tableau de bord →</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-solid btn-lg">Commencer maintenant →</a>
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-lg">J'ai déjà un compte</a>
                @endauth
            </div>

            <div class="hero-stats">
                <div>
                    <div class="stat-num">01</div>
                    <div class="stat-label">Plateforme unifiée</div>
                </div>
                <div>
                    <div class="stat-num">m³</div>
                    <div class="stat-label">Facturation au réel</div>
                </div>
                <div>
                    <div class="stat-num">PDF</div>
                    <div class="stat-label">Reçus exportables</div>
                </div>
            </div>
        </div>

        <div class="gauge-card">
            <div class="gauge-label">
                <span>Compteur N°0427</span>
                <span>Actif</span>
            </div>
            <div class="gauge-wrap">
                <svg viewBox="0 0 180 180">
                    <defs>
                        <linearGradient id="gaugeGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#56B4BF"/>
                            <stop offset="100%" stop-color="#D9A441"/>
                        </linearGradient>
                    </defs>
                    <circle class="gauge-track" cx="90" cy="90" r="80"/>
                    <circle class="gauge-fill" cx="90" cy="90" r="80"/>
                </svg>
                <div class="gauge-center">
                    <div class="gauge-reading">INDEX ACTUEL</div>
                    <div class="gauge-value">1284<span>m³</span></div>
                </div>
            </div>
            <div class="gauge-footer">
                <span class="gauge-tag"><span class="dot-live"></span> Relevé synchronisé</span>
                <span class="gauge-tag mono">76%</span>
            </div>
        </div>
    </section>

    <svg class="wave" viewBox="0 0 1440 70" preserveAspectRatio="none">
        <path d="M0,40 C240,80 480,0 720,30 C960,60 1200,10 1440,40 L1440,70 L0,70 Z"></path>
    </svg>

    <section class="process">
        <div class="wrap">
            <div class="section-head">
                <span class="section-kicker">Le circuit</span>
                <h2>De l'abonnement au paiement</h2>
                <p>Un flux linéaire qui suit exactement le parcours d'un abonné, du premier compteur assigné jusqu'au règlement de sa facture.</p>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-num">01</div>
                    <h3>Abonnement</h3>
                    <p>Le client est enregistré comme abonné.</p>
                </div>
                <div class="step">
                    <div class="step-num">02</div>
                    <h3>Compteur</h3>
                    <p>Un compteur disponible lui est assigné.</p>
                </div>
                <div class="step">
                    <div class="step-num">03</div>
                    <h3>Relevé</h3>
                    <p>L'index est relevé à chaque passage.</p>
                </div>
                <div class="step">
                    <div class="step-num">04</div>
                    <h3>Facture</h3>
                    <p>Le montant est calculé selon le tarif.</p>
                </div>
                <div class="step">
                    <div class="step-num">05</div>
                    <h3>Paiement</h3>
                    <p>Le règlement est enregistré et suivi.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="wrap">
            <div class="section-head">
                <span class="section-kicker">Fonctionnalités</span>
                <h2>Tout ce qu'il faut, rien de plus</h2>
            </div>
            <div class="grid-6">
                <div class="card">
                    <div class="card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg>
                    </div>
                    <h3>Abonnés</h3>
                    <p>Fiches clients complètes, triées par collectivité, avec historique intégral.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18M8 4v4"/></svg>
                    </div>
                    <h3>Compteurs</h3>
                    <p>Stock, attribution et transfert des compteurs suivis en temps réel.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                    </div>
                    <h3>Facturation</h3>
                    <p>Génération automatique à partir des relevés, avec suivi du solde.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 15l4-6 3 4 5-8"/></svg>
                    </div>
                    <h3>Tarifs</h3>
                    <p>Grille de prix par catégorie, ajustable sans toucher au code.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="7" height="7"/><rect x="13" y="4" width="7" height="7"/><rect x="4" y="13" width="7" height="7"/><rect x="13" y="13" width="7" height="7"/></svg>
                    </div>
                    <h3>Tableau de bord</h3>
                    <p>Vue d'ensemble instantanée : recouvrement, impayés, activité.</p>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M9 15h6M9 11h2"/></svg>
                    </div>
                    <h3>Reçus PDF</h3>
                    <p>Facture téléchargeable et imprimable, prête à remettre au client.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <h2>Prêt à structurer votre facturation ?</h2>
        <p>Créez un compte et commencez à gérer vos abonnés dès aujourd'hui.</p>
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-solid btn-lg" style="background: var(--gold); color: var(--ink);">Accéder au tableau de bord →</a>
        @else
            <a href="{{ route('register') }}" class="btn btn-solid btn-lg" style="background: var(--gold); color: var(--ink);">Créer un compte gratuitement →</a>
        @endauth
    </section>
    <footer>
        AquaGest — Application académique, UCAD Département Informatique
    </footer>
</body>
</html>