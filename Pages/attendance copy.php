<?php
include('../includes/dbcon.php');
include('../includes/header.php');

// Read Attendance Data from Database
$sql = "SELECT iId, MAX(month) as month, contractor from attendance where isDelete = '0' GROUP BY iId, contractor";
$result = sqlsrv_query($conn, $sql);
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

        #attTable {
            border-collapse:collapse;
        }

        #attTable th {
            white-space: nowrap !important;
            font-size: 1rem;
            padding: 8px 6px;
            width: 100px !important;
        }

        #attTable td {
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
    <div class="mt-5">
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
        if (isset($_SESSION['delete'])) {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                <?= $_SESSION['delete']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="delete"></button>
            </div>
            <?php
            unset($_SESSION['delete']);
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
    </div>

    <div class="container fl ">
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0">Attendance</h4>
            </div>
            <div class="col-auto"> <a class="btn rounded-pill common-btn" href="attendance_sheet.php">+Add</a></div>
        </div>
        <div class="divCss ">
            <table class="table table-bordered text-center table-hover mb-0" id="attTable">
                <thead>
                    <tr class="bg-secondary text-light">
                        <th>Sr. No</th>
                        <th>Contractor</th>
                        <th>Month</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['iId'] ?>
                            </td>
                            <td>
                                <?php echo $row['contractor'] ?>
                            </td>
                            <td>
                                <?php echo date('F-Y', strtotime($row['month'])); ?>
                            </td>
                            <td class="tdCss"><a
                                    href="attendance_edit.php?param3=<?php echo $row['iId'] ?>&param2=<?php echo $row['month'] ?>&param1=<?php echo $row['contractor'] ?>"
                                    class="btn rounded-pill btn-warning btn-sm">Edit</a>

                                <a href="attendance_db.php?id=<?php echo $row['iId'] ?>"
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
    $(document).ready(function () {
        $('#attendance').addClass('active');

        $('#attTable').DataTable({
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

</body>

</html>



<?php
include('../includes/footer.php');
?>