<?php
include 'passwordLib.php';
include 'clean_data.php';
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$companyid = $_POST['companyid'];
$username = clean_input($_POST['username']);
$password = $_POST['password'];

$sql="SELECT userid, password FROM user WHERE email='$username'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$count=mysql_num_rows($result);



// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1)
{
	if(password_verify($password,$row['password']))
		$_SESSION['userid']=$row['userid'];
	else
		header("location: loginError.html");

//echo "I am in";
//$_SESSION["myusername"]=$myusername;
//echo "success";
header("location: recruiter_dashboard.php");
}
else 
{
header("location: loginError.html");
//echo "Wrong password";
//$error="Your Login Name or Password is invalid";
}
}
?>