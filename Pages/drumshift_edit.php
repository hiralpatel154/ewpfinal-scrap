<?php
include('../includes/dbcon.php');
include('../includes/header.php');  
include('../includes/session.php');  
$id=$_GET['edit'];
$sql="SELECT * FROM Dshift WHERE id='$id'";
$run=sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Entery</title>

    <style>
        .fl{
            margin-top:2rem;
        }

        .divCss {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
           
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
                <div class="col"><h4 class="pt-2 mb-0">Edit Drum details</h4></div>
                <div class="col-auto"> <button type="submit" class="btn  rounded-pill common-btn"  name="update" >Update</button></div>
                <div class="col-auto p-0"> <a type="" class="btn  rounded-pill btn-secondary " href="drumshift.php">Back</a></div>
            </div>

            <div class="divCss">
        
                <div class="row px-2">
                    <label  class="form-label  col-lg-3 col-md-6" for="cno">Challan No.
                        <input class="form-control " type="number" id="cno" name="cno" value="<?php echo $row['Challanno'] ?>"  >
                        <input type="hidden" name="id" id="id"  value="<?php echo $row['id'] ?>" >
                    </label>

                    <label  class="form-label  col-lg-3 col-md-6" for="date">Date
                        <input class="form-control" type="date" id="date" name="date" value="<?php echo $row['Date']->format('Y-m-d') ?>" >
                    </label>

                    <label  class="form-label  col-lg-3 col-md-6" for="nameoc">Name of Contractor
                        <select  class="form-select" name="nameoc" id="nameoc"   >
                            <option value=""></option>
                            <?php
                            $sql1="SELECT name FROM drum_contractor";
                            $run1=sqlsrv_query($conn,$sql1);
                           while( $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC)){
?>
                            <option <?php if( $row['Name_of_contractor']==$row1['name'])  { ?> selected <?php } ?> ><?php echo $row1['name']  ?></option>
                            <?php }
                            ?>
                        </select>
                    </label>
                    
                    <label  class="form-label  col-lg-3 col-md-6" for="name">Name
                        <select  class="form-select" name="name" id="name" value="<?php echo $row['Name'] ?>">
                            <option value=""></option>
                            <?php
                             $sql2="SELECT name FROM drum_name";
                             $run2=sqlsrv_query($conn,$sql2);
                            while( $row2=sqlsrv_fetch_array($run2,SQLSRV_FETCH_ASSOC)){
                                ?>
                            <option <?php if($row['Name'] ==$row2['name']  ) { ?> selected <?php } ?>><?php echo $row2['name']   ?></option>
                            <?php }
                            ?>
                        </select>
                    </label>

                    <label  class="form-label  col-lg-3 col-md-6" for="fplant">From-Plant
                        <select  class="form-select" name="fplant" id="fplant" >
                            <option value=""></option>
                            <?php
                             $sql3="SELECT name FROM drum_plant";
                             $run3=sqlsrv_query($conn,$sql3);
                            while( $row3=sqlsrv_fetch_array($run3,SQLSRV_FETCH_ASSOC)){
                                ?>  
                            <option <?php if($row['From_Plant']==$row3['name']  ) {?> selected <?php }   ?> selected ><?php echo $row3['name']   ?></option>
                           <?php }
                           ?>
                        </select>
                    </label>
                    
                    <label  class="form-label  col-lg-3 col-md-6" for="tplant">To-Plant
                        <select  class="form-select" name="tplant" id="tplant" >
                            <option value=""></option>
                            <?php
                           $sql3="SELECT name FROM drum_plant";
                           $run3=sqlsrv_query($conn,$sql3);
                          while( $row3=sqlsrv_fetch_array($run3,SQLSRV_FETCH_ASSOC)){
                                ?>
                            <option <?php if($row['To_Plant']==$row3['name']  ) {?> selected <?php }   ?> selected ><?php echo $row3['name']   ?></option>
                           <?php }
                           ?>
                        </select>
                    </label>
                    
                    <label  class="form-label  col-lg-3 col-md-6" for="dseries">Drum Series
                        <select  class="form-select" name="dseries" id="dseries" >
                            <option value=""></option>
                            <?php
                            $sql4="SELECT name FROM drum_series";
                            $run4=sqlsrv_query($conn,$sql4);
                            while( $row4=sqlsrv_fetch_array($run4,SQLSRV_FETCH_ASSOC)){
                                ?>
                            <option <?php if($row['Drum_series']==$row4['name'])   {?> selected <?php } ?>><?php echo $row4['name'] ?></option>                        
                       <?php }
                       ?>                      
                        </select>
                    </label>
                    
                    <label  class="form-label  col-lg-3 col-md-6" for="dnum">Drum No.
                        <input class="form-control" type="number" id="dnum" name="dnum" value="<?php echo $row['Drum_No'] ?>">
                    </label>
                    
                    <!-- <label  class="form-label  col-lg-3 col-md-6" for="stage">Stage
                        <select  class="form-select" name="stage" id="stage" >
                            <option <?php if($row['Stage']=="armour drums")   ?> selected >ARMOUR DRUMS </option>
                            <option <?php if($row['Stage']=="conductor drums")   ?> selected >CONDUCTOR DRUMS</option>
                          
                        </select>
                    </label>
                
                    <label  class="form-label  col-lg-3 col-md-6" for="ncore">No of. Core
                        <input class="form-control" type="number" id="ncore" name="ncore" value="<?php echo $row['No_of_core'] ?>">
                    </label>
                    
                    <label  class="form-label  col-lg-3 col-md-6" for="corepair">Core/Pair
                        <select  class="form-select" name="corepair" id="corepair" >
                            <option value=""></option>
                            <option  <?php if($row['Stage']=="core")   ?> selected >Core</option>
                            <option  <?php if($row['Stage']=="pair")   ?> selected >Pair</option>
                        </select>
                    </label>
                    
                    <label  class="form-label  col-lg-3 col-md-6" for="sqmm">Sqmm
                        <input class="form-control" type="number" id="sqmm" name="sqmm" value="<?php echo $row['Sqmm'] ?>">
                    </label>

                    
                    <label  class="form-label  col-lg-3 col-md-6" for="ctype">Conductor-Type
                        <select  class="form-select" name="ctype" id="ctype" >
                            <option value=""></option>
                            <option <?php if($row['ConductorType']=="cu")   ?> selected >CU</option>
                            <option <?php if($row['ConductorType']=="alu")   ?> selected >ALU</option>
                        </select>
                    </label>
                    
                    <label  class="form-label  col-lg-3 col-md-6" for="qty">Qnty
                        <input class="form-control" type="number" id="qty" name="qty" value="<?php echo $row['Qnty'] ?>"> 
                    </label>

                    <label  class="form-label  col-lg-3 col-md-6" for="unit">Unit
                        <select  class="form-select" name="unit" id="unit" value="<?php echo $row['Unit'] ?>">
                            <option value=""></option>
                            <option  <?php if($row['Unit']=="mtr")   ?> selected >Mtr</option>
                            <option  <?php if($row['Unit']=="kg")   ?> selected >Kg</option>
                        </select>
                    </label> -->

                    <label  class="form-label  col-lg-3 col-md-6" for="rem">Remark
                        <input class="form-control" type="text" id="rem" name="rem" value="<?php echo $row['Remark'] ?>">
                    </label>
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

