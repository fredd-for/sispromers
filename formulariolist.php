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
<?php include "header.php" ?>
<span class="phpmaker"><a href="merlist.php">Volver atras</a></span><br>
<script LANGUAGE="JavaScript">
function estadoHabilitar()
{
var agree=confirm("Esta seguro de habilitar la MERS.");
if (agree)
return true;
return false ;

}
</script>
<?php
mysql_select_db($database_conexion, $conexion);
$query_mer= "SELECT a.*, b.regional, c.departamento, d.municipio, e.comunidad, f.rubro FROM mer a, regional b, departamento c, municipio d, comunidad e, rubro f, responsable g WHERE a.idMer='".$_GET['idMer']."' AND a.idMer=g.idMer AND a.idRegional=b.idRegional AND a.idDepartamento=c.idDepartamento AND a.idMunicipio = d.idMunicipio AND a.idComunidad=e.idComunidad AND a.idRubro=f.idRubro";
$mostrar_mer = mysql_query($query_mer, $conexion) or die(mysql_error());
$row_mer = mysql_fetch_assoc($mostrar_mer);
$total_mer=mysql_num_rows($mostrar_mer);

mysql_select_db($database_conexion, $conexion);
$query_responsable= "SELECT b.* FROM responsable a, usuario b WHERE a.idMer='".(int)$_GET['idMer']."' AND a.idGerente=b.idUsuario";
$mostrar_responsable= mysql_query($query_responsable, $conexion) or die(mysql_error());
$row_responsable= mysql_fetch_assoc($mostrar_responsable);
$total_responsable=mysql_num_rows($mostrar_responsable);

if($total_mer>0) {
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<tr class="titulo">
<th colspan="10" align="left"> DATOS GENERALES DE LA MERS</th>
</tr>
<tr>
<th class="ewTableHeader" align="left">Nombre de la unidad productiva:</th><td style="background: #d3faa5; font-size: 14px"><?php echo $row_mer['mer'];?></td>
<th class="ewTableHeader" align="left">C&oacute;digo:</th><td><?php echo $row_mer['codigo'];?></td>
<th class="ewTableHeader" align="left">La Unidad Productiva se dedica a:</td><td colspan="5"><?php echo $row_mer['unidadProductivaDedica'];?></td>
</tr>
<tr>
<th class="ewTableHeader" align="left">Regional:</th><td><?php echo $row_mer['regional'];?></td>
<th class="ewTableHeader" align="left">Departamento:</th><td><?php echo $row_mer['departamento'];?></td>
<th class="ewTableHeader" align="left">Municipio:</th><td><?php echo $row_mer['municipio'];?></td>
<th class="ewTableHeader" align="left">Comunidad:</th><td><?php echo $row_mer['comunidad'];?></td>
<th class="ewTableHeader" align="left">Zona:</th><td><?php echo $row_mer['zona'];?></td>
</tr>
<tr>
<th class="ewTableHeader" align="left">Direcci&oacute;n:</th><td><?php echo $row_mer['direccion'];?></td>
<th class="ewTableHeader" align="left">Referencia:</th><td><?php echo $row_mer['referencia'];?></td>
<th class="ewTableHeader" align="left">Ref. Telefonica:</th><td><?php echo $row_mer['refTelefonica'];?></td>
<th class="ewTableHeader" align="left">Ref. Celular:</th><td><?php echo $row_mer['refCelular'];?></td>
<th class="ewTableHeader" align="left">Nro de Socios:</th><td><?php echo $row_mer['numeroSocios'];?></td>
</tr>
</table></div></td></tr></table>

<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<tr class="titulo">
<th colspan="10" align="left">DATOS DEL RESPONSABLE</th>
</tr>
<tr>
<th class="ewTableHeader">Tecnico Responsable:</th><td style="background: #d3faa5; font-size: 14px">&nbsp;<?php echo $row_responsable['nombre']." ".$row_responsable['paterno']." ".$row_responsable['materno'];?>&nbsp;&nbsp;</td>
<th class="ewTableHeader">Periodo:</th><td>&nbsp;<?php echo date("d-m-Y",strtotime($row_mer['fechaInicio']))." a ".date("d-m-Y", strtotime($row_mer['fechaFinal']));?>&nbsp;&nbsp;</td>
<th class="ewTableHeader">Gesti&oacute;n:</th><td colspan="5">&nbsp;2010&nbsp;&nbsp;</td>
</tr>
</table></div></td></tr></table>
<p></p>

<?php } ?>
<script type="text/javascript">
function confirmarDelete()
{
var agree=confirm("Est\u00e1 seguro de eliminar el contrato.");
if (agree)
return true ;
else
return false ;

}
function confirmarDeleteArchivo()
{
var agree=confirm("Est\u00e1 seguro de eliminar el archivo.");
if (agree)
return true ;
else
return false ;

}
function estadoDesabilitado(x)
{
var agree=confirm("Esta seguro de guardar los cambios realizados en la MERS.");
if (agree)
{var agree2=confirm("Usted no podra realizar mas cambios dentro de la MERS ");
if (agree2)
{
if(x==1){alert("Usted debe llenar el formulario 15");return false;}else{return true;}
}
else {return false;}
}
else{return false ;}

}
</script>
<script type="text/javascript" charset="utf-8">
Date.firstDayOfWeek = 0;
Date.format = 'dd-mm-yyyy';
$(function(){
$('.date-pick').datePicker({createButton:false,startDate:'01-01-1990'})
.bind('click',
function(){
$(this).dpDisplay();
this.blur();
return false;
}
);
});
//Formato del calendario
</script>
<?php
$x_idPlanilla = 0;
if(isset($_GET['idPlanilla'])) {
    $x_idPlanilla = $_GET['idPlanilla'];
}

if($x_idPlanilla=='16') {
mysql_select_db($database_conexion, $conexion);
$query_prestamo = "SELECT count(prestamo) as prestamo FROM obtencion_credito16 WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".(int)$x_idPlanilla."' AND prestamo='SI'";
$mostrar_prestamo= mysql_query($query_prestamo, $conexion) or die(mysql_error());
$row_prestamo=mysql_fetch_assoc($mostrar_prestamo);

mysql_select_db($database_conexion, $conexion);
$query_mora= "SELECT count(mora) as mora FROM obtencion_credito16 WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".(int)$x_idPlanilla."' AND mora='SI'";
$mostrar_mora= mysql_query($query_mora, $conexion) or die(mysql_error());
$row_mora=mysql_fetch_assoc($mostrar_mora);

if($row_prestamo['prestamo']>=1) {
mysql_select_db($database_conexion, $conexion);
$query_formularioP = "UPDATE formulario SET cuenta='SI' WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".(int)$x_idPlanilla."'";
$mostrar_formularioP= mysql_query($query_formularioP, $conexion) or die(mysql_error());
}else {
mysql_select_db($database_conexion, $conexion);
$query_formularioP = "UPDATE formulario SET cuenta='NO' WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".(int)$x_idPlanilla."'";
$mostrar_formularioP= mysql_query($query_formularioP, $conexion) or die(mysql_error());
}

if($row_mora['mora']>=1) {
mysql_select_db($database_conexion, $conexion);
$query_formularioM = "UPDATE formulario SET porcentaje='1' WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".(int)$x_idPlanilla."'";
$mostrar_formularioM= mysql_query($query_formularioM, $conexion) or die(mysql_error());
}else {
mysql_select_db($database_conexion, $conexion);
$query_formularioM = "UPDATE formulario SET porcentaje='0' WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".(int)$x_idPlanilla."'";
$mostrar_formularioM= mysql_query($query_formularioM, $conexion) or die(mysql_error());
}
}

//Creando todo el formulario para el usuario, si este no a sido creado aun
mysql_select_db($database_conexion, $conexion);
$query_formulario = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".(int)$x_idPlanilla."'";
$mostrar_formulario= mysql_query($query_formulario, $conexion) or die(mysql_error());
$row_formulario= mysql_fetch_assoc($mostrar_formulario);
$totalRows_formulario = mysql_num_rows($mostrar_formulario);
if($totalRows_formulario <= 0) {
//Iterar formulario para su llenado------------------------------------------------------------
mysql_select_db($database_conexion, $conexion);
$query_crear_formulario = "INSERT INTO formulario VALUES ('',".(int)$_GET["idMer"].",".(int)$_GET["idPlanilla"].",'','','','')";
mysql_query($query_crear_formulario, $conexion) or die(mysql_error());
}

if($x_idPlanilla=='1' || $x_idPlanilla=='14'|| $x_idPlanilla=='20') {
//Creando todo el tipo contrato para el usuario, si este no a sido creado aun
mysql_select_db($database_conexion, $conexion);
$query_contratoLlenar = "SELECT * FROM contrato_llenar WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".(int)$x_idPlanilla."' ORDER BY idCL asc";
$mostrar_contratoLlenar= mysql_query($query_contratoLlenar, $conexion) or die(mysql_error());
$row_contratoLlenar= mysql_fetch_assoc($mostrar_contratoLlenar);
$totalRows_contratoLlenar= mysql_num_rows($mostrar_contratoLlenar);
}
//Creando todo pregunta para el usuario, si este no a sido creado aun
if($x_idPlanilla!='1' || $x_idPlanilla!='14'|| $x_idPlanilla!='20') {
mysql_select_db($database_conexion, $conexion);
$query_preguntaResp = "SELECT * FROM pregunta WHERE idPlanilla='".(int)$x_idPlanilla."' AND idPregunta NOT IN (SELECT idPregunta FROM pregunta_respuesta WHERE idPlanilla='".(int)$x_idPlanilla."' AND idMer='".(int)$_GET["idMer"]."')";
$mostrar_preguntaResp= mysql_query($query_preguntaResp, $conexion) or die(mysql_error());
$totalRows_preguntaResp = mysql_num_rows($mostrar_preguntaResp);
if($totalRows_preguntaResp > 0) {
//Iterar el llenado de pregunta------------------------------------------------------------
while ($row_preguntaResp= mysql_fetch_assoc($mostrar_preguntaResp)) {

mysql_select_db($database_conexion, $conexion);
$query_crear_preguntaRespuesta = "INSERT INTO pregunta_respuesta VALUES ('',".(int)$_GET["idMer"].",".(int)$_GET["idPlanilla"].",'',".$row_preguntaResp['idPregunta'].",'','','','');";
mysql_query($query_crear_preguntaRespuesta, $conexion) or die(mysql_error());

}
}
}
/////////////////// proceso de llenado de datos

if($x_idPlanilla=='1' || $x_idPlanilla=='14' || $x_idPlanilla=='20') {
$mostrar_contratoLlenar= mysql_query($query_contratoLlenar, $conexion) or die(mysql_error());
$totalRows_contratoLlenar= mysql_num_rows($mostrar_contratoLlenar);
}
$mostrar_formulario= mysql_query($query_formulario, $conexion) or die(mysql_error());
$row_formulario= mysql_fetch_assoc($mostrar_formulario);
$totalRows_formulario = mysql_num_rows($mostrar_formulario);

mysql_select_db($database_conexion, $conexion);
$query_preguntaRespuesta = "SELECT a.*, b.pregunta FROM pregunta_respuesta a, pregunta b WHERE a.idMer='".(int)$_GET['idMer']."' AND a.idPlanilla='".(int)$x_idPlanilla."' AND a.idPregunta = b.idPregunta";
$mostrar_preguntaRespuesta= mysql_query($query_preguntaRespuesta, $conexion) or die(mysql_error());
$row_preguntaRespuesta= mysql_fetch_assoc($mostrar_preguntaRespuesta);
$totalRows_preguntaRespuesta = mysql_num_rows($mostrar_preguntaRespuesta);
// extraendo todos los archivos
mysql_select_db($database_conexion, $conexion);
$query_archivo = "SELECT * FROM archivo WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".(int)$x_idPlanilla."'";
$mostrar_archivo= mysql_query($query_archivo, $conexion) or die(mysql_error());
$totalRows_archivo= mysql_num_rows($mostrar_archivo);

mysql_select_db($database_conexion, $conexion);
$query_mer = "SELECT * FROM mer WHERE idMer='".(int)$_GET['idMer']."'";
$mostrar_mer = mysql_query($query_mer, $conexion) or die(mysql_error());
$row_mer= mysql_fetch_assoc($mostrar_mer);
$totalRows_mer= mysql_num_rows($mostrar_mer);
$estado=$row_mer['estado'];
?>
<script type="text/javascript">
var x=$(document);
x.ready(inicializarEventos);
function inicializarEventos()
{var x,z,y,str,i,cont,lista,pSI,lista_porcentaje,resp,resp2,respuesta;
// formaulario 16
$(":radio").click(function(){
var lista=$("#check_list16");
str = $("input[name='x_prestamo']:checked").val();
lista.attr("value",str);

});

// formurio 17
var nroRegistro=$("#nroRegistros").attr("value")
var lista17=$("#check_list17");
if(nroRegistro>'0'){lista17.attr("value",'SI');$("#idcheck_list17").text('SI');}else {lista17.attr("value",'NO');$("#idcheck_list17").text('NO');}
var suma_valor=$("#suma_valor").attr("value");
var list_porcentaje17=$("#check_list_porcentaje17");
list_porcentaje17.attr("value",suma_valor); $("#idcheck_list_porcentaje17").text(suma_valor);
//
//formulario 12
var cumple=$("#check_list12").attr("value");
var montobs=$("#check_list_porcentaje12").attr("value");
$("#idcheck_list12").text(cumple);
$("#idcheck_list_porcentaje12").text(montobs);
//

y="<?php echo $totalRows_preguntaRespuesta?>";

pSI=$("#preguntaSI").attr("value");
lista=$("#check_list");
lista_porcentaje=$("#check_list_porcentaje");
var aux=pSI*100/y;
aux = Math.round(aux*100)/100

if("<?php echo $x_idPlanilla?>"!='13'){
if(aux=='100'){resp="SI"}else{resp="NO"}
lista.attr("value",resp);$("#idcheck_list").text(resp);
lista_porcentaje.attr("value",aux);$("#idcheck_list_porcentaje").text(aux);
}
$(":radio").click(function(){
lista=$("#check_list");
lista_porcentaje=$("#check_list_porcentaje");
cont=0;
if("<?php echo $x_idPlanilla?>"=='13'){
cont=0;
for(i=1;i<=y;i++)
{str = $("input[name='respuesta_"+i+"']:checked").val();
if(str=='SI'){cont++;}
}
if(cont>0){lista.attr("value","SI");$("#idcheck_list").text("SI");}else{lista.attr("value","NO");$("#idcheck_list").text("NO");}
}else{
for(i=1;i<=y;i++)
{str = $("input[name='respuesta_"+i+"']:checked").val();
if(str=='SI'){cont++;}
}
var aux2=cont*100/y;
aux2 = Math.round(aux2*100)/100 
if(aux2=='100'){resp2="SI"}else{resp2="NO"}
lista.attr("value",resp2);$("#idcheck_list").text(resp2);
lista_porcentaje.attr("value",aux2);$("#idcheck_list_porcentaje").text(aux2);
}});

x=$("#x_td_contrato a");
x.click(presionFila);
z=$("#x_tdPregunta a");
z.click(presiona_pregunta);
//planilla 15
if("<?php echo $x_idPlanilla?>"=='15'){
var respuesta,respuesta2;
for(i=1;i<="<?php echo $totalRows_preguntaRespuesta;?>";i++){
respuesta=$("#respuesta_"+i);
respuesta2=$("#respuesta2_"+i);
respuesta.blur(planilla15);
respuesta2.blur(planilla15);
}
}
}
function planilla15(){
var suma=0, respuesta_suma,i,suma2=0,respuesta_suma2,porcentaje,aux,auxP;
var totalPlanificado=$("#totalPlanificado");
var totalAlcanzado=$("#totalAlcanzado");
var porcentaje15=$("#porcentaje15");
var cuentaPlan=$("#cuentaPlan").attr("value");
var check_list_porcentaje=$("#check_list_porcentaje15");
var check_list=$("#check_list15");
for(i=1;i<="<?php echo $totalRows_preguntaRespuesta;?>";i++){
porcentaje=0;
respuesta_suma=$("#respuesta_"+i).attr("value");
respuesta_suma2=$("#respuesta2_"+i).attr("value");
porcentaje=$("#porcentaje15_"+i);
aux=(respuesta_suma2/respuesta_suma)*100;
aux=Math.round(aux*100)/100;
porcentaje.text(aux);
if(respuesta_suma!="")suma=parseFloat(suma)+parseFloat(respuesta_suma);
if(respuesta_suma2!="")suma2=parseFloat(suma2)+parseFloat(respuesta_suma2);
}
suma=Math.round(suma*100)/100;
totalPlanificado.attr("value", suma);
suma2=Math.round(suma2*100)/100;
totalAlcanzado.attr("value", suma2);
auxP=(suma2/suma)*100;
auxP=Math.round(auxP*100)/100;
porcentaje15.text(auxP+"%");
if(cuentaPlan=='SI'){
var resp=(suma2/suma)*100;
resp=Math.round(resp*100)/100;
check_list_porcentaje.attr("value",resp);$("#idcheck_list_porcentaje15").text(resp)
if((suma2/suma)*100>='100'){check_list.attr("value",'SI'); $("#idcheck_list15").text('SI')}else{check_list.attr("value",'NO');$("#idcheck_list15").text('NO')}
} else{check_list.attr("value",'NO'); $("#idcheck_list15").text('NO')}
}

function presionFila() {
var pagina=$(this).attr("href");
var carga=$("#carga_contratoLlenar");
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
var carga=$("#carga_contratoLlenar");
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
function validar_formulario()
{ var v_archivo=$("#archivo").attr("value");
  var v_observacion=$("#x_observacion").attr("value");
  //alert(v_observacion.length);
    if("<?php echo $x_idPlanilla?>"=='1' || "<?php echo $x_idPlanilla?>"=='14' || "<?php echo $x_idPlanilla?>"=='16' || "<?php echo $x_idPlanilla?>"=='17'){
        if("<?php echo $x_idPlanilla?>"=='17'){var v_checkList=$("#check_list17").attr("value");}else{var v_checkList=$("#check_list_1").attr("value");}
    }
    else{var v_checkList=$("#idcheck_list").text();}
    
    if(v_observacion.length<=50 && v_checkList=='SI'){
        alert("Cuando cumple el 100% o respuesta es SI debe llenar La descripcion de trabajo realizado mayor a 50 letras...")
$("#x_observacion").focus();
        return (false);
}
if((v_archivo.length<=1 && v_checkList=='SI' && <?php echo $totalRows_archivo;?><=0))
    {alert("Cuando cumple el 100% de llenado de check list o cumple con una respuesta SI es necesario adjuntar minimo un archivo de respaldo");
        $("#archivo").focus();
        return (false);
    }
}

function validar_formulario12()
{ var v_archivo=$("#archivo").attr("value");
  var v_observacion=$("#x_observacion").attr("value");
  //alert(v_observacion.length);
    var v_checkList=$("#idcheck_list12").text();

    if(v_observacion.length<=50 && v_checkList=='SI'){
        alert("Cuando cumple el 100% o respuesta es SI debe llenar La descripcion de trabajo realizado mayor a 50 letras...")
$("#x_observacion").focus();
        return (false);
}
if((v_archivo.length<=1 && v_checkList=='SI' && <?php echo $totalRows_archivo;?><=0))
    {alert("Cuando cumple el 100% de llenado de check list o cumple con una respuesta SI es necesario adjuntar minimo un archivo de respaldo");
        $("#archivo").focus();
        return (false);
    }
}
</script>
<?php if($x_idPlanilla=="") {    ?>
<br>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data">
<table cellspacing="0" class="ewGrid" align="center"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<tr style="background: repeat #333333; color:#FFFFFF; font-size: 13px;">
    <th>DOCUMENTOS CON LAS QUE CUENTA LA MERS</t>
    <th>RESULTADO</th>
</tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario1 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=1";
    $mostrar_formulario1= mysql_query($query_formulario1, $conexion) or die(mysql_error());
    $row_formulario1= mysql_fetch_assoc($mostrar_formulario1);

    mysql_select_db($database_conexion, $conexion);
    $query_numeroContratos = "SELECT count(completo) as completo FROM contrato_llenar WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=1 AND completo='SI'";
    $mostrar_numeroContratos= mysql_query($query_numeroContratos, $conexion) or die(mysql_error());
    $row_numeroContratos= mysql_fetch_assoc($mostrar_numeroContratos);

    mysql_select_db($database_conexion, $conexion);
    $query_empleos = "SELECT sum(certConformidad) as empleos FROM contrato_llenar WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=20 AND completo='SI'";
    $mostrar_empleos= mysql_query($query_empleos, $conexion) or die(mysql_error());
    $row_empleos= mysql_fetch_assoc($mostrar_empleos);

    mysql_select_db($database_conexion, $conexion);
    $query_cumplimiento = "SELECT certConformidad FROM contrato_llenar WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=1 AND certConformidad='SI'";
    $mostrar_cumplimiento= mysql_query($query_cumplimiento, $conexion) or die(mysql_error());
    $totalRows_cumplimiento= mysql_num_rows($mostrar_cumplimiento);
    $sw=0;
    ?>
<tr><td>CONTRATOS DE VENTA/SERVICIO</td><td><?php echo $row_formulario1['cuenta'];
            $indicador1=$row_formulario1['cuenta']?></td></tr>
<tr bgcolor="#F1F1F1"><td>N&Uacute;MERO DE CONTRATOS</td><td><?php if($row_numeroContratos['completo']>0)echo $row_numeroContratos['completo'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario2 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=2";
    $mostrar_formulario2= mysql_query($query_formulario2, $conexion) or die(mysql_error());
    $row_formulario2= mysql_fetch_assoc($mostrar_formulario2);
    if($row_formulario2['cuenta']=='SI') {
        $sw=1;
}
            ?>
<tr><td>PLAN DE NEGOCIO</td><td><?php echo $row_formulario2['cuenta'];
    $b21=$row_formulario2['cuenta'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario3 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=3";
    $mostrar_formulario3= mysql_query($query_formulario3, $conexion) or die(mysql_error());
    $row_formulario3= mysql_fetch_assoc($mostrar_formulario3);
if($row_formulario3['cuenta']=='SI') {
                $sw=1;
    }
    ?>
<tr bgcolor="#F1F1F1"><td>PLAN ESTRATEGICO</td><td><?php echo $row_formulario3['cuenta'];
    $b22=$row_formulario3['cuenta'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario4 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=4";
$mostrar_formulario4= mysql_query($query_formulario4, $conexion) or die(mysql_error());
            $row_formulario4= mysql_fetch_assoc($mostrar_formulario4);
    if($row_formulario4['cuenta']=='SI') {
        $sw=1;
    }
    ?>
<tr><td>PLAN FINANCIERO</td><td><?php echo $row_formulario4['cuenta'];
    $b23=$row_formulario4['cuenta'];?></td></tr>
    <?php
mysql_select_db($database_conexion, $conexion);
            $query_formulario5 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=5";
    $mostrar_formulario5= mysql_query($query_formulario5, $conexion) or die(mysql_error());
    $row_formulario5= mysql_fetch_assoc($mostrar_formulario5);
    if($row_formulario5['cuenta']=='SI') {
        $sw=1;
    }
    ?>
<tr bgcolor="#F1F1F1"><td>PLAN DE PRODUCCION</td><td><?php echo $row_formulario5['cuenta'];
$b24=$row_formulario5['cuenta'];?></td></tr>
            <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario6= "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=6";
    $mostrar_formulario6= mysql_query($query_formulario6, $conexion) or die(mysql_error());
    $row_formulario6= mysql_fetch_assoc($mostrar_formulario6);
    if($row_formulario6['cuenta']=='SI') {
        $sw=1;
}
            ?>
<tr><td>PLAN OPERATIVO ANUAL</td><td><?php echo $row_formulario6['cuenta'];
    $b25=$row_formulario6['cuenta'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario7 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=7";
    $mostrar_formulario7= mysql_query($query_formulario7, $conexion) or die(mysql_error());
$row_formulario7= mysql_fetch_assoc($mostrar_formulario7);
            ?>
<tr bgcolor="#F1F1F1"><td>TESTIMONIO DE CONSTITUCION</td><td><?php echo $row_formulario7['cuenta'];
    $b26=$row_formulario7['cuenta'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario8 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=8";
    $mostrar_formulario8= mysql_query($query_formulario8, $conexion) or die(mysql_error());
$row_formulario8= mysql_fetch_assoc($mostrar_formulario8);
            ?>
<tr><td>ESTATUTO ORGANICO</td><td><?php echo $row_formulario8['cuenta'];
    $b27=$row_formulario8['cuenta'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario9 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=9";
    $mostrar_formulario9= mysql_query($query_formulario9, $conexion) or die(mysql_error());
$row_formulario9= mysql_fetch_assoc($mostrar_formulario9);
            ?>
<tr bgcolor="#F1F1F1"><td>REGLAMENTO INTERNO</td><td><?php echo $row_formulario9['cuenta'];
    $b28=$row_formulario9['cuenta'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario10 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=10";
    $mostrar_formulario10= mysql_query($query_formulario10, $conexion) or die(mysql_error());
$row_formulario10= mysql_fetch_assoc($mostrar_formulario10);
            ?>
<tr><td>TARJETA EMPRESARIAL</td><td><?php echo $row_formulario10['cuenta'];
    $b29=$row_formulario10['cuenta'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario11 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=11";
    $mostrar_formulario11= mysql_query($query_formulario11, $conexion) or die(mysql_error());
$row_formulario11= mysql_fetch_assoc($mostrar_formulario11);
            ?>
<tr bgcolor="#F1F1F1"><td>REGISTRO FUNDAEMPRESA</td><td><?php echo $row_formulario11['cuenta'];
    $b30=$row_formulario11['cuenta'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario12 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=12";
    $mostrar_formulario12= mysql_query($query_formulario12, $conexion) or die(mysql_error());
$row_formulario12= mysql_fetch_assoc($mostrar_formulario12);
    ?>
<tr><td>CONTRATO MUNICIPIO MERS</td><td><?php echo $row_formulario12['cuenta'];
    $indicador15=$row_formulario12['cuenta'];
    $indicador4=$row_formulario['cuenta'];?></td></tr>
    <?php
mysql_select_db($database_conexion, $conexion);
    $query_formulario13 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=13";
    $mostrar_formulario13= mysql_query($query_formulario13, $conexion) or die(mysql_error());
    $row_formulario13= mysql_fetch_assoc($mostrar_formulario13);
    ?>
<tr bgcolor="#F1F1F1"><td>PART. EVENTO MUNICIPIO</td><td><?php echo $row_formulario13['cuenta'];
    $indicador14=$row_formulario13['cuenta'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario14 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=14";
    $mostrar_formulario14= mysql_query($query_formulario14, $conexion) or die(mysql_error());
    $row_formulario14= mysql_fetch_assoc($mostrar_formulario14);
?>
<tr><td>ALIANZA PUBLICO PRIVADA</td><td><?php echo $row_formulario14['cuenta'];
    $indicador13=$indicador5=$row_formulario14['cuenta'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario15 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=15";
    $mostrar_formulario15= mysql_query($query_formulario15, $conexion) or die(mysql_error());
    $row_formulario15= mysql_fetch_assoc($mostrar_formulario15);
    mysql_select_db($database_conexion, $conexion);
$query_preguntaRespuesta15 = "SELECT sum(respuesta) as planificado FROM pregunta_respuesta WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=15";
            $mostrar_preguntaRespuesta15= mysql_query($query_preguntaRespuesta15, $conexion) or die(mysql_error());
$row_preguntaRespuesta15=mysql_fetch_assoc($mostrar_preguntaRespuesta15);
            $planificado=$row_preguntaRespuesta15['planificado'];
            ?>
<tr bgcolor="#F1F1F1"><td>CUMPLIMIENTO DE VENTAS (PROYECTADO)</td><td><?php echo $row_formulario15['cuenta'];
            $indicador11=$row_formulario15['cuenta'];?></td></tr>
            <?php
            mysql_select_db($database_conexion, $conexion);
            $query_formulario16 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=16";
            $mostrar_formulario16= mysql_query($query_formulario16, $conexion) or die(mysql_error());
            $row_formulario16= mysql_fetch_assoc($mostrar_formulario16);
    $totalRows_formulario16=mysql_num_rows($mostrar_formulario16);
    ?>
<tr><td>CREDITO</td><td><?php echo $row_formulario16['cuenta'];
    $indicador8=$row_formulario16['cuenta'];?></td></tr>
<tr bgcolor="#F1F1F1"><td>MORA</td><td><?php if($totalRows_formulario16>0) {
        if($row_formulario16['porcentaje']=='1') {
echo "SI";
                    $indicador9="SI";
        }else {
            echo "NO";
            $indicador9="NO";
        }
    }
    ?></td></tr>
<?php
            mysql_select_db($database_conexion, $conexion);
    $query_formulario17 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=17";
    $mostrar_formulario17= mysql_query($query_formulario17, $conexion) or die(mysql_error());
    $row_formulario17= mysql_fetch_assoc($mostrar_formulario17);
    ?>
<tr><td>REGISTRO DE VENTAS</td><td><?php echo $row_formulario17['cuenta'];
    $b37=$row_formulario17['cuenta'];?></td></tr>
<?php
            mysql_select_db($database_conexion, $conexion);
$query_formulario18 = "SELECT * FROM formulario WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla=18";
$mostrar_formulario18= mysql_query($query_formulario18, $conexion) or die(mysql_error());
            $row_formulario18= mysql_fetch_assoc($mostrar_formulario18);
            ?>
<tr bgcolor="#F1F1F1"><td>REGISTROS CONTABLES</td><td><?php echo $row_formulario18['cuenta'];
            $b38=$row_formulario18['cuenta'];?></td></tr>
    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario19 = "SELECT * FROM formulario WHERE idMer='" . (int) $_GET['idMer'] . "' AND idPlanilla=19";
    $mostrar_formulario19 = mysql_query($query_formulario19, $conexion) or die(mysql_error());
    $row_formulario19 = mysql_fetch_assoc($mostrar_formulario19);
    ?>
<tr><td>PERSONERIA JURIDICA</td><td><?php echo $row_formulario19['cuenta'];
$b39=$row_formulario19['cuenta'];?></td></tr>
<tr bgcolor="#F1F1F1"><td>CONTRATO DE TRABAJO (Empleos)</td><td><?php echo $row_empleos['empleos'];
$indicador3=$row_empleos['empleos'];?></td></tr>
<tr><td>DOCUMENTO DE CUMPLIMIENTO</td><td><?php if($totalRows_cumplimiento>0) {
if($totalRows_cumplimiento>0) {
echo "SI";
$indicador12="SI";
} else {
echo "NO";
    $indicador12="NO";
}
}
?></td></tr>
<?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario21 = "SELECT * FROM formulario WHERE idMer='" . (int) $_GET['idMer'] . "' AND idPlanilla=21";
    $mostrar_formulario21 = mysql_query($query_formulario21, $conexion) or die(mysql_error());
    $row_formulario21 = mysql_fetch_assoc($mostrar_formulario21);
?>
<tr><td>PARAMETROS DE CALIDAD</td><td><?php echo $row_formulario21['cuenta'];
$b100=$row_formulario21['cuenta'];?></td></tr>
</table>
</div>
<!--         </td>
 <td width="100">&nbsp;</td>
<td >
      <div class="ewGridMiddlePanel">
          <table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
              <tr class="ewTableHeader" style="background: repeat #333333; color:#FFFFFF; font-size: 13px;">
                  <th>INDICADORES</th>
                  <th>CUMPLE</th>
              </tr>
<?php
if(($b21=='SI' || $b22=='SI' || $b23=='SI'|| $b24=='SI' || $b25=='SI')&& ($b26=='SI' || $b39=='SI') && ($b28=='SI' || $b29=='SI' || $b30=='SI') && ($b37=='SI')) {
$indicador2='SI';
}else {
$indicador2='NO';
}
if($b39=='SI' && ($b29=='SI' || ($b27=='SI' && $b28=='SI'))) {
$indicador6='SI';
}else {
$indicador6='NO';
}
if(($b21=='SI' || $b22=='SI' || $b23=='SI'|| $b24=='SI') && ($b37=='SI' || $b38=='SI')) {
$indicador7='SI';
}else {
$indicador7='NO';
}
?>
              <tr><td>A los dos años de finalizado el proyecto, al menos 80% de las 115 MERS beneficiarias mantienen sus servicios</td><td><?php echo $indicador1;?></td></tr>
              <tr bgcolor="#F1F1F1"><td>Número de MERS sostenibles y en funcionamiento: Año 2: 50; Fin proyecto: 115</td><td><?php echo $indicador2;?></td></tr>
                  <tr><td>Número de empleos generados: Año 2:  150; Fin proyecto: 450</td><td><?php echo $indicador3;?></td></tr>

              <tr bgcolor="#F1F1F1"><td>Al final del proyecto al menos un contrato en cada municipio con una MERS</td><td><?php echo $indicador4;?></td></tr>

              <tr><td> Al final del proyecto al menos una alianza público privada en la zona del proyecto</td><td><?php echo $indicador5;?></td></tr>

              <tr bgcolor="#F1F1F1"><td>Porcentaje de MERS  formalizadas (Testimonio, Reglamentos, Estatutos, Tarjeta Empresarial, u otros). Año 2: 30%; Fin proyecto: 70% de las 115  MERS </td><td><?php echo $indicador6;?></td></tr>

              <tr><td>Porcentaje de  MERS que aplican instrumentos de gestión empresarial  (contabilidad básica, administración y plan de negocios). Año 2: 30%; Fin proyecto: </td><td><?php echo $indicador7;?></td></tr>

              <tr bgcolor="#F1F1F1"><td>Porcentaje de  MERS que acceden a créditos: Año 2: 10%; Fin de proyecto: 30% de las 115  MERS.</td><td><?php echo $indicador8;?></td></tr>

              <tr><td>Porcentaje máximo de MERS con problemas de mora en el financiamiento durante todo el proyecto: 10% de las 115  MERS</td><td><?php echo $indicador9;?></td></tr>

              <tr bgcolor="#F1F1F1"><td>Porcentaje de MERS que han prestado servicios a entidades públicas o privadas, con contrato formal: Año 2: 30%; Fin de proyecto: 80% de las 115  MERS.</td><td><?php echo $indicador1;?></td></tr>

              <tr><td>Porcentaje de cumplimiento de venta de servicios de las MERS respecto a lo proyectado en sus planes de negocios: Año 2; 50%; Fin de proyecto: 70% de las 115  MERS</td><td><?php echo $indicador11;?></td></tr>

              <tr bgcolor="#F1F1F1"><td>Porcentaje de MERS que cumplen sus contratos de servicios: Año 2: 20%; Fin de proyecto: 80% de las 115  MERS</td><td><?php echo $indicador12;?></td></tr>

              <tr><td>Municipios que establecen una alianza público-privada con fines de desarrollo. Año 2:  4; Fin de proyecto: 8</td><td><?php echo $indicador13;?></td></tr>

              <tr bgcolor="#F1F1F1"><td>Municipios que incorporan acciones de apoyo al sector productivo en sus Planes Anuales y los ejecutan. Año 2: 4; Fin de proyecto: 8</td><td><?php echo $indicador14;?></td></tr>

              <tr><td>Municipios que contratan anualmente los servicios de al menos una MERS. Año 2: 4; Fin de proyecto: 8 </td><td><?php echo $indicador15;?></td></tr>

                </table>
      </div>
 </td>-->
</tr>
</table>
</form>
<?php
if($sw==1 && $planificado<=0){$sw=1;}else{$sw=0;}
?>
<div align="center" style="background: #344785; color: #ffffff">
<?php if ($estado==1 && ($Security->CanAdd() || $Security->CanEdit())) {?><a href="envio_email.php?x_idMer=<?php echo $_GET['idMer']?>&x_idPlanilla=<?php echo $x_idPlanilla;?>&sw=desabilitar" style="background: red" onclick="return estadoDesabilitado(<?php echo $sw?>)">
    <img src="images/guardar.png" width="180" height="25" border="none"></a><br><?php }
if($estado==2 && ($Security->CanAdd() || $Security->CanEdit())) {echo "Realizo el reporte exitosamente en fecha ".date("d-m-Y",strtotime($row_mer['fechaModificacion']));}?>
<?php if ($estado==2 && $_SESSION['idRol']<2){ echo "Reporte realizado en fecha ".date("d-m-Y",strtotime($row_mer['fechaModificacion']));?>
    <br>    <a href="formulario_guardar.php?x_idMer=<?php echo $_GET['idMer']?>&sw=habilitar" style="background: red" onclick="return estadoHabilitar()">
    <img src="images/habilitar.png" width="180" height="20" border="none"></a><?php }
if ($estado==1 && $Security->CanView()) {echo "La MERS se habilito en fecha ".date("d-m-Y",strtotime($row_mer['fechaModificacion']));}?>
</div>
<?php }?>
<?php if($x_idPlanilla=='1') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">CONTRATO DE SERVICIO</div></td></tr>
<tr><td colspan="11" class="ewTableHeader" align="center">REGISTRO DE LOS CONTRATOS DE LA MERS</td></tr>
<tr class="ewTableHeader">
    <td>Nro</td><td>Tipo de Contrato(*)</td><td>Registro por recibos/planillas (*)</td><td>Fecha Inicio</td><td>Fecha Finalizacion</td><td>Precio Bs.</td><td>Completo</td><td>Cert. Conformidad(x)</td>
    <?php if($Security->CanAdd()){?><td id="x_td_contrato" colspan="3"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=contratoadd" title="agregar" id="contrato"><img src="images/add.png" style="border: none"></a></td><?php } ?>
</tr>
<?php
$cont=1;
$cont_tipoContrato=0;
            $cont_contratoCompleto=0;
            while($row_contratoLlenar=mysql_fetch_assoc($mostrar_contratoLlenar)) {
                mysql_select_db($database_conexion, $conexion);
$query_tipoContrato = "SELECT * FROM tipo_contrato WHERE idTipoContrato='".$row_contratoLlenar['idTipoContrato']."'";
$mostrar_tipoContrato= mysql_query($query_tipoContrato, $conexion) or die(mysql_error());
$row_tipoContrato= mysql_fetch_assoc($mostrar_tipoContrato);
mysql_select_db($database_conexion, $conexion);
$query_registroContrato = "SELECT * FROM registro_contrato WHERE idRegistroContrato='".$row_contratoLlenar['idRegistroContrato']."'";
                $mostrar_registroContrato = mysql_query($query_registroContrato, $conexion) or die(mysql_error());
                $row_registroContrato = mysql_fetch_assoc($mostrar_registroContrato);
                ?>

<tr>
    <td><?php echo $cont;?></td>
    <td><?php echo $row_tipoContrato['tipoContrato'];
if($row_tipoContrato['tipoContrato']) {
$cont_tipoContrato++;
}?></td>
    <td><?php echo $row_registroContrato ['registroContrato'];?></td>
    <td><?php if($row_contratoLlenar['fechaInicio']!='0000-00-00') echo date("d-m-Y",strtotime($row_contratoLlenar['fechaInicio']));?></td>
    <td><?php if($row_contratoLlenar['fechaFinal']!='0000-00-00') echo date("d-m-Y",strtotime($row_contratoLlenar['fechaFinal']));?></td>
    <td><?php if($row_contratoLlenar['valor']!='0')echo $row_contratoLlenar['valor'];?></td>
    <td><?php echo $row_contratoLlenar['completo'];
        if($row_contratoLlenar['completo']=='SI') {
            $cont_contratoCompleto++;
}?></td>
    <td><?php echo $row_contratoLlenar['certConformidad'];
if($row_contratoLlenar['certConformidad']=='SI') {
$cont_conformidad='SI';
}?></td>
<?php if($Security->CanView()){?><td id="x_td_contrato"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=contratoview&x_idCL=<?php echo $row_contratoLlenar['idCL'];?>" title="ver contrato" id="contratoedit"><img src="images/page.png" border="none"></a></td><?php } ?>
<?php if($estado==1 && $Security->CanEdit()){?><td id="x_td_contrato"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=contratoedit&x_idCL=<?php echo $row_contratoLlenar['idCL'];?>" title="editar contrato" id="contratoedit"><img src="images/page_edit.png" border="none"></a></td><?php } ?>
<?php if($estado==1 && $Security->CanDelete()) {?><td><a href="formulario_guardar.php?x_idMer=<?php echo $_GET['idMer']?>&x_idPlanilla=<?php echo $x_idPlanilla;?>&sw=contratodelete&x_idCL=<?php echo $row_contratoLlenar['idCL'];?>" title="borrar contrato" id="contratodelete" onClick="return confirmarDelete();"><img src="images/delete.png" border="none"></a></td><?php } ?>
</tr>
                <?php
                $cont++;
}
mysql_select_db($database_conexion, $conexion);
$query_contadorRegistro = "SELECT b.idRegistroContrato, b.registroContrato , count(b.idRegistroContrato) as cont FROM contrato_llenar a, registro_contrato b WHERE a.idMer='".(int)$_GET['idMer']."' AND a.idPlanilla='".(int)$x_idPlanilla."' AND a.idRegistroContrato=b.idRegistroContrato GROUP BY b.idRegistroContrato";
$mostrar_contadorRegistro= mysql_query($query_contadorRegistro, $conexion) or die(mysql_error());
?>
<tr><td colspan="11"><div id="carga_contratoLlenar"></div><td></tr>
</table>
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="6"><div class="titulo">RESUMEN DEL FORMULARIO</div></td></tr>
<tr>
    <td class="ewTableHeader">Numero de Contratos</td><td>&nbsp;&nbsp;<?php echo $cont_tipoContrato;?>&nbsp;&nbsp;</td>
    <td class="ewTableHeader">Numero de Registros por</td><td colspan="3"><?php while($row_contadorRegistro= mysql_fetch_assoc($mostrar_contadorRegistro)) {
echo '<strong>'.$row_contadorRegistro['registroContrato'].":</strong> ".$row_contadorRegistro['cont']."&nbsp;&nbsp;&nbsp;&nbsp;";
} ?></td>
</tr>
<tr>
    <td class="ewTableHeader">Numero de Contratos Completos</td><td>&nbsp;&nbsp;<?php echo $cont_contratoCompleto;?>&nbsp;&nbsp;</td>
    <td class="ewTableHeader">Cuenta con un contrato de venta y servicio</td>
    <td><?php if($cont_contratoCompleto>'0') {echo "SI";}else {echo "NO";}?></td>
    <td class="ewTableHeader">Cuenta con Certificado de conformidad</td><td><?php echo $cont_conformidad;?></td>
</tr>
<tr><td class="ewTableHeader">Descripcion del Trabajo Realizado:</td>
    <td colspan="5"><textarea name="x_observacion" id="x_observacion" rows="2" cols="150"><?php echo $row_formulario['observacion'];?></textarea></td>
</tr>
</table>
<div id="cargar_checklist"></div>

<input type="hidden" name="check_list" id="check_list_1" size="5" value="<?php if($cont_contratoCompleto>'0') {echo "SI";}else {echo "NO";}?>">

<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DE CONTRATO TIPO</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
    <?php }?>

<?php if($x_idPlanilla=='2') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">PLAN DE NEGOCIO</div></td></tr>
<tr><td>LA MERS CUENTA CON UN PLAN DE NEGOCIO:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">El Plan de Negocio Cuenta Con:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
<?php
$cont_pregunta=1;
$cont_preguntaSI=0;
do {?>
<tr>
<td><?php echo $cont_pregunta?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI"
<?php if($row_preguntaRespuesta["respuesta"]=="SI") { echo("checked='checked'"); $cont_preguntaSI++;}?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO"
<?php if($row_preguntaRespuesta["respuesta"]=="NO") { echo("checked='checked'");} ?>/></td>
</tr>
<?php
$cont_pregunta++;
}while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DEL PLAN DE NEGOCIO</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
    <?php }?>

<?php if($x_idPlanilla=='3') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">PLAN ESTRATEGICO</div></td></tr>
<tr><td>LA MERS CUENTA CON UN PLAN ESTRATEGICO:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">El Plan Estrategico Cuenta Con:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
<?php
$cont_pregunta=1;
$cont_preguntaSI=0;
do {?>
<tr>
<td><?php echo $cont_pregunta?>
<input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>">
</td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
                    echo("checked='checked'");
                    $cont_preguntaSI++;
                }?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
                    echo("checked='checked'");
                } ?>/></td>
</tr>
                <?php
                $cont_pregunta++;
            }while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DEL PLAN ESTRATEGICO</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
    <?php }?>

<?php if($x_idPlanilla=='4') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">PLAN FINANCIERO</div></td></tr>
<tr><td>LA MERS CUENTA CON UN PLAN FINANCIERO:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">El Plan Financiero Cuenta Con:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
<?php
$cont_pregunta=1;
$cont_preguntaSI=0;
do {?>
<tr>
<td><?php echo $cont_pregunta?>
<input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>">
</td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
                    echo("checked='checked'");
                    $cont_preguntaSI++;
                }?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
                    echo("checked='checked'");
                } ?>/></td>
</tr>
                <?php
                $cont_pregunta++;
            }while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DEL PLAN FINANCIERO</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
    <?php }?>

<?php if($x_idPlanilla=='5') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">PLAN DE PRODUCCION</div></td></tr>
<tr><td>LA MERS CUENTA CON UN PLAN DE PRODUCCION:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">El Plan de Producci&oacute;n Cuenta Con:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
<?php
$cont_pregunta=1;
$cont_preguntaSI=0;
do {?>
<tr>
<td><?php echo $cont_pregunta?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
                    echo("checked='checked'");
                    $cont_preguntaSI++;
                }?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
                    echo("checked='checked'");
                } ?>/></td>
</tr>
                <?php
                $cont_pregunta++;
            }while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DEL PLAN DE PRODUCCION</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
    <?php }?>

<?php if($x_idPlanilla=='6') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">PLAN OPERATIVO ANUAL</div></td></tr>
<tr><td>LA MERS CUENTA CON UN POA:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">El Plan Operativo Anual Cuenta Con:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
<?php
$cont_pregunta=1;
$cont_preguntaSI=0;
do {?>
<tr>
<td><?php echo $cont_pregunta?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
                    echo("checked='checked'");
                    $cont_preguntaSI++;
                }?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
                    echo("checked='checked'");
                } ?>/></td>
</tr>
                <?php
                $cont_pregunta++;
            }while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DEL PLAN OPERATIVO ANUAL</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?></table>
</div>
</td></tr></table>
</form>
    <?php }?>

<?php if($x_idPlanilla=='7') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">CONSTITUCION DE LA MERS</div></td></tr>
<tr><td>LA MERS CUENTA CON UNA ACTA DE CONSTITUCION:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">El Acta de Constitucion de la MERS cuenta con:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
<?php
$cont_pregunta=1;
$cont_preguntaSI=0;
do {?>
<tr>
<td><?php echo $cont_pregunta?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
                    echo("checked='checked'");
                    $cont_preguntaSI++;
                }?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
                    echo("checked='checked'");
                } ?>/></td>
</tr>
                <?php
                $cont_pregunta++;
            }while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">REQUISITOS PARA LA CONSTITUCION DE LA MERS</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
    <?php }?>

<?php if($x_idPlanilla=='8') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">ESTATUTO ORG&Aacute;NICO</div></td></tr>
<tr><td>LA MERS CUENTA CON ESTATUTO ORG&Aacute;NICO:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">El Estatuto Organico Cuenta con:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
<?php
$cont_pregunta=1;
$cont_preguntaSI=0;
do {?>
<tr>
<td><?php echo $cont_pregunta?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
                    echo("checked='checked'");
                    $cont_preguntaSI++;
                }?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
                    echo("checked='checked'");
                } ?>/></td>
</tr>
                <?php
                $cont_pregunta++;
            }while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DEL ESTATUTO ORGANICO "TIPO ACOPIO, TRANSFORMACION Y PRODUCCION"</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
    <?php }?>
<?php if($x_idPlanilla=='9') {    ?>
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">REGLAMENTO INTERNO</div></td></tr>
<tr><td>LA MERS CUENTA CON UN REGLAMENTO INTERNO:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">El Reglamento Interno Cuenta con:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
<?php
$cont_pregunta=1;
$cont_preguntaSI=0;
do {?>
<tr>
<td><?php echo $cont_pregunta?>
<input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>">
</td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {echo("checked='checked'");$cont_preguntaSI++;}?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {echo("checked='checked'");} ?>/></td>
</tr>
<?php
$cont_pregunta++;
}while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
    <input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DEL REGLAMENTO INTERNO "TIPO"</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
    <?php }?>
<?php if($x_idPlanilla=='10') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">TARJETA EMPRESARIAL</div></td></tr>
<tr><td>LA MERS CUENTA CON TARJETA EMPRESARIAL:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">La Tarjeta Empresarial en Tramite:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
<?php
$cont_pregunta=1;
$cont_preguntaSI=0;
do {?>
<tr>
<td><?php echo $cont_pregunta?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
                    echo("checked='checked'");
                    $cont_preguntaSI++;
                }?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
                    echo("checked='checked'");
                } ?>/></td>
</tr>
                <?php
                $cont_pregunta++;
            }while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">REQUISITOS PARA LA OBTENCIÓN DE LA TARJETA EMPRESARIAL</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
    <?php }?>
<?php if($x_idPlanilla=='11') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">REGISTRO FUNDAEMPRESA</div></td></tr>
<tr><td>LA MERS CUENTA CON REGISTRO FUNDAEMPRESA:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">En Tramite:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
<?php
$cont_pregunta=1;
$cont_preguntaSI=0;
do {?>
<tr>
<td><?php echo $cont_pregunta?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
                    echo("checked='checked'");
                    $cont_preguntaSI++;
                }?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
                    echo("checked='checked'");
                } ?>/></td>
</tr>
                <?php
                $cont_pregunta++;
            }while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">REQUISITOS PARA EL REGISTRO FUNDAEMPRESA</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
    <?php }?>
<?php if($x_idPlanilla=='12') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario12(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">DOCUMENTOS DE CONTRATO MUNICIPIO-MERS</div></td></tr>
<tr><td>EL MUNICIPIO CONTRATO SERVICIOS DE LA MERS:<td id="idcheck_list12"></td></tr>
<tr><td>MONTO TOTAL BS.:</td><td id="idcheck_list_porcentaje12"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="13" class="ewTableHeader" align="center">REGISTRO DE CONTRATOS</td></tr>
<tr class="ewTableHeader">
    <td>No</td>
    <td>Tipo de Contrato</td>
    <td>Descripcion del Contrato</td>
    <td>Unid.</td>
    <td>P.U. Bs.</td>
    <td>Cant.</td>
    <td>Costo Total Bs.</td>
    <td>Fecha Inicial</td>
    <td>Fecha Finalizacion</td>
    <td>Cumple</td>
<?php if($Security->CanAdd()){?><td id="x_td_contrato" colspan="2"><a href="formulario_agregar12.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=formulario12add" title="agregar" id="contrato"><img src="images/add.png" style="border: none"></a></td><?php } ?>
</tr>
<?php
    mysql_select_db($database_conexion, $conexion);
    $query_formulario12 = "SELECT * FROM formulario12 WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".$x_idPlanilla."'";
    $mostrar_formulario12= mysql_query($query_formulario12, $conexion) or die(mysql_error());
 $cont=1;
 $cumple_condicion='NO';
 $suma_costo=0;
while($row_formulario12=mysql_fetch_assoc($mostrar_formulario12)){?>
<tr>
    <td><?php echo $cont;?></td>
    <td><?php 
        switch ($row_formulario12['tipoContrato']) {
            case '1': echo "Municipio-Mers"; break;
            case '2': echo "Prvado-Privado"; break;
            case '3': echo "Publico-Privado"; break;
        default: break;
        }
    ?>
    </td>
    <td><?php echo $row_formulario12['descripcion']?></td>
    <td><?php echo $row_formulario12['unidad']?></td>
    <td><?php echo $row_formulario12['precioUnitario']?></td>
    <td><?php echo $row_formulario12['cantidad']?></td>
    <td><?php echo $row_formulario12['costoTotal']?></td>
    <td><?php if($row_formulario12['fechaInicial']!='0000-00-00'){echo date("d-m-Y", strtotime($row_formulario12['fechaInicial']));}?></td>
    <td><?php if($row_formulario12['fechaFinal']!='0000-00-00'){echo date("d-m-Y", strtotime($row_formulario12['fechaFinal']));}?></td>
    <td><?php echo $row_formulario12['cumple']?></td>
<?php if($estado==1 && $Security->CanEdit()){?><td id="x_td_contrato"><a href="formulario_agregar12.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=formulario12edit&x_idFormulario12=<?php echo $row_formulario12['idFormulario12'];?>" title="editar contrato" id="contratoedit"><img src="images/page_edit.png" border="none"></a></td><?php } ?>
<?php if($estado==1 && $Security->CanDelete()) {?><td><a href="formulario_guardar.php?x_idMer=<?php echo $_GET['idMer']?>&x_idPlanilla=<?php echo $x_idPlanilla;?>&sw=formulario12delete&x_idFormulario12=<?php echo $row_formulario12['idFormulario12'];?>" title="borrar contrato" id="contratodelete" onClick="return confirmarDelete();"><img src="images/delete.png" border="none"></a></td><?php } ?>
<?php if($row_formulario12['cumple']=='SI' && $row_formulario12['tipoContrato']=='1')
{$cumple_condicion='SI';}
$suma_costo+=$row_formulario12['costoTotal'];
?>
</tr>

<?php $cont++; }
?>
<tr><td colspan="10"><div id="carga_contratoLlenar"></div><td></tr>
</table>
    <input type="hidden" name="check_list" id="check_list12" value="<?php echo $cumple_condicion;?>">
    <input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje12" value="<?php echo $suma_costo;?>">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DE CONTRATO</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}
closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?></table>
</div>
</td></tr></table>
</form>
    <?php }?>
<?php if($x_idPlanilla=='13') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">DOCUMENTOS DE LA RUEDA DE NEGOCIO</div></td></tr>
<tr><td>LA MERS PARTICIPO DE EVENTO ORGANIZADO POR EL MUNICIPIO:</td><td id="idcheck_list"><?php echo $row_formulario['cuenta'];?></td></tr>
<tr><td>APORTE DEL MUNICIPIO EN BS.:</td><td><input type="text" name="check_list_porcentaje" id="check_list_porcentaje" value="<?php echo $row_formulario['porcentaje'];?>"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">Eventos de apoyo Municipio al Sector Productivo:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
<?php
$cont_pregunta=1;
$cont_preguntaSI=0;
            do {?>
<tr>
<td><?php echo $cont_pregunta?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
                    echo("checked='checked'");
                    $cont_preguntaSI++;
                }?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
                    echo("checked='checked'");
                } ?>/></td>
</tr>
                <?php
                $cont_pregunta++;
            }while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list" value="<?php echo $row_formulario['cuenta'];?>">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DE LA RUEDA DE NEGOCIO</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
    <?php }?>

<?php if($x_idPlanilla=='14') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<tr><td colspan="10"><div class="titulo">ALIANZA PUBLICO-PRIVADA</div></td></tr>
<tr><td colspan="10" class="ewTableHeader" align="center">REGISTRO DE ALIANZAS</td></tr>
<tr class="ewTableHeader">
    <td>Nro</td><td>Tipo de Alianza</td><td>Motivo de la Alianza</td><td>Fecha Inicio</td><td>Fecha Finalizacion</td><td>Valor Bs.</td><td>Completo</td>
    <?php if($Security->CanAdd()){?><td id="x_td_contrato" colspan="3"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=contratoadd" title="agregar" id="contrato"><img src="images/add.png" style="border: none"></a></td><?php } ?>
</tr>
<?php
$cont=1;
            $cont_tipoContrato=0;
            $cont_contratoCompleto=0;
            while($row_contratoLlenar=mysql_fetch_assoc($mostrar_contratoLlenar)) {
mysql_select_db($database_conexion, $conexion);
$query_tipoContrato = "SELECT * FROM tipo_contrato WHERE idTipoContrato='".$row_contratoLlenar['idTipoContrato']."'";
$mostrar_tipoContrato= mysql_query($query_tipoContrato, $conexion) or die(mysql_error());
        $row_tipoContrato= mysql_fetch_assoc($mostrar_tipoContrato);
        mysql_select_db($database_conexion, $conexion);
        $query_registroContrato = "SELECT * FROM registro_contrato WHERE idRegistroContrato='".$row_contratoLlenar['idRegistroContrato']."'";
        $mostrar_registroContrato = mysql_query($query_registroContrato, $conexion) or die(mysql_error());
        $row_registroContrato = mysql_fetch_assoc($mostrar_registroContrato);
        ?>

<tr>
    <td><?php echo $cont;?></td>
    <td><?php echo $row_tipoContrato['tipoContrato'];
if($row_tipoContrato['tipoContrato']) {
$cont_tipoContrato++;
}?></td>
    <td><?php echo $row_registroContrato ['registroContrato'];?></td>
    <td><?php if($row_contratoLlenar['fechaInicio']!='0000-00-00') echo date("d-m-Y",strtotime($row_contratoLlenar['fechaInicio']));?></td>
    <td><?php if($row_contratoLlenar['fechaFinal']!='0000-00-00') echo date("d-m-Y",strtotime($row_contratoLlenar['fechaFinal']));?></td>
    <td><?php if($row_contratoLlenar['valor']!='0')echo $row_contratoLlenar['valor'];?></td>
    <td><?php echo $row_contratoLlenar['completo'];
if($row_contratoLlenar['completo']=='SI') {
$cont_contratoCompleto++;
}?></td>
<?php if($Security->CanView()){?><td id="x_td_contrato"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=contratoview&x_idCL=<?php echo $row_contratoLlenar['idCL'];?>" title="ver contrato" id="contratoedit"><img src="images/page.png" border="none"></a></td><?php } ?>
<?php if($estado==1 && $Security->CanEdit()){?><td id="x_td_contrato"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=contratoedit&x_idCL=<?php echo $row_contratoLlenar['idCL'];?>" title="editar contrato" id="contratoedit"><img src="images/page_edit.png" border="none"></a></td><?php } ?>
<?php if($estado==1 && $Security->CanDelete()) {?><td><a href="formulario_guardar.php?x_idMer=<?php echo $_GET['idMer']?>&x_idPlanilla=<?php echo $x_idPlanilla;?>&sw=contratodelete&x_idCL=<?php echo $row_contratoLlenar['idCL'];?>" title="borrar contrato" id="contratodelete" onClick="return confirmarDelete();"><img src="images/delete.png" border="none"></a></td><?php } ?>
</tr>
<?php
$cont++;
}
mysql_select_db($database_conexion, $conexion);
$query_contadorRegistro = "SELECT b.idRegistroContrato, b.registroContrato , count(b.idRegistroContrato) as cont FROM contrato_llenar a, registro_contrato b WHERE a.idMer='".(int)$_GET['idMer']."' AND a.idPlanilla='".(int)$x_idPlanilla."' AND a.idRegistroContrato=b.idRegistroContrato GROUP BY b.idRegistroContrato";
$mostrar_contadorRegistro= mysql_query($query_contadorRegistro, $conexion) or die(mysql_error());
?>
<tr><td colspan="11"><div id="carga_contratoLlenar"></div><td></tr>
</table>
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="5"><div class="titulo">RESUMEN DEL FORMULARIO</div></td></tr>
<tr>
    <td class="ewTableHeader">Numero de Alianza Publico-Privada</td><td><?php echo $cont_contratoCompleto;?></td>
    <td class="ewTableHeader">La Mers tiene Alianza Publico-Privada</td>
    <td><?php if($cont_contratoCompleto>0) {echo "SI";}else {echo "NO";}?></td>
<input type="hidden" name="check_list_porcentaje" size="5" value="<?php echo $cont_contratoCompleto;?>" >
</tr>
<tr><td class="ewTableHeader">Descripcion del Trabajo Realizado:</td>
    <td colspan="3"><textarea name="x_observacion" id="x_observacion" rows="2" cols="100"><?php echo $row_formulario['observacion'];?></textarea></td>
</tr>
</table>
<input type="hidden" name="check_list" id="check_list_1" value="<?php if($cont_contratoCompleto>'0') {echo "SI";}else {echo "NO";}?>">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELOS DE ALIANZA "TIPO"</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
            <?php }?>
<?php if($x_idPlanilla=='15') {    ?>
<form name="formulario15" id="formulario15" action="formulario_guardar.php" method="post" enctype="multipart/form-data">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">Porcentaje de Cumplimiento respecto al Plan de Negocio</div></td></tr>
<tr><td>La MERS alcanzo el (%):</td><td id="idcheck_list_porcentaje15"><?php echo $row_formulario['porcentaje'];?></td></tr>
<tr><td>Cumple con lo Proyectado:<td id="idcheck_list15"><?php echo $row_formulario['cuenta'];?></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<?php
    mysql_select_db($database_conexion, $conexion);
    $query_formularioCuenta = "SELECT idPlanilla, cuenta FROM formulario WHERE cuenta='SI' AND idPlanilla > 1 AND idPlanilla < 7 AND idMer='".$_GET['idMer']."'";
    $mostrar_formularioCuenta= mysql_query($query_formularioCuenta, $conexion) or die(mysql_error());
    $row_formularioCuenta= mysql_fetch_assoc($mostrar_formularioCuenta);
    $total_row_formularioCuenta=mysql_num_rows($mostrar_formularioCuenta);
    ?>
<table cellspacing="0" class="ewTable">
<tr><td colspan="7"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">Tiene Plan de Negocio (u otro plan):</td>
    <td colspan="5"><input type="text" name="cuentaPlan" id="cuentaPlan" value="<?php if($total_row_formularioCuenta>0) {
echo 'SI';
}else {
echo 'NO';
}?>" readonly style="background: #e95b45;color: #ffffff"></td>
</tr>
<tr class="ewTableHeader">
    <td></td>
    <td></td>
    <td>Fecha Inicio</td>
    <td>Fecha Final</td>
    <td>Planificado</td>
    <td>Alcanzado</td>
    <td>Porcentaje</td>
</tr>
    <?php $cont_pregunta=1;
    $suma_planificado=0;
    $suma_alcanzado=0;
    function dividir($x,$y) {
        if($y==0) {
return "0";
}else {
return ($x/$y);
}
}
do {
?>
<tr>
<td><?php echo $cont_pregunta;?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input class="date-pick" type="text" name="fechaInicio15_<?php echo $cont_pregunta ?>" id="fechaInicio15_<?php echo $cont_pregunta ?>" value="<?php if($row_preguntaRespuesta['fechaInicio']!='0000-00-00') {
                    echo date("d-m-Y",strtotime($row_preguntaRespuesta['fechaInicio']));
                }?>"  size="12" <?php if($total_row_formularioCuenta<=0) {
                    echo "disabled";
                }?>></td>
<td><input type="text" name="fechaFinal15_<?php echo $cont_pregunta ?>" id="fechaFinal15_<?php echo $cont_pregunta ?>" value="<?php if($row_preguntaRespuesta['fechaFinal']!='0000-00-00') {
                    echo date("d-m-Y",strtotime($row_preguntaRespuesta['fechaFinal']));
                }?>" class="date-pick" size="12" <?php if($total_row_formularioCuenta<=0) {
                    echo "disabled";
                }?>></td>
<td><input class="required" name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="text" value="<?php echo $row_preguntaRespuesta['respuesta'];?>" <?php if($total_row_formularioCuenta<=0) {
                    echo "disabled";
                }?>/>Bs.</td>
<td><input type="text" name="respuesta2_<?php echo $cont_pregunta ?>" id="respuesta2_<?php echo $cont_pregunta ?>" value="<?php echo $row_preguntaRespuesta['respuesta2'];?>" <?php if($total_row_formularioCuenta<=0) {
echo "disabled";
}?>>Bs.</td>
<td id="porcentaje15_<?php echo $cont_pregunta ?>"><?php echo dividir($row_preguntaRespuesta['respuesta2'],$row_preguntaRespuesta['respuesta'])*100?></td>
</tr>
<?php
$cont_pregunta++;
$suma_planificado=$suma_planificado+$row_preguntaRespuesta['respuesta'];
$suma_alcanzado=$suma_alcanzado+$row_preguntaRespuesta['respuesta2'];
}while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>
<tr><td>&nbsp;</td><td colspan="3">TOTAL Bs.</td><td><input type="text" name="totalPlanificado" id="totalPlanificado" value="<?php echo $suma_planificado;?>" readonly>Bs.</td><td><input type="text" name="totalAlcanzado" id="totalAlcanzado" value="<?php echo $suma_alcanzado;?>" readonly>Bs.</td><td id="porcentaje15"><?php echo dividir($suma_alcanzado,$suma_planificado)*100;?>%</td></tr>
</table>
<input type="hidden" name="check_list" id="check_list15" value="<?php echo $row_formulario['cuenta'];?>">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje15" value="<?php echo $row_formulario['porcentaje'];?>">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DE LA RUEDA DE NEGOCIO</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?></table>
</div>
</td></tr></table>
</form>
<script language="javascript" type="text/javascript">

//$(document).ready(function(){
//$("#formulario15").validate();
//});

</script>
<?php }?>
<?php if($x_idPlanilla=='16') {    ?>
<?php
//Creando todo el formulario para el usuario, si este no a sido creado aun
mysql_select_db($database_conexion, $conexion);
$query_obtencionCredito = "SELECT * FROM obtencion_credito16 WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".(int)$x_idPlanilla."'";
    $mostrar_obtencionCredito= mysql_query($query_obtencionCredito, $conexion) or die(mysql_error());
    $totalRows_obtencionCredito = mysql_num_rows($mostrar_obtencionCredito);

?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">DOCUMENTOS DE PRESTAMO</div></td></tr>
<tr><td>La MERS cuenta con un prestamo</td><td colspan="3" id="idcheck_list_1"><?php echo $row_formulario['cuenta'];?></td></tr>
<tr><td>Se Encuentra con Mora:</td><td><?php if($row_formulario['porcentaje']=='0') {echo "NO";}else {echo "SI";}?></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="9"><div class="titulo">OBTENCI&Oacute;N DE CREDITO</div></td></tr>
<tr class="ewTableHeader">
    <td>Nro</td><td>Solicitud</td><td>Entidad Financiera</td><td>Prestamo</td><td>Monto Solicitado Bs.</td><td>Mora</td><td>Fecha Ultimo Recibo</td>
<?php if($Security->CanAdd()){?><td id="x_td_contrato" colspan="2"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=obtencionCreditoadd" title="agregar" id="contrato"><img src="images/add.png" style="border: none"></a></td><?php } ?>
</tr>
            <?php
            $cont=1;
            while($row_obtencionCredito= mysql_fetch_assoc($mostrar_obtencionCredito)) {?>
<tr>
    <td><?php echo $cont;?></td>
    <td><?php echo $row_obtencionCredito['solicitud']?></td>
    <td><?php echo $row_obtencionCredito['entidadFinanciera']?></td>
    <td><?php echo $row_obtencionCredito['prestamo']?></td>
    <td><?php echo $row_obtencionCredito['montoSolicitado']?></td>
    <td><?php echo $row_obtencionCredito['mora']?></td>
    <td><?php if($row_obtencionCredito['fechaUltimoRecibo']!='0000-00-00') {
echo date("d-m-Y",strtotime($row_obtencionCredito['fechaUltimoRecibo']));
}?></td>
<?php if($estado==1 && $Security->CanEdit()){?><td id="x_td_contrato"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=obtencionCreditoedit&x_idObtencionCredito=<?php echo $row_obtencionCredito['idObtencionCredito'];?>" title="editar credito" id="contratoedit"><img src="images/page_edit.png" border="none"></a></td><?php } ?>
<?php if($estado==1 && $Security->CanDelete()) {?><td><a href="formulario_guardar.php?x_idMer=<?php echo $_GET['idMer']?>&x_idPlanilla=<?php echo $x_idPlanilla;?>&sw=obtencionCreditodelete&x_idObtencionCredito=<?php echo $row_obtencionCredito['idObtencionCredito'];?>" title="borrar credito" id="contratodelete" onClick="return confirmarDelete();"><img src="images/delete.png"  border="none"></a></td><?php  } ?>

</tr>
<?php
$cont++;
}?>
<tr><td colspan="9"><div id="carga_contratoLlenar"></div><td></tr>
</table>
<input type="hidden" name="check_list" id="check_list_1" value="<?php echo $row_formulario['cuenta'];?>">
<input type="hidden" name="check_list_porcentaje" value="<?php if($row_formulario['porcentaje']=='0') {echo "NO";}else {echo "SI";}?>">
<input type="hidden" name="sw" value="edit16">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DE DOCUMENTO DE PRESTAMO</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?></table>
</div>
</td></tr></table>
</form>
            <?php }?>
<?php if($x_idPlanilla=='17') {
mysql_select_db($database_conexion, $conexion);
            $query_registroVentas= "SELECT * FROM registroventas17 WHERE idMer='".(int)$_GET['idMer']."' AND idPlanilla='".(int)$x_idPlanilla."' ORDER BY idRegistroVentas asc";
            $mostrar_registroVentas= mysql_query($query_registroVentas, $conexion) or die(mysql_error());
//$row_registroVentas= mysql_fetch_assoc($mostrar_registroVentas);
$totalRows_registroVentas= mysql_num_rows($mostrar_registroVentas);
?>

<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">REGISTRO DE VENTAS</div></td></tr>
<tr><td>LA MERS CUENTA CON UN REGISTRO DE VENTAS:<td id="idcheck_list17"></td></tr>
<tr><td>VALOR TOTAL EN Bs.:</td><td id="idcheck_list_porcentaje17"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="12"><div class="titulo">REGISTRO DE VENTAS/SERVICIOS</div></td></tr>
<tr><td colspan="12" class="ewTableHeader" align="center">REGISTRO DE VENTAS/SERVICIOS</td></tr>
<tr class="ewTableHeader">
    <td>Nro</td><td>Nro de Comprobante</td><td>Tipo de Comprobante</td><td>Nombres y Apellidos del Comprador</td><td>Detalle de Ventas PRODUCTO / SERVICIO</td><td>Precio Unitario</td><td>Cantidad</td><td>Valor Total Bs.</td><td>Fecha</td><td>Cumple</td>
<?php if($Security->CanAdd()){?><td id="x_td_contrato" colspan="2"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=registroadd17" title="agregar" id="contrato"><img src="images/add.png" style="border: none"></a></td><?php } ?>
</tr>
            <?php
            $cont=1;
            $cont_cumple=0;
            $suma_valor=0;
            while($row_registroVentas=mysql_fetch_assoc($mostrar_registroVentas)) { ?>
<tr>
    <td><?php echo $cont;?></td>
    <td><?php if($row_registroVentas['nro']!='0')echo $row_registroVentas['nro'];?></td>
    <td><?php echo $row_registroVentas['tipo']; ?></td>
    <td><?php echo $row_registroVentas['nombreComprador'];?></td>
    <td><?php echo $row_registroVentas['detalle'];?></td>
    <td><?php if($row_registroVentas['precioUnitario']!='0')echo $row_registroVentas['precioUnitario'];?></td>
    <td><?php if($row_registroVentas['cantidad']!='0')echo $row_registroVentas['cantidad'];?></td>
    <td><?php if($row_registroVentas['valor']!='0')echo $row_registroVentas['valor'];
                $suma_valor=$suma_valor+$row_registroVentas['valor']?></td>
    <td><?php if($row_registroVentas['fecha']!='0000-00-00') echo date("d-m-Y",strtotime($row_registroVentas['fecha']));?></td>
    <td><?php echo $row_registroVentas['cumple'];
if($row_registroVentas['cumple']=='SI') {
$cont_cumple++;
}?></td>
<?php if($estado==1 && $Security->CanEdit()){?><td id="x_td_contrato"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=registroedit17&x_idRegistroVentas=<?php echo $row_registroVentas['idRegistroVentas'];?>" title="editar registro" id="contratoedit"><img src="images/page_edit.png" border="none"></a></td><?php } ?>
<?php if($estado==1 && $Security->CanDelete()) {?><td><a href="formulario_guardar.php?x_idMer=<?php echo $_GET['idMer']?>&x_idPlanilla=<?php echo $x_idPlanilla;?>&sw=registrodelete17&x_idRegistroVentas=<?php echo $row_registroVentas['idRegistroVentas'];?>" title="borrar registro" id="contratodelete" onClick="return confirmarDelete();"><img src="images/delete.png" border="none"></a></td><?php } ?>
</tr>
<?php
$cont++;
}
?>
<tr><td colspan="12"><div id="carga_contratoLlenar"></div><td></tr>
<TR><TD colspan="12">Nro. Registros de ventas Recibo/factura: <input type="text" name="nroRegistros" id="nroRegistros" value="<?php echo $cont_cumple?>" size="5" readonly></TD></TR>
</table>
<input type="hidden" name="check_list" id="check_list17">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje17">
    <input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<input type="hidden" name="suma_valor" id="suma_valor" value="<?php echo $suma_valor;?>">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DE REGISTRO DE VENTAS</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?></table>
</div>
</td></tr></table>
</form>
<?php }?>
<?php if($x_idPlanilla=='18') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">REGISTROS CONTABLES</div></td></tr>
<tr><td>LA MERS CUENTA CON UN REGISTRO CONTABLE:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">Registros Contables Actualizados de</td>
    <td>SI</td>
    <td>NO</td>
</tr>
            <?php
            $cont_pregunta=1;
            $cont_preguntaSI=0;
            do {?>
<tr>
<td><?php echo $cont_pregunta?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
echo("checked='checked'");
$cont_preguntaSI++;
}?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
echo("checked='checked'");
} ?>/></td>
</tr>
<?php
$cont_pregunta++;
}while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DE REGISTRO CONTABLE</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?></table>
</div>
</td></tr></table>
</form>
<?php }?>
<?php if($x_idPlanilla=='19') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">PERSONER&Iacute;A JUR&Iacute;DICA</div></td></tr>
<tr><td>LA MERS CUENTA CON PERSONER&Iacute;A JUR&Iacute;DICA:<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">La Personeria Juridica Cuenta con:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
            <?php
            $cont_pregunta=1;
            $cont_preguntaSI=0;
            do {?>
<tr>
<td><?php echo $cont_pregunta?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
echo("checked='checked'");
$cont_preguntaSI++;
}?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
echo("checked='checked'");
} ?>/></td>
</tr>
<?php
$cont_pregunta++;
}while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">REQUISITOS PARA OBTENER LA PERSONERIA JURIDICA</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?></table>
</div>
</td></tr></table>
</form>
            <?php }?>

        <?php if($x_idPlanilla=='20') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">CONTRATO DE TRABAJO</div></td></tr>
<tr><td colspan="11" class="ewTableHeader" align="center">REGISTRO DE CONTRATO DE TRABAJOS</td></tr>
<tr class="ewTableHeader">
    <td>Nro de Empleos</td><td>Tipo de Contrato</td><td>Registro por recibos/planillas</td><td>Fecha Inicio</td><td>Fecha Finalizacion</td><td>Precio Bs.</td><td>Completo</td><td>Valor</td>
<?php if($Security->CanAdd()){?><td id="x_td_contrato" colspan="2"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=contratoadd" title="agregar" id="contrato"><img src="images/add.png" style="border: none"></a></td><?php } ?>
</tr>
    <?php
$suma=0;
$cont_tipoContrato=0;
$cont_contratoCompleto=0;
while($row_contratoLlenar=mysql_fetch_assoc($mostrar_contratoLlenar)) {
mysql_select_db($database_conexion, $conexion);
$query_tipoContrato = "SELECT * FROM tipo_contrato WHERE idTipoContrato='".$row_contratoLlenar['idTipoContrato']."'";
$mostrar_tipoContrato= mysql_query($query_tipoContrato, $conexion) or die(mysql_error());
$row_tipoContrato= mysql_fetch_assoc($mostrar_tipoContrato);
mysql_select_db($database_conexion, $conexion);
$query_registroContrato = "SELECT * FROM registro_contrato WHERE idRegistroContrato='".$row_contratoLlenar['idRegistroContrato']."'";
$mostrar_registroContrato = mysql_query($query_registroContrato, $conexion) or die(mysql_error());
$row_registroContrato = mysql_fetch_assoc($mostrar_registroContrato);
?>

<tr>
    <td><?php echo $row_contratoLlenar['nroContrato'];?></td>
    <td><?php echo $row_tipoContrato['tipoContrato'];
                if($row_tipoContrato['tipoContrato']) {
                    $cont_tipoContrato++;
                }?></td>
    <td><?php echo $row_registroContrato['registroContrato'];?></td>
    <td><?php if($row_contratoLlenar['fechaInicio']!='0000-00-00') echo date("d-m-Y",strtotime($row_contratoLlenar['fechaInicio']));?></td>
    <td><?php if($row_contratoLlenar['fechaFinal']!='0000-00-00') echo date("d-m-Y",strtotime($row_contratoLlenar['fechaFinal']));?></td>
    <td><?php if($row_contratoLlenar['valor']!='0')echo $row_contratoLlenar['valor'];?></td>
    <td><?php echo $row_contratoLlenar['completo'];
                if($row_contratoLlenar['completo']=='SI') {
                    $cont_contratoCompleto++;
                }?></td>
    <td><?php echo $row_contratoLlenar['certConformidad'];
                $suma=$row_contratoLlenar['certConformidad']+$suma;?></td>
                <?php if($estado==1 && $Security->CanEdit()){?><td id="x_td_contrato"><a href="formulario_agregar.php?idMer=<?php echo $_GET['idMer']?>&idPlanilla=<?php echo $x_idPlanilla?>&sw=contratoedit&x_idCL=<?php echo $row_contratoLlenar['idCL'];?>" title="editar contrato" id="contratoedit"><img src="images/page_edit.png" border="none"></a></td><?php } ?>
<?php if($estado==1 && $Security->CanDelete()) {?><td><a href="formulario_guardar.php?x_idMer=<?php echo $_GET['idMer']?>&x_idPlanilla=<?php echo $x_idPlanilla;?>&sw=contratodelete&x_idCL=<?php echo $row_contratoLlenar['idCL'];?>" title="borrar contrato" id="contratodelete" onClick="return confirmarDelete();"><img src="images/delete.png" border="none"></a></td><?php } ?>
</tr>
<?php
$cont++;
}
mysql_select_db($database_conexion, $conexion);
$query_contadorRegistro = "SELECT b.idRegistroContrato, b.registroContrato , count(b.idRegistroContrato) as cont FROM contrato_llenar a, registro_contrato b WHERE a.idMer='".(int)$_GET['idMer']."' AND a.idPlanilla='".(int)$x_idPlanilla."' AND a.idRegistroContrato=b.idRegistroContrato GROUP BY b.idRegistroContrato";
$mostrar_contadorRegistro= mysql_query($query_contadorRegistro, $conexion) or die(mysql_error());
?>
<tr><td colspan="11"><div id="carga_contratoLlenar"></div><td></tr>
</table>
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="5"><div class="titulo">RESUMEN DEL FORMULARIO</div></td></tr>
<tr>
    <td class="ewTableHeader">Numero de empleos generados en el periodo (Cumplen requisito)</td><td><?php echo $suma;?></td>
</tr>
</table>
<input type="hidden" name="x_observacion" id="x_observacion" value="<?php echo $row_formulario['observacion'];?>">
<input type="hidden" name="nroContratosCompletos" id="nroContratosCompletos" value="<?php echo $suma;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">MODELO DE CONTRATO TIPO</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?></table>
</div>
</td></tr></table>

</form>
<?php } ?>

<?php if($x_idPlanilla=='21') {    ?>
<form name="formulario1" id="formulario1" action="formulario_guardar.php" method="post" enctype="multipart/form-data" onSubmit="return validar_formulario(this);">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="idPlanilla" id="idPlanilla" value="<?php echo $x_idPlanilla?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="11"><div class="titulo">PARAMETROS DE CALIDAD</div></td></tr>
<tr><td>LA MERS CUENTA CON PARAMETROS DE CALIDAD<td id="idcheck_list"></td></tr>
<tr><td>EN PROCESO %:</td><td id="idcheck_list_porcentaje"></td></tr>
<tr><td>Descripcion del trabajo realizado:</td><td><textarea name="x_observacion" id="x_observacion" rows="2" cols="130"><?php echo $row_formulario['observacion'];?></textarea></td></tr>
</table>
<table cellspacing="0" class="ewTable">
<tr><td colspan="4"><div class="titulo">Ckeck List</div></td></tr>
<tr><td colspan="2">Los Parametros de Calidad Cuenta con:</td>
    <td>SI</td>
    <td>NO</td>
</tr>
            <?php
            $cont_pregunta=1;
            $cont_preguntaSI=0;
            do {?>
<tr>
<td><?php echo $cont_pregunta?><input type="hidden" name="idPregunta_<?php echo $cont_pregunta; ?>" value="<?php echo $row_preguntaRespuesta['idPregunta'] ?>"></td>
<td><?php echo $row_preguntaRespuesta['pregunta'];?></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="SI" <?php if($row_preguntaRespuesta["respuesta"]=="SI") {
echo("checked='checked'");
$cont_preguntaSI++;
}?>/></td>
<td><input name="respuesta_<?php echo $cont_pregunta ?>" id="respuesta_<?php echo $cont_pregunta ?>" type="radio" value="NO" <?php if($row_preguntaRespuesta["respuesta"]=="NO") {
echo("checked='checked'");
} ?>/></td>
</tr>
<?php
$cont_pregunta++;
}while($row_preguntaRespuesta=mysql_fetch_assoc($mostrar_preguntaRespuesta)); ?>

</table>
<input type="hidden" name="check_list" id="check_list">
<input type="hidden" name="check_list_porcentaje" id="check_list_porcentaje">
<input type="hidden" name="preguntaSI" id="preguntaSI" value="<?php echo $cont_preguntaSI;?>">
<input type="hidden" name="x_idMer" value="<?php echo $_GET['idMer'] ?>">
<input type="hidden" name="x_idPlanilla" value="<?php echo $x_idPlanilla ?>">
<table cellspacing="0" class="ewTable">
<tr><td colspan="2"><div class="titulo">REQUISITOS PARA OBTENER LOS PARAMETROS DE CALIDAD</div></td></tr>
<tr><td>Adjuntar Archivo</td><td><?php if($Security->CanAdd()){?><input type="file" name="archivo" id="archivo" class="casilla" size="100"><?php } ?>
<?php
while($row_archivo= mysql_fetch_assoc($mostrar_archivo)) {
if ($gestor = opendir('files')) {
while (false !== ($arch = readdir($gestor))) {
if ($arch != "." && $arch != ".." && $arch==$row_archivo['archivo']) {
echo "<li><a href=\"files/".$arch."\" class=\"linkli\" title='Extraer archivo'>".$arch."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
if($estado==1 && $Security->CanDelete()) {
echo "<a href='formulario_guardar.php?x_idArchivo=".$row_archivo['idArchivo']."&sw=archivodelete&archivo=".$arch."&x_idMer=".$_GET['idMer']."&x_idPlanilla=".$x_idPlanilla."' title='Borrar archivo' onclick='return confirmarDeleteArchivo()'><img src='images/delete.png' height='10' width='12' border='none'></a>";
};
echo "</li>\n";
}
}

closedir($gestor);
}
}
?>
</td></tr>
<?php if($estado==1 && ($Security->CanAdd() || $Security->CanEdit() || $Security->CanDelete())){?>
<tr align="center"><td colspan="2"><div><input type="submit" name="guardar_pregunta" id="guardar_pregunta" value="GUARDAR"></div></td></tr>
<?php } ?></table>
</div>
</td></tr></table>
</form>
            <?php }?>

<!--modificado 18/02/2013-->

<?php if ($x_idPlanilla == '22') { ?>
<?php 
mysql_select_db($database_conexion, $conexion);
$query = "SELECT usu.nombre,usu.paterno,usu.materno,mru.idMer,mru.selector,
mru.comentario,mru.archivo,mru.fechaCreacion,mru.estado
FROM meta_reporte_unitario AS mru
INNER JOIN usuario AS usu ON mru.idUsuario = usu.idUsuario
WHERE mru.idMer = ".(int)$_GET['idMer']." AND mru.selector = 0
ORDER BY mru.fechaCreacion DESC";
$mostrar_arc= mysql_query($query, $conexion) or die(mysql_error());

?>
        
<table>
    <tr>
        <td>
            <table id="table_example" cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
                <thead>
                    <tr class="ewTableHeader">
                        <td>No</td>
                        <td>Consultor</td>
                        <td>Archivo</td>
                        <td>Fecha Creaci&oacute;n</td>
                        <td>Opcion</td>
                    </tr>
                </thead>
                <?php
                $c = 0;
                while ($row = mysql_fetch_assoc($mostrar_arc)) {
                    ?>
                    <tr>
                        <td><?php echo $c ?></td>
                        <td><?php echo $row['nombre'].' '.$row['paterno'].' '.$row['materno'] ?></td>
                        <td><?php echo $row['archivo'] ?></td>
                        <td><?php echo date("d-m-Y", strtotime($row['fechaCreacion'])) ?></td>
                        <td><a href="#">Asignar</a></td>

                    </tr>    
                    <?php
                    $c++;
                }
                ?>
            </table>
        </td>
    </tr>
</table>


    
                
<?php } ?>



<?php include "footer.php" ?>
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
