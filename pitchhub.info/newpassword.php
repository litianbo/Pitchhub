<?php
include 'passwordLib.php';
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
$userid = $_SESSION['userid'];
$oldpassword = $_POST['oldpassword'];
$newpassword = $_POST['password'];

$mysql1= mysql_query("SELECT * FROM user WHERE userid = '$userid'");
if (!$mysql1) { // add this check.
    die('Invalid query: ' . mysql_error());
}
$numofrows = mysql_num_rows($mysql1);
if($numofrows==1){
$row = mysql_fetch_array($mysql1);
$userpassword = $row["password"];


if(password_verify($oldpassword, $userpassword)){
	$temp_newpassword = password_hash($newpassword,PASSWORD_BCRYPT); 
$mysql2= mysql_query("UPDATE user SET 
password = '$temp_newpassword'
WHERE userid = '$userid'");

if (!$mysql2) { // add this check.
    die('Invalid query: ' . mysql_error());
}
// enable this to switch to dashboard page immediately.
if($row['jobseeker_TF'] == true)
	header("Location: jobseeker_dashboard.php");
else
	header("Location: recruiter_dashboard.php");
}


else{
//old password doesn't match:
header("Location: wrongpassword.php");
}
}
else{
echo "couldn't find userid for this user";
}

?>