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
        if ($user->isAdmin($email)) {
            $_SESSION['admin'] = true;
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
    <title>Inloggen</title>
    <link rel="stylesheet" href="style.css">
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