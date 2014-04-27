	
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
    if(!is_jobseeker())
        header("Location: recruiter_dashboard.php");
}
else
    header("location: index.html");

$userid = $_SESSION['userid'];
$jobseekerresult= mysql_query("SELECT * FROM jobseeker WHERE userid = '$userid'");
if (!$jobseekerresult) { // add this check.
die('Invalid query: ' . mysql_error());
}
$collegeresult= mysql_query("SELECT * FROM college WHERE userid = '$userid'");
if (!$collegeresult) { // add this check.
die('Invalid query: ' . mysql_error());
}
//counting the schools
$counter=0;

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
                        <a class="navbar-brand" href="jobseeker_dashboard.php"><img src="img/pitchhub_logo.png" height="35" width="35" alt="..." class="img-rounded" style ="margin-right: 40px" />PitchHub</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                </nav>
            </div>



            <div class="row">
                <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->

                <button type="button" class="btn btn-primary"  style ="vertical-align: middle" onclick="javascript:window.location.href = 'jobseeker_dashboard.php';"> <i class="glyphicon glyphicon-home"></i> Home </button>

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
                <div class="col-md-3">
                    <form action="" method="post">
                        <br/>
                        <label for="exampleInputPassword1"> <font size = "3">Settings:</font> </label>
                        

                        <ul class="nav nav-pills nav-stacked">
                          <li class="active"><a href="#job3" data-toggle="tab">Profile Photo</a></li>
                          <li><a href="#job4" data-toggle="tab">Contact Information</a></li>
                          <li><a href="#job5" data-toggle="tab">Education</a></li>
                          <li><a href="#job6" data-toggle="tab">Personal Social Pages</a></li>
                        </ul>
                    </form>

                    <br/>

                </div>

                <div class="col-md-9">

                    <div class="tab-content" style="background-color: #f8f8f8">
						
                        <!--Tab for job3 registration-->
						
                        <div class="tab-pane fade active in" style="background-color: white; vertical-align: middle; padding: 25px" align="center" id="job3">
                            <!-- Profile Photo -->
                            <br />
							<form method="post" action="newphoto.php" enctype="multipart/form-data">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <img class="fileupload-preview thumbnail"  id="blah" src="img/default.gif" style="width: 150px; height: 150px;">
                                <input name="MAX_FILE_SIZE" value="102400" type="hidden">
                                <input name="photo" accept="image/jpeg" id="imgInp" type="file" value = "Upload" />
                            </div>
                            <br />

                            <button type="submit" class="btn btn-default">Save</button>
                            <button type="reset" class="btn btn-default" value="Reset">Reset</button>
						</form>
                        </div>
						
                        <!--Tab for job4 registration-->
                        <div class="tab-pane fade in" style="background-color: white; vertical-align: middle; padding: 25px" align="center" id="job4">
                            <!-- Contact Info -->
                            <br />
							<form method="post" action="newphone.php" >
                            <input type="text" class="form-control" name = "mobile" onchange="checkPhone(this)" placeholder="Mobile phone" style = "width: 400px">
                            <br />

                            <input type="text" class="form-control" name = "home" onchange="checkPhone(this)" placeholder="Home phone" style = "width: 400px">
                            <br />

                            <button type="submit" class="btn btn-default">Save</button>
                            <button type="reset" class="btn btn-default" value="Reset">Reset</button>
						</form>
						
                        </div>

                        <!--Tab for job5 registration-->
                        <div class="tab-pane fade in" style="background-color: white; vertical-align: middle; padding: 25px" align="center" id="job5">
                            <!-- JAVASCRIPT EDUCATION -->
                            <br />
							
                            <label >Education</label>
							<br/>
							<label style="float: left; width: 300px; margin-right: 5px;" >School</label>
							<label style="float: left; width: 100px; margin-right: 5px;">Degree</label>
							<label style="float: left; width: 220px; margin-right: 5px;">Major</label>
							<label style="float: left; width: 100px; margin-right: 5px;">Year</label>
							<form method="post" action="neweducation.php" >
								
								<?php
								
								while($rows = mysql_fetch_array($collegeresult)){
								$counter++;
								$idcounter = 5 + $counter;?>
								<script language="Javascript" type="text/javascript"></script>
								
								<input type="text" ONCLICK = "autocompletefunction()"<?php echo " id = auto". $idcounter; ?>
								class="form-control" 
								style="float: left; width: 300px; margin-right: 5px;" 
								name = <?php echo "school" . $counter ?>  value = "<?php if (!empty($rows['college'])) echo clean_output($rows['college']) ;
								else{} ?>" >
								<input type="text" class="form-control" style="float: left; width: 100px; margin-right: 5px;"
								name = <?php echo "degree"  . $counter ?> value = "<?php if (!empty($rows['degree'])) echo clean_output($rows['degree']);
								else{}?>" >
								<input type="text"
								class="form-control" style="float: left; width: 220px; margin-right: 5px;" placeholder="Major"
								name = <?php echo "major"  . $counter ?>  value = "<?php if (!empty($rows['major'])) echo  clean_output($rows['major']);
								else{}?> " >
								<input type="text" class="form-control" style="float: left; width: 100px; margin-right: 5px;"
								name = <?php echo "year"  . $counter ?> value = "<?php if ($rows['graduationyear']!=0) echo $rows['graduationyear'];
								else{}?> ">
								<input type = "hidden" name = <?php echo "id" . $counter; ?> value = "<?php echo $rows['id'];?>" >
								<?php
								}
								//this while loop shouldn't be executed 
								//since everyone should have 5 schools stored at database
								while($counter!=5){
								$counter++;
								?>
								<input type="text" class="form-control" style="float: left; width: 300px; margin-right: 5px;" placeholder="School"
								name = <?php echo "school" . '$counter'?>>
								<input type="text" class="form-control" style="float: left; width: 100px; margin-right: 5px;" placeholder="Degree"
								name = <?php echo "degree"  . '$counter'?>>
								<input type="text" class="form-control" style="float: left; width: 220px; margin-right: 5px;" placeholder="Major"
								name = <?php echo "major"  . '$counter' ?> >
								<input type="text" class="form-control" style="float: left; width: 100px; margin-right: 5px;" placeholder="Year"
								name = <?php echo "year"  . '$counter' ?> >
								
								<?php
								}
								?>
                                
								
								
						<button type="submit" class="btn btn-default">Save</button>
                        <button type="reset" class="btn btn-default" value="Reset">Reset</button>
						</form>
						
                        </div>
							
                        <!--Tab for job6 registration-->
                        <div class="tab-pane fade in" style="background-color: white; vertical-align: middle; padding: 25px" align="center" id="job6">
                            <!-- Personal Social Pages -->
							<form method="post" action="newsocialpage.php" >
							<?php
							while($row = mysql_fetch_array($jobseekerresult)){?>
							 <br />
							<label >LinkedIn</label> 
                            <input type="text" name = "linkedin" placeholder = "LinkedIn" 
							style = "width: 400px" class="form-control" value = <?php 
							
							if (!empty($row['linkedin'])){echo clean_output($row['linkedin']);} else {}?> >
							
                            <br />
							<label >Facebook</label> 
                            <input type="text" name = "facebook" placeholder = "Facebook" 
							style = "width: 400px" class="form-control" value = <?php 
							if (!empty($row['facebook'])){echo clean_output($row['facebook']);} else {} ?>
							>
                            <br />

                            <label >Monster</label> 
                            <input type="text" name = "monster" style = "width: 400px" 
							class="form-control" placeholder = "Monster" value = <?php 
							if (!empty($row['monster'])){echo clean_output($row['monster']);} else {} ?> 
							><br /> 
							<label >Other</label> 
                            <input type="text" name = "other" style = "width: 400px" 
							placeholder = "Other" class="form-control" value = <?php 
							if (!empty($row['other'])){echo clean_output($row['other']);} else {} ?>
							>
                            <br />
							<?php
							}
							?>
                           

                            <button type="submit" class="btn btn-default">Save</button>
                            <button type="reset" class="btn btn-default" value="Reset">Reset</button>
						</form>
						
                        </div>

                    </div>

                </div>

                    
            </div>

        </div>
		 <script type="text/javascript">
 function checkPhone (obj) {
  str = obj.value.replace(/[^0-9]+?/g, '');
  switch (str.length) {
   case 0:
     alert('Please enter numbers only.');
     obj.select();
     return;
   case 7:
     str = str.substr(0,3)+"-"+str.substr(3,4);
     break;
   case 10:
     str = "("+str.substr(0,3)+") "+str.substr(3,3)+"-"+str.substr(6,4);
     break;
   default:
     alert('Please enter a 7 digit phone number (with area code, if applicable).');
     obj.select();
     return;
  }
  obj.value = str;
 }
 </script> 
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-1.9.1.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
		<style>
		.ui-autocomplete {
		max-height: 300px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		}
		/* IE 6 doesn't support max-height
		* we use height instead, but this forces the menu to always be this tall
		*/
		* html .ui-autocomplete {
		height: 100px;
		}
		</style>
		<script type="text/javascript">
		function autocompletefunction(){
		c = $('#auto6').autocomplete(
        {
            source: "./autocomplete.php",
            minLength:4
			
        });
		c = $('#auto7').autocomplete(
        {
            source: "./autocomplete.php",
            minLength:4
			
        });
		c = $('#auto8').autocomplete(
        {
            source: "./autocomplete.php",
            minLength:4
			
        });
		c = $('#auto9').autocomplete(
        {
            source: "./autocomplete.php",
            minLength:4
			
        });
		c = $('#auto10').autocomplete(
        {
            source: "./autocomplete.php",
            minLength:4
			
        });
		}
</script>
		<script type="text/javascript">
		function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL(this);
});
	</script>	

 
 
    </body>
</html>

<!--
class="col-md-4 col-md-offset-4"

                    <br/>
-->
