<?php

    include("../database.php");

    date_default_timezone_set("Asia/Colombo");

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

    if($userDetails['category']!="Head"){
        echo '<script type="text/javascript">alert("Oops..! Something went wrong...");</script>';
        echo "<script>location.href='Home.php'</script>";
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
        <title>Programs - Risk Register Management System</title>
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
                                current"><i 
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
                                    text-uppercase mb-0">Programs</h4>
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
                            <?php
                                $sqlInfoProg = "SELECT COUNT(*) AS progTot FROM divinfogather WHERE status = 0 AND division = '$department'";
                                $resultInfoProg = mysqli_query($conn,$sqlInfoProg) or die(mysqli_error($conn));
                                $detailsInfoProg = mysqli_fetch_array($resultInfoProg);
                                $countInfoProg = $detailsInfoProg['progTot'];

                                $sqlProgDetails = "SELECT * FROM divinfogather WHERE status = 0 AND division = '$department'";
                                $resultProgDetails = mysqli_query($conn,$sqlProgDetails) or die(mysqli_error($conn));
                                $detailsProgDetails = mysqli_fetch_array($resultProgDetails);

                                if($countInfoProg == 1){
                            ?>
                                <div class="row g-1 g-lg-2">
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-header">
                                                    <small><?php    echo    $detailsProgDetails['Name'];  ?></small>
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
                                                                            $value = $detailsProgDetails['startDate'];
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
                                                                        <small><small><label>Due Date / Time </label></small></small>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <small><small><label style="float: right;">
                                                                        <?php
                                                                            $valueEnd = $detailsProgDetails['endDate'];
                                                                            $end_datetime = new DateTime($valueEnd);
                                                                            echo    $end_datetime->format("l, d F Y, h:i A");
                                                                        ?>
                                                                        </label></small></small>
                                                                    </div>
                                                                    <div class="col-3">
                                                                    </div>
                                                                </div>
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
                                                                                Time Remaining :
                                                                        <?php
                                                                            }else{
                                                                        ?>
                                                                                Overdue By :
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
                                                            </div>
                                                            <div class="col-4">
                                                                <button type="button" name="btn_end" id="btn_end" style="float: right;" class="btn btn-danger mx-1 btn-md px-5" <?php   if($end_datetime > $now){   echo    "disabled"; }   ?>>End This Program</button>
                                                                <a href="View-Program.php?id=<?php  echo    $detailsProgDetails['idInfo']; ?>" style="float: right;" class="btn btn-info btn-md" tabindex="-1" role="button">View Details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }else{
                            ?>
                                <div class="row g-1 g-lg-2">
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-header">
                                                    <small>Start Information Gather Programs</small>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-control p-3 mb-3">
                                                        <div class="row d-flex justify-content-between align-items-center mt-2">
                                                            <div class="col-4">
                                                                <label>Name <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" name="name" id="name" onfocusout="remmoveError(this)" class="form-control" />
                                                                <small><small><span id="error_name" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-between align-items-center mt-2">
                                                            <div class="col-4">
                                                                <label>End Date / Time <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="datetime-local" name="deadline" id="deadline" onfocusout="remmoveErrorDt(this)" class="form-control" style="width: 60%;"/>
                                                                <small><small><span id="error_deadline" class="text-danger"></span></small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div align="center">
                                                        <button type="button" name="btn_start" id="btn_start" class="btn btn-primary mx-1 btn-md px-5">Start</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                                <div class="row g-1 g-lg-2">
                                    <div class="col">
                                        <div class="p-1">
                                            <div class="card" style="width: auto; height: auto;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Previous Information Gather Programs</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted"><small>Shown all previous information gather programs</small></h6>
                                                    <br>
                                                    <div class="d-grid gap-2">
                                                        <div class="table-responsive d-flex" style="height: 360px; width:100%; overflow: auto; overflow-x: auto; overflow-y: auto;">
                                                            <table class="table table-sm table-striped table-hover" style="width:100%; min-width:1100px">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col"><small><small>#</small></small></th>
                                                                        <th scope="col"><small><small>Program Name</small></small></th>
                                                                        <th scope="col"><small><small>Start Date / Time</small></small></th>
                                                                        <th scope="col"><small><small>End Date / Time</small></small></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        $sqlAllProgDetails = "SELECT * FROM divinfogather WHERE status = 1 AND division = '$department'";
                                                                        $resultAllProgDetails = mysqli_query($conn,$sqlAllProgDetails) or die(mysqli_error($conn));
                                                                        $countAllDetailsProgDetails = mysqli_num_rows($resultAllProgDetails);
                                                                        if($countAllDetailsProgDetails>0){
                                                                            $count = 1;
                                                                            while($allDetailsProgDetails = mysqli_fetch_array($resultAllProgDetails)){
                                                                    ?>
                                                                    <tr>
                                                                        <td scope="row"><small><small><?php   echo    $count;  ?></small></small></td>
                                                                        <td><small><small><a href="View-Program.php?id=<?php  echo    $allDetailsProgDetails['idInfo']; ?>"><?php   echo    $allDetailsProgDetails['Name'];  ?></a></small></small></td>
                                                                        <td><small><small><?php   echo    $allDetailsProgDetails['startDate'];  ?></small></small></td>
                                                                        <td><small><small><?php   echo    $allDetailsProgDetails['endDate'];  ?></small></small></td>
                                                                    </tr>
                                                                    <?php
                                                                            }
                                                                        }else{
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="4" class="text-danger" style="text-align:center"><small><small>No Previous Programs to View</small></small></td>
                                                                    </tr>
                                                                    <?php
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

            $('#btn_start').click(function(){
                var error_name = '';
                var error_deadline = '';

                if($.trim($('#name').val()).length == 0){
                    error_name = 'Name is Required';
                    $('#error_name').text(error_name);
                    $('#name').addClass('has-error');
                }else{
                    error_name = '';
                    $('#error_name').text(error_name);
                    $('#name').removeClass('has-error');
                }

                if($.trim($('#deadline').val()) == ''){
                    error_deadline = 'Deadline is Required';
                    $('#error_deadline').text(error_deadline);
                    $('#deadline').addClass('has-error');
                }else{
                    error_deadline = '';
                    $('#error_deadline').text(error_deadline);
                    $('#deadline').removeClass('has-error');
                }

                if(error_name != '' | error_deadline != ''){
                    return false;
                }else{
                    $("#btn_start").html("Sending Data...");
                    document.getElementById('btn_start').disabled = true;
                    document.body.style.cursor = 'wait';
                    var deadline = $.trim($('#deadline').val());
                    var name = $.trim($('#name').val());
                    var division = "<?php   echo    $department;    ?>";
                    $.ajax({
                        url: "Start-Info-Program.php",
                        method: "POST",
                        data: { 
                            deadline:deadline,
                            division:division,
                            name:name,
                        },
                        dataType: "text",
                        success: function(data){
                            if(data == 'True'){
                                alert("Successfully Started!");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please check and resubmit...");
                                location.reload();
                            }
                        }
                    });
                }
            });

            $('#btn_end').click(function(){
                $("#btn_end").html("Ending This Program...");
                document.getElementById('btn_end').disabled = true;
                document.body.style.cursor = 'wait';
                var idInfoProg = "<?php   echo  $detailsProgDetails['idInfo']; ?>";
                var division = "<?php   echo    $department;    ?>";
                $.ajax({
                    url: "End-Info-Program.php",
                    method: "POST",
                    data: {idInfoProg:idInfoProg,division:division},
                    dataType: "text",
                    success: function(data){
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

        </script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="../../bootstrap-5.0.0/js/popper.js"></script>
        <script src="../../bootstrap-5.0.0/js/bootstrap.js"></script>
    </body>
</html>