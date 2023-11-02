<?php
include('../includes/dbcon.php');
$month = $_POST['month'];
$cont = $_POST['cont'];
$id = $_POST['id'];
//echo $cont;

$sql = "SELECT * FROM emp_contractor where isDelete=0 AND id='$id'";
$result = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

$dsql = "SELECT * FROM bill";
$run = sqlsrv_query($conn, $dsql);

$sql2 = "SELECT max(billNo) as bid from bill";
$result2 = sqlsrv_query($conn, $sql2);
$row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);

$sql3 = "SELECT sum(hra) as hra, sum(basic) as basic, sum(allowance) as allowance, sum(attBonus) as bonus, sum(ot) as ot, sum(salary) as salary from attendance where month='$month' AND contractor = '$cont'";
$result3 = sqlsrv_query($conn, $sql3);
$row3 = sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #858796 !important;
        }

        .bill-table {
            color: #858796;
        }

        .html {
            scroll-behavior: smooth;
        }

        .bill-table input {
            border: 0;
        }

        .table th {
            padding: 10px;
        }

        .email {
            width: 350px;
        }

        .form-control[readonly] {
            background-color: #c6e3de94;
            opacity: 1;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem #deefec;
        }

        p {
            margin-bottom: 0;
        }

        .table-css {
            padding-bottom: 50px;
        }

        body {
            position: relative;
        }


        .scroll {
            position: absolute;
            right: 1rem;
            bottom: 0;
            width: 3rem;
            height: 3rem;
            line-height: 46px;

        }

        .scroll .scroll-to-top {
            text-align: center;
            color: #fff;
            background: rgba(90, 92, 105, .5);
            padding: 12px 16px;
        }

        .scroll-to-top:focus,
        .scroll-to-top:hover {
            color: #fff
        }

        .scroll-to-top:hover {
            background: #5a5c69
        }

        .scroll-to-top i {
            font-weight: 800
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        @media only screen and (max-width:1650px) {
            .bill-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body id="page-top">
    <div class="container-fluid">

        <form action="bill_db.php" method="post" id="billForm">
            <div class="divCss table-css">
                <table class="table table-bordered" style="border-collapse:collapse;width:100%">
                    <thead>
                        <input type="hidden" value="<?php echo $cont ?>" name="contractor">
                        <input type="hidden" value="<?php echo $month ?>" name="month">
                        <tr>
                            <th colspan="4">E-mail : <input type="email" name="email" class="form-control-sm border-0"
                                    style="width: 250px;" value="<?php echo $row['email'] ?>"></th>
                            <th>
                                Mob.No. : <input type="number" name="mobile" class="form-control-sm border-0"
                                    value="<?php echo $row['mobile'] ?>">
                            </th>
                        </tr>
                        <tr>
                            <th colspan="4" style="font-size:14px;">
                                <sup>M / S .</sup>
                                Suyog Electricals Ltd
                            </th>
                            <th>
                                GST TAX INVOICE
                            </th>
                        </tr>
                        <tr style="font-size:14px;">
                            <th colspan="4">
                                2204/2205,GIDC ESTATE - Halol,PMS-GJ-389350 </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p>
                                        Bill No : <input type="number" name="billNo" class="form-control-sm border-0"
                                            id="billNo" value="<?php echo $row2['bid'] + 1 ?>">

                                    </p>

                                </div>
                            </th>
                        </tr>
                        <tr style="font-size:14px;">
                            <th colspan="4">
                                24AACCS9412R1ZV </th>
                            <th>
                                <p>
                                    Date :<input type="date" name="date" class=" form-control-sm border-0" required
                                        value="<?php echo date('Y-m-d'); ?>">
                                </p>

                            </th>
                        </tr>
                        <tr style="font-size:14px;" class="bg-secondary text-white">
                            <th>Sr.no</th>
                            <th class="text-center">Particulars</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Rate</th>
                            <th class="text-center">Amount</th>
                        </tr>

                    </thead>
                    <tbody style="font-size:14px;">
                        <tr>
                            <td>1</td>
                            <td>

                            </td>
                            <td>
                                <input type="number" name="qty" class="form-control form-control-sm border-0 qty"
                                    placeholder="0" required>
                            </td>
                            <td><input type="number" name="rate" class="form-control form-control-sm border-0 rate"
                                    placeholder="0" required>
                            </td>
                            <td><input type="number" name="amt" class="form-control form-control-sm border-0 total"
                                    placeholder="0" readonly>

                            </td>

                        </tr>




                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                Att. Bonus</td>
                            <td></td>
                            <td></td>
                            <td><input type="number" name="bonus" class="form-control form-control-sm border-0 bonus"
                            value="<?php echo $row3['bonus'] ?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                HRA</td>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="number" name="hra" class="form-control form-control-sm border-0 hra"
                                    value="<?php echo $row3['hra'] ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                Over Time</td>

                            <td></td>
                            <td></td>
                            <td>
                                <input type="number" name="ot" class="form-control form-control-sm border-0 ot"
                                    value="<?php echo $row3['ot'] ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                Washing Allowance
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="number" name="allowance" class="form-control form-control-sm border-0 wa"
                                    value="<?php echo $row3['allowance'] ?>" required>

                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align:right;">Total</td>
                            <td></td>
                            <td><input type="number" name="total" class="form-control form-control-sm border-0 ta"
                                    placeholder="0" readonly></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                ESIC</td>
                            <td></td>
                            <td>3.25%</td>
                            <td><input type="number" name="esic" id="esic"
                                    class="form-control form-control-sm border-0 esic" placeholder="0" readonly></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">PF Charges
                            </td>
                            <td></td>
                            <td>13%</td>
                            <td><input type="number" name="pf" id="pf" class="form-control form-control-sm border-0 pf"
                                    placeholder="0" readonly></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;;padding-right:5px;">
                                Service Charges</td>
                            <td></td>
                            <td>4%</td>
                            <td><input type="number" name="sc" id="service"
                                    class="form-control form-control-sm border-0 service" placeholder="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align:right;padding-right:5px;vertical-align:middle;">Sub Total</td>
                            <td></td>
                            <td><input type="number" name="st" class="form-control form-control-sm border-0 subtotal"
                                    placeholder="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                SGST</td>
                            <td></td>
                            <td>9%</td>
                            <td><input type="number" name="sgst" class="form-control form-control-sm border-0 sgst"
                                    placeholder="0" readonly></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;;padding-right:5px;">
                                CGST</td>
                            <td></td>
                            <td>9%</td>
                            <td><input type="number" name="cgst" class="form-control form-control-sm border-0 cgst"
                                    placeholder="0" readonly></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="3" style="text-align:right;vertical-align:middle;">Invoice Total</td>
                            <td><input type="number" name="inTotal"
                                    class="form-control form-control-sm border-0 invoice" id="invoice" placeholder="0"
                                    readonly></td>
                        </tr>
                        <!-- <tr>
                            <td colspan="2">Amount In Word: 
                            </td>
                            <td colspan="3"></td>
                        </tr> -->
                        <tr>
                            <td rowspan="8" colspan="4">
                                <p>GST No:&nbsp
                                    <?php echo $row['gst'] ?>
                                </p>
                                <p>PAN NO:&nbsp
                                    <?php echo $row['pan'] ?>
                                </p>
                                <p>ESIC NO:&nbsp
                                    <?php echo $row['esic'] ?>
                                </p>
                                <p>P F No:&nbsp
                                    <?php echo $row['pf'] ?>
                                </p>
                                <p>Bank Detail:&nbsp
                                    <?php echo $row['bank'] ?>
                                </p>
                                <p>A/C NO:&nbsp
                                    <?php echo $row['ac'] ?>
                                </p>
                                <p>E. & O. E.:&nbsp
                                    <?php echo $row['eoe'] ?>
                                </p>
                            </td>
                            <td style="font-weight:bold">
                                For , Shubham Recruitment Agency Business
                                <br><br><br><br>
                                Authorised Signatory
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row mb-3 mt-5">
                    <div class="col-auto">
                        <button type="submit" name="submit" class="btn common-btn float-end rounded-pill">Save</button>
                    </div>
                    <div class="col-auto p-0">
                        <a type="" class="btn  rounded-pill btn-secondary " href="bill.php">Back</a>
                    </div>


                </div>
        </form>
    </div>
    <div class="scroll">
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>
</body>

</html>
<script>
    $('#bill').addClass('active');


</script>
<?php
include('../includes/footer.php');
?>