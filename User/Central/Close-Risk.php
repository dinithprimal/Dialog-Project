<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $indexRisk = $_POST['indexRisk'];
    $comment = $_POST['comment'];

    $Dt = new DateTime();
    $Date = $Dt->format("Y-m-d");

    $Time = $Dt->format("H:i:s");

    $sqlActorDetails = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
    $resultActorDetails = mysqli_query($conn,$sqlActorDetails) or die(mysqli_error($conn));
    $actorDetails = mysqli_fetch_array($resultActorDetails);
    $actorFullName = $actorDetails['fullName'];

    
    //for($countRO = 0; $countRO<count($_POST['idRiskOwners']); $countRO++){
    //    $empRO = $_POST['idRiskOwners'][$countRO];
        $slRO = "UPDATE risk SET closeStatus = '2', closeDate = '$Date', closeTime = '$Time', closeComment = '$comment', closeEMP = '$empNo' WHERE indexRisk = '$indexRisk'";
        if($conn->query($slRO) === TRUE){
            
            $queryEmails = "SELECT email FROM user_details WHERE empNo IN (SELECT reporter FROM risk WHERE indexRisk = '$indexRisk' UNION SELECT empNo FROM riskowners WHERE indexRisk = '$indexRisk' UNION SELECT empNo FROM actionowners WHERE indexRisk = '$indexRisk')";
            $resultEmails = mysqli_query($conn,$queryEmails) or die(mysqli_error($conn));

            $queryAdminDetails = "SELECT email FROM user_details WHERE role = 'Admin'";
            $resultAdminDetails = mysqli_query($conn,$queryAdminDetails) or die(mysqli_error($conn));

            /* $mail = new PHPMailer;
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
            $mail->addAddress($reporterEmail);     // Add a recipient
                        
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'GT - Risk Registry : '.$indexRisk.'';
            $mail->Body   = '<small>Dear '.$reporterFirstName.',</small><br><br>';
            $mail->Body   .= '<small>Risk mitigation action of risk index <em>'.$indexRisk.'</em> marked as completed by <em>'.$actorFullName.'</em>. thus, risk will be marked for removal from the risk registry. If the risk mitigation action is not completed / in-adequate as per your view / knowladge, kindly re-open the risk.</small><br>';
            $mail->Body   .= '<small>Click on the below link to login and view the risk status of activities.</small><br><br>';
            $mail->Body   .= '<small>Link - <a href="http://localhost/Risk-Registry-System">Risk Register Management System</a></small><br><br>';
            $mail->Body   .= '<small>If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.</small><br><br>';
            $mail->Body   .= '<small><small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small></small><br><br>';
            $mail->Body   .= '<br><small>Thank You and Best Regard,<br>GTD Team.</small>';

            if(!$mail->send()){
                //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }else{

            } */

            $mail2 = new PHPMailer;
            //$mail->SMTPDebug = 4; 
            $mail2->SMTPDebug = false;                                // Disable verbose debug output

            $mail2->isSMTP();                                      // Set mailer to use SMTP
            $mail2->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
            $mail2->SMTPAuth = true;                               // Enable SMTP authentication
            $mail2->Username = EMAIL;                 // SMTP username
            $mail2->Password = PASS;                           // SMTP password
            $mail2->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail2->Port = 587;                                    // TCP port to connect to

            $mail2->setFrom(EMAIL, 'GT - Risk Management');

            while($adminDetails = mysqli_fetch_array($resultAdminDetails)){
                $emailA = $adminDetails['email'];
                $mail->addAddress($emailA);     // Add a recipient
            }
            while($userEmail = mysqli_fetch_array($resultEmails)){
                $emailU = $userEmail['email'];
                $mail->addCC($emailU);     // Add a recipient
            }

            $mail2->isHTML(true);                                  // Set email format to HTML

            $mail2->Subject = 'GT - Risk Registry : '.$indexRisk.'';
            $mail2->Body   = 'Dear Admin,<br><br>';
            $mail2->Body   .= 'Risk mitigation action of risk index <em>'.$indexRisk.'</em> marked as completed by <em>'.$actorFullName.' and requesting for close this risk.</em>.<br>';
            $mail2->Body   .= 'Click on the below link to login and view the risk status of activities.<br><br>';
            $mail2->Body   .= 'Link - <a href="http://localhost/Risk-Registry-System">Risk Register Management System</a><br><br>';
            $mail2->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
            $mail2->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

            if(!$mail2->send()){
                //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }else{

            }

            $queryActivity = "INSERT INTO activity (indexRisk, empNo, Date, Time, Des) VALUES ('$indexRisk', '$empNo', '$Date', '$Time', 'Requested to close this Risk')";
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
    //}

    echo $data;
?>