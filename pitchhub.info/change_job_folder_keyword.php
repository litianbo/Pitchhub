<?php
include 'clean_data.php';
$host = "50.62.209.83:3306";
$user = "general";
$db = "pitchhub";
$pass = "1234q";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
$user_id=$_SESSION['userid'];
$keyword = clean_input($_POST['ckey']);
$job_id=clean_input($_POST['cfjob']);

//change keyword
$ses_sql= "UPDATE keyword_jobs SET keyword='$keyword' WHERE jobid='$job_id'";
mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());

header("Location: recruiter_dashboard.php");
?>
