<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "reporte_generalinfo.php" ?>
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
$reporte_general_list = new creporte_general_list();
$Page =& $reporte_general_list;

// Page init processing
$reporte_general_list->Page_Init();

// Page main processing
$reporte_general_list->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
    var x=$(document);
    x.ready(inicializarEventos);
    function inicializarEventos()
    { var x=$("#num_indicador");
        x.change(seleccionarIndicador);
     }
     function seleccionarIndicador(){
         var i,y,z,w;
         var x=$("#num_indicador").attr("value");
         //alert(x);
      if(x!=16){
      for(i=1;i<=14;i++){
          if(i!=x && x!=0){
            y=$("#table_example tr #i"+i);
            z=$("#table_example tr #c"+i);
            w=$("#table_example tr #r"+i);
            y.hide();
            z.hide();
            w.hide();
          }else{
            y=$("#table_example tr #i"+i);
            z=$("#table_example tr #c"+i);
            w=$("#table_example tr #r"+i);
            y.show();
            z.show();
            w.show();
        }
      }
      }else{
         for(i=1;i<=15;i++){
            y=$("#table_example tr #c"+i);
            y.hide();
          }
      }
     }
</script>
<script type="text/javascript">
    $(function () {
        $('input#id_search').quicksearch('table table#table_example #contenidoTbody tr');
    });
</script>
<span class="phpmaker" style="white-space: nowrap;">
<?php if ($Reporte_Mers->Export == "") { ?>
<div id="linkDescargar"></div>
    <?php } ?>
<?php
if ($Reporte_Mers->Export == "") {
mysql_select_db($database_conexion, $conexion);
$query_mer = "SELECT a.idMer,b.regional,c.departamento,d.municipio,e.comunidad,a.zona,f.rubro,a.mer,a.gestion,f.detalle,f.gestion2009,f.gestion2010,f.gestion2011,f.gestion2012,a.unidadProductivaDedica,
a.codigo,a.numeroSocios,a.direccion,a.referencia,a.refTelefonica,a.refCelular,a.fechaInicio,a.fechaFinal,a.fechaCreacion,a.fechaModificacion,a.longitudUTM,a.latitudUTM
FROM mer a, regional b, departamento c, municipio d, comunidad e, rubro f
WHERE a.idRegional = b.idRegional And a.idDepartamento = c.idDepartamento And a.idMunicipio = d.idMunicipio And a.idComunidad = e.idComunidad And a.idRubro = f.idRubro And a.estado > 0
ORDER BY a.idMer ASC";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$totalRows_mer=mysql_num_rows($mostrar_mer);
$contador=1;
}
?>
</span>


<div id="div_formulario">
 <table id="table_example" width="100%" border="1" class="ewTable">
    <thead>
    <tr>
        <th bgcolor="#B8C692"></th>
        <th colspan="5" align="center" bgcolor="#B8C692">INFORME GEOGRAFICO</th>
        <th colspan="4" align="center" bgcolor="#b8c2a5">DATOS DE LA MERS</th>
        <th colspan="5" align="center" bgcolor="#b89ec1" id="i1">INDICADOR 1<br>Numero de MERS sostenibles y en funcionamiento: A&ntilde;o 2: 50; Fin proyecto: 115</th>
        <th colspan="2" align="center" bgcolor="#b89ec1" id="i2">INDICADOR 2<br>N&uacute;mero de empleos generados: A&ntilde;o 2:  150; Fin proyecto: 450</th>
        <th colspan="1" align="center" bgcolor="#b89ec1" id="i3">INDICADOR 3<br>Al final del proyecto al menos un contrato en cada municipio con una MERS</th>
        <th colspan="1" align="center" bgcolor="#b89ec1" id="i4">INDICADOR 4<br>Al final del proyecto al menos una alianza publico privada en la zona del proyecto. </th>
        <th colspan="2" align="center" bgcolor="#b89ec1" id="i5">INDICADOR 5<br>% de MERS  formalizadas (Testimonio, Reglamentos, Estatutos, Tarjeta Empresarial, u otros). A&ntilde;o 2: 30%; Fin proyecto: 70% de las 115  MERS</th>
        <th colspan="3" align="center" bgcolor="#b89ec1" id="i6">INDICADOR 6<br>% de  MERS que aplican instrumentos de gestion empresarial  (contabilidad basica, administracion y plan de negocios). A&ntilde;o 2: 30%; Fin proyecto:</th>
        <th colspan="1" align="center" bgcolor="#b89ec1" id="i7">INDICADOR 7<br>% de  MERS que acceden a creditos: A&ntilde;o 2: 10%; Fin de proyecto: 30% de las 115  MERS</th>
        <th colspan="1" align="center" bgcolor="#b89ec1" id="i8">INDICADOR 8<br>% maximo de MERS con problemas de mora en el financiamiento durante todo el proyecto: 10% de las 115  MERS</th>
        <th colspan="1" align="center" bgcolor="#b89ec1" id="i9">INDICADOR 9<br>% de MERS que han prestado servicios a entidades publicas o privadas, con contrato formal: A&ntilde;o 2: 30%; Fin de proyecto: 80% de las 115  MERS</th>
        <th colspan="1" align="center" bgcolor="#b89ec1" id="i10">INDICADOR 10<br>% de cumplimiento de venta de servicios de las MERS respecto a lo proyectado en sus planes de negocios: A&ntilde;o 2; 50%; Fin de proyecto: 70% de las 115  MERS</th>
        <th colspan="2" align="center" bgcolor="#b89ec1" id="i11">INDICADOR 11<br>% de MERS que cumplen sus contratos de servicios: A&ntilde;o 2: 20%; Fin de proyecto: 80% de las 115  MERS</th>
        <th colspan="1" align="center" bgcolor="#b89ec1" id="i12">INDICADOR 12<br>Municipios que establecen una alianza publico-privada con fines de desarrollo. A&ntilde;o 2:  4; Fin de proyecto: 8</th>
        <th colspan="1" align="center" bgcolor="#b89ec1" id="i13">INDICADOR 13<br>Municipios que incorporan acciones de apoyo al sector productivo en sus Planes Anuales y los ejecutan. A&ntilde;o 2: 4; Fin de proyecto: 8</th>
        <th colspan="1" align="center" bgcolor="#b89ec1" id="i14">INDICADOR 14<br>Municipios que contratan anualmente los servicios de al menos una MERS. A&ntilde;o 2: 4; Fin de proyecto: 8</th>
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
        
        <th>Detalle</th>
        <th>gestion2009</th>
        <th>gestion2010</th>
        <th>gestion2011</th>
        <th>gestion2011</th>
        <th>Mer se dedica</th>
        <th>Codigo</th>
        <th>Numero Socios</th>
        <th>direccion</th>
        <th>Referencia</th>
        <th>Ref. Telefonica</th>
        <th>Ref. Celular</th>
        <th>Fecha Inicio</th>
        <th>Fecha Conclusion</th>
        <th>Fecha de Creacion</th>
        <th>Fecha de Modificacion</th>
        <th>Longitud UTM</th>
        <th>Latitud UTM</th>

        <th>Plan de Negocio Cuenta</th>
        <th>Plan de Negocio Archivo</th>
        <th>Plan de Negocio Porcentaje</th>
        <th>Plan de Negocio Observacion</th>
        <th>Plan Estrategico Cuenta</th>
        <th>Plan Estrategico Archivo</th>
        <th>Plan Estrategico Porcentaje</th>
        <th>Plan Estrategico Observacion</th>
        <th>Plan Produccion Cuenta</th>
        <th>Plan Produccion Archivo</th>
        <th>Plan Produccion Porcentaje</th>
        <th>Plan Produccion Observacion</th>
        <th>Plan Financiero Cuenta</th>
        <th>Plan Financiero Archivo</th>
        <th>Plan Financiero Porcentaje</th>
        <th>Plan Financiero Observacion</th>
        <th>POA Cuenta</th>
        <th>POA Archivo</th>
        <th>POA Porcentaje</th>
        <th>POA Observacion</th>

        <th>Personeria Juridica Cuenta</th>
        <th>Personeria Juridica Archivo</th>
        <th>Personeria Juridica Porcentaje</th>
        <th>Personeria Juridica Observacion</th>
        <th>Estatuto Organico Cuenta</th>
        <th>Estatuto Organico Archivo</th>
        <th>Estatuto Organico Porcentaje</th>
        <th>Estatuto Organico Observacion</th>
        <th>Reglamento Interno Cuenta</th>
        <th>Reglamento Interno Archivo</th>
        <th>Reglamento Interno Porcentaje</th>
        <th>Reglamento Interno Observacion</th>
        <th>Reg. FundaEmpresa Cuenta</th>
        <th>Reg. FundaEmpresa Archivo</th>
        <th>Reg. FundaEmpresa Porcentaje</th>
        <th>Reg. FundaEmpresa Observacion</th>
        <th>Acta Constitucion Cuenta</th>
        <th>Acta Constitucion Archivo</th>
        <th>Acta Constitucion Porcentaje</th>
        <th>Acta Constitucion Observacion</th>
        <th>Tarjeta Empresarial Cuenta</th>
        <th>Tarjeta Empresarial Archivo</th>
        <th>Tarjeta Empresarial Porcentaje</th>
        <th>Tarjeta Empresarial Observacion</th>


        <th id="c1">Estrategia Promocional</th>
        <th id="c1">Reg. Ventas</th>
        <th id="c1"></th>
        <th id="c2">Nro. Empleos</th>
        <th id="c2">Tipo de Empleos</th>
        <th id="c3">Contratos Municipio-MERS</th>
        <th id="c4">Alianza P&uacute;blico privada (con algun organismo del sector p&uacute;blico: empresas estatales, gob locales, gob departamentales, etc)</th>
        <th id="c5">Documentos de formalizaci&oacute;n de las MERS</th>
        <th id="c5"></th>
        <th id="c6">a1) Planificacion</th>
        <th id="c6">b1)Registro de ventas - b2)Registros contables</th>
        <th id="c6"></th>
        <th id="c7">Informes del sistema de monitoreo</th>
        <th id="c8">Informes de evaluacion del proyecto</th>
        <th id="c9">Contratos represtacion de servicios</th>
        <th id="c10">Datos del sistema de monitoreo y seguimiento de las MERS</th>
        <th id="c11">Planes de negocios: A)Existencia de contratos - B)Cumplimiento del contrato (mediante algun documento de satisfaccion)</th>
        <th id="c11"></th>
        <th id="c12">Convenios de cooperaci&oacute;n interinstitucional entre MERS y los gobiernos locales en los que se ejecuta el proyecto.</th>
        <th id="c13">A)Ruedas de Negocio ( organizacion) - B)Organizacion de Misiones comerciales (a ruedas de negocio o a ferias comerciales) - C)Organizacion de ferias locales distintas  a las fiestas patronales o comunales</th>
        <th id="c14">Contratos de prestacion de servicios entre MERS y gobiernos locales en los que se ejecuta el proyecto.</th>
        </tr>
</thead>
<tbody id="contenidoTbody">
<?php if ($Reporte_Mers->Export == "") { ?>
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
$query_formulario6 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=6";
$mostrar_formulario6= mysql_query($query_formulario6, $conexion) or die(mysql_error());
$row_formulario6= mysql_fetch_assoc($mostrar_formulario6);

mysql_select_db($database_conexion, $conexion);
$query_formulario7 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=7";
$mostrar_formulario7= mysql_query($query_formulario7, $conexion) or die(mysql_error());
$row_formulario7= mysql_fetch_assoc($mostrar_formulario7);

mysql_select_db($database_conexion, $conexion);
$query_formulario8 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=8";
$mostrar_formulario8= mysql_query($query_formulario8, $conexion) or die(mysql_error());
$row_formulario8= mysql_fetch_assoc($mostrar_formulario8);

mysql_select_db($database_conexion, $conexion);
$query_formulario9 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=9";
$mostrar_formulario9= mysql_query($query_formulario9, $conexion) or die(mysql_error());
$row_formulario9= mysql_fetch_assoc($mostrar_formulario9);

mysql_select_db($database_conexion, $conexion);
$query_formulario10 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=10";
$mostrar_formulario10= mysql_query($query_formulario10, $conexion) or die(mysql_error());
$row_formulario10= mysql_fetch_assoc($mostrar_formulario10);

mysql_select_db($database_conexion, $conexion);
$query_formulario11 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=11";
$mostrar_formulario11= mysql_query($query_formulario11, $conexion) or die(mysql_error());
$row_formulario11= mysql_fetch_assoc($mostrar_formulario11);

mysql_select_db($database_conexion, $conexion);
$query_formulario12 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=12";
$mostrar_formulario12= mysql_query($query_formulario12, $conexion) or die(mysql_error());
$row_formulario12= mysql_fetch_assoc($mostrar_formulario12);

mysql_select_db($database_conexion, $conexion);
$query_formulario13 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=13";
$mostrar_formulario13= mysql_query($query_formulario13, $conexion) or die(mysql_error());
$row_formulario13= mysql_fetch_assoc($mostrar_formulario13);

mysql_select_db($database_conexion, $conexion);
$query_formulario14 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=14";
$mostrar_formulario14= mysql_query($query_formulario14, $conexion) or die(mysql_error());
$row_formulario14= mysql_fetch_assoc($mostrar_formulario14);

mysql_select_db($database_conexion, $conexion);
$query_formulario15 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=15";
$mostrar_formulario15= mysql_query($query_formulario15, $conexion) or die(mysql_error());
$row_formulario15= mysql_fetch_assoc($mostrar_formulario15);

mysql_select_db($database_conexion, $conexion);
$query_formulario16 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=16";
$mostrar_formulario16= mysql_query($query_formulario16, $conexion) or die(mysql_error());
$row_formulario16= mysql_fetch_assoc($mostrar_formulario16);
$totalRows_formulario16=mysql_num_rows($mostrar_formulario16);

mysql_select_db($database_conexion, $conexion);
$query_formulario17 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=17";
$mostrar_formulario17= mysql_query($query_formulario17, $conexion) or die(mysql_error());
$row_formulario17= mysql_fetch_assoc($mostrar_formulario17);

mysql_select_db($database_conexion, $conexion);
$query_formulario18 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=18";
$mostrar_formulario18= mysql_query($query_formulario18, $conexion) or die(mysql_error());
$row_formulario18= mysql_fetch_assoc($mostrar_formulario18);

mysql_select_db($database_conexion, $conexion);
$query_formulario19 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=19";
$mostrar_formulario19= mysql_query($query_formulario19, $conexion) or die(mysql_error());
$row_formulario19= mysql_fetch_assoc($mostrar_formulario19);

mysql_select_db($database_conexion, $conexion);
$query_formulario20 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=20";
$mostrar_formulario20= mysql_query($query_formulario20, $conexion) or die(mysql_error());
$row_formulario20= mysql_fetch_assoc($mostrar_formulario20);

mysql_select_db($database_conexion, $conexion);
$query_planificado = "SELECT sum(respuesta) as planificado FROM pregunta_respuesta WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=15";
$mostrar_planificado= mysql_query($query_planificado, $conexion) or die(mysql_error());
$row_planificado= mysql_fetch_assoc($mostrar_planificado);

mysql_select_db($database_conexion, $conexion);
$query_conformidad = "SELECT count(certConformidad) as conformidad FROM contrato_llenar WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=1 AND certConformidad='SI'";
$mostrar_conformidad= mysql_query($query_conformidad, $conexion) or die(mysql_error());
$row_conformidad= mysql_fetch_assoc($mostrar_conformidad);

mysql_select_db($database_conexion, $conexion);
$query_preguntaRespuesta = "SELECT b.pregunta, a.respuesta FROM pregunta_respuesta a, pregunta b WHERE a.idMer='".$row_mer['idMer']."' AND a.idPlanilla=13 AND a.idPregunta=b.idPregunta";
$mostrar_preguntaRespuesta= mysql_query($query_preguntaRespuesta, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_empleos = "SELECT sum(certConformidad) as empleos FROM contrato_llenar WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=20 AND completo='SI'";
$mostrar_empleos= mysql_query($query_empleos, $conexion) or die(mysql_error());
$row_empleos= mysql_fetch_assoc($mostrar_empleos);

mysql_select_db($database_conexion, $conexion);
$query_nrocontratos = "SELECT sum(a.nroContrato) as nroContrato, a.idTipoContrato, b.tipoContrato FROM contrato_llenar a, tipo_contrato b WHERE a.idMer='".$row_mer['idMer']."' AND a.idPlanilla=20 AND a.completo='SI' AND a.idTipoContrato=b.idTipoContrato GROUP BY a.idTipoContrato";
$mostrar_nrocontratos = mysql_query($query_nrocontratos, $conexion) or die(mysql_error());
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

        
        <td><?php echo $row_mer['detalle'];?></td>
        <td><?php echo $row_mer['gestion2009'];?></td>
        <td><?php echo $row_mer['gestion2010'];?></td>
        <td><?php echo $row_mer['gestion2011'];?></td>
        <td><?php echo $row_mer['gestion2012'];?></td>
        <td><?php echo $row_mer['unidadProductivaDedica'];?></td>
        <td><?php echo $row_mer['codigo'];?></td>
        <td><?php echo $row_mer['numeroSocios'];?></td>
        <td><?php echo $row_mer['direccion'];?></td>
        <td><?php echo $row_mer['referencia'];?></td>
        <td><?php echo $row_mer['refTelefonica'];?></td>
        <td><?php echo $row_mer['refCelular'];?></td>
        <td><?php echo $row_mer['fechaInicio'];?></td>
        <td><?php echo $row_mer['fechaFinal'];?></td>
        <td><?php echo $row_mer['fechaCreacion'];?></td>
        <td><?php echo $row_mer['fechaModificacion'];?></td>
        <td><?php echo $row_mer['longitudUTM'];?></td>
        <td><?php echo $row_mer['latitudUTM'];?></td>

       <!--plan de negocio -->
        <td><?php echo $row_formulario2['cuenta'];?></td>
        <td><?php echo $row_formulario2['archivo'];?></td>
        <td><?php echo $row_formulario2['porcentaje'];?></td>
        <td><?php echo $row_formulario2['observacion'];?></td>
        <td><?php echo $row_formulario3['cuenta'];?></td>
        <td><?php echo $row_formulario3['archivo'];?></td>
        <td><?php echo $row_formulario3['porcentaje'];?></td>
        <td><?php echo $row_formulario3['observacion'];?></td>
        <td><?php echo $row_formulario5['cuenta'];?></td>
        <td><?php echo $row_formulario5['archivo'];?></td>
        <td><?php echo $row_formulario5['porcentaje'];?></td>
        <td><?php echo $row_formulario5['observacion'];?></td>
        <td><?php echo $row_formulario4['cuenta'];?></td>
        <td><?php echo $row_formulario4['archivo'];?></td>
        <td><?php echo $row_formulario4['porcentaje'];?></td>
        <td><?php echo $row_formulario4['observacion'];?></td>
        <td><?php echo $row_formulario6['cuenta'];?></td>
        <td><?php echo $row_formulario6['archivo'];?></td>
        <td><?php echo $row_formulario6['porcentaje'];?></td>
        <td><?php echo $row_formulario6['observacion'];?></td>

        <td><?php echo $row_formulario19['cuenta'];?></td>
        <td><?php echo $row_formulario19['archivo'];?></td>
        <td><?php echo $row_formulario19['porcentaje'];?></td>
        <td><?php echo $row_formulario19['observacion'];?></td>
        <td><?php echo $row_formulario8['cuenta'];?></td>
        <td><?php echo $row_formulario8['archivo'];?></td>
        <td><?php echo $row_formulario8['porcentaje'];?></td>
        <td><?php echo $row_formulario8['observacion'];?></td>
        <td><?php echo $row_formulario9['cuenta'];?></td>
        <td><?php echo $row_formulario9['archivo'];?></td>
        <td><?php echo $row_formulario9['porcentaje'];?></td>
        <td><?php echo $row_formulario9['observacion'];?></td>
        <td><?php echo $row_formulario11['cuenta'];?></td>
        <td><?php echo $row_formulario11['archivo'];?></td>
        <td><?php echo $row_formulario11['porcentaje'];?></td>
        <td><?php echo $row_formulario11['observacion'];?></td>
        <td><?php echo $row_formulario7['cuenta'];?></td>
        <td><?php echo $row_formulario7['archivo'];?></td>
        <td><?php echo $row_formulario7['porcentaje'];?></td>
        <td><?php echo $row_formulario7['observacion'];?></td>
        <td><?php echo $row_formulario10['cuenta'];?></td>
        <td><?php echo $row_formulario10['archivo'];?></td>
        <td><?php echo $row_formulario10['porcentaje'];?></td>
        <td><?php echo $row_formulario10['observacion'];?></td>


        <td id="r1"><table width="90px"><tr><td>Producto Desarrollado<input type="checkbox" <?php if($row_formulario3['cuenta']=='SI' || $row_formulario4['cuenta']=='SI' || $row_formulario5['cuenta']=='SI' || $row_formulario6['cuenta']=='SI'){echo "checked";}?>></td></tr><tr><td>Servicio Desarrollado<input type="checkbox" <?php if($row_formulario3['cuenta']=='SI' || $row_formulario4['cuenta']=='SI' || $row_formulario5['cuenta']=='SI' || $row_formulario6['cuenta']=='SI'){echo "checked";}?>></td></tr><tr><td>Plan Marketing<input type="checkbox" <?php if($row_formulario2['cuenta']=='SI'){echo "checked";}?>></td></tr></table></td>
        <td id="r1"><div>Registros de Ventas<input type="checkbox" <?php if($row_formulario17['cuenta']=='SI'){echo "checked";}?>></div></td>
        <?php if(($row_formulario2['cuenta']=='SI' || $row_formulario3['cuenta']=='SI' || $row_formulario4['cuenta']=='SI'|| $row_formulario5['cuenta']=='SI' || $row_formulario6['cuenta']=='SI')&& ($row_formulario19['cuenta']=='SI' || $row_formulario8['cuenta']=='SI' || $row_formulario9['cuenta']=='SI' || $row_formulario11['cuenta']=='SI' || $row_formulario7['cuenta']=='SI' || $row_formulario10['cuenta']=='SI') && ($row_formulario17['cuenta']=='SI')){$indicador2='Formalizada';$contIndicador=$contIndicador+1;}else{$indicador2='No Form.';} ?>
        <td id="r1" style="background:<?php if($indicador2=='Formalizada'){echo "#075e0d";}else{echo "#f35041";};?>; color: #ffffff; text-align: center"><?php echo $indicador2;?></td>
        <td id="r2"><?php echo $row_empleos['empleos'];?></td>
        <td id="r2">
        <?php while($row_nrocontratos = mysql_fetch_assoc($mostrar_nrocontratos)){?>
        <div><?php echo $row_nrocontratos['tipoContrato']."=".$row_nrocontratos['nroContrato']?></div>
       <?php } ?>
        </td>
        <td id="r3">Contratato Municipio MERS<input type="checkbox" <?php if($row_formulario12['cuenta']=='SI'){echo "checked";}?>></td>
        <td id="r4">Alianza Publico Privada<input type="checkbox" <?php if($row_formulario14['cuenta']=='SI'){echo "checked";}?>></td>
        <td id="r5"><table width="130px"><tr><td>Personeria<input type="checkbox" <?php if($row_formulario19['cuenta']=='SI'){echo "checked";}?>></td></tr><tr><td>Estatuto Organico<input type="checkbox" <?php if($row_formulario8['cuenta']=='SI'){echo "checked";}?>></td></tr><tr><td>Reglamento Interno<input type="checkbox" <?php if($row_formulario9['cuenta']=='SI'){echo "checked";}?>></td></tr><tr><td>Tarjeta Empresarial<input type="checkbox" <?php if($row_formulario10['cuenta']=='SI'){echo "checked";}?>></td></tr></table></td>
        <?php if($row_formulario19['cuenta']=='SI' && ($row_formulario10['cuenta']=='SI' || ($row_formulario8['cuenta']=='SI' && $row_formulario9['cuenta']=='SI'))){$indicador6='Cumple';}else{$indicador6='No Cumple';} ?>
        <td id="r5" style="background:<?php if($indicador6=='Cumple'){echo "#075e0d";}else{echo "#f35041";};?>; color: #ffffff; text-align: center"><?php echo $indicador6;?></td>
        <td id="r6"><table width="120px"><tr><td>Plan de Negocio<input type="checkbox" <?php if($row_formulario2['cuenta']=='SI'){echo "checked";}?>></td></tr><tr><td>Plan Estrategico<input type="checkbox" <?php if($row_formulario3['cuenta']=='SI'){echo "checked";}?>></td></tr><tr><td>Plan Produccion<input type="checkbox" <?php if($row_formulario5['cuenta']=='SI'){echo "checked";$b24=$row_formulario5['cuenta'];}?>></td></tr><tr><td>Plan Financiero<input type="checkbox" <?php if($row_formulario4['cuenta']=='SI'){echo "checked";}?>></td></tr></table></td>
        <td id="r6"><table width="141px"><tr><td>Registro Ventas<input type="checkbox" <?php if($row_formulario17['cuenta']=='SI'){echo "checked";}?>></td></tr><tr><td>Registros Contables<input type="checkbox" <?php if($row_formulario18['cuenta']=='SI'){echo "checked";}?>></td></tr></table></td>
        <?php  if(($row_formulario2['cuenta']=='SI' || $row_formulario3['cuenta']=='SI' || $row_formulario4['cuenta']=='SI'|| $row_formulario5['cuenta']=='SI') && ($row_formulario17['cuenta']=='SI' || $row_formulario18['cuenta']=='SI')){$indicador7='Cumple';}else{$indicador7='No Cumple';}?>
        <td id="r6" style="background:<?php if($indicador7=='Cumple'){echo "#075e0d";}else{echo "#f35041";};?>; color: #ffffff; text-align: center"><?php echo $indicador7;?></td>
        <td id="r7">Documento de Prestamo<input type="checkbox" <?php if($row_formulario16['cuenta']=='SI'){echo "checked";}?>></td>
        <td id="r8">Mora<input type="checkbox" <?php if($totalRows_formulario16>0){ if($row_formulario16['porcentaje']=='1'){echo "checked";}}?>></td>
        <td id="r9">Contrato formal<input type="checkbox" <?php if($row_formulario1['cuenta']=='SI'){echo "checked";}?>></td>
        <td id="r10"><?php if($row_formulario17['porcentaje']!=0 && $row_planificado['planificado']!=0){echo ($row_formulario17['porcentaje']/$row_planificado['planificado'])*100;}?>%</td>
        <td id="r11"><table width="120px"><tr><td>Plan Negocio<input type="checkbox"  <?php if($row_formulario2['cuenta']=='SI'){echo "checked";}?>></td></tr><tr><td>Contrato Servicios<input type="checkbox"  <?php if($row_formulario1['cuenta']=='SI'){echo "checked";}?>></td></tr><tr><td>Certificado Satisfaccion<input type="checkbox"  <?php if($row_conformidad['conformidad']>0){echo "checked";}?>></td></tr></table></td>
        <?php if($row_formulario2['cuenta']=='SI' && $row_formulario1['cuenta']=='SI' && $row_conformidad['conformidad']>0) {$indicador10='Cumple';}else{$indicador10='No Cumple';} ?>
        <td id="r11" style="background:<?php if($indicador10=='Cumple'){echo "#075e0d";}else{echo "#f35041";};?>; color: #ffffff; text-align: center"><?php echo $indicador10;?></td>
        <td id="r12">Alianza publico-privada con fines de desarrollo<input type="checkbox" <?php if($row_formulario14['cuenta']=='SI'){echo "checked";}?>></td>
        <td id="r13"><table width="135px">
        <?php while ($row_preguntaRespuesta= mysql_fetch_assoc($mostrar_preguntaRespuesta)){?>
          <tr><td>  <?php echo $row_preguntaRespuesta['pregunta']."-";?><input type="checkbox" <?php if($row_preguntaRespuesta['respuesta']=='SI'){echo "checked";}?>></td></tr>
        <?php } ?>
                </table></td>
        <td id="r14">Contratos de prestacion de servicios<input type="checkbox" <?php if($row_formulario12['cuenta']=='SI'){echo "checked";}?>></td>
            </tr>
<?php
$contador++;
}

?>
    <input type="hidden" name="contIndicador" id="contIndicador" value="<?php echo $contIndicador; ?>">
<?php } ?>
</tbody>
 </table>

</div>

<script type="text/javascript" language="javascript">
<!--
//Free Memory allow case
x320001();
-->
</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class creporte_general_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'reporte_general';

	// Page Object Name
	var $PageObjName = 'reporte_general_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $reporte_general;
		if ($reporte_general->UseTokenInUrl) $PageUrl .= "t=" . $reporte_general->TableVar . "&"; // add page token
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
		global $objForm, $reporte_general;
		if ($reporte_general->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($reporte_general->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($reporte_general->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function creporte_general_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["reporte_general"] = new creporte_general();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'reporte_general', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $reporte_general;
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
	$reporte_general->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $reporte_general->Export; // Get export parameter, used in header
	$gsExportFile = $reporte_general->TableVar; // Get export file, used in header
	if ($reporte_general->Export == "print" || $reporte_general->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($reporte_general->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $reporte_general;
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
		if ($reporte_general->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $reporte_general->getRecordsPerPage(); // Restore from Session
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
		$reporte_general->setSessionWhere($sFilter);
		$reporte_general->CurrentFilter = "";

		// Export data only
		if (in_array($reporte_general->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $reporte_general;
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
			$reporte_general->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$reporte_general->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $reporte_general;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$reporte_general->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$reporte_general->CurrentOrderType = @$_GET["ordertype"];
			$reporte_general->UpdateSort($reporte_general->idMer); // Field 
			$reporte_general->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $reporte_general;
		$sOrderBy = $reporte_general->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($reporte_general->SqlOrderBy() <> "") {
				$sOrderBy = $reporte_general->SqlOrderBy();
				$reporte_general->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $reporte_general;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$reporte_general->setSessionOrderBy($sOrderBy);
				$reporte_general->idMer->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$reporte_general->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $reporte_general;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$reporte_general->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$reporte_general->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $reporte_general->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$reporte_general->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$reporte_general->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$reporte_general->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $reporte_general;

		// Call Recordset Selecting event
		$reporte_general->Recordset_Selecting($reporte_general->CurrentFilter);

		// Load list page SQL
		$sSql = $reporte_general->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$reporte_general->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $reporte_general;
		$sFilter = $reporte_general->KeyFilter();

		// Call Row Selecting event
		$reporte_general->Row_Selecting($sFilter);

		// Load sql based on filter
		$reporte_general->CurrentFilter = $sFilter;
		$sSql = $reporte_general->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$reporte_general->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $reporte_general;
		$reporte_general->idMer->setDbValue($rs->fields('idMer'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $reporte_general;

		// Call Row_Rendering event
		$reporte_general->Row_Rendering();

		// Common render codes for all row types
		// idMer

		$reporte_general->idMer->CellCssStyle = "";
		$reporte_general->idMer->CellCssClass = "";
		if ($reporte_general->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$reporte_general->idMer->ViewValue = $reporte_general->idMer->CurrentValue;
			$reporte_general->idMer->CssStyle = "";
			$reporte_general->idMer->CssClass = "";
			$reporte_general->idMer->ViewCustomAttributes = "";

			// idMer
			$reporte_general->idMer->HrefValue = "";
		}

		// Call Row Rendered event
		$reporte_general->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $reporte_general;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($reporte_general->ExportAll) {
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
		if ($reporte_general->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($reporte_general->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $reporte_general->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idMer', $reporte_general->Export);
				echo ew_ExportLine($sExportStr, $reporte_general->Export);
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
				$reporte_general->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($reporte_general->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idMer', $reporte_general->idMer->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $reporte_general->Export <> "csv") { // Vertical format
						echo ew_ExportField('idMer', $reporte_general->idMer->ExportValue($reporte_general->Export, $reporte_general->ExportOriginalValue), $reporte_general->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $reporte_general->idMer->ExportValue($reporte_general->Export, $reporte_general->ExportOriginalValue), $reporte_general->Export);
						echo ew_ExportLine($sExportStr, $reporte_general->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($reporte_general->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($reporte_general->Export);
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
