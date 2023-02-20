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
        $queryUserDetails = "SELECT idUser, empNo, fullName, role, category, department FROM user_details WHERE username = '$username'";
        $resultUserDetails = mysqli_query($conn,$queryUserDetails) or die(mysqli_error($conn));
        $userDetails = mysqli_fetch_array($resultUserDetails);
        $empNoUser = $userDetails['empNo'];
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
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" 
        integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
        
        <title>My Risks - Risk Register Management System</title>
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
                                sidebar-link"><i class="fas fa-tachometer-alt text-light 
                                fa-lg mx-3"></i>Dashboard</a></li>

                                <li class="nav-item"><a href="Home.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-home text-light 
                                fa-lg fa-fw mx-3"></i>Home</a></li>

                                <li class="nav-item"><a href="My-Risks.php"
                                class="nav-link text-white p-3 mb-2 
                                current"><i 
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
                                    text-uppercase mb-0">All Risks</h4>
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
                            <div class="container mb-3">
                                <div class="row g-1 g-lg-2">
                                    <div class="col">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-body" style="width: 100%;">
                                                    <h5 class="card-title">Reported Risks</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted"><small>Shown all risks which reported by you. Please select the risk to view and update.</small></h6>
                                                    <br>
                                                    <small>
                                                        <table cellpadding="3" cellspacing="0" border="0" style="width: 67%; margin: 0 auto 2em auto;">
                                                            <tbody>
                                                                <tr id="filter_col1" data-column="0">
                                                                    <td>Risk Index</td>
                                                                    <td align="center"><input type="text" class="column_filter" id="col0_filter"></td>
                                                                </tr>
                                                                <tr id="filter_col2" data-column="1">
                                                                    <td>Category</td>
                                                                    <td align="center"><input type="text" class="column_filter" id="col1_filter"></td>
                                                                </tr>
                                                                <tr id="filter_col4" data-column="2">
                                                                    <td>Main Unit</td>
                                                                    <td align="center"><input type="text" class="column_filter" id="col2_filter"></td>
                                                                </tr>
                                                                <tr id="filter_col5" data-column="3">
                                                                    <td>Current Status</td>
                                                                    <td align="center"><input type="text" class="column_filter" id="col3_filter"></td>
                                                                </tr>
                                                                <tr id="filter_col6" data-column="4">
                                                                    <td>Action Owner</td>
                                                                    <td align="center"><input type="text" class="column_filter" id="col4_filter"></td>
                                                                </tr>
                                                                <tr id="filter_col7" data-column="5">
                                                                    <td>Reporter</td>
                                                                    <td align="center"><input type="text" class="column_filter" id="col5_filter"></td>
                                                                </tr>
                                                                <tr id="filter_col8" data-column="6">
                                                                    <td>Date</td>
                                                                    <td align="center"><input type="text" class="column_filter" id="col6_filter"></td>
                                                                </tr>
                                                                <tr id="filter_col8" data-column="8" class="form-check form-switch d-flex justify-content-between align-items-center">
                                                                    <td>Key Risks</td>
                                                                    <td align="center"><input type="checkbox" onchange="remmoveErrorRiskUnit(this)" value="KR" class="form-check-input form-switch" id="col8_filter"></td>
                                                                </tr>
                                                                <tr id="filter_col9" data-column="9" class="form-check form-switch d-flex justify-content-between align-items-center">
                                                                    <td>Closed Risks</td>
                                                                    <td align="center"><input type="checkbox" onchange="remmoveErrorRiskUnit(this)" value="Closed" class="form-check-input form-switch" id="col9_filter"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                            
                                                        <table id="programsHistory" style="width:100%;" class="table table-sm table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th><small>Risk Index</small></th>
                                                                    <th><small>Category</small></th>
                                                                    <th><small>Main Unit</small></th>
                                                                    <th><small>Current Status</small></th>
                                                                    <th><small>Action Owners</small></th>
                                                                    <th><small>Reported By</small></th>
                                                                    <th><small>Date</small></th>
                                                                    <th><small>Time</small></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                                $querySelIndex = "SELECT * FROM divrisk WHERE reporter = '$empNoUser' ORDER BY idRisk DESC";
                                                                $resultSelIndex = mysqli_query($conn, $querySelIndex);
                                                                if(mysqli_num_rows($resultSelIndex) > 0){
                                                                    while($rowIndex = mysqli_fetch_array($resultSelIndex)){
                                                            ?>
                                                                <tr>
                                                                    <td><small><a href="View-Risk.php?id=<?php  echo    $rowIndex['indexRisk']; ?>"><?php echo  $rowIndex["indexRisk"]; if($rowIndex['keyRiskTag'] == 1){ ?><span class="text-danger"> KR</span><?php  } if($rowIndex['closeStatus'] == 1){ ?><span class="text-danger"> Closed</span><?php  }   ?></a></small></td>
                                                                    <td><small><?php echo  $rowIndex['cateory']; ?></small></td>
                                                                    <td><small><?php echo  $rowIndex['mainUnit']; ?></small></td>
                                                                    <td><small><?php echo  $rowIndex["currentStatus"]; ?></small></td>
                                                                    <?php
                                                                        $index = $rowIndex["indexRisk"];
                                                                        $sqlActionOwnerEMP = "SELECT empNo FROM divactionowners WHERE indexRisk = '$index'";
                                                                        $resultActionOwnerEMP = mysqli_query($conn, $sqlActionOwnerEMP);
                                                                        $actionOwners = '';
                                                                        $count = 1;
                                                                        while($ActionOwnerEMP = mysqli_fetch_array($resultActionOwnerEMP)){
                                                                            $actionOwnerEmp = $ActionOwnerEMP['empNo'];
                                                                            $sqlFullName = "SELECT fullName FROM user_details WHERE empNo = '$actionOwnerEmp'";
                                                                            $resultFullName = mysqli_query($conn, $sqlFullName);
                                                                            $arrayFullName = mysqli_fetch_array($resultFullName);
                                                                            $fullName = $arrayFullName['fullName'];
                                                                            if($count == 1){
                                                                                $actionOwners .= ''.$fullName.'';
                                                                            }else{
                                                                                $actionOwners .= '<br>'.$fullName.'';
                                                                            }
                                                                            $count++;
                                                                        }
                                                                    ?>
                                                                    <td><small><?php echo  $actionOwners; ?></small></td>
                                                                    <td>
                                                                        <small>
                                                                            <?php
                                                                                $empNo = $rowIndex["reporter"];
                                                                                $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
                                                                                $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                                                                                $fullName = mysqli_fetch_array($resultFullName);
                                                                                echo    $fullName['fullName'];
                                                                            ?>
                                                                        </small>
                                                                    </td>
                                                                    <td><small><?php echo  $rowIndex['reportedDate']; ?></small></td>
                                                                    <td><small><?php echo  $rowIndex["reportedTime"]; ?></small></td>
                                                                </tr>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th><small>Risk Index</small></th>
                                                                    <th><small>Category</small></th>
                                                                    <th><small>Main Unit</small></th>
                                                                    <th><small>Current Status</small></th>
                                                                    <th><small>Action Owners</small></th>
                                                                    <th><small>Reported By</small></th>
                                                                    <th><small>Date</small></th>
                                                                    <th><small>Time</small></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </small>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="row g-1 g-lg-2 mt-2">
                                    <div class="col">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-body" style="width: 100%;">
                                                    <h5 class="card-title">Me as Risk Owner</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted"><small>Shown all risks which you as risk owner. Please select the risk to view and update.</small></h6>
                                                    <br>
                                                    <small>
                                                        <table cellpadding="3" cellspacing="0" border="0" style="width: 67%; margin: 0 auto 2em auto;">
                                                            <tbody>
                                                                <tr id="filter_col1T2" data-column="0">
                                                                    <td>Risk Index</td>
                                                                    <td align="center"><input type="text" class="column_filterT2" id="col0_filterT2"></td>
                                                                </tr>
                                                                <tr id="filter_col2T2" data-column="1">
                                                                    <td>Category</td>
                                                                    <td align="center"><input type="text" class="column_filterT2" id="col1_filterT2"></td>
                                                                </tr>
                                                                <tr id="filter_col4T2" data-column="2">
                                                                    <td>Main Unit</td>
                                                                    <td align="center"><input type="text" class="column_filterT2" id="col2_filterT2"></td>
                                                                </tr>
                                                                <tr id="filter_col5T2" data-column="3">
                                                                    <td>Current Status</td>
                                                                    <td align="center"><input type="text" class="column_filterT2" id="col3_filterT2"></td>
                                                                </tr>
                                                                <tr id="filter_col6T2" data-column="4">
                                                                    <td>Reporter</td>
                                                                    <td align="center"><input type="text" class="column_filterT2" id="col4_filterT2"></td>
                                                                </tr>
                                                                <tr id="filter_col7T2" data-column="5">
                                                                    <td>Action Owner</td>
                                                                    <td align="center"><input type="text" class="column_filterT2" id="col5_filterT2"></td>
                                                                </tr>
                                                                <tr id="filter_col8T2" data-column="6">
                                                                    <td>Date</td>
                                                                    <td align="center"><input type="text" class="column_filterT2" id="col6_filterT2"></td>
                                                                </tr>
                                                                <tr id="filter_col8" data-column="8" class="form-check form-switch d-flex justify-content-between align-items-center">
                                                                    <td>Key Risks</td>
                                                                    <td align="center"><input type="checkbox" onchange="remmoveErrorRiskUnit2(this)" value="KR" class="form-check-input form-switch" id="col8_filter"></td>
                                                                </tr>
                                                                <tr id="filter_col9" data-column="9" class="form-check form-switch d-flex justify-content-between align-items-center">
                                                                    <td>Closed Risks</td>
                                                                    <td align="center"><input type="checkbox" onchange="remmoveErrorRiskUnit2(this)" value="Closed" class="form-check-input form-switch" id="col9_filter"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                            
                                                        <table id="riskOwnerTable" style="width:100%;" class="table table-sm table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th><small>Risk Index</small></th>
                                                                    <th><small>Category</small></th>
                                                                    <th><small>Main Unit</small></th>
                                                                    <th><small>Current Status</small></th>
                                                                    <th><small>Action Owners</small></th>
                                                                    <th><small>Reported By</small></th>
                                                                    <th><small>Date</small></th>
                                                                    <th><small>Time</small></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                                $querySelIndex = "SELECT indexRisk FROM divriskowners WHERE empNo = '$empNoUser'";
                                                                $resultSelIndex = mysqli_query($conn, $querySelIndex);
                                                                if(mysqli_num_rows($resultSelIndex) > 0){
                                                                    while($rowIndex = mysqli_fetch_array($resultSelIndex)){
                                                                        $index = $rowIndex['indexRisk'];
                                                                        $query = "SELECT indexRisk, cateory, mainUnit, currentStatus, reporter, reportedDate, keyRiskTag, closeStatus, reportedTime FROM divrisk WHERE indexRisk = '$index'";
                                                                        $result = mysqli_query($conn, $query);
                                                                        $row = mysqli_fetch_array($result);
                                                            ?>
                                                                <tr>
                                                                    <td><small><a href="View-Risk.php?id=<?php  echo    $row['indexRisk']; ?>"><?php echo  $row["indexRisk"]; if($row['keyRiskTag'] == 1){ ?><span class="text-danger"> KR</span><?php  } if($row['closeStatus'] == 1){ ?><span class="text-danger"> Closed</span><?php  }   ?></a></small></td>
                                                                    <td><small><?php echo  $row['cateory']; ?></small></td>
                                                                    <td><small><?php echo  $row['mainUnit']; ?></small></td>
                                                                    <td><small><?php echo  $row["currentStatus"]; ?></small></td>
                                                                    <?php
                                                                        $index = $rowIndex["indexRisk"];
                                                                        $sqlActionOwnerEMP = "SELECT empNo FROM divactionowners WHERE indexRisk = '$index'";
                                                                        $resultActionOwnerEMP = mysqli_query($conn, $sqlActionOwnerEMP);
                                                                        $actionOwners = '';
                                                                        $count = 1;
                                                                        while($ActionOwnerEMP = mysqli_fetch_array($resultActionOwnerEMP)){
                                                                            $actionOwnerEmp = $ActionOwnerEMP['empNo'];
                                                                            $sqlFullName = "SELECT fullName FROM user_details WHERE empNo = '$actionOwnerEmp'";
                                                                            $resultFullName = mysqli_query($conn, $sqlFullName);
                                                                            $arrayFullName = mysqli_fetch_array($resultFullName);
                                                                            $fullName = $arrayFullName['fullName'];
                                                                            if($count == 1){
                                                                                $actionOwners .= ''.$fullName.'';
                                                                            }else{
                                                                                $actionOwners .= '<br>'.$fullName.'';
                                                                            }
                                                                            $count++;
                                                                        }
                                                                    ?>
                                                                    <td><small><?php echo  $actionOwners; ?></small></td>
                                                                    <td>
                                                                        <small>
                                                                            <?php
                                                                                $empNo = $row["reporter"];
                                                                                $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
                                                                                $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                                                                                $fullName = mysqli_fetch_array($resultFullName);
                                                                                echo    $fullName['fullName'];
                                                                            ?>
                                                                        </small>
                                                                    </td>
                                                                    <td><small><?php echo  $row['reportedDate']; ?></small></td>
                                                                    <td><small><?php echo  $row["reportedTime"]; ?></small></td>
                                                                </tr>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th><small>Risk Index</small></th>
                                                                    <th><small>Category</small></th>
                                                                    <th><small>Main Unit</small></th>
                                                                    <th><small>Current Status</small></th>
                                                                    <th><small>Action Owners</small></th>
                                                                    <th><small>Reported By</small></th>
                                                                    <th><small>Date</small></th>
                                                                    <th><small>Time</small></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </small>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="row g-1 g-lg-2 mt-2">
                                    <div class="col">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-body" style="width: 100%;">
                                                    <h5 class="card-title">Me as Action Owner</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted"><small>Shown all risks which you as action owner. Please select the risk to view and update.</small></h6>
                                                    <br>
                                                    <small>
                                                        <table cellpadding="3" cellspacing="0" border="0" style="width: 67%; margin: 0 auto 2em auto;">
                                                            <tbody>
                                                                <tr id="filter_col1T3" data-column="0">
                                                                    <td>Risk Index</td>
                                                                    <td align="center"><input type="text" class="column_filterT3" id="col0_filterT3"></td>
                                                                </tr>
                                                                <tr id="filter_col2T3" data-column="1">
                                                                    <td>Category</td>
                                                                    <td align="center"><input type="text" class="column_filterT3" id="col1_filterT3"></td>
                                                                </tr>
                                                                <tr id="filter_col4T3" data-column="2">
                                                                    <td>Main Unit</td>
                                                                    <td align="center"><input type="text" class="column_filterT3" id="col2_filterT3"></td>
                                                                </tr>
                                                                <tr id="filter_col5T3" data-column="3">
                                                                    <td>Current Status</td>
                                                                    <td align="center"><input type="text" class="column_filterT3" id="col3_filterT3"></td>
                                                                </tr>
                                                                <tr id="filter_col6T3" data-column="4">
                                                                    <td>Reporter</td>
                                                                    <td align="center"><input type="text" class="column_filterT3" id="col4_filterT3"></td>
                                                                </tr>
                                                                <tr id="filter_col7T3" data-column="5">
                                                                    <td>Action Owner</td>
                                                                    <td align="center"><input type="text" class="column_filterT3" id="col5_filterT3"></td>
                                                                </tr>
                                                                <tr id="filter_col8T3" data-column="6">
                                                                    <td>Date</td>
                                                                    <td align="center"><input type="text" class="column_filterT3" id="col6_filterT3"></td>
                                                                </tr>
                                                                <tr id="filter_col8" data-column="8" class="form-check form-switch d-flex justify-content-between align-items-center">
                                                                    <td>Key Risks</td>
                                                                    <td align="center"><input type="checkbox" onchange="remmoveErrorRiskUnit3(this)" value="KR" class="form-check-input form-switch" id="col8_filter"></td>
                                                                </tr>
                                                                <tr id="filter_col9" data-column="9" class="form-check form-switch d-flex justify-content-between align-items-center">
                                                                    <td>Closed Risks</td>
                                                                    <td align="center"><input type="checkbox" onchange="remmoveErrorRiskUnit3(this)" value="Closed" class="form-check-input form-switch" id="col9_filter"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                            
                                                        <table id="actionOwnerTable" style="width:100%;" class="table table-sm table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th><small>Risk Index</small></th>
                                                                    <th><small>Category</small></th>
                                                                    <th><small>Main Unit</small></th>
                                                                    <th><small>Current Status</small></th>
                                                                    <th><small>Action Owners</small></th>
                                                                    <th><small>Reported By</small></th>
                                                                    <th><small>Date</small></th>
                                                                    <th><small>Time</small></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                                $querySelIndex = "SELECT indexRisk FROM divactionowners WHERE empNo = '$empNoUser'";
                                                                $resultSelIndex = mysqli_query($conn, $querySelIndex);
                                                                if(mysqli_num_rows($resultSelIndex) > 0){
                                                                    while($rowIndex = mysqli_fetch_array($resultSelIndex)){
                                                                        $index = $rowIndex['indexRisk'];
                                                                        $query = "SELECT indexRisk, cateory, mainUnit, currentStatus, reporter, reportedDate, keyRiskTag, closeStatus, reportedTime FROM divrisk WHERE indexRisk = '$index'";
                                                                        $result = mysqli_query($conn, $query);
                                                                        $row = mysqli_fetch_array($result);
                                                            ?>
                                                                <tr>
                                                                    <td><small><a href="View-Risk.php?id=<?php  echo    $row['indexRisk']; ?>"><?php echo  $row["indexRisk"]; if($row['keyRiskTag'] == 1){ ?><span class="text-danger"> KR</span><?php  } if($row['closeStatus'] == 1){ ?><span class="text-danger"> Closed</span><?php  }   ?></a></small></td>
                                                                    <td><small><?php echo  $row['cateory']; ?></small></td>
                                                                    <td><small><?php echo  $row['mainUnit']; ?></small></td>
                                                                    <td><small><?php echo  $row["currentStatus"]; ?></small></td>
                                                                    <?php
                                                                        $index = $rowIndex["indexRisk"];
                                                                        $sqlActionOwnerEMP = "SELECT empNo FROM divactionowners WHERE indexRisk = '$index'";
                                                                        $resultActionOwnerEMP = mysqli_query($conn, $sqlActionOwnerEMP);
                                                                        $actionOwners = '';
                                                                        $count = 1;
                                                                        while($ActionOwnerEMP = mysqli_fetch_array($resultActionOwnerEMP)){
                                                                            $actionOwnerEmp = $ActionOwnerEMP['empNo'];
                                                                            $sqlFullName = "SELECT fullName FROM user_details WHERE empNo = '$actionOwnerEmp'";
                                                                            $resultFullName = mysqli_query($conn, $sqlFullName);
                                                                            $arrayFullName = mysqli_fetch_array($resultFullName);
                                                                            $fullName = $arrayFullName['fullName'];
                                                                            if($count == 1){
                                                                                $actionOwners .= ''.$fullName.'';
                                                                            }else{
                                                                                $actionOwners .= '<br>'.$fullName.'';
                                                                            }
                                                                            $count++;
                                                                        }
                                                                    ?>
                                                                    <td><small><?php echo  $actionOwners; ?></small></td>
                                                                    <td>
                                                                        <small>
                                                                            <?php
                                                                                $empNo = $row["reporter"];
                                                                                $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
                                                                                $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                                                                                $fullName = mysqli_fetch_array($resultFullName);
                                                                                echo    $fullName['fullName'];
                                                                            ?>
                                                                        </small>
                                                                    </td>
                                                                    <td><small><?php echo  $row['reportedDate']; ?></small></td>
                                                                    <td><small><?php echo  $row["reportedTime"]; ?></small></td>
                                                                </tr>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th><small>Risk Index</small></th>
                                                                    <th><small>Category</small></th>
                                                                    <th><small>Main Unit</small></th>
                                                                    <th><small>Current Status</small></th>
                                                                    <th><small>Action Owners</small></th>
                                                                    <th><small>Reported By</small></th>
                                                                    <th><small>Date</small></th>
                                                                    <th><small>Time</small></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </small>
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

            function filterGlobal () {
                $('#programsHistory').DataTable().search(
                    $('#global_filter').val(),
                    $('#global_regex').prop('checked'),
                    $('#global_smart').prop('checked')
                ).draw();
            }
            function filterColumn ( i ) {
                $('#programsHistory').DataTable().column( i ).search(
                    $('#col'+i+'_filter').val(),
                    $('#col'+i+'_regex').prop('checked'),
                    $('#col'+i+'_smart').prop('checked')
                ).draw();
            }
            $(document).ready(function() {
                $('#programsHistory').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [,
                    ],
                    "scrollY":        "500px",
                    "scrollX":        "100%",
                    "scrollCollapse": true,
                    "paging":         true,
                    
                } );
                $('input.global_filter').on( 'keyup click', function () {
                    filterGlobal();
                } );
                $('input.column_filter').on( 'keyup click', function () {
                    filterColumn( $(this).parents('tr').attr('data-column') );
                } );
            } );

            function remmoveErrorRiskUnit(RU){
                
                var i = $(RU).parents('tr').attr('data-column');
                if(RU.checked){
                    $('#programsHistory').DataTable().column( 0 ).search(
                        $('#col'+i+'_filter').val(),
                        $('#col'+i+'_regex').prop('checked'),
                        $('#col'+i+'_smart').prop('checked')
                    ).draw();
                }else{
                    $('#programsHistory').DataTable().column( 0 ).search(
                        "",
                        $('#col'+i+'_regex').prop('checked'),
                        $('#col'+i+'_smart').prop('checked')
                    ).draw();
                }
            }

            //second dataTable

            function filterGlobalT2 () {
                $('#riskOwnerTable').DataTable().search(
                    $('#global_filterT2').val(),
                    $('#global_regex').prop('checked'),
                    $('#global_smart').prop('checked')
                ).draw();
            }
            function filterColumnT2 ( i ) {
                $('#riskOwnerTable').DataTable().column( i ).search(
                    $('#col'+i+'_filterT2').val(),
                    $('#col'+i+'_regex').prop('checked'),
                    $('#col'+i+'_smart').prop('checked')
                ).draw();
            }
            $(document).ready(function() {
                $('#riskOwnerTable').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [,
                    ],
                    "scrollY":        "500px",
                    "scrollX":        "100%",
                    "scrollCollapse": true,
                    "paging":         true,
                    
                } );
                $('input.global_filterT2').on( 'keyup click', function () {
                    filterGlobalT2();
                } );
                $('input.column_filterT2').on( 'keyup click', function () {
                    filterColumnT2( $(this).parents('tr').attr('data-column') );
                } );
            } );

            function remmoveErrorRiskUnit2(RU){
                
                var i = $(RU).parents('tr').attr('data-column');
                if(RU.checked){
                    $('#riskOwnerTable').DataTable().column( 0 ).search(
                        $('#col'+i+'_filter').val(),
                        $('#col'+i+'_regex').prop('checked'),
                        $('#col'+i+'_smart').prop('checked')
                    ).draw();
                }else{
                    $('#riskOwnerTable').DataTable().column( 0 ).search(
                        "",
                        $('#col'+i+'_regex').prop('checked'),
                        $('#col'+i+'_smart').prop('checked')
                    ).draw();
                }
            }

            //third dataTable

            function filterGlobalT3 () {
                $('#actionOwnerTable').DataTable().search(
                    $('#global_filterT3').val(),
                    $('#global_regex').prop('checked'),
                    $('#global_smart').prop('checked')
                ).draw();
            }
            function filterColumnT3 ( i ) {
                $('#actionOwnerTable').DataTable().column( i ).search(
                    $('#col'+i+'_filterT3').val(),
                    $('#col'+i+'_regex').prop('checked'),
                    $('#col'+i+'_smart').prop('checked')
                ).draw();
            }
            $(document).ready(function() {
                $('#actionOwnerTable').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [,
                    ],
                    "scrollY":        "500px",
                    "scrollX":        "100%",
                    "scrollCollapse": true,
                    "paging":         true,
                    
                } );
                $('input.global_filterT3').on( 'keyup click', function () {
                    filterGlobalT3();
                } );
                $('input.column_filterT3').on( 'keyup click', function () {
                    filterColumnT3( $(this).parents('tr').attr('data-column') );
                } );
            } );

            function remmoveErrorRiskUnit3(RU){
                
                var i = $(RU).parents('tr').attr('data-column');
                if(RU.checked){
                    $('#actionOwnerTable').DataTable().column( 0 ).search(
                        $('#col'+i+'_filter').val(),
                        $('#col'+i+'_regex').prop('checked'),
                        $('#col'+i+'_smart').prop('checked')
                    ).draw();
                }else{
                    $('#actionOwnerTable').DataTable().column( 0 ).search(
                        "",
                        $('#col'+i+'_regex').prop('checked'),
                        $('#col'+i+'_smart').prop('checked')
                    ).draw();
                }
            }

        </script>

        <script src="../../bootstrap-5.0.0/js/popper.js"></script>
        <script src="../../bootstrap-5.0.0/js/bootstrap.js"></script>

        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    </body>
</html>