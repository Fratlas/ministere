<?php
$title = 'Contact - Ministère des Finances';
$extraHead = <<<'HTML'
<style>
    :root {
        --contact-blue: #0d8bdc;
        --contact-blue-deep: #005b9f;
        --contact-ink: #1d2a3f;
        --contact-muted: #6f7a8a;
        --contact-border: #e6ebf2;
    }

    .contact-page {
        position: relative;
        overflow: hidden;
        background: #fff;
    }

    .page-no-animations .contact-page,
    .page-no-animations .contact-page *,
    .page-no-animations .navbar,
    .page-no-animations .main-footer,
    .page-no-animations .main-footer * {
        animation: none !important;
        transition: none !important;
    }

    .page-no-animations .contact-title,
    .page-no-animations .contact-title .word,
    .page-no-animations .contact-title .char,
    .page-no-animations .contact-title .line {
        display: inline !important;
        transform: none !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    .page-no-animations .contact-title {
        display: block !important;
        writing-mode: horizontal-tb;
        text-orientation: mixed;
        white-space: normal;
    }

    /* Hero titre — fond bleu pleine largeur */
    .contact-page .contact-hero {
        background: linear-gradient(180deg, #0d8bdc 0%, #0772c0 52%, #006db9 100%);
        padding: 56px 0 0;
        position: relative;
        overflow: hidden;
    }

    .contact-page .contact-hero::before,
    .contact-page .contact-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
        pointer-events: none;
    }

    .contact-page .contact-hero::before {
        width: 280px;
        height: 280px;
        top: -90px;
        right: -70px;
    }

    .contact-page .contact-hero::after {
        width: 180px;
        height: 180px;
        bottom: 40px;
        left: -60px;
    }

    .contact-page .contact-hero .container {
        position: relative;
        z-index: 1;
    }

    .contact-page .contact-title {
        margin: 0;
        text-align: center !important;
        color: #fff;
        font-size: clamp(2.2rem, 4.5vw, 3.4rem);
        line-height: 1.05;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        text-shadow: 0 8px 22px rgba(0, 0, 0, 0.12);
    }

    .contact-page .contact-accent {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 18px auto 0;
        width: 90px;
        height: 4px;
        background: linear-gradient(to right, #0d8bdc 33%, #ffcc00 33%, #ffcc00 66%, #e60000 66%);
    }

    /* Zone formulaire + coordonnées */
    .contact-page .contact-panel {
        background: linear-gradient(180deg, #0772c0 0%, #006db9 100%);
        padding: 42px 0 64px;
        position: relative;
    }

    .contact-page .contact-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.12fr) minmax(300px, 0.88fr);
        gap: clamp(28px, 4vw, 44px);
        align-items: start;
        margin-top: 36px;
    }

    .contact-page .contact-card {
        background: #fff;
        border-radius: 16px;
        padding: 32px 32px 34px;
        box-shadow: 0 22px 44px rgba(9, 31, 64, 0.16);
        border: 0;
        text-align: left !important;
    }

    .contact-page .contact-card h3 {
        margin: 0 0 10px;
        color: var(--contact-ink);
        font-size: 1.45rem;
        line-height: 1.15;
        font-weight: 900;
        text-align: left !important;
    }

    .contact-page .contact-card .lead {
        margin: 0 0 26px;
        color: #7f8795;
        font-size: 0.94rem;
        line-height: 1.55;
        text-align: left !important;
    }

    .contact-page .contact-form label {
        display: block;
        margin-bottom: 8px;
        font-size: 0.72rem;
        font-weight: 800;
        color: #506074;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        text-align: left !important;
    }

    .contact-page .contact-form .row {
        --bs-gutter-x: 16px;
        --bs-gutter-y: 16px;
    }

    .contact-page .contact-form .form-control,
    .contact-page .contact-form .form-select {
        min-height: 46px;
        border-radius: 8px;
        border: 1px solid var(--contact-border);
        background: #fff;
        color: var(--contact-ink);
        box-shadow: none;
        font-size: 0.92rem;
    }

    .contact-page .contact-form .form-control::placeholder {
        color: #a0aab8;
    }

    .contact-page .contact-form .form-control:focus,
    .contact-page .contact-form .form-select:focus {
        border-color: rgba(13, 139, 220, 0.55);
        box-shadow: 0 0 0 3px rgba(13, 139, 220, 0.12);
    }

    .contact-page .contact-form textarea.form-control {
        min-height: 120px;
        resize: vertical;
        padding-top: 12px;
    }

    .contact-page .contact-submit {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 8px;
        border: 0;
        border-radius: 10px;
        padding: 13px 24px;
        font-size: 0.92rem;
        font-weight: 800;
        color: #fff;
        background: linear-gradient(135deg, #0d8bdc 0%, #006db9 100%);
        box-shadow: 0 12px 24px rgba(13, 139, 220, 0.28);
        cursor: pointer;
    }

    .contact-page .contact-submit:hover {
        background: linear-gradient(135deg, #0a7ec8 0%, #005fa8 100%);
        color: #fff;
    }

    .contact-page .contact-info {
        padding-top: 4px;
        text-align: left !important;
    }

    .contact-page .contact-info-title {
        margin: 0 0 12px;
        color: #fff;
        font-size: 1.42rem;
        line-height: 1.15;
        font-weight: 900;
        text-align: left !important;
    }

    .contact-page .contact-info-subtitle {
        margin: 0 0 24px;
        max-width: 420px;
        color: rgba(255, 255, 255, 0.88);
        font-size: 0.95rem;
        line-height: 1.58;
        text-align: left !important;
    }

    .contact-page .contact-info-card {
        display: flex;
        gap: 16px;
        align-items: center;
        background: #fff;
        border-radius: 14px;
        padding: 18px 20px;
        box-shadow: 0 14px 30px rgba(9, 31, 64, 0.14);
        margin-bottom: 16px;
        text-align: left !important;
    }

    .contact-page .contact-info-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: #eef6fd;
        color: var(--contact-blue);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 46px;
        font-size: 1.25rem;
    }

    .contact-page .contact-info-icon a {
        color: var(--contact-blue);
        text-decoration: none;
        display: inline-flex;
    }

    .contact-page .contact-info-card strong {
        display: block;
        color: var(--contact-ink);
        font-size: 0.98rem;
        line-height: 1.2;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .contact-page .contact-info-card p {
        margin: 0;
        color: #667185;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .contact-page .contact-map {
        width: 100%;
        height: 420px;
        background: #eef2f8;
        overflow: hidden;
        margin: 0;
        padding: 0;
    }

    .contact-page .contact-map iframe {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
        filter: grayscale(8%);
    }

    @media (max-width: 991.98px) {
        .contact-page .contact-grid {
            grid-template-columns: 1fr;
            gap: 28px;
            margin-top: 28px;
        }

        .contact-page .contact-info-subtitle {
            max-width: none;
        }

        .contact-page .contact-hero {
            padding-top: 44px;
        }

        .contact-page .contact-panel {
            padding-bottom: 48px;
        }
    }

    @media (max-width: 767.98px) {
        .contact-page .contact-title {
            font-size: 2rem;
        }

        .contact-page .contact-panel {
            padding: 28px 0 40px;
        }

        .contact-page .contact-card {
            padding: 24px 20px;
        }

        .contact-page .contact-info-card {
            padding: 16px;
        }

        .contact-page .contact-map {
            height: 300px;
        }
    }
</style>
HTML;

ob_start();
?>

<div class="contact-page">
    <section class="contact-hero">
        <div class="container">
            <h1 class="contact-title">NOUS CONTACTER</h1>
            <div class="contact-accent" aria-hidden="true"></div>
        </div>
    </section>

    <section class="contact-panel">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-card contact-form-wrap">
                    <h3>Envoyez un message</h3>
                    <p class="lead">Remplissez le formulaire ci-dessous et nos services vous répondront dans les plus brefs délais.</p>

                    <form class="contact-form" action="#" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="contact-name">Nom complet</label>
                                <input id="contact-name" type="text" name="name" class="form-control" placeholder="Ex: Jean Kasongo">
                            </div>
                            <div class="col-md-6">
                                <label for="contact-email">Adresse Email</label>
                                <input id="contact-email" type="email" name="email" class="form-control" placeholder="nom@exemple.cd">
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="contact-subject">Sujet</label>
                            <select id="contact-subject" name="subject" class="form-select">
                                <option>Demande d'information générale</option>
                                <option>Suivi de dossier</option>
                                <option>Réclamation</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="contact-message">Message</label>
                            <textarea id="contact-message" name="message" class="form-control" placeholder="Comment pouvons-nous vous aider ?"></textarea>
                        </div>

                        <button type="submit" class="contact-submit">
                            Envoyer le message <i class="bi bi-send"></i>
                        </button>
                    </form>
                </div>

                <div class="contact-info contact-info-wrap">
                    <h2 class="contact-info-title">Nos Coordonnées</h2>
                    <p class="contact-info-subtitle">
                        Vous pouvez également nous joindre directement via nos canaux officiels ou nous rendre visite à nos bureaux administratifs.
                    </p>

                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <a href="https://maps.google.com/maps?q=Place+de+la+Révolution,+Gombe,+Kinshasa,+RD+Congo" target="_blank" rel="noopener noreferrer" aria-label="Voir sur la carte">
                                <i class="bi bi-geo-alt-fill"></i>
                            </a>
                        </div>
                        <div>
                            <strong>Siège Social</strong>
                            <p>Place de la Révolution, Gombe<br>Kinshasa, RD Congo</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <strong>Téléphones</strong>
                            <p>+243 81 000 0000<br>+243 99 123 4567</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <strong>Emails officiels</strong>
                            <p>contact@finances.gouv.cd<br>secretariat@finances.gouv.cd</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-map" aria-label="Carte de localisation">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3978.352!2d15.3125!3d-4.3217!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a6a31209f98a761%3A0x69f20e41785f838!2sPlace%20de%20la%20R%C3%A9volution%2C%20Kinshasa!5e0!3m2!1sfr!2scd!4v1710000000000!5m2!1sfr!2scd"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Carte — Place de la Révolution, Kinshasa"
        ></iframe>
    </section>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
