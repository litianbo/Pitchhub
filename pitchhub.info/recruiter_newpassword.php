<?php
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
$userid = $_SESSION['userid'];
$newpassword = $_POST['password'];
$mysql= mysql_query("UPDATE user SET 
password = SHA1('$newpassword') 
WHERE userid = '$userid'");

if (!$mysql) { // add this check.
    die('Invalid query: ' . mysql_error());
}
//enable this to switch to dashboard page immediately.
header("Location: recruiter_dashboard.php");
?>