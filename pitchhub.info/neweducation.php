<?php
include 'clean_data.php';
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");
session_start();
$userid = $_SESSION['userid'];
$id1 = $_POST['id1'];
$id2 = $_POST['id2'];
$id3 = $_POST['id3'];
$id4 = $_POST['id4'];
$id5 = $_POST['id5'];
$newschool1 = clean_input($_POST['school1']);
$newschool2 = clean_input($_POST['school2']);
$newschool3 = clean_input($_POST['school3']);
$newschool4 = clean_input($_POST['school4']);
$newschool5 = clean_input($_POST['school5']);
$newgraduationyear1 = $_POST['year1'];
$newgraduationyear2 = $_POST['year2'];
$newgraduationyear3 = $_POST['year3'];
$newgraduationyear4 = $_POST['year4'];
$newgraduationyear5 = $_POST['year5'];
$newmajor1 = clean_input($_POST['major1']);
$newmajor2 = clean_input($_POST['major2']);
$newmajor3 = clean_input($_POST['major3']);
$newmajor4 = clean_input($_POST['major4']);
$newmajor5 = clean_input($_POST['major5']);
$newdegree1 = clean_input($_POST['degree1']);
$newdegree2 = clean_input($_POST['degree2']);
$newdegree3 = clean_input($_POST['degree3']);
$newdegree4 = clean_input($_POST['degree4']);
$newdegree5 = clean_input($_POST['degree5']);

$mysql1= mysql_query("UPDATE college SET college = '$newschool1', 
graduationyear = '$newgraduationyear1', major = '$newmajor1',degree = '$newdegree1'
WHERE userid = '$userid' AND id = '$id1'");
$mysql2= mysql_query("UPDATE college SET college = '$newschool2', 
graduationyear = '$newgraduationyear2', major = '$newmajor2',degree = '$newdegree2'
WHERE userid = '$userid' AND id = '$id2'");
$mysql3= mysql_query("UPDATE college SET college = '$newschool3', 
graduationyear = '$newgraduationyear3', major = '$newmajor3',degree = '$newdegree3'
WHERE userid = '$userid' AND id = '$id3'");
$mysql4= mysql_query("UPDATE college SET college = '$newschool4', 
graduationyear = '$newgraduationyear4', major = '$newmajor4',degree = '$newdegree4'
WHERE userid = '$userid' AND id = '$id4'");
$mysql5= mysql_query("UPDATE college SET college = '$newschool5', 
graduationyear = '$newgraduationyear5', major = '$newmajor5',degree = '$newdegree5'
WHERE userid = '$userid' AND id = '$id5'");
if (!$mysql1 || !$mysql2 || !$mysql3 || !$mysql4 || !$mysql5) { // add this check.
    die('Invalid query: ' . mysql_error());
}
//enable this to switch to dashboard page immediately.
header("Location: jobseeker_dashboard.php");
?>