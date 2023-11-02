<?php
session_start();
$user = $_SESSION['empid'];
// include('../includes/dbcon.php');
include('../includes/dbcon.php');

$action = $_GET['action'] ?? '';

$response = array();
$query = "SELECT MAX(id) as id FROM emp_name";
$connect = sqlsrv_query($conn, $query);
$crow = sqlsrv_fetch_array($connect, SQLSRV_FETCH_ASSOC);
$id = $crow['id'] + 1;
if ($action == 'sync') {
    // Enable identity insert
    $sql_identity_insert = "SET IDENTITY_INSERT emp_name ON";
    $result_identity_insert = sqlsrv_query($conn, $sql_identity_insert);

    if ($result_identity_insert === false) {
        // Handle the error
        $response['error'] = 'Error enabling IDENTITY_INSERT';
    } else {
        $sql = "SELECT DISTINCT  e.*, d.DEPARTMENTNAME 
        FROM [bcsdb].[dbo].[TblEmployee] as e 
        JOIN [bcsdb].[dbo].[tblDepartment] as d ON e.DEPARTMENTCODE = d.DEPARTMENTCODE 
        WHERE PAYCODE LIKE 'SH-%' AND ACTIVE='Y'";
        $result = sqlsrv_query($conn, $sql);

        if ($result === false) {
            $response['error'] = 'D query error';
        } else {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $pay_code = trim($row['PAYCODE']);
                $name = trim($row['EMPNAME']);
                $department = trim($row['DEPARTMENTNAME']);
                // Convert SQL Server datetime to PHP DateTime object
                $doj = $row['DateOFJOIN'];
                $dob = $row['DateOFBIRTH'];

                // Check if the datetime values are valid
                if ($doj !== null && $dob !== null) {
                    // Format dates as 'YYYY-MM-DD' for SQL Server insertion
                    $doj = $doj->format('Y-m-d');
                    $dob = $dob->format('Y-m-d');
                } else {
                    // Handle invalid date formats here
                    $doj = null; // Set to a default value or handle the error as needed
                    $dob = null; // Set to a default value or handle the error as needed
                }

                $csql = "SELECT COUNT(*) AS count FROM emp_name WHERE pay_code = '$pay_code'";
                $cresult = sqlsrv_query($conn, $csql);

                if ($cresult === false) {
                    $response['error'] = 'Database query error';
                    break;
                }

                $row1 = sqlsrv_fetch_array($cresult, SQLSRV_FETCH_ASSOC);
                $count = $row1['count'];
                $update_query = "UPDATE emp_name SET isDelete = '0' WHERE pay_code = '$pay_code' AND isDelete = '1'";
                $update_result = sqlsrv_query($conn, $update_query);

                if ($update_result === false) {
                    $response['error'] = 'Error updating record';
                    break;
                }
                if ($count == 0) {
                    // Update isDelete to 0 where pay_code exists with isDelete = 1
                
                    $isql = "INSERT INTO emp_name (id,pay_code, name, department, doj, dob, status, isDelete, createdBy) VALUES ('$id','$pay_code', '$name', '$department', '$doj', '$dob', 'Active', '0', '$user')";

                    $iresult = sqlsrv_query($conn, $isql);
                    if ($iresult === false) {
                        $errors = sqlsrv_errors();
                        foreach ($errors as $error) {
                            // Log or print detailed error information
                            echo "Message: " . $error['message'] . "<br />";
                        }
                        $response['error'] = "Insert Error";
                        break;
                    }
                    $id++;
                } else {
                    echo $count;
                }
            }
        }

        // Disable identity insert when done
        $sql_disable_identity_insert = "SET IDENTITY_INSERT emp_name OFF";
        $result_disable_identity_insert = sqlsrv_query($conn, $sql_disable_identity_insert);

        if ($result_disable_identity_insert === false) {
            // Handle the error
            $response['error'] = 'Error disabling IDENTITY_INSERT';
        }
    }
    // Convert the $response array to JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>