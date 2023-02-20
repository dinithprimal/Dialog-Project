<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $userCategory = $_POST['userCategory'];

    if($userCategory == "Member"){
        $userCategory = "Body";
    }

    $slRO = "UPDATE user_details SET category = '$userCategory' WHERE empNo = '$empNo'";
    if($conn->query($slRO) === TRUE){
        $data = "true";
    }else{
        $data = "false";
    }

    echo $data;
?>