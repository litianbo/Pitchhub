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
            <h3> Add recordings to your profile now! </h3>
            <!-- REGISTRATION STEP -->
            <div class="btn-group btn-group-lg" style = "margin: auto" >
                <button type="button" class="btn btn-default" ONCLICK="window.location.href='js_step1.php'" disabled>  Step 1  </button>
                <button type="button" class="btn btn-default" ONCLICK="window.location.href='js_step2.php'" > Step 2</button>
                <button type="button" class="btn btn-primary btn-lg active">Step 3</button>
            </div>
        </div>
        </br>

        <!--- PROGRESS BAR -->
        <div class="progress progress-striped active">
            <div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only">100% Complete</span>
            </div>
        </div>

        <button type="button" class="btn  btn-danger"  style ="vertical-align: middle" data-toggle="modal" data-target="#recordPitch"> <i class="glyphicon glyphicon-record"></i> Record a pitch </button> 
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

        <div>
            <p><h4><strong>OR </strong> Upload a pitch</h4></p>
        </div>

        <form role="form" method="post" action="upload_audio.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="Tile">Title</label>
                <input type="title" class="form-control" name = "title" id="title" placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="Key word">Key word</label>
                <input type="title" class="form-control" name = "keyword0" id="keyword" placeholder="Enter key word">
            </div>
            <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input name="MAX_FILE_SIZE" value="10240000" type="hidden">
                <input name="pitch" accept="audio/*" type="file" value = "Upload" />
            </div>
            <div class="checkbox">
            </div>
            <button type="submit" class="btn btn-default" style="float: right">Next &rarr;</button>
            <button type="button" class="btn btn-default" style="float: left" onclick="window.location='jobseeker_dashboard.php';">Skip For Now</button>
        </form>
    </div>
</div>
<script>
function checkFields()
{
    //first check to see if title and keyword fields are not empty
    var titleField = document.getElementById("title");
    var keywordField = document.getElementById("keyword");

    if (titleField.value == '' || keywordField.value == ''){
        alert("Your recording must have a title and at least one keyword before you can upload an audio file.");
        return false;
    }
    else
        return true;
}

</script>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/recorderHandler.js"></script>
<script type="text/javascript" src="js/recorder.js"> </script>
</body>
</html>

<!--
class="col-md-4 col-md-offset-4"

                    <br/>
