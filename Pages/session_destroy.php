<?php
session_start();
unset($_SESSION['ch']);
$_SESSION['reset']= 1;


 header('location:drumshift.php');
?>