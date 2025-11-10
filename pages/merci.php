<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci - FSC</title>
    <link rel="stylesheet" href="sondage.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">FSC</div>
            <nav class="navbar">
                <ul>
                    <li><a href="../main.html#services">Services</a></li>
                    <li><a href="../main.html#formation">Formation</a></li>
                    <li><a href="../main.html#methodologie">Méthodologie</a></li>
                    <li><a href="sondage.php">Sondage</a></li>
                    <li><a href="../main.html#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Merci Section -->
    <section class="merci-section">
        <div class="container">
            <div class="merci-content">
                <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
                    <div class="success-icon">✅</div>
                    <h1 class="section-title">Merci pour votre participation ! 🎉</h1>
                    <p class="merci-message">
                        Votre réponse a été enregistrée avec succès. Vos insights sont précieux pour nous aider à améliorer nos services et mieux répondre aux besoins des étudiants et professionnels.
                    </p>

                    <?php if (isset($_GET['email']) && !empty($_GET['email'])): ?>
                    <div class="email-confirmation" style="background: #f0f9ff; border: 1px solid #0ea5e9; border-radius: 8px; padding: 20px; margin: 20px 0; text-align: center;">
                        <div style="font-size: 2em; margin-bottom: 10px;">📧</div>
                        <h3 style="color: #0ea5e9; margin-bottom: 10px;">Email de confirmation envoyé !</h3>
                        <p style="color: #374151; margin: 0;">Un email de remerciement a été envoyé à <strong><?php echo htmlspecialchars($_GET['email']); ?></strong></p>
                        <p style="color: #6b7280; font-size: 0.9em; margin: 10px 0 0 0;">Vérifiez votre boîte de réception (et vos spams)</p>
                    </div>
                    <?php endif; ?>

                    <div class="next-steps" style="background: white; border-radius: 12px; padding: 25px; margin: 20px 0; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                        <h3 style="color: #1f2937; margin-bottom: 15px;">Que se passe-t-il maintenant ?</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                            <div style="text-align: center; padding: 15px; background: #f8fafc; border-radius: 8px;">
                                <div style="font-size: 1.5em; margin-bottom: 8px;">📊</div>
                                <h4 style="margin: 0 0 5px 0; color: #2563eb;">Analyse des données</h4>
                                <p style="margin: 0; font-size: 0.9em; color: #6b7280;">Nous analysons vos réponses avec celles des autres participants</p>
                            </div>
                            <div style="text-align: center; padding: 15px; background: #f8fafc; border-radius: 8px;">
                                <div style="font-size: 1.5em; margin-bottom: 8px;">📈</div>
                                <h4 style="margin: 0 0 5px 0; color: #059669;">Résultats</h4>
                                <p style="margin: 0; font-size: 0.9em; color: #6b7280;">Publication des insights et tendances identifiées</p>
                            </div>
                            <div style="text-align: center; padding: 15px; background: #f8fafc; border-radius: 8px;">
                                <div style="font-size: 1.5em; margin-bottom: 8px;">🎓</div>
                                <h4 style="margin: 0 0 5px 0; color: #dc2626;">Adaptation</h4>
                                <p style="margin: 0; font-size: 0.9em; color: #6b7280;">Création de formations répondant à vos besoins réels</p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="success-icon" style="color: #dc2626;">⚠️</div>
                    <h1 class="section-title">Une erreur s'est produite</h1>
                    <p class="merci-message">
                        Désolé, une erreur s'est produite lors de l'enregistrement de votre réponse. Veuillez réessayer ou nous contacter directement.
                    </p>
                <?php endif; ?>

                <div class="merci-actions">
                    <a href="../main.html" class="btn btn-primary">Retour à l'accueil</a>
                    <a href="sondage.php" class="btn btn-secondary">Voir d'autres enquêtes</a>
                </div>

                <div class="merci-stats">
                    <h3>Quelques statistiques de notre communauté :</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Participants actifs</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">15</span>
                            <span class="stat-label">Pays représentés</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">95%</span>
                            <span class="stat-label">Satisfaction générale</span>
                        </div>
                    </div>
                </div>

                <div class="merci-community">
                    <h3>Rejoignez notre communauté !</h3>
                    <p>Restez informé des dernières évolutions et participez à de futurs projets.</p>
                    <div class="community-actions">
                        <a href="#" class="btn btn-primary">S'inscrire à la newsletter</a>
                        <a href="#" class="btn btn-secondary">Rejoindre Discord</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="logo">FSC</div>
                    <p>Formation Suivi Conseil - Votre partenaire digital</p>
                </div>
                <div class="footer-links">
                    <h4>Liens utiles</h4>
                    <ul>
                        <li><a href="../main.html#services">Services</a></li>
                        <li><a href="../main.html#formation">Formation</a></li>
                        <li><a href="../main.html#methodologie">Méthodologie</a></li>
                        <li><a href="sondage.php">Sondage</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Contact</h4>
                    <p>Email: contact@fsc.com</p>
                    <p>Téléphone: +212 6 XX XX XX XX</p>
                    <p>Adresse: Casablanca, Maroc</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>