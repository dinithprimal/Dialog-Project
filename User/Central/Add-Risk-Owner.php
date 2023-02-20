<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $indexRisk = $_POST['indexRisk'];

    $sqlRiskDetails = "SELECT description, impact, resriskLevel FROM risk WHERE indexRisk = '$indexRisk'";
    $resultRiskDetails = mysqli_query($conn,$sqlRiskDetails) or die(mysqli_error($conn));
    $riskDetails = mysqli_fetch_array($resultRiskDetails);

    $riskDescription = $riskDetails['description'];
    $impact = $riskDetails['impact'];
    $resriskLevel = $riskDetails['resriskLevel'];

    $sqlRiskDeadline = "SELECT deadline FROM risktreatmentdeadline WHERE indexRisk = '$indexRisk' ORDER BY id DESC LIMIT 1";
    $resultRiskDeadline = mysqli_query($conn,$sqlRiskDeadline) or die(mysqli_error($conn));
    $riskDeadline = mysqli_fetch_array($resultRiskDeadline);

    $deadline = $riskDeadline['deadline'];

    $sqlRiskAction = "SELECT action FROM risktreatmentresponseaction WHERE indexRisk = '$indexRisk' ORDER BY id DESC LIMIT 1";
    $resultRiskAction = mysqli_query($conn,$sqlRiskAction) or die(mysqli_error($conn));
    $riskAction = mysqli_fetch_array($resultRiskAction);

    $detailLevel = $riskAction['action'];

    $sqlReporterDetails = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
    $resultReporterDetails = mysqli_query($conn,$sqlReporterDetails) or die(mysqli_error($conn));
    $reporterDetails = mysqli_fetch_array($resultReporterDetails);
    $reporterName = $reporterDetails['fullName'];

    
    for($countRO = 0; $countRO<count($_POST['idRiskOwners']); $countRO++){
        $empRO = $_POST['idRiskOwners'][$countRO];
        $slRO = "INSERT INTO riskowners (indexRisk, empNo) VALUES ('$indexRisk','$empRO')";
        if($conn->query($slRO) === TRUE){
            
            $queryUserName = "SELECT fullName, fName, email FROM user_details WHERE empNo = '$empRO'";
            $resultUserName = mysqli_query($conn,$queryUserName) or die(mysqli_error($conn));
            $userName = mysqli_fetch_array($resultUserName);
            $ROname = $userName['fullName'];

            $Dt = new DateTime();
            $Date = $Dt->format("Y-m-d");

            $Time = $Dt->format("H:i:s");

            $email = $userName['email'];
            $fName = $userName['fName'];

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

            $mail->Subject = 'GT - Risk Registry : '.$indexRisk.'';
            $mail->Body   = 'Dear '.$fName.',<br><br>';
            $mail->Body   .= '<em>'.$indexRisk.'</em> risk recorded in the system by <em>'.$reporterName.'</em> and tagged you as a "Risk Owner" to take necessary action to mitigate the risk.<br>';
            $mail->Body   .= 'Click on the below link to login and view the risk / update the status of activities.<br><br>';
            $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
            $mail->Body   .= 'Risk Description - <em>'.$riskDescription.'</em><br><br>';
            $mail->Body   .= 'Risk Impact - <em>'.$impact.'</em><br><br>';
            $mail->Body   .= 'Action - <em>'.$detailLevel.'</em><br><br>';
            $mail->Body   .= 'Due Date - <em>'.$deadline.'</em><br><br>';
            $mail->Body   .= 'Residual Risk Level - <em>'.$resriskLevel.'</em><br><br>';
            $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
            $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
            $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

            if(!$mail->send()){
                //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }else{

            }

            $queryActivity = "INSERT INTO activity (indexRisk, empNo, Date, Time, Des, field,  updatedValue) VALUES ('$indexRisk', '$empNo', '$Date', '$Time', 'Add New Risk Owner','Risk Owners', '$ROname')";
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
    }

    echo $data;
?>