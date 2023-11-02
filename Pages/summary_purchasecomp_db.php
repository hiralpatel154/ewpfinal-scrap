<?php
include('../includes/dbcon.php');
session_start();
// if(true){
//     $inw_id=$_POST['inw_id'];
//     $checkbox_state=$_POST['checkbox_state'];
   
//     foreach ($inw_id as $key => $value) {
       
//         $sql="UPDATE purchase_data SET is_cancel='".$checkbox_state[$key]."' WHERE inw_id='$value' ";
//         $run=sqlsrv_query($conn,$sql);    
// }
//}
    if( isset($_POST['inw_id'])){
        $inw_id=$_POST['inw_id'];
        $recdate=$_POST['recdate'];
        $mon=$_POST['mon'];
        $invno=$_POST['invno'];
        $invdate=$_POST['invdate'];
        $partyn=$_POST['partyn'];
        $item=$_POST['item'];
        $pkg=$_POST['pkg'];
        $qty=$_POST['qty'];
        $rate=$_POST['rate'];
        $amt=$_POST['amt'];
        $main_grade=$_POST['main_grad'];

    
        $sql="INSERT INTO purchase_data(inw_id,rcv_date,month,main_grade,inv_no,inv_date,party,item,qnty,rate,basic_amt,pkg,is_cancel) 
        VALUES('$inw_id','$recdate','$mon','$main_grade','$invno','$invdate','$partyn','$item','$qty','$rate','$amt','$pkg','0')";
        $run=sqlsrv_query($conn,$sql);    
        
      
        if($run){
            echo "saveed successfully";
        }else{
            print_r(sqlsrv_errors());

        }
    
        }

        ?>
