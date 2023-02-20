<?php

    include("../database.php");

    session_start();

    // Session timeout duration in seconds
    // Specify value lesser than the PHPs default timeout of 24 minutes
    $timeout = 900;
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
        $queryUserDetails = "SELECT idUser, fullName, role, category, department FROM user_details WHERE username = '$username'";
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
    $department = $userDetails['department'];
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css" integrity="sha512-C7hOmCgGzihKXzyPU/z4nv97W0d9bv4ALuuEbSf6hm93myico9qa0hv4dODThvCsqQUmKmLcJmlpRmCaApr83g==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" 
        integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
        
        <script src="../../bootstrap-5.0.0/js/popper.js"></script>
        <title>Dashboard - Risk Register Management System</title>
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
                            mb-4 bottom-border">Portal - Divisional<br><small><small><?php   echo    $department;    ?></small></small></a>
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
                                current"><i class="fas fa-tachometer-alt text-light 
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

                                <?php
                                    if($userDetails['category']=="Head"){
                                ?>

                                <li class="nav-item"><a href="Programs.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-stream text-light 
                                fa-lg fa-fw mx-3"></i>Programs</a></li>

                                <?php
                                    }
                                ?>
                            </ul>
                        </div>
                        <!--end of sidebar-->
                        <!--TopNav-->
                        <div class="col-xl-10 col-lg-9 col-md-8 ms-auto bg-dark fixed-top py-2 top-navbar">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h4 class="text-light 
                                    text-uppercase mb-0">Dashboard</h4>
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
                                                <i class="fas fa-user-circle
                                                    text-muted fa-lg">
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
                                                <li><a class="dropdown-item me-3" href="../Central/Home.php"><i class="fas fas fa-map-signs
                                                    fa-lg fa-fw text-light mx-3"></i>ERM Registry</a>
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
                                <div class="row">
                                    <div class="col-xl-4 col-md-12" style="min-height: 315px;">
                                        <div class="card" style="width: auto; height: 100%;">
                                            <div class="card-header justify-content-between">
                                                <small>
                                                    <span style="float: left;">Risk Summary</span>
                                                    <?php
                                                        $sqltot = "SELECT COUNT(*) AS tot FROM divrisk WHERE closeStatus = 0 AND mainUnit = '$department'";
                                                        $resulttot = mysqli_query($conn,$sqltot) or die(mysqli_error($conn));
                                                        $tot = mysqli_fetch_array($resulttot);
                                                        $tot = $tot['tot'];
                                                    ?>
                                                    <span class="text-right" style="float: right;">Total No. of Risk - <?php    echo    $tot;   ?></span>
                                                </small>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive d-flex" style="height: 364px; width:100%; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                    <table class="table table-sm table-striped table-hover" style="width:100%;">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th scope="col"><small><small>Category</small></small></th>
                                                                <th scope="col"><small><small>Key Risks</small></small></th>
                                                                <th scope="col"><small><small>Other Risks</small></small></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row"><small><small>DR / BCM Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRRR = "SELECT COUNT(*) AS KRRR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'DR / BCM Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRRR = mysqli_query($conn,$sqlKRRR) or die(mysqli_error($conn));
                                                                        $KRRR = mysqli_fetch_array($resultKRRR);
                                                                        $KRRR = $KRRR['KRRR'];
                                                                        echo    $KRRR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlRRR = "SELECT COUNT(*) AS RRR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'DR / BCM Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultRRR = mysqli_query($conn,$sqlRRR) or die(mysqli_error($conn));
                                                                        $RRR = mysqli_fetch_array($resultRRR);
                                                                        $RRR = $RRR['RRR'];
                                                                        echo    $RRR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Economic & Political Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKEPR = "SELECT COUNT(*) AS KEPR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Economic & Political Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKEPR = mysqli_query($conn,$sqlKEPR) or die(mysqli_error($conn));
                                                                        $KEPR = mysqli_fetch_array($resultKEPR);
                                                                        $KEPR = $KEPR['KEPR'];
                                                                        echo    $KEPR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlEPR = "SELECT COUNT(*) AS EPR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Economic & Political Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultEPR = mysqli_query($conn,$sqlEPR) or die(mysqli_error($conn));
                                                                        $EPR = mysqli_fetch_array($resultEPR);
                                                                        $EPR = $EPR['EPR'];
                                                                        echo    $EPR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Environmental Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRER = "SELECT COUNT(*) AS KRER FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Environmental Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRER = mysqli_query($conn,$sqlKRER) or die(mysqli_error($conn));
                                                                        $KRER = mysqli_fetch_array($resultKRER);
                                                                        $KRER = $KRER['KRER'];
                                                                        echo    $KRER;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlER = "SELECT COUNT(*) AS ER FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Environmental Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultER = mysqli_query($conn,$sqlER) or die(mysqli_error($conn));
                                                                        $ER = mysqli_fetch_array($resultER);
                                                                        $ER = $ER['ER'];
                                                                        echo    $ER;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Financial Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRFR = "SELECT COUNT(*) AS KRFR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Financial Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRFR = mysqli_query($conn,$sqlKRFR) or die(mysqli_error($conn));
                                                                        $KRFR = mysqli_fetch_array($resultKRFR);
                                                                        $KRFR = $KRFR['KRFR'];
                                                                        echo    $KRFR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlFR = "SELECT COUNT(*) AS FR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Financial Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultFR = mysqli_query($conn,$sqlFR) or die(mysqli_error($conn));
                                                                        $FR = mysqli_fetch_array($resultFR);
                                                                        $FR = $FR['FR'];
                                                                        echo    $FR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Information Security Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRFR = "SELECT COUNT(*) AS KRFR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Information Security Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRFR = mysqli_query($conn,$sqlKRFR) or die(mysqli_error($conn));
                                                                        $KRFR = mysqli_fetch_array($resultKRFR);
                                                                        $KRFR = $KRFR['KRFR'];
                                                                        echo    $KRFR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlFR = "SELECT COUNT(*) AS FR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Information Security Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultFR = mysqli_query($conn,$sqlFR) or die(mysqli_error($conn));
                                                                        $FR = mysqli_fetch_array($resultFR);
                                                                        $FR = $FR['FR'];
                                                                        echo    $FR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Market Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRMR = "SELECT COUNT(*) AS KRMR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Market Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRMR = mysqli_query($conn,$sqlKRMR) or die(mysqli_error($conn));
                                                                        $KRMR = mysqli_fetch_array($resultKRMR);
                                                                        $KRMR = $KRMR['KRMR'];
                                                                        echo    $KRMR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlMR = "SELECT COUNT(*) AS MR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Market Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultMR = mysqli_query($conn,$sqlMR) or die(mysqli_error($conn));
                                                                        $MR = mysqli_fetch_array($resultMR);
                                                                        $MR = $MR['MR'];
                                                                        echo    $MR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Operational Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKROR = "SELECT COUNT(*) AS KROR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Operational Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKROR = mysqli_query($conn,$sqlKROR) or die(mysqli_error($conn));
                                                                        $KROR = mysqli_fetch_array($resultKROR);
                                                                        $KROR = $KROR['KROR'];
                                                                        echo    $KROR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlROR = "SELECT COUNT(*) AS ROR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Operational Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultROR = mysqli_query($conn,$sqlROR) or die(mysqli_error($conn));
                                                                        $ROR = mysqli_fetch_array($resultROR);
                                                                        $ROR = $ROR['ROR'];
                                                                        echo    $ROR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>People Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRPR = "SELECT COUNT(*) AS KRPR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'People Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRPR = mysqli_query($conn,$sqlKRPR) or die(mysqli_error($conn));
                                                                        $KRPR = mysqli_fetch_array($resultKRPR);
                                                                        $KRPR = $KRPR['KRPR'];
                                                                        echo    $KRPR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlPR = "SELECT COUNT(*) AS PR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'People Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultPR = mysqli_query($conn,$sqlPR) or die(mysqli_error($conn));
                                                                        $PR = mysqli_fetch_array($resultPR);
                                                                        $PR = $PR['PR'];
                                                                        echo    $PR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Power Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRPR = "SELECT COUNT(*) AS KRPR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Power Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRPR = mysqli_query($conn,$sqlKRPR) or die(mysqli_error($conn));
                                                                        $KRPR = mysqli_fetch_array($resultKRPR);
                                                                        $KRPR = $KRPR['KRPR'];
                                                                        echo    $KRPR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlPR = "SELECT COUNT(*) AS PR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Power Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultPR = mysqli_query($conn,$sqlPR) or die(mysqli_error($conn));
                                                                        $PR = mysqli_fetch_array($resultPR);
                                                                        $PR = $PR['PR'];
                                                                        echo    $PR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Regulatory Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRRR = "SELECT COUNT(*) AS KRRR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Regulatory Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRRR = mysqli_query($conn,$sqlKRRR) or die(mysqli_error($conn));
                                                                        $KRRR = mysqli_fetch_array($resultKRRR);
                                                                        $KRRR = $KRRR['KRRR'];
                                                                        echo    $KRRR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlRRR = "SELECT COUNT(*) AS RRR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Regulatory Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultRRR = mysqli_query($conn,$sqlRRR) or die(mysqli_error($conn));
                                                                        $RRR = mysqli_fetch_array($resultRRR);
                                                                        $RRR = $RRR['RRR'];
                                                                        echo    $RRR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Reputation Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRReR = "SELECT COUNT(*) AS KRReR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Reputation Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRReR = mysqli_query($conn,$sqlKRReR) or die(mysqli_error($conn));
                                                                        $KRReR = mysqli_fetch_array($resultKRReR);
                                                                        $KRReR = $KRReR['KRReR'];
                                                                        echo    $KRReR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlReR = "SELECT COUNT(*) AS ReR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Reputation Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultReR = mysqli_query($conn,$sqlReR) or die(mysqli_error($conn));
                                                                        $ReR = mysqli_fetch_array($resultReR);
                                                                        $ReR = $ReR['ReR'];
                                                                        echo    $ReR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Strategic Investment Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRSIR = "SELECT COUNT(*) AS KRSIR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Strategic Investment Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRSIR = mysqli_query($conn,$sqlKRSIR) or die(mysqli_error($conn));
                                                                        $KRSIR = mysqli_fetch_array($resultKRSIR);
                                                                        $KRSIR = $KRSIR['KRSIR'];
                                                                        echo    $KRSIR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlSIR = "SELECT COUNT(*) AS SIR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Strategic Investment Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultSIR = mysqli_query($conn,$sqlSIR) or die(mysqli_error($conn));
                                                                        $SIR = mysqli_fetch_array($resultSIR);
                                                                        $SIR = $SIR['SIR'];
                                                                        echo    $SIR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Strategic Partnership Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRSPR = "SELECT COUNT(*) AS KRSPR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Strategic Partnership Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRSPR = mysqli_query($conn,$sqlKRSPR) or die(mysqli_error($conn));
                                                                        $KRSPR = mysqli_fetch_array($resultKRSPR);
                                                                        $KRSPR = $KRSPR['KRSPR'];
                                                                        echo    $KRSPR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlSPR = "SELECT COUNT(*) AS SPR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Strategic Partnership Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultSPR = mysqli_query($conn,$sqlSPR) or die(mysqli_error($conn));
                                                                        $SPR = mysqli_fetch_array($resultSPR);
                                                                        $SPR = $SPR['SPR'];
                                                                        echo    $SPR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><small><small>Technology Risk</small></small></th>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlKRTR = "SELECT COUNT(*) AS KRTR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Technology Risk' AND keyRiskTag = 1) AND mainUnit = '$department'";
                                                                        $resultKRTR = mysqli_query($conn,$sqlKRTR) or die(mysqli_error($conn));
                                                                        $KRTR = mysqli_fetch_array($resultKRTR);
                                                                        $KRTR = $KRTR['KRTR'];
                                                                        echo    $KRTR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                                <td align="right" class="px-3">
                                                                    <small><small>
                                                                    <?php
                                                                        $sqlTR = "SELECT COUNT(*) AS TR FROM divrisk WHERE closeStatus = 0 AND (cateory = 'Technology Risk' AND keyRiskTag = 0) AND mainUnit = '$department'";
                                                                        $resultTR = mysqli_query($conn,$sqlTR) or die(mysqli_error($conn));
                                                                        $TR = mysqli_fetch_array($resultTR);
                                                                        $TR = $TR['TR'];
                                                                        echo    $TR;
                                                                    ?>
                                                                    </small></small>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-12 mt-2 mt-xl-0" style="min-height: 315px;">
                                        <div class="card" style="width: auto;  height: 100%;">
                                            <div class="card-header">
                                                <small>Residual Risk of Open Risks</small>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="myChart" width="100%" height="100%"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-12 mt-2 mt-xl-0" style="min-height: 315px;">
                                        <div class="card" style="width: auto;  height: 100%;">
                                            <div class="card-header">
                                                <small>Absorbed Risks</small>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="myChart2" width="100%" height="100%"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-xl-6 col-md-12" style="min-height: 315px;">
                                        <div class="card" style="width: auto;  height: 100%;">
                                            <div class="card-header">
                                                <small>Open Risks</small>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="myChart3" width="400" height="200"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-12 mt-2 mt-xl-0" style="min-height: 315px;">
                                        <div class="card" style="width: auto;  height: 100%;">
                                            <div class="card-header">
                                                <small>Closed Risks</small>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="myChart4" width="400" height="200"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of Section -->

        <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js" integrity="sha512-zO8oeHCxetPn1Hd9PdDleg5Tw1bAaP0YmNvPY8CwcRyUk7d7/+nyElmFrB6f7vg4f7Fv4sui1mcep8RIEShczg==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js" integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js" integrity="sha512-hZf9Qhp3rlDJBvAKvmiG+goaaKRZA6LKUO35oK6EsM0/kjPK32Yw7URqrq3Q+Nvbbt8Usss+IekL7CRn83dYmw==" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="../../bootstrap-5.0.0/js/popper.js"></script>
        <script src="../../bootstrap-5.0.0/js/bootstrap.js"></script>

        <script type="text/javascript">
            
            var resRisk = [];

            <?php
                $sqlCountRiskLow = "SELECT COUNT(*) AS riskLow FROM divrisk WHERE resriskLevel = 'Low' AND riskResponse != 'Retain' AND closeStatus = 0 AND mainUnit = '$department'";
                $resultCountRiskLow = mysqli_query($conn,$sqlCountRiskLow) or die(mysqli_error($conn));
                $countRiskLow = mysqli_fetch_array($resultCountRiskLow);
            ?>
            resRisk.push(<?php  echo    $countRiskLow['riskLow'];    ?>);

            <?php
                $sqlCountRiskModerate = "SELECT COUNT(*) AS riskModerate FROM divrisk WHERE resriskLevel = 'Moderate' AND riskResponse != 'Retain' AND closeStatus = 0 AND mainUnit = '$department'";
                $resultCountRiskModerate = mysqli_query($conn,$sqlCountRiskModerate) or die(mysqli_error($conn));
                $countRiskModerate = mysqli_fetch_array($resultCountRiskModerate);
            ?>
            resRisk.push(<?php  echo    $countRiskModerate['riskModerate'];    ?>);

            <?php
                $sqlCountRiskHigh = "SELECT COUNT(*) AS riskHigh FROM divrisk WHERE resriskLevel = 'High' AND riskResponse != 'Retain' AND closeStatus = 0 AND mainUnit = '$department'";
                $resultCountRiskHigh = mysqli_query($conn,$sqlCountRiskHigh) or die(mysqli_error($conn));
                $countRiskHigh = mysqli_fetch_array($resultCountRiskHigh);
            ?>
            resRisk.push(<?php  echo    $countRiskHigh['riskHigh'];    ?>);

            <?php
                $sqlCountRiskSignificant = "SELECT COUNT(*) AS riskSignificant FROM divrisk WHERE resriskLevel = 'Significant' AND riskResponse != 'Retain' AND closeStatus = 0 AND mainUnit = '$department'";
                $resultCountRiskSignificant = mysqli_query($conn,$sqlCountRiskSignificant) or die(mysqli_error($conn));
                $countRiskSignificant = mysqli_fetch_array($resultCountRiskSignificant);
            ?>
            resRisk.push(<?php  echo    $countRiskSignificant['riskSignificant'];    ?>);

            <?php
                $sqlCountRiskExtreme = "SELECT COUNT(*) AS riskExtreme FROM divrisk WHERE resriskLevel = 'Extreme' AND riskResponse != 'Retain' AND closeStatus = 0 AND mainUnit = '$department'";
                $resultCountRiskExtreme = mysqli_query($conn,$sqlCountRiskExtreme) or die(mysqli_error($conn));
                $countRiskExtreme = mysqli_fetch_array($resultCountRiskExtreme);
            ?>
            resRisk.push(<?php  echo    $countRiskExtreme['riskExtreme'];    ?>);


            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Low', 'Moderate', 'High', 'Significant', 'Extreme'],
                    datasets: [{
                        data: resRisk,
                        backgroundColor: [
                            'rgba(0, 255, 0, 1)',
                            'rgba(255, 255, 0, 1)',
                            'rgba(255, 128, 0, 1)',
                            'rgba(128, 0, 255, 1)',
                            'rgba(255, 0, 0, 1)'
                        ],
                        borderColor: [
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    plugins: {
                        datalabels: {
                            display: true,
                            align: 'center',
                            backgroundColor: '#ffffff',
                            borderRadius: 5,
                            font: {
                                size: 15,
                            }
                        },
                    }
                }
            });

            var resRTRisk = [];

            <?php
                $sqlCountRiskLow = "SELECT COUNT(*) AS riskLow FROM divrisk WHERE resriskLevel = 'Low' AND riskResponse = 'Retain' AND closeStatus = 0 AND mainUnit = '$department'";
                $resultCountRiskLow = mysqli_query($conn,$sqlCountRiskLow) or die(mysqli_error($conn));
                $countRiskLow = mysqli_fetch_array($resultCountRiskLow);
            ?>
            resRTRisk.push(<?php  echo    $countRiskLow['riskLow'];    ?>);

            <?php
                $sqlCountRiskModerate = "SELECT COUNT(*) AS riskModerate FROM divrisk WHERE resriskLevel = 'Moderate' AND riskResponse = 'Retain' AND closeStatus = 0 AND mainUnit = '$department'";
                $resultCountRiskModerate = mysqli_query($conn,$sqlCountRiskModerate) or die(mysqli_error($conn));
                $countRiskModerate = mysqli_fetch_array($resultCountRiskModerate);
            ?>
            resRTRisk.push(<?php  echo    $countRiskModerate['riskModerate'];    ?>);

            <?php
                $sqlCountRiskHigh = "SELECT COUNT(*) AS riskHigh FROM divrisk WHERE resriskLevel = 'High' AND riskResponse = 'Retain' AND closeStatus = 0 AND mainUnit = '$department'";
                $resultCountRiskHigh = mysqli_query($conn,$sqlCountRiskHigh) or die(mysqli_error($conn));
                $countRiskHigh = mysqli_fetch_array($resultCountRiskHigh);
            ?>
            resRTRisk.push(<?php  echo    $countRiskHigh['riskHigh'];    ?>);

            <?php
                $sqlCountRiskSignificant = "SELECT COUNT(*) AS riskSignificant FROM divrisk WHERE resriskLevel = 'Significant' AND riskResponse = 'Retain' AND closeStatus = 0 AND mainUnit = '$department'";
                $resultCountRiskSignificant = mysqli_query($conn,$sqlCountRiskSignificant) or die(mysqli_error($conn));
                $countRiskSignificant = mysqli_fetch_array($resultCountRiskSignificant);
            ?>
            resRTRisk.push(<?php  echo    $countRiskSignificant['riskSignificant'];    ?>);

            <?php
                $sqlCountRiskExtreme = "SELECT COUNT(*) AS riskExtreme FROM divrisk WHERE resriskLevel = 'Extreme' AND riskResponse = 'Retain' AND closeStatus = 0 AND mainUnit = '$department'";
                $resultCountRiskExtreme = mysqli_query($conn,$sqlCountRiskExtreme) or die(mysqli_error($conn));
                $countRiskExtreme = mysqli_fetch_array($resultCountRiskExtreme);
            ?>
            resRTRisk.push(<?php  echo    $countRiskExtreme['riskExtreme'];    ?>);

            var ctx = document.getElementById('myChart2').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Low', 'Moderate', 'High', 'Significant', 'Extreme'],
                    datasets: [{
                        data: resRTRisk,
                        backgroundColor: [
                            'rgba(0, 255, 0, 1)',
                            'rgba(255, 255, 0, 1)',
                            'rgba(255, 128, 0, 1)',
                            'rgba(128, 0, 255, 1)',
                            'rgba(255, 0, 0, 1)'
                        ],
                        borderColor: [
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    plugins: {
                        datalabels: {
                            display: true,
                            align: 'center',
                            backgroundColor: '#ffffff',
                            borderRadius: 5,
                            font: {
                                size: 15,
                            }
                        },
                    }
                }
            });

            var l = [];
            var openRisk = [];

            <?php

                $sqlMinMaxYr = "SELECT MIN(YEAR(reportedDate)) AS minYr FROM divrisk";
                $resultMinMaxYr = mysqli_query($conn,$sqlMinMaxYr) or die(mysqli_error($conn));
                $minYrMaxYr = mysqli_fetch_array($resultMinMaxYr);

                $minYr = $minYrMaxYr['minYr'];
                $maxYr = date("Y");
                $month = date("n");
                $yearQuarter = ceil($month / 3);
                $c = 0;
                for($yr = $minYr;$yr<=$maxYr;$yr++){
                    if($yr<$maxYr){
                        for($q = 1;$q<=4;$q++){
                            $sqlCountOpenRisk = "SELECT COUNT(*) AS tot FROM divrisk WHERE QUARTER(reportedDate) = '$q' AND YEAR(reportedDate) = '$yr' AND mainUnit = '$department'";
                            $resultCountOpenRisk = mysqli_query($conn,$sqlCountOpenRisk) or die(mysqli_error($conn));
                            $countOpenRisk = mysqli_fetch_array($resultCountOpenRisk);
                            $count = $countOpenRisk['tot'];
                            $c = $c + $count;
            ?>
                            l.push('<?php   echo    'Q'.$q.' - '.$yr.'';   ?>');
                            openRisk.push('<?php echo    $c; ?>');
            <?php
                        }
                    }else if($yr==$maxYr){
                        for($qf = 1;$qf<=$yearQuarter;$qf++){
                            $sqlCountOpenRisk = "SELECT COUNT(*) AS tot FROM divrisk WHERE QUARTER(reportedDate) = '$qf' AND YEAR(reportedDate) = '$yr' AND mainUnit = '$department'";
                            $resultCountOpenRisk = mysqli_query($conn,$sqlCountOpenRisk) or die(mysqli_error($conn));
                            $countOpenRisk = mysqli_fetch_array($resultCountOpenRisk);
                            $count = $countOpenRisk['tot'];
                            $c = $c + $count;
            ?>
                            l.push('<?php   echo    'Q'.$qf.' - '.$yr.'';   ?>');
                            openRisk.push('<?php echo    $c; ?>');
            <?php
                        }
                    }
                }
            ?>

            var ctx = document.getElementById('myChart3').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: l,
                    datasets: [{
                        backgroundColor: "#8DA6F9",
                        label: 'Number Opened of Risks (Cumulative)',
                        base: 0,
                        data: openRisk,
                    }],
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                                stepSize: 1
                            },
                            beginAtZero: true
                        }]
                    }
                }
            });

            var l2 = [];
            var closeRisk = [];

            <?php
                for($yr = $minYr;$yr<=$maxYr;$yr++){
                    if($yr<$maxYr){
                        for($q = 1;$q<=4;$q++){
                            $sqlCountOpenRisk = "SELECT COUNT(*) AS tot FROM divrisk WHERE closeStatus = 1 AND (QUARTER(closeDate) = '$q' AND YEAR(closeDate) = '$yr') AND mainUnit = '$department'";
                            $resultCountOpenRisk = mysqli_query($conn,$sqlCountOpenRisk) or die(mysqli_error($conn));
                            $countOpenRisk = mysqli_fetch_array($resultCountOpenRisk);
                            $count = $countOpenRisk['tot'];
                            $cc = $count;
            ?>
                            l2.push('<?php   echo    'Q'.$q.' - '.$yr.'';   ?>');
                            closeRisk.push('<?php echo    $cc; ?>');
            <?php
                        }
                    }else if($yr==$maxYr){
                        for($q = 1;$q<=$yearQuarter;$q++){
                            $sqlCountOpenRisk = "SELECT COUNT(*) AS tot FROM divrisk WHERE closeStatus = 1 AND (QUARTER(closeDate) = '$q' AND YEAR(closeDate) = '$yr') AND mainUnit = '$department'";
                            $resultCountOpenRisk = mysqli_query($conn,$sqlCountOpenRisk) or die(mysqli_error($conn));
                            $countOpenRisk = mysqli_fetch_array($resultCountOpenRisk);
                            $count = $countOpenRisk['tot'];
                            $cc = $count;
            ?>
                            l2.push('<?php   echo    'Q'.$q.' - '.$yr.'';   ?>');
                            closeRisk.push('<?php echo    $cc; ?>');
            <?php
                        }
                    }
                }
            ?>

            var ctx = document.getElementById('myChart4').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: l2,
                    datasets: [{
                        backgroundColor: "#79D1DF",
                        label: 'Number of Closed Risks',
                        base: 0,
                        data: closeRisk,
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                                stepSize: 1
                            },
                            beginAtZero: true
                        }]
                    }
                }
            });
        </script>
    </body>
</html>