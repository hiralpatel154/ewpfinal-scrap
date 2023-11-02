<?php
include('../includes/dbcon.php');
$mon=$_POST['mon'];
$pmat=$_POST['pmat'];
?>
<!-- <div class="total">
    <h5 >Total Qty:</h5> <h5><input type="number" id="tqty" name="tqty"> </h5>
</div> -->
<!-- <form action="summary_db.php" method="post" id="secondform" autocomplete="off" enctype="multipart/form-data"> -->
    <form id="addform">
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
        
        <tr>
            <td><?php echo 1  ?>
            <input type="hidden" class="inw_id" name="inw_id" value="0" ></td>
            <input type="hidden" class="main_grad" name="main_grad" value="<?php echo $pmat ?>" >
            <input type="hidden" class="mon" id="mon" name="mon" value="<?php echo $mon ?>" >
            <td>
                <input type="date" name="recdate" id="recdate" class="recdate" required 
                min="<?php echo $mon ?>-01" 
                max="<?php echo $mon ?>-<?php echo date('t',strtotime($mon)); ?>">
            </td>
            <td><input type="number" name="invno" id="invno" class="invno" required></td>
            <td><input type="date" name="invdate" id="invdate" class="invdate" required></td>
            <td><input type="number" name="partyn" id="partyn" class="partyn" required></td>
            <td><input type="number" name="item" id="item" class="item" required></td>
            <td><input type="number"  name="pkg" id="pkg" class="pkg" required></td>
            <td><input type="number" id="qty" class="qty" name="qty" required></td>
            <td><input type="number" id="rate" class="rate" name="rate" required> </td>
            <td><input type="number"  id="amt" class="amt" name="amt" required></td>
        </tr>
   </table>
</form>
   <script>

$(document).on("change",".qty,.rate",function(){
        var amt = 0;
        var totalSum= 0;
        var rate = $(this).closest('tr').find('.rate').val();
        var qty = $(this).closest('tr').find('.qty').val(); 
        $(this).closest('tr').find('.amt').val(rate*qty);

});
    $(document).ready(function () {
    let totalSum = 0;

    // Iterate over each row in the table
    $('.qty').each(function () {
        const value = parseFloat($(this).val());
        if (!isNaN(value)) {
            totalSum += value;
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

//disable dates


   </script>