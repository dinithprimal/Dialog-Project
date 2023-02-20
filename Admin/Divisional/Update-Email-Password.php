<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $emailPassword = $_POST['emailPassword'];


    $sqlValidate = "UPDATE emailref SET password = '$emailPassword' WHERE id = 1";
    if($conn->query($sqlValidate) === TRUE){
        $data = 'true';
    }else{
        $data = 'false';
    }

    echo $data;
?>