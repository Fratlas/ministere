<?php
$title = 'A propos - Ministere des Finances';
$extraHead = <<<'HTML'
<style>
    .about-page {
        position: relative;
        overflow-x: hidden;
    }

    .about-page .about-intro,
    .about-page .about-section {
        scroll-margin-top: 120px;
    }

    .about-page .about-intro {
        background: linear-gradient(135deg, #0d8bdc 0%, #005b9f 100%);
        color: #fff;
        padding: 56px 0 64px;
        text-align: center;
        position: relative;
        z-index: 0;
        overflow: hidden;
    }

    .about-page .about-intro-blob {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        filter: blur(3px);
        animation: floatBlob 12s ease-in-out infinite;
    }

    .about-page .about-intro-blob-1 {
        width: 300px;
        height: 300px;
        top: -80px;
        right: -100px;
    }

    .about-page .about-intro-blob-2 {
        width: 200px;
        height: 200px;
        bottom: -60px;
        left: -80px;
        animation-delay: -4s;
    }

    .about-page .about-intro h1 {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        letter-spacing: 0.5px;
        line-height: 1.05;
        margin-bottom: 14px;
    }

    .about-page .about-intro p {
        max-width: 760px;
        margin: 0 auto;
        opacity: 0.9;
        font-size: 0.98rem;
        line-height: 1.55;
    }

    .about-page .about-divider {
        width: 90px;
        height: 4px;
        margin: 18px auto 0;
        background: #ffcc00;
    }

    .about-page .about-divider-tri {
        width: 90px;
        height: 4px;
        margin: 18px auto 0;
        background: linear-gradient(to right, #0d8bdc 33%, #ffcc00 33%, #ffcc00 66%, #e60000 66%);
    }

    .about-page .about-section {
        padding: 80px 0;
        background: #f6f8fb;
        position: relative;
        z-index: 1;
        overflow: visible;
    }

    /* Le 1er <section> est .about-intro — :first-of-type ne matche jamais .about-section */
    .about-page .about-intro + .about-section {
        padding-top: 140px;
    }

    .about-page .about-section > .container {
        position: relative;
        z-index: 1;
    }

    .about-page .about-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 18px 55px rgba(0, 58, 118, 0.08);
        overflow: hidden;
    }

    .about-page .about-authority {
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(0, 1fr);
        gap: 52px;
        align-items: start;
    }

    .about-page .about-authority > div {
        min-width: 0;
    }

    .about-page .about-photo {
        position: relative;
        display: block;
        max-width: 100%;
        z-index: 1;
        overflow: visible;
        padding-bottom: 110px;
    }

    .about-page .about-photo img {
        width: 100%;
        height: 520px;
        object-fit: cover;
        object-position: center;
        border-radius: 26px;
        box-shadow: 0 24px 50px rgba(0, 0, 0, 0.14);
        display: block;
    }

    .about-page .quote-badge {
        position: absolute;
        background: #0d8bdc;
        color: #fff;
        width: 290px;
        padding: 24px;
        border-radius: 18px;
        box-shadow: 0 18px 40px rgba(13, 139, 220, 0.35);
        z-index: 2;
        animation: slideInUp 0.8s ease-out both;
        animation-delay: 0.3s;
        transition: all 0.3s ease;
        left: 34%;
        bottom: 0;
        margin-left: 0;
    }

    .about-page .quote-badge:hover {
        transform: translateY(-5px);
        box-shadow: 0 24px 50px rgba(13, 139, 220, 0.45);
    }

    .about-page .section-kicker {
        text-transform: uppercase;
        letter-spacing: 0.18em;
        font-size: 0.72rem;
        font-weight: 800;
        color: #0d8bdc;
        margin-bottom: 12px;
        animation: slideInLeft 0.6s ease-out both;
    }

    .about-page .section-title {
        font-size: 2.4rem;
        line-height: 1.05;
        font-weight: 900;
        color: #101828;
        margin-bottom: 22px;
        animation: slideInRight 0.6s ease-out both;
        animation-delay: 0.1s;
    }

    .about-page .section-copy {
        color: #4b5563;
        line-height: 1.9;
        margin-bottom: 18px;
        text-align: justify;
        overflow-wrap: anywhere;
    }

    .about-page .signature-block {
        margin-top: 26px;
        font-weight: 800;
        color: #101828;
    }

    .about-page .signature-block small {
        display: block;
        color: #0d8bdc;
        font-weight: 700;
    }

    .about-page .foundation-shell {
        background: #fff;
        border-radius: 28px;
        padding: 48px;
        box-shadow: 0 18px 55px rgba(0, 58, 118, 0.08);
        position: relative;
        z-index: 1;
        animation: softLift 0.8s ease both;
    }

    .about-page .foundation-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 28px;
    }

    .about-page .foundation-card {
        border-radius: 24px;
        border: 1px solid rgba(13, 139, 220, 0.08);
        padding: 30px;
        background: #fff;
        min-height: 240px;
    }

    .about-page .foundation-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: rgba(13, 139, 220, 0.12);
        color: #0d8bdc;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        font-size: 1.2rem;
    }

    .about-page .structure-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .about-page .structure-card {
        background: #fff;
        border-radius: 22px;
        padding: 24px;
        min-height: 240px;
        box-shadow: 0 10px 35px rgba(16, 24, 40, 0.08);
    }

    .about-page .structure-card h5 {
        font-weight: 800;
        color: #101828;
        margin-bottom: 16px;
    }

    .about-page .structure-card ul {
        padding-left: 18px;
        margin-bottom: 0;
        color: #475467;
        line-height: 1.8;
    }

    .about-page .team-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }

    .about-page .team-card {
        background: #fff;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(16, 24, 40, 0.08);
        text-align: center;
    }

    .about-page .team-photo {
        height: 180px;
        background: linear-gradient(180deg, #d9d9d9, #ececec);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #111827;
        font-size: 4rem;
    }

    .about-page .team-body {
        padding: 18px 18px 24px;
    }

    .about-page .team-name {
        font-weight: 800;
        margin-bottom: 6px;
    }

    .about-page .team-role {
        color: #0d8bdc;
        font-size: 0.9rem;
        font-weight: 700;
    }

    @media (max-width: 991.98px) {
        .about-page .about-authority,
        .about-page .foundation-grid,
        .about-page .structure-grid,
        .about-page .team-grid {
            grid-template-columns: 1fr;
        }

        .about-page .about-photo {
            max-width: 100%;
            padding-bottom: 0;
        }

        .about-page .quote-badge {
            width: 100%;
            position: relative;
            left: 0;
            bottom: 0;
            margin-top: -36px;
        }

        .about-page .about-intro {
            padding: 44px 0 52px;
        }

        .about-page .about-intro + .about-section {
            padding-top: 100px;
        }

        .about-page .about-intro h1 {
            font-size: clamp(1.8rem, 6vw, 2.4rem);
        }

        .about-page .section-title {
            font-size: 2rem;
        }
    }

    /* Quelques chiffres — barre grise, titre à gauche, 2 colonnes chiffrées + séparateurs (maquette) */
    .about-page .about-stats {
        background: #e7e7e7;
        padding: 44px 0;
        position: relative;
        z-index: 1;
    }

    .about-page .about-stats-row {
        display: grid;
        grid-template-columns: minmax(0, 240px) 1px minmax(0, 1fr) 1px minmax(0, 1fr) 1px;
        align-items: center;
        column-gap: clamp(20px, 4vw, 40px);
        row-gap: 0;
    }

    .about-page .about-stats-title {
        font-size: clamp(1.55rem, 2.5vw, 2rem);
        font-weight: 900;
        color: #333;
        line-height: 1.08;
        margin: 0;
        text-align: left;
    }

    .about-page .about-stats-divider {
        width: 1px;
        height: 88px;
        background: rgba(0, 0, 0, 0.32);
        justify-self: center;
        align-self: center;
    }

    .about-page .about-stat {
        text-align: center;
        padding: 8px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .about-page .about-stat-number {
        font-size: clamp(1.85rem, 3.2vw, 2.35rem);
        font-weight: 900;
        color: #333;
        line-height: 1;
        margin: 0 0 12px;
        letter-spacing: -0.02em;
    }

    .about-page .about-stat-label {
        font-size: 0.88rem;
        font-weight: 400;
        color: #2f2f2f;
        line-height: 1.35;
        margin: 0;
        max-width: 280px;
    }

    @media (max-width: 991.98px) {
        .about-page .about-stats {
            padding: 40px 0;
        }

        .about-page .about-stats-row {
            grid-template-columns: 1fr;
            row-gap: 22px;
        }

        .about-page .about-stats-divider {
            width: 100%;
            height: 1px;
            max-width: 100%;
        }

        .about-page .about-stats-title {
            text-align: left;
            max-width: 100%;
        }

        .about-page .about-stat {
            text-align: center;
            align-items: center;
        }

        .about-page .about-stat-label {
            max-width: 36rem;
        }
    }
</style>
HTML;
ob_start();
?>

<div class="about-page">
<section id="presentation" class="about-intro" style="overflow: hidden;">
    <div class="about-intro-blob about-intro-blob-1"></div>
    <div class="about-intro-blob about-intro-blob-2"></div>
    <div class="container" style="position: relative; z-index: 2;">
        <h1>A PROPOS</h1>
        <br>
        <div class="about-divider"></div>
        <br>
        <p>Decouvrez les missions, les valeurs et la structure organisationnelle<br>du Ministere des Finances de la Republique Democratique du<br>Congo.</p>
    </div>
</section>

<section id="mission" class="about-section">
    <div class="container">
        <div class="about-authority">
            <div class="about-photo">
                <img
                    src="/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg"
                    alt="Ministere des Finances"
                    onerror="this.onerror=null;this.src='/public/images/Home1.png';"
                >
                <div class="quote-badge">
                    <div class="fw-bold fs-4 mb-2">"</div>
                    <p class="mb-0 small">Notre engagement est de batir une economie resiliente et transparente, au service du bien-etre de chaque citoyen.</p>
                </div>
            </div>
            <div>
                <div class="section-kicker">LE MOT DE L'AUTORITE</div>
                <h2 class="section-title">Vision pour une gestion financiere exemplaire</h2>
                <p class="section-copy">Le Ministere des Finances joue un role pivot dans la stabilisation macroeconomique et le developpement durable du pays. Sous l'impulsion du Chef de l'Etat, nous avons engage des reformes profondes visant a moderniser nos regies financieres et a optimiser la depense publique.</p>
                <p class="section-copy">La transformation digitale que nous operons aujourd'hui est le socle de notre strategie pour lutter contre la corruption et garantir une mobilisation maximale des recettes. L'informatisation de la chaine de la recette est une priorite absolue.</p>
                <div class="signature-block">
                    S.E. MONSIEUR LE MINISTRE
                    <small>Ministere des Finances, RDC</small>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="structure" class="about-section pt-0">
    <div class="container">
        <div class="foundation-shell">
            <div class="text-center mb-5">
                <div class="section-kicker"></div>
                <h2 class="section-title mb-0">NOS FONDEMENTS</h2>
            </div>
                         <div class="about-divider-tri"></div>
             <div style="height:50px;"></div>
            <div class="foundation-grid">
                <div class="foundation-card">
                    <div class="foundation-icon"><i class="bi bi-journal-check"></i></div>
                    <h3 class="h4 fw-bold">NOTRE MISSION</h3>
                    <p class="section-copy mb-0">Preparer et executer la politique budgetaire et fiscale de l'Etat, assurer la gestion de la tresorerie publique et superviser le secteur financier pour garantir la stabilite economique nationale et la croissance durable.</p>
                </div>
                <div class="foundation-card">
                    <div class="foundation-icon"><i class="bi bi-eye"></i></div>
                    <h3 class="h4 fw-bold">NOTRE VISION</h3>
                    <p class="section-copy mb-0">Devenir une administration financiere moderne, performante et totalement transparente, au service d'une croissance inclusive et de l'emergence irreversible de la Republique Democratique du Congo.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="team" class="about-section pt-0">
    <div class="container">
        <div class="foundation-shell">
            <div class="text-center mb-5">
                <div class="section-kicker"></div>
                <h2 class="section-title mb-0">STRUCTURE ORGANISATIONNELLE</h2>
            </div>
             <div class="about-divider-tri"></div>
             <div style="height:50px;"></div>
            <div class="structure-grid">
                <div class="structure-card">
                    <h5><i class="bi bi-diagram-3 me-2 text-primary"></i>Cabinet du Ministre</h5>
                    <ul>
                        <li>Cabinet Politique</li>
                        <li>Secretariat Particulier</li>
                        <li>Conseillers Techniques</li>
                        <li>Cellule de Communication</li>
                    </ul>
                </div>
                <div class="structure-card">
                    <h5><i class="bi bi-diagram-3 me-2 text-primary"></i>Secretariat General</h5>
                    <ul>
                        <li>Directions de l'administration</li>
                        <li>Services generaux</li>
                        <li>Etudes et Planification</li>
                        <li>Informatique</li>
                    </ul>
                </div>
                <div class="structure-card">
                    <h5><i class="bi bi-diagram-3 me-2 text-primary"></i>Regies Financieres</h5>
                    <ul>
                        <li>DGI (Impots)</li>
                        <li>DGDA (Douanes)</li>
                        <li>DGRAD (Recettes domaniales)</li>
                        <li>CENAREF</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="about-section pt-0">
    <div class="container">
        <div class="foundation-shell">
            <div class="text-center mb-5">
                <div class="section-kicker"></div>
                <h2 class="section-title mb-0">NOTRE EQUIPE</h2>
            </div>
                         <div class="about-divider-tri"></div>
             <div style="height:50px;"></div>
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-photo"><i class="bi bi-person-circle"></i></div>
                    <div class="team-body">
                        <div class="team-name">Didier Bazangika</div>
                        <div class="team-role">Coordonnateur-Chef de Projet</div>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-photo"><i class="bi bi-person-circle"></i></div>
                    <div class="team-body">
                        <div class="team-name">Peggy d'Eve Mpengeli</div>
                        <div class="team-role">Coordinatrice Adjointe</div>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-photo"><i class="bi bi-person-circle"></i></div>
                    <div class="team-body">
                        <div class="team-name">Emmanuelle Mulanga</div>
                        <div class="team-role">Developpeuse</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
?>

