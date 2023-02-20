<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $deadline = $_POST['deadline'];
    $name = $_POST['name'];

    $DLDt = new DateTime($deadline);
    $DLDate = $DLDt->format("Y-m-d H:i:s");
    $emailDL = $DLDt->format("F j, Y, g:i a");

    $Dt = new DateTime();
    $Date = $Dt->format("Y-m-d H:i:s");

    $slAO = "INSERT INTO infogather (Name, startDate, endDate, status) VALUES ('$name','$Date','$DLDate','0')";
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

            $queryUserDetails = "SELECT email FROM user_details WHERE role = 'User'";
            $resultUserDetails = mysqli_query($conn,$queryUserDetails) or die(mysqli_error($conn));
            while($userDetails = mysqli_fetch_array($resultUserDetails)){

                $emailU = $userDetails['email'];
                
                $mail->addAddress($emailU);     // Add a recipient
            }

            $queryAdminDetails = "SELECT email FROM user_details WHERE role = 'Admin'";
            $resultAdminDetails = mysqli_query($conn,$queryAdminDetails) or die(mysqli_error($conn));
            while($adminDetails = mysqli_fetch_array($resultAdminDetails)){

                $emailA = $adminDetails['email'];
                
                $mail->addCC($emailA);     // Add a recipient
            }
                        
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'GT - Risk Registry';
            $mail->Body   = 'Dear All,<br><br>';
            $mail->Body   .= 'As requested by ERM, it is necessary to provide an update of Group Technology Risk Register for <b>'.$name.'</b>. Please note that system will only open till '.$emailDL.'.<br><br>';
            $mail->Body   .= '<ul>';
            $mail->Body   .= '<li>Need to include New Risks forseen for <b>'.$name.'</b> (if any).</li>';
            $mail->Body   .= '<li>Action owners of risk mitigation activities should update the status of risk mitigation activities assigned to you or if there is no update to provide for this quarter, mark it as no update.</li>';
            $mail->Body   .= '</ul>';
            $mail->Body   .= '<br><br>Kindly log into the risk registry (Link) to provide the updates.';
            $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
            $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
            $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
            $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

            if(!$mail->send()){
                $data = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                echo $data;
            }else{
                $data = "True";
                echo $data;
            }
            
    }

    
?>