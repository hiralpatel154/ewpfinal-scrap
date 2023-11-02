<?php
session_start();
$user = $_SESSION['empid'];
date_default_timezone_set('Asia/Kolkata');
$cur_date = date('m/d/Y h:i:s a', time());
include('../includes/dbcon.php');

// Add Name
if (isset($_POST['submit'])) {
    $name = $_POST['name'];

    $query = "SELECT MAX(id) as id FROM drum_name";
    $connect = sqlsrv_query($conn, $query);
    $crow = sqlsrv_fetch_array($connect, SQLSRV_FETCH_ASSOC);
    $id = $crow['id']+1;

    $sql = "INSERT INTO drum_name (id,name,isDelete,createdBy) values ('$id','$name','0','$user')";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location: drum_name.php');
        $_SESSION['insert'] = "Data Inserted Successfully";
    }else{
        print_r(sqlsrv_errors());
    }
}
// Delete Name
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sql = "UPDATE drum_name SET isDelete = '1' where id=$id";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:drum_name.php');
        $_SESSION['delete'] = "Data Deleted Successfully";
    }else{
        print_r(sqlsrv_errors());
    }
}

// Edit Name
if (isset($_POST['update'])) {
    $editName = $_POST['editName'];
    $editId = $_POST['editId'];

    $sql = "UPDATE drum_name SET name='$editName', updatedAt='$cur_date', updatedBy='$user' where id='$editId'";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:drum_name.php');
        $_SESSION['update'] = "Data Updated Successfully";
    }else{
        print_r(sqlsrv_errors());
    }
}
?>