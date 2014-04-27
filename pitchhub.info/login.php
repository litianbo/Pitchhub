<?php
include 'passwordLib.php';
include 'clean_data.php';
date_default_timezone_set('America/Los_Angeles');

$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$username = clean_input($_POST['username']);
$password = $_POST['password'];

// username and password sent from Form 
//$myusername=addslashes('$username'); 
//$mypassword=addslashes('$password'); 

$sql="SELECT * FROM user WHERE email='$username'";

$result=mysql_query($sql);
$row=mysql_fetch_array($result);
//$active=$row['active'];
$count=mysql_num_rows($result);


// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1)
{
	$attempts = $row['loginattempts'];
	if($attempts > 4 && ((time() - strtotime($row['lastattempt'])) < (60*15))){
		header("location: loginLockout.html");
		exit();
	}

	$time = date('Y-m-d H:i:s');
	if(password_verify($password,$row['password'])){
		$_SESSION['userid']=$row['userid'];
		$_SESSION['logged_in']=true;

		$update_row = mysql_query("UPDATE user SET loginattempts = '0' WHERE email = '$username'");
		if (!$update_row) // add this check.
   	 		die('Invalid query: ' . mysql_error());

		$update_row = mysql_query("UPDATE user SET lastattempt = '$time' WHERE email = '$username'");
		if (!$update_row) // add this check.
	   	 	die('Invalid query: ' . mysql_error());
	}
	else{
		/* User tried to lock in 5 times. Lock out for 15 minutes */
		if($attempts > 4){
			$update_row = mysql_query("UPDATE user SET loginattempts = '0' WHERE email = '$username'");
			if (!$update_row) // add this check.
   	 			die('Invalid query: ' . mysql_error());
		}

		$update_row = mysql_query("UPDATE user SET loginattempts = loginattempts + 1 WHERE email = '$username'");
		if (!$update_row) // add this check.
   	 		die('Invalid query: ' . mysql_error());

		$update_row = mysql_query("UPDATE user SET lastattempt = '$time' WHERE email = '$username'");
		if (!$update_row) // add this check.
	   	 	die('Invalid query: ' . mysql_error());

		header("location: loginError.html");
		exit();
	}

//$_SESSION["myusername"]=$myusername;
//echo "success";
header("location: jobseeker_dashboard.php");
}
else 
{
header("location: loginError.html");
//echo "Wrong password";
//$error="Your Login Name or Password is invalid";
}
}
?>