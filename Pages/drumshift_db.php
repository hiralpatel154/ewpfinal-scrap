<?php
session_start();
include('../includes/dbcon.php');





//add
if(isset($_POST['save'])){
    $cno=$_POST['cno'];
    $date=$_POST['date'];
    $nameoc=$_POST['nameoc'];
    $name=$_POST['name'];
    $fplant=$_POST['fplant'];
    $tplant=$_POST['tplant'];
    $dseries=$_POST['dseries'];
    $dnum=$_POST['dnum'];
    // $stage=$_POST['stage'];
    // $ncore=$_POST['ncore'];
    // $corepair=$_POST['corepair'];
    // $sqmm=$_POST['sqmm'];
    // $ctype=$_POST['ctype'];
    // $qty=$_POST['qty'];
    // $unit=$_POST['unit'];
    $rem=$_POST['rem'];
   

    $sql="INSERT INTO Dshift (Challanno,Date,Name_of_contractor,Name,From_Plant,To_Plant,Drum_series,Drum_No,Remark,createdBy)
     VALUES( '$cno','$date', '$nameoc', '$name','$fplant','$tplant','$dseries','$dnum','$rem','".$_SESSION['Sr']."')";
    $run=sqlsrv_query($conn,$sql);
    $_SESSION['ch']=$cno;
   
    
    if($run){
        ?>
        <script>
             window.open('drumshift.php','_self');
        </script>
        <?php

    }else{
        print_r(sqlsrv_errors());
    }

}
//edit
if(isset($_POST['update'])){
    $id=$_POST['id'];
    $cno=$_POST['cno'];
    $date=$_POST['date'];
    $nameoc=$_POST['nameoc'];
    $name=$_POST['name'];
    $fplant=$_POST['fplant'];
    $tplant=$_POST['tplant'];
    $dseries=$_POST['dseries'];
    $dnum=$_POST['dnum'];
    $stage=$_POST['stage'];
    $ncore=$_POST['ncore'];
    $corepair=$_POST['corepair'];
    $sqmm=$_POST['sqmm'];
    $ctype=$_POST['ctype'];
    $qty=$_POST['qty'];
    $unit=$_POST['unit'];
    $rem=$_POST['rem'];

    $sql="UPDATE Dshift SET Challanno='$cno',Date='$date',Name_of_contractor='$nameoc',Name='$name',From_Plant='$fplant',To_Plant='$tplant',Drum_series='$dseries',Drum_No='$dnum',Stage='$stage',No_of_core='$ncore',corepair='$corepair',Sqmm='$sqmm',
    ConductorType='$ctype',Qnty='$qty',Unit='$unit',Remark='$rem',updatedAt='".date('Y-m-d')."',updatedBy='".$_SESSION['Sr']."' WHERE id='$id'";

    $run=sqlsrv_query($conn,$sql);
    
    if($run){
        ?>
        <script>
            window.open('drumshift.php','_self');
        </script>
        <?php

    }else{
        print_r(sqlsrv_errors());
    }

}