<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $fullName = ''.$firstName.' '.$lastName.'';

    $slRO = "UPDATE user_details SET fName = '$firstName', lName = '$lastName', fullName = '$fullName' WHERE empNo = '$empNo'";
    if($conn->query($slRO) === TRUE){
        $data = "true";
    }else{
        $data = "false";
    }

    echo $data;
?>