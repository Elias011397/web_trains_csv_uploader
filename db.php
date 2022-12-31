<?php

    $server = "sql104.epizy.com";
    $username = "epiz_32499480";
    $password = "qQVF1tRFjXZ8Nx";
    $dbname = "epiz_32499480_trains";

    $conn = mysqli_connect($server,$username,$password,$dbname);

    if(!$conn){
        die("Connection could not be established".mysqli_connect_error());
    }