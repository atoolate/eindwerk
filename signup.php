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
            header('Location: login.php'); // Redirect to login on success
            exit;
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

</body>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const step1 = document.getElementById("step-1");
    const step2 = document.getElementById("step-2");
    const nextButton = document.getElementById("next-button");
    const prevButton = document.getElementById("prev-button");
    const submitButton = document.getElementById("cta-complete");
    const errorDivStep1 = document.querySelector("#step-1 .error");
    const errorDivStep2 = document.querySelector("#step-2 .error");

    // Step 1: Validate and move to Step 2
    nextButton.addEventListener("click", () => {
        const firstName = document.getElementById("first_name").value.trim();
        const lastName = document.getElementById("last_name").value.trim();
        const email = document.getElementById("email").value.trim();

        // Validate Step 1 fields
        if (!firstName || !lastName || !email) {
            errorDivStep1.textContent = "We need more info. Please fill out all fields.";
            errorDivStep1.style.display = "block"; // Show error div
            return;
        }

        // Clear errors and go to Step 2
        errorDivStep1.textContent = "";
        errorDivStep1.style.display = "none"; // Hide error div
        step1.style.display = "none";
        step2.style.display = "flex";
    });

    // Step 2: Validate and submit the form
    submitButton.addEventListener("click", (event) => {
        const password = document.getElementById("password").value.trim();
        const passwordConfirm = document.getElementById("password_confirm").value.trim();

        // Prevent form submission if validation fails
        if (!password || !passwordConfirm) {
            event.preventDefault();
            errorDivStep2.textContent = "Please fill out all fields.";
            errorDivStep2.style.display = "block";
            return;
        }

        if (password !== passwordConfirm) {
            event.preventDefault();
            errorDivStep2.textContent = "Passwords do not match.";
            errorDivStep2.style.display = "block";
            return;
        }

        // Clear errors and allow form submission
        errorDivStep2.textContent = "";
        errorDivStep2.style.display = "none";
    });

    // Go back to Step 1
    prevButton.addEventListener("click", () => {
        // Clear errors when navigating back to Step 1
        errorDivStep2.textContent = "";
        errorDivStep2.style.display = "none";
        step2.style.display = "none";
        step1.style.display = "flex";
    });
});



</script>

</html>