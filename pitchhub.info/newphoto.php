<?php
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");
date_default_timezone_set('America/Los_Angeles');
$date = date('m_d_Y_h_i_s_a', time());
session_start();
$userid = $_SESSION['userid'];
//for photo
$photoFileName = $date.$userid.".jpg";
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["photo"]["name"]);
$extension = end($temp);

if(!empty($_FILES["photo"]["name"])){
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
$query = mysql_query("SELECT * FROM photo WHERE userid = '$userid'") or die(mysql_error());
$numofrows = mysql_num_rows($query);
if($numofrows==1){
$sql = "UPDATE photo SET
url = '$photo' WHERE userid = '$userid'";
if(!mysql_query($sql,$connection ))
{
die('Error: ' . mysql_error());
}
}
else if($numofrows == 0){
$sql = "INSERT INTO photo (photoid, userid,url)
VALUES
(DEFAULT,'$userid','$photo')";
if(!mysql_query($sql,$connection ))
{
die('Error: ' . mysql_error());
}
}else{
die('we have more than one photo for this user, something is wrong!!!');
}
}
else{
//user didn't select a photo
}
mysql_close($connection);
header("Location: jobseeker_dashboard.php");
?>
