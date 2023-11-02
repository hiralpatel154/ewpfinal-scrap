<?php
include('../includes/dbcon.php');

$mon=$_POST['mon'];
$pmat=$_POST['pmat'];
//echo $pmat;

?>
<style>
     #pmattable input{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            text-align: center;
            padding:0px !important;
        }
        #pmattable td{
           /* padding:0px !important; */
        }
        .tqty{
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
        #pmattable{
            max-height:200px !important;
        }

        #pmattable th,
    #pmattable td {
        text-align: center;
        white-space:nowrap;
    }
        /* #pmattable th{
            padding:0px;
        }
       */
</style>
<!-- <form action="summary_db.php" method="post" id="purchaseform" autocomplete="off" enctype="multipart/form-data"> -->
<form id="purchase">
    <div class="total">
        <h5 >Total Qty: </h5> <h5><input class="tqty" type="number" id="tqty" name="tqty">
        <input type="hidden" name="temp" id="temp" value="<?php echo $id; ?>">
    </h5>
    </div>

    <table class="table table-bordered text-center table-striped table-hover mt-7" id="pmattable">
        <thead class="bg-secondary text-light">
            <th>Sr</th>
            <th style="width:50px;">Rev Date</th>
            <th style="width:140px;">Inv No.</th>
            <th>Inv Date.</th>
            <th>Party</th>
            <th>Item</th>
            <th>Pkg</th>
            <th>Qnty</th>
            <th>Rate</th>
            <th>Basic Amt</th>
            <th>Cancel</th>
        
        </thead>
        <tbody>
        <tr>
            <?php
            $sr=1;
            if($pmat=='GI WIRE'){
                $sql="SELECT
                ic1.sr_no,ic1.receive_date,ic1.invoice_date,ic1.invoice_no,ii.order_qnty,ii.order_rate,ii.p_pkg,ii.total_amt,ri.item,ri.m_code, pm.party_name 
                FROM
                    [RM_software].[dbo].[inward_ind] AS ii
                INNER JOIN
                [RM_software].[dbo].[inward_com] AS ic1 ON ii.sr_no = ic1.sr_no and ii.receive_at = ic1.receive_at
                INNER JOIN [RM_software].[dbo].[rm_item] ri ON ii.p_item=ri.i_code
                INNER JOIN [RM_software].[dbo].[rm_party_master] pm ON ic1.mat_from_party=pm.pid
                WHERE FORMAT(ic1.receive_date,'yyyy-MM') ='$mon' AND m_code=164  AND ic1.sr_no  NOT IN (select inw_id from  [EWP].[dbo].[purchase_data])  ";
            }
            elseif($pmat=='PVC COMPOUND'){
                $sql="SELECT
                ic1.sr_no,ic1.receive_date,ic1.invoice_date,ic1.invoice_no,ii.order_qnty,ii.order_rate,ii.p_pkg,ii.total_amt,ri.item,ri.m_code, pm.party_name 
                FROM
                    [RM_software].[dbo].[inward_ind] AS ii
                INNER JOIN
                [RM_software].[dbo].[inward_com] AS ic1 ON ii.sr_no = ic1.sr_no and ii.receive_at = ic1.receive_at
                INNER JOIN [RM_software].[dbo].[rm_item] ri ON ii.p_item=ri.i_code
                INNER JOIN [RM_software].[dbo].[rm_party_master] pm ON ic1.mat_from_party=pm.pid
                WHERE FORMAT(ic1.receive_date,'yyyy-MM') ='$mon' AND m_code IN (161,171,148,163) AND ic1.sr_no  NOT IN (select inw_id from  [EWP].[dbo].[purchase_data])";

                }
                else{
                    $sql="SELECT
                    ic1.sr_no,ic1.receive_date,ic1.invoice_date,ic1.invoice_no,ii.order_qnty,ii.order_rate,ii.p_pkg,ii.total_amt,ri.item,ri.m_code, pm.party_name 
                    FROM
                        [RM_software].[dbo].[inward_ind] AS ii
                    INNER JOIN
                    [RM_software].[dbo].[inward_com] AS ic1 ON ii.sr_no = ic1.sr_no and ii.receive_at = ic1.receive_at
                    INNER JOIN [RM_software].[dbo].[rm_item] ri ON ii.p_item=ri.i_code
                    INNER JOIN [RM_software].[dbo].[rm_party_master] pm ON ic1.mat_from_party=pm.pid
                    WHERE FORMAT(ic1.receive_date,'yyyy-MM') ='$mon' AND m_code =500 AND ic1.sr_no  NOT IN (select inw_id from  [EWP].[dbo].[purchase_data])";
                }
        
                $run=sqlsrv_query($conn,$sql);
                while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                    // echo $sql;
                ?>
                
                <td><?php echo $sr  ?>
                <input type="hidden" class="inw_id" name="inw_id[]" value="<?php echo $row['sr_no'] ?>">
                <input type="hidden" class="main_grad" name="main_grad" value="<?php echo $pmat ?>">
                <input type="hidden" class="mon" id="mon" name="mon" value="<?php echo $mon ?>"></td>
                <td ><input type="date" name="recdate[]" id="recdate[]" class="recdate" value="<?php echo $row['receive_date']->format('Y-m-d') ?>" readonly></td>
                <td><input type="number" name="invno[]" id="invno[]" class="invno" value="<?php echo $row['invoice_no']  ?>" readonly></td>
                <td><input type="date" name="invdate[]" id="invdate[]" class="invdate" value="<?php echo $row['invoice_date']->format('Y-m-d')  ?>" readonly></td>
                <td><input type="number" name="partyn[]" id="partyn[]" class="partyn" value="<?php echo $row['party_name']  ?>" readonly></td>
                <td><input type="number" name="item[]" id="item[]" class="item" value="<?php echo $row['item']  ?>" readonly></td>
                <td><input type="number"  name="pkg[]" id="pkg[]" class="pkg" value="<?php echo $row['p_pkg']  ?>" readonly></td>
                <td><input type="number" id="qty[]" class="qty" name="qty[]" value="<?php echo $row['order_qnty']  ?>" readonly></td>
                <td><input type="number" id="rate[]" class="rate" name="rate[]" value="<?php echo $row['order_rate']  ?>" readonly> </td>
                <td><input type="number"  id="amt[]" class="amt" name="amt[]" value="<?php echo $row['order_qnty']*$row['order_rate'] ?>" readonly></td>
                <td><input type="checkbox" class="remove-qty">
                <input type="hidden" class="checkbox-state" name="checkbox_state[]" value="0" ></td>
                    
        </tr>
    <?php  $sr++; } 
    ?>
    </tbody>
    </table>
</form>
<script>
    
    $(document).ready(function() {
    let totalSum = 0;

    // Update total sum when the page loads
    $('.qty').each(function() {
        const value = parseFloat($(this).val());
        if (!isNaN(value)) {
            totalSum += value;
        }
    });

    // Display the total sum
    $('#tqty').val(totalSum);

    // Update total sum when a checkbox is checked or unchecked
    $('.remove-qty').change(function() {
        const isChecked = $(this).is(':checked');
        const qtyToRemove = parseFloat($(this).closest('tr').find('.qty').val());

        if (!isNaN(qtyToRemove)) {
            if (!isChecked) {
                totalSum += qtyToRemove;
                // Toggle the checkbox-state value between 0 and 1
                $(this).closest('tr').find('.checkbox-state').val(0);
            } else {
                totalSum -= qtyToRemove;
                // Toggle the checkbox-state value between 0 and 1
                $(this).closest('tr').find('.checkbox-state').val(1);
            }

            $('#tqty').val(totalSum);
        }
    });

});


</script>

  
