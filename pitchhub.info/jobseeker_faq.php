	
<?php
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




            

            <div class="row" style="background-color: #f8f8f8; vertical-align: middle; padding: 30px; font-size: 20px">
                <p><strong>FAQ</strong></p>
                <br/>

                <p><strong>The audio enhancing process froze?</strong></p>
                <p>Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail</p>
                <br/>
                
                <p><strong>How do I change the keyword and title?</strong></p>
                <p>Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail</p>
                <br/>

                <p><strong>How to see what my profile looks like to recruiter?</strong></p>
                <p>Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail</p>
                <br/>

                <p><strong>The uploaded audio was not on my profile?</strong></p>
                <p>Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail Tech detail</p>
                <br/>
                    
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

<script> 
function checkEmail(theForm) {
    var emailflag=false;
    var pwflag=false;
    //var reValidName =/\w+@\w+\.[a-zA-Z]{2,4}/
        if (theForm.email.value != theForm.email2.value)
        {
            alert('Those emails don\'t match!');
        } else {
            emailflag=true;
        }
   /* if (theForm.password.value != theForm.password2.value)
    {
        alert('Those passwords don\'t match!');
    } else {
        pwflag=true;
    }
    
    if(!theForm.pw1.value.match(reValidName)){
        alert('Please enter a valid email');
    }
    else{
        emailflag=false;
    }
     */

    if (emailflag)
        return true;
    else
        return false;
}
</script> 
 
 <script> 
 function checkPassword(theForm) {
    var emailflag=false;
    var pwflag=false;
    
    if (theForm.password.value != theForm.password2.value)
    {
        alert('Those passwords don\'t match!');
    } else {
        pwflag=true;
    }
    
  

    if (pwflag)
        return true;
    else
        return false;
}
</script> 
 
    </body>
</html>

<!--
class="col-md-4 col-md-offset-4"

                    <br/>
-->
