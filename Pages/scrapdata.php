<?php
include('../includes/dbcon.php');
include('../includes/header.php');  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         /* .hideText{
            color: transparent !important;
          
        }
        .btnhide{
            background: transparent !important;
            border: none !important;
            font-size:0 !important;
        } */
        .fl{
            margin-top:2rem;
        }
        .common-btn{
            background-color: #62bdae;
            border:none;
            color:white !important;
        }
        .row{
            
        }
        #drumTable th{
            white-space: nowrap !important;
           /* font-size:0.8rem; */
            padding: 8px 6px;
            /* padding-left:0;
            padding-right:0; */
        }
        #drumTable td{
            white-space:nowrap;
          /* font-size:1rem; */
            padding: 6px;
             /* padding-left:0;
            padding-right:0; */
        }
        .tdCss{
            padding: 3px 6px !important;
        }
        #scrapTable th,
    #scrapTable td {
        text-align: center;
    }
    </style>
</head>
<body>
    <div class="container-fluid fl ">
        <div class="row mb-3">
            <div class="col"><h4 class="pt-2 mb-0">Scrap Data</h4></div>
            <div class="col-auto"> <a  class="btn rounded-pill common-btn" href="scrapdata_add.php">+Add</a></div>
        </div>
        <div class="divCss ">
            <table class="table table-bordered text-center table-striped table-hover mb-0" id="scrapTable">
                <thead>
                    <tr class="bg-secondary text-light">
                        <th>Sr</th>
                        <th>Scrap Type</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Month</th>
                        <th>Team Name</th>
                        <th>M.p</th>
                        <th>Total WT</th>
                        <th>Total Amt</th>
                        <!-- <th>Type</th>
                        <th>Name</th>
                        <th>Remark</th>
                        <th>Qnty</th>
                        <th>Rate</th>
                        <th>Amount</th> -->
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    
                        <?php
                            $sr=1;
                            $sql="SELECT * FROM scraphead order by id desc";
                            $run=sqlsrv_query($conn,$sql);
                            $printedSrNos = array();
                            while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                        ?>
                            <tr>
                                <!-- <?php
                            if (!in_array($row['head_id'], $printedSrNos)) {
                            
                                $condi = '';
                                $printedSrNos[] = $row['head_id'];
                            } else {
                               
                                $condi = 'hideText';
                            }
                            ?> -->
                                <td ><?php echo $row['id']  ?></td>
                                <!-- <td><?php echo $row['head_id']  ?></td> -->
                                <td  ><?php if($row['Typeofscrap'] =='CP'){ echo "Control/Power"; }elseif($row['Typeofscrap'] =='IP'){ echo "Instru/Panni"; } else{echo "Other Extra";}   ?></td>
                                <td ><?php echo $row['Fromdate']->format('d-m-Y')  ?></td>
                                <td ><?php echo $row['Todate']->format('d-m-Y') ?></td>
                                <td ><?php echo $row['Month']  ?></td>
                                <td ><?php echo $row['Teamname']  ?></td>
                                <td ><?php echo $row['mp']  ?></td>
                                <td ><?php echo $row['Totalwt']  ?></td>
                                <td ><?php echo $row['Totalamt']  ?></td>
                                <!-- <td><?php echo $row['Type']  ?></td>
                                <td><?php echo $row['Name']  ?></td>
                                <td><?php echo $row['Remark']  ?></td>
                                <td><?php echo $row['qnty']  ?></td>
                                <td><?php echo $row['rate']  ?></td>
                                <td  class="<?php echo $condi ?>"><?php echo $row['amount'] ?></td> -->
                               
                                <td  class="tdCss" ><a href="scrapdata_edit.php?edit=<?php echo $row['id']?>"  class="btn rounded-pill btn-warning btn-sm"  >Edit</a></td>
                            </tr>
                        <?php
                        //  $sr++; 
                         }
                        ?>                                       
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<script>
     $('#sdata').addClass('active');

     $(document).ready(function(){
		var table = $('#scrapTable').DataTable({   // initializes a DataTable using the DataTables library 
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
<?php

include('../includes/footer.php');
?>