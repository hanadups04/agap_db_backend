<?php
    $conn = mysqli_connect("localhost", "root", "", "agap_admin_db");

    if(!$conn){
        die("connection failed: " . mysqli_connect_error());
    } 
    else {
        //echo "Database connection established!";
    }
?>