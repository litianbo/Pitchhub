<?php
include 'clean_data.php';
$host =  "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$college = "collegetable";
	$connection = mysql_connect($host, $user, $pass);
	mysql_select_db('pitchhub');
	$search = clean_input($_GET['term']);    
	//echo $search;
    $result = mysql_query("SELECT collegename FROM colleges WHERE collegename 
	LIKE '%$search%' ") or die(mysql_error());
    $rows = array();
    while($row = mysql_fetch_array($result))
	{
	$rows[] = array('label' => $row['collegename']);
	}

echo json_encode($rows);
?>