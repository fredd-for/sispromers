<?php
//session_start(); // Initialize session data
//ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "reporte_mmlinfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php require_once('Connections/conexion.php'); ?>
<?php include "librerias/librerias.php";?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>

<?php
//mysql_select_db($database_conexion, $conexion);
//$query = "SELECT idConsultoria FROM consultoria WHERE estado =  '1' and idConsultoria=1";
//$mostrar_con=mysql_query($query, $conexion) or die(mysql_error());
//$total_con=mysql_num_rows($mostrar_con);
//while ($row_con = mysql_fetch_assoc($mostrar_con)) {
//    
//    
//    mysql_select_db($database_conexion, $conexion);
//    //$query="SELECT idCronograma FROM cronograma WHERE idConsultoria =  '".$row_con['idConsultoria']."'";
//    $query="SELECT idCronograma FROM cronograma WHERE idConsultoria =  '".$row_con['idConsultoria']."' AND idCronograma=55";
//    $mostrar_cro=mysql_query($query, $conexion) or die(mysql_error());
//    $total_cro=mysql_num_rows($mostrar_cro);
//    while ($row_cro = mysql_fetch_array($mostrar_cro)) {
//        mysql_select_db($database_conexion, $conexion);
//        $query = "SELECT idMeta,metaAlcanzar, meta FROM meta WHERE idCronograma =  '".$row_cro['idCronograma']."' AND cabecera =  '0' order by idMeta asc";
//        $mostrar_meta=mysql_query($query, $conexion) or die(mysql_error());
//        $total_meta=mysql_num_rows($mostrar_meta);
//        $sumaMeta = 0;
//        $sumaLogro = 0;
//        while ($row_meta = mysql_fetch_assoc($mostrar_meta)) {
//            
//            mysql_select_db($database_conexion, $conexion);
//            $query="SELECT idMer FROM ubicacion_consultoria WHERE idConsultoria =  '".$row_con['idConsultoria']."'";
//            $mostrar_mer=mysql_query($query, $conexion) or die(mysql_error());
//            $total_mer=mysql_num_rows($mostrar_mer);
//            $total_uni=0;
//            while ($row_mer = mysql_fetch_assoc($mostrar_mer)) {
//                $idMetaidMer = idMetaidMer($row_meta['idMeta'], $row_mer['idMer'], $database_conexion, $conexion, $row_con['idConsultoria'], $row_cro['idCronograma']);
//                if($idMetaidMer['selector']==1 || $idMetaidMer['archivo']!=""){
//                    $total_uni++;
//                }
//            }
//            
////            mysql_select_db($database_conexion, $conexion);
////            $query = "SELECT idMetaReporteUnitario FROM meta_reporte_unitario WHERE idMeta =  '".$row_meta['idMeta']."' AND idMer IN (SELECT idMer FROM ubicacion_consultoria WHERE idConsultoria =  '".$row_con['idConsultoria']."')";
////            $mostrar_uni=mysql_query($query, $conexion) or die(mysql_error());
////            $total_uni=mysql_num_rows($mostrar_uni);
//            $sumaMeta+=$row_meta['metaAlcanzar'];
//            $x=($total_uni*100)/$total_mer;
//            $sumaLogro+= $x;
//        }
//        $porcentajeHito= ($sumaLogro*100)/$sumaMeta;
//        mysql_select_db($database_conexion, $conexion);
//        $query = "UPDATE cronograma SET porcentajeCumplimiento=$porcentajeHito  WHERE idCronograma='".$row_cro['idCronograma']."'";
//        $mostrar=mysql_query($query, $conexion) or die(mysql_error());
//    }
//    
//}

mysql_select_db($database_conexion, $conexion);
$query = "SELECT idConsultoria FROM consultoria WHERE estado =  '1' ";
$mostrar_con=mysql_query($query, $conexion) or die(mysql_error());
while ($row_con = mysql_fetch_array($mostrar_con)) {

$v_idConsultoria = $row_con['idConsultoria'];
mysql_select_db($database_conexion, $conexion);
$query="SELECT idCronograma FROM cronograma WHERE idConsultoria =  '".$row_con['idConsultoria']."' AND porcentajeCumplimiento>0";
$mostrar_cro=mysql_query($query, $conexion) or die(mysql_error());
while ($row_cro = mysql_fetch_assoc($mostrar_cro)) {
    $v_idCronograma = $row_cro['idCronograma'];    



mysql_select_db($database_conexion, $conexion);
$query_consultoria = "SELECT a.idConsultoria, a.consultoria, a.fechaInicio, a.fechaFinal, b.paterno, b.materno,b.nombre FROM consultoria a, usuario b WHERE a.idConsultoria='" . (int) $v_idConsultoria . "' AND a.idUsuario=b.idUsuario";
$mostrar_consultoria = mysql_query($query_consultoria, $conexion) or die(mysql_error());
$row_consultoria = mysql_fetch_assoc($mostrar_consultoria);
?>
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
                            <?php
                            $num_campos = 0;
                            while ($row_regional = mysql_fetch_assoc($mostrar_regional)) {
                                $num_campos+=$row_regional['numRegional'];
                            }
                            ?>
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
                                    $array_idmer[] = $row_mers['idMer'];
                                }
                            }
                            ?>
                        
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
                                <?php
                                // recorremos las mers
                                $suma_meta = 0;
                                for ($i = 0; $i < count($array_idmer); $i++) {
                                    $row_reporteUnitario = idMetaidMer($row_meta['idMeta'], $array_idmer[$i], $database_conexion, $conexion, $v_idConsultoria, $v_idCronograma);
                                    ?>
                                    <?php if ($row_meta['cabecera'] == '0') {
                                    if ($row_meta['archivoGeneral'] == '0') { 
                                       if ($row_reporteUnitario['selector'] == '1') {
                                           $suma_meta++;
                                       }
                                            
                                            
                                            } else { ?>
                                                <?php if ($row_reporteUnitario['archivo'] != "") { 
                                                    $suma_meta++;
                                                } 
                                        }
                                    }
                                    ?>
                                    <?php } ?>
    <?php if ($row_meta['cabecera'] == '0') { 
                                    $sumaLogroAlcanzar+= ( $suma_meta * 100) / count($array_idmer);
                                    $sumaMetaAlcanzar+=$row_meta['metaAlcanzar'];
                                } 
                            $contador++;
                        }
                        ?>
                <?php
                
                echo $porcentajeHito =($sumaLogroAlcanzar * 100) / $sumaMetaAlcanzar;
                mysql_select_db($database_conexion, $conexion);
        $query = "UPDATE cronograma SET porcentajeCumplimiento=$porcentajeHito  WHERE idCronograma='".$v_idCronograma."'";
        $mostrar=mysql_query($query, $conexion) or die(mysql_error());
}

}


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

?>

