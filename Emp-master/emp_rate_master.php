<?php
include('../includes/dbcon.php');
include('../includes/header.php');


// Read Rate Data from Database

$sql = "SELECT iId,rate, MIN(id) as minid, MAX(id) as maxid FROM emp_rate_master where isDelete = '0' GROUP BY iId,rate ORDER BY iId ASC";
$result = sqlsrv_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #from_err,
        #to_err {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0">Rate</h4>
            </div>
            <div class="col-auto">
                <button class="btn rounded-pill common-btn add-new" data-bs-toggle="modal" data-bs-target="#addModal"
                    href="emp_contractor_db.php">+
                    Add New</button>
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
        if (isset($_SESSION['update'])) {
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">

                <?= $_SESSION['update']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="update"></button>
            </div>
            <?php
            unset($_SESSION['update']);
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
        <div class="divCss">
            <table class="table table-bordered text-center mb-0" id="emp-data">
                <thead>
                    <tr class="bg-light">
                        <th>Sr</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        // Get Minimum ID
                        $dsql = "SELECT month from emp_rate_master where id = " . $row['minid'] . "";
                        $drun = sqlsrv_query($conn, $dsql);
                        $drow = sqlsrv_fetch_array($drun, SQLSRV_FETCH_ASSOC);

                        // Get Maximum ID
                        $msql = "SELECT month from emp_rate_master where id = " . $row['maxid'] . "";
                        $mrun = sqlsrv_query($conn, $msql);
                        $mrow = sqlsrv_fetch_array($mrun, SQLSRV_FETCH_ASSOC)
                            ?>
                        <tr>
                            <td>
                                <?php echo $row['iId'] ?>
                            </td>
                            <td>
                                <?php echo date('M-Y', strtotime($drow['month'])) ?>
                            </td>
                            <td>
                                <?php echo date('M-Y', strtotime($mrow['month'])) ?>
                            </td>
                            <td>
                                <?php echo $row['rate'] ?>
                            </td>

                            <td class="tdCss">
                                <a href="emp_rate_db.php?editid=<?php echo $row['iId'] ?>" id=<?php echo $row['iId'] ?>
                                    class="btn btn-primary btn-sm edit" data-bs-toggle="modal"
                                    data-bs-target="#editModal">Edit</a>

                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <!------------------ Add new modal ------------------->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="addForm" action="emp_rate_db.php" method="post">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <label for="month">From</label>
                            <input type="month" name="fmonth" id="fmonth" class="form-control" required>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="tmonth">To</label>
                            <input type="month" name="tmonth" id="tmonth" class="form-control" readonly>

                        </div>
                        <div class="col-lg-12 mt-3">
                            <label for="rate">Rate</label>
                            <input type="number" name="rate" id="rate" placeholder="Enter Rate" class="form-control"
                                required>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn common-btn btn-sm" form="addForm">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!------------------ edit modal ------------------->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="editForm" action="emp_rate_db.php" method="post">

                </form>
                <div class="modal-footer">
                    <button type="submit" name="update" class="btn common-btn btn-sm" form="editForm">Submit</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $('#eRate').addClass('active');
    $('#eMenu').addClass('showMenu');
    // Get To Month based on From month
    $(document).ready(function () {
        $("#fmonth").change(function () {
            var fmonth = $(this).val();
            $.ajax({
                url: 'emp_rate_db.php',
                type: 'post',
                data: { month: fmonth },
                success: function (data) {
                    $("#tmonth").val(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

    });
    $(document).on('click', '.edit', function () {
        var id = $(this).attr('id');
        $.ajax({
            url: 'emp_rate_edit.php',
            type: 'post',
            data: { id: id },
            success: function (data) {
                $('#editForm').html(data);
                $('#editModal').modal('show');
                $("#femonth").change(function () {
                    var femonth = $(this).val();
                    console.log("e",femonth);

                    $.ajax({
                        url: 'emp_rate_db.php',
                        type: 'post',
                        data: { edmonth: femonth },
                        success: function (data) {
                            $("#temonth").val(data);
                            console.log("e",$("#temonth").val());
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                });
            }
        });
    });
</script>
<?php
include('../includes/footer.php');
?>