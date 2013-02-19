<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
    <head>
        <META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=ISO-8859-1">
            <title>Mapa de Google</title>
            <script src="http://maps.google.com/maps?file=api&v=2&key=#37cd0b69485f9d44b7f61ef6d53b614278df3c1b#" type="text/javascript"></script>
            <script type="text/javascript">
                function clicMarca(marca) {
                    alert(marca);
                    if (GBrowserIsCompatible() && cargado) {
                        GEvent.trigger(marca, "click");
                    }
                }
                
                var marca_n = new Array();
                var x=0;
                var cargado=false;

                function load() {
                       if (GBrowserIsCompatible()) {
                        var map = new GMap2(document.getElementById("map"));
                        map.addControl(new GLargeMapControl());
                        map.addControl(new GMapTypeControl());
                        map.setCenter(new GLatLng(40.41689826118782,-3.7034815549850464), 5);    
      
                        function CrearMarca(punto, html){
                            var miMarca = new GMarker(punto);
                            map.addOverlay(miMarca);
                            GEvent.addListener(miMarca, "click", function (){
                                miMarca.openInfoWindowHtml(html);
                            });
                            return miMarca;
                        }
                        //estilo para las ventanas de info de las marcas
                        var estilo_bocadillo = "font-size: 10pt; font-family: verdana; lineheight: 120%;";
                        //creo marca 1
                        var point;
                        point=new GLatLng(40.413496049701955,-3.6968994140625);
                        var htmlBocadillo = "<div><b>Madrid:</b><br><img height='112' width='170' border='0' src='http://www.guiarte.com/archivoimg/miniaturas-usuarios/1893.jpg'/></div>"
                        marca_n[x] = CrearMarca(point, htmlBocadillo);
                        x++;
                        //creo marca 2
                        point=new GLatLng(39.5633531658293,-0.2801513671875);
                        var htmlBocadillo = "<div style='" + estilo_bocadillo + "'><b>Pobla de Farnals:</b><br><img height='97' width='170' border='0' alt='' src='http://www.guiarte.com/archivoimg/miniaturas-usuarios/1662.jpg'/></div>"
                        marca_n[x] = CrearMarca(point, htmlBocadillo);
                        x++;
                        //creo marca 3
                        point=new GLatLng(42.45690084412248,-6.053466796875);
                        var htmlBocadillo = "<div style='" + estilo_bocadillo + "'><b>Astorga:</b><br><img height='128' width='170' border='0' alt='' src='http://www.guiarte.com/archivoimg/miniaturas-usuarios/1522.jpg'/></div>"
                        marca_n[x] = CrearMarca(point, htmlBocadillo);
                        x++;
                        //creo marca 4
                        point=new GLatLng(42.33012354634199,-3.6859130859375);
                        var htmlBocadillo = "<div style='" + estilo_bocadillo + "'><b>Burgos:</b><br><img height='150' width='113' border='0' alt='' src='http://www.guiarte.com/archivoimg/miniaturas-usuarios/35.jpg'/></div>"
                        marca_n[x] = CrearMarca(point, htmlBocadillo);
                        x++;
      
                        cargado=true;
                    }
                }
                window.onload=load
                //]]>
            </script>
    </head>
    <body>

<?php $x=0; ?>
        <div id="map" style="height: 550px; width:700px"></div>
        <div id="enlaces">
            <ul>
                <li><a href="javascript: clicMarca(marca_n[<?php echo $x ?>])">Madrid</a></li>
                <?php $x++; ?>
                <li><a href="javascript: clicMarca(marca_n[<?php echo $x ?>])">La Pobla de Farnals</a></li>
                <?php $x++; ?>
                <li><a href="javascript: clicMarca(marca_n[<?php echo $x ?>])">Astorga</a></li>
                <?php $x++; ?>
                <li><a href="javascript: clicMarca(marca_n[<?php echo $x ?>])">Burgos</a></li>
            </ul>
        </div>
    </body>
</html>