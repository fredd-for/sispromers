<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "avance_productoinfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php
// Define page object
$avance_producto_list = new cavance_producto_list();
$Page = & $avance_producto_list;

// Page init processing
$avance_producto_list->Page_Init();

// Page main processing
$avance_producto_list->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript" src="jquery/ajaxfileupload.js"></script>
<script type="text/javascript">
    function confirmarDeleteArchivo()
    {
        var agree=confirm("Est\u00e1 seguro de eliminar el archivo.");
        if (agree)
            return true ;
        else
            return false ;

    }
</script>
<script type="text/javascript">
    var x;
    x=$(document);
    x.ready(inicializarEventos);
    function inicializarEventos()
    {
        var p=$("#reporteHitoVer");
        p.click(reporteHitoVer);
        var q=$("#reporteHitoOcultar");
        q.click(reporteHitoOcultar);

    }
    function reporteHitoVer(){
        //    $("#tabla_hito").show();
        $("#reporteHitoVer").hide();
        $("#reporteHitoOcultar").show();
        var v_idCronograma=$("#x_idCronograma").attr("value");
        var v_idConsultoria=$("#x_idConsultoria").attr("value");
        var pagina="avance_producto_reporte_hito.php?idCronograma="+v_idCronograma+"&idConsultoria="+v_idConsultoria;
        var carga=$("#reporte_hito_div");
        carga.load(pagina);
        carga.show();
        return false;
    }
    function reporteHitoOcultar(){
        $("#reporte_hito_div").hide();
        $("#reporteHitoVer").show();
        $("#reporteHitoOcultar").hide();
    }

    function deleteArchivoReporte(idMeta,idCronograma)
    {  var archivo=$("#sw_archivo"+idMeta).attr("value");
        //alert(archivo);
        var agree=confirm("Est\u00e1 seguro de eliminar el archivo.");
        if (agree)
        {$.getJSON("avance_producto_guardar.php",{x_idMeta:idMeta,x_idCronograma:idCronograma,sw:'archivoReporteDelete',x_archivo:archivo},llegadaDatos);}
        else {return false;}
    }

    function llegadaDatos(datos)
    {  alert(datos.respuesta)
        $("#archivo_reportado"+datos.idMeta).text("");
        $("#detalle"+datos.idMeta).attr("value","");
    }
    function func_revisar_cronograma(idCronogramaReporte){
        // alert(idCronogramaReporte);
        var v_idCronograma=$("#x_idCronograma").attr("value");
        var v_idConsultoria=$("#x_idConsultoria").attr("value");
        var pagina="avance_producto_revision_hito.php?idCronograma="+v_idCronograma+"&idConsultoria="+v_idConsultoria+"&idCronogramaReporte="+idCronogramaReporte;
        var carga=$("#revisar_hito_div");
        carga.load(pagina);
        carga.show("slow");
        return false;
    }
    function func_cerrar_revisar_hito(){
        $("#revisar_hito_div").hide();
    }
    function func_reporte_meta(idMeta){
        //    alert(idMeta);
        //    id="reporteConsultor_td<?php echo $contador ?>"

        var v_idCronograma=$("#x_idCronograma").attr("value");
        var v_idConsultoria=$("#x_idConsultoria").attr("value");
        var pagina="avance_producto_reporte_meta.php?idCronograma="+v_idCronograma+"&idConsultoria="+v_idConsultoria+"&idMeta="+idMeta;
        var carga=$("#reporteConsultor_td"+idMeta);
        carga.load(pagina);
        carga.show();
        return false;
    }
    function func_cerrar_reporte_meta(idMeta){
        $("#reporteConsultor_td"+idMeta).hide();
    }

    function func_revisar_reporte_meta(idMetaReporte,idMeta){
        // alert(idCronogramaReporte);
        //var v_idMeta=$("#x_idCronograma").attr("value");
        var v_idConsultoria=$("#x_idConsultoria").attr("value");
        //alert(v_idConsultoria);
        var pagina="avance_producto_revision_meta.php?idMetaReporte="+idMetaReporte+'&idConsultoria='+v_idConsultoria+'&idMeta='+idMeta;
        var carga=$("#revisionReporteMeta_td"+idMeta);
        carga.load(pagina);
        carga.show();
        return false;
    }

    function validar_formulario_reporte_hito()
    { 
        var v_sugerencia=$("#sugerencia_reporte_hito").attr("value");
        if(v_sugerencia.length<1){
            alert("Ingrese sugerencia para la unidad de coordinacion del informe del hito... ")
            $("#sugerencia_reporte_hito").focus();
            return (false);
        }

        var v_inesperado=$("#inesperado_reporte_hito").attr("value");
        if(v_inesperado.length<1){
            alert("Ingrese resultados inesperados del informe del hito... ")
            $("#inesperado_reporte_hito").focus();
            return (false);
        }

        var v_detalle=$("#detalle_reporte_hito").attr("value");
        if(v_detalle.length<1){
            alert("Ingrese descripcion del informe del hito... ")
            $("#detalle_reporte_hito").focus();
            return (false);
        }
        var agree=confirm("REPORTE DEL HITO. Esta seguro de realizar el reporte?");
        if (agree)
            return (true)
        else return(false)
    }

    function validar_formulario_revision_hito_observar()
    { var v_detalle=$("#observacion_revision_hito").attr("value");
        if(v_detalle.length<1){
            alert("Ingrese Observacion o Conformidad del reporte... ")
            $("#observacion_revision_hito").focus();
            return (false);
        }
        var agree=confirm("OBSERVACION. Esta seguro de realizar la observacion?");
        if (agree)
            return (true)
        else return(false)
    }

    function validar_formulario_revision_hito_aprobar()
    { var v_detalle=$("#observacion_revision_hito").attr("value");
        if(v_detalle.length<1){
            alert("Ingrese Observacion o Conformidad del reporte... ")
            $("#observacion_revision_hito").focus();
            return (false);
        }
        var agree=confirm("APROBAR. Esta seguro de aprobar el informe?");
        if (agree)
            return (true)
        else return(false)
    }

    function mostrarOcultarComentario(checked,idMeta,idMer){
        //alert(checked);
        if(checked==true)
            $("#comentario"+idMeta+idMer).show();
        else
            $("#comentario"+idMeta+idMer).hide();
    }

    function mostrarOcultarComentarioFile(file,idMeta,idMer){
        //alert(file);
        if(file!="")
            $("#comentario"+idMeta+idMer).show();
        else
            $("#comentario"+idMeta+idMer).hide();
    }

</script>
<script type="text/javascript">
    function func_reporte_meta_join(idMeta,idCronograma)
    {    var v_detalle=$("#detalle_reporte_meta"+idMeta).attr("value");

        $("#loading")
        .ajaxStart(function(){
            $(this).show();
        })
        .ajaxComplete(function(){
            $(this).hide();
        });

        $.ajaxFileUpload
        (
        {
            url:'avance_producto_guardar.php?x_idMeta='+idMeta+'&x_idCronograma='+idCronograma+'&x_detalle='+v_detalle+'&sw=guardar_reporte_meta',
            secureuri:false,
            fileElementId:'archivo_reporte_meta'+idMeta,
            dataType: 'json',
            success: function (data, status)
            {
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {alert(data.error);}
                    else{
                        alert(data.respuesta);
                        func_reporte_meta(idMeta);
                    }
                }
            },
            error: function (data, status, e)
            {
                alert(e);
            }
        }
    )

        return false;

    }
    function func_borrar_reporte_meta(idMetaReporte,archivo,idMeta)
    {   var agree=confirm("Est\u00e1 seguro de borrar el reporte?");
        if (agree)
        {$.getJSON("avance_producto_guardar.php",{x_idMetaReporte:idMetaReporte,x_idMeta:idMeta,x_archivo:archivo,sw:'borrar_reporte_meta'},respuestaBorrarReporteMeta);}
        else {return false;}
    }
    function respuestaBorrarReporteMeta(datos)
    {  alert(datos.respuesta);
        func_reporte_meta(datos.idMeta);
    }
</script>
<script type="text/javascript">
    function func_reportarHito(idCronograma)
    {    var v_detalle=$("#detalle_reporte_hito").attr("value");

        $("#loading")
        .ajaxStart(function(){
            $(this).show();
        })
        .ajaxComplete(function(){
            $(this).hide();
        });

        $.ajaxFileUpload
        (
        {
            url:'avance_producto_guardar.php?x_idCronograma='+idCronograma+'&x_detalle='+v_detalle+'&sw=guardar_reporte_hito',
            secureuri:false,
            fileElementId:'archivo_reporte_hito',
            dataType: 'json',
            success: function (data, status)
            {
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {alert(data.error);}
                    else{
                        alert(data.respuesta);
                        reporteHitoVer();
                    }
                }
            },
            error: function (data, status, e)
            {
                alert(e);
            }
        }
    )

        return false;

    }

</script>
<script type="text/javascript">
    function func_observar_reporte_meta(v_idMetaReporte,v_idRC,v_idMeta)
    {var v_observacion=$("#observacion_revision_meta"+v_idMetaReporte).attr("value");
        //alert('idMetaReporte='+v_idMetaReporte+'idRC='+v_idRC+'idMeta='+v_idMeta);
        //alert(v_observacion)
        $("#loading")
        .ajaxStart(function(){
            $(this).show();
        })
        .ajaxComplete(function(){
            $(this).hide();
        });

        $.ajaxFileUpload
        (
        {
            url:'avance_producto_guardar.php?x_idMeta='+v_idMeta+'&x_idMetaReporte='+v_idMetaReporte+'&x_idRC='+v_idRC+'&x_observacion='+v_observacion+'&sw=observar_reporte_meta',
            secureuri:false,
            fileElementId:'archivo_revision_meta'+v_idMetaReporte,
            dataType: 'json',
            success: function (data, status)
            {
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {alert(data.error);}
                    else{
                        alert(data.respuesta);
                        func_reporte_meta(v_idMeta);
                        func_cerrar_revisar_meta(v_idMeta);
                    }
                }
            },
            error: function (data, status, e)
            {
                alert(e);
            }
        }
    )
        return false;
    }
    function func_aprobar_reporte_meta(v_idMetaReporte,v_idRC,v_idMeta,v_idConsultoria)
    {var v_observacion=$("#observacion_revision_meta"+v_idMetaReporte).attr("value");
        //alert('idMetaReporte='+v_idMetaReporte+'idRC='+v_idRC+'idMeta='+v_idMeta);
        //alert(v_observacion)
        $("#loading")
        .ajaxStart(function(){
            $(this).show();
        })
        .ajaxComplete(function(){
            $(this).hide();
        });

        $.ajaxFileUpload
        (
        {
            url:'avance_producto_guardar.php?x_idMeta='+v_idMeta+'&x_idMetaReporte='+v_idMetaReporte+'&x_idRC='+v_idRC+'&x_observacion='+v_observacion+'&x_idConsultoria='+v_idConsultoria+'&sw=aprobar_reporte_meta',
            secureuri:false,
            fileElementId:'archivo_revision_meta'+v_idMetaReporte,
            dataType: 'json',
            success: function (data, status)
            {
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {alert(data.error);}
                    else{
                        alert(data.respuesta);
                        func_reporte_meta(v_idMeta);
                        func_cerrar_revisar_meta(v_idMeta);
                    }
                }
            },
            error: function (data, status, e)
            {
                alert(e);
            }
        }
    )
        return false;
    }
    function func_cerrar_revisar_meta(idMeta){
        $("#revisionReporteMeta_td"+idMeta).hide();
    }
</script>
<link rel="stylesheet" type="text/css" href="archivoAdjunto.css">
<?php
$v_idCronograma = $_GET['idCronograma'];
$v_idConsultoria = $_GET['idConsultoria'];
mysql_select_db($database_conexion, $conexion);
$query_consultoria = "SELECT a.idConsultoria, a.consultoria, a.fechaInicio, a.fechaFinal, b.paterno, b.materno,b.nombre FROM consultoria a, usuario b WHERE a.idConsultoria='" . (int) $v_idConsultoria . "' AND a.idUsuario=b.idUsuario";
$mostrar_consultoria = mysql_query($query_consultoria, $conexion) or die(mysql_error());
$row_consultoria = mysql_fetch_assoc($mostrar_consultoria);
?>
<p><span class="phpmaker">
        <?php if ($cronograma->Export == "") { ?>
            <a href="cronogramalist.php?idConsultoria=<?php echo $v_idConsultoria ?>">Volver al listado</a>&nbsp;
            <a href="avance_productoPDF.php?idConsultoria=<?php echo $v_idConsultoria ?>&idCronograma=<?php echo $v_idCronograma ?>">Informe PDF</a>&nbsp;
            <a href="avance_productoFile.php?idConsultoria=<?php echo $v_idConsultoria ?>&idCronograma=<?php echo $v_idCronograma ?>">Download File Hito</a>&nbsp;
        <?php } ?>
    </span></p>
<?php $avance_producto_list->ShowMessage() ?>
<fieldset>
    <legend>Proyecto: Promoviendo el Desarrollo Local y la Formacion de MERS</legend>
    <table>
        <tr>
            <td><div>Consultoria:</div></td><td colspan="7"><?php echo $row_consultoria['consultoria'] ?></td>
        </tr>
        <tr>
            <td><div>Responsable:</div></td><td><?php echo $row_consultoria['paterno'] . " " . $row_consultoria['materno'] . ", " . $row_consultoria['nombre'] ?></td>
            <td><div>Desde:</div></td><td><?php echo date("d-m-Y", strtotime($row_consultoria['fechaInicio'])) ?></td>
            <td><div>Hasta:</div></td><td><?php echo date("d-m-Y", strtotime($row_consultoria['fechaFinal'])) ?></td>
        </tr>

    </table>
</fieldset>
<?php
mysql_select_db($database_conexion, $conexion);
$query_regional = "SELECT a.idUC, a.idRegional, b.regional, count(a.idRegional) as numRegional FROM ubicacion_consultoria a, regional b, municipio c, mer d WHERE a.idConsultoria='" . $v_idConsultoria . "' AND a.idRegional=b.idRegional AND a.idMunicipio=c.idMunicipio AND a.idMer=d.idMer GROUP BY a.idRegional ORDER BY b.regional asc, c.municipio asc, d.mer asc ";
$mostrar_regional = mysql_query($query_regional, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_municipio = "SELECT a.idUC, a.idMunicipio, c.municipio, count(a.idMunicipio) as numMunicipio FROM ubicacion_consultoria a, regional b, municipio c, mer d WHERE a.idConsultoria='" . $v_idConsultoria . "' AND a.idRegional=b.idRegional AND a.idMunicipio=c.idMunicipio AND a.idMer=d.idMer GROUP BY a.idMunicipio ORDER BY b.regional asc, c.municipio asc, d.mer asc ";
$mostrar_municipio = mysql_query($query_municipio, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_totalmers = "SELECT count(idMer) as totalmers FROM ubicacion_consultoria WHERE idConsultoria='" . $v_idConsultoria . "'";
$mostrar_totalmers = mysql_query($query_totalmers, $conexion) or die(mysql_error());
$row_totalmers = mysql_fetch_assoc($mostrar_totalmers);

mysql_select_db($database_conexion, $conexion);
$query_cronograma = "SELECT * FROM cronograma WHERE idCronograma='" . $v_idCronograma . "'";
$mostrar_cronograma = mysql_query($query_cronograma, $conexion) or die(mysql_error());
$row_cronograma = mysql_fetch_assoc($mostrar_cronograma);
$total_cronograma = mysql_num_rows($mostrar_cronograma);
?>
<form action="avance_producto_guardar.php" method="post" enctype="multipart/form-data">
    <table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
                <div class="ewGridMiddlePanel">
                    <table cellspacing="0" class="ewTable">
                        <tr>
                            <td class="ewTableHeader">Hito</td>
                            <td colspan="3">
                                <div><?php echo $row_cronograma['detalle'] ?></div></td>
                            <td>Regional</td>
                            <?php
                            $num_campos = 0;
                            while ($row_regional = mysql_fetch_assoc($mostrar_regional)) {
                                ?>
                                <td colspan="<?php echo $row_regional['numRegional'] ?>" align="center" style="font-size: 10pt;background: #75923C;color: white"><?php echo strtoupper($row_regional['regional']) ?></td>
                                <?php
                                $num_campos+=$row_regional['numRegional'];
                            }
                            ?>
                            <td rowspan="3" colspan="3"><div>Avance %</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ewTableHeader">Fecha Inicio</td>
                            <td>
                                <div><?php echo date("d-m-Y", strtotime($row_cronograma['fechaInicio'])) ?></div></td>
                            <td class="ewTableHeader">Fecha Final</td>
                            <td>
                                <div><?php echo date("d-m-Y", strtotime($row_cronograma['fechaFinal'])) ?></div></td>
                            <td>Municipio(s)</td>
                            <?php while ($row_municipio = mysql_fetch_assoc($mostrar_municipio)) { ?>
                                <td colspan="<?php echo $row_municipio['numMunicipio'] ?>" style="font-size: 8pt;background: #C2D69A;text-align: center;border-color: #ffffff"><?php echo $row_municipio['municipio'] ?></td>
                            <?php } ?>
                        </tr>
                        <tr class="ewTableHeader">
                            <td style="background: #9df9c1;text-align: center" colspan="2">DESCRIPCION DE RESULTADOS DEL HITO</td>
                            <td style="background: #9dfb98;text-align: center" colspan="2">META</td>
                            <td style="background: #9dfb98;text-align: center">Meta Alcanzar</td>
                            <?php
                            $array_idmer = array();
                            $array_idmeta = array();

                            $mostrar_municipio = mysql_query($query_municipio, $conexion) or die(mysql_error());
                            while ($row_municipio = mysql_fetch_assoc($mostrar_municipio)) {
                                mysql_select_db($database_conexion, $conexion);
                                $query_mers = "SELECT a.idMer, b.mer FROM ubicacion_consultoria a, mer b WHERE a.idConsultoria='" . $v_idConsultoria . "' AND a.idMunicipio='" . $row_municipio['idMunicipio'] . "' AND a.idMer=b.idMer ORDER BY mer asc";
                                $mostrar_mers = mysql_query($query_mers, $conexion) or die(mysql_error());
                                $total_mers = mysql_num_rows($mostrar_mers);
                                while ($row_mers = mysql_fetch_assoc($mostrar_mers)) {
                                    ?>
                                    <td style="font-size: 8.5px;background: #EAF1DD"><?php echo $row_mers['mer']; ?>
                                        <input type="hidden" name="y_idMer[]" value="<?php echo $row_mers['idMer']; ?>">
                                    </td>
                                    <?php
                                    $array_idmer[] = $row_mers['idMer'];
                                }
                            }
                            ?>
                        </tr>
                        <?php
                        $sw = 1;
                        mysql_select_db($database_conexion, $conexion);
                        $query_indicador = "SELECT * FROM indicador WHERE idCronograma='" . $v_idCronograma . "'";
                        $mostrar_indicador = mysql_query($query_indicador, $conexion) or die(mysql_error());
                        $total_indicador = mysql_num_rows($mostrar_indicador);

                        mysql_select_db($database_conexion, $conexion);
                        $query_meta = "SELECT idMeta,idCronograma,meta,metaAlcanzar,cabecera,archivoGeneral, (case estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estado FROM meta WHERE idCronograma='" . $v_idCronograma . "' ORDER BY idMeta asc";
                        $mostrar_meta = mysql_query($query_meta, $conexion) or die(mysql_error());
                        $total_meta = mysql_num_rows($mostrar_meta);
                        $contador = 1;
                        $sumaMetaAlcanzar = 0;
                        $sumaLogroAlcanzar = 0;
// recorremos las metas
                        while ($row_meta = mysql_fetch_assoc($mostrar_meta)) {
                            mysql_select_db($database_conexion, $conexion);
                            $query_metaReporte = "SELECT * FROM meta_reporte WHERE idMeta='" . $row_meta['idMeta'] . "' AND idCronograma='" . $v_idCronograma . "'";
                            $mostrar_metaReporte = mysql_query($query_metaReporte, $conexion) or die(mysql_error());
                            $row_metaReporte = mysql_fetch_assoc($mostrar_metaReporte);
                            $total_metaReporte = mysql_num_rows($mostrar_metaReporte);
                            ?>
                            <tr <?php
                        if ($row_meta['cabecera'] == '1') {
                            echo "style='background: #DBE5F1;'";
                        }
                        ?>>
                                <?php if ($sw == '1') { ?><td colspan="2" rowspan="<?php echo $total_meta ?>">
                                    <?php while ($row_indicador = mysql_fetch_assoc($mostrar_indicador)) { ?>
                                            <p><div style="width: 150px"><?php echo $row_indicador['indicador'] ?></div></p>
        <?php } ?>
                                    </td><?php $sw = 0;
    } ?>

                                <td colspan="2"><div style="width: 300px"><?php echo $row_meta['meta']; ?></div></td>
                                <td><?php
                            if ($row_meta['cabecera'] == '0') {
                                echo "<div>" . $row_meta['metaAlcanzar'] . " %</div><div style='color: blue'>" . $row_meta['estado'] . "</div>";
                            }
    ?></td>
                                <?php
                                // recorremos las mers
                                $suma_meta = 0;
                                for ($i = 0; $i < count($array_idmer); $i++) {
//mysql_select_db($database_conexion, $conexion);
//$query_reporteUnitario= "SELECT selector, archivo,comentario FROM meta_reporte_unitario WHERE idMeta='".$row_meta['idMeta']."' AND idMer='".$array_idmer[$i]."' ";
//$mostrar_reporteUnitario=mysql_query($query_reporteUnitario, $conexion) or die(mysql_error());
//$row_reporteUnitario=mysql_fetch_assoc($mostrar_reporteUnitario);
//$total_reporteUnitario=mysql_num_rows($mostrar_reporteUnitario);
                                    $row_reporteUnitario = idMetaidMer($row_meta['idMeta'], $array_idmer[$i], $database_conexion, $conexion, $v_idConsultoria, $v_idCronograma);
//                                    if ($row_reporteUnitario) {
//                                        $suma_meta++;
//                                    }
                                    ?>
                                    <td align="center"><?php if ($row_meta['cabecera'] == '0') {
                                    if ($row_meta['archivoGeneral'] == '0') { ?>
                                                <input type="checkbox" id="selector<?php echo $row_meta['idMeta'] ?><?php echo $array_idmer[$i] ?>" name="selector[<?php echo $row_meta['idMeta'] ?>][<?php echo $array_idmer[$i] ?>]" size="5" <?php
                                       if ($row_reporteUnitario['selector'] == '1') {
                                           echo 'checked';
                                           $suma_meta++;
                                       }
                                            ?> onclick="mostrarOcultarComentario(this.checked,<?php echo $row_meta['idMeta'] ?>,<?php echo $array_idmer[$i] ?>)">
                                                <div><textarea id="comentario<?php echo $row_meta['idMeta'] ?><?php echo $array_idmer[$i] ?>" name="comentario[<?php echo $row_meta['idMeta'] ?>][<?php echo $array_idmer[$i] ?>]" rows="2" cols="30" ><?php echo $row_reporteUnitario['comentario'] ?></textarea></div>
                                                <?php if ($row_reporteUnitario['selector'] != '1') { ?>
                                                    <script type="text/javascript">
                                                        mostrarOcultarComentario(false,<?php echo $row_meta['idMeta'] ?>,<?php echo $array_idmer[$i] ?>)
                                                    </script>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <?php if ($row_reporteUnitario['archivo'] != "") { ?>
                                                    <input type="hidden" name="archivo_nombre[<?php echo $row_meta['idMeta'] ?>][<?php echo $array_idmer[$i] ?>]" size="2" value="<?php echo $row_reporteUnitario['archivo'] ?>" />
                                                    <?php
// archivo para reporte  unitario
                                                    if ($gestor = opendir('files_consultoria')) {
                                                        $sw_arch=0;
                                                        while (false !== ($arch = readdir($gestor))) {
                                                            if ($arch != "." && $arch != ".." && $arch == $row_reporteUnitario['archivo']) {
                                                                echo "<li><a href=\"files_consultoria/" . $arch . "\" class=\"linkli\" title='Extraer archivo(" . $arch . ")'>Descargar&nbsp;&nbsp;&nbsp;</a> ";

                                                                if ($Security->CanDelete() && $row_meta['estado'] == 'Proceso' && $row_reporteUnitario['sw'] == 0) {
                                                                    echo "<a href='avance_producto_guardar.php?x_idMeta=" . $row_meta['idMeta'] . "&x_idMer=" . $array_idmer[$i] . "&sw=archivodelete&archivo=" . $arch . "&x_idConsultoria=" . $v_idConsultoria . "&x_idCronograma=" . $v_idCronograma . "&numMers=" . count($array_idmer) . "' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'> ";
                                                                    echo "<img src='images/delete.png' height='10' width='12' border='none'></a>";
                                                                }
                                                                echo "</li>\n";
                                                                $sw_arch=1;
                                                            }
                                                        }
                                                        closedir($gestor);
//                                                        // incrementado por freddy
//                                                        if($sw_arch==0){
//                                                            //if ($Security->CanDelete() && $row_meta['estado'] == 'Proceso' && $row_reporteUnitario['sw'] == 0) {
//                                                                    echo "<a href='avance_producto_guardar.php?x_idMeta=" . $row_meta['idMeta'] . "&x_idMer=" . $array_idmer[$i] . "&sw=archivodelete&archivo=" . $arch . "&x_idConsultoria=" . $v_idConsultoria . "&x_idCronograma=" . $v_idCronograma . "&numMers=" . count($array_idmer) . "' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'> ";
//                                                                    echo "<img src='images/delete.png' height='10' width='12' border='none'></a>";
//                                                              //  }
//                                                        }
//                                                        /////
                                                    }
                                                    ?>
                                                    <div><textarea id="comentario<?php echo $row_meta['idMeta'] ?><?php echo $array_idmer[$i] ?>" name="comentario[<?php echo $row_meta['idMeta'] ?>][<?php echo $array_idmer[$i] ?>]" rows="2" cols="30" ><?php echo $row_reporteUnitario['comentario']; ?></textarea></div>
                                                    <?php
                                                    $suma_meta++;
                                                } else {
                                                    if ($Security->CanAdd() && $row_meta['estado'] == 'Proceso') {
                                                        ?>
                                                        <input type="file" name="archivo<?php echo $row_meta['idMeta'] ?><?php echo $array_idmer[$i] ?>" id="archivo" size="2" onchange="mostrarOcultarComentarioFile(this.value,<?php echo $row_meta['idMeta'] ?>,<?php echo $array_idmer[$i] ?>)"/>
                                                        <div><textarea id="comentario<?php echo $row_meta['idMeta'] ?><?php echo $array_idmer[$i] ?>" name="comentario[<?php echo $row_meta['idMeta'] ?>][<?php echo $array_idmer[$i] ?>]" rows="2" cols="30" ><?php echo $row_reporteUnitario['comentario']; ?></textarea></div>
                                                    <?php } ?>
                                                    <script type="text/javascript">
                                                        mostrarOcultarComentarioFile("",<?php echo $row_meta['idMeta'] ?>,<?php echo $array_idmer[$i] ?>)
                                                    </script>
                                                <?php
                                            }
                                        }
                                    }
                                    ?></td>
                                    <?php } ?>
    <?php if ($row_meta['cabecera'] == '0') { ?>
                                    <td id="logro_td<?php echo $row_meta['idMeta'] ?>" style="cursor: pointer" title="Presione para realizar el reporte de la meta" onclick="func_reporte_meta(<?php echo $row_meta['idMeta'] ?>)">
        <?php echo "<div>" . round(($suma_meta * 100) / count($array_idmer), 2) . "%</div><div style='color: blue'>" . $row_meta['estado'] . "</div>" ?>
                                    </td>
                                    <td align="center">
                                        <div id="reporteConsultor_td<?php echo $row_meta['idMeta'] ?>"></div>
                                        <div id="revisionReporteMeta_td<?php echo $row_meta['idMeta'] ?>"></div>
                                    </td>
                                    <?php
                                    $sumaLogroAlcanzar+= ( $suma_meta * 100) / count($array_idmer);
                                    $sumaMetaAlcanzar+=$row_meta['metaAlcanzar'];
                                } else {
                                    ?> <td></td>
                                    <td></td>
                            <?php } ?>
                            </tr>
                            <input type="hidden" name="y_idMeta[]" value="<?php echo $row_meta['idMeta'] ?>">
                            <?php
                            $contador++;
                        }
                        ?>
                        <tr style="background: #75923C; color: white">
                            <td colspan="<?php echo $num_campos + 5 ?>" >Porcentaje de Cumplimiento</td>
                            <td><?php echo round(($sumaLogroAlcanzar * 100) / $sumaMetaAlcanzar, 2); ?> %</td>
                        </tr>
                        <input type="hidden" name="x_sumaMetaAlcanzar" value="<?php echo $sumaMetaAlcanzar ?>">
                        <input type="hidden" name="contador" id="contador" value="<?php echo $contador ?>">
                        <input type="hidden" name="x_idConsultoria" id="x_idConsultoria" value="<?php echo $v_idConsultoria ?>">
                        <input type="hidden" name="x_idCronograma" id="x_idCronograma" value="<?php echo $v_idCronograma ?>">
<?php if ($Security->CanAdd() && $row_cronograma['estado'] == 1) { ?>
                            <tr align="center"><td colspan="<?php echo $num_campos + 6; ?>">
                                    <input type="submit" name="guardar_cambios" value="GUARDAR CAMBIOS">&nbsp;&nbsp;&nbsp;&nbsp;
                                </td>
                            </tr>
<?php } ?>
                    </table>
                </div></td></tr></table>
</form>
<div>
    <span>REPORTE HITO
        <img src="images/collapse.gif" id="reporteHitoOcultar" title="Ocultar" style="cursor: pointer">
        <img src="images/expand.gif" id="reporteHitoVer" title="Ver" style="cursor: pointer">
    </span>
</div>
<div id="reporte_hito_div"></div>
<br>
<div id="revisar_hito_div"></div>
<script type="text/javascript">
    reporteHitoVer();

</script>
<?php include "footer.php" ?>
<?php

function idMetaidMer($idMeta, $idMer, $database_conexion, $conexion, $idConsultoria, $idCronograma) {
    mysql_select_db($database_conexion, $conexion);
    $query = "SELECT selector, archivo,comentario FROM meta_reporte_unitario WHERE idMeta='" . $idMeta . "' AND idMer='" . $idMer . "' ";
    $mostrar_reporteUnitario = mysql_query($query, $conexion) or die(mysql_error());
    $row_reporteUnitario = mysql_fetch_assoc($mostrar_reporteUnitario);
    $total_reporteUnitario = mysql_num_rows($mostrar_reporteUnitario);
    $datosArray = array();
    if ($total_reporteUnitario > 0) {
        $row_reporteUnitario['sw'] = 0;
        return $row_reporteUnitario;
    } else {
        $query = "SELECT d.selector,d.comentario,d.archivo
FROM consultoria AS a 
Inner Join cronograma AS b ON a.idConsultoria = b.idConsultoria
Inner Join meta AS c ON b.idCronograma = c.idCronograma
Inner Join meta_reporte_unitario AS d ON c.idMeta = d.idMeta
WHERE
a.idConsultoria =  '$idConsultoria' AND
b.idCronograma <  '$idCronograma' AND
c.meta =(SELECT meta FROM meta WHERE idMeta='$idMeta')  AND
d.idMer =  '$idMer'
ORDER BY b.idCronograma desc
LIMIT 1";
        mysql_select_db($database_conexion, $conexion);
        $mostrar_reporteUnitario = mysql_query($query, $conexion) or die(mysql_error());
        $row_reporteUnitario = mysql_fetch_assoc($mostrar_reporteUnitario);
        $row_reporteUnitario['sw'] = 1;
        return $row_reporteUnitario;
    }
}

//
// Page Class
//
class cavance_producto_list {

    // Page ID
    var $PageID = 'list';
    // Table Name
    var $TableName = 'avance_producto';
    // Page Object Name
    var $PageObjName = 'avance_producto_list';

    // Page Name
    function PageName() {
        return ew_CurrentPage();
    }

    // Page Url
    function PageUrl() {
        $PageUrl = ew_CurrentPage() . "?";
        global $avance_producto;
        if ($avance_producto->UseTokenInUrl)
            $PageUrl .= "t=" . $avance_producto->TableVar . "&"; // add page token
        return $PageUrl;
    }

    // Message
    function getMessage() {
        return @$_SESSION[EW_SESSION_MESSAGE];
    }

    function setMessage($v) {
        if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Append
            $_SESSION[EW_SESSION_MESSAGE] .= "<br>" . $v;
        } else {
            $_SESSION[EW_SESSION_MESSAGE] = $v;
        }
    }

    // Show Message
    function ShowMessage() {
        if ($this->getMessage() <> "") { // Message in Session, display
            echo "<p><span class=\"ewMessage\">" . $this->getMessage() . "</span></p>";
            $_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
        }
    }

    // Validate Page request
    function IsPageRequest() {
        global $objForm, $avance_producto;
        if ($avance_producto->UseTokenInUrl) {

            //IsPageRequest = False
            if ($objForm)
                return ($avance_producto->TableVar == $objForm->GetValue("t"));
            if (@$_GET["t"] <> "")
                return ($avance_producto->TableVar == $_GET["t"]);
        } else {
            return TRUE;
        }
    }

    //
    //  Class initialize
    //  - init objects
    //  - open connection
    //
	function cavance_producto_list() {
        global $conn;

        // Initialize table object
        $GLOBALS["avance_producto"] = new cavance_producto();

        // Initialize other table object
        $GLOBALS['usuario'] = new cusuario();

        // Intialize page id (for backward compatibility)
        if (!defined("EW_PAGE_ID"))
            define("EW_PAGE_ID", 'list', TRUE);

        // Initialize table name (for backward compatibility)
        if (!defined("EW_TABLE_NAME"))
            define("EW_TABLE_NAME", 'avance_producto', TRUE);

        // Open connection to the database
        $conn = ew_Connect();

        // Initialize list options
        $this->ListOptions = new cListOptions();
    }

    // 
    //  Page_Init
    //
	function Page_Init() {
        global $gsExport, $gsExportFile, $avance_producto;
        global $Security;
        $Security = new cAdvancedSecurity();
        if (!$Security->IsLoggedIn())
            $Security->AutoLogin();
        if (!$Security->IsLoggedIn()) {
            $Security->SaveLastUrl();
            $this->Page_Terminate("login.php");
        }
        $Security->TablePermission_Loading();
        $Security->LoadCurrentUserLevel($this->TableName);
        $Security->TablePermission_Loaded();
        if (!$Security->IsLoggedIn()) {
            $Security->SaveLastUrl();
            $this->Page_Terminate("login.php");
        }
        if (!$Security->CanList()) {
            $Security->SaveLastUrl();
            $this->Page_Terminate("login.php");
        }
        $avance_producto->Export = @$_GET["export"]; // Get export parameter
        $gsExport = $avance_producto->Export; // Get export parameter, used in header
        $gsExportFile = $avance_producto->TableVar; // Get export file, used in header
        if ($avance_producto->Export == "print" || $avance_producto->Export == "html") {

            // Printer friendly or Export to HTML, no action required
        }
        if ($avance_producto->Export == "excel") {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=' . $gsExportFile . '.xls');
        }

        // Global page loading event (in userfn6.php)
        Page_Loading();

        // Page load event, used in current page
        $this->Page_Load();
    }

    //
    //  Page_Terminate
    //  - called when exit page
    //  - if URL specified, redirect to the URL
    //
	function Page_Terminate($url = "") {
        global $conn;

        // Page unload event, used in current page
        $this->Page_Unload();

        // Global page unloaded event (in userfn*.php)
        Page_Unloaded();

        // Close Connection
        $conn->Close();

        // Go to URL if specified
        if ($url <> "") {
            ob_end_clean();
            header("Location: $url");
        }
        exit();
    }

    var $lDisplayRecs; // Number of display records
    var $lStartRec;
    var $lStopRec;
    var $lTotalRecs;
    var $lRecRange;
    var $sSrchWhere;
    var $lRecCnt;
    var $lEditRowCnt;
    var $lRowCnt;
    var $lRowIndex;
    var $lOptionCnt;
    var $lRecPerRow;
    var $lColCnt;
    var $sDeleteConfirmMsg; // Delete confirm message
    var $sDbMasterFilter;
    var $sDbDetailFilter;
    var $bMasterRecordExists;
    var $ListOptions;
    var $sMultiSelectKey;

    //
    // Page main processing
    //
	function Page_Main() {
        global $objForm, $gsSearchError, $Security, $avance_producto;
        $this->lDisplayRecs = 20;
        $this->lRecRange = 10;
        $this->lRecCnt = 0; // Record count
        // Search filters
        $sSrchAdvanced = ""; // Advanced search filter
        $sSrchBasic = ""; // Basic search filter
        $sFilter = "";
        $this->sSrchWhere = ""; // Search WHERE clause
        $this->sDeleteConfirmMsg = "�Quiere borrar este registro?"; // Delete confirm message
        // Master/Detail
        $this->sDbMasterFilter = ""; // Master filter
        $this->sDbDetailFilter = ""; // Detail filter
        if ($this->IsPageRequest()) { // Validate request
            // Set up records per page dynamically
            $this->SetUpDisplayRecs();

            // Handle reset command
            $this->ResetCmd();

            // Set Up Sorting Order
            $this->SetUpSortOrder();
        } // End Validate Request
        // Restore display records
        if ($avance_producto->getRecordsPerPage() <> "") {
            $this->lDisplayRecs = $avance_producto->getRecordsPerPage(); // Restore from Session
        } else {
            $this->lDisplayRecs = 20; // Load default
        }

        // Load Sorting Order
        $this->LoadSortOrder();

        // Build filter
        $sFilter = "";
        if (!$Security->CanList()) {
            $sFilter = "(0=1)"; // Filter all records
        }
        if ($this->sDbDetailFilter <> "")
            $sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
        if ($this->sSrchWhere <> "")
            $sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sSrchWhere . ")" : $this->sSrchWhere;

        // Set up filter in Session
        $avance_producto->setSessionWhere($sFilter);
        $avance_producto->CurrentFilter = "";

        // Export data only
        if (in_array($avance_producto->Export, array("html", "word", "excel", "xml", "csv"))) {
            $this->ExportData();
            $this->Page_Terminate(); // Terminate response
            exit();
        }
    }

    // Set up number of records displayed per page
    function SetUpDisplayRecs() {
        global $avance_producto;
        $sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
        if ($sWrk <> "") {
            if (is_numeric($sWrk)) {
                $this->lDisplayRecs = intval($sWrk);
            } else {
                if (strtolower($sWrk) == "all") { // Display all records
                    $this->lDisplayRecs = -1;
                } else {
                    $this->lDisplayRecs = 20; // Non-numeric, load default
                }
            }
            $avance_producto->setRecordsPerPage($this->lDisplayRecs); // Save to Session
            // Reset start position
            $this->lStartRec = 1;
            $avance_producto->setStartRecordNumber($this->lStartRec);
        }
    }

    // Set up Sort parameters based on Sort Links clicked
    function SetUpSortOrder() {
        global $avance_producto;

        // Check for an Order parameter
        if (@$_GET["order"] <> "") {
            $avance_producto->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
            $avance_producto->CurrentOrderType = @$_GET["ordertype"];
            $avance_producto->UpdateSort($avance_producto->idConsultoria); // Field 
            $avance_producto->UpdateSort($avance_producto->idCronograma); // Field 
            $avance_producto->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load Sort Order parameters
    function LoadSortOrder() {
        global $avance_producto;
        $sOrderBy = $avance_producto->getSessionOrderBy(); // Get order by from Session
        if ($sOrderBy == "") {
            if ($avance_producto->SqlOrderBy() <> "") {
                $sOrderBy = $avance_producto->SqlOrderBy();
                $avance_producto->setSessionOrderBy($sOrderBy);
            }
        }
    }

    // Reset command based on querystring parameter cmd=
    // - RESET: reset search parameters
    // - RESETALL: reset search & master/detail parameters
    // - RESETSORT: reset sort parameters
    function ResetCmd() {
        global $avance_producto;

        // Get reset cmd
        if (@$_GET["cmd"] <> "") {
            $sCmd = $_GET["cmd"];

            // Reset sort criteria
            if (strtolower($sCmd) == "resetsort") {
                $sOrderBy = "";
                $avance_producto->setSessionOrderBy($sOrderBy);
                $avance_producto->idConsultoria->setSort("");
                $avance_producto->idCronograma->setSort("");
            }

            // Reset start position
            $this->lStartRec = 1;
            $avance_producto->setStartRecordNumber($this->lStartRec);
        }
    }

    // Set up Starting Record parameters based on Pager Navigation
    function SetUpStartRec() {
        global $avance_producto;
        if ($this->lDisplayRecs == 0)
            return;
        if ($this->IsPageRequest()) { // Validate request			
            if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
                $this->lStartRec = $_GET[EW_TABLE_START_REC];
                $avance_producto->setStartRecordNumber($this->lStartRec);
            } elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
                $this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
                if (is_numeric($this->nPageNo)) {
                    $this->lStartRec = ($this->nPageNo - 1) * $this->lDisplayRecs + 1;
                    if ($this->lStartRec <= 0) {
                        $this->lStartRec = 1;
                    } elseif ($this->lStartRec >= intval(($this->lTotalRecs - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1) {
                        $this->lStartRec = intval(($this->lTotalRecs - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1;
                    }
                    $avance_producto->setStartRecordNumber($this->lStartRec);
                }
            }
        }
        $this->lStartRec = $avance_producto->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
            $this->lStartRec = 1; // Reset start record counter
            $avance_producto->setStartRecordNumber($this->lStartRec);
        } elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
            $this->lStartRec = intval(($this->lTotalRecs - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1; // Point to last page first record
            $avance_producto->setStartRecordNumber($this->lStartRec);
        } elseif (($this->lStartRec - 1) % $this->lDisplayRecs <> 0) {
            $this->lStartRec = intval(($this->lStartRec - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1; // Point to page boundary
            $avance_producto->setStartRecordNumber($this->lStartRec);
        }
    }

    // Load recordset
    function LoadRecordset($offset = -1, $rowcnt = -1) {
        global $conn, $avance_producto;

        // Call Recordset Selecting event
        $avance_producto->Recordset_Selecting($avance_producto->CurrentFilter);

        // Load list page SQL
        $sSql = $avance_producto->SelectSQL();
        if ($offset > -1 && $rowcnt > -1)
            $sSql .= " LIMIT $offset, $rowcnt";

        // Load recordset
        $conn->raiseErrorFn = 'ew_ErrorFn';
        $rs = $conn->Execute($sSql);
        $conn->raiseErrorFn = '';

        // Call Recordset Selected event
        $avance_producto->Recordset_Selected($rs);
        return $rs;
    }

    // Load row based on key values
    function LoadRow() {
        global $conn, $Security, $avance_producto;
        $sFilter = $avance_producto->KeyFilter();

        // Call Row Selecting event
        $avance_producto->Row_Selecting($sFilter);

        // Load sql based on filter
        $avance_producto->CurrentFilter = $sFilter;
        $sSql = $avance_producto->SQL();
        if ($rs = $conn->Execute($sSql)) {
            if ($rs->EOF) {
                $LoadRow = FALSE;
            } else {
                $LoadRow = TRUE;
                $rs->MoveFirst();
                $this->LoadRowValues($rs); // Load row values
                // Call Row Selected event
                $avance_producto->Row_Selected($rs);
            }
            $rs->Close();
        } else {
            $LoadRow = FALSE;
        }
        return $LoadRow;
    }

    // Load row values from recordset
    function LoadRowValues(&$rs) {
        global $avance_producto;
        $avance_producto->idConsultoria->setDbValue($rs->fields('idConsultoria'));
        $avance_producto->idCronograma->setDbValue($rs->fields('idCronograma'));
    }

    // Render row values based on field settings
    function RenderRow() {
        global $conn, $Security, $avance_producto;

        // Call Row_Rendering event
        $avance_producto->Row_Rendering();

        // Common render codes for all row types
        // idConsultoria

        $avance_producto->idConsultoria->CellCssStyle = "";
        $avance_producto->idConsultoria->CellCssClass = "";

        // idCronograma
        $avance_producto->idCronograma->CellCssStyle = "";
        $avance_producto->idCronograma->CellCssClass = "";
        if ($avance_producto->RowType == EW_ROWTYPE_VIEW) { // View row
            // idConsultoria
            $avance_producto->idConsultoria->ViewValue = $avance_producto->idConsultoria->CurrentValue;
            $avance_producto->idConsultoria->CssStyle = "";
            $avance_producto->idConsultoria->CssClass = "";
            $avance_producto->idConsultoria->ViewCustomAttributes = "";

            // idCronograma
            $avance_producto->idCronograma->ViewValue = $avance_producto->idCronograma->CurrentValue;
            $avance_producto->idCronograma->CssStyle = "";
            $avance_producto->idCronograma->CssClass = "";
            $avance_producto->idCronograma->ViewCustomAttributes = "";

            // idConsultoria
            $avance_producto->idConsultoria->HrefValue = "";

            // idCronograma
            $avance_producto->idCronograma->HrefValue = "";
        }

        // Call Row Rendered event
        $avance_producto->Row_Rendered();
    }

    // Export data in XML or CSV format
    function ExportData() {
        global $avance_producto;
        $sCsvStr = "";

        // Default export style
        $sExportStyle = "h";

        // Load recordset
        $rs = $this->LoadRecordset();
        $this->lTotalRecs = $rs->RecordCount();
        $this->lStartRec = 1;

        // Export all
        if ($avance_producto->ExportAll) {
            $this->lStopRec = $this->lTotalRecs;
        } else { // Export 1 page only
            $this->SetUpStartRec(); // Set up start record position
            // Set the last record to display
            if ($this->lDisplayRecs < 0) {
                $this->lStopRec = $this->lTotalRecs;
            } else {
                $this->lStopRec = $this->lStartRec + $this->lDisplayRecs - 1;
            }
        }
        if ($avance_producto->Export == "xml") {
            $XmlDoc = new cXMLDocument();
        } else {
            echo ew_ExportHeader($avance_producto->Export);

            // Horizontal format, write header
            if ($sExportStyle <> "v" || $avance_producto->Export == "csv") {
                $sExportStr = "";
                ew_ExportAddValue($sExportStr, 'idConsultoria', $avance_producto->Export);
                ew_ExportAddValue($sExportStr, 'idCronograma', $avance_producto->Export);
                echo ew_ExportLine($sExportStr, $avance_producto->Export);
            }
        }

        // Move to first record
        $this->lRecCnt = $this->lStartRec - 1;
        if (!$rs->EOF) {
            $rs->MoveFirst();
            $rs->Move($this->lStartRec - 1);
        }
        while (!$rs->EOF && $this->lRecCnt < $this->lStopRec) {
            $this->lRecCnt++;
            if (intval($this->lRecCnt) >= intval($this->lStartRec)) {
                $this->LoadRowValues($rs);

                // Render row for display
                $avance_producto->RowType = EW_ROWTYPE_VIEW; // Render view
                $this->RenderRow();
                if ($avance_producto->Export == "xml") {
                    $XmlDoc->BeginRow();
                    $XmlDoc->AddField('idConsultoria', $avance_producto->idConsultoria->CurrentValue);
                    $XmlDoc->AddField('idCronograma', $avance_producto->idCronograma->CurrentValue);
                    $XmlDoc->EndRow();
                } else {
                    if ($sExportStyle == "v" && $avance_producto->Export <> "csv") { // Vertical format
                        echo ew_ExportField('idConsultoria', $avance_producto->idConsultoria->ExportValue($avance_producto->Export, $avance_producto->ExportOriginalValue), $avance_producto->Export);
                        echo ew_ExportField('idCronograma', $avance_producto->idCronograma->ExportValue($avance_producto->Export, $avance_producto->ExportOriginalValue), $avance_producto->Export);
                    } else { // Horizontal format
                        $sExportStr = "";
                        ew_ExportAddValue($sExportStr, $avance_producto->idConsultoria->ExportValue($avance_producto->Export, $avance_producto->ExportOriginalValue), $avance_producto->Export);
                        ew_ExportAddValue($sExportStr, $avance_producto->idCronograma->ExportValue($avance_producto->Export, $avance_producto->ExportOriginalValue), $avance_producto->Export);
                        echo ew_ExportLine($sExportStr, $avance_producto->Export);
                    }
                }
            }
            $rs->MoveNext();
        }

        // Close recordset
        $rs->Close();
        if ($avance_producto->Export == "xml") {
            header("Content-Type: text/xml");
            echo $XmlDoc->XML();
        } else {
            echo ew_ExportFooter($avance_producto->Export);
        }
    }

    // Page Load event
    function Page_Load() {

        //echo "Page Load";
    }

    // Page Unload event
    function Page_Unload() {

        //echo "Page Unload";
    }

    // Form Custom Validate event
    function Form_CustomValidate(&$CustomError) {

        // Return error message in CustomError
        return TRUE;
    }

}
?>
