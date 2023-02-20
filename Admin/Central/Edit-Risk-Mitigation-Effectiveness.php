<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $indexRisk = $_POST['indexRisk'];
    $mitigationEffectiveness = $_POST['mitigationEffectiveness'];
    $initialVal = $_POST['initialVal'];

    $sqlUpdateBI = "UPDATE risk SET Effectiveness = '$mitigationEffectiveness' WHERE indexRisk = '$indexRisk'";
    if($conn->query($sqlUpdateBI) === TRUE){

        $Dt = new DateTime();
        $Date = $Dt->format("Y-m-d");

        $Time = $Dt->format("H:i:s");

        $queryActivity = "INSERT INTO activity (indexRisk, empNo, Date, Time, Des, field, intialValue, updatedValue) VALUES ('$indexRisk', '$empNo', '$Date', '$Time', 'Update Risk Mitigation Effectiveness','Risk Mitigation Effectiveness', '$initialVal', '$mitigationEffectiveness')";
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