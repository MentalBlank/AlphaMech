<?php
/*
 * AlphaFable (DragonFable Private Server) 
 * Made by MentalBlank
 * File: config.php - v0.0.3
 */

$mysql_host = "localhost";
$mysql_user = "root";
$mysql_pass = "root";
$mysql_name = "alphafable";

$MySQLi = new MySQLi($mysql_host, $mysql_user, $mysql_pass, $mysql_name);
if (mysqli_connect_error()) {
    trigger_error("Failed to connect to MySQL: " . mysql_connect_error(), E_USER_ERROR);
};

date_default_timezone_set('America/Los_Angeles');
error_reporting(0);
$dateToday = date('Y\-m\-j\TH\:i\:s\.B');