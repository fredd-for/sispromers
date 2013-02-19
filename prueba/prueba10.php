<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=ISO-8859-1">
            <title>Mapa de Google</title>
            <script src="http://maps.google.com/maps?file=api&v=2&key=#37cd0b69485f9d44b7f61ef6d53b614278df3c1b#" type="text/javascript"></script>
            <script type="text/javascript">
                //<![CDATA[

                function load() {
                    if (GBrowserIsCompatible()) {
                        var map = new GMap2(document.getElementById("map"));   
                        map.setCenter(new GLatLng(-17.392579,-64.35791), 5);   
                        map.addControl(new GLargeMapControl());
                        map.setMapType(G_NORMAL_MAP);
      
                        var point = new GPoint (-64.35791,-17.392579);
                        var marker = new GMarker(point);
                        map.addOverlay(marker);
      
                        GEvent.addListener(map, "click", function (overlay,point){
                            if (point){
                                marker.setPoint(point);
                                document.posicion.x.value=point.x
                                document.posicion.y.value=point.y
                            }
                        });
                    }
                }

                window.onload=load
                //]]>
            </script>

    </head>

    <body>
        <div id="map" style="width: 765px; height: 278px"></div>
        <div id="formulario" style="margin: 10px">
            <form action="#" id="posicion" name="posicion">
                X: <input type="text" name="x" value="" />
                <br />
                Y: <input type="text" name="y" value="" />
            </form>
        </div>
        <br />
        <br />
        Por <a href="http://www.guiarte.com">guiarte.com</a>
    </body>
</html>