<?php
include('../includes/dbcon.php');
include('../includes/header.php');
$sql = "SELECT * FROM emp_contractor where isDelete=0";
$result = sqlsrv_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill</title>
    <style>
        .fl {
            margin-top: 2rem;
        }
        /* form label{
            width:20%;
        } */
        .common-btn {
            background-color: #62bdae;
            border: none;
            color: white !important;
        }
        .col-lg-3 {
            padding: 0px 4px;
        }
        #showdata {
            /* background-color:black; */
            /* height:70px; */
            /* margin-bottom:5px;
            border-radius:20px;
             */
        }
        
    </style>
</head>

<body>
    <div class="container fl">
        <div class="divCss">
            <div class="row mb-3 ">
                <div class="col">
                    <h4 class="pt-2 mb-0">Bill Generate</h4>
                </div>
                <div class="col-auto">

                    <select class="form-select" aria-label="Default select example" name="contractor" id="cont"
                        required>
                        <option disabled selected value="">--Select--</option>
                        <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['name']; ?>" name="<?php echo $row['name']; ?>"
                                data-id="<?php echo $row['id'] ?>">
                                <?php echo $row['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-auto">
                    <input class="form-control" type="month" name="month" id="month">
                </div>
            </div>

            <form action="bill_db.php" method="post" autocomplete="off" id="summform" class="summform">
                <div id="showdata">
                    <br>

                </div>
            </form>
            <!-- <div class="row mb-3 mt-5">
                <div class="col-auto"> <button type="submit" class="btn  rounded-pill common-btn" name="save"
                        form="summform">Save</button></div>
                <div class="col-auto p-0"> <a type="" class="btn  rounded-pill btn-secondary " href="bill.php">Back</a>
                </div>
            </div> -->
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function () {
        $('#bill').addClass('active');

        $(document).on("change", "#month, #cont", function () {
            var month = $('#month').val();
            var cont = $('#cont').val();
            var id = $('#cont option:selected').data('id');

            if (month && cont) {
                // Check if the record already exists in the database
                $.ajax({
                    url: 'bill_db.php', // Create a new PHP file for checking if the record exists
                    type: 'post',
                    data: {
                        month: month,
                        cont: cont
                    },
                    success: function (data) {
                        if (data === "exists") {
                            // If the record exists, redirect to the edit page for that record
                            window.location.href = 'bill_edit.php?param2=' + month + '&param1=' + cont + '&param3=' + id;
                        } else if (data === "not_exists") {
                            // If the record doesn't exist, load the form for adding a new record
                            $.ajax({
                                url: 'bill_data.php',
                                type: 'post',
                                data: {
                                    month: month,
                                    cont: cont,
                                    id: id
                                },
                                success: function (data) {
                                    $('#showdata').html(data);
                                    // console.log(data);
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
                    },
                    error: function (res) {
                        console.log(res);
                    }
                });
            }
        });
        $(document).on('change', '#billNo', function () {
            var bill_no = $(this).val();
            console.log(bill_no);
            $.ajax({
                url: 'bill_db.php',
                type: 'post',
                data: { bill_no: bill_no },
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
    });

</script>