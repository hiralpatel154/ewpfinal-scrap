<?php
include('../includes/header.php');
include('../includes/dbcon.php');


$sql = "SELECT * from scrap_rate_master where type='CP' AND is_update='0'";
$result = sqlsrv_query($conn, $sql);


$query = "SELECT * from scrap_rate_master where type='IP' AND is_update='0'";
$run = sqlsrv_query($conn, $query);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .rate-title {
            color: #858796;
        }

        td input {
            border: none !important;
            text-align: center
        }

        input:focus-visible {
            outline: none !important;
        }

        input:focus {
            box-shadow: none !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0">Rate Master</h4>
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
        <div class="control-power-div divCss">
            <form action="scrap_rate_master_db.php" method="post" id="form1">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="rate-title m-3">Control/Power</h5>
                    </div>
                    <div class="col-lg-6">
                        <button type="submit" name="cpsubmit" class="btn btn-success m-3 float-end update" id="cpsubmit"
                            form="form1">Update</button>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-bordered text-center mb-0 table-sm" id="controlPower">
                        <thead>
                            <tr class="bg-light">
                                <th>Bare Cu</th>
                                <th>Tin Cu</th>
                                <th>Alu</th>
                                <th>PVC</th>
                                <th>XLPE</th>
                                <th>GI</th>
                                <th>Tape</th>
                                <th>PVC-D</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { ?>
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <input type="hidden" name="type" value="<?php echo $row['type'] ?>">
                                <tr>
                                    <td>
                                        <input type="number" name="bare_cu" value="<?php echo $row['bare_cu'] ?>"
                                            class="form-control bare_cu" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="tin_cu" value="<?php echo $row['tin_cu'] ?>" 
                                            class="form-control tin_cu" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="alu" value="<?php echo $row['alu'] ?>"
                                            class="form-control alu" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="pvc" value="<?php echo $row['pvc'] ?>"
                                            class="form-control pvc" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="xlpe" value="<?php echo $row['xlpe'] ?>"
                                            class="form-control xlpe" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="gi" value="<?php echo $row['gi'] ?>" class="form-control gi"
                                            step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="tape_r" value="<?php echo $row['tape_r'] ?>"
                                            class="form-control tape_r" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="pvc_d" value="<?php echo $row['pvc_d'] ?>"
                                            class="form-control pvc_d" step="0.01">
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <div class="instru-panni-div divCss mt-5">
            <form action="scrap_rate_master_db.php" method="post" id="form2">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="rate-title m-3">Instru/Panni</h5>
                    </div>
                    <div class="col-lg-6">
                        <button type="submit" name="ipsubmit" class="btn btn-success m-3 float-end" id="ipsubmit"
                            form="form2">Update</button>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-bordered text-center mb-0" id="controlPower">
                        <thead>
                            <tr class="bg-light">
                                <th>Bare Cu</th>
                                <th>Tin Cu</th>
                                <th>Alu</th>
                                <th>PVC</th>
                                <th>XLPE</th>
                                <th>GI</th>
                                <th>Tape</th>
                                <th>PVC-D</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($count = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) { ?>
                                <input type="hidden" name="id" value="<?php echo $count['id'] ?>">
                                <input type="hidden" name="type" value="<?php echo $count['type'] ?>">
                                <tr>
                                    <td>
                                        <input type="number" name="bare_cu" value="<?php echo $count['bare_cu'] ?>"
                                            class="form-control ip_bare_cu" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="tin_cu" value="<?php echo $count['tin_cu'] ?>"
                                            class="form-control ip_tin_cu" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="alu" value="<?php echo $count['alu'] ?>"
                                            class="form-control ip_alu" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="pvc" value="<?php echo $count['pvc'] ?>"
                                            class="form-control ip_pvc" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="xlpe" value="<?php echo $count['xlpe'] ?>"
                                            class="form-control ip_xlpe" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="gi" value="<?php echo $count['gi'] ?>"
                                            class="form-control ip_gi" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="tape_r" value="<?php echo $count['tape_r'] ?>"
                                            class="form-control ip_tape_r" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="pvc_d" value="<?php echo $count['pvc_d'] ?>"
                                            class="form-control ip_pvc_d" step="0.01">
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<script>
     $('#sRate').addClass('active');
    $('#sMenu').addClass('showMenu');
    $(document).ready(function () {
        $('#cpsubmit').hide();
        $('#ipsubmit').hide();
        
    });
    $(document).on('change','.bare_cu,.tin_cu,.alu,.pvc,.xlpe,.gi,.tape_r,.pvc_d',function () {
        $('#cpsubmit').show();
    });
    $(document).on('change','.ip_bare_cu,.ip_tin_cu,.ip_alu,.ip_pvc,.ip_xlpe,.ip_gi,.ip_tape_r,.pvc_d',function () {
        $('#ipsubmit').show();
    });
</script>
<?php
include('../includes/footer.php');
?>