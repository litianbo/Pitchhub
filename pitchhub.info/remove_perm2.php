<?php
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

$recruiterid = $_POST['recruiterid'];
$jobid = $_POST['jobid'];
$sql = "DELETE FROM job_recruiter WHERE jobid = '$jobid' AND userid = '$recruiterid'";
if(!mysql_query($sql,$connection ))
{
die('Error: ' . mysql_error());
}

$sql = "DELETE FROM savedjobseekers WHERE jobid = '$jobid' AND recruiterid = '$recruiterid'";
if(!mysql_query($sql,$connection ))
{
die('Error: ' . mysql_error());
}

header("Location: recruiter_dashboard.php");
?>
