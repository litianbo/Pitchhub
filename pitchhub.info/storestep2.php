<?php
include 'clean_data.php';
include 'passwordLib.php';
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");
date_default_timezone_set('America/Los_Angeles');
$date = date('m_d_Y_h_i_s_a', time());

session_start();
$email=$_SESSION['login_email'];
$password=$_SESSION['login_password'];
$cellnumber = clean_input($_POST['mobilenumber']);
$homenumber = clean_input($_POST['homenumber']);
$school1 = clean_input($_POST['school1']);
$degree1 = clean_input($_POST['degree1']);
$major1 = clean_input($_POST['major1']);
$graduationyear1 = clean_input($_POST['year1']);
//$college2 = $_POST['school2'];
//$degree2 = $_POST['degree2'];
//$graduationyear2 = $_POST['year2'];

$linkedin = clean_input($_POST['linkedin']);
$facebook = clean_input($_POST['facebook']);
$monster = clean_input($_POST['monster']);
$other = clean_input($_POST['other']);

$sql = "SELECT * FROM user WHERE email = '$email' and password = '$password';";
$result = mysql_query($sql);

if (!$result) { // add this check.
    die('Invalid query: ' . mysql_error());
}

while($row = mysql_fetch_array($result)){

$userid = $row['userid'];
$ses_sql= "INSERT INTO jobseeker (userid, cellnumber, homenumber, 
linkedin, facebook, monster, other)
    VALUES
    ('$userid','$cellnumber','$homenumber',
	'$linkedin', 
	'$facebook', '$monster', '$other')";
	
$ses_sqlcollege = "INSERT INTO college (id,userid, college,graduationyear,degree,major)
    VALUES
    (DEFAULT,'$userid','$school1','$graduationyear1','$degree1','$major1')";
	if(!mysql_query($ses_sqlcollege,$connection ))
		{
		die('Error: ' . mysql_error());
		}
		if(!mysql_query($ses_sql,$connection ))
		{
		die('Error: ' . mysql_error());
		}
if (isset($_POST['school2'])){
$school2 = clean_input($_POST['school2']);
$degree2 = clean_input($_POST['degree2']);
$major2 = clean_input($_POST['major2']);
$year2 = clean_input($_POST['year2']);
}else{
$school2 = NULL;
$degree2 = NULL;
$major2 = NULL;
$year2 = NULL;
}
$ses_sqlcollege2 = "INSERT INTO college (id,userid, college,graduationyear,degree,major)
    VALUES
    (DEFAULT,'$userid','$school2','$year2','$degree2','$major2')";
	if(!mysql_query($ses_sqlcollege2,$connection ))
		{
		die('Error: ' . mysql_error());
		}
if (isset($_POST['school3'])){
$school3 = clean_input($_POST['school3']);
$degree3 = clean_input($_POST['degree3']);
$major3 = clean_input($_POST['major3']);
$year3 = clean_input($_POST['year3']);
}else{
$school3 = NULL;
$degree3 = NULL;
$major3 = NULL;
$year3 = NULL;
}
$ses_sqlcollege3 = "INSERT INTO college (id,userid, college,graduationyear,degree,major)
    VALUES
    (DEFAULT,'$userid','$school3','$year3','$degree3','$major3')";
	if(!mysql_query($ses_sqlcollege3,$connection ))
		{
		die('Error: ' . mysql_error());
		}
		
if (isset($_POST['school4'])){
$school4 = clean_input($_POST['school4']);
$degree4 = clean_input($_POST['degree4']);
$major4 = clean_input($_POST['major4']);
$year4 = clean_input($_POST['year4']);
}else{
$school4 = NULL;
$degree4 = NULL;
$major4 = NULL;
$year4 = NULL;
}
$ses_sqlcollege4 = "INSERT INTO college (id,userid, college,graduationyear,degree,major)
    VALUES
    (DEFAULT,'$userid','$school4','$year4','$degree4','$major4')";
	if(!mysql_query($ses_sqlcollege4,$connection ))
		{
		die('Error: ' . mysql_error());
		}
		
if (isset($_POST['school5'])){
$school5 = clean_input($_POST['school5']);
$degree5 = clean_input($_POST['degree5']);
$major5 = clean_input($_POST['major5']);
$year5 = clean_input($_POST['year5']);
}else{
$school5 = NULL;
$degree5 = NULL;
$major5 = NULL;
$year5 = NULL;
}
$ses_sqlcollege5 = "INSERT INTO college (id,userid, college,graduationyear,degree,major)
    VALUES
    (DEFAULT,'$userid','$school5','$year5','$degree5','$major5')";
	if(!mysql_query($ses_sqlcollege5,$connection ))
		{
		die('Error: ' . mysql_error());
		}
}


//for photo
if (!empty($_FILES["photo"]["type"])){
$photoFileName = $date.$userid.".jpg";
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["photo"]["name"]);
$extension = end($temp);


if ( 
(($_FILES["photo"]["type"] == "image/gif")
|| ($_FILES["photo"]["type"] == "image/jpeg")
|| ($_FILES["photo"]["type"] == "image/jpg")
|| ($_FILES["photo"]["type"] == "image/pjpeg")
|| ($_FILES["photo"]["type"] == "image/x-png")
|| ($_FILES["photo"]["type"] == "image/png"))
&& ($_FILES["photo"]["size"] < 200000)
&& in_array($extension, $allowedExts))
  {
  
  if ($_FILES["photo"]["error"] > 0  )
    {
    echo "photo Error: " . $_FILES["photo"]["error"] . "<br>";
    }
	
  else
    {
    if(!empty($_FILES["photo"]["name"])){	
     move_uploaded_file($_FILES["photo"]["tmp_name"], 
    dirname(__FILE__)."\\tmp\\".$photoFileName);
    $photo = "tmp/" . $photoFileName;
    }
	  }
      }


$sql = "INSERT INTO photo (photoid, userid,url)
VALUES
(DEFAULT,'$userid','$photo')";
if(!mysql_query($sql,$connection ))
{
die('Error: ' . mysql_error());
}
//echo "TEST!!!";
}
mysql_close($connection);

header("Location: js_step3.php");

?>
