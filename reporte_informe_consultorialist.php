<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "reporte_informe_consultoriainfo.php" ?>
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
$reporte_informe_consultoria_list = new creporte_informe_consultoria_list();
$Page =& $reporte_informe_consultoria_list;

// Page init processing
$reporte_informe_consultoria_list->Page_Init();

// Page main processing
$reporte_informe_consultoria_list->Page_Main();
?>
<?php include "header.php";
function color_estado($valor){
    if($valor=='3'){
        return '#D7E4BC';       //verde
    }
    if($valor=='2'){
        return '#fbffba';       // amarillo
    }
    if($valor=='1' || $valor==''){
        return '#FEB0A0';       // rojo
    }
}

function diasEntreFechas($inicio, $fin) {
    $diasFalt = 0;
    if($inicio){
        if ($fin > $inicio) {
            $inicio = strtotime($inicio);
            $fin = strtotime($fin);
            $dif = $fin - $inicio;
            $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
        }
    }
    return ceil($diasFalt);
}
?>
<script language="javascript" type="text/javascript">
                $(document).ready(function(){
                        $("#tab").tab();
                });
</script>

<div id="tab" class="tab">
<ul>
<li><a href="#tab1">Reporte Consultores</a></li>
<li><a href="#tab2">Revision Gerentes</a></li>
<li><a href="#tab3">Cronogramas - Reportes Atrasados</a></li>
<li><a href="#tab4">Reporte Dias Retraso</a></li>
</ul>
<div id="tab1">
<table border='0' align='center' cellpadding='0' cellspacing='0' class='bordes' id="table_example">
    <thead>
    <tr bgcolor="#B8C692">
        <th>Nro</th>
        <th>Resposanble</th>
        <th>Nombre Consultoria</th>
        <th>Cronograma</th>
        <th>Fecha Reporte</th>
        <th>Estado</th>
    </tr>
    </thead>
<tbody id="contenidoTbody">
<?php
mysql_select_db($database_conexion, $conexion);
switch ($_SESSION['idRol']) {
    case 2:
//echo $_SESSION['idUsuario'];
$query_cronogramaReporte= "SELECT b.idConsultoria,c.idCronograma,a.idUsuario,e.nombre,e.paterno,e.materno,b.consultoria,c.detalle,d.fechaCreacion,d.estado,
(case d.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estadoLiteral
FROM
responsable_consultoria AS a
Inner Join consultoria AS b ON a.idConsultoria = b.idConsultoria
Inner Join cronograma AS c ON b.idConsultoria = c.idConsultoria
Inner Join cronograma_reporte AS d ON c.idCronograma = d.idCronograma
Inner Join usuario AS e ON b.idUsuario = e.idUsuario
WHERE a.idUsuario ='".$_SESSION['idUsuario']."' AND b.estado=1 ORDER BY d.fechaCreacion desc, d.idCronogramaReporte desc
LIMIT 50";
    //return $query_CRC;
        break;
    case 3:
$query_cronogramaReporte= "SELECT a.idConsultoria,b.idCronograma,d.nombre,d.paterno,d.materno,a.consultoria,b.detalle,c.fechaCreacion,
c.estado,(case c.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estadoLiteral
FROM
consultoria AS a
Inner Join cronograma AS b ON a.idConsultoria = b.idConsultoria
Inner Join cronograma_reporte AS c ON b.idCronograma = c.idCronograma
Inner Join usuario AS d ON a.idUsuario = d.idUsuario
WHERE a.idUsuario ='".$_SESSION['idUsuario']."' AND a.estado=1 ORDER BY c.fechaCreacion desc, c.idCronogramaReporte desc LIMIT 50";
        break;
    default:
$query_cronogramaReporte= "SELECT c.idConsultoria,b.idCronograma,c.consultoria,d.nombre,d.paterno,d.materno,b.detalle,a.fechaCreacion,(case a.estado  when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estadoLiteral, a.estado
FROM cronograma_reporte AS a
Inner Join cronograma AS b ON a.idCronograma = b.idCronograma
Inner Join consultoria AS c ON b.idConsultoria = c.idConsultoria
Inner Join usuario AS d ON a.idUsuario = d.idUsuario
WHERE c.estado=1
ORDER BY a.fechaCreacion desc, a.idCronogramaReporte desc LIMIT 50";

    //return $query_CRC;
        break;
}
$mostrar_cronogramaReporte=mysql_query($query_cronogramaReporte, $conexion) or die(mysql_error());
$total_cronogramaReporte=mysql_num_rows($mostrar_cronogramaReporte);
$contador=1;
$blanco = '#FFFFFF';
$gris = '#F1FED8';
while($row_cronogramaReporte=mysql_fetch_assoc($mostrar_cronogramaReporte)){
                if ($contador % 2 == 0) {
                    $color = $blanco;
                }else
                    {$color=$gris;}
    ?>

<tr bgcolor="<?php echo $color?>">
            <td><?php echo $contador?></td>
            <td><?php echo $row_cronogramaReporte['paterno'].' '.$row_cronogramaReporte['materno'].' '.$row_cronogramaReporte['nombre']?></td>
            <td><?php echo $row_cronogramaReporte['consultoria']?></td>
            <td><a href="avance_productolist.php?idConsultoria=<?php echo $row_cronogramaReporte['idConsultoria']?>&idCronograma=<?php echo $row_cronogramaReporte['idCronograma']?>"><?php echo $row_cronogramaReporte['detalle']?></a></td>
            <td><?php echo date("d-m-Y",strtotime($row_cronogramaReporte['fechaCreacion']))?></td>
            <td bgcolor="<?php echo color_estado($row_cronogramaReporte['estado'])?>"><?php echo $row_cronogramaReporte['estadoLiteral']?></td>
 </tr>
<?php 
$contador++;
} ?>
    </tbody>
</table>
</div>
<div id="tab2">
<table border='0' align='center' cellpadding='0' cellspacing='0' class='bordes' id="table_example">
    <thead>
    <tr bgcolor="#B8C692">
        <th>Nro</th>
        <th>Revisor Gerente</th>
        <th>Nombre Consultoria</th>
        <th>Cronograma</th>
        <th>Fecha Revisi&oacute;n</th>
        <th>Estado</th>
    </tr>
    </thead>
<tbody id="contenidoTbody">
<?php

mysql_select_db($database_conexion, $conexion);
switch ($_SESSION['idRol']) {
    case 2:   //usuario revisor
//echo $_SESSION['idUsuario'];
$query_CRC= "SELECT b.idConsultoria,c.idCronograma,b.consultoria,e.estado,e.fechaCreacion,e.idRC,
(SELECT concat(q.paterno,' ',q.nombre) FROM responsable_consultoria p, usuario q WHERE p.idRC=e.idRC AND p.idUsuario=q.idUsuario) as revisor,
(case e.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estadoLiteral, c.detalle
FROM
responsable_consultoria AS a
Inner Join consultoria AS b ON a.idConsultoria = b.idConsultoria
Inner Join cronograma AS c ON b.idConsultoria = c.idConsultoria
Inner Join cronograma_reporte AS d ON c.idCronograma = d.idCronograma
Inner Join cronograma_reporte_control AS e ON d.idCronogramaReporte = e.idCronogramaReporte
WHERE a.idUsuario ='".$_SESSION['idUsuario']."' AND b.estado=1 ORDER BY e.fechaCreacion desc, e.idCronogramaReporteControl desc LIMIT 50";
    //return $query_CRC;
        break;
    case 3:    // usuario consultor
        $query_CRC= "SELECT a.idConsultoria,b.idCronograma,a.consultoria,d.idRC,b.detalle,d.fechaCreacion,
d.estado, (case d.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estadoLiteral,
concat(f.paterno,' ',f.nombre) as revisor
FROM
consultoria AS a
Inner Join cronograma AS b ON a.idConsultoria = b.idConsultoria
Inner Join cronograma_reporte AS c ON b.idCronograma = c.idCronograma
Inner Join cronograma_reporte_control AS d ON c.idCronogramaReporte = d.idCronogramaReporte
Inner Join responsable_consultoria AS e ON d.idRC = e.idRC
Inner Join usuario AS f ON e.idUsuario = f.idUsuario
WHERE a.idUsuario ='".$_SESSION['idUsuario']."' AND a.estado=1 ORDER BY d.fechaCreacion desc, d.idCronogramaReporteControl desc LIMIT 50";
        break;
    default:     // los demas usuarios
$query_CRC= "SELECT f.idConsultoria,e.idCronograma,concat(c.paterno,' ',c.nombre) as revisor,f.consultoria,e.detalle,a.fechaCreacion,(case a.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estadoLiteral, a.estado
FROM
cronograma_reporte_control AS a
Inner Join responsable_consultoria AS b ON a.idRC = b.idRC
Inner Join usuario AS c ON b.idUsuario = c.idUsuario
Inner Join cronograma_reporte AS d ON a.idCronogramaReporte = d.idCronogramaReporte
Inner Join cronograma AS e ON d.idCronograma = e.idCronograma
Inner Join consultoria AS f ON e.idConsultoria=f.idConsultoria
WHERE f.estado=1
ORDER BY a.fechaCreacion desc, a.idCronogramaReporteControl desc LIMIT 50";
    //return $query_CRC;
        break;
}


$mostrar_CRC=mysql_query($query_CRC, $conexion) or die(mysql_error());
$total_CRC=mysql_num_rows($mostrar_CRC);
$contador=1;
$blanco = '#FFFFFF';
$gris = '#F1FED8';
while($row_CRC=mysql_fetch_assoc($mostrar_CRC)){
                if ($contador % 2 == 0) {
                    $color = $blanco;
                }else
                    {$color=$gris;}
    ?>
<tr bgcolor="<?php echo $color?>">
            <td><?php echo $contador?></td>
            <td><?php echo $row_CRC['revisor']?></td>
            <td><?php echo $row_CRC['consultoria']?></td>
            <td><a href="avance_productolist.php?idConsultoria=<?php echo $row_CRC['idConsultoria']?>&idCronograma=<?php echo $row_CRC['idCronograma']?>"><?php echo $row_CRC['detalle']?></a></td>
            <td><?php echo date("d-m-Y", strtotime($row_CRC['fechaCreacion']))?></td>
            <td bgcolor="<?php echo color_estado($row_CRC['estado'])?>"><?php echo $row_CRC['estadoLiteral']?></td>
 </tr>
<?php
$contador++;
} ?>
    </tbody>
</table>
</div>
<div id="tab3">
<table border='0' align='center' cellpadding='0' cellspacing='0' class='bordes' id="table_example">
    <thead>
    <tr bgcolor="#B8C692">
        <th>Nro</th>
        <th>Nombre Consultoria</th>
        <th>Responsable</th>
        <th>Cronograma</th>
        <th>Fecha Inicial</th>
        <th>Fecha Finalizaci&oacute;n</th>
        <th>% Cumplimiento</th>
        <th>Estado</th>
    </tr>
    </thead>
<tbody id="contenidoTbody">
<?php
//  cronogramas vencidos color Rojo
$fechaHoy=date("Y-m-d");
$fecha7dias=date( "Y-m-d", mktime(0,0,0,date("m"), date("d")+7,date("Y")) );

mysql_select_db($database_conexion, $conexion);
switch ($_SESSION['idRol']) {
    case 2:   //usuario revisor
//echo $_SESSION['idUsuario'];
$query_CRC= "SELECT a.idConsultoria, a.idCronograma,b.consultoria,c.nombre,c.paterno,c.materno,a.detalle,a.fechaInicio,a.fechaFinal,a.porcentajeCumplimiento,
(case a.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) AS estadoLiteral,a.estado
FROM cronograma AS a Inner Join consultoria AS b ON a.idConsultoria = b.idConsultoria Inner Join usuario AS c ON b.idUsuario = c.idUsuario
Inner Join responsable_consultoria AS d ON b.idConsultoria = d.idConsultoria
WHERE a.fechaFinal < '$fechaHoy' AND a.estado <  '3' AND d.idUsuario =  '".$_SESSION['idUsuario']."' AND b.estado =  '1'
ORDER BY a.fechaFinal ASC";
    //return $query_CRC;
        break;
    case 3:    // usuario consultor
$query_CRC= "SELECT a.idConsultoria,a.idCronograma,b.consultoria,c.nombre,c.paterno,c.materno,a.detalle,a.fechaInicio,a.fechaFinal,a.porcentajeCumplimiento,
(case a.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estadoLiteral,a.estado
FROM cronograma AS a Inner Join consultoria AS b ON a.idConsultoria = b.idConsultoria Inner Join usuario AS c ON b.idUsuario = c.idUsuario
WHERE a.fechaFinal <  '$fechaHoy' AND a.estado <  '3' AND b.estado =  '1' AND b.idUsuario =  '".$_SESSION['idUsuario']."'
ORDER BY a.fechaFinal ASC";
        break;
    default:     // los demas usuarios
$query_CRC= "SELECT a.idConsultoria,a.idCronograma,b.consultoria,c.nombre,c.paterno,c.materno,a.detalle,a.fechaInicio,a.fechaFinal,a.porcentajeCumplimiento,
(case a.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estadoLiteral,a.estado
FROM cronograma AS a Inner Join consultoria AS b ON a.idConsultoria = b.idConsultoria Inner Join usuario AS c ON b.idUsuario = c.idUsuario
WHERE a.fechaFinal <  '$fechaHoy' AND a.estado <  '3' AND b.estado='1' ORDER BY a.fechaFinal ASC";    //return $query_CRC;
        break;
}
$mostrar_CRC=mysql_query($query_CRC, $conexion) or die(mysql_error());
$total_CRC=mysql_num_rows($mostrar_CRC);
$contador=1;
$blanco = '#FFFFFF';
$gris = '#F1FED8';
while($row_CRC=mysql_fetch_assoc($mostrar_CRC)){
                if ($contador % 2 == 0) {
                    $color = $blanco;
                }else
                    {$color=$gris;}
    ?>
<tr bgcolor="<?php echo $color?>">
            <td><?php echo $contador?></td>
            <td><?php echo $row_CRC['consultoria']?></td>
            <td><?php echo $row_CRC['paterno']." ".$row_CRC['materno']." ".$row_CRC['nombre']?></td>
            <td><a href="avance_productolist.php?idConsultoria=<?php echo $row_CRC['idConsultoria']?>&idCronograma=<?php echo $row_CRC['idCronograma']?>"><?php echo $row_CRC['detalle']?></a></td>
            <td><?php echo date("d-m-Y", strtotime($row_CRC['fechaInicio']))?></td>
            <td bgcolor="#FEB0A0"><?php echo date("d-m-Y", strtotime($row_CRC['fechaFinal']))?></td>
            <td><?php echo $row_CRC['porcentajeCumplimiento']?></td>
            <td bgcolor="#FEB0A0"><?php echo $row_CRC['estadoLiteral']?></td>
 </tr>
<?php
$contador++;
} ?>

<?php
// Proyectos por reportar color Amarillo
mysql_select_db($database_conexion, $conexion);

switch ($_SESSION['idRol']) {
    case 2:   //usuario revisor
//echo $_SESSION['idUsuario'];
$query_CRC= "SELECT a.idConsultoria, a.idCronograma,b.consultoria,c.nombre,c.paterno,c.materno,a.detalle,a.fechaInicio,a.fechaFinal,a.porcentajeCumplimiento,
(case a.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) AS estadoLiteral,a.estado
FROM cronograma AS a Inner Join consultoria AS b ON a.idConsultoria = b.idConsultoria Inner Join usuario AS c ON b.idUsuario = c.idUsuario
Inner Join responsable_consultoria AS d ON b.idConsultoria = d.idConsultoria
WHERE a.fechaFinal >=  '$fechaHoy' AND a.fechaFinal <=  '$fecha7dias' AND a.estado <  '3' AND d.idUsuario =  '".$_SESSION['idUsuario']."' AND b.estado =  '1'
ORDER BY a.fechaFinal ASC";
    //return $query_CRC;
        break;
    case 3:    // usuario consultor
$query_CRC= "SELECT a.idConsultoria,a.idCronograma,b.consultoria,c.nombre,c.paterno,c.materno,a.detalle,a.fechaInicio,a.fechaFinal,a.porcentajeCumplimiento,
(case a.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estadoLiteral,a.estado
FROM cronograma AS a Inner Join consultoria AS b ON a.idConsultoria = b.idConsultoria Inner Join usuario AS c ON b.idUsuario = c.idUsuario
WHERE a.fechaFinal >=  '$fechaHoy' AND a.fechaFinal <=  '$fecha7dias' AND a.estado <  '3' AND b.estado =  '1' AND b.idUsuario =  '".$_SESSION['idUsuario']."'
ORDER BY a.fechaFinal ASC";
        break;
    default:     // los demas usuarios
$query_CRC= "SELECT a.idConsultoria,a.idCronograma,b.consultoria,c.nombre,c.paterno,c.materno,a.detalle,a.fechaInicio,a.fechaFinal,a.porcentajeCumplimiento,
(case a.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estadoLiteral,a.estado
FROM cronograma AS a Inner Join consultoria AS b ON a.idConsultoria = b.idConsultoria Inner Join usuario AS c ON b.idUsuario = c.idUsuario
WHERE a.fechaFinal >=  '$fechaHoy' AND a.fechaFinal <=  '$fecha7dias' AND a.estado <  '3' AND b.estado='1'
ORDER BY a.fechaFinal ASC";    //return $query_CRC;
        break;
}
$mostrar_CRC=mysql_query($query_CRC, $conexion) or die(mysql_error());
$total_CRC=mysql_num_rows($mostrar_CRC);

while($row_CRC=mysql_fetch_assoc($mostrar_CRC)){
                if ($contador % 2 == 0) {
                    $color = $blanco;
                }else
                    {$color=$gris;}
    ?>
<tr bgcolor="<?php echo $color?>">
            <td><?php echo $contador?></td>
            <td><?php echo $row_CRC['consultoria']?></td>
            <td><?php echo $row_CRC['paterno']." ".$row_CRC['materno']." ".$row_CRC['nombre']?></td>
            <td><a href="avance_productolist.php?idConsultoria=<?php echo $row_CRC['idConsultoria']?>&idCronograma=<?php echo $row_CRC['idCronograma']?>"><?php echo $row_CRC['detalle']?></a></td>
            <td><?php echo date("d-m-Y", strtotime($row_CRC['fechaInicio']))?></td>
            <td bgcolor="#fbffba"><?php echo date("d-m-Y", strtotime($row_CRC['fechaFinal']))?></td>
            <td><?php echo $row_CRC['porcentajeCumplimiento']?></td>
            <td bgcolor="#fbffba"><?php echo $row_CRC['estadoLiteral']?></td>
 </tr>
<?php
$contador++;
} ?>
    </tbody>
</table>
    </div>
<div id="tab4">
<table border='0' align='center' cellpadding='0' cellspacing='0' class='bordes' id="table_example">
    <thead>
    <tr bgcolor="#B8C692">
        <th>Nro</th>
        <th>Consultoria</th>
        <th>Responsable</th>
        <th>Cronograma</th>
        <th witdh="200px">Fecha Inicial &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>Fecha Finalizaci&oacute;n</th>
<!--        <th>% Cumplimiento</th>-->
        <th>Fecha Reporte &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>Dias Retrazo</th>
        <th>Fecha Aprobaci&oacute;n</th>
        <th>Dias Revisi&oacute;n </th>
        <th>Estado</th>
    </tr>
    </thead>
<tbody id="contenidoTbody">
<?php
//  cronogramas vencidos color Rojo
$fechaHoy=date("Y-m-d");
$contador=1;
$blanco = '#FFFFFF';
$gris = '#F1FED8';
 ?>

<?php
// Proyectos por reportar color Amarillo
mysql_select_db($database_conexion, $conexion);
$query = "SELECT a.idConsultoria,a.idCronograma,b.consultoria,c.nombre,c.paterno,c.materno,a.detalle,a.fechaInicio,a.fechaFinal,a.porcentajeCumplimiento,
(case a.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estadoLiteral,a.estado,
(SELECT c.fechaCreacion FROM cronograma_reporte AS c WHERE c.idCronograma =  a.idCronograma ORDER BY c.fechaCreacion ASC LIMIT 1) as fechaReporte,
(SELECT f.fechaCreacion FROM cronograma AS d
Inner Join cronograma_reporte AS e ON d.idCronograma = e.idCronograma
Inner Join cronograma_reporte_control AS f ON e.idCronogramaReporte = f.idCronogramaReporte
WHERE d.idCronograma =  a.idCronograma AND d.estado =  '3'
ORDER BY f.fechaCreacion DESC LIMIT 1) as fechaAprobado

FROM cronograma AS a Inner Join consultoria AS b ON a.idConsultoria = b.idConsultoria Inner Join usuario AS c ON b.idUsuario = c.idUsuario
WHERE a.fechaFinal <=  '$fechaHoy' AND b.estado>0
ORDER BY b.idConsultoria ASC, a.idCronograma ASC";

$mostrar_CRC=mysql_query($query, $conexion) or die(mysql_error());
$total_CRC=mysql_num_rows($mostrar_CRC);

while($row_CRC=mysql_fetch_assoc($mostrar_CRC)){
                if ($contador % 2 == 0) {
                    $color = $blanco;
                }else
                    {$color=$gris;}
    ?>
<tr bgcolor="<?php echo $color?>">
            <td><?php echo $contador?></td>
            <td><?php echo $row_CRC['consultoria']?></td>
            <td><?php echo $row_CRC['paterno']." ".$row_CRC['materno']." ".$row_CRC['nombre']?></td>
            <td><a href="avance_productolist.php?idConsultoria=<?php echo $row_CRC['idConsultoria']?>&idCronograma=<?php echo $row_CRC['idCronograma']?>"><?php echo $row_CRC['detalle']?></a></td>
            <td><?php echo date("d-m-Y", strtotime($row_CRC['fechaInicio']))?></td>
            <td><?php echo date("d-m-Y", strtotime($row_CRC['fechaFinal']))?></td>
<!--            <td><?php //echo $row_CRC['porcentajeCumplimiento']?></td>-->
            <td><?php if($row_CRC['fechaReporte']) echo date("d-m-Y", strtotime($row_CRC['fechaReporte']));?></td>
            <td bgcolor="#fbffba"><?php if($row_CRC['fechaReporte']) {echo diasEntreFechas($row_CRC['fechaFinal'], $row_CRC['fechaReporte']);} else{echo diasEntreFechas($row_CRC['fechaFinal'], $fechaHoy);}?></td>
            <td><?php if($row_CRC['fechaAprobado']) echo date("d-m-Y",  strtotime ($row_CRC['fechaAprobado']))?></td>
            <td bgcolor="#fbffba"><?php if($row_CRC['fechaAprobado']) {echo diasEntreFechas($row_CRC['fechaReporte'], $row_CRC['fechaAprobado']);}else{echo diasEntreFechas($row_CRC['fechaReporte'], $fechaHoy);}?></td>
            <td bgcolor="<?php echo color_estado($row_CRC['estado'])?>"><?php echo $row_CRC['estadoLiteral']?></td>
 </tr>
<?php
$contador++;
} ?>
    </tbody>
</table>
    </div>    
</div>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class creporte_informe_consultoria_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'reporte_informe_consultoria';

	// Page Object Name
	var $PageObjName = 'reporte_informe_consultoria_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $reporte_informe_consultoria;
		if ($reporte_informe_consultoria->UseTokenInUrl) $PageUrl .= "t=" . $reporte_informe_consultoria->TableVar . "&"; // add page token
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
		global $objForm, $reporte_informe_consultoria;
		if ($reporte_informe_consultoria->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($reporte_informe_consultoria->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($reporte_informe_consultoria->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function creporte_informe_consultoria_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["reporte_informe_consultoria"] = new creporte_informe_consultoria();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'reporte_informe_consultoria', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $reporte_informe_consultoria;
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
	$reporte_informe_consultoria->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $reporte_informe_consultoria->Export; // Get export parameter, used in header
	$gsExportFile = $reporte_informe_consultoria->TableVar; // Get export file, used in header
	if ($reporte_informe_consultoria->Export == "print" || $reporte_informe_consultoria->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($reporte_informe_consultoria->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $reporte_informe_consultoria;
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
		if ($reporte_informe_consultoria->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $reporte_informe_consultoria->getRecordsPerPage(); // Restore from Session
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
		$reporte_informe_consultoria->setSessionWhere($sFilter);
		$reporte_informe_consultoria->CurrentFilter = "";

		// Export data only
		if (in_array($reporte_informe_consultoria->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $reporte_informe_consultoria;
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
			$reporte_informe_consultoria->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$reporte_informe_consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $reporte_informe_consultoria;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$reporte_informe_consultoria->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$reporte_informe_consultoria->CurrentOrderType = @$_GET["ordertype"];
			$reporte_informe_consultoria->UpdateSort($reporte_informe_consultoria->idConsultoria); // Field 
			$reporte_informe_consultoria->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $reporte_informe_consultoria;
		$sOrderBy = $reporte_informe_consultoria->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($reporte_informe_consultoria->SqlOrderBy() <> "") {
				$sOrderBy = $reporte_informe_consultoria->SqlOrderBy();
				$reporte_informe_consultoria->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $reporte_informe_consultoria;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$reporte_informe_consultoria->setSessionOrderBy($sOrderBy);
				$reporte_informe_consultoria->idConsultoria->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$reporte_informe_consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $reporte_informe_consultoria;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$reporte_informe_consultoria->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$reporte_informe_consultoria->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $reporte_informe_consultoria->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$reporte_informe_consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$reporte_informe_consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$reporte_informe_consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $reporte_informe_consultoria;

		// Call Recordset Selecting event
		$reporte_informe_consultoria->Recordset_Selecting($reporte_informe_consultoria->CurrentFilter);

		// Load list page SQL
		$sSql = $reporte_informe_consultoria->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$reporte_informe_consultoria->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $reporte_informe_consultoria;
		$sFilter = $reporte_informe_consultoria->KeyFilter();

		// Call Row Selecting event
		$reporte_informe_consultoria->Row_Selecting($sFilter);

		// Load sql based on filter
		$reporte_informe_consultoria->CurrentFilter = $sFilter;
		$sSql = $reporte_informe_consultoria->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$reporte_informe_consultoria->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $reporte_informe_consultoria;
		$reporte_informe_consultoria->idConsultoria->setDbValue($rs->fields('idConsultoria'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $reporte_informe_consultoria;

		// Call Row_Rendering event
		$reporte_informe_consultoria->Row_Rendering();

		// Common render codes for all row types
		// idConsultoria

		$reporte_informe_consultoria->idConsultoria->CellCssStyle = "";
		$reporte_informe_consultoria->idConsultoria->CellCssClass = "";
		if ($reporte_informe_consultoria->RowType == EW_ROWTYPE_VIEW) { // View row

			// idConsultoria
			$reporte_informe_consultoria->idConsultoria->ViewValue = $reporte_informe_consultoria->idConsultoria->CurrentValue;
			$reporte_informe_consultoria->idConsultoria->CssStyle = "";
			$reporte_informe_consultoria->idConsultoria->CssClass = "";
			$reporte_informe_consultoria->idConsultoria->ViewCustomAttributes = "";

			// idConsultoria
			$reporte_informe_consultoria->idConsultoria->HrefValue = "";
		}

		// Call Row Rendered event
		$reporte_informe_consultoria->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $reporte_informe_consultoria;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($reporte_informe_consultoria->ExportAll) {
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
		if ($reporte_informe_consultoria->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($reporte_informe_consultoria->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $reporte_informe_consultoria->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idConsultoria', $reporte_informe_consultoria->Export);
				echo ew_ExportLine($sExportStr, $reporte_informe_consultoria->Export);
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
				$reporte_informe_consultoria->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($reporte_informe_consultoria->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idConsultoria', $reporte_informe_consultoria->idConsultoria->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $reporte_informe_consultoria->Export <> "csv") { // Vertical format
						echo ew_ExportField('idConsultoria', $reporte_informe_consultoria->idConsultoria->ExportValue($reporte_informe_consultoria->Export, $reporte_informe_consultoria->ExportOriginalValue), $reporte_informe_consultoria->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $reporte_informe_consultoria->idConsultoria->ExportValue($reporte_informe_consultoria->Export, $reporte_informe_consultoria->ExportOriginalValue), $reporte_informe_consultoria->Export);
						echo ew_ExportLine($sExportStr, $reporte_informe_consultoria->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($reporte_informe_consultoria->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($reporte_informe_consultoria->Export);
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
