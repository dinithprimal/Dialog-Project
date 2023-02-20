<?php

    include("database.php");

    $sqlEmaiPW = "SELECT emailAddress, password FROM emailref WHERE id = 1";
    $resultEmailPW = mysqli_query($conn,$sqlEmaiPW) or die(mysqli_error($conn));
    $emailPW = mysqli_fetch_array($resultEmailPW);
    $pw = $emailPW['password'];
    $email = $emailPW['emailAddress'];

    define('EMAIL', $email);
    define('PASS', $pw);
?>