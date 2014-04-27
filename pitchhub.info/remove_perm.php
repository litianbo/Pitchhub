<!DOCTYPE html>
<html>
<head>
<title>PitchHub</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

<style>
.tab-pane{
    border-left: solid 1px #ddd;
    border-right: solid 1px #ddd;
    border-bottom: solid 1px #ddd;
    padding: 0.8em;
}
</style>
</head>

<?php
include 'clean_data.php';
$host = "50.62.209.83:3306";
$user = "general";
$db = "pitchhub";
$pass = "1234q";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");

session_start();
$userId=$_SESSION['userid'];
$jobId = $_POST['jobid'];
$jobTitle = clean_output($_POST['remove_id']);

$sql="SELECT permission FROM job_recruiter WHERE userid='$userId' AND jobid='$jobId'";
$result=mysql_query($sql) or die (mysql_error());
$row=mysql_fetch_array($result);
$permission = $row["permission"];

if($permission)
{
	$sql="SELECT userid, permission FROM job_recruiter WHERE userid!='$userId' AND jobid='$jobId' AND permission='1'";
	$result=mysql_query($sql) or die (mysql_error());
	if(!$result)
	{
		echo "Only you have permission to edit this folder!";
	}
	else if(mysql_num_rows($result)==0)
	{
		echo "Only you have permission to edit this folder!";
	}
	else
	{
		while($row=mysql_fetch_array($result))
		{
			$otherUser = $row["userid"];
			$connection2 = mysql_connect($host, $user, $pass);
			mysql_select_db($db) or die ("Unable to select database!");
			$sql2="SELECT firstname, lastname FROM user WHERE userid='$otherUser' ORDER BY lastname, firstname";
			$result2=mysql_query($sql2) or die (mysql_error());
			$row2=mysql_fetch_array($result2);
			?>
			<div style="background-color: white; border: 1px solid grey; padding: 15px" class="col-md-offset-1">
				<div class = "row">
					<div class = "col-md-5">
						<p style="margin-top:5px; margin-left:20px; font-size:24pt"><?php echo clean_output($row2['lastname']) . ", " . clean_output($row2['firstname']) . "<br />"; ?></p>
					</div>
					
					<div style="margin-left:20px" class = "col-md-2">
						<form method="post" action="remove_perm2.php" onsubmit="return confirm('Are you sure you want to remove this recruiter's permission to edit from <?php echo $jobTitle; ?>?')">
							<button type="submit" name="recruiterid" value="<?php echo $otherUser; ?>" class="btn btn-danger btn-sm" style="margin: 10px; float: left;">
								<i class="glyphicon glyphicon-trash"></i></button>
							<input type="hidden" name="jobid" value=" <?php echo $jobId; ?>">
						</form>
					</div>
				</div>
			</div>
			<?php
		}
	}
}
else
{
	echo "You do not have permission to edit this folder!";
}

//header("Location: recruiter_dashboard.php");
?>

<script src="js/bootstrap.min.js"></script>
</html>