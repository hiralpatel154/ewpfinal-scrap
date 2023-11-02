<?php
session_start();
$user = $_SESSION['empid'];
date_default_timezone_set('Asia/Kolkata');
$cur_date = date('m/d/Y h:i:s a', time());
include('../includes/dbcon.php');

// Add Contractor
if (isset($_POST['submit'])) {
    $name = $_POST['name'];

    $query = "SELECT MAX(id) as id FROM emp_contractor";
    $connect = sqlsrv_query($conn, $query);
    $crow = sqlsrv_fetch_array($connect, SQLSRV_FETCH_ASSOC);
    $id = $crow['id']+1;

    $sql = "INSERT INTO emp_contractor (id,name,isDelete,createdBy) values ('$id','$name','0','$user')";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location: emp_contractor.php');
        $_SESSION['insert'] = "Data Inserted Successfully";
    }else{
        print_r(sqlsrv_errors());
    }
}
// Delete Contractor
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sql = "UPDATE emp_contractor SET isDelete = '1' where id=$id";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:emp_contractor.php');
        $_SESSION['delete'] = "Data Deleted Successfully";
    }else{
        print_r(sqlsrv_errors());
    }
}

// Edit Contractor
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $gst = $_POST['gst'];
    $pan = $_POST['pan'];
    $esic = $_POST['esic'];
    $pf = $_POST['pf'];
    $bank = $_POST['bank'];
    $ac = $_POST['ac'];
    $eoe = $_POST['eoe'];
    $address = $_POST['address'];

    $sql = "UPDATE emp_contractor SET name='$name',email='$email', mobile='$mobile',gst='$gst',pan='$pan',esic='$esic',pf='$pf',bank='$bank',ac='$ac',eoe='$eoe',address='$address',updatedAt='$cur_date', updatedBy='$user' where id='$id'";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:emp_contractor.php');
        $_SESSION['update'] = "Data Updated Successfully";
    } else {
        print_r(sqlsrv_errors());
    }
}
?>