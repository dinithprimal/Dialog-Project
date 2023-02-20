<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $indexRisk = $_POST['indexRisk'];
    $comment = $_POST['comment'];

    $sqlRiskDetails = "SELECT description, impact, resriskLevel FROM risk WHERE indexRisk = '$indexRisk'";
    $resultRiskDetails = mysqli_query($conn,$sqlRiskDetails) or die(mysqli_error($conn));
    $riskDetails = mysqli_fetch_array($resultRiskDetails);

    $riskDescription = $riskDetails['description'];
    $impact = $riskDetails['impact'];
    $resriskLevel = $riskDetails['resriskLevel'];

    $sqlRiskDeadline = "SELECT deadline FROM risktreatmentdeadline WHERE indexRisk = '$indexRisk' ORDER BY id DESC LIMIT 1";
    $resultRiskDeadline = mysqli_query($conn,$sqlRiskDeadline) or die(mysqli_error($conn));
    $riskDeadline = mysqli_fetch_array($resultRiskDeadline);

    $deadline = $riskDeadline['deadline'];

    $sqlRiskAction = "SELECT action FROM risktreatmentresponseaction WHERE indexRisk = '$indexRisk' ORDER BY id DESC LIMIT 1";
    $resultRiskAction = mysqli_query($conn,$sqlRiskAction) or die(mysqli_error($conn));
    $riskAction = mysqli_fetch_array($resultRiskAction);

    $detailLevel = $riskAction['action'];

    $sqlActorDetails = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
    $resultActorDetails = mysqli_query($conn,$sqlActorDetails) or die(mysqli_error($conn));
    $actorDetails = mysqli_fetch_array($resultActorDetails);
    $actorFullName = $actorDetails['fullName'];

    $Dt = new DateTime();
    $Date = $Dt->format("Y-m-d");

    $Time = $Dt->format("H:i:s");

    $slRO = "UPDATE risk SET closeStatus = '0', closeDate = Null, closeTime = Null, closeComment = Null WHERE indexRisk = '$indexRisk'";
    if($conn->query($slRO) === TRUE){

        $queryEmails = "SELECT email FROM user_details WHERE empNo IN (SELECT reporter FROM risk WHERE indexRisk = '$indexRisk' UNION SELECT empNo FROM riskowners WHERE indexRisk = '$indexRisk' UNION SELECT empNo FROM actionowners WHERE indexRisk = '$indexRisk')";
        $resultEmails = mysqli_query($conn,$queryEmails) or die(mysqli_error($conn));

        $sqlAdminDetails = "SELECT email FROM user_details WHERE role = 'Admin'";
        $resultAdminDetails = mysqli_query($conn,$sqlAdminDetails) or die(mysqli_error($conn));

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

        while($userEmail = mysqli_fetch_array($resultEmails)){
            $emailU = $userEmail['email'];
            $mail->addAddress($emailU);     // Add a recipient
        }

        while($adminDetails = mysqli_fetch_array($resultAdminDetails)){
            $adminEmail = $adminDetails['email'];
            $mail->addCC($adminEmail);     // Add a recipient
        }
                    
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'GT - Risk Registry : '.$indexRisk.'';
        $mail->Body   = 'Dear All,<br><br>';
        $mail->Body   .= '<em>'.$actorFullName.'</em> re-opened the risk <em>'.$indexRisk.'</em>.<br><br>';
        $mail->Body   .= 'Comment - '.$comment.'<br><br>';
        $mail->Body   .= 'Risk details<br><br>';
        $mail->Body   .= 'Risk Description - <em>'.$riskDescription.'</em><br><br>';
        $mail->Body   .= 'Risk Impact - <em>'.$impact.'</em><br><br>';
        $mail->Body   .= 'Action - <em>'.$detailLevel.'</em><br><br>';
        $mail->Body   .= 'Due Date - <em>'.$deadline.'</em><br><br>';
        $mail->Body   .= 'Residual Risk Level - <em>'.$resriskLevel.'</em><br><br>';
        $mail->Body   .= 'Click on the below link to login and view the risk / update the status of activities.<br><br>';
        $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br>';
        $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
        $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
        $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

        if(!$mail->send()){
            //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }else{

        }

        $des = 'Risk Re-Opened - Comment: '.$comment.'';

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