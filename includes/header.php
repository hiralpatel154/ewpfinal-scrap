<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header('location:index.php');
}

include('dbcon.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"  href="../includes/style.css"/>


    <!-- 
      show 5 row,copy,excel and search  -->

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!----------------------- jQuery UI --------------------------->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!---------------------- Data Table links ------------------>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/autofill/2.4.0/css/autoFill.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/autofill/2.4.0/js/dataTables.autoFill.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

    <style>
            input[type="number"]::-webkit-outer-spin-button,
            input[type="number"]::-webkit-inner-spin-button {     /*   remove up down arrows for number type*/
                -webkit-appearance: none;
                margin: 0;
            }
        </style> 


</head>

<body>

    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <h3><i class="fa-solid fa-earth-americas pt-1"></i><span>SEPL</span></h3>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="../Pages/dashboard.php" id="dashboard" class="menu-link"><i class="fa-solid fa-house"></i>
                        <span>Dashboard</span> </a>
                    <div class="sub-menu mt-3">
                        <a href="../Pages/dashboard.php" class="link_name"></i>Dashboard</a>
                    </div>
                </li>
                <li>
                    <a href="../Pages/drumshift.php" id="dshift" class="menu-link"><i class="fa-solid fa-drum-steelpan "></i>
                        <span>Drum Shiffting</span>
                    </a>
                    <div class="sub-menu">
                        <a href="../Pages/drumshift.php" class="link_name"></i>Drum Shiffting</a>
                    </div>
                </li>
                <li>
                    <a href="../Pages/scrapdata.php" id="sdata" class="menu-link"><i class="fa-regular fa-square-plus me-3"></i>
                        <span>Scrap Data</span>
                    </a>
                    <div class="sub-menu">
                        <a href="../Pages/scrapdata.php" class="link_name"></i>Scrap Data</a>
                    </div>
                </li>
                <li>
                    <a href="../Pages/summary.php" id="summary" class="menu-link"><i class="fa-regular fa-file me-3"></i>
                        <span>Summary</span>
                    </a>
                    <div class="sub-menu">
                        <a href="../Pages/summary.php" class="link_name"></i>Summary</a>
                    </div>
                </li>
                <li>
                    <a href="../Pages/attendance.php" id="attendance" class="menu-link"><i class="fa-solid fa-person"></i>
                        <span>Attendance</span>
                    </a>
                    <div class="sub-menu">
                        <a href="../Pages/attendance.php" class="link_name"></i>Attendance</a>
                    </div>
                </li>
                <li>
                    <a href="../Pages/bill.php" id="bill" class="menu-link"><i class="fa-solid fa-receipt"></i>
                        <span>Bill</span>
                    </a>
                    <div class="sub-menu">
                        <a href="../Pages/bill.php" class="link_name"></i>Bill</a>
                    </div>
                </li>
                <li>
                    <a class="sub-btn drop-menu" href="#" id="Dmaster">
                        <i class="fa-solid fa-database"></i>
                        <span class="link_name"> Drum Master</span>
                        <i class="fas fa-angle-right dropdown"></i>
                    </a>
                    <div class="sub-menu" id="drumMenu">
                    <a href="../Drum-master/drum_contractor.php" class="sub-item" id="dCon">0.
                            &nbsp;Name of Contractor</a>
                        <a href="../Drum-master/drum_name.php" class="sub-item" id="dName">1. &nbsp; Name</a>
                        <a href="../Drum-master/drum_plant.php" class="sub-item" id="dPlant">2. &nbsp;Plant</a>
                        <a href="../Drum-master/drum_series.php" class="sub-item" id="dSeries">3. &nbsp;Drum Series</a>
                        <a href="../Drum-master/drum_conductor.php" class="sub-item" id="dConductor">4. &nbsp;Conductor</a>
                        <a href="../Drum-master/drum_stage.php" class="sub-item" id="dStage">5. &nbsp;Stage</a>
                        <a href="../Drum-master/drum_unit.php" class="sub-item" id="dUnit">6. &nbsp;Unit</a>
                    </div>
                </li>
                <li>
                    <a class="sub-btn drop-menu" href="#" id="Mmaster">
                        <i class="fa-solid fa-database"></i>
                        <span>Material Master</span>
                        <i class="fas fa-angle-right dropdown"></i>
                    </a>
                    <div class="sub-menu" id="mMenu">
                        <a href="#" class="link_name">Material Master</a>
                        <a href="../Material-master/material_unloading.php" class="sub-item" id="mUnload">0. &nbsp;Material Unloading</a>
                    </div>
                </li>
                <li>
                    <a class="sub-btn drop-menu" href="#" id="Smaster">
                        <i class="fa-solid fa-database"></i>
                        <span>Scrap Master</span>
                        <i class="fas fa-angle-right dropdown"></i>
                    </a>
                    <div class="sub-menu" id="sMenu">
                        <a href="#" class="link_name">Scrap Master</a>

                        <a href="../Scrap-master/scrap_team_name.php" class="sub-item" id="sTeam">0.
                            &nbsp;Team Name</a>
                        <a href="../Scrap-master/scrap_rate_master.php" class="sub-item" id="sRate">1. &nbsp;Rate Master </a>
                    </div>
                </li>
                <li>
                    <a class="sub-btn drop-menu" href="#" id="Emaster">
                        <i class="fa-solid fa-database"></i>
                        <span>Employee Master</span>
                        <i class="fas fa-angle-right dropdown"></i>
                    </a>
                    <div class="sub-menu" id="eMenu">
                        <a href="#" class="link_name">Employee Master</a>

                        <a href="../Emp-master/emp_name.php" class="sub-item" id="eName">0.
                            &nbsp;Employee Name </a>
                            <a href="../Emp-master/emp_contractor.php" class="sub-item" id="eCon">1. &nbsp; Contractor Master</a>
                        <a href="../Emp-master/emp_rate_master.php" class="sub-item" id="eRate">2. &nbsp; Rate Master</a>
                    </div>
                </li>
                <li>
                    <a class="sub-btn menu-link" href="./logout.php"
                        onclick="return confirm('Are you sure you want to log out?');">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="title">Logout</span>
                    </a>
                    <div class="sub-menu">
                        <a href="#" class="link_name"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <div class="header-title">
                <label for="nav-toggle">
                    <i class="fa-solid fa-bars"></i>
                </label>
                <span>Dashboard</sapn>
            </div>

            <div class="user-wrapper">
                <img src="../images/avtar.png" width="40px" height="30px" alt="">
                <div>
                    <h4>
                        <?php echo $_SESSION['uname'] ?>
                    </h4>
                    <small>
                        <?php echo $_SESSION['rights'] ?>
                    </small>
                </div>
            </div>
        </header>

        <main>  