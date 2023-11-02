<?php

include('../includes/dbcon.php');
include('../includes/header.php');  

if(isset($_POST['save'])){
//head part
$stype=$_POST['stype'];
$fdate=$_POST['fdate'];
$tdate=$_POST['tdate'];
$month=$_POST['month'];
$tname=$_POST['tname'];
$mp=$_POST['mp'];
$twt=$_POST['twt'];
$tamt=$_POST['tamt'];
//detail part
$type=$_POST['type'];
$name=$_POST['name'];
$rem=$_POST['rem'];
$qty=$_POST['qty'];
$rate=$_POST['rate'];
$amt=$_POST['amt'];


$sql1="SELECT MAX(id) as 'num' FROM scraphead";
$run1 =sqlsrv_query($conn,$sql1);
$row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);
$count=$row1['num']+1;


$sql="INSERT INTO scraphead(id,Typeofscrap,Fromdate,Todate,Month,Teamname,mp,Totalwt,Totalamt,createdBy) VALUES('$count','$stype','$fdate','$tdate','$month','$tname','$mp','$twt','$tamt','".$_SESSION['empid']."')";

$run= sqlsrv_query($conn,$sql);
if($run){
    foreach ($type as $key => $value) {
        $sql2="INSERT INTO scrapdetail(Type,Name,Remark,qnty,rate,amount,createdBy,head_id) VALUES('".$value."','".$name[$key]."','".$rem[$key]."','".$qty[$key]."','".$rate[$key]."','".$amt[$key]."','".$_SESSION['empid']."','$count' )";
        $run2=sqlsrv_query($conn,$sql2);
    }   
    if($run2){
        ?>
        <script>
            window.open('scrapdata.php','_self');
            alert('saved');
        </script>
        <?php
    }else{
            print_r(sqlsrv_errors());
    }
    }
    else{
        echo 'error for first if';
        print_r(sqlsrv_errors());
    }
}

//edit
if(isset($_POST['update'])){
    //head part
    $id=$_POST['id'];
    $stype=$_POST['stype'];
    $fdate=$_POST['fdate'];
    $tdate=$_POST['tdate'];
    $month=$_POST['month'];
    $tname=$_POST['tname'];
    $mp=$_POST['mp'];
    $twt=$_POST['twt'];
    $tamt=$_POST['tamt'];
    //detail part
    $type=$_POST['type'];
    $name=$_POST['name'];
    $rem=$_POST['rem'];
    $qty=$_POST['qty'];
    $rate=$_POST['rate'];
    $amt=$_POST['amt'];
    $detailSr=$_POST['detailSr'];

    $sql="UPDATE scraphead SET Typeofscrap='$stype', Fromdate='$fdate' ,Todate='$tdate', Month='$month',Teamname='$tname',mp='$mp',Totalwt=' $twt',Totalamt='$tamt' WHERE id = '$id' ";
    $run=sqlsrv_query($conn,$sql);

    foreach ($type as $key => $value) {
        if($detailSr[$key]!=''){
         
            $sql1="UPDATE scrapdetail SET Type='".$value."',Name='".$name[$key]."',Remark='".$rem[$key]."',qnty='".$qty[$key]."',rate='".$rate[$key]."',amount='".$amt[$key]."',UpdatedAt='".date('Y-m-d')."',UpdatedBy='".$_SESSION['empid']."' where id = '".$detailSr[$key]."'";
            $run1=sqlsrv_query($conn,$sql1);
          
        }else{
            $sql1="INSERT INTO scrapdetail(Type,Name,Remark,qnty,rate,amount,UpdatedAt,UpdatedBy,head_id) VALUES('".$value."','".$name[$key]."','".$rem[$key]."','".$qty[$key]."','".$rate[$key]."','".$amt[$key]."','".date('Y-m-d')."','".$_SESSION['empid']."','$id' )";
            $run1=sqlsrv_query($conn,$sql1);
           
         
        }
        
    }
    if($run && $run1){
        ?>
        <script>
            alert('updated Successfully');
            window.open('scrapdata.php','_self');
        </script>
        <?php
    }else{
        print_r(sqlsrv_errors());
    }
}

//delete
if(isset($_GET['del'])){
    $id=$_GET['del'];

    $sql="UPDATE Table_1 SET Isdelete=1, UpdatedBy='$userid', UpdatedAt='$date' WHERE Sr='$Sr'";
    $run=sqlsrv_query($conn,$sql);

if($run){
    ?>
    <script>
        alert('Deleted Successfully');
        window.open('gatepass.php','_self');
    </script>
    <?php
    }else{
        print_r(sqlsrv_errors());
    }
}

?>






