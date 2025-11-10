<?php
// Configuration de la base de données SQLite
$db_file = __DIR__ . '/fsc_survey.db';

try {
    // Créer la connexion SQLite
    $pdo = new PDO("sqlite:$db_file");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Fonction pour convertir les prix selon le pays
function convertCurrency($amount_range, $country) {
    $conversions = [
        'Maroc' => ['MAD', 1], // Base: MAD
        'Algérie' => ['DZD', 13.5],
        'Tunisie' => ['TND', 0.32],
        'France' => ['EUR', 0.088],
        'Canada' => ['CAD', 0.12],
        'Belgique' => ['EUR', 0.088],
        'Suisse' => ['CHF', 0.094],
        'Espagne' => ['EUR', 0.088],
        'Italie' => ['EUR', 0.088],
        'Portugal' => ['EUR', 0.088],
        'États-Unis' => ['USD', 0.099],
        'Royaume-Uni' => ['GBP', 0.077],
        'Allemagne' => ['EUR', 0.088]
    ];

    if (!isset($conversions[$country])) {
        return $amount_range . " MAD"; // Défaut Maroc
    }

    list($currency, $rate) = $conversions[$country];

    // Parser la plage de prix
    if (strpos($amount_range, '-') !== false) {
        list($min, $max) = explode('-', $amount_range);
        $min_converted = intval($min) * $rate;
        $max_converted = intval($max) * $rate;
        return number_format($min_converted, 0) . " - " . number_format($max_converted, 0) . " " . $currency;
    } elseif (strpos($amount_range, '+') !== false) {
        $amount = intval(str_replace('+', '', $amount_range));
        $converted = $amount * $rate;
        return number_format($converted, 0) . "+ " . $currency;
    }

    return $amount_range . " " . $currency;
}

// Récupérer les données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // PARTIE 1
    $prenom = $_POST['prenom'] ?? '';
    $pays = $_POST['pays'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $sexe = $_POST['sexe'] ?? '';
    $domaine = $_POST['domaine'] ?? '';
    $annee = $_POST['annee'] ?? '';
    $etablissement = $_POST['etablissement'] ?? '';
    $experience = $_POST['experience'] ?? '';

    // PARTIE 2
    $cours_ia = $_POST['cours_ia'] ?? '';
    $explication_ia = $_POST['explication_ia'] ?? '';
    $usage_ia = $_POST['usage_ia'] ?? '';
    $usages_ia = isset($_POST['usages_ia']) ? implode(', ', $_POST['usages_ia']) : '';

    // PARTIE 3
    $problemes = isset($_POST['problemes']) ? implode(', ', $_POST['problemes']) : '';
    $probleme_principal = $_POST['probleme_principal'] ?? '';
    $processus_repetitifs = isset($_POST['processus_repetitifs']) ? implode(', ', $_POST['processus_repetitifs']) : '';
    $processus_automatise = $_POST['processus_automatise'] ?? '';
    $heures_economisees = $_POST['heures_economisees'] ?? '';
    $quantite_donnees = $_POST['quantite_donnees'] ?? '';

    // PARTIE 4
    $competences = isset($_POST['competences']) ? implode(', ', $_POST['competences']) : '';
    $duree_formation = $_POST['duree_formation'] ?? '';
    $format_formation = $_POST['format_formation'] ?? '';
    $prix_formation = $_POST['prix_formation'] ?? '';

    // Convertir le prix selon le pays
    $prix_converti = convertCurrency($prix_formation, $pays);

    // PARTIE 5
    $obstacles = isset($_POST['obstacles']) ? implode(', ', $_POST['obstacles']) : '';
    $equipements = $_POST['equipements'] ?? '';
    $raisons_pas_solutions = isset($_POST['raisons_pas_solutions']) ? implode(', ', $_POST['raisons_pas_solutions']) : '';
    $obstacle_principal = $_POST['obstacle_principal'] ?? '';

    // PARTIE 6
    $formation_securite = $_POST['formation_securite'] ?? '';
    $niveau_securite = $_POST['niveau_securite'] ?? '';
    $pratiques_securite = $_POST['pratiques_securite'] ?? '';
    $risques_cyber = $_POST['risques_cyber'] ?? '';

    // PARTIE 7
    $importance_ia_carriere = $_POST['importance_ia_carriere'] ?? '';
    $secteur_souhaite = $_POST['secteur_souhaite'] ?? '';
    $demande_emploi = $_POST['demande_emploi'] ?? '';
    $competences_importance = isset($_POST['competences_importance']) ? implode(' > ', $_POST['competences_importance']) : '';
    $preparation_emploi = $_POST['preparation_emploi'] ?? '';
    $manque_preparation = $_POST['manque_preparation'] ?? '';
    $entreprises_innovantes = $_POST['entreprises_innovantes'] ?? '';

    // PARTIE 8
    $ia_cours = $_POST['ia_cours'] ?? '';
    $ia_ameliore_enseignement = $_POST['ia_ameliore_enseignement'] ?? '';
    $risques_ia_enseignement = $_POST['risques_ia_enseignement'] ?? '';
    $risques_details = $_POST['risques_details'] ?? '';

    // PARTIE 9
    $recommandation_education = $_POST['recommandation_education'] ?? '';
    $vision_tech = $_POST['vision_tech'] ?? '';
    $interets_communaute = isset($_POST['interets_communaute']) ? implode(', ', $_POST['interets_communaute']) : '';
    $email = $_POST['email'] ?? '';

    // Date de soumission
    $date_soumission = date('Y-m-d H:i:s');

    // Préparer la requête SQL
    $sql = "INSERT INTO survey_responses (
        date_soumission, prenom, pays, adresse, sexe, domaine, annee, etablissement, experience,
        cours_ia, explication_ia, usage_ia, usages_ia,
        problemes, probleme_principal, processus_repetitifs, processus_automatise, heures_economisees, quantite_donnees,
        competences, duree_formation, format_formation, prix_formation, prix_converti,
        obstacles, equipements, raisons_pas_solutions, obstacle_principal,
        formation_securite, niveau_securite, pratiques_securite, risques_cyber,
        importance_ia_carriere, secteur_souhaite, demande_emploi, competences_importance, preparation_emploi, manque_preparation, entreprises_innovantes,
        ia_cours, ia_ameliore_enseignement, risques_ia_enseignement, risques_details,
        recommandation_education, vision_tech, interets_communaute, email
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?,
        ?, ?, ?, ?,
        ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?,
        ?, ?, ?, ?
    )";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $date_soumission, $prenom, $pays, $adresse, $sexe, $domaine, $annee, $etablissement, $experience,
            $cours_ia, $explication_ia, $usage_ia, $usages_ia,
            $problemes, $probleme_principal, $processus_repetitifs, $processus_automatise, $heures_economisees, $quantite_donnees,
            $competences, $duree_formation, $format_formation, $prix_formation, $prix_converti,
            $obstacles, $equipements, $raisons_pas_solutions, $obstacle_principal,
            $formation_securite, $niveau_securite, $pratiques_securite, $risques_cyber,
            $importance_ia_carriere, $secteur_souhaite, $demande_emploi, $competences_importance, $preparation_emploi, $manque_preparation, $entreprises_innovantes,
            $ia_cours, $ia_ameliore_enseignement, $risques_ia_enseignement, $risques_details,
            $recommandation_education, $vision_tech, $interets_communaute, $email
        ]);

        // Envoyer l'email de remerciement
        if (!empty($email) && !empty($prenom)) {
            include_once __DIR__ . '/../includes/mail.php';
            sendThankYouEmail($email, $prenom);

            // Notification à l'admin
            $surveyData = [
                'prenom' => $prenom,
                'pays' => $pays,
                'email' => $email,
                'domaine' => $domaine,
                'annee' => $annee,
                'usage_ia' => $usage_ia,
                'format_formation' => $format_formation,
                'prix_formation' => $prix_formation,
                'prix_converti' => $prix_converti
            ];
            sendAdminNotification($surveyData);
        }

        // Redirection vers une page de remerciement
        header("Location: merci.php?success=1&email=" . urlencode($email));
        exit();

    } catch (PDOException $e) {
        // Redirection avec message d'erreur
        header("Location: sondage.php?error=database&message=" . urlencode($e->getMessage()));
        exit();
    }
}
?>