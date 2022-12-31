<?php
    session_start();
    include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>

<body>
<form action="upload.php" method="POST" enctype="multipart/form-data")">
    <input type="file" name="file" required>
    <button type="submit" name="submit">Upload CSV</button>
</form>

<div style="width: 100%; display: table;">
    <div style="display: table-row">
        <!-- left div -->
        <div style="width: 20px; display: table-cell;">
            <form method="POST">
            <?php      
                if (!isset ($_GET['page']) ) {  
                    $page_number = 1;  
                } else {  
                    $page_number = $_GET['page'];  
                }  
                // set rows per page
                $limit = 5;  
                $initial_page = ($page_number-1) * $limit;
                $_SESSION['currPage'] = $initial_page;
                $getQuery = "SELECT * FROM TRAIN_DATA";  
                $result = mysqli_query($conn, $getQuery);  
                $total_rows = mysqli_num_rows($result);
                // echo $total_rows;
                // echo " ";
                // echo $initial_page;
            ?>
                <?php if(isset($total_rows)){ ?>
                    <input type="radio" name="row" value="1" <?php if (!($total_rows >= $_SESSION['currPage']+1)){ ?> disabled <?php   } ?>></br>
                    <input type="radio" name="row" value="2" <?php if (!($total_rows >= $_SESSION['currPage']+2)){ ?> disabled <?php   } ?>></br>
                    <input type="radio" name="row" value="3" <?php if (!($total_rows >= $_SESSION['currPage']+3)){ ?> disabled <?php   } ?>></br>
                    <input type="radio" name="row" value="4" <?php if (!($total_rows >= $_SESSION['currPage']+4)){ ?> disabled <?php   } ?>></br>
                    <input type="radio" name="row" value="5" <?php if (!($total_rows >= $_SESSION['currPage']+5)){ ?> disabled <?php   } ?>></br>
                <?php } ?>
            </form> 
        </div>
        <!-- right div -->
        <div style="display: table-cell; line-height:19.5px;"> 

            <?php
            if(isset($_SESSION['uploadedFile'])){
                if(!(isset($_SESSION['isSorted']))){
                    mysqli_query($conn, "TRUNCATE TABLE TRAIN_DATA");
                    unset($_SESSION['isSorted']);
                }
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
                // retrieve current page #
                if (!isset ($_GET['page']) ) {  
                    $page_number = 1;  
                } else {  
                    $page_number = $_GET['page'];  
                }  
                // set rows per page
                $limit = 5;  
                $initial_page = ($page_number-1) * $limit;
                $_SESSION['currPage'] = $initial_page;

                $getQuery = "SELECT * FROM TRAIN_DATA";  
                $result = mysqli_query($conn, $getQuery);  
                $total_rows = mysqli_num_rows($result); 
                $total_pages = ceil($total_rows / $limit);

                //retrieve the selected results from database   
                $getQuery = "SELECT * FROM TRAIN_DATA LIMIT " . $initial_page . ',' . $limit;  
                $result = mysqli_query($conn, $getQuery);      

                //display results 
                while ($row = mysqli_fetch_array($result)) {  
                    echo $row['TRAIN_LINE'] . ' ' . $row['ROUTE_NAME'] . ' ' . $row['RUN_NUMBER'] . ' ' . $row['OPERATOR_ID'] . '</br>';
                }
                // Close opened CSV file
                fclose($csvOpen);
            }
        ?>
        </div>
    </div>
</div>

<?php 
    // show page number with link
    for($page_number = 1; $page_number<= $total_pages; $page_number++) {
        echo '<a href = "home.php?page=' . $page_number . '">' . $page_number . ' </a>';  
    }
?>

<form action="checkbox.php" method="POST">
    <input type="submit" name="delete0" value="DELETE"/>
    <input type="submit" name="update0" value="UPDATE"/>
    <input type="submit" name="create0" value="CREATE"/>
</form>

<form action="sort.php" method="POST">
    <?php echo 'Sort Alphabetically By: '; ?>
    <button type="submit" name="sort1">TRAIN_LINE</button>
    <button type="submit" name="sort2">ROUTE_NAME</button>
    <button type="submit" name="sort3">RUN_NUMBER</button>
    <button type="submit" name="sort4">OPERATOR_ID</button>
</form>




</body>
</html>

