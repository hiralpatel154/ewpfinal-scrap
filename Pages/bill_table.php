<?php
include('../includes/dbcon.php');
include('../includes/header.php');

$sql = "SELECT * FROM emp_contractor where isDelete=0";
$result = sqlsrv_query($conn, $sql);

$dsql = "SELECT * FROM bill";
$run = sqlsrv_query($conn, $dsql);
$row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

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
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0">Bill Generate</h4>
            </div>
            <div class="col-auto">
                <a href="bill.php" class="btn rounded-pill common-btn">Back</a>
            </div>
        </div>
        <form action="bill_db.php" method="post" id="billForm">
            <div class="divCss table-css">
                <table class="table table-bordered" style="border-collapse:collapse;width:100%">
                    <thead>
                        <tr>
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <label class="me-2">Contractor:</label>
                                    <select class="form-select bcontractor" aria-label="Default select example"
                                        id="contractor" name="contractor">

                                        <option disabled selected value="">Select Contractor</option>
                                        <?php while ($row2 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { ?>
                                            <option value="<?php echo $row2['name']; ?>"
                                                name="<?php echo $row2['name']; ?>">
                                                <?php echo $row2['name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center">
                                    <label class="me-2">Month:</label>
                                    <input type="month" name="month" id="month" class="form-control bmonth" required="">
                                </div>

                            </div>


                        </tr>
                        <tr>
                            <th colspan="5" class="text-center fw-bold">
                                A/33, Vijaya Nagar Society, Nr- Meghdoot Society. Halol - 389350 . Panchmahal - Gujarat
                                .
                            </th>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-center">
                                Godhra Road. Halol - 389350 . Panchmahal - Gujarat .
                            </th>
                        </tr>
                        <tr>
                            <th colspan="4">E-mail : <input type="email" name="email" class="form-control-sm border-0"
                                    style="width: 250px;" required></th>
                            <th>
                                Mob.No. : <input type="number" name="mobile" class="form-control-sm border-0" required>
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
                                        Bill No : <input type="text" name="billNo" class="form-control-sm border-0"
                                            required id="billNo">

                                    </p>
                                    <p class="text-danger" id="billError">

                                    </p>
                                </div>
                            </th>
                        </tr>
                        <tr style="font-size:14px;">
                            <th colspan="4">
                                24AACCS9412R1ZV </th>
                            <th>
                                <p>
                                    Date :<input type="date" name="date" class=" form-control-sm border-0" required>
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
                                    placeholder="0"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                HRA</td>
                            <td></td>
                            <td></td>
                            <td><input type="number" name="hra" class="form-control form-control-sm border-0 hra"
                                    placeholder="0" required></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                Over Time</td>

                            <td></td>
                            <td></td>
                            <td><input type="number" name="ot" class="form-control form-control-sm border-0 ot"
                                    placeholder="0" required></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                Washing Allowance
                            </td>
                            <td></td>
                            <td></td>
                            <td><input type="number" name="allowance" class="form-control form-control-sm border-0 wa"
                                    placeholder="0" required>
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
                                <p>GST No: 24ATAPG6048D1Z6</p>
                                <p>PAN NO :
                                    ATAPG6048D</p>
                                <p>ESIC NO :38000484020001019</p>
                                <p>P F No :VDBRD2076807000</p>
                                <p>Bank Detail :HDFC BANK -Halol.</p>
                                <p>A/C NO :50200049051242</p>
                                <p>E. & O. E.: Subject to Halol Jurisdiction</p>
                            </td>
                            <td style="font-weight:bold">
                                For , Shubham Recruitment Agency Business
                                <br><br><br><br>
                                Authorised Signatory
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <button type="submit" name="submit" class="btn common-btn float-end">Submit</button>
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
    $(document).on('focusout', '#billNo', function () {
        var bill_no = $(this).val();

        $.ajax({
            url: 'bill_db.php',
            type: 'post',
            data: { bill_no },
            success: function (data) {
                if (data == 'Yes') {
                    $('#billError').html('Bill Number is already exist');
                    $('#bill_no').val('');
                    $('#bill_no').focus();
                } else {
                    $('#billError').html('');
                }
            }
        });
    });
    $(document).on('focusout', '#month', function () {
        var contractor = $('#contractor').val();
        var month = $('#month').val();

        $.ajax({
            url: 'bill_db.php',
            type: 'POST',
            data: { contractor: contractor, month: month },
            success: function (data) {
                if (data === 'exists') {
                    alert('Cannot insert a duplicate record.');
                    $('#month').val('');
                    $('#month').focus();
                }
            }
        });
    });
</script>
<?php
include('../includes/footer.php');
?>