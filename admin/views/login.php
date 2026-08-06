<?php
$pageTitle = 'Admin - Ministère des Finances';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --blue: #0d8bdc;
            --blue-dark: #084b92;
            --navy: #071a33;
            --text: #0f172a;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 15% 15%, rgba(255,255,255,0.18), transparent 22%),
                radial-gradient(circle at 85% 20%, rgba(13,139,220,0.25), transparent 18%),
                linear-gradient(135deg, rgba(7, 26, 51, 0.82), rgba(13, 139, 220, 0.60)),
                url('/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png') center/cover no-repeat fixed;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(255,255,255,0.18), transparent 16%),
                radial-gradient(circle at 75% 78%, rgba(255,205,0,0.14), transparent 14%);
            pointer-events: none;
        }

        .admin-login-page {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            padding: 28px;
        }

        .admin-login-page::before,
        .admin-login-page::after {
            content: "";
            position: fixed;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            filter: blur(10px);
            pointer-events: none;
            opacity: 0.35;
        }

        .admin-login-page::before {
            top: -140px;
            right: -120px;
            background: rgba(255, 255, 255, 0.12);
        }

        .admin-login-page::after {
            left: -160px;
            bottom: -160px;
            background: rgba(13, 139, 220, 0.20);
        }

        .admin-auth-shell {
            width: min(1240px, 100%);
            margin: auto;
            position: relative;
            z-index: 1;
        }

        .admin-auth-card {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            min-height: 760px;
            border-radius: 34px;
            overflow: hidden;
            box-shadow: 0 30px 100px rgba(0, 0, 0, 0.28);
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.16);
        }

        .admin-auth-visual {
            position: relative;
            padding: 44px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background:
                linear-gradient(135deg, rgba(4, 18, 40, 0.36), rgba(13, 139, 220, 0.55)),
                url('/public/images/d6aa7c59153499f8c21f31ede2d928d8e0f9d23a.png') center/cover no-repeat;
        }

        .admin-auth-visual::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(7, 26, 51, 0.10), rgba(7, 26, 51, 0.42));
            pointer-events: none;
        }

        .visual-top,
        .visual-bottom {
            position: relative;
            z-index: 1;
        }

        .brand-line {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 30px;
        }

        .brand-line img {
            width: 78px;
            height: 78px;
            object-fit: contain;
            filter: brightness(0) invert(1);
            background: rgba(255,255,255,0.10);
            border-radius: 18px;
            padding: 10px;
            backdrop-filter: blur(12px);
        }

        .brand-copy small {
            display: block;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            opacity: 0.8;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .brand-copy h1 {
            margin: 0;
            font-size: 1.7rem;
            line-height: 1.05;
            font-weight: 900;
        }

        .hero-copy {
            max-width: 520px;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.12);
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .hero-copy h2 {
            font-size: clamp(2.4rem, 4vw, 4.6rem);
            line-height: 0.96;
            font-weight: 900;
            margin: 0 0 18px;
            text-wrap: balance;
        }

        .hero-copy p {
            max-width: 560px;
            font-size: 1.05rem;
            line-height: 1.8;
            color: rgba(255,255,255,0.88);
            margin-bottom: 26px;
        }

        .hero-bars {
            display: flex;
            gap: 0;
            width: 140px;
            height: 6px;
            border-radius: 999px;
            overflow: hidden;
            box-shadow: 0 0 0 1px rgba(255,255,255,0.16);
        }

        .hero-bars span:nth-child(1) { flex: 1; background: #1f8cff; }
        .hero-bars span:nth-child(2) { flex: 1; background: #ffd400; }
        .hero-bars span:nth-child(3) { flex: 1; background: #ff1e1e; }
        .hero-bars span:nth-child(4) { flex: 1; background: #061a33; }

        .visual-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 28px;
        }

        .visual-stat {
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 20px;
            padding: 16px 18px;
            backdrop-filter: blur(14px);
        }

        .visual-stat strong {
            display: block;
            font-size: 1.1rem;
            margin-bottom: 4px;
        }

        .visual-stat span {
            display: block;
            font-size: 0.84rem;
            color: rgba(255,255,255,0.78);
            line-height: 1.5;
        }

        .login-panel {
            background: rgba(255,255,255,0.94);
            padding: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            background: rgba(255,255,255,0.82);
            border: 1px solid rgba(13, 139, 220, 0.12);
            border-radius: 28px;
            box-shadow: 0 22px 70px rgba(8, 45, 90, 0.16);
            padding: 34px;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: "";
            position: absolute;
            inset: auto -80px -80px auto;
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, rgba(13,139,220,0.18), transparent 68%);
            pointer-events: none;
        }

        .login-header {
            margin-bottom: 28px;
        }

        .login-header .eyebrow {
            color: var(--blue);
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            font-size: 0.74rem;
            margin-bottom: 10px;
        }

        .login-header h3 {
            margin: 0 0 10px;
            font-size: 2rem;
            font-weight: 900;
            color: #0b2f5e;
        }

        .login-header p {
            margin: 0;
            color: #5b6473;
            line-height: 1.7;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            font-size: 0.92rem;
            color: #1e293b;
        }

        .form-group input {
            width: 100%;
            border: 1px solid #d7e0ea;
            background: #fff;
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 0.98rem;
            outline: none;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
        }

        .form-group input:focus {
            border-color: rgba(13,139,220,0.60);
            box-shadow: 0 0 0 4px rgba(13,139,220,0.12);
            transform: translateY(-1px);
        }

        .btn-login {
            width: 100%;
            border: 0;
            border-radius: 16px;
            padding: 14px 18px;
            background: linear-gradient(135deg, #0d8bdc, #0a5fb3);
            color: #fff;
            font-weight: 800;
            font-size: 1rem;
            box-shadow: 0 16px 30px rgba(13, 139, 220, 0.22);
            transition: transform 0.25s ease, box-shadow 0.25s ease, filter 0.25s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 36px rgba(13, 139, 220, 0.28);
            filter: brightness(1.03);
        }

        .error {
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 16px;
            background: #fff1f2;
            color: #b42318;
            border: 1px solid rgba(180, 35, 24, 0.16);
            padding: 14px 16px;
            margin-bottom: 18px;
            font-weight: 600;
        }

        .info-text {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid rgba(148, 163, 184, 0.22);
            color: #475569;
            font-size: 0.9rem;
        }

        .info-text p {
            margin-bottom: 8px;
        }

        .info-text code {
            color: #0d8bdc;
            font-weight: 700;
        }

        .login-footer-note {
            margin-top: 16px;
            font-size: 0.8rem;
            color: #6b7280;
        }

        .login-footer-note a {
            color: #0d8bdc;
            text-decoration: none;
            font-weight: 700;
        }

        @media (max-width: 991.98px) {
            .admin-login-page {
                padding: 16px;
            }

            .admin-auth-card {
                grid-template-columns: 1fr;
            }

            .admin-auth-visual {
                min-height: 420px;
                padding: 28px;
            }

            .login-panel {
                padding: 22px;
            }

            .login-card {
                padding: 26px;
            }

            .visual-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <main class="admin-login-page">
        <div class="admin-auth-shell">
            <div class="admin-auth-card">
                <section class="admin-auth-visual">
                    <div class="visual-top">
                        <div class="brand-line">
                            <img src="/public/images/logo.webp" alt="Ministère des Finances">
                            <div class="brand-copy">
                                <small>République Démocratique du Congo</small>
                                <h1>Ministère des Finances</h1>
                            </div>
                        </div>

                        <div class="hero-copy">
                            <div class="hero-kicker">
                                <i class="bi bi-shield-lock-fill"></i>
                                Accès sécurisé
                            </div>
                            <h2>Un espace admin moderne pour piloter les contenus.</h2>
                            <p>
                                Gérez les projets, les réalisations, les documents et les articles dans un tableau de bord fluide,
                                lisible et pensé pour le quotidien de l’équipe.
                            </p>
                            <div class="hero-bars" aria-hidden="true">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>

                    <div class="visual-bottom">
                        <div class="visual-stats">
                            <div class="visual-stat">
                                <strong><i class="bi bi-lightning-charge-fill"></i> Rapide</strong>
                                <span>Connexion claire et accès direct aux contenus.</span>
                            </div>
                            <div class="visual-stat">
                                <strong><i class="bi bi-phone-fill"></i> Responsive</strong>
                                <span>Interface lisible aussi sur tablette et mobile.</span>
                            </div>
                            <div class="visual-stat">
                                <strong><i class="bi bi-palette-fill"></i> Élégant</strong>
                                <span>Cartes glassmorphism et fond image dynamique.</span>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="login-panel">
                    <div class="login-card">
                        <div class="login-header">
                            <div class="eyebrow">Connexion</div>
                            <h3>Panel Admin</h3>
                            <p>Connectez-vous pour administrer le site du Ministère des Finances.</p>
                        </div>

                        <?php if (!empty($error)): ?>
                            <div class="error">
                                <i class="bi bi-exclamation-circle"></i>
                                <span><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username">Nom d'utilisateur</label>
                                <input type="text" id="username" name="username" required autofocus autocomplete="username" placeholder="admin">
                            </div>

                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                            </div>

                            <button type="submit" class="btn-login">
                                Se connecter
                            </button>
                        </form>

                        <div class="info-text">
                            <p><strong>Accès de test :</strong></p>
                            <p>Utilisateur: <code>admin</code></p>
                            <p>Mot de passe: <code>admin123</code></p>
                        </div>

                        <div class="login-footer-note">
                            Besoin d'aide ? Vérifiez la base de données ou revenez à la page publique du site.
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
