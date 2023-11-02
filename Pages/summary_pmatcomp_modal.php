<?php
include('../includes/dbcon.php');
$mon=$_POST['mon'];
$pmat=$_POST['pmat'];
// $id = $_POST['id'];
// echo $pmat;


?>
<style>
     #pmattable input{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            text-align: center;
        }
        input{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            /* text-align: center; */
        }
        .total{
            display:flex;
            flex-direction:row;
            white-space:nowrap;
            
        }
        #purcomplete{
            overflow-y: scroll; 
            overflow-x:none;
            max-height: 500px; 
        }
</style>

<!-- <form action="summary_db.php" method="post" id="purchaseform" autocomplete="off" enctype="multipart/form-data"> -->
<form id="purcomplete">
    <div class="total">
        <h5 >Total Qty : </h5> <h5><input type="number" id="tqty" name="tqty">
        <input type="hidden" name="tempid" id="tempid" value="<?php echo $id; ?>"></h5>
    </div>

    <table class="table table-bordered text-center table-striped table-hover mt-7" id="pmattable">
        <tr class="bg-secondary text-light">
            <th>Sr</th>
            <th>Rev Date</th>
            <th>Inv No.</th>
            <th>Inv Date.</th>
            <th>Party</th>
            <th>Item</th>
            <th>Pkg</th>
            <th>Qnty</th>
            <th>Rate</th>
            <th>Basic Amt</th>
            <th>Cancel</th>
        </tr>
        <tr>
            <?php
            $sr=1;
        if($pmat=='GI WIRE'){
            $sql="SELECT * FROM purchase_data WHERE FORMAT(rcv_date,'yyyy-MM') ='$mon' AND main_grade='GI WIRE' ";
        }
        elseif($pmat=='PVC COMPOUND'){
            $sql="SELECT * FROM purchase_data WHERE FORMAT(rcv_date,'yyyy-MM') ='$mon' AND main_grade ='PVC COMPOUND' ";
        }
        else{
            $sql="SELECT * FROM purchase_data WHERE FORMAT(rcv_date,'yyyy-MM') ='$mon' AND main_grade not in( 'GI WIRE', 'PVC COMPOUND')";

        }
        
        $run=sqlsrv_query($conn,$sql);
            while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
            ?>
            <td><?php echo $sr  ?>
                <input type="hidden" class="uid" name="uid[]" value="<?php echo $row['id'] ?>"></td>
                <input type="hidden" class="inw_id" name="inw_id[]" value="<?php echo $row['inw_id'] ?>">
                <input type="hidden" class="main_grad" name="main_grad" value="<?php echo $row['main_grade'] ?>" >
                <input type="hidden" class="mon" id="mon" name="mon" value="<?php echo $row['month'] ?>">
            </td>    
            <td><input type="date" name="recdate[]" id="recdate[]" class="recdate" value="<?php echo $row['rcv_date']->format('Y-m-d') ?>" readonly ></td>
            <td><input type="number" name="invno[]" id="invno[]" class="invno" value="<?php echo $row['inv_no']  ?>" readonly></td>
            <td><input type="date" name="invdate[]" id="invdate[]" class="invdate" value="<?php echo $row['inv_date']->format('Y-m-d')  ?>" readonly></td>
            <td><input type="number" name="partyn[]" id="partyn[]" class="partyn" value="<?php echo $row['party']  ?>" readonly></td>
            <td><input type="number" name="item[]" id="item[]" class="item" value="<?php echo $row['item']  ?>" readonly></td>
            <td><input type="number"  name="pkg[]" id="pkg[]" class="pkg" value="<?php echo $row['pkg']  ?>" readonly></td>
            <td><input type="number" id="qty[]" class="qty" name="qty[]" value="<?php echo $row['qnty']  ?>" readonly></td>
            <td><input type="number" id="rate[]" class="rate" name="rate[]" value="<?php echo $row['rate']  ?>" readonly> </td>
            <td><input type="number"  id="amt[]" class="amt" name="amt[]" value="<?php echo $row['qnty']*$row['rate'] ?>" readonly></td>
        <td>
            <input type="checkbox" class="remove-qty" <?php echo ($row['is_cancel'] == 1) ? 'checked' : ''; ?>>
            <input type="hidden" class="checkbox-state" name="checkbox_state[]" value="<?php echo $row['is_cancel'] ?>" >
        </td> 

        </tr>
    <?php  $sr++; }  
    ?>
    </table>
</form>
   
   <script>
 $(document).ready(function () {


    
    let totalSum = 0;

    // Iterate over each row in the table
    // $('.qty').each(function () {
    //     const value = parseFloat($(this).val());
    //     if (!isNaN(value)) {
    //         totalSum += value;
    //     }
    // });

    // // Display the total sum
    // $('#tqty').val(totalSum);

       // Iterate over each row in the table
       $('.qty').each(function (index) {
        const isChecked = !$('.remove-qty').eq(index).is(':checked');
        const qty = parseFloat($(this).val());

        if (!isNaN(qty) && isChecked) {
            totalSum += qty;
        }
    });

    // Display the total sum
    $('#tqty').val(totalSum);


    // Event listener for checkbox changes
    $('.remove-qty').change(function () {
        const isChecked = $(this).is(':checked');
        const qtyToRemove = parseFloat($(this).closest('tr').find('.qty').val());

        if (!isNaN(qtyToRemove)) {
            totalSum += isChecked ? -qtyToRemove : qtyToRemove;
            $('#tqty').val(totalSum);
        }

        // Get the checkbox state input
        const checkboxStateInput = $(this).closest('tr').find('.checkbox-state');

        // Update the hidden input to '1' when the checkbox is checked, '0' when unchecked
        checkboxStateInput.val(isChecked ? '1' : '0');
    });
});


   </script>