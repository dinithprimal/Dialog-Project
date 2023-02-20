<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $indexRisk = $_POST['indexRisk'];
    $addRiskActivity = $_POST['addRiskActivity'];

    $Dt = new DateTime();
    $Date = $Dt->format("Y-m-d");

    $Time = $Dt->format("H:i:s");

    $sqlUpdateBI = "INSERT INTO divrisktreatmentactivity (indexRisk, activity, empNo, date, time)  VALUES ('$indexRisk','$addRiskActivity','$empNo','$Date','$Time')";
    if($conn->query($sqlUpdateBI) === TRUE){

        $queryActivity = "INSERT INTO divactivity (indexRisk, empNo, Date, Time, Des, field, updatedValue) VALUES ('$indexRisk', '$empNo', '$Date', '$Time', 'Add Risk Activity','Risk Activity', '$addRiskActivity')";
        if($conn->query($queryActivity) === TRUE){
            $queryLastUpdate = "UPDATE divlastupdate SET empNo = '$empNo', date = '$Date', time = '$Time' WHERE indexRisk = '$indexRisk'";
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