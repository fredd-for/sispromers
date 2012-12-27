<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SISPROMERS_v0.2</title>
<?php if (@$gsExport == "") { ?>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.6.0/build/container/assets/skins/sam/container.css">
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<link rel="stylesheet" type="text/css" href="sispromers2.css">
<link href="jquery/jquery.tab.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="jquery/datePicker.css">
<?php } ?>
<meta name="generator" content="PHPMaker v6.0.0.1">
</head>
<body class="yui-skin-sam">
<?php if (@$gsExport == "") { ?>
<script type="text/javascript" src="http://yui.yahooapis.com/2.6.0/build/utilities/utilities.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.6.0/build/container/container-min.js"></script>
<script type="text/javascript">
<!--
var EW_DATE_SEPARATOR = "/"; 
if (EW_DATE_SEPARATOR == "") EW_DATE_SEPARATOR = "/"; // Default date separator
var EW_UPLOAD_ALLOWED_FILE_EXT = "gif,jpg,jpeg,bmp,png,doc,xls,pdf,zip"; // Allowed upload file extension
var EW_FIELD_SEP = ", "; // Default field separator

// Ajax settings
var EW_RECORD_DELIMITER = "\r";
var EW_FIELD_DELIMITER = "|";
var EW_LOOKUP_FILE_NAME = "ewlookup6.php"; // lookup file name

//var EW_ADD_OPTION_FILE_NAME = ""; // add option file name
var EW_BUTTON_SUBMIT_TEXT = "  AGREGAR  ";
var EW_BUTTON_CANCEL_TEXT = " Cancelar ";

//-->
</script>
<script type="text/javascript" src="js/ewp6.js"></script>
<script type="text/javascript" src="js/userfn6.js"></script>
        <script language="javascript" type="text/javascript" src="jquery/jquery-1.3.2.min.js"></script>
        <script language="javascript" type="text/javascript" src="jquery/jquery.tab.js"></script>
        <script language="javascript" type="text/javascript" src="jquery/jquery.blockUI.js"></script>
        <script language="javascript" type="text/javascript" src="jquery/jquery.validate.1.5.2.js"></script>
<script type="text/javascript" src="jquery/jquery.quicksearch.js"></script>
        <!--<script type="text/javascript" src="../jquery/jquery-1.2.6.pack.js"></script>-->
        <script type="text/javascript" src="jquery/date.js"></script>
        <script type="text/javascript" src="jquery/jquery.datePicker.js"></script>
        <link href="jquery/jquery.tab.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var x;
x=$(document).ready(inicializarEventos)
function inicializarEventos()
{   //func_municipio_mer();
//    //func_municipio_mer();
//    var v_idRegionalConsultoria=$("#x_idRegionalConsultoria");
//    v_idRegionalConsultoria.change(func_municipio_mer);
    // $.browser.msie en IE funcioan: click = change en los de mas exploradores funciona normal con change
    var v_idRegional=$("#x_idRegional");
    if ($.browser.msie){ v_idRegional.click(func_departamento);}
    else{v_idRegional.change(func_departamento);}

    var v_idDepartamento=$("#divx_idDepartamento");
    if ($.browser.msie){ v_idDepartamento.click(func_municipio);}
    else { v_idDepartamento.change(func_municipio);}

    var v_idMunicipio=$("#divx_idMunicipio");
    if ($.browser.msie){v_idMunicipio.click(func_comunidad);}
    else {v_idMunicipio.change(func_comunidad);}

    var v_idRegional=$("#x_idRegional").attr("value");
    var v_idDepartamento=$("#x_idDepartamento_edit").attr("value");
    var x='departamento.php?idRegional='+v_idRegional+'&idDepartamento='+v_idDepartamento;
    var p=$("#divx_idDepartamento");
    p.load(x,func_municipio);
    return false;

    function func_departamento(){
        var v_idRegional=$("#x_idRegional").attr("value");
        var v_idDepartamento=$("#x_idDepartamento_edit").attr("value");
        var x='departamento.php?idRegional='+v_idRegional+'&idDepartamento='+v_idDepartamento;
        var p=$("#divx_idDepartamento");
        p.load(x,func_municipio);
        return false;
    }
    function func_municipio(){
        var v_idRegional=$("#x_idRegional").attr("value");
        var v_idDepartamento=$("#x_idDepartamento").attr("value");
        var v_idMunicipio=$("#x_idMunicipio_edit").attr("value");
        var x='municipio.php?idRegional='+v_idRegional+'&idDepartamento='+v_idDepartamento+'&idMunicipio='+v_idMunicipio;
        var p=$("#divx_idMunicipio");
        p.load(x,func_comunidad);
        return false;
    }
    function func_comunidad(){
        var v_idRegional=$("#x_idRegional").attr("value");
        var v_idDepartamento=$("#x_idDepartamento").attr("value");
        var v_idMunicipio=$("#x_idMunicipio").attr("value");
        var v_idComunidad=$("#x_idComunidad_edit").attr("value");
        var x='comunidad.php?idRegional='+v_idRegional+'&idDepartamento='+v_idDepartamento+'&idMunicipio='+v_idMunicipio+'&idComunidad='+v_idComunidad;
        var p=$("#divx_idComunidad");
        p.load(x);
        return false;
    }
    // para consultoria
//    function func_municipio_mer(){
//var v_idRegionalConsultoria=$("#x_idRegionalConsultoria").attr("value");
//var v_idConsultoria=$("#x_idConsultoria").attr("value");
//        var x='consultoria_municipio_mer.php?idRegional='+v_idRegionalConsultoria+'&idConsultoria='+v_idConsultoria;
//        var p=$("#carga_municipio_mer");
//        p.load(x);
//        return false;
//    }
}
</script>
<?php
function combinaciones($gestion,$rubro,$regional,$departamento,$municipio){
//combinaciones
    $combinacion=0;
if($gestion=='-1' && $rubro=='-1' && $regional=='-1' && $departamento=='-1' && $municipio=='-1'){ $combinacion=1; return '1';}
if($gestion=='-1' && $rubro=='-1' && $regional=='-1' && $departamento=='-1' && $municipio>'0'){ $combinacion=2; return '2';}
if($gestion=='-1' && $rubro=='-1' && $regional=='-1' && $departamento>'0' && $municipio=='-1'){ $combinacion=3; return '3';}
if($gestion=='-1' && $rubro=='-1' && $regional=='-1' && $departamento>'0' && $municipio>'0'){ $combinacion=4; return '4';}
if($gestion=='-1' && $rubro=='-1' && $regional>'0' && $departamento=='-1' && $municipio=='-1'){ $combinacion=5; return '5';}
if($gestion=='-1' && $rubro=='-1' && $regional>'0' && $departamento=='-1' && $municipio>'0'){ $combinacion=6; return '6';}
if($gestion=='-1' && $rubro=='-1' && $regional>'0' && $departamento>'0' && $municipio=='-1'){ $combinacion=7; return '7';}
if($gestion=='-1' && $rubro=='-1' && $regional>'0' && $departamento>'0' && $municipio>'0'){ $combinacion=8; return '8';}
if($gestion=='-1' && $rubro>'0' && $regional=='-1' && $departamento=='-1' && $municipio=='-1'){ $combinacion=9; return '9';}
if($gestion=='-1' && $rubro>'0' && $regional=='-1' && $departamento=='-1' && $municipio>'0'){ $combinacion=10; return '10';}
if($gestion=='-1' && $rubro>'0' && $regional=='-1' && $departamento>'0' && $municipio=='-1'){ $combinacion=11; return '11';}
if($gestion=='-1' && $rubro>'0' && $regional=='-1' && $departamento>'0' && $municipio>'0'){ $combinacion=12; return '12';}
if($gestion=='-1' && $rubro>'0' && $regional>'0' && $departamento=='-1' && $municipio=='-1'){ $combinacion=13; return '13';}
if($gestion=='-1' && $rubro>'0' && $regional>'0' && $departamento=='-1' && $municipio>'0'){ $combinacion=14; return '14';}
if($gestion=='-1' && $rubro>'0' && $regional>'0' && $departamento>'0' && $municipio=='-1'){ $combinacion=15; return '15';}
if($gestion=='-1' && $rubro>'0' && $regional>'0' && $departamento>'0' && $municipio>'0'){ $combinacion=16; return '16';}
///
if($gestion>'0' && $rubro=='-1' && $regional=='-1' && $departamento=='-1' && $municipio=='-1'){ $combinacion=17; return '17';}
if($gestion>'0' && $rubro=='-1' && $regional=='-1' && $departamento=='-1' && $municipio>'0'){ $combinacion=18; return '18';}
if($gestion>'0' && $rubro=='-1' && $regional=='-1' && $departamento>'0' && $municipio=='-1'){ $combinacion=19; return '19';}
if($gestion>'0' && $rubro=='-1' && $regional=='-1' && $departamento>'0' && $municipio>'0'){ $combinacion=20; return '20';}
if($gestion>'0' && $rubro=='-1' && $regional>'0' && $departamento=='-1' && $municipio=='-1'){ $combinacion=21; return '21';}
if($gestion>'0' && $rubro=='-1' && $regional>'0' && $departamento=='-1' && $municipio>'0'){ $combinacion=22; return '22';}
if($gestion>'0' && $rubro=='-1' && $regional>'0' && $departamento>'0' && $municipio=='-1'){ $combinacion=23; return '23';}
if($gestion>'0' && $rubro=='-1' && $regional>'0' && $departamento>'0' && $municipio>'0'){ $combinacion=24; return '24';}
if($gestion>'0' && $rubro>'0' && $regional=='-1' && $departamento=='-1' && $municipio=='-1'){ $combinacion=25; return '25';}
if($gestion>'0' && $rubro>'0' && $regional=='-1' && $departamento=='-1' && $municipio>'0'){ $combinacion=26; return '26';}
if($gestion>'0' && $rubro>'0' && $regional=='-1' && $departamento>'0' && $municipio=='-1'){ $combinacion=27; return '27';}
if($gestion>'0' && $rubro>'0' && $regional=='-1' && $departamento>'0' && $municipio>'0'){ $combinacion=28; return '28';}
if($gestion>'0' && $rubro>'0' && $regional>'0' && $departamento=='-1' && $municipio=='-1'){ $combinacion=29; return '29';}
if($gestion>'0' && $rubro>'0' && $regional>'0' && $departamento=='-1' && $municipio>'0'){ $combinacion=30; return '30';}
if($gestion>'0' && $rubro>'0' && $regional>'0' && $departamento>'0' && $municipio=='-1'){ $combinacion=31; return '31';}
if($gestion>'0' && $rubro>'0' && $regional>'0' && $departamento>'0' && $municipio>'0'){ $combinacion=32; return '32';}
if($combinacion=='0'){return '1';}
}
?>
<script type="text/javascript" src="stibx.js"></script>
<div class="ewLayout">
	<!-- header (begin) --><!-- *** Note: Only licensed users are allowed to change the logo *** -->
            <div class="ewHeaderRow"><img src="banner_fh.png" width="200" height="70" alt="" border="0"><img src="banner_sispromers.png" width="400" height="70" alt="" border="0"></div>
	<!-- header (end) -->
	<!-- content (begin) -->
  <table cellspacing="0" class="ewContentTable">
		<tr>	
			<td class="ewMenuColumn">
			<!-- left column (begin) -->
<?php include "ewmenu.php" ?>
			<!-- left column (end) -->
			</td>		
	    <td class="ewContentColumn">
			<!-- right column (begin) -->
<?php
//require_once('Connections/conexion.php');
//mysql_select_db($database_conexion, $conexion);
//$query_rol= "SELECT nombre FROM rol WHERE idRol=".$_SESSION['idRol'];
//$mostrar_rol=mysql_query($query_rol, $conexion) or die(mysql_error());
//$row_rol=mysql_fetch_assoc($mostrar_rol);
?>
<p style="color: green" align="right"><?php echo "<b>Usuario: </b>".$_SESSION['nombre']." ".$_SESSION['paterno'];?></p>
	<?php } ?>
