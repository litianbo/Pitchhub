// Create the XHR object.
function createCORSRequest(method, url) {
  var xhr = new XMLHttpRequest();
  if ("withCredentials" in xhr) {
    // XHR for Chrome/Firefox/Opera/Safari.
    xhr.open(method, url, true);
  } else if (typeof XDomainRequest != "undefined") {
    // XDomainRequest for IE.
    xhr = new XDomainRequest();
    xhr.open(method, url);
  } else {
    // CORS not supported.
    xhr = null;
  }
  return xhr;
}

function createProduction(timestamp) {

//var time = Math.round(+new Date()/1000);
//var timestamp = <?php echo json_encode($date) ?>;

  // create CORS request to Auphonic Simple API
  var xhr = new createCORSRequest("POST", "https://auphonic.com/api/productions.json");

  //authentication
  xhr.setRequestHeader("Content-type", "application/json");
  xhr.setRequestHeader("Authorization", "Basic " + btoa("pitchtest:testing1"));
  
  xhr.onload = function(e) {
	  console.log("Production: created");
	  
	  // parse response of first request to get the production UUID
	  var response = JSON.parse(e.target.response);
	  var data = response.data;
	  var production_uuid = data.uuid;

	  var file = document.querySelector('#files').files[0];
	  
	  if (file) {
		console.log("File Upload: started");

		// second request to add audio file to the production
		// IMPORTANT: we must not set the Content Type to JSON here!
		var url = 'https://auphonic.com/api/production/{uuid}/upload.json'.replace('{uuid}', production_uuid);
		var xhr2 = new createCORSRequest("POST", url);
		xhr2.setRequestHeader("Authorization","Basic " + btoa("pitchtest:testing1"));

		// event listener to show upload progress
		xhr2.upload.addEventListener("progress", function(e) { console.log((e.loaded / e.total) * 100); }, false);

		// callback when upload finished
		xhr2.onload = function(e) {
		  console.log("File Upload: Done");
		  var url2 = 'https://auphonic.com/api/production/{uuid}/start.json'.replace('{uuid}', production_uuid);
		  var xhr3 = new createCORSRequest("POST", url2);
		  
		  xhr3.setRequestHeader("Authorization","Basic " + btoa("pitchtest:testing1"));
		  
		  xhr3.onload = function(e) {
			console.log("Production: start");
			var response2 = JSON.parse(e.target.response);
	        	var data2 = response2.data;
			var stuff = data.output_files.download_url;
			
			console.log(stuff);
			document.getElementById('uploader').submit();
		  }
		  
		  xhr3.send( JSON.stringify( { "action":"start" } ) );
		};

		// append file to our form and send second request
		var formData = new FormData();
		formData.append('input_file', file);
		xhr2.send(formData);
	  }
	};

	// send first request and set some production details in JSON
	xhr.send(JSON.stringify({"preset": "aBy3NFm5bS2Bvw8KEF2cpa","metadata":{"title": "stuff"},"output_basename": timestamp}));
}