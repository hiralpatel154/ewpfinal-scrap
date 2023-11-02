<?php
session_start();
$user = $_SESSION['empid'];
date_default_timezone_set('Asia/Kolkata');
$cur_date = date('m/d/Y h:i:s a', time());
include('../includes/dbcon.php');

// Add Contractor
if (isset($_POST['submit'])) {
    $pay_code = $_POST['pay_code'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $team = $_POST['team'];
    $contractor = $_POST['contractor'];
    $doj = $_POST['doj'];
    $dob = $_POST['dob'];
    $rate = $_POST['rate'];
    $status = $_POST['status'];
    $doe = $_POST['doe'];

    // Insert without the 'id' column
    $sql = "INSERT INTO emp_name (pay_code, name, department, team, contractor, doj, dob, rate, status, doe, isDelete, createdBy) VALUES ('$pay_code', '$name', '$department', '$team', '$contractor', '$doj', '$dob', '$rate', '$status', '$doe', '0', '$user')";

    $result = sqlsrv_query($conn, $sql);

    if ($result === false) {
        // Handle the error and print the error message
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
            echo "Code: " . $error['code'] . "<br />";
            echo "Message: " . $error['message'] . "<br />";
        }
        exit;
    }

    // Disable identity insert when done
    $sql_disable_identity_insert = "SET IDENTITY_INSERT emp_name OFF";
    $result_disable_identity_insert = sqlsrv_query($conn, $sql_disable_identity_insert);

    if ($result_disable_identity_insert === false) {
        print_r(sqlsrv_errors());
        exit; // Exit on error
    }

    if ($result) {
        header('Location: emp_name.php');
        $_SESSION['insert'] = "Data Inserted Successfully";
    } else {
        header('Location: emp_name.php');
        $_SESSION['delete'] = "An error occurred during insertion";
    }
}

// Delete Contractor
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sql = "UPDATE emp_name SET isDelete = '1' where id=$id";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:emp_name.php');
        $_SESSION['delete'] = "Data Deleted Successfully";
    } else {
        print_r(sqlsrv_errors());
    }
}

// Edit Contractor
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $pay_code = $_POST['pay_code'];
    $department = $_POST['department'];
    $team = $_POST['team'];
    $contractor = $_POST['contractor'];
    $doj = $_POST['doj'];
    $dob = $_POST['dob'];
    $rate = $_POST['rate'];
    $status = $_POST['status'];
    $doe = $_POST['doe'];

    $sql = "UPDATE emp_name SET pay_code='$pay_code',name='$name', department='$department',team='$team',contractor='$contractor',doj='$doj',dob='$dob',rate='$rate',status='$status',doe='$doe',updatedAt='$cur_date', updatedBy='$user' where id='$id'";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:emp_name.php');
        $_SESSION['update'] = "Data Updated Successfully";
    } else {
        print_r(sqlsrv_errors());
    }
}

// Check Paycode if it already exists or not
if (isset($_POST['paycode'])) {
    $paycode = $_POST['paycode'];
    $sql = "SELECT COUNT(*) AS count FROM emp_name WHERE pay_code = '$paycode'";
    $result = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

    if ($row['count'] > 0) {
        $response = 'exist';
    } else {
        $response = 'not exist';
    }
    echo $response;
}
?>