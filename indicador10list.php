<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "indicador10info.php" ?>
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
$indicador10_list = new cindicador10_list();
$Page =& $indicador10_list;

// Page init processing
$indicador10_list->Page_Init();

// Page main processing
$indicador10_list->Page_Main();
?>
<?php include "header.php" ?>
<script src="ajax/prototype1.7.js" type="text/javascript"></script>
<script type="text/javascript">
function seleccionar_departamento(){
var v_idRegional = document.getElementById("x_idRegional");
var v_idDepartamento = document.getElementById("x_idDepartamento_edit");
new Ajax.Updater('divx_idDepartamento','departamentoSelector.php?idRegional='+v_idRegional.value+'&idDepartamento='+v_idDepartamento.value,{onComplete:function(){
	seleccionar_municipio();
}});
}
function seleccionar_municipio(){
var v_idRegional = document.getElementById("x_idRegional");
var v_idDepartamento = document.getElementById("x_idDepartamento");
var v_idMunicipio = document.getElementById("x_idMunicipio_edit");
new Ajax.Updater('divx_idMunicipio','municipioSelector.php?idRegional='+v_idRegional.value+'&idDepartamento='+v_idDepartamento.value+'&idMunicipio='+v_idMunicipio.value);
}
function ocultar(){
    var i;
    for(i=1;i<$F('contador');i++){
       $('plan_negocio'+i).hide();
       $('plan_estrategico'+i).hide();
       $('plan_produccion'+i).hide();
       $('plan_financiero'+i).hide();
       $('plan_poa'+i).hide();
   }
}
function verOcultarPlanes(){
    var i;
    for(i=1;i<$F('contador');i++){
       $('plan_negocio'+i).toggle();
       $('plan_estrategico'+i).toggle();
       $('plan_produccion'+i).toggle();
       $('plan_financiero'+i).toggle();
       $('plan_poa'+i).toggle();
   }
}
</script>
<span class="phpmaker" style="white-space: nowrap;">
<?php if ($Reporte_Mers->Export == "") { ?>
<div id="linkDescargar"></div>
    <?php } ?>
<script type="text/javascript">
    $(function () {
        $('input#id_search').quicksearch('table table#table_example #contenidoTbody tr');
    });
</script>
    <?php
$combi=combinaciones($_POST['x_gestion'], $_POST['x_idRubro'], $_POST['x_idRegional'], $_POST['x_idDepartamento'], $_POST['x_idMunicipio']);
mysql_select_db($database_conexion, $conexion);
$query_mer = "SELECT a.idMer, b.regional, c.departamento, d.municipio, e.comunidad, a.zona, f.rubro, a.mer, a.gestion FROM mer a, regional b, departamento c, municipio d, comunidad e, rubro f WHERE
    CASE '".$combi."'
        WHEN 1 THEN a.gestion>0 AND a.idRubro>0 AND a.idRegional>0 AND a.idDepartamento>0 AND a.idMunicipio>0
        WHEN 2 THEN a.gestion>0 AND a.idRubro>0 AND a.idRegional>0 AND a.idDepartamento>0 AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 3 THEN a.gestion>0 AND a.idRubro>0 AND a.idRegional>0 AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio>0
        WHEN 4 THEN a.gestion>0 AND a.idRubro>0 AND a.idRegional>0 AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 5 THEN a.gestion>0 AND a.idRubro>0 AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento>0 AND a.idMunicipio>0
        WHEN 6 THEN a.gestion>0 AND a.idRubro>0 AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento>0 AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 7 THEN a.gestion>0 AND a.idRubro>0 AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio>0
        WHEN 8 THEN a.gestion>0 AND a.idRubro>0 AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 9 THEN a.gestion>0 AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional>0 AND a.idDepartamento>0 AND a.idMunicipio>0
        WHEN 10 THEN a.gestion>0 AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional>0 AND a.idDepartamento>0 AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 11 THEN a.gestion>0 AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional>0 AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio>0
        WHEN 12 THEN a.gestion>0 AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional>0 AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 13 THEN a.gestion>0 AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento>0 AND a.idMunicipio>0
        WHEN 14 THEN a.gestion>0 AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento>0 AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 15 THEN a.gestion>0 AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio>0
        WHEN 16 THEN a.gestion>0 AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 17 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro>0 AND a.idRegional>0 AND a.idDepartamento>0 AND a.idMunicipio>0
        WHEN 18 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro>0 AND a.idRegional>0 AND a.idDepartamento>0 AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 19 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro>0 AND a.idRegional>0 AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio>0
        WHEN 20 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro>0 AND a.idRegional>0 AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 21 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro>0 AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento>0 AND a.idMunicipio>0
        WHEN 22 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro>0 AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento>0 AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 23 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro>0 AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio>0
        WHEN 24 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro>0 AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 25 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional>0 AND a.idDepartamento>0 AND a.idMunicipio>0
        WHEN 26 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional>0 AND a.idDepartamento>0 AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 27 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional>0 AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio>0
        WHEN 28 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional>0 AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 29 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento>0 AND a.idMunicipio>0
        WHEN 30 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento>0 AND a.idMunicipio='".$_POST['x_idMunicipio']."'
        WHEN 31 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio>0
        WHEN 32 THEN a.gestion='".$_POST['x_gestion']."' AND a.idRubro='".$_POST['x_idRubro']."' AND a.idRegional='".$_POST['x_idRegional']."' AND a.idDepartamento='".$_POST['x_idDepartamento']."' AND a.idMunicipio='".$_POST['x_idMunicipio']."'
END
    AND a.idRegional = b.idRegional And a.idDepartamento = c.idDepartamento And a.idMunicipio = d.idMunicipio And a.idComunidad = e.idComunidad And a.idRubro = f.idRubro And a.estado > 0 ORDER BY b.regional ASC, c.departamento ASC, d.municipio asc, e.comunidad asc, f.rubro asc";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$totalRows_mer=mysql_num_rows($mostrar_mer);
$contador=1;
?>
</span>
<?php
// seletores para realizar el filtrado
mysql_select_db($database_conexion, $conexion);
$query_gestion= "SELECT gestion FROM mer GROUP BY gestion ORDER BY gestion asc";
$mostrar_gestion=mysql_query($query_gestion, $conexion) or die(mysql_error());
$total_gestion=mysql_num_rows($mostrar_gestion);

mysql_select_db($database_conexion, $conexion);
$query_rubro= "SELECT idRubro, rubro FROM rubro ORDER BY rubro asc";
$mostrar_rubro=mysql_query($query_rubro, $conexion) or die(mysql_error());
$total_rubro=mysql_num_rows($mostrar_rubro);

mysql_select_db($database_conexion, $conexion);
$query_regional= "SELECT idRegional, regional FROM regional ORDER BY regional asc";
$mostrar_regional=mysql_query($query_regional, $conexion) or die(mysql_error());
$total_regional=mysql_num_rows($mostrar_regional);
?>
<form method="post" action="indicador10list.php">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
    <tr style="color: blue">
        <td>Gesti&oacute;n</td>
     <td>
         <select name="x_gestion" id="x_gestion">
             <option value="-1" style="color: gray">Todos...</option>
             <?php
             while($row_gestion=mysql_fetch_assoc($mostrar_gestion)){?>
             <option value="<?php echo $row_gestion['gestion']?>" <?php if($_POST['x_gestion']==$row_gestion['gestion']){echo "selected";}?>><?php echo $row_gestion['gestion']?></option>
             <?php }
             ?>
         </select>
     </td>
     <td>Rubro</td>
     <td>
         <select name="x_idRubro" id="x_idRubro">
             <option value="-1" style="color: gray">Todos...</option>
             <?php
             while($row_rubro=mysql_fetch_assoc($mostrar_rubro)){?>
             <option value="<?php echo $row_rubro['idRubro']?>" <?php if($_POST['x_idRubro']==$row_rubro['idRubro']){echo "selected";}?>><?php echo $row_rubro['rubro']?></option>
             <?php }
             ?>
         </select>
     </td>
     <td>Proyeccion Ventas</td>
     <td>
         <select name="x_formalizada" id="x_formalizada">
             <option value="-1" <?php if($_POST['x_formalizada']=='-1'){echo "selected";$sw='-1';}?> style="color: gray">Todos...</option>
             <option value="1" <?php if(isset ($_POST['x_formalizada'])){if($_POST['x_formalizada']=='1'){echo "selected";$sw='1';}}else{echo "selected";$sw='1';}?>>Mers con Ventas > 99%</option>
             <option value="0" <?php if($_POST['x_formalizada']=='0'){echo "selected";$sw='0';}?>>Mers con Ventas <= 99%</option>
         </select>
     </td>
     </tr>
   <tr style="color: blue">
     <td>Regional</td>
     <td>
         <select name="x_idRegional" id="x_idRegional" onchange="seleccionar_departamento();">
             <option value="-1" style="color:gray" >Todos...</option>
             <?php
             while($row_regional=mysql_fetch_assoc($mostrar_regional)){?>
             <option value="<?php echo $row_regional['idRegional']?>" <?php if($_POST['x_idRegional']==$row_regional['idRegional']){echo "selected";}?>><?php echo $row_regional['regional']?></option>
             <?php }
             ?>
         </select>
     </td>
     <td>Departamento</td>
     <td>
<input type="hidden" name="x_idDepartamento_edit" id="x_idDepartamento_edit" value="<?php if($_POST['x_idDepartamento']>0){echo $_POST['x_idDepartamento'];}else{echo "-1";}?>"/>
<div id="divx_idDepartamento"></div>
     </td>
     <td>Municipio</td>
     <td>
<input type="hidden" name="x_idMunicipio_edit" id="x_idMunicipio_edit" value="<?php if($_POST['x_idMunicipio']>0){echo $_POST['x_idMunicipio'];}else{echo "-1";}?>"/>
<div id="divx_idMunicipio"></div>
     </td>
     </tr>
 <tr>
 <td colspan="6" align="center"><input type="submit" name="filtrar" value="FILTRAR (*)"></td>
 </tr>
 </table>
</div></td></tr></table>
</form>
<div id="div_formulario">
<table>
     <tr style="background: #667120; color:#ffffff; font-size: 15px">
         <th colspan="2">INDICADOR C.2-I.2:</th><td colspan="10">Porcentaje de cumplimiento de venta de servicios de las MERS respecto a lo proyectado en sus planes de negocios: A&ntilde;o 2; 50%; Fin de proyecto: 70% de las 115 MERS</td>
     </tr>
</table>
 <table id="table_example" width="100%" border="1" class="ewTable">
    <thead>
    <tr>
        <th bgcolor="#B8C692"></th>
        <th colspan="5" align="center" bgcolor="#B8C692">INFORME GEOGRAFICO</th>
        <th colspan="4" align="center" bgcolor="#b8c2a5">DATOS DE LA MERS</th>
        <th colspan="3" align="center" bgcolor="#b8f5e0">DOCUMENTOS</th>
        <th colspan="1" align="center" bgcolor="#b89ec1">INDICADOR</th>
    </tr>
    <tr class="ewTableHeader">
        <th>Nro</th>
        <th>Regional</th>
        <th>Departamento</th>
        <th>Municipio</th>
        <th>Comunidad</th>
        <th>Zona</th>
        <th>Rubro</th>
        <th>Razon Social de la Mers</th>
        <th>Responsable de la Mers</th>
        <th>Gesti&oacute;n</th>
        <th style="cursor: pointer" title="Ocultar/Ver Comentarios" onclick="verOcultarPlanes();">Planes <img src="images/expand.gif"></th>
        <th>Meta Trazada Bs.</th>
        <th>Ventas Bs. Bs.</th>
        <th>% cumplimiento</th>
    </tr>
</thead>
<tbody id="contenidoTbody">
<?php
$contIndicador=0;
while ($row_mer=mysql_fetch_assoc($mostrar_mer)){

mysql_select_db($database_conexion, $conexion);
$query_responsable = "SELECT b.nombre, b.materno, b.paterno FROM responsable a, usuario b WHERE a.idMer='".$row_mer['idMer']."' AND a.idGerente=b.idUsuario ORDER BY b.paterno asc";
$mostrar_responsable=mysql_query($query_responsable, $conexion) or die(mysql_error());
$totalRows_responsable=mysql_num_rows($mostrar_responsable);

mysql_select_db($database_conexion, $conexion);
$query_formulario1 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=1";
$mostrar_formulario1= mysql_query($query_formulario1, $conexion) or die(mysql_error());
$row_formulario1= mysql_fetch_assoc($mostrar_formulario1);

mysql_select_db($database_conexion, $conexion);
$query_formulario2 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=2";
$mostrar_formulario2= mysql_query($query_formulario2, $conexion) or die(mysql_error());
$row_formulario2= mysql_fetch_assoc($mostrar_formulario2);

mysql_select_db($database_conexion, $conexion);
$query_formulario3 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=3";
$mostrar_formulario3= mysql_query($query_formulario3, $conexion) or die(mysql_error());
$row_formulario3= mysql_fetch_assoc($mostrar_formulario3);

mysql_select_db($database_conexion, $conexion);
$query_formulario4 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=4";
$mostrar_formulario4= mysql_query($query_formulario4, $conexion) or die(mysql_error());
$row_formulario4= mysql_fetch_assoc($mostrar_formulario4);

mysql_select_db($database_conexion, $conexion);
$query_formulario5 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=5";
$mostrar_formulario5= mysql_query($query_formulario5, $conexion) or die(mysql_error());
$row_formulario5= mysql_fetch_assoc($mostrar_formulario5);

mysql_select_db($database_conexion, $conexion);
$query_formulario6= "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=6";
$mostrar_formulario6= mysql_query($query_formulario6, $conexion) or die(mysql_error());
$row_formulario6= mysql_fetch_assoc($mostrar_formulario6);

mysql_select_db($database_conexion, $conexion);
$query_meta15= "SELECT sum(respuesta) as meta FROM pregunta_respuesta WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=15 GROUP BY idMer";
$mostrar_meta15= mysql_query($query_meta15, $conexion) or die(mysql_error());
$row_meta15= mysql_fetch_assoc($mostrar_meta15);

mysql_select_db($database_conexion, $conexion);
$query_logro17= "SELECT sum(valor) as logro FROM registroventas17 WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=17  GROUP BY idMer";
$mostrar_logro17= mysql_query($query_logro17, $conexion) or die(mysql_error());
$row_logro17= mysql_fetch_assoc($mostrar_logro17);

if($row_meta15['meta']>'0'){$resul=($row_logro17['logro']*100)/$row_meta15['meta'];}else{$resul=0;}
if(($row_formulario2['cuenta']=='SI' || $row_formulario3['cuenta']=='SI' || $row_formulario4['cuenta']=='SI' || $row_formulario5['cuenta']=='SI' || $row_formulario6['cuenta']=='SI') && ($resul>'99')){$indicador2='1';}else{$indicador2='0';}
if($sw==$indicador2 || $sw=='-1'){
?>
<tr <?php if($contador%2==0){echo "bgcolor='#F1F1F1'";}?>>
<td><?php echo $contador;?></td>
        <td><?php echo $row_mer['regional'];?></td>
        <td><?php echo $row_mer['departamento'];?></td>
        <td><?php echo $row_mer['municipio'];?></td>
        <td><?php echo $row_mer['comunidad'];?></td>
        <td><?php echo $row_mer['zona'];?></td>
        <td><?php echo $row_mer['rubro'];?></td>
        <td><?php echo $row_mer['mer'];?></td>
        <td><?php
        $color=1;
        while ($row_responsable=mysql_fetch_assoc($mostrar_responsable)){ ?>
            <div <?php if($color%2==0){echo "style='background:#d7d3c8'";}?>><?php echo $row_responsable['paterno']." ".$row_responsable['materno'].", ".$row_responsable['nombre']."</div>";
        $color++;
        }?>
        </td>
        <td><?php echo $row_mer['gestion'];?></td>
        <td>
<table width="120px" id="poas_table">
        <tr <?php if($row_formulario2['cuenta']=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
       <td>Plan Negocio <?php echo $tiqueado ?></td>
       <td id="plan_negocio<?php echo $contador?>"><?php echo $row_formulario2['observacion']?></td>
        </tr>
        <tr <?php if($row_formulario3['cuenta']=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
       <td>Plan Estrategico <?php echo $tiqueado ?></td>
       <td id="plan_estrategico<?php echo $contador?>"><?php echo $row_formulario3['observacion']?></td>
        </tr>
        <tr <?php if($row_formulario5['cuenta']=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
       <td>Plan Produccion <?php echo $tiqueado ?></td>
       <td id="plan_produccion<?php echo $contador?>"><?php echo $row_formulario5['observacion']?></td>
        </tr>
        <tr <?php if($row_formulario4['cuenta']=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
       <td>Plan Financiero <?php echo $tiqueado ?></td>
       <td id="plan_financiero<?php echo $contador?>"><?php echo $row_formulario4['observacion']?></td>
        </tr>
        <tr <?php if($row_formulario6['cuenta']=='SI'){echo "style='color:blue'"; $tiqueado="&radic;";}else{echo "style='color:gray'";$tiqueado="";}?>>
       <td>Plan POA <?php echo $tiqueado ?></td>
       <td id="plan_poa<?php echo $contador?>"><?php echo $row_formulario6['observacion']?></td>
        </tr>
    </table>
        </td>
        <td><?php printf("%0.1f",$row_meta15['meta']) ?></td>
        <td><?php printf("%0.1f",$row_logro17['logro']) ?></td>
        <td <?php if($indicador2=='1'){ echo "style='background:#C2D69A'"; $contIndicador=$contIndicador+1;}else{  echo "style='background:#FFFF99'"; }?>><?php printf("%0.1f",$resul); echo "%";?></td>
    </tr>
<?php
$contador++;
}
} ?>
 </tbody>
 </table>
     <input type="hidden" name="contador" id="contador" value="<?php echo $contador?>">
<table>
     <tr style="background: #667120; color:#ffffff; font-size: 15px">
         <th colspan="2">INDICADOR C.2-I.2:</th><td colspan="10">Porcentaje de cumplimiento de venta de servicios de las MERS respecto a lo proyectado en sus planes de negocios: A&ntilde;o 2; 50%; Fin de proyecto: 70% de las 115 MERS</td>
     </tr>
     <tr style="background:#b8f5e0; font-size: 11px; text-align: center">
         <th colspan="6">N&uacute;mero de MERS con cumplimiento de ventas: <?php echo $contIndicador; ?></th><td colspan="6">Porcentaje de cumplimiento de ventas: <?php printf("%0.2f", ($contIndicador*100)/115); echo" %"; ?></td>
     </tr>

</table>
</div>
<script type="text/javascript" language="javascript">
<!--
//Free Memory allow case
x320001();
seleccionar_departamento();
ocultar();
-->
</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cindicador10_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'indicador10';

	// Page Object Name
	var $PageObjName = 'indicador10_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $indicador10;
		if ($indicador10->UseTokenInUrl) $PageUrl .= "t=" . $indicador10->TableVar . "&"; // add page token
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
		global $objForm, $indicador10;
		if ($indicador10->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($indicador10->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($indicador10->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cindicador10_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["indicador10"] = new cindicador10();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'indicador10', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $indicador10;
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
	$indicador10->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $indicador10->Export; // Get export parameter, used in header
	$gsExportFile = $indicador10->TableVar; // Get export file, used in header
	if ($indicador10->Export == "print" || $indicador10->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($indicador10->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $indicador10;
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
		if ($indicador10->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $indicador10->getRecordsPerPage(); // Restore from Session
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
		$indicador10->setSessionWhere($sFilter);
		$indicador10->CurrentFilter = "";

		// Export data only
		if (in_array($indicador10->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $indicador10;
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
			$indicador10->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$indicador10->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $indicador10;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$indicador10->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$indicador10->CurrentOrderType = @$_GET["ordertype"];
			$indicador10->UpdateSort($indicador10->idMer); // Field 
			$indicador10->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $indicador10;
		$sOrderBy = $indicador10->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($indicador10->SqlOrderBy() <> "") {
				$sOrderBy = $indicador10->SqlOrderBy();
				$indicador10->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $indicador10;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$indicador10->setSessionOrderBy($sOrderBy);
				$indicador10->idMer->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$indicador10->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $indicador10;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$indicador10->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$indicador10->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $indicador10->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$indicador10->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$indicador10->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$indicador10->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $indicador10;

		// Call Recordset Selecting event
		$indicador10->Recordset_Selecting($indicador10->CurrentFilter);

		// Load list page SQL
		$sSql = $indicador10->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$indicador10->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $indicador10;
		$sFilter = $indicador10->KeyFilter();

		// Call Row Selecting event
		$indicador10->Row_Selecting($sFilter);

		// Load sql based on filter
		$indicador10->CurrentFilter = $sFilter;
		$sSql = $indicador10->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$indicador10->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $indicador10;
		$indicador10->idMer->setDbValue($rs->fields('idMer'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $indicador10;

		// Call Row_Rendering event
		$indicador10->Row_Rendering();

		// Common render codes for all row types
		// idMer

		$indicador10->idMer->CellCssStyle = "";
		$indicador10->idMer->CellCssClass = "";
		if ($indicador10->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$indicador10->idMer->ViewValue = $indicador10->idMer->CurrentValue;
			$indicador10->idMer->CssStyle = "";
			$indicador10->idMer->CssClass = "";
			$indicador10->idMer->ViewCustomAttributes = "";

			// idMer
			$indicador10->idMer->HrefValue = "";
		}

		// Call Row Rendered event
		$indicador10->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $indicador10;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($indicador10->ExportAll) {
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
		if ($indicador10->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($indicador10->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $indicador10->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idMer', $indicador10->Export);
				echo ew_ExportLine($sExportStr, $indicador10->Export);
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
				$indicador10->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($indicador10->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idMer', $indicador10->idMer->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $indicador10->Export <> "csv") { // Vertical format
						echo ew_ExportField('idMer', $indicador10->idMer->ExportValue($indicador10->Export, $indicador10->ExportOriginalValue), $indicador10->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $indicador10->idMer->ExportValue($indicador10->Export, $indicador10->ExportOriginalValue), $indicador10->Export);
						echo ew_ExportLine($sExportStr, $indicador10->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($indicador10->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($indicador10->Export);
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
