<?php
include('../includes/dbcon.php');

session_start();
if(isset($_POST['save'])){
    $type=$_POST['type'];
    $mon=$_POST['mon'];
    $date = date('Y-m', strtotime($mon));
    $cont=$_POST['cont'];   
    $cat=$_POST['cat'];
    $qty=$_POST['qty'];
    $rate=$_POST['rate'];
    $amt=$_POST['amt'];
    $atqty=$_POST['atqty'];
    $atamt=$_POST['atamt'];
    $btqty=$_POST['btqty'];
    $btamt=$_POST['btamt'];
    $ctqty=$_POST['ctqty'];
    $ctamt=$_POST['ctamt'];
    $fqty=$_POST['fqty'];
   // $total=$_POST['total'];
    $remark=$_POST['remark'];
//   print_r($remark);
    $grandtotal=$_POST['grandtotal'];

   
    foreach ($type as $key => $value) {

        if($cat[$key]=='Drum'){
            $tqty=$atqty;
            $tamt=$atamt;
                
        }elseif($cat[$key]=='RM_Shifting'){
            $tqty=$btqty;
            $tamt=$btamt;
          
        }elseif($cat[$key]=='Purchase_Unloading'){
            $tqty=$ctqty;
            $tamt=$ctamt;
          
        }else{
            $tqty=0;
            $tamt=0;
            $qty[$key]=0;
            $fqty[$key]=0;
            $rate[$key]=0;
           
        }
        if($value==''){
            continue;
        }
       
        $sql2="INSERT INTO summary(contrator,month,CAT,type,qnty,final_qnty,rate,amt,total_amt,total_qnty,grand_total,remark,createdBy)
         VALUES('$cont','$date','".$cat[$key]."','".$value."','".$qty[$key]."','".$fqty[$key]."','".$rate[$key]."','".$amt[$key]."','$tamt',
         '$tqty','$grandtotal','".$remark[$key]."','".$_SESSION['empid']."' )";
        $run2=sqlsrv_query($conn,$sql2);
}
    
if($run2){
    ?>
    <script>
        alert("updated successfully");
       window.open('summary.php','_self');
    </script>
    <?php
}else{
    print_r(sqlsrv_errors());
}

}

//delete
if(isset($_GET['param1'])){
    $contractor=$_GET['param1'];
    $month=$_GET['param2'];

    $sql="UPDATE summary SET isdelete=1,updatedAt='".date('Y-m-d')."',updatedBy='".$_SESSION['Sr']."' WHERE contrator='$contractor' AND month='$month' ";
    $run=sqlsrv_query($conn,$sql);

    if($run){
        ?>
        <script>
            //alert('Deleted Successfully');
            window.open('summary.php','_self');
        </script>
        <?php
        }else{
            print_r(sqlsrv_errors());
        }
}


//edit
if(isset($_POST['update'])){
    $id=$_POST['id'];
    $type=$_POST['type'];
    $mon=$_POST['mon'];
    $cont=$_POST['cont'];
    $cat=$_POST['cat'];
    $qty=$_POST['qty'];
    $rate=$_POST['rate'];
    $amt=$_POST['amt'];
    $atqty=$_POST['atqty'];
    $atamt=$_POST['atamt'];
    $btqty=$_POST['btqty'];
    $btamt=$_POST['btamt'];
    $ctqty=$_POST['ctqty'];
    $ctamt=$_POST['ctamt'];
    $fqty=$_POST['fqty'];
    $total=$_POST['total'];
    $remark=$_POST['remark'];
    //   print_r($remark);
    $grandtotal=$_POST['grandtotal'];

    
    foreach($type as $key => $value) {
       // print_r($type);
        
        if($cat[$key]=='Drum'){
            $tqty=$atqty;
            $tamt=$atamt;    
        }elseif($cat[$key]=='RM_Shifting'){
            $tqty=$btqty;
            $tamt=$btamt;
        }elseif($cat[$key]=='Purchase_Unloading'){
            $tqty=$ctqty;
            $tamt=$ctamt;
        }else{
            $tqty=0;
            $tamt=0;
            $qty[$key]=0;
            $fqty[$key]=0;
            $rate[$key]=0;
            
        }
       
        $sql2="UPDATE summary SET type='".$value."',qnty='".$qty[$key]."',final_qnty='".$fqty[$key]."',rate='".$rate[$key]."',amt='".$amt[$key]."',
        total_amt='$tamt',total_qnty='$tqty',grand_total='$grandtotal',remark='".$remark[$key]."',updatedBy='".$_SESSION['Sr']."',updatedAt='".date('Y-m-d')."' WHERE id='".$id[$key]."' AND contrator='$cont' AND month='$mon'";
        $run2=sqlsrv_query($conn,$sql2); 
        }   
       
        if($run2){
            ?>
            <script>
                alert("updated successfully");
                 window.open('summary.php','_self');
            </script>
            <?php
        }else{
            print_r(sqlsrv_errors());
        }
}

//purchase add
// if(true){
//     $inw_id=$_POST['inw_id'];
//    //print_r($inw_id);
//     $recdate=$_POST['recdate'];
//     $mon=$_POST['mon'];
//     $invno=$_POST['invno'];
//     $invdate=$_POST['invdate'];
//     $partyn=$_POST['partyn'];
//     $item=$_POST['item'];
//     $pkg=$_POST['pkg'];
//     $qty=$_POST['qty'];
//     $rate=$_POST['rate'];
//     $amt=$_POST['amt'];
//     $checkbox_state=$_POST['checkbox_state'];
//     $main_grad=$_POST['main_grad'];

//     foreach ($inw_id as $key => $value) {
       
//         $sql="INSERT INTO purchase_data(inw_id,rcv_date,month,main_grade,inv_no,inv_date,party,item,qnty,rate,basic_amt,pkg,is_cancel) 
//         VALUES('".$value."','".$recdate[$key]."','$mon','$main_grad','".$invno[$key]."','".$invdate[$key]."','".$partyn[$key]."', '".$item[$key]."',
//         '".$pkg[$key]."','".$qty[$key]."','".$rate[$key]."','".$amt[$key]."','".$checkbox_state[$key]."')";
//         $run=sqlsrv_query($conn,$sql);
       // echo  $sql.'<br>';
    // }

    // if($run){
    //     ?>
    //     <script>
    //         alert("saved successfully");
    //         window.open('summary_data.php','_self');
    //     </script>
    //     <?php
    // }else{
    //         print_r(sqlsrv_errors());
    // // }

    // }
//purchase edit completed
// if( isset($_POST['updateButton'])){
//     $inw_id=$_POST['inw_id'];
//     $checkbox_state=$_POST['checkbox_state'];
   

//     foreach ($inw_id as $key => $value) {
       
//         $sql="UPDATE purchase_data SET is_cancel='".$checkbox_state[$key]."' WHERE inw_id='$value' ";
//         $run=sqlsrv_query($conn,$sql);    
// }
//     if($run){
//         ?>
//         <script>
//             alert("saved successfully");
//         window.open('summary_data.php','_self');
//         </script>
//         <?php
//     }else{
//         print_r(sqlsrv_errors());
//     }

//     }
    
    //purchse add
    // if( isset($_POST['secondform'])){
    //     $inw_id=$_POST['inw_id'];
    //     $recdate=$_POST['recdate'];
    //     $mon=$_POST['mon'];
    //     $invno=$_POST['invno'];
    //     $invdate=$_POST['invdate'];
    //     $partyn=$_POST['partyn'];
    //     $item=$_POST['item'];
    //     $pkg=$_POST['pkg'];
    //     $qty=$_POST['qty'];
    //     $rate=$_POST['rate'];
    //     $amt=$_POST['amt'];
    //     $main_grade=$_POST['main_grad'];

    
    //     $sql="INSERT INTO purchase_data(inw_id,rcv_date,month,main_grade,inv_no,inv_date,party,item,qnty,rate,basic_amt,pkg,is_cancel) 
    //     VALUES('$inw_id',
    //     '$recdate','$mon','$main_grade','$invno','$invdate','$partyn','$item','$qty','$rate','$amt','$pkg','0')";
    //     $run=sqlsrv_query($conn,$sql);    
        
    //     if($run){
    //         ?>
    //         <script>
    //             alert("saved successfully");
    //         window.open('summary_data.php','_self');
    //         </script>
    //         <?php
    //     }else{
    //         print_r(sqlsrv_errors());
    //     }
    
    //     }

?>