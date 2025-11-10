<?php
// Script pour créer la base de données SQLite et la table des sondages
$db_file = __DIR__ . '/fsc_survey.db';

try {
    // Créer/supprimer la base de données SQLite
    if (file_exists($db_file)) {
        unlink($db_file);
    }

    // Créer la connexion SQLite
    $pdo = new PDO("sqlite:$db_file");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Créer la table des réponses au sondage
    $create_table_sql = "
    CREATE TABLE survey_responses (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        date_soumission DATETIME NOT NULL,

        -- PARTIE 1 : Profil
        prenom TEXT NOT NULL,
        pays TEXT NOT NULL,
        adresse TEXT,
        sexe TEXT NOT NULL,
        domaine TEXT NOT NULL,
        annee TEXT NOT NULL,
        etablissement TEXT NOT NULL,
        experience TEXT NOT NULL,

        -- PARTIE 2 : IA et Data
        cours_ia TEXT NOT NULL,
        explication_ia TEXT,
        usage_ia TEXT NOT NULL,
        usages_ia TEXT,

        -- PARTIE 3 : Défis
        problemes TEXT,
        probleme_principal TEXT,
        processus_repetitifs TEXT,
        processus_automatise TEXT,
        heures_economisees INTEGER,
        quantite_donnees TEXT NOT NULL,

        -- PARTIE 4 : Formation
        competences TEXT,
        duree_formation TEXT,
        format_formation TEXT,
        prix_formation TEXT,
        prix_converti TEXT,

        -- PARTIE 5 : Obstacles
        obstacles TEXT,
        equipements TEXT,
        raisons_pas_solutions TEXT,
        obstacle_principal TEXT,

        -- PARTIE 6 : Cybersécurité
        formation_securite TEXT,
        niveau_securite TEXT,
        pratiques_securite TEXT,
        risques_cyber TEXT,

        -- PARTIE 7 : Avenir Professionnel
        importance_ia_carriere TEXT,
        secteur_souhaite TEXT,
        demande_emploi TEXT,
        competences_importance TEXT,
        preparation_emploi TEXT,
        manque_preparation TEXT,
        entreprises_innovantes TEXT,

        -- PARTIE 8 : IA dans l'enseignement
        ia_cours TEXT,
        ia_ameliore_enseignement TEXT,
        risques_ia_enseignement TEXT,
        risques_details TEXT,

        -- PARTIE 9 : Réflexion finale
        recommandation_education TEXT,
        vision_tech TEXT,
        interets_communaute TEXT,
        email TEXT,

        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    ";

    $pdo->exec($create_table_sql);

    // Créer un index sur la date pour de meilleures performances
    $pdo->exec("CREATE INDEX idx_date_soumission ON survey_responses(date_soumission)");

    echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background: #f0f9ff; border: 1px solid #0ea5e9; border-radius: 8px;'>";
    echo "<h2 style='color: #0ea5e9; margin-bottom: 20px;'>✅ Base de données créée avec succès !</h2>";
    echo "<p style='margin-bottom: 15px;'><strong>Fichier créé :</strong> fsc_survey.db</p>";
    echo "<p style='margin-bottom: 15px;'><strong>Table créée :</strong> survey_responses</p>";
    echo "<p style='margin-bottom: 20px;'><strong>Statut :</strong> Prêt pour les tests</p>";
    echo "<div style='background: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>";
    echo "<h3 style='margin-top: 0; color: #059669;'>Prochaines étapes :</h3>";
    echo "<ol style='margin-bottom: 0;'>";
    echo "<li><a href='sondage.php' style='color: #2563eb;'>Tester le sondage</a></li>";
    echo "<li>Vérifier les données sauvegardées</li>";
    echo "<li>Consulter les statistiques</li>";
    echo "</ol>";
    echo "</div>";
    echo "<p style='color: #6b7280; font-size: 0.9em;'>La base de données SQLite est maintenant opérationnelle et ne nécessite aucune configuration supplémentaire.</p>";
    echo "</div>";

} catch (PDOException $e) {
    echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background: #fef2f2; border: 1px solid #dc2626; border-radius: 8px;'>";
    echo "<h2 style='color: #dc2626; margin-bottom: 20px;'>❌ Erreur lors de la création de la base de données</h2>";
    echo "<p><strong>Erreur :</strong> " . $e->getMessage() . "</p>";
    echo "<p style='margin-top: 15px; color: #6b7280;'>Vérifiez les permissions d'écriture dans le dossier.</p>";
    echo "</div>";
}
?>