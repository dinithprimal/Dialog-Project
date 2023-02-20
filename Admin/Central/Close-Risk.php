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

    $sqlRiskClose = "SELECT closeStatus, closeEMP, closeComment FROM risk WHERE indexRisk = '$indexRisk'";
    $resultRiskClose = mysqli_query($conn,$sqlRiskClose) or die(mysqli_error($conn));
    $riskClose = mysqli_fetch_array($resultRiskClose);

    if($riskClose['closeStatus']=='2'){
        $empNo = $riskClose['closeEMP'];
        $comment = $riskClose['closeComment'];
    }

    
    //for($countRO = 0; $countRO<count($_POST['idRiskOwners']); $countRO++){
    //    $empRO = $_POST['idRiskOwners'][$countRO];
        $slRO = "UPDATE risk SET closeStatus = '1', closeDate = '$Date', closeTime = '$Time', closeComment = '$comment' WHERE indexRisk = '$indexRisk'";
        if($conn->query($slRO) === TRUE){

            $sqlActorDetails = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
            $resultActorDetails = mysqli_query($conn,$sqlActorDetails) or die(mysqli_error($conn));
            $actorDetails = mysqli_fetch_array($resultActorDetails);
            $actorFullName = $actorDetails['fullName'];
            
            $queryEmails = "SELECT email FROM user_details WHERE empNo IN (SELECT reporter FROM risk WHERE indexRisk = '$indexRisk' UNION SELECT empNo FROM riskowners WHERE indexRisk = '$indexRisk' UNION SELECT empNo FROM actionowners WHERE indexRisk = '$indexRisk')";
            $resultEmails = mysqli_query($conn,$queryEmails) or die(mysqli_error($conn));

            $queryAdminDetails = "SELECT email FROM user_details WHERE role = 'Admin'";
            $resultAdminDetails = mysqli_query($conn,$queryAdminDetails) or die(mysqli_error($conn));

            $riskReporter = "SELECT empNo FROM riskowners WHERE indexRisk = '$indexRisk'";
            $resultRiskReporter = mysqli_query($conn,$riskReporter) or die(mysqli_error($conn));
            $EMPRiskReporter = mysqli_fetch_array($resultRiskReporter);

            $sqlReporterDetails = "SELECT fullName FROM user_details WHERE empNo = '$EMPRiskReporter'";
            $resultReporterDetails = mysqli_query($conn,$sqlReporterDetails) or die(mysqli_error($conn));
            $reporterDetails = mysqli_fetch_array($resultReporterDetails);
            $reporterFullName = $reporterDetails['fullName'];


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
                $emailA = $adminDetails['email'];
                $mail->addCC($emailA);     // Add a recipient
            }
                        
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'GT - Risk Registry : '.$indexRisk.'';
            $mail->Body   = 'Dear All,<br><br>';
            $mail->Body   .= 'Risk mitigation action of risk index <em>'.$indexRisk.'</em> marked as completed by <em>'.$actorFullName.'</em> and risk owner <em>'.$reporterFullName.'</em> accepted to close the risk as there is no further risk. thus, risk will be marked for removal from the risk registry. If the risk mitigation action is not completed / in-adequate as per your view / knowladge, kindly re-open the risk.<br><br>';
            $mail->Body   .= 'Comment - <em>'.$comment.'</em> by <em>'.$actorFullName.'</em><br><br>';
            $mail->Body   .= 'Click on the below link to login and view the risk status of activities.<br><br>';
            $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
            $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
            $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
            $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

            if(!$mail->send()){
                //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }else{

            }

            $queryActivity = "INSERT INTO activity (indexRisk, empNo, Date, Time, Des) VALUES ('$indexRisk', '$empNo', '$Date', '$Time', 'Risk Closed')";
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