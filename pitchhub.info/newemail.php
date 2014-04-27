<?php
include 'clean_data.php';
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
$userid = $_SESSION['userid'];
$newemail = clean_input($_POST['email']);
$mysql= mysql_query("UPDATE user SET email='$newemail'
WHERE userid = '$userid'");

if (!$mysql) { // add this check.
    die('Invalid query: ' . mysql_error());
}
//enable this to switch to dashboard page immediately.
header("Location: jobseeker_dashboard.php");
?>
