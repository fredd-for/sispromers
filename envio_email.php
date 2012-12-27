<?php
//session_start();
//if($_SESSION['session_gerente_acceso'] != "iniSession_gerente") {
//    header("Location: ../index.php");
//}
?>
<?php require_once('Connections/conexion.php'); ?>
<?php require("phpmailer/class.phpmailer.php"); //Importamos la función PHP class.phpmailer ?>
<?php
$servidor="mailhost.fhi.net";
if($_GET['sw']=='desabilitar'){
// envio de emails de forma automatica a el administrador y al gerente
$mensaje="Se ha reportado correctamente";
mysql_select_db($database_conexion, $conexion);
$query_historialArchivoedit = "UPDATE historial_archivo SET informe=1, fechaInforme='".date("Y-m-d")."' WHERE idMer='".$row_cabezeramer['idMer']."' AND informe=0";
mysql_query($query_historialArchivoedit, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_historialContratoedit = "UPDATE historial_contrato SET informe=1, fechaInforme='".date("Y-m-d")."' WHERE idMer='".$row_cabezeramer['idMer']."' AND informe=0";
mysql_query($query_historialContratoedit, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_historialFormularioedit = "UPDATE historial_formulario SET informe=1, fechaInforme='".date("Y-m-d")."' WHERE idMer='".$row_cabezeramer['idMer']."' AND informe=0";
mysql_query($query_historialFormularioedit, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_merdes = "UPDATE mer SET estado='2', fechaModificacion='".date("Y-m-d")."' WHERE idMer = '".(int)$_GET['x_idMer']."'";
mysql_query($query_merdes, $conexion) or die(mysql_error());

}
if($_GET['sw']=='desabilitar'){
    $x_idPlanilla=$_GET['x_idPlanilla'];
    $x_idMer=$_GET['x_idMer'];
}else {$x_idPlanilla=$_POST['x_idPlanilla'];
    $x_idMer=$_POST['x_idMer'];
}
header("Location: formulariolist.php?idMer=".$x_idMer."&idPlanilla=".$x_idPlanilla."");
?>
