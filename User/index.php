<?php
    include("database.php");

    $err = '';

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
            echo "<script>location.href='../index.php'</script>";
        }
    }
    $_SESSION['lastaccess'] = time();
    //Session timeout function over

    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        $queryUserDetails = "SELECT idUser, fullName, role FROM user_details WHERE username = '$username'";
        $resultUserDetails = mysqli_query($conn,$queryUserDetails) or die(mysqli_error($conn));
        $userDetails = mysqli_fetch_array($resultUserDetails);
        if($userDetails['role']!="User"){
            session_destroy();
            unset($_SESSION["user"]);
            echo '<script type="text/javascript">alert("Oops..! Something went wrong. Please login again.");</script>';
            echo "<script>location.href='../index.php'</script>";
        }
    }else{
        session_destroy();
        unset($_SESSION["user"]);
        echo "<script>location.href='../index.php'</script>";
    }

    if(isset($_POST['central'])){
        header("location: Central/Home.php");
    }else if(isset($_POST['Divisional'])){
        header("location: Divisional/Home.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <link rel="title icon" href="../images/title-img2.jpg">

        <link rel="stylesheet" href="../CSS/CSS-Login.css">
        <link rel="stylesheet" href="../bootstrap-5.0.0/css/bootstrap.css">
        <link rel="stylesheet" href="../bootstrap-5.0.0/css/font-awesome.css">
        
        <title>Select Option - Admin - Risk Register Management System</title>
    </head>
    <body class="container-fluid bg">
        <h2 class="text-center pt-5" style="color: white;">Risk Register Management System</h2>
        <div class="row">
            <div class="col-xl-4 col-lg-3 col-md-2 col-sm-12"></div>
            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12">
                <form class="form" action="index.php" method="POST">
                    <?= $err ; ?>
                    <h3>Select Option Here</h3>
                    <div align="center" class="form-group mt-2">
                        <input type="submit" name="central" class="btn btn-secondary btn-block mt-5" value="ERM" style="width: 200px; height: 80px;" />
                    </div>
                    <div align="center" class="form-group mt-2">
                        <input type="submit" name="Divisional" class="btn btn-secondary btn-block mt-5" value="Divisional" style="width: 200px; height: 80px;" />
                    </div>
                </form>
            </div>
            <div class="col-xl-4 col-lg-3 col-md-2 col-sm-12"></div>
        </div>

        <script type="text/javascript"></script>
            

        <script src="../bootstrap-5.0.0/js/popper.js"></script>
        <script src="../bootstrap-5.0.0/js/bootstrap.bundle.min.js"></script>
        <script src="../bootstrap-5.0.0/js/bootstrap.js"></script>
        
    </body>
</html>