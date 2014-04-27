<?php
include 'clean_data.php';
$host = "50.62.209.83:3306";
$user = "general";
$db = "pitchhub";
$pass = "1234q";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
//need to add recruiter login later.  For now, hardcoding user_id
$user_id=$_SESSION['userid'];
$jobTitle = clean_input($_POST['job']);
$keyword = strtolower(clean_input($_POST['keyword']));

//work on adding job
$ses_sql= "INSERT INTO `job`(`jobtitle`) VALUES ('$jobTitle')";
mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());
$job_id = mysql_insert_id();

//work on storing keyword
$ses_sql= "INSERT INTO `keyword_jobs`(`keyword`,`jobid`) VALUES ('$keyword','$job_id')";
mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());


//add to internal editors
$editor = clean_input($_POST['editor']);
$editors = explode(' ', $editor);
foreach ($editors as $term) {
	$term = trim($term);
	$term = preg_replace('/[^a-zA-Z0-9@.]+/', ' ', $term);
	if( !empty($term)) {
		$ses_sql= "INSERT INTO `job_recruiter`(`userid`, `jobid`, `permission`) VALUES ('$term', '$job_id', 1)";
		mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());
	}
}

//add to external editors
$editor2 = clean_input($_POST['editor2']);
$editor3 = clean_input($_POST['editor3']);
$editors3 = explode(' ', $editor3);
foreach ($editors3 as $term2) {
	$term2 = trim($term2);
	$term2 = preg_replace('/[^a-zA-Z0-9@.]+/', ' ', $term2);
	if( !empty($term2)) {
		$ses_sql= "INSERT INTO `job_recruiter`(`userid`, `jobid`, `permission`) VALUES ('$term2', '$job_id', 1)";
		mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());
	}
}

//add to viewers;
$viewer = clean_input($_POST['viewer']);
$viewers = explode(' ', $viewer);
foreach ($viewers as $term3) {
	$term3 = trim($term3);
	$term3 = preg_replace('/[^a-zA-Z0-9@.]+/', ' ', $term3);
	if( !empty($term3)) {
		$ses_sql= "INSERT INTO `job_recruiter`(`userid`, `jobid`, `permission`) VALUES ('$term3', '$job_id', 0)";
		mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());
	}
}

$ses_sql= "INSERT INTO `job_recruiter`(`userid`, `jobid`, `permission`) VALUES ('$user_id', '$job_id', 1)";
mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());
header("Location: recruiter_dashboard.php");
?>
