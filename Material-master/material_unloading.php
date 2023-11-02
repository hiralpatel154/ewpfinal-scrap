<?php
include('../includes/dbcon.php');
include('../includes/header.php');


// Read Material Unloading Data from Database
$sql = "SELECT * FROM material_unloading where isDelete = '0'";
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
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0">Material Unloading Name</h4>
            </div>
            <div class="col-auto">
                <button class="btn rounded-pill common-btn add-new" data-bs-toggle="modal" data-bs-target="#addModal">+
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
            <table class="table table-bordered text-center mb-0">
                <thead>
                    <tr class="bg-light">
                        <th>Sr</th>
                        <th>Material</th>
                        <th>Unloading Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { ?>
                        <tr>
                            <th scope="row">
                                <?php echo $row['id'] ?>
                            </th>
                            <td>
                                <?php echo $row['material'] ?>
                            </td>
                            <td>
                                <?php echo $row['u_rate'] ?>
                            </td>
                            <td class="tdCss">
                                <button class="btn btn-primary btn-sm edit" id=<?php echo $row['id'] ?>
                                    data-name="<?php echo $row['material'] ?>"
                                    data-rate="<?php echo $row['u_rate'] ?>">Edit</button>
                                <a href="material_unloading_db.php?deleteid=<?php echo $row['id'] ?>"
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Material Unloading Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="addForm" action="material_unloading_db.php" method="post">
                    <div class="mb-3">
                        <label for="name">Material</label>
                        <input type="text" name="material" id="material" placeholder="Enter Material"
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="u_rate">Unloading Rate</label>
                        <input type="number" name="u_rate" id="u_rate" placeholder="Enter Rate" class="form-control" required>
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
                    <h5 class="modal-title">Edit Material Unloading Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="editForm" action="material_unloading_db.php" method="post">
                    <input type="hidden" id="editId" name="editId">
                    <div class="mb-3">
                        <label for="material">Material Unloading Name</label>
                        <input type="text" id="editMaterial" name="editMaterial" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="u_rate">Material Unloading Rate</label>
                        <input type="number" id="editRate" name="editRate" class="form-control" required>
                    </div>
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
     $('#mUnload').addClass('active');
    $('#mMenu').addClass('showMenu');
    $(document).on('click', '.edit', function () {
        var editid = $(this).attr('id');
        var material = $(this).data('name');
        var u_rate = $(this).data('rate');
        $('#editId').val(editid);
        $('#editMaterial').val(material);
        $('#editRate').val(u_rate);
        $('#editModal').modal('show');
    });
</script>
<?php
include('../includes/footer.php');
?>