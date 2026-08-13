<?php
$title = 'Contact - Ministère des Finances';
$extraHead = <<<'HTML'
<style>
    :root {
        --contact-blue: #1084d2;
        --contact-blue-deep: #006db9;
        --contact-ink: #1d2a3f;
        --contact-muted: #6f7a8a;
        --contact-border: #e6ebf2;
        --contact-surface: #ffffff;
    }

    .contact-page {
        position: relative;
        overflow: hidden;
    }

    .contact-title {
        margin: 0 0 30px;
        text-align: center;
        color: #fff;
        font-size: clamp(2rem, 3.6vw, 3rem);
        line-height: 1;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.01em;
        text-shadow: 0 10px 24px rgba(0, 0, 0, 0.14);
    }

    .contact-accent {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0;
        margin: 18px auto 30px;
        width: 132px;
    }

    .contact-accent span {
        height: 4px;
        display: block;
    }

    .contact-accent .blue {
        width: 56px;
        background: rgba(0, 72, 145, 0.95);
    }

    .contact-accent .yellow {
        width: 42px;
        background: #ffd74a;
    }

    .contact-accent .red {
        width: 34px;
        background: #e31d27;
    }

    .contact-panel {
        background: linear-gradient(180deg, #1187d5 0%, #0772c0 100%);
        padding: 60px 0 60px;
        position: relative;
    }
    
    .contact-panel::before {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.04);
        top: -100px;
        right: -80px;
        pointer-events: none;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.08fr) minmax(320px, 0.92fr);
        gap: 40px;
        align-items: start;
    }

    .contact-form-wrap {
        margin-top: 0;
    }

    .contact-card {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 18px;
        padding: 34px 34px 36px;
        box-shadow: 0 24px 48px rgba(9, 31, 64, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.7);
    }

    .contact-card h3 {
        margin: 0 0 10px;
        color: var(--contact-ink);
        font-size: 1.48rem;
        line-height: 1.15;
        font-weight: 900;
    }

    .contact-card .lead {
        margin: 0 0 28px;
        color: #7f8795;
        font-size: 0.95rem;
        line-height: 1.55;
    }

    .contact-form .row {
        --bs-gutter-x: 18px;
        --bs-gutter-y: 18px;
    }

    .contact-form label {
        display: block;
        margin-bottom: 8px;
        font-size: 0.72rem;
        font-weight: 800;
        color: #506074;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .contact-form .form-control,
    .contact-form .form-select {
        min-height: 44px;
        border-radius: 10px;
        border: 1px solid var(--contact-border);
        background: #fbfcfe;
        color: var(--contact-ink);
        box-shadow: none;
    }

    .contact-form .form-control:focus,
    .contact-form .form-select:focus {
        border-color: rgba(16, 132, 210, 0.55);
        box-shadow: 0 0 0 3px rgba(16, 132, 210, 0.1);
    }

    .contact-form textarea.form-control {
        min-height: 112px;
        resize: none;
        padding-top: 14px;
    }

    .contact-submit {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        border: 0;
        border-radius: 10px;
        padding: 14px 26px;
        font-weight: 800;
        color: #fff;
        background: linear-gradient(135deg, #255ee6 0%, #0d55d7 100%);
        box-shadow: 0 14px 28px rgba(37, 94, 230, 0.28);
    }

    .contact-info {
        padding-top: 6px;
    }

    .contact-info-title {
        margin: 0 0 14px;
        color: #fff;
        font-size: 1.42rem;
        line-height: 1.15;
        font-weight: 900;
    }

    .contact-info-subtitle {
        margin: 0 0 26px;
        max-width: 460px;
        color: rgba(255, 255, 255, 0.86);
        font-size: 0.96rem;
        line-height: 1.58;
    }

    .contact-info-card {
        display: flex;
        gap: 18px;
        align-items: center;
        background: rgba(255, 255, 255, 0.98);
        border-radius: 14px;
        padding: 18px 20px;
        box-shadow: 0 16px 34px rgba(9, 31, 64, 0.15);
        margin-bottom: 18px;
    }

    .contact-info-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #eef4ff;
        color: var(--contact-blue);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 48px;
        font-size: 1.35rem;
    }

    .contact-info-card strong {
        display: block;
        color: var(--contact-ink);
        font-size: 1rem;
        line-height: 1.2;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .contact-info-card p {
        margin: 0;
        color: #667185;
        font-size: 0.92rem;
        line-height: 1.55;
    }

    .contact-map {
        height: 450px;
        background: #eef2f8;
        overflow: hidden;
    }

    .contact-map iframe {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
    }

    @media (max-width: 991.98px) {
        .contact-hero {
            margin-left: 12px;
            margin-right: 12px;
            padding-top: 30px;
            padding-bottom: 24px;
        }

        .contact-grid {
            grid-template-columns: 1fr;
            gap: 26px;
        }

        .contact-form-wrap,
        .contact-info-wrap {
            margin-top: 0;
        }

        .contact-info-subtitle {
            max-width: none;
        }
    }

    @media (max-width: 767.98px) {
        .contact-title {
            font-size: 2rem;
        }

        .contact-panel {
            padding: 28px 0 40px;
        }

        .contact-card {
            padding: 24px 18px;
        }

        .contact-info-card {
            padding: 16px;
        }

        .contact-map {
            height: 320px;
        }
    }
</style>
HTML;

ob_start();
?>

<div class="contact-page">
    <section class="contact-panel">
        <div class="container">
            <h1 class="contact-title" style="margin-bottom: 50px;">NOUS CONTACTER</h1>
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
                        <div class="contact-info-icon"><a href="https://maps.google.com/maps?q=Place+de+la+Révolution,+Gombe,+Kinshasa,+RD+Congo" target="_blank" style="color: var(--contact-blue);"><i class="bi bi-geo-alt-fill"></i></a></div>
                        <div>
                            <strong>Adresse physique</strong>
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
                            <p>contact@finances.gov.cd<br>secretariat@finances.gov.cd</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="contact-map" aria-label="Carte de localisation">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127303.49755480112!2d15.234327464067333!3d-4.321817441164936!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a6a31209f98a761%3A0x69f20e41785f838!2sKinshasa!5e0!3m2!1sen!2scd!4v1710000000000!5m2!1sen!2scd"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Carte de localisation"
            ></iframe>
        </section>
    </section>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
