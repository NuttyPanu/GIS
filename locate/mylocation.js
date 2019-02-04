function myCurrentLocation() {
  var output = document.getElementById("output-pre-maps");
  var outputmaps = document.getElementById("maps-mapbox");
  var outputLatitude = document.getElementById("latitude");
  var outputLongitude = document.getElementById("longitude");
  var outputAltitude = document.getElementById("altitude");
  var outputAccuracy = document.getElementById("accuracy");
  var outputLocation = document.getElementById("locationname");


  if (!navigator.geolocation) {
    alert("<p>Sorry, Geolocation is not supported by your browser. Please use Chrome or Firefox for better experience</p>");
    return;
  }

  function success(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

   /*  outputLatitude.innerHTML = latitude.toFixed(5);
    outputLongitude.innerHTML = longitude.toFixed(5);
    outputAltitude.innerHTML = position.coords.altitude;
    outputAccuracy.innerHTML = position.coords.accuracy.toFixed(2); */

    alert(latitude +" "+longitude);

  };

  function error() {
    output.innerHTML = "Sorry, we are Unable to retrieve your location yet. <br />If you use smartphone, please Turn on your GPS and or wait 1-2 minutes.";
	alert('Sorry, we are Unable to retrieve your location yet. <br />If you use smartphone, please Turn on your GPS and or wait 1-2 minutes.');
    //var myip = document.getElementById("ipNumber").innerHTML;

  }


  var geo_options = {
    enableHighAccuracy: true,
    maximumAge: 30000,
    timeout: 27000
  };

 alert('<p>Please wait, we are detecting your location...</p>');

  navigator.geolocation.getCurrentPosition(success, error, geo_options);
  //var watchid = navigator.geolocation.watchPosition(success, error, geo_options);
  //alert("wpid : " + wpid);
}