<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $indexRisk = $_POST['indexRisk'];
    $addRiskAction = $_POST['addRiskAction'];

    $Dt = new DateTime();
    $Date = $Dt->format("Y-m-d");

    $Time = $Dt->format("H:i:s");

    $sqlUpdateBI = "INSERT INTO risktreatmentresponseaction (indexRisk, action, empNo, date, time)  VALUES ('$indexRisk','$addRiskAction','$empNo','$Date','$Time')";
    if($conn->query($sqlUpdateBI) === TRUE){

        $queryActivity = "INSERT INTO activity (indexRisk, empNo, Date, Time, Des, field, updatedValue) VALUES ('$indexRisk', '$empNo', '$Date', '$Time', 'Add Risk Action','Risk Action', '$addRiskAction')";
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