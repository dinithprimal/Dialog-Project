<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $indexRisk = $_POST['indexRisk'];
    $empNo_removeA = $_POST['empNo_removeA'];

    $sqlEmpNoCheck = "SELECT role FROM user_details WHERE empNo = '$empNo'";
    $resultEmpNoCheck = mysqli_query($conn,$sqlEmpNoCheck) or die(mysqli_error($conn));
    $EmpNoCheck = mysqli_fetch_array($resultEmpNoCheck);
    $cat = $EmpNoCheck['role'];

    $userRole = '';
    if($cat == "Admin"){
        $userRole = 'Admin';
    }else{
        $userRole = 'Risk Owner';
    }

    $sqlRiskDetails = "SELECT description, impact, reporter FROM risk WHERE indexRisk = '$indexRisk'";
    $resultRiskDetails = mysqli_query($conn,$sqlRiskDetails) or die(mysqli_error($conn));
    $riskDetails = mysqli_fetch_array($resultRiskDetails);

    $riskDescription = $riskDetails['description'];
    $impact = $riskDetails['impact'];
    $empNoRep = $riskDetails['reporter'];

    $queryReporterName = "SELECT fullName FROM user_details WHERE empNo = '$empNoRep'";
    $resultReporterName = mysqli_query($conn,$queryReporterName) or die(mysqli_error($conn));
    $reporterName = mysqli_fetch_array($resultReporterName);
    $reporter = $reporterName['fullName'];

    $sqlRiskDeadline = "SELECT deadline FROM risktreatmentdeadline WHERE indexRisk = '$indexRisk' ORDER BY id DESC LIMIT 1";
    $resultRiskDeadline = mysqli_query($conn,$sqlRiskDeadline) or die(mysqli_error($conn));
    $riskDeadline = mysqli_fetch_array($resultRiskDeadline);

    $deadline = $riskDeadline['deadline'];

    $sqlRiskAction = "SELECT action FROM risktreatmentresponseaction WHERE indexRisk = '$indexRisk' ORDER BY id DESC LIMIT 1";
    $resultRiskAction = mysqli_query($conn,$sqlRiskAction) or die(mysqli_error($conn));
    $riskAction = mysqli_fetch_array($resultRiskAction);

    $detailLevel = $riskAction['action'];

    $slRO = "DELETE FROM actionowners WHERE empNo = '$empNo_removeA'";
    if($conn->query($slRO) === TRUE){
        $queryUserName = "SELECT fullName, fName, email FROM user_details WHERE empNo = '$empNo_removeA'";
        $resultUserName = mysqli_query($conn,$queryUserName) or die(mysqli_error($conn));
        $userName = mysqli_fetch_array($resultUserName);
        $AOname = $userName['fullName'];

        $Dt = new DateTime();
        $Date = $Dt->format("Y-m-d");

        $Time = $Dt->format("H:i:s");

        $email = $userName['email'];
        $fName = $userName['fName'];

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
        $mail->addAddress($email);     // Add a recipient
                    
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'GT - Risk Registry : '.$indexRisk.' - Action Owner Name Deletion';
        $mail->Body   = 'Dear '.$fName.',<br><br>';
        $mail->Body   .= '<em>'.$userRole.'</em> delete your name from the action owner field of the risk <em>'.$indexRisk.'</em>. If you need further clarification, kindly contact risk owner / reporter or GTD.<br><br>';
        $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
        $mail->Body   .= 'Risk Description - <em>'.$riskDescription.'</em><br><br>';
        $mail->Body   .= 'Risk Impact - <em>'.$impact.'</em><br><br>';
        $mail->Body   .= 'Action - <em>'.$detailLevel.'</em><br><br>';
        $mail->Body   .= 'Due Date - <em>'.$deadline.'</em><br><br>';
        $mail->Body   .= 'Risk Reporter - <em>'.$reporter.'</em><br><br>';
        $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
        $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
        $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

        if(!$mail->send()){
            //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }else{

        }

        $queryActivity = "INSERT INTO activity (indexRisk, empNo, Date, Time, Des, field,  updatedValue) VALUES ('$indexRisk', '$empNo', '$Date', '$Time', 'Remove Action Owner','Action Owners', '$AOname')";
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