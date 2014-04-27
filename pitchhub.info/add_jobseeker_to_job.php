<?php
$host = "50.62.209.83:3306";
$user = "general";
$db = "pitchhub";
$pass = "1234q";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
//need to add recruiter login later.  For now, hardcoding user_id
$user_id=$_SESSION['userid'];
$jobseeker_id = $_POST['jobseekerid'];

$query = "SELECT j.jobid FROM job j, job_recruiter jr WHERE j.jobid=jr.jobid AND jr.userid=$user_id";
$checkboxResult0 = mysql_query($query, $connection) or die('Error: ' . mysql_error());
while($checkboxRecord0 = mysql_fetch_row($checkboxResult0)){
    if(isset($_POST[$checkboxRecord0[0]])){
        echo 'inside';
        //jobseeker id not working TODO
		//normal insert
		//$insertQuery = "INSERT INTO savedjobseekers VALUES ('$checkboxRecord0[0]', '$jobseeker_id', '$user_id')";
        //mysql_query($insertQuery, $connection) or die('Error: ' . mysql_error());
		
		//search for recruiters who know about this folder (jobid)
		$searchQuery = "SELECT userid FROM job_recruiter WHERE jobid = $checkboxRecord0[0] AND permission = 1";
		$result = mysql_query($searchQuery, $connection) or die('Error: ' . mysql_error());
		
		//insert jobseeker to all recruiter's folders
		if(mysql_num_rows($result)>0)
		{
			while($row = mysql_fetch_array($result))
			{
				$tempid = $row['userid'];
				$insertQuery = "INSERT INTO savedjobseekers VALUES ('$checkboxRecord0[0]', '$jobseeker_id', '$tempid')";
				mysql_query($insertQuery, $connection) or die('Error: ' . mysql_error());
			}
		}
		else
		{
			echo "You don't have permission to add to this folder";
		}
    }
}
mysql_close($connection);
header("Location: recruiter_dashboard.php");


//work on adding Job
/*
$ses_sql= "INSERT INTO `job`(`jobtitle`) VALUES ('$jobTitle')";
mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());
$job_id = mysql_insert_id();
$ses_sql= "INSERT INTO `job_recruiter`(`userid`, `jobid`) VALUES ('$user_id', '$job_id')";
mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());
header("Location: recruiter_dashboard.php");
*/
?>
