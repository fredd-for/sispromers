<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "reporte_mmlinfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php require_once('Connections/conexion.php'); ?>
<?php include "librerias/librerias.php";?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$reporte_mml_list = new creporte_mml_list();
$Page =& $reporte_mml_list;

// Page init processing
$reporte_mml_list->Page_Init();

// Page main processing
$reporte_mml_list->Page_Main();
?>
 <script language="javascript" type="text/javascript" src="jqplot/excanvas.js"></script>
<link rel="stylesheet" type="text/css" href="jqplot/jquery.jqplot.css" />
  <link rel="stylesheet" type="text/css" href="examples.css" />
   <!-- BEGIN: load jquery -->
  <script language="javascript" type="text/javascript" src="jqplot/jquery-1.4.2.min.js"></script>
  <!-- END: load jquery -->

  <!-- BEGIN: load jqplot -->
  <script language="javascript" type="text/javascript" src="jqplot/jquery.jqplot.js"></script>
  <script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.dateAxisRenderer.js"></script>
  <script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.barRenderer.js"></script>
  <script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.categoryAxisRenderer.js"></script>
  <script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.pointLabels.js"></script>
 <script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.canvasTextRenderer.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.canvasAxisTickRenderer.js"></script>

<script type="text/javascript">
    var x=$(document);
    x.ready(inicializarEventos);
    function inicializarEventos()
    {
	if(<?php echo $_GET['gestion']?> =='0'){
        $("#gestion2009").show();
        $("#gestion2010").show();
        $("#gestion2011").show();
        $("#gestion2012").show();
		}else{
	if(<?php echo $_GET['gestion']?> !='2009'){$("#gestion2009").hide();}else{$("#gestion2009").show();}
	if(<?php echo $_GET['gestion']?> !='2010'){$("#gestion2010").hide();}else{$("#gestion2010").show();}
	if(<?php echo $_GET['gestion']?> !='2011'){$("#gestion2011").hide();}else{$("#gestion2011").show();}
	if(<?php echo $_GET['gestion']?> !='2012'){$("#gestion2012").hide();}else{$("#gestion2012").show();}
	}
	}

 </script>

<?php
if($_GET['gestion']<>'0'){
	$gestionInicial=$_GET['gestion'];
	$gestionFinal=$_GET['gestion'];
}else{
	$gestionInicial=2009;
	$gestionFinal=2012;
}
$gestionElegida=$_GET['gestion'];

$metaGestion[2009]=array(1,1,1,1,1,1,1,1,1,1,1,1,1,1);
$metaGestion[2010]=array(50,150,4,4,35,35,12,5,35,30,23,4,4,4);
$metaGestion[2011]=array(50,150,3,3,35,35,12,5,35,20,35,3,3,3);
$metaGestion[2012]=array(15,150,1,1,11,11,11,2,22,10,34,1,1,1);
$metaMarcoLogico=array(115,450,8,8,81,81,35,12,92,60,92,8,8,8);
$codigos=array('Prop. I.1','Prop. I.2','Prop. I.3','Prop. I.4','C.1-I.1','C.1-I.2','C.1-I.3','C.1-I.4','C.2-I.1','C.2-I.2','C.2-I.3','C.3-I.1','C.3-I.2','C.3-I.3');
//$marcoLogicoMeta=array ();
$marcoLogicoLogro=array ();
$logroGestion=array ();
        ?>

<span class="phpmaker" style="white-space: nowrap;">
<div id="linkDescargar"></div>
</span>
<div id="div_formulario">
    <table id="table_example" width="100%" border="1" class="ewTable" >
    <thead>
    <tr style="font-size: 12pt">
        <th colspan="2">CONTROL DE AVANCE DEL PROYECTO SEG&Uacute;N MARCO L&Oacute;GICO</th>
    </tr>
        <tr>
        <th style="font-size: 10pt;background: #632523;color: white" rowspan="2">Nro</th>
        <th style="font-size: 10pt;background: #632523;color: white" rowspan="2">INDICADORES</th>
        <?php for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <th colspan="3" style="background: #75923C; color: white">POA GESTION <?php echo $i;?></th>
        <?php } ?>
        <th style="font-size: 10pt;background: #632523;color: white" colspan="3">Marco Logico</th>
    </tr>
        <tr>
        <?php for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <th style="background: #75923C; color: white">Meta</th>
        <th style="background: #75923C; color: white">Logro</th>
        <th style="background: #75923C; color: white">% Avance</th>
        <?php } ?>
        <th style="font-size: 10pt;background: #632523;color: white">Meta</th>
        <th style="font-size: 10pt;background: #632523;color: white">Logro</th>
        <th style="font-size: 10pt;background: #632523;color: white">% Avance</th>
    </tr>
    </thead>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[0];?></td>
        <td>Numero de MERS sostenibles y en funcionamiento: A&ntilde;o 2: 50; Fin proyecto: 115</td>
        <?php for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][0];?></td>
        <td><?php $resp=indicador1_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][0]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][0]=($resp[cumple]*100)/$metaGestion[$i][0]; printf("%0.2f",$resulGestion[$i][0]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[0];?></td>
        <td><?php $resp=indicador1_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[0]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[0]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[1];?></td>
        <td>N&uacute;mero de empleos generados: A&ntilde;o 2:  150; Fin proyecto: 450</td>
        <?php for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][1];?></td>
        <td><?php $resp=indicador2_cantidad(0, 0, 0, 0, 0, 0, $i,$database_conexion, $conexion); echo $logroGestion[$i][1]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][1]=($resp[cumple]*100)/$metaGestion[$i][1]; printf("%0.2f",$resulGestion[$i][1]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[1];?></td>
        <td><?php $resp=indicador2_cantidad(0, 0, 0, 0, 0, 0, 0,$database_conexion, $conexion); echo $marcoLogicoLogro[1]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[1]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[2];?></td>
        <td>Municipios que contratan anualmente los servicios de al menos una MERS. A&ntilde;o 2: 4; Fin de proyecto: 8</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][2];?></td>
        <td><?php $resp=indicador3_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][2]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][2]=($resp[cumple]*100)/$metaGestion[$i][2]; printf("%0.2f",$resulGestion[$i][2]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[2];?></td>
        <td><?php $resp=indicador3_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[2]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[2]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[3];?></td>
        <td>Municipios que establecen una alianza publico-privada con fines de desarrollo. A&ntilde;o 2:  4; Fin de proyecto: 8.</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][3];?></td>
        <td><?php $resp=indicador4_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][3]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][3]=($resp[cumple]*100)/$metaGestion[$i][3]; printf("%0.2f",$resulGestion[$i][3]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[3];?></td>
        <td><?php $resp=indicador4_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[3]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[3]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[4];?></td>
        <td>Porcentaje de MERS  formalizadas (Testimonio, Reglamentos, Estatutos, Tarjeta Empresarial, u otros). A&ntilde;o 2: 30%; Fin proyecto: 70% de las 115  MERS</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][4];?></td>
        <td><?php $resp=indicador5_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][4]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][4]=($resp[cumple]*100)/$metaGestion[$i][4]; printf("%0.2f",$resulGestion[$i][4]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[4];?></td>
        <td><?php $resp=indicador5_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[4]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[4]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[5];?></td>
        <td>Porcentaje de  MERS que aplican instrumentos de gestion empresarial  (contabilidad basica, administracion y plan de negocios). A&ntilde;o 2: 30%; Fin proyecto:</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][5];?></td>
        <td><?php $resp=indicador6_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][5]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][5]=($resp[cumple]*100)/$metaGestion[$i][5]; printf("%0.2f",$resulGestion[$i][5]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[5];?></td>
        <td><?php $resp=indicador6_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[5]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[5]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[6];?></td>
        <td>Porcentaje de  MERS que acceden a creditos: A&ntilde;o 2: 10%; Fin de proyecto: 30% de las 115  MERS</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][6];?></td>
        <td><?php $resp=indicador7_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][6]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][6]=($resp[cumple]*100)/$metaGestion[$i][6]; printf("%0.2f",$resulGestion[$i][6]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[6];?></td>
        <td><?php $resp=indicador7_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[6]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[6]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[7];?></td>
        <td>Porcentaje maximo de MERS con problemas de mora en el financiamiento durante todo el proyecto: 10% de las 115  MERS</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][7];?></td>
        <td><?php $resp=indicador8_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][7]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][7]=($resp[cumple]*100)/$metaGestion[$i][7]; printf("%0.2f",$resulGestion[$i][7]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[7];?></td>
        <td><?php $resp=indicador8_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[7]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[7]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[8];?></td>
        <td>Porcentaje de MERS que han prestado servicios a entidades publicas o privadas, con contrato formal: A&ntilde;o 2: 30%; Fin de proyecto: 80% de las 115  MERS</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][8];?></td>
        <td><?php $resp=indicador9_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][8]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][8]=($resp[cumple]*100)/$metaGestion[$i][8]; printf("%0.2f",$resulGestion[$i][8]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[8];?></td>
        <td><?php $resp=indicador9_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[8]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[8]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[9];?></td>
        <td>Porcentaje de cumplimiento de venta de servicios de las MERS respecto a lo proyectado en sus planes de negocios: A&ntilde;o 2; 50%; Fin de proyecto: 70% de las 115  MERS</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][9];?></td>
        <td><?php $resp=indicador10_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][9]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][9]=($resp[cumple]*100)/$metaGestion[$i][9]; printf("%0.2f",$resulGestion[$i][9]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[9];?></td>
        <td><?php $resp=indicador10_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[9]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[9]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[10];?></td>
        <td>Porcentaje de MERS que cumplen sus contratos de servicios: A&ntilde;o 2: 20%; Fin de proyecto: 80% de las 115  MERS</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][10];?></td>
        <td><?php $resp=indicador11_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][10]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][10]=($resp[cumple]*100)/$metaGestion[$i][10]; printf("%0.2f",$resulGestion[$i][10]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[10];?></td>
        <td><?php $resp=indicador11_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[10]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[10]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[11];?></td>
        <td>Municipios que establecen una alianza publico-privada con fines de desarrollo. A&ntilde;o 2:  4; Fin de proyecto: 8</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][3];?></td>
        <td><?php $resp=indicador4_cantidad(0, 0, 0, 0, 0, 0, $i,$database_conexion, $conexion); echo $logroGestion[$i][11]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][11]=($resp[cumple]*100)/$metaGestion[$i][3]; printf("%0.2f",$resulGestion[$i][11]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[3];?></td>
        <td><?php $resp=indicador4_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[11]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[3]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[12];?></td>
        <td>Municipios que incorporan acciones de apoyo al sector productivo en sus Planes Anuales y los ejecutan. A&ntilde;o 2: 4; Fin de proyecto: 8</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][12];?></td>
        <td><?php $resp=indicador13_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][12]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][12]=($resp[cumple]*100)/$metaGestion[$i][12]; printf("%0.2f",$resulGestion[$i][12]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[12];?></td>
        <td><?php $resp=indicador11_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[12]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[12]);?></td>
    </tr>
    <tr style="color: white;background: #4F6228">
        <td><?php echo $codigos[13];?></td>
        <td>Municipios que contratan anualmente los servicios de al menos una MERS. A&ntilde;o 2: 4; Fin de proyecto: 8</td>
        <?php
        for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <td><?php echo $metaGestion[$i][13];?></td>
        <td><?php $resp=indicador3_cantidad(0, 0, 0, 0, 0, 0, $i, $database_conexion, $conexion); echo $logroGestion[$i][13]=$resp[cumple];?></td>
        <td style="background: #75923C"><?php $resulGestion[$i][13]=($resp[cumple]*100)/$metaGestion[$i][13]; printf("%0.2f",$resulGestion[$i][13]);?></td>
        <?php } ?>
        <td><?php echo $metaMarcoLogico[13];?></td>
        <td><?php $resp=indicador3_cantidad(0, 0, 0, 0, 0, 0, 0, $database_conexion, $conexion); echo $marcoLogicoLogro[13]=$resp[cumple];?></td>
        <td><?php printf("%0.2f",($resp[cumple]*100)/$metaMarcoLogico[13]);?></td>
    </tr>
    </table>
<?php
//funcion para graficar
function php2js ($var) {

    if (is_array($var)) {
        $res = "[";
        $array = array();
        foreach ($var as $a_var) {
            $array[] = php2js($a_var);
        }
        return "[" . join(",", $array) . "]";
    }
    elseif (is_bool($var)) {
        return $var ? "true" : "false";
    }
    elseif (is_int($var) || is_integer($var) || is_double($var) || is_float($var)) {
        return $var;
    }
    elseif (is_string($var)) {
        return "\"" . addslashes(stripslashes($var)) . "\"";
    }
    return FALSE;
}
?>

  <style type="text/css" media="screen">
    .jqplot-axis {
      font-size: 1.2em;
    }
    .jqplot-title {
      font-size: 2.2em;
      color: navy;
    }
  </style>
  <script type="text/javascript" language="javascript">

$(document).ready(function(){
$.jqplot.config.enablePlugins = true;
var x_meta=<?php echo php2js($metaMarcoLogico)?>;
var x_logro=<?php echo php2js($marcoLogicoLogro)?>;
var x_rubro=<?php echo php2js($codigos)?>;
// inicio de la imagen
plot1 = $.jqplot('marcoLogico', [x_meta, x_logro], {
	title:'Grafico Marco Logico',
	seriesDefaults:{renderer:$.jqplot.BarRenderer, rendererOptions:{barPadding:10, barMargin:10}},
    legend: {show:true, location: 'nw'},
    series: [{label: 'META'},{label: 'LOGRO'}],
    axes:{
       xaxis:{renderer:$.jqplot.CategoryAxisRenderer,
    	ticks:x_rubro ,
    	tickRenderer: $.jqplot.CanvasAxisTickRenderer,
    tickOptions: {
        angle: -25,
        fontSize: '10pt',
        showMark: false,
        showGridline: false
    }
    },
    yaxis:{min:0,numberTicks:12}}
    });
////// fin de la imagen
////// fin de la imagen
<?php
for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
var x_meta =<?php echo php2js($metaGestion[$i])?>;
var x_logro=<?php echo php2js($logroGestion[$i])?>;

plot1 = $.jqplot('gestion'+<?php echo $i;?>, [x_meta, x_logro], {
	title:'<?php echo "Grafico Gestion ".$i; ?>',
	seriesDefaults:{renderer:$.jqplot.BarRenderer, rendererOptions:{barPadding:10, barMargin:10}},
    legend: {show:true, location: 'nw'},
    series: [{label: 'META'},{label: 'LOGRO'}],
    axes:{
       xaxis:{renderer:$.jqplot.CategoryAxisRenderer,
    	ticks:x_rubro ,
    	tickRenderer: $.jqplot.CanvasAxisTickRenderer,
    tickOptions: {
        angle: -25,
        fontSize: '10pt',
        showMark: false,
        showGridline: false
    }
    },
    yaxis:{min:0,numberTicks:12}}
    });
<?php
}
?>
  });
  </script>
       <div id="marcoLogico" style="margin-top:20px; margin-left:20px; width:800px; height:300px;"></div>
	<div id="gestion2009" style="margin-top:20px; margin-left:20px; width:800px; height:300px;"></div>
	<div id="gestion2010" style="margin-top:20px; margin-left:20px; width:800px; height:300px;"></div>
	<div id="gestion2011" style="margin-top:20px; margin-left:20px; width:800px; height:300px;"></div>
	<div id="gestion2012" style="margin-top:20px; margin-left:20px; width:800px; height:300px;"></div>

</div>
<script type="text/javascript" language="javascript">
<!--
//Free Memory allow case
x320001();
-->
</script>

<?php

//
// Page Class
//
class creporte_mml_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'reporte_mml';

	// Page Object Name
	var $PageObjName = 'reporte_mml_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $reporte_mml;
		if ($reporte_mml->UseTokenInUrl) $PageUrl .= "t=" . $reporte_mml->TableVar . "&"; // add page token
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
		global $objForm, $reporte_mml;
		if ($reporte_mml->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($reporte_mml->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($reporte_mml->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function creporte_mml_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["reporte_mml"] = new creporte_mml();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'reporte_mml', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $reporte_mml;
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
	$reporte_mml->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $reporte_mml->Export; // Get export parameter, used in header
	$gsExportFile = $reporte_mml->TableVar; // Get export file, used in header
	if ($reporte_mml->Export == "print" || $reporte_mml->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($reporte_mml->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $reporte_mml;
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
		if ($reporte_mml->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $reporte_mml->getRecordsPerPage(); // Restore from Session
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
		$reporte_mml->setSessionWhere($sFilter);
		$reporte_mml->CurrentFilter = "";

		// Export data only
		if (in_array($reporte_mml->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $reporte_mml;
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
			$reporte_mml->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$reporte_mml->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $reporte_mml;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$reporte_mml->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$reporte_mml->CurrentOrderType = @$_GET["ordertype"];
			$reporte_mml->UpdateSort($reporte_mml->idMer); // Field
			$reporte_mml->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $reporte_mml;
		$sOrderBy = $reporte_mml->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($reporte_mml->SqlOrderBy() <> "") {
				$sOrderBy = $reporte_mml->SqlOrderBy();
				$reporte_mml->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $reporte_mml;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$reporte_mml->setSessionOrderBy($sOrderBy);
				$reporte_mml->idMer->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$reporte_mml->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $reporte_mml;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$reporte_mml->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$reporte_mml->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $reporte_mml->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$reporte_mml->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$reporte_mml->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$reporte_mml->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $reporte_mml;

		// Call Recordset Selecting event
		$reporte_mml->Recordset_Selecting($reporte_mml->CurrentFilter);

		// Load list page SQL
		$sSql = $reporte_mml->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$reporte_mml->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $reporte_mml;
		$sFilter = $reporte_mml->KeyFilter();

		// Call Row Selecting event
		$reporte_mml->Row_Selecting($sFilter);

		// Load sql based on filter
		$reporte_mml->CurrentFilter = $sFilter;
		$sSql = $reporte_mml->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$reporte_mml->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $reporte_mml;
		$reporte_mml->idMer->setDbValue($rs->fields('idMer'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $reporte_mml;

		// Call Row_Rendering event
		$reporte_mml->Row_Rendering();

		// Common render codes for all row types
		// idMer

		$reporte_mml->idMer->CellCssStyle = "";
		$reporte_mml->idMer->CellCssClass = "";
		if ($reporte_mml->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$reporte_mml->idMer->ViewValue = $reporte_mml->idMer->CurrentValue;
			$reporte_mml->idMer->CssStyle = "";
			$reporte_mml->idMer->CssClass = "";
			$reporte_mml->idMer->ViewCustomAttributes = "";

			// idMer
			$reporte_mml->idMer->HrefValue = "";
		}

		// Call Row Rendered event
		$reporte_mml->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $reporte_mml;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($reporte_mml->ExportAll) {
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
		if ($reporte_mml->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($reporte_mml->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $reporte_mml->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idMer', $reporte_mml->Export);
				echo ew_ExportLine($sExportStr, $reporte_mml->Export);
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
				$reporte_mml->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($reporte_mml->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idMer', $reporte_mml->idMer->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $reporte_mml->Export <> "csv") { // Vertical format
						echo ew_ExportField('idMer', $reporte_mml->idMer->ExportValue($reporte_mml->Export, $reporte_mml->ExportOriginalValue), $reporte_mml->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $reporte_mml->idMer->ExportValue($reporte_mml->Export, $reporte_mml->ExportOriginalValue), $reporte_mml->Export);
						echo ew_ExportLine($sExportStr, $reporte_mml->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($reporte_mml->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($reporte_mml->Export);
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
