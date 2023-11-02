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
            padding-left:0;
            padding-right:0;
        }
        #drumTable td{
            white-space:nowrap;
            /* font-size:0.8rem; */
            padding: 6px;
            padding-left:0;
            padding-right:0;

        }
        .tdCss{
            padding: 3px 6px !important;
        }
        #drumTable th,
    #drumTable td {
        text-align: center;
    }
    </style>
</head>
<body>

    <div class="container-fluid fl ">
         <form action="drumshift_db.php" method="post" >
            <div class="row mb-3">
                <div class="col"><h4 class="pt-2 mb-0">Add Drum details</h4></div>
                <!-- <div class="col-auto"> <button type="submit" class="btn  rounded-pill common-btn"  name="save" >Save</button></div>
                <div class="col-auto p-0"> <a type="" class="btn  rounded-pill btn-secondary " href="drumshift.php">Back</a></div> -->
                <div class="col-auto">
                <a href="session_destroy.php"  class="btn rounded-pill btn-danger mt-2" name="reset">Reset</a>
                </div>
            </div>

            <div class="divCss">
                <div class="row px-2">
                <?php
                if (isset($_SESSION['ch'])) {
                    
                    $sql1="WITH top1 as(select max (id) as mid from Dshift  where challanno='".$_SESSION['ch']."')
                    select * from Dshift where id in(select mid from top1)
                    ";
                    $run1=sqlsrv_query($conn,$sql1);
                    $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);

                    $cno=$row1['Challanno'];
                    $date=$row1['Date']->format('Y-m-d');
                    $nameoc=$row1['Name_of_contractor'];
                    $name=$row1['Name'];
                    $fplant=$row1['From_Plant'];
                    $tplant=$row1['To_Plant'];
                    $dseries=$row1['Drum_series'];
                    $dnum=$row1['Drum_No'];
                    // $stage=$row1['stage'];
                    // $ncore=$row1['ncore'];
                    // $corepair=$row1['corepair'];
                    // $sqmm=$row1['sqmm'];
                    // $ctype=$row1['ctype'];
                    // $qty=$row1['qty'];
                    // $unit=$row1['unit'];
                   // $rem=$row1['Remark'];
                }else{
                    $sql="SELECT MAX(Challanno) AS ch FROM Dshift";
                    $run=sqlsrv_query($conn,$sql);
                    $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);

                    $cno = (isset($_SESSION['reset']) || $row['ch'] == NULL) ? $row['ch']+1 : $row['ch'];
                    $date=date('Y-m-d');
                    $nameoc='';
                    $name='';
                    $fplant='';
                    $tplant='';
                    $dseries='';
                    $dnum='';
                    // $stage=$row1['stage'];
                    // $ncore=$row1['ncore'];
                    // $corepair=$row1['corepair'];
                    // $sqmm=$row1['sqmm'];
                    // $ctype=$row1['ctype'];
                    // $qty=$row1['qty'];
                    // $unit=$row1['unit'];
                    $rem='';

                }
                
                // echo $nameoc;
                    ?>
                    <label class="form-label col-lg-3 col-md-6" for="cno">Challan No.
                        <input class="form-control " type="number" id="cno" name="cno"  value="<?php echo $cno ?>" required readonly>
                        
                    </label>
                  
                    <label class="form-label col-lg-3 col-md-6" for="date">Date
                        <input class="form-control" type="date" id="date" name="date" value="<?php echo $date ?>" required>
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="nameoc">Name of Contractor
                        <select  class="form-select" name="nameoc" id="nameoc"   >
                            <option value=""></option>
                            <?php
                            $sql="SELECT name FROM drum_contractor";
                            $run=sqlsrv_query($conn,$sql);
                           while( $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
?>
                            <option <?php if( $nameoc==$row['name']) { ?> selected <?php } ?>  ><?php echo $row['name']  ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    
                    <label class="form-label col-lg-3 col-md-6" for="name">Name
                        <select  class="form-select" name="name" id="name" >
                            <option value=""></option>
                            <?php
                             $sql1="SELECT name FROM drum_name";
                             $run1=sqlsrv_query($conn,$sql1);
                            while( $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC)){
?>
                            <option <?php if( $name==$row1['name']){  ?>selected <?php } ?> ><?php echo $row1['name']   ?></option>
                            <?php } ?> 
                        </select>
                    </label>
                    <label  class="form-label col-lg-3 col-md-6" for="fplant">From-Plant
                        <select  class="form-select" name="fplant" id="fplant" >
                            <option value=""></option>
                            <?php
                             $sql2="SELECT name FROM drum_plant";
                             $run2=sqlsrv_query($conn,$sql2);
                            while( $row2=sqlsrv_fetch_array($run2,SQLSRV_FETCH_ASSOC)){
?>  
                            <option <?php if($fplant==$row2['name'] )   { ?> selected <?php } ?> ><?php echo $row2['name']   ?></option>
                            <?php } ?>
                        </select>
                    </label>
                
                    <label  class="form-label col-lg-3 col-md-6" for="tplant">To-Plant
                        <select  class="form-select" name="tplant" id="tplant" >
                            <option value=""></option>
                            <?php
                            $sql2="SELECT name FROM drum_plant";
                            $run2=sqlsrv_query($conn,$sql2);
                            while( $row2=sqlsrv_fetch_array($run2,SQLSRV_FETCH_ASSOC)){
?>  
                            <option <?php if($fplant==$row2['name'] )   { ?> selected <?php } ?> ><?php echo $row2['name']   ?></option>
                            <?php } ?>
                           
                        </select>
                    </label>
                    
                    <label  class="form-label col-lg-3 col-md-6" for="dseries">Drum Series
                        <select  class="form-select" name="dseries" id="dseries" >
                            <option value=""></option>
                            <?php
                            $sql3="SELECT name FROM drum_series";
                            $run3=sqlsrv_query($conn,$sql3);
                            while( $row3=sqlsrv_fetch_array($run3,SQLSRV_FETCH_ASSOC)){
?>  
                            <option <?php if($dseries==$row3['name'])   { ?> selected <?php } ?> ><?php echo $row3['name'] ?></option>                        
                         <?php } ?>                   
                        </select>
                    </label>
                    
                    <label  class="form-label col-lg-3 col-md-6" for="dnum">Drum No.
                        <input class="form-control" type="number" id="dnum" name="dnum"  required>
                    </label>
                    <!-- <label  class="form-label col-lg-3 col-md-6" for="stage">Stage
                        <select  class="form-select" name="stage" id="stage" required>
                            <option value="armour drums">ARMOUR DRUMS </option>
                            <option value="conductor drums">CONDUCTOR DRUMS</option>
                            
                        </select>
                    </label>
                
                    <label  class="form-label col-lg-3 col-md-6" for="ncore">No of. Core
                        <input class="form-control" type="number" id="ncore" name="ncore" required>
                    </label>
                    
                    <label  class="form-label col-lg-3 col-md-6" for="corepair">Core/Pair
                        <select  class="form-select" name="corepair" id="corepair" required>
                            <option value=""></option>
                            <option value="core">Core</option>
                            <option value="pair">Pair</option>
                        </select>
                    </label>
                    
                    <label  class="form-label col-lg-3 col-md-6" for="sqmm">Sqmm
                        <input class="form-control" type="number" id="sqmm" name="sqmm" required>
                    </label>
                    
                    <label  class="form-label col-lg-3 col-md-6" for="ctype">Conductor-Type
                        <select  class="form-select" name="ctype" id="ctype" required>
                            <option value=""></option>
                            <option value="cu">CU</option>
                            <option value="alu">ALU</option>
                        </select>
                    </label>
                    
                    <label  class="form-label col-lg-3 col-md-6" for="qty">Qnty
                        <input class="form-control" type="number" id="qty" name="qty" required> 
                    </label>

                    <label  class="form-label col-lg-3 col-md-6" for="unit">Unit
                        <select  class="form-select" name="unit" id="unit" required>
                            <option value=""></option>
                            <option value="mtr">Mtr</option>
                            <option value="kg">Kg</option>
                        </select>
                    </label> -->
                                   
                    </div>
                    <div class="row ps-2">
                        <label  class="form-label col-lg-3 col-md-6" for="rem">Remark
                            <input class="form-control" type="text" id="rem" name="rem" required>
                        </label>
                        <div class="col"></div>
                        <div class="col-auto">
                           <button type="submit" class="btn  rounded-pill common-btn mt-3"  name="save" >Save</button>
                          <a type="" class="btn  rounded-pill btn-secondary mt-3" href="drumshift.php">Back</a>
                            <!-- <a href="session_destroy.php"  class="btn rounded-pill btn-danger mt-2" name="reset">Reset</a> -->
                        </div>
                    </div>
                </div> <br>       
            </form>
        
        <div class="divCss ">
            <table class="table table-bordered text-center table-striped table-hover mb-0" id="drumTable">
                <thead>
                    <tr class="bg-secondary text-light">
                        <th>Chal. No.</th>
                        <th>Date</th>
                        <th>Contractor Name</th>
                        <th>Name</th>
                        <th>From Plant</th>
                        <th>To Plant </th>
                        <th>Drum Series</th>
                        <th>Drum No.</th>
                        <!-- <th>Stage</th>
                        <th>No of Core</th>
                        <th>Core/Pair</th>
                        <th>Sqmm</th>
                        <th>Cond. Type</th>
                        <th>Qnty</th> -->
                        <th>Remark</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    
                        <?php
                            $sr=1;
                            $sql="SELECT * FROM Dshift order by Challanno desc ";
                            $run=sqlsrv_query($conn,$sql);
                            
                            while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                        ?>
                            <tr>
                                <td><?php echo $row['Challanno']  ?></td>
                                <td><?php echo $row['Date']->format('d-m-Y')  ?></td>
                                <td><?php echo $row['Name_of_contractor']  ?></td>
                                <td><?php echo $row['Name']  ?></td>
                                <td><?php echo $row['From_Plant']  ?></td>
                                <td><?php echo $row['To_Plant']  ?></td>
                                <td><?php echo $row['Drum_series']  ?></td>
                                <td><?php echo $row['Drum_No']  ?></td>
                                <!-- <td><?php echo $row['Stage']  ?></td>
                                <td><?php echo $row['No_of_core']  ?></td>
                                <td><?php echo $row['corepair']  ?></td>
                                <td><?php echo $row['Sqmm']  ?></td>
                                <td><?php echo $row['ConductorType']  ?></td>
                                <td><?php echo $row['Qnty'].' '.$row['Unit'] ?></td> -->
                                <td><?php echo $row['Remark']  ?></td>
                                <td class="tdCss"><a href="drumshift_edit.php?edit=<?php echo $row['id']?>" class="btn rounded-pill btn-warning btn-sm" >Edit</a></td>
                            </tr>
                        <?php
                         $sr++;  }
                        ?>                                       
                </tbody>
            </table>
        </div>
        
    </div>
</body>
</html>
<script>
     $('#dshift').addClass('active');

     $(document).ready(function(){
		var table = $('#drumTable').DataTable({   // initializes a DataTable using the DataTables library 
		    "processing": true,                  //This option enables the processing indicator to be shown while the table is being processed
			 dom: 'Bfrtip',                      // This option specifies the layout of the table's user interface B-buttons,f-flitering input control,T-table,I-informationsummary,P-pagination
			 ordering: false,                   //sort the columns by clicking on the header cells if true
			 destroy: true,                     //This option indicates that if this DataTable instance is re-initialized, 
                                                //the previous instance should be destroyed. This is useful when you need to re-create the table dynamically.
            
		 	lengthMenu: [
            	[ 10, 50, -1 ],
            	[ '10 rows','50 rows','Show all' ]
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