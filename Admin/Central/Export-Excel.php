<?php  
//export.php 

    include("../database.php");

    //$conn = mysqli_connect("localhost","root","","training");

    $sqlGetIndex = "SELECT * FROM trindex WHERE status = 'Active'";
    $resultGetIndex = mysqli_query($conn, $sqlGetIndex);
    
    //$getIndex = mysqli_fetch_array($resultGetIndex);
    $output = '';

    if(mysqli_num_rows($resultGetIndex) > 0){
        $output .= '
                    <table class="table" bordered="1">  
                        <tr>  
                            <th>KR Flag</th>  
                            <th>Reported Date</th>  
                            <th>Reporter Ref</th>  
                            <th>Last Update</th>
                            <th>Main Unit</th>
                            <th>Index</th>
                            <th>Category</th>
                            <th>High Level Business Objective</th>
                            <th>Risk Description</th>
                            <th>Risk Owners</th>
                            <th>KRI</th>
                            <th>BAU</th>
                            <th>Alert</th>
                            <th>Risk</th>
                            <th>Cause</th>
                            <th>Impact</th>
                            <th>Likelyhood Level</th>
                            <th>Impact Level</th>
                            <th>Risk Level</th>
                            <th>Existing Control</th>
                            <th>Control Effectiveness</th>
                            <th>Residual Likelyhood Level</th>
                            <th>Residual Impact Level</th>
                            <th>Residual Risk Level</th>
                            <th>Risk Response</th>
                            <th>Activity</th>
                            <th>Action Owner</th>
                            <th>Deadline</th>
                            <th>Effectiveness of Risk Mitigation Method</th>
                            <th>Current Status</th>
                            <th>Current Progress / Remark</th>
                        </tr>
                        <tr>
                        </tr>
                    ';
        while($row = mysqli_fetch_array($resultGetIndex)){
            $indexRisk = $row['indexRisk'];
            $queryRiskDetails = "SELECT * FROM risk WHERE indexRisk = '$indexRisk'";
            $resultRiskDetails = mysqli_query($conn, $queryRiskDetails);
            $RiskDetails = mysqli_fetch_array($resultRiskDetails);

            $keyRiskTag = $RiskDetails['keyRiskTag'];
            if($keyRiskTag == 0){
                $keyRiskTag = '';
            }else if($keyRiskTag == 1){
                $keyRiskTag = 'Key Risk';
            }

            $reporterEmpNo = $RiskDetails['reporter'];
            $sqlReporterName = "SELECT fullName FROM user_details WHERE empNo = '$reporterEmpNo'";
            $resultReporterName = mysqli_query($conn, $sqlReporterName);
            $ReporterName = mysqli_fetch_array($resultReporterName);
            $fullName = $ReporterName['fullName'];

            $sqlLastUpdateDetails = "SELECT * FROM lastupdate WHERE indexRisk = '$indexRisk'";
            $resultLastUpdateDetails = mysqli_query($conn, $sqlLastUpdateDetails);
            $LastUpdateDetails = mysqli_fetch_array($resultLastUpdateDetails);
            $lastUpdateDate = $LastUpdateDetails['date'];
            $lastUpdateTime = $LastUpdateDetails['time'];
            $lastUpdateEmpNo = $LastUpdateDetails['empNo'];

            $sqlLastUpdateName = "SELECT fullName FROM user_details WHERE empNo = '$lastUpdateEmpNo'";
            $resultLastUpdateName = mysqli_query($conn, $sqlLastUpdateName);
            $lastUpdateName = mysqli_fetch_array($resultLastUpdateName);
            $lastUpdatefullName = $lastUpdateName['fullName'];

            $lastUpdate = ''.$lastUpdatefullName.'<br>'.$lastUpdateDate.' '.$lastUpdateTime.'';

            $sqlRiskOwnerEMP = "SELECT empNo FROM riskowners WHERE indexRisk = '$indexRisk'";
            $resultRiskOwnerEMP = mysqli_query($conn, $sqlRiskOwnerEMP);
            $riskOwners = '';
            $countriskOw = 1;
            while($RiskOwnerEMP = mysqli_fetch_array($resultRiskOwnerEMP)){
                $riskOwnerEmp = $RiskOwnerEMP['empNo'];
                $sqlFullNameRiskOwner = "SELECT fullName FROM user_details WHERE empNo = '$riskOwnerEmp'";
                $resultFullNameRiskOwner = mysqli_query($conn, $sqlFullNameRiskOwner);
                $arrayFullNameRiskOwner = mysqli_fetch_array($resultFullNameRiskOwner);
                $fullNameRiskOwner = $arrayFullNameRiskOwner['fullName'];
                if($countriskOw == 1){
                    $riskOwners .= ''.$fullNameRiskOwner.'';
                }else{
                    $riskOwners .= '<br>'.$fullNameRiskOwner.'';
                }
                $countriskOw++;
            }
            $activityDetails = '';
            $sql_activity = "SELECT activity, empNo, date, time FROM risktreatmentactivity WHERE indexRisk = '$indexRisk' ORDER BY id DESC";
            $resul_activity = mysqli_query($conn,$sql_activity) or die(mysqli_error($conn));
            $count_activity = mysqli_num_rows($resul_activity);
            if($count_activity>0){
                while($activity = mysqli_fetch_array($resul_activity)){
                        $activityDetails .= ''.$activity['activity'].'';

                        $empNoActivity = $activity['empNo'];
                        $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNoActivity'";
                        $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                        $fullNameActivity = mysqli_fetch_array($resultFullName);
                        $activityDetails .= ' ['.$fullNameActivity['fullName'].' / ';

                        $activityDetails .= ''.$activity['date'].' '.$activity['time'].']<br>';
                    
                }
            }

            $sqlActionOwnerEMP = "SELECT empNo FROM actionowners WHERE indexRisk = '$indexRisk'";
            $resultActionOwnerEMP = mysqli_query($conn, $sqlActionOwnerEMP);
            $actionOwners = '';
            $count = 1;
            while($ActionOwnerEMP = mysqli_fetch_array($resultActionOwnerEMP)){
                $actionOwnerEmp = $ActionOwnerEMP['empNo'];
                $sqlFullName = "SELECT fullName FROM user_details WHERE empNo = '$actionOwnerEmp'";
                $resultFullName = mysqli_query($conn, $sqlFullName);
                $arrayFullName = mysqli_fetch_array($resultFullName);
                $fullNameAction = $arrayFullName['fullName'];
                if($count == 1){
                    $actionOwners .= ''.$fullNameAction.'';
                }else{
                    $actionOwners .= '<br>'.$fullNameAction.'';
                }
                $count++;
            }

            $sql_deadline = "SELECT deadline FROM risktreatmentdeadline WHERE indexRisk = '$indexRisk' ORDER BY id DESC LIMIT 1";
            $resul_deadline = mysqli_query($conn,$sql_deadline) or die(mysqli_error($conn));
            $count_deadline = mysqli_num_rows($resul_deadline);
            $deadline = mysqli_fetch_array($resul_deadline);
            $deadline = $deadline['deadline'];

            $actionDetails = '';
            $sql_actions = "SELECT action, empNo, date, time FROM risktreatmentresponseaction WHERE indexRisk = '$indexRisk' ORDER BY id DESC";
            $resul_action = mysqli_query($conn,$sql_actions) or die(mysqli_error($conn));
            $count_action = mysqli_num_rows($resul_action);
            if($count_action>0){
                while($action = mysqli_fetch_array($resul_action)){
                    $actionDetails .= ''.$action['action'].'';  
            
                    $empNoAction = $action['empNo'];
                    $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNoAction'";
                    $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                    $fullNameRes = mysqli_fetch_array($resultFullName);
                    $actionDetails .= ' ['.$fullNameRes['fullName'].' / ';
                    $actionDetails .= ''.$action['date'].' '.$action['time'].'<br>';
                }
            }

            $output .= '
                        <tr>  
                            <td>'.$keyRiskTag.'</td>  
                            <td>'.$RiskDetails["reportedDate"].' '.$RiskDetails["reportedTime"].'</td>  
                            <td>'.$fullName.'</td>  
                            <td>'.$lastUpdate.'</td>  
                            <td>'.$RiskDetails["mainUnit"].'</td>
                            <td>'.$RiskDetails["indexRisk"].'</td>  
                            <td>'.$RiskDetails["cateory"].'</td>  
                            <td>'.$RiskDetails["businessObj"].'</td>
                            <td>'.$RiskDetails["description"].'</td>  
                            <td>'.$riskOwners.'</td>
                            <td>'.$RiskDetails["kri"].'</td>
                            <td>'.$RiskDetails["bau"].'</td>  
                            <td>'.$RiskDetails["riskAlert"].'</td>
                            <td>'.$RiskDetails["risk"].'</td>  
                            <td>'.$RiskDetails["cause"].'</td>  
                            <td>'.$RiskDetails["impact"].'</td>  
                            <td>'.$RiskDetails["likelyhoodLevel"].'</td>
                            <td>'.$RiskDetails["impactLevel"].'</td>  
                            <td>'.$RiskDetails["riskLevel"].'</td>  
                            <td>'.$RiskDetails["existingControl"].'</td>  
                            <td>'.$RiskDetails["ContrEffectv"].'</td>  
                            <td>'.$RiskDetails["reslikelyhoodLevel"].'</td>
                            <td>'.$RiskDetails["resimpactLevel"].'</td>  
                            <td>'.$RiskDetails["resriskLevel"].'</td>
                            <td>'.$RiskDetails["riskResponse"].'</td>
                            <td>'.$activityDetails.'</td>
                            <td>'.$actionOwners.'</td>
                            <td>'.$deadline.'</td>
                            <td>'.$RiskDetails["Effectiveness"].'</td>
                            <td>'.$RiskDetails["currentStatus"].'</td>
                            <td>'.$actionDetails.'</td>
                        </tr>
                        ';
            
            
            
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=Risk_Registry_Details.xls');
        
        echo $output;
    }


?>