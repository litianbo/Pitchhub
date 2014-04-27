<?php
include 'clean_data.php';
date_default_timezone_set('America/Los_Angeles');
$date = date('m_d_Y_h_i_s_a', time());

$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
$userid=$_SESSION['userid'];
//$userid=41;

$url = "tmp\\".$userid.$date.".wav";
//$pitchname = "temporaryName";
//$key0 = "temporaryKey";
$key0 = strtolower(clean_input($_POST['keyword']));
$pitchname = clean_input($_POST['title']);
//$key0 = $_POST['keyword'];

$sql = sprintf("INSERT INTO pitches (pitchid,url,userid,title,key0,daterecorded)
VALUES
(DEFAULT,'%s','$userid','$pitchname','$key0', NOW())", mysql_real_escape_string($url));

if(!mysql_query($sql,$connection ))
{
die('Error: ' . mysql_error());
}
$pitchid = mysql_insert_id();
//store keyword for pitches
$ses_sql= "INSERT INTO `keyword_pitches`(`keyword`,`pitchid`) VALUES ('$key0','$pitchid')";
mysql_query($ses_sql, $connection) or die('Error: ' . mysql_error());


$audioPath = dirname(__FILE__)."\\tmp\\".$userid.$date.".wav";
// pull the raw binary data from the POST array
$data = substr($_POST['data'], strpos($_POST['data'], ",") + 1);
// decode it
$decodedData = base64_decode($data);
// print out the raw data, 
echo ($decodedData);
// write the data out to the file
$fp = fopen($audioPath, 'wb');
fwrite($fp, $decodedData);
fclose($fp);

?>
