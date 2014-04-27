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
                        <!-- <li><a href="#">Privacy</a></li> -->
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
                <div class="col-md-3">
                    <form action="" method="post">
                        <br/>
                        <label for="exampleInputPassword1"> <font size = "3">Settings:</font> </label>
                        

                        <ul class="nav nav-pills nav-stacked">
                          <li class="active"><a href="#job1" data-toggle="tab">Change Password</a></li>
						
                        </ul>
                    </form>

                    <br/>

                </div>

                <div class="col-md-9">

                    <div class="tab-content" style="background-color: #f8f8f8">
                        <!--Tab for job1 registration-->
						
                        <div class="tab-pane fade active in" style="background-color: white; vertical-align: middle; padding: 25px" align="center" id="job1">
                            <!-- Account Info -->
                            <!-- Profile Photo -->
                            <br />
							<form method="post" action="newpassword.php" enctype="multipart/form-data" onsubmit = "return checkPassword(this)">
							<input type="password" class="form-control" name = "oldpassword" 
							placeholder="Enter old password" required style = "width: 400px">
                            <br />
							<input type="password" class="form-control" name = "password" required placeholder="Enter new password" style = "width: 400px">
                            <br />
                            <input type="password" class="form-control" name = "password2" placeholder="Re-type new password" style = "width: 400px">
                            <br />
                            
                            <button type="submit" class="btn btn-default">Save</button>
                            <button type="reset" class="btn btn-default" value="Reset">Reset</button>
						</form>
						
                        </div>
						
						<!--Tab for job2 registration-->
						
						

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
    var passwordcheck = theForm.password.value;

    if (theForm.password.value != theForm.password2.value)
    {
        alert('Those passwords don\'t match!');
    } 
	else if (passwordcheck.length < 8){
		alert('Password has to be 8 or more letters');
	}
	

	
	else {
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
