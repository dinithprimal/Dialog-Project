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
        <title>Add New User - Risk Register Management System</title>
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
                                    text-uppercase mb-0">Add New User</h4>
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
                                <h4 align="center">New User Registration</h4>
                                <br>
                                <div class="row row-cols-1 g-1 g-lg-2 mb-2">
                                    <div class="col">
                                        <div class="p-0">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-body p-3">
                                                    <div class="form-control p-3 mb-3">
                                                        <div class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                <label>First Name <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" name="firstName" id="firstName" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_firstName" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Last Name <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" name="lastName" id="lastName" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_lastName" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Employee ID <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" name="empNo" id="empNo" onfocusout="remmoveError(this)" class="form-control" style="width: 50%;" />
                                                                <small><small><span id="error_empNo" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Email <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" name="email" id="email" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_email" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Role <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="role" id="role" class="form-control form-select" onchange="remmoveErrorRole(this)" aria-label="Default select example" style="width: 50%;">
                                                                    <option selected class="text-muted">Select Role</option>
                                                                    <option>Admin</option>
                                                                    <option>User</option>
                                                                </select>
                                                                <small><small><span id="error_role" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Division <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="division" id="division" class="form-control form-select" onfocusout="remmoveError(this)" aria-label="Default select example" style="width: 70%;">
                                                                    <option selected class="text-muted">Select Division</option>
                                                                    <option>Access Planning</option>
                                                                    <option>Broadband Planning</option>
                                                                    <option>CFSS</option>
                                                                    <option>Core Network Planning</option>
                                                                    <option>Cyber Security</option>
                                                                    <option>Data Center & Power Systems</option>
                                                                    <option>DE-TAC</option>
                                                                    <option>Digital Transformation</option>
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
                                                                    <option>Tele-Infra</option>
                                                                    <option>TNP</option>
                                                                    <option>TSC</option>
                                                                </select>
                                                                <small><small><span id="error_division" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Unit <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" name="unit" id="unit" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_unit" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-3">
                                                            <div class="col-4">
                                                                <label>Category <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <select name="category" id="category" class="form-control form-select" onchange="remmoveErrorCategory(this)" aria-label="Default select example" style="width: 50%;">
                                                                    <option selected class="text-muted">Select Category</option>
                                                                    <option>Head</option>
                                                                    <option>Member</option>
                                                                </select>
                                                                <small><small><span id="error_category" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div align="center">
                                                        <button type="button" name="cancel" id="cancel" class="btn btn-secondary mx-1 btn-md">Cancel</button>
                                                        <button type="button" name="save" id="save" class="btn btn-info mx-1 btn-md">Save</button>
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

            function remmoveError(out){
                if($.trim($(out).val()).length != 0){
                    $(out).removeClass('has-error');
                    var id = $(out).attr("id");
                    $('#error_'+id+'').text('');
                }
            }

            function remmoveErrorRole(RC){
                if($.trim($(RC).val()) != 'Select Role'){
                    $(RC).removeClass('has-error');
                    var id = $(RC).attr("id");
                    $('#error_'+id+'').text('');
                }
            }

            function remmoveErrorCategory(RC){
                if($.trim($(RC).val()) != 'Select Category'){
                    $(RC).removeClass('has-error');
                    var id = $(RC).attr("id");
                    $('#error_'+id+'').text('');
                }
            }
            
            $('#cancel').click(function(){

                $('#error_firstName').text("");
                $('#firstName').removeClass('has-error');
                document.getElementById('firstName').value = '';

                $('#error_lastName').text("");
                $('#lastName').removeClass('has-error');
                document.getElementById('lastName').value = '';

                $('#error_empNo').text("");
                $('#empNo').removeClass('has-error');
                document.getElementById('empNo').value = '';

                $('#error_email').text("");
                $('#email').removeClass('has-error');
                document.getElementById('email').value = '';

                $('#error_role').text("");
                $('#role').removeClass('has-error');
                document.getElementById('role').value = 'Select Role';

                $('#error_division').text("");
                $('#division').removeClass('has-error');
                document.getElementById('division').value = '';

                $('#error_unit').text("");
                $('#unit').removeClass('has-error');
                document.getElementById('unit').value = '';

                $('#error_category').text("");
                $('#category').removeClass('has-error');
                document.getElementById('category').value = 'Select Category';

            }); 

            $('#save').click(function(){
                var error_firstName = '';
                var error_lastName = '';
                var error_empNo = '';
                var error_email = '';
                var error_role = '';
                var error_division = '';
                var error_unit = '';
                var error_category = '';

                if($.trim($('#firstName').val()).length == 0){
                    error_firstName = 'First Name is Required';
                    $('#error_firstName').text(error_firstName);
                    $('#firstName').addClass('has-error');
                }else{
                    error_firstName = '';
                    $('#error_firstName').text(error_firstName);
                    $('#firstName').removeClass('has-error');
                }

                if($.trim($('#lastName').val()).length == 0){
                    error_lastName = 'Last Name is Required';
                    $('#error_lastName').text(error_lastName);
                    $('#lastName').addClass('has-error');
                }else{
                    error_lastName = '';
                    $('#error_lastName').text(error_lastName);
                    $('#lastName').removeClass('has-error');
                }

                if($.trim($('#empNo').val()).length == 0){
                    error_empNo = 'Employee ID is Required';
                    $('#error_empNo').text(error_empNo);
                    $('#empNo').addClass('has-error');
                }else{
                    error_empNo = '';
                    $('#error_empNo').text(error_empNo);
                    $('#empNo').removeClass('has-error');
                }

                if($.trim($('#email').val()).length == 0){
                    error_email = 'Email is Required';
                    $('#error_email').text(error_email);
                    $('#email').addClass('has-error');
                }else{
                    error_email = '';
                    $('#error_email').text(error_email);
                    $('#email').removeClass('has-error');
                }

                if($.trim($('#role').val()) == 'Select Role'){
                    error_role = 'Role is Required';
                    $('#error_role').text(error_role);
                    $('#role').addClass('has-error');
                }else{
                    error_role = '';
                    $('#error_role').text(error_role);
                    $('#role').removeClass('has-error');
                }

                if($.trim($('#division').val()).length == 'Select Division'){
                    error_division = 'Division is Required';
                    $('#error_division').text(error_division);
                    $('#division').addClass('has-error');
                }else{
                    error_division = '';
                    $('#error_division').text(error_division);
                    $('#division').removeClass('has-error');
                }

                if($.trim($('#unit').val()).length == 0){
                    error_unit = 'Unit is Required';
                    $('#error_unit').text(error_unit);
                    $('#unit').addClass('has-error');
                }else{
                    error_unit = '';
                    $('#error_unit').text(error_unit);
                    $('#unit').removeClass('has-error');
                }

                if($.trim($('#category').val()) == 'Select Category'){
                    error_category = 'Category is Required';
                    $('#error_category').text(error_category);
                    $('#category').addClass('has-error');
                }else{
                    error_category = '';
                    $('#error_category').text(error_category);
                    $('#category').removeClass('has-error');
                }

                if(error_firstName != '' | error_lastName != '' | error_empNo != '' | error_email != '' | error_role != '' | error_division != '' | error_unit != '' | error_category != ''){
                    return false;
                }else{

                    $("#save").html("Saving");
                    document.getElementById('save').disabled = true;
                    document.body.style.cursor = 'wait';

                    var firstName = $.trim($('#firstName').val());
                    var lastName = $.trim($('#lastName').val());
                    var empNo = $.trim($('#empNo').val());
                    var email = $.trim($('#email').val());
                    var role = $.trim($('#role').val());
                    var division = $.trim($('#division').val());
                    var unit = $.trim($('#unit').val());
                    var category = $.trim($('#category').val());

                    $.ajax({
                        url: "Add-User.php",
                        method: "POST",
                        data: { 
                            firstName:firstName,
                            lastName:lastName,
                            empNo:empNo,
                            email:email,
                            role:role,
                            division:division,
                            unit:unit,
                            category:category
                        },
                        dataType: "text",
                        success: function(data){
                            alert(data);
                            if(data == 'true'){
                                alert("Successfully Saved!");
                                location.reload();
                            }else if(data == 'duplicate'){
                                alert("Employee ID or Email is duplicate..! Please check and resubmit...");
                                $("#save").html("Save");
                                document.getElementById('save').disabled = false;
                                document.body.style.cursor = 'auto';
                            }else{
                                alert("Something went wrong..! Please check and resubmit...");
                                location.reload();
                            }
                            //$("#settingsDiv").submit();
                        }
                    });
                }
            });

        </script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="../../bootstrap-5.0.0/js/popper.js"></script>
        <script src="../../bootstrap-5.0.0/js/bootstrap.js"></script>
    </body>
</html>