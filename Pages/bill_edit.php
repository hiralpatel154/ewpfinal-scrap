<?php
include('../includes/dbcon.php');
include('../includes/header.php');
$contractor = $_GET['param1'];
$month = $_GET['param2'];


$dsql = "SELECT * FROM bill WHERE contractor='$contractor' AND month='$month'";
$run = sqlsrv_query($conn, $dsql);
$row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Entery</title>

    <style>
        .fl {
            margin-top: 2rem;
        }

        #summtable {
            table-layout: auto;
            width: 100%;

        }

        #summtable input {
            background: transparent !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            width: 100%;
            text-align: center;
        }

        #summtable select {
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            text-align: center;
        }

        /* #summtable th{
            padding-left:0;
        } */
        #summtable td {
            padding-left: 0;
            padding-right: 0;

        }

        b {
            color: #1f9384;
        }

        .tqty {
            background-color: yellow !important;
        }

        .common-btn {
            background-color: #62bdae;
            border: none;
            color: white !important;
        }

        .totcol {
            background-color: #d4d0cf !important;

        }

        .head {
            background-color: #f2f2f2;

        }

        .abc {
            background-color: #e6e4e3 !important;
            font-weight: 500;
        }

        .drums,
        .mat,
        .tname {
            cursor: pointer;
            text-decoration: none;
            font-weight: normal;
            /* Remove the boldness */
            /* font-weight:1px !important; */
            color: black;

        }

        .roundoff {
            font-weight: normal;

        }

        .drums:hover,
        .mat:hover {
            color: black;
            /* Set the desired color for the hover state */
        }

        #purchase,
        #abc,
        #drum_table {
            overflow-y: scroll;
            overflow-x: none;
            max-height: 500px;
        }

        .custom-modal {
            max-width: 70%;
        }
    </style>
</head>

<body>
    <div class="container fl">
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0">Bill Generate</h4>
            </div>
            <div class="col-auto">
                <a href="bill_add.php" class="btn rounded-pill common-btn">Back</a>
            </div>
        </div>
        <form action="bill_db.php" method="post" id="billForm">
            <div class="divCss table-css">

                <table class="table table-bordered" style="border-collapse:collapse;width:100%">
                    <thead>
                        <input type="hidden" id="id" name="id" value=<?php echo $row['id'] ?>>
                        <tr>
                            <th colspan="4">E-mail : <input type="email" name="email" class="form-control-sm border-0"
                                    style="width: 250px;" required value="<?php echo $row['email'] ?>"></th>
                            <th>
                                Mob.No. : <input type="number" name="mobile" class="form-control-sm border-0" required
                                    value="<?php echo $row['mobile'] ?? '' ?>">
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
                                            required id="billNo" value="<?php echo $row['billNo'] ?? '' ?>">

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
                                    Date :<input type="date" name="date" class=" form-control-sm border-0" required
                                        value="<?php echo $row['date']->format('Y-m-d') ?>">
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
                                    placeholder="0" required value="<?php echo $row['qty'] ?? '' ?>">
                            </td>
                            <td><input type="number" name="rate" class="form-control form-control-sm border-0 rate"
                                    placeholder="0" required value="<?php echo $row['rate'] ?? '' ?>">
                            </td>
                            <td><input type="number" name="amt" class="form-control form-control-sm border-0 total"
                                    placeholder="0" readonly value="<?php echo $row['amt'] ?? '' ?>">

                            </td>

                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                Att. Bonus</td>
                            <td></td>
                            <td></td>
                            <td><input type="number" name="bonus" class="form-control form-control-sm border-0 bonus"
                                    placeholder="0" value="<?php echo $row['bonus'] ?? '' ?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                HRA</td>
                            <td></td>
                            <td></td>
                            <td><input type="number" name="hra" class="form-control form-control-sm border-0 hra"
                                    placeholder="0" value="<?php echo $row['hra'] ?? '' ?>" required></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                Over Time</td>

                            <td></td>
                            <td></td>
                            <td><input type="number" name="ot" class="form-control form-control-sm border-0 ot"
                                    placeholder="0" required value="<?php echo $row['ot'] ?? '' ?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                Washing Allowance
                            </td>
                            <td></td>
                            <td></td>
                            <td><input type="number" name="wa" class="form-control form-control-sm border-0 wa"
                                    placeholder="0" required value="<?php echo $row['wa'] ?? '' ?>">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align:right;">Total</td>
                            <td></td>
                            <td><input type="number" name="total" class="form-control form-control-sm border-0 ta"
                                    placeholder="0" readonly value="<?php echo $row['total'] ?? '' ?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                ESIC</td>
                            <td></td>
                            <td>3.25%</td>
                            <td><input type="number" name="esic" id="esic"
                                    class="form-control form-control-sm border-0 esic" placeholder="0" readonly
                                    value="<?php echo $row['esic'] ?? '' ?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">PF Charges
                            </td>
                            <td></td>
                            <td>13%</td>
                            <td><input type="number" name="pf" id="pf" class="form-control form-control-sm border-0 pf"
                                    placeholder="0" readonly value="<?php echo $row['pf'] ?? '' ?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;;padding-right:5px;">
                                Service Charges</td>
                            <td></td>
                            <td>4%</td>
                            <td><input type="number" name="sc" id="service"
                                    class="form-control form-control-sm border-0 service" placeholder="0" readonly
                                    value="<?php echo $row['sc'] ?? '' ?>">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align:right;padding-right:5px;vertical-align:middle;">Sub Total</td>
                            <td></td>
                            <td><input type="number" name="st" class="form-control form-control-sm border-0 subtotal"
                                    placeholder="0" readonly value="<?php echo $row['st'] ?? '' ?>">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">
                                SGST</td>
                            <td></td>
                            <td>9%</td>
                            <td><input type="number" name="sgst" class="form-control form-control-sm border-0 sgst"
                                    placeholder="0" readonly value="<?php echo $row['sgst'] ?? '' ?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;;padding-right:5px;">
                                CGST</td>
                            <td></td>
                            <td>9%</td>
                            <td><input type="number" name="cgst" class="form-control form-control-sm border-0 cgst"
                                    placeholder="0" readonly value="<?php echo $row['cgst'] ?? '' ?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="3" style="text-align:right;vertical-align:middle;">Invoice Total</td>
                            <td><input type="number" name="inTotal"
                                    class="form-control form-control-sm border-0 invoice" id="invoice" placeholder="0"
                                    readonly value="<?php echo $row['inTotal'] ?? '' ?>"></td>
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
                <div class="row mb-3 mt-5">
                    <div class="col-auto"> <button type="submit" class="btn  rounded-pill common-btn"
                            name="update">Update</button></div>
                    <div class="col-auto p-0"> <a type="" class="btn  rounded-pill btn-secondary "
                            href="bill.php">Back</a></div>

                </div>

        </form>
    </div>

</body>

</html>

<?php

include('../includes/footer.php');

?>
<script>
    $('#bill').addClass('active');
    $(document).on('change', '#billNo', function () {
        var bill_no = $(this).val();
        console.log("e",bill_no);
        $.ajax({
            url: 'bill_db.php',
            type: 'post',
            data: { bill_no:bill_no },
            success: function (data) {
                if (data == 'Yes') {
                    alert('Cannot insert a duplicate record.');
                    $('#billNo').val('');
                    $('#billNo').focus();
                } else {
                    $('#billError').html('');
                }
            }
        });
    });




</script>