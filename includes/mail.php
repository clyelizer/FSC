<?php
/**
 * Fonction utilitaire pour envoyer des emails via PHPMailer
 *
 * @param string $destinataire Email du destinataire
 * @param string $sujet Sujet du mail
 * @param string $message Corps du message (HTML)
 * @param string $messageTexte Version texte brut (optionnel)
 * @return bool True si envoyé avec succès, false sinon
 */
function sendMail($destinataire, $sujet, $message, $messageTexte = '') {
    try {
        // Charger les variables d'environnement
        if (file_exists(__DIR__ . '/../.env')) {
            $env = parse_ini_file(__DIR__ . '/../.env');
        } else {
            throw new Exception('Fichier .env non trouvé');
        }

        // Vérifier si PHPMailer est installé
        if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
            throw new Exception('PHPMailer n\'est pas installé. Exécutez: composer require phpmailer/phpmailer');
        }

        require_once __DIR__ . '/../vendor/autoload.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = $env['SMTP_HOST'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $env['SMTP_USERNAME'] ?? '';
        $mail->Password = $env['SMTP_PASSWORD'] ?? '';
        $mail->SMTPSecure = $env['SMTP_SECURE'] ?? 'tls';
        $mail->Port = $env['SMTP_PORT'] ?? 587;

        // Timeout pour éviter les blocages
        $mail->Timeout = 30;

        // Destinataire et expéditeur
        $mail->setFrom($env['FROM_EMAIL'] ?? 'contact@fsc.com', $env['FROM_NAME'] ?? 'FSC');
        $mail->addAddress($destinataire);

        // Copie à l'admin si configuré
        if (!empty($env['ADMIN_EMAIL'])) {
            $mail->addBCC($env['ADMIN_EMAIL']);
        }

        // Contenu du mail
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $sujet;
        $mail->Body = $message;

        // Version texte si fournie
        if (!empty($messageTexte)) {
            $mail->AltBody = $messageTexte;
        } else {
            // Générer automatiquement une version texte
            $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n\n"], $message));
        }

        // Envoyer le mail
        $result = $mail->send();

        // Log en mode développement
        if (($env['APP_ENV'] ?? 'production') === 'development') {
            error_log("Email envoyé à $destinataire - Sujet: $sujet");
        }

        return $result;

    } catch (PHPMailer\PHPMailer\Exception $e) {
        error_log("Erreur PHPMailer: " . $mail->ErrorInfo);
        return false;
    } catch (Exception $e) {
        error_log("Erreur générale email: " . $e->getMessage());
        return false;
    }
}

/**
 * Fonction pour envoyer un email de remerciement après soumission du sondage
 *
 * @param string $email Email du participant
 * @param string $prenom Prénom du participant
 * @return bool
 */
function sendThankYouEmail($email, $prenom) {
    $sujet = "Merci pour votre participation au sondage FSC !";

    $message = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
        <div style='background: linear-gradient(135deg, #2563eb, #059669); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0;'>
            <h1 style='margin: 0; font-size: 24px;'>FSC - Formation Suivi Conseil</h1>
            <p style='margin: 10px 0 0 0; opacity: 0.9;'>Merci pour votre contribution !</p>
        </div>

        <div style='background: white; padding: 30px; border: 1px solid #e5e7eb; border-radius: 0 0 10px 10px;'>
            <h2 style='color: #1f2937; margin-bottom: 20px;'>Cher(e) {$prenom},</h2>

            <p style='color: #4b5563; line-height: 1.6; margin-bottom: 20px;'>
                Nous vous remercions chaleureusement d'avoir pris le temps de répondre à notre enquête complète sur les technologies, l'IA et les besoins en formation.
            </p>

            <p style='color: #4b5563; line-height: 1.6; margin-bottom: 20px;'>
                Vos réponses sont précieuses et nous aideront à mieux comprendre les défis rencontrés par les étudiants et professionnels, afin d'adapter nos services et formations aux besoins réels du marché.
            </p>

            <div style='background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #2563eb;'>
                <h3 style='margin: 0 0 10px 0; color: #1f2937;'>Que se passe-t-il maintenant ?</h3>
                <ul style='color: #4b5563; margin: 0; padding-left: 20px;'>
                    <li>Analyse de vos réponses dans les prochains jours</li>
                    <li>Publication des résultats de l'enquête</li>
                    <li>Adaptation de nos formations selon vos besoins</li>
                    <li>Contact possible pour des opportunités personnalisées</li>
                </ul>
            </div>

            <p style='color: #4b5563; line-height: 1.6; margin-bottom: 30px;'>
                N'hésitez pas à nous contacter si vous avez des questions ou souhaitez en savoir plus sur nos services.
            </p>

            <div style='text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;'>
                <a href='https://fsc-website.com' style='background: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 500; display: inline-block; margin-right: 10px;'>Visiter notre site</a>
                <a href='mailto:contact@fsc.com' style='color: #2563eb; text-decoration: none; font-weight: 500;'>contact@fsc.com</a>
            </div>
        </div>

        <div style='text-align: center; padding: 20px; color: #6b7280; font-size: 12px;'>
            <p>FSC - Formation Suivi Conseil<br>
            Casablanca, Maroc<br>
            © 2024 Tous droits réservés</p>
        </div>
    </div>
    ";

    $messageTexte = "
    FSC - Formation Suivi Conseil

    Cher(e) {$prenom},

    Nous vous remercions chaleureusement d'avoir pris le temps de répondre à notre enquête complète sur les technologies, l'IA et les besoins en formation.

    Vos réponses sont précieuses et nous aideront à mieux comprendre les défis rencontrés par les étudiants et professionnels, afin d'adapter nos services et formations aux besoins réels du marché.

    Que se passe-t-il maintenant ?
    - Analyse de vos réponses dans les prochains jours
    - Publication des résultats de l'enquête
    - Adaptation de nos formations selon vos besoins
    - Contact possible pour des opportunités personnalisées

    N'hésitez pas à nous contacter si vous avez des questions ou souhaitez en savoir plus sur nos services.

    Visitez notre site: https://fsc-website.com
    Contact: contact@fsc.com

    FSC - Formation Suivi Conseil
    Casablanca, Maroc
    © 2024 Tous droits réservés
    ";

    return sendMail($email, $sujet, $message, $messageTexte);
}

/**
 * Fonction pour envoyer une notification à l'admin lors d'une nouvelle soumission
 *
 * @param array $data Données du sondage
 * @return bool
 */
function sendAdminNotification($data) {
    $sujet = "Nouvelle soumission de sondage FSC";

    $message = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
        <h2 style='color: #2563eb;'>Nouvelle réponse au sondage FSC</h2>

        <div style='background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0;'>
            <h3>Informations du participant :</h3>
            <p><strong>Prénom:</strong> {$data['prenom']}</p>
            <p><strong>Pays:</strong> {$data['pays']}</p>
            <p><strong>Email:</strong> {$data['email']}</p>
            <p><strong>Domaine:</strong> {$data['domaine']}</p>
            <p><strong>Année:</strong> {$data['annee']}</p>
        </div>

        <div style='background: #fef3c7; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b;'>
            <h3>Points clés :</h3>
            <p><strong>Usage IA:</strong> {$data['usage_ia']}</p>
            <p><strong>Formation souhaitée:</strong> {$data['format_formation']}</p>
            <p><strong>Budget:</strong> {$data['prix_formation']} ({$data['prix_converti']})</p>
        </div>

        <p style='color: #6b7280; font-size: 12px;'>
            Date de soumission: " . date('d/m/Y H:i') . "
        </p>
    </div>
    ";

    // Charger l'email admin depuis .env
    if (file_exists(__DIR__ . '/../.env')) {
        $env = parse_ini_file(__DIR__ . '/../.env');
        $adminEmail = $env['ADMIN_EMAIL'] ?? '';
        if (!empty($adminEmail)) {
            return sendMail($adminEmail, $sujet, $message);
        }
    }

    return false;
}
?>