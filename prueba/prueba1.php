<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=ISO-8859-1">
<title>Ejemplo de Google Maps API</title>
<script src="http://maps.google.com/maps?file=api&v=2&key=#37cd0b69485f9d44b7f61ef6d53b614278df3c1b#" type="text/javascript"></script>
<script type="text/javascript">
   //<![CDATA[
   
   //función para cargar un mapa de Google.
   //Esta función se llama cuando la página se ha terminado de cargar. Evento onload
   function load() {
      //comprobamos si el navegador es compatible con los mapas de google
      if (GBrowserIsCompatible()) {
         //instanciamos un mapa con GMap, pasándole una referencia a la capa o <div> donde queremos mostrar el mapa
         var map = new GMap2(document.getElementById("map"));   
         //centramos el mapa en una latitud y longitud deseadas
         map.setCenter(new GLatLng(-17.392579,-64.35791), 5);   
         //añadimos controles al mapa, para interacción con el usuario
         map.addControl(new GLargeMapControl());
         map.addControl(new GMapTypeControl());
         map.addControl(new GOverviewMapControl()); ;
      }
   }
   
   //]]>
   </script>
</head>
<body onload="load()" onunload="GUnload()">
<div id="map" style="width: 615px; height: 400px"></div>
</body>
</html>


//  37cd0b69485f9d44b7f61ef6d53b614278df3c1b

