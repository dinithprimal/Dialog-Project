<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $idInfoProg = $_POST['idInfoProg'];
    $division = $_POST['division'];

    $sqlName = "SELECT Name FROM divinfogather WHERE idInfo = '$idInfoProg' AND division = '$division'";
    $resulName = mysqli_query($conn,$sqlName) or die(mysqli_error($conn));
    $progName = mysqli_fetch_array($resulName);
    $name = $progName['Name'];


    $slAO = "UPDATE divinfogather SET status = '1' WHERE idInfo = '$idInfoProg' AND division = '$division'";
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

            $queryUserDetails = "SELECT email FROM user_details WHERE empNo IN (SELECT reporter FROM divrisk WHERE mainUnit = '$division' UNION SELECT empNo FROM divactionowners WHERE indexRisk IN (SELECT indexRisk FROM divrisk WHERE mainUnit = '$division') UNION SELECT empNo FROM divriskowners WHERE indexRisk IN (SELECT indexRisk FROM divrisk WHERE mainUnit = '$division'))";
            $resultUserDetails = mysqli_query($conn,$queryUserDetails) or die(mysqli_error($conn));
            while($userDetails = mysqli_fetch_array($resultUserDetails)){

                $emailU = $userDetails['email'];
                
                $mail->addAddress($emailU);     // Add a recipient
            }

           /*  $queryAdminDetails = "SELECT email FROM user_details WHERE role = 'Admin'";
            $resultAdminDetails = mysqli_query($conn,$queryAdminDetails) or die(mysqli_error($conn));
            while($adminDetails = mysqli_fetch_array($resultAdminDetails)){

                $emailA = $adminDetails['email'];
                
                $mail->addCC($emailA);     // Add a recipient
            } */
                        
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'GT - Risk Registry';
            $mail->Body   = 'Dear All,<br><br>';
            $mail->Body   .= 'Thanks for providing updates on the new risk forseen and update on risk mitigation activities. We will extract the copy of risk registry as at today and share it with BCM secretariat as the <b>'.$name.'</b> risk update.<br><br>';
            $mail->Body   .= 'Need to include New Risks forseen for <b>'.$name.'</b> (if any).</li>';
            $mail->Body   .= 'However, if you have any update on risk, kindly update on the system and it will capture for the next quarter risk update.<br><br>';
            $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
            $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
            $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
            $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

            if(!$mail->send()){
                $data = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                echo $data;
            }else{
                $data = "true";
                echo $data;
            }
            
    }

    
?>