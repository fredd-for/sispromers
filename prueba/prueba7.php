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
      map.setCenter(new GLatLng(33,0),3);   
      map.addControl(new GLargeMapControl());
      //map.addControl(new GMapTypeControl());
      //map.addControl(new GOverviewMapControl()); ;
      map.setMapType(G_NORMAL_MAP);
      //map.setMapType(G_SATELLITE_MAP);
      
      
      //DEFINO EL ICONO
      var iconoMarca = new GIcon(G_DEFAULT_ICON);
      iconoMarca.image = "../images/add.png";
      var tamanoIcono = new GSize(17,17);
      iconoMarca.iconSize = tamanoIcono;
//      iconoMarca.shadow = "../images/add.png";
//      var tamanoSombra = new GSize(22,18);
//      iconoMarca.shadowSize = tamanoSombra;
      iconoMarca.iconAnchor = new GPoint(11, 16);
      
      function createMarker(point,nombre,continente,pais) {
      
         //CREO LA MARCA EN EL PUNTO Y CON EL ICONO DESEADO
         var marker = new GMarker(point, iconoMarca);
         
         GEvent.addListener(marker, 'click', function() {
         marker.openInfoWindowHtml("<span style='font-size: 8pt; font-family: verdana'>Pais: " + nombre + "<br><a target='_parent' href='/destinos/" + continente + "/" + pais + ".html'>Ir al destino " + nombre + "</a></span>");
         });
         return marker;
      }
   
         var point = new GPoint (-4.0,40);
         var nombre = "España";
         var continente = "europa";
         var pais = "espana";
         var marker = createMarker (point,nombre,continente,pais);
         map.addOverlay(marker);
         
         
         var point = new GPoint (2,46);
         var nombre = "Francia";
         var continente = "europa";
         var pais = "francia";
         var marker = createMarker (point,nombre,continente,pais);
         map.addOverlay(marker);
         
         
         var point = new GPoint (-5.0,32);
         var nombre = "Marruecos";
         var continente = "africa";
         var pais = "marruecos";
         var marker = createMarker (point,nombre,continente,pais);
         map.addOverlay(marker);
         
         
//         var point = new GPoint (10.5,51.5);
//         var nombre = "Alemania";
//         var continente = "europa";
//         var pais = "alemania";
//         var marker = createMarker (point,nombre,continente,pais);
//         map.addOverlay(marker);
         
         
         }
}

window.onload=load
//]]>
</script>
<style type="text/css">
body{
margin:0px;
}
</style>
</head>

<body>

<div id="map" style="width: 765px; height: 388px"></div>
</body>
</html> 