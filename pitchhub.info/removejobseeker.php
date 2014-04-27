<?php
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
//$connection = mysql_connect($host, $user);
mysql_select_db($db) or die ("Unable to select database!");

$jobseekerid = $_POST['jobseekerid'];
$recruiterid = $_POST['recruiterid'];
$jobid = $_POST['jobid'];
$sql = "DELETE FROM savedjobseekers
WHERE jobid = '$jobid' AND jobseekerid = '$jobseekerid'";

if(!mysql_query($sql,$connection ))
{
die('Error: ' . mysql_error());
}

//echo "Done";
header("Location: recruiter_dashboard.php");
?>
