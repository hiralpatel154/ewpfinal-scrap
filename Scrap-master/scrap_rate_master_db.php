<?php
include('../includes/dbcon.php');
session_start();
$user = $_SESSION['empid'];
if (isset($_POST['cpsubmit'])) {
    $type = $_POST['type'];
    $bare_cu = $_POST['bare_cu'];
    $tin_cu = $_POST['tin_cu'];
    $alu = $_POST['alu'];
    $pvc = $_POST['pvc'];
    $xlpe = $_POST['xlpe'];
    $gi = $_POST['gi'];
    $tape_r = $_POST['tape_r'];
    $pvc_d = $_POST['pvc_d'];
    $createdBy = $_POST['createdBy'];

    $query="SELECT MAX(id) as id from scrap_rate_master";
    $run=sqlsrv_query($conn, $query);
    $row = sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);
    $id=$row['id']+1;

    $query2 = "UPDATE scrap_rate_master SET is_update='1' where type='CP'";
    $qresult=sqlsrv_query($conn,$query2);

    $sql = "INSERT into scrap_rate_master (id,type,bare_cu,tin_cu,alu,pvc,xlpe,gi,tape_r,pvc_d,is_update,createdBy) values('$id','$type','$bare_cu', '$tin_cu', '$alu', '$pvc', '$xlpe', '$gi', '$tape_r','$pvc_d','0','$user')";
    $result = sqlsrv_query($conn,$sql);

    if($result){
        header('Location:scrap_rate_master.php');
        $_SESSION['update'] = "Data Updated Successfully";
    }else{
        print_r(sqlsrv_errors());
    }
}

if (isset($_POST['ipsubmit'])) {
    $type = $_POST['type'];
    $bare_cu = $_POST['bare_cu'];
    $tin_cu = $_POST['tin_cu'];
    $alu = $_POST['alu'];
    $pvc = $_POST['pvc'];
    $xlpe = $_POST['xlpe'];
    $gi = $_POST['gi'];
    $tape_r = $_POST['tape_r'];
    $pvc_d = $_POST['pvc_d'];

    $query="SELECT MAX(id) as id from scrap_rate_master";
    $run=sqlsrv_query($conn, $query);
    $row = sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);
    $id=$row['id']+1;
    
    $query = "UPDATE scrap_rate_master SET is_update='1' where type='IP'";
    $qresult=sqlsrv_query($conn,$query);

    $sql = "INSERT into scrap_rate_master (id,type,bare_cu,tin_cu,alu,pvc,xlpe,gi,tape_r,pvc_d,is_update,createdBy) values('$id','$type','$bare_cu', '$tin_cu', '$alu', '$pvc', '$xlpe', '$gi', '$tape_r','$pvc_d','0','$user')";
    $result = sqlsrv_query($conn,$sql);

    if($result){
        header('Location:scrap_rate_master.php');
        $_SESSION['update'] = "Data Updated Successfully";
    }else{
        print_r(sqlsrv_errors());
    }
}

?>