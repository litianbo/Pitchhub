<?php
include 'clean_data.php';
include 'validate_redirecting.php';
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");
session_start();

if($_SESSION['logged_in'] == true){
    if(is_jobseeker())
        header("Location: jobseeker_dashboard.php");
}
else
    header("Location: recruiter_index.html");

$userid = $_SESSION['userid'];
$sql="SELECT * FROM recruiter WHERE userid='$userid'";
$result=mysql_query($sql) or die (mysql_error());
$row=mysql_fetch_array($result);
$companyid = $row["companyid"];
//find name
$sql2="SELECT * FROM user WHERE userid='$userid'";
$result2=mysql_query($sql2) or die (mysql_error());
$row2=mysql_fetch_array($result2);
$firstname = clean_output($row2["firstname"]);
$lastname = clean_output($row2["lastname"]);
$recruiterid = $_SESSION['userid'];

?>




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

<div class="container"> 
    <br/>
    <div class="row">
        <nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				
				<a class="navbar-brand" href="#">Welcome! <?php echo $companyid?> Recruiter 
				<?php echo $firstname . " " .  $lastname . ", Your ID is " . $userid?></a>
				
				
                <!-- <a class="navbar-brand">Search</a> -->
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <form method="post" action="recruitersearch.php" class="navbar-form navbar-left" role="search">
                        <form class="navbar-form navbar-left" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" name = "searchterm" placeholder="Find Job Seeker" style = "width: 400px">
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form>
                    </form>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </div>
    <div class="row">
        <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
       <button type="button" class="btn btn-primary"  style ="vertical-align: middle" onclick="javascript:window.location.href = 'recruiter_dashboard.php';"> <i class="glyphicon glyphicon-home"></i> Home </button> 
      

        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-wrench"></i> 
                Account <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
				<li><a href="#">Update Information</a></li>
                <li><a href="recruiter_settings.php">Setting</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-question-sign"></i> 
                Help <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#">FAQ's </a> </li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>

    </div>
    <div class="row" style="background-color: #f8f8f8; vertical-align: middle">
        <div class="col-md-3" style="float:left; width:25%;">
            <br/>
            <label for="exampleInputPassword1"> <font size = "6">Filter By:</font> </label>
            <ul class="nav nav-pills nav-stacked">
                <?php
                $db = "pitchhub";
                $con = mysql_connect("50.62.209.83:3306", "general", "1234q") or die ("Could not connect ".mysql_error());
                mysql_select_db($db, $con) or die ("could not find database: ".mysql_error());

                $jobidquery = "SELECT jr.jobid FROM job_recruiter jr WHERE jr.userid=$recruiterid";
                $jobidresults = mysql_query($jobidquery, $con) or die('Error: ' . mysql_error());
                //storing all jobids from job_recruiter in a array which is used later to track which
                //jobseekers have already been added to which jobs
                $jobids = array();
                while ($jobidrow = mysql_fetch_row($jobidresults)){
                    $jobids[] = $jobidrow[0];
                }
                $result = mysql_query("SELECT filtertype FROM search", $con) or die("nope: ".mysql_error());
                if (mysql_num_rows($result)==0){
                    echo'No Filters';
                }
                else{
                    $activeTab = True;
                    $filterTabNum = 0;
                    while($arrRecord = mysql_fetch_row($result)){
                        $filterTabID = "filter".$filterTabNum;
                        $filterTitle = clean_output($arrRecord[0]);
                        if ($activeTab){
                            echo '<li class="active"><a href="#'.$filterTabID.'" data-toggle="tab">'.$filterTitle.'</a></li>';
                            $activeTab = False;
                        }
                        else{
                            echo '<li><a href="#'.$filterTabID.'" data-toggle="tab">'.$filterTitle.'</a></li>';
                        }
                        $filterTabNum++; 
                    }
                }
                mysql_close($con);
                ?>
            </ul>
            <br/>
        </div>
        <div class="col-md-9" style="float:left; width:75%;">
            <div class="tab-content" style="background-color: #f8f8f8">
                <!--Tab for filter0-->
                <div class="tab-pane fade active in" style="background-color: white" id="filter0">
                    <br />
					
						<?php
						$host = "50.62.209.83:3306";
						$user = "general";
						$pass = "1234q";
						$db = "pitchhub";
						$connection = mysql_connect($host, $user, $pass);
						mysql_select_db($db) or die ("Unable to select database!");

						$searchTerm = $_POST['searchterm'];
						$searchTerms = explode(' ', $searchTerm);
						$searchTermWords = array();
						foreach ($searchTerms as $term) {
							$term = trim($term);
							$term = preg_replace('/[^a-zA-Z0-9@.]+/', ' ', $term);
							if( !empty($term)) {
								$searchTermWords[] = "firstname LIKE '%$term%' OR lastname LIKE '%$term%' OR email LIKE '%$term%'";
							}
						}
						$combo = implode(' OR ', $searchTermWords);

						$query = "SELECT userid, firstname, lastname, email FROM user WHERE $combo ORDER BY lastname, firstname";

						$result = mysql_query($query) or die(mysql_error());
						if (!$result) {
                        ?> <div style = "margin-left:55px"> <?php echo 'Results found: 0';?> </div>
						<?php }else{?>
							<div style = "margin-left:55px"> <?php echo "Results found: " . mysql_num_rows($result); ?> </div>
						<?php while($row = mysql_fetch_array($result))
						{?>
							<div style="background-color: white; border: 1px solid grey; padding: 15px" class="col-md-offset-1">
								<div class = "row">
									<div style="margin-left:20px" class = "col-md-3">
									<?php
										$photo_id = $row['userid'];
										$connection2 = mysql_connect($host, $user, $pass);
										mysql_select_db($db) or die ("Unable to select database!");
										$photo_query = mysql_query("SELECT url FROM photo WHERE userid = '$photo_id'") or die(mysql_error());
										if(mysql_num_rows($photo_query) > 0) {
											$photo_result = mysql_fetch_row($photo_query);
											$photo = $photo_result[0];
											if(empty($photo))
											{
												echo '<img src="img/DefaultProfileImage.jpg" alt="default" style="length:70px; width:70px;"/>';
											}
											else
											{
												echo '<img src="'.$photo.'" alt="'.$photo.'" style="length:70px; width:70px;"/>';
											}
										}
										else {
											echo '<img src="img/DefaultProfileImage.jpg" alt="default" style="length:70px; width:70px;"/>';
										}
									?>									
									</div>


                                    <?php 
                                    $education_query = mysql_query("SELECT * FROM college WHERE userid = '$photo_id'") or die(mysql_error());
                                    $education = mysql_fetch_array($education_query);
                                    $school = clean_output($education["college"]);
                                    ?>

									<div class = "col-md-5">
										<p style="margin-top:5px; margin-left:20px; font-size:24pt"><?php echo clean_output($row['lastname']) . 
										", " . clean_output($row['firstname']) . "<br />"; ?></p>
                                        <h6 style="margin-top:10px; margin-left:20px; font-size:10pt"><?php echo $school; ?></h6>
									</div>
									<div style="margin-left:20px" class = "col-md-2">
                                        <p href="#" 
                                            class="btn btn-sm btn-info" 
                                            data-toggle="popover" 
                                            title="Add to Jobs"
                                            data-content="
                                            <form method='post' action='add_jobseeker_to_job.php'>
                                                <div style='width: 200px;'>
                                                    <?php
                                                    $host = "50.62.209.83:3306";
                                                    $user = "general";
                                                    $db = "pitchhub";
                                                    $pass = "1234q";
                                                    $connection = mysql_connect($host, $user, $pass);
                                                    mysql_select_db($db) or die ("Unable to select database!");

                                                    $canAdd = false;
                                                    $jsID = $row['userid']; 
                                                    foreach($jobids as $jID){
                                                        $query2 = "SELECT *
                                                            FROM savedjobseekers sjs
                                                            WHERE sjs.jobseekerid=$jsID AND sjs.recruiterid=$recruiterid AND sjs.jobid=$jID";
                                                        $query2Result = mysql_query($query2, $connection) or die('Error: ' . mysql_error());
                                                        if (mysql_num_rows($query2Result) == 0) {
                                                            $jobquery = "SELECT j.jobtitle 
                                                                FROM job j 
                                                                WHERE j.jobid=$jID";
                                                            $checkboxResult0 = mysql_query($jobquery, $connection) or die('Error: ' . mysql_error());
                                                            $jobrecord = mysql_fetch_row($checkboxResult0);
                                                            echo "<input type='checkbox' name='$jID'>$jobrecord[0]<br>";    
                                                            $canAdd = true;
                                                        }
                                                        else{
                                                            continue;
                                                        }
                                                    }
                                                    mysql_close($connection);
                                                    if(!$canAdd){
                                                        echo "You have added this jobseeker to all possible jobs.";
                                                    }
                                                    else{
                                                        echo "<br>";
                                                        echo "<button type='submit' class='btn btn-info btn-sm' value='$jsID' name='jobseekerid' >Submit</button>";
                                                    }
                                                    ?>
                                                </div>
                                            </form>
                                            "
                                            >Add to Job</p>
											<br>
												<form method="post" action="search_more_info.php">
                                                <button type='submit' value="<?php echo $row['userid']?>" name='info_id' class='btn btn-info btn-sm' style="margin-top:10px"> More Info </button>
												</form>
									</div>
								</div>
							</div>
						<?php
						}
						}?>
						
                    <br />

                </div>

                <!--Tab for filter1-->
                <div class="tab-pane fade in" style="background-color: white" id="filter1">
                    <br />
                    
						<?php
						$host = "50.62.209.83:3306";
						$user = "general";
						$pass = "1234q";
						$db = "pitchhub";
						$connection = mysql_connect($host, $user, $pass);
						mysql_select_db($db) or die ("Unable to select database!");

						$searchTerm = $_POST['searchterm'];
						$searchTerms = explode(' ', $searchTerm);
						$searchTermWords = array();
						foreach ($searchTerms as $term) {
							$term = trim($term);
							$term = preg_replace('/[^a-zA-Z0-9@.]+/', ' ', $term);
							if( !empty($term)) {
								$searchTermWords[] = "firstname LIKE '%$term%' OR lastname LIKE '%$term%' OR email LIKE '%$term%'";
							}
						}
						$combo = implode(' OR ', $searchTermWords);

						$query = "SELECT userid, firstname, lastname, email FROM user WHERE $combo ORDER BY firstname, lastname";

						$result = mysql_query($query);
						if (!$result) {
                        ?> <div style = "margin-left:55px"> <?php echo 'Results found: 0';?> </div>
						<?php }else{?>
							<div style = "margin-left:55px"> <?php echo "Results found: " . mysql_num_rows($result); ?> </div>
						<?php while($row = mysql_fetch_array($result))
						{?>
							<div style="background-color: white; border: 1px solid grey; padding: 15px" class="col-md-offset-1">
								<div class = "row">
									<div style="margin-left:20px" class = "col-md-3">
										<?php
										$photo_id = $row['userid'];
										$connection2 = mysql_connect($host, $user, $pass);
										mysql_select_db($db) or die ("Unable to select database!");
										$photo_query = mysql_query("SELECT url FROM photo WHERE userid = '$photo_id'") or die(mysql_error());
										if(mysql_num_rows($photo_query) > 0) {
											$photo_result = mysql_fetch_row($photo_query);
											$photo = $photo_result[0];
											if(empty($photo))
											{
												echo '<img src="img/DefaultProfileImage.jpg" alt="default" style="length:70px; width:70px;"/>';
											}
											else
											{
												echo '<img src="'.$photo.'" alt="'.$photo.'" style="length:70px; width:70px;"/>';
											}
										}
										else {
											echo '<img src="img/DefaultProfileImage.jpg" alt="default" style="length:70px; width:70px;"/>';
										}
										?>		
									</div>

                                    <?php 
                                    $education_query = mysql_query("SELECT * FROM college WHERE userid = '$photo_id'") or die(mysql_error());
                                    $education = mysql_fetch_array($education_query);
                                    $school = clean_output($education["college"]);
                                    ?>


									<div class = "col-md-5">
										<p style="margin-top:5px; margin-left:20px; font-size:24pt"><?php echo $row['firstname'] . 
										" " . $row['lastname'] . "<br />"; ?></p>
                                        <h6 style="margin-top:10px; margin-left:20px; font-size:10pt"><?php echo $school; ?></h6>

									</div>
									<div style="margin-left:20px" class = "col-md-2">
                                        <p href="#"
                                            class="btn btn-sm btn-info" 
                                            data-toggle="popover" 
                                            data-content="<input type='button' value='implement this later'>"
                                            >Add to Job</p>
											<br>
                                                <form method="post" action="search_more_info.php">
                                                <button type='submit' value="<?php echo $row['userid']?>" name='info_id' class='btn btn-info btn-sm' style="margin-top:10px"> More Info </button>
												</form>
									</div>
								</div>
							</div>
						<?php
						}
						}?>
					
                    <br />
                </div>
				
            </div>
        </div>
    </div>
</div>


<script language="javascript" type="text/javascript">
$(function () {
    $('#logintab a:first').tab('show')
}
</script>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('[data-toggle="popover"]').popover({trigger: 'click',placement: 'right', html: 'true'});
    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');

            }
        });
    });;
});
</script>
</body>
</html>
