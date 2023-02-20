<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];


    $sqlValidate = "SELECT email, fName FROM user_details WHERE empNo = '$empNo'";
    $resultValidate = mysqli_query($conn,$sqlValidate) or die(mysqli_error($conn));
    $validate = mysqli_fetch_array($resultValidate);

    $email = $validate['email'];
    $firstName = $validate['fName'];


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

        $mail->Subject = 'GT - Risk Registry : Test Mail';
        $mail->Body   = 'Dear '.$firstName.',<br><br>';
        $mail->Body   .= 'This is a <b>Test Mail</b> sent by your acount.<br>';
        $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

        if(!$mail->send()){
            $data = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }else{
            $data = "true";
        }

    echo $data;
?>