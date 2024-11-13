<?php
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');

    // Start de sessie, maar voeg pas sessiegegevens toe na succesvolle login
    session_start();

    if (!empty($_POST)) {
        $user = new User();

        if ($user->canLogin($_POST['email'], $_POST['password'])) {
            $_SESSION['email'] = $_POST['email'];
            header('Location: index.php');
            exit;
        } else {
            echo "Ongeldige inloggegevens.";
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
</body>
</html>