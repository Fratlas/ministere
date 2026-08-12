<?php
$title = 'A propos - Ministere des Finances';
$extraHead = <<<'HTML'
<style>
    .about-page {
        position: relative;
        overflow-x: hidden;
    }

    .about-page .about-intro,
    .about-page .about-section,
    .about-page #presentation-projet,
    .about-page #fondements,
    .about-page #missions-objectifs,
    .about-page #financement,
    .about-page #equipe-projet {
        scroll-margin-top: 130px;
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

    .about-page .about-divider,
    .about-page .about-divider-tri {
        width: 88px;
        height: 4px;
        margin: 18px auto 0;
        background: linear-gradient(to right, #0a84db 0 33%, #f4d10f 33% 66%, #ce1021 66% 100%);
        border-radius: 1px;
    }

    .about-page .about-section {
        padding: 80px 0;
        background: #f6f8fb;
        position: relative;
        z-index: 1;
        overflow: visible;
    }

    .about-page .about-intro + .about-section {
        padding-top: 100px;
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
        font-style: italic;
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
        transition: 0.2s ease-in-out;
    }
    
    .about-page .foundation-card:hover {
        border-color: #0d8bdc;
        box-shadow: 0 8px 25px rgba(13, 139, 220, 0.08);
    }

    .about-page .foundation-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(13, 139, 220, 0.14);
        color: #0d8bdc;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        font-size: 1.25rem;
    }

    .about-page .foundation-icon.foundation-icon-amber {
        background: rgba(245, 191, 13, 0.2);
        color: #c99700;
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
        transition: 0.2s ease-in-out;
        border: 1px solid transparent;
    }
    
    .about-page .structure-card:hover {
        border-color: #0d8bdc;
        box-shadow: 0 12px 40px rgba(13, 139, 220, 0.1);
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

    /* Styles pour la section Chaîne de la recette */
    .about-page .chain-intro {
        background: linear-gradient(135deg, #f0f7ff 0%, #e6f0fa 100%);
        border-radius: 24px;
        padding: 40px;
        margin-bottom: 30px;
        border-left: 6px solid #0d8bdc;
    }

    .about-page .chain-intro h3 {
        color: #0d8bdc;
        font-weight: 800;
        margin-bottom: 16px;
    }

    .about-page .chain-intro p {
        color: #2d3748;
        line-height: 1.8;
    }

    .about-page .diagnostic-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px;
        margin-top: 20px;
    }

    .about-page .diagnostic-card {
        background: #f8fafc;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        transition: 0.2s ease;
    }

    .about-page .diagnostic-card:hover {
        border-color: #0d8bdc;
        background: #f0f7ff;
    }

    .about-page .diagnostic-card h4 {
        font-weight: 700;
        color: #0d8bdc;
        font-size: 1.1rem;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .about-page .diagnostic-card ul {
        padding-left: 20px;
        margin-bottom: 0;
        color: #475467;
        line-height: 2;
        list-style-type: disc;
    }

    .about-page .diagnostic-card ul li::marker {
        color: #0d8bdc;
    }

    .about-page .perspectives-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .about-page .perspectives-list .perspective-item {
        background: #f8fafc;
        padding: 20px 24px;
        border-radius: 16px;
        border-left: 4px solid #0d8bdc;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        transition: 0.2s ease;
    }

    .about-page .perspectives-list .perspective-item:hover {
        background: #f0f7ff;
        transform: translateX(6px);
    }

    .about-page .perspectives-list .perspective-item .icon {
        color: #0d8bdc;
        font-size: 1.4rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .about-page .perspectives-list .perspective-item p {
        margin: 0;
        color: #2d3748;
        line-height: 1.6;
    }

    @media (max-width: 991.98px) {
        .about-page .about-authority,
        .about-page .foundation-grid,
        .about-page .structure-grid,
        .about-page .team-grid,
        .about-page .diagnostic-grid,
        .about-page .perspectives-list {
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

        .about-page .chain-intro {
            padding: 24px;
        }

        .about-page .perspectives-list .perspective-item {
            padding: 16px 18px;
        }
    }

    @media (max-width: 576px) {
        .about-page .foundation-shell {
            padding: 24px;
        }

        .about-page .diagnostic-card {
            padding: 18px;
        }
    }
</style>
HTML;
ob_start();
?>

<div class="about-page">
<section class="about-intro" style="overflow: hidden;">
    <div class="about-intro-blob about-intro-blob-1"></div>
    <div class="about-intro-blob about-intro-blob-2"></div>
    <div class="container" style="position: relative; z-index: 2;">
        <h1>A PROPOS</h1>
        <br>
        <div class="about-divider-tri"></div>
        <br>
        <p>Découvrez l'historique, le contexte et les objectifs du projet Gouvernance Financière, ainsi que l'organisation de son équipe de pilotage.</p>
    </div>
</section>

<section id="presentation-projet" class="about-section">
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
                    <p class="mb-0 small">Je profite de cette occasion pour relever qu'aujourd'hui plus que jamais le problème de fond de l'économie congolaise se situe au niveau de l'augmentation durable des recettes dont je fais une priorité nationale impérative : tout sera mis en œuvre pour juguler la fraude et l'évasion fiscale, engager une lutte sans merci contre la corruption et le coulage des recettes.</p>
                    <p class="mb-0 small fw-bold mt-2" style="font-style: normal;">— Discours sur l'État de la Nation, 13/12/2019</p>
                </div>
            </div>
            <div>
                <div class="section-kicker">PRÉSENTATION DU PROJET</div>
                <h2 class="section-title">Historique et contexte du projet</h2>
                <p class="section-copy">Le Ministère des Finances joue un rôle pivot dans la stabilisation macroéconomique et le développement durable du pays. Sous l'impulsion du Chef de l'État, nous avons engagé des réformes profondes visant à moderniser nos régies financières et à optimiser la dépense publique.</p>
                <p class="section-copy">La transformation digitale que nous opérons aujourd'hui est le socle de notre stratégie pour lutter contre la corruption et garantir une mobilisation maximale des recettes. L'informatisation de la chaîne de la recette est une priorité absolue.</p>
                <div class="signature-block">
                    S.E. MONSIEUR LE MINISTRE
                    <small>Ministère des Finances, RDC</small>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="fondements" class="about-section pt-0">
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
                    <div class="foundation-icon"><i class="bi bi-file-earmark-text"></i></div>
                    <h3 class="h4 fw-bold">NOTRE MISSION</h3>
                    <p class="section-copy mb-0">Préparer et exécuter la politique budgétaire et fiscale de l'État, assurer la gestion de la trésorerie publique et superviser le secteur financier pour garantir la stabilité économique nationale et la croissance durable.</p>
                </div>
                <div id="missions-objectifs" class="foundation-card">
                    <div class="foundation-icon foundation-icon-amber"><i class="bi bi-link-45deg"></i></div>
                    <h3 class="h4 fw-bold">MISSIONS ET OBJECTIFS</h3>
                    <p class="section-copy mb-0">Devenir une administration financière moderne, performante et totalement transparente, au service d'une croissance inclusive et de l'émergence irréversible de la République Démocratique du Congo.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION: CHAÎNE DE LA RECETTE -->
<section id="chainerecette" class="about-section pt-0">
    <div class="container">
        <div class="foundation-shell">
            <div class="text-center mb-5">
                <div class="section-kicker"></div>
                <h2 class="section-title mb-0">LA CHAÎNE DE LA RECETTE</h2>
            </div>
            <div class="about-divider-tri"></div>
            <div style="height:50px;"></div>

            <!-- Introduction -->
            <div class="chain-intro">
                <h3><i class="bi bi-link-45deg me-2"></i>Présentation</h3>
                <p>La chaîne de la recette est l'ensemble d'outils informatiques interconnectés qui permettent de gérer de manière automatique toute la procédure de collecte des recettes de l'État. Elle est mise en place par le projet Gouvernance Financière.</p>
                <p><strong>Son objectif</strong> est de réduire les manipulations humaines et lutter contre la fraude fiscale afin de maximiser les recettes domestiques et produire les tableaux de bord décisionnels.</p>
                <p><strong>Son champ d'actions</strong> s'étend des régies financières — la Direction Générale des Impôts (DGI), la Direction Générale des Douanes et Accises (DGDA), la Direction Générale des Recettes Administratives, Judiciaires, Domaniales et de Participations (DGRAD) — aux autres services impliqués dans la mobilisation des recettes : les banques commerciales, la Banque Centrale du Congo (BCC), la Direction du Trésor et de l'Ordonnancement (DTO), la Direction de la Comptabilité Publique (DCP) et le Cabinet du Ministre des Finances.</p>
            </div>

            <!-- État des lieux avant 2017 -->
            <div style="margin-top: 40px;">
                <h3 class="fw-bold" style="color: #101828; margin-bottom: 20px;"><i class="bi bi-clipboard-data me-2 text-primary"></i>État des lieux avant 2017</h3>
                <p style="color: #475467; margin-bottom: 24px;">Contrairement à la chaîne de la Dépense qui existe depuis 2004, la RDC ne disposait pas d'une chaîne de la Recette lors de l'état des lieux réalisé en 2016. Cet état des lieux a relevé les constats suivants :</p>
                
                <div class="diagnostic-grid">
                    <div class="diagnostic-card">
                        <h4><i class="bi bi-laptop"></i> Concernant les logiciels</h4>
                        <ul>
                            <li>Absence d'un logiciel fiable, performant et centralisé de gestion des impôts à la DGI.</li>
                            <li>Absence d'un mécanisme fiable d'identification et de localisation des contribuables.</li>
                            <li>Présence de doublons dans le répertoire d'identification des contribuables.</li>
                            <li>Absence d'un logiciel de gestion des recettes non fiscales à la DGRAD.</li>
                            <li>Déploiement partiel de Sydonia World dans les postes frontaliers.</li>
                            <li>Absence d'un logiciel de collecte et de traçabilité des flux des recettes encaissées par les banques et comptabilisées par la Banque Centrale du Congo.</li>
                            <li>Absence d'outils fiables de recoupement automatique des données des recettes pour lutter contre la fraude fiscale et la production des statistiques.</li>
                        </ul>
                    </div>
                    <div>
                        <div class="diagnostic-card" style="margin-bottom: 16px;">
                            <h4><i class="bi bi-building"></i> Concernant les infrastructures</h4>
                            <ul>
                                <li>Très faible informatisation des services opérationnels des régies financières (absence d'équipements, logiciels de gestion, câblage du réseau local, énergie électrique, etc.).</li>
                                <li>Absence d'un réseau d'échange des données entre les régies financières d'une part et entre celles-ci et les institutions détentrices des données financières de l'État d'autre part.</li>
                            </ul>
                        </div>
                        <div class="diagnostic-card" style="margin-bottom: 16px;">
                            <h4><i class="bi bi-person-gear"></i> Concernant la formation des informaticiens</h4>
                            <ul>
                                <li>Faible niveau de maîtrise des nouvelles technologies de l'information dans les régies financières.</li>
                            </ul>
                        </div>
                        <div class="diagnostic-card">
                            <h4><i class="bi bi-diagram-3"></i> Concernant la gouvernance</h4>
                            <ul>
                                <li>Absence d'un Schéma directeur informatique.</li>
                                <li>Absence d'un Plan de Sécurité des Systèmes d'Information.</li>
                                <li>Absence de coordination des projets informatiques au niveau des régies financières et autres services du ministère des finances.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perspectives -->
            <div style="margin-top: 50px;">
                <h3 class="fw-bold" style="color: #101828; margin-bottom: 20px;"><i class="bi bi-rocket-takeoff me-2 text-primary"></i>Perspectives</h3>
                <p style="color: #475467; margin-bottom: 20px;">La chaîne de la recette devra évoluer et réaliser les objectifs suivants :</p>
                <div class="perspectives-list">
                    <div class="perspective-item">
                        <span class="icon"><i class="bi bi-globe-americas"></i></span>
                        <p>Étendre le réseau d'échange des données financières sur toute l'étendue du territoire national.</p>
                    </div>
                    <div class="perspective-item">
                        <span class="icon"><i class="bi bi-database-add"></i></span>
                        <p>Concevoir et mettre en œuvre des projets informatiques d'intégration de toutes les données fiscales et parafiscales afin d'optimiser la collecte des ressources domestiques.</p>
                    </div>
                    <div class="perspective-item">
                        <span class="icon"><i class="bi bi-shield-lock"></i></span>
                        <p>Implémenter des automates de contrôle fiscal, grâce aux analyses croisées, afin de reconstituer le comportement fiscal du contribuable, de rationaliser le contrôle fiscal et de réduire la fraude fiscale.</p>
                    </div>
                    <div class="perspective-item">
                        <span class="icon"><i class="bi bi-people"></i></span>
                        <p>Implémenter une plateforme citoyenne et participative de téléservices en vue de faciliter l'accès aux services publics et d'améliorer le climat des affaires.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="financement" class="about-section pt-0">
    <div class="container">
        <div class="foundation-shell">
            <div class="text-center mb-5">
                <div class="section-kicker"></div>
                <h2 class="section-title mb-0">FINANCEMENTS</h2>
            </div>
            <div class="about-divider-tri"></div>
            <div style="height:50px;"></div>
            <div class="foundation-grid">
                <div class="foundation-card">
                    <div class="foundation-icon"><i class="bi bi-currency-dollar"></i></div>
                    <h3 class="h4 fw-bold">Partenaires financiers</h3>
                    <p class="section-copy mb-0">Le projet Gouvernance Financière bénéficie du soutien de partenaires publics et internationaux, engagés pour la modernisation des régies financières et la transparence de la gestion des recettes.</p>
                </div>
                <div class="foundation-card">
                    <div class="foundation-icon"><i class="bi bi-building-up"></i></div>
                    <h3 class="h4 fw-bold">Sources de financement</h3>
                    <p class="section-copy mb-0">Les financements comprennent des appuis bilatéraux, des aides techniques, ainsi que des contributions internes destinées à l'informatique, aux infrastructures et à la formation des acteurs du projet.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION: NOTRE ÉQUIPE -->
<section id="equipe-projet" class="about-section pt-0">
    <div class="container">
        <div class="foundation-shell">
            <div class="text-center mb-5">
                <div class="section-kicker"></div>
                <h2 class="section-title mb-0">ÉQUIPE PROJET</h2>
            </div>
            <div class="about-divider-tri"></div>
            <div style="height:50px;"></div>
            
            <p style="text-align: center; color: #475467; margin-bottom: 30px;">La chaîne de la recette est mise en place par une équipe d'experts composée de :</p>
            
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-photo"><i class="bi bi-person-circle"></i></div>
                    <div class="team-body">
                        <div class="team-name">Didier BAZANGIKA</div>
                        <div class="team-role">Coordonnateur-Chef de Projet</div>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-photo"><i class="bi bi-person-circle"></i></div>
                    <div class="team-body">
                        <div class="team-name">Papin d'Eve MPENGELE</div>
                        <div class="team-role">Coordonnateur Adjoint</div>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-photo"><i class="bi bi-person-circle"></i></div>
                    <div class="team-body">
                        <div class="team-name">Emmanuelle MULANGA</div>
                        <div class="team-role">Développeuse</div>
                    </div>
                </div>
            </div>

            <!-- Équipe d'appui -->
            <div style="margin-top: 30px; background: #f8fafc; border-radius: 18px; padding: 24px; border: 1px solid #e2e8f0;">
                <p style="color: #2d3748; margin-bottom: 0; text-align: center; line-height: 1.8;">
                    <strong>Ces experts sont appuyés par :</strong> un expert en passation des marchés, un expert-comptable, cinq ingénieurs spécialistes en développement et réseaux, une assistante administrative, un archiviste, une réceptionniste, trois chauffeurs et une technicienne de surface.
                </p>
                <p style="color: #2d3748; margin-top: 12px; text-align: center; line-height: 1.8;">
                    <strong>Un centre d'appel</strong> de six (6) opérateurs permet d'assurer un support de premier niveau aux utilisateurs et bénéficiaires des différents outils et infrastructures mis en œuvre par le projet.
                </p>
            </div>
        </div>
    </div>
</section>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
?>