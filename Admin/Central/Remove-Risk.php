<?php
    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $riskIndex = $_POST['riskIndex'];


    $sqlDelActionOw = "DELETE FROM actionowners WHERE indexRisk = '$riskIndex'";
    if($conn->query($sqlDelActionOw) === TRUE){

        $sqlDelActivity = "DELETE FROM activity WHERE indexRisk = '$riskIndex'";
        if($conn->query($sqlDelActivity) === TRUE){

            $sqlDelDivActionOw = "DELETE FROM divactionowners WHERE indexRisk = '$riskIndex'";
            if($conn->query($sqlDelDivActionOw) === TRUE){

                $sqlDelDivActivity = "DELETE FROM divactivity WHERE indexRisk = '$riskIndex'";
                if($conn->query($sqlDelDivActivity) === TRUE){

                    $sqlDelDivInfoGathDetail = "DELETE FROM divinfogatherdetails WHERE indexRisk = '$riskIndex'";
                    if($conn->query($sqlDelDivInfoGathDetail) === TRUE){

                        $sqlDelDivLastUpdate = "DELETE FROM divlastupdate WHERE indexRisk = '$riskIndex'";
                        if($conn->query($sqlDelDivLastUpdate) === TRUE){
    
                            $sqlDelDivRisk = "DELETE FROM divrisk WHERE indexRisk = '$riskIndex'";
                            if($conn->query($sqlDelDivRisk) === TRUE){
        
                                $sqlDelDivRiskOw = "DELETE FROM divriskowners WHERE indexRisk = '$riskIndex'";
                                if($conn->query($sqlDelDivRiskOw) === TRUE){
            
                                    $sqlDelDivRiskTreatAct = "DELETE FROM divrisktreatmentactivity WHERE indexRisk = '$riskIndex'";
                                    if($conn->query($sqlDelDivRiskTreatAct) === TRUE){
                
                                        $sqlDelDivRiskTreatDead = "DELETE FROM divrisktreatmentdeadline WHERE indexRisk = '$riskIndex'";
                                        if($conn->query($sqlDelDivRiskTreatDead) === TRUE){
                    
                                            $sqlDelDivRiskTreatResAct = "DELETE FROM divrisktreatmentresponseaction WHERE indexRisk = '$riskIndex'";
                                            if($conn->query($sqlDelDivRiskTreatResAct) === TRUE){
                        
                                                $sqlDelDivTriIndex = "DELETE FROM divtrindex WHERE indexRisk = '$riskIndex'";
                                                if($conn->query($sqlDelDivTriIndex) === TRUE){
                            
                                                    $sqlDelInfoGathDetail = "DELETE FROM infogatherdetails WHERE indexRisk = '$riskIndex'";
                                                    if($conn->query($sqlDelInfoGathDetail) === TRUE){
                                
                                                        $sqlDelLastUpdate = "DELETE FROM lastupdate WHERE indexRisk = '$riskIndex'";
                                                        if($conn->query($sqlDelLastUpdate) === TRUE){
                                    
                                                            $sqlDelMoveRisk = "DELETE FROM moverisk WHERE (ERMindexRisk = '$riskIndex' OR DIVindexRisk = '$riskIndex')";
                                                            if($conn->query($sqlDelMoveRisk) === TRUE){
                                        
                                                                $sqlDelRisk = "DELETE FROM risk WHERE indexRisk = '$riskIndex'";
                                                                if($conn->query($sqlDelRisk) === TRUE){
                                            
                                                                    $sqlDelRiskOw = "DELETE FROM riskowners WHERE indexRisk = '$riskIndex'";
                                                                    if($conn->query($sqlDelRiskOw) === TRUE){
                                                
                                                                        $sqlDelRiskTreatAct = "DELETE FROM risktreatmentactivity WHERE indexRisk = '$riskIndex'";
                                                                        if($conn->query($sqlDelRiskTreatAct) === TRUE){
                                                    
                                                                            $sqlDelRiskTreatDead = "DELETE FROM risktreatmentdeadline WHERE indexRisk = '$riskIndex'";
                                                                            if($conn->query($sqlDelRiskTreatDead) === TRUE){
                                                        
                                                                                $sqlDelRiskTreatResAct = "DELETE FROM risktreatmentresponseaction WHERE indexRisk = '$riskIndex'";
                                                                                if($conn->query($sqlDelRiskTreatResAct) === TRUE){
                                                            
                                                                                    $sqlDelTriIndex = "DELETE FROM trindex WHERE indexRisk = '$riskIndex'";
                                                                                    if($conn->query($sqlDelTriIndex) === TRUE){
                                                                
                                                                                        $data = 'true';
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
        $data = 'false';
    }

    echo $data;
?>