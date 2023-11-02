<?php
include('../includes/dbcon.php');
 
if(isset($_POST['stype'])){
$stype = $_POST['stype'];
$Array= array();
if($stype=='CP' || $stype=='IP' ){
$sql1="SELECT * FROM [EWP].[dbo].[scrap_rate_master] WHERE type='$stype' AND is_update=0";
$run1=sqlsrv_query($conn,$sql1);
$row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);

$name=array('bare_cu','tin_cu','alu','pvc','xlpe','gi','tape_r','pvc_d');
for($i=0;$i<8;$i++){ 
    $Array[$i]= $row1[$name[$i]];
}
}
else{
    $Array=[0,0,0,0,0,0,0,0];
}
echo json_encode($Array);
}
?>
  