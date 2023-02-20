<?php

    include("../database.php");

    $user = '';

    session_start();

    // Session timeout duration in seconds
    // Specify value lesser than the PHPs default timeout of 24 minutes
    $timeout = 1800;
    // Check existing timeout variable
    if( isset( $_SESSION[ 'lastaccess' ] ) ) {
        // Time difference since user sent last request
        $duration = time() - intval( $_SESSION[ 'lastaccess' ] );
        // Destroy if last request was sent before the current time minus last request
        if( $duration > $timeout ) {
            //session_unset();
            session_destroy();
            unset($_SESSION["user"]);
            echo '<script type="text/javascript">alert("Your session has been expired! Please login again...");</script>';
            echo "<script>location.href='../../index.php'</script>";
        }
    }
    $_SESSION['lastaccess'] = time();

    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        $queryUserDetails = "SELECT idUser,fName, lName, fullName, empNo, role FROM user_details WHERE username = '$username'";
        $resultUserDetails = mysqli_query($conn,$queryUserDetails) or die(mysqli_error($conn));
        $userDetails = mysqli_fetch_array($resultUserDetails);
        if($userDetails['role']!="User"){
            session_destroy();
            unset($_SESSION["user"]);
            echo '<script type="text/javascript">alert("Oops..! Something went wrong. Please login again.");</script>';
            echo "<script>location.href='../../index.php'</script>";
        }
    }else{
        session_destroy();
        unset($_SESSION["user"]);
        echo "<script>location.href='../../index.php'</script>";
    }

    if(isset($_POST['logout'])){
        session_destroy();
        unset($_SESSION["user"]);
        echo "<script>location.href='../../index.php'</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="title icon" href="../../images/title-img2.jpg">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

        <link rel="stylesheet" href="../../bootstrap-5.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../bootstrap-5.0.0/css/font-awesome.css">
        <link rel="stylesheet" href="../../CSS/style.css">
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" 
        integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
        
        <script src="../../bootstrap-5.0.0/js/popper.js"></script>
        <title>Add New Risks - Risk Register Management System</title>
    </head>
    <body>
        <!-- navbar -->
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container-fluid">
                <button class="navbar-toggler mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false"  aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <div class="row">
                        <!--sidebar-->
                        <div class="col-xl-2 col-lg-3 col-md-4 sidebar fixed-top">
                            <a href="Home.php" class="navbar-brand
                            text-white d-block mx-auto text-center py-3
                            mb-4 bottom-border">Portal</a>
                            <div class="bottom-border pb-3" align="center">
                                <a href="myProfile.php" class="text-white mx-auto">
                                    <small>
                                        <?php
                                            echo    ''.$userDetails['fullName'].'';
                                        ?>
                                    </small>
                                </a>
                            </div>
                            <ul class="navbar-nav flex-column mt-4">
                                <li class="nav-item"><a href="Dashboard.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i class="fas fa-tachometer-alt text-light 
                                fa-lg mx-3"></i>Dashboard</a></li>

                                <li class="nav-item"><a href="Home.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-home text-light 
                                fa-lg fa-fw mx-3"></i>Home</a></li>

                                <li class="nav-item"><a href="My-Risks.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-address-card text-light 
                                fa-lg fa-fw mx-3"></i>My Risks</a></li>

                                <li class="nav-item"><a href="All-Risks.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-tasks text-light 
                                fa-lg fa-fw mx-3"></i>All Risks</a></li>
                            </ul>
                        </div>
                        <!--end of sidebar-->
                        <!--TopNav-->
                        <div class="col-xl-10 col-lg-9 col-md-8 ms-auto bg-dark fixed-top py-2 top-navbar">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h4 class="text-light 
                                    text-uppercase mb-0">Add New Risks</h4>
                                </div>
                                <div class="col-md-5">
                                
                                </div>
                                <div class="col-md-3">
                                    <ul class="navbar-nav">                            

                                        <li class="nav-item ms-md-auto dropdown">
                                            <a href="#" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-bell text-muted fa-lg"></i>
                                                <span class="badge badge-danger" id="count"></span>
                                            </a>
                                            <div class="dropdown-menu  dropdown-menu-end dropdown-menu-dark dropdown-menu-notify" aria-labelledby="navbarDropdown">
                                                
                                            </div>
                                        </li>

                                        <li class="nav-item dropdown ms-md-auto">
                                            <a href="#" 
                                            class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-user-circle text-muted fa-lg">
                                                </i>
                                            </a>
                                            <ul class="dropdown-menu  dropdown-menu-end dropdown-menu-dark" aria-labelledby="navbarDropdown1">
                                                <li><h1 class="dropdown-header mb-2"><i class="fas fa-user text-muted
                                                    fa-lg mx-3"></i>
                                                    <?php
                                                        echo    ''.$userDetails['fullName'].'';
                                                    ?>
                                                </h1></li>
                                                <li><a class="dropdown-item me-3" href="Home.php"><i class="fas fa-home
                                                    fa-lg fa-fw text-light mx-3"></i>Home</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item me-3" href="myProfile.php"><i class="fas fa-user 
                                                    fa-lg fa-fw text-light mx-3"></i>My Profile</a>
                                                </li>
                                                <li><a class="dropdown-item me-3" href="../Divisional/Home.php"><i class="fas fas fa-map-signs
                                                    fa-lg fa-fw text-light mx-3"></i>Divisional Registry</a>
                                                </li>
                                                <li><a class="dropdown-item me-3" href="../index.php"><i class="fas fa-arrow-alt-circle-left
                                                    fa-lg fa-fw text-light mx-3"></i>Landing Page</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item me-3" href="#" data-bs-toggle="modal" data-bs-target="#sign-out"><i class="fas fa-sign-out-alt text-danger 
                                                    fa-lg fa-fw mx-3"></i>Logout</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--end of TopNav-->
                    </div>
                </div>
            </div>
        </nav>
        <!-- end of navbar -->

        <!-- Modal -->
        <div class="modal fade" id="sign-out" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Want to logout?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Click logout to leave
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel</button>
                        <form action="" method="POST">
                            <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Modal -->

        <!-- Section -->
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 col-lg-9 col-md-8 ms-auto">
                        <div class="row p-2 pt-md-5 mt-md-2 mb-auto">
                            <div class="container">
                                <h4 align="center">New Risk Registration</h4>
                                <br>
                                <form method="post" id="new_risk">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active active_tab1 me-1" style="border:1px solid #ccc" id="list_risk_identification">Risk Identification</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link inactive_tab1 me-1" style="border:1px solid #ccc" id="list_risk_analysis">Risk Analysis</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link inactive_tab1 me-1" style="border:1px solid #ccc" id="list_risk_evaluation">Risk Evaluation</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link inactive_tab1 me-1" style="border:1px solid #ccc" id="list_risk_treatment">Risk Treatment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link inactive_tab1" style="border:1px solid #ccc" id="list_risk_review">Risk Review</a>
                                        </li>  
                                    </ul>
                                    <div class="tab-content" style="margin-top: 16px;">
                                        <div class="tab-pane active" id="risk_identification">
                                            <div class="card">
                                                <div class="card-heading pt-2 ps-3">Risk Identification</div>
                                                <div class="card-body p-3">
                                                    <div class="form-control p-3 mb-3">
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label>High Level Business Impact <span class="text-danger">*</span><span class="text-muted"><small> (Impact by the risk)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" maxlength="1500" onkeypress="maxLengthCheck(this)" name="businessImpact" id="businessImpact" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_businessImpact" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Risk Description <span class="text-danger">*</span><span class="text-muted"><small> (At high-level)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <textarea type="text" maxlength="1500" onkeypress="maxLengthCheck(this)" name="riskDescription" id="riskDescription" onfocusout="remmoveError(this)" class="form-control"></textarea>
                                                                <small><small><span id="error_riskDescription" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Risk Category <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="riskCategory" id="riskCategory" class="form-control form-select" onfocusout="remmoveErrorRiskCat(this)" aria-label="Default select example" style="width: 70%;">
                                                                    <option selected class="text-muted">Select Risk Category</option>
                                                                    <option>DR / BCM Risk</option>
                                                                    <option>Economic & Political Risk</option>
                                                                    <option>Environmental Risk</option>
                                                                    <option>Financial Risk</option>
                                                                    <option>Information Security Risk</option>
                                                                    <option>Market Risk</option>
                                                                    <option>Operational Risk</option>
                                                                    <option>People Risk</option>
                                                                    <option>Power Risk</option>
                                                                    <option>Regulatory Risk</option>
                                                                    <option>Reputation Risk</option>
                                                                    <option>Strategic Investment Risk</option>
                                                                    <option>Strategic Partnership Risk</option>
                                                                    <option>Technology Risk</option>
                                                                </select>
                                                                <small><small><span id="error_riskCategory" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between mt-3 pt-1">
                                                            <div class="col-4">
                                                                <label>Risk Owners <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="table-responsive d-flex" style="height: 200px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                                    <table class="table table-sm table-striped table-hover" id="riskOwners">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" style="width: 70%;"><small>Name</small></th>
                                                                                <th scope="col" style="width: 30%;"><small>Employee ID</small></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                           
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="table-responsive d-flex" style="height: 200px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                                    <table class="table table-sm table-striped table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" style="width: 50%;"><small>Name</small></th>
                                                                                <th scope="col" style="width: 30%;"><small>Employee ID</small></th>
                                                                                <th scope="col" style="width: 20%;"><small>Add/Remove</small></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $sql = "SELECT fullName, empNo FROM user_details WHERE category = 'Head' ORDER BY fullName";
                                                                                $resul = mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                                                                $count = mysqli_num_rows($resul);
                                                                                if($count>0){
                                                                                    while($name = mysqli_fetch_array($resul)){
                                                                            ?>
                                                                            <tr>
                                                                                <td><small><?php    echo    $name['fullName'];  ?><input type="hidden" id="riskOwnerSel<?php  echo    $name['empNo'];   ?>" value="<?php    echo    $name['fullName'];  ?>"/></small></td>
                                                                                <td><small><?php    echo    $name['empNo'];  ?><input type="hidden" id="riskOwnerEmpSel<?php  echo    $name['empNo'];   ?>" value="<?php    echo    $name['empNo'];  ?>"/></small></td>
                                                                                <td align="center"><small><button type="button" onclick="riskOwnerSel(this)" name="riskOwnerButton" id="<?php  echo    $name['empNo'];   ?>" class="btn btn-sm btn-info" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem;">Add</button></small></td>
                                                                            </tr>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Main Unit / Segment <span class="text-danger">*</span><span class="text-muted"><small> (New)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="mainUnit" id="mainUnit" class="form-control form-select" onfocusout="remmoveErrorRiskUnit(this)" aria-label="Default select example" style="width: 70%;">
                                                                    <option selected class="text-muted">Select Unit</option>
                                                                    <option>Access Planning</option>
                                                                    <option>Broadband Planning</option>
                                                                    <option>CFSS</option>
                                                                    <option>Core Network Planning</option>
                                                                    <option>Data Center & Power Systems</option>
                                                                    <option>DE-TAC</option>
                                                                    <option>DNS</option>
                                                                    <option>DTV</option>
                                                                    <option>GTD</option>
                                                                    <option>Network Strategy</option>
                                                                    <option>NOSA - ANO</option>
                                                                    <option>NOSA - Core Network</option>
                                                                    <option>NOSA - CRC</option>
                                                                    <option>NOSA - Enterprise Service Support</option>
                                                                    <option>NOSA - Enterprise Service Support (IDC)</option>
                                                                    <option>NOSA - Enterprise Service Support (SD)</option>
                                                                    <option>NOSA - NSQ</option>
                                                                    <option>NOSA - PS & International</option>
                                                                    <option>NOSA - TNO</option>
                                                                    <option>NOSA - VAS</option>
                                                                    <option>Product Development</option>
                                                                    <option>Project Planning</option>
                                                                    <option>TNP</option>
                                                                    <option>TSC</option>
                                                                </select>
                                                                <small><small><span id="error_mainUnit" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div align="center">
                                                        <button type="button" name="btn_risk_identification" id="btn_risk_identification" class="btn btn-info btn-md">Next</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="risk_analysis">
                                            <div class="card">
                                                <div class="card-heading pt-2 ps-3">Risk Analysis</div>
                                                <div class="card-body p-3">
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Key Risk Indicators (KRIs)</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>KRI <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" maxlength="200" onkeypress="maxLengthCheck(this)" name="kri" id="kri" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_kri" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>BAU <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" maxlength="200" onkeypress="maxLengthCheck(this)" name="bau" id="bau" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_bau" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Alert <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" maxlength="200" onkeypress="maxLengthCheck(this)" name="alert" id="alert" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_alert" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Risk <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" maxlength="200" onkeypress="maxLengthCheck(this)" name="risk" id="risk" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_risk" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Root Cause Analysis</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Cause <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" maxlength="500" onkeypress="maxLengthCheck(this)" name="cause" id="cause" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_cause" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Impact Analysis</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Impact <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" maxlength="300" onkeypress="maxLengthCheck(this)" name="impact" id="impact" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_impact" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Gross Risk Rating</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Likelihood Level <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="likelyhoodLevel" id="likelyhoodLevel" class="form-control form-select" onchange="remmoveErrorLikeGR(this)" aria-label="Default select example" style="width: 70%;">
                                                                    <option selected class="text-muted">Select Likelyhood Level</option>
                                                                    <option>Almost Certain</option>
                                                                    <option>Likely</option>
                                                                    <option>Moderate</option>
                                                                    <option>Unlikely</option>
                                                                    <option>Rare</option>
                                                                </select>
                                                                <small><small><span id="error_likelyhoodLevel" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Impact Level <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="impactLevel" id="impactLevel" class="form-control form-select" onchange="remmoveErrorImpactGR(this)" aria-label="Default select example" style="width: 70%;">
                                                                    <option selected class="text-muted">Select Impact Level</option>
                                                                    <option>Insignificant</option>
                                                                    <option>Minor</option>
                                                                    <option>Moderate</option>
                                                                    <option>Major</option>
                                                                    <option>Catastropic</option>
                                                                </select>
                                                                <small><small><span id="error_impactLevel" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="col-4">
                                                                <label>Risk Level</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <label data-toggle="tooltip" title="This will auto generated" ><span class="text-danger" id="riskLevel" name="riskLevel" >Please select Likelyhood Level and Impact Level</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div align="center">
                                                        <button type="button" name="previous_btn_risk_analysis" id="previous_btn_risk_analysis" class="btn btn-secondary mx-1 btn-md">Previous</button>
                                                        <button type="button" name="btn_risk_analysis" id="btn_risk_analysis" class="btn btn-info mx-1 btn-md">Next</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="risk_evaluation">
                                            <div class="card">
                                                <div class="card-heading pt-2 ps-3">Risk Evaluation</div>
                                                <div class="card-body p-3">
                                                    <div class="form-control p-3 mb-3">
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label>Existing Control <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" maxlength="300" onkeypress="maxLengthCheck(this)" name="existingControl" id="existingControl" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_existingControl" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Control Effectiveness <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="controlEffectiveness" id="controlEffectiveness" class="form-control form-select" onfocusout="remmoveErrorConEff(this)" aria-label="Default select example" style="width: 70%;">
                                                                    <option selected class="text-muted">Select Control Effectiveness</option>
                                                                    <option>Ineffective (<25%)</option>
                                                                    <option>Fairly Effective (25% - 50%)</option>
                                                                    <option>Mostly Effective (50% - 75%)</option>
                                                                    <option>Effective (>75%)</option>
                                                                    <option>N/A</option>
                                                                </select>
                                                                <small><small><span id="error_controlEffectiveness" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Residual Risk Rating</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Likelihood Level <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="reslikelyhoodLevel" id="reslikelyhoodLevel" class="form-control form-select" onchange="remmoveErrorResLikeGR(this)" aria-label="Default select example" style="width: 70%;">
                                                                    <option selected class="text-muted">Select Likelyhood Level</option>
                                                                    <option>Almost Certain</option>
                                                                    <option>Likely</option>
                                                                    <option>Moderate</option>
                                                                    <option>Unlikely</option>
                                                                    <option>Rare</option>
                                                                </select>
                                                                <small><small><span id="error_reslikelyhoodLevel" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Impact Level <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="resimpactLevel" id="resimpactLevel" class="form-control form-select" onchange="remmoveErrorResImpactGR(this)" aria-label="Default select example" style="width: 70%;">
                                                                    <option selected class="text-muted">Select Impact Level</option>
                                                                    <option>Insignificant</option>
                                                                    <option>Minor</option>
                                                                    <option>Moderate</option>
                                                                    <option>Major</option>
                                                                    <option>Catastropic</option>
                                                                </select>
                                                                <small><small><span id="error_resimpactLevel" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="col-4">
                                                                <label> Overall Risk Level</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <label data-toggle="tooltip" id="resriskLevel" name="resriskLevel" title="This will auto generated" class="text-danger">Please select Likelyhood Level and Impact Level</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div align="center">
                                                        <button type="button" name="previous_btn_risk_evaluation" id="previous_btn_risk_evaluation" class="btn btn-secondary mx-1 btn-md">Previous</button>
                                                        <button type="button" name="btn_risk_evaluation" id="btn_risk_evaluation" class="btn btn-info mx-1 btn-md">Next</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="risk_treatment">
                                            <div class="card">
                                                <div class="card-heading pt-2 ps-3">Risk Treatment</div>
                                                <div class="card-body p-3">
                                                    <div class="form-control p-3 mb-3">
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label>Risk Response <span class="text-danger">*</span><span class="text-muted"><small> (Rationale)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="riskResponse" id="riskResponse" class="form-control form-select" onchange="disableFields(this)" onfocusout="remmoveErrorRiskRes(this)" aria-label="Default select example" style="width: 70%;">
                                                                    <option selected class="text-muted">Select Risk Response</option>
                                                                    <option>Avoid</option>
                                                                    <option>Change</option>
                                                                    <option>Share</option>
                                                                    <option>Retain</option>
                                                                </select>
                                                                <small><small><span id="error_riskResponse" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Response Action Plan</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Activity <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" maxlength="1500" onkeypress="maxLengthCheck(this)" name="activity" id="activity" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_activity" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Action Owners <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="table-responsive d-flex" style="height: 200px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                                    <table class="table table-sm table-striped table-hover" id="actionOwners">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" style="width: 70%;"><small>Name</small></th>
                                                                                <th scope="col" style="width: 30%;"><small>Employee ID</small></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <!-- table -->
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="table-responsive d-flex" style="height: 200px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                                    <table class="table table-sm table-striped table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" style="width: 50%;"><small>Name</small></th>
                                                                                <th scope="col" style="width: 30%;"><small>Employee ID</small></th>
                                                                                <th scope="col" style="width: 20%;"><small>Add/Remove</small></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $sqlAc = "SELECT fullName, empNo FROM user_details ORDER BY fullName";
                                                                                $resulAc = mysqli_query($conn,$sqlAc) or die(mysqli_error($conn));
                                                                                $countAc = mysqli_num_rows($resulAc);
                                                                                if($countAc>0){
                                                                                    while($nameAc = mysqli_fetch_array($resulAc)){
                                                                            ?>
                                                                            <tr>
                                                                                <td><small><?php    echo    $nameAc['fullName'];  ?><input type="hidden" id="actionOwnerSel<?php  echo    $nameAc['empNo'];   ?>" value="<?php    echo    $nameAc['fullName'];  ?>"/></small></td>
                                                                                <td><small><?php    echo    $nameAc['empNo'];  ?><input type="hidden" id="actionOwnerEmpSel<?php  echo    $nameAc['empNo'];   ?>" value="<?php    echo    $nameAc['empNo'];  ?>"/></small></td>
                                                                                <td align="center"><small><button type="button" onclick="actionOwnerSel(this)" name="actionOwnerButton" id="<?php  echo    $nameAc['empNo'];   ?>" class="btn btn-sm btn-info" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem;">Add</button></small></td>
                                                                            </tr>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-lg-4 col-4">
                                                                <label>Deadline <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-lg-4 col-8">
                                                                <input type="date" name="deadline" id="deadline" onfocusout="remmoveErrorDt(this)" class="form-control" />
                                                                <small><small><span id="error_deadline" class="text-danger"></span></small></small>
                                                            </div>
                                                            <div class="col-lg-4"></div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Effectiveness of the Risk Mitigation Method <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="Effectiveness" id="Effectiveness" class="form-control form-select" onfocusout="remmoveErrorEff(this)" aria-label="Default select example" style="width: 70%;">
                                                                    <option selected class="text-muted">Select Effectiveness</option>
                                                                    <option>Ineffective (<25%)</option>
                                                                    <option>Fairly Effective (25% - 50%)</option>
                                                                    <option>Mostly Effective (50% - 75%)</option>
                                                                    <option>Effective (>75%)</option>
                                                                    <option>N/A</option>
                                                                </select>
                                                                <small><small><span id="error_Effectiveness" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Current Status <span class="text-danger">*</span><span class="text-muted"><small> (High level)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="currentStatus" id="currentStatus" class="form-control form-select" onfocusout="remmoveErrorCuSt(this)" aria-label="Default select example" style="width: 70%;">
                                                                    <option selected class="text-muted">Select Current Status</option>
                                                                    <option>Abandoned</option>
                                                                    <option>Completed (delay)</option>
                                                                    <option>Completed (early)</option>
                                                                    <option>Completed (on time)</option>
                                                                    <option>Manage with existing controls</option>
                                                                    <option>Not started</option>
                                                                    <option>Ongoing (ahead of time)</option>
                                                                    <option>Ongoing (on time)</option>
                                                                    <option>Ongoing (with delays)</option>
                                                                    <option>Redirected</option>
                                                                </select>
                                                                <small><small><span id="error_currentStatus" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label>Current Progress / Remarks <span class="text-danger">*</span><span class="text-muted"><small> (If applicable)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" maxlength="1500" onkeypress="maxLengthCheck(this)" name="detailLevel" id="detailLevel" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_detailLevel" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div align="center">
                                                        <button type="button" name="previous_btn_risk_treatment" id="previous_btn_risk_treatment" class="btn btn-secondary mx-1 btn-md">Previous</button>
                                                        <button type="button" name="btn_risk_treatment" id="btn_risk_treatment" class="btn btn-info mx-1 btn-md">Next</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="risk_review">
                                            <div class="card">
                                                <div class="card-heading pt-2 ps-3">Risk Review</div>
                                                <div class="card-body p-3">
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Risk Identification</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label>High Level Business Impact<span class="text-muted"><small> (Impact by the risk)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_businessImpact"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Risk Description<span class="text-muted"><small> (At high-level)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_riskDescription"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Risk Category</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_riskCategory"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Risk Owner</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="table-responsive d-flex" style="height: 200px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                                    <table class="table table-sm table-striped table-hover" id="riskOwnersVw">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" style="width: 70%;"><small>Name</small></th>
                                                                                <th scope="col" style="width: 30%;"><small>Employee ID</small></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Main Unit / Segment<span class="text-muted"><small> (New)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_mainUnit"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Risk Analysis</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label>KRI</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_kri"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>BAU</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_bau"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Alert</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_alert"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Risk</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_risk"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Cause</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_cause"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Impact</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_impact"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Likelihood Level</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_likelyhoodLevel"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Impact Level</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_impactLevel"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="col-4">
                                                                <label>Risk Level</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_riskLevel"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Risk Evaluation</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label>Existing Control</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_existingControl"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Control Effectiveness</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_controlEffectiveness"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Likelihood Level</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_reslikelyhoodLevel"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Impact Level</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_resimpactLevel"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="col-4">
                                                                <label> Overall Risk Level</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_resriskLevel"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Risk Treatment</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label>Risk Response<span class="text-muted"><small> (Rationale)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_riskResponse"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Activity</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_activity"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Action Owners</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="table-responsive d-flex" style="height: 200px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                                    <table class="table table-sm table-striped table-hover" id="actionOwnersVw">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" style="width: 70%;"><small>Name</small></th>
                                                                                <th scope="col" style="width: 30%;"><small>Employee ID</small></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <!-- table -->
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Deadline</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_deadline"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Effectiveness of the Risk Mitigation Method</label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_Effectiveness"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Current Status <span class="text-muted"><small> (High level)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_currentStatus"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Current Progress / Remarks <span class="text-muted"><small> (If applicable)</small></span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span id="view_detailLevel"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div align="center">
                                                        <button type="button" name="previous_btn_risk_review" id="previous_btn_risk_review" class="btn btn-secondary mx-1 btn-md">Previous</button>
                                                        <button type="button" name="btn_submit" id="btn_submit" class="btn btn-success mx-1 btn-md">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of Section -->

        
        
        <script type="text/javascript">

            function maxLengthCheck(object) {
                var ids = $(object).attr("id");
                if(object.value.length == $(object).attr("maxlength")){
                    $('#error_'+ids+'').text('You have reached your maximum limit of characters allowed. Max character limit '+$(object).attr("maxlength")+'');
                }else{
                    $('#error_'+ids+'').text('');
                }
            }

            function riskOwnerSel(button){
                var row_id_risk_owner = $(button).attr("id");
                if($(button).text() == "Add"){
                    $(button).removeClass("btn-info");
                    $(button).addClass("btn-danger");
                    $(button).text("Remove");
                    var Name = $('#riskOwnerSel'+row_id_risk_owner+'').val();
                    var empNo = $('#riskOwnerEmpSel'+row_id_risk_owner+'').val();
                    var output = '';
                    output = '<tr id="row_'+row_id_risk_owner+'">';
                    output +=    '<td><small>'+Name+'<input type="hidden" name="hidden_riskOwner[]" id="riskOwner'+row_id_risk_owner+'" value="'+Name+'"/></small></td>';
                    output +=    '<td><small>'+empNo+'<input type="hidden" name="hidden_riskOwnerEmp[]" id="riskOwnerEmp'+row_id_risk_owner+'" value="'+empNo+'"/></small></td>';
                    output += '</tr>';
                    $('#riskOwners').append(output);
                    var outputVw = '';
                    outputVw = '<tr id="row_Vw'+row_id_risk_owner+'">';
                    outputVw +=    '<td><small>'+Name+'</small></td>';
                    outputVw +=    '<td><small>'+empNo+'</small></td>';
                    outputVw += '</tr>';
                    $('#riskOwnersVw').append(outputVw);
                }else if($(button).text() == "Remove"){
                    if(confirm("Are you sure you want to remove this name?")){
                        $(button).removeClass("btn-danger");
                        $(button).addClass("btn-info");
                        $(button).text("Add");
                        $('#row_'+row_id_risk_owner+'').remove();
                        $('#row_Vw'+row_id_risk_owner+'').remove();
                    }else{
                        return false;
                    }
                }
            }

            function actionOwnerSel(button){
                var row_id_action_owner = $(button).attr("id");
                if($(button).text() == "Add"){
                    $(button).removeClass("btn-info");
                    $(button).addClass("btn-danger");
                    $(button).text("Remove");
                    var NameAc = $('#actionOwnerSel'+row_id_action_owner+'').val();
                    var empNoAc = $('#actionOwnerEmpSel'+row_id_action_owner+'').val();
                    var outputac = '';
                    outputac = '<tr id="row_action_'+row_id_action_owner+'">';
                    outputac +=    '<td><small>'+NameAc+'<input type="hidden" name="hidden_actionOwner[]" id="actionOwner'+row_id_action_owner+'" value="'+NameAc+'"/></small></td>';
                    outputac +=    '<td><small>'+empNoAc+'<input type="hidden" name="hidden_actionOwnerEmp[]" id="actionOwnerEmp'+row_id_action_owner+'" value="'+empNoAc+'"/></small></td>';
                    outputac += '</tr>';
                    $('#actionOwners').append(outputac);
                    var outputacVw = '';
                    outputacVw = '<tr id="row_action_Vw'+row_id_action_owner+'">';
                    outputacVw +=    '<td><small>'+NameAc+'</small></td>';
                    outputacVw +=    '<td><small>'+empNoAc+'</small></td>';
                    outputacVw += '</tr>';
                    $('#actionOwnersVw').append(outputacVw);
                }else if($(button).text() == "Remove"){
                    if(confirm("Are you sure you want to remove this name?")){
                        $(button).removeClass("btn-danger");
                        $(button).addClass("btn-info");
                        $(button).text("Add");
                        $('#row_action_'+row_id_action_owner+'').remove();
                        $('#row_action_Vw'+row_id_action_owner+'').remove();
                    }else{
                        return false;
                    }
                }
            }

            $(function(){
                var dtToday = new Date();
                
                var month = dtToday.getMonth() + 1;
                var day = dtToday.getDate();
                var year = dtToday.getFullYear();
                if(month < 10)
                    month = '0' + month.toString();
                if(day < 10)
                    day = '0' + day.toString();
                
                var minDate= year + '-' + month + '-' + day;
                
                $('#deadline').attr('min', minDate);
            });

            function remmoveError(out){
                if($.trim($(out).val()).length != 0){
                    $(out).removeClass('has-error');
                    var id = $(out).attr("id");
                    $('#error_'+id+'').text('');
                }
            }

            function remmoveErrorDt(out){
                if($.trim($(out).val()) != ''){
                    $(out).removeClass('has-error');
                    var id = $(out).attr("id");
                    $('#error_'+id+'').text('');
                }
            }

            function remmoveErrorRiskCat(RC){
                if($.trim($(RC).val()) != 'Select Risk Category'){
                    $(RC).removeClass('has-error');
                    var id = $(RC).attr("id");
                    $('#error_'+id+'').text('');
                }
            }

            function remmoveErrorRiskUnit(RU){
                if($.trim($(RU).val()) != 'Select Unit'){
                    $(RU).removeClass('has-error');
                    var id = $(RU).attr("id");
                    $('#error_'+id+'').text('');
                }
            }

            function remmoveErrorConEff(CE){
                if($.trim($(CE).val()) != 'Select Control Effectiveness'){
                    $(CE).removeClass('has-error');
                    var id = $(CE).attr("id");
                    $('#error_'+id+'').text('');
                }
            }

            function remmoveErrorRiskRes(CE){
                if($.trim($(CE).val()) != 'Select Risk Response'){
                    $(CE).removeClass('has-error');
                    var id = $(CE).attr("id");
                    $('#error_'+id+'').text('');
                }
            }

            function disableFields(CE){
                if($.trim($(CE).val()) == 'Retain'){
                    document.getElementById("activity").value = "";
                    document.getElementById("deadline").value = "";
                    document.getElementById("Effectiveness").value = "Select Effectiveness";
                    $('#activity').attr('disabled', true);
                    $('#deadline').attr('disabled', true);
                    $('#Effectiveness').attr('disabled', true);
                }else{
                    $('#activity').attr('disabled', false);
                    $('#deadline').attr('disabled', false);
                    $('#Effectiveness').attr('disabled', false);
                }
            }

            function remmoveErrorEff(CE){
                if($.trim($(CE).val()) != 'Select Effectiveness'){
                    $(CE).removeClass('has-error');
                    var id = $(CE).attr("id");
                    $('#error_'+id+'').text('');
                }
            }

            function remmoveErrorCuSt(CE){
                if($.trim($(CE).val()) != 'Select Curunt Status'){
                    $(CE).removeClass('has-error');
                    var id = $(CE).attr("id");
                    $('#error_'+id+'').text('');
                }
            }

            function setRiskLevel(){
                var likelyhood = $.trim($('#likelyhoodLevel').val());
                var impact = $.trim($('#impactLevel').val());
                $('#riskLevel').removeClass('text-danger');
                if(likelyhood == 'Almost Certain'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#riskLevel').text('Moderate');
                    }else if(impact == 'Moderate'){
                        $('#riskLevel').text('High');
                    }else if(impact == 'Major'){
                        $('#riskLevel').text('Significant');
                    }else if(impact == 'Catastropic'){
                        $('#riskLevel').text('Extreme');
                    }
                }else if(likelyhood == 'Likely'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#riskLevel').text('Moderate');
                    }else if(impact == 'Moderate'){
                        $('#riskLevel').text('High');
                    }else if(impact == 'Major' | impact == 'Catastropic'){
                        $('#riskLevel').text('Significant');
                    }
                }else if(likelyhood == 'Moderate'){
                    if(impact == 'Insignificant'){
                        $('#riskLevel').text('Low');
                    }else if(impact == 'Minor'){
                        $('#riskLevel').text('Moderate');
                    }else if(impact == 'Moderate' | impact == 'Major'){
                        $('#riskLevel').text('High');
                    }else if(impact == 'Catastropic'){
                        $('#riskLevel').text('Significant');
                    }
                }else if(likelyhood == 'Unlikely'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#riskLevel').text('Low');
                    }else if(impact == 'Moderate'){
                        $('#riskLevel').text('Moderate');
                    }else if(impact == 'Major' | impact == 'Catastropic'){
                        $('#riskLevel').text('High');
                    }
                }else if(likelyhood == 'Rare'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#riskLevel').text('Low');
                    }else if(impact == 'Moderate' | impact == 'Major'){
                        $('#riskLevel').text('Moderate');
                    }else if(impact == 'Catastropic'){
                        $('#riskLevel').text('High');
                    }
                }
            }

            function remmoveErrorLikeGR(LHL){
                if($.trim($(LHL).val()) != 'Select Likelyhood Level'){
                    $(LHL).removeClass('has-error');
                    var id = $(LHL).attr("id");
                    $('#error_'+id+'').text('');
                    if($.trim($('#impactLevel').val()) == 'Select Impact Level'){
                        $('#riskLevel').addClass('text-danger');
                        $('#riskLevel').text('Please select Impact Level');
                    }else{
                        setRiskLevel();
                    }
                }else{
                    if($.trim($('#impactLevel').val()) != 'Select Impact Level'){
                        $('#riskLevel').addClass('text-danger');
                        $('#riskLevel').text('Please select Likelyhood Level');
                    }else{
                        $('#riskLevel').addClass('text-danger');
                        $('#riskLevel').text('Please select Likelyhood Level and Impact Level');
                    }
                }
            }

            function remmoveErrorImpactGR(IL){
                if($.trim($(IL).val()) != 'Select Impact Level'){
                    $(IL).removeClass('has-error');
                    var id = $(IL).attr("id");
                    $('#error_'+id+'').text('');
                    if($.trim($('#likelyhoodLevel').val()) == 'Select Likelyhood Level'){
                        $('#riskLevel').addClass('text-danger');
                        $('#riskLevel').text('Please select Likelyhood Level');
                    }else{
                        setRiskLevel();
                    }
                }else{
                    if($.trim($('#likelyhoodLevel').val()) != 'Select Likelyhood Level'){
                        $('#riskLevel').addClass('text-danger');
                        $('#riskLevel').text('Please select Impact Level');
                    }else{
                        $('#riskLevel').addClass('text-danger');
                        $('#riskLevel').text('Please select Likelyhood Level and Impact Level');
                    }
                }
            }

            function setResRiskLevel(){
                var likelyhood = $.trim($('#reslikelyhoodLevel').val());
                var impact = $.trim($('#resimpactLevel').val());
                $('#resriskLevel').removeClass('text-danger');
                if(likelyhood == 'Almost Certain'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#resriskLevel').text('Moderate');
                    }else if(impact == 'Moderate'){
                        $('#resriskLevel').text('High');
                    }else if(impact == 'Major'){
                        $('#resriskLevel').text('Significant');
                    }else if(impact == 'Catastropic'){
                        $('#resriskLevel').text('Extreme');
                    }
                }else if(likelyhood == 'Likely'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#resriskLevel').text('Moderate');
                    }else if(impact == 'Moderate'){
                        $('#resriskLevel').text('High');
                    }else if(impact == 'Major' | impact == 'Catastropic'){
                        $('#resriskLevel').text('Significant');
                    }
                }else if(likelyhood == 'Moderate'){
                    if(impact == 'Insignificant'){
                        $('#resriskLevel').text('Low');
                    }else if(impact == 'Minor'){
                        $('#resriskLevel').text('Moderate');
                    }else if(impact == 'Moderate' | impact == 'Major'){
                        $('#resriskLevel').text('High');
                    }else if(impact == 'Catastropic'){
                        $('#resriskLevel').text('Significant');
                    }
                }else if(likelyhood == 'Unlikely'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#resriskLevel').text('Low');
                    }else if(impact == 'Moderate'){
                        $('#resriskLevel').text('Moderate');
                    }else if(impact == 'Major' | impact == 'Catastropic'){
                        $('#resriskLevel').text('High');
                    }
                }else if(likelyhood == 'Rare'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#resriskLevel').text('Low');
                    }else if(impact == 'Moderate' | impact == 'Major'){
                        $('#resriskLevel').text('Moderate');
                    }else if(impact == 'Catastropic'){
                        $('#resriskLevel').text('High');
                    }
                }
            }

            function remmoveErrorResLikeGR(LHL){
                if($.trim($(LHL).val()) != 'Select Likelyhood Level'){
                    $(LHL).removeClass('has-error');
                    var id = $(LHL).attr("id");
                    $('#error_'+id+'').text('');
                    if($.trim($('#resimpactLevel').val()) == 'Select Impact Level'){
                        $('#resriskLevel').addClass('text-danger');
                        $('#resriskLevel').text('Please select Impact Level');
                    }else{
                        setResRiskLevel();
                    }
                }else{
                    if($.trim($('#resimpactLevel').val()) != 'Select Impact Level'){
                        $('#resriskLevel').addClass('text-danger');
                        $('#resriskLevel').text('Please select Likelyhood Level');
                    }else{
                        $('#resriskLevel').addClass('text-danger');
                        $('#resriskLevel').text('Please select Likelyhood Level and Impact Level');
                    }
                }
            }

            function remmoveErrorResImpactGR(IL){
                if($.trim($(IL).val()) != 'Select Impact Level'){
                    $(IL).removeClass('has-error');
                    var id = $(IL).attr("id");
                    $('#error_'+id+'').text('');
                    if($.trim($('#reslikelyhoodLevel').val()) == 'Select Likelyhood Level'){
                        $('#resriskLevel').addClass('text-danger');
                        $('#resriskLevel').text('Please select Likelyhood Level');
                    }else{
                        setResRiskLevel();
                    }
                }else{
                    if($.trim($('#reslikelyhoodLevel').val()) != 'Select Likelyhood Level'){
                        $('#resriskLevel').addClass('text-danger');
                        $('#resriskLevel').text('Please select Impact Level');
                    }else{
                        $('#resriskLevel').addClass('text-danger');
                        $('#resriskLevel').text('Please select Likelyhood Level and Impact Level');
                    }
                }
            }
            
            $('#btn_risk_identification').click(function(){
                var error_businessImpact = '';
                var error_riskDescription = '';
                var error_riskCategory = '';
                var error_mainUnit = '';

                if($.trim($('#businessImpact').val()).length == 0){
                    error_businessImpact = 'Business Impact is Required';
                    $('#error_businessImpact').text(error_businessImpact);
                    $('#businessImpact').addClass('has-error');
                }else{
                    error_businessImpact = '';
                    $('#error_businessImpact').text(error_businessImpact);
                    $('#businessImpact').removeClass('has-error');
                }

                if($.trim($('#riskDescription').val()).length == 0){
                    error_riskDescription = 'Risk Description is Required';
                    $('#error_riskDescription').text(error_riskDescription);
                    $('#riskDescription').addClass('has-error');
                }else{
                    error_riskDescription = '';
                    $('#error_riskDescription').text(error_riskDescription);
                    $('#riskDescription').removeClass('has-error');
                }

                if($.trim($('#riskCategory').val()) == 'Select Risk Category'){
                    error_riskCategory = 'Risk Category is Required';
                    $('#error_riskCategory').text(error_riskCategory);
                    $('#riskCategory').addClass('has-error');
                }else{
                    error_riskCategory = '';
                    $('#error_riskCategory').text(error_riskCategory);
                    $('#riskCategory').removeClass('has-error');
                }

                if($.trim($('#mainUnit').val()) == 'Select Unit'){
                    error_mainUnit = 'Unit is Required';
                    $('#error_mainUnit').text(error_mainUnit);
                    $('#mainUnit').addClass('has-error');
                }else{
                    error_mainUnit = '';
                    $('#error_mainUnit').text(error_mainUnit);
                    $('#mainUnit').removeClass('has-error');
                }

                if(error_businessImpact != '' | error_riskDescription != '' | error_riskCategory != '' | error_mainUnit != ''){
                    return false;
                }else{
                    $('#list_risk_identification').removeClass('active_tab1 active');
                    $('#list_risk_identification').removeAttr('href data-toggle');
                    $('#risk_identification').removeClass('active in');
                    $('#risk_identification').addClass('fade');
                    $('#list_risk_identification').addClass('inactive_tab1');

                    $('#list_risk_analysis').removeClass('inactive_tab1');
                    $('#list_risk_analysis').addClass('active_tab1 active');
                    $('#list_risk_analysis').attr('href','#risk_analysis');
                    $('#list_risk_analysis').attr('data-toggle','tab');
                    $('#risk_analysis').addClass('active in');
                    $('#risk_analysis').removeClass('fade');
                }
            });

            $('#previous_btn_risk_analysis').click(function(){
                $('#list_risk_analysis').removeClass('active_tab1 active');
                $('#list_risk_analysis').removeAttr('href data-toggle');
                $('#risk_analysis').removeClass('active in');
                $('#risk_analysis').addClass('fade');
                $('#list_risk_analysis').addClass('inactive_tab1');

                $('#list_risk_identification').removeClass('inactive_tab1');
                $('#list_risk_identification').addClass('active_tab1 active');
                $('#list_risk_identification').attr('href','#risk_analysis');
                $('#list_risk_identification').attr('data-toggle','tab');
                $('#risk_identification').addClass('active in');
                $('#risk_identification').removeClass('fade');
            });

            $('#btn_risk_analysis').click(function(){
                var error_kri = '';
                var error_bau = '';
                var error_alert = '';
                var error_risk = '';
                var error_cause = '';
                var error_impact = '';
                var error_likelyhoodLevel = '';
                var error_impactLevel = '';

                if($.trim($('#kri').val()).length == 0){
                    error_kri = 'KRI is Required';
                    $('#error_kri').text(error_kri);
                    $('#kri').addClass('has-error');
                }else{
                    error_kri = '';
                    $('#error_kri').text(error_kri);
                    $('#kri').removeClass('has-error');
                }

                if($.trim($('#bau').val()).length == 0){
                    error_bau = 'BAU is Required';
                    $('#error_bau').text(error_bau);
                    $('#bau').addClass('has-error');
                }else{
                    error_bau = '';
                    $('#error_bau').text(error_bau);
                    $('#bau').removeClass('has-error');
                }

                if($.trim($('#alert').val()).length == 0){
                    error_alert = 'Alert is Required';
                    $('#error_alert').text(error_alert);
                    $('#alert').addClass('has-error');
                }else{
                    error_alert = '';
                    $('#error_alert').text(error_alert);
                    $('#alert').removeClass('has-error');
                }

                if($.trim($('#risk').val()).length == 0){
                    error_risk = 'Risk is Required';
                    $('#error_risk').text(error_risk);
                    $('#risk').addClass('has-error');
                }else{
                    error_risk = '';
                    $('#error_risk').text(error_risk);
                    $('#risk').removeClass('has-error');
                }

                if($.trim($('#cause').val()).length == 0){
                    error_cause = 'Cause is Required';
                    $('#error_cause').text(error_cause);
                    $('#cause').addClass('has-error');
                }else{
                    error_cause = '';
                    $('#error_cause').text(error_cause);
                    $('#cause').removeClass('has-error');
                }

                if($.trim($('#impact').val()).length == 0){
                    error_impact = 'Impact is Required';
                    $('#error_impact').text(error_impact);
                    $('#impact').addClass('has-error');
                }else{
                    error_impact = '';
                    $('#error_impact').text(error_impact);
                    $('#impact').removeClass('has-error');
                }

                if($.trim($('#likelyhoodLevel').val()) == 'Select Likelyhood Level'){
                    error_likelyhoodLevel = 'Likelyhood Level is Required';
                    $('#error_likelyhoodLevel').text(error_likelyhoodLevel);
                    $('#likelyhoodLevel').addClass('has-error');
                }else{
                    error_likelyhoodLevel = '';
                    $('#error_likelyhoodLevel').text(error_likelyhoodLevel);
                    $('#likelyhoodLevel').removeClass('has-error');
                }

                if($.trim($('#impactLevel').val()) == 'Select Impact Level'){
                    error_impactLevel = 'Impact Level is Required';
                    $('#error_impactLevel').text(error_impactLevel);
                    $('#impactLevel').addClass('has-error');
                }else{
                    error_impactLevel = '';
                    $('#error_impactLevel').text(error_impactLevel);
                    $('#impactLevel').removeClass('has-error');
                }

                if(error_kri != '' | error_bau != '' | error_alert != '' | error_risk != '' | error_cause != '' | error_impact != '' | error_likelyhoodLevel != '' | error_impactLevel != ''){
                    return false;
                }else{
                    $('#list_risk_analysis').removeClass('active_tab1 active');
                    $('#list_risk_analysis').removeAttr('href data-toggle');
                    $('#risk_analysis').removeClass('active in');
                    $('#risk_analysis').addClass('fade');
                    $('#list_risk_analysis').addClass('inactive_tab1');

                    $('#list_risk_evaluation').removeClass('inactive_tab1');
                    $('#list_risk_evaluation').addClass('active_tab1 active');
                    $('#list_risk_evaluation').attr('href','#risk_analysis');
                    $('#list_risk_evaluation').attr('data-toggle','tab');
                    $('#risk_evaluation').addClass('active in');
                    $('#risk_evaluation').removeClass('fade');
                }
            });

            $('#previous_btn_risk_evaluation').click(function(){
                $('#list_risk_evaluation').removeClass('active_tab1 active');
                $('#list_risk_evaluation').removeAttr('href data-toggle');
                $('#risk_evaluation').removeClass('active in');
                $('#risk_evaluation').addClass('fade');
                $('#list_risk_evaluation').addClass('inactive_tab1');

                $('#list_risk_analysis').removeClass('inactive_tab1');
                $('#list_risk_analysis').addClass('active_tab1 active');
                $('#list_risk_analysis').attr('href','#risk_analysis');
                $('#list_risk_analysis').attr('data-toggle','tab');
                $('#risk_analysis').addClass('active in');
                $('#risk_analysis').removeClass('fade');
            });

            $('#btn_risk_evaluation').click(function(){
                var error_existingControl = '';
                var error_controlEffectiveness = '';
                var error_reslikelyhoodLevel = '';
                var error_resimpactLevel = '';

                if($.trim($('#existingControl').val()).length == 0){
                    error_existingControl = 'Existing Control is Required';
                    $('#error_existingControl').text(error_existingControl);
                    $('#existingControl').addClass('has-error');
                }else{
                    error_existingControl = '';
                    $('#error_existingControl').text(error_existingControl);
                    $('#existingControl').removeClass('has-error');
                }

                if($.trim($('#controlEffectiveness').val()) == 'Select Control Effectiveness'){
                    error_controlEffectiveness = 'Control Effectiveness is Required';
                    $('#error_controlEffectiveness').text(error_controlEffectiveness);
                    $('#controlEffectiveness').addClass('has-error');
                }else{
                    error_controlEffectiveness = '';
                    $('#error_controlEffectiveness').text(error_controlEffectiveness);
                    $('#controlEffectiveness').removeClass('has-error');
                }

                if($.trim($('#reslikelyhoodLevel').val()) == 'Select Likelyhood Level'){
                    error_reslikelyhoodLevel = 'Likelyhood Level is Required';
                    $('#error_reslikelyhoodLevel').text(error_reslikelyhoodLevel);
                    $('#reslikelyhoodLevel').addClass('has-error');
                }else{
                    error_reslikelyhoodLevel = '';
                    $('#error_reslikelyhoodLevel').text(error_reslikelyhoodLevel);
                    $('#reslikelyhoodLevel').removeClass('has-error');
                }

                if($.trim($('#resimpactLevel').val()) == 'Select Impact Level'){
                    error_resimpactLevel = 'Impact Level is Required';
                    $('#error_resimpactLevel').text(error_resimpactLevel);
                    $('#resimpactLevel').addClass('has-error');
                }else{
                    error_resimpactLevel = '';
                    $('#error_resimpactLevel').text(error_resimpactLevel);
                    $('#resimpactLevel').removeClass('has-error');
                }

                if(error_existingControl != '' | error_controlEffectiveness != '' | error_reslikelyhoodLevel != '' | error_resimpactLevel != ''){
                    return false;
                }else{
                    $('#list_risk_evaluation').removeClass('active_tab1 active');
                    $('#list_risk_evaluation').removeAttr('href data-toggle');
                    $('#risk_evaluation').removeClass('active in');
                    $('#risk_evaluation').addClass('fade');
                    $('#list_risk_evaluation').addClass('inactive_tab1');

                    $('#list_risk_treatment').removeClass('inactive_tab1');
                    $('#list_risk_treatment').addClass('active_tab1 active');
                    $('#list_risk_treatment').attr('href','#risk_analysis');
                    $('#list_risk_treatment').attr('data-toggle','tab');
                    $('#risk_treatment').addClass('active in');
                    $('#risk_treatment').removeClass('fade');
                }
            });

            $('#previous_btn_risk_treatment').click(function(){
                $('#list_risk_treatment').removeClass('active_tab1 active');
                $('#list_risk_treatment').removeAttr('href data-toggle');
                $('#risk_treatment').removeClass('active in');
                $('#risk_treatment').addClass('fade');
                $('#list_risk_treatment').addClass('inactive_tab1');

                $('#list_risk_evaluation').removeClass('inactive_tab1');
                $('#list_risk_evaluation').addClass('active_tab1 active');
                $('#list_risk_evaluation').attr('href','#risk_analysis');
                $('#list_risk_evaluation').attr('data-toggle','tab');
                $('#risk_evaluation').addClass('active in');
                $('#risk_evaluation').removeClass('fade');
            });

            $('#btn_risk_treatment').click(function(){
                var error_riskResponse = '';
                var error_activity = '';
                var error_deadline = '';
                var error_Effectiveness = '';
                var error_currentStatus = '';
                var error_detailLevel = '';

                if($.trim($('#riskResponse').val()) == 'Select Risk Response'){
                    error_riskResponse = 'Risk Response is Required';
                    $('#error_riskResponse').text(error_riskResponse);
                    $('#riskResponse').addClass('has-error');
                }else{
                    error_riskResponse= '';
                    $('#error_riskResponse').text(error_riskResponse);
                    $('#riskResponse').removeClass('has-error');
                }

                if($.trim($('#activity').val()).length == 0 & ($.trim($('#riskResponse').val()) != 'Retain')){
                    error_activity = 'Activity is Required';
                    $('#error_activity').text(error_activity);
                    $('#activity').addClass('has-error');
                }else{
                    error_activity = '';
                    $('#error_activity').text(error_activity);
                    $('#activity').removeClass('has-error');
                }

                if($.trim($('#deadline').val()) == '' & ($.trim($('#riskResponse').val()) != 'Retain')){
                    error_deadline = 'Deadline is Required';
                    $('#error_deadline').text(error_deadline);
                    $('#deadline').addClass('has-error');
                }else{
                    error_deadline = '';
                    $('#error_deadline').text(error_deadline);
                    $('#deadline').removeClass('has-error');
                }

                if($.trim($('#Effectiveness').val()) == 'Select Effectiveness' & ($.trim($('#riskResponse').val()) != 'Retain')){
                    error_Effectiveness = 'Effectiveness is Required';
                    $('#error_Effectiveness').text(error_Effectiveness);
                    $('#Effectiveness').addClass('has-error');
                }else{
                    error_Effectiveness = '';
                    $('#error_Effectiveness').text(error_Effectiveness);
                    $('#Effectiveness').removeClass('has-error');
                }

                if($.trim($('#currentStatus').val()) == 'Select Current Status' & ($.trim($('#riskResponse').val()) != 'Retain')){
                    error_currentStatus = 'Current Status is Required';
                    $('#error_currentStatus').text(error_currentStatus);
                    $('#currentStatus').addClass('has-error');
                }else{
                    error_currentStatus = '';
                    $('#error_currentStatus').text(error_currentStatus);
                    $('#currentStatus').removeClass('has-error');
                }

                if(error_riskResponse != '' | error_activity != '' | error_deadline != '' | error_Effectiveness != '' | error_currentStatus != ''){
                    return false;
                }else{
                    $('#view_businessImpact').text($.trim($('#businessImpact').val()));
                    $('#view_riskDescription').text($.trim($('#riskDescription').val()));
                    $('#view_riskCategory').text($.trim($('#riskCategory').val()));
                    $('#view_mainUnit').text($.trim($('#mainUnit').val()));
                    $('#view_kri').text($.trim($('#kri').val()));
                    $('#view_bau').text($.trim($('#bau').val()));
                    $('#view_alert').text($.trim($('#alert').val()));
                    $('#view_risk').text($.trim($('#risk').val()));
                    $('#view_cause').text($.trim($('#cause').val()));
                    $('#view_impact').text($.trim($('#impact').val()));
                    $('#view_likelyhoodLevel').text($.trim($('#likelyhoodLevel').val()));
                    $('#view_impactLevel').text($.trim($('#impactLevel').val()));
                    $('#view_riskLevel').text($.trim($('#riskLevel').text()));
                    $('#view_existingControl').text($.trim($('#existingControl').val()));
                    $('#view_controlEffectiveness').text($.trim($('#controlEffectiveness').val()));
                    $('#view_reslikelyhoodLevel').text($.trim($('#reslikelyhoodLevel').val()));
                    $('#view_resimpactLevel').text($.trim($('#resimpactLevel').val()));
                    $('#view_resriskLevel').text($.trim($('#resriskLevel').text()));
                    $('#view_riskResponse').text($.trim($('#riskResponse').val()));
                    if($.trim($('#riskResponse').val()) == 'Retain'){
                        $('#view_activity').text("-");
                        $('#view_deadline').text("-");
                        $('#view_Effectiveness').text("-");
                    }else{
                        $('#view_activity').text($.trim($('#activity').val()));
                        $('#view_deadline').text($.trim($('#deadline').val()));
                        $('#view_Effectiveness').text($.trim($('#Effectiveness').val()));
                    }
                    if($.trim($('#currentStatus').val()) == 'Select Current Status'){
                        $('#view_currentStatus').text("-");
                    }else{
                        $('#view_currentStatus').text($.trim($('#currentStatus').val()));
                    }
                    if($.trim($('#detailLevel').val()) == ''){
                        $('#view_detailLevel').text("-");
                    }else{
                        $('#view_detailLevel').text($.trim($('#detailLevel').val()));
                    }


                    $('#list_risk_treatment').removeClass('active_tab1 active');
                    $('#list_risk_treatment').removeAttr('href data-toggle');
                    $('#risk_treatment').removeClass('active in');
                    $('#risk_treatment').addClass('fade');
                    $('#list_risk_treatment').addClass('inactive_tab1');

                    $('#list_risk_review').removeClass('inactive_tab1');
                    $('#list_risk_review').addClass('active_tab1 active');
                    $('#list_risk_review').attr('href','#risk_analysis');
                    $('#list_risk_review').attr('data-toggle','tab');
                    $('#risk_review').addClass('active in');
                    $('#risk_review').removeClass('fade');
                }
            });

            $('#previous_btn_risk_review').click(function(){
                $('#list_risk_review').removeClass('active_tab1 active');
                $('#list_risk_review').removeAttr('href data-toggle');
                $('#risk_review').removeClass('active in');
                $('#risk_review').addClass('fade');
                $('#list_risk_review').addClass('inactive_tab1');

                $('#list_risk_treatment').removeClass('inactive_tab1');
                $('#list_risk_treatment').addClass('active_tab1 active');
                $('#list_risk_treatment').attr('href','#risk_analysis');
                $('#list_risk_treatment').attr('data-toggle','tab');
                $('#risk_treatment').addClass('active in');
                $('#risk_treatment').removeClass('fade');
            });

            $('#btn_submit').click(function(){

                $("#btn_submit").html("Submitting");
                document.getElementById('btn_submit').disabled = true;
                document.body.style.cursor = 'wait';
                
                var reporter = "<?php    $user = $userDetails['empNo']; echo    ''.$user.''; ?>";
                var businessImpact = $.trim($('#businessImpact').val());
                var riskDescription = $.trim($('#riskDescription').val());
                var riskCategory = $.trim($('#riskCategory').val());
                var riskOwner = ['test'];
                var RO = document.getElementsByName("hidden_riskOwnerEmp[]");
                RO.forEach(element => {
                    riskOwner.push(element.value);
                });
                var mainUnit = $.trim($('#mainUnit').val());
                var kri = $.trim($('#kri').val());
                var bau = $.trim($('#bau').val());
                var riskAlert = $.trim($('#alert').val());
                var risk = $.trim($('#risk').val());
                var cause = $.trim($('#cause').val());
                var impact = $.trim($('#impact').val());
                var likelyhoodLevel = $.trim($('#likelyhoodLevel').val());
                var impactLevel = $.trim($('#impactLevel').val());
                var riskLevel = $.trim($('#riskLevel').text());
                var existingControl = $.trim($('#existingControl').val());
                var controlEffectiveness = $.trim($('#controlEffectiveness').val());
                var reslikelyhoodLevel = $.trim($('#reslikelyhoodLevel').val());
                var resimpactLevel = $.trim($('#resimpactLevel').val());
                var resriskLevel = $.trim($('#resriskLevel').text());
                var riskResponse = $.trim($('#riskResponse').val());
                var activity = '';
                var deadline = '';
                var Effectiveness = '';
                if($.trim($('#riskResponse').val()) == 'Retain'){
                    activity = '-';
                    deadline = '-';
                    Effectiveness = '-';
                }else{
                    activity = $.trim($('#activity').val());
                    deadline = $.trim($('#deadline').val());
                    Effectiveness = $.trim($('#Effectiveness').val());
                }
                var Owner = ['test'];
                var AO = document.getElementsByName("hidden_actionOwnerEmp[]");
                AO.forEach(element => {
                    Owner.push(element.value);
                });
                var currentStatus = '';
                if($.trim($('#currentStatus').val()) == 'Select Current Status'){
                    currentStatus = '-';
                }else{
                    currentStatus = $.trim($('#currentStatus').val());
                }
                var detailLevel = '-';
                if($.trim($('#detailLevel').val()) == ''){
                    detailLevel = '-';
                }else{
                    detailLevel = $.trim($('#detailLevel').val());
                }
                
                $.ajax({
                    url: "Add-Risk.php",
                    method: "POST",
                    data: { 
                            businessImpact:businessImpact,
                            riskDescription:riskDescription,
                            riskCategory:riskCategory,
                            riskOwner:riskOwner,
                            mainUnit:mainUnit,
                            kri:kri,
                            bau:bau,
                            riskAlert:riskAlert,
                            risk:risk,
                            cause:cause,
                            impact:impact,
                            likelyhoodLevel:likelyhoodLevel,
                            impactLevel:impactLevel,
                            riskLevel:riskLevel,
                            existingControl:existingControl,
                            controlEffectiveness:controlEffectiveness,
                            reslikelyhoodLevel:reslikelyhoodLevel,
                            resimpactLevel:resimpactLevel,
                            resriskLevel:resriskLevel,
                            riskResponse:riskResponse,
                            activity:activity,
                            Owner:Owner,
                            deadline:deadline,
                            Effectiveness:Effectiveness,
                            currentStatus:currentStatus,
                            detailLevel:detailLevel,
                            reporter:reporter
                    },
                    dataType: "text",
                    success: function(data){
                        if(data == 'True'){
                            alert("Successfully Added!");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please check and resubmit...");
                            location.reload();
                        }
                        
                        //$("#settingsDiv").submit();
                    }
                });
            });
            
            //var option = 
            //{
            //    animation : true
            //};

            //var element = document.getElementById("index");
            //var tooltip = new bootstrap.Tooltip(element, options);
        </script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="../../bootstrap-5.0.0/js/popper.js"></script>
        <script src="../../bootstrap-5.0.0/js/bootstrap.js"></script>
    </body>
</html>