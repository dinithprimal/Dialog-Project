<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $deadline = $_POST['deadline'];
    $idInfoProg = $_POST['idInfoProg'];

    $DLDt = new DateTime($deadline);
    $DLDate = $DLDt->format("Y-m-d H:i:s");

    $slAO = "UPDATE divinfogather SET endDate = '$DLDate' WHERE idInfo = '$idInfoProg'";
    if($conn->query($slAO) === TRUE){
        $data = "true";
    }

    echo    $data;
?>