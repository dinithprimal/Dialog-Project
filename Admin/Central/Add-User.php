<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $empNo = $_POST['empNo'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $division = $_POST['division'];
    $unit = $_POST['unit'];
    $category = $_POST['category'];

    if($category == 'Member'){
        $category = 'Body';
    }

    function userName($fname,$empid){
        $username = ''.$fname.'_'.$empid.'';
        return $username;
    }

    $sqlValidate = "SELECT COUNT(*) AS tot FROM user_details WHERE empNo = '$empNo' OR email = '$email'";
    $resultValidate = mysqli_query($conn,$sqlValidate) or die(mysqli_error($conn));
    $validate = mysqli_fetch_array($resultValidate);

    $count = $validate['tot'];

    if($count == 0){

        $fullName = ''.$firstName.' '.$lastName.'';
        $username = userName($firstName,$empNo);

        $Dt = new DateTime();
        $Date = $Dt->format("Y-m-d");

        $str = "qwertyuiopasdfghjklzxcvbnm1234567890";
        $str = str_shuffle($str);
        $pw = substr($str,0,6);

        $slRO = "INSERT INTO user_details (username, password, pwExDate, fName, lName, fullName, empNo, email, role, department, unit, category, activeStatus) VALUES ('$username','$pw','$Date','$firstName','$lastName','$fullName','$empNo','$email','$role','$division','$unit','$category', 0)";
        if($conn->query($slRO) === TRUE){

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

            $mail->Subject = 'GT - Risk Registry';
            $mail->Body   = 'Dear '.$firstName.',<br><br>';
            $mail->Body   .= 'GTD team added you to the GT Risk Management System and now you can add, view and update risks in the GT Risk Management System.<br>';
            $mail->Body   .= 'Click on the below link to login and view the risks / update the status of activities.<br><br>';
            $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
            $mail->Body   .= 'Username - <em>'.$username.'</em><br><br>';
            $mail->Body   .= 'Password - <em>'.$pw.'</em><br><br>';
            $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
            $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
            $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

            if(!$mail->send()){
                $data = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }else{
                $data = "true";
            }

            
        }else{
            $data = "false";
        }
    }else{
        $data = "duplicate";
    }

    echo $data;
?>