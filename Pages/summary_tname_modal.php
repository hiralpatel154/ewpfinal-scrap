<?php
include('../includes/dbcon.php');

$mon=$_POST['mon'];
$tname=$_POST['tname'];
$month = date('F', strtotime("$mon-01"));
$year = date('Y', strtotime("$mon-01"));

?>
<style>

#tnametable input{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width:50%;
            text-align: center;
            padding:0px !important;
        }
        .totaltname{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            /* text-align: center; */
        }

        #tnametable th,
        #tnametable td {
            text-align: center ;
            white-space:nowrap;
    }
</style>
<div class="total">
        <h5 >Total Qty:</h5> <h5><input class="totaltname" type="number" id="totaltname" >
       
    </h5>
    </div>

<table class="table table-bordered text-center table-striped table-hover mt-7" id="tnametable">
   <thead>
        <tr class="bg-secondary text-light">
            <th>Sr No.</th>
            <th>From Date</th>
            <th>To Date </th>
            <th>Weight</th>
            <th>Type</th>
            <th>Name</th>
            <th style="width:50px;">Qnty</th>
            <th>Rate</th>
         </tr>
   </thead> 
   <tbody>
    <tr>
        <?php
        $sr=1;
            $sql="SELECT * FROM scraphead h left outer join scrapdetail t on h.id=t.head_id 
            where h.Teamname='$tname' AND h.Month='$month' AND FORMAT(H.Fromdate,'yyyy')='$year'";
            $run=sqlsrv_query($conn,$sql);
            while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){ 
        ?>
            <tr>
                <td><?php echo $sr ?></td>
                <td><?php echo $row['Fromdate']->format('Y-m-d')  ?></td>
                <td><?php echo $row['Todate']->format('Y-m-d')  ?></td>
                <td><?php echo $row['Totalwt']  ?></td>
                <td><?php echo $row['Type']  ?></td>
                <td><?php echo $row['Name']  ?></td>
                <td>
                    <input type="text" class="tnameqty" value="<?php echo $row['qnty']  ?>" > 
                </td>
                <td><?php echo $row['rate']  ?></td>
            </tr> 
        <?php 
        $sr++; }
        ?>   
         
   </tbody>
    
</table>
<script>

$(document).ready(function() {
    let totalSum = 0;

    // Update total sum when the page loads
    $('.tnameqty').each(function() {
        const value = parseFloat($(this).val());
        if (!isNaN(value)) {
            totalSum += value;
        }
    });

    // Display the total sum
    $('#totaltname').val(totalSum);

});
        $(document).ready(function(){
		var table = $('#tnametable').DataTable({   // initializes a DataTable using the DataTables library 
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
