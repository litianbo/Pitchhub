<?php
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
$userid = $_SESSION['userid'];
$newcellphone = $_POST['mobile'];
$newhomephone = $_POST['home'];
$mysql= mysql_query("UPDATE jobseeker SET cellnumber='$newcellphone', 
homenumber = '$newhomephone'
WHERE userid = '$userid'");

if (!$mysql) { // add this check.
    die('Invalid query: ' . mysql_error());
}
//enable this to switch to dashboard page immediately.
header("Location: jobseeker_dashboard.php");
?>
