<?php
session_start();
$_SESSION['start_month'] = $_GET['start_month'];
$_SESSION['start_day'] = $_GET['start_day'];
$_SESSION['start_year'] = $_GET['start_year'];
$_SESSION['end_month'] = $_GET['end_month'];
$_SESSION['end_day'] = $_GET['end_day'];
$_SESSION['end_year'] = $_GET['end_year'];

header( 'Location: Home.php' ) ;
/*
echo $_GET['start_month'];
echo $_GET['start_day'];
echo $_GET['start_year'];
echo $_GET['end_month'];
echo $_GET['end_date'];
echo $_GET['end_year'];
*/ 



?> 