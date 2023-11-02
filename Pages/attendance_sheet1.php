<?php
include('../includes/dbcon.php');
include('../includes/header.php');



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

        #att-data th {
            text-align: center;
            white-space: nowrap !important;
            padding: 8px !important;
        }
        

        #att-data tr td {
            text-align: center;
            padding: 6px !important;
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
            display: none;
        }
        /* width */
        ::-webkit-scrollbar {
            width: 5px;
            height:10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        
        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888; 
        }

        
        @media only screen and (max-width:3470px) {
            #att-data {
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
        if (isset($_SESSION['insert'])) {
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">

                <?= $_SESSION['insert']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="insert"></button>
            </div>
            <?php
            unset($_SESSION['insert']);
        }
        ?>
        <?php
        if (isset($_SESSION['update'])) {
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">

                <?= $_SESSION['update']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="update"></button>
            </div>
            <?php
            unset($_SESSION['update']);
        }
        ?>
        <form action="attendance_insert.php" method="post">
            <div class="divCss">
                <div class="row">
                    <div class="col-lg-3 col-sm-12">
                        <label for="month">Month:</label>
                        <input type="month" name="month" id="month" class="form-control" required>
                        <p class="text-danger" id="month_err">Please select month</p>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <input type="button" value="Get Record" class="btn common-btn mt-4" id="get_record"
                            name="get_record">
                    </div>
                    <div class="col-lg-3 col-sm-12 mt-4">
                        <label for="working-days">Working Days : 23</label>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <button type="submit" value="" name="submit" class="btn common-btn float-end m-3"
                            id="att_submit">Submit</button>
                    </div>
                </div>
            </div><br>
            <div id="putData" class="divCss">

            </div>
        </form>
    </div>
</body>

</html>
<script>
    $('#attendance').addClass('active');
    // Get Day based on Month and Year
    $(document).on('click', "#get_record", function () {
        var month = $("#month").val();
        $("#update").click();
        $("#insert").click();
        if (month == '') {
            $("#month_err").show();
        } else {
            $("#month_err").hide();
            $("#att_submit").show();
            $.ajax({
                url: 'attendance_get.php',
                type: 'post',
                data: { month: month },
                success: function (data) {
                    $('#putData').html(data);
                }
            });
        }
    });
    
    
</script>
<?php
include('../includes/footer.php');
?>