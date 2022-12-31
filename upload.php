<?php
    session_start();
    include 'db.php';

if(isset($_SESSION['uploadedFile'])){
    mysqli_query($conn, "TRUNCATE TABLE TRAIN_DATA");
}
if(isset($_POST['submit'])){
    $file = $_FILES['file'];
    // records file info
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('csv');

    // verify correct file and file upload
    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 10000000){
                $newFileName = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'uploads/'.$newFileName;
                move_uploaded_file($fileTmpName, $fileDestination);
                $_SESSION['uploadedFile'] = $fileDestination;
                    if(isset($_SESSION['uploadedFile'])){

                    // Open uploaded CSV file with read-only mode
                    $csvOpen = fopen($_SESSION['uploadedFile'], 'r');

                    // Skip the first line
                    fgetcsv($csvOpen);

                    // Parse data from CSV file line by line
                    while (($getData = fgetcsv($csvOpen, 10000, ",")) !== FALSE){
                        // Get row data
                        $TRAIN_LINE = $getData[0];
                        $ROUTE_NAME = $getData[1];
                        $RUN_NUMBER = $getData[2];
                        $OPERATOR_ID = $getData[3];

                        // If run number already exists in the database
                        $query = "SELECT * FROM TRAIN_DATA WHERE RUN_NUMBER = '" . $getData[2] . "'";
                        $check = mysqli_query($conn, $query);

                        if (!$check->num_rows > 0){
                            mysqli_query($conn, "INSERT INTO TRAIN_DATA (TRAIN_LINE, ROUTE_NAME, RUN_NUMBER, OPERATOR_ID) VALUES ('" . $TRAIN_LINE . "', '" . $ROUTE_NAME . "', '" . $RUN_NUMBER . "', '" . $OPERATOR_ID . "')");    
                        }   
                    }
                    // Close opened CSV file
                    fclose($csvOpen);
                }

                header("Location: home.php?successfulupload");
            } else{
                echo "Error: Infinityfree has a limit of 10MB per upload";
                echo '<a href = "home.php"> Back Home </a>';
            }
        } else{
            echo "Error uploading file";
            echo '<a href = "home.php"> Back Home </a>';
        }
    } else{
        echo "Must upload a csv file type";
        echo '<a href = "home.php"> Back Home </a>';
    }

}

?>
