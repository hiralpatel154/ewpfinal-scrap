<?php
include('../includes/dbcon.php');
include('../includes/header.php');

$id = 1;
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

        #sumTable {
            border-collapse: collapse;
        }

        #sumTable th {
            white-space: nowrap !important;
            font-size: 1rem;
            padding: 8px 6px;
            width: 100px !important;
        }

        #sumTable td {
            white-space: nowrap;
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

                <?php echo $_SESSION['insert']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="insert"></button>
            </div>
            <?php
            unset($_SESSION['insert']);
        }
        if (isset($_SESSION['delete'])) {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                <?php echo $_SESSION['delete']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="delete"></button>
            </div>
            <?php
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">

                <?php echo $_SESSION['update']; ?>
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
                <h4 class="pt-2 mb-0">Bill Generate</h4>
            </div>
            <div class="col-auto"> <a class="btn rounded-pill common-btn" href="bill_add.php">+Add</a></div>
        </div>

        <div class="divCss ">
            <table class="table table-bordered text-center table-hover mb-0" id="sumTable">
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
                    $sql = "SELECT * FROM bill";
                    $run = sqlsrv_query($conn, $sql);
                    while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $id ?>
                            </td>
                            <td>
                                <?php echo $row['contractor'] ?>
                            </td>
                            <td>
                                <?php echo date('F-Y', strtotime($row['month'])) ?>
                            </td>
                            <td class="tdCss"><a
                                    href="bill_edit.php?param1=<?php echo $row['contractor'] ?>&param2=<?php echo $row['month'] ?>&id=<?php echo $row['id'] ?>"
                                    class="btn rounded-pill btn-warning btn-sm">Edit</a>

                                <a onclick="window.open('bill_pdf.php?pid=<?php echo $row['id'] ?> &cont=<?php $row['contractor'] ?>', '_blank'); return false;"
                                    class="btn rounded-pill btn-primary btn-sm print">Print</a>
                                <!-- <a href="bill_db.php?&delid=<?php echo $row['id'] ?>">d</a> -->
                            </td>
                        </tr>
                        <?php
                        $id++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<script>
    $('#bill').addClass('active');

    $('#sumTable').DataTable({
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
</script>

</body>

</html>



<?php
include('../includes/footer.php');
?>