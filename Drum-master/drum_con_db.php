<?php
session_start();
$user = $_SESSION['empid'];
date_default_timezone_set('Asia/Kolkata');
$cur_date = date('m/d/Y h:i:s a', time());
include('../includes/dbcon.php');

// Add Contractor
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $mcont = $_POST['main_contractor'];
    $query = "SELECT MAX(id) as id FROM drum_contractor";
    $connect = sqlsrv_query($conn, $query);
    $crow = sqlsrv_fetch_array($connect, SQLSRV_FETCH_ASSOC);
    $id = $crow['id']+1;

    $sql = "INSERT INTO drum_contractor (id,name,main_contractor,isDelete,createdBy) values ('$id','$name','$mcont','0','$user')";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location: drum_contractor.php');
        $_SESSION['insert'] = "Data Inserted Successfully";
    }else{
        print_r(sqlsrv_errors());
    }
}
// Delete Contractor
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sql = "UPDATE drum_contractor SET isDelete = '1' where id=$id";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:drum_contractor.php');
        $_SESSION['delete'] = "Data Deleted Successfully";
    }else{
        print_r(sqlsrv_errors());
    }
}

// Edit Contractor
if (isset($_POST['update'])) {
    $editName = $_POST['editName'];
    $editId = $_POST['editId'];

    $sql = "UPDATE drum_contractor SET name='$editName', updatedAt='$cur_date', updatedBy='$user' where id='$editId'";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:drum_contractor.php');
        $_SESSION['update'] = "Data Updated Successfully";
    }else{
        print_r(sqlsrv_errors());
    }
}
?>