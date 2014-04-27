<?php
include 'passwordLib.php';
include 'clean_data.php';
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
//$connection = mysql_connect($host, $user);
mysql_select_db($db) or die ("Unable to select database!");

$firstname = clean_input($_POST['firstname']);
$lastname = clean_input($_POST['lastname']);
$password = password_hash($_POST['pw2'],PASSWORD_BCRYPT);


$email = clean_input($_POST['email2']);

$query = mysql_query("SELECT * FROM user WHERE email = '$email'") or die(mysql_error());
$numofrows = mysql_num_rows($query);
if($numofrows ==0){
$sql = "INSERT INTO user (userid,firstname, lastname, email, password, jobseeker_TF, recruiter_TF)
    VALUES
    (DEFAULT,'$firstname','$lastname','$email', '$password','1','0')";


	if(!mysql_query($sql,$connection ))
{
    die('Error: ' . mysql_error());
}


session_start();

// This is to make sure userid session is stored.
$sql = "SELECT * FROM user WHERE email = '$email'";
$result = mysql_query($sql);
if (!$result) { // add this check.
    die('Invalid query: ' . mysql_error());
}
$found = false;
while($row = mysql_fetch_array($result)){
	if($password == $row['password']){
		$_SESSION['userid'] = $row['userid'];
		$_SESSION['logged_in'] = true;
		$found = true;

		// Send an email for confirmation
		$to      = $email;
		$subject = 'Thank You For Joining PitchHub';
		$message = '
Dear '. $firstname . ' ' . $lastname . ',


Welcome to PitchHub!

You have signed up for a new user account at PitchHub.  

If you believe you have not signed up for this account. Please email us at setup@pitchhub.info

Your Email: ' . $email . '

Sincerely,



PitchHub Team';
		$headers = 'From: setup@pitchhub.info' . "\r\n" .
		    'Reply-To: setup@pitchhub.info' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);



		break;
	}
}
if($found == false){
	die('Invalid query: ' . mysql_error());
}


$_SESSION['login_email']=$email;
$_SESSION['login_password']=$password;
header("Location: js_step2.php");
}
else{
header("Location: emailexist.html");
}
mysql_close($connection);

?>
