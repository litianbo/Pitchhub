<!DOCTYPE html>
<html>
<head>
<title>PitchHub Profile</title>
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

<body style="background-color: #E5E4E2;">
<div class="container" style ="vertical-align: middle"> 
        <br/>
        <nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"> <img src="img/pitchhub_logo.png"  height="35" width="35" alt="..." class="img-rounded" style =" margin-right: 40px">PitchHub</a>
            </div>
        </nav>
        <div class="container" style="background-color: #f8f8f8; padding: 15px;">
            <div class="col-md-15">
                <h3> Setup Your Profile </h3>

                <!-- REGISTRATION STEP -->


                <div class="btn-group btn-group-lg" style="width: 50%; margin: 0 auto;" >
                    <button type="button" class="btn btn-primary btn-lg active">Step 1</button>
                    <button type="button" class="btn btn-default" ONCLICK="window.location.href='js_step2.php'" disabled>Step 2</button>
                    <button type="button" class="btn btn-default" ONCLICK="window.location.href='js_step3.php'" disabled>Step 3</button>


                </div>
            </div>
            </br>

            <!--- PROGRESS BAR -->
            <div class="progress progress-striped active">
                <div class="progress-bar"  role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%">
                    <span class="sr-only">33% Complete</span>
                </div>
            </div>

            <!-- JOB SEEKER REGISTRATION FORM -->
            <form method = "post" action = "register_jobseeker.php" onsubmit = "return checkEmail(this)">

                <div class="form-group" id="focusedInput" >
                    <input type="first name" class="form-control" id="first name" name = "firstname" value = <?php include 'clean_data.php'; echo clean_output($_POST['firstname']); ?> name = "lastname"  required placeholder="First name *" style="width: 400px;">
                </div>
                <div class="form-group" id="focusedInput">
                    <input type="last name" class="form-control" id="last name" name = "lastname" value = <?php echo clean_output($_POST['lastname']); ?> name = "firstname" required placeholder="Last name *"  style="width: 400px;">
                </div>

                <div class="form-group" id="focusedInput">
                    <input type="email" class="form-control" id="exampleInputEmail1" name = "email1" required placeholder="Enter email *" style="width: 400px;">
                </div>

                <div class="form-group" id="focusedInput">
                    <input type="email" class="form-control" id="email" name = "email2" required placeholder="Confirm email *" style="width: 400px;">
                </div>

                <div class="form-group" id="focusedInput">
                    <input type="password" class="form-control" id="inputPassword" name = "pw1" required placeholder="Password *" style="width: 400px;">
                </div>

                <div class="form-group" id="focusedInput">
                    <input type="password" class="form-control" id="inputPassword" name = "pw2" required placeholder=" Confirm Password *" style="width: 400px;">
                </div>

                <p style="color:gray;margin: auto;"> <font size ="2"> <i>* required </i></font> </p> 
                <button type="submit" class="btn btn-default" style="float: right">Next &rarr;</button>

            </form>
        </div>
</div>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script> 
function checkEmail(theForm) {
    var emailflag=false;
    var pwflag=false;
    var password = theForm.pw1.value;
    //var reValidName =/\w+@\w+\.[a-zA-Z]{2,4}/
    if (theForm.email1.value != theForm.email2.value)
        {
            alert('Those emails don\'t match!');
        } else {
            emailflag=true;
        }
    if (theForm.pw1.value != theForm.pw2.value)
    {
        alert('Those passwords don\'t match!');
    }
	
else if (password.length < 8){
		alert('Password has to be 8 or more letters');
	}
	


	else {
        pwflag=true;
    }
	
	

	
    /*
    if(!theForm.pw1.value.match(reValidName)){
        alert('Please enter a valid email');
    }
    else{
        emailflag=false;
    }
     */

    if (emailflag && pwflag)
        return true;
    else
        return false;
}
</script> 
</body>
</html>
