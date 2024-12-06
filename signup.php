<?php
namespace Alex\Eindwerk;
include_once(__DIR__ . '/vendor/autoload.php');

session_start();

$error = ""; // Initialize the error variable

if (!empty($_POST)) {
    $user = new User();
    $email = trim($_POST['email']); // Remove leading/trailing spaces
    $password = trim($_POST['password']); // Remove leading/trailing spaces

    // Validate input: Check if fields are empty
    if (empty($email) || empty($password)) {
        $error = "Alle velden moeten worden ingevuld.";
    } else {
        // Check if the user is an admin
        if ($user->isAdmin($email, $password)) {
            $_SESSION['email'] = $email;
            $_SESSION['admin'] = true;
            header('Location: admin.php');
            exit;
        } 

        // Check if the email is already in use
        if ($user->emailExists($email)) {
            $error = "Dit e-mailadres is al in gebruik.";
        } else {
            // Save the user if no errors
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]));

            if ($user->save()) {
                header('Location: login.php');
                exit;
            } else {
                $error = "Er is een fout opgetreden bij het registreren.";
            }
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <!-- Preconnect for Google Fonts (only include once) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Page-specific stylesheet -->
    <link rel="stylesheet" href="login.css">

    <title>Account Aanmaken</title>
</head>
</head>
<body>
    <div class="login">
        <div class="login-nav">

            <h1>Welkom bij XD Brewery</h1>
            <a href="index.php">
                <i class="fas fa-arrow-left"></i>
                <p>Terug naar de shop</p>
            </a>

        </div>

        <form class="login-form" action="" method="POST">
            <h2>Account Aanmaken</h2>
            
            <!-- Error div -->
            <div class="error <?php echo empty($error) ? 'hidden' : ''; ?>">
                <?php echo $error; ?>
            </div>

            <div class="form-element">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-element">
                <label for="password">Wachtwoord</label>
                <input type="password" name="password" id="password">
            </div>
            
            <button class="cta" type="submit">Account Aanmaken</button>

            <div class="login-links">
                <a href="login.php">Heb je al een account? Log in.</a>
                <a href="#">Wachtwoord vergeten?</a>
            </div>
        </form>

    </div>

</body>
</html>