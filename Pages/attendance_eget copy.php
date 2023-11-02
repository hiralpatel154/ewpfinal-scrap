<?php
include('../includes/dbcon.php');


if (isset($_POST['month']) && isset($_POST['cont'])) {
    $month = $_POST['month'];
    $cont = $_POST['cont'];
    $ldate = date('Y-m-t', strtotime($_POST['month']));
    $fdate = date('Y-m-01', strtotime($_POST['month']));
    $days = date('t', strtotime($_POST['month']));

    $sql = "SELECT * from emp_name as e LEFT JOIN attendance as a on e.pay_code = a.paycode where a.month =  '$month' AND e.STATUS='Active' AND a.contractor = '$cont'";
    $result = sqlsrv_query($conn, $sql);
    ?>
    <table class="table table-bordered text-center mb-0" id="att-data">
        <thead>
            <tr class="bg-light">
                <th>Paycode</th>
                <th>Name</th>
                <th>Department</th>
                <?php for ($i = 1; $i <= $days; $i++) { ?>
                    <th>
                        <?php echo $i ?>
                    </th>
                <?php } ?>
                <th>Days</th>
                <th>Rate</th>
                <th>Basic</th>
                <th>HRA</th>
                <th>Allow.</th>
                <th>OT</th>
                <th>Salary</th>
            </tr>
            <tr>
                <th colspan="3"></th>
                <?php
                for ($i = 1; $i <= $days; $i++) {
                    $day = date('D', strtotime($month . '-' . $i));
                    ?>
                    <th class="<?php echo $day ?>">
                        <?php echo $day ?>
                    </th>
                <?php } ?>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                 ?>

                <tr>
                    <td>
                        <?php echo $row['pay_code'] ?>
                    </td>
                    <td>
                        <?php echo $row['name'] ?>
                    </td>
                    <td>
                        <?php echo $row['department'] ?>
                    </td>

                    <?php
                    for ($i = 1; $i <= $days; $i++) {
                        $date = date('Y-m-d', strtotime($month . '-' . $i));
                        $query = "SELECT * from [bcsdb].[dbo].[tblTimeRegister] where PAYCODE = '" . $row['pay_code'] . "' AND DateOFFICE = '$date'";
                        $qresult = sqlsrv_query($conn, $query);
                        $qrow = sqlsrv_fetch_array($qresult, SQLSRV_FETCH_ASSOC);

                        $dbquery = "SELECT * from attendance where month='$month' AND paycode='" . $row['pay_code'] . "'";
                        $dbresult = sqlsrv_query($conn, $dbquery);
                        $dbrow = sqlsrv_fetch_array($dbresult, SQLSRV_FETCH_ASSOC);
                        ?>
                        <td>

                            <?php echo $qrow['STATUS'] ?? '' ?>
                        </td>
                    <?php } ?>
                    <?php

                    $query = "SELECT sum(PRESENTVALUE) as PRESENTVALUE from [bcsdb].[dbo].[tblTimeRegister] where PAYCODE = '" . $row['pay_code'] . "' AND DateOFFICE between '$fdate' and '$ldate'";
                    $qresult = sqlsrv_query($conn, $query);
                    $qrow = sqlsrv_fetch_array($qresult, SQLSRV_FETCH_ASSOC);
                    ?>
                    <td>
                        <?php echo $qrow['PRESENTVALUE'] ?>
                    </td>

                    <td>
                       
                    </td>
                    <td class="tdCss">
                        <input type="number" name="basic[]" id="basic" class="form-control form-control-sm num-input"
                            step="0.01" value="<?php echo $dbrow['basic'] ?? '' ?>" readonly>
                        <input type="hidden" name="paycode[]" value="<?php echo $row['pay_code'] ?>">
                    </td>

                    <td class="tdCss"><input type="number" name="hra[]" id="" class="form-control form-control-sm num-input"
                            step="0.01" value="<?php echo $dbrow['hra'] ?? '' ?>">
                    </td>
                    <td class="tdCss"><input type="number" name="allowance[]" id=""
                            class="form-control form-control-sm num-input" step="0.01"
                            value="<?php echo $dbrow['allowance'] ?? '' ?>"></td>
                    <td class="tdCss"><input type="number" name="ot[]" id="" class="form-control form-control-sm num-input"
                            step="0.01" value="<?php echo $dbrow['ot'] ?? '' ?>"></td>
                    <td class="tdCss"><input type="number" name="salary[]" id="" class="form-control form-control-sm num-input"
                            value="<?php echo $dbrow['salary'] ?? '' ?>" readonly>
                            <input type="hidden" name="id[]"
                            value="<?php echo $dbrow['id'] ?? '' ?>"></td>

                </tr>
            <?php } ?>


        </tbody>
    </table>
    <?php
}
?>
<script>
    $(document).ready(function () {
        $('#att-data').DataTable({
            "processing": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "responsive": {
                "details": true
            },
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" }
            ],

            dom: 'Bfrtip',
            buttons: ['pageLength'],
            language: {
                searchPlaceholder: "Search..."
            }
        });
    });
</script>