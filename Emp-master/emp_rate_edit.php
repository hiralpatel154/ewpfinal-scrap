<?php
include('../includes/dbcon.php');
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
$sql = "SELECT iId,rate, MIN(id) as minid, MAX(id) as maxid FROM emp_rate_master where isDelete = '0' AND iId=$id GROUP BY iId,rate ORDER BY iId ASC";
$result = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

// Get Minimum ID
$dsql = "SELECT month from emp_rate_master where id = " . $row['minid'] . "";
$drun = sqlsrv_query($conn, $dsql);
$drow = sqlsrv_fetch_array($drun, SQLSRV_FETCH_ASSOC);

// Get Maximum ID
$msql = "SELECT month from emp_rate_master where id = " . $row['maxid'] . "";
$mrun = sqlsrv_query($conn, $msql);
$mrow = sqlsrv_fetch_array($mrun, SQLSRV_FETCH_ASSOC)

    ?>

<input type="hidden" name="eid" value="<?php echo $row['iId'] ?>">
<input type="hidden" name="mid" value="<?php echo $row['minid'] ?>">

<div class="row mb-3">
    <div class="col-lg-6 col-sm-12">
        <label for="fmonth">From</label>
        <input type="month" name="feditmonth" value="<?php echo $drow['month'] ?>" id="femonth" class="form-control"
            required>
    </div>
    <div class="col-lg-6 col-sm-12">
        <label for="tmonth">To</label>
        <input type="month" name="teditmonth" value="<?php echo $mrow['month'] ?>" id="temonth" class="form-control"
            readonly>

    </div>
    <div class="col-md-12">
        <label for="rate">Rate</label>
        <input type="number" name="rate" id="rate" class="form-control" value="<?php echo $row['rate'] ?>" required>
    </div>
</div>