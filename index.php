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
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(42.280119, -83.74379),
          zoom: 12,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
      }
      
      function get_cities()
      {
      /*
        var xmlhttp;
        
          if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange=function()
          {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
              var jsondata=eval("("+xmlhttp.responseText+")");
              var html_code = '<ul id="list">';
              var rssentries=jsondata.locs;
              for (var i=0; i<rssentries.length; i++)
              {
                 html_code += '<li>'+rssentries[i].uid+'</li>';
              }
              html_code += '</ul>'
              document.getElementById("list").innerHTML = html_code;
            }
          }
          xmlhttp.open("GET","/from_douban.php");
          xmlhttp.send();
*/

        $.ajax({
          type: "GET",
          url: "/from_douban.php",
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
    </script>
    
</body>
</html>