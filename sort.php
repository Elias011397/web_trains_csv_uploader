<?php
    session_start();
    include 'db.php';
    if(isset($_POST['sort1'])){
        $sortQuery = "SELECT * FROM TRAIN_DATA ORDER BY TRAIN_LINE ASC";
        $sortedResults = mysqli_query($conn, $sortQuery);
        $sorted = array();
        while ($row= mysqli_fetch_array($sortedResults)) {
            $sorted[] = array(
            'line' => $row['TRAIN_LINE'],
            'name' => $row['ROUTE_NAME'],
            'number' => $row['RUN_NUMBER'],
            'id' => $row['OPERATOR_ID']
            );
        }
        mysqli_query($conn, "TRUNCATE TABLE TRAIN_DATA");
        foreach ($sorted as $row){
            mysqli_query($conn, "INSERT INTO TRAIN_DATA (TRAIN_LINE, ROUTE_NAME, RUN_NUMBER, OPERATOR_ID) VALUES ('" . $row['line'] . "', '" . $row['name'] . "', '" . $row['number'] . "', '" . $row['id'] . "')");
        }
        $_SESSION['isSorted'] = $sorted;
        header("Location: home.php?sortedtrain_lines");
    }
    if(isset($_POST['sort2'])){
        $sortQuery = "SELECT * FROM TRAIN_DATA ORDER BY ROUTE_NAME ASC";
        $sortedResults = mysqli_query($conn, $sortQuery);
        $sorted = array();
        while ($row= mysqli_fetch_array($sortedResults)) {
            $sorted[] = array(
            'line' => $row['TRAIN_LINE'],
            'name' => $row['ROUTE_NAME'],
            'number' => $row['RUN_NUMBER'],
            'id' => $row['OPERATOR_ID']
            );
        }
        mysqli_query($conn, "TRUNCATE TABLE TRAIN_DATA");
        foreach ($sorted as $row){
            mysqli_query($conn, "INSERT INTO TRAIN_DATA (TRAIN_LINE, ROUTE_NAME, RUN_NUMBER, OPERATOR_ID) VALUES ('" . $row['line'] . "', '" . $row['name'] . "', '" . $row['number'] . "', '" . $row['id'] . "')");
        }
        $_SESSION['isSorted'] = $sorted;
        header("Location: home.php?sortedroute_names");
    }
    if(isset($_POST['sort3'])){
        $sortQuery = "SELECT * FROM TRAIN_DATA ORDER BY RUN_NUMBER ASC";
        $sortedResults = mysqli_query($conn, $sortQuery);
        $sorted = array();
        while ($row= mysqli_fetch_array($sortedResults)) {
            $sorted[] = array(
            'line' => $row['TRAIN_LINE'],
            'name' => $row['ROUTE_NAME'],
            'number' => $row['RUN_NUMBER'],
            'id' => $row['OPERATOR_ID']
            );
        }
        mysqli_query($conn, "TRUNCATE TABLE TRAIN_DATA");
        foreach ($sorted as $row){
            mysqli_query($conn, "INSERT INTO TRAIN_DATA (TRAIN_LINE, ROUTE_NAME, RUN_NUMBER, OPERATOR_ID) VALUES ('" . $row['line'] . "', '" . $row['name'] . "', '" . $row['number'] . "', '" . $row['id'] . "')");
        }
        $_SESSION['isSorted'] = $sorted;
        header("Location: home.php?sortedrun_numbers");
    }
    if(isset($_POST['sort4'])){
        $sortQuery = "SELECT * FROM TRAIN_DATA ORDER BY OPERATOR_ID ASC";
        $sortedResults = mysqli_query($conn, $sortQuery);
        $sorted = array();
        while ($row= mysqli_fetch_array($sortedResults)) {
            $sorted[] = array(
            'line' => $row['TRAIN_LINE'],
            'name' => $row['ROUTE_NAME'],
            'number' => $row['RUN_NUMBER'],
            'id' => $row['OPERATOR_ID']
            );
        }
        mysqli_query($conn, "TRUNCATE TABLE TRAIN_DATA");
        foreach ($sorted as $row){
            mysqli_query($conn, "INSERT INTO TRAIN_DATA (TRAIN_LINE, ROUTE_NAME, RUN_NUMBER, OPERATOR_ID) VALUES ('" . $row['line'] . "', '" . $row['name'] . "', '" . $row['number'] . "', '" . $row['id'] . "')");
        }
        $_SESSION['isSorted'] = $sorted;
        header("Location: home.php?sortedoperator_ids");
    }

?>