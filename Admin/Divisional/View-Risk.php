<?php

    $riskIndex = $_GET['id'];

    include("../database.php");

    $validate = "SELECT COUNT(*) AS tot FROM divtrindex WHERE indexRisk = '$riskIndex'";
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
        $queryUserDetails = "SELECT idUser, fullName, empNo, department, role FROM user_details WHERE username = '$username'";
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

        <script src="../../bootstrap-5.0.0/js/popper.js"></script>
        <title>View Risk - Risk Register Management System</title>
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
                                    text-uppercase mb-0">View Risk</h4>
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
            $riks_sql = "SELECT * FROM divrisk WHERE indexRisk = '$riskIndex'";
            $result_riks_sql = mysqli_query($conn,$riks_sql) or die(mysqli_error($conn));
            $risk_details = mysqli_fetch_array($result_riks_sql);

            $activeQuery = "SELECT status FROM divtrindex WHERE indexRisk = '$riskIndex'";
            $result_activeQuery = mysqli_query($conn,$activeQuery) or die(mysqli_error($conn));
            $activeStatusArray = mysqli_fetch_array($result_activeQuery);
            $activeStatus = $activeStatusArray['status'];
        ?>

        <!-- Modal -->
        <!-- Modal Logout -->
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
        <!-- end of Modal Logout -->

        <!-- Modal Add Risk Owners -->
        <div class="modal fade" id="risk-owners" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Add Risk Owners</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-1">
                            <div class="table-responsive d-flex" style="height: 153px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                <table class="table table-sm table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 60%;"><small><small>Name</small></small></th>
                                            <th scope="col" style="width: 30%;"><small><small>Employee ID</small></small></th>
                                            <th scope="col" style="width: 10%;"><small><small>Select</small></small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql_riskOwners = "SELECT fullName, empNo FROM user_details WHERE category = 'Head' AND empNo NOT IN (SELECT empNo FROM divriskowners WHERE indexRisk = '$riskIndex') ORDER BY fullName";
                                            $resul_riskOwners = mysqli_query($conn,$sql_riskOwners) or die(mysqli_error($conn));
                                            $count = mysqli_num_rows($resul_riskOwners);
                                            if($count>0){
                                                while($riskOwners = mysqli_fetch_array($resul_riskOwners)){
                                        ?>
                                        <tr>
                                            <td><small><small><?php    echo    $riskOwners['fullName'];  ?></small></small></td>
                                            <td><small><small><?php    echo    $riskOwners['empNo'];  ?></small></small></td>
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                                    <small><small><input type="checkbox" onclick="selectRiskOwners(this);" name="riskOwnerCheck" value="<?php  echo    $riskOwners['empNo'];   ?>" class="form-check-input form-switch"></small></small>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                                }
                                            }else{
                                        ?>
                                            <td colspan="3"  align="center"><small><small><span class="text-danger">Nothing to show</span></small></small></td>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="addRiskOwners" name="addRiskOwners" class="btn btn-sm btn-primary" disabled>Add</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Add Risk Owners -->

        <!-- Modal Add Action Owners -->
        <div class="modal fade" id="action-owners" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Add Action Owners</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-1">
                            <div class="table-responsive d-flex" style="height: 153px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                <table class="table table-sm table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 60%;"><small><small>Name</small></small></th>
                                            <th scope="col" style="width: 30%;"><small><small>Employee ID</small></small></th>
                                            <th scope="col" style="width: 10%;"><small><small>Select</small></small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql_actionOwners = "SELECT fullName, empNo FROM user_details WHERE empNo NOT IN (SELECT empNo FROM divactionowners WHERE indexRisk = '$riskIndex') ORDER BY fullName";
                                            $resul_actionOwners = mysqli_query($conn,$sql_actionOwners) or die(mysqli_error($conn));
                                            $count_actionOw = mysqli_num_rows($resul_actionOwners);
                                            if($count_actionOw>0){
                                                while($actionOwners = mysqli_fetch_array($resul_actionOwners)){
                                        ?>
                                        <tr>
                                            <td><small><small><?php    echo    $actionOwners['fullName'];  ?></small></small></td>
                                            <td><small><small><?php    echo    $actionOwners['empNo'];  ?></small></small></td>
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                                    <small><small><input type="checkbox" onclick="selectActionOwners(this);" name="actionOwnerCheck" value="<?php  echo    $actionOwners['empNo'];   ?>" class="form-check-input form-switch"></small></small>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                                }
                                            }else{
                                        ?>
                                            <td colspan="3"  align="center"><small><small><span class="text-danger">Nothing to show</span></small></small></td>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="addActionOwners" name="addActionOwners" class="btn btn-sm btn-primary" disabled>Add</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Add Action Owners -->

        <!-- Modal Business Impact -->
        <div class="modal fade" id="business-impact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit High Level Business Impact</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <textarea class="form-control form-control-sm" maxlength="1500" onkeypress="maxLengthCheck(this)" id="businessImpact" rows="3" onclick="enableSaveBusinessImpact();" onkeyup="enableSaveBusinessImpact()"><?php    echo    $risk_details['businessObj'];    ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveBusinessImpact" name="saveBusinessImpact" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Business Impact -->

        <!-- Modal Risk Description -->
        <div class="modal fade" id="risk-description" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Description</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <textarea class="form-control form-control-sm" maxlength="1500" onkeypress="maxLengthCheck(this)" id="riskDescription" rows="3" onclick="enableSaveRiskDescription();" onkeyup="enableSaveRiskDescription()"><?php    echo    $risk_details['description'];    ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskDescription" name="saveRiskDescription" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Description -->

        <!-- Modal Risk category -->
        <div class="modal fade" id="risk-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Category</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <select name="riskCategory" id="riskCategory" class="form-control form-select-sm form-select" onchange="enableSaveRiskCategory()" aria-label=".form-select-sm example" style="width: 100%;">
                                <option class="text-muted">Select Risk Category</option>
                                <option <?php   if($risk_details['cateory'] == "DR / BCM Risk"){ echo    "selected";  }  ?>>DR / BCM Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Economic & Political Risk"){ echo    "selected";  }  ?>>Economic & Political Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Environmental Risk"){ echo    "selected";  }  ?>>Environmental Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Financial Risk"){ echo    "selected";  }  ?>>Financial Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Information Security Risk"){ echo    "selected";  }  ?>>Information Security Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Market Risk"){ echo    "selected"; }  ?>>Market Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Operational Risk"){ echo    "selected";  }  ?>>Operational Risk</option>
                                <option <?php   if($risk_details['cateory'] == "People Risk"){ echo    "selected";  }  ?>>People Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Power Risk"){ echo    "selected";  }  ?>>Power Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Regulatory Risk"){ echo    "selected";  }  ?>>Regulatory Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Reputation Risk"){ echo    "selected";  }  ?>>Reputation Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Strategic Investment Risk"){ echo    "selected";  }  ?>>Strategic Investment Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Strategic Partnership Risk"){ echo    "selected";  }  ?>>Strategic Partnership Risk</option>
                                <option <?php   if($risk_details['cateory'] == "Technology Risk"){ echo    "selected";  }  ?>>Technology Risk</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskCategory" name="saveRiskCategory" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Category -->

        <!-- Modal Main Unit -->
        <div class="modal fade" id="main-unit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Main Unit</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <select name="mainUnit" id="mainUnit" class="form-control form-select-sm form-select" onchange="enableSaveMainUnit()" aria-label=".form-select-sm example" style="width: 100%;">
                                <option selected class="text-muted">Select Unit</option>
                                <option <?php   if($risk_details['mainUnit'] == "Access Planning"){ echo    "selected";  }  ?>>Access Planning</option>
                                <option <?php   if($risk_details['mainUnit'] == "Broadband Planning"){ echo    "selected";  }  ?>>Broadband Planning</option>
                                <option <?php   if($risk_details['mainUnit'] == "CFSS"){ echo    "selected";  }  ?>>CFSS</option>
                                <option <?php   if($risk_details['mainUnit'] == "Core Network Planning"){ echo    "selected";  }  ?>>Core Network Planning</option>
                                <option <?php   if($risk_details['mainUnit'] == "Data Center & Power Systems"){ echo    "selected";  }  ?>>Data Center & Power Systems</option>
                                <option <?php   if($risk_details['mainUnit'] == "DE-TAC"){ echo    "selected";  }  ?>>DE-TAC</option>
                                <option <?php   if($risk_details['mainUnit'] == "DNS"){ echo    "selected";  }  ?>>DNS</option>
                                <option <?php   if($risk_details['mainUnit'] == "DTV"){ echo    "selected";  }  ?>>DTV</option>
                                <option <?php   if($risk_details['mainUnit'] == "GTD"){ echo    "selected";  }  ?>>GTD</option>
                                <option <?php   if($risk_details['mainUnit'] == "Network Strategy"){ echo    "selected";  }  ?>>Network Strategy</option>
                                <option <?php   if($risk_details['mainUnit'] == "NOSA - ANO"){ echo    "selected";  }  ?>>NOSA - ANO</option>
                                <option <?php   if($risk_details['mainUnit'] == "NOSA - Core Network"){ echo    "selected";  }  ?>>NOSA - Core Network</option>
                                <option <?php   if($risk_details['mainUnit'] == "NOSA - CRC"){ echo    "selected";  }  ?>>NOSA - CRC</option>
                                <option <?php   if($risk_details['mainUnit'] == "NOSA - Enterprise Service Support"){ echo    "selected";  }  ?>>NOSA - Enterprise Service Support</option>
                                <option <?php   if($risk_details['mainUnit'] == "NOSA - Enterprise Service Support (IDC)"){ echo    "selected";  }  ?>>NOSA - Enterprise Service Support (IDC)</option>
                                <option <?php   if($risk_details['mainUnit'] == "NOSA - Enterprise Service Support (SD)"){ echo    "selected";  }  ?>>NOSA - Enterprise Service Support (SD)</option>
                                <option <?php   if($risk_details['mainUnit'] == "NOSA - NSQ"){ echo    "selected";  }  ?>>NOSA - NSQ</option>
                                <option <?php   if($risk_details['mainUnit'] == "NOSA - PS & International"){ echo    "selected";  }  ?>>NOSA - PS & International</option>
                                <option <?php   if($risk_details['mainUnit'] == "NOSA - TNO"){ echo    "selected";  }  ?>>NOSA - TNO</option>
                                <option <?php   if($risk_details['mainUnit'] == "NOSA - VAS"){ echo    "selected";  }  ?>>NOSA - VAS</option>
                                <option <?php   if($risk_details['mainUnit'] == "Product Development"){ echo    "selected";  }  ?>>Product Development</option>
                                <option <?php   if($risk_details['mainUnit'] == "Project Planning"){ echo    "selected";  }  ?>>Project Planning</option>
                                <option <?php   if($risk_details['mainUnit'] == "TNP"){ echo    "selected";  }  ?>>TNP</option>
                                <option <?php   if($risk_details['mainUnit'] == "TSC"){ echo    "selected";  }  ?>>TSC</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveMainUnit" name="saveMainUnit" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Main Unit -->

        <!-- Modal KRI -->
        <div class="modal fade" id="KRI" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit KRI</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <textarea type="text" maxlength="200" onkeypress="maxLengthCheck(this)" class="form-control form-control-sm" id="riskKRI" rows="3" onclick="enableSaveRiskKRI();" onkeyup="enableSaveRiskKRI()" ><?php    echo    $risk_details['kri'];    ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskKRI" name="saveRiskKRI" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of KRI -->

        <!-- Modal BAU -->
        <div class="modal fade" id="BAU" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit BAU</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <textarea type="text" maxlength="200" onkeypress="maxLengthCheck(this)" class="form-control form-control-sm" id="riskBAU" rows="3" onclick="enableSaveRiskBAU();" onkeyup="enableSaveRiskBAU()" ><?php    echo    $risk_details['bau'];    ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskBAU" name="saveRiskBAU" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of BAU -->

        <!-- Modal Risk Alert -->
        <div class="modal fade" id="Risk-Alert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Alert</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <textarea type="text" maxlength="200" onkeypress="maxLengthCheck(this)" class="form-control form-control-sm" id="riskAlert" rows="3" onclick="enableSaveRiskAlert();" onkeyup="enableSaveRiskAlert()" ><?php    echo    $risk_details['riskAlert'];    ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskAlert" name="saveRiskAlert" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Alert -->

        <!-- Modal Risk Risk -->
        <div class="modal fade" id="Risk-Risk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <textarea type="text" maxlength="200" onkeypress="maxLengthCheck(this)" class="form-control form-control-sm" id="riskRisk" rows="3" onclick="enableSaveRiskRisk();" onkeyup="enableSaveRiskRisk()" ><?php    echo    $risk_details['risk'];    ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskRisk" name="saveRiskRisk" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Risk -->

        <!-- Modal Risk Cause -->
        <div class="modal fade" id="Risk-Cause" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Cause</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <textarea type="text" maxlength="500" onkeypress="maxLengthCheck(this)" class="form-control form-control-sm" id="riskCause" rows="3" onclick="enableSaveRiskCause();" onkeyup="enableSaveRiskCause()" ><?php    echo    $risk_details['cause'];    ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskCause" name="saveRiskCause" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Cause -->

        <!-- Modal Risk Impact -->
        <div class="modal fade" id="Risk-Impact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Impact</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <textarea type="text" maxlength="300" onkeypress="maxLengthCheck(this)" class="form-control form-control-sm" id="riskImpact" rows="3" onclick="enableSaveRiskImpact();" onkeyup="enableSaveRiskImpact()" ><?php    echo    $risk_details['impact'];    ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskImpact" name="saveRiskImpact" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Impact -->

        <!-- Modal Risk Likelyhood Level -->
        <div class="modal fade" id="Risk-Likelyhood-Level" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Likelyhood Level</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Likelihood Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <select name="likelyhoodLevel" id="likelyhoodLevel" class="form-control form-select form-select-sm" onchange="enableSaveRiskLikelyhoodLevel()" aria-label="Default select example" style="width: 100%;">
                                    <option selected class="text-muted">Select Likelyhood Level</option>
                                    <option <?php   if($risk_details['likelyhoodLevel'] == "Almost Certain"){ echo    "selected";  }  ?>>Almost Certain</option>
                                    <option <?php   if($risk_details['likelyhoodLevel'] == "Likely"){ echo    "selected";  }  ?>>Likely</option>
                                    <option <?php   if($risk_details['likelyhoodLevel'] == "Moderate"){ echo    "selected";  }  ?>>Moderate</option>
                                    <option <?php   if($risk_details['likelyhoodLevel'] == "Unlikely"){ echo    "selected";  }  ?>>Unlikely</option>
                                    <option <?php   if($risk_details['likelyhoodLevel'] == "Rare"){ echo    "selected";  }  ?>>Rare</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Impact Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <label><small><small><span id="impactLevel"><?php   echo    $risk_details['impactLevel']; ?></span></small></small></label>
                            </div>
                        </div>
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Risk Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <label><small><small><span id="riskLevel"><?php   echo    $risk_details['riskLevel']; ?></span></small></small></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskLikelyhoodLevel" name="saveRiskLikelyhoodLevel" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Likelyhood Level -->

        <!-- Modal Risk Impact Level -->
        <div class="modal fade" id="Risk-Impact-Level" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Impact Level</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Likelihood Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <label><small><small><span id="impactLikelyhoodLevel"><?php   echo    $risk_details['likelyhoodLevel']; ?></span></small></small></label>
                            </div>
                        </div>
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Impact Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <select name="impactImpactLevel" id="impactImpactLevel" class="form-control form-select form-select-sm" onchange="enableSaveRiskImpactLevel()" aria-label="Default select example" style="width: 100%;">
                                    <option selected class="text-muted">Select Impact Level</option>
                                    <option <?php   if($risk_details['impactLevel'] == "Insignificant"){ echo    "selected";  }  ?>>Insignificant</option>
                                    <option <?php   if($risk_details['impactLevel'] == "Minor"){ echo    "selected";  }  ?>>Minor</option>
                                    <option <?php   if($risk_details['impactLevel'] == "Moderate"){ echo    "selected";  }  ?>>Moderate</option>
                                    <option <?php   if($risk_details['impactLevel'] == "Major"){ echo    "selected";  }  ?>>Major</option>
                                    <option <?php   if($risk_details['impactLevel'] == "Catastropic"){ echo    "selected";  }  ?>>Catastropic</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Risk Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <label><small><small><span id="impactRiskLevel"><?php   echo    $risk_details['riskLevel']; ?></span></small></small></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskImpactLevel" name="saveRiskImpactLevel" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Impact Level -->

        <!-- Modal Risk Existing Control -->
        <div class="modal fade" id="Risk-Existing-Control" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Existing Control</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <textarea type="text" maxlength="300" onkeypress="maxLengthCheck(this)" class="form-control form-control-sm" id="riskExistingControl" rows="3" onclick="enableSaveRiskExistingControl();" onkeyup="enableSaveRiskExistingControl()" ><?php    echo    $risk_details['existingControl'];    ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskExistingControl" name="saveRiskExistingControl" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Existing Control -->

        <!-- Modal Risk Control Effectiveness -->
        <div class="modal fade" id="Control-Effectiveness" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Control Effectiveness</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <select name="controlEffectiveness" id="controlEffectiveness" class="form-control form-select-sm form-select" onchange="enableSaveControlEffectiveness()" aria-label=".form-select-sm example" style="width: 100%;">
                                <option selected class="text-muted">Select Effectiveness</option>
                                <option <?php   if($risk_details['ContrEffectv'] == "Ineffective (<25%)"){ echo    "selected";  }  ?>>Ineffective (<25%)</option>
                                <option <?php   if($risk_details['ContrEffectv'] == "Fairly Effective (25% - 50%)"){ echo    "selected";  }  ?>>Fairly Effective (25% - 50%)</option>
                                <option <?php   if($risk_details['ContrEffectv'] == "Mostly Effective (50% - 75%)"){ echo    "selected";  }  ?>>Mostly Effective (50% - 75%)</option>
                                <option <?php   if($risk_details['ContrEffectv'] == "Effective (>75%)"){ echo    "selected";  }  ?>>Effective (>75%)</option>
                                <option <?php   if($risk_details['ContrEffectv'] == "N/A"){ echo    "selected";  }  ?>>N/A</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskControlEffectiveness" name="saveRiskControlEffectiveness" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Control Effectiveness -->

        <!-- Modal Risk Evaluation Likelyhood Level -->
        <div class="modal fade" id="Risk-Evaluation-Likelyhood-Level" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Evaluation Likelyhood Level</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Likelihood Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <select name="evaluationLikelyhoodLevel" id="evaluationLikelyhoodLevel" class="form-control form-select form-select-sm" onchange="enableSaveRiskEvaluationLikelyhoodLevel()" aria-label="Default select example" style="width: 100%;">
                                    <option selected class="text-muted">Select Likelyhood Level</option>
                                    <option <?php   if($risk_details['reslikelyhoodLevel'] == "Almost Certain"){ echo    "selected";  }  ?>>Almost Certain</option>
                                    <option <?php   if($risk_details['reslikelyhoodLevel'] == "Likely"){ echo    "selected";  }  ?>>Likely</option>
                                    <option <?php   if($risk_details['reslikelyhoodLevel'] == "Moderate"){ echo    "selected";  }  ?>>Moderate</option>
                                    <option <?php   if($risk_details['reslikelyhoodLevel'] == "Unlikely"){ echo    "selected";  }  ?>>Unlikely</option>
                                    <option <?php   if($risk_details['reslikelyhoodLevel'] == "Rare"){ echo    "selected";  }  ?>>Rare</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Impact Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <label><small><small><span id="evaluationImpactLevel"><?php   echo    $risk_details['resimpactLevel']; ?></span></small></small></label>
                            </div>
                        </div>
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Risk Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <label><small><small><span id="evaluationRiskLevel"><?php   echo    $risk_details['resriskLevel']; ?></span></small></small></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskEvaluationLikelyhoodLevel" name="saveRiskEvaluationLikelyhoodLevel" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Evaluation Likelyhood Level -->

        <!-- Modal Risk Evaluation Impact Level -->
        <div class="modal fade" id="Risk-Evaluation-Impact-Level" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Evaluation Impact Level</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Likelihood Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <label><small><small><span id="evaluationImpactLikelyhoodLevel"><?php   echo    $risk_details['reslikelyhoodLevel']; ?></span></small></small></label>
                            </div>
                        </div>
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Impact Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <select name="impactImpactLevel" id="evaluationImpactImpactLevel" class="form-control form-select form-select-sm" onchange="enableSaveRiskEvaluationImpactLevel()" aria-label="Default select example" style="width: 100%;">
                                    <option selected class="text-muted">Select Impact Level</option>
                                    <option <?php   if($risk_details['resimpactLevel'] == "Insignificant"){ echo    "selected";  }  ?>>Insignificant</option>
                                    <option <?php   if($risk_details['resimpactLevel'] == "Minor"){ echo    "selected";  }  ?>>Minor</option>
                                    <option <?php   if($risk_details['resimpactLevel'] == "Moderate"){ echo    "selected";  }  ?>>Moderate</option>
                                    <option <?php   if($risk_details['resimpactLevel'] == "Major"){ echo    "selected";  }  ?>>Major</option>
                                    <option <?php   if($risk_details['resimpactLevel'] == "Catastropic"){ echo    "selected";  }  ?>>Catastropic</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2 px-2">
                            <div class="col-4">
                                <label><small><small>Risk Level</small></small></label>
                            </div>
                            <div class="col-8">
                                <label><small><small><span id="evaluationImpactRiskLevel"><?php   echo    $risk_details['resriskLevel']; ?></span></small></small></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskEvaluationImpactLevel" name="saveRiskEvaluationImpactLevel" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Evaluation Impact Level -->

        <!-- Modal Risk Response -->
        <div class="modal fade" id="Risk-Response" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Response</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <select name="riskResponse" id="riskResponse" class="form-control form-select-sm form-select" onchange="enableSaveRiskResponse()" aria-label=".form-select-sm example" style="width: 100%;">
                                <option selected class="text-muted">Select Risk Response</option>
                                <option <?php   if($risk_details['riskResponse'] == "Avoid"){ echo    "selected";  }  ?>>Avoid</option>
                                <option <?php   if($risk_details['riskResponse'] == "Change"){ echo    "selected";  }  ?>>Change</option>
                                <option <?php   if($risk_details['riskResponse'] == "Share"){ echo    "selected";  }  ?>>Share</option>
                                <option <?php   if($risk_details['riskResponse'] == "Retain"){ echo    "selected";  }  ?>>Retain</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskResponse" name="saveRiskResponse" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Response -->

        <!-- Modal Add Risk Activity -->
        <div class="modal fade" id="Add-Risk-Activity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Add Risk Activity</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <textarea class="form-control form-control-sm" maxlength="1500" onkeypress="maxLengthCheck(this)" id="addRiskActivity" rows="3" onclick="enableSaveAddRiskActivity();" onkeyup="enableSaveAddRiskActivity()"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveAddRiskActivity" name="saveAddRiskActivity" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Add Risk Activity -->

        <!-- Modal Add Risk Deadline -->
        <div class="modal fade" id="Add-Risk-Deadline" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Change Risk Deadline</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <input type="date" name="deadline" id="deadline" onchange="enableSaveChangeRiskDeadline();" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveChangeRiskDeadline" name="saveChangeRiskDeadline" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Add Risk Deadline -->

        <!-- Modal Risk Mitigation Effectiveness -->
        <div class="modal fade" id="Mitigation-Effectiveness" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Mitigation Effectiveness</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <select name="mitigationEffectiveness" id="mitigationEffectiveness" class="form-control form-select-sm form-select" onchange="enableSaveMitigationEffectiveness()" aria-label=".form-select-sm example" style="width: 100%;">
                                <option selected class="text-muted">Select Effectiveness</option>
                                <option <?php   if($risk_details['Effectiveness'] == "Ineffective (<25%)"){ echo    "selected";  }  ?>>Ineffective (<25%)</option>
                                <option <?php   if($risk_details['Effectiveness'] == "Fairly Effective (25% - 50%)"){ echo    "selected";  }  ?>>Fairly Effective (25% - 50%)</option>
                                <option <?php   if($risk_details['Effectiveness'] == "Mostly Effective (50% - 75%)"){ echo    "selected";  }  ?>>Mostly Effective (50% - 75%)</option>
                                <option <?php   if($risk_details['Effectiveness'] == "Effective (>75%)"){ echo    "selected";  }  ?>>Effective (>75%)</option>
                                <option <?php   if($risk_details['Effectiveness'] == "N/A"){ echo    "selected";  }  ?>>N/A</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskMitigationEffectiveness" name="saveRiskMitigationEffectiveness" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Mitigation Effectiveness -->

        <!-- Modal Risk Current Status -->
        <div class="modal fade" id="Current-Status" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Edit Risk Current Status</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <select name="riskCurrentStatus" id="riskCurrentStatus" class="form-control form-select-sm form-select" onchange="enableSaveRiskCurrentStatus()" aria-label=".form-select-sm example" style="width: 100%;">
                                <option selected class="text-muted">Select Current Status</option>
                                <option <?php   if($risk_details['currentStatus'] == "Abandoned"){ echo    "selected";  }  ?>>Abandoned</option>
                                <option <?php   if($risk_details['currentStatus'] == "Completed (delay)"){ echo    "selected";  }  ?>>Completed (delay)</option>
                                <option <?php   if($risk_details['currentStatus'] == "Completed (early)"){ echo    "selected";  }  ?>>Completed (early)</option>
                                <option <?php   if($risk_details['currentStatus'] == "Completed (on time)"){ echo    "selected";  }  ?>>Completed (on time)</option>
                                <option <?php   if($risk_details['currentStatus'] == "Manage with existing controls"){ echo    "selected";  }  ?>>Manage with existing controls</option>
                                <option <?php   if($risk_details['currentStatus'] == "Not started"){ echo    "selected";  }  ?>>Not started</option>
                                <option <?php   if($risk_details['currentStatus'] == "Ongoing (ahead of time)"){ echo    "selected";  }  ?>>Ongoing (ahead of time)</option>
                                <option <?php   if($risk_details['currentStatus'] == "Ongoing (on time)"){ echo    "selected";  }  ?>>Ongoing (on time)</option>
                                <option <?php   if($risk_details['currentStatus'] == "Ongoing (with delays)"){ echo    "selected";  }  ?>>Ongoing (with delays)</option>
                                <option <?php   if($risk_details['currentStatus'] == "Redirected"){ echo    "selected";  }  ?>>Redirected</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveRiskCurrentStatus" name="saveRiskCurrentStatus" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Risk Current Status -->

        <!-- Modal Add Risk Action -->
        <div class="modal fade" id="Add-Risk-Action" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Add Current Progress / Remarks</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <textarea class="form-control form-control-sm" maxlength="1500" onkeypress="maxLengthCheck(this)" id="addRiskAction" rows="3" onclick="enableSaveAddRiskAction();" onkeyup="enableSaveAddRiskAction()"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveAddRiskAction" name="saveAddRiskAction" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Add Risk Action -->

        <!-- Modal Close Risk Action -->
        <div class="modal fade" id="Close-Risk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Close Risk?</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label><small>Please leave a comment...</small></label>
                        <div class="row mt-2 px-2">
                            <textarea class="form-control form-control-sm" id="closeRiskComment" rows="3" onclick="enableCloseRiskComment();" onkeyup="enableCloseRiskComment()"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="closeRisk" name="closeRisk" class="btn btn-sm btn-danger" disabled>Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Close Risk Action -->

        <!-- Modal Re-Open Risk -->
        <div class="modal fade" id="ReOpen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Are you sure you want to re-open this risk?</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label><small>Please leave a comment...</small></label>
                        <div class="row mt-2 px-2">
                            <textarea class="form-control form-control-sm" maxlength="1500" onkeypress="maxLengthCheck(this)" id="ReOpenRiskComment" rows="3" onclick="enableReOpenRiskComment();" onkeyup="enableReOpenRiskComment()"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="reopen" name="reopen" class="btn btn-sm btn-danger" disabled>Re-Open</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Re-Open Risk -->

        <!-- Modal Reject transfer Risk -->
        <div class="modal fade" id="Reject-Risk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Reject Transfer Risk?</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label><small>Please leave a comment...</small></label>
                        <div class="row mt-2 px-2">
                            <textarea class="form-control form-control-sm" id="RejectRiskComment" rows="3" onclick="enableRejectRiskComment();" onkeyup="enableRejectRiskComment()"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="rejectsend2Div" name="rejectsend2Div" class="btn btn-sm btn-danger" disabled>Reject</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal View Log -->
        <div class="modal fade" id="View-Risk-Log" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Log</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="width:auto;">
                        <div class="container">
                            <table class="table table-fixed table-fixedheader table-striped table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th style="width:15%"><small><small>Date / Time</small></small></th>
                                        <th style="width:75%"><small><small>Description</small></small></th>
                                        <th style="width:10%"><small><small>Task By</small></small></th>
                                    </tr>
                                </thead>
                                <tbody style="overflow-y:auto;">
                                <?php
                                    $sqlLog = "SELECT * FROM divactivity WHERE indexRisk = '$riskIndex' ORDER BY idActivity DESC";
                                    $resultLog = mysqli_query($conn,$sqlLog) or die(mysqli_error($conn));
                                    while($log = mysqli_fetch_array($resultLog)){
                                ?>
                                    <tr>
                                        <td>
                                            <small><small>
                                                <?php
                                                    $dateTime = "".$log['Date']." / ".$log['Time']."";
                                                    echo    $dateTime;
                                                ?>
                                            </small></small>
                                        </td>
                                        <td>
                                            <small><small>
                                                <?php
                                                    $updateFields = array('Business Impact', 'Risk Description', 'Risk Category', 'Main Unit', 'KRI', 'BAU', 'Risk Alert', 'Risk', 'Risk Cause', 'Risk Impact', 'Risk Likelyhood Level', 'Risk Impact Level', 'Risk Existing Control', 'Risk Control Effectiveness', 'Risk Evaluation Likelyhood Level', 'Risk Evaluation Impact Level', 'Risk Response', 'Risk Mitigation Effectiveness', 'Risk Current Status');
                                                    $addedFields = array('Risk Activity', 'Risk Action');
                                                    $owners = array('Risk Owners', 'Action Owners');
                                                    if(in_array($log['field'], $updateFields)){
                                                        $des = ''.$log['Des'].' from intial value = "'.$log['intialValue'].'" to value = "'.$log['updatedValue'].'"';
                                                        echo    $des;
                                                    }else if(in_array($log['field'], $addedFields)){
                                                        $des = ''.$log['Des'].' value = "'.$log['updatedValue'].'"';
                                                        echo    $des;
                                                    }else if(in_array($log['field'], $owners)){
                                                        $des = ''.$log['Des'].' - '.$log['updatedValue'].'';
                                                        echo    $des;
                                                    }else if($log['field'] == "Risk Deadline"){
                                                        $des = ''.$log['Des'].' to '.$log['updatedValue'].'';
                                                        echo    $des;
                                                    }else{
                                                        echo    $log['Des'];
                                                    }
                                                ?>
                                            </small></small>
                                        </td>
                                        <td>
                                            <small><small>
                                                <?php
                                                    $empNo = $log['empNo'];
                                                    $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
                                                    $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                                                    $fullName = mysqli_fetch_array($resultFullName);
                                                    echo    $fullName['fullName'];
                                                ?>
                                            </small></small>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of View Log -->

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
                                            echo    $riskIndex;
                                            if($risk_details['closeStatus'] == 1){ 
                                        ?>
                                            <span class="text-danger"><b> (Closed)</b></span>
                                        <?php
                                            } 
                                        ?>
                                    </small>
                                    <br>
                                    <span class="text-danger"><small><small><small>
                                        <?php
                                            if($activeStatus == "Inactive"){
                                                $querySelDivID = "SELECT ERMindexRisk FROM moverisk WHERE  DIVindexRisk = '$riskIndex'";
                                                $resultSelDivID = mysqli_query($conn,$querySelDivID) or die(mysqli_error($conn));
                                                $selDivID = mysqli_fetch_array($resultSelDivID);
                                                $divID = $selDivID['ERMindexRisk'];
                                                echo    "Risk transferred from divisional risk registry to ERM - ERM Risk ID: ".$divID."";
                                            }else if($activeStatus == "Pending"){
                                                echo    "Requesting transfer this risk to ERM";
                                            }
                                        ?>
                                    </small></small></small>
                                </h4>
                                <br>
                                <?php
                                    if($risk_details['closeStatus'] == 1){
                                ?>
                                <div class="row row-cols-1 g-1 g-lg-2 mb-3">
                                    <div class="col">
                                        <div class="p-0">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-body">
                                                    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 g-1 g-lg-2">
                                                        <div class="col mb-4 mb-lg-1">
                                                            <div class="form-control">
                                                                <div class="row d-flex justify-content-between align-items-center">
                                                                    <div class="col-6">
                                                                        <label><small><small>Closed Date / Time :</small></small></label>
                                                                    </div>
                                                                    <?php
                                                                        $valueClose = ''.$risk_details['closeDate'].' '.$risk_details['closeTime'].'';
                                                                        $close_datetime = new DateTime($valueClose);
                                                                    ?>
                                                                    <div class="col-6">
                                                                        <label><small><small><b><?php   echo    $close_datetime->format("l, d F Y, h:i A");   ?></b></small></small></label>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center">
                                                                    <div class="col-6">
                                                                        <label><small><small>Close Comment :</small></small></label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label><small><small><?php   echo    $risk_details['closeComment'];   ?></small></small></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col mb-4 mb-lg-1">
                                                            <div class="row justify-content-between align-item-center">
                                                                <div class="col align-item-center">
                                                                    <button style="float: right" type="button" data-bs-toggle="modal" data-bs-target="#ReOpen" class="btn btn-sm btn-info mx-2" >Open Again</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    $division = $risk_details['mainUnit'];
                                    $sqlInfoProg = "SELECT * FROM divinfogather WHERE status = 0 AND division = '$division'";
                                    $resultInfoProg = mysqli_query($conn,$sqlInfoProg) or die(mysqli_error($conn));
                                    $countInfoProg = mysqli_num_rows($resultInfoProg);
                                    $infoProg = mysqli_fetch_array($resultInfoProg);
                                    if($risk_details['closeStatus'] == 0){
                                        if($countInfoProg == 1){
                                ?>
                                <div class="row row-cols-1 g-1 g-lg-2 mb-3">
                                    <div class="col">
                                        <div class="p-0">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-header">
                                                    <small><?php   echo    $infoProg['Name'];    ?></small>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 g-1 g-lg-2">
                                                        <div class="col mb-4 mb-lg-1">
                                                            <div class="form-control">
                                                                <div class="row d-flex justify-content-between align-items-center">
                                                                    <div class="col-6">
                                                                        <label><small><small>Due Date / Time :</small></small></label>
                                                                    </div>
                                                                    <?php
                                                                        $value = $infoProg['endDate'];
                                                                        $datetime = new DateTime($value);
                                                                    ?>
                                                                    <div class="col-6">
                                                                        <label><small><small><b><?php   echo    $datetime->format("l, d F Y, h:i A");   ?></b></small></small></label>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center">
                                                                    <?php
                                                                        $now = new DateTime();
                                                                        $interval = $datetime->diff($now);
                                                                    ?>
                                                                    <div class="col-6">
                                                                        <label class="<?php    if($datetime < $now){   echo    "text-danger"; }else{   echo    "text-success"; }  ?>"><small><small>
                                                                        <?php
                                                                            if($datetime > $now){
                                                                        ?>
                                                                                Time Remaining :
                                                                        <?php
                                                                            }else{
                                                                        ?>
                                                                                Overdue By :
                                                                        <?php
                                                                            }
                                                                        ?>   
                                                                        </small></small></label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="<?php    if($datetime < $now){   echo    "text-danger"; }else{   echo    "text-success"; }  ?>"><small><small>
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
                                                                        </small></small></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col mb-4 mb-lg-1">
                                                                <div class="row justify-content-between align-item-center">
                                                                    <div class="col align-item-center">
                                                                        <?php
                                                                            $userEmpNo = $userDetails['empNo'];
                                                                            $infoProgID = $infoProg['idInfo'];
                                                                            $sqlUpdate = "SELECT * FROM divinfogatherdetails WHERE idInfo = '$infoProgID' AND indexRisk = '$riskIndex' AND empNo = '$userEmpNo'";
                                                                            $resultUpdate = mysqli_query($conn,$sqlUpdate) or die(mysqli_error($conn));
                                                                            $UpdateRecord = mysqli_fetch_array($resultUpdate);
                                                                            $countUpdate = mysqli_num_rows($resultUpdate);

                                                                            $infoGatherStartDate = $infoProg['startDate'];
                                                                            $inGthrStartDate = new DateTime($infoGatherStartDate);
                                                                            $startDate = $inGthrStartDate->format('Y-m-d');
                                                                            $startTime = $inGthrStartDate->format('H:i:s');
                                                                            $queryInfoRecord = "SELECT COUNT(*) AS activityTot FROM divactivity WHERE (indexRisk = '$riskIndex') AND des NOT IN ('Newly Added','New Action Owner','Remove Action Owner','Add New Risk Owner','Remove Risk Owner') AND (empNo = '$userEmpNo') AND ((Date > '$startDate' OR (Date = '$startDate' AND Time > '$startTime')))";
                                                                            $resultInfoRecord = mysqli_query($conn,$queryInfoRecord) or die(mysqli_error($conn));
                                                                            $infoRecord = mysqli_fetch_array($resultInfoRecord);
                                                                            $countInfoRecord = $infoRecord['activityTot'];

                                                                            $sqlDeadline = "SELECT deadline FROM divrisktreatmentdeadline WHERE id = (SELECT MAX(id) FROM divrisktreatmentdeadline WHERE indexRisk = '$riskIndex')";
                                                                            $resulDeadline = mysqli_query($conn,$sqlDeadline) or die(mysqli_error($conn));
                                                                            $deadlineValue = mysqli_fetch_array($resulDeadline);
                                                                            $dl = new DateTime($deadlineValue['deadline']);

                                                                            if($countUpdate == 0){
                                                                                $status = array("Completed (delay)","Completed (early)","Completed (on time)","Abandoned");
                                                                                $currentStatus = ''.$risk_details['currentStatus'].'';
                                                                        ?>
                                                                        <button style="float: right" type="button" id="done" name="done" class="btn btn-sm btn-success mx-2" <?php if(($countInfoRecord==0) | (($now > $dl) & (!(in_array($currentStatus, $status))))){ echo    "disabled"; }  ?>>Submit</button>
                                                                        <button style="float: right" type="button" id="noUpdate" name="noUpdate" class="btn btn-sm btn-info mx-2" <?php if(($countInfoRecord>0) | ($now > $dl)){ echo    "disabled"; }  ?>>No Updates</button>
                                                                        <?php
                                                                            }else{
                                                                        ?>
                                                                        <small><small><span class="p-2 ps-4">You have selected option '<b><?php echo    $UpdateRecord['descrition'];    ?></b>' for this risk on <b><?php echo    $UpdateRecord['date'];    ?></b> at <b><?php echo    $UpdateRecord['time'];    ?></b></span></small></small>
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
                                <?php
                                        }
                                    }
                                ?>
                                <div class="row row-cols-1 g-1 g-lg-2 mb-2">
                                    <div class="col">
                                        <button style="float: right" type="button" data-bs-toggle="modal" data-bs-target="#View-Risk-Log" class="btn btn-sm btn-primary mx-2" >View Log</button>
                                    <?php
                                        if($risk_details['keyRiskTag'] == 0){
                                    ?>
                                        <button style="float: right" type="button" id="keyRisk" name="keyRisk" class="btn btn-sm btn-danger mx-2" <?php if($activeStatus != "Active"){ echo "disabled"; }?>>Tag as a Key Risk</button>
                                    <?php
                                        }else{
                                    ?>
                                        <button style="float: right" type="button" id="removeKeyRisk" name="removeKeyRisk" class="btn btn-sm btn-danger mx-2" >Remove Key Risk Tag</button>
                                    <?php
                                        }
                                        if($activeStatus == "Active" & $risk_details['closeStatus'] == 0){
                                    ?>
                                        <button style="float: right" type="button" id="send2Div" name="send2Div" class="btn btn-sm btn-danger mx-2" >Send This to ERM</button>
                                    <?php
                                        }
                                        if($activeStatus == "Pending"){
                                    ?>
                                        <button style="float: right" type="button" data-bs-toggle="modal" data-bs-target="#Reject-Risk" id="rejectsend2DivModel" name="rejectsend2DivModel" class="btn btn-sm btn-danger mx-2" >Reject</button>
                                        <button style="float: right" type="button" id="acceptsend2Div" name="acceptsend2Div" class="btn btn-sm btn-success mx-2" >Accept</button>
                                    <?php
                                        }
                                    ?>
                                    </div>
                                </div>
                                <div class="row row-cols-1 g-1 g-lg-2 mb-2">
                                    <div class="col">
                                        <div class="p-0">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-header">
                                                    Summary
                                                </div>
                                                <div class="card-body">
                                                    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 row-cols-xl-3 g-1 g-lg-2">
                                                        <div class="col mb-4 mb-lg-1">
                                                            <div class="form-control">
                                                                <div class="row d-flex justify-content-between align-items-center">
                                                                    <div class="col-6">
                                                                        <label><small><small>Risk Index</small></small></label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label><small><small><b><?php  echo    $riskIndex;   ?>  <span class="text-danger"><?php  if($risk_details['keyRiskTag'] == 1){ echo  "(Key Risk)";   }   ?></span></b></small></small></label>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="col-6">
                                                                        <label><small><small>Risk Category</small></small></label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label><small><small><?php  echo    $risk_details['cateory'];   ?></small></small></label>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="col-6">
                                                                        <label><small><small>Reported By</small></small></label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label>
                                                                            <small><small>
                                                                                <?php
                                                                                    $empNo = $risk_details["reporter"];
                                                                                    $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNo'";
                                                                                    $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                                                                                    $fullName = mysqli_fetch_array($resultFullName);
                                                                                    echo    $fullName['fullName'];
                                                                                ?>
                                                                            </small></small>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="col-6">
                                                                        <label><small><small>Main Unit / Segment</small></small></label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label><small><small><?php  echo    $risk_details['mainUnit'];   ?></small></small></label>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="col-6">
                                                                        <label><small><small>Reported Date / Time</small></small></label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label><small><small><?php  echo    ''.$risk_details['reportedDate'].' / '.$risk_details['reportedTime'].'';   ?></small></small></label>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="col-6">
                                                                        <label><small><small>Last Updated By</small></small></label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <?php
                                                                            $sql_LastUpdate = "SELECT empNo,date,time FROM divlastupdate WHERE indexRisk = '$riskIndex'";
                                                                            $result_lastUpdate = mysqli_query($conn,$sql_LastUpdate) or die(mysqli_error($conn));
                                                                            $lastUpdate = mysqli_fetch_array($result_lastUpdate);
                                                                        ?>
                                                                        <label>
                                                                            <small><small>
                                                                                <?php
                                                                                    $empNolastUp = $lastUpdate['empNo'];
                                                                                    $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNolastUp'";
                                                                                    $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                                                                                    $fullName = mysqli_fetch_array($resultFullName);
                                                                                    echo    $fullName['fullName'];
                                                                                ?>
                                                                            </small></small>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="col-6">
                                                                        <label><small><small>Last Updated Date / Time</small></small></label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label><small><small><?php  echo    ''.$lastUpdate['date'].' / '.$lastUpdate['time'].'';   ?></small></small></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col mb-4 mb-lg-1">
                                                            <div class="form-control">
                                                                <div class="row">
                                                                    <label align="center"><small>Risk Owners</small></label>
                                                                </div>
                                                                <div class="row">
                                                                <?php
                                                                    if($risk_details['closeStatus'] == 0){
                                                                ?>
                                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#risk-owners" class="btn btn-info m-auto mt-2" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem; width: 50%;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Add Risk Owner</button>
                                                                <?php
                                                                    }
                                                                ?>
                                                                </div>
                                                                <div class="row mt-2 px-1">
                                                                    <div class="table-responsive d-flex" style="height: 153px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                                        <table class="table table-sm table-striped table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col" style="width: 50%;"><small><small>Name</small></small></th>
                                                                                    <th scope="col" style="width: 30%;"><small><small>Employee ID</small></small></th>
                                                                                    <th scope="col" style="width: 20%;"><small><small>Remove</small></small></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $sql_riskOwners = "SELECT fullName, empNo FROM user_details WHERE empNo IN (SELECT empNo FROM divriskowners WHERE indexRisk = '$riskIndex') ORDER BY fullName";
                                                                                    $resul_riskOwners = mysqli_query($conn,$sql_riskOwners) or die(mysqli_error($conn));
                                                                                    $count = mysqli_num_rows($resul_riskOwners);
                                                                                    if($count>0){
                                                                                        while($riskOwners = mysqli_fetch_array($resul_riskOwners)){
                                                                                ?>
                                                                                <tr>
                                                                                    <td><small><small><?php    echo    $riskOwners['fullName'];  ?></small></small></td>
                                                                                    <td><small><small><?php    echo    $riskOwners['empNo'];  ?></small></small></td>
                                                                                    <?php
                                                                                        if($risk_details['closeStatus'] == 0){
                                                                                    ?>
                                                                                    <td align="center"><small><small><button type="button" name="riskOwnerButton" onclick="removeRiskOwners(this);" id="<?php  echo    $riskOwners['empNo'];   ?>" class="btn btn-sm btn-danger" style="padding: .20rem .4rem; font-size: .800rem; line-height: .95; border-radius: .2rem;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Remove</button></small></small></td>
                                                                                    <?php
                                                                                        }else{
                                                                                    ?>
                                                                                        <td></td>
                                                                                    <?php        
                                                                                        }
                                                                                    ?>
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
                                                        </div>
                                                        <div class="col mb-4 mb-lg-1">
                                                            <div class="form-control">
                                                                <div class="row">
                                                                    <label align="center"><small>Action Owners</small></label>
                                                                </div>
                                                                <div class="row">
                                                                <?php
                                                                    if($risk_details['closeStatus'] == 0){
                                                                ?>
                                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#action-owners" class="btn btn-info m-auto mt-2" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem; width: 50%;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Add Action Owner</button>
                                                                <?php
                                                                    }
                                                                ?>
                                                                </div>
                                                                <div class="row mt-2 px-1">
                                                                    <div class="table-responsive d-flex" style="height: 153px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                                        <table class="table table-sm table-striped table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col" style="width: 50%;"><small><small>Name</small></small></th>
                                                                                    <th scope="col" style="width: 30%;"><small><small>Employee ID</small></small></th>
                                                                                    <th scope="col" style="width: 20%;"><small><small>Remove</small></small></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $sql_actionOwners = "SELECT fullName, empNo FROM user_details WHERE empNo IN (SELECT empNo FROM divactionowners WHERE indexRisk = '$riskIndex') ORDER BY fullName";
                                                                                    $resul_actionOwners = mysqli_query($conn,$sql_actionOwners) or die(mysqli_error($conn));
                                                                                    $countaction = mysqli_num_rows($resul_actionOwners);
                                                                                    if($countaction>0){
                                                                                        while($actionOwners = mysqli_fetch_array($resul_actionOwners)){
                                                                                ?>
                                                                                <tr>
                                                                                    <td><small><small><?php    echo    $actionOwners['fullName'];  ?></small></small></td>
                                                                                    <td><small><small><?php    echo    $actionOwners['empNo'];  ?></small></small></td>
                                                                                    <?php
                                                                                        if($risk_details['closeStatus'] == 0){
                                                                                    ?>
                                                                                    <td align="center"><small><small><button type="button" name="actionOwnerButton" onclick="removeActionOwners(this);" id="<?php  echo    $actionOwners['empNo'];   ?>" class="btn btn-sm btn-danger" style="padding: .20rem .4rem; font-size: .800rem; line-height: .95; border-radius: .2rem;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Remove</button></small></small></td>
                                                                                    <?php
                                                                                        }else{
                                                                                    ?>
                                                                                        <td></td>
                                                                                    <?php        
                                                                                        }
                                                                                    ?>
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-cols-1 g-1 g-lg-2 mb-2">
                                    <div class="col">
                                        <div class="p-0">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-header">
                                                    Details
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Risk Identification</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label><small><small>High Level Business Impact<span class="text-muted"><small> (Impact by the risk)</small></span></small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['businessObj'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#business-impact" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Risk Description<span class="text-muted"><small> (At high-level)</small></span></small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['description'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#risk-description" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Risk Category</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['cateory'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#risk-category" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Main Unit / Segment<span class="text-muted"><small> (New)</small></span></small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['mainUnit'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#main-unit" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Risk Analysis</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label><small><small>KRI</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['kri'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#KRI" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>BAU</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['bau'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#BAU" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Alert</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['riskAlert'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Risk-Alert" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Risk</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['risk'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Risk-Risk" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Cause</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['cause'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Risk-Cause" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Impact</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['impact'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Risk-Impact" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Likelihood Level</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['likelyhoodLevel'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Risk-Likelyhood-Level" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Impact Level</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['impactLevel'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Risk-Impact-Level" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Risk Level</small></small></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span><small><small><?php    echo    $risk_details['riskLevel'];    ?></small></small></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Risk Evaluation</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label><small><small>Existing Control</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['existingControl'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Risk-Existing-Control" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Control Effectiveness</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['ContrEffectv'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Control-Effectiveness" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Likelihood Level</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['reslikelyhoodLevel'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Risk-Evaluation-Likelyhood-Level" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Impact Level</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['resimpactLevel'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Risk-Evaluation-Impact-Level" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Overall Risk Level</small></small></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <span><small><small><?php    echo    $risk_details['resriskLevel'];    ?></small></small></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-control p-3 mb-3">
                                                        <h6 align="center"><small>Risk Treatment</small></h6>
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label><small><small>Risk Response<span class="text-muted"><small> (Rationale)</small></span></small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['riskResponse'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Risk-Response" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Activity</small></small></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="table-responsive d-flex" style="height: 200px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                                    <table class="table table-sm table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" style="width: 65%;"><small><small>Activity</small></small></th>
                                                                                <th scope="col" style="width: 15%;"><small><small>Name</small></small></th>
                                                                                <th scope="col" style="width: 20%;"><small><small>Date / Time</small></small></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $sql_activity = "SELECT activity, empNo, date, time FROM divrisktreatmentactivity WHERE indexRisk = '$riskIndex' ORDER BY id DESC";
                                                                                $resul_activity = mysqli_query($conn,$sql_activity) or die(mysqli_error($conn));
                                                                                $count_activity = mysqli_num_rows($resul_activity);
                                                                                if($count_activity>0){
                                                                                    $countRowAc = 0;
                                                                                    while($activity = mysqli_fetch_array($resul_activity)){
                                                                            ?>
                                                                            <tr>
                                                                                <td><small><small><?php if($countRowAc>0){    echo    "<del>";    }  echo    $activity['activity'];  if($countRowAc>0){    echo    "</del>";    }  ?></small></small></td>
                                                                                <td>
                                                                                    <small><small>
                                                                                        <?php

                                                                                            if($countRowAc>0){
                                                                                                echo    "<del>";
                                                                                            }
                                                                                            $empNoActivity = $activity['empNo'];
                                                                                            $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNoActivity'";
                                                                                            $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                                                                                            $fullName = mysqli_fetch_array($resultFullName);
                                                                                            echo    $fullName['fullName'];

                                                                                            if($countRowAc>0){
                                                                                                echo    "</del>";
                                                                                            }
                                                                                        ?>
                                                                                    </small></small>
                                                                                </td>
                                                                                <td><small><small><?php if($countRowAc>0){    echo    "<del>";    } echo    ''.$activity['date'].' / '.$activity['time'].'';  if($countRowAc>0){    echo    "</del>";    }  ?></small></small></td>
                                                                            </tr>
                                                                            <?php
                                                                                        $countRowAc++;
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <br>
                                                                <?php
                                                                    if($risk_details['closeStatus'] == 0){
                                                                ?>
                                                                <button data-bs-toggle="modal" data-bs-target="#Add-Risk-Activity" type="button" style="padding: .35rem .5rem; font-size: .900rem; line-height: .95; border-radius: .2rem; float: right;" class="btn btn-info" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Add Activity</button>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Deadline</small></small></label>
                                                            </div>
                                                            <div class="col-8">
                                                            <div class="table-responsive d-flex" style="height: 200px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                                    <table class="table table-sm table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" style="width: 65%;"><small><small>Deadline</small></small></th>
                                                                                <th scope="col" style="width: 15%;"><small><small>Name</small></small></th>
                                                                                <th scope="col" style="width: 20%;"><small><small>Date / Time</small></small></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $sql_deadline = "SELECT deadline, empNo, date, time FROM divrisktreatmentdeadline WHERE indexRisk = '$riskIndex' ORDER BY id DESC";
                                                                                $resul_deadline = mysqli_query($conn,$sql_deadline) or die(mysqli_error($conn));
                                                                                $count_deadline = mysqli_num_rows($resul_deadline);
                                                                                if($count_deadline>0){
                                                                                    $countRow = 0;
                                                                                    while($deadline = mysqli_fetch_array($resul_deadline)){
                                                                            ?>
                                                                            <tr>
                                                                                <td><small><small><?php if($countRow>0){    echo    "<del>";    }   echo    $deadline['deadline'];  if($countRow>0){    echo    "</del>";    } ?></small></small></td>
                                                                                <td>
                                                                                    <small><small>
                                                                                        <?php
                                                                                            if($countRow>0){
                                                                                                echo    "<del>";
                                                                                            }

                                                                                            $empNoDeadline = $deadline['empNo'];
                                                                                            $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNoDeadline'";
                                                                                            $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                                                                                            $fullName = mysqli_fetch_array($resultFullName);
                                                                                            echo    $fullName['fullName'];

                                                                                            if($countRow>0){
                                                                                                echo    "</del>";
                                                                                            }
                                                                                        ?>
                                                                                    </small></small>
                                                                                </td>
                                                                                <td><small><small><?php if($countRow>0){    echo    "<del>";    }   echo    ''.$deadline['date'].' / '.$deadline['time'].'';    if($countRow>0){    echo    "</del>";    }  ?></small></small></td>
                                                                            </tr>
                                                                            <?php
                                                                                        $countRow++;
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <br>
                                                                <?php
                                                                    if($risk_details['closeStatus'] == 0){
                                                                ?>
                                                                <button data-bs-toggle="modal" data-bs-target="#Add-Risk-Deadline" type="button" style="padding: .35rem .5rem; font-size: .900rem; line-height: .95; border-radius: .2rem; float: right;" class="btn btn-info" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Change Deadline</button>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Effectiveness of the Risk Mitigation Method</small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['Effectiveness'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Mitigation-Effectiveness" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>    
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Current Status <span class="text-muted"><small> (High level)</small></span></small></small></label>
                                                            </div>
                                                            <div class="col-7">
                                                                <span><small><small><?php    echo    $risk_details['currentStatus'];    ?></small></small></span>
                                                            </div>
                                                            <div class="col-1">
                                                            <?php
                                                                if($risk_details['closeStatus'] == 0){
                                                            ?>
                                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#Current-Status" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Edit</button>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label><small><small>Current Progress / Remarks<span class="text-muted"><small> (As applicable)</small></span></small></small></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="table-responsive d-flex" style="height: 200px; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                                    <table class="table table-sm table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" style="width: 65%;"><small><small>Action</small></small></th>
                                                                                <th scope="col" style="width: 15%;"><small><small>Name</small></small></th>
                                                                                <th scope="col" style="width: 20%;"><small><small>Date / Time</small></small></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $sql_actions = "SELECT action, empNo, date, time FROM divrisktreatmentresponseaction WHERE indexRisk = '$riskIndex' ORDER BY id DESC";
                                                                                $resul_action = mysqli_query($conn,$sql_actions) or die(mysqli_error($conn));
                                                                                $count_action = mysqli_num_rows($resul_action);
                                                                                if($count_action>0){
                                                                                    $countRowTRAC = 0;
                                                                                    while($action = mysqli_fetch_array($resul_action)){
                                                                            ?>
                                                                            <tr>
                                                                                <td><small><small><?php if($countRowTRAC>0){    echo    "<del>";    }  echo    $action['action']; if($countRowTRAC>0){    echo    "</del>";    }   ?></small></small></td>
                                                                                <td>
                                                                                    <small><small>
                                                                                        <?php
                                                                                            if($countRowTRAC>0){
                                                                                                echo    "<del>";
                                                                                            }

                                                                                            $empNoAction = $action['empNo'];
                                                                                            $queryFullName = "SELECT fullName FROM user_details WHERE empNo = '$empNoAction'";
                                                                                            $resultFullName = mysqli_query($conn,$queryFullName) or die(mysqli_error($conn));
                                                                                            $fullName = mysqli_fetch_array($resultFullName);
                                                                                            echo    $fullName['fullName'];

                                                                                            if($countRowTRAC>0){
                                                                                                echo    "</del>";
                                                                                            }
                                                                                        ?>
                                                                                    </small></small>
                                                                                </td>
                                                                                <td><small><small><?php if($countRowTRAC>0){    echo    "<del>";    }  echo    ''.$action['date'].' / '.$action['time'].''; if($countRowTRAC>0){    echo    "</del>";    }   ?></small></small></td>
                                                                            </tr>
                                                                            <?php
                                                                                        $countRowTRAC++;
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <br>
                                                                <?php
                                                                    if($risk_details['closeStatus'] == 0){
                                                                ?>
                                                                <button data-bs-toggle="modal" data-bs-target="#Add-Risk-Action" type="button" style="padding: .35rem .5rem; font-size: .900rem; line-height: .95; border-radius: .2rem; float: right;" class="btn btn-info" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Add Action</button>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div align="center">
                                                    <?php
                                                        if($risk_details['closeStatus'] == 0){
                                                    ?>
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#Close-Risk" class="btn btn-sm btn-danger mx-2" <?php if($activeStatus != "Active"){  echo    "disabled"; }  ?>>Close this Risk</button>
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

            $('#done').click(function(){
                if(confirm("Are you sure you want to proceed with 'Submit' option?")){
                    var indexRisk = `<?php   echo    $riskIndex; ?>`;
                    var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                    var idInfo = `<?php echo    $infoProg['idInfo'];    ?>`;
                    var option = "Submit";
                    $.ajax({
                        url: "Add-InfoProg-Details.php",
                        method: "POST",
                        data: {empNo:empNo,indexRisk:indexRisk,idInfo:idInfo,option:option},
                        dataType: "text",
                        success: function(data){
                            if(data == "true"){
                                alert("Successfully Submitted");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please try again...");
                                location.reload();
                            }
                        }
                    })
                }
            });

            $('#noUpdate').click(function(){
                if(confirm("Are you sure you want to proceed with 'No Update' option?")){
                    var indexRisk = `<?php   echo    $riskIndex; ?>`;
                    var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                    var idInfo = `<?php echo    $infoProg['idInfo'];    ?>`;
                    var option = "No Update";
                    $.ajax({
                        url: "Add-InfoProg-Details.php",
                        method: "POST",
                        data: {empNo:empNo,indexRisk:indexRisk,idInfo:idInfo,option:option},
                        dataType: "text",
                        success: function(data){
                            if(data == "true"){
                                alert("Successfully Submitted");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please try again...");
                                location.reload();
                            }
                        }
                    })
                }
            });

            var idRiskOwners = [];
            var idActionOwners = [];

            function selectRiskOwners(checkRisk){
                if(checkRisk.checked){
                    idRiskOwners.push(checkRisk.value);
                    document.getElementById('addRiskOwners').disabled = false;
                }else{
                    var pos = idRiskOwners.indexOf(checkRisk.value);
                    idRiskOwners.splice(pos, 1);
                    if(idRiskOwners.length == 0){
                        document.getElementById('addRiskOwners').disabled = true;
                    }
                }
            }

            function selectActionOwners(checkAction){
                if(checkAction.checked){
                    idActionOwners.push(checkAction.value);
                    document.getElementById('addActionOwners').disabled = false;
                }else{
                    var pos = idActionOwners.indexOf(checkAction.value);
                    idActionOwners.splice(pos, 1);
                    if(idActionOwners.length == 0){
                        document.getElementById('addActionOwners').disabled = true;
                    }
                }
            }

            $('#keyRisk').click(function(){
                if(confirm("Are you sure you want to tag this risk as Key Risk?")){
                    $("#keyRisk").html("Adding...");
                    document.getElementById('keyRisk').disabled = true;
                    document.body.style.cursor = 'wait';
                    var indexRisk = `<?php   echo    $riskIndex; ?>`;
                    var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                    $.ajax({
                        url: "Tag-Key-Risk.php",
                        method: "POST",
                        data: {empNo:empNo,indexRisk:indexRisk},
                        dataType: "text",
                        success: function(data){
                            if(data == "true"){
                                alert("Successfully Tagged");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please try again...");
                            }
                        }
                    })
                }else{
                    return false;
                }
            });

            $('#removeKeyRisk').click(function(){
                if(confirm("Are you sure you want to remove Key Risk Tag form this risk?")){
                    $("#removeKeyRisk").html("Removing...");
                    document.getElementById('removeKeyRisk').disabled = true;
                    document.body.style.cursor = 'wait';
                    var indexRisk = `<?php   echo    $riskIndex; ?>`;
                    var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                    $.ajax({
                        url: "Remove-Key-Risk.php",
                        method: "POST",
                        data: {empNo:empNo,indexRisk:indexRisk},
                        dataType: "text",
                        success: function(data){
                            if(data == "true"){
                                alert("Successfully Removed");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please try again...");
                            }
                        }
                    })
                }else{
                    return false;
                }
            });

            $('#addRiskOwners').click(function(){
                $("#addRiskOwners").html("Adding...");
                document.getElementById('addRiskOwners').disabled = true;
                document.body.style.cursor = 'wait';
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Add-Risk-Owner.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,idRiskOwners:idRiskOwners},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Added");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                        }
                    }
                })
            });

            $('#send2Div').click(function(){
                if(confirm("Are you sure you want to send this risk to ERM?")){
                    $("#send2Div").html("Sending...");
                    document.getElementById('send2Div').disabled = true;
                    document.body.style.cursor = 'wait';
                    var indexRisk = `<?php   echo    $riskIndex; ?>`;
                    var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                    $.ajax({
                        url: "Send-Risk-ERM.php",
                        method: "POST",
                        data: {empNo:empNo,indexRisk:indexRisk},
                        dataType: "text",
                        success: function(data){
                            if(data == "true"){
                                alert("Successfully Sent");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please try again...");
                                location.reload();
                            }
                        }
                    })
                }else{
                    return false;
                }
            });

            $('#acceptsend2Div').click(function(){
                if(confirm("Are you sure you want to send this risk to ERM?")){
                    $("#acceptsend2Div").html("Sending...");
                    document.getElementById('acceptsend2Div').disabled = true;
                    document.getElementById('rejectsend2Div').disabled = true;
                    document.body.style.cursor = 'wait';
                    var indexRisk = `<?php   echo    $riskIndex; ?>`;
                    var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                    $.ajax({
                        url: "Send-Risk-ERM.php",
                        method: "POST",
                        data: {empNo:empNo,indexRisk:indexRisk},
                        dataType: "text",
                        success: function(data){
                            if(data == "true"){
                                alert("Successfully Sent");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please try again...");
                                location.reload();
                            }
                        }
                    })
                }else{
                    return false;
                }
            });

            
            $('#rejectsend2Div').click(function(){
                if(confirm("Are you sure you want to reject this request?")){
                    $("#rejectsend2Div").html("Rejecting...");
                    var comment = document.getElementById('RejectRiskComment').value;
                    document.getElementById('acceptsend2Div').disabled = true;
                    document.getElementById('rejectsend2Div').disabled = true;
                    document.body.style.cursor = 'wait';
                    var indexRisk = `<?php   echo    $riskIndex; ?>`;
                    var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                    $.ajax({
                        url: "Reject-Send-Risk-ERM.php",
                        method: "POST",
                        data: {empNo:empNo,indexRisk:indexRisk,comment:comment},
                        dataType: "text",
                        success: function(data){
                            if(data == "true"){
                                alert("Successfully Rejected");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please try again...");
                                location.reload();
                            }
                        }
                    })
                }else{
                    return false;
                }
            });

            $('#addActionOwners').click(function(){
                $("#addActionOwners").html("Adding...");
                document.getElementById('addActionOwners').disabled = true;
                document.body.style.cursor = 'wait';
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Add-Action-Owner.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,idActionOwners:idActionOwners},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Added");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                        }
                    }
                })
            });

            function removeRiskOwners(remove){
                if(confirm("Are you sure you want to remove this name?")){
                    $(remove).html("Removing...");
                    $(remove).disabled = true;
                    document.body.style.cursor = 'wait';

                    var empNo_remove = $(remove).attr("id");
                    var indexRisk = `<?php   echo    $riskIndex; ?>`;
                    var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                    $.ajax({
                        url: "Remove-Risk-Owner.php",
                        method: "POST",
                        data: {empNo:empNo,indexRisk:indexRisk,empNo_remove:empNo_remove},
                        dataType: "text",
                        success: function(data){
                            if(data == "true"){
                                alert("Successfully Removed");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please try again...");
                            }
                        }
                    })
                }else{
                    return false;
                }
            }

            function removeActionOwners(removeA){
                if(confirm("Are you sure you want to remove this name?")){
                    $(removeA).html("Removing...");
                    $(removeA).disabled = true;
                    document.body.style.cursor = 'wait';

                    var empNo_removeA = $(removeA).attr("id");
                    var indexRisk = `<?php   echo    $riskIndex; ?>`;
                    var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                    $.ajax({
                        url: "Remove-Action-Owner.php",
                        method: "POST",
                        data: {empNo:empNo,indexRisk:indexRisk,empNo_removeA:empNo_removeA},
                        dataType: "text",
                        success: function(data){
                            if(data == "true"){
                                alert("Successfully Removed");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please try again...");
                            }
                        }
                    })
                }else{
                    return false;
                }
            }

            function enableSaveBusinessImpact(){
                if((document.getElementById('businessImpact').value != `<?php    echo    $risk_details['businessObj'];    ?>`) & (document.getElementById('businessImpact').value != "")){
                    document.getElementById('saveBusinessImpact').disabled = false;
                }else{
                    document.getElementById('saveBusinessImpact').disabled = true;
                }
            }

            $('#saveBusinessImpact').click(function(){
                var businessImpact = document.getElementById('businessImpact').value;
                var initialVal = `<?php    echo    $risk_details['businessObj'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Business-Impact.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,businessImpact:businessImpact,initialVal:initialVal},
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

            $('#closeRisk').click(function(){
                $("#closeRisk").html("Closing...");
                document.getElementById('closeRisk').disabled = true;
                document.body.style.cursor = 'wait';
                var comment = document.getElementById('closeRiskComment').value;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Close-Risk.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,comment:comment},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Closed");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                            location.reload();
                        }
                    }
                })
            });

            $('#reopen').click(function(){
                $("#reopen").html("Opening...");
                document.getElementById('reopen').disabled = true;
                document.body.style.cursor = 'wait';
                var comment = document.getElementById('ReOpenRiskComment').value;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Open-Again-Risk.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Re-Opened");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                            location.reload();
                        }
                    }
                })
                
            });

            function enableCloseRiskComment(){
                if(document.getElementById('closeRiskComment').value != ""){
                    document.getElementById('closeRisk').disabled = false;
                }else{
                    document.getElementById('closeRisk').disabled = true;
                }
            }

            function enableReOpenRiskComment(){
                if(document.getElementById('ReOpenRiskComment').value != ""){
                    document.getElementById('reopen').disabled = false;
                }else{
                    document.getElementById('reopen').disabled = true;
                }
            }

            function enableSaveRiskDescription(){
                if((document.getElementById('riskDescription').value != `<?php    echo    $risk_details['description'];    ?>`) & (document.getElementById('riskDescription').value != "")){
                    document.getElementById('saveRiskDescription').disabled = false;
                }else{
                    document.getElementById('saveRiskDescription').disabled = true;
                }
            }

            
            function enableRejectRiskComment(){
                if(document.getElementById('RejectRiskComment').value != ""){
                    document.getElementById('rejectsend2Div').disabled = false;
                }else{
                    document.getElementById('rejectsend2Div').disabled = true;
                }
            }

            $('#saveRiskDescription').click(function(){
                var riskDescription = document.getElementById('riskDescription').value;
                var initialVal = `<?php    echo    $risk_details['description'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Description.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,riskDescription:riskDescription,initialVal:initialVal},
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

            function enableSaveRiskCategory(){
                if((document.getElementById('riskCategory').value != `<?php    echo    $risk_details['cateory'];    ?>`) & (document.getElementById('riskCategory').value != "Select Risk Category")){
                    document.getElementById('saveRiskCategory').disabled = false;
                }else{
                    document.getElementById('saveRiskCategory').disabled = true;
                }
            }

            $('#saveRiskCategory').click(function(){
                var riskCategory = document.getElementById('riskCategory').value;
                var initialVal = `<?php    echo    $risk_details['cateory'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Category.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,riskCategory:riskCategory,initialVal:initialVal},
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

            function enableSaveMainUnit(){
                if((document.getElementById('mainUnit').value != `<?php    echo    $risk_details['mainUnit'];    ?>`) & (document.getElementById('mainUnit').value != "Select Unit")){
                    document.getElementById('saveMainUnit').disabled = false;
                }else{
                    document.getElementById('saveMainUnit').disabled = true;
                }
            }

            $('#saveMainUnit').click(function(){
                var mainUnit = document.getElementById('mainUnit').value;
                var initialVal = `<?php    echo    $risk_details['mainUnit'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Main-Unit.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,mainUnit:mainUnit,initialVal:initialVal},
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

            function enableSaveRiskKRI(){
                if((document.getElementById('riskKRI').value != `<?php    echo    $risk_details['kri'];    ?>`) & (document.getElementById('riskKRI').value != "")){
                    document.getElementById('saveRiskKRI').disabled = false;
                }else{
                    document.getElementById('saveRiskKRI').disabled = true;
                }
            }

            $('#saveRiskKRI').click(function(){
                var riskKRI = document.getElementById('riskKRI').value;
                var initialVal = `<?php    echo    $risk_details['kri'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-KRI.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,riskKRI:riskKRI,initialVal:initialVal},
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

            function enableSaveRiskBAU(){
                if((document.getElementById('riskBAU').value != `<?php    echo    $risk_details['bau'];    ?>`) & (document.getElementById('riskBAU').value != "")){
                    document.getElementById('saveRiskBAU').disabled = false;
                }else{
                    document.getElementById('saveRiskBAU').disabled = true;
                }
            }

            $('#saveRiskBAU').click(function(){
                var riskBAU = document.getElementById('riskBAU').value;
                var initialVal = `<?php    echo    $risk_details['bau'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-BAU.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,riskBAU:riskBAU,initialVal:initialVal},
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

            function enableSaveRiskAlert(){
                if((document.getElementById('riskAlert').value != `<?php    echo    $risk_details['riskAlert'];    ?>`) & (document.getElementById('riskAlert').value != "")){
                    document.getElementById('saveRiskAlert').disabled = false;
                }else{
                    document.getElementById('saveRiskAlert').disabled = true;
                }
            }

            $('#saveRiskAlert').click(function(){
                var riskAlert = document.getElementById('riskAlert').value;
                var initialVal = `<?php    echo    $risk_details['riskAlert'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Alert.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,riskAlert:riskAlert,initialVal:initialVal},
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

            function enableSaveRiskRisk(){
                if((document.getElementById('riskRisk').value != `<?php    echo    $risk_details['risk'];    ?>`) & (document.getElementById('riskRisk').value != "")){
                    document.getElementById('saveRiskRisk').disabled = false;
                }else{
                    document.getElementById('saveRiskRisk').disabled = true;
                }
            }

            $('#saveRiskRisk').click(function(){
                var riskRisk = document.getElementById('riskRisk').value;
                var initialVal = `<?php    echo    $risk_details['risk'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Risk.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,riskRisk:riskRisk,initialVal:initialVal},
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

            function enableSaveRiskCause(){
                if((document.getElementById('riskCause').value != `<?php    echo    $risk_details['cause'];    ?>`) & (document.getElementById('riskCause').value != "")){
                    document.getElementById('saveRiskCause').disabled = false;
                }else{
                    document.getElementById('saveRiskCause').disabled = true;
                }
            }

            $('#saveRiskCause').click(function(){
                var riskCause = document.getElementById('riskCause').value;
                var initialVal = `<?php    echo    $risk_details['cause'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Cause.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,riskCause:riskCause,initialVal:initialVal},
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

            function enableSaveRiskImpact(){
                if((document.getElementById('riskImpact').value != `<?php    echo    $risk_details['impact'];    ?>`) & (document.getElementById('riskImpact').value != "")){
                    document.getElementById('saveRiskImpact').disabled = false;
                }else{
                    document.getElementById('saveRiskImpact').disabled = true;
                }
            }

            $('#saveRiskImpact').click(function(){
                var riskImpact = document.getElementById('riskImpact').value;
                var initialVal = `<?php    echo    $risk_details['impact'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Impact.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,riskImpact:riskImpact,initialVal:initialVal},
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

            function setRiskLevel(){
                var likelyhood = $.trim($('#likelyhoodLevel').val());
                var impact = $.trim($('#impactLevel').text());
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

            function enableSaveRiskLikelyhoodLevel(){
                if((document.getElementById('likelyhoodLevel').value != `<?php    echo    $risk_details['likelyhoodLevel'];    ?>`) & (document.getElementById('likelyhoodLevel').value != "Select Likelyhood Level")){
                    document.getElementById('saveRiskLikelyhoodLevel').disabled = false;
                    setRiskLevel();
                }else{
                    document.getElementById('saveRiskLikelyhoodLevel').disabled = true;
                    if(document.getElementById('likelyhoodLevel').value == `<?php    echo    $risk_details['likelyhoodLevel'];    ?>`){
                        $('#riskLevel').removeClass('text-danger');
                        setRiskLevel();
                    }else if(document.getElementById('likelyhoodLevel').value == "Select Likelyhood Level"){
                        $('#riskLevel').addClass('text-danger');
                        $('#riskLevel').text('Please select likelyhood level');
                    }
                }
            }

            $('#saveRiskLikelyhoodLevel').click(function(){
                var likelyhoodLevel = document.getElementById('likelyhoodLevel').value;
                var riskLevel = $.trim($('#riskLevel').text());
                var initialVal = `<?php    echo    $risk_details['likelyhoodLevel'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Likelyhood-Level.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,likelyhoodLevel:likelyhoodLevel,riskLevel:riskLevel,initialVal:initialVal},
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

            function setImpactRiskLevel(){
                var likelyhood = $.trim($('#impactLikelyhoodLevel').text());
                var impact = $.trim($('#impactImpactLevel').val());
                $('#impactRiskLevel').removeClass('text-danger');
                if(likelyhood == 'Almost Certain'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#impactRiskLevel').text('Moderate');
                    }else if(impact == 'Moderate'){
                        $('#impactRiskLevel').text('High');
                    }else if(impact == 'Major'){
                        $('#impactRiskLevel').text('Significant');
                    }else if(impact == 'Catastropic'){
                        $('#impactRiskLevel').text('Extreme');
                    }
                }else if(likelyhood == 'Likely'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#impactRiskLevel').text('Moderate');
                    }else if(impact == 'Moderate'){
                        $('#impactRiskLevel').text('High');
                    }else if(impact == 'Major' | impact == 'Catastropic'){
                        $('#impactRiskLevel').text('Significant');
                    }
                }else if(likelyhood == 'Moderate'){
                    if(impact == 'Insignificant'){
                        $('#impactRiskLevel').text('Low');
                    }else if(impact == 'Minor'){
                        $('#impactRiskLevel').text('Moderate');
                    }else if(impact == 'Moderate' | impact == 'Major'){
                        $('#impactRiskLevel').text('High');
                    }else if(impact == 'Catastropic'){
                        $('#impactRiskLevel').text('Significant');
                    }
                }else if(likelyhood == 'Unlikely'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#impactRiskLevel').text('Low');
                    }else if(impact == 'Moderate'){
                        $('#impactRiskLevel').text('Moderate');
                    }else if(impact == 'Major' | impact == 'Catastropic'){
                        $('#impactRiskLevel').text('High');
                    }
                }else if(likelyhood == 'Rare'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#impactRiskLevel').text('Low');
                    }else if(impact == 'Moderate' | impact == 'Major'){
                        $('#impactRiskLevel').text('Moderate');
                    }else if(impact == 'Catastropic'){
                        $('#impactRiskLevel').text('High');
                    }
                }
            }

            function enableSaveRiskImpactLevel(){
                if((document.getElementById('impactImpactLevel').value != `<?php    echo    $risk_details['impactLevel'];    ?>`) & (document.getElementById('impactImpactLevel').value != "Select Impact Level")){
                    document.getElementById('saveRiskImpactLevel').disabled = false;
                    setImpactRiskLevel();
                }else{
                    document.getElementById('saveRiskImpactLevel').disabled = true;
                    if(document.getElementById('impactImpactLevel').value == `<?php    echo    $risk_details['impactLevel'];    ?>`){
                        $('#impactRiskLevel').removeClass('text-danger');
                        setImpactRiskLevel();
                    }else if(document.getElementById('impactImpactLevel').value == "Select Impact Level"){
                        $('#impactRiskLevel').addClass('text-danger');
                        $('#impactRiskLevel').text('Please select likelyhood level');
                    }
                }
            }

            $('#saveRiskImpactLevel').click(function(){
                var impactLevel = document.getElementById('impactImpactLevel').value;
                var riskLevel = $.trim($('#impactRiskLevel').text());
                var initialVal = `<?php    echo    $risk_details['impactLevel'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Impact-Level.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,impactLevel:impactLevel,riskLevel:riskLevel,initialVal:initialVal},
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

            function enableSaveRiskExistingControl(){
                if((document.getElementById('riskExistingControl').value != `<?php    echo    $risk_details['existingControl'];    ?>`) & (document.getElementById('riskExistingControl').value != "")){
                    document.getElementById('saveRiskExistingControl').disabled = false;
                }else{
                    document.getElementById('saveRiskExistingControl').disabled = true;
                }
            }

            $('#saveRiskExistingControl').click(function(){
                var riskExistingControl = document.getElementById('riskExistingControl').value;
                var initialVal = `<?php    echo    $risk_details['existingControl'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Existing-Control.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,riskExistingControl:riskExistingControl,initialVal:initialVal},
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

            function enableSaveControlEffectiveness(){
                if((document.getElementById('controlEffectiveness').value != `<?php    echo    $risk_details['ContrEffectv'];    ?>`) & (document.getElementById('controlEffectiveness').value != "Select Effectiveness")){
                    document.getElementById('saveRiskControlEffectiveness').disabled = false;
                }else{
                    document.getElementById('saveRiskControlEffectiveness').disabled = true;
                }
            }

            $('#saveRiskControlEffectiveness').click(function(){
                var controlEffectiveness = document.getElementById('controlEffectiveness').value;
                var initialVal = `<?php    echo    $risk_details['ContrEffectv'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Control-Effectiveness.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,controlEffectiveness:controlEffectiveness,initialVal:initialVal},
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

            function setEvaluationRiskLevel(){
                var likelyhood = $.trim($('#evaluationLikelyhoodLevel').val());
                var impact = $.trim($('#evaluationImpactLevel').text());
                $('#evaluationRiskLevel').removeClass('text-danger');
                if(likelyhood == 'Almost Certain'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#evaluationRiskLevel').text('Moderate');
                    }else if(impact == 'Moderate'){
                        $('#evaluationRiskLevel').text('High');
                    }else if(impact == 'Major'){
                        $('#evaluationRiskLevel').text('Significant');
                    }else if(impact == 'Catastropic'){
                        $('#evaluationRiskLevel').text('Extreme');
                    }
                }else if(likelyhood == 'Likely'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#evaluationRiskLevel').text('Moderate');
                    }else if(impact == 'Moderate'){
                        $('#evaluationRiskLevel').text('High');
                    }else if(impact == 'Major' | impact == 'Catastropic'){
                        $('#evaluationRiskLevel').text('Significant');
                    }
                }else if(likelyhood == 'Moderate'){
                    if(impact == 'Insignificant'){
                        $('#evaluationRiskLevel').text('Low');
                    }else if(impact == 'Minor'){
                        $('#evaluationRiskLevel').text('Moderate');
                    }else if(impact == 'Moderate' | impact == 'Major'){
                        $('#evaluationRiskLevel').text('High');
                    }else if(impact == 'Catastropic'){
                        $('#evaluationRiskLevel').text('Significant');
                    }
                }else if(likelyhood == 'Unlikely'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#evaluationRiskLevel').text('Low');
                    }else if(impact == 'Moderate'){
                        $('#evaluationRiskLevel').text('Moderate');
                    }else if(impact == 'Major' | impact == 'Catastropic'){
                        $('#evaluationRiskLevel').text('High');
                    }
                }else if(likelyhood == 'Rare'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#evaluationRiskLevel').text('Low');
                    }else if(impact == 'Moderate' | impact == 'Major'){
                        $('#evaluationRiskLevel').text('Moderate');
                    }else if(impact == 'Catastropic'){
                        $('#evaluationRiskLevel').text('High');
                    }
                }
            }

            function enableSaveRiskEvaluationLikelyhoodLevel(){
                if((document.getElementById('evaluationLikelyhoodLevel').value != `<?php    echo    $risk_details['reslikelyhoodLevel'];    ?>`) & (document.getElementById('evaluationLikelyhoodLevel').value != "Select Likelyhood Level")){
                    document.getElementById('saveRiskEvaluationLikelyhoodLevel').disabled = false;
                    setEvaluationRiskLevel();
                }else{
                    document.getElementById('saveRiskEvaluationLikelyhoodLevel').disabled = true;
                    if(document.getElementById('evaluationLikelyhoodLevel').value == `<?php    echo    $risk_details['likelyhoodLevel'];    ?>`){
                        $('#evaluationRiskLevel').removeClass('text-danger');
                        setEvaluationRiskLevel();
                    }else if(document.getElementById('evaluationLikelyhoodLevel').value == "Select Likelyhood Level"){
                        $('#evaluationRiskLevel').addClass('text-danger');
                        $('#evaluationRiskLevel').text('Please select likelyhood level');
                    }
                }
            }

            $('#saveRiskEvaluationLikelyhoodLevel').click(function(){
                var likelyhoodLevel = document.getElementById('evaluationLikelyhoodLevel').value;
                var riskLevel = $.trim($('#evaluationRiskLevel').text());
                var initialVal = `<?php    echo    $risk_details['reslikelyhoodLevel'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "UEdit-Risk-Evaluation-Likelyhood-Level.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,likelyhoodLevel:likelyhoodLevel,riskLevel:riskLevel,initialVal:initialVal},
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

            function setEvaluationImpactRiskLevel(){
                var likelyhood = $.trim($('#evaluationImpactLikelyhoodLevel').text());
                var impact = $.trim($('#evaluationImpactImpactLevel').val());
                $('#evaluationImpactRiskLevel').removeClass('text-danger');
                if(likelyhood == 'Almost Certain'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#evaluationImpactRiskLevel').text('Moderate');
                    }else if(impact == 'Moderate'){
                        $('#evaluationImpactRiskLevel').text('High');
                    }else if(impact == 'Major'){
                        $('#evaluationImpactRiskLevel').text('Significant');
                    }else if(impact == 'Catastropic'){
                        $('#evaluationImpactRiskLevel').text('Extreme');
                    }
                }else if(likelyhood == 'Likely'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#evaluationImpactRiskLevel').text('Moderate');
                    }else if(impact == 'Moderate'){
                        $('#evaluationImpactRiskLevel').text('High');
                    }else if(impact == 'Major' | impact == 'Catastropic'){
                        $('#evaluationImpactRiskLevel').text('Significant');
                    }
                }else if(likelyhood == 'Moderate'){
                    if(impact == 'Insignificant'){
                        $('#evaluationImpactRiskLevel').text('Low');
                    }else if(impact == 'Minor'){
                        $('#evaluationImpactRiskLevel').text('Moderate');
                    }else if(impact == 'Moderate' | impact == 'Major'){
                        $('#evaluationImpactRiskLevel').text('High');
                    }else if(impact == 'Catastropic'){
                        $('#evaluationImpactRiskLevel').text('Significant');
                    }
                }else if(likelyhood == 'Unlikely'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#evaluationImpactRiskLevel').text('Low');
                    }else if(impact == 'Moderate'){
                        $('#evaluationImpactRiskLevel').text('Moderate');
                    }else if(impact == 'Major' | impact == 'Catastropic'){
                        $('#evaluationImpactRiskLevel').text('High');
                    }
                }else if(likelyhood == 'Rare'){
                    if(impact == 'Insignificant' | impact == 'Minor'){
                        $('#evaluationImpactRiskLevel').text('Low');
                    }else if(impact == 'Moderate' | impact == 'Major'){
                        $('#evaluationImpactRiskLevel').text('Moderate');
                    }else if(impact == 'Catastropic'){
                        $('#evaluationImpactRiskLevel').text('High');
                    }
                }
            }

            function enableSaveRiskEvaluationImpactLevel(){
                if((document.getElementById('evaluationImpactImpactLevel').value != `<?php    echo    $risk_details['resimpactLevel'];    ?>`) & (document.getElementById('evaluationImpactImpactLevel').value != "Select Impact Level")){
                    document.getElementById('saveRiskEvaluationImpactLevel').disabled = false;
                    setEvaluationImpactRiskLevel();
                }else{
                    document.getElementById('saveRiskEvaluationImpactLevel').disabled = true;
                    if(document.getElementById('evaluationImpactImpactLevel').value == `<?php    echo    $risk_details['resimpactLevel'];    ?>`){
                        $('#evaluationImpactRiskLevel').removeClass('text-danger');
                        setEvaluationImpactRiskLevel();
                    }else if(document.getElementById('evaluationImpactImpactLevel').value == "Select Impact Level"){
                        $('#evaluationImpactRiskLevel').addClass('text-danger');
                        $('#evaluationImpactRiskLevel').text('Please select likelyhood level');
                    }
                }
            }

            $('#saveRiskEvaluationImpactLevel').click(function(){
                var impactLevel = document.getElementById('evaluationImpactImpactLevel').value;
                var riskLevel = $.trim($('#evaluationImpactRiskLevel').text());
                var initialVal = `<?php    echo    $risk_details['resimpactLevel'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Evaluation-Impact-Level.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,impactLevel:impactLevel,riskLevel:riskLevel,initialVal:initialVal},
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

            function enableSaveRiskResponse(){
                if((document.getElementById('riskResponse').value != `<?php    echo    $risk_details['riskResponse'];    ?>`) & (document.getElementById('riskResponse').value != "Select Risk Response")){
                    document.getElementById('saveRiskResponse').disabled = false;
                }else{
                    document.getElementById('saveRiskResponse').disabled = true;
                }
            }

            $('#saveRiskResponse').click(function(){
                var riskResponse = document.getElementById('riskResponse').value;
                var initialVal = `<?php    echo    $risk_details['riskResponse'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Risk-Response.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,riskResponse:riskResponse,initialVal:initialVal},
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

            function enableSaveAddRiskActivity(){
                if(document.getElementById('addRiskActivity').value != ""){
                    document.getElementById('saveAddRiskActivity').disabled = false;
                }else{
                    document.getElementById('saveAddRiskActivity').disabled = true;
                }
            }

            $('#saveAddRiskActivity').click(function(){
                var addRiskActivity = document.getElementById('addRiskActivity').value;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Add-Risk-Activity.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,addRiskActivity:addRiskActivity},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Added");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                        }
                    }
                })
            });

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

            function enableSaveChangeRiskDeadline(){
                if(document.getElementById('deadline').value != ""){
                    document.getElementById('saveChangeRiskDeadline').disabled = false;
                }else{
                    document.getElementById('saveChangeRiskDeadline').disabled = true;
                }
            }

            $('#saveChangeRiskDeadline').click(function(){
                var deadline = document.getElementById('deadline').value;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Change-Risk-Deadline.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,deadline:deadline},
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

            function enableSaveMitigationEffectiveness(){
                if((document.getElementById('mitigationEffectiveness').value != `<?php    echo    $risk_details['Effectiveness'];    ?>`) & (document.getElementById('mitigationEffectiveness').value != "Select Effectiveness")){
                    document.getElementById('saveRiskMitigationEffectiveness').disabled = false;
                }else{
                    document.getElementById('saveRiskMitigationEffectiveness').disabled = true;
                }
            }

            $('#saveRiskMitigationEffectiveness').click(function(){
                var mitigationEffectiveness = document.getElementById('mitigationEffectiveness').value;
                var initialVal = `<?php    echo    $risk_details['Effectiveness'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Mitigation-Effectiveness.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,mitigationEffectiveness:mitigationEffectiveness,initialVal:initialVal},
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

            function enableSaveRiskCurrentStatus(){
                if((document.getElementById('riskCurrentStatus').value != `<?php    echo    $risk_details['currentStatus'];    ?>`) & (document.getElementById('riskCurrentStatus').value != "Select Current Status")){
                    document.getElementById('saveRiskCurrentStatus').disabled = false;
                }else{
                    document.getElementById('saveRiskCurrentStatus').disabled = true;
                }
            }

            $('#saveRiskCurrentStatus').click(function(){
                var riskCurrentStatus = document.getElementById('riskCurrentStatus').value;
                var initialVal = `<?php    echo    $risk_details['currentStatus'];    ?>`;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Edit-Risk-Current-Status.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,riskCurrentStatus:riskCurrentStatus,initialVal:initialVal},
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

            function enableSaveAddRiskAction(){
                if(document.getElementById('addRiskAction').value != ""){
                    document.getElementById('saveAddRiskAction').disabled = false;
                }else{
                    document.getElementById('saveAddRiskAction').disabled = true;
                }
            }

            $('#saveAddRiskAction').click(function(){
                var addRiskAction = document.getElementById('addRiskAction').value;
                var indexRisk = `<?php   echo    $riskIndex; ?>`;
                var empNo = `<?php   echo    $userDetails['empNo'];   ?>`;
                $.ajax({
                    url: "Add-Risk-Action.php",
                    method: "POST",
                    data: {empNo:empNo,indexRisk:indexRisk,addRiskAction:addRiskAction},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Added");
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