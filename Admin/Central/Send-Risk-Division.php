<?php
    include("../database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $empNo = $_POST['empNo'];
    $indexRisk = $_POST['indexRisk'];

    $queryCheckCount = "SELECT COUNT(*) AS moveTot FROM moverisk WHERE ERMindexRisk = '$indexRisk'";
    $resultCheckCount = mysqli_query($conn,$queryCheckCount) or die(mysqli_error($conn));
    $checkCount = mysqli_fetch_array($resultCheckCount);
    $moveCount = $checkCount['moveTot'];

    $sqlRiskMove = "SELECT * FROM trindex WHERE indexRisk = '$indexRisk'";
    $resultRiskMove = mysqli_query($conn,$sqlRiskMove) or die(mysqli_error($conn));
    $riskMove = mysqli_fetch_array($resultRiskMove);

    $riskMoverName = "User";

    $riskStatus = $riskMove['status'];
    if($riskStatus == "Pending"){
        $riskMover = $riskMove['moveRequest'];
    }else{
        $riskMover = $empNo;
    }

    $queryMoverName = "SELECT fullName FROM user_details WHERE empNo = '$riskMover'";
    $resultMoverName = mysqli_query($conn,$queryMoverName) or die(mysqli_error($conn));
    $userMoverName = mysqli_fetch_array($resultMoverName);
    $riskMoverName = $userMoverName['fullName'];

    if($moveCount == 0){

        $sqlRiskDetails = "SELECT * FROM risk WHERE indexRisk = '$indexRisk'";
        $resultRiskDetails = mysqli_query($conn,$sqlRiskDetails) or die(mysqli_error($conn));
        $riskDetails = mysqli_fetch_array($resultRiskDetails);

        $businessObj = $riskDetails['businessObj'];
        $description = $riskDetails['description'];
        $cateory = $riskDetails['cateory'];
        $mainUnit = $riskDetails['mainUnit'];
        $kri = $riskDetails['kri'];
        $bau = $riskDetails['bau'];
        $riskAlert = $riskDetails['riskAlert'];
        $risk = $riskDetails['risk'];
        $cause = $riskDetails['cause'];
        $impact = $riskDetails['impact'];
        $riskLevel = $riskDetails['riskLevel'];
        $likelyhoodLevel = $riskDetails['likelyhoodLevel'];
        $impactLevel = $riskDetails['impactLevel'];
        $existingControl = $riskDetails['existingControl'];
        $ContrEffectv = $riskDetails['ContrEffectv'];
        $reslikelyhoodLevel = $riskDetails['reslikelyhoodLevel'];
        $resimpactLevel = $riskDetails['resimpactLevel'];
        $resriskLevel = $riskDetails['resriskLevel'];
        $riskResponse = $riskDetails['riskResponse'];
        $Effectiveness = $riskDetails['Effectiveness'];
        $currentStatus = $riskDetails['currentStatus'];
        $reporter = $riskDetails['reporter'];
        $reportedDate = $riskDetails['reportedDate'];
        $reportedTime = $riskDetails['reportedTime'];
        $keyRiskTag = $riskDetails['keyRiskTag'];
        $closeStatus = $riskDetails['closeStatus'];

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

        $queryInesrtRisk = "INSERT INTO divtrindex (code,indexRisk, status) VALUES ('$code','$TR', 'Active')";
        if($conn->query($queryInesrtRisk)=== TRUE){
            $queryRisk = "INSERT INTO divrisk (indexRisk,businessObj,description,cateory,mainUnit,kri,bau,riskAlert,risk,cause,impact,likelyhoodLevel,impactLevel,riskLevel,existingControl,ContrEffectv,reslikelyhoodLevel,resimpactLevel,resriskLevel,riskResponse,Effectiveness,currentStatus,reporter,reportedDate,reportedTime,keyRiskTag,closeStatus) VALUES ('$TR','$businessObj','$description','$cateory','$mainUnit','$kri','$bau','$riskAlert','$risk','$cause','$impact','$likelyhoodLevel','$impactLevel','$riskLevel','$existingControl','$ContrEffectv','$reslikelyhoodLevel','$resimpactLevel','$resriskLevel','$riskResponse','$Effectiveness','$currentStatus','$reporter','$reportedDate','$reportedTime','$keyRiskTag','$closeStatus')";	
            if($conn->query($queryRisk)=== TRUE){
                $queryRiskOwners = "SELECT empNO FROM riskowners WHERE indexRisk = '$indexRisk'";
                $resultRiskOwners = mysqli_query($conn,$queryRiskOwners) or die(mysqli_error($conn));
                while($riskOwners = mysqli_fetch_array($resultRiskOwners)){
                    $emp = $riskOwners['empNO']; 
                    $sl = "INSERT INTO divriskowners (indexRisk, empNo) VALUES ('$TR','$emp')";
                    if($conn->query($sl) === TRUE){

                    }
                }
                $queryActionOwners = "SELECT empNO FROM actionowners WHERE indexRisk = '$indexRisk'";
                $resultActionOwners = mysqli_query($conn,$queryActionOwners) or die(mysqli_error($conn));
                while($actionOwners = mysqli_fetch_array($resultActionOwners)){
                    $emp = $actionOwners['empNO']; 
                    $sl = "INSERT INTO divactionowners (indexRisk, empNo) VALUES ('$TR','$emp')";
                    if($conn->query($sl) === TRUE){
                    }
                }
                $sqlRiskDeadline = "SELECT * FROM risktreatmentdeadline WHERE indexRisk = '$indexRisk' ORDER BY id";
                $resultRiskDeadline = mysqli_query($conn,$sqlRiskDeadline) or die(mysqli_error($conn));
                while($riskDeadline = mysqli_fetch_array($resultRiskDeadline)){
                    $deadline = $riskDeadline['deadline'];
                    $reporter = $riskDeadline['empNo'];
                    $Date = $riskDeadline['date'];
                    $Time = $riskDeadline['time'];
                    $queryDeadline = "INSERT INTO divrisktreatmentdeadline (indexRisk,deadline,empNo,date,time) VALUES ('$TR','$deadline','$reporter','$Date','$Time')";
                    if($conn->query($queryDeadline)=== TRUE){
                    }
                }
                $sqlRiskAction = "SELECT * FROM risktreatmentresponseaction WHERE indexRisk = '$indexRisk' ORDER BY id";
                $resultRiskAction = mysqli_query($conn,$sqlRiskAction) or die(mysqli_error($conn));
                while($riskAction = mysqli_fetch_array($resultRiskAction)){
                    $detailLevel = $riskAction['action'];
                    $reporter = $riskAction['empNo'];
                    $Date = $riskAction['date'];
                    $Time = $riskAction['time'];
                    $queryResponseAction = "INSERT INTO divrisktreatmentresponseaction (indexRisk,action,empNo,date,time) VALUES ('$TR','$detailLevel','$reporter','$Date','$Time')";
                    if($conn->query($queryResponseAction)=== TRUE){
                    }
                }
                $sqlRiskActivity = "SELECT * FROM risktreatmentactivity WHERE indexRisk = '$indexRisk' ORDER BY id";
                $resultRiskActivity = mysqli_query($conn,$sqlRiskActivity) or die(mysqli_error($conn));
                while($riskActivity = mysqli_fetch_array($resultRiskActivity)){
                    $activity = $riskActivity['activity'];
                    $reporter = $riskActivity['empNo'];
                    $Date = $riskActivity['date'];
                    $Time = $riskActivity['time'];
                    $queryActivity = "INSERT INTO divrisktreatmentactivity (indexRisk,activity,empNo,date,time) VALUES ('$TR','$activity','$reporter','$Date','$Time')";
                    if($conn->query($queryActivity)=== TRUE){
                    }
                }

                $Dt = new DateTime();
                $Date = $Dt->format("Y-m-d");

                $Time = $Dt->format("H:i:s");

                $queryResActivity = "INSERT INTO divactivity (indexRisk,empNo,Date,Time,Des) VALUES ('$TR','$riskMover','$Date','$Time','Moved from ERM')";
                if($conn->query($queryResActivity)=== TRUE){
                    $queryLastUpdate = "INSERT INTO divlastupdate (indexRisk,empNo,date,time) VALUES ('$TR','$riskMover','$Date','$Time')";
                    if($conn->query($queryLastUpdate)=== TRUE){

                        $queryEmails = "SELECT email FROM user_details WHERE empNo IN (SELECT reporter FROM risk WHERE indexRisk = '$indexRisk' UNION SELECT empNo FROM riskowners WHERE indexRisk = '$indexRisk' UNION SELECT empNo FROM actionowners WHERE indexRisk = '$indexRisk')";
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
                        $mail->Body   .= ''.$riskMoverName.', transferred the risk <em>'.$indexRisk.'</em> from ERM to <em>'.$mainUnit.'</em> divisional risk registry. <br><br>Divisional Risk Index- <em>'.$TR.'</em><bR><br>';
                        $mail->Body   .= 'Click on the below link to login and view the risk / update the status of activities.<br><br>';
                        $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
                        $mail->Body   .= 'Division - <em>'.$mainUnit.'</em><br><br>';
                        $mail->Body   .= 'Risk Description - <em>'.$description.'</em><br><br>';
                        $mail->Body   .= 'Impact - <em>'.$impact.'</em><br><br>';
                        $mail->Body   .= 'Residual Risk Level - <em>'.$resriskLevel.'</em><br><br>';
                        $mail->Body   .= 'Due Date - <em>'.$deadline.'</em><br><br>';
                        $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
                        $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
                        $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

                        if(!$mail->send()){
                            //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                        }else{

                        }

                        $queryActivity = "INSERT INTO activity (indexRisk, empNo, Date, Time, Des) VALUES ('$indexRisk', '$riskMover', '$Date', '$Time', 'Moved to Divisional Risk Registry')";
                        if($conn->query($queryActivity) === TRUE){
                            $queryLastUpdate = "UPDATE lastupdate SET empNo = '$riskMover', date = '$Date', time = '$Time' WHERE indexRisk = '$indexRisk'";
                            if($conn->query($queryLastUpdate) === TRUE){
                                $queryUpdateTrindex = "UPDATE trindex SET status = 'Inactive' WHERE indexRisk = '$indexRisk'";
                                if($conn->query($queryUpdateTrindex) === TRUE){
                                    $queryMove = "INSERT INTO moverisk (ERMindexRisk, DIVindexRisk, position) VALUES ('$indexRisk', '$TR', 'Divisional')";
                                    if($conn->query($queryMove) === TRUE){
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
                        }else{
                            $data = "false";
                        }

                    }else{
                        $data = 'false';
                    }
                }else{
                    $data = 'false';
                }
            }else{
                $data = 'false';
            }
        }else{
            $data = 'false';
        } 

    }else{

        
        $sqlRiskDetails = "SELECT * FROM risk WHERE indexRisk = '$indexRisk'";
        $resultRiskDetails = mysqli_query($conn,$sqlRiskDetails) or die(mysqli_error($conn));
        $riskDetails = mysqli_fetch_array($resultRiskDetails);

        $businessObj = $riskDetails['businessObj'];
        $description = $riskDetails['description'];
        $cateory = $riskDetails['cateory'];
        $mainUnit = $riskDetails['mainUnit'];
        $kri = $riskDetails['kri'];
        $bau = $riskDetails['bau'];
        $riskAlert = $riskDetails['riskAlert'];
        $risk = $riskDetails['risk'];
        $cause = $riskDetails['cause'];
        $impact = $riskDetails['impact'];
        $riskLevel = $riskDetails['riskLevel'];
        $likelyhoodLevel = $riskDetails['likelyhoodLevel'];
        $impactLevel = $riskDetails['impactLevel'];
        $existingControl = $riskDetails['existingControl'];
        $ContrEffectv = $riskDetails['ContrEffectv'];
        $reslikelyhoodLevel = $riskDetails['reslikelyhoodLevel'];
        $resimpactLevel = $riskDetails['resimpactLevel'];
        $resriskLevel = $riskDetails['resriskLevel'];
        $riskResponse = $riskDetails['riskResponse'];
        $Effectiveness = $riskDetails['Effectiveness'];
        $currentStatus = $riskDetails['currentStatus'];
        $reporter = $riskDetails['reporter'];
        $reportedDate = $riskDetails['reportedDate'];
        $reportedTime = $riskDetails['reportedTime'];
        $keyRiskTag = $riskDetails['keyRiskTag'];
        $closeStatus = $riskDetails['closeStatus'];

        $queryDIVindexRisk = "SELECT DIVindexRisk FROM moverisk WHERE ERMindexRisk = '$indexRisk'";
        $resultDIVindexRisk = mysqli_query($conn,$queryDIVindexRisk) or die(mysqli_error($conn));
        $DIVindexRisk = mysqli_fetch_array($resultDIVindexRisk);
        $TR = $DIVindexRisk['DIVindexRisk'];

        $queryInesrtRisk = "UPDATE divtrindex SET status = 'Active' WHERE indexRisk = '$TR'";
        if($conn->query($queryInesrtRisk)=== TRUE){
            $queryRisk = "UPDATE divrisk SET businessObj = '$businessObj', description = '$description', cateory = '$cateory', mainUnit = '$mainUnit', kri = '$kri', bau = '$bau', riskAlert = '$riskAlert', risk = '$risk', cause = '$cause', impact = '$impact', likelyhoodLevel = '$likelyhoodLevel', impactLevel = '$impactLevel', riskLevel = '$riskLevel', existingControl = '$existingControl', ContrEffectv = '$ContrEffectv', reslikelyhoodLevel = '$reslikelyhoodLevel', resimpactLevel = '$resimpactLevel', resriskLevel = '$resriskLevel', riskResponse = '$riskResponse', Effectiveness = '$Effectiveness', currentStatus = '$currentStatus', reporter = '$reporter', reportedDate = '$reportedDate', reportedTime = '$reportedTime', keyRiskTag = '$keyRiskTag', closeStatus = '$closeStatus' WHERE indexRisk = '$TR'";	
            if($conn->query($queryRisk)=== TRUE){
                $queryDelRiskOwners = "DELETE FROM divriskowners WHERE indexRisk = '$TR'";
                if($conn->query($queryDelRiskOwners)=== TRUE){
                }
                $queryRiskOwners = "SELECT empNO FROM riskowners WHERE indexRisk = '$indexRisk'";
                $resultRiskOwners = mysqli_query($conn,$queryRiskOwners) or die(mysqli_error($conn));
                while($riskOwners = mysqli_fetch_array($resultRiskOwners)){
                    $emp = $riskOwners['empNO']; 
                    $sl = "INSERT INTO divriskowners (indexRisk, empNo) VALUES ('$TR','$emp')";
                    if($conn->query($sl) === TRUE){

                    }
                }
                $queryDelActionOwners = "DELETE FROM divactionowners WHERE indexRisk = '$TR'";
                if($conn->query($queryDelActionOwners)=== TRUE){
                }
                $queryActionOwners = "SELECT empNO FROM actionowners WHERE indexRisk = '$indexRisk'";
                $resultActionOwners = mysqli_query($conn,$queryActionOwners) or die(mysqli_error($conn));
                while($actionOwners = mysqli_fetch_array($resultActionOwners)){
                    $emp = $actionOwners['empNO']; 
                    $sl = "INSERT INTO divactionowners (indexRisk, empNo) VALUES ('$TR','$emp')";
                    if($conn->query($sl) === TRUE){
                    }
                }
                $queryDelDeadline = "DELETE FROM divrisktreatmentdeadline WHERE indexRisk = '$TR'";
                if($conn->query($queryDelDeadline)=== TRUE){
                }
                $sqlRiskDeadline = "SELECT * FROM risktreatmentdeadline WHERE indexRisk = '$indexRisk' ORDER BY id";
                $resultRiskDeadline = mysqli_query($conn,$sqlRiskDeadline) or die(mysqli_error($conn));
                while($riskDeadline = mysqli_fetch_array($resultRiskDeadline)){
                    $deadline = $riskDeadline['deadline'];
                    $reporter = $riskDeadline['empNo'];
                    $Date = $riskDeadline['date'];
                    $Time = $riskDeadline['time'];
                    $queryDeadline = "INSERT INTO divrisktreatmentdeadline (indexRisk,deadline,empNo,date,time) VALUES ('$TR','$deadline','$reporter','$Date','$Time')";
                    if($conn->query($queryDeadline)=== TRUE){
                    }
                }
                $queryDelAction = "DELETE FROM divrisktreatmentresponseaction WHERE indexRisk = '$TR'";
                if($conn->query($queryDelAction)=== TRUE){
                }
                $sqlRiskAction = "SELECT * FROM risktreatmentresponseaction WHERE indexRisk = '$indexRisk' ORDER BY id";
                $resultRiskAction = mysqli_query($conn,$sqlRiskAction) or die(mysqli_error($conn));
                while($riskAction = mysqli_fetch_array($resultRiskAction)){
                    $detailLevel = $riskAction['action'];
                    $reporter = $riskAction['empNo'];
                    $Date = $riskAction['date'];
                    $Time = $riskAction['time'];
                    $queryResponseAction = "INSERT INTO divrisktreatmentresponseaction (indexRisk,action,empNo,date,time) VALUES ('$TR','$detailLevel','$reporter','$Date','$Time')";
                    if($conn->query($queryResponseAction)=== TRUE){
                    }
                }
                $queryDelActivity = "DELETE FROM divrisktreatmentactivity WHERE indexRisk = '$TR'";
                if($conn->query($queryDelActivity)=== TRUE){
                }
                $sqlRiskActivity = "SELECT * FROM risktreatmentactivity WHERE indexRisk = '$indexRisk' ORDER BY id";
                $resultRiskActivity = mysqli_query($conn,$sqlRiskActivity) or die(mysqli_error($conn));
                while($riskActivity = mysqli_fetch_array($resultRiskActivity)){
                    $activity = $riskActivity['activity'];
                    $reporter = $riskActivity['empNo'];
                    $Date = $riskActivity['date'];
                    $Time = $riskActivity['time'];
                    $queryActivity = "INSERT INTO divrisktreatmentactivity (indexRisk,activity,empNo,date,time) VALUES ('$TR','$activity','$reporter','$Date','$Time')";
                    if($conn->query($queryActivity)=== TRUE){
                    }
                }

                $Dt = new DateTime();
                $Date = $Dt->format("Y-m-d");

                $Time = $Dt->format("H:i:s");

                $queryResActivity = "INSERT INTO divactivity (indexRisk,empNo,Date,Time,Des) VALUES ('$TR','$riskMover','$Date','$Time','Moved from ERM')";
                if($conn->query($queryResActivity)=== TRUE){
                    $queryLastUpdate = "UPDATE divlastupdate SET empNo = '$riskMover', date = '$Date', time = '$Time' WHERE indexRisk = '$TR'";
                    if($conn->query($queryLastUpdate)=== TRUE){

                        $queryEmails = "SELECT email FROM user_details WHERE empNo IN (SELECT reporter FROM risk WHERE indexRisk = '$indexRisk' UNION SELECT empNo FROM riskowners WHERE indexRisk = '$indexRisk' UNION SELECT empNo FROM actionowners WHERE indexRisk = '$indexRisk')";
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
                        $mail->Body   .= ''.$riskMoverName.', transferred the risk <em>'.$indexRisk.'</em> from ERM to <em>'.$mainUnit.'</em> divisional risk registry. <br><br>Divisional Risk Index- <em>'.$TR.'</em><bR><br>';
                        $mail->Body   .= 'Click on the below link to login and view the risk / update the status of activities.<br><br>';
                        $mail->Body   .= 'Link - <a href="http://172.26.59.67:8080/">Risk Register Management System</a><br><br>';
                        $mail->Body   .= 'Division - <em>'.$mainUnit.'</em><br><br>';
                        $mail->Body   .= 'Risk Description - <em>'.$description.'</em><br><br>';
                        $mail->Body   .= 'Impact - <em>'.$impact.'</em><br><br>';
                        $mail->Body   .= 'Residual Risk Level - <em>'.$resriskLevel.'</em><br><br>';
                        $mail->Body   .= 'Due Date - <em>'.$deadline.'</em><br><br>';
                        $mail->Body   .= 'If you have any concern please contact Nuwantha Rodrigo or Dimuthu Balasooriya.<br><br>';
                        $mail->Body   .= '<small><span style="color:red">Note - Please note that you can access the link through VPN only.</span></small><br><br>';
                        $mail->Body   .= '<br>Thank You and Best Regard,<br>GTD Team.';

                        if(!$mail->send()){
                            //$des = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                        }else{

                        }

                        $queryActivity = "INSERT INTO activity (indexRisk, empNo, Date, Time, Des) VALUES ('$indexRisk', '$riskMover', '$Date', '$Time', 'Moved to Divisional Risk Registry')";
                        if($conn->query($queryActivity) === TRUE){
                            $queryLastUpdate = "UPDATE lastupdate SET empNo = '$riskMover', date = '$Date', time = '$Time' WHERE indexRisk = '$indexRisk'";
                            if($conn->query($queryLastUpdate) === TRUE){
                                $queryUpdateTrindex = "UPDATE trindex SET status = 'Inactive' WHERE indexRisk = '$indexRisk'";
                                if($conn->query($queryUpdateTrindex) === TRUE){
                                    $queryMove = "UPDATE moverisk SET position = 'Divisional' WHERE ERMindexRisk = '$indexRisk' AND DIVindexRisk = '$TR'";
                                    if($conn->query($queryMove) === TRUE){
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
                        }else{
                            $data = "false";
                        }

                    }else{
                        $data = 'false';
                    }
                }else{
                    $data = 'false';
                }
            }else{
                $data = 'false';
            }
        }else{
            $data = 'false';
        } 

    }

    echo $data;

    
?>