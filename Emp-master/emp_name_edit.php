<?php
include('../includes/dbcon.php');
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
$sql = "SELECT * from emp_name where id=$id";
$result = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

$query = "SELECT * from emp_contractor where isDelete = '0'";
$run = sqlsrv_query($conn, $query);

$query2 = "SELECT * from scrap_team where isDelete = '0'";
$run2 = sqlsrv_query($conn, $query2);
?>

<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
<div class="row mb-3">
    <div class="col-md-6">
        <label for="pay_code">Pay Code</label>
        <input type="text" name="pay_code" id="pay_code" class="form-control" value="<?php echo $row['pay_code'] ?>"
            readonly>
    </div>
    <div class="col-md-6">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name"
            value="<?php echo $row['name'] ?>" readonly>
    </div>

</div>
<div class="row mb-3">
    <div class="col-md-6">
        <label for="department">Department</label>
        <input type="text" name="department" id="department" class="form-control" placeholder="Enter Department"
            value="<?php echo $row['department'] ?>" required>
    </div>
    <div class="col-md-6">
        <label for="team">Team</label>
        <select class="form-select" aria-label="Default select example" name="team" id="editTeamDropdown">
            <?php while ($count2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC)) { ?>
                <option value="<?php echo $count2['name'] ?>" <?php if ($row['team'] == $count2['name']) {
                       echo "selected";
                   } ?>>
                    <?php echo $count2['name'] ?>
                </option>
            <?php } ?>

        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-6">
        <label for="contractor">Contractor Name</label>
        <select name="contractor" id="editContractorDropdown" class="form-select">
            <?php while ($count = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) { ?>
                <option value="<?php echo $count['name'] ?>" <?php if ($row['contractor'] == $count['name']) {
                       echo "selected";
                   } ?>>
                    <?php echo $count['name'] ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="type">Type</label>
        <select name="type" id="editaTypeDropdown" class="form-select">
            <option <?php if ($row['type'] == 'Drum Shifting') { ?> selected <?php } ?>>Drum Shifting</option>
            <option <?php if ($row['type'] == 'Material') { ?> selected <?php } ?>>Material</option>
            <option <?php if ($row['type'] == 'Scrap') { ?> selected <?php } ?>>Scrap</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="rate">Rate</label>
        <input type="number" name="rate" id="rate" class="form-control" placeholder="Enter Rate"
            value="<?php echo $row['rate'] ?>" required>
    </div>
    <div class="col-md-4">
        <label for="doj">DOJ</label>
        <input type="date" name="doj" id="doj" class="form-control" value="<?php echo $row['doj']->format('Y-m-d') ?>"
            readonly>
    </div>
    <div class="col-md-4">
        <label for="dob">DOB</label>
        <input type="date" name="dob" id="dob" class="form-control" value="<?php echo $row['dob']->format('Y-m-d') ?>"
            readonly>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="name">Status</label>
        <select class="form-select" aria-label="Default select example" name="status">
            <option <?php if ($row['status'] == 'Active') { ?> selected <?php } ?>>Active</option>
            <option <?php if ($row['status'] == 'Left') { ?> selected <?php } ?> class="text-danger">Left</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="doe">DOE</label>
        <input type="date" name="doe" id="doe" class="form-control" value="<?php echo $row['doe']->format('Y-m-d') ?>">
    </div>
</div>