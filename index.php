<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta name="description" content="A google map for douban" />
    <meta name="keywords" content="HTML,CSS,XML,JavaScript" />
    <meta name="author" content="Aaven & Roy" />
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

    <title>Douban Map</title>
    <link rel="shortcut icon" href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/images/favicon.ico'; ?>" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/styles.css'; ?>" />
    
    <!--jQuery-->
    <script src="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/js/jquery-1.8.1.js'; ?>" type="text/javascript"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
    
</head>

<body onload="initialize()">
    <div class="page">
        <div class="header">
            <div class="header-title">Douban Map
            </div>

        </div><!-- #header -->


        <div class="main">
            <div class="side-container">
                <div>City List</div>
                <br/>
                <button onclick="get_cities()">Get Cities</button>
                <br/>
                <button onclick="get_events()">Get Events</button>
                <br/>
                <ul id="list">
                    <li>Coffee</li>
                    <li>Milk</li>
                </ul>
            </div>
            
            <div class="map-container" id="map_canvas"></div>

        </div><!-- #main -->

        <footer>
        </footer><!-- footer -->
    </div><!-- #page -->
    
    <script type="text/javascript">
		var map;
      	function initialize() {
        	var styleArray = [
				{
					featureType: "all",
					stylers: [
						{ saturation: -70 }
					]
				},{
					featureType: "road.highway",
					elementType: "geometry.fill",
					stylers: [
						{ hue: "#3FA156" },
						{ saturation: 20 },
					]
				},{
					featureType: "poi",
					elementType: "labels.icon",
					stylers: [
						{ visibility: "off" }
					]
				}
			];
			var mapOptions = {
				center: new google.maps.LatLng(42.280826,-83.743038),
				zoom: 13,
        		mapTypeId: google.maps.MapTypeId.ROADMAP,
			};
        	map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
			map.setOptions({styles : styleArray});
		}
      
      function get_cities()
      {
        $.ajax({
          type: "GET",
          url: "from_douban.php",
          success: function(result) {
              var html_code = '<ul id="list">';
              var rssentries=result.locs;
              for (var i=0; i<rssentries.length; i++)
              {
                 html_code += '<li>'+rssentries[i].uid+'</li>';
              }
              html_code += '</ul>'
              document.getElementById("list").innerHTML = html_code;
          },
          dataType: "json"
        });
      }
		
	var positions = [];
	function get_events()
	{
        $.ajax({
			type: "GET",
			url: "query_events.php",
			success: function(results) {
				var events = results.events;
				for (var i = 0; i < events.length; i++) {
	            	var array = events[i].geo.split(" ");
					var latlng = new google.maps.LatLng(array[0],array[1],true);
					positions.push(latlng);
					// setTimeout(function() {
						marker = new google.maps.Marker({
							map:map,
							animation:google.maps.Animation.DROP,
							position:positions[i],
							draggable:true
						});
						map.setCenter(positions[i]);
						// alert(positions[i]);
					// }, i * 100);
				}
			},
			dataType: "json"
		});
	}
    </script>
    
</body>
</html>