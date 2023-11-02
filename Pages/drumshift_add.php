<?php
include('../includes/dbcon.php');
include('../includes/header.php');  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Entery</title>

    <style>
        .fl{
            margin-top:2rem;
        }
        form label{
            width:20%;
        }
        .common-btn{
            background-color: #62bdae;
            border:none;
            color:white !important;
        }
        .col-lg-3{
            padding: 0px 4px;
        }

    </style>
</head>
<body>
    <div class="container-fluid fl">
   
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
                    $rem=$row1['Remark'];
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

                    <label  class="form-label col-lg-3 col-md-6" for="rem">Remark
                        <input class="form-control" type="text" id="rem" name="rem" value="<?php echo $rem ?>">
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
                    <div class="row mb-3">
                        <div class="col-auto">
                           <button type="submit" class="btn  rounded-pill common-btn"  name="save" >Save</button>
                          <a type="" class="btn  rounded-pill btn-secondary " href="drumshift.php">Back</a>
                            <!-- <a href="session_destroy.php"  class="btn rounded-pill btn-danger mt-2" name="reset">Reset</a> -->
                        </div>
                    </div>
                </div>            
            </form>
    </div>
</body>
</html>

<?php

include('../includes/footer.php');

?>
<script>
     $('#dshift').addClass('active');






 
</script>

