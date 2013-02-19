<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=ISO-8859-1">
<title>Ejemplo de Google Maps API</title>
<script src="http://maps.google.com/maps?file=api&v=2&key=#37cd0b69485f9d44b7f61ef6d53b614278df3c1b#" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[
function load() {
   if (GBrowserIsCompatible()) {
      var map = new GMap2(document.getElementById("map"));   
      map.setCenter(new GLatLng(-17.392579,-64.35791), 5);   
      map.addControl(new GMapTypeControl());
      map.setMapType(G_SATELLITE_MAP);
   }
}
//]]>
</script>
</head>
<body onload="load()" onunload="GUnload()">
<div id="map" style="width: 615px; height: 400px"></div>
</body>
</html> 