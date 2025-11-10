#!/bin/bash

# Script de déploiement FSC - Cloudflare Pages
# Utilisation: ./deploy.sh

echo "🚀 Déploiement FSC sur Cloudflare Pages"
echo "========================================"

# Vérifier si git est initialisé
if [ ! -d ".git" ]; then
    echo "📝 Initialisation du repository Git..."
    git init
    git add .
    git commit -m "Initial commit - Site FSC complet"
fi

# Créer un fichier .gitignore si nécessaire
if [ ! -f ".gitignore" ]; then
    echo "📝 Création du .gitignore..."
    cat > .gitignore << EOF
# Environnement
.env
.env.local
.env.*.local

# Base de données
*.db
*.sqlite
*.sqlite3

# Dépendances
vendor/
node_modules/

# Cache
.cache/
*.log

# OS
.DS_Store
Thumbs.db

# IDE
.vscode/
.idea/
*.swp
*.swo

# Temp files
tmp/
temp/
EOF
fi

# Vérifier les fichiers critiques
echo "🔍 Vérification des fichiers..."

files_to_check=(
    "index.php"
    "main.html"
    "main.css"
    "_headers"
    "_redirects"
    "functions/_middleware.js"
    "pages/sondage.php"
    "pages/process_survey.php"
    "pages/merci.php"
)

for file in "${files_to_check[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file - OK"
    else
        echo "❌ $file - MANQUANT"
        exit 1
    fi
done

# Vérifier la syntaxe PHP
echo "🔍 Vérification de la syntaxe PHP..."
find . -name "*.php" -not -path "./vendor/*" -exec php -l {} \; > /dev/null 2>&1
if [ $? -eq 0 ]; then
    echo "✅ Syntaxe PHP - OK"
else
    echo "❌ Erreurs de syntaxe PHP détectées"
    exit 1
fi




# Commit des changements
echo "📝 Commit des fichiers..."
git add .
git commit -m "Déploiement $(date +'%Y-%m-%d %H:%M:%S')" || true

echo ""
echo "🎯 Prochaines étapes :"
echo "1. Créer un compte Cloudflare (https://dash.cloudflare.com/)"
echo "2. Aller dans 'Pages' > 'Create a project'"
echo "3. Connecter votre repository GitHub/GitLab"
echo "4. Configurer le build :"
echo "   - Build command: (vide)"
echo "   - Build output directory: /"
echo "   - Root directory: /"
echo "5. Activer Cloudflare D1 pour la base de données (optionnel)"
echo "6. Déployer !"
echo ""
echo "📧 N'oubliez pas de configurer vos variables d'environnement dans Cloudflare :"
echo "   - SMTP_USERNAME"
echo "   - SMTP_PASSWORD"
echo "   - ADMIN_EMAIL"
echo ""
echo "✨ Site prêt pour le déploiement !"