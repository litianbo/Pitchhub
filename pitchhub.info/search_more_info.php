
<?php
include 'clean_data.php';
$host = "50.62.209.83:3306";
$user = "general";
$pass = "1234q";
$db = "pitchhub";
$connection = mysql_connect($host, $user, $pass);
mysql_select_db($db) or die ("Unable to select database!");
session_start();
$recruiterid = $_SESSION['userid'];
//find the companyid
$sql="SELECT * FROM recruiter WHERE userid='$recruiterid'";
$result=mysql_query($sql) or die (mysql_error());
$row=mysql_fetch_array($result);
$companyid = $row["companyid"];
//find name
$sql2="SELECT * FROM user WHERE userid='$recruiterid'";
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
				<?php echo $firstname . " " .  $lastname . ", Your ID is " . $recruiterid?></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                </nav>
            </div>
	
	
	
	
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
    <div class="row" style="background-color: #f8f8f8; vertical-align: middle">
        <div class="col-md-4">
            <br/>
            <div style="background-color: white; padding: 10px; margin: 4px;" class="col-md-offset-1">
                
                <?php
					//require 'authenticate.php';
                    //session_start();
					$userid = $_POST['info_id'];
                    $host = "50.62.209.83:3306";
                    $user = "general";
                    $password = "1234q";
                    $db = "pitchhub";
                    $connection = mysql_connect($host, $user, $password);
                    mysql_select_db($db) or die ("Unable to select database!");

                    $photo_query = mysql_query("SELECT * FROM photo WHERE userid = '$userid'") or die(mysql_error());
                    $row = mysql_fetch_array($photo_query);

                    $photo = $row['url'];
                    if($photo == "upload/default.gif" || $photo == ""){
                        echo '<img src="img/DefaultProfileImage.jpg" alt="default" style="height:210px; width:210px; margin: auto"/>';
                    }
                    else{
                        echo '<img src="'.$photo.'" alt="'.$photo.'" style="height:210px; width:210px; margin: auto"/>';
                    }
                    echo "<br/>";


                    $query = mysql_query("SELECT * FROM user WHERE userid = '$userid'") or die(mysql_error());
                    $row = mysql_fetch_array($query);
					
                    echo "<font size='6pt'><strong>". clean_output($row['firstname'])   ." ". clean_output($row['lastname'])."</strong></font>"."<br/>";
                echo clean_output($row['email']). "<br/>";
                //for colleges
                $education = mysql_query("SELECT * FROM college WHERE userid = '$userid'") or die(mysql_error());
                $education_counter = 1;
                while($rows = mysql_fetch_array($education)){
                    if(!empty($rows['degree']) || !empty($rows['major']) || !empty($rows['college']))
                        echo "<br/>";
                    if($education_counter == 1){
                        echo "<font size='3pt'><b><u>Education</u></b></font><br/>";
                    }
                    if(!empty($rows['degree'])){
                        echo "<i>".clean_output($rows['degree'])."</i>";
                    }
                    if(!empty($rows['major'])){
                        echo " " . clean_output($rows['major']);
                    }
                    if(!empty($rows['college'])){
                        echo "<br/>".clean_output($rows['college']);
                        if($rows['graduationyear'] != 0){
                            echo " ".$rows['graduationyear'];
                        }
                    }
                    $education_counter++;
                }
                //for social pages
                $query = mysql_query("SELECT * FROM jobseeker WHERE userid = '$userid'") or die(mysql_error());
                $row = mysql_fetch_array($query);
                if(($row['linkedin'] != "linkedin" && $row['linkedin'] != "") || ($row['facebook'] != "facebook" && $row['facebook'] != "") ||
                     ($row['monster'] != "monster" && $row['monster'] != "") || ($row['other'] != "other" && $row['other'] != "")){
                    echo "<br/><br/><font size='3pt'><b><u>Social Links</u></b></font><br/>";
                }
                if($row['linkedin'] != "linkedin" && $row['linkedin'] != ""){
                    echo '<img src="img/linkedin_logo.png" alt="" style="height:30px; width:30px; margin: auto"/>';
                    echo '<a href="http://'.clean_output($row['linkedin']).'">&#160&#160'.clean_output($row['linkedin']).'</a>';
                }
                if($row['facebook'] != "facebook" && $row['facebook'] != ""){
                    echo '<br/><img src="img/facebook_logo.png" alt="" style="height:30px; width:30px; margin: auto"/>';
                    echo '<a href="http://'.clean_output($row['facebook']).'">&#160&#160'.clean_output($row['facebook']).'</a>';
                }
                if($row['monster'] != "monster" && $row['monster'] != ""){
                    echo '<br/><img src="img/monster_logo.jpg" alt="" style="height:30px; width:30px; margin: auto"/>';
                    echo '<a href="http://'.clean_output($row['monster']).'">&#160&#160'.clean_output($row['monster']).'</a>';
                }
                if($row['other'] != "other" && $row['other'] != ""){
                    echo '<br/><a href="http://'.clean_output($row['other']).'">&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160'.clean_output($row['other']).'</a>';
                }
                    mysql_close($connection);
                ?>
                    
            </div>
            <div style="background-color: white; padding: 10px; margin: 10px;" class="col-md-offset-1">
                <!--Add dynamic information here-->
            </div>
        </div>
        <div class="col-xs-8">
            <br />
			
           
            <div style="background-color: white; padding: 10px; margin: 10px;" class="col-md-offset-1">
            <?php
            //displaying pitches for recruiter
			//displayed pitch array
			$displayedpitches = array();
			$matchedjobs = array();
            $userid = $_POST['info_id'];
            $con = mysqli_connect("50.62.209.83:3306", "general", "1234q") or die ("Could not connect ".mysql_error());
            mysqli_select_db($con, "pitchhub") or die ("could not find database: ".mysql_error());  
            $result = mysqli_query($con, "SELECT title, url,pitchid FROM pitches WHERE userid = '$userid'") or die("nope: ".mysql_error());
            $none = true;
            while($arrRecord = mysqli_fetch_row($result)){
                $none = false;
                $title = clean_output($arrRecord[0]);
                $url = clean_output($arrRecord[1]);
				$pitchid = clean_output($arrRecord[2]);
				
				?>
                    
						<?php //display pitch and print keyword
						$connection = mysql_connect("50.62.209.83:3306", "general", "1234q") or die ("Could not connect ".mysql_error());
						mysql_select_db("pitchhub") or die ("could not find database: ".mysql_error());  
						$keywords = mysql_query("SELECT * FROM keyword_pitches WHERE pitchid = 
						 '$pitchid'") or die("Error: ".mysql_error());
						 while($keywordrecord = mysql_fetch_assoc($keywords)){
							$recruiterjob = mysql_query("SELECT * FROM job_recruiter WHERE userid = 
							'$recruiterid'") or die("Error: ".mysql_error());
							//go over all the recruiter's job, to see if there is any match with jobseeker's pitch
							
							while($jobrecord = mysql_fetch_assoc($recruiterjob)){
							$jobid = $jobrecord['jobid'];
							$jobkeyword = mysql_query("SELECT * FROM keyword_jobs WHERE jobid = 
							'$jobid'") or die("Error: ".mysql_error());
							//this is the loop contains all of the job keyword
							while($jobkeywordrecord = mysql_fetch_assoc($jobkeyword)){
							
							if($keywordrecord['keyword'] == $jobkeywordrecord['keyword']){
							//if their keyword MATCH, display this pair HERE
							//looking for job title
							$jobs = mysql_query("SELECT * FROM job WHERE jobid = 
							'$jobid'") or die("Error: ".mysql_error());
							$jobresult = mysql_fetch_assoc($jobs);
							$jobtitle = $jobresult['jobtitle'];
							array_push($matchedjobs,$jobtitle);
							array_push($displayedpitches,$pitchid);
							}
							
							}
							
							}
							
							
			 }
			
			 }
			 //print matched pitches:
			$allpitches = array();
			
			$allpitchresulttemp = mysqli_query($con, "SELECT title, url,pitchid FROM pitches 
			WHERE userid = '$userid'  ") or die("nope: ".mysql_error());
            while($allpitchRecord = mysqli_fetch_array($allpitchresulttemp)){
			
			array_push($allpitches,$allpitchRecord[2]);
			}
			$allpitchresulttemp2 = mysqli_query($con, "SELECT title, url,pitchid FROM pitches 
			WHERE userid = '$userid' ORDER BY daterecorded DESC") or die("nope: ".mysql_error());
			$displayedpitchescopy = array_unique($displayedpitches);
			
            while($allpitchRecord2 = mysqli_fetch_array($allpitchresulttemp2)){
			foreach($displayedpitchescopy as $matchedpitchid){
			
			if($allpitchRecord2[2] ==  $matchedpitchid){
			$result = mysqli_query($con, "SELECT title, url,daterecorded FROM 
			pitches WHERE pitchid = '$matchedpitchid'") or die("Error: ".mysql_error());
			$matchedpitchRecord = mysqli_fetch_row($result);
			$title = clean_output($matchedpitchRecord[0]);
            $url = clean_output($matchedpitchRecord[1]);
			$date = $matchedpitchRecord[2];
			$index = array_search($matchedpitchid,$displayedpitches);
			$jobtitle = $matchedjobs[$index];
			$keyword_pitch = mysqli_query($con, "SELECT keyword FROM 
			keyword_pitches WHERE pitchid = '$matchedpitchid'") or die("Error: ".mysql_error());
			$keywordrecord = mysqli_fetch_array($keyword_pitch);
			 ?>
			  
			 <div style="border:1px solid grey; padding: 10px; margin: 10px">
                        <div class="row" style="margin-top:5px; margin-left:5px">
                            <p><h4><font color="red"><?php echo $title; ?></font></h4></p>
                        </div>
						
						<div class="pull-right">
                            <font color="red"><span title="<?php echo 'Uploaded on '.date('F d, Y \a\t g:i:s A', strtotime($date));
							?>"><?php echo date("F d", strtotime($date)); ?></font></span>
                        </div>
                        <div class="row">
                            <audio controls style="width: 90%; margin-left: 20px;">
                            <source src="<?php echo $url; ?>" type="audio/wav">
                            </audio>
                        </div>
							<div class="row" style="margin-top:5px; margin-left:5px">
                            <p><h4><font color="red"><?php echo "keyword: " . $keywordrecord[0]. 
							"<br/>It matches with your job: " . $jobtitle ; 
							
							?></font></h4></p>
							</div>
							</div>
			 
			<?php
			}
			}
			}
			//construct an array contains unmatched pitches using displayed pitches
			$undisplayedpitches = array();
			$result = mysqli_query($con, "SELECT title, url,pitchid FROM pitches WHERE userid = '$userid' ORDER BY daterecorded DESC
			") or die("nope: ".mysql_error());
            while($arrRecord = mysqli_fetch_row($result)){
                $none = false;
                $title = clean_output($arrRecord[0]);
                $url = clean_output($arrRecord[1]);
				$pitchid = clean_output($arrRecord[2]);
				
				$displayed = 3;
				foreach ($displayedpitches as $displayedpitchid){
				if($pitchid == $displayedpitchid){
				$displayed = 1;
				}
				//echo $displayed . "<br/>";
				}
				if($displayed==3){
				//echo $pitchid . "<br/>";
				array_push($undisplayedpitches,$pitchid);
				//echo $undisplayedpitches[0];
				}
				
				}
				
				foreach ($undisplayedpitches as $unmatchedpitchid){
				$result = mysqli_query($con, "SELECT title, url,daterecorded,pitchid FROM 
				pitches WHERE pitchid = '$unmatchedpitchid' ORDER BY daterecorded DESC") or die("Error: ".mysql_error());
				$unmatchedpitchRecord = mysqli_fetch_row($result);
				$title = clean_output($unmatchedpitchRecord[0]);
                $url = clean_output($unmatchedpitchRecord[1]);
				$date = clean_output($unmatchedpitchRecord[2]);
				$pitchid = clean_output($unmatchedpitchRecord[3]);
				
				$keyword_pitch = mysqli_query($con,"SELECT * FROM keyword_pitches 
					WHERE pitchid = '$pitchid'") or die("Error: ".mysql_error());
				$keywordrecord = mysqli_fetch_array($keyword_pitch);
				?>
						
							<div style="border:1px solid grey; padding: 10px; margin: 10px">
                        <div class="row" style="margin-top:5px; margin-left:5px">
                            <p><h4><?php echo $title; ?></h4></p>
                        </div>
						<div class="pull-right">
                            <span title="<?php echo'Uploaded on '.date('F d, Y \a\t g:i:s A', strtotime($date));
							?>"><?php echo  date("F d", strtotime($date)); ?></span>
                        </div>
                        <div class="row">
                            <audio controls style="width: 90%; margin-left: 20px;">
                            <source src="<?php echo $url; ?>" type="audio/wav">
                            </audio>
                        </div>
							
							<div class="row" style="margin-top:5px; margin-left:5px">
                            <p><h4><?php if(!empty($keywordrecord['keyword'])){echo "Keyword is: " . $keywordrecord['keyword'] . ".
							This pitch doesn't match any of your current job"; }
							
							?></h4></p>
							</div>
							</div>
							<?php
				}			
				
			mysql_close($connection);
            mysqli_close($con);
            if ($none){
                echo'
                    <p><h4> This user does not have any pitches! </h4></p>
                    ';

            }
            ?>
                
            </div>

            <br />
            <br />

        </div>
    </div>
</div>


<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
