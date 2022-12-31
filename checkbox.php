<?php 
    session_start();
    include 'db.php';

    if(isset($conn)){
        echo "supersmelly";
    }

    echo 'we out here';
    print_r($_POST['name']);
    if(isset($_POST['name'])){
        echo "isset";
    } else{
        echo 'lame';
    }

    if($_POST['name'] == "delete0"){
        echo 'delete';
    }
    if($_POST['name'] == "create0"){
        echo 'create';
    }
    if($_POST['name'] == "update0"){
        echo 'update';
    }


?>