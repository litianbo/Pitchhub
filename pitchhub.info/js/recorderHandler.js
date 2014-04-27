window.URL = window.URL || window.webkitURL;
window.AudioContext = window.AudioContext || window.webkitAudioContext;
navigator.getUserMedia  = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

var context = new AudioContext;
var mediaStream;
var interval;

var onFail = function(e) {
    console.log('Rejected!', e);
};

var onSuccess = function(s) {
    document.getElementById("download").innerHTML = '&nbsp';
    var newAudio = document.createElement('audio');
    newAudio.id = 'audio';
    newAudio.className = 'pull-left';
    newAudio.setAttribute('controls', '');
    newAudio.setAttribute('style', 'width: 84%;');

    //delete old audio node
    audio.parentNode.removeChild(audio);
    document.getElementById('stop').parentNode.insertBefore(newAudio, document.getElementById('stop').nextSibling);

    
    audio = document.querySelector('audio');
    var mediaStreamSource = context.createMediaStreamSource(s);
    recorder = new Recorder(mediaStreamSource);
    recorder.record();

    document.getElementById("start").setAttribute("disabled", "disabled");
    document.getElementById("upload").setAttribute("disabled", "disabled");
    document.getElementById("stop").removeAttribute("disabled");
    document.getElementById("waitlabel").style.color = "red";
    document.getElementById("waitlabel").innerHTML = "Recording now...";
    console.log('succeeded, you can start recording');
    /*
    $(function () {
        interval = setInterval(function () {
            $('#waitlabel').fadeIn(750).delay(500).fadeOut(750);
        }, 2000);
    });
    */

    mediaStream = s;
    // audio loopback
    // mediaStreamSource.connect(context.destination);
}


var recorder;
var audio = document.querySelector('audio');

function startRecording() {

    if (navigator.getUserMedia) {
        navigator.getUserMedia({audio: true}, onSuccess, onFail);
    } else {
        console.log('navigator.getUserMedia not present');
    }
}

function stopRecording() {
    document.getElementById("start").removeAttribute("disabled");
    document.getElementById("upload").removeAttribute("disabled");
    document.getElementById("stop").setAttribute("disabled", "disabled");
    //clearInterval(interval);
    document.getElementById("waitlabel").innerHTML = 'Recording stopped';
    document.getElementById("waitlabel").style.color = 'black';
    document.getElementById("waitlabel").style.display = 'block';
    recorder.stop();
    recorder.exportWAV(function(s) {
        audio.src = window.URL.createObjectURL(s);

        var url = URL.createObjectURL(s);
        var hf = document.getElementById("download");
        hf.href = url;
        hf.download = new Date().toISOString() + '.wav';
        hf.innerHTML = 'Click Here To Download Recording';
        
        var elem = document.getElementById("download");
        elem.parentNode.insertBefore(hf, elem.nextSibling);
        //document.body.appendChild (hf);
    });
    mediaStream.stop();
}
function uploadRecording(elem){
    //first check to see that fields aren't empty
    var titleField = document.getElementById("onsite_title");
    var keywordField = document.getElementById("onsite_keyword");
    var elem = document.getElementById("upload");

    //elem.parentNode.insertBefore(hf, elem.nextSibling);

    if (titleField.value == '' || keywordField.value == ''){
        alert("Your recording must have a title and at least one keyword before you can upload an audio file.");
        return;
    }

    document.getElementById("start").setAttribute("disabled", "disabled");
    document.getElementById("upload").setAttribute("disabled", "disabled");
    document.getElementById("stop").setAttribute("disabled", "disabled");
    document.getElementById("waitlabel").innerHTML = "Audio Uploading...";
    recorder.exportWAV(function(s) {
        audio.src = window.URL.createObjectURL(s);
        var reader = new FileReader();
        // this function is triggered once a call to readAsDataURL returns
        reader.onload = function(event){
            var fd = new FormData();
            fd.append('fname', 'test.wav');
            fd.append('data', event.target.result);
            fd.append('title', titleField.value);
            fd.append('keyword', keywordField.value);
            $.ajax({
                type: 'POST',
                url: 'onsite_upload_audio.php',
                data: fd,
                processData: false,
                contentType: false
            }).done(function(data) {
                // print the output from the upload.php script
                console.log(data);
                document.getElementById("waitlabel").innerHTML = "Finished uploading!";
                location.reload();
            });
        };      
        // trigger the read from the reader...
        reader.readAsDataURL(s);
    });
}

