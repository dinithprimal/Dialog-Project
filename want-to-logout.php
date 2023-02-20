<?php
    include("database.php");

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
            echo "<script>location.href='index.php'</script>";
        }
    }
    $_SESSION['lastaccess'] = time();
    //Session timeout function over

    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
    }else{
        session_destroy();
        unset($_SESSION["user"]);
        echo "<script>location.href='index.php'</script>";
    }

    if(isset($_POST['cancel'])){
        $query = "select role from user_details WHERE Username='".$username."'";
        $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        if($count == 1){
            $role = mysqli_fetch_array($result);
            if($role['role'] == 'Admin'){
                $_SESSION["user"] = $username;
                header("location: Admin/index.php");
            }else if($role['role'] == 'User'){
                $_SESSION["user"] = $username;
                header("location: User/index.php");
            }
        }
    }

    if(isset($_POST['logout'])){
        session_destroy();
        unset($_SESSION["user"]);
        echo "<script>location.href='index.php'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="title icon" href="images/title-img2.jpg">

        <link rel="stylesheet" href="CSS/CSS-Login.css">
        <link rel="stylesheet" href="bootstrap-5.0.0/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap-5.0.0/css/font-awesome.css">

        <script src="bootstrap-5.0.0/js/bootstrap-jquery.js"></script>
        <script src="bootstrap-5.0.0/js/bootstrap.js"></script>
        <script src="bootstrap-5.0.0/js/popper.js"></script>
        <title>Want to Logout? - Risk Registry Management System</title>
    </head>
    <body class="container-fluid bg">
        <h2 class="text-center pt-5" style="color: white;">Risk Registry Management System</h2>
        <div class="row">
            <div class="col-xl-4 col-lg-3 col-md-2 col-sm-1"></div>
            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-10">
                <h3 class="mt-5 pt-5">Want to logout?</h3>
                <form action="want-to-logout.php" method="POST">
                    <div class="row mt-5 pt-5">
                        <div class="col" align="center">
                            <button type="submit" name="cancel" class="btn btn-success btn-lg" style="width:150px;">Cancel</button>
                        </div>
                        <div class="col" align="center">
                            <button type="submit" name="logout" class="btn btn-danger btn-lg" style="width:150px;">Logout</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-4 col-lg-3 col-md-2 col-sm-1"></div>
        </div>
    </body>
</html>