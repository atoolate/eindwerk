<?php 
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');

    session_start();
    // if is Admin is false, redirect to index.php
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] === false) {
        header('Location: index.php');
        exit;
    }    

    

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="logout.php">Logout</a>
</body>
</html>