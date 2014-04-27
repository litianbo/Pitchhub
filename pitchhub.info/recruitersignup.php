<?php
include 'clean_data.php';
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
//$connection = mysql_connect($host, $user);
mysql_select_db($db) or die ("Unable to select database!");

$username = clean_input($_POST['username']);
$companyid = $_POST['companyid'];
$password = $_POST['password'];
$firstname = clean_input($_POST['firstname']);
$lastname = clean_input($_POST['lastname']);
$query = mysql_query("SELECT * FROM user WHERE email = '$username'") or die(mysql_error());
$numofrows = mysql_num_rows($query);


if($numofrows ==0){
$hashed_pw = password_hash($password,PASSWORD_BCRYPT);
$sql = "INSERT INTO user (userid,firstname, lastname, email,  password, jobseeker_TF, recruiter_TF)
    VALUES
    (DEFAULT,'$firstname','$lastname', '$username','$hashed_pw','0','1')";

	if(!mysql_query($sql,$connection ))
{
    die('Error: ' . mysql_error());
}

//find userid
$sql = "SELECT * FROM user WHERE email = '$username'";
$result = mysql_query($sql);
if (!$result) { // add this check.
    die('Invalid query: ' . mysql_error());
}
$found = false;
while($row = mysql_fetch_array($result)){
	if(password_verify($password,$row['password'])){
		$userid = $row['userid'];
		$_SESSION['logged_in'] = true;
		$found = true;
		break;
	}
}
if($found == false){
	die('Invalid query: ' . mysql_error());
}
$sql2 = "INSERT INTO recruiter (userid,companyid)
    VALUES
    ( '$userid','$companyid')";
	if(!mysql_query($sql2,$connection ))
{
    die('Error: ' . mysql_error());
}




echo header("Location: recruiter_index.html");


}else{
header("Location: emailexist.html");
}
mysql_close($connection);
?>
