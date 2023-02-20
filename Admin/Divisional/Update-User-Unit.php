<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $userUnit = $_POST['userUnit'];

    $slRO = "UPDATE user_details SET unit = '$userUnit' WHERE empNo = '$empNo'";
    if($conn->query($slRO) === TRUE){
        $data = "true";
    }else{
        $data = "false";
    }

    echo $data;
?>