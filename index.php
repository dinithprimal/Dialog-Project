<?php
    include("database.php");

    $err = '';

    session_start();

    if(isset($_SESSION['user'])){
        header("location: want-to-logout.php");
    }

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username != "" | $password != ""){
            $query = "select role, activeStatus from user_details WHERE Username='".$username."' AND Password='".$password."'";
            $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
            $count = mysqli_num_rows($result);
            if($count == 1){
                $role = mysqli_fetch_array($result);
                if($role['activeStatus'] == 0){
                    if($role['role'] == 'Admin'){
                        $_SESSION["user"] = $username;
                        header("location: Admin/index.php");
                    }else if($role['role'] == 'User'){
                        $_SESSION["user"] = $username;
                        header("location: User/index.php");
                    }
                }else{
                    $err = "<div class='alert alert-danger text-center text-danger' role='alert'>Your account has been deactivated. Please contact admin..!</div>";
                }
            }else{
                $err = "<div class='alert alert-danger text-center text-danger' role='alert'>Invalied username or password..!</div>";
            }
        }else{
            $err = "<div class='alert alert-danger text-center text-danger' role='alert'>Please enter username and password for login</div>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <link rel="title icon" href="images/title-img2.jpg">

        <link rel="stylesheet" href="CSS/CSS-Login.css">
        <link rel="stylesheet" href="bootstrap-5.0.0/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap-5.0.0/css/font-awesome.css">
        
        <title>Login - Risk Register Management System</title>
    </head>
    <body class="container-fluid bg">
        <h2 class="text-center pt-5" style="color: white;">Risk Register Management System</h2>
        <div class="row">
            <div class="col-xl-4 col-lg-3 col-md-2 col-sm-12"></div>
            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12">
                <form class="form" action="index.php" method="POST">
                    <?= $err ; ?>
                    <h3>Login Here</h3>
                    <div class="form-group mt-5">
                        <label for="username">Username</label>
                        <input data-bs-toggle="tooltip" title="Enter your username here..." type="username" class="form-control" name="username" id="username" aria-describedby="usernameHelp">
                    </div>
                    <div class="form-group mt-3">
                        <label for="password">Password</label>
                        <input data-bs-toggle="tooltip"  title="Enter your password here..." type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group mt-2">
                        <a href="forgetPassword.php" class="text-info"><small class="text-info">Forgot password..?</label></small></a>
                    </div>
                    <div align="center" class="form-group mt-2">
                        <input type="submit" data-bs-toggle="tooltip" title="Click to login" name="submit" class="btn btn-success btn-block mt-5" value="Login" />
                    </div>
                </form>
            </div>
            <div class="col-xl-4 col-lg-3 col-md-2 col-sm-12"></div>
        </div>

        <script type="text/javascript"></script>
            

        <script src="bootstrap-5.0.0/js/popper.js"></script>
        <script src="bootstrap-5.0.0/bootstrap.bundle.min.js"></script>
        <script src="bootstrap-5.0.0/js/bootstrap.js"></script>
        
    </body>
</html>