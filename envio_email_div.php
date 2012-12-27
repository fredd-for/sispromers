<?php
session_start();
if($_SESSION['session_gerente_acceso'] != "iniSession_gerente") {
    header("Location: ../index.php");
}
?>
<?php require_once('../Connections/conexion.php'); ?>
<?php require("../phpmailer/class.phpmailer.php"); //Importamos la función PHP class.phpmailer ?>
<?php
$servidor="mailhost.fhi.net";
if($_GET['sw']=='desabilitar'){
// envio de emails de forma automatica a el administrador y al gerente
mysql_select_db($database_conexion, $conexion);
$query_cabezeramer = "SELECT a.idMer, a.mer,b.regional,c.rubro FROM mer a, regional b, rubro c WHERE a.idMer = '".(int)$_GET['x_idMer']."' AND a.idRegional=b.idRegional AND a.idRubro=c.idRubro";
$mostrar_cabezeramer=mysql_query($query_cabezeramer, $conexion) or die(mysql_error());
$row_cabezeramer=mysql_fetch_assoc($mostrar_cabezeramer);
echo "<div style='clear: none;font-size: 12px'>";
echo "<div><b>MER:</b>".$row_cabezeramer['mer']."</div><div><b>Regional:</b>".$row_cabezeramer['regional']."</div><div><b>Rubro:</b>".$row_cabezeramer['rubro']."</div><div><b>Gerente:</b>".$_SESSION['session_usuario_nombre']."</div>";
echo "</div>";

// Editamos las planillas
mysql_select_db($database_conexion, $conexion);
$query_planilla= "SELECT * FROM planilla";
$mostrar_planilla=mysql_query($query_planilla, $conexion) or die(mysql_error());
$totalRows_planilla=mysql_num_rows($mostrar_planilla);
while($row_planilla=mysql_fetch_assoc($mostrar_planilla)){
echo "<div style='background: green; color: #ffffff;font-size:12px'>".$row_planilla['idPlanilla']." - ".$row_planilla['Nombre']."</div>";
// informe historial contrato planilla nro 1
mysql_select_db($database_conexion, $conexion);
$query_historialContrato= "SELECT a.*, b.nombre,b.paterno,b.materno, c.tipoContrato,d.registroContrato FROM historial_contrato a, gerente b, tipo_contrato c, registro_contrato d WHERE a.idMer='".$row_cabezeramer['idMer']."' AND a.idPlanilla='".$row_planilla['idPlanilla']."' AND a.informe=0 AND a.idGerente=b.idGerente AND a.idTipoContrato=c.idTipoContrato AND a.idRegistroContrato=d.idRegistroContrato ORDER BY a.fecha asc";
$mostrar_historialContrato=mysql_query($query_historialContrato, $conexion) or die(mysql_error());
$totalRows_historialContrato=mysql_num_rows($mostrar_historialContrato);
if($totalRows_historialContrato>0){
?>
<div style='clear: none;overflow: auto;font-size: 12px;border: 1px solid #FC8F30; width: 800px'>
    <div style='clear: both;border-bottom: 1px solid #FC8F30'>
<div style='width:7%;float: left;padding: 5px;background:#F0E0A0'>Fecha</div>
<div style='width:10%;float: left;padding: 5px;background:#F0E0A0 '>Gerente</div>
<div style='width:6%;float: left;padding: 5px;background:#F0E0A0 '>Estado</div>
<div style='width:12%;float: left;padding: 5px;background:#F0E0A0 '>Tipo Contrato</div>
<div style='width:12%;float: left;padding: 5px;background:#F0E0A0 '>Registro</div>
<div style='width:9%;float: left;padding: 5px;background:#F0E0A0 '>Fecha Inicio</div>
<div style='width:9%;float: left;padding: 5px;background:#F0E0A0 '>Fecha Finalizacion</div>
<div style='width:6%;float: left;padding: 5px;background:#F0E0A0 '>Precio Bs.</div>
<div style='width:6%;float: left;padding: 5px;background:#F0E0A0 '>Completo</div>
<div style='width:10%;float: left;padding: 5px;background:#F0E0A0 '>Cert. Conformidad</div>
    </div>
<?php while($row_historialContrato=mysql_fetch_assoc($mostrar_historialContrato)){?>
    <div style='clear: both;border-bottom: 1px solid #FC8F30'>
        <div style='width:7%;float: left;padding: 5px'><?php echo date("d-m-Y H:m",strtotime($row_historialContrato['fecha']));?></div>
        <div style='width:10%;float: left;padding: 5px'><?php echo $row_historialContrato['paterno']." ".$row_historialContrato['materno'].", ".$row_historialContrato['nombre'];?></div>
        <div style='width:6%;float: left;padding: 5px'><?php echo $row_historialContrato['estado'];?></div>
        <div style='width:12%;float: left;padding: 5px'><?php echo $row_historialContrato['tipoContrato'];?></div>
        <div style='width:12%;float: left;padding: 5px'><?php echo $row_historialContrato['registroContrato'];?></div>
        <div style='width:9%;float: left;padding: 5px'><?php echo $row_historialContrato['fechaInicio'];?></div>
        <div style='width:9%;float: left;padding: 5px'><?php echo $row_historialContrato['fechaFinal'];?></div>
        <div style='width:6%;float: left;padding: 5px'><?php echo $row_historialContrato['valor'];?></div>
        <div style='width:6%;float: left;padding: 5px'><?php echo $row_historialContrato['completo'];?></div>
        <div style='width:10%;float: left;padding: 5px'><?php echo $row_historialContrato['certConformidad'];?></div>
    </div>
<?php } ?>

</div>
<?php
}
// informe historial formulario planilla nro 1
mysql_select_db($database_conexion, $conexion);
$query_historialFormulario= "SELECT a.*,b.nombre,b.paterno,b.materno FROM historial_formulario a, gerente b WHERE a.idMer='".$row_cabezeramer['idMer']."' AND a.idGerente=b.idGerente AND a.idPlanilla='".$row_planilla['idPlanilla']."' AND informe=0 ORDER BY a.fecha asc";
$mostrar_historialFormulario=mysql_query($query_historialFormulario, $conexion) or die(mysql_error());
$totalRows_historialFormulario=mysql_num_rows($mostrar_historialFormulario);
if($totalRows_historialFormulario>0){?>
<div style='clear: none;overflow: auto;font-size: 12px;border: 1px solid #FC8F30; width: 700px'>
    <div style='clear: both;border-bottom: 1px solid #FC8F30'>
        <div style='width:20%;float: left;padding: 5px;background:#F0E0A0'>fecha</div>
        <div style='width:20%;float: left;padding: 5px;background:#F0E0A0'>Gerente</div>
        <div style='width:10%;float: left;padding: 5px;background:#F0E0A0'>Cuenta</div>
        <div style='width:10%;float: left;padding: 5px;background:#F0E0A0'>Porcentaje</div>
        <div style='width:30%;float: left;padding: 5px;background:#F0E0A0'>Observaciones</div>
    </div>
<?php while($row_historialFormulario=mysql_fetch_assoc($mostrar_historialFormulario)){?>
     <div style='clear: both;border-bottom: 1px solid #FC8F30'>
        <div style='width:20%;float: left;padding: 5px'><?php echo date("d-m-Y H:m",strtotime($row_historialFormulario['fecha']));?></div>
        <div style='width:20%;float: left;padding: 5px'><?php echo $row_historialFormulario['paterno']." ".$row_historialFormulario['materno'].", ".$row_historialFormulario['nombre']?></div>
        <div style='width:10%;float: left;padding: 5px'><?php echo $row_historialFormulario['cuenta']?></div>
        <div style='width:10%;float: left;padding: 5px'><?php echo $row_historialFormulario['porcentaje']?></div>
        <div style='width:30%;float: left;padding: 5px'><?php echo $row_historialFormulario['observacion']?></div>
    </div>
<?php } ?>
</div>
<?php }
// informe historial archivo planilla nro 1
mysql_select_db($database_conexion, $conexion);
$query_historialArchivo= "SELECT a.*,b.nombre,b.paterno,b.materno FROM historial_archivo a, gerente b WHERE a.idMer='".$row_cabezeramer['idMer']."' AND a.idGerente=b.idGerente AND a.idPlanilla='".$row_planilla['idPlanilla']."' AND informe=0 ORDER BY a.fecha asc";
$mostrar_historialArchivo=mysql_query($query_historialArchivo, $conexion) or die(mysql_error());
$totalRows_historialArchivo=mysql_num_rows($mostrar_historialArchivo);
if($totalRows_historialArchivo>0){?>
<div style='clear: none;overflow: auto;font-size: 12px;border: 1px solid #FC8F30; width: 700px'>
    <div style='clear: both;border-bottom: 1px solid #FC8F30'>
        <div style='width:20%;float: left;padding: 5px;background:#F0E0A0'>fecha</div>
        <div style='width:20%;float: left;padding: 5px;background:#F0E0A0'>Gerente</div>
        <div style='width:10%;float: left;padding: 5px;background:#F0E0A0'>Estado</div>
        <div style='width:40%;float: left;padding: 5px;background:#F0E0A0'>Archivo</div>
    </div>
<?php while($row_historialArchivo=mysql_fetch_assoc($mostrar_historialArchivo)){?>
    <div style='clear: both;border-bottom: 1px solid #FC8F30'>
        <div style='width:20%;float: left;padding: 5px'><?php echo date("d-m-Y H:m",strtotime($row_historialArchivo['fecha']));?></div>
        <div style='width:20%;float: left;padding: 5px'><?php echo $row_historialArchivo['paterno']." ".$row_historialArchivo['materno'].", ".$row_historialArchivo['nombre']?></div>
        <div style='width:10%;float: left;padding: 5px'><?php echo $row_historialArchivo['estado']?></div>
        <div style='width:40%;float: left;padding: 5px'><?php echo $row_historialArchivo['archivo']?></div>
    </div>
<?php } ?>
</div>
<?php }
}

//$mail = new PHPMailer();  //Luego tenemos que iniciar la validación por SMTP:
//$mail->Mailer = "smtp";
//$mail->Host = $servidor;
//$mail->IsHTML= true;
//$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta o de lo contrario False
//$mail->Username = "sispromer@fh.org"; // Cuenta de e-mail
//$mail->Password = "Micah6:8"; // Password
//$mail->From = "sispromer@fh.org";
//$mail->FromName = "SISTEMA-SISPROMERS";
////$mail->Timeout=60;
//$mail->Subject = "SISPROMERS-".$row_cabezeramer['mer'];
//// datos de los administradores
//mysql_select_db($database_conexion, $conexion);
//$query_administrador= "SELECT * FROM administrador";
//$mostrar_administrador=mysql_query($query_administrador, $conexion) or die(mysql_error());
//$totalRows_administrador=mysql_num_rows($mostrar_administrador);
//while($row_administrador=mysql_fetch_assoc($mostrar_administrador)){
//$mail->AddAddress($row_administrador['email'],$row_administrador['paterno']." ".$row_administrador['materno'].", ".$row_administrador['nombre']);
//}
////$mail->AddAddress("vbarrera@fh.org","Veronica Barrera");
////$mail->WordWrap = 50;
//
//$mail->Body = $body;
//$mail->AltBody = $body;
//$exito=$mail->Send();
//if(!$exito)
//{ $mensaje="No se pudo enviar el email...";}
//    else{
//$mensaje="email enviado exitosamente";
//mysql_select_db($database_conexion, $conexion);
//$query_historialArchivoedit = "UPDATE historial_archivo SET informe=1, fechaInforme='".date("Y-m-d")."' WHERE idMer='".$row_cabezeramer['idMer']."' AND informe=0";
//mysql_query($query_historialArchivoedit, $conexion) or die(mysql_error());
//
//mysql_select_db($database_conexion, $conexion);
//$query_historialContratoedit = "UPDATE historial_contrato SET informe=1, fechaInforme='".date("Y-m-d")."' WHERE idMer='".$row_cabezeramer['idMer']."' AND informe=0";
//mysql_query($query_historialContratoedit, $conexion) or die(mysql_error());
//
//mysql_select_db($database_conexion, $conexion);
//$query_historialFormularioedit = "UPDATE historial_formulario SET informe=1, fechaInforme='".date("Y-m-d")."' WHERE idMer='".$row_cabezeramer['idMer']."' AND informe=0";
//mysql_query($query_historialFormularioedit, $conexion) or die(mysql_error());
//
//mysql_select_db($database_conexion, $conexion);
//$query_merdes = "UPDATE mer SET estado='2', fechaModificacion='".date("Y-m-d")."' WHERE idMer = '".(int)$_GET['x_idMer']."'";
//mysql_query($query_merdes, $conexion) or die(mysql_error());
//}

}
//if($_GET['sw']=='desabilitar'){
//    $x_idPlanilla=$_GET['x_idPlanilla'];
//    $x_idMer=$_GET['x_idMer'];
//}else {$x_idPlanilla=$_POST['x_idPlanilla'];
//    $x_idMer=$_POST['x_idMer'];
//}
//header("Location: formulario.php?idMer=".$x_idMer."&idPlanilla=".$x_idPlanilla."");
?>
