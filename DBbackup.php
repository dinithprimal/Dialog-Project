<?php

    include("database.php");

    include_once('Mysqldump.php');

    $dump = new Ifsnop\Mysqldump\Mysqldump('mysql:host=localhost;dbname=risk_registry_system', 'root', '');

    $f = date('d-m-y');

    $dump->start("DB_Backups/$f.sql");

    require 'PHPMailerAutoload.php';
    require 'credential.php';

    $sqlAdminDetails = "SELECT email FROM user_details WHERE role = 'Admin'";
    $resultAdminDetails = mysqli_query($conn,$sqlAdminDetails) or die(mysqli_error($conn));

    $mail = new PHPMailer;

    $mail->SMTPDebug = false;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = EMAIL;                 // SMTP username
    $mail->Password = PASS;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom(EMAIL, 'GT - Risk Management');
    while($adminDetails = mysqli_fetch_array($resultAdminDetails)){
        $adminEmail = $adminDetails['email'];
        $mail->addAddress($adminEmail);     // Add a recipient
    }
                // Name is optional
    $mail->AddAttachment("DB_Backups/$f.sql");
    
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Database Backup - '.$f.'';
    $mail->Body    = 'Dear Admin,<br><br>';
    $mail->Body    .= 'Please refer to the attachedment of system databse backup.<br><br>';
    $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

    if(!$mail->send()){

    }else{

    }

?>