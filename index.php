<?php
/**
 * Point d'entrée principal du site FSC
 * Affiche directement le contenu HTML pour Cloudflare Pages
 */

// Forcer le type de contenu HTML
header('Content-Type: text/html; charset=UTF-8');

// Inclure le contenu HTML directement
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSC - Formation Suivi Conseil</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">FSC</div>
            <nav class="navbar">
                <ul>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#formation">Formation</a></li>
                    <li><a href="#methodologie">Méthodologie</a></li>
                    <li><a href="pages/sondage.php">Sondage</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section" style="background: linear-gradient(rgba(37, 99, 235, 0.9), rgba(37, 99, 235, 0.8)), url('images/hero-bg.jpg'); background-size: cover; background-position: center;">
        <div class="container">
            <div class="hero-content">
                <h2>FSC - Formation Suivi Conseil</h2>
                <p class="subtitle">Votre partenaire pour la sécurisation numérique, l'optimisation avec l'IA et la formation en ligne</p>
                <div class="cta-group">
                    <a href="#services" class="btn btn-primary">Découvrir nos services</a>
                    <a href="#contact" class="btn btn-secondary">Nous contacter</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Sondage Section -->
    <section class="sondage-highlight-section">
        <div class="container">
            <div class="sondage-highlight">
                <div class="sondage-content">
                    <h2>🗳️ Sondage en Cours</h2>
                    <h3>Faites Évoluer Nos Services</h3>
                    <p>Aidez-nous à adapter nos objectifs pour mieux répondre aux besoins réels des particuliers et entreprises. Votre avis compte !</p>
                    <div class="sondage-stats">
                        <div class="stat">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Participants</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number">15</span>
                            <span class="stat-label">Jours restants</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number">95%</span>
                            <span class="stat-label">Satisfaction</span>
                        </div>
                    </div>
                    <a href="pages/sondage.php" class="btn btn-primary btn-huge">Participer au Sondage</a>
                </div>
                <div class="sondage-visual">
                    <div class="survey-icon">📊</div>
                    <div class="floating-elements">
                        <div class="floating-element">💡</div>
                        <div class="floating-element">🎯</div>
                        <div class="floating-element">📈</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <h2 class="section-title">Nos Services</h2>
            <p class="section-description">Nous accompagnons votre entreprise dans sa transformation digitale</p>
            <div class="service-cards">
                <div class="card">
                    <img src="images/security.jpg" alt="Sécurisation numérique" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0; margin-bottom: 20px;">
                    <h3>Sécurisation Numérique</h3>
                    <p>Conseils et mise en place des meilleures pratiques pour protéger vos systèmes informatiques.</p>
                </div>
                <div class="card">
                    <img src="images/ai.jpg" alt="Intelligence artificielle" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0; margin-bottom: 20px;">
                    <h3>Outils d'IA</h3>
                    <p>Intégration d'outils d'intelligence artificielle pour booster votre productivité.</p>
                </div>
                <div class="card">
                    <img src="images/education.jpg" alt="Formation et vulgarisation" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0; margin-bottom: 20px;">
                    <h3>Vulgarisation des Technologies</h3>
                    <p>Rendre accessibles les outils d'IA, de sécurisation et d'automatisation à tous.</p>
                </div>
                <div class="card">
                    <img src="images/education.jpg" alt="Formation en ligne" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0; margin-bottom: 20px;">
                    <h3>Formation en Ligne</h3>
                    <p>Apprentissage complet dans le domaine informatique, 100% en ligne.</p>
                </div>
                <div class="card">
                    <img src="images/consulting.jpg" alt="Accompagnement et conseil" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0; margin-bottom: 20px;">
                    <h3>Accompagnement</h3>
                    <p>Suivi personnalisé et conseils adaptés à vos besoins.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Formation Section -->
    <section id="formation" class="formation-section">
        <div class="container">
            <div class="content-wrapper">
                <h2 class="section-title">Formation en Informatique</h2>
                <p>Notre formation complète vous permet d'acquérir toutes les compétences nécessaires dans le domaine informatique, entièrement en ligne.</p>
                <ul>
                    <li>Cours interactifs et accessibles 24/7</li>
                    <li>Suivi personnalisé par nos experts</li>
                    <li>Certifications reconnues</li>
                    <li>Communauté d'apprenants active</li>
                </ul>
                <a href="#contact" class="btn btn-primary btn-huge">S'inscrire à la formation</a>
            </div>
        </div>
    </section>

    <!-- Méthodologie Section -->
    <section id="methodologie" class="methodologie-section">
        <div class="container">
            <h2 class="section-title">Notre Méthodologie FSC</h2>
            <p class="section-description">Formation, Suivi, Conseil : une approche complète pour votre réussite</p>
            <div class="steps">
                <div class="step">
                    <h3>Formation</h3>
                    <p>Apprentissage théorique et pratique adapté à vos besoins.</p>
                </div>
                <div class="step">
                    <h3>Suivi</h3>
                    <p>Accompagnement continu pour assurer votre progression.</p>
                </div>
                <div class="step">
                    <h3>Conseil</h3>
                    <p>Conseils stratégiques pour optimiser vos projets.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final Section -->
    <section class="cta-final-section">
        <div class="container">
            <h2>Prêt à transformer votre entreprise ?</h2>
            <p>Contactez-nous dès aujourd'hui pour discuter de vos besoins.</p>
            <a href="#contact" class="btn btn-huge">Commencer maintenant</a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="logo">FSC</div>
                    <p>Formation Suivi Conseil - Votre partenaire digital</p>
                </div>
                <div class="footer-links">
                    <h4>Liens utiles</h4>
                    <ul>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#formation">Formation</a></li>
                        <li><a href="#methodologie">Méthodologie</a></li>
                        <li><a href="pages/sondage.php">Sondage</a></li>
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
<?php
// Fin du fichier PHP
?>