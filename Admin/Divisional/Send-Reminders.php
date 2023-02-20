<?php

    $idInfoProg = $_POST['idInfoProg'];

    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    $data = '';

    $sqlInfoProg = "SELECT * FROM divinfogather WHERE idInfo = '$idInfoProg'";
    $resultInfoProg = mysqli_query($conn,$sqlInfoProg) or die(mysqli_error($conn));
    $detailsInfoProg = mysqli_fetch_array($resultInfoProg);
    $name = $detailsInfoProg['Name'];
    $deadline = $detailsInfoProg['endDate'];
    $totLastReminders = $detailsInfoProg['totReminder'];
    if($totLastReminders == Null){
        $totLastReminders = 0;
    }
    $totLastReminders++;

    $DLDt = new DateTime($deadline);
    $emailDL = $DLDt->format("F j, Y, g:i a");

    $Dt = new DateTime();
    $Date = $Dt->format("Y-m-d H:i:s");

    $slAO = "UPDATE divinfogather SET lastReminder = '$Date', totReminder = '$totLastReminders' WHERE idInfo = '$idInfoProg'";
    if($conn->query($slAO) === TRUE){

        $mail = new PHPMailer;
        //$mail->SMTPDebug = 4; 
        $mail->SMTPDebug = false;                                // Disable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = EMAIL;                 // SMTP username
        $mail->Password = PASS;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom(EMAIL, 'GT - Risk Management');

        $sqlAllRisks = "SELECT indexRisk FROM divrisk WHERE closeStatus = 0";
        $resultAllRisks = mysqli_query($conn,$sqlAllRisks) or die(mysqli_error($conn));
        while($AllRisks = mysqli_fetch_array($resultAllRisks)){
            $indexRisk = $AllRisks['indexRisk'];
            $sqlGetOwners = "SELECT empNo AS empN FROM divactionowners WHERE indexRisk = '$indexRisk'";
            $resultGetOwners = mysqli_query($conn,$sqlGetOwners) or die(mysqli_error($conn));
            while($GetOwners = mysqli_fetch_array($resultGetOwners)){
                $empNo = $GetOwners['empN'];
                $sqlInfo = "SELECT * FROM divinfogatherdetails WHERE idInfo = '$idInfoProg' AND indexRisk = '$indexRisk' AND empNo = '$empNo'";
                $resultInfo = mysqli_query($conn,$sqlInfo) or die(mysqli_error($conn));
                $countInfo = mysqli_num_rows($resultInfo);
                if($countInfo == 0){
                    $sqlGetOwnerName = "SELECT email FROM user_details WHERE empNo = '$empNo'";
                    $resultGetOwnersName = mysqli_query($conn,$sqlGetOwnerName) or die(mysqli_error($conn));
                    $GetOwnersName = mysqli_fetch_array($resultGetOwnersName);
                    $email = $GetOwnersName['email'];

                    $mail->addAddress($email);     // Add a recipient
                }
            }
        }
                    
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'GT - Risk Management';
        $mail->Body   = 'Dear All,<br><br>';
        $mail->Body   .= 'There are risk mitigation activities assigned to you and kindly provide an update for <em>'.$name.'</em> on or before <em>'.$emailDL.'</em>.';
        $mail->Body   .= '<br><br>Kindly log into the risk registry (Link) to provide the updates.';
        $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
        $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
        $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
        $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

        if(!$mail->send()){
            $data = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }else{
            $data = "true";
        }

    }

    echo    $data;

?>