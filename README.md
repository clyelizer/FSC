# FSC - Formation Suivi Conseil

Site web professionnel pour FSC (Formation Suivi Conseil), une entreprise spécialisée dans la sécurisation numérique, l'optimisation avec l'IA et la formation en ligne.

## 🚀 Fonctionnalités

- **Site vitrine responsive** avec design moderne
- **Sondage interactif** complet (9 parties) pour recueillir les avis des utilisateurs
- **Architecture serverless** avec Cloudflare Functions
- **Base de données D1** gratuite et évolutive
- **Emails automatiques** de confirmation et notifications admin
- **Conversion de devises** automatique selon le pays
- **Validation avancée** des formulaires
- **Animations et interactions** fluides

## 📋 Objectifs de l'entreprise

1. **Conseiller et mettre en place les bonnes pratiques** pour assurer la sécurisation numérique des systèmes
2. **Conseiller et mettre en place des outils d'IA** pour booster la productivité
3. **La vulgarisation des outils d'IA**, de sécurisation des systèmes et d'automatisation des tâches
4. **Formation dans le domaine de l'informatique** 100% en ligne
5. **Accompagnement et suivi** personnalisé

## 🛠️ Technologies utilisées

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: Cloudflare Functions (serverless)
- **Base de données**: Cloudflare D1 (SQLite)
- **Emails**: API externes (SendGrid/Mailgun)
- **Déploiement**: Cloudflare Pages (plan gratuit)
- **Polices**: Inter (Google Fonts)

## 📁 Structure du projet

```
FSC-Website/
├── index.html          # Page d'accueil
├── sondage.html        # Formulaire de sondage
├── merci.html          # Page de remerciement
├── style.css           # Styles CSS principaux
├── script.js           # JavaScript pour l'interactivité
├── survey.js           # JavaScript spécifique au sondage
├── .functions/         # Cloudflare Functions
│   ├── survey.js       # API de traitement du sondage
│   └── create-db.js    # Script de création de la DB
├── database_schema.sql # Schéma SQL pour D1
└── README.md          # Ce fichier
```

## 🚀 Déploiement sur Cloudflare

### 1. Prérequis
- Compte Cloudflare gratuit
- Git (pour le versioning)

### 2. Configuration Cloudflare D1
```bash
# Créer une base de données D1
# Aller dans Cloudflare Dashboard > D1
# Créer une DB nommée "fsc_survey"
```

### 3. Importer le schéma SQL
```sql
-- Copier le contenu de database_schema.sql
-- Coller dans l'éditeur SQL de D1
-- Exécuter la requête
```

### 4. Variables d'environnement
Dans Cloudflare Dashboard > Pages > Paramètres > Variables d'environnement :
```
DB=your-d1-database-id
EMAIL_API_KEY=your-email-api-key
EMAIL_API_URL=https://api.sendgrid.com/v3/mail/send
ADMIN_EMAIL=admin@fsc.com
FROM_EMAIL=contact@fsc.com
```

### 5. Déploiement
```bash
# Pousser sur GitHub/GitLab
git add .
git commit -m "Initial commit"
git push origin main

# Cloudflare détecte automatiquement et déploie
```

## 📊 Sondage détaillé

Le sondage comprend **9 parties** :

1. **Profil** - Informations personnelles et académiques
2. **IA & Data** - Perception et usage de l'IA
3. **Défis** - Problèmes rencontrés et solutions
4. **Formation** - Besoins en compétences et formats préférés
5. **Obstacles** - Barrières à l'apprentissage
6. **Cybersécurité** - Connaissances et pratiques
7. **Carrière** - Avenir professionnel et marché de l'emploi
8. **IA dans l'enseignement** - Impact sur l'éducation
9. **Réflexion finale** - Recommandations et contact

## 🎨 Design

- **Couleurs principales** : Bleu (#2563eb), Vert (#059669), Rouge (#dc2626)
- **Typographie** : Inter (moderne et lisible)
- **Animations** : Subtiles et professionnelles
- **Responsive** : Optimisé pour tous les appareils
- **Accessibilité** : Contraste élevé et navigation clavier

## 📈 Fonctionnalités avancées

- **Validation temps réel** des formulaires
- **Progression visuelle** du sondage
- **Conversion automatique** des devises
- **Emails personnalisés** avec templates HTML
- **Notifications admin** avec résumé des réponses
- **Partage social** intégré
- **Analytics** prêtes pour Google Analytics

## 🔧 Développement local

```bash
# Cloner le repo
git clone https://github.com/your-username/fsc-website.git
cd fsc-website

# Ouvrir dans un serveur local
# Par exemple avec Python :
python -m http.server 8000

# Ou avec Node.js :
npx serve .
```

## 📞 Support

Pour toute question ou problème :
- **Email**: contact@fsc.com
- **Site web**: https://fsc-website.pages.dev
- **Documentation**: Ce README

## 📄 Licence

© 2024 FSC - Formation Suivi Conseil. Tous droits réservés.

---

*Fait avec ❤️ pour FSC - Formation Suivi Conseil*