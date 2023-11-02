<?php
include('../includes/dbcon.php');
include('../includes/header.php');


// Read Contractor Data from Database
$sql = "SELECT * FROM emp_contractor where isDelete = '0'";
$result = sqlsrv_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .tdCss {
            padding: 4px 6px !important;
        }

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

        #empCont th {
            white-space: nowrap !important;
        }

        #empCont tr td {
            text-align: center;
        }

        #empCont th {
            white-space: nowrap !important;
        }

        @media only screen and (max-width:1650px) {
            #empCont {
                /* display: block;
                overflow-x: auto; */
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0">Name Of Contractor</h4>
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
            <table class="table table-bordered text-center mb-0" id="empCont">
                <thead>
                    <tr>
                        <th class="bg-light">Sr</th>
                        <th class="bg-light">Contractor Name</th>
                        <th class="bg-light">Email</th>
                        <th class="bg-light">Mobile</th>
                        <th class="bg-light">GST No</th>

                        <th class="bg-light">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { ?>
                        <tr>
                            <th scope="row">
                                <?php echo $row['id'] ?>
                            </th>
                            <td>
                                <?php echo $row['name'] ?>
                            </td>

                            <td>
                                <?php echo $row['email'] ?>
                            </td>
                            <td>
                                <?php echo $row['mobile'] ?>
                            </td>
                            <td>
                                <?php echo $row['gst'] ?>
                            </td>
                            <td class="tdCss">
                                <button class="btn btn-primary btn-sm edit" id=<?php echo $row['id'] ?>
                                    data-name="<?php echo $row['name'] ?>">Edit</button>
                                <a href="emp_contractor_db.php?deleteid=<?php echo $row['id'] ?>"
                                    onclick="return confirm('Are you sure?')" name="delete"
                                    class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!------------------ Add new modal ------------------->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Contractor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="addForm" action="emp_contractor_db.php" method="post">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="name">Email</label>
                            <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="mobile">Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile"
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="gst">GST NO</label>
                            <input type="text" name="gst" id="gst" class="form-control" placeholder="GST NO" required>
                        </div>
                        <div class="col-md-4">
                            <label for="pan">PAN NO</label>
                            <input type="text" name="pan" id="pan" placeholder="Enter PAN NO" class="form-control"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="esic">ESIC NO</label>
                            <input type="text" name="esic" id="esic" class="form-control" placeholder="Enter ESIC NO"
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="pf">PF NO</label>
                            <input type="text" name="pf" id="pf" class="form-control" placeholder="PF NO" required>
                        </div>
                        <div class="col-md-4">
                            <label for="bank">Bank Detail</label>
                            <input type="text" name="bank" id="bank" placeholder="Enter Bank Detail"
                                class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="ac">A/C No</label>
                            <input type="text" name="ac" id="ac" class="form-control" placeholder="Enter A/C No"
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="eoe">E. & O. E.</label>
                            <input type="text" name="eoe" id="eoe" class="form-control" placeholder="E. & O. E."
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" cols="30" rows="5" class="form-control"></textarea>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Contractor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="editForm" action="emp_contractor_db.php" method="post">

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
    $(document).ready(function () {
        $('#empCont').DataTable({
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
        $('#eCon').addClass('active');
        $('#eMenu').addClass('showMenu');
        $(document).on('click', '.edit', function () {
            var id = $(this).attr('id');
            $.ajax({
                url: 'emp_contractor_edit.php',
                type: 'post',
                data: { id },
                success: function (data) {
                    $('#editForm').html(data);
                    $('#editModal').modal('show');
                }
            });
        });

    })
</script>
<?php
include('../includes/footer.php');
?>