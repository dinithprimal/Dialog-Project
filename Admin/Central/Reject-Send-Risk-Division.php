<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $indexRisk = $_POST['indexRisk'];
    $comment = $_POST['comment'];

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

        $mail->setFrom(EMAIL, 'GT - Risk Management');
        while($userEmail = mysqli_fetch_array($resultEmails)){
            $emailU = $userEmail['email'];
            $mail->addAddress($emailU);     // Add a recipient
        }

        $queryAdminDetails = "SELECT email FROM user_details WHERE role = 'Admin'";
        $resultAdminDetails = mysqli_query($conn,$queryAdminDetails) or die(mysqli_error($conn));
        while($adminDetails = mysqli_fetch_array($resultAdminDetails)){

            $emailA = $adminDetails['email'];
            
            $mail->addCC($emailA);     // Add a recipient
        }
                    
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'GT - Risk Registry : '.$indexRisk.'';
        $mail->Body   = 'Dear All,<br><br>';
        $mail->Body   .= 'Admin rejected your request transfer risk <em>'.$indexRisk.'</em> from ERM to Divisional Risk Registry with comment - <em>'.$comment.'</em>.<br>';
        $mail->Body   .= 'Click on the below link to login and view the risk / update the status of activities.<br><br>';
        $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
        $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
        $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
        $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

        if(!$mail->send()){
            //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }else{

        }
        $Dt = new DateTime();
        $Date = $Dt->format("Y-m-d");

        $Time = $Dt->format("H:i:s");

        $com = 'Rejected the request of transfer the risk from ERM to Divisional Risk Registry with comment - '.$comment.'';

        $queryActivity = "INSERT INTO activity (indexRisk, empNo, Date, Time, Des) VALUES ('$indexRisk', '$empNo', '$Date', '$Time', '$com')";
        if($conn->query($queryActivity) === TRUE){
            $queryUpdateTrindex = "UPDATE trindex SET status = 'Active' WHERE indexRisk = '$indexRisk'";
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