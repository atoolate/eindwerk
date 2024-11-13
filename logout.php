<?php 
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');

    // logout the user
    session_start();
    session_destroy();
    header('Location: index.php');

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You are logged out</title>
</head>
<body>
    
</body>
</html>