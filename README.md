# FSC - Formation Suivi Conseil

Site web professionnel pour FSC (Formation Suivi Conseil), entreprise spécialisée dans la sécurisation numérique, l'optimisation avec l'IA et la formation en ligne.

## 🚀 Fonctionnalités

- **Site vitrine responsive** avec design moderne
- **Sondage interactif** en 9 parties pour collecter les besoins des utilisateurs
- **Base de données SQLite** pour le stockage des réponses
- **Conversion automatique des devises** selon le pays
- **Navigation fluide** entre les sections
- **Optimisé pour le déploiement** sur Cloudflare Pages

## 📋 Structure du Projet

```
/
├── main.html              # Page d'accueil
├── main.css               # Styles principaux
├── .htaccess             # Configuration Apache
├── _headers              # Headers de sécurité (Cloudflare)
├── _redirects            # Redirections (Cloudflare)
├── images/               # Images du site
│   ├── hero-bg.jpg
│   ├── security.jpg
│   ├── ai.jpg
│   ├── education.jpg
│   └── consulting.jpg
├── pages/                # Pages secondaires
│   ├── sondage.php       # Formulaire de sondage
│   ├── process_survey.php # Traitement des données
│   ├── create_database.php # Création de la base
│   ├── merci.php         # Page de remerciement
│   ├── sondage.css       # Styles du sondage
│   └── fsc_survey.db     # Base de données SQLite
└── functions/            # Fonctions Cloudflare
    └── _middleware.js    # API serverless
```

## 🛠️ Installation et Configuration

### Développement Local

1. **Cloner le repository**
   ```bash
   git clone <repository-url>
   cd fsc-website
   ```

2. **Démarrer le serveur PHP**
   ```bash
   cd pages
   php -S localhost:3000
   ```

3. **Créer la base de données**
   - Ouvrir `http://localhost:3000/create_database.php`
   - La base SQLite sera créée automatiquement

4. **Tester le sondage**
   - Aller sur `http://localhost:3000/sondage.php`
   - Remplir et soumettre le formulaire

### Déploiement sur Cloudflare Pages

1. **Connecter le repository** à Cloudflare Pages
2. **Configurer le build** :
   - Build command: (vide pour site statique)
   - Build output: `/`
   - Root directory: `/`

3. **Activer Cloudflare D1** (optionnel pour la base de données cloud)
4. **Déployer automatiquement** via Git

## 📊 Sondage - Structure des Données

Le sondage collecte des données en 9 parties :

1. **Profil** : Informations personnelles et académiques
2. **IA & Data** : Perception et usage de l'IA
3. **Défis** : Problèmes rencontrés et automatisation
4. **Formation** : Besoins en compétences et budget
5. **Obstacles** : Freins à l'apprentissage
6. **Cybersécurité** : Connaissances et pratiques
7. **Carrière** : Impact de l'IA sur l'avenir professionnel
8. **IA dans l'enseignement** : Perception des outils pédagogiques
9. **Réflexion finale** : Recommandations et contact

## 🔒 Sécurité

- **Prepared statements** pour éviter les injections SQL
- **Validation côté client** avec JavaScript
- **Headers de sécurité** configurés
- **Protection CSRF** basique
- **Sanitisation des entrées**

## 🎨 Personnalisation

### Couleurs (variables CSS)
```css
:root {
  --primary-color: #2563eb;    /* Bleu professionnel */
  --secondary-color: #059669;  /* Vert émeraude */
  --accent-color: #dc2626;     /* Rouge moderne */
  --text-color: #1f2937;       /* Gris foncé */
}
```

### Images
- Remplacer les images dans `/images/`
- Formats recommandés : JPG/WebP pour les photos, PNG pour les graphiques

## 📈 Fonctionnalités Avancées

- **Conversion de devises** automatique selon le pays
- **Navigation par étapes** dans le sondage
- **Validation en temps réel** des formulaires
- **Stockage persistant** des réponses
- **Interface responsive** pour tous les appareils
- **Animations CSS** modernes

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/nouvelle-fonction`)
3. Commit les changements (`git commit -am 'Ajout nouvelle fonctionnalité'`)
4. Push la branche (`git push origin feature/nouvelle-fonction`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 📞 Contact

**FSC - Formation Suivi Conseil**
- Email: contact@fsc.com
- Site web: [fsc-website.com](https://fsc-website.com)
- Adresse: Casablanca, Maroc

---

*Développé avec ❤️ pour FSC*