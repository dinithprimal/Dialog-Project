<?php

    include("../database.php");

    require 'credential.php';

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
        $queryUserDetails = "SELECT idUser, fullName, role, empNo FROM user_details WHERE username = '$username'";
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
        <title>Settings - Risk Register Management System</title>
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
                                current"><i 
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
                                    text-uppercase mb-0">Settings</h4>
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

        <!-- Modal email -->
        <div class="modal fade" id="email" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Change Email Address</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <input type="text" class="form-control form-control-sm mb-2" name="emailAddress" id="emailAddress" onclick="enableSaveEamil();" onkeyup="enableSaveEamil()" value="<?php    echo    EMAIL;    ?>" />
                            <small><small><span id="error_emailAddress" class="text-danger mt-2"></span></small></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveChangeEmail" name="saveChangeEmail" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of email -->

        <!-- Modal password -->
        <div class="modal fade" id="password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><small>Change Email Password</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2 px-2">
                            <div class="col-6">
                                <label><small><small>Enter New Password :</small></small></label>
                            </div>
                            <div class="col-6">
                                <input type="password" class="form-control form-control-sm mb-2" name="emailPassword" id="emailPassword"  />
                            </div>
                        </div>
                        <div class="row mt-2 px-2">
                            <div class="col-6">
                                <label><small><small>Confirm Password :</small></small></label>
                            </div>
                            <div class="col-6">
                                <input type="password" class="form-control form-control-sm mb-2" name="emailPassword2" id="emailPassword2" onclick="enableSavePassword();" onkeyup="enableSavePassword();" />
                                <small><small><span id="error_emailPassword" class="text-danger mt-2"></span></small></small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveChangePassword" name="saveChangePassword" class="btn btn-sm btn-primary" disabled>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of password -->

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
                                    <div class="col">
                                            <div class="p-1">
                                                <div class="card" style="width: auto;">
                                                    <div class="card-body">
                                                        <h5 class="card-title">System Email</h5>
                                                        <h6 class="card-subtitle mb-2 text-muted"><small>Make changes of system email and password</small></h6>
                                                        <br>
                                                        <div class="d-grid gap-2">
                                                            <div class="form-control p-3 mb-3">
                                                                <div class="row d-flex justify-content-between align-items-center">
                                                                    <div class="col-4">
                                                                        <label><small><small>Email Address :</small></small></label>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <label><small><small><b><?php   echo    EMAIL;  ?></b></small></small></label>
                                                                    </div>
                                                                    <div class="col-1">
                                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#email" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;">Edit</button>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center mt-3">
                                                                    <div class="col-4">
                                                                        <label><small><small>Password :</small></small></label>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <span><small><small>*************</small></small></span>
                                                                    </div>
                                                                    <div class="col-1">
                                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#password" type="button" style="padding: .25rem .4rem; font-size: .820rem; line-height: .95; border-radius: .2rem; display: inline;">Edit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div align="center">
                                                                <button type="button" name="sendTest" id="sendTest" class="btn btn-success mx-1 btn-md">Send Test Mail</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row mt-2">
                                    <div class="col">
                                            <div class="p-1">
                                                <div class="card" style="width: 100%;">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Remove Risks</h5>
                                                        <h6 class="card-subtitle mb-2 text-muted"><small>Remove risks form database (Once you delete, It can not recover again!)</small></h6>
                                                        <br>
                                                        <div class="d-grid gap-2">
                                                            <div class="form-control p-3 mb-3">
                                                                <div class="row d-flex justify-content-between align-items-center">
                                                                    <div class="col-4">
                                                                        <label><small><small>Risk Index :</small></small></label>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <small><small>
                                                                            <input type="text" class="form-control form-control-sm mb-2" name="riskIndex1" id="riskIndex1" onclick="enableRemoveRisk();" onkeyup="enableRemoveRisk();" style="width: 50%;"/>
                                                                            <small><small><span id="error_riskIndex1" class="text-danger mt-2"></span></small></small>
                                                                        </small></small>
                                                                    </div>
                                                                    <div class="col-1">
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-between align-items-center mt-3">
                                                                    <div class="col-4">
                                                                        <label><small><small>Retype Risk Index :</small></small></label>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <small><small>
                                                                            <input type="text" class="form-control form-control-sm mb-2" name="riskIndex2" id="riskIndex2" onclick="enableRemoveRisk();" onkeyup="enableRemoveRisk();" style="width: 50%;"/>
                                                                            <small><small><span id="error_riskIndex2" class="text-danger mt-2"></span></small></small>
                                                                        </small></small>
                                                                    </div>
                                                                    <div class="col-1">
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div align="center">
                                                                <button type="button" name="removeRisk" id="removeRisk" class="btn btn-danger mx-1 btn-md" disabled>Remove</button>
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

            function validateEmail(email) {
                const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }

            function enableSaveEamil(){
                error_emailAddress = '';
                if((document.getElementById('emailAddress').value == "<?php    echo    EMAIL;    ?>")){
                    document.getElementById('saveChangeEmail').disabled = true;
                }else if((document.getElementById('emailAddress').value == "")){
                    document.getElementById('saveChangeEmail').disabled = true;
                    error_emailAddress = 'Email Address is Required';
                    $('#error_emailAddress').text(error_emailAddress);
                    $('#emailAddress').addClass('has-error');
                }else if(!validateEmail(document.getElementById('emailAddress').value)){
                    document.getElementById('saveChangeEmail').disabled = true;
                    error_emailAddress = 'Please Enter Valied Email Address...';
                    $('#error_emailAddress').text(error_emailAddress);
                    $('#emailAddress').addClass('has-error');
                }else{
                    document.getElementById('saveChangeEmail').disabled = false;
                    error_emailAddress = '';
                    $('#error_emailAddress').text(error_emailAddress);
                    $('#emailAddress').removeClass('has-error');
                }
                
            }

            function enableSavePassword(){
                error_emailPassword = '';
                if(document.getElementById('emailPassword').value == "" | document.getElementById('emailPassword2').value == ""){
                    document.getElementById('saveChangePassword').disabled = true;
                    error_emailPassword = 'Both Fields are Required';
                    $('#error_emailPassword').text(error_emailPassword);
                    $('#error_emailPassword').addClass('text-danger');
                    $('#error_emailPassword').removeClass('text-success');
                    $('#emailPassword').addClass('has-error');
                    $('#emailPassword2').addClass('has-error');
                }else if((document.getElementById('emailPassword').value != document.getElementById('emailPassword2').value)){
                    document.getElementById('saveChangePassword').disabled = true;
                    error_emailPassword = 'Passwords are does not match';
                    $('#error_emailPassword').text(error_emailPassword);
                    $('#error_emailPassword').addClass('text-danger');
                    $('#error_emailPassword').removeClass('text-success');
                    $('#emailPassword').removeClass('has-error');
                    $('#emailPassword2').addClass('has-error');
                }else if((document.getElementById('emailPassword').value == document.getElementById('emailPassword2').value)){
                    document.getElementById('saveChangePassword').disabled = false;
                    error_emailPassword = 'Passwords are matched';
                    $('#error_emailPassword').text(error_emailPassword);
                    $('#error_emailPassword').removeClass('text-danger');
                    $('#error_emailPassword').addClass('text-success');
                    $('#emailPassword').removeClass('has-error');
                    $('#emailPassword2').removeClass('has-error');
                }
                
            }

            function enableRemoveRisk(){
                error_riskIndex1 = '';
                error_riskIndex2 = '';
                if(document.getElementById('riskIndex1').value == "" | document.getElementById('riskIndex2').value == ""){
                    document.getElementById('removeRisk').disabled = true;
                    error_emailPassword = 'Both Fields are Required';
                    $('#error_riskIndex1').text(error_emailPassword);
                    $('#error_riskIndex1').removeClass('text-success');
                    $('#error_riskIndex1').addClass('text-danger');
                    $('#error_riskIndex2').text(error_emailPassword);
                    $('#error_riskIndex2').removeClass('text-success');
                    $('#error_riskIndex2').addClass('text-danger');
                    $('#riskIndex1').addClass('has-error');
                    $('#riskIndex2').addClass('has-error');
                }else if((document.getElementById('riskIndex1').value != document.getElementById('riskIndex2').value)){
                    document.getElementById('removeRisk').disabled = true;
                    error_emailPassword = 'Risk index are does not match';
                    $('#error_riskIndex1').text(error_emailPassword);
                    $('#error_riskIndex1').removeClass('text-success');
                    $('#error_riskIndex1').addClass('text-danger');
                    $('#error_riskIndex2').text(error_emailPassword);
                    $('#error_riskIndex2').removeClass('text-success');
                    $('#error_riskIndex2').addClass('text-danger');
                    $('#riskIndex1').addClass('has-error');
                    $('#riskIndex2').addClass('has-error');
                }else if((document.getElementById('emailPassword').value == document.getElementById('emailPassword2').value)){
                    document.getElementById('removeRisk').disabled = false;
                    error_emailPassword = 'Matched';
                    $('#error_riskIndex1').text(error_emailPassword);
                    $('#error_riskIndex1').removeClass('text-danger');
                    $('#error_riskIndex1').addClass('text-success');
                    $('#error_riskIndex2').text(error_emailPassword);
                    $('#error_riskIndex2').removeClass('text-danger');
                    $('#error_riskIndex2').addClass('text-success');
                    $('#riskIndex1').removeClass('has-error');
                    $('#riskIndex2').removeClass('has-error');
                }
                
            }

            $('#saveChangeEmail').click(function(){
                var emailAddress = document.getElementById('emailAddress').value;
                $.ajax({
                    url: "Update-Email-Address.php",
                    method: "POST",
                    data: { 
                        emailAddress:emailAddress
                    },
                    dataType: "text",
                    success: function(data){
                        if(data == 'true'){
                            alert("Successfully Updated!");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please check and try again...");
                        }
                    }
                });
            });

            $('#saveChangePassword').click(function(){
                var emailPassword = document.getElementById('emailPassword').value;
                $.ajax({
                    url: "Update-Email-Password.php",
                    method: "POST",
                    data: { 
                        emailPassword:emailPassword
                    },
                    dataType: "text",
                    success: function(data){
                        if(data == 'true'){
                            alert("Successfully Updated!");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please check and try again...");
                        }
                    }
                });
            });

            $('#removeRisk').click(function(){
                var riskIndex = document.getElementById('riskIndex1').value;
                if(confirm("Are you sure you want to remove this risk - "+riskIndex+" ?")){
                    var riskIndex = document.getElementById('riskIndex1').value;
                    $.ajax({
                        url: "Remove-Risk.php",
                        method: "POST",
                        data: { 
                            riskIndex:riskIndex
                        },
                        dataType: "text",
                        success: function(data){
                            if(data == 'true'){
                                alert("Successfully Removed!");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please check and try again...");
                            }
                        }
                    });
                }else{
                    return false;
                }
            });

            $('#sendTest').click(function(){
                $("#sendTest").html("Sending Test Mail");
                document.getElementById('sendTest').disabled = true;
                document.body.style.cursor = 'wait';

                var empNo = "<?php    $empNo = $userDetails['empNo'];   echo    $empNo; ?>";
                $.ajax({
                    url: "Send-Test-Mail.php",
                    method: "POST",
                    data: { 
                        empNo:empNo
                    },
                    dataType: "text",
                    success: function(data){
                        if(data == 'true'){
                            alert("Successfully Sent!");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please check and resend...");
                            location.reload();
                        }
                    }
                });
            });

        </script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="../../bootstrap-5.0.0/js/popper.js"></script>
        <script src="../../bootstrap-5.0.0/js/bootstrap.js"></script>
    </body>
</html>