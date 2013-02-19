<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=ISO-8859-1">
<title>Mapa de Google</title>
<script src="http://maps.google.com/maps?file=api&v=2&key=#37cd0b69485f9d44b7f61ef6d53b614278df3c1b#"
type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[

function load() {
   if (GBrowserIsCompatible()) {
      var map = new GMap2(document.getElementById("map"));   
      map.setCenter(new GLatLng(-17.392579,-64.35791), 5);   
      map.addControl(new GLargeMapControl());
      map.setMapType(G_NORMAL_MAP);
      
      var point = new GPoint (-68.115234375,-16.53089842368168);
      var marker = new GMarker(point);
      map.addOverlay(marker);
      
      GEvent.addListener(map, "click", function (overlay,point){
         if (point){
            marker.setPoint(point);
         }
      });
   }
}

window.onload=load
//]]>
</script>

</head>

<body>
   <div id="map" style="width: 765px; height: 388px"></div>
   
</body>
</html> 