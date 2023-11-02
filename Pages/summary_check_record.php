<?php
include('../includes/dbcon.php'); // Include your database connection file
 

if (isset($_POST['month']) && isset($_POST['cont'])) {
    $month = $_POST['month'];
    $cont = $_POST['cont'];

    // Perform a database query to check if the record exists
    $sql = "SELECT COUNT(*) AS count FROM summary WHERE month = '$month' AND contrator = '$cont' AND isdelete='0'";
    $run = sqlsrv_query($conn, $sql);
    
    if ($run) {
        $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
        $count = $row['count'];

        if ($count > 0) {
            // The record exists
            echo "exists";
        } else {
            // The record does not exist
            echo "not_exists";
        }
    } else {
        // Error handling for the database query
        echo "error";
    }
} else {
    // Handle the case where 'month' or 'cont' is not set in the POST data
    echo "missing_data";
}
?>
