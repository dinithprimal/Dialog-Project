<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $indexRisk = $_POST['indexRisk'];

        $queryEmailRequest = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
        $resultEmailRequest = mysqli_query($conn,$queryEmailRequest) or die(mysqli_error($conn));
        $userEmailRequest = mysqli_fetch_array($resultEmailRequest);
        $userFullName = $userEmailRequest['fullName'];

        $sqlRiskDetails = "SELECT * FROM risk WHERE indexRisk = '$indexRisk'";
        $resultRiskDetails = mysqli_query($conn,$sqlRiskDetails) or die(mysqli_error($conn));
        $riskDetails = mysqli_fetch_array($resultRiskDetails);

        $riskDescription = $riskDetails['description'];
        $businessObj = $riskDetails['businessObj'];
        $resriskLevel = $riskDetails['resriskLevel'];
        $mainUnit = $riskDetails['mainUnit'];

        $sqlRiskDeadline = "SELECT deadline FROM risktreatmentdeadline WHERE indexRisk = '$indexRisk' ORDER BY id DESC LIMIT 1";
        $resultRiskDeadline = mysqli_query($conn,$sqlRiskDeadline) or die(mysqli_error($conn));
        $riskDeadline = mysqli_fetch_array($resultRiskDeadline);

        $deadline = $riskDeadline['deadline'];

        $queryEmails = "SELECT email FROM user_details WHERE empNo IN (SELECT reporter FROM risk WHERE indexRisk = '$indexRisk' UNION SELECT empNO FROM riskowners WHERE indexRisk = '$indexRisk' UNION SELECT empNO FROM actionowners WHERE indexRisk = '$indexRisk')";
        $resultEmails = mysqli_query($conn,$queryEmails) or die(mysqli_error($conn));
        //$userName = mysqli_fetch_array($resultEmails);

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

        $queryAdminDetails = "SELECT email FROM user_details WHERE role = 'Admin'";
        $resultAdminDetails = mysqli_query($conn,$queryAdminDetails) or die(mysqli_error($conn));
        while($adminDetails = mysqli_fetch_array($resultAdminDetails)){

            $emailA = $adminDetails['email'];
            
            $mail->addAddress($emailA);     // Add a recipient
        }

        $mail->setFrom(EMAIL, 'GT - Risk Management');
        while($userEmail = mysqli_fetch_array($resultEmails)){
            $emailU = $userEmail['email'];
            $mail->addCC($emailU);     // Add a recipient
        }

        
                    
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'GT - Risk Registry : '.$indexRisk.'';
        $mail->Body   = 'Dear Admin,<br><br>';
        $mail->Body   .= ''.$userFullName.' has requested to transfer the following risk <em>'.$indexRisk.'</em> from ERM to Divisional Risk Registry.<br>';
        $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
        $mail->Body   .= 'Division - <em>'.$mainUnit.'</em><br><br>';
        $mail->Body   .= 'Risk Description - <em>'.$riskDescription.'</em><br><br>';
        $mail->Body   .= 'High Level Business Objective - <em>'.$businessObj.'</em><br><br>';
        $mail->Body   .= 'Due Date - <em>'.$deadline.'</em><br><br>';
        $mail->Body   .= 'Residual Risk Level - <em>'.$resriskLevel.'</em><br><br>';
        $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
        $mail->Body   .= '<br>Thank You and Best Regard';

        if(!$mail->send()){
            //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }else{

        }

        $Dt = new DateTime();
        $Date = $Dt->format("Y-m-d");

        $Time = $Dt->format("H:i:s");

        $queryActivity = "INSERT INTO divactivity (indexRisk, empNo, Date, Time, Des) VALUES ('$indexRisk', '$empNo', '$Date', '$Time', 'Requested to transfer the risk from ERM to Divisional Risk Registry')";
        if($conn->query($queryActivity) === TRUE){
            $queryUpdateTrindex = "UPDATE trindex SET status = 'Pending', moveRequest = '$empNo' WHERE indexRisk = '$indexRisk'";
            if($conn->query($queryUpdateTrindex) === TRUE){
                $data = "true";
            }else{
                $data = "false";
            }
        }else{
            $data = "false";
        }

    echo $data;

    
?>