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
<?php require_once('Connections/conexion.php'); ?>
<?php
require_once('tcpdf/config/lang/esp.php');
require_once('tcpdf/tcpdf.php');
?>
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
$Page =& $avance_producto_list;

// Page init processing
$avance_producto_list->Page_Init();

// Page main processing
$avance_producto_list->Page_Main();
?>

<?php
ob_end_clean();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Luis Freddy Velasco');
$pdf->SetTitle('Reporte de Evaluacion de Proyecto');
$pdf->SetSubject('Este es el Subject');
$pdf->SetKeywords('FH/Bolivia, SISPROMERS-Consultorias, Luis Freddy Velasco');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'INFORME DE EVALUACION DE HITO', PDF_HEADER_STRING);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings
$pdf->setLanguageArray($l);
// set font
$pdf->AddPage();
// consultas sql
$v_idCronograma=$_GET['idCronograma'];
$v_idConsultoria=$_GET['idConsultoria'];
// datos generales
mysql_select_db($database_conexion, $conexion);
$query_consultoria= "SELECT a.idConsultoria, a.consultoria, a.fechaInicio, a.fechaFinal, b.paterno, b.materno,b.nombre FROM consultoria a, usuario b WHERE a.idConsultoria='".(int)$v_idConsultoria."' AND a.idUsuario=b.idUsuario";
$mostrar_consultoria=mysql_query($query_consultoria, $conexion) or die(mysql_error());
$row_consultoria=mysql_fetch_assoc($mostrar_consultoria);

mysql_select_db($database_conexion, $conexion);
$query_revisor= "SELECT b.nombre,b.paterno,b.materno,a.idRC
FROM responsable_consultoria AS a Inner Join usuario AS b ON a.idUsuario = b.idUsuario
WHERE a.idConsultoria = '".(int)$v_idConsultoria."' ORDER BY b.paterno ASC,b.paterno ASC,b.nombre ASC";
$mostrar_revisor=mysql_query($query_revisor, $conexion) or die(mysql_error());

// tabla contenido
mysql_select_db($database_conexion, $conexion);
$query_regional= "SELECT a.idUC, a.idRegional, b.regional, count(a.idRegional) as numRegional FROM ubicacion_consultoria a, regional b, municipio c, mer d WHERE a.idConsultoria='".$v_idConsultoria."' AND a.idRegional=b.idRegional AND a.idMunicipio=c.idMunicipio AND a.idMer=d.idMer GROUP BY a.idRegional ORDER BY b.regional asc, c.municipio asc, d.mer asc ";
$mostrar_regional=mysql_query($query_regional, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_municipio= "SELECT a.idUC, a.idMunicipio, c.municipio, count(a.idMunicipio) as numMunicipio FROM ubicacion_consultoria a, regional b, municipio c, mer d WHERE a.idConsultoria='".$v_idConsultoria."' AND a.idRegional=b.idRegional AND a.idMunicipio=c.idMunicipio AND a.idMer=d.idMer GROUP BY a.idMunicipio ORDER BY b.regional asc, c.municipio asc, d.mer asc ";
$mostrar_municipio=mysql_query($query_municipio, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_totalmers= "SELECT count(idMer) as totalmers FROM ubicacion_consultoria WHERE idConsultoria='".$v_idConsultoria."'";
$mostrar_totalmers=mysql_query($query_totalmers, $conexion) or die(mysql_error());
$row_totalmers=mysql_fetch_assoc($mostrar_totalmers);

mysql_select_db($database_conexion, $conexion);
$query_cronograma= "SELECT * FROM cronograma WHERE idCronograma='".$v_idCronograma."'";
$mostrar_cronograma=mysql_query($query_cronograma, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_cronogramaReporte= "SELECT idCronogramaReporte, idCronograma,archivo,detalle,sugerencia,inesperado,fechaCreacion,(case estado when 1 then 'Corregir' when 2 then 'Revision' when 3 then 'Aprobado' end) as estado  FROM cronograma_reporte WHERE idCronograma=".$v_idCronograma;
$mostrar_cronogramaReporte=mysql_query($query_cronogramaReporte, $conexion) or die(mysql_error());


//$pdf->Cell(0, 12, 'Este es un Ejemplo de Gmurillo', 1, 1, 'C');
$fechaimpresion=date("d")."-".date("m")."-".date("Y");
$horaimpresion=date("H").":".date("i").":".date("s");
$usuarioimpresion = $_SESSION["nombrecompleto"];
//        ancho alto txt                         borde,siglinea, align,
$pdf->SetFont('times', 'B', 6);

$pdf->Cell(100, 6, 'Fecha Impresion:'.$fechaimpresion, 0, 0, 'L', 2, '', 0);
$pdf->Cell(100, 6, 'Hora Impresion:'.$horaimpresion, 0, 0, 'L', 2, '', 0);
$pdf->Cell(100, 6, 'Usuario Impresion: '.$_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'], 0, 1, 'L', 0, '', 0);

$pdf->SetFont('times', '', 9);
$pdf->writeHTML(generaTablaHtml('datos_proyecto'),true,0,true,0);

$pdf->SetFont('times', '', 7);
$pdf->writeHTML(generaTablaHtml('tabla_contenido'),true,0,true,0);

$pdf->AddPage();
$pdf->SetFont('times', 'B', 9);
$pdf->Cell(0, 10, 'HISTORICO DE INFORMES Y REVISIONES', 0, 1, 'L', 0, '', 0);
$pdf->SetFont('times', '', 7);
$pdf->writeHTML(generaTablaHtml('historico'),true,0,true,0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('times', '', 10);
$pdf->Cell(0, 10, 'CONSULTOR: '.utf8_encode($row_consultoria['paterno'].' '.$row_consultoria['materno'].' '.$row_consultoria['nombre']).'                                                                             COORDINADOR DE PROYECTO: Ruiz Adolfo', 0, 1, 'C', 0, '', 0);
$pdf->Cell(0, 10, 'La Paz, '.textofecha(), 0, 1, 'L', 0, '', 0);


$pdf->Output('informe_hito.pdf', 'I');
function generaTablaHtml($tabla) {
    global $database_conexion;
    global $conexion;
    global $mostrar_consultoria;
    global $mostrar_revisor;
    global $mostrar_cronograma;
    global $mostrar_regional;
    global $mostrar_municipio;
    global $v_idConsultoria;
    global $v_idCronograma;
    global $mostrar_cronogramaReporte;
    $colorTitulo="#EAF1DD";
    $blanco='#FFFFFF';
    $gris='#D3D3D3';
        
    switch($tabla) {
  case "historico":      
  $total_cronogramaReporte=mysql_num_rows($mostrar_cronogramaReporte);
  $total_revisor=mysql_num_rows($mostrar_revisor);
if($total_cronogramaReporte>0){
  $htmlTabla='<table width="100%" border="1">';
$htmlTabla.='<tr align="center" >
    <td bgcolor="#75923C"><b>Informe Consultor</b></td>
    <td bgcolor="#75923C"><b>Sugerencia Unid. Cordinaci&oacute;n</b></td>
    <td bgcolor="#75923C"><b>Resultados Inesperados</b></td>    
    <td bgcolor="#75923C"><b>Descripci&oacute;n</b></td>
    <td bgcolor="#EAF1DD"><b>Fecha Informe</b></td>
    <td bgcolor="#EAF1DD"><b>Revisor</b></td>
    <td bgcolor="#EAF1DD"><b>Informe Revisor</b></td>
    <td bgcolor="#EAF1DD"><b>Observacion</b></td>
    <td bgcolor="#EAF1DD"><b>Fecha Revision</b></td>
    <td bgcolor="#EAF1DD"><b>Estado</b></td>
</tr>';
$i=1;
while($row_cronogramaReporte=mysql_fetch_assoc($mostrar_cronogramaReporte)){
mysql_data_seek($mostrar_revisor, 0);
$row_revisor=mysql_fetch_assoc($mostrar_revisor);

mysql_select_db($database_conexion, $conexion);
$query_revision= "SELECT a.archivo, a.observacion,a.fechaCreacion,(case a.estado when 1 then 'Corregir' when 2 then 'Revisar' when 3 then 'Aprobado' end) as estado
FROM cronograma_reporte_control AS a WHERE a.idRC ='".$row_revisor['idRC']."' AND a.idCronogramaReporte = '".$row_cronogramaReporte['idCronogramaReporte']."'";
$mostrar_revision=mysql_query($query_revision, $conexion) or die(mysql_error());
$row_revision=mysql_fetch_assoc($mostrar_revision);
if($i%2==0)
$color=$blanco;
else
$color=$gris;

$num=1;
$htmlTabla.='<tr bgcolor="'.$color.'">';
$htmlTabla.='<td rowspan="'.$total_revisor.'">'.utf8_encode($row_cronogramaReporte['archivo']).'</td>
    <td rowspan="'.$total_revisor.'">'.utf8_encode($row_cronogramaReporte['sugerencia']).'</td>
    <td rowspan="'.$total_revisor.'">'.utf8_encode($row_cronogramaReporte['inesperado']).'</td>    
    <td rowspan="'.$total_revisor.'">'.utf8_encode($row_cronogramaReporte['detalle']).'</td>
    <td rowspan="'.$total_revisor.'">'.date("d-m-Y", strtotime($row_cronogramaReporte['fechaCreacion'])).'</td>
    <td>'.$num.'.- '.utf8_encode($row_revisor['paterno'].' '.$row_revisor['materno'].' '.$row_revisor['nombre']).'</td>
    <td>'.$row_revision['archivo'].'</td>
    <td>'.$row_revision['observacion'].'</td>
    <td>'.$row_revision['fechaCreacion'].'</td>
    <td>'.$row_revision['estado'].'</td>
    ';
$num++;
$htmlTabla.='</tr>';
while($row_revisor=mysql_fetch_assoc($mostrar_revisor)){

mysql_select_db($database_conexion, $conexion);
$query_revision= "SELECT a.archivo, a.observacion,a.fechaCreacion,(case a.estado when 1 then 'Corregir' when 2 then 'Revisar' when 3 then 'Aprobado' end) as estado
FROM cronograma_reporte_control AS a WHERE a.idRC ='".$row_revisor['idRC']."' AND a.idCronogramaReporte = '".$row_cronogramaReporte['idCronogramaReporte']."'";
$mostrar_revision=mysql_query($query_revision, $conexion) or die(mysql_error());
$row_revision=mysql_fetch_assoc($mostrar_revision);

$htmlTabla.='<tr bgcolor="'.$color.'">
<td>'.$num.'.- '.utf8_encode($row_revisor['paterno'].' '.$row_revisor['materno'].' '.$row_revisor['nombre']).'</td>
    <td>'.$row_revision['archivo'].'</td>
    <td>'.$row_revision['observacion'].'</td>
    <td>'.$row_revision['fechaCreacion'].'</td>
    <td>'.$row_revision['estado'].'</td>
</tr>';

$num++;
}

$i++;
}

$htmlTabla.='</table>';
}else{
$htmlTabla="No se tiene ningun informe...";
}
return $htmlTabla;
    break;

  case "tabla_contenido":
$dim_ubicacion=540;
mysql_select_db($database_conexion, $conexion);
$query_numeroMers= "SELECT idMer FROM ubicacion_consultoria WHERE idConsultoria='".$v_idConsultoria."'";
$mostrar_numeroMers=mysql_query($query_numeroMers, $conexion) or die(mysql_error());
$total_mers=mysql_num_rows($mostrar_numeroMers);
$numero_divisiones=$dim_ubicacion/$total_mers;

$row_cronograma=mysql_fetch_assoc($mostrar_cronograma);
$total_cronograma=mysql_num_rows($mostrar_cronograma);
   $htmlTabla='<table width="100%" border="1">';
$htmlTabla.='<tr>';
$htmlTabla.='<td width="30" bgcolor='.$colorTitulo.'><b>Hito:</b></td><td colspan="3" width="150"><div>'.utf8_encode($row_cronograma['detalle']).'</div></td>
<td width="30" bgcolor='.$colorTitulo.'><b>Regional:</b></td>';
$num_campos=0;
while($row_regional=mysql_fetch_assoc($mostrar_regional)){

    $htmlTabla.='<td colspan="'.$row_regional['numRegional'].'" align="center" width="'.$row_regional['numRegional']*$numero_divisiones.'">'.utf8_encode(strtoupper($row_regional['regional'])).'</td>';

    $num_campos+=$row_regional['numRegional'];
}
$htmlTabla.='<td rowspan="3" width="30" bgcolor='.$colorTitulo.'><div>Avance %</div></td>';
$htmlTabla.='</tr>';

$htmlTabla.='<tr>';
$htmlTabla.='<td width="30" bgcolor='.$colorTitulo.'><b>Fecha Inicio</b></td><td width="60"><div>'.date("d-m-Y",strtotime($row_cronograma['fechaInicio'])).'</div></td>
    <td width="30" bgcolor='.$colorTitulo.'><b>Fecha Final</b></td><td width="60"><div>'.date("d-m-Y",strtotime($row_cronograma['fechaFinal'])).'</div></td>
    <td width="30" bgcolor='.$colorTitulo.'><b>Municipio(s)</b></td>';
while($row_municipio=mysql_fetch_assoc($mostrar_municipio)){
$htmlTabla.='<td colspan="'.$row_municipio['numMunicipio'].'" width="'.$row_municipio['numMunicipio']*$numero_divisiones.'" align="center">'.utf8_encode($row_municipio['municipio']).'</td>';
}
$htmlTabla.='</tr>';

$htmlTabla.='<tr bgcolor='.$colorTitulo.'>';
$htmlTabla.='<td width="90" colspan="2" align="center">RESULTADOS DEL HITO</td>
    <td width="90" colspan="2" align="center">META</td>
    <td width="30" align="center">Meta Alcanzar</td>';

//$mostrar_municipio=mysql_query($query_municipio, $conexion) or die(mysql_error());
 $array_idmer=array();
mysql_data_seek($mostrar_municipio, 0);
while($row_municipio=mysql_fetch_assoc($mostrar_municipio)){
mysql_select_db($database_conexion, $conexion);
$query_mers= "SELECT a.idMer, b.mer FROM ubicacion_consultoria a, mer b WHERE a.idConsultoria='".$v_idConsultoria."' AND a.idMunicipio='".$row_municipio['idMunicipio']."' AND a.idMer=b.idMer ORDER BY mer asc";
$mostrar_mers=mysql_query($query_mers, $conexion) or die(mysql_error());
$total_mers=mysql_num_rows($mostrar_mers);
while($row_mers=mysql_fetch_assoc($mostrar_mers)){
 $htmlTabla.='<td style="font-size: 15px;" width="'.$numero_divisiones.'" align="center">'.utf8_encode($row_mers['mer']).'</td>';
$array_idmer[]=$row_mers['idMer'];
}
}
$htmlTabla.='</tr>';

// recorremos las metas
$sw=1;
mysql_select_db($database_conexion, $conexion);
$query_indicador= "SELECT * FROM indicador WHERE idCronograma='".$v_idCronograma."'";
$mostrar_indicador=mysql_query($query_indicador, $conexion) or die(mysql_error());
$total_indicador=mysql_num_rows($mostrar_indicador);

mysql_select_db($database_conexion, $conexion);
$query_meta= "SELECT idMeta,idCronograma,meta,metaAlcanzar,cabecera,archivoGeneral, (case estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estado FROM meta WHERE idCronograma='".$v_idCronograma."' ORDER BY idMeta asc";
$mostrar_meta=mysql_query($query_meta, $conexion) or die(mysql_error());
$total_meta=mysql_num_rows($mostrar_meta);
 $contador=1;
 $sumaMetaAlcanzar=0;
 while($row_meta=mysql_fetch_assoc($mostrar_meta)){
     mysql_select_db($database_conexion, $conexion);
$query_metaReporte= "SELECT * FROM meta_reporte WHERE idMeta='".$row_meta['idMeta']."' AND idCronograma='".$v_idCronograma."'";
$mostrar_metaReporte=mysql_query($query_metaReporte, $conexion) or die(mysql_error());
$row_metaReporte=mysql_fetch_assoc($mostrar_metaReporte);
$total_metaReporte=mysql_num_rows($mostrar_metaReporte);

$htmlTabla.='<tr>';
//Mostramos todos los indicadores
if($sw=='1'){
    $htmlTabla.='<td colspan="2" rowspan="'.$total_meta.'" width="90">';	
    
while($row_indicador=mysql_fetch_assoc($mostrar_indicador)){
       $htmlTabla.='<p><div>'.utf8_encode($row_indicador['indicador']).'</div></p>'; 
    }
    $htmlTabla.='</td>';
    $sw=0;}
//
if($row_meta['cabecera']=='0') 
{$color=$blanco;}
else{$color=$gris;}
    
$htmlTabla.='<td colspan="2" width="90" bgcolor="'.$color.'">'.utf8_encode($row_meta['meta']).'</td>';

if($row_meta['cabecera']=='0') 
{$htmlTabla.='<td width="30" bgcolor="'.$color.'">'.$row_meta['metaAlcanzar'].' %</td>';
}else{
	$htmlTabla.='<td width="30" bgcolor="'.$color.'"></td>';
}

$suma_meta=0;
for($i=0;$i<count($array_idmer);$i++){
mysql_select_db($database_conexion, $conexion);
$query_reporteUnitario= "SELECT selector, archivo, comentario FROM meta_reporte_unitario WHERE idMeta='".$row_meta['idMeta']."' AND idMer='".$array_idmer[$i]."' ";
$mostrar_reporteUnitario=mysql_query($query_reporteUnitario, $conexion) or die(mysql_error());
$row_reporteUnitario=mysql_fetch_assoc($mostrar_reporteUnitario);
$total_reporteUnitario=mysql_num_rows($mostrar_reporteUnitario);
if($total_reporteUnitario>0){$suma_meta++;}
$htmlTabla.='<td align="center" width="'.$numero_divisiones.'" bgcolor="'.$color.'">';      
if($row_meta['cabecera']=='0'){
   if($row_meta['archivoGeneral']=='0'){
       if($row_reporteUnitario['selector']){$selector="<b>1</b> <div>".$row_reporteUnitario['comentario']."</div>";}else{$selector="";}
    $htmlTabla.=$selector;
           }else{
        if($row_reporteUnitario['archivo']){$selector="<b>Archivo</b> <div>".$row_reporteUnitario['comentario']."</div>";}else{$selector="";}
        $htmlTabla.=$selector;
          }
      }
$htmlTabla.='</td>';
}
if($row_meta['cabecera']=='0'){
$porcMeta=round(($suma_meta*100)/count($array_idmer), 2);
$htmlTabla.='<td width="30" bgcolor="'.$color.'">'.$porcMeta.' %</td>';
$sumaMetaAlcanzar+=$row_meta['metaAlcanzar'];
    } else {
$htmlTabla.='<td width="30" bgcolor="'.$color.'"></td>';
    }    
$htmlTabla.='</tr>';
    $contador++;

 }
$num_campos+=5;
$dim_ubicacion+=210;
$htmlTabla.='<tr>';
$htmlTabla.='<td colspan="'.$num_campos.'" width="'.$dim_ubicacion.'">Porcentaje de Cumplimiento</td>
    <td width="30">'.$row_cronograma['porcentajeCumplimiento'].' </td>';
$htmlTabla.='</tr>';
 
$htmlTabla.='</table>';
return $htmlTabla;
break;

case "datos_proyecto":
    $total_revisor=mysql_num_rows($mostrar_revisor);
    mysql_data_seek($mostrar_consultoria, 0);
    $row_consultoria=mysql_fetch_assoc($mostrar_consultoria);
    $htmlTabla='<table width="100%" >';
    $htmlTabla.='
        <tr>
                <td width="100"><b>Nombre Consultoria:</b></td><td>'.utf8_encode(strtoupper($row_consultoria['consultoria'])).'</td>
        </tr>
        <tr>
                <td width="100"><b>Duracion Consultoria:</b></td><td>'.date("d-m-Y",strtotime($row_consultoria['fechaInicio'])).' al '. date("d-m-Y",strtotime($row_consultoria['fechaFinal'])).'</td>
        </tr>
        <tr>
        <td width="100"><b>Consultor:</b></td><td>'.utf8_encode($row_consultoria['paterno'].' '.$row_consultoria['materno'].' '.$row_consultoria['nombre']).'</td>
</tr>
<tr>
<td width="100"><b>Revisor (es):</b></td>
<td>';
    $num=1;
    while($row_revisor=mysql_fetch_assoc($mostrar_revisor)) {
        $htmlTabla.='<div>'.$num.'.- '.utf8_encode($row_revisor['paterno'].' '.$row_revisor['materno'].' '.$row_revisor['nombre']).'</div>';
        $num++;
    }
    $htmlTabla.='</td></tr>';

    $htmlTabla.='</table>';
    break;
    }
    return $htmlTabla;

}
function textofecha() {
    switch(date("m")) {
        case 1:
            $salida=date("d").' de Enero de '.date("Y");
            break;
        case 2:
            $salida=date("d").' de Febrero de '.date("Y");
            break;
        case 3:
            $salida=date("d").' de Marzo de '.date("Y");
            break;
        case 4:
            $salida=date("d").' de Abril de '.date("Y");
            break;
        case 5:
            $salida=date("d").' de Mayo de '.date("Y");
            break;
        case 6:
            $salida=date("d").' de Junio de '.date("Y");
            break;
        case 7:
            $salida=date("d").' de Julio de '.date("Y");
            break;
        case 8:
            $salida=date("d").' de Agosto de '.date("Y");
            break;
        case 9:
            $salida=date("d").' de Septiembre de '.date("Y");
            break;
        case 10:
            $salida=date("d").' de Octubre de '.date("Y");
            break;
        case 11:
            $salida=date("d").' de Noviembre de '.date("Y");
            break;
        case 12:
            $salida=date("d").' de Diciembre de '.date("Y");
            break;
    }
    return $salida;
}
?>


<?php
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
        if ($avance_producto->UseTokenInUrl) $PageUrl .= "t=" . $avance_producto->TableVar . "&"; // add page token
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
        if (!$Security->IsLoggedIn()) $Security->AutoLogin();
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
            header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
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
            $sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

        // Set up filter in Session
        $avance_producto->setSessionWhere($sFilter);
        $avance_producto->CurrentFilter = "";

        // Export data only
        if (in_array($avance_producto->Export, array("html","word","excel","xml","csv"))) {
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
                    $this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
                    if ($this->lStartRec <= 0) {
                        $this->lStartRec = 1;
                    } elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
                        $this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
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
            $this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
            $avance_producto->setStartRecordNumber($this->lStartRec);
        } elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
            $this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
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
        if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

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
                    }	else { // Horizontal format
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
