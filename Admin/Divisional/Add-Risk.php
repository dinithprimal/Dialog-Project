<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $businessImpact = $_POST['businessImpact'];
    $riskDescription = $_POST['riskDescription'];
    $riskCategory = $_POST['riskCategory'];
    //$riskOwner = $_POST['riskOwner'];
    $mainUnit = $_POST['mainUnit'];
    $kri = $_POST['kri'];
    $bau = $_POST['bau'];
    $riskAlert = $_POST['riskAlert'];
    $risk = $_POST['risk'];
    $cause = $_POST['cause'];
    $impact = $_POST['impact'];
    $likelyhoodLevel = $_POST['likelyhoodLevel'];
    $impactLevel = $_POST['impactLevel'];
    $riskLevel = $_POST['riskLevel'];
    $existingControl = $_POST['existingControl'];
    $controlEffectiveness = $_POST['controlEffectiveness'];
    $reslikelyhoodLevel = $_POST['reslikelyhoodLevel'];
    $resimpactLevel = $_POST['resimpactLevel'];
    $resriskLevel = $_POST['resriskLevel'];
    $riskResponse = $_POST['riskResponse'];
    $activity = $_POST['activity'];
    //$Owner = $_POST['Owner'];
    $deadline = $_POST['deadline'];
    $Effectiveness = $_POST['Effectiveness'];
    $currentStatus = $_POST['currentStatus'];
    $detailLevel = $_POST['detailLevel'];
    $reporter = $_POST['reporter'];
    $code = '';

    switch ($mainUnit) {
        case "Access Planning":
            $code = "AP";
            break;
        case "Broadband Planning":
            $code = "BP";
            break;
        case "CFSS":
            $code = "CFS";
            break;
        case "Core Network Planning":
            $code = "CNP";
            break;
        case "Data Center & Power Systems":
            $code = "DCP";
            break;
        case "DE-TAC":
            $code = "TAC";
            break;
        case "DNS":
            $code = "DNS";
            break;
        case "DTV":
            $code = "DTV";
            break;
        case "GTD":
            $code = "GTD";
            break;
        case "Network Strategy":
            $code = "NS";
            break;
        case "NOSA - ANO":
            $code = "ANO";
            break;
        case "NOSA - Core Network":
            $code = "CN";
            break;
        case "NOSA - CRC":
            $code = "CRC";
            break;
        case "NOSA - Enterprise Service Support":
            $code = "ESS";
            break;
        case "NOSA - Enterprise Service Support (IDC)":
            $code = "IDC";
            break;
        case "NOSA - Enterprise Service Support (SD)":
            $code = "ESD";
            break;
        case "NOSA - NSQ":
            $code = "NSQ";
            break;
        case "NOSA - PS & International":
            $code = "PSI";
            break;
        case "NOSA - TNO":
            $code = "TNO";
            break;
        case "NOSA - VAS":
            $code = "VAS";
            break;
        case "Product Development":
            $code = "PD";
            break;
        case "Project Planning":
            $code = "PP";
            break;
        case "TNP":
            $code = "TNP";
            break;
        case "TSC":
            $code = "TSC";
            break;
    }

    
    
    $Dt = new DateTime();
    $Date = $Dt->format("Y-m-d");

    $Time = $Dt->format("H:i:s");

    $getCount = "SELECT COUNT(*) AS tot FROM divtrindex WHERE code = '$code'";
    $result_getCount = mysqli_query($conn,$getCount) or die(mysqli_error($conn));
    $count = mysqli_fetch_array($result_getCount);

    $countTR = $count['tot'] + 1;
    if($countTR<10){
        $TR = ''.$code.'000'.$countTR.'';
    }else if ($countTR>=10 AND $countTR<100){
        $TR = ''.$code.'00'.$countTR.'';
    }else if ($countTR>=100 AND $countTR<1000){
        $TR = ''.$code.'0'.$countTR.'';
    }else if ($countTR>=1000 AND $countTR<10000){
        $TR = ''.$code.''.$countTR.'';
    }else{
        $TR = ''.$code.''.$countTR.'';
    }

    $sqlReporterDetails = "SELECT fullName FROM user_details WHERE empNo = '$reporter'";
    $resultReporterDetails = mysqli_query($conn,$sqlReporterDetails) or die(mysqli_error($conn));
    $reporterDetails = mysqli_fetch_array($resultReporterDetails);
    $reporterName = $reporterDetails['fullName'];

    $queryInesrtRisk = "INSERT INTO divtrindex (code,indexRisk, status) VALUES ('$code','$TR', 'Active')";
    if($conn->query($queryInesrtRisk)=== TRUE){
        $queryRisk = "INSERT INTO divrisk (indexRisk,businessObj,description,cateory,mainUnit,kri,bau,riskAlert,risk,cause,impact,likelyhoodLevel,impactLevel,riskLevel,existingControl,ContrEffectv,reslikelyhoodLevel,resimpactLevel,resriskLevel,riskResponse,Effectiveness,currentStatus,reporter,reportedDate,reportedTime,keyRiskTag,closeStatus) VALUES ('$TR','$businessImpact','$riskDescription','$riskCategory','$mainUnit','$kri','$bau','$riskAlert','$risk','$cause','$impact','$likelyhoodLevel','$impactLevel','$riskLevel','$existingControl','$controlEffectiveness','$reslikelyhoodLevel','$resimpactLevel','$resriskLevel','$riskResponse','$Effectiveness','$currentStatus','$reporter','$Date','$Time','0','0')";	
        if($conn->query($queryRisk)=== TRUE){
            for($count = 1; $count<count($_POST['riskOwner']); $count++){
                $emp = $_POST['riskOwner'][$count];
                $sl = "INSERT INTO divriskowners (indexRisk, empNo) VALUES ('$TR','$emp')";
                if($conn->query($sl) === TRUE){

                    $sqlUserDetails = "SELECT fName, email FROM user_details WHERE empNo = '$emp'";
                    $resultUserDetails = mysqli_query($conn,$sqlUserDetails) or die(mysqli_error($conn));
                    $userDetails = mysqli_fetch_array($resultUserDetails);

                    $email = $userDetails['email'];
                    $fName = $userDetails['fName'];

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

                    $mail->Subject = 'GT - Risk Registry : '.$TR.'';
                    $mail->Body   = 'Dear '.$fName.',<br><br>';
                    $mail->Body   .= '<em>'.$TR.'</em> risk recorded in the system by <em>'.$reporterName.'</em> and tagged you as a "Risk Owner" to take necessary action to mitigate the risk.<br>';
                    $mail->Body   .= 'Click on the below link to login and view the risk / update the status of activities.<br><br>';
                    $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
                    $mail->Body   .= 'Risk Description - <em>'.$riskDescription.'</em><br><br>';
                    $mail->Body   .= 'Risk Impact - <em>'.$impact.'</em><br><br>';
                    $mail->Body   .= 'Activity - <em>'.$activity.'</em><br><br>';
                    $mail->Body   .= 'Action - <em>'.$detailLevel.'</em><br><br>';
                    $mail->Body   .= 'Due Date - <em>'.$deadline.'</em><br><br>';
                    $mail->Body   .= 'Residual Risk Level - <em>'.$resriskLevel.'</em><br><br>';
                    $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
                    $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
                    $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';


                    if(!$mail->send()){
                        //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                    }else{
                        continue;
                    }
                }
            }
            for($countAO = 1; $countAO<count($_POST['Owner']); $countAO++){
                $empAO = $_POST['Owner'][$countAO];
                $slAO = "INSERT INTO divactionowners (indexRisk, empNo) VALUES ('$TR','$empAO')";
                if($conn->query($slAO) === TRUE){
                    $sqlUserDetails = "SELECT fName, email FROM user_details WHERE empNo = '$empAO'";
                    $resultUserDetails = mysqli_query($conn,$sqlUserDetails) or die(mysqli_error($conn));
                    $userDetails = mysqli_fetch_array($resultUserDetails);

                    $email = $userDetails['email'];
                    $fName = $userDetails['fName'];

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

                    $mail->Subject = 'GT - Risk Registry : '.$TR.'';
                    $mail->Body   = 'Dear '.$fName.',<br><br>';
                    $mail->Body   .= '<em>'.$TR.'</em> risk recorded in the system by <em>'.$reporterName.'</em> and tagged you as a "Action Owner" to take necessary action to mitigate the risk.<br>';
                    $mail->Body   .= 'Click on the below link to login and view the risk / update the status of activities.<br><br>';
                    $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
                    $mail->Body   .= 'Risk Description - <em>'.$riskDescription.'</em><br><br>';
                    $mail->Body   .= 'Risk Impact - <em>'.$impact.'</em><br><br>';
                    $mail->Body   .= 'Activity - <em>'.$activity.'</em><br><br>';
                    $mail->Body   .= 'Action - <em>'.$detailLevel.'</em><br><br>';
                    $mail->Body   .= 'Due Date - <em>'.$deadline.'</em><br><br>';
                    $mail->Body   .= 'Residual Risk Level - <em>'.$resriskLevel.'</em><br><br>';
                    $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
                    $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
                    $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

                    if(!$mail->send()){
                        //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                    }else{
                        continue;
                    }
                }
            }

            $mail2 = new PHPMailer;
            //$mail->SMTPDebug = 4; 
            $mail2->SMTPDebug = false;                                // Disable verbose debug output

            $mail2->isSMTP();                                      // Set mailer to use SMTP
            $mail2->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
            $mail2->SMTPAuth = true;                               // Enable SMTP authentication
            $mail2->Username = EMAIL;                 // SMTP username
            $mail2->Password = PASS;                           // SMTP password
            $mail2->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail2->Port = 587;                                    // TCP port to connect to

            $mail2->setFrom(EMAIL, 'GT - Risk Management');

            $queryAdminDetails = "SELECT email FROM user_details WHERE role = 'Admin'";
            $resultAdminDetails = mysqli_query($conn,$queryAdminDetails) or die(mysqli_error($conn));
            while($adminDetails = mysqli_fetch_array($resultAdminDetails)){

                $emailA = $adminDetails['email'];
                
                $mail2->addAddress($emailA);     // Add a recipient
            }
                        
            $mail2->isHTML(true);                                  // Set email format to HTML

            $mail2->Subject = 'GT - Risk Registry : '.$TR.'';
            $mail2->Body   = 'Dear Admin,<br><br>';
            $mail2->Body   .= ''.$reporterName.' added new risk to the system and risk details are follows.<br><br>';
            $mail2->Body   .= 'Risk Index - <em>'.$TR.'</em><br><br>';
            $mail2->Body   .= 'Risk Description - <em>'.$riskDescription.'</em><br><br>';
            $mail2->Body   .= 'Risk Impact - <em>'.$impact.'</em><br><br>';
            $mail2->Body   .= 'Activity - <em>'.$activity.'</em><br><br>';
            $mail2->Body   .= 'Action - <em>'.$detailLevel.'</em><br><br>';
            $mail2->Body   .= 'Due Date - <em>'.$deadline.'</em><br><br>';
            $mail2->Body   .= 'Residual Risk Level - <em>'.$resriskLevel.'</em><br><br>';
            $mail2->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
            $mail2->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
            $mail2->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

            if(!$mail2->send()){
                $data = 'Message could not be sent. Mailer Error: ' . $mail2->ErrorInfo;
                echo $data;
            }else{
                
            }

            $queryActivity = "INSERT INTO divrisktreatmentactivity (indexRisk,activity,empNo,date,time) VALUES ('$TR','$activity','$reporter','$Date','$Time')";
            if($conn->query($queryActivity)=== TRUE){
                if($deadline != '-'){
                    $queryDeadline = "INSERT INTO divrisktreatmentdeadline (indexRisk,deadline,empNo,date,time) VALUES ('$TR','$deadline','$reporter','$Date','$Time')";
                    if($conn->query($queryDeadline)=== TRUE){
                    }
                }
                $queryResponseAction = "INSERT INTO divrisktreatmentresponseaction (indexRisk,action,empNo,date,time) VALUES ('$TR','$detailLevel','$reporter','$Date','$Time')";
                if($conn->query($queryResponseAction)=== TRUE){
                    $queryLastUpdate = "INSERT INTO divlastupdate (indexRisk,empNo,date,time) VALUES ('$TR','$reporter','$Date','$Time')";
                    if($conn->query($queryLastUpdate)=== TRUE){
                        $queryResActivity = "INSERT INTO divactivity (indexRisk,empNo,Date,Time,Des) VALUES ('$TR','$reporter','$Date','$Time','Newly Added')";
                        if($conn->query($queryResActivity)=== TRUE){
                            $data = 'True';
                            echo $data;
                        }else{
                            $data = 'false';
                            echo $data;
                        }
                    }else{
                        $data = 'false';
                        echo $data;
                    }
                }else{
                    $data = 'false';
                    echo $data;
                }
            }else{
                $data = 'false';
                echo $data;
            }
        }else{
            $data = 'false';
            echo $data;
        }
    }else{
        $data = 'false';
        echo $data;
    }
?>