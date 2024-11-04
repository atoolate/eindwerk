<?php
include_once(__DIR__ . '/classes/User.php');
    //signup
    $user = new User();
    $user->setFirstname($_POST['firstname']);
    //..
    $user->save();


    //login
    if(User::canLogin($email, $password)){
        //login, maak sessie + redirect naar home
    } else {
        //error
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