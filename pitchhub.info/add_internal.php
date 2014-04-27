<?php
include 'clean_data.php';
$host = "50.62.209.83:3306";
$user = "general";
$db = "pitchhub";
$pass = "1234q";
$connection = mysql_connect($host, $user, $pass);
$connection2 = mysql_connect($host, $user, $pass);
$connection3 = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
$user_id=$_SESSION['userid'];
$job_id=clean_input($_POST['addijob']);

//add to internal editors
$editor = clean_input($_POST['addi']);
$editors = explode(' ', $editor);
foreach ($editors as $term) {
	//give folder permissions
	$term = trim($term);
	$term = preg_replace('/[^a-zA-Z0-9@.]+/', ' ', $term);
	if( !empty($term)) {
		$ses_sql= "INSERT INTO `job_recruiter`(`userid`, `jobid`, `permission`) VALUES ('$term', '$job_id', 1)";
		mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());
	}
	
	//add contents of folder
	$oldQuery = "SELECT jobseekerid FROM savedjobseekers WHERE recruiterid=$user_id AND recruiterid!=$term AND jobid=$job_id";
	$result = mysql_query($oldQuery, $connection2) or die('Error: ' . mysql_error());
	if(mysql_num_rows($result)>0)
	{
		while($row = mysql_fetch_array($result))
		{
			$tempid = $row['jobseekerid'];
			$insertQuery = "INSERT INTO savedjobseekers VALUES ('$job_id', '$tempid', '$term')";
			mysql_query($insertQuery, $connection3) or die('Error: ' . mysql_error());
		}
	}
}
header("Location: recruiter_dashboard.php");
?>
