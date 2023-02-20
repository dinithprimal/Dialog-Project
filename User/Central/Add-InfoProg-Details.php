<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $indexRisk = $_POST['indexRisk'];
    $idInfo = $_POST['idInfo'];
    $option = $_POST['option'];

    $des = "Added ".$option." option to Information Gather Program";

    $Dt = new DateTime();
    $Date = $Dt->format("Y-m-d");

    $Time = $Dt->format("H:i:s");

    $sqlInfoProgDetails = "INSERT INTO infogatherdetails (idInfo, indexRisk, empNo, descrition, date, time) VALUES ('$idInfo', '$indexRisk', '$empNo', '$option', '$Date', '$Time')";
    if($conn->query($sqlInfoProgDetails) === TRUE){
        $queryActivity = "INSERT INTO activity (indexRisk, empNo, Date, Time, Des) VALUES ('$indexRisk', '$empNo', '$Date', '$Time', '$des')";
        if($conn->query($queryActivity) === TRUE){
            $queryLastUpdate = "UPDATE lastupdate SET empNo = '$empNo', date = '$Date', time = '$Time' WHERE indexRisk = '$indexRisk'";
            if($conn->query($queryLastUpdate) === TRUE){
                $data = "true";
            }else{
                $data = "false";
            }
        }else{
            $data = "false";
        }
    }else{
        $data = "false";
    }
    

    echo $data;
?>