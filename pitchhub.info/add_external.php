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
$job_id=clean_input($_POST['addejob']);

//add to external editors
$editor2 = clean_input($_POST['adde']);
$editor3 = clean_input($_POST['adde2']);
$editors3 = explode(' ', $editor3);
foreach ($editors3 as $term2) {
	$term2 = trim($term2);
	$term2 = preg_replace('/[^a-zA-Z0-9@.]+/', ' ', $term2);
	if( !empty($term2)) {
		//give folder permissions
		$ses_sql= "INSERT INTO `job_recruiter`(`userid`, `jobid`, `permission`) VALUES ('$term2', '$job_id', 1)";
		mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());

		//add contents of folder
		$oldQuery = "SELECT jobseekerid FROM savedjobseekers WHERE recruiterid=$user_id AND recruiterid!=$term2 AND jobid=$job_id";
		$result = mysql_query($oldQuery, $connection2) or die('Error: ' . mysql_error());
		if(mysql_num_rows($result)>0)
		{
			while($row = mysql_fetch_array($result))
			{
				$tempid = $row['jobseekerid'];
				$insertQuery = "INSERT INTO savedjobseekers VALUES ('$job_id', '$tempid', '$term2')";
				mysql_query($insertQuery, $connection3) or die('Error: ' . mysql_error());
			}
		}
	}
}

header("Location: recruiter_dashboard.php");
?>
