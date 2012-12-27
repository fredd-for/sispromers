<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "cronogramainfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php require_once('Connections/conexion.php'); ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php
function borrar_meta_cascada($idMeta,$database_conexion, $conexion){
/////////////////////////////////////////
//Borramos idMeta de la tabla Meta+
$value=$idMeta;
mysql_select_db($database_conexion, $conexion);
$query_item_costodelete = "DELETE FROM meta WHERE idMeta='".$value."'";
//$query_item_costodelete = "DELETE a,b,c,d FROM meta AS a INNER JOIN meta_reporte AS b ON a.idMeta=b.idMeta INNER JOIN meta_reporte_control AS c ON b.idMetaReporte=c.idMetaReporte INNER JOIN meta_reporte_unitario AS d ON a.idMeta=d.idMeta WHERE a.idMeta='".$value."'";
mysql_query($query_item_costodelete, $conexion) or die(mysql_error());

// borramos la tabla meta_reporte_unitario y sus archivos adjuntos
mysql_select_db($database_conexion, $conexion);
$query_meta_reporte_unitario = "SELECT idMetaReporteUnitario,archivo FROM meta_reporte_unitario WHERE idMeta=$value";
$mostrar_meta_reporte_unitario=mysql_query($query_meta_reporte_unitario, $conexion) or die(mysql_error());
while($row_meta_reporte_unitario=  mysql_fetch_assoc($mostrar_meta_reporte_unitario)){
mysql_select_db($database_conexion, $conexion);
$query_archivodelete = "DELETE FROM meta_reporte_unitario WHERE idMetaReporteUnitario=".$row_meta_reporte_unitario['idMetaReporteUnitario'];
mysql_query($query_archivodelete, $conexion) or die(mysql_error());
unlink("files_consultoria/".$row_meta_reporte_unitario['archivo']);
}
// Borramos la tabla meta_reporte_control
mysql_select_db($database_conexion, $conexion);
$query_meta_reporte_control = "SELECT b.idMetaReporteControl, b.archivo FROM meta_reporte a, meta_reporte_control b WHERE a.idMeta=$value AND a.idMetaReporte=b.idMetaReporte";
$mostrar_meta_reporte_control=mysql_query($query_meta_reporte_control, $conexion) or die(mysql_error());
while($row_meta_reporte_control=  mysql_fetch_assoc($mostrar_meta_reporte_control)){
mysql_select_db($database_conexion, $conexion);
$query_archivodelete = "DELETE FROM meta_reporte_control WHERE idMetaReporteControl=".$row_meta_reporte_control['idMetaReporteControl'];
mysql_query($query_archivodelete, $conexion) or die(mysql_error());
unlink("files_consultoria/".$row_meta_reporte_control['archivo']);
}
// borramos la tabla meta_control
mysql_select_db($database_conexion, $conexion);
$query_meta_reporte = "SELECT idMetaReporte, archivo FROM meta_reporte WHERE idMeta=$value";
$mostrar_meta_reporte=mysql_query($query_meta_reporte, $conexion) or die(mysql_error());
while($row_meta_reporte=  mysql_fetch_assoc($mostrar_meta_reporte)){
mysql_select_db($database_conexion, $conexion);
$query_archivodelete = "DELETE FROM meta_reporte WHERE idMetaReporte=".$row_meta_reporte['idMetaReporte'];
mysql_query($query_archivodelete, $conexion) or die(mysql_error());
unlink("files_consultoria/".$row_meta_reporte['archivo']);
}
////////////
}

// tabla indicador
if($_POST['btnAction']){
// actualizamos cronograma
    if($_POST['x_fechaInicio']){
    $fechaExplode=explode("/", $_POST['x_fechaInicio']);
    $fechaInicio= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaInicio='';}
    if($_POST['x_fechaFinal']){
    $fechaExplode=explode("/", $_POST['x_fechaFinal']);
    $fechaFinal= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaFinal='';}

mysql_select_db($database_conexion, $conexion);
$query_item_costoupdate = "UPDATE cronograma SET fechaInicio='".$fechaInicio."', fechaFinal='".$fechaFinal."', detalle='".$_POST['x_detalle']."' WHERE idCronograma='".$_POST['idCronograma']."'";
mysql_query($query_item_costoupdate, $conexion) or die(mysql_error());

$query_item_costo = "SELECT idIndicador FROM indicador WHERE idCronograma='".$_POST['idCronograma']."' ORDER BY idIndicador ASC";
$mostrar_itemCosto=mysql_query($query_item_costo, $conexion) or die(mysql_error());
$total_itemCosto=mysql_num_rows($mostrar_itemCosto);
$auxArray=array ();
$contadorArray=array();
while($row_itemCosto=mysql_fetch_assoc($mostrar_itemCosto)){
    $auxArray[]=$row_itemCosto['idIndicador'];
}
$contador=count($_POST['x_indicador']);
//echo $contador." - ".$total_itemCosto;
if($contador<$total_itemCosto){
for($i=0;$i<$contador;$i++){
mysql_select_db($database_conexion, $conexion);
$query_item_costo = "SELECT * FROM indicador WHERE idIndicador='".$_POST['x_idIndicador'][$i]."'";
$mostrar_itemCosto=mysql_query($query_item_costo, $conexion) or die(mysql_error());
$total_itemCosto=mysql_num_rows($mostrar_itemCosto);
if($total_itemCosto>0){
mysql_select_db($database_conexion, $conexion);
$query_item_costoupdate = "UPDATE indicador SET indicador='".$_POST['x_indicador'][$i]."' WHERE idIndicador='".$_POST['x_idIndicador'][$i]."'";
mysql_query($query_item_costoupdate, $conexion) or die(mysql_error());
}else{
  mysql_select_db($database_conexion, $conexion);
$query_item_costoinsert = "INSERT INTO indicador VALUES('','".$_POST['idCronograma']."','".$_POST['x_indicador'][$i]."')";
mysql_query($query_item_costoinsert, $conexion) or die(mysql_error());
}
$contadorArray[]=$_POST['x_idIndicador'][$i];
}
$result = array_diff($auxArray, $contadorArray);
foreach ($result as $value) {
mysql_select_db($database_conexion, $conexion);
$query_item_costodelete = "DELETE FROM indicador WHERE idIndicador='".$value."'";
mysql_query($query_item_costodelete, $conexion) or die(mysql_error());
}
}
else{
for($i=0;$i<$contador;$i++){
mysql_select_db($database_conexion, $conexion);
$query_item_costo = "SELECT * FROM indicador WHERE idIndicador='".$_POST['x_idIndicador'][$i]."'";
$mostrar_itemCosto=mysql_query($query_item_costo, $conexion) or die(mysql_error());
$total_itemCosto=mysql_num_rows($mostrar_itemCosto);
if($total_itemCosto>0){
mysql_select_db($database_conexion, $conexion);
$query_item_costoupdate = "UPDATE indicador SET indicador='".$_POST['x_indicador'][$i]."'WHERE idIndicador='".$_POST['x_idIndicador'][$i]."'";
mysql_query($query_item_costoupdate, $conexion) or die(mysql_error());
}else{
  mysql_select_db($database_conexion, $conexion);
$query_item_costoinsert = "INSERT INTO indicador VALUES('','".$_POST['idCronograma']."','".$_POST['x_indicador'][$i]."')";
mysql_query($query_item_costoinsert, $conexion) or die(mysql_error());
}
}
}
}

// tabla resultado
if($_POST['btnAction']){
    
$query_item_costo = "SELECT idMeta FROM meta WHERE idCronograma='".$_POST['idCronograma']."' ORDER BY idMeta ASC";
$mostrar_itemCosto=mysql_query($query_item_costo, $conexion) or die(mysql_error());
$total_itemCosto=mysql_num_rows($mostrar_itemCosto);
$auxArray=array ();
$contadorArray=array();
while($row_itemCosto=mysql_fetch_assoc($mostrar_itemCosto)){
    $auxArray[]=$row_itemCosto['idMeta'];
}
$contador=count($_POST['x_meta']);
//echo $contador." - ".$total_itemCosto;
if($contador<$total_itemCosto){
for($i=0;$i<$contador;$i++){
mysql_select_db($database_conexion, $conexion);
$query_item_costo = "SELECT * FROM meta WHERE idMeta='".$_POST['x_idMeta'][$i]."'";
$mostrar_itemCosto=mysql_query($query_item_costo, $conexion) or die(mysql_error());
$total_itemCosto=mysql_num_rows($mostrar_itemCosto);
if($total_itemCosto>0){
mysql_select_db($database_conexion, $conexion);
$query_item_costoupdate = "UPDATE meta SET meta='".$_POST['x_meta'][$i]."' WHERE idMeta='".$_POST['x_idMeta'][$i]."'";
mysql_query($query_item_costoupdate, $conexion) or die(mysql_error());
}else{
  mysql_select_db($database_conexion, $conexion);
$query_item_costoinsert = "INSERT INTO meta VALUES('','".$_POST['idCronograma']."','".$_POST['x_meta'][$i]."','".$_POST['x_metaAlcanzar'][$i]."','".$_POST['x_cabezera'][$i]."','".$_POST['x_archivoGeneral'][$i]."')";
mysql_query($query_item_costoinsert, $conexion) or die(mysql_error());
}
$contadorArray[]=$_POST['x_idMeta'][$i];
}
$result = array_diff($auxArray, $contadorArray);
foreach ($result as $value) {
    borrar_meta_cascada($value,$database_conexion, $conexion);
}
}
else{
for($i=0;$i<$contador;$i++){
mysql_select_db($database_conexion, $conexion);
$query_item_costo = "SELECT * FROM meta WHERE idMeta='".$_POST['x_idMeta'][$i]."'";
$mostrar_itemCosto=mysql_query($query_item_costo, $conexion) or die(mysql_error());
$total_itemCosto=mysql_num_rows($mostrar_itemCosto);
if($total_itemCosto>0){
mysql_select_db($database_conexion, $conexion);
$query_item_costoupdate = "UPDATE meta SET meta='".$_POST['x_meta'][$i]."',metaAlcanzar='".$_POST['x_metaAlcanzar'][$i]."',cabecera='".$_POST['x_cabezera'][$i]."',archivoGeneral='".$_POST['x_archivoGeneral'][$i]."' WHERE idMeta='".$_POST['x_idMeta'][$i]."'";
mysql_query($query_item_costoupdate, $conexion) or die(mysql_error());
}else{
  mysql_select_db($database_conexion, $conexion);
$query_item_costoinsert = "INSERT INTO meta VALUES('','".$_POST['idCronograma']."','".$_POST['x_meta'][$i]."','".$_POST['x_metaAlcanzar'][$i]."','".$_POST['x_cabezera'][$i]."','".$_POST['x_archivoGeneral'][$i]."','1')";
mysql_query($query_item_costoinsert, $conexion) or die(mysql_error());
}
}
}
}
// Define page object
$cronograma_edit = new ccronograma_edit();
$Page =& $cronograma_edit;

// Page init processing
$cronograma_edit->Page_Init();

// Page main processing
if($_POST['btnAction']){
header("Location: cronogramalist.php?idConsultoria=".$_POST['idConsultoria']);
}
    else{
$cronograma_edit->Page_Main();
}
?>
<?php include "header.php" ?>
<script type="text/javascript">
var x;
x=$(document);
x.ready(inicializarEventos);
function inicializarEventos()
{
  var x,y;
    x=$("#indicadorAdd");
  x.click(anadirIndicadorFinal);
  //x=$("#indicadorDelete");
  //x.click(eliminarIndicadorFinal);
  // meta
  y=$("#metaAdd");
  y.click(anadirMetaFinal);
  //y=$("#metaDelete");
  //y.click(eliminarMetaFinal);

}
function anadirIndicadorFinal()
{
  var x,y;
  x=$("#x_tableIndicador");
  y=$("#x_tableIndicador tr");
 y=y.length+1;
 x.append("<tr id='tr_indicador"+y+"'><td><textarea name='x_indicador[]' id='x_indicador_"+y+"' rows='3' cols='45' class='required'></textarea></td><td><div><img src='images/delete.png' style='border: none; cursor: pointer' title='Eliminar Indicador' onclick='eliminarIndicadorFinal("+y+")'></div></td></tr>");

 }
function eliminarIndicadorFinal(n)
{
var agree=confirm("Est\u00e1 seguro de eliminar el Indicador.");
if (agree)
{var m=$("#tr_indicador"+n);
m.remove();}
else
{return false ;}
}
//metas
function anadirMetaFinal()
{
  var x,y;
  x=$("#x_tableMeta");
  y=$("#x_tableMeta tr");
 y=y.length+1;
 x.append("<tr id='tr_id"+y+"'><td><textarea name='x_meta[]' id='x_meta_"+y+"' rows='2' cols='40' class='required'></textarea></td><td><select name='x_cabezera[]' id='x_cabezera_"+y+"' title='Si es cabecera opcion SI' onchange='resultadoAlcanzar("+y+");'><option value='0'>NO</option><option value='1'>SI</option></select></td><td id='meta_"+y+"'><input type='text' name='x_metaAlcanzar[]' id='x_metaAlcanzar_"+y+"' value='100' size='4' title='% de cumplimiento de la meta'>%</td><td id='archivo_"+y+"'><select name='x_archivoGeneral[]' id='x_archivoGeneral_"+y+"' title='Seleccione SI si requiere un archivo por cada MERS'><option value='0'>NO</option><option value='1'>SI</option></select></td><td><div><img src='images/delete.png' style='border: none; cursor: pointer' title='Eliminar meta/resultado' onclick='eliminarMetaFinal("+y+")'></div></td></tr>");
}
function eliminarMetaFinal(n)
{
var agree=confirm("Est\u00e1 seguro de eliminar la meta. Perdera toda la informacion");
if (agree)
{var m=$("#tr_id"+n);
m.remove();}
else
{return false ;}
}
function resultadoAlcanzar(y){
    //alert(y);
  var cabecera=$("#x_cabezera_"+y).attr("value");
  var meta=$("#meta_"+y);
  var archivo=$("#archivo_"+y);
  if(cabecera=='1'){
      meta.hide();
      archivo.hide();
  }
  if(cabecera=='0'){
      meta.show();
      archivo.show();
  }
}
</script>
<script type="text/javascript">
<!--

// Create page object
var cronograma_edit = new ew_Page("cronograma_edit");

// page properties
cronograma_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = cronograma_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
cronograma_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_fechaInicio"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Inicio");
		elm = fobj.elements["x" + infix + "_fechaInicio"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Inicio");
		elm = fobj.elements["x" + infix + "_fechaFinal"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Final");
		elm = fobj.elements["x" + infix + "_fechaFinal"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Final");
		elm = fobj.elements["x" + infix + "_detalle"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Detalle");
		elm = fobj.elements["x" + infix + "_mesAnio"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Mes Anio");
		elm = fobj.elements["x" + infix + "_mesAnio"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd/mm/yyyy - Mes Anio");
		elm = fobj.elements["x" + infix + "_estado"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Estado");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
cronograma_edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cronograma_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cronograma_edit.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-1.css" title="win2k-1">
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script type="text/javascript">
<!--
var ew_DHTMLEditors = [];

//-->
</script>
<?php
//echo $_GET['idConsultoria'];
mysql_select_db($database_conexion, $conexion);
$query_consultoria= "SELECT a.idConsultoria, a.consultoria, a.fechaInicio, a.fechaFinal, b.paterno, b.materno,b.nombre FROM consultoria a, usuario b WHERE a.idConsultoria='".(int)$_GET['idConsultoria']."' AND a.idUsuario=b.idUsuario";
$mostrar_consultoria=mysql_query($query_consultoria, $conexion) or die(mysql_error());
$row_consultoria=mysql_fetch_assoc($mostrar_consultoria);
?>
<span class="phpmaker"><a href="<?php echo $cronograma->getReturnUrl() ?>">Volver atras</a></span>
<br>
<?php $cronograma_edit->ShowMessage() ?>
<fieldset>
    <legend>Proyecto: Promoviendo el Desarrollo Local y la Formacion de MERS</legend>
    <table>
        <tr>
            <td><div>Consultoria:</div></td><td colspan="7"><?php echo $row_consultoria['consultoria']?></td>
        </tr>
        <tr>
            <td><div>Responsable:</div></td><td><?php echo $row_consultoria['paterno']." ".$row_consultoria['materno'].", ".$row_consultoria['nombre']?></td>
            <td><div>Desde:</div></td><td><?php echo date("d-m-Y",strtotime($row_consultoria['fechaInicio']))?></td>
            <td><div>Hasta:</div></td><td><?php echo date("d-m-Y",strtotime($row_consultoria['fechaFinal']))?></td>
        </tr>

    </table>
</fieldset>
<?php
mysql_select_db($database_conexion, $conexion);
$query_regional= "SELECT a.idUC, a.idRegional, b.regional, count(a.idRegional) as numRegional FROM ubicacion_consultoria a, regional b, municipio c, mer d WHERE a.idConsultoria='".$_GET['idConsultoria']."' AND a.idRegional=b.idRegional AND a.idMunicipio=c.idMunicipio AND a.idMer=d.idMer GROUP BY a.idRegional ORDER BY b.regional asc, c.municipio asc, d.mer asc ";
$mostrar_regional=mysql_query($query_regional, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_municipio= "SELECT a.idUC, a.idMunicipio, c.municipio, count(a.idMunicipio) as numMunicipio FROM ubicacion_consultoria a, regional b, municipio c, mer d WHERE a.idConsultoria='".$_GET['idConsultoria']."' AND a.idRegional=b.idRegional AND a.idMunicipio=c.idMunicipio AND a.idMer=d.idMer GROUP BY a.idMunicipio ORDER BY b.regional asc, c.municipio asc, d.mer asc ";
$mostrar_municipio=mysql_query($query_municipio, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_totalmers= "SELECT count(idMer) as totalmers FROM ubicacion_consultoria WHERE idConsultoria='".$_GET['idConsultoria']."'";
$mostrar_totalmers=mysql_query($query_totalmers, $conexion) or die(mysql_error());
$row_totalmers=mysql_fetch_assoc($mostrar_totalmers);
?>
<form name="fcronogramaedit" id="fcronogramaedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return cronograma_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="cronograma">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="idCronograma" value="<?php echo $_GET['idCronograma']?>">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cronograma->idCronograma->Visible) { // idCronograma ?>
<input type="hidden" name="x_idCronograma" id="x_idCronograma" value="<?php echo ew_HtmlEncode($cronograma->idCronograma->CurrentValue) ?>">
<?php } ?>
<?php if ($cronograma->detalle->Visible) { // detalle ?>
	<tr<?php echo $cronograma->detalle->RowAttributes ?>>
		<td class="ewTableHeader">Hito<span class="ewRequired">&nbsp;*</span></td>
                <td<?php echo $cronograma->detalle->CellAttributes() ?> colspan="3"><span id="el_detalle">
<input type="text" name="x_detalle" id="x_detalle" size="45" maxlength="255" value="<?php echo $cronograma->detalle->EditValue ?>"<?php echo $cronograma->detalle->EditAttributes() ?>>
</span><?php echo $cronograma->detalle->CustomMsg ?></td>
                <td colspan="2">Regional</td>
<?php while($row_regional=mysql_fetch_assoc($mostrar_regional)) {?>
<td colspan="<?php echo $row_regional['numRegional']?>" align="center" style="font-size: 10pt;background: #75923C;color: white"><?php echo strtoupper($row_regional['regional'])?></td>
<?php } ?>
<td rowspan="3">Avance %</td>
	</tr>
<?php } ?>
<?php if ($cronograma->fechaInicio->Visible) { // fechaInicio ?>
	<tr<?php echo $cronograma->fechaInicio->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Inicio<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $cronograma->fechaInicio->CellAttributes() ?>><span id="el_fechaInicio">
<input type="text" name="x_fechaInicio" id="x_fechaInicio" value="<?php echo $cronograma->fechaInicio->EditValue ?>"<?php echo $cronograma->fechaInicio->EditAttributes() ?>>
&nbsp;<img src="images/calendar.png" id="cal_x_fechaInicio" name="cal_x_fechaInicio" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x_fechaInicio", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "cal_x_fechaInicio" // ID of the button
});
</script>
</span><?php echo $cronograma->fechaInicio->CustomMsg ?></td>
<td class="ewTableHeader">Fecha Final<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $cronograma->fechaFinal->CellAttributes() ?>><span id="el_fechaFinal">
<input type="text" name="x_fechaFinal" id="x_fechaFinal" value="<?php echo $cronograma->fechaFinal->EditValue ?>"<?php echo $cronograma->fechaFinal->EditAttributes() ?>>
&nbsp;<img src="images/calendar.png" id="cal_x_fechaFinal" name="cal_x_fechaFinal" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x_fechaFinal", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "cal_x_fechaFinal" // ID of the button
});
</script>
</span><?php echo $cronograma->fechaFinal->CustomMsg ?></td>
<td colspan="2">Municipio(s)</td>
<?php while($row_municipio=mysql_fetch_assoc($mostrar_municipio)){?>
<td colspan="<?php echo $row_municipio['numMunicipio']?>" style="font-size: 8pt;background: #C2D69A;text-align: center;border-color: #ffffff"><?php echo $row_municipio['municipio']?></td>
<?php }?>
	</tr>
<?php } ?>
<?php if ($cronograma->mesAnio->Visible) { // mesAnio ?>
        <input type="hidden" name="x_mesAnio" id="x_mesAnio" value="<?php echo $cronograma->mesAnio->EditValue ?>"<?php echo $cronograma->mesAnio->EditAttributes() ?>>
<?php } ?>
<?php if ($cronograma->estado->Visible) { // estado ?>
        <input type="hidden" name="x_estado" id="x_estado" value="<?php echo strval($cronograma->estado->CurrentValue)?>">
<?php } ?>
        <tr class="ewTableHeader">
    <td>No</td>
    <td style="background: #9df9c1;text-align: center">DESCRIPCION DE RESULTADOS DEL HITO</td>
    <td style="background: #9df9c1;text-align: center">
        <div><img src="images/add.png" style="border: none; cursor: pointer" id="indicadorAdd" title="Agregar Indicador"></div>
    </td>
    <td style="background: #9dfb98;text-align: center">META</td>
    <td style="background: #9dfb98;text-align: center">Meta Alcanzar</td>
<td style="background: #9dfb98;text-align: center">
<div><img src="images/add.png" style="border: none; cursor: pointer" id="metaAdd" title="Agregar meta/resultado"></div>
    </td>
 <?php
 $mostrar_municipio=mysql_query($query_municipio, $conexion) or die(mysql_error());
 while($row_municipio=mysql_fetch_assoc($mostrar_municipio)){
mysql_select_db($database_conexion, $conexion);
$query_mers= "SELECT a.idMer, b.mer FROM ubicacion_consultoria a, mer b WHERE a.idConsultoria='".$_GET['idConsultoria']."' AND a.idMunicipio='".$row_municipio['idMunicipio']."' AND a.idMer=b.idMer ORDER BY mer asc";
$mostrar_mers=mysql_query($query_mers, $conexion) or die(mysql_error());
while($row_mers=mysql_fetch_assoc($mostrar_mers)){
?>
<td style="font-size: 8.5px;background: #EAF1DD"><?php echo $row_mers['mer']?></td>
<?php } }?>
</tr>
<?php 
mysql_select_db($database_conexion, $conexion);
$query_indicador= "SELECT * FROM indicador WHERE idCronograma='".$_GET['idCronograma']."' ORDER BY idIndicador asc";
$mostrar_indicador=mysql_query($query_indicador, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_resultado= "SELECT * FROM meta WHERE idCronograma='".$_GET['idCronograma']."' ORDER BY idMeta asc";
$mostrar_resultado=mysql_query($query_resultado, $conexion) or die(mysql_error());
?>
<tr>
    <td></td>
    <td colspan="2">
        <table id="x_tableIndicador">
<?php
$contador=1;
while($row_indicador=mysql_fetch_assoc($mostrar_indicador)){?>
            
            <tr id="tr_indicador<?php echo $contador?>">
                <input type="hidden" name="x_idIndicador[]" id="x_idIndicador_<?php echo $contador?>" value="<?php echo $row_indicador['idIndicador']?>">
                <td><textarea name='x_indicador[]' id='x_indicador_<?php echo $contador?>' rows='3' cols='45' class='required'><?php echo $row_indicador['indicador']?></textarea></td>
                <td><div><img src="images/delete.png" style="border: none; cursor: pointer" id="indicadorDelete" title="Eliminar Indicador" onclick="eliminarIndicadorFinal(<?php echo $contador?>)"></div></td>
            </tr>   
<?php 
$contador++;
} ?>
        </table>
    </td>
    <td colspan="3">
        <table id="x_tableMeta">
<?php
$cont=1;
while($row_resultado=mysql_fetch_assoc($mostrar_resultado)){?>
            <tr id="tr_id<?php echo $cont?>">
                <input type="hidden" name="x_idMeta[]" id="x_idMeta_<?php echo $cont?>" value="<?php echo $row_resultado['idMeta']?>">
                <td><textarea name='x_meta[]' id='x_meta_<?php echo $cont?>' rows='3' cols='45' class='required'><?php echo $row_resultado['meta']?></textarea></td>
                <td><select name="x_cabezera[]" id="x_cabezera_<?php echo $cont?>" title="Si es cabecera opcion SI" onchange="resultadoAlcanzar(<?php echo $cont?>);">
                        <option value="0" <?php if($row_resultado['cabecera']=='0'){ echo "selected";}?>>NO</option>
                        <option value="1" <?php if($row_resultado['cabecera']=='1'){ echo "selected";}?>>SI</option>
                    </select></td>
                    <td id="meta_<?php echo $cont?>"><input type="text" name="x_metaAlcanzar[]" id="x_metaAlcanzar_<?php echo $cont?>" size="5" value="<?php echo $row_resultado['metaAlcanzar']?>">%</td>
                    <td id="archivo_<?php echo $cont?>"><select name="x_archivoGeneral[]" id="x_archivoGeneral_<?php echo $cont?>" title="Seleccione SI si requiere un archivo por cada MERS" onchange="resultadoAlcanzar(<?php echo $cont?>);">
                        <option value="0" <?php if($row_resultado['archivoGeneral']=='0'){ echo "selected";}?>>NO</option>
                        <option value="1" <?php if($row_resultado['archivoGeneral']=='1'){ echo "selected";}?>>SI</option>
                    </select></td>
                    <td><div><img src="images/delete.png" style="border: none; cursor: pointer" id="metaDelete" title="Eliminar meta/resultado" onclick="eliminarMetaFinal(<?php echo $cont?>)"></div></td>
            </tr>
<script language="JavaScript" type="text/javascript">
resultadoAlcanzar(<?php echo $cont?>);
</script>
                    <?php $cont++;} ?>
        </table>
    </td>
    <td colspan="<?php echo $row_totalmers['totalmers']?>">&nbsp;</td>
    <td></td>
</tr>
</table>
</div>
</td></tr></table>
<p>
<input type="hidden" name="idConsultoria" value="<?php echo $_GET['idConsultoria']?>">
<input type="submit" name="btnAction" id="btnAction" value="  GUARDAR  ">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class ccronograma_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'cronograma';

	// Page Object Name
	var $PageObjName = 'cronograma_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cronograma;
		if ($cronograma->UseTokenInUrl) $PageUrl .= "t=" . $cronograma->TableVar . "&"; // add page token
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
		global $objForm, $cronograma;
		if ($cronograma->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($cronograma->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cronograma->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccronograma_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["cronograma"] = new ccronograma();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cronograma', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $cronograma;
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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("cronogramalist.php");
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

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $cronograma;

		// Load key from QueryString
		if (@$_GET["idCronograma"] <> "")
			$cronograma->idCronograma->setQueryStringValue($_GET["idCronograma"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$cronograma->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$cronograma->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$cronograma->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($cronograma->idCronograma->CurrentValue == "")
			$this->Page_Terminate("cronogramalist.php"); // Invalid key, return to list
		switch ($cronograma->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No se encontraron registros"); // No record found
					$this->Page_Terminate("cronogramalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$cronograma->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Update success
					$sReturnUrl = $cronograma->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$cronograma->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $cronograma;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $cronograma;
		$cronograma->idCronograma->setFormValue($objForm->GetValue("x_idCronograma"));
		$cronograma->fechaInicio->setFormValue($objForm->GetValue("x_fechaInicio"));
		$cronograma->fechaInicio->CurrentValue = ew_UnFormatDateTime($cronograma->fechaInicio->CurrentValue, 7);
		$cronograma->fechaFinal->setFormValue($objForm->GetValue("x_fechaFinal"));
		$cronograma->fechaFinal->CurrentValue = ew_UnFormatDateTime($cronograma->fechaFinal->CurrentValue, 7);
		$cronograma->detalle->setFormValue($objForm->GetValue("x_detalle"));
		$cronograma->mesAnio->setFormValue($objForm->GetValue("x_mesAnio"));
		$cronograma->mesAnio->CurrentValue = ew_UnFormatDateTime($cronograma->mesAnio->CurrentValue, 7);
		$cronograma->estado->setFormValue($objForm->GetValue("x_estado"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $cronograma;
		$this->LoadRow();
		$cronograma->idCronograma->CurrentValue = $cronograma->idCronograma->FormValue;
		$cronograma->fechaInicio->CurrentValue = $cronograma->fechaInicio->FormValue;
		$cronograma->fechaInicio->CurrentValue = ew_UnFormatDateTime($cronograma->fechaInicio->CurrentValue, 7);
		$cronograma->fechaFinal->CurrentValue = $cronograma->fechaFinal->FormValue;
		$cronograma->fechaFinal->CurrentValue = ew_UnFormatDateTime($cronograma->fechaFinal->CurrentValue, 7);
		$cronograma->detalle->CurrentValue = $cronograma->detalle->FormValue;
		$cronograma->mesAnio->CurrentValue = $cronograma->mesAnio->FormValue;
		$cronograma->mesAnio->CurrentValue = ew_UnFormatDateTime($cronograma->mesAnio->CurrentValue, 7);
		$cronograma->estado->CurrentValue = $cronograma->estado->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cronograma;
		$sFilter = $cronograma->KeyFilter();

		// Call Row Selecting event
		$cronograma->Row_Selecting($sFilter);

		// Load sql based on filter
		$cronograma->CurrentFilter = $sFilter;
		$sSql = $cronograma->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$cronograma->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $cronograma;
		$cronograma->idCronograma->setDbValue($rs->fields('idCronograma'));
		$cronograma->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$cronograma->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$cronograma->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$cronograma->detalle->setDbValue($rs->fields('detalle'));
		$cronograma->mesAnio->setDbValue($rs->fields('mesAnio'));
		$cronograma->estado->setDbValue($rs->fields('estado'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $cronograma;

		// Call Row_Rendering event
		$cronograma->Row_Rendering();

		// Common render codes for all row types
		// idCronograma

		$cronograma->idCronograma->CellCssStyle = "";
		$cronograma->idCronograma->CellCssClass = "";

		// fechaInicio
		$cronograma->fechaInicio->CellCssStyle = "";
		$cronograma->fechaInicio->CellCssClass = "";

		// fechaFinal
		$cronograma->fechaFinal->CellCssStyle = "";
		$cronograma->fechaFinal->CellCssClass = "";

		// detalle
		$cronograma->detalle->CellCssStyle = "";
		$cronograma->detalle->CellCssClass = "";

		// mesAnio
		$cronograma->mesAnio->CellCssStyle = "";
		$cronograma->mesAnio->CellCssClass = "";

		// estado
		$cronograma->estado->CellCssStyle = "";
		$cronograma->estado->CellCssClass = "";
		if ($cronograma->RowType == EW_ROWTYPE_VIEW) { // View row

			// idCronograma
			$cronograma->idCronograma->ViewValue = $cronograma->idCronograma->CurrentValue;
			$cronograma->idCronograma->CssStyle = "";
			$cronograma->idCronograma->CssClass = "";
			$cronograma->idCronograma->ViewCustomAttributes = "";

			// idConsultoria
			$cronograma->idConsultoria->ViewValue = $cronograma->idConsultoria->CurrentValue;
			$cronograma->idConsultoria->CssStyle = "";
			$cronograma->idConsultoria->CssClass = "";
			$cronograma->idConsultoria->ViewCustomAttributes = "";

			// fechaInicio
			$cronograma->fechaInicio->ViewValue = $cronograma->fechaInicio->CurrentValue;
			$cronograma->fechaInicio->ViewValue = ew_FormatDateTime($cronograma->fechaInicio->ViewValue, 7);
			$cronograma->fechaInicio->CssStyle = "";
			$cronograma->fechaInicio->CssClass = "";
			$cronograma->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$cronograma->fechaFinal->ViewValue = $cronograma->fechaFinal->CurrentValue;
			$cronograma->fechaFinal->ViewValue = ew_FormatDateTime($cronograma->fechaFinal->ViewValue, 7);
			$cronograma->fechaFinal->CssStyle = "";
			$cronograma->fechaFinal->CssClass = "";
			$cronograma->fechaFinal->ViewCustomAttributes = "";

			// detalle
			$cronograma->detalle->ViewValue = $cronograma->detalle->CurrentValue;
			$cronograma->detalle->CssStyle = "";
			$cronograma->detalle->CssClass = "";
			$cronograma->detalle->ViewCustomAttributes = "";

			// mesAnio
			$cronograma->mesAnio->ViewValue = $cronograma->mesAnio->CurrentValue;
			$cronograma->mesAnio->ViewValue = ew_FormatDateTime($cronograma->mesAnio->ViewValue, 7);
			$cronograma->mesAnio->CssStyle = "";
			$cronograma->mesAnio->CssClass = "";
			$cronograma->mesAnio->ViewCustomAttributes = "";

			// estado
			if (strval($cronograma->estado->CurrentValue) <> "") {
				switch ($cronograma->estado->CurrentValue) {
					case "1":
						$cronograma->estado->ViewValue = "Habilitado";
						break;
					case "2":
						$cronograma->estado->ViewValue = "Desabilitado";
						break;
					case "3":
						$cronograma->estado->ViewValue = "Aprobado";
						break;
					default:
						$cronograma->estado->ViewValue = $cronograma->estado->CurrentValue;
				}
			} else {
				$cronograma->estado->ViewValue = NULL;
			}
			$cronograma->estado->CssStyle = "";
			$cronograma->estado->CssClass = "";
			$cronograma->estado->ViewCustomAttributes = "";

			// idCronograma
			$cronograma->idCronograma->HrefValue = "";

			// fechaInicio
			$cronograma->fechaInicio->HrefValue = "";

			// fechaFinal
			$cronograma->fechaFinal->HrefValue = "";

			// detalle
			$cronograma->detalle->HrefValue = "";

			// mesAnio
			$cronograma->mesAnio->HrefValue = "";

			// estado
			$cronograma->estado->HrefValue = "";
		} elseif ($cronograma->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idCronograma
			$cronograma->idCronograma->EditCustomAttributes = "";
			$cronograma->idCronograma->EditValue = $cronograma->idCronograma->CurrentValue;
			$cronograma->idCronograma->CssStyle = "";
			$cronograma->idCronograma->CssClass = "";
			$cronograma->idCronograma->ViewCustomAttributes = "";

			// fechaInicio
			$cronograma->fechaInicio->EditCustomAttributes = "";
			$cronograma->fechaInicio->EditValue = ew_HtmlEncode(ew_FormatDateTime($cronograma->fechaInicio->CurrentValue, 7));

			// fechaFinal
			$cronograma->fechaFinal->EditCustomAttributes = "";
			$cronograma->fechaFinal->EditValue = ew_HtmlEncode(ew_FormatDateTime($cronograma->fechaFinal->CurrentValue, 7));

			// detalle
			$cronograma->detalle->EditCustomAttributes = "";
			$cronograma->detalle->EditValue = ew_HtmlEncode($cronograma->detalle->CurrentValue);

			// mesAnio
			$cronograma->mesAnio->EditCustomAttributes = "";
			$cronograma->mesAnio->EditValue = ew_HtmlEncode(ew_FormatDateTime($cronograma->mesAnio->CurrentValue, 7));

			// estado
			$cronograma->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("1", "Habilitado");
			$arwrk[] = array("2", "Desabilitado");
			$arwrk[] = array("3", "Aprobado");
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$cronograma->estado->EditValue = $arwrk;

			// Edit refer script
			// idCronograma

			$cronograma->idCronograma->HrefValue = "";

			// fechaInicio
			$cronograma->fechaInicio->HrefValue = "";

			// fechaFinal
			$cronograma->fechaFinal->HrefValue = "";

			// detalle
			$cronograma->detalle->HrefValue = "";

			// mesAnio
			$cronograma->mesAnio->HrefValue = "";

			// estado
			$cronograma->estado->HrefValue = "";
		}

		// Call Row Rendered event
		$cronograma->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $cronograma;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($cronograma->fechaInicio->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Inicio";
		}
		if (!ew_CheckEuroDate($cronograma->fechaInicio->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Inicio";
		}
		if ($cronograma->fechaFinal->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Final";
		}
		if (!ew_CheckEuroDate($cronograma->fechaFinal->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Final";
		}
		if ($cronograma->detalle->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Detalle";
		}
		if ($cronograma->mesAnio->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Mes Anio";
		}
		if (!ew_CheckEuroDate($cronograma->mesAnio->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Mes Anio";
		}
		if ($cronograma->estado->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Estado";
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $cronograma;
		$sFilter = $cronograma->KeyFilter();
		$cronograma->CurrentFilter = $sFilter;
		$sSql = $cronograma->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// Field idCronograma
			// Field fechaInicio

			$cronograma->fechaInicio->SetDbValueDef(ew_UnFormatDateTime($cronograma->fechaInicio->CurrentValue, 7), ew_CurrentDate());
			$rsnew['fechaInicio'] =& $cronograma->fechaInicio->DbValue;

			// Field fechaFinal
			$cronograma->fechaFinal->SetDbValueDef(ew_UnFormatDateTime($cronograma->fechaFinal->CurrentValue, 7), ew_CurrentDate());
			$rsnew['fechaFinal'] =& $cronograma->fechaFinal->DbValue;

			// Field detalle
			$cronograma->detalle->SetDbValueDef($cronograma->detalle->CurrentValue, "");
			$rsnew['detalle'] =& $cronograma->detalle->DbValue;

			// Field mesAnio
			$cronograma->mesAnio->SetDbValueDef(ew_UnFormatDateTime($cronograma->mesAnio->CurrentValue, 7), ew_CurrentDate());
			$rsnew['mesAnio'] =& $cronograma->mesAnio->DbValue;

			// Field estado
			$cronograma->estado->SetDbValueDef($cronograma->estado->CurrentValue, 0);
			$rsnew['estado'] =& $cronograma->estado->DbValue;

			// Call Row Updating event
			$bUpdateRow = $cronograma->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($cronograma->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($cronograma->CancelMessage <> "") {
					$this->setMessage($cronograma->CancelMessage);
					$cronograma->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$cronograma->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
