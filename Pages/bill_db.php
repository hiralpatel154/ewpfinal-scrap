<?php
include('../includes/dbcon.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $billNo = $_POST['billNo'];
    $contractor = $_POST['contractor'];
    $month = $_POST['month'];
    $date = $_POST['date'];
    $qty = $_POST['qty'];
    $rate = $_POST['rate'];
    $amt = $_POST['amt'];
    $hra = $_POST['hra'];
    $bonus = $_POST['bonus'];
    $ot = $_POST['ot'];
    $wa = $_POST['allowance'];
    $total = $_POST['total'];
    $esic = $_POST['esic'];
    $pf = $_POST['pf'];
    $sc = $_POST['sc'];
    $st = $_POST['st'];
    $sgst = $_POST['sgst'];
    $cgst = $_POST['cgst'];
    $inTotal = $_POST['inTotal'];

    $sql = "INSERT INTO bill (email, mobile, billNo, contractor, month, date, qty, rate, amt, hra, bonus, ot, wa, total, esic, pf, sc, st, sgst, cgst, inTotal) VALUES ('$email', '$mobile', '$billNo', '$contractor', '$month', '$date', '$qty', '$rate', '$amt', '$hra', '$bonus', '$ot', '$wa', '$total', '$esic', '$pf', '$sc', '$st', '$sgst', '$cgst', '$inTotal')";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:bill.php');
        $_SESSION['insert'] = "Data Inserted Successfully";
    } else {
        print_r(sqlsrv_errors());
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $billNo = $_POST['billNo'];
    $date = $_POST['date'];
    $qty = $_POST['qty'];
    $rate = $_POST['rate'];
    $amt = $_POST['amt'];
    $hra = $_POST['hra'];
    $bonus = $_POST['bonus'];
    $ot = $_POST['ot'];
    $wa = $_POST['wa'];
    $total = $_POST['total'];
    $esic = $_POST['esic'];
    $pf = $_POST['pf'];
    $sc = $_POST['sc'];
    $st = $_POST['st'];
    $sgst = $_POST['sgst'];
    $cgst = $_POST['cgst'];
    $inTotal = $_POST['inTotal'];

    $sql = "UPDATE bill SET email = '$email',mobile = '$mobile',billNo = '$billNo',date = '$date',qty = '$qty',rate = '$rate',amt = '$amt',hra = '$hra',bonus = '$bonus',ot = '$ot',wa = '$wa',
        total = '$total',esic = '$esic',pf = '$pf',sc = '$sc',st = '$st',sgst = '$sgst',cgst = '$cgst',inTotal = '$inTotal' where id='$id'";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        header('Location:bill.php');
        $_SESSION['update'] = "Data Updated Successfully";
    } else {
        print_r(sqlsrv_errors());
    }
}

if (isset($_POST['month']) && isset($_POST['cont'])) {
    $month = $_POST['month'];
    $cont = $_POST['cont'];

    // Perform a database query to check if the record exists
    $sql = "SELECT COUNT(*) AS count FROM bill WHERE month = '$month' AND contractor = '$cont'";
    $run = sqlsrv_query($conn, $sql);
    
    if ($run) {
        $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
        $count = $row['count'];

        if ($count > 0) {
            // The record exists
            echo "exists";
        } else {
            // The record does not exist
            echo "not_exists";
        }
    } else {
        // Error handling for the database query
        echo "error";
    }
}
if (isset($_POST['bill_no'])) {
    $bill_no = $_POST['bill_no'];
    $sql = "SELECT count(billNo) as count FROM bill where billNo='$bill_no'";
    $run = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
    if ($row['count'] > 0) {
        $print = 'Yes';
    } else {
        $print = 'No';
    }
    echo $print;
}
if (isset($_GET['delid'])) {
    $id = $_GET['delid'];
    $sql = "DELETE from bill where id=$id";
    $run = sqlsrv_query($conn, $sql);
    if($run){
        header("location:bill.php");
        $_SESSION['delete']= "Data Deleted Successfully";
    }
}
?>