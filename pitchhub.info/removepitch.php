<?php
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
//$connection = mysql_connect($host, $user);
mysql_select_db($db) or die ("Unable to select database!");

$pitchid = $_POST['pitchid'];
$sql = "DELETE FROM pitches
WHERE pitchid = '$pitchid'";

if(!mysql_query($sql,$connection ))
{
die('Error: ' . mysql_error());
}

//echo "Done";
header("Location: jobseeker_dashboard.php");
?>