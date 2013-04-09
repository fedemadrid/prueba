      var map;

      function initialize() {
    	lat=document.getElementById("latitud").value;
        lng=document.getElementById("longitud").value;  
        
        if (lat == '') {
			lat=-34.918452;
			lng=-57.953911;
        }
    
        var mapOptions = {
          zoom: 4,
          center: new google.maps.LatLng(lat, lng),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map_canvas'),
            mapOptions);

        var latLng = new google.maps.LatLng(lat, lng);
        marker = new google.maps.Marker({
           position: latLng,
           draggable: true,
           map: map,
           icon: new google.maps.MarkerImage(
             "http://chart.googleapis.com/chart?chst=d_bubble_text_small&chld=bb|Mi%20Ubicacion|FF8080|000000",
             null, null, new google.maps.Point(0, 42)),
           shadow: new google.maps.MarkerImage(
             "http://chart.googleapis.com/chart?chst=d_bubble_text_small_shadow&chld=bb|Mi%20Ubicacion",
             null, null, new google.maps.Point(0, 45))
         });

      }
      
      function updateInputs() {
      	v = marker.getPosition();
      	latitud = v.lat();
      	longitud = v.lng();
      	document.getElementById("latitud").value = latitud;
      	document.getElementById("longitud").value = longitud;
      }

      google.maps.event.addDomListener(window, 'load', initialize);