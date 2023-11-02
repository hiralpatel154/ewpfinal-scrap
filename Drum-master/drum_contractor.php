<?php
include('../includes/dbcon.php');
include('../includes/header.php');


// Read Contractor Data from Database
$sql = "SELECT * FROM drum_contractor where isDelete = '0'";
$result = sqlsrv_query($conn, $sql);

$ssql = "SELECT * FROM emp_contractor";
$sresult = sqlsrv_query($conn, $ssql);

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
        .mheight{
            transition: all 1s ease; 
        }
        .modal-content.add.mheight{
        
            height: 360px;
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
                    href="drum_con_db.php">+
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
                    <tr>
                        <th class="bg-light">Sr</th>
                        <th class="bg-light">Sub Contractor</th>
                        <th class="bg-light">Main Contractor</th>
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
                                <?php echo $row['main_contractor'] ?>
                            </td>
                            <td class="tdCss">
                                <button class="btn btn-primary btn-sm edit" id=<?php echo $row['id'] ?>
                                    data-name="<?php echo $row['name'] ?>">Edit</button>
                                <a href="drum_con_db.php?deleteid=<?php echo $row['id'] ?>"
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
            <div class="modal-content add">
                <div class="modal-header">
                    <h5 class="modal-title">Add Contractor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="addForm" action="drum_con_db.php" method="post">
                    <label for="name">Sub Contractor</label>
                    <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control" required>

                    <label for="name" class="mt-2">Main Contractor</label>
                    <select name="main_contractor" id="mainCont" class="form-select" aria-label="Default select example">
                        <option disabled selected value="">Select Main Contractor</option>
                        <?php while ($row2 = sqlsrv_fetch_array($sresult, SQLSRV_FETCH_ASSOC)) { ?>
                        <option name="<?php echo $row2['name']?>">
                            <?php echo $row2['name'] ?>
                        </option>
                        <?php } ?>
                    </select>
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
                    <h5 class="modal-title">Edit Contractor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="editForm" action="drum_con_db.php" method="post">
                    <label for="name">Name</label>
                    <input type="text" id="editName" name="editName" class="form-control" required>
                    <input type="hidden" id="editId" name="editId">
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
    $('#dCon').addClass('active');
    $('#drumMenu').addClass('showMenu');
    $(document).on('click', '.edit', function () {
        var editid = $(this).attr('id');
        var name = $(this).data('name');
        $('#editId').val(editid);
        $('#editName').val(name);
        $('#editModal').modal('show');
    });
    $(document).ready(function() {
        $("#mainCont").on("click", function() {
            // Remove the height adjustment when the dropdown is closed
            $(".modal-content.add").toggleClass('mheight'); // Reset the value
        });
    });
</script>
<?php
include('../includes/footer.php');
?>