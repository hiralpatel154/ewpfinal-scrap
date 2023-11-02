<?php
include('../includes/dbcon.php');
session_start();
$user = $_SESSION['empid'];
date_default_timezone_set('Asia/Kolkata');
$cur_date = date('m/d/Y h:i:s a', time());

// Get To Month based on From month
if (isset($_POST['month'])) {
    $fmonth = $_POST['month'];
    $emonth = date("Y-m", strtotime($fmonth . "+5 months"));
    echo $emonth;
}

// Add Rate for 6 months
if (isset($_POST['submit'])) {
    $rate = $_POST['rate'];
    $fmonth = $_POST['fmonth'];
    $query = "SELECT MAX(iId) as Id FROM emp_rate_master";
    $connect = sqlsrv_query($conn, $query);
    $crow = sqlsrv_fetch_array($connect, SQLSRV_FETCH_ASSOC);
    $Id = $crow['Id'] + 1;
    // $allQueries = "";
    for ($i = 0; $i <6; $i++) {

        $emonth = date("Y-m", strtotime($fmonth . "+$i months"));
        $sql = "INSERT INTO emp_rate_master(iId,rate,month,isDelete) values('$Id','$rate','$emonth','0')";
        // $allQueries .="Query for etmonth $emonth: $sql<br>";
        $run = sqlsrv_query($conn, $sql);

        if ($run) {
            $_SESSION['insert'] = "Data Inserted Successfully";
        } else {
            print_r(sqlsrv_errors());
        }
    }
    // echo $allQueries;exit;
    header('Location: emp_rate_master.php');
}
// Get To Month based on From month
if (isset($_POST['edmonth'])) {
    $fedmonth = $_POST['edmonth'];
    $edmonth = date("Y-m", strtotime($fedmonth . "+5 months"));
    echo $edmonth;
}
// Edit Rate

if (isset($_POST['update'])) {
    $iid = $_POST['eid'];
    $id = $_POST['mid']; // Assuming 'id' is the starting ID
    $fmonth = $_POST['feditmonth'];
    $rate = $_POST['rate'];

    for ($i = 0; $i < 6; $i++) {
        $etmonth = date("Y-m", strtotime($fmonth . "+$i months"));
        $sql = "UPDATE emp_rate_master SET rate='$rate', month='$etmonth', updatedAt='$cur_date', updatedBy='$user' WHERE iId='$iid' AND isDelete='0' AND id = $id";
        $result = sqlsrv_query($conn, $sql);

        if (!$result) {
            die(print_r(sqlsrv_errors(), true));
        }
        $id++;
    }
    $_SESSION['update'] = "Data Updated Successfully";
    header('Location: emp_rate_master.php');
}


?>