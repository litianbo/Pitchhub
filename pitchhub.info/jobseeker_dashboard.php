<!DOCTYPE html>

<?php
    include 'validate_redirecting.php';
    session_start();
    if($_SESSION['logged_in'] == true){
        if(!is_jobseeker())
            header("Location: recruiter_dashboard.php");
    }
    else
        header("location: index.html");
?>
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
                <a class="navbar-brand" href="jobseeker_dashboard.php"><img src="img/pitchhub_logo.png" height="35" width="35" alt="..." class="img-rounded" style ="margin-right: 40px" />PitchHub</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
        </nav>
    </div>



    <div class="row">
        <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->

        <button type="button" class="btn btn-primary"  style ="vertical-align: middle" onclick="javascript:window.location.href = 'jobseeker_dashboard.php';"> <i class="glyphicon glyphicon-home"></i> Home</button>

        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-user"></i> 
                Profile <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="jobseeker_dashboard.php">View your profile</a></li>
                <li><a href="jobseeker_profile_update.php">Update profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-wrench"></i> 
                Account <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="jobseeker_settings.php">Setting</a></li>
                <!-- <li><a href="#">Privacy</a></li> -->
            </ul>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-question-sign"></i> 
                Help <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="jobseeker_faq.php">FAQ's </a> </li>
                <li><a href="jobseeker_contact.php">Contact Us</a></li>
            </ul>
        </div>
    </div>

    <div class="row" style="background-color: #f8f8f8; vertical-align: middle">
        <div class="col-md-4">
            <br/>
            <div style="background-color: white; padding: 10px; margin: 4px;" class="col-md-offset-1">
                <?php
                include 'clean_data.php';
                //require 'authenticate.php';
                $userid = $_SESSION['userid'];
                $host = "50.62.209.83:3306";
                $user = "general";
                $password = "1234q";
                $db = "pitchhub";
                $connection = mysql_connect($host, $user, $password);
                mysql_select_db($db) or die ("Unable to select database!");


                date_default_timezone_set('America/Los_Angeles');
                $date = date('m_d_Y_h_i_s_a', time());
                $auphonicName = $date.$userid;
                $_SESSION['auphonicName'] = $auphonicName;

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
            <button type="button" class="btn  btn-danger"  style ="vertical-align: middle; margin: 10px;" data-toggle="modal" data-target="#recordPitch"> <i class="glyphicon glyphicon-record"></i> Record a pitch </button> 

            <!-- Modal -->
            <div class="modal fade" id="recordPitch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Record your pitch</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <button type="button" onclick="startRecording()" id="start" title="Begin Recording" class="btn btn-sm btn-danger pull-left" style="width: 7%; margin-right: 1%;"><i class="glyphicon glyphicon-record"></i></button>
                                <button type="button" onclick="stopRecording()" id="stop" title="Stop Recording" class="btn btn-sm btn-danger pull-left" style="width: 7%; margin-right: 1%;" disabled="disabled"><i class="glyphicon glyphicon-stop"></i></button>
                                <audio controls style="width: 84%;" class="pull-left" id="audio"></audio>
                            </div>
                            <a id="download">&nbsp</a>
                            <div class="form-group">
                                <label for="Tile">Title</label>
                                <input type="text" class="form-control" name = "onsite_title" id="onsite_title" placeholder="Enter title">
                            </div>
                            <div>
                                <label for="Key word">Keyword</label>
                                <input type="text" class="form-control" name = "onsite_keyword" id="onsite_keyword" placeholder="Enter keyword">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <label id="waitlabel" class="pull-left"></label>
                            <button type="button" onclick="uploadRecording()" id="upload" title="Upload Recording" class="btn btn-info" disabled="disabled"><span class="glyphicon glyphicon-upload"></span> Upload Pitch</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <button type="button" class="btn  btn-info"  style ="vertical-align: middle; margin: 10px;" data-toggle="modal" data-target="#uploadPitch"> <i class="glyphicon glyphicon-upload"></i> Upload a pitch </button> 


            <!-- Modal -->
            <div class="modal fade" id="uploadPitch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Upload your pitch</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="uploader" method="post" action="upload_audio.php" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <input name="MAX_FILE_SIZE" value="10240000" type="hidden">
                                    <input name="pitch" accept="audio/*" type="file" id="files" value = "Upload"/>
                                </div>
                                <div class="form-group">
                                    <label for="Tile">Title</label>
                                    <input type="text" class="form-control" name = "title" id="title" placeholder="Enter title">
                                </div>
                                <div>
                                    <label for="Keyword">Keyword</label>
                                    <input type="text" class="form-control" name = "keyword0" id="title" placeholder="Enter keyword">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <label id="theclick" class="pull-left"></label>
                            <button type="submit" class="btn btn-info" onclick="improveAudio('<?php echo $auphonicName ?>');return false" style="float: right"><span class="glyphicon glyphicon-upload"></span> Upload Pitch</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div style="background-color: white; padding: 10px; margin: 10px;" class="col-md-offset-1">
                <?php
                //Session_Start();
                $userid = $_SESSION['userid'];
                $con = mysqli_connect("50.62.209.83:3306", "general", "1234q") or die ("Could not connect ".mysql_error());
                mysqli_select_db($con, "pitchhub") or die ("could not find database: ".mysql_error());  
                $result = mysqli_query($con, "SELECT title, url,pitchid, daterecorded 
				FROM pitches WHERE userid = '$userid' ORDER BY daterecorded DESC") or die("nope: ".mysql_error());
                $none = true;
                while($arrRecord = mysqli_fetch_assoc($result)){
                    $none = false;
                    $title = $arrRecord['title'];
                    $url = $arrRecord['url'];
                    $date = $arrRecord['daterecorded'];
                ?>
                <div style="border:1px solid grey; padding: 1%; margin: 10px">
                    <div class="row" style="margin: 1%;">
                        <div class="pull-left">
                            <strong><?php echo clean_output($title); ?></strong>
                        </div>
                        <div class="pull-right">
                            <span title="<?php echo 'Uploaded on '.date('F d, Y \a\t g:i:s A', strtotime($date));?>"><?php echo date("F d", strtotime($date)); ?></span>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 1%; margin-right: 1%;">
                        <audio controls class="pull-left" style="width: 93.5%;">
                            <source src="<?php echo $url ?>" type="audio/wav">
                        </audio>
                        <form method="post" action="removepitch.php" onsubmit="return confirm('Are you sure you want to delete this pitch?')">
                            <button type='submit' value="<?php echo $arrRecord['pitchid'];?>" title="Delete Pitch"
                                name='pitchid' class='btn btn-danger btn-sm pull-left' style="width: 5.5%; margin-left: 1%;"><span class="glyphicon glyphicon-trash"></span></button>
                        </form>   
                    </div>
					<?php
					//dispay keyword
					$connection = mysql_connect("50.62.209.83:3306", "general", "1234q") or die ("Could not connect ".mysql_error());
					mysql_select_db("pitchhub") or die ("could not find database: ".mysql_error());  
					$pitchid = $arrRecord['pitchid'];
					$result2 = mysql_query("SELECT * FROM keyword_pitches 
					WHERE pitchid = '$pitchid'") or die("Error: ".mysql_error());
					while($rows = mysql_fetch_assoc($result2)){
					?>
                    <div class="row" style="margin-left: 1%; margin-right: 1%; margin-top: 1%;">
                        <?php echo "Keywords: <button class='btn btn-xs ' disabled='disabled' style='opacity: 1.0;'>" . clean_output($rows['keyword'])."</button>"; ?>
                    </div>
					<?php
					}
					?>
					
                </div>
                <?php	
                }
                mysqli_close($con);
                if ($none){
                    echo'
                        <p><h4>You currently have no audio recordings on your profile.  Click "Record a Pitch" or "Upload Pitch" to get started! </h4></p>
                        ';
                }
                ?>
            </div>
        </div>
        <br />
        <br />
    </div>
</div>

<script language="javascript" type="text/javascript">
function q() {
    $('#logintab a:first').tab('show')
}
</script>
<script language="javascript" type="text/javascript">
function improveAudio(timestamp)
{
    document.getElementById("theclick").innerHTML = "Please Wait";
    createProduction(timestamp);
}
function clearStuff()
{
    document.getElementById("improveChoice").reset();
    document.getElementById("progress").innerHTML = "";
}

</script>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/filter.js"></script>
<script src="js/recorderHandler.js"></script>
<script type="text/javascript" src="js/recorder.js"> </script>

</body>
</html>
