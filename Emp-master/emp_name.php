<?php
include('../includes/dbcon.php');
include('../includes/header.php');

$sql = "SELECT * from emp_name where isDelete = '0'";
$result = sqlsrv_query($conn, $sql);

$query = "SELECT * from emp_contractor where isDelete = '0'";
$run = sqlsrv_query($conn, $query);

$query2 = "SELECT * from scrap_team where isDelete = '0'";
$run2 = sqlsrv_query($conn, $query2);

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
        }

        table td {
            font-size: 14px;
            white-space: nowrap;
        }

        .dataTables_length {
            margin-bottom: 20px;
        }

        #emp-data th {
            white-space: nowrap !important;
        }

        @media only screen and (max-width:1650px) {
            #emp-data {
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
                <h4 class="pt-2 mb-0">Name</h4>
            </div>
            <div class="col-auto">
                <button class="btn rounded-pill btn-warning sync" href="#">
                    Sync</button>
                <button class="btn rounded-pill common-btn add-new" data-bs-toggle="modal" data-bs-target="#addModal"
                    href="emp_name_db.php">+
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
        <div class="divCss editForm">
            <table class="table table-bordered text-center mb-0" id="emp-data">
                <thead>
                    <tr class="bg-light">
                        <th>Sr</th>
                        <th>Pay Code</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Team</th>
                        <th>Contractor</th>
                        <th>Type</th>
                        <th>DOJ</th>
                        <th>DOB</th>
                        <th>Rate</th>
                        <th>Status</th>
                        <th>DOE</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['id'] ?>
                            </td>
                            <td>
                                <?php echo $row['pay_code'] ?>
                            </td>
                            <td>
                                <?php echo $row['name'] ?>
                            </td>
                            <td>
                                <?php echo $row['department'] ?>
                            </td>
                            <td>
                                <?php echo $row['team'] ?>
                            </td>
                            <td>
                                <?php echo $row['contractor'] ?>
                            </td>
                            <td>
                                <?php echo $row['type'] ?>
                            </td>
                            <td>
                                <?php echo $row['doj']->format('d-m-Y') ?>
                            </td>
                            <td>
                                <?php echo $row['dob']->format('d-m-Y') ?>
                            </td>
                            <td>
                                <?php echo $row['rate'] ?>
                            </td>
                            <td>
                                <?php echo $row['status'] ?>
                            </td>
                            <td>
                            </td>
                            <td class="tdCss">
                                <a href="emp_name_db.php?editid=<?php echo $row['id'] ?>" id=<?php echo $row['id'] ?>
                                    class="btn btn-primary btn-sm edit" data-bs-toggle="modal"
                                    data-bs-target="#editModal">Edit</a>

                                <a href="emp_name_db.php?deleteid=<?php echo $row['id'] ?>"
                                    onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="addForm" action="emp_name_db.php" method="post">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="pay_code">Pay Code</label>
                            <input type="text" name="pay_code" id="pay_code" class="form-control"
                                placeholder="Enter Pay Code" required>
                            <p class="text-danger paycode-error d-none"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name"
                                required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="department">Department</label>
                            <input type="text" name="department" id="department" class="form-control"
                                placeholder="Enter Department" required>
                        </div>
                        <div class="col-md-6">
                            <label for="name">Team</label>
                            <select class="form-select" aria-label="Default select example" id="teamDropdown"
                                name="team">
                                <option disabled selected value="">Select Team</option>
                                <?php while ($row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC)) { ?>
                                <option value="<?php echo $row2['name']; ?>" name="<?php echo $row2['name']; ?>">
                                    <?php echo $row2['name'] ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contractor">Contractor Name</label>
                            <select class="form-select" name="contractor" id="contractor">
                                <option disabled selected value="">Select Contractor</option>
                                <?php while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) { ?>

                                <option value="<?php echo $row['name']; ?>" name="<?php echo $row['name']; ?>">
                                    <?php echo $row['name']; ?>

                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="contractor">Type</label>
                            <select class="form-select" name="type" id="type">
                                <option selected>Select Type</option>
                                <option value="Drum Shifting">Drum Shifting</option>x
                                <option value="Material">Material</option>
                                <option value="Scrap">Scrap</option>
                            </select>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rate">Rate</label>
                            <input type="number" step="0.01" name="rate" id="rate" class="form-control"
                                placeholder="Enter Rate" required>
                        </div>
                        <div class="col-md-6">
                            <label for="doe">DOJ</label>
                            <input type="date" name="doj" id="doj" class="form-control" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="doe">DOB</label>
                            <input type="date" name="dob" id="dob" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="name">Status</label>
                            <select class="form-select" aria-label="Default select example" name="status" id="idStatus">
                                <option value="" disabled selected>Select Option</option>
                                <option>Active</option>
                                <option class="text-danger">Left</option>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="doe">DOE</label>
                            <input type="date" name="doe" id="doe" class="form-control">
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
                    <h5 class="modal-title">Edit Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="editForm" action="emp_name_db.php" method="post">

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
    $('#eName').addClass('active');
    $('#eMenu').addClass('showMenu');
    $(document).ready(function () {
        $('#emp-data').DataTable({
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
        $("#teamDropdown").prop("required", true);
        $("#contractor").prop("required", true);
        $("#idStatus").prop("required", true);

        $(document).on('click', '.edit', function () {
            var id = $(this).attr('id');
            $.ajax({
                url: 'emp_name_edit.php',
                type: 'post',
                data: { id },
                success: function (data) {
                    $('#editForm').html(data);
                    $('#editModal').modal('show');
                }
            })
        });

        $(document).on('click', '.sync', function () {
            location.reload();
            $.ajax({
                url: 'sync-data.php?action=sync',
                type: 'post',
                dataType: 'json',
                success: function (response) {

                    console.log('Data synchronized successfully:', response);
                },
                error: function (xhr, status, error) {
                    // Handle errors here
                    console.error('Error:', error);
                }
            });
        });
        $("#pay_code").on('focusout', function () {
            var paycode = $(this).val();
            if (paycode.trim() !== '') {
                $.ajax({
                    url: 'emp_name_db.php',
                    type: 'post',
                    data: { paycode: paycode },
                    success: function (data) {
                        if (data == 'exist') {
                            $('.paycode-error').text('Paycode already exists');
                            $('.paycode-error').css('display', 'block');
                            $('.paycode-error').removeClass('d-none');
                            $('#pay_code').val('');
                        } else {
                            $('.paycode-error').html('');
                        }
                    }
                });
            }
        });
    });


</script>
<?php
include('../includes/footer.php');
?>