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
<?php require("phpmailer/class.phpmailer.php"); ?>
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

$idUsuario=$_SESSION['idUsuario'];
//$archivo_array=$_POST['archivo'];
$fecha=date("Y-m-d");

//$detalle=$_POST['detalle'];

//echo print_r($_FILES['archivo']['name']);

if(isset($_POST['guardar_cambios'])) {
$selector_array=$_POST['selector'];
$comentario_array= $_POST['comentario'];
$archivo_nombre_array=$_POST['archivo_nombre'];
$idmeta_array=$_POST['y_idMeta'];
$idmer_array=$_POST['y_idMer'];
$idConsultoria=$_POST['x_idConsultoria'];
$idCronograma=$_POST['x_idCronograma'];
$sumaMetaAlcanzar=$_POST['x_sumaMetaAlcanzar'];
$porcentajeCumplimiento=0;
$valorUnitario=100/count($idmer_array);

    for($i=0;$i<count($idmeta_array);$i++) {
        //echo $idmeta_array[$i]."<br>";
        mysql_select_db($database_conexion, $conexion);
        $query_deleteidMeta= "DELETE FROM meta_reporte_unitario WHERE idUsuario='".$idUsuario."' AND idMeta='".$idmeta_array[$i]."'";
        mysql_query($query_deleteidMeta, $conexion) or die(mysql_error());
        $contadorRespuestas=0;
        for($j=0;$j<count($idmer_array);$j++) {
            $selector=0;
            $comentario = "";
            $archivo="";
            $sw=0;
            if($selector_array[$idmeta_array[$i]][$idmer_array[$j]]=='on'){
                $selector=1;
                $comentario = trim($comentario_array[$idmeta_array[$i]][$idmer_array[$j]]);
                mysql_select_db($database_conexion, $conexion);
                $query_reporteUnitarioadd= "INSERT INTO meta_reporte_unitario VALUES('','$idUsuario','$idmeta_array[$i]','$idmer_array[$j]','$selector','$comentario','$archivo','$fecha','$fecha','1')";
                mysql_query($query_reporteUnitarioadd, $conexion) or die(mysql_error());
                $sw=1;
                $contadorRespuestas++;
            }
            if(isset($archivo_nombre_array[$idmeta_array[$i]][$idmer_array[$j]])){
                $comentario = trim($comentario_array[$idmeta_array[$i]][$idmer_array[$j]]);
                $archivo=$archivo_nombre_array[$idmeta_array[$i]][$idmer_array[$j]];
                mysql_select_db($database_conexion, $conexion);
                $query_reporteUnitarioadd= "INSERT INTO meta_reporte_unitario VALUES('','$idUsuario','$idmeta_array[$i]','$idmer_array[$j]','$selector','$comentario','$archivo','$fecha','$fecha','1')";
                mysql_query($query_reporteUnitarioadd, $conexion) or die(mysql_error());
                $sw=1;
                $contadorRespuestas++;
            }
            if($_FILES['archivo'.$idmeta_array[$i].$idmer_array[$j]]['name']!=""){
            $archivo=$idmeta_array[$i]."_".$idmer_array[$j]."_".$_FILES['archivo'.$idmeta_array[$i].$idmer_array[$j]]['name'];
            $tamano = $_FILES['archivo'.$idmeta_array[$i].$idmer_array[$j]]['size'];
            $tipo =$_FILES['archivo'.$idmeta_array[$i].$idmer_array[$j]]['type'];
            // guardamos el archivo a la carpeta files
            $destino =  "files_consultoria/".$archivo;
                    if (copy($_FILES['archivo'.$idmeta_array[$i].$idmer_array[$j]]['tmp_name'],$destino)) {
                        $comentario = trim($comentario_array[$idmeta_array[$i]][$idmer_array[$j]]);
                        mysql_select_db($database_conexion, $conexion);
                        $query_reporteUnitarioadd= "INSERT INTO meta_reporte_unitario VALUES('','$idUsuario','$idmeta_array[$i]','$idmer_array[$j]','$selector','$comentario','$archivo','$fecha','$fecha','1')";
                        mysql_query($query_reporteUnitarioadd, $conexion) or die(mysql_error());
                        $sw=1;
                        $contadorRespuestas++;
                    }else{echo "error al almacenra archivo";}
                }
            }
            $porcentajeCumplimiento+=$contadorRespuestas*$valorUnitario;
        }
        $porcentaje=($porcentajeCumplimiento*100)/$sumaMetaAlcanzar;
        mysql_select_db($database_conexion, $conexion);
        $query_deleteidMeta= "UPDATE cronograma SET porcentajeCumplimiento=$porcentaje WHERE idCronograma=$idCronograma";
        mysql_query($query_deleteidMeta, $conexion) or die(mysql_error());
header("Location: avance_productolist.php?idConsultoria=".$idConsultoria."&idCronograma=".$idCronograma."");
}
// borrar archivo de la base de datos y dela carpeta files
if($_GET['sw']=='archivodelete'){
    //unlink("files_consultoria/".$_GET['archivo']);
    mysql_select_db($database_conexion, $conexion);
    $query_archivodelete = "DELETE FROM meta_reporte_unitario WHERE idMeta='".$_GET['x_idMeta']."' AND idMer='".$_GET['x_idMer']."'";
    mysql_query($query_archivodelete, $conexion) or die(mysql_error());

//actualizamos el porcentaje de cumplimiento
$valorUnitario=100/$_GET['numMers'];
mysql_select_db($database_conexion, $conexion);
$query_metaTotal= "SELECT Sum(a.metaAlcanzar) as metaTotal FROM meta AS a
WHERE a.idCronograma = ".$_GET['x_idCronograma']." AND a.cabecera =  '0' GROUP BY a.idCronograma";
$mostrar_metaTotal=mysql_query($query_metaTotal, $conexion) or die(mysql_error());
$total_metaTotal=mysql_fetch_assoc($mostrar_metaTotal);

mysql_select_db($database_conexion, $conexion);
$query_contador= "SELECT Count(b.selector) as contador FROM meta AS a Inner Join meta_reporte_unitario AS b
    ON a.idMeta = b.idMeta WHERE a.idCronograma =".$_GET['x_idCronograma'];
$mostrar_contador=mysql_query($query_contador, $conexion) or die(mysql_error());
$total_contador=mysql_fetch_assoc($mostrar_contador);

$porcentaje=($valorUnitario*$total_contador['contador'])*100/$total_metaTotal['metaTotal'];
mysql_select_db($database_conexion, $conexion);
$query_deleteidMeta= "UPDATE cronograma SET porcentajeCumplimiento=$porcentaje WHERE idCronograma=".$_GET['x_idCronograma'];
mysql_query($query_deleteidMeta, $conexion) or die(mysql_error());
header("Location: avance_productolist.php?idConsultoria=".$_GET['x_idConsultoria']."&idCronograma=".$_GET['x_idCronograma']."");
}

if($_GET['sw']=='guardar_reporte_meta'){
   $error = "";
   $sw="";
   $archivo="";
   $fecha=date("dmY_His");
   $idMeta=$_GET['x_idMeta'];
   $idCronograma=$_GET['x_idCronograma'];
   $detalle=$_GET['x_detalle'];
   $fileElementName = 'archivo_reporte_meta'.$idMeta;
   $fecha=date("dmY_His");
   $fechaCreacion=date("Y-m-d");

if($_FILES['archivo_reporte_meta'.$idMeta]['name'] || $detalle!=""){

$archivo=$fecha.'_'.$_FILES['archivo_reporte_meta'.$idMeta]['name'];
$tamano = $_FILES['archivo_reporte_meta'.$idMeta]['size'];
$tipo =$_FILES['archivo_reporte_meta'.$idMeta]['type'];
            // guardamos el archivo a la carpeta files
$destino =  "files_consultoria/".$archivo;
if (copy($_FILES['archivo_reporte_meta'.$idMeta]['tmp_name'],$destino)) {
   mysql_select_db($database_conexion, $conexion);
   $query_metaReporteadd = "INSERT INTO meta_reporte VALUES('','$idUsuario','$idMeta','$idCronograma','$archivo','$detalle','2','$fechaCreacion')";
   mysql_query($query_metaReporteadd, $conexion) or die(mysql_error());

   mysql_select_db($database_conexion, $conexion);
   $query_metaedit = "UPDATE meta SET estado=2 WHERE idMeta=$idMeta";
   mysql_query($query_metaedit, $conexion) or die(mysql_error());

   $sw='Se realiza el reporte correctamente';
                    }else{$error = 'Ingrese archivo adjunto para su reporte';}
                }else{$error = 'NO se pudo realizar la operacion';}

echo "{
        'detalle':'$detalle',
        'respuesta':'$sw',
        'idMeta':'$idMeta',
        'error':'$error',
        'nombre_archivo':'$archivo',
      }";

}
//borrar meta reporte
if($_GET['sw']=='borrar_reporte_meta'){
    $idMetaReporte=$_GET['x_idMetaReporte'];
    $idMeta=$_GET['x_idMeta'];
    $archivo=$_GET['x_archivo'];
    unlink("files_consultoria/".$archivo);
    mysql_select_db($database_conexion, $conexion);
    $query_archivodelete = "DELETE FROM meta_reporte WHERE idMetaReporte='".$idMetaReporte."'";
    mysql_query($query_archivodelete, $conexion) or die(mysql_error());

       mysql_select_db($database_conexion, $conexion);
   $query_metaedit = "UPDATE meta SET estado=1 WHERE idMeta=$idMeta";
   mysql_query($query_metaedit, $conexion) or die(mysql_error());
    echo "{
        'respuesta':'Se borro correctamente el reporte de la meta',
        'idMeta':'$idMeta',
        'idCronograma':'$idCronograma',
        'nombre_archivo':'$archivo',
      }";
}
 //borrar archivo de la base de datos y dela carpeta files
if($_GET['sw']=='archivoReporteDelete'){
    $idMeta=$_GET['x_idMeta'];
    $idCronograma=$_GET['x_idCronograma'];
    $archivo=$_GET['x_archivo'];
    unlink("files_consultoria/".$archivo);
    mysql_select_db($database_conexion, $conexion);
    $query_archivodelete = "DELETE FROM meta_reporte WHERE idMeta='".$idMeta."' AND idCronograma='".$idCronograma."' AND archivo='".$archivo."'";
    mysql_query($query_archivodelete, $conexion) or die(mysql_error());

    echo "{
        'respuesta':'Se borro correctamente el archivo',
        'idMeta':'$idMeta',
        'idCronograma':'$idCronograma',
        'nombre_archivo':'$archivo',
      }";
}

if($_GET['sw']=='guardar_reporte_hito'){
   $error = "";
   $sw="";
   $archivo="";
   $fecha=date("dmY_His");
   $idCronograma=$_GET['x_idCronograma'];
   $sugerencia=$_GET['sugerencia_reporte_hito'];
   $inesperado=$_GET['inesperado_reporte_hito'];
   $detalle=$_GET['detalle_reporte_hito'];
   $fechaCreacion=date("Y-m-d");

if($_FILES['archivo_reporte_hito']['name'] && $detalle!=""){
$archivo=$fecha.'_'.$_FILES['archivo_reporte_hito']['name'];
$tamano = $_FILES['archivo_reporte_hito']['size'];
$tipo =$_FILES['archivo_reporte_hito']['type'];
            // guardamos el archivo a la carpeta files
$destino =  "files_consultoria/".$archivo;
if (copy($_FILES['archivo_reporte_hito']['tmp_name'],$destino)) {
        mysql_select_db($database_conexion, $conexion);
        $query_cronogramaReporte= "INSERT INTO cronograma_reporte VALUES('','$idUsuario','$idCronograma','$archivo','$detalle','$sugerencia','$inesperado','2','$fechaCreacion','$fechaCreacion')";
        mysql_query($query_cronogramaReporte, $conexion) or die(mysql_error());

        mysql_select_db($database_conexion, $conexion);
        $query_cronogramaedit= "UPDATE cronograma SET estado=2 WHERE idCronograma=$idCronograma";
        mysql_query($query_cronogramaedit, $conexion) or die(mysql_error());

        mysql_select_db($database_conexion, $conexion);
        $query_metaedit= "UPDATE meta SET estado=2 WHERE idCronograma=$idCronograma";
        mysql_query($query_metaedit, $conexion) or die(mysql_error());

        $sw='Se realiza el reporte correctamente';
        
                    }else{$error = 'Error de transferencia de archivo';}
                }else{$error = 'Ingrese archivo adjunto para su reporte';}

echo "{
        'detalle':'$detalle',
        'respuesta':'$sw',
        'error':'$error',
        'nombre_archivo':'$archivo',
      }";

}

if (isset($_POST['reporte_hito'])) {
    $error = "";
    $sw = "";
    $archivo = "";
    $fecha = date("dmY_His");
    $idCronograma = $_POST['x_idCronograma'];
    $idConsultoria = $_POST['x_idConsultoria'];
    $sugerencia = $_POST['sugerencia_reporte_hito'];
    $inesperado = $_POST['inesperado_reporte_hito'];
    $detalle = $_POST['detalle_reporte_hito'];
    $fechaCreacion = date("Y-m-d");

    if ($_FILES['archivo_reporte_hito']['name'] && $detalle != "") {
        $archivo = $fecha . '_' . $_FILES['archivo_reporte_hito']['name'];
        $tamano = $_FILES['archivo_reporte_hito']['size'];
        $tipo = $_FILES['archivo_reporte_hito']['type'];
        // guardamos el archivo a la carpeta files
        $destino = "files_consultoria/" . $archivo;
        if (copy($_FILES['archivo_reporte_hito']['tmp_name'], $destino)) {
            mysql_select_db($database_conexion, $conexion);
            $query_cronogramaReporte = "INSERT INTO cronograma_reporte VALUES('','$idUsuario','$idCronograma','$archivo','$detalle','$sugerencia','$inesperado','2','$fechaCreacion','$fechaCreacion')";
            mysql_query($query_cronogramaReporte, $conexion) or die(mysql_error());

            mysql_select_db($database_conexion, $conexion);
            $query_cronogramaedit = "UPDATE cronograma SET estado=2 WHERE idCronograma=$idCronograma";
            mysql_query($query_cronogramaedit, $conexion) or die(mysql_error());

            mysql_select_db($database_conexion, $conexion);
            $query_metaedit = "UPDATE meta SET estado=2 WHERE idCronograma=$idCronograma AND estado=1";
            mysql_query($query_metaedit, $conexion) or die(mysql_error());

            mysql_select_db($database_conexion, $conexion);
            $query = "SELECT a.fechaInicio,a.fechaFinal,a.detalle,a.mesAnio,b.consultoria,c.nombre,c.paterno,c.materno
FROM cronograma AS a Inner Join consultoria AS b ON a.idConsultoria = b.idConsultoria Inner Join usuario AS c ON b.idUsuario = c.idUsuario
WHERE a.idCronograma =  '$idCronograma'";
            $mostrar_datos = mysql_query($query, $conexion) or die(mysql_error());
            $row_datos = mysql_fetch_assoc($mostrar_datos);

            mysql_select_db($database_conexion, $conexion);
            $query = "SELECT usuario.email FROM usuario WHERE usuario.idRol =  '1'
                    UNION all
                    SELECT usuario.email FROM responsable_consultoria Inner Join usuario ON responsable_consultoria.idUsuario = usuario.idUsuario 
                    WHERE responsable_consultoria.idConsultoria =  '$idConsultoria'";
            $mostrar_admin = mysql_query($query, $conexion) or die(mysql_error());


            $cadena = "";
            $cadena .="<strong>Consultoria: </strong>" . $row_datos['consultoria'] . "<br>";
            $cadena .="<strong>Consultor: </strong>" . $row_datos['nombre'] . " " . $row_datos['paterno'] . " " . $row_datos['materno'] . "<br>";
            $cadena .="<strong>Hito: </strong>" . $row_datos['detalle'] . "<br>";
            $cadena .="<strong>Periodo: </strong>" . date("d/m/Y", strtotime($row_datos['fechaInicio'])) . " al " . date("d/m/Y", strtotime($row_datos['fechaFinal'])) . "<br><br><br>";
            $cadena .="<strong>Adjunto Archivo: </strong>Si<br>";
            $cadena .="<strong>Sugerencia para la Unidad de Coordinaci&oacute;n: </strong>" . $sugerencia . "<br>";
            $cadena .="<strong>Resultados Inesperados: </strong>" . $inesperado . "<br>";
            $cadena .="<strong>Descripcion del Informe: </strong>" . $detalle . "<br>";
            // envio de email

            while ($row_admin = mysql_fetch_assoc($mostrar_admin)) {
                $email = $row_admin['email'];
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->Host = "mail.iteam.com.bo"; // ssl://smtp.gmail.com
                $mail->Username = "freddy.velasco@iteam.com.bo"; // sispromer@fh.org
                $mail->Password = "8209125"; // Micah6:8
                $mail->Port = 25; // 465
                $mail->From = "freddy.velasco@iteam.com.bo"; // Desde donde enviamos (Para mostrar)
                $mail->FromName = "Sistema SISPROMERS";
                $mail->AddAddress($email); // Esta es la dirección a donde enviamos
                $mail->IsHTML(true); // El correo se envía como HTML
                $mail->Subject = "Consultoria:" . $row_datos['consultoria']; // Este es el titulo del email.
                $body = $cadena;


                $mail->Body = $body; // Mensaje a enviar
                $mail->AltBody = "Consultoria"; // Texto sin html

                if (!$mail->Send()) {
                    echo "Error: " . $mail->ErrorInfo;
                }
            }
//        else {
//            header("Location: avance_productolist.php?idConsultoria=$idConsultoria&idCronograma=$idCronograma");
//        }
        } else {
            $error = 'Error de transferencia de archivo';
        }
    }
    header("Location: avance_productolist.php?idConsultoria=$idConsultoria&idCronograma=$idCronograma");
}

if(isset($_POST['observar_cronograma_reporte'])) {
   $error = "";
   $sw="";
   $archivo="";
   $fecha=date("dmY_His");
   $idCronogramaReporte=$_POST['x_idCronogramaReporte'];
   $idCronograma=$_POST['x_idCronograma'];
   $idConsultoria=$_POST['x_idConsultoria'];
   $observacion=$_POST['observacion_revision_hito'];
   $fechaCreacion=date("Y-m-d");
   $idRC=$_POST['x_idRC'];


if($_FILES['archivo_revision_hito']['name'] || $observacion!=""){
if($_FILES['archivo_revision_hito']['name']){
$tamano = $_FILES['archivo_revision_hito']['size'];
$tipo =$_FILES['archivo_revision_hito']['type'];
$archivo=$fecha.'_'.$_FILES['archivo_revision_hito']['name'];
$destino =  "files_consultoria/".$archivo;
if (copy($_FILES['archivo_revision_hito']['tmp_name'],$destino)) {
}else{ $error = 'Error de transferencia de archivo';}
}
        mysql_select_db($database_conexion, $conexion);
        $query_CRC= "INSERT INTO cronograma_reporte_control VALUES('','$idRC','$idCronogramaReporte','$observacion','$archivo','1','$fechaCreacion','$fechaCreacion')";
        mysql_query($query_CRC, $conexion) or die(mysql_error());

        mysql_select_db($database_conexion, $conexion);
        $query_cronogramareporteedit= "UPDATE cronograma_reporte SET estado=1 WHERE idCronogramaReporte=$idCronogramaReporte";
        mysql_query($query_cronogramareporteedit, $conexion) or die(mysql_error());

        mysql_select_db($database_conexion, $conexion);
        $query_cronogramaedit= "UPDATE cronograma SET estado=1 WHERE idCronograma=$idCronograma";
        mysql_query($query_cronogramaedit, $conexion) or die(mysql_error());

        mysql_select_db($database_conexion, $conexion);
        $query_metaedit= "UPDATE meta SET estado=1 WHERE idCronograma=$idCronograma AND estado=2";
        mysql_query($query_metaedit, $conexion) or die(mysql_error());
    }
 header("Location: avance_productolist.php?idConsultoria=$idConsultoria&idCronograma=$idCronograma");
}
if(isset($_POST['aprobar_cronograma_reporte'])) {
   $error = "";
   $sw="";
   $archivo="";
   $fecha=date("dmY_His");
   $idCronogramaReporte=$_POST['x_idCronogramaReporte'];
   $idCronograma=$_POST['x_idCronograma'];
   $idConsultoria=$_POST['x_idConsultoria'];
   $observacion=$_POST['observacion_revision_hito'];
   $fechaCreacion=date("Y-m-d");
   $idRC=$_POST['x_idRC'];

if($_FILES['archivo_revision_hito']['name'] || $observacion!=""){
if($_FILES['archivo_revision_hito']['name']){
$tamano = $_FILES['archivo_revision_hito']['size'];
$tipo =$_FILES['archivo_revision_hito']['type'];
// guardamos el archivo a la carpeta files
$archivo=$fecha.'_'.$_FILES['archivo_revision_hito']['name'];
$destino =  "files_consultoria/".$archivo;
if (copy($_FILES['archivo_revision_hito']['tmp_name'],$destino)) {
}else{ $error = 'Error de transferencia de archivo';}
}

mysql_select_db($database_conexion, $conexion);
$query_CRC= "INSERT INTO cronograma_reporte_control VALUES('','$idRC','$idCronogramaReporte','$observacion','$archivo','3','$fechaCreacion','$fechaCreacion')";
mysql_query($query_CRC, $conexion) or die(mysql_error());

// preguntamos si todos los usuarios han aprobado
mysql_select_db($database_conexion, $conexion);
$query_responsableConsultoria= "SELECT idRC FROM responsable_consultoria WHERE idConsultoria=$idConsultoria";
$mostrar_responsableConsultoria=mysql_query($query_responsableConsultoria, $conexion) or die(mysql_error());
$total_responsableConsultoria=mysql_num_rows($mostrar_responsableConsultoria);
$sw=1;
while($row_responsableConsultoria=mysql_fetch_assoc($mostrar_responsableConsultoria)){
mysql_select_db($database_conexion, $conexion);
$query_CRCestado= "SELECT estado FROM cronograma_reporte_control WHERE idRC=".$row_responsableConsultoria['idRC']." AND idCronogramaReporte=".$idCronogramaReporte." AND estado=3";
$mostrar_CRCestado=mysql_query($query_CRCestado, $conexion) or die(mysql_error());
$total_CRCestado=mysql_num_rows($mostrar_CRCestado);
if($total_CRCestado<1){$sw=0;}
}
if($sw==1){
    mysql_select_db($database_conexion, $conexion);
        $query_cronogramareporteedit= "UPDATE cronograma_reporte SET estado=3 WHERE idCronogramaReporte=$idCronogramaReporte";
        mysql_query($query_cronogramareporteedit, $conexion) or die(mysql_error());

        mysql_select_db($database_conexion, $conexion);
        $query_cronogramaedit= "UPDATE cronograma SET estado=3 WHERE idCronograma=$idCronograma";
        mysql_query($query_cronogramaedit, $conexion) or die(mysql_error());

        mysql_select_db($database_conexion, $conexion);
        $query_metaedit= "UPDATE meta SET estado=3 WHERE idCronograma=$idCronograma";
        mysql_query($query_metaedit, $conexion) or die(mysql_error());
}

}
 header("Location: avance_productolist.php?idConsultoria=$idConsultoria&idCronograma=$idCronograma");
}
/// observar reporte meta reportado
if($_GET['sw']=='observar_reporte_meta'){
    $idRC=$_GET['x_idRC'];
    $idMeta=$_GET['x_idMeta'];
    $idMetaReporte=$_GET['x_idMetaReporte'];
    $observacion=$_GET['x_observacion'];
    //$fileElementName = 'archivo_revision_meta'.$idMetaReporte;
   $fecha=date("dmY_His");
   $fechaCreacion=date("Y-m-d");
   $archivo_obs="";  //ojo con esta operacion

if($_FILES['archivo_revision_meta'.$idMetaReporte]['name']){

$archivo_obs=$fecha.'_'.$_FILES['archivo_revision_meta'.$idMetaReporte]['name'];
$tamano = $_FILES['archivo_revision_meta'.$idMetaReporte]['size'];
$tipo =$_FILES['archivo_revision_meta'.$idMetaReporte]['type'];
// guardamos el archivo a la carpeta files
$destino =  "files_consultoria/".$archivo_obs;
if(copy($_FILES['archivo_revision_meta'.$idMetaReporte]['tmp_name'],$destino)) {
    //$archivo_obs=$fecha.'_'.$_FILES['archivo_revision_meta'.$idMetaReporte]['name'];
}
}
if($observacion!=""){
mysql_select_db($database_conexion, $conexion);
$query_MRCadd = "INSERT INTO meta_reporte_control VALUES('','$idRC','$idMetaReporte','$observacion','$archivo_obs','1','$fechaCreacion','$fechaCreacion')";
mysql_query($query_MRCadd, $conexion) or die(mysql_error());

   mysql_select_db($database_conexion, $conexion);
   $query_metaedit = "UPDATE meta_reporte SET estado=1 WHERE idMetaReporte=$idMetaReporte";
   mysql_query($query_metaedit, $conexion) or die(mysql_error());

   mysql_select_db($database_conexion, $conexion);
   $query_metaedit = "UPDATE meta SET estado=1 WHERE idMeta=$idMeta";
   mysql_query($query_metaedit, $conexion) or die(mysql_error());

   $sw='Se realiza la observacion correctamente';
                }else{$error = 'NO se pudo realizar la operacion';}

echo "{
        'idMetaReporte':'$idMetaReporte',
        'respuesta':'$sw',
        'idMeta':'$idMeta',
        'error':'$error',
        'nombre_archivo':'$archivo_obs'
      }";
}
/// aprobar reporte meta reportado
if($_GET['sw']=='aprobar_reporte_meta'){
    $idRC=$_GET['x_idRC'];
    $idMeta=$_GET['x_idMeta'];
    $idMetaReporte=$_GET['x_idMetaReporte'];
    $observacion=$_GET['x_observacion'];
    $idConsultoria = $_GET['x_idConsultoria'];
   $fecha=date("dmY_His");
   $fechaCreacion=date("Y-m-d");
   $archivo_obs="";  //ojo con esta operacion

if($_FILES['archivo_revision_meta'.$idMetaReporte]['name']){

$archivo_obs=$fecha.'_'.$_FILES['archivo_revision_meta'.$idMetaReporte]['name'];
$tamano = $_FILES['archivo_revision_meta'.$idMetaReporte]['size'];
$tipo =$_FILES['archivo_revision_meta'.$idMetaReporte]['type'];
// guardamos el archivo a la carpeta files
$destino =  "files_consultoria/".$archivo_obs;
if(copy($_FILES['archivo_revision_meta'.$idMetaReporte]['tmp_name'],$destino)) {
    //$archivo_obs=$fecha.'_'.$_FILES['archivo_revision_meta'.$idMetaReporte]['name'];
}
}
if($observacion!=""){
mysql_select_db($database_conexion, $conexion);
$query_MRCadd = "INSERT INTO meta_reporte_control VALUES('','$idRC','$idMetaReporte','$observacion','$archivo_obs','3','$fechaCreacion','$fechaCreacion')";
mysql_query($query_MRCadd, $conexion) or die(mysql_error());

// preguntamos si todos los usuarios han aprobado
mysql_select_db($database_conexion, $conexion);
$query_responsableConsultoria= "SELECT idRC FROM responsable_consultoria WHERE idConsultoria=$idConsultoria";
$mostrar_responsableConsultoria=mysql_query($query_responsableConsultoria, $conexion) or die(mysql_error());
$total_responsableConsultoria=mysql_num_rows($mostrar_responsableConsultoria);
$sw=1;
while($row_responsableConsultoria=mysql_fetch_assoc($mostrar_responsableConsultoria)){
mysql_select_db($database_conexion, $conexion);
$query_CRCestado= "SELECT estado FROM meta_reporte_control WHERE idRC=".$row_responsableConsultoria['idRC']." AND idMetaReporte=".$idMetaReporte." AND estado=3";
$mostrar_CRCestado=mysql_query($query_CRCestado, $conexion) or die(mysql_error());
$total_CRCestado=mysql_num_rows($mostrar_CRCestado);
if($total_CRCestado<1){$sw=0;}
}
if($sw==1){
   mysql_select_db($database_conexion, $conexion);
   $query_metaedit = "UPDATE meta_reporte SET estado=3 WHERE idMetaReporte=$idMetaReporte";
   mysql_query($query_metaedit, $conexion) or die(mysql_error());

   mysql_select_db($database_conexion, $conexion);
   $query_metaedit = "UPDATE meta SET estado=3 WHERE idMeta=$idMeta";
   mysql_query($query_metaedit, $conexion) or die(mysql_error());
}
   $sw='Se realiza la aprobacion correctamente';
                }else{$error = 'NO se pudo realizar la operacion';}

echo "{
        'idMetaReporte':'$idMetaReporte',
        'respuesta':'$sw',
        'idMeta':'$idMeta',
        'error':'$error',
        'nombre_archivo':'$archivo_obs'
      }";
}
?>
<?php

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
