<?php
include('../includes/dbcon.php');

$mon=$_POST['mon'];
$ser=$_POST['ser'];

$position = strpos($ser, '-'); // Find the position of the first hyphen
if ($position !== false) {
    $result = substr($ser, 0, $position); // Get the substring from the start to the hyphen
} else {
    $result=$ser;
}
// echo $result;
?>
<style>
 
</style>
<table class="table table-bordered text-center table-striped table-hover mt-7" id="dtable">
    <tr class="bg-secondary text-light">
        <th>Sr No.</th>
        <th>Date</th>
        <th>Con. Name</th>
        <th>From Plant</th>
        <th>To Plant</th>
        <th>Drum No.</th>
        <th>Qnty</th>
    </tr>
    <tr>
        <?php
        $sr=1;
            $sql="SELECT * FROM Dshift WHERE FORMAT(Date,'yyyy-MM') = '$mon' AND Drum_series='$result' ";
            $run=sqlsrv_query($conn,$sql);
            while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
               ?>
               <td><?php echo $sr ?></td>
               <td><?php echo $mon ?> </td>
               <td><?php echo $row['Name_of_contractor'] ?> </td>
               <td><?php echo $row['From_Plant'] ?></td>
               <td><?php echo $row['To_Plant'] ?></td>
               <td><?php echo $row['Drum_No'] ?></td>
               <td><?php echo $row['Drum_No'] ?></td> 
               </tr> 
                <?php
               $sr++; }
        ?>
</table>
<script>
    $(document).ready(function(){
		var table = $('#dtable').DataTable({   // initializes a DataTable using the DataTables library 
		    "processing": true,                  //This option enables the processing indicator to be shown while the table is being processed
			 dom: 'Bfrtip',                      // This option specifies the layout of the table's user interface B-buttons,f-flitering input control,T-table,I-informationsummary,P-pagination
			 ordering: false,                   //sort the columns by clicking on the header cells if true
			 destroy: true,                     //This option indicates that if this DataTable instance is re-initialized, 
                                                //the previous instance should be destroyed. This is useful when you need to re-create the table dynamically.
                
		 	lengthMenu: [
            	[ 15, 50, -1 ],
            	[ '15 rows','50 rows','Show all' ]
        	],
			 buttons: [
		 		'pageLength','copy', 'excel'
        	]
    	});
 	});

</script>


