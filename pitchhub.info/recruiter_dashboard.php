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
//find the companyid
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

<body style="background-color: #E5E4E2">
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
			<div class="btn-group" style="float: right">
<!--			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-minus-sign"></i>Remove Permission</button>
			<ul class="dropdown-menu" role="menu">
                <?php
                /*$db = "pitchhub";
                $con = mysql_connect("50.62.209.83:3306", "general", "1234q") or die ("Could not connect ".mysql_error());
                $jobsExist = true;
                mysql_select_db($db, $con) or die ("could not find database: ".mysql_error());
                $result = mysql_query("SELECT j.jobtitle, j.jobid FROM job j, job_recruiter jr WHERE j.jobid=jr.jobid AND jr.userid=$userid", $con) or die("nope: ".mysql_error());
                if (mysql_num_rows($result)==0){
                    echo'You currently have no jobs added.  To add a job, click on add job in the top right corner';
                    $jobsExist = false;
                }
                else{
					$remove_num=0;
                    while($arrRecord = mysql_fetch_assoc($result)){
                        $jobTitle = clean_output($arrRecord["jobtitle"]);
						$jobId = $arrRecord["jobid"];
						//echo '<li><button type="button" class="btn btn-primary" style ="vertical-align: middle" data-toggle="modal" data-id="testing" data-target="#remove_perm">'.$jobTitle.'</button></li>';	
						?>
						<form method="post" action="remove_perm.php">
                        <button type='submit' value="<?php echo $jobTitle?>" name='remove_id' class='btn btn-info btn-sm' style="margin:1px; width:155px;"> <?php echo $jobTitle; ?> </button>
                        <input type="hidden" name="jobid" value=" <?php echo $jobId; ?>">
						</form>
						<?php
						$remove_num++;
					}
                }
                */?>
            </ul> -->
			

            <button type="button" class="btn btn-primary"  style ="vertical-align: middle" data-toggle="modal" data-target="#addJob"> <i class="glyphicon glyphicon-plus-sign"></i> Add a Job</button> 
            <!-- Modal -->
            <div class="modal fade" id="addJob" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Add a job</h4>
                        </div>
                        <form role="form" method = "post" action = "add_job.php">
                            <div class="modal-body">
                                <div style="margin-left: auto; margin-right: auto;">
                                    <div class="form-group">
                                        <label for="jobTitle">Job Title</label>
                                        <input type="text" class="form-control" id="jobTitle" name="job" placeholder="Job Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="keywords">Keywords</label>
                                        <input type="text" class="form-control" id="keywords" name="keyword" placeholder="Keywords">
                                    </div>
									<div class="form-group">
                                        <label for="editors">Internal Editors</label>
                                        <input type="text" class="form-control" id="editors" name="editor" placeholder="Editor IDs separated with spaces">
                                    </div>
									<div class="form-group">
										<label for="editors2">External Editors</label>
										<div style="margin-left: auto; margin-right: auto;">
											<div style="float:left; width:50%;">
												<input type="text" class="form-control" id="editors2" name="editor2" placeholder="Editor's Company ID">
											</div>
											<div style="float:left; width:50%;">
												<input type="text" class="form-control" id="editors3" name="editor3" placeholder="Editor IDs separated with spaces">
											</div>
										</div>
									</div>
									<div class="form-group">
                                        <label for="viewers">Viewers</label>
                                        <input type="text" class="form-control" id="viewers" name="viewer" placeholder="Viewer IDs separated with spaces">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>

    </div>
    <div class="row" style="background-color: #f8f8f8; vertical-align: middle">
        <div class="col-md-3" style="float:left; width:25%;">
            <br/>
            <label for="exampleInputPassword1"> <font size = "6">Jobs:</font> </label>
            <ul class="nav nav-pills nav-stacked">
                <?php
                $db = "pitchhub";
                $con = mysql_connect("50.62.209.83:3306", "general", "1234q") or die ("Could not connect ".mysql_error());
                $jobsExist = true;
                mysql_select_db($db, $con) or die ("could not find database: ".mysql_error());
                $result = mysql_query("SELECT j.jobtitle, j.jobid FROM job j, job_recruiter jr WHERE j.jobid=jr.jobid AND jr.userid=$userid", $con) or die("nope: ".mysql_error());
                if (mysql_num_rows($result)==0){
                    echo'You currently have no jobs added.  To add a job, click on add job in the top right corner';
                    $jobsExist = false;
                }
                else{
					
                    $activeTab = True;
                    $jobIDs = array();
                    while($arrRecord = mysql_fetch_assoc($result)){
                        $jobTabID = "job".$arrRecord["jobid"];
						$editTabID = "edit".$arrRecord["jobid"];
						$currentJobID = $arrRecord["jobid"];
                        $jobIDs[] = $arrRecord["jobid"];
                        $jobTitle = clean_output($arrRecord["jobtitle"]);
                        if ($activeTab){
                            //echo '<li class="active"><a href="#'.$jobTabID.'" data-toggle="tab" style="float:left; width:75%">'.$jobTitle.'</a><button style="float:left; width:23%; margin:1%;" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-minus-sign"></i>Edit</button></li>';

							$sql="SELECT permission FROM job_recruiter WHERE userid='$userid' AND jobid='$currentJobID'";
							$result2=mysql_query($sql) or die (mysql_error());
							$row=mysql_fetch_array($result2);
							$permission = $row["permission"];

							if($permission)
                            {
								echo '<li class="active" style="float:left; width:75%"><a href="#'.$jobTabID.'" data-toggle="tab">'.$jobTitle.'</a></li>';
								echo '<li style="float:left; width:23%; margin:1%;"><a href="#'.$editTabID.'" data-toggle="tab">Edit</a></li>';
							}
							else
							{
								echo '<li class="active"><a href="#'.$jobTabID.'" data-toggle="tab">'.$jobTitle.'</a></li>';
							}
							$activeTab = false;
                        }
                        else{
							$sql="SELECT permission FROM job_recruiter WHERE userid='$userid' AND jobid='$currentJobID'";
							$result2=mysql_query($sql) or die (mysql_error());
							$row=mysql_fetch_array($result2);
							$permission = $row["permission"];

							if($permission)
                            {
								echo '<li style="float:left; width:75%"><a href="#'.$jobTabID.'" data-toggle="tab">'.$jobTitle.'</a></li>';
								echo '<li style="float:left; width:23%; margin:1%;"><a href="#'.$editTabID.'" data-toggle="tab">Edit</a></li>';
							}
							else
							{
								echo '<li><a href="#'.$jobTabID.'" data-toggle="tab">'.$jobTitle.'</a></li>';
							}
                        }
                    }
                }
                ?>
            </ul>
            <br/>
        </div>
        <div class="col-md-9" style="float:left; width:75%;">
            <div class="tab-content" style="background-color: #f8f8f8">
                <?php
                if($jobsExist){
                $recruiterid = $userid;
                $activeFlag = true;
                foreach($jobIDs as $jobID){
                    if ($activeFlag){
                        $divClass = "tab-pane fade active in";
                        $activeFlag = false;
                    }
                    else
                        $divClass = "tab-pane fade in";
                ?>
                    <div class="<?php echo $divClass?>" style="background-color: white" id="<?php echo'job'.$jobID?>">
                        <br />
                        <?php
						//display keyword
						$keywordsql = "SELECT * FROM keyword_jobs WHERE jobid = '$jobID'";
						$keywordresult = mysql_query($keywordsql) or die("Error: ".mysql_error());
						while($rows = mysql_fetch_array($keywordresult)){
						if (!empty($rows['keyword'])){
						echo "Keyword: " . clean_output($rows['keyword']) . "<br/>";
						}
						else{
						echo "You have no keyword for this job <br/>";
						}
						}
						
						
						
                        $sql3="SELECT u.userid, u.firstname, u.lastname FROM user u, savedjobseekers s WHERE u.userid=s.jobseekerid AND s.recruiterid='$recruiterid' AND s.jobid = '$jobID'";
                        $result3=mysql_query($sql3) or die (mysql_error());
                        if (mysql_num_rows($result3) == 0) { 
                            echo 'There are no jobseekers added to this job.  Please use search for jobseekers and add them';
                        }
                        else{
                            while($record3 = mysql_fetch_assoc($result3)){
                                $fname = clean_output($record3["firstname"]);
                                $lname = clean_output($record3["lastname"]);
                                $useridphoto = $record3["userid"];
                        ?>
                            <div style="background-color: white; border: 1px solid grey; padding: 15px" class="col-md-offset-1">
                                <div class = "row">
                                    <div style="margin-left:20px" class = "col-md-3">
										<?php
										$photo_query = mysql_query("SELECT url FROM photo WHERE userid = '$useridphoto'") or die(mysql_error());
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
                                    <div class = "col-md-5">
                                        <p style="margin-top:5px; padding-bottom: 0px;margin-left:20px; font-size:24pt"><?php echo $fname.' '.$lname; ?></p>
                                        <?php 
                                        $education_query = mysql_query("SELECT * FROM college WHERE userid = '$useridphoto'") or die(mysql_error());
                                        $education = mysql_fetch_array($education_query);
                                        $school = clean_output($education["college"]);
                                        ?>

                                        <h6 style="margin-top:10px; margin-left:20px; font-size:10pt"><?php echo $school; ?></h6>
                                    </div>
                                    <div style="margin-left:20px;" class = "col-md-3">
                                        <form method="post" action="search_more_info.php">
                                            <button type='submit' value="<?php echo $record3['userid']?>" name='info_id' class='btn btn-info btn-sm' style="margin:10px; float: left;"> More Info </button>
                                        </form>
                                        <form method="post" action="removejobseeker.php" onsubmit="return confirm('Are you sure you want to delete this jobseeker from this job?')">
                                            <button type="submit" name="jobseekerid" value="<?php echo $record3['userid']; ?>" class="btn btn-danger btn-sm" style="margin: 10px; float: left;">
                                                <i class="glyphicon glyphicon-trash"></i></button>
                                            <input type="hidden" name="recruiterid" value=" <?php echo $recruiterid; ?>">
                                            <input type="hidden" name="jobid" value=" <?php echo $jobID; ?>">
                                        </form>   
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
					
					<!-- The Edit Tab -->
					<div class="tab-pane fade in" style="background-color: white" id="<?php echo'edit'.$jobID?>">
						<!--folder editing-->
						<div class="container">
							<form method = "post" action = "change_job_folder_name.php">
								<div>
									<label for="cfname" style="float:left; width:100%;">Change Folder Name</label>
									<input type="text" class="form-control" id="cfname" name="fname" placeholder="Folder Name" style="float:left; width:75%;">
									<input type="hidden" name="cfjob" value=<?php echo $jobID; ?>>
									<button type="submit" class="btn btn-default" style="float:left; width:23%; margin-left:1%">Change</button>
								</div>
							</form>
							<form method = "post" action = "change_job_folder_keyword.php">
								<div>
									<label for="ckeys" style="float:left; width:100%;">Change Keyword</label>
									<input type="text" class="form-control" id="ckeys" name="ckey" placeholder="Keyword" style="float:left; width:75%;">
									<input type="hidden" name="cfjob" value=<?php echo $jobID; ?>>
									<button type="submit" class="btn btn-default" style="float:left; width:23%; margin-left:1%">Change</button>
								</div>
							</form>
							<form method = "post" action = "add_internal.php">
								<div>
									<label for="addie" style="float:left; width:100%;">Add Internal Editors</label>
									<input type="text" class="form-control" id="addie" name="addi" placeholder="Editors IDs seperated with spaces" style="float:left; width:75%;">
									<input type="hidden" name="addijob" value=<?php echo $jobID; ?>>
									<button type="submit" class="btn btn-default" style="float:left; width:23%; margin-left:1%">Add</button>
								</div>
							</form>
							<form method = "post" action = "add_external.php">
								<div>
									<label for="addee" style="float:left; width:100%;">Add External Editors</label>
									<div style="float:left; width:37%;">
										<input type="text" class="form-control" id="addee" name="adde" placeholder="Editor's Company ID">
									</div>
									<div style="float:left; width:37%; margin-left:1%;">
										<input type="text" class="form-control" id="addee2" name="adde2" placeholder="Editor IDs separated with spaces">
									</div>
									<input type="hidden" name="addejob" value=<?php echo $jobID; ?>>
									<button type="submit" class="btn btn-default" style="float:left; width:23%; margin-left:1%">Add</button>
								</div>
							</form>
							<form method = "post" action = "add_viewer.php">
								<div>
									<label for="addvi" style="float:left; width:100%;">Add Viewers</label>
									<input type="text" class="form-control" id="addvi" name="addv" placeholder="Editors IDs seperated with spaces" style="float:left; width:75%;">
									<input type="hidden" name="addvjob" value=<?php echo $jobID; ?>>
									<button type="submit" class="btn btn-default" style="float:left; width:23%; margin-left:1%">Add</button>
								</div>
							</form>
						</div>

						<br />
						
						<!-- Editing Permissions-->
						<div class="container">
							<p style="float:left; width:50%;">Editors:</p>
							<p style="float:left; width:50%;">Viewers:</p>
							<div class="container" style="float:left; width:50%;">
								<?php
								$sql="SELECT userid, permission FROM job_recruiter WHERE userid!='$userid' AND jobid='$jobID' AND permission='1'";
								$result=mysql_query($sql) or die (mysql_error());
								if(!$result || mysql_num_rows($result)==0)
								{
									echo "<p>Only you have permission to edit this folder!</p>";
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
										<div style="background-color: white; border: 1px solid grey; padding: 15px">
											<div class = "row">
												<div class = "col-md-5" style="float:left; width:75%;">
													<p style="font-size:18pt; margin: 10px;"><?php echo clean_output($row2['lastname']) . ", " . clean_output($row2['firstname']) . "<br />"; ?></p>
												</div>
												
												<div style="float:left; width:25%;" class = "col-md-3">
													<form method="post" action="remove_perm2.php">
														<button type="submit" name="recruiterid" value="<?php echo $otherUser; ?>" class="btn btn-danger btn-sm" style="margin: 10px; float: left;">
															<i class="glyphicon glyphicon-trash"></i></button>
														<input type="hidden" name="jobid" value=" <?php echo $jobID; ?>">
													</form>
												</div>
											</div>
										</div>
										<?php
									}
								}
							echo "</div>";
								
							echo "<div class=\"container\" style=\"float:left; width:50%;\">";
								$sql="SELECT userid, permission FROM job_recruiter WHERE userid!='$userid' AND jobid='$jobID' AND permission='0'";
								$result=mysql_query($sql) or die (mysql_error());
								if(!$result || mysql_num_rows($result)==0)
								{
									echo "<p>Only you can view this folder!</p>";
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
										<div style="background-color: white; border: 1px solid grey; padding: 15px">
											<div class = "row">
												<div class = "col-md-5" style="float:left; width:75%;">
													<p style="font-size:18pt; margin: 10px;"><?php echo clean_output($row2['lastname']) . ", " . clean_output($row2['firstname']) . "<br />"; ?></p>
												</div>
												
												<div style="float:left; width:25%;" class = "col-md-3">
													<form method="post" action="remove_viewer.php">
														<button type="submit" name="viewerid" value="<?php echo $otherUser; ?>" class="btn btn-danger btn-sm" style="margin: 10px; float: left;">
															<i class="glyphicon glyphicon-trash"></i></button>
														<input type="hidden" name="jobid" value=" <?php echo $jobID; ?>">
													</form>
												</div>
											</div>
										</div>
										<?php
									}
								}
								?>
							</div>
						</div>
					</div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>


<script language="javascript" type="text/javascript">
$(function () {
    $('#logintab a:first').tab('show')
}

function confirmdelete(){
    confirm("Are you sure you want to delete this jobseeker from this list?");
}
</script>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
