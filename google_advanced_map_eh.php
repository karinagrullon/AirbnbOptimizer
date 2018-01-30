<!DOCTYPE html>
<html>
  <head>
  
  <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  
      <script>
	  var script = document.createElement('script');
	  script.src = 'geojson_entire_home.php';
	  document.getElementsByTagName('head')[0].appendChild(script);
	</script>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0" />
	
	<link rel="stylesheet" type="text/css" href="css/style1.css">
	
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
	  
	  </style>
	
	
  </head>
  <body id="map-container">
  
    <!-- Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">AirBbB Optimizer</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Maps
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="google_advanced_map_pr.php">Private rooms listing prices</a>
          <a class="dropdown-item" href="google_advanced_map_sr.php">Shared rooms listing prices</a>
          <a class="dropdown-item" href="google_advanced_map_eh.php">Entire home listing prices</a>
        </div>
      </li>
	  
	  <li class="nav-item">
        <a class="nav-link" href="price_estimation.php">Price Estimator</a>
      </li>
	  
      <li class="nav-item">
        <a class="nav-link" href="bookings_optimization.php">Bookings optimizer</a>
      </li>
    </ul>

  </div>
</nav>
 <!-- End menu -->
 
  
    <div id="map"></div>
    <script>
      var map;

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: new google.maps.LatLng(37.76,-122.44),
         mapTypeId: 'roadmap'
          //styles: mapStyle

        });

        map.data.setStyle(styleFeature);
		
		 var script = document.createElement('script');
		 
		 map.data.loadGeoJson('geojson_entire_home.php');
		 
		 
		  /* Legend */
	  
	 // Create the legend and display on the map
	 // Average price is calculared by (newPrice + newPrice) / 2. On geojson_shared_room.php file
	 
        var legend = document.createElement('div');
        legend.id = 'legend';
        var content = [];
        content.push('<h3>Entire home/apt average listing prices</h3>');  
        content.push('<p><div class="color strong_green"></div>$ 146</p>');
        content.push('<p><div class="color green"></div>$ 186</p>');
        content.push('<p><div class="color green_avocado"></div>$ 231</p>');
        content.push('<p><div class="color light_brown"></div>$ 273</p>');
        content.push('<p><div class="color light_red"></div>$ 315 </p>');
        legend.innerHTML = content.join('');
        legend.index = 1;
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
		 
	  }

        // Get the earthquake data (JSONP format)
        // This feed is a copy from the USGS feed, you can find the originals here:
        //   http://earthquake.usgs.gov/earthquakes/feed/v1.0/geojson.php
		
        // var script = document.createElement('script');
        // script.setAttribute(
            // 'src',
            // 'https://storage.googleapis.com/mapsdevsite/json/quakes.geo.json');
        // document.getElementsByTagName('head')[0].appendChild(script);
      // }

      // Defines the callback function referenced in the jsonp file.
      function eqfeed_callback(data) {
        map.data.addGeoJson(data);
      }

      function styleFeature(feature) {
        var low = [151, 83, 34];   // color of mag 1.0
        var high = [5, 69, 54];  // color of mag 6.0 and above
        var minMag = 1.0;
        var maxMag = 6.0;

        // fraction represents where the value sits between the min and max
        var fraction = (Math.min(feature.getProperty('mag'), maxMag) - minMag) /
            (maxMag - minMag);

        var color = interpolateHsl(low, high, fraction);

        return {
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
            strokeWeight: 0.5,
            strokeColor: '#fff',
            fillColor: color,
            fillOpacity: 4 / feature.getProperty('mag'),
            // while an exponent would technically be correct, quadratic looks nicer
            scale: Math.pow(feature.getProperty('mag'), 2)
          },
          zIndex: Math.floor(feature.getProperty('mag'))
        };
      }

      function interpolateHsl(lowHsl, highHsl, fraction) {
        var color = [];
        for (var i = 0; i < 3; i++) {
          // Calculate color based on the fraction.
          color[i] = (highHsl[i] - lowHsl[i]) * fraction + lowHsl[i];
        }

        return 'hsl(' + color[0] + ',' + color[1] + '%,' + color[2] + '%)';
      }

      var mapStyle = [{
        'featureType': 'all',
        'elementType': 'all',
        'stylers': [{'visibility': 'off'}]
      }, {
        'featureType': 'landscape',
        'elementType': 'geometry',
        'stylers': [{'visibility': 'on'}, {'color': '#fcfcfc'}]
      }, {
        'featureType': 'water',
        'elementType': 'labels',
        'stylers': [{'visibility': 'off'}]
      }, {
        'featureType': 'water',
        'elementType': 'geometry',
        'stylers': [{'visibility': 'on'}, {'hue': '#5f94ff'}, {'lightness': 60}]
      }];
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE&callback=initMap"">
    </script>
	
	
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	
  </body>
</html>
