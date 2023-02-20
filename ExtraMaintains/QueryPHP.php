<?php
    include("../database.php");

    // $query = "SELECT email FROM user_details WHERE empNo IN (SELECT reporter FROM risk WHERE indexRisk = 'TR0266' UNION SELECT empNo FROM riskowners WHERE indexRisk = 'TR0266' UNION SELECT empNo FROM actionowners WHERE indexRisk = 'TR0266')";
    // $resultEmails = mysqli_query($conn,$query) or die(mysqli_error($conn));
    // while($userName = mysqli_fetch_array($resultEmails)){
    //     echo    "".$userName['email']."/\n";
    // }
?>