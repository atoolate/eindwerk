<?php
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');
    
    if (!empty($_POST)) {
        $user = new User();
        $email = $_POST['email'];
        
        // Check if the user is an admin
        if ($user->isAdmin($email)) {
            $_SESSION['admin'] = true;
            header('Location: admin.php');
            exit;
        } 
        
        // Only proceed with registration if the user is not an admin
        $user->setEmail($email);
        $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]));
    
        if ($user->save()) {
            header('Location: login.php');
            exit;
        } else {
            echo "Er is een fout opgetreden bij het registreren.";
        }
    }
    

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account aanmaken</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Account aanmaken</h1>
    <form action="" method="POST">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email">
        <label for="password">Wachtwoord</label>
        <input type="password" name="password" id="password">
        <button type="submit">Account aanmaken</button>
    </form>
</body>
</html>