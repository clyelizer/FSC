export async function onRequest(context) {
  const { env } = context;

  try {
    // Check if database already exists
    const existingTables = await env.DB.prepare("SELECT name FROM sqlite_master WHERE type='table' AND name='survey_responses'").all();

    if (existingTables.results.length > 0) {
      return new Response(`
        <html>
        <head><title>Base de données FSC</title></head>
        <body style="font-family: Arial, sans-serif; padding: 20px;">
          <h1>⚠️ Base de données déjà créée</h1>
          <p>La table <strong>survey_responses</strong> existe déjà dans la base de données.</p>
          <p>Si vous voulez la recréer, supprimez d'abord la table existante.</p>
          <a href="/" style="color: #2563eb;">Retour à l'accueil</a>
        </body>
        </html>
      `, {
        headers: { 'Content-Type': 'text/html' }
      });
    }

    // Create the survey_responses table
    const createTableSQL = `
      CREATE TABLE survey_responses (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        date_soumission DATETIME NOT NULL,
        prenom TEXT NOT NULL,
        pays TEXT NOT NULL,
        adresse TEXT,
        sexe TEXT NOT NULL,
        domaine TEXT NOT NULL,
        annee TEXT NOT NULL,
        etablissement TEXT NOT NULL,
        experience TEXT NOT NULL,
        cours_ia TEXT NOT NULL,
        explication_ia TEXT,
        usage_ia TEXT NOT NULL,
        usages_ia TEXT,
        problemes TEXT,
        probleme_principal TEXT,
        processus_repetitifs TEXT,
        processus_automatise TEXT,
        heures_economisees INTEGER,
        quantite_donnees TEXT NOT NULL,
        competences TEXT,
        duree_formation TEXT,
        format_formation TEXT,
        prix_formation TEXT,
        prix_converti TEXT,
        obstacles TEXT,
        equipements TEXT,
        raisons_pas_solutions TEXT,
        obstacle_principal TEXT,
        formation_securite TEXT,
        niveau_securite TEXT,
        pratiques_securite TEXT,
        risques_cyber TEXT,
        importance_ia_carriere TEXT,
        secteur_souhaite TEXT,
        demande_emploi TEXT,
        competences_importance TEXT,
        preparation_emploi TEXT,
        manque_preparation TEXT,
        entreprises_innovantes TEXT,
        ia_cours TEXT,
        ia_ameliore_enseignement TEXT,
        risques_ia_enseignement TEXT,
        risques_details TEXT,
        recommandation_education TEXT,
        vision_tech TEXT,
        interets_communaute TEXT,
        email TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
      )
    `;

    await env.DB.prepare(createTableSQL).run();

    // Insert sample data for testing
    const sampleData = {
      date_soumission: new Date().toISOString(),
      prenom: 'Test',
      pays: 'Maroc',
      adresse: 'Casablanca',
      sexe: 'Homme',
      domaine: 'Informatique',
      annee: '3ème année',
      etablissement: 'Université Test',
      experience: '1-2 ans',
      cours_ia: 'Oui',
      explication_ia: 'Intelligence Artificielle',
      usage_ia: 'Oui, régulièrement',
      usages_ia: 'Recherche, Analyse de données',
      problemes: 'Manque de compétences',
      probleme_principal: 'Formation inadéquate',
      processus_repetitifs: 'Saisie de données',
      processus_automatise: '50%',
      heures_economisees: 10,
      quantite_donnees: '100-500 Go',
      competences: 'Python, Machine Learning',
      duree_formation: '3-6 mois',
      format_formation: 'En ligne',
      prix_formation: '5000-10000 MAD',
      prix_converti: '5000-10000 MAD',
      obstacles: 'Coût élevé',
      equipements: 'Ordinateur portable',
      raisons_pas_solutions: 'Prix trop élevé',
      obstacle_principal: 'Coût',
      formation_securite: 'Non',
      niveau_securite: 'Débutant',
      pratiques_securite: 'Mots de passe forts',
      risques_cyber: 'Vol de données',
      importance_ia_carriere: 'Très important',
      secteur_souhaite: 'Tech',
      demande_emploi: 'Élevée',
      competences_importance: 'IA > Data > Cloud',
      preparation_emploi: 'Formation spécialisée',
      manque_preparation: 'Pratique insuffisante',
      entreprises_innovantes: 'Google, Microsoft',
      ia_cours: 'Oui',
      ia_ameliore_enseignement: 'Oui',
      risques_ia_enseignement: 'Désinformation',
      risques_details: 'Contenu généré automatiquement',
      recommandation_education: 'Plus de cours pratiques',
      vision_tech: 'L\'IA transformera tous les secteurs',
      interets_communaute: 'Échanges, Projets collaboratifs',
      email: 'test@fsc.com'
    };

    const insertSQL = `
      INSERT INTO survey_responses (
        date_soumission, prenom, pays, adresse, sexe, domaine, annee, etablissement, experience,
        cours_ia, explication_ia, usage_ia, usages_ia,
        problemes, probleme_principal, processus_repetitifs, processus_automatise, heures_economisees, quantite_donnees,
        competences, duree_formation, format_formation, prix_formation, prix_converti,
        obstacles, equipements, raisons_pas_solutions, obstacle_principal,
        formation_securite, niveau_securite, pratiques_securite, risques_cyber,
        importance_ia_carriere, secteur_souhaite, demande_emploi, competences_importance, preparation_emploi, manque_preparation, entreprises_innovantes,
        ia_cours, ia_ameliore_enseignement, risques_ia_enseignement, risques_details,
        recommandation_education, vision_tech, interets_communaute, email
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    `;

    await env.DB.prepare(insertSQL).bind(
      sampleData.date_soumission, sampleData.prenom, sampleData.pays, sampleData.adresse,
      sampleData.sexe, sampleData.domaine, sampleData.annee, sampleData.etablissement, sampleData.experience,
      sampleData.cours_ia, sampleData.explication_ia, sampleData.usage_ia, sampleData.usages_ia,
      sampleData.problemes, sampleData.probleme_principal, sampleData.processus_repetitifs, sampleData.processus_automatise,
      sampleData.heures_economisees, sampleData.quantite_donnees,
      sampleData.competences, sampleData.duree_formation, sampleData.format_formation, sampleData.prix_formation, sampleData.prix_converti,
      sampleData.obstacles, sampleData.equipements, sampleData.raisons_pas_solutions, sampleData.obstacle_principal,
      sampleData.formation_securite, sampleData.niveau_securite, sampleData.pratiques_securite, sampleData.risques_cyber,
      sampleData.importance_ia_carriere, sampleData.secteur_souhaite, sampleData.demande_emploi, sampleData.competences_importance,
      sampleData.preparation_emploi, sampleData.manque_preparation, sampleData.entreprises_innovantes,
      sampleData.ia_cours, sampleData.ia_ameliore_enseignement, sampleData.risques_ia_enseignement, sampleData.risques_details,
      sampleData.recommandation_education, sampleData.vision_tech, sampleData.interets_communaute, sampleData.email
    ).run();

    return new Response(`
      <html>
      <head><title>Base de données FSC - Créée</title></head>
      <body style="font-family: Arial, sans-serif; padding: 20px;">
        <h1>✅ Base de données créée avec succès !</h1>
        <p>La table <strong>survey_responses</strong> a été créée et remplie avec des données de test.</p>

        <div style="background: #f0f9ff; border: 1px solid #0ea5e9; border-radius: 8px; padding: 15px; margin: 20px 0;">
          <h3>📊 Structure de la table :</h3>
          <ul>
            <li><strong>44 colonnes</strong> pour stocker toutes les réponses du sondage</li>
            <li><strong>Clé primaire automatique</strong> (id)</li>
            <li><strong>Timestamps</strong> pour le suivi des soumissions</li>
            <li><strong>Données de test</strong> insérées pour vérification</li>
          </ul>
        </div>

        <div style="background: #f0fdf4; border: 1px solid #16a34a; border-radius: 8px; padding: 15px; margin: 20px 0;">
          <h3>🎯 Prochaines étapes :</h3>
          <ol>
            <li>Aller sur <a href="/sondage.html">le sondage</a> pour tester la soumission</li>
            <li>Vérifier que les emails sont envoyés (configurer les variables d'environnement)</li>
            <li>Consulter les données dans Cloudflare D1 Dashboard</li>
          </ol>
        </div>

        <a href="/" style="background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px;">Retour à l'accueil</a>
      </body>
      </html>
    `, {
      headers: { 'Content-Type': 'text/html' }
    });

  } catch (error) {
    console.error('Database creation error:', error);

    return new Response(`
      <html>
      <head><title>Erreur - Base de données FSC</title></head>
      <body style="font-family: Arial, sans-serif; padding: 20px;">
        <h1>❌ Erreur lors de la création de la base</h1>
        <p><strong>Erreur :</strong> ${error.message}</p>
        <p>Vérifiez que Cloudflare D1 est correctement configuré dans votre projet.</p>
        <a href="/" style="color: #2563eb;">Retour à l'accueil</a>
      </body>
      </html>
    `, {
      status: 500,
      headers: { 'Content-Type': 'text/html' }
    });
  }
}