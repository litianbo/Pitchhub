<?php

$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
//$connection = mysql_connect($host, $user);
mysql_select_db($db) or die ("Unable to select database!");

session_start();


if(!empty($_FILES["pitch"]["tmp_name"])){
$userid=$_SESSION['userid'];
$pitch = "";
$pitchname = clean_input($_POST['title']);
$key0 = clean_input($_POST['keyword0']);
move_uploaded_file($_FILES["pitch"]["tmp_name"],
 "G:\PleskVhosts\pitchhub.info\pitchhub.info/tmp/" . $_FILES["pitch"]["name"]);
$pitch = "tmp/" . $_FILES["pitch"]["name"];
$sql = "INSERT INTO pitches (pitchid,url,userid,title,key0)
VALUES
(DEFAULT,'$pitch','$userid','$pitchname','$key0')";

if(!mysql_query($sql,$connection ))
{
die('Error: ' . mysql_error());
}

}

//$query = mysql_query("SELECT * FROM pitches") or die(mysql_error());
//$pitchid = mysql_num_rows($query);

header("Location: jobseeker_dashboard.php");
//session_destroy();
?>

