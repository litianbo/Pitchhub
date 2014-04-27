<?php
include 'clean_data.php';
date_default_timezone_set('America/Los_Angeles');
$date = date('m_d_Y_h_i_s_a', time());

ini_set('max_execution_time', 300);
ini_set('display_errors',1);
error_reporting(-1);
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
//$connection = mysql_connect($host, $user);
mysql_select_db($db) or die ("Unable to select database!");

session_start();


// Audio will be unplayable until auphonics is finished.
// Prevents a race condition in case both write at the same time.

if(!empty($_FILES["pitch"]["name"])){
$userid=$_SESSION['userid'];
//$audioFileName = $date.$userid;
$audioFileName = $_SESSION['auphonicName'];
$url = "";
$title = clean_input($_POST['title']);
$key0 = strtolower(clean_input($_POST['keyword0']));
    move_uploaded_file($_FILES["pitch"]["tmp_name"], 
        __DIR__."/tmp/".$audioFileName.".wav");
$url = "tmp/"."$audioFileName".".wav";

$sql = "INSERT INTO pitches (pitchid,userid,title,url,key0,daterecorded)
VALUES
(DEFAULT,'$userid','$title','$url','$key0', NOW())";

if(!mysql_query($sql,$connection ))
{
die('Error: ' . mysql_error());
}
$pitchid = mysql_insert_id();
//store keyword for pitches
$ses_sql= "INSERT INTO `keyword_pitches`(`keyword`,`pitchid`) VALUES ('$key0','$pitchid')";
mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());
}




header("Location: jobseeker_dashboard.php");
?>

