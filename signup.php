<?php
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');

    session_start();

    if (!empty($_POST)) {
        $user = new User();
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $passwordConfirm = trim($_POST['password_confirm']);
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);

        // Backend validation (safety net)
        if (empty($email) || empty($password) || empty($passwordConfirm) || empty($first_name) || empty($last_name)) {
            die("Alle velden moeten worden ingevuld."); // Stop execution with an error message
        }

        if ($password !== $passwordConfirm) {
            die("De wachtwoorden komen niet overeen."); // Stop execution with an error message
        }

        if ($user->emailExists($email)) {
            die("Dit e-mailadres is al in gebruik."); // Stop execution with an error message
        }

        // Save user if validation passes
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]));
        $user->setFirstName($first_name);
        $user->setLastName($last_name);

        if ($user->save()) {
            echo '<input type="hidden" id="account-created" value="true">';
        } else {
            die("Er is een fout opgetreden bij het registreren."); // Stop execution with an error message
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

    <title>Create Account</title>
</head>
</head>
<body>
    <div class="login">
        <div class="login-nav">

            <h1>Welcome to XD Brewery</h1>
            <a href="index.php">
                <i class="fas fa-arrow-left"></i>
                <p>Back to shop</p>
            </a>

        </div>

        <form id="multi-step-form" action="" method="POST">
        <div class="login-form" id="step-1" style="display: flex;">
            <h2>Step 1: Personal Info</h2>
            <div class="error" style="display: none;"></div> <!-- Error div for Step 1 -->
            <div class="form-element">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name">
            </div>
            <div class="form-element">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name">
            </div>
            <div class="form-element">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email">
            </div>
            <button type="button" class="cta" id="next-button">Continue</button>
        </div>

        <div class="login-form" id="step-2" style="display: none;">
            <h2>Step 2: Choose your password</h2>
            <div class="error" style="display: none;"></div> <!-- Error div for Step 2 -->
            <div class="form-element">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-element">
                <label for="password_confirm">Confirm Password</label>
                <input type="password" name="password_confirm" id="password_confirm">
            </div>
            <div class="form-buttons">
                <button class="cta" type="button" id="prev-button">Go Back</button>
                <button class="cta" id="cta-complete" type="submit">Create Account</button>
            </div>
        </div>

        </form>


    </div>

    <div id="popup" class="popup">
        Account created successfully, redirecting to login page...
    </div>

</body>

<script src="js/signupError.js"></script>

<script src="js/signupPopup.js"></script>



</html>