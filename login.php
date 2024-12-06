<?php
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');
    
    // Start the session only once at the top
    session_start();
    
    if (!empty($_POST)) {
        $user = new User();
        $email = $_POST['email'];
        $password = $_POST['password'];

        // check if the user is an admin
        if ($user->isAdmin($email, $password)) {
            $_SESSION['admin'] = true;
            $_SESSION['email'] = $email;
            header('Location: admin.php');
            exit;
        }
        // only proceed with login if the user canLogin
        if ($user->canLogin($email, $password)) {
            $_SESSION['email'] = $email;
            header('Location: index.php');
            exit;
        } else {
            echo "Er is een fout opgetreden bij het inloggen.";
        }

    }


?><!DOCTYPE html>
<html lang="en">
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

    <title>Login</title>
</head>
<body>
    <h1>Welkom terug</h1>
    <h2>Inloggen</h2>
    <form action="" method="POST">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email">
        <label for="password">Wachtwoord</label>
        <input type="password" name="password" id="password">
        <button type="submit">Inloggen</button>
    </form>
    <a href="signup.php">Nog geen account? Registreer hier.</a>
</body>
</html>