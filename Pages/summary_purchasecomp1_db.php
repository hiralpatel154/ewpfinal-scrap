<?php
include('../includes/dbcon.php');
session_start();
if(isset($_POST['inw_id'])){
    $uid=$_POST['uid'];
    $inw_id=$_POST['inw_id'];
    $tqty=$_POST['tqty'];
    $checkbox_state=$_POST['checkbox_state'];
   
    foreach ($uid as $key => $value) {   
        $sql="UPDATE purchase_data SET is_cancel='".$checkbox_state[$key]."',tqty='$tqty' WHERE id='$value' ";
        $run=sqlsrv_query($conn,$sql); 
        //echo  $sql.'<br>';
    }

    if($run){
        echo 'Saved Successfully';
    }else{
        print_r(sqlsrv_errors());
    }
}

?>
