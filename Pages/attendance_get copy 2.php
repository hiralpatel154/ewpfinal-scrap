<?php
include('../includes/dbcon.php');
$typee = $_POST['typee'];

// if type is blank
if ($typee == 'blank') {
    // NATU MAKWANA
    $sql1 = "SELECT  * from emp_name where isDelete=0 AND team = 'NATU MAKWANA'";
    $result1 = sqlsrv_query($conn, $sql1);

    // HARI RAM SUTHAR
    $sql12 = "SELECT  * from emp_name where isDelete=0 AND team = 'HARI RAM SUTHAR'";
    $result12 = sqlsrv_query($conn, $sql12);

    // OTHERS
    $sql13 = "SELECT  * from emp_name where isDelete=0 AND team = 'OTHERS'";
    $result13 = sqlsrv_query($conn, $sql13);

    if (isset($_POST['month']) && isset($_POST['cont'])) {
        $month = $_POST['month'];
        $contractor = $_POST['cont'];
        $ldate = date('Y-m-t', strtotime($_POST['month']));
        $fdate = date('Y-m-01', strtotime($_POST['month']));
        $days = date('t', strtotime($_POST['month']));
        ?>
        <!-- NATU MAKWANA -->
        <div class="divCss">
            <table class="table table-bordered text-center mb-0" id="att-all-data">
                <h3 class="mb-3 text-center">NATU MAKWANA</h3>
                <thead>
                    <tr class="bg-light">
                        <th>Paycode</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Team</th>
                        <?php for ($i = 1; $i <= $days; $i++) { ?>
                            <th>
                                <?php echo $i ?>
                            </th>
                        <?php } ?>
                        <th>Days</th>
                        <th>Rate</th>
                        <th>Basic</th>
                        <th>Att. Bonus</th>
                        <th>HRA</th>
                        <th>Allow.</th>
                        <th>OT</th>
                        <th>Salary</th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row1 = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)) {
                        ?>

                        <tr>
                            <td>
                                <?php echo $row1['pay_code'] ?>
                            </td>
                            <td>
                                <?php echo $row1['name'] ?>
                            </td>
                            <td>
                                <?php echo $row1['department'] ?>
                            </td>
                            <td>
                                <?php echo $row1['team'] ?>
                            </td>

                            <?php
                            for ($i = 1; $i <= $days; $i++) {
                                $date = date('Y-m-d', strtotime($month . '-' . $i));
                                $query = "SELECT * from [bcsdb].[dbo].[tblTimeRegister] where PAYCODE = '" . $row1['pay_code'] . "' AND DateOFFICE = '$date'";
                                $qresult = sqlsrv_query($conn, $query);
                                $qrow = sqlsrv_fetch_array($qresult, SQLSRV_FETCH_ASSOC);

                                $dbquery = "SELECT * from attendance where month='$month' AND paycode='" . $row1['pay_code'] . "'";
                                $dbresult = sqlsrv_query($conn, $dbquery);
                                $dbrow = sqlsrv_fetch_array($dbresult, SQLSRV_FETCH_ASSOC);
                                ?>
                                <td>

                                    <?php echo $qrow['STATUS'] ?? '' ?>
                                </td>
                            <?php } ?>
                            <?php

                            $query = "SELECT SUM(
                            CASE
                                WHEN STATUS IN ('P', 'SRT', 'POW', 'POH') THEN 1
                                WHEN STATUS = 'HLF' THEN 0.5
                                ELSE 0
                            END
                          ) AS PRESENTVALUE
                          FROM [bcsdb].[dbo].[tblTimeRegister]
                          WHERE PAYCODE = '" . $row1['pay_code'] . "'
                          AND DateOFFICE BETWEEN '$fdate' AND '$ldate'";
                            $qresult = sqlsrv_query($conn, $query);
                            $qrow = sqlsrv_fetch_array($qresult, SQLSRV_FETCH_ASSOC);

                            $basic = $qrow['PRESENTVALUE'] * 441;
                            $bonus = $qrow['PRESENTVALUE'] * 60;
                            $allow = $qrow['PRESENTVALUE'] * 30;
                            $ot = $qrow['PRESENTVALUE'] * (441 / 8) * 2;
                            ?>

                            <td>
                                <?php echo $qrow['PRESENTVALUE'] ?>
                            </td>

                            <td>
                                <?php echo $row1['rate'] ?>
                            </td>
                            <td class="tdCss">
                                <input type="hidden" name="month[]" id="month" class="form-control form-control-sm num-input"
                                    step="0.01" value="<?php echo $month ?>" readonly>
                                <input type="hidden" name="contractor[]" id="contractor"
                                    class="form-control form-control-sm num-input" step="0.01" value="<?php echo $contractor ?>"
                                    readonly>

                                <!-- Basic -->
                                <input type="number" name="basic[]" id="basic" class="form-control form-control-sm num-input basic"
                                    step="0.01" value="<?php echo $basic ?? '' ?>" readonly>

                                <input type="hidden" name="paycode[]" value="<?php echo $row['pay_code'] ?>">
                            </td>
                            <!-- Bonus -->
                            <td class="tdCss">
                                <input type="number" name="attBonus[]" id="bonus"
                                    class="form-control form-control-sm num-input bonus" step="0.01"
                                    value="<?php echo $bonus ?? '' ?>">
                            </td>
                            <!-- HRA -->
                            <td class="tdCss"><input type="number" name="hra[]" id="hra"
                                    class="form-control form-control-sm num-input hra" step="0.01" value="">
                            </td>
                            <!-- Allowance -->
                            <td class="tdCss"><input type="number" name="allowance[]" id="allowance"
                                    class="form-control form-control-sm num-input allowance" step="0.01"
                                    value="<?php echo $allow ?? '' ?>">
                            </td>

                            <!-- OT -->
                            <td class="tdCss"><input type="number" name="ot[]" id="ot"
                                    class="form-control form-control-sm num-input ot" step="0.01" value="<?php echo $ot ?? '' ?>">
                            </td>

                            <!-- Salary -->
                            <td class="tdCss"><input type="number" name="salary[]" id="salary"
                                    class="form-control form-control-sm num-input salary"
                                    value="<?php echo $basic + $bonus + $allow + $ot ?? '' ?>">
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <br>

    
        <?php
    }
}

// if type is from 3 options
if ($typee == 'Drum Shifting' || $typee == 'Scrap' || $typee == 'Material') {
    // NATU MAKWANA
    $sql = "SELECT  * from emp_name where isDelete=0 AND type='$typee' AND team = 'NATU MAKWANA'";
    $result = sqlsrv_query($conn, $sql);

    // HARI RAM SUTHAR
    $sql2 = "SELECT  * from emp_name where isDelete=0 AND type='$typee' AND team = 'HARI RAM SUTHAR'";
    $result2 = sqlsrv_query($conn, $sql2);

    // OTHERS
    $sql3 = "SELECT  * from emp_name where isDelete=0 AND type='$typee' AND team = 'OTHERS'";
    $result3 = sqlsrv_query($conn, $sql3);

    if (isset($_POST['month']) && isset($_POST['cont'])) {
        $month = $_POST['month'];
        $contractor = $_POST['cont'];
        $ldate = date('Y-m-t', strtotime($_POST['month']));
        $fdate = date('Y-m-01', strtotime($_POST['month']));
        $days = date('t', strtotime($_POST['month']));
        ?>
        <!-- NATU MAKWANA -->
        <div class="divCss">
            <table class="table table-bordered text-center mb-0" id="att-data">
                <h3 class="mb-3 text-center">NATU MAKWANA</h3>
                <thead>
                    <tr class="bg-light">
                        <th>Paycode</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Team</th>
                        <?php for ($i = 1; $i <= $days; $i++) { ?>
                            <th>
                                <?php echo $i ?>
                            </th>
                        <?php } ?>
                        <th>Days</th>
                        <th>Rate</th>
                        <th>Basic</th>
                        <th>Att. Bonus</th>
                        <th>HRA</th>
                        <th>Allow.</th>
                        <th>OT</th>
                        <th>Salary</th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
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
                            <td>
                                <?php echo $row['team'] ?>
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

                            $query = "SELECT SUM(
                            CASE
                                WHEN STATUS IN ('P', 'SRT', 'POW', 'POH') THEN 1
                                WHEN STATUS = 'HLF' THEN 0.5
                                ELSE 0
                            END
                          ) AS PRESENTVALUE
                          FROM [bcsdb].[dbo].[tblTimeRegister]
                          WHERE PAYCODE = '" . $row['pay_code'] . "'
                          AND DateOFFICE BETWEEN '$fdate' AND '$ldate'";
                            $qresult = sqlsrv_query($conn, $query);
                            $qrow = sqlsrv_fetch_array($qresult, SQLSRV_FETCH_ASSOC);

                            $basic = $qrow['PRESENTVALUE'] * 441;
                            $bonus = $qrow['PRESENTVALUE'] * 60;
                            $allow = $qrow['PRESENTVALUE'] * 30;
                            $ot = $qrow['PRESENTVALUE'] * (441 / 8) * 2;
                            ?>
                            <td>
                                <?php echo $qrow['PRESENTVALUE'] ?>
                            </td>

                            <td>
                                <?php echo $row['rate'] ?>
                            </td>
                            <td class="tdCss">
                                <input type="hidden" name="month[]" id="month" class="form-control form-control-sm num-input"
                                    step="0.01" value="<?php echo $month ?>" readonly>
                                <input type="hidden" name="contractor[]" id="contractor"
                                    class="form-control form-control-sm num-input" step="0.01" value="<?php echo $contractor ?>"
                                    readonly>

                                <!-- Basic -->
                                <input type="number" name="basic[]" id="basic" class="form-control form-control-sm num-input basic"
                                    step="0.01" value="<?php echo $basic ?? '' ?>" readonly>

                                <input type="hidden" name="paycode[]" value="<?php echo $row['pay_code'] ?>">
                            </td>
                            <!-- Bonus -->
                            <td class="tdCss">
                                <input type="number" name="attBonus[]" id="bonus"
                                    class="form-control form-control-sm num-input bonus" step="0.01"
                                    value="<?php echo $bonus ?? '' ?>">
                            </td>
                            <!-- HRA -->
                            <td class="tdCss"><input type="number" name="hra[]" id="hra"
                                    class="form-control form-control-sm num-input hra" step="0.01" value="">
                            </td>
                            <!-- Allowance -->
                            <td class="tdCss"><input type="number" name="allowance[]" id="allowance"
                                    class="form-control form-control-sm num-input allowance" step="0.01"
                                    value="<?php echo $allow ?? '' ?>">
                            </td>

                            <!-- OT -->
                            <td class="tdCss"><input type="number" name="ot[]" id="ot"
                                    class="form-control form-control-sm num-input ot" step="0.01" value="<?php echo $ot ?? '' ?>">
                            </td>

                            <!-- Salary -->
                            <td class="tdCss"><input type="number" name="salary[]" id="salary"
                                    class="form-control form-control-sm num-input salary"
                                    value="<?php echo $basic + $bonus + $allow + $ot ?? '' ?>">
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div><br>
        <?php
    }
}





?>
<script>
    $(document).ready(function () {
        var at_table = $('#att-data').DataTable({
            "processing": true,
            "lengthMenu": [10, 25, 50, 75, 100, 200],
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



        $(document).on('click', "#att_submit", function () {
            var adata = at_table.$('input').serialize();
            $.ajax({
              
                type: 'POST',
                url: 'attendance_db.php',
                data: {adata:adata},
                success: function (data) {
                    window.location.href = 'attendance.php';
                },
                error: function (error) {
                    console.error('Ajax request failed', error);
                }
            });
        });

    });
</script>