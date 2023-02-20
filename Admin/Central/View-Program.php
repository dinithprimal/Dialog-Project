<?php

    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

    session_start();

    $idInfoProg = $_GET['id'];

    $sqlInfoProg = "SELECT * FROM infogather WHERE idInfo = '$idInfoProg'";
    $resultInfoProg = mysqli_query($conn,$sqlInfoProg) or die(mysqli_error($conn));
    $detailsInfoProg = mysqli_fetch_array($resultInfoProg);
    $countInfoProg = mysqli_num_rows($resultInfoProg);

    if($countInfoProg != 1){
        echo '<script type="text/javascript">alert("Oops..! Something went wrong...");</script>';
        echo "<script>location.href='Home.php'</script>";
    }

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
        $queryUserDetails = "SELECT idUser, fullName, role FROM user_details WHERE username = '$username'";
        $resultUserDetails = mysqli_query($conn,$queryUserDetails) or die(mysqli_error($conn));
        $userDetails = mysqli_fetch_array($resultUserDetails);
        if($userDetails['role']!="Admin"){
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
        <title>View Program - Risk Register Management System</title>
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

                                <li class="nav-item"><a href="Risks.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-tasks text-light 
                                fa-lg fa-fw mx-3"></i>Risks</a></li>

                                <li class="nav-item"><a href="Programs.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-stream text-light 
                                fa-lg fa-fw mx-3"></i>Programs</a></li>

                                <li class="nav-item"><a href="Users.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-users text-light 
                                fa-lg fa-fw mx-3"></i>Users</a></li>

                                <li class="nav-item"><a href="Settings.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-wrench text-light 
                                fa-lg fa-fw mx-3"></i>Settings</a></li>
                            </ul>
                        </div>
                        <!--end of sidebar-->
                        <!--TopNav-->
                        <div class="col-xl-10 col-lg-9 col-md-8 ms-auto bg-dark fixed-top py-2 top-navbar">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h4 class="text-light 
                                    text-uppercase mb-0">View Program</h4>
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

        <!-- Model Logout -->
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
        <!-- end of Model Logout -->

        <!-- Modal Add Risk Deadline -->
        <div class="modal fade" id="change-deadline" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Change Program Deadline</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                        <input type="datetime-local" name="deadline" id="deadline" onchange="enableSaveChangeProgramDeadline();" class="form-control" style="width: 100%;"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveChangeProgramDeadline" name="saveChangeProgramDeadline" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Add Risk Deadline -->

        <!-- end of Modal -->

        <!-- Section -->
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 col-lg-9 col-md-8 ms-auto">
                        <div class="row p-2 pt-md-5 mt-md-2 mb-auto">
                            <div class="container">
                                <div class="row g-1 g-lg-2">
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-header">
                                                    <small><?php    echo    $detailsInfoProg['Name'];  ?></small>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-control p-3">
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="col-3">
                                                                        <small><small><label>Start Date / Time </label></small></small>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <small><small><label style="float: right;">
                                                                        <?php
                                                                            $value = $detailsInfoProg['startDate'];
                                                                            $start_datetime = new DateTime($value);
                                                                            echo    $start_datetime->format("l, d F Y, h:i A");
                                                                        ?>
                                                                        </label></small></small>
                                                                    </div>
                                                                    <div class="col-3">
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="col-3">
                                                                        <small><small><label>
                                                                        <?php
                                                                            if($detailsInfoProg['status'] == 0){
                                                                        ?>
                                                                            Due Date / Time 
                                                                        <?php
                                                                            }else{
                                                                        ?>
                                                                            End Date
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                        </label></small></small>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <small><small><label style="float: right;">
                                                                        <?php
                                                                            $valueEnd = $detailsInfoProg['endDate'];
                                                                            $end_datetime = new DateTime($valueEnd);
                                                                            echo    $end_datetime->format("l, d F Y, h:i A");
                                                                        ?>
                                                                        </label></small></small>
                                                                    </div>
                                                                    <div class="col-3">
                                                                    <?php
                                                                        if($detailsInfoProg['status'] == 0){
                                                                    ?>
                                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#change-deadline" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;">Edit</button>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                    if($detailsInfoProg['status'] == 0){
                                                                ?>
                                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                                    <?php
                                                                        $now = new DateTime();
                                                                        $interval = $end_datetime->diff($now);
                                                                    ?>
                                                                    <div class="col-3">
                                                                        <small><small><label class="<?php    if($end_datetime < $now){   echo    "text-danger"; }else{   echo    "text-success"; }  ?>">
                                                                        <?php
                                                                            if($end_datetime > $now){
                                                                        ?>
                                                                                Time Remaining 
                                                                        <?php
                                                                            }else{
                                                                        ?>
                                                                                Overdue By 
                                                                        <?php
                                                                            }
                                                                        ?>  
                                                                        </label></small></small>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <small><small><label class="<?php    if($end_datetime < $now){   echo    "text-danger"; }else{   echo    "text-success"; }  ?>" style="float: right;">
                                                                            <b>
                                                                                <?php
                                                                                    if(($interval->format("%a"))>0){

                                                                                        echo $interval->format("%a day(s), %h hour(s)");
                                    
                                                                                    }else if(($interval->format("%h"))>0){
                                    
                                                                                        echo $interval->format("%h hour(s), %i minute(s)");
                                    
                                                                                    }else if(($interval->format("%i"))>0){
                                    
                                                                                        echo $interval->format("%i minute(s), %s second(s)");
                                    
                                                                                    }else{
                                    
                                                                                        echo $interval->format("%s second(s)");
                                    
                                                                                    }
                                                                                ?>
                                                                            </b>
                                                                        </label></small></small>
                                                                    </div>
                                                                    <div class="col-3">
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="col-3">
                                                                        <small><small><label>Number of Reminders Sent </label></small></small>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <small><small><label style="float: right;">
                                                                        <?php
                                                                            $valueTot = $detailsInfoProg['totReminder'];
                                                                            echo   $valueTot;
                                                                        ?>
                                                                        </label></small></small>
                                                                    </div>
                                                                    <div class="col-3">
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="col-3">
                                                                        <small><small><label>Last Reminder Sent on </label></small></small>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <small><small><label style="float: right;">
                                                                        <?php
                                                                            $valueRem = $detailsInfoProg['lastReminder'];
                                                                            $reminderdatetime = new DateTime($valueRem);
                                                                            echo    $reminderdatetime->format("l, d F Y, h:i A");
                                                                        ?>
                                                                        </label></small></small>
                                                                    </div>
                                                                    <div class="col-3">
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="row mb-5">
                                                                    <div class="col">
                                                            <?php
                                                                if($detailsInfoProg['status'] == 0){
                                                            ?>
                                                                        <button type="button" name="btn_end" id="btn_end" style="float: right;" class="btn btn-danger mx-1 btn-md px-5" <?php   if($end_datetime > $now){   echo    "disabled"; }   ?>>End This Program</button>
                                                            <?php
                                                                }
                                                            ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-5">
                                                                    <div class="col pt-2">
                                                                    <?php
                                                                        if($detailsInfoProg['status'] == 0){
                                                                            $nowDate = $now->format('Y-m-d');
                                                                            $remDate = $reminderdatetime->format('Y-m-d');
                                                                    ?>
                                                                        <button type="button" name="sendReminders" id="sendReminders" style="float: right;" class="btn btn-success mx-1 btn-md px-5" <?php   if($end_datetime < $now | ($remDate == $nowDate)){   echo    "disabled"; }   ?>>Send Reminders</button>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-cols-1 g-1 g-lg-2">
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="card" style="width: auto; height: 470px;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Risk Update Details</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted"><small>Shown option that taken by risk owners / action owners belongs to the risks</small></h6>
                                                    <br>
                                                    <div class="d-grid gap-2">
                                                        <div class="table-responsive d-flex" style="height: 360px; width:100%; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                            <table class="table table-sm table-striped table-hover" style="width:100%; min-width:1100px">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col" style="width: 15%;"><small><small>Risk ID</small></small></th>
                                                                        <th scope="col" style="width: 35%;"><small><small>Risk / Action Owner</small></small></th>
                                                                        <th scope="col" style="width: 30%;"><small><small>Status</small></small></th>
                                                                        <th scope="col" style="width: 20%;"><small><small>Submitted Date / Time</small></small></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                    $sqlAllRisks = "SELECT indexRisk FROM risk WHERE closeStatus = 0";
                                                                    $resultAllRisks = mysqli_query($conn,$sqlAllRisks) or die(mysqli_error($conn));
                                                                    while($AllRisks = mysqli_fetch_array($resultAllRisks)){
                                                                        $indexRisk = $AllRisks['indexRisk'];
                                                                        $sqlGetOwners = "SELECT empNo AS empN FROM actionowners WHERE indexRisk = '$indexRisk'";
                                                                        $resultGetOwners = mysqli_query($conn,$sqlGetOwners) or die(mysqli_error($conn));
                                                                        $countGetOwners = mysqli_num_rows($resultGetOwners);
                                                                        $count = 1;
                                                                        while($GetOwners = mysqli_fetch_array($resultGetOwners)){
                                                                            $empNo = $GetOwners['empN'];
                                                                            $sqlGetOwnerName = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
                                                                            $resultGetOwnersName = mysqli_query($conn,$sqlGetOwnerName) or die(mysqli_error($conn));
                                                                            $GetOwnersName = mysqli_fetch_array($resultGetOwnersName);
                                                                            $name = $GetOwnersName['fullName'];

                                                                            $sqlInfo = "SELECT * FROM infogatherdetails WHERE idInfo = '$idInfoProg' AND indexRisk = '$indexRisk' AND empNo = '$empNo'";
                                                                            $resultInfo = mysqli_query($conn,$sqlInfo) or die(mysqli_error($conn));
                                                                            $countInfo = mysqli_num_rows($resultInfo);
                                                                            $info = mysqli_fetch_array($resultInfo);
                                                                            if($count == 1){
                                                                ?>
                                                                    <tr>
                                                                        <td rowspan="<?php  echo    $countGetOwners;    ?>"><small><small><a href="View-Risk.php?id=<?php  echo    $indexRisk;  ?>"><?php   echo    $indexRisk;  ?></a><small><small></td>
                                                                        <td><small><small><?php echo    $name;  ?></small></small></td>
                                                                        <td><small>
                                                                        <?php
                                                                                if($countInfo == 0){
                                                                        ?>
                                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                                        <?php
                                                                                }else{
                                                                                    if($info['descrition'] == 'Submit'){
                                                                        ?>
                                                                            <span class="badge bg-success text-dark">Submited</span>
                                                                        <?php
                                                                                    }else if($info['descrition'] == 'No Update'){
                                                                        ?>
                                                                            <span class="badge bg-info text-dark">No Update</span>
                                                                        <?php
                                                                                    }
                                                                                }
                                                                        ?>
                                                                        </small></td>
                                                                        <td><small><small>
                                                                        <?php
                                                                                if($countInfo == 0){
                                                                        ?>
                                                                            -
                                                                        <?php
                                                                                }else{
                                                                                    $date = ''.$info['date'].' / '.$info['time'].'';
                                                                                    echo    $date;
                                                                                }
                                                                        ?>
                                                                        </small></small></td>
                                                                    </tr>
                                                                <?php
                                                                            }else{
                                                                ?>
                                                                    <tr>
                                                                        <td><small><small><?php echo    $name;  ?></small></small></td>
                                                                        <td><small>
                                                                        <?php
                                                                                if($countInfo == 0){
                                                                        ?>
                                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                                        <?php
                                                                                }else{
                                                                                    if($info['descrition'] == 'Submit'){
                                                                        ?>
                                                                            <span class="badge bg-success text-dark">Submited</span>
                                                                        <?php
                                                                                    }else if($info['descrition'] == 'No Update'){
                                                                        ?>
                                                                            <span class="badge bg-info text-dark">No Update</span>
                                                                        <?php
                                                                                    }
                                                                                }
                                                                        ?>
                                                                        </small></td>
                                                                        <td><small><small>
                                                                        <?php
                                                                                if($countInfo == 0){
                                                                        ?>
                                                                            -
                                                                        <?php
                                                                                }else{
                                                                                    $date = ''.$info['date'].' / '.$info['time'].'';
                                                                                    echo    $date;
                                                                                }
                                                                        ?>
                                                                        </small></small></td>
                                                                    </tr>
                                                                <?php
                                                                            }
                                                                            $count++;
                                                                        }
                                                                    }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
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

        <script type="text/javascript">

            $(function(){
                var dtToday = new Date();
                
                var month = dtToday.getMonth() + 1;
                var day = dtToday.getDate();
                var year = dtToday.getFullYear();
                var hour = dtToday.getHours();
                var minute = dtToday.getMinutes();
                if(month < 10)
                    month = '0' + month.toString();
                if(day < 10)
                    day = '0' + day.toString();
                if(hour<10)
                    hour = '0' + hour.toString();
                if(minute<10)
                    minute = '0' + minute.toString();
                
                var minDate= year + '-' + month + '-' + day + 'T' + hour + ':' + minute;
                
                $('#deadline').attr('min', minDate);
            });

            function enableSaveChangeProgramDeadline(){
                if(document.getElementById('deadline').value != ""){
                    document.getElementById('saveChangeProgramDeadline').disabled = false;
                }else{
                    document.getElementById('saveChangeProgramDeadline').disabled = true;
                }
            }

            $('#saveChangeProgramDeadline').click(function(){
                var deadline = document.getElementById('deadline').value;
                var idInfoProg = "<?php   echo    $idInfoProg; ?>";
                $.ajax({
                    url: "Change-Program-Deadline.php",
                    method: "POST",
                    data: {idInfoProg:idInfoProg,deadline:deadline},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Changed");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                        }
                    }
                })
            });

            $('#btn_end').click(function(){
                $("#btn_end").html("Ending This Program...");
                document.getElementById('btn_end').disabled = true;
                document.body.style.cursor = 'wait';
                var idInfoProg = "<?php   echo    $idInfoProg; ?>";
                $.ajax({
                    url: "End-Info-Program.php",
                    method: "POST",
                    data: {idInfoProg:idInfoProg},
                    dataType: "text",
                    success: function(data){
                        
                        alert(data);
                        if(data == "true"){
                            alert("Successfully Ended");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                            location.reload();
                        }
                    }
                })
            });

            $('#sendReminders').click(function(){
                $("#sendReminders").html("Sending...");
                document.getElementById('sendReminders').disabled = true;
                document.body.style.cursor = 'wait';
                var idInfoProg = "<?php   echo    $idInfoProg; ?>";
                $.ajax({
                    url: "Send-Reminders.php",
                    method: "POST",
                    data: {idInfoProg:idInfoProg},
                    dataType: "text",
                    success: function(data){
                        
                        alert(data);
                        if(data == "true"){
                            alert("Successfully Sent");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                            location.reload();
                        }
                    }
                })
            });

        </script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="../../bootstrap-5.0.0/js/popper.js"></script>
        <script src="../../bootstrap-5.0.0/js/bootstrap.js"></script>
    </body>
</html>