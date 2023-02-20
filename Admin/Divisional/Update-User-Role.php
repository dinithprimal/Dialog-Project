<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $userRole = $_POST['userRole'];

    $slRO = "UPDATE user_details SET role = '$userRole' WHERE empNo = '$empNo'";
    if($conn->query($slRO) === TRUE){
        $data = "true";
    }else{
        $data = "false";
    }

    echo $data;
?>