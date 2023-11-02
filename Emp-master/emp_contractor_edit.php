<?php
include('../includes/dbcon.php');
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
$sql = "SELECT * from emp_contractor where id=$id";
$result = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

?>

<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
<div class="row mb-3">
    <div class="col-md-4">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control"
            value="<?php echo $row['name'] ?>">
    </div>
    <div class="col-md-4">
        <label for="name">Email</label>
        <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control"
            value="<?php echo $row['email'] ?>">
    </div>
    <div class="col-md-4">
        <label for="mobile">Mobile</label>
        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile" value="<?php echo $row['mobile'] ?>">
    </div>

</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="gst">GST NO</label>
        <input type="text" name="gst" id="gst" class="form-control" placeholder="GST NO" value="<?php echo $row['gst'] ?>">
    </div>
    <div class="col-md-4">
        <label for="pan">PAN NO</label>
        <input type="text" name="pan" id="pan" placeholder="Enter PAN NO" class="form-control" value="<?php echo $row['pan'] ?>">
    </div>
    <div class="col-md-4">
        <label for="esic">ESIC NO</label>
        <input type="text" name="esic" id="esic" class="form-control" placeholder="Enter ESIC NO" value="<?php echo $row['esic'] ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="pf">PF NO</label>
        <input type="text" name="pf" id="pf" class="form-control" placeholder="PF NO" value="<?php echo $row['pf'] ?>">
    </div>
    <div class="col-md-4">
        <label for="bank">Bank Detail</label>
        <input type="text" name="bank" id="bank" placeholder="Enter Bank Detail" class="form-control" value="<?php echo $row['bank'] ?>">
    </div>
    <div class="col-md-4">
        <label for="ac">A/C No</label>
        <input type="text" name="ac" id="ac" class="form-control" placeholder="Enter A/C No" value="<?php echo $row['ac'] ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="eoe">E. & O. E.</label>
        <input type="text" name="eoe" id="eoe" class="form-control" placeholder="E. & O. E. NO" value="<?php echo $row['eoe'] ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="address">Address</label>
        <textarea name="address" id="address" cols="30" rows="5" class="form-control"><?php echo $row['address'] ?></textarea>
    </div>
</div>