<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "formularioinfo.php" ?>
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

// Define page object
$formulario_list = new cformulario_list();
$Page =& $formulario_list;

// Page init processing
$formulario_list->Page_Init();

// Page main processing
$formulario_list->Page_Main();
?>
<?php
//if($_POST['idPlanilla']==1) {
//Actualizar tabla formulario
$historial=1;           // 1= historial detallado; 2=primer y ultimo cambio
$status = "";
if ($_POST["guardar_pregunta"] == "GUARDAR") {
    // obtenemos los datos del archivo
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = (int)$_POST['x_idMer']."_".(int)$_POST['x_idPlanilla']."_".$_FILES["archivo"]['name'];
    // guardamos el archivo a la carpeta files
        $destino =  "files/".$archivo;
        if (copy($_FILES['archivo']['tmp_name'],$destino)) {
//            if($_POST['archivoDelete'])
//            {unlink("files/".$_POST['archivoDelete']);}
            $fecha=date("Y-m-d");
    mysql_select_db($database_conexion, $conexion);
            $query_archivoadd = "INSERT INTO archivo VALUES('','".(int)$_POST['x_idMer']."','".(int)$_POST['x_idPlanilla']."','$archivo','$fecha')";
             mysql_query($query_archivoadd, $conexion) or die(mysql_error());
            $status = "Archivo subido: <b>".$archivo."</b>";

// historila de archivos
if($historial==1){
mysql_select_db($database_conexion, $conexion);
$query_maxArchivo = "SELECT max(idArchivo) as idArchivo FROM archivo";
$mostrar_maxArchivo=mysql_query($query_maxArchivo, $conexion) or die(mysql_error());
$row_maxArchivo=mysql_fetch_assoc($mostrar_maxArchivo);

mysql_select_db($database_conexion, $conexion);
$query_historialContrato = "INSERT INTO historial_archivo (estado,fecha,idGerente,idArchivo,idMer,idPlanilla,archivo)SELECT 'Adicionar', '".date("Y-m-d H:i:s")."', '".(int)$_SESSION['idUsuario']."', idArchivo, idMer,idPlanilla,archivo FROM archivo WHERE idArchivo='".$row_maxArchivo['idArchivo']."'";
mysql_query($query_historialContrato, $conexion) or die(mysql_error());
}
        } else {$status = "Error al subir el archivosaa";}
    mysql_select_db($database_conexion, $conexion);
    $query_formulario = "UPDATE formulario SET cuenta='".$_POST['check_list']."', porcentaje='".$_POST['check_list_porcentaje']."', observacion='".$_POST['x_observacion']."' WHERE idMer = '".(int)$_POST['x_idMer']."' AND idPlanilla = '".(int)$_POST['x_idPlanilla']."'";
    mysql_query($query_formulario, $conexion) or die(mysql_error());

// historial de formularios
if($historial==1){
mysql_select_db($database_conexion, $conexion);
$query_historialFormulario = "INSERT INTO historial_formulario (fecha,idGerente,idFormulario,idMer,idPlanilla,archivo,cuenta,porcentaje,observacion)SELECT '".date("Y-m-d H:i:s")."', '".(int)$_SESSION['idUsuario']."', idFormulario, idMer,idPlanilla,archivo,cuenta,porcentaje,observacion FROM formulario WHERE idMer = '".(int)$_POST['x_idMer']."' AND idPlanilla = '".(int)$_POST['x_idPlanilla']."'";
mysql_query($query_historialFormulario, $conexion) or die(mysql_error());
}
}
// borrar archivo de la base de datos y dela carpeta files
if($_GET['sw']=='archivodelete'){
if($historial==1){
mysql_select_db($database_conexion, $conexion);
$query_historialContrato = "INSERT INTO historial_archivo (estado,fecha,idGerente,idArchivo,idMer,idPlanilla,archivo)SELECT 'Eliminar', '".date("Y-m-d H:i:s")."', '".(int)$_SESSION['idUsuario']."', idArchivo, idMer,idPlanilla,archivo FROM archivo WHERE idArchivo='".$_GET['x_idArchivo']."'";
mysql_query($query_historialContrato, $conexion) or die(mysql_error());        
    }
    unlink("files/".$_GET['archivo']);
    mysql_select_db($database_conexion, $conexion);
    $query_archivodelete = "DELETE FROM archivo WHERE idArchivo='".$_GET['x_idArchivo']."'";
    mysql_query($query_archivodelete, $conexion) or die(mysql_error());
}
if($_POST['sw']=='contratoadd') {
// actuallizar tabla tipo_contrato_llenar
    if($_POST['x_fechaInicio']){
    $fechaExplode=explode("-", $_POST['x_fechaInicio']);
    $fechaInicio= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaInicio='';}
    if($_POST['x_fechaFinal']){
    $fechaExplode=explode("-", $_POST['x_fechaFinal']);
    $fechaFinal= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaFinal='';}
    mysql_select_db($database_conexion, $conexion);
    $query_contratoLlenar = "INSERT INTO contrato_llenar VALUES ('','".(int)$_POST['x_idMer']."','".(int)$_POST['x_idPlanilla']."','".(int)$_POST['x_nroContrato']."','".(int)$_POST['x_idTipoContrato']."','".(int)$_POST['x_idRegistroContrato']."','$fechaInicio','$fechaFinal','".$_POST['x_valor']."','".$_POST['x_completo']."','".$_POST['x_certConformidad']."')";
    mysql_query($query_contratoLlenar, $conexion) or die(mysql_error());

// historial de contrato
if($historial==1){
mysql_select_db($database_conexion, $conexion);
$query_maxContrato = "SELECT max(idCL) as idCL FROM contrato_llenar";
$mostrar_maxContrato=mysql_query($query_maxContrato, $conexion) or die(mysql_error());
$row_maxContrato=mysql_fetch_assoc($mostrar_maxContrato);
for($i=0;$i<=$_POST['totalPregunta'];$i++){
mysql_select_db($database_conexion, $conexion);
$query_preguntaRespuesta= "INSERT INTO pregunta_respuesta VALUES('','".(int)$_POST['x_idMer']."','".(int)$_POST['x_idPlanilla']."','".$row_maxContrato['idCL']."','".$_POST['pregunta_'.$i]."','".$_POST['resp_'.$i]."','','','')";
mysql_query($query_preguntaRespuesta, $conexion) or die(mysql_error());
}
mysql_select_db($database_conexion, $conexion);
$query_historialContrato = "INSERT INTO historial_contrato (estado,fecha,idGerente,idCL,idMer,idPlanilla,nroContrato,idTipoContrato,idRegistroContrato, fechaInicio, fechaFinal, valor, completo, certConformidad)SELECT 'Adicionar', '".date("Y-m-d H:i:s")."', '".(int)$_SESSION['idUsuario']."', idCL, idMer,idPlanilla,nroContrato,idTipoContrato,idRegistroContrato, fechaInicio, fechaFinal, valor, completo, certConformidad FROM contrato_llenar WHERE idCL='".$row_maxContrato['idCL']."'";
mysql_query($query_historialContrato, $conexion) or die(mysql_error());
}
}
if($_POST['sw']=='registroadd17') {
// actuallizar tabla tipo_contrato_llenar
    if($_POST['x_fecha']){
    $fechaExplode=explode("-", $_POST['x_fecha']);
    $fecha= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fecha='';}
    mysql_select_db($database_conexion, $conexion);
    $query_registroVentas = "INSERT INTO registroventas17 VALUES ('','".(int)$_POST['x_idMer']."','".(int)$_POST['x_idPlanilla']."','".(int)$_POST['x_nro']."','".$_POST['x_tipo']."','".$_POST['x_nombreComprador']."','".$_POST['x_detalle']."','".$_POST['x_precioUnitario']."','".$_POST['x_cantidad']."','".$_POST['x_valor']."','$fecha','".$_POST['x_cumple']."')";
    mysql_query($query_registroVentas, $conexion) or die(mysql_error());
}
if($_POST['sw']=='contratoedit') {
// actuallizar tabla tipo_contrato_llenar
    if($_POST['x_fechaInicio']){
    $fechaExplode=explode("-", $_POST['x_fechaInicio']);
    $fechaInicio= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaInicio='';}
    if($_POST['x_fechaFinal']){
    $fechaExplode=explode("-", $_POST['x_fechaFinal']);
    $fechaFinal= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaFinal='';}
    mysql_select_db($database_conexion, $conexion);
    $query_contratoLlenar = "UPDATE contrato_llenar SET idMer='".(int)$_POST['x_idMer']."', idPlanilla='".(int)$_POST['x_idPlanilla']."', nroContrato='".(int)$_POST['x_nroContrato']."', idTipoContrato='".(int)$_POST['x_idTipoContrato']."', idRegistroContrato='".(int)$_POST['x_idRegistroContrato']."', fechaInicio='$fechaInicio', fechaFinal='$fechaFinal', valor='".$_POST['x_valor']."', completo='".$_POST['x_completo']."',certConformidad='".$_POST['x_certConformidad']."' WHERE idCL='".(int)$_POST['x_idCL']."'";
    mysql_query($query_contratoLlenar, $conexion) or die(mysql_error());
//actualizar checklist

mysql_select_db($database_conexion, $conexion);
    $query_preguntaRespuesta = "SELECT a.* FROM pregunta_respuesta a WHERE a.idMer='".(int)$_POST['x_idMer']."' AND a.idPlanilla='".(int)$_POST['x_idPlanilla']."' AND a.idCL='".(int)$_POST['x_idCL']."' AND a.idPregunta>0";
    $mostrar_preguntaRespuesta= mysql_query($query_preguntaRespuesta, $conexion) or die(mysql_error());
    $row_preguntaRespuesta= mysql_fetch_assoc($mostrar_preguntaRespuesta);
    $totalRows_preguntaRespuesta= mysql_num_rows($mostrar_preguntaRespuesta);
    if($totalRows_preguntaRespuesta > 0) {
        $cont_preguntaRespuesta=1;
        do {
            mysql_select_db($database_conexion, $conexion);
            $query_actualizar_preguntaRespuesta= "UPDATE pregunta_respuesta SET respuesta = '".$_POST["resp_".$cont_preguntaRespuesta]."' WHERE idMer='".(int)$_POST['x_idMer']."' AND idPlanilla='".(int)$_POST['x_idPlanilla']."' AND idCL='".(int)$_POST['x_idCL']."' AND idPregunta='".(int)$row_preguntaRespuesta['idPregunta']."'";
            mysql_query($query_actualizar_preguntaRespuesta, $conexion) or die(mysql_error());
            $cont_preguntaRespuesta++;
        } while ($row_preguntaRespuesta= mysql_fetch_assoc($mostrar_preguntaRespuesta));
    }
    // historial de contrato edit
if($historial==1){
mysql_select_db($database_conexion, $conexion);
$query_historialContrato = "INSERT INTO historial_contrato (estado,fecha,idGerente,idCL,idMer,idPlanilla,nroContrato,idTipoContrato,idRegistroContrato, fechaInicio, fechaFinal, valor, completo, certConformidad)SELECT 'Editar', '".date("Y-m-d H:i:s")."', '".(int)$_SESSION['idUsuario']."', idCL, idMer,idPlanilla,nroContrato,idTipoContrato,idRegistroContrato, fechaInicio, fechaFinal, valor, completo, certConformidad FROM contrato_llenar WHERE idCL='".(int)$_POST['x_idCL']."'";
mysql_query($query_historialContrato, $conexion) or die(mysql_error());
}
}
if($_POST['sw']=='registroedit17') {
// actuallizar tabla tipo_contrato_llenar
    if($_POST['x_fecha']){
    $fechaExplode=explode("-", $_POST['x_fecha']);
    $fecha= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fecha='';}
    mysql_select_db($database_conexion, $conexion);
    $query_registroVentas = "UPDATE registroventas17 SET idMer='".(int)$_POST['x_idMer']."', idPlanilla='".(int)$_POST['x_idPlanilla']."', nro='".(int)$_POST['x_nro']."', tipo='".$_POST['x_tipo']."', nombreComprador='".$_POST['x_nombreComprador']."', detalle='".$_POST['x_detalle']."', precioUnitario='".$_POST['x_precioUnitario']."', cantidad='".$_POST['x_cantidad']."', valor='".$_POST['x_valor']."', fecha='$fecha', cumple='".$_POST['x_cumple']."' WHERE idRegistroVentas='".(int)$_POST['x_idRegistroVentas']."'";
    mysql_query($query_registroVentas, $conexion) or die(mysql_error());
}
//// actuallizar tabla pregunta_respuesta
if($_GET['sw']=='contratodelete'){
// historial de contrato delete
if($historial==1){
mysql_select_db($database_conexion, $conexion);
$query_historialContrato = "INSERT INTO historial_contrato (estado,fecha,idGerente,idCL,idMer,idPlanilla,nroContrato,idTipoContrato,idRegistroContrato, fechaInicio, fechaFinal, valor, completo, certConformidad)SELECT 'Eliminar', '".date("Y-m-d H:i:s")."', '".(int)$_SESSION['idUsuario']."', idCL, idMer,idPlanilla,nroContrato,idTipoContrato,idRegistroContrato, fechaInicio, fechaFinal, valor, completo, certConformidad FROM contrato_llenar WHERE idCL='".$_GET['x_idCL']."'";
mysql_query($query_historialContrato, $conexion) or die(mysql_error());
}

mysql_select_db($database_conexion, $conexion);
$query_contratoLlenar = "DELETE FROM contrato_llenar WHERE idCL='".$_GET['x_idCL']."'";
 mysql_query($query_contratoLlenar, $conexion) or die(mysql_error());

 mysql_select_db($database_conexion, $conexion);
$query_preguntaRespuestadelete = "DELETE FROM pregunta_respuesta WHERE idCL='".$_GET['x_idCL']."'";
 mysql_query($query_preguntaRespuestadelete, $conexion) or die(mysql_error());

}
if($_GET['sw']=='registrodelete17'){
mysql_select_db($database_conexion, $conexion);
$query_registroVentas = "DELETE FROM registroventas17 WHERE idRegistroVentas='".$_GET['x_idRegistroVentas']."'";
 mysql_query($query_registroVentas, $conexion) or die(mysql_error());
}
//operaciones de obtencion de credito planilla 16
if($_POST['sw']=='obtencionCreditoadd') {
// actuallizar tabla tipo_contrato_llenar
    if($_POST['x_fechaUltimoRecibo']){
    $fechaExplode=explode("-", $_POST['x_fechaUltimoRecibo']);
    $fecha= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fecha='';}
    mysql_select_db($database_conexion, $conexion);
    $query_obtencionCredito= "INSERT INTO obtencion_credito16 VALUES ('','".(int)$_POST['x_idMer']."','".(int)$_POST['x_idPlanilla']."','".$_POST['x_solicitud']."','".$_POST['x_entidadFinanciera']."','".$_POST['x_prestamo']."','".$_POST['x_montoSolicitado']."','".$_POST['x_mora']."','$fecha')";
    mysql_query($query_obtencionCredito, $conexion) or die(mysql_error());
}
if($_POST['sw']=='obtencionCreditoedit') {
// actuallizar tabla tipo_contrato_llenar
    if($_POST['x_fechaUltimoRecibo']){
    $fechaExplode=explode("-", $_POST['x_fechaUltimoRecibo']);
    $fecha= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fecha='';}
    mysql_select_db($database_conexion, $conexion);
    $query_obtencionCredito = "UPDATE obtencion_credito16 SET idMer='".(int)$_POST['x_idMer']."', idPlanilla='".(int)$_POST['x_idPlanilla']."', solicitud='".$_POST['x_solicitud']."', entidadFinanciera='".$_POST['x_entidadFinanciera']."', prestamo='".$_POST['x_prestamo']."', montoSolicitado='".$_POST['x_montoSolicitado']."', mora='".$_POST['x_mora']."', fechaUltimoRecibo='$fecha' WHERE idObtencionCredito='".(int)$_POST['x_idObtencionCredito']."'";
    mysql_query($query_obtencionCredito, $conexion) or die(mysql_error());
}
if($_GET['sw']=='obtencionCreditodelete'){
mysql_select_db($database_conexion, $conexion);
$query_obtencionCredito = "DELETE FROM obtencion_credito16 WHERE idObtencionCredito='".$_GET['x_idObtencionCredito']."'";
 mysql_query($query_obtencionCredito, $conexion) or die(mysql_error());
}
if($_POST['x_idPlanilla']!=1 && $_POST['x_idPlanilla']!=15){
if($_POST['guardar_pregunta']) {
    mysql_select_db($database_conexion, $conexion);
    $query_preguntaRespuesta = "SELECT a.* FROM pregunta_respuesta a WHERE a.idMer='".(int)$_POST['x_idMer']."' AND a.idPlanilla='".(int)$_POST['x_idPlanilla']."'";
    $mostrar_preguntaRespuesta= mysql_query($query_preguntaRespuesta, $conexion) or die(mysql_error());
    $row_preguntaRespuesta= mysql_fetch_assoc($mostrar_preguntaRespuesta);
    $totalRows_preguntaRespuesta= mysql_num_rows($mostrar_preguntaRespuesta);
    if($totalRows_preguntaRespuesta > 0) {
        $cont_preguntaRespuesta=1;
        do {
            mysql_select_db($database_conexion, $conexion);
            $query_actualizar_preguntaRespuesta= "UPDATE pregunta_respuesta SET respuesta = '".$_POST["respuesta_".$cont_preguntaRespuesta]."' WHERE idMer='".(int)$_POST['x_idMer']."' AND idPlanilla='".(int)$_POST['x_idPlanilla']."' AND idPregunta='".(int)$row_preguntaRespuesta['idPregunta']."'";
            mysql_query($query_actualizar_preguntaRespuesta, $conexion) or die(mysql_error());
            $cont_preguntaRespuesta++;
        } while ($row_preguntaRespuesta= mysql_fetch_assoc($mostrar_preguntaRespuesta));
    }
}
}
if($_POST['x_idPlanilla']==15){
if($_POST['guardar_pregunta']) {

    mysql_select_db($database_conexion, $conexion);
    $query_preguntaRespuesta = "SELECT a.* FROM pregunta_respuesta a WHERE a.idMer='".(int)$_POST['x_idMer']."' AND a.idPlanilla='".(int)$_POST['x_idPlanilla']."'";
    $mostrar_preguntaRespuesta= mysql_query($query_preguntaRespuesta, $conexion) or die(mysql_error());
    $row_preguntaRespuesta= mysql_fetch_assoc($mostrar_preguntaRespuesta);
    $totalRows_preguntaRespuesta= mysql_num_rows($mostrar_preguntaRespuesta);
    if($totalRows_preguntaRespuesta > 0) {
        $cont_preguntaRespuesta=1;
        do {
    if($_POST['fechaInicio15_'.$cont_preguntaRespuesta]){
    $fechaExplode=explode("-", $_POST['fechaInicio15_'.$cont_preguntaRespuesta]);
    $fechaInicio= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaInicio='';}
    if($_POST['fechaFinal15_'.$cont_preguntaRespuesta]){
    $fechaExplode=explode("-", $_POST['fechaFinal15_'.$cont_preguntaRespuesta]);
    $fechaFinal= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaFinal='';}
            mysql_select_db($database_conexion, $conexion);
            $query_actualizar_preguntaRespuesta= "UPDATE pregunta_respuesta SET respuesta = '".$_POST["respuesta_".$cont_preguntaRespuesta]."',respuesta2 = '".$_POST["respuesta2_".$cont_preguntaRespuesta]."',fechaInicio = '$fechaInicio',fechaFinal = '$fechaFinal' WHERE idMer='".(int)$_POST['x_idMer']."' AND idPlanilla='".(int)$_POST['x_idPlanilla']."' AND idPregunta='".(int)$row_preguntaRespuesta['idPregunta']."'";
            mysql_query($query_actualizar_preguntaRespuesta, $conexion) or die(mysql_error());
            $cont_preguntaRespuesta++;
        } while ($row_preguntaRespuesta= mysql_fetch_assoc($mostrar_preguntaRespuesta));
    }
}
}

if($_GET['sw']=='habilitar'){
     mysql_select_db($database_conexion, $conexion);
    $query_merdes = "UPDATE mer SET estado='1', fechaModificacion='".date("Y-m-d")."' WHERE idMer = '".(int)$_GET['x_idMer']."'";
    mysql_query($query_merdes, $conexion) or die(mysql_error());
}
// operaciones del formulario 12
if($_POST['sw']=='formulario12add') {
// actuallizar tabla tipo_contrato_llenar
    if($_POST['x_fechaInicial']){
    $fechaExplode=explode("-", $_POST['x_fechaInicial']);
    $fechaInicial= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaInicial='';}
    if($_POST['x_fechaFinal']){
    $fechaExplode=explode("-", $_POST['x_fechaFinal']);
    $fechaFinal= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaFinal='';}
    mysql_select_db($database_conexion, $conexion);
    $query_formulario12 = "INSERT INTO formulario12 VALUES ('','".(int)$_POST['x_idMer']."','".(int)$_POST['x_idPlanilla']."','".(int)$_POST['x_tipoContrato']."','".$_POST['x_descripcion']."','".$_POST['x_unidad']."','".$_POST['x_precioUnitario']."','".$_POST['x_cantidad']."','".$_POST['x_costoTotal']."','$fechaInicial','$fechaFinal','".$_POST['x_cumple']."')";
    mysql_query($query_formulario12, $conexion) or die(mysql_error());
}
if($_POST['sw']=='formulario12edit') {
// actuallizar tabla tipo_contrato_llenar
    if($_POST['x_fechaInicial']){
    $fechaExplode=explode("-", $_POST['x_fechaInicial']);
    $fechaInicial= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaInicial='';}
    if($_POST['x_fechaFinal']){
    $fechaExplode=explode("-", $_POST['x_fechaFinal']);
    $fechaFinal= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
    }else {$fechaFinal='';}
    mysql_select_db($database_conexion, $conexion);
    $query_formulario12= "UPDATE formulario12 SET idMer='".(int)$_POST['x_idMer']."', idPlanilla='".(int)$_POST['x_idPlanilla']."', tipoContrato='".$_POST['x_tipoContrato']."', descripcion='".$_POST['x_descripcion']."', unidad='".$_POST['x_unidad']."', precioUnitario='".$_POST['x_precioUnitario']."', cantidad='".$_POST['x_cantidad']."', costoTotal='".$_POST['x_costoTotal']."', fechaInicial='$fechaInicial', fechaFinal='$fechaFinal', cumple='".$_POST['x_cumple']."' WHERE idFormulario12='".(int)$_POST['x_idFormulario12']."'";
    mysql_query($query_formulario12, $conexion) or die(mysql_error());
}
if($_GET['sw']=='formulario12delete'){
mysql_select_db($database_conexion, $conexion);
$query_formulario12 = "DELETE FROM formulario12 WHERE idFormulario12='".$_GET['x_idFormulario12']."'";
 mysql_query($query_formulario12, $conexion) or die(mysql_error());
}

if($_GET['sw']=='contratodelete' || $_GET['sw']=='registrodelete17' || $_GET['sw']=='archivodelete' || $_GET['sw']=='desabilitar' || $_GET['sw']=='habilitar' || $_GET['sw']=='obtencionCreditodelete' || $_GET['sw']=='formulario12delete'){
    $x_idPlanilla=$_GET['x_idPlanilla'];
    $x_idMer=$_GET['x_idMer'];
//echo "get";
}else {$x_idPlanilla=$_POST['x_idPlanilla'];
    $x_idMer=$_POST['x_idMer'];
//    echo "post";
}

header("Location: formulariolist.php?idMer=".$x_idMer."&idPlanilla=".$x_idPlanilla."");

?>

<?php

//
// Page Class
//
class cformulario_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'formulario';

	// Page Object Name
	var $PageObjName = 'formulario_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $formulario;
		if ($formulario->UseTokenInUrl) $PageUrl .= "t=" . $formulario->TableVar . "&"; // add page token
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
		global $objForm, $formulario;
		if ($formulario->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($formulario->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($formulario->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cformulario_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["formulario"] = new cformulario();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'formulario', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $formulario;
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
	$formulario->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $formulario->Export; // Get export parameter, used in header
	$gsExportFile = $formulario->TableVar; // Get export file, used in header
	if ($formulario->Export == "print" || $formulario->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($formulario->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $formulario;
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
		if ($formulario->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $formulario->getRecordsPerPage(); // Restore from Session
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
		$formulario->setSessionWhere($sFilter);
		$formulario->CurrentFilter = "";

		// Export data only
		if (in_array($formulario->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $formulario;
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
			$formulario->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$formulario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $formulario;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$formulario->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$formulario->CurrentOrderType = @$_GET["ordertype"];
			$formulario->UpdateSort($formulario->idFormulario); // Field
			$formulario->UpdateSort($formulario->idMer); // Field
			$formulario->UpdateSort($formulario->idPlanilla); // Field
			$formulario->UpdateSort($formulario->archivo); // Field
			$formulario->UpdateSort($formulario->cuenta); // Field
			$formulario->UpdateSort($formulario->porcentaje); // Field
			$formulario->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $formulario;
		$sOrderBy = $formulario->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($formulario->SqlOrderBy() <> "") {
				$sOrderBy = $formulario->SqlOrderBy();
				$formulario->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $formulario;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$formulario->setSessionOrderBy($sOrderBy);
				$formulario->idFormulario->setSort("");
				$formulario->idMer->setSort("");
				$formulario->idPlanilla->setSort("");
				$formulario->archivo->setSort("");
				$formulario->cuenta->setSort("");
				$formulario->porcentaje->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$formulario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $formulario;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$formulario->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$formulario->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $formulario->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$formulario->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$formulario->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$formulario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $formulario;

		// Call Recordset Selecting event
		$formulario->Recordset_Selecting($formulario->CurrentFilter);

		// Load list page SQL
		$sSql = $formulario->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$formulario->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $formulario;
		$sFilter = $formulario->KeyFilter();

		// Call Row Selecting event
		$formulario->Row_Selecting($sFilter);

		// Load sql based on filter
		$formulario->CurrentFilter = $sFilter;
		$sSql = $formulario->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$formulario->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $formulario;
		$formulario->idFormulario->setDbValue($rs->fields('idFormulario'));
		$formulario->idMer->setDbValue($rs->fields('idMer'));
		$formulario->idPlanilla->setDbValue($rs->fields('idPlanilla'));
		$formulario->archivo->setDbValue($rs->fields('archivo'));
		$formulario->cuenta->setDbValue($rs->fields('cuenta'));
		$formulario->porcentaje->setDbValue($rs->fields('porcentaje'));
		$formulario->observacion->setDbValue($rs->fields('observacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $formulario;

		// Call Row_Rendering event
		$formulario->Row_Rendering();

		// Common render codes for all row types
		// idFormulario

		$formulario->idFormulario->CellCssStyle = "";
		$formulario->idFormulario->CellCssClass = "";

		// idMer
		$formulario->idMer->CellCssStyle = "";
		$formulario->idMer->CellCssClass = "";

		// idPlanilla
		$formulario->idPlanilla->CellCssStyle = "";
		$formulario->idPlanilla->CellCssClass = "";

		// archivo
		$formulario->archivo->CellCssStyle = "";
		$formulario->archivo->CellCssClass = "";

		// cuenta
		$formulario->cuenta->CellCssStyle = "";
		$formulario->cuenta->CellCssClass = "";

		// porcentaje
		$formulario->porcentaje->CellCssStyle = "";
		$formulario->porcentaje->CellCssClass = "";
		if ($formulario->RowType == EW_ROWTYPE_VIEW) { // View row

			// idFormulario
			$formulario->idFormulario->ViewValue = $formulario->idFormulario->CurrentValue;
			$formulario->idFormulario->CssStyle = "";
			$formulario->idFormulario->CssClass = "";
			$formulario->idFormulario->ViewCustomAttributes = "";

			// idMer
			$formulario->idMer->ViewValue = $formulario->idMer->CurrentValue;
			$formulario->idMer->CssStyle = "";
			$formulario->idMer->CssClass = "";
			$formulario->idMer->ViewCustomAttributes = "";

			// idPlanilla
			$formulario->idPlanilla->ViewValue = $formulario->idPlanilla->CurrentValue;
			$formulario->idPlanilla->CssStyle = "";
			$formulario->idPlanilla->CssClass = "";
			$formulario->idPlanilla->ViewCustomAttributes = "";

			// archivo
			$formulario->archivo->ViewValue = $formulario->archivo->CurrentValue;
			$formulario->archivo->CssStyle = "";
			$formulario->archivo->CssClass = "";
			$formulario->archivo->ViewCustomAttributes = "";

			// cuenta
			$formulario->cuenta->ViewValue = $formulario->cuenta->CurrentValue;
			$formulario->cuenta->CssStyle = "";
			$formulario->cuenta->CssClass = "";
			$formulario->cuenta->ViewCustomAttributes = "";

			// porcentaje
			$formulario->porcentaje->ViewValue = $formulario->porcentaje->CurrentValue;
			$formulario->porcentaje->CssStyle = "";
			$formulario->porcentaje->CssClass = "";
			$formulario->porcentaje->ViewCustomAttributes = "";

			// idFormulario
			$formulario->idFormulario->HrefValue = "";

			// idMer
			$formulario->idMer->HrefValue = "";

			// idPlanilla
			$formulario->idPlanilla->HrefValue = "";

			// archivo
			$formulario->archivo->HrefValue = "";

			// cuenta
			$formulario->cuenta->HrefValue = "";

			// porcentaje
			$formulario->porcentaje->HrefValue = "";
		}

		// Call Row Rendered event
		$formulario->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $formulario;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($formulario->ExportAll) {
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
		if ($formulario->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($formulario->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $formulario->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idFormulario', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'idMer', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'idPlanilla', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'archivo', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'cuenta', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'porcentaje', $formulario->Export);
				echo ew_ExportLine($sExportStr, $formulario->Export);
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
				$formulario->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($formulario->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idFormulario', $formulario->idFormulario->CurrentValue);
					$XmlDoc->AddField('idMer', $formulario->idMer->CurrentValue);
					$XmlDoc->AddField('idPlanilla', $formulario->idPlanilla->CurrentValue);
					$XmlDoc->AddField('archivo', $formulario->archivo->CurrentValue);
					$XmlDoc->AddField('cuenta', $formulario->cuenta->CurrentValue);
					$XmlDoc->AddField('porcentaje', $formulario->porcentaje->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $formulario->Export <> "csv") { // Vertical format
						echo ew_ExportField('idFormulario', $formulario->idFormulario->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('idMer', $formulario->idMer->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('idPlanilla', $formulario->idPlanilla->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('archivo', $formulario->archivo->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('cuenta', $formulario->cuenta->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('porcentaje', $formulario->porcentaje->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $formulario->idFormulario->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->idMer->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->idPlanilla->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->archivo->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->cuenta->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->porcentaje->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportLine($sExportStr, $formulario->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($formulario->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($formulario->Export);
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