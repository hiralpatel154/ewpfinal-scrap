<?php
include('../includes/dbcon.php');
include('../includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .fl {
            margin-top: 2rem;
        }

        .common-btn {
            background-color: #62bdae;
            border: none;
            color: white !important;
        }

        .row {}

        #sumTable th {
            white-space: nowrap !important;
            font-size: 1rem;
            padding: 8px 6px;
            width: 100px !important;
        }

        #sumTable td {
            white-space: nowrap;
            /* // font-size:0.8rem; */
            padding: 6px;
        }

        .tdCss {
            padding: 3px 6px !important;
        }
    </style>
</head>

<body>
    <div class="container fl ">
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0">Summary</h4>
            </div>
            <div class="col-auto"> <a class="btn rounded-pill common-btn" href="summary_add.php">+Add</a></div>
        </div>
        <div class="divCss ">
            <table class="table table-bordered text-center table-hover mb-0" id="sumTable">
                <thead>
                    <tr class="bg-secondary text-light">
                        <th>Contractor</th>
                        <th>Month</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT DISTINCT(contrator),month FROM summary where isdelete='0'";
                    $run = sqlsrv_query($conn, $sql);
                    while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['contrator'] ?>
                            </td>
                            <td>
                                <?php echo $row['month'] ?>
                            </td>
                            <td class="tdCss"><a
                                    href="summary_edit.php?param1=<?php echo $row['contrator'] ?>&param2=<?php echo $row['month'] ?>"
                                    class="btn rounded-pill btn-warning btn-sm">Edit</a>

                                <a href="summary_db.php?param1=<?php echo $row['contrator'] ?>&param2=<?php echo $row['month'] ?>"
                                    class="btn rounded-pill btn-danger btn-sm delete" name="delete"
                                    onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<script>
    $('#summary').addClass('active');
</script>

</body>

</html>



<?php
include('../includes/footer.php');
?>