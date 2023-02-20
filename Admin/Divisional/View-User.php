<?php

    $userEmp = $_GET['id'];

    include("../database.php");

    $validate = "SELECT COUNT(*) AS tot FROM user_details WHERE empNo = '$userEmp'";
    $validateResult = mysqli_query($conn,$validate) or die(mysqli_error($conn));
    $result = mysqli_fetch_array($validateResult);
    $count = $result['tot'];

    if($count != 1){
        echo '<script type="text/javascript">alert("Oops..! Something went wrong...");</script>';
        echo "<script>location.href='Home.php'</script>";
    }

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
        <title>View User - Risk Register Management System</title>
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
                            mb-4 bottom-border">Portal - Divisional</a>
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
                                    text-uppercase mb-0">View User</h4>
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

        <?php
            $sqlEmpUserDetails = "SELECT * FROM user_details WHERE empNo = '$userEmp'";
            $resultEmpUserDetails = mysqli_query($conn,$sqlEmpUserDetails) or die(mysqli_error($conn));
            $empUserDetails = mysqli_fetch_array($resultEmpUserDetails);
        ?>

        <!-- Modal Full Name -->
        <div class="modal fade" id="full-name" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Full Name</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>First Name</small></small></label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="firstName" rows="3" onclick="enableSaveFullName();" onkeyup="enableSaveFullName()" value="<?php    echo    $empUserDetails['fName'];    ?>"/>
                            </div>
                        </div>
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Last Name</small></small></label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="lastName" rows="3" onclick="enableSaveFullName();" onkeyup="enableSaveFullName()" value="<?php    echo    $empUserDetails['lName'];    ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveFullName" name="saveFullName" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Full Name -->

        <!-- Modal Role -->
        <div class="modal fade" id="role" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit User Role</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <select name="userRole" id="userRole" class="form-control form-select-sm form-select" onchange="enableSaveRole()" aria-label=".form-select-sm example" style="width: 100%;">
                                <option selected class="text-muted">Select Role</option>
                                <option <?php   if($empUserDetails['role'] == "User"){ echo    "selected";  }  ?>>User</option>
                                <option <?php   if($empUserDetails['role'] == "Admin"){ echo    "selected";  }  ?>>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRole" name="saveRole" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Role -->

        <!-- Modal Division -->
        <div class="modal fade" id="division" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Division</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <div class="col">
                                <select name="userDivision" id="userDivision" class="form-control form-select-sm form-select" onchange="enableSaveDivision()" aria-label=".form-select-sm example" style="width: 100%;">
                                    <option selected class="text-muted">Select Unit</option>
                                    <option <?php   if($empUserDetails['department'] == "Access Planning"){ echo    "selected";  }  ?>>Access Planning</option>
                                    <option <?php   if($empUserDetails['department'] == "Broadband Planning"){ echo    "selected";  }  ?>>Broadband Planning</option>
                                    <option <?php   if($empUserDetails['department'] == "CFSS"){ echo    "selected";  }  ?>>CFSS</option>
                                    <option <?php   if($empUserDetails['department'] == "Core Network Planning"){ echo    "selected";  }  ?>>Core Network Planning</option>
                                    <option <?php   if($empUserDetails['department'] == "Data Center & Power Systems"){ echo    "selected";  }  ?>>Data Center & Power Systems</option>
                                    <option <?php   if($empUserDetails['department'] == "DE-TAC"){ echo    "selected";  }  ?>>DE-TAC</option>
                                    <option <?php   if($empUserDetails['department'] == "DNS"){ echo    "selected";  }  ?>>DNS</option>
                                    <option <?php   if($empUserDetails['department'] == "DTV"){ echo    "selected";  }  ?>>DTV</option>
                                    <option <?php   if($empUserDetails['department'] == "GTD"){ echo    "selected";  }  ?>>GTD</option>
                                    <option <?php   if($empUserDetails['department'] == "Network Strategy"){ echo    "selected";  }  ?>>Network Strategy</option>
                                    <option <?php   if($empUserDetails['department'] == "NOSA - ANO"){ echo    "selected";  }  ?>>NOSA - ANO</option>
                                    <option <?php   if($empUserDetails['department'] == "NOSA - Core Network"){ echo    "selected";  }  ?>>NOSA - Core Network</option>
                                    <option <?php   if($empUserDetails['department'] == "NOSA - CRC"){ echo    "selected";  }  ?>>NOSA - CRC</option>
                                    <option <?php   if($empUserDetails['department'] == "NOSA - Enterprise Service Support"){ echo    "selected";  }  ?>>NOSA - Enterprise Service Support</option>
                                    <option <?php   if($empUserDetails['department'] == "NOSA - Enterprise Service Support (IDC)"){ echo    "selected";  }  ?>>NOSA - Enterprise Service Support (IDC)</option>
                                    <option <?php   if($empUserDetails['department'] == "NOSA - Enterprise Service Support (SD)"){ echo    "selected";  }  ?>>NOSA - Enterprise Service Support (SD)</option>
                                    <option <?php   if($empUserDetails['department'] == "NOSA - NSQ"){ echo    "selected";  }  ?>>NOSA - NSQ</option>
                                    <option <?php   if($empUserDetails['department'] == "NOSA - PS & International"){ echo    "selected";  }  ?>>NOSA - PS & International</option>
                                    <option <?php   if($empUserDetails['department'] == "NOSA - TNO"){ echo    "selected";  }  ?>>NOSA - TNO</option>
                                    <option <?php   if($empUserDetails['department'] == "NOSA - VAS"){ echo    "selected";  }  ?>>NOSA - VAS</option>
                                    <option <?php   if($empUserDetails['department'] == "Product Development"){ echo    "selected";  }  ?>>Product Development</option>
                                    <option <?php   if($empUserDetails['department'] == "Project Planning"){ echo    "selected";  }  ?>>Project Planning</option>
                                    <option <?php   if($empUserDetails['department'] == "TNP"){ echo    "selected";  }  ?>>TNP</option>
                                    <option <?php   if($empUserDetails['department'] == "TSC"){ echo    "selected";  }  ?>>TSC</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveDivision" name="saveDivision" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Division -->

        <!-- Modal Unit -->
        <div class="modal fade" id="unit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Unit</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <div class="col">
                                <input type="text" class="form-control form-control-sm" id="userUnit" onclick="enableSaveUnit();" onkeyup="enableSaveUnit()" value="<?php    echo    $empUserDetails['unit'];    ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveUnit" name="saveUnit" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Unit -->

        <!-- Modal Category -->
        <div class="modal fade" id="category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit User Category</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <select name="userCategory" id="userCategory" class="form-control form-select-sm form-select" onchange="enableSaveCategory()" aria-label=".form-select-sm example" style="width: 100%;">
                                <option selected class="text-muted">Select Category</option>
                                <option <?php   if($empUserDetails['category'] == "Head"){ echo    "selected";  }  ?>>Head</option>
                                <option <?php   if($empUserDetails['category'] == "Body"){ echo    "selected";  }  ?>>Member</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveCategory" name="saveCategory" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Category -->

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
                                <h4 align="center">
                                    <small>
                                    <?php
                                        echo    $empUserDetails['fullName'];
                                    ?>
                                    </small>
                                </h4>
                                <br>
                                <div class="row row-cols-1 g-1 g-lg-2 mb-2">
                                    <div class="col">
                                        <div class="p-0">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-header">
                                                    Details
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-control p-3">
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label><small><small>Full Name</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $empUserDetails['fullName'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#full-name" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;">Edit</button>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>EMP ID</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $empUserDetails['empNo'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Email</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $empUserDetails['email'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                                <!-- <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#email" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;">Edit</button> -->
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Role</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $empUserDetails['role'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#role" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;">Edit</button>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Division</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $empUserDetails['department'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#division" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;">Edit</button>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Unit</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $empUserDetails['unit'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#unit" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;">Edit</button>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Category</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php if($empUserDetails['category'] == 'Head'){   echo    "Head"; }else{  echo    "Member";   }   ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#category" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;">Edit</button>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Status</small></small></label>
                                                            </div>
                                                            <div class="col-4">
                                                                <small><small>
                                                                    <?php
                                                                        if($empUserDetails['activeStatus'] == '0'){
                                                                    ?>
                                                                        <span class="text-success">Active</span>
                                                                    <?php
                                                                        }else{
                                                                    ?>
                                                                        <span class="text-danger">Inactive</span>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </small></small>
                                                            </div>
                                                            <div class="col-3">
                                                                <button class="btn btn-sm btn-success" type="button" id="Active" name="Active" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: none;">Active</button>
                                                                <button class="btn btn-sm btn-danger" type="button" id="Inactive" name="Inactive" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: none;">Inactive</button>
                                                            </div>
                                                            <div class="col-1">
                                                                <button class="btn btn-sm btn-info" type="button" id="editStatus" name="editStatus" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline-block;">Edit</button>
                                                                <button class="btn btn-sm btn-danger" type="button" id="cancelStatus" name="cancelStatus" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: none;">Cancel</button>
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
            </div>
        </section>
        <!-- end of Section -->

        <script type="text/javascript">
            
            function enableSaveFullName(){
                if((document.getElementById('firstName').value != "<?php    echo    $empUserDetails['fName'];    ?>") & (document.getElementById('firstName').value != "") | (document.getElementById('lastName').value != "<?php    echo    $empUserDetails['lName'];    ?>") & (document.getElementById('lastName').value != "")){
                    document.getElementById('saveFullName').disabled = false;
                }else{
                    document.getElementById('saveFullName').disabled = true;
                }
            }

            $('#saveFullName').click(function(){
                var firstName = document.getElementById('firstName').value;
                var lastName = document.getElementById('lastName').value;
                var empNo = "<?php   echo    $empUserDetails['empNo'];   ?>";
                $.ajax({
                    url: "Update-User-Full-Name.php",
                    method: "POST",
                    data: {firstName:firstName,lastName:lastName,empNo:empNo},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Updated");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                        }
                    }
                })
            });

            function enableSaveRole(){
                if((document.getElementById('userRole').value != "<?php    echo    $empUserDetails['role'];    ?>") & (document.getElementById('userRole').value != "Select Role")){
                    document.getElementById('saveRole').disabled = false;
                }else{
                    document.getElementById('saveRole').disabled = true;
                }
            }

            $('#saveRole').click(function(){
                var userRole = document.getElementById('userRole').value;
                var empNo = "<?php   echo    $empUserDetails['empNo'];   ?>";
                $.ajax({
                    url: "Update-User-Role.php",
                    method: "POST",
                    data: {userRole:userRole,empNo:empNo},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Updated");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                        }
                    }
                })
            });

            function enableSaveDivision(){
                if((document.getElementById('userDivision').value != "<?php    echo    $empUserDetails['department'];    ?>")){
                    document.getElementById('saveDivision').disabled = false;
                }else{
                    document.getElementById('saveDivision').disabled = true;
                }
            }

            $('#saveDivision').click(function(){
                var userDivision = document.getElementById('userDivision').value;
                var empNo = "<?php   echo    $empUserDetails['empNo'];   ?>";
                $.ajax({
                    url: "Update-User-Division.php",
                    method: "POST",
                    data: {userDivision:userDivision,empNo:empNo},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Updated");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                        }
                    }
                })
            });

            function enableSaveUnit(){
                if((document.getElementById('userUnit').value != "<?php    echo    $empUserDetails['unit'];    ?>")){
                    document.getElementById('saveUnit').disabled = false;
                }else{
                    document.getElementById('saveUnit').disabled = true;
                }
            }

            $('#saveUnit').click(function(){
                var userUnit = document.getElementById('userUnit').value;
                var empNo = "<?php   echo    $empUserDetails['empNo'];   ?>";
                $.ajax({
                    url: "Update-User-Unit.php",
                    method: "POST",
                    data: {userUnit:userUnit,empNo:empNo},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Updated");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                        }
                    }
                })
            });

            function enableSaveCategory(){
                if((document.getElementById('userCategory').value != "<?php    echo    $empUserDetails['category'];    ?>") & (document.getElementById('userCategory').value != "Select Category")){
                    document.getElementById('saveCategory').disabled = false;
                }else{
                    document.getElementById('saveCategory').disabled = true;
                }
            }

            $('#saveCategory').click(function(){
                var userCategory = document.getElementById('userCategory').value;
                var empNo = "<?php   echo    $empUserDetails['empNo'];   ?>";
                $.ajax({
                    url: "Update-User-Category.php",
                    method: "POST",
                    data: {userCategory:userCategory,empNo:empNo},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Updated");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                        }
                    }
                })
            });

            $('#editStatus').click(function(){
                document.getElementById("editStatus").style.display='none';
                document.getElementById("cancelStatus").style.display='inline-block';
                document.getElementById("Inactive").style.display='inline-block';
                document.getElementById("Active").style.display='inline-block';
            });

            $('#cancelStatus').click(function(){
                document.getElementById("editStatus").style.display='inline-block';
                document.getElementById("cancelStatus").style.display='none';
                document.getElementById("Inactive").style.display='none';
                document.getElementById("Active").style.display='none';
            });

            $('#Inactive').click(function(){
                var empNo = "<?php   echo    $empUserDetails['empNo'];   ?>";
                $.ajax({
                    url: "User-Inactive.php",
                    method: "POST",
                    data: {empNo:empNo},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Updated");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                        }
                    }
                })
            });

            $('#Active').click(function(){
                var empNo = "<?php   echo    $empUserDetails['empNo'];   ?>";
                $.ajax({
                    url: "User-Active.php",
                    method: "POST",
                    data: {empNo:empNo},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Updated");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
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