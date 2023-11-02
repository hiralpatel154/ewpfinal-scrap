<?php
include('../includes/dbcon.php');
include('../includes/header.php');  
include('../includes/session.php');  
$id=$_GET['edit'];
$sql="SELECT * FROM scraphead WHERE id='$id'";
$run=sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Scrapdata</title>
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

        #scrapTable{
            table-layout: auto;
            width: 100%;

        }       
        #scrapTable input,#scrapTable select{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            text-align: center;
        }
        
    </style>
</head>
<body>
<div class="container-fluid fl">
        
        <form action="scrapdata_db.php" method="post" autocomplete="off">
            <div class="row mb-3">
                <div class="col"><h4 class="pt-2 mb-0">Edit Scrap data</h4></div>
                <div class="col-auto"> <button type="submit" class="btn  rounded-pill common-btn"  name="update" >Update</button></div>
                <div class="col-auto p-0"> <a type="" class="btn  rounded-pill btn-secondary " href="scrapdata.php">Back</a></div>
            </div>

            <div class="divCss">
                <div class="row px-2">
                    <label class="form-label col-lg-3 col-md-6" for="stype">Type of Scrap
                        <select  class="form-select" name="stype" id="stype" value="<?php echo $row['Typeofscrap']   ?>"required>
                            <option value="">--Select--</option>
                            <option <?php if($row['Typeofscrap'] =="CP") {?> selected <?php } ?> value="CP" >Control/Power</option>
                            <option <?php if($row['Typeofscrap'] =="IP") {?> selected <?php } ?> value="IP" >Instru/Panni</option>
                            <option <?php if($row['Typeofscrap'] =="OE") {?> selected <?php } ?> value="OE" >Other Extra</option>
                        </select>
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="fdate">From Date
                        <input class="form-control" type="date" id="fdate" name="fdate" onchange="checkDateSelection()" value="<?php echo $row['Fromdate']->format('Y-m-d') ?>"  required >
                        <input type="hidden" name="id" id="id"  value="<?php echo $row['id'] ?>" >
                        
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="tdate">To Date
                        <input class="form-control" type="date" id="tdate" name="tdate" onchange="checkDateSelection()" value="<?php echo $row['Todate']->format('Y-m-d') ?>" required >
                        <p id="alertMessage" style="color: red;"></p>
                    </label>
                    
                   

                    <label class="form-label col-lg-3 col-md-6" for="month">Month
                        <input class="form-control" type="text" id="month" name="month" value="<?php echo $row['Month'] ?>"  readonly required>
                    </label>
                    
                    <label class="form-label col-lg-3 col-md-6" for="tname">Team Name
                        <select  class="form-select" name="tname" id="tname" value="<?php echo $row['Teamname'] ?>"  required>
                            <option value="">--Select--</option>
                            <?php
                            $sql1="SELECT name FROM scrap_team";
                            $run1=sqlsrv_query($conn,$sql1);
                            while($row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC)){
                            ?>
                            <option <?php if($row['Teamname']==$row1['name']) { ?> selected <?php } ?> > <?php echo $row1['name'] ?> </option>
                            <?php
                            } ?>  
                        </select>
                    </label>

                    <label  class="form-label col-lg-3 col-md-6" for="mp">M.P
                        <input class="form-control" type="number" id="mp" name="mp" value="<?php echo $row['mp'] ?>" readonly >
                    </label>

                    <label  class="form-label col-lg-3 col-md-6" for="twt">Total WT
                        <input class="form-control twt" type="number" id="twt" name="twt" value="<?php echo $row['Totalwt'] ?>"  readonly >
                    </label>

                    <label  class="form-label col-lg-3 col-md-6" for="tamt">Total Amount
                        <input class="form-control" type="number" id="tamt" name="tamt" value="<?php echo $row['Totalamt'] ?>" readonly  >
                    </label>
                                        
                </div>

                <div class="row mb-3">              
                    <div class="col ms-2"> <button type="button"  id="addRowBtn" class="btn  rounded-pill btn-danger mt-2" >Add</button></div>                
                </div>    

                <table  class="table table-bordered text-center mb-0" id="scrapTable" >
                    <thead>
                        
                        <th>Type</th>
                        <th>Name</th>
                        <th>Remark</th>
                        <th>Qnty</th>
                        <th>Rate</th>
                        <th>Amount</th>   
                        <th></th>                  
                    </thead>
                    <tbody>
                            <tr>
                                <?php
                                $sql2="SELECT * FROM scrapdetail WHERE head_id ='$id'";
                                $run2=sqlsrv_query($conn,$sql2);
                                while($row2=sqlsrv_fetch_array($run2,SQLSRV_FETCH_ASSOC)){
                                    ?>                       
                            <td>
                            <input type="hidden" name="detailSr[]" value="<?php echo $row2['id'] ?>">
                            <input type="text" id="type" name="type[]" value="<?php echo $row2['Type'] ?>"></td>
                            <td><input  class="name" type="text" id="name[]" name="name[]" value="<?php echo $row2['Name'] ?>"></td>
                            <td><input type="text" id="rem[]" class="rem" name="rem[]" value="<?php echo $row2['Remark'] ?>"></td>
                            <td><input class="qty" type="number" id="qty[]" name="qty[]" value="<?php echo $row2['qnty'] ?>"></td>
                            <td><input  class="rate" type="number" id="rate[]" name="rate[]" value="<?php echo $row2['rate']   ?>"> </td>
                            <td><input class="amt" type="number" id="amt[]" name="amt[]" value="<?php echo $row2['amount'] ?>" readonly></td>       
                            <td></td>                    
                            <?php                          
                            ?>
                        </tr>
                        <?php
                            }              
                            ?>                      
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</body>
</html>
<script>
     $('#sdata').addClass('active');
     //clode modals
$(document).ready(function() {

$(document).on('click','#purchaseform', function(){
    $.ajax({                                  
        url:'summary_purchase_db.php',
        type:'post',
        data:$('#purchase').serialize(),       
                                            
        success:function(response){          
        console.log(response);                                    
                                                            
                                                                
        alert("Saved Successfully"); 
        $('#pmat').modal('hide');
        
    }
})
});

$(document).on('click','#updateButton', function(){
    $.ajax({                                 
        url:'summary_purchasecomp_db.php',
        type:'post',
        data:$('#purcomplete').serialize(),       
                                                
        success:function(response){          
        console.log(response);                                    
            
        alert("Updated Successfully"); 
        $('#pmat').modal('hide');

    }
})
});

$(document).on('click','#secondform', function(){
    $.ajax({                                 
        url:'summary_purchasecomp_db.php',
        type:'post',
        data:$('#add').serialize(),       
                                                
        success:function(response){          
        console.log(response);                                    
            
        alert("saved Successfully"); 
        $('#secondModal').modal('hide');
    }
})
});
});                       
     $(document).ready(function () {
        var selectedType = $('#stype').val();
        if(selectedType !='OE'){
        $('.rate').prop('readonly', true);
        }else{
            $('.rate').prop('readonly', false);
        }
     });

    $(document).on("change", ".amt", function () {
            console.log('sd');    
            updateTotalamt();
            });
  
            $(document).on('focusout','.qty',function(){
                let totalSum = 0;
                let totalAmt = 0;
                $('.qty').each(function () {
                    const value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        totalSum += value;
                    } 
                });
                // Display the total sum
                $('#twt').val(totalSum);

                $('.amt').each(function () {
                    const value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        totalAmt += value;
                    } 
                });
                // Display the total sum
                $('#tamt').val(totalAmt);
            });


    function updateTotalamt() {
            let totalSum = 0;
          
         $('.amt').each(function () {
                
            const value = parseFloat($(this).val());
   
                if (!isNaN(value)) {
                
                    totalSum += value;
                }
            });

            // Display the total sum
            $('#tamt').val(totalSum);
    }

    //for calculating amount
    $(document).on("change",".qty,.rate",function(){
        var rate = $(this).closest('tr').find('.rate').val();
        var qty = $(this).closest('tr').find('.qty').val(); 
        $(this).closest('tr').find('.amt').val(rate*qty);
    
    });

 
    $('#fdate').on('change', function () {
        const selectedDate = $(this).val();
        const dateParts = selectedDate.split('-'); // Assuming date format is YYYY-MM-DD

        if (dateParts.length === 3) {
            const year = parseInt(dateParts[0]);
            const month = parseInt(dateParts[1]);
            const day = parseInt(dateParts[2]);

            // Check if the date is valid
            if (!isNaN(year) && !isNaN(month) && !isNaN(day)) {
                // Create a Date object and set the selected date
                const date = new Date(year, month - 1, day); // Month is 0-based, so subtract 1

                // Get the full month name
                const fullMonthName = date.toLocaleString('default', { month: 'long' });

                // Set the full month name in the #month input
                $('#month').val(fullMonthName);
            } else {
                // Handle invalid date input
                $('#month').val('');
            }
        } else {
            // Handle invalid date input
            $('#month').val('');
        }
    });

        function checkDateSelection() {
            var fromDate = document.getElementById("fdate").value;
            var toDate = document.getElementById("tdate").value;
            var alertMessage = document.getElementById("alertMessage");
           

            if (fromDate === "" || toDate === "") {
                alertMessage.textContent = "'To Date' must be grater than 'From Date'";
                
            } 
         else {
                alertMessage.textContent = "";
             
            }
        }
        $(document).ready(function() {
         //add extra row at end of table
        // Add an event listener to the "Add" button
        $('#addRowBtn').on('click', function () {
            // Get a reference to the tbody of the table
            const tbody = $('#scrapTable tbody');

            // Create a new row and append it to the tbody
            const newRow = $('<tr>');
            newRow.html(' <td><input type="text" class="type" id="type" name="type[]" value="Other"></td> <td> <select class="name" id="name[]" name="name[]"  required><option value="">--Select--</option><option value="Bare Cu">Bare Cu</option><option value="Tin Cu">Tin Cu</option><option value="Alu">Alu</option><option value="PVC">PVC</option><option value="XLPE">XLPE</option><option value="GI">GI</option><option value="Tape">Tape</option><option value="PVC-D(RE-OUT)">PVC-D(RE-OUT)</option></select></td> <td><input type="text" id="rem[]" class="rem" name="rem[]"  ></td> <td><input class="qty" type="number" id="qty[]" name="qty[]"></td> <td><input class="rate" type="number" id="rate[]" name="rate[]" value="0" ></td> <td><input class="amt" type="number" id="amt[]" name="amt[]"></td>,<td><button class="btn-sm btn-danger remove-row" >X</button></button></td>');

            // Append the new row to the table
            tbody.append(newRow);

            // Add an event listener for input changes in the new row
            newRow.find('.qty, .rate').on('input', function () {
                updateRowAmount(newRow);
            });
               // Add an event listener to the delete button
            newRow.find('.remove-row').on('click', function () {
                    deductRowValues(newRow);
                     newRow.remove(); // Remove the row when the button is clicked
    });
        });

        // Function to update the amount for a row
        function updateRowAmount(row) {
            let totalAmt = 0;
            const qty = parseFloat(row.find('.qty').val());
            const rate = parseFloat(row.find('.rate').val());
            const amt = isNaN(qty) || isNaN(rate) ? 0 : qty * rate;
            row.find('.amt').val(amt);
            
            $('.amt').each(function() {
                const value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    totalAmt += value;
                }
            });
            // Display the total sum
            $('#tamt').val(totalAmt);
        }
         // Function to deduct the values when a row is removed
         function deductRowValues(row) {
            const amt = parseFloat(row.find('.amt').val()) || 0;
            const qty = parseFloat(row.find('.qty').val()) || 0;
            const currentTwt = parseFloat($('#twt').val()) || 0;
            const currentTamt = parseFloat($('#tamt').val()) || 0;

            // Update twt and tamt by subtracting the amount from the row being removed
            $('#twt').val(currentTwt - qty);
            $('#tamt').val(currentTamt - amt);
        }
    //     to delete row
    //     $(document).ready(function () {
    //     // Attach a click event handler to the delete buttons
    //     $('.delete-row').on('click', function () {
    //         // Get the unique identifier for the row to be deleted
    //         var rowId = $(this).data('row-id');

    //         // Find the parent row of the delete button and remove it
    //         $(this).closest('tr').remove();

          
    //     });
    // });

        //for fetching rates for particular scrap type
        $('#stype').on('change', function () {
                    var stype= $('#stype').val();
            $.ajax({
            url: 'scrapdata_detail.php',
            type: 'post',
            dataType: 'json',
            data: {stype:stype},
            
                success:function(data){
                    $('.name').each(function (index) {
                       // $(this).closest('tr').find('.rate').val(data[index]);
                       var $rateInput = $(this).closest('tr').find('.rate');
                        $rateInput.val(data[index]);

                        if(stype === 'CP'|| stype=== 'IP') {
                            $rateInput.prop('readonly', true);
                        }else {
                            $rateInput.prop('readonly', false);
                        }
                    });
            
                },
                error:function(res){
                    console.log(res);
            } 
        });
        });
    });

</script>