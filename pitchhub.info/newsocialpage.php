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
$newfacebook = clean_input($_POST['facebook']);
$newlinkedin = clean_input($_POST['linkedin']);
$newmonster = clean_input($_POST['monster']);
$newother = clean_input($_POST['other']);

$mysql= mysql_query("UPDATE jobseeker SET facebook='$newfacebook', 
linkedin = '$newlinkedin', monster = '$newmonster', other = '$newother'
WHERE userid = '$userid'");

if (!$mysql) { // add this check.
    die('Invalid query: ' . mysql_error());
}
//enable this to switch to dashboard page immediately.
header("Location: jobseeker_dashboard.php");
?>
