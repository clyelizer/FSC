// Survey form navigation and validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('surveyForm');
    const parts = document.querySelectorAll('.survey-part');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    const progressFill = document.getElementById('progressFill');
    const progressPercent = document.getElementById('progressPercent');
    const paysSelect = document.getElementById('pays');

    let currentPart = 0;
    const totalParts = parts.length;

    // Currency conversion rates (MAD as base)
    const currencyRates = {
        'Maroc': { symbol: 'MAD', rate: 1 },
        'Algérie': { symbol: 'DZD', rate: 13.5 },
        'Tunisie': { symbol: 'TND', rate: 0.32 },
        'France': { symbol: 'EUR', rate: 0.088 },
        'Canada': { symbol: 'CAD', rate: 0.12 },
        'Belgique': { symbol: 'EUR', rate: 0.088 },
        'Suisse': { symbol: 'CHF', rate: 0.094 },
        'Espagne': { symbol: 'EUR', rate: 0.088 },
        'Italie': { symbol: 'EUR', rate: 0.088 },
        'Portugal': { symbol: 'EUR', rate: 0.088 },
        'États-Unis': { symbol: 'USD', rate: 0.099 },
        'Royaume-Uni': { symbol: 'GBP', rate: 0.077 },
        'Allemagne': { symbol: 'EUR', rate: 0.088 }
    };

    function updateCurrencyDisplays(country) {
        if (currencyRates[country]) {
            const rate = currencyRates[country].rate;
            const symbol = currencyRates[country].symbol;

            // Update all currency displays
            const radioLabels = document.querySelectorAll('.radio-label');
            radioLabels.forEach(label => {
                const text = label.textContent;
                if (text.includes('MAD') && !text.includes('Gratuit')) {
                    const rangeMatch = text.match(/(\d+)\s*-\s*(\d+)/);
                    if (rangeMatch) {
                        const min = parseInt(rangeMatch[1].replace(/\s/g, ''));
                        const max = parseInt(rangeMatch[2].replace(/\s/g, ''));
                        const minConverted = Math.round(min * rate);
                        const maxConverted = Math.round(max * rate);
                        label.innerHTML = label.innerHTML.replace(/\d+\s*-\s*\d+\s*MAD/, `${minConverted} - ${maxConverted} ${symbol}`);
                    } else if (text.includes('+')) {
                        const amountMatch = text.match(/(\d+)/);
                        if (amountMatch) {
                            const amount = parseInt(amountMatch[1].replace(/\s/g, ''));
                            const converted = Math.round(amount * rate);
                            label.innerHTML = label.innerHTML.replace(/\d+\+/, `${converted}+`);
                        }
                    }
                }
            });
        }
    }

    // Update currency when country changes
    if (paysSelect) {
        paysSelect.addEventListener('change', function() {
            updateCurrencyDisplays(this.value);
        });
    }

    function showPart(index) {
        parts.forEach((part, i) => {
            part.style.display = i === index ? 'block' : 'none';
        });

        prevBtn.style.display = index === 0 ? 'none' : 'inline-block';
        nextBtn.style.display = index === totalParts - 1 ? 'none' : 'inline-block';
        submitBtn.style.display = index === totalParts - 1 ? 'inline-block' : 'none';

        const progress = ((index + 1) / totalParts) * 100;
        progressFill.style.width = progress + '%';
        progressPercent.textContent = Math.round(progress) + '%';

        // Scroll to top of form
        document.querySelector('.survey-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function validateCurrentPart() {
        // No validation required - user is completely free
        return true;
    }

    nextBtn.addEventListener('click', function() {
        if (validateCurrentPart()) {
            if (currentPart < totalParts - 1) {
                currentPart++;
                showPart(currentPart);
            }
        } else {
            alert('Veuillez remplir tous les champs obligatoires de cette partie.');
        }
    });

    prevBtn.addEventListener('click', function() {
        if (currentPart > 0) {
            currentPart--;
            showPart(currentPart);
        }
    });

    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Show loading state
        submitBtn.innerHTML = '<span class="loading">Envoi en cours...</span>';
        submitBtn.disabled = true;

        try {
            const formData = new FormData(form);

            // Convert FormData to JSON
            const data = {};
            for (const [key, value] of formData.entries()) {
                if (key.includes('[]')) {
                    const arrayKey = key.replace('[]', '');
                    if (!data[arrayKey]) data[arrayKey] = [];
                    data[arrayKey].push(value);
                } else {
                    data[key] = value;
                }
            }

            // For local development, simulate success
            if (window.location.hostname === '127.0.0.1' || window.location.hostname === 'localhost') {
                console.log('Données du formulaire:', data);
                setTimeout(() => {
                    // Simulate successful submission
                    window.location.href = 'merci.html?success=1&email=' + encodeURIComponent(data.email || '');
                }, 1000);
                return;
            }

            const response = await fetch('/api/survey', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });

            let result;
            try {
                result = await response.json();
            } catch (jsonError) {
                // If response is not JSON, treat as success
                result = { success: true, message: 'Formulaire envoyé' };
            }

            if (response.ok || response.status === 302) {
                // Success - redirect to thank you page
                window.location.href = 'merci.html?success=1&email=' + encodeURIComponent(data.email || '');
            } else {
                // Error
                alert('Erreur lors de l\'envoi: ' + (result.error || 'Erreur inconnue'));
                submitBtn.innerHTML = 'Envoyer l\'enquête';
                submitBtn.disabled = false;
            }
        } catch (error) {
            console.error('Erreur:', error);
            // For local development, still redirect to success
            if (window.location.hostname === '127.0.0.1' || window.location.hostname === 'localhost') {
                setTimeout(() => {
                    window.location.href = 'merci.html?success=1';
                }, 500);
            } else {
                alert('Erreur de connexion. Veuillez réessayer.');
                submitBtn.innerHTML = 'Envoyer l\'enquête';
                submitBtn.disabled = false;
            }
        }
    });

    // Real-time validation feedback
    form.addEventListener('input', function(e) {
        if (e.target.hasAttribute('required') && e.target.value.trim()) {
            e.target.style.borderColor = '#d1d5db';
            e.target.style.boxShadow = 'none';
        }
    });

    // Handle radio button changes
    form.addEventListener('change', function(e) {
        if (e.target.type === 'radio') {
            const radioGroup = e.target.closest('.radio-group');
            if (radioGroup) {
                radioGroup.style.border = 'none';
                radioGroup.style.padding = '0';
            }
        }
    });

    // Initialize first part
    showPart(0);
});