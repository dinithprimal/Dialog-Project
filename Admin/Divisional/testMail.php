
<?php

include("../database.php");

//$conn = mysqli_connect("localhost","root","","training");

require 'credential.php';

require 'PHPMailerAutoload.php';
//require 'credential.php';

for($i = 0; $i < 30; $i++){
    $mail = new PHPMailer;

    $mail->SMTPDebug = 4; 
    //$mail->SMTPDebug = false;                                // Disable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = /*'smtp.gmail.com';*/'smtp.office365.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = EMAIL;                 // SMTP username
    $mail->Password = PASS;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom(EMAIL, 'GT - Risk Management');
    //$mail->addAddress('dinith.primal-intern@dialog.lk', 'Dinith');     // Add a recipient
    //dinith.primal-intern@dialog.lk
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
                // Name is optional
    //$mail->addReplyTo(EMAIL);
    /*for($j=0;$j<count($ccMails);$j++){
        $mail->addCC($ccMails[$j]);
    }*/
    //$mail->addCC('niproban@gmail.com');
    //$mail->addBCC('bcc@example.com');

    // $file = $progDetails['wordFile'];

    // $mail->addStringAttachment($file,'wodr.docx');

    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Here is the subject';
    $mail->Body    = '<small>This is the HTML message body <b>in bold!</b></small><br><br>';
    $mail->Body .= '<a href="http://www.domain.com/register/registration.php?token=$token&stud_id=stud_id">hello</a>';
    $mail->AltBody = 'Click to Register';

    if(!$mail->send()){
        $des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        echo    'error with '.$i.'';
        continue;
    }else{
        $des = 'true';
        echo    $i;
        continue;
    }
}
echo $des;
?>
