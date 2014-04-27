<!DOCTYPE html>
<html>
<head>
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
		
        a = $('#auto1').autocomplete(
        {
            source: "./autocomplete.php",
            minLength:4
			
        });
		 b = $('#auto2').autocomplete(
        {
            source: "./autocomplete.php",
            minLength:4
			
        });
		 c = $('#auto3').autocomplete(
        {
            source: "./autocomplete.php",
            minLength:4
			
        });
		 c = $('#auto4').autocomplete(
        {
            source: "./autocomplete.php",
            minLength:4
			
        });
		c = $('#auto5').autocomplete(
        {
            source: "./autocomplete.php",
            minLength:4
			
        });
		}
</script>


 <script type="text/javascript"><!--
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
 //--></script>  
 
 
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
<div class="container"> 
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
            <div class="btn-group btn-group-lg" style = "margin: auto" >
                <button type="button" class="btn btn-default" ONCLICK="window.location.href='js_step1.php'" disabled>  Step 1  </button>
                <button type="button" class="btn btn-primary btn-lg active">Step 2</button>
                <button type="button" class="btn btn-default"ONCLICK="window.location.href='js_step3.php'">Step 3</button>
            </div>
        </div>
        </br>
        <!--- PROGRESS BAR -->
        <div class="progress progress-striped active">
            <div class="progress-bar"  role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width: 66%">
                <span class="sr-only">66% Complete</span>
            </div>
        </div>
        <!-- JOB SEEKER REGISTRATION FORM -->

        <div class="form-group">

            <div class="col-md-15">
                <form method = "post" action = "storestep2.php" enctype="multipart/form-data">
                    <label for="upload image">Upload your profile photo</label>

                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <img class="fileupload-preview thumbnail" id="blah" src="img/default.gif" style="width: 150px; height: 150px;">
                        <input name="MAX_FILE_SIZE" value="102400" type="hidden">
                        <input  class="btn btn-primary btn-sm" id="imgInp"  name="photo" accept="image/jpeg" type="file" value = "Upload" />

                    </div>


                    <!-- CONTACT INFORMATION -->


                    <div class="form-group">
                        <label for="phone number">Contact Information</label>
                        <input type="phone number" class="form-control" id="mobile phone" name = "mobilenumber" onchange="checkPhone(this)"  placeholder="Mobile phone (###) ###-####"style="width: 220px;">
                    </div>





                    <div class="form-group">
                        <input type="phone number" class="form-control" id="home phone"  name = "homenumber" onchange="checkPhone(this)" placeholder="Home phone (###) ###-####"style="width: 220px;">
                    </div>




                    <!-- JAVASCRIPT EDUCATION -->
                    <script src="js/addInput.js" language="Javascript" type="text/javascript"></script>

                    <label for="phone number">Education</label>

                    <div id="dynamicInput" action='' method='post' style= "" >

                        <input type="text" onclick = "autocompletefunction()" class="form-control" name = "school1"  id='auto1' style="float: left; width: 300px; margin-right: 5px;" placeholder="School">
                        <input type="text" class="form-control" name = "major1"  style="float: left; width: 220px; margin-right: 5px;" placeholder="Major">
                        <input type="text" class="form-control" name = "degree1"  style="float: left; width: 100px; margin-right: 5px;" placeholder="Degree">
                        <input type="text" class="form-control" name = "year1" style="float: left; width: 100px; margin-right: 5px;" placeholder="Year">


                    </div>
                    <br>
                    <br>
                    <button type="button" class="btn btn-primary btn-sm " id="addButton" onClick="addInput('dynamicInput');autocompletefunction()">
                        Add more School</button>
                    <br>
                    <br>

                    <!-- PERSONAL SOCIAL PAGE -->


                    <div class="form-group" id="focusedInput" >
                        <label for="phone number">Personal Social Pages</label>
                        <input type="LinkedIn" class="form-control" name = "linkedin"id="LinkedIn" placeholder="LinkedIn" style="width: 400px;">
                    </div>

                    <div class="form-group" id="focusedInput">
                        <input type="Facebook" class="form-control" name = "facebook" id="facebook" placeholder="Facebook" style="width: 400px;">
                    </div>

                    <div class="form-group" style="width: 400px;">
                        <input type="Monster" class="form-control" name = "monster" id="monster" placeholder="Monster" style="width: 400px;">
                    </div>

                    <div class="form-group" id="focusedInput">
                        <input type="Other sites" class="form-control" name = "other" id="other" placeholder="Other" style="width: 400px;">
                    </div>
                    <button type="submit" class="btn btn-default" style="float: right">Save & Next &rarr;</button>
                    </form>
            </div>
        </div>

    </div>
<script type="text/javascript">
<!--
function myFunction(){
    if (document.forms['formName'].elements['name'].value == "")
    { 
        document.forms['formName'].elements['name'] =  "text"
    }
}
-->
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
</div>
</body>
</html>
