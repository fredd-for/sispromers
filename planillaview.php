<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "planillainfo.php" ?>
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
$planilla_view = new cplanilla_view();
$Page =& $planilla_view;

// Page init processing
$planilla_view->Page_Init();

// Page main processing
$planilla_view->Page_Main();
?>
<?php include "header.php" ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_tipoContrato = "SELECT * FROM tipo_contrato WHERE idPlanilla='".$_GET['idPlanilla']."'";
$mostrar_tipoContrato = mysql_query($query_tipoContrato, $conexion) or die(mysql_error());


mysql_select_db($database_conexion, $conexion);
$query_registroContrato = "SELECT * FROM registro_contrato WHERE idPlanilla='".$_GET['idPlanilla']."'";
$mostrar_registroContrato = mysql_query($query_registroContrato, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_pregunta = "SELECT * FROM pregunta WHERE idPlanilla='".$_GET['idPlanilla']."'";
$mostrar_pregunta = mysql_query($query_pregunta, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_planilla = "SELECT * FROM planilla WHERE idPlanilla='".$_GET['idPlanilla']."'";
$mostrar_planilla = mysql_query($query_planilla, $conexion) or die(mysql_error());
$row_planilla= mysql_fetch_assoc($mostrar_planilla);
?>

<script language="javascript" type="text/javascript" src="../jquery/jquery-1.3.2.min.js"></script>
<script language="javascript" type="text/javascript" src="../jquery/jquery.blockUI.js"></script>
<script language="javascript" type="text/javascript" src="../jquery/jquery.validate.1.5.2.js"></script>
<script LANGUAGE="JavaScript">

function confirmarDelete()
{
var agree=confirm("Est\u00e1 seguro de eliminar el contrato.");
if (agree)
return true ;
else
return false ;

}
</script>
<script type="text/javascript">
var x=$(document);
x.ready(inicializarEventos);
function inicializarEventos()
{
var x,y,z;
x=$("#x_td a");

x.click(presionFila);
y=$("#x_tdRegistroContrato a");
y.click(presiona_registroContrato);
z=$("#x_tdPregunta a");
z.click(presiona_pregunta);
}
function presionFila() {
var pagina=$(this).attr("href");
var carga=$("#carga_tipoContrato");
carga.load(pagina);
carga.show("slow");
return false;
}
function presiona_registroContrato()    {
var pagina=$(this).attr("href");
var carga=$("#carga_registroContrato");
carga.load(pagina);
carga.show("slow");
return false;
}
function presiona_pregunta(){
var pagina=$(this).attr("href");
var carga=$("#carga_pregunta");
carga.load(pagina);
carga.show("slow");
return false;
}

function fn_cancelar(){
var carga=$("#carga_tipoContrato");
//    var cerrar=$("#cerrar");
carga.hide("slow");
}
function fn_cancelarRegistroContrato(){
var carga=$("#carga_registroContrato");
//    var cerrar=$("#cerrar");
carga.hide("slow");
}
function fn_cancelarPregunta(){
var carga=$("#carga_pregunta");
//    var cerrar=$("#cerrar");
carga.hide("slow");
}

</script>

<script type="text/javascript">
<!--
var ew_DHTMLEditors = [];

//-->
</script>
<span class="phpmaker"><a href="<?php echo $planilla->getReturnUrl() ?>">Volver atras</a></span>
<?php $planilla_view->ShowMessage() ?>
<div align="center" style="font-size:15px; color:red;">
<?php echo strtoupper($row_planilla['Nombre']) ;?>
</div>

<div class="titulo">
DATOS GENERALES DE LA MERS
</div>
<div class="contenido">
Nombre de la Unidad Productiva:	_____________________________________________   C&oacute;digo	___________   La Unidad Productiva se dedica a:_________________________________________________<br>
Regional: __________________________    Departamento: __________________________    Municipio: __________________________ Comunidad: __________________________ Zona: ______________________<br>
Direcci&oacute;n: _____________________ Referencia: ____________________________    Ref. Telefonica:_________________  Ref. Celular: _________________ Nro de Socios: __________________________<br>
</div>
<div class="titulo">
DATOS DEL RESPONSABLE
</div>
<div class="contenido">
Tecnico Responsable:	____________________________________	Periodo:___________  al ___________ Gesti&oacute;n: ___________<br>
</div>
<br>
<?php
if($row_planilla['idPlanilla']=='1'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">CONTRATO DE SERVICIO</div></td></tr>
        <tr><td colspan="11" class="ewTableHeader" align="center">REGISTRO DE LOS CONTRATOS DE LA MERS</td></tr>
        <tr class="ewTableHeader">
            <td>TIPO DE CONTRATOS</td>
            <td id="x_td"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=tipoContrato" title="agregar" id="contrato"><img src="images/add.png" border="none"></a><?php } ?></td>
            <td>&nbsp;</td><td>Nro Contratos</td><td>Tipo de Contrato(*)</td><td>Registro por recibos/planillas (*)</td><td>Fecha Inicio</td><td>Fecha Finalizacion</td><td>Valor Bs.</td><td>Completo</td><td>Cert. Conformidad(x)</td>
        </tr>

        <?php
        while($row_tipoContrato=mysql_fetch_assoc($mostrar_tipoContrato)) {?>
        <tr>
            <td><?php echo $row_tipoContrato['tipoContrato']?></td>
            <td id="x_td"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=tipoContratoedit&idTipoContrato=<?php echo $row_tipoContrato['idTipoContrato'];?>" title="editar contrato" id="contratoedit"><img src="images/page_edit.png" border="none"></a><?php }?></td>
            <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=tipoContratodelete&idTipoContrato=<?php echo $row_tipoContrato['idTipoContrato'];?>" title="borrar contrato" id="contratodelete" onClick="return confirmarDelete();"><img src="images/delete.png" border="none"></a><?php } ?></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <?php } ?>
        <tr><td colspan="11"><div id="carga_tipoContrato"></div></td></tr>
        <tr class="ewTableHeader">
            <td>REGISTRO DE LOS CONTRATOS</td>
            <td id="x_tdRegistroContrato"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=registroContrato" title="agregar" id="contrato"><img src="images/add.png" border="none"></a><?php } ?></td>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <?php
        while($row_registroContrato=mysql_fetch_assoc($mostrar_registroContrato)) {?>
        <tr>
            <td><?php echo $row_registroContrato['registroContrato']?></td>
            <td id="x_tdRegistroContrato"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=registroContratoedit&idRegistroContrato=<?php echo $row_registroContrato['idRegistroContrato'];?>" title="editar contrato" id="contratoedit"><img src="images/page_edit.png" border="none"></a><?php } ?></td>
            <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=registroContratodelete&idRegistroContrato=<?php echo $row_registroContrato['idRegistroContrato'];?>" title="borrar contrato" id="contratodelete" onClick="return confirmarDelete();"><img src="images/delete.png" border="none"></a><?php } ?></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <?php }?>
        <tr><td colspan="11"><div id="carga_registroContrato"></div></td></tr>
    </table>
    <input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $_GET['idPlanilla']?>">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="5"><div class="titulo">RESUMEN DEL FORMULARIO</div></td></tr>
        <tr>
            <td class="ewTableHeader">Numero de Contratos</td><td><img src="images/cuadrado.png" height="15" width="15"></td><td>&nbsp;</td>
            <td class="ewTableHeader">Cuenta con un contrato de venta y servicio</td><td><img src="images/cuadrado.png" height="15" width="15" border="none"></td>
        </tr>
        <tr>
            <td class="ewTableHeader">Numero de Recibos</td><td><img src="images/cuadrado.png" height="15" width="15"></td><td>&nbsp;</td>
            <td class="ewTableHeader">Numero de Contratos Completos</td><td><img src="images/cuadrado.png" height="15" width="15" border="none"></td>
        </tr>
        <tr>
            <td class="ewTableHeader">Numero de Registros en libro</td><td><img src="images/cuadrado.png" height="15" width="15"></td><td>&nbsp;</td>
            <td class="ewTableHeader">Cuenta con Certificado de conformidad</td><td><img src="images/cuadrado.png" height="15" width="15" border="none"></td>
        </tr>

    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">CONTRATO VENTA/SERVICIO</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img src="images/add.png" border="none"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img src="images/cuadrado.png" height="15" width="15" border="none"></td><td><img src="images/cuadrado.png" height="15" width="15" border="none"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div>
</td></tr></table>
</form>
<?php } ?>
<?php
if($row_planilla['idPlanilla']=='2'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">PLAN DE NEGOCIO</div></td></tr>
        <tr><td>LA MERS CUENTA CON UN PLAN DE NEGOCIO:<td>&nbsp;</td></tr>
        <tr><td>EN PROCESO %:</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">El plan de negocio cuenta con:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>

<?php
if($row_planilla['idPlanilla']=='3'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">PLAN ESTRATEGICO</div></td></tr>
        <tr><td>LA MERS CUENTA CON UN PLAN DE ESTRATEGICO:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">El plan estrategico cuenta con:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>

<?php
if($row_planilla['idPlanilla']=='4'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">PLAN FINANCIERO</div></td></tr>
        <tr><td>LA MERS CUENTA CON UN PLAN DE FINANCIERO:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">El plan financiero cuenta con:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>

<?php
if($row_planilla['idPlanilla']=='5'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">PLAN DE PRODUCCI&Oacute;N</div></td></tr>
        <tr><td>LA MERS CUENTA CON UN PLAN DE PRODUCCI&Oacute;N:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">El plan de producci&oacute;n cuenta con:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>
<?php
if($row_planilla['idPlanilla']=='6'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">PLAN OPERTATIVO ANUAL (POA)</div></td></tr>
        <tr><td>LA MERS CUENTA CON UN POA:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">El plan opertativo anual cuenta con:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>

<?php
if($row_planilla['idPlanilla']=='7'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">CONSTITUCI&Oacute;N DE LA MERS</div></td></tr>
        <tr><td>LA MERS CUENTA CON ACTA DE CONSTITUCI&Oacute;N:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">El acta de la constituci&oacute;n de la MERS cuenta con:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>
<?php if($row_planilla['idPlanilla']=='8'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">ESTATUTO ORGANICO</div></td></tr>
        <tr><td>LA MERS CUENTA CON UN ESTATUTO ORGANICO:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">El estatuto organico cuenta con:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>
<?php if($row_planilla['idPlanilla']=='9'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">REGLAMENTO INTERNO</div></td></tr>
        <tr><td>LA MERS CUENTA CON UN REGLAMENTO INTERNO:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">El reglamento interno cuenta con:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>
<?php if($row_planilla['idPlanilla']=='10'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">TARJETA EMPRESARIAL</div></td></tr>
        <tr><td>LA MERS CUENTA CON UNA TARJETA EMPRESARIAL:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">La tarjeta empresarial en tramite:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>
<?php if($row_planilla['idPlanilla']=='11'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">REGISTRO FUNDAEMPRESA</div></td></tr>
        <tr><td>LA MERS CUENTA CON UN REGISTRO FUNDAEMPRESA:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">En tramite:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>
<?php if($row_planilla['idPlanilla']=='12'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">DOCUMENTO DE CONTRATO MUNICIPIO - MERS</div></td></tr>
        <tr><td>EL MUNICIPIO CONTRATO SERVICIOS DE LA MERS:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">Contratos:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>
<?php if($row_planilla['idPlanilla']=='13'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">DOCUMENTOS DE LA RUEDA DE NEGOCIOS</div></td></tr>
        <tr><td>LA MERS PARTICIPO DE EVENTOS ORGANIZADOS POR EL MUNICIPIO:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">Eventos de apoyo municipio al sector productivo:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>

<?php
if($row_planilla['idPlanilla']=='14'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">ALIANZA PUBLICA-PRIVADA</div></td></tr>
        <tr><td colspan="11" class="ewTableHeader" align="center">REGISTRO DE ALIANZA</td></tr>
        <tr class="ewTableHeader">
            <td>TIPO DE ALIANZA</td>
            <td id="x_td"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=tipoContrato" title="agregar" id="contrato"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td><td>Nro de Alianzas</td><td>Tipo de Alianzas(*)</td><td>Motivo de la Alianza (*)</td><td>Valor Monetario</td><td>Fecha Inicio</td><td>Fecha Finalizacion</td><td>Completo</td>
        </tr>

        <?php
        while($row_tipoContrato=mysql_fetch_assoc($mostrar_tipoContrato)) {?>
        <tr>
            <td><?php echo $row_tipoContrato['tipoContrato']?></td>
            <td id="x_td"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=tipoContratoedit&idTipoContrato=<?php echo $row_tipoContrato['idTipoContrato'];?>" title="editar contrato" id="contratoedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
            <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=tipoContratodelete&idTipoContrato=<?php echo $row_tipoContrato['idTipoContrato'];?>" title="borrar contrato" id="contratodelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <?php } ?>
        <tr><td colspan="11"><div id="carga_tipoContrato"></div></td></tr>
        <tr class="ewTableHeader">
            <td>MOTIVO DE LA ALIANZA</td>
            <td id="x_tdRegistroContrato"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=registroContrato" title="agregar" id="contrato"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <?php
        while($row_registroContrato=mysql_fetch_assoc($mostrar_registroContrato)) {?>
        <tr>
            <td><?php echo $row_registroContrato['registroContrato']?></td>
            <td id="x_tdRegistroContrato"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=registroContratoedit&idRegistroContrato=<?php echo $row_registroContrato['idRegistroContrato'];?>" title="editar contrato" id="contratoedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
            <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=registroContratodelete&idRegistroContrato=<?php echo $row_registroContrato['idRegistroContrato'];?>" title="borrar contrato" id="contratodelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <?php }?>
        <tr><td colspan="10"><div id="carga_registroContrato"></div></td></tr>
    </table>
    <input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $_GET['idPlanilla']?>">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="5"><div class="titulo">RESUMEN DEL FORMULARIO</div></td></tr>
        <tr>
            <td class="ewTableHeader">La MERS tiene alianza Publico-Privada</td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td>&nbsp;</td>
            <td class="ewTableHeader">Numero de Alianza Publico-Privada</td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
        </tr>

    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">El documento de la alianza resalta:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div>
</td></tr></table>
</form>
<?php } ?>

<?php if($row_planilla['idPlanilla']=='15'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">PORCENTAJE DE CUMPLIMIENTO RESPECTO AL PLAN DE NEGOCIO</div></td></tr>
        <tr><td>LA MERS ALCANZA EL (%):</td><td>&nbsp;</td></tr>
        <tr><td>CUMPLE CON LO PROYECTADO:</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="9"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">Tiene plan de negocion (u otro Plan):</td>
            <td align="center"><input type="text" size="10" readonly></td>
            <td colspan="6">&nbsp;</td>


        </tr>
        <tr class="ewTableHeader">
            <td>&nbsp;</td><td>&nbsp;</td><td>Fecha Inicio</td><td>Fecha Final</td><td>Planificado</td><td>Alcanzado</td><td>Porcentaje</td><td>&nbsp;</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td>
            <td><?php echo $row_pregunta['pregunta']?></td>
            <td align="center"><input type="text" size="10" readonly></td>
            <td align="center"><input type="text" size="10" readonly></td>
            <td align="center"><input type="text" size="10" readonly></td>
            <td align="center"><input type="text" size="10" readonly></td>
           <td>&nbsp;</td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>

</div></td></tr></table></form>
<?php } ?>

<?php if($row_planilla['idPlanilla']=='16'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">DOCUMENTO DE PRESTAMO</div></td></tr>
        <tr><td>LA MERS CUENTA CON UN PRESTAMO:</td><td colspan="3"><input type="text" readonly size="10"></td></tr>
        <tr><td>SE ENCUENTRA CON MORA:</td><td><input type="text" readonly size="10">(SI/NO)</td><td>Fecha Ultimo Recibo:</td><td><input type="text" readonly size="10"></td></tr>
        <tr><td>OBSERVACIONES:</td><td colspan="3">_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">En Proceso:</td>
            <td>SI</td>
            <td>NO</td>

        </tr>
        <tr><td>1</td><td>Solicitud</td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td></tr>
        <tr><td>2</td><td>Entidad Financiera</td><td colspan="2"><input type="text" size="50" readonly></td></tr>
        <tr><td>3</td><td>Otorgacion de Prestamo</td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td></tr>
        <tr><td>4</td><td>Monto solicitado</td><td colspan="4">Bs.<input type="text" size="20" readonly></td></tr>

    </table>
</div></td></tr></table></form>
<?php } ?>

<?php if($row_planilla['idPlanilla']=='17'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">REGISTRO DE VENTAS</div></td></tr>
        <tr><td>LA MERS CUENTA CON UN REGISTRO DE VENTAS:</td><td><input type="text" readonly size="10"></td><td>VALOR TOTAL BS. :</td><td><input type="text" readonly size="10"></td></tr>
        <tr><td>OBSERVACIONES:</td><td colspan="5">_______________________________________________</td></tr>
    </table>
<table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">REGISTRO DE VENTAS/SERVICIOS</div></td></tr>
        <tr><td colspan="11" class="ewTableHeader" align="center">REGISTRO DE VENTAS/SERVICIOS</td></tr>
        <tr class="ewTableHeader">
            <td>Nro Comprabante</td><td>Tipo de Comprobante</td><td>Nombre y Apellido del Comprador</td><td>Detalle de ventas Producto/Servicio</td>
            <td>Precio Unitario</td><td>Cantidad</td><td>Valor Total Bs.</td><td>Fecha</td><td colspan="2">Cumple</td>

        <tr>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
          <tr class="ewTableHeader">
              <td colspan="2">Nro. de registros de recibo/factura</td>
              <td colspan="8"><input type="text" readonly size="10">..........................................................................................................................................................................................</td>
        </tr>
    </table>
</div></td></tr></table></form>
<?php } ?>

<?php if($row_planilla['idPlanilla']=='18'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">REGISTRO DE CONTABLES</div></td></tr>
        <tr><td>LA MERS CUENTA CON UN REGITRO CONTABLE:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">Registros contables actualizados de:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>
<?php if($row_planilla['idPlanilla']=='19'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">PERSONERIA JURIDICA</div></td></tr>
        <tr><td>LA MERS CUENTA CON PERSONERIA JURIDICA:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">La personeria juridica cuenta con:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>

<?php
if($row_planilla['idPlanilla']=='20'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">CONTRATO DE TRABAJO</div></td></tr>
        <tr><td colspan="11" class="ewTableHeader" align="center">REGISTRO DE CONTRATOS</td></tr>
        <tr class="ewTableHeader">
            <td>TIPO DE CONTRATOS(*)</td>
            <td id="x_td"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=tipoContrato" title="agregar" id="contrato"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td><td>Nro de Empleos</td><td>Tipo de Contrato(*)</td><td>Registro por recibos/planillas (*)</td><td>Fecha Inicio</td><td>Fecha Finalizacion</td><td>Precio Unitario</td><td>Cumple</td><td>Valor</td>
        </tr>

        <?php
        while($row_tipoContrato=mysql_fetch_assoc($mostrar_tipoContrato)) {?>
        <tr>
            <td><?php echo $row_tipoContrato['tipoContrato']?></td>
            <td id="x_td"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=tipoContratoedit&idTipoContrato=<?php echo $row_tipoContrato['idTipoContrato'];?>" title="editar contrato" id="contratoedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
            <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=tipoContratodelete&idTipoContrato=<?php echo $row_tipoContrato['idTipoContrato'];?>" title="borrar contrato" id="contratodelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <?php } ?>
        <tr><td colspan="11"><div id="carga_tipoContrato"></div></td></tr>
        <tr class="ewTableHeader">
            <td>REGISTRO DE LOS CONTRATOS(**)</td>
            <td id="x_tdRegistroContrato"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=registroContrato" title="agregar" id="contrato"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <?php
        while($row_registroContrato=mysql_fetch_assoc($mostrar_registroContrato)) {?>
        <tr>
            <td><?php echo $row_registroContrato['registroContrato']?></td>
            <td id="x_tdRegistroContrato"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=registroContratoedit&idRegistroContrato=<?php echo $row_registroContrato['idRegistroContrato'];?>" title="editar contrato" id="contratoedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
            <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=registroContratodelete&idRegistroContrato=<?php echo $row_registroContrato['idRegistroContrato'];?>" title="borrar contrato" id="contratodelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <?php }?>
        <tr><td colspan="11"><div id="carga_registroContrato"></div></td></tr>
    </table>
    <input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $_GET['idPlanilla']?>">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="5"><div class="titulo">RESUMEN DEL FORMULARIO</div></td></tr>
        <tr>
            <td class="ewTableHeader">Numero de empleos generados en el periodo (Cumplen requisito)</td><td><input type="text" size="10" readonly></td>
        </tr>
       </table>
 </div>
</td></tr></table>
</form>
<?php } ?>


<?php if($row_planilla['idPlanilla']=='21'){
?>
<form action="planillaedit.php" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="11"><div class="titulo">PARAMETROS DE CALIDAD</div></td></tr>
        <tr><td>LA MERS CUENTA CON PARAMETROS DE CALIDAD:</td><td>&nbsp;</td></tr>
        <tr><td>EN PROCESO % :</td><td>&nbsp;</td></tr>
        <tr><td>OBSERVACIONES:</td><td>_______________________________________________</td></tr>
    </table>
    <table cellspacing="0" class="ewTable">
        <tr><td colspan="6"><div class="titulo">Ckeck List</div></td></tr>
        <tr><td colspan="2">Los parametros de calidad cuentan con:</td>
            <td>SI</td>
            <td>NO</td>
            <td id="x_tdPregunta"><?php if ($Security->CanAdd()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=pregunta" title="agregar" id="pregunta"><img border="none" src="images/add.png"></a><?php } ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $cont=1;
        while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)) {?>
        <tr><td><?php echo $cont?></td><td><?php echo $row_pregunta['pregunta']?></td>
            <td><img border="none" src="images/cuadrado.png" height="15" width="15"></td><td><img border="none" src="images/cuadrado.png" height="15" width="15"></td>
            <td id="x_tdPregunta"><?php if ($Security->CanEdit()) {?><a href="planilla_agregar.php?idPlanilla=<?php echo $_GET['idPlanilla']?>&sw=preguntaedit&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="editar pregunta" id="preguntaedit"><img border="none" src="images/page_edit.png"></a><?php } ?></td>
        <td><?php if ($Security->CanDelete()) {?><a href="planilla_guardar.php?x_idPlanilla=<?php echo $_GET['idPlanilla'];?>&sw=preguntadelete&idPregunta=<?php echo $row_pregunta['idPregunta'];?>" title="borrar pregunta" id="preguntadelete" onClick="return confirmarDelete();"><img border="none" src="images/delete.png"></a><?php } ?></td>
        </tr>
        <?php   $cont++;       }?>
        <tr><td colspan="11"><div id="carga_pregunta"></div></td></tr>
    </table>
</div></td></tr></table></form>
<?php } ?>

<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cplanilla_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'planilla';

	// Page Object Name
	var $PageObjName = 'planilla_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $planilla;
		if ($planilla->UseTokenInUrl) $PageUrl .= "t=" . $planilla->TableVar . "&"; // add page token
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
		global $objForm, $planilla;
		if ($planilla->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($planilla->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($planilla->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cplanilla_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["planilla"] = new cplanilla();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'planilla', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $planilla;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->TableName);
		$Security->TablePermission_Loaded();

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
	var $lRecCnt;

	//
	// Page main processing
	//
	function Page_Main() {
		global $planilla;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idPlanilla"] <> "") {
				$planilla->idPlanilla->setQueryStringValue($_GET["idPlanilla"]);
			} else {
				$sReturnUrl = "planillalist.php"; // Return to list
			}

			// Get action
			$planilla->CurrentAction = "I"; // Display form
			switch ($planilla->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "planillalist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "planillalist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$planilla->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $planilla;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$planilla->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$planilla->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $planilla->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$planilla->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$planilla->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$planilla->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $planilla;
		$sFilter = $planilla->KeyFilter();

		// Call Row Selecting event
		$planilla->Row_Selecting($sFilter);

		// Load sql based on filter
		$planilla->CurrentFilter = $sFilter;
		$sSql = $planilla->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$planilla->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $planilla;
		$planilla->idPlanilla->setDbValue($rs->fields('idPlanilla'));
		$planilla->Nombre->setDbValue($rs->fields('Nombre'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $planilla;

		// Call Row_Rendering event
		$planilla->Row_Rendering();

		// Common render codes for all row types
		// idPlanilla

		$planilla->idPlanilla->CellCssStyle = "";
		$planilla->idPlanilla->CellCssClass = "";

		// Nombre
		$planilla->Nombre->CellCssStyle = "";
		$planilla->Nombre->CellCssClass = "";
		if ($planilla->RowType == EW_ROWTYPE_VIEW) { // View row

			// idPlanilla
			$planilla->idPlanilla->ViewValue = $planilla->idPlanilla->CurrentValue;
			$planilla->idPlanilla->CssStyle = "";
			$planilla->idPlanilla->CssClass = "";
			$planilla->idPlanilla->ViewCustomAttributes = "";

			// Nombre
			$planilla->Nombre->ViewValue = $planilla->Nombre->CurrentValue;
			$planilla->Nombre->CssStyle = "";
			$planilla->Nombre->CssClass = "";
			$planilla->Nombre->ViewCustomAttributes = "";

			// idPlanilla
			$planilla->idPlanilla->HrefValue = "";

			// Nombre
			$planilla->Nombre->HrefValue = "";
		}

		// Call Row Rendered event
		$planilla->Row_Rendered();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}
}
?>
