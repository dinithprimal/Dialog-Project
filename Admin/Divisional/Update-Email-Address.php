<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $emailAddress = $_POST['emailAddress'];


    $sqlValidate = "UPDATE emailref SET emailAddress = '$emailAddress' WHERE id = 1";
    if($conn->query($sqlValidate) === TRUE){
        $data = 'true';
    }else{
        $data = 'false';
    }

    echo $data;
?>