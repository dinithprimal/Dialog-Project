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
        <title>Home - Risk Register Management System</title>
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
                                fa-lg fa-fw mx-3"></i>Dashboard</a></li>

                                <li class="nav-item"><a href="Home.php"
                                class="nav-link text-white p-3 mb-2 
                                current"><i 
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
                                    text-uppercase mb-0">Home</h4>
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
                                <div class="row row-cols-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4 g-1 g-lg-2">
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="card" style="width: auto;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Risks</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted"><small>View all registered risks</small></h6>
                                                    <br>
                                                    <div class="d-grid gap-2">
                                                        <a href="Risks.php" class="btn btn-info btn-md" tabindex="-1" role="button">Goto Risks Page</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="card" style="width: auto;">
                                                <div class="card-body">
                                                    <h5 class="card-title">New Risks</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted"><small>Add new risks</small></h6>
                                                    <br>
                                                    <div class="d-grid gap-2">
                                                        <a href="New-Risks.php" class="btn btn-info btn-md" tabindex="-1" role="button">Add New Risks</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="card" style="width: auto;">
                                                <div class="card-body">
                                                    <h5 class="card-title">New Users</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted"><small>Add new users</small></h6>
                                                    <br>
                                                    <div class="d-grid gap-2">
                                                        <a href="Add-New-User.php" class="btn btn-info btn-md" tabindex="-1" role="button">Add New Users</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="card" style="width: auto;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Program Update Risks</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted"><small>Program Update registered risks</small></h6>
                                                    <br>
                                                    <div class="d-grid gap-2">
                                                        <a href="Programs.php" class="btn btn-info btn-md" tabindex="-1" role="button">Programs</a>
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
                                                    <h5 class="card-title">Recent Activities</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted"><small>Shown 20 activities that recently did</small></h6>
                                                    <br>
                                                    <div class="d-grid gap-2">
                                                        <div class="table-responsive d-flex" style="height: 360px; width:100%; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                            <table class="table table-sm table-striped table-hover" style="width:100%; min-width:1100px">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col"><small>#</small></th>
                                                                        <th scope="col"><small>Risk ID</small></th>
                                                                        <th scope="col"><small>Description</small></th>
                                                                        <th scope="col"><small>Done By</small></th>
                                                                        <th scope="col"><small>Date</small></th>
                                                                        <th scope="col"><small>Time</small></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        $queryActivity = "SELECT * FROM activity ORDER BY idActivity DESC LIMIT 20";
                                                                        $result_queryActivity = mysqli_query($conn,$queryActivity) or die(mysqli_error($conn));
                                                                        $count = 1;
                                                                        while($activity = mysqli_fetch_array($result_queryActivity)){
                                                                    ?>
                                                                    <tr>
                                                                        <td scope="row"><small><small><?php   echo    $count;  ?></small></small></td>
                                                                        <?php
                                                                            $queryRisk = "SELECT keyRiskTag, closeStatus FROM risk WHERE indexRisk = '".$activity['indexRisk']."'";
                                                                            $result_queryRisk = mysqli_query($conn,$queryRisk) or die(mysqli_error($conn));
                                                                            $risk = mysqli_fetch_array($result_queryRisk);
                                                                        ?>
                                                                        <td><small><small><a href="View-Risk.php?id=<?php  echo    $activity['indexRisk']; ?>"><?php   echo    $activity['indexRisk'];  if($risk['keyRiskTag'] == 1){ ?><span class="text-danger"> KR</span><?php  }   if($risk['closeStatus'] == 1){ ?><span class="text-danger"> Closed</span><?php  }   ?></a></small></small></td>
                                                                        <td><small><small><?php   echo    $activity['Des'];  ?></small></small></td>
                                                                        <td>
                                                                            <small><small>
                                                                                <?php
                                                                                    $empNo = $activity['empNo'];
                                                                                    $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
                                                                                    $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                                                                                    $fullName = mysqli_fetch_array($resultFullName);
                                                                                    echo    $fullName['fullName'];
                                                                                ?>
                                                                            </small></small>
                                                                        </td>
                                                                        <td><small><small><?php   echo    $activity['Date'];  ?></small></small></td>
                                                                        <td><small><small><?php   echo    $activity['Time'];  ?></small></small></td>
                                                                    </tr>
                                                                    <?php
                                                                            $count++;
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

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="../../bootstrap-5.0.0/js/popper.js"></script>
        <script src="../../bootstrap-5.0.0/js/bootstrap.js"></script>
    </body>
</html>