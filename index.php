<?php
/**
 * Point d'entrée principal du site FSC
 * Redirige vers la page d'accueil appropriée
 */

// Redirections selon l'environnement
if (isset($_SERVER['HTTP_HOST'])) {
    // Production (Cloudflare) - rediriger vers main.html
    if (strpos($_SERVER['HTTP_HOST'], 'pages.dev') !== false ||
        strpos($_SERVER['HTTP_HOST'], 'cloudflare') !== false) {
        header('Location: /main.html');
        exit;
    }
}

// Développement local - inclure main.html
include 'main.html';
?>