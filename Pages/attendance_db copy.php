<?php
session_start();
include('../includes/dbcon.php');
$user = $_SESSION['empid'];
$date = date('m/d/Y h:i:s a', time());

// 
if (isset($_POST['month']) && $_POST['contractor']) {
    $month = $_POST['month'];
    $basic = $_POST['basic'];
    $contractor = $_POST['contractor'];
    $attBonus = $_POST['attBonus'];
    $id = $_POST['id'];
    $query = "SELECT MAX(iId) as Id FROM attendance";
    $connect = sqlsrv_query($conn, $query);
    $crow = sqlsrv_fetch_array($connect, SQLSRV_FETCH_ASSOC);
    if ($crow['Id'] == NULL) {
        $Id = 1;
    }
    $Id = $crow['Id'] + 1;
    $paycode = $_POST['paycode'];
    $hra = $_POST['hra'];
    $allowance = $_POST['allowance'];
    $ot = $_POST['ot'];
    $salary = $_POST['salary'];

    foreach ($paycode as $key => $value) {
        if ($id[$key] == '') {
            $sql = "INSERT INTO attendance(iId, month, paycode, contractor, basic,attBonus, hra, allowance, ot, salary, createdBy, isDelete) VALUES ('$Id', '$month[$key]', '$value', '$contractor[$key]', '$basic[$key]','$attBonus[$key]', '$hra[$key]', '$allowance[$key]', '$ot[$key]', '$salary[$key]', '$user', 0)";
            $run = sqlsrv_query($conn, $sql);
            if ($run) {
                $_SESSION['insert'] = "Data Inserted Successfully";
            }
        } else {
            $query = "UPDATE attendance SET basic = '$basic[$key]', hra = '$hra[$key]', attBonus = '$attBonus[$key]', allowance = '$allowance[$key]', ot = '$ot[$key]', salary = '$salary[$key]', updatedBy = '$user', updatedAt = '$date' WHERE id = '$id[$key]' AND paycode = '$value'";
            $run2 = sqlsrv_query($conn, $query);
            if ($run2) {
                header('Location: attendance_sheet.php');
                $_SESSION['update'] = "Data Updated Successfully";
            }
        }
    }
}

// DELETE selected month AND Contractor data from Attendance
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Add a SQL query to delete the record with the specified ID
    $deleteQuery = "DELETE FROM attendance WHERE iId = $id";

    $run = sqlsrv_query($conn, $deleteQuery);

    if ($run) {
        header('Location: attendance.php');
        $_SESSION['delete'] = "Record deleted successfully";
    } else {
        print_r(sqlsrv_errors());
    }
}

// attendance_sheet month, contractor and team type selection
if (isset($_POST['mon_th']) && isset($_POST['cont']) && isset($_POST['typee'])) {
    $month = $_POST['mon_th'];
    $cont = $_POST['cont'];
    $type = $_POST['typee'];
    // Perform a database query to check if the record exists
    $sql = "SELECT COUNT(*) AS count FROM attendance as a JOIN emp_name as e ON a.paycode = e.pay_code WHERE a.month = '$month' AND a.contractor = '$cont' AND e.type = '$type'";
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
}

?>