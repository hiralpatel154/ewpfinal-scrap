<?php
include('../includes/dbcon.php');
include('../includes/header.php');
$sql = "SELECT * FROM emp_contractor where isDelete=0";
$result = sqlsrv_query($conn, $sql);

$sql1 = "SELECT distinct(type) FROM emp_name where isDelete=0";
$result1 = sqlsrv_query($conn, $sql1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
        }

        table td {
            font-size: 14px;
            white-space: nowrap;
        }

        .dataTables_length {
            margin-bottom: 20px;
        }
        #att_update{
            display: none;
        }

        #att-data th,
        #att-two-data th,
        #att-three-data th,
        #att-all-data th {
            white-space: nowrap !important;
        }

        #att-data tr td,
        #att-two-data tr td,
        #att-three-data tr td,
        #att-all-data tr td {
            text-align: center;
        }

        .tdCss {
            padding: 4px !important;
        }

        .Sun {
            background-color: red !important;
            color: white;
        }

        .num-input {
            width: 100px;
        }

        .num-input:focus {
            box-shadow: 0 0 0 0.2rem #deefec;
            border: 0;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        #month_err {
            display: none;
        }

        #att_submit {
            /* display: none; */
        }
        #attn_submit{
            /* width: 140px; */
        }

        @media only screen and (max-width:3470px) {

            #att-data,
            #att-all-two-data,
            #att-all-three-data,
            #att-all-data,
            #att-two-data,
            #att-three-data {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0">Attendance</h4>
            </div>
        </div>
        <?php
        if (isset($_SESSION['update'])) {
            ?>
            <div class="alert alert-warning alert-dismissible fade show auto-close" role="alert">

                <?= $_SESSION['update']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="update"></button>
            </div>
            <?php
            unset($_SESSION['update']);
        }
        ?>
        <form id="attnForm">
            <div class="divCss">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-sm-12">
                        <div class="box d-flex">
                            <div class="contractor me-2">
                                <select class="form-select" aria-label="Default select example" name="contractor"
                                    id="cont">
                                    <option disabled selected value="">--Select--</option>
                                    <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { ?>
                                        <option value="<?php echo $row['name']; ?>" name="<?php echo $row['name']; ?>"
                                            data-id="<?php echo $row['id'] ?>">
                                            <?php echo $row['name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="month me-2">
                                <input type="month" name="month" id="month" class="form-control">
                                <p class="text-danger" id="month_err">Please select month</p>
                            </div>
                            <div class="type">
                                <select name="type" id="type" class="form-select">
                                    <option value="blank"></option>
                                    <?php while ($row1 = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)) { ?>
                                        <option value="<?php echo $row1['type'] ?>" name="<?php echo $row1['type']; ?>">
                                            <?php echo $row1['type'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <input type="button" value="Get Record" class="btn common-btn" id="get_record"
                            name="get_record">
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <label for="working-days">Working Days : 23</label>
                    </div>
                    <!-- <div class="col-lg-2 col-sm-12">
                        <button type="submit" value="" name="submit" class="btn common-btn float-end m-3"
                            id="att_submit" for="attnForm">Submit Common</button>
                    </div> -->

                </div>
            </div><br>

            <div id="putData">

            </div>
        </form>
    </div>
</body>

</html>
<script>
    
    $(document).on("click", "#get_record", function () {
        var month = $('#month').val();
        var cont = $('#cont').val();
        var typee = $('#type').val();
        var id = $('#cont option:selected').data('id');
        if (month && cont && typee) {
            $.ajax({
                url: 'attendance_db.php',
                type: 'post',
                data: {
                    mon_th: month,
                    cont: cont,
                    type: typee
                },
                success: function (data) {
                    if (data === "exists") {
                        console.log('e');
                        // If the record exists, redirect to the edit page for that record
                        window.location.href = 'attendance_edit.php?param2=' + month + '&param1=' + cont + '&param3=' + id;
                        console.log(window.location.href);
                    } else if (data === "not_exists") {
                        $("#att_submit").show();
                        // If the record doesn't exist, load the form for adding a new record
                        $.ajax({
                            url: 'attendance_get.php',
                            type: 'post',
                            data: {
                                month: month,
                                cont: cont,
                                typee: typee,
                                id: id
                            },
                            success: function (data) {
                                $('#putData').html(data);
                            },
                            error: function (res) {
                                console.log(res);
                            }
                        });
                    }
                    else {
                        // Handle other responses or errors
                        console.log("Unexpected response: " + data);
                    }
                }
            })
        }
    });


    $('#attendance').addClass('active');




</script>
<?php
include('../includes/footer.php');
?>