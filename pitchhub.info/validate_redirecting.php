<?php

	function is_jobseeker(){ 
		$host = "50.62.209.83:3306";
		$user = "general";
		$pass = "1234q";
		$db = "pitchhub";
		$connection = mysql_connect($host, $user, $pass);
		mysql_select_db($db) or die ("Unable to select database!");
		if (session_status() == PHP_SESSION_NONE)
			session_start();
		$userid = $_SESSION['userid'];
		$sql2="SELECT * FROM user WHERE userid='$userid'";
		$result2=mysql_query($sql2) or die (mysql_error());
		$row2=mysql_fetch_array($result2);

		if($row2['jobseeker_TF'] == true)
   		 	return true;
   		else
   			return false;
	}

?>