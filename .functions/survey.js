export async function onRequest(context) {
  const { request, env } = context;

  // Handle both GET and POST requests
  if (request.method === 'GET') {
    // Return a simple HTML form for testing
    return new Response(`
      <!DOCTYPE html>
      <html>
      <head><title>Test Survey API</title></head>
      <body>
        <h1>API Sondage FSC - Test</h1>
        <p>Cette API accepte les requêtes POST avec des données de formulaire.</p>
        <p>Utilisez le formulaire sur <a href="/sondage.html">/sondage.html</a></p>
        <p>Status: 200 OK - API fonctionnelle</p>
      </body>
      </html>
    `, {
      headers: { 'Content-Type': 'text/html' }
    });
  }

  // Only handle POST requests for form submission
  if (request.method !== 'POST') {
    return new Response('Method not allowed - Use POST for form submission or GET for testing', {
      status: 405,
      headers: { 'Content-Type': 'text/plain' }
    });
  }

  try {
    // Parse form data
    const formData = await request.formData();

    // Extract and process form fields
    const data = {};
    for (const [key, value] of formData.entries()) {
      if (key.includes('[]')) {
        // Handle array fields
        const arrayKey = key.replace('[]', '');
        if (!data[arrayKey]) data[arrayKey] = [];
        data[arrayKey].push(value);
      } else {
        data[key] = value;
      }
    }

    // Process arrays into comma-separated strings
    const processedData = {
      ...data,
      competences: Array.isArray(data.competences) ? data.competences.join(', ') : data.competences,
      problemes: Array.isArray(data.problemes) ? data.problemes.join(', ') : data.problemes,
      processus_repetitifs: Array.isArray(data.processus_repetitifs) ? data.processus_repetitifs.join(', ') : data.processus_repetitifs,
      obstacles: Array.isArray(data.obstacles) ? data.obstacles.join(', ') : data.obstacles,
      raisons_pas_solutions: Array.isArray(data.raisons_pas_solutions) ? data.raisons_pas_solutions.join(', ') : data.raisons_pas_solutions,
      interets_communaute: Array.isArray(data.interets_communaute) ? data.interets_communaute.join(', ') : data.interets_communaute,
      competences_importance: Array.isArray(data.competences_importance) ? data.competences_importance.join(' > ') : data.competences_importance,
      date_soumission: new Date().toISOString(),
      prix_converti: convertCurrency(data.prix_formation, data.pays)
    };

    // Save to Cloudflare D1 if available
    if (env.DB) {
      const stmt = env.DB.prepare(`
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
      `);

      await stmt.bind(
        processedData.date_soumission, processedData.prenom, processedData.pays, processedData.adresse,
        processedData.sexe, processedData.domaine, processedData.annee, processedData.etablissement, processedData.experience,
        processedData.cours_ia, processedData.explication_ia, processedData.usage_ia, processedData.usages_ia,
        processedData.problemes, processedData.probleme_principal, processedData.processus_repetitifs, processedData.processus_automatise,
        processedData.heures_economisees, processedData.quantite_donnees,
        processedData.competences, processedData.duree_formation, processedData.format_formation, processedData.prix_formation, processedData.prix_converti,
        processedData.obstacles, processedData.equipements, processedData.raisons_pas_solutions, processedData.obstacle_principal,
        processedData.formation_securite, processedData.niveau_securite, processedData.pratiques_securite, processedData.risques_cyber,
        processedData.importance_ia_carriere, processedData.secteur_souhaite, processedData.demande_emploi, processedData.competences_importance,
        processedData.preparation_emploi, processedData.manque_preparation, processedData.entreprises_innovantes,
        processedData.ia_cours, processedData.ia_ameliore_enseignement, processedData.risques_ia_enseignement, processedData.risques_details,
        processedData.recommandation_education, processedData.vision_tech, processedData.interets_communaute, processedData.email
      ).run();
    }

    // Send thank you email if email is provided
    if (processedData.email && processedData.prenom) {
      await sendThankYouEmail(processedData.email, processedData.prenom, env);

      // Send admin notification
      await sendAdminNotification(processedData, env);
    }

    // Redirect to thank you page
    return new Response(null, {
      status: 302,
      headers: {
        'Location': '/merci.html?success=1&email=' + encodeURIComponent(processedData.email || '')
      }
    });

  } catch (error) {
    console.error('Survey processing error:', error);

    // Redirect to error page
    return new Response(null, {
      status: 302,
      headers: { 'Location': '/sondage.html?error=database' }
    });
  }
}

// Currency conversion function
function convertCurrency(amount_range, country) {
  const conversions = {
    'Maroc': ['MAD', 1],
    'Algérie': ['DZD', 13.5],
    'Tunisie': ['TND', 0.32],
    'France': ['EUR', 0.088],
    'Canada': ['CAD', 0.12],
    'Belgique': ['EUR', 0.088],
    'Suisse': ['CHF', 0.094],
    'Espagne': ['EUR', 0.088],
    'Italie': ['EUR', 0.088],
    'Portugal': ['EUR', 0.088],
    'États-Unis': ['USD', 0.099],
    'Royaume-Uni': ['GBP', 0.077],
    'Allemagne': ['EUR', 0.088]
  };

  if (!conversions[country]) {
    return amount_range + " MAD";
  }

  const [currency, rate] = conversions[country];

  if (amount_range.includes('-')) {
    const [min, max] = amount_range.split('-').map(s => parseInt(s.replace(/\D/g, '')));
    return `${Math.round(min * rate)} - ${Math.round(max * rate)} ${currency}`;
  } else if (amount_range.includes('+')) {
    const amount = parseInt(amount_range.replace(/\D/g, ''));
    return `${Math.round(amount * rate)}+ ${currency}`;
  }

  return amount_range + " " + currency;
}

// Email sending functions
async function sendThankYouEmail(email, prenom, env) {
  const subject = "Merci pour votre participation au sondage FSC !";

  const htmlContent = `
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
        <div style='background: linear-gradient(135deg, #2563eb, #059669); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0;'>
            <h1 style='margin: 0; font-size: 24px;'>FSC - Formation Suivi Conseil</h1>
            <p style='margin: 10px 0 0 0; opacity: 0.9;'>Merci pour votre contribution !</p>
        </div>

        <div style='background: white; padding: 30px; border: 1px solid #e5e7eb; border-radius: 0 0 10px 10px;'>
            <h2 style='color: #1f2937; margin-bottom: 20px;'>Cher(e) ${prenom},</h2>

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
  `;

  const textContent = `
    FSC - Formation Suivi Conseil

    Cher(e) ${prenom},

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
  `;

  // Use Cloudflare Email Routing or external API
  if (env.EMAIL_API_KEY && env.EMAIL_API_URL) {
    // Example with external email service (SendGrid, Mailgun, etc.)
    const emailData = {
      to: email,
      subject: subject,
      html: htmlContent,
      text: textContent,
      from: env.FROM_EMAIL || 'contact@fsc.com'
    };

    await fetch(env.EMAIL_API_URL, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${env.EMAIL_API_KEY}`,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(emailData)
    });
  }
}

async function sendAdminNotification(data, env) {
  if (!env.ADMIN_EMAIL) return;

  const subject = "Nouvelle soumission de sondage FSC";

  const htmlContent = `
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
        <h2 style='color: #2563eb;'>Nouvelle réponse au sondage FSC</h2>

        <div style='background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0;'>
            <h3>Informations du participant :</h3>
            <p><strong>Prénom:</strong> ${data.prenom}</p>
            <p><strong>Pays:</strong> ${data.pays}</p>
            <p><strong>Email:</strong> ${data.email}</p>
            <p><strong>Domaine:</strong> ${data.domaine}</p>
            <p><strong>Année:</strong> ${data.annee}</p>
        </div>

        <div style='background: #fef3c7; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b;'>
            <h3>Points clés :</h3>
            <p><strong>Usage IA:</strong> ${data.usage_ia}</p>
            <p><strong>Formation souhaitée:</strong> ${data.format_formation}</p>
            <p><strong>Budget:</strong> ${data.prix_formation} (${data.prix_converti})</p>
        </div>

        <p style='color: #6b7280; font-size: 12px;'>
            Date de soumission: ${new Date().toLocaleString('fr-FR')}
        </p>
    </div>
  `;

  // Send to admin
  if (env.EMAIL_API_KEY && env.EMAIL_API_URL) {
    const emailData = {
      to: env.ADMIN_EMAIL,
      subject: subject,
      html: htmlContent,
      from: env.FROM_EMAIL || 'contact@fsc.com'
    };

    await fetch(env.EMAIL_API_URL, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${env.EMAIL_API_KEY}`,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(emailData)
    });
  }
}