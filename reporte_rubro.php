<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "reporte_rubrosinfo.php" ?>
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
$reporte_rubros_list = new creporte_rubros_list();
$Page =& $reporte_rubros_list;

// Page init processing
$reporte_rubros_list->Page_Init();

// Page main processing
$reporte_rubros_list->Page_Main();
?>

 <!--[if IE]><script language="javascript" type="text/javascript" src="jqplot/excanvas.js"></script><![endif]-->
  
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

<span class="phpmaker" style="white-space: nowrap;">
<div id="linkDescargar"></div>
</span>
<?php

mysql_select_db($database_conexion, $conexion);
$query_regional = "SELECT a.*,count(c.municipio) as numMunicipios FROM regional a, municipio c WHERE a.idRegional=c.idRegional GROUP BY idRegional ORDER BY a.regional asc";
$mostrar_regional=mysql_query($query_regional, $conexion) or die(mysql_error());
$totalRows_regional=mysql_num_rows($mostrar_regional);

mysql_select_db($database_conexion, $conexion);
$query_numMunicipios = "SELECT * FROM municipio";
$mostrar_numMunicipios=mysql_query($query_numMunicipios, $conexion) or die(mysql_error());
$totalRows_numMunicipios=mysql_num_rows($mostrar_numMunicipios);
if($_GET['gestion']<>'0'){
	$gestionInicial=$_GET['gestion'];
	$gestionFinal=$_GET['gestion'];
}else{
	$gestionInicial=2009;
	$gestionFinal=2012;
}
$formalizada=$_GET['formalizada'];
$gestionElegida=$_GET['gestion'];
?>
<div id="div_formulario">
    <table id="table_example" width="100%" border="1" class="ewTable">
    <thead>
    <tr style="font-size: 12pt">
        <th colspan="20">CONTROL DE AVANCE DEL PROYECTO POR RUBROS DE LAS MICROEMPRESAS</th>
    </tr>
    <tr>
        <th style="background: #632523; color: #ffffff; font-size: 10px">RUBRO DE LA MERS</th>
        <th colspan="<?php echo $totalRows_numMunicipios;?>" style="background: #632523; color: #ffffff; font-size: 10px">MERS EN LA LINEA DE BASE</th>
        <th colspan="1" style="background: #632523; color: #ffffff; font-size: 10px">TOTAL</th>
        <?php for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <th colspan="4" style="background: #FAC090">POA GESTION <?php echo $i;?></th>
        <?php } ?>
        <th colspan="3" style="background: #632523; color: #ffffff; font-size: 10px">MARCO LOGICO</th>
    </tr>
        <tr>
        <th rowspan="3" style="font-size: 8pt;background: #d77050;color: white">La MERS se dedica a:</th>
        <?php while($row_regional=mysql_fetch_assoc($mostrar_regional)){?>
        <th colspan="<?php echo $row_regional['numMunicipios']?>" style="font-size: 8pt;background: #d77050;color: white"><?php echo utf8_encode($row_regional['regional'])?></th>
        <?php }
        ?>
        <th rowspan="3" style="font-size: 8pt;background: #d77050;color: white">TOTAL MERS</th>
        <?php for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
        <th rowspan="3" style="background: #FCD5B4">Meta Planificada</th>
        <th rowspan="3" style="background: #FCD5B4">Logro Mers Fortalecidas</th>
        <th rowspan="3" style="background: #FCD5B4">Mers en Proceso</th>
        <th rowspan="3" style="background: #FCD5B4">% de Avance</th>
        <?php } ?>
        <th rowspan="3" style="font-size: 8pt;background: #d77050;color: white">META</th>
        <th rowspan="3" style="font-size: 8pt;background: #d77050;color: white">LOGRO</th>
        <th rowspan="3" style="font-size: 8pt;background: #d77050;color: white">% de Avance</th>
    </tr>
<tr style="font-size: 7pt;background: #d75245;color: #000000">
<?php
$mostrar_regional=mysql_query($query_regional, $conexion) or die(mysql_error());

while($row_regional=mysql_fetch_assoc($mostrar_regional)){
mysql_select_db($database_conexion, $conexion);
$query_departamento = "SELECT a.*, count(b.municipio) as numMunicipios FROM departamento a, municipio b WHERE a.idRegional='".$row_regional['idRegional']."' AND a.idDepartamento=b.idDepartamento GROUP BY a.idDepartamento ORDER BY a.departamento asc";
$mostrar_departamento=mysql_query($query_departamento, $conexion) or die(mysql_error());
$totalRows_departamento=mysql_num_rows($mostrar_departamento);

while($row_departamento=mysql_fetch_assoc($mostrar_departamento)){
    ?>
<th colspan="<?php echo $row_departamento['numMunicipios']?>"><?php echo utf8_encode($row_departamento['departamento'])?></th>
<?php } }?>
</tr>
<tr style="font-size: 7pt;background: #d77589;color: #000000">
<?php
$contMunicipio=array ();
$mostrar_regional=mysql_query($query_regional, $conexion) or die(mysql_error());

while($row_regional=mysql_fetch_assoc($mostrar_regional)){
mysql_select_db($database_conexion, $conexion);
$query_departamento = "SELECT a.* FROM departamento a WHERE a.idRegional='".$row_regional['idRegional']."' ORDER BY a.departamento asc";
$mostrar_departamento=mysql_query($query_departamento, $conexion) or die(mysql_error());

while($row_departamento=mysql_fetch_assoc($mostrar_departamento)){
mysql_select_db($database_conexion, $conexion);
$query_municipio = "SELECT a.* FROM municipio a WHERE a.idDepartamento='".$row_departamento['idDepartamento']."' ORDER BY a.municipio asc";
$mostrar_municipio=mysql_query($query_municipio, $conexion) or die(mysql_error());
while($row_municipio=mysql_fetch_assoc($mostrar_municipio)){
$contMunicipio[]=$row_municipio['idMunicipio'];
    ?>
<th><?php echo utf8_encode($row_municipio['municipio']);?></th>
<?php } } }
?>
</tr>
<?php
mysql_select_db($database_conexion, $conexion);
$query_rubro = "SELECT *, (gestion2009+gestion2010+gestion2011+gestion2012) as totalgestion FROM rubro ORDER BY rubro";
$mostrar_rubro=mysql_query($query_rubro, $conexion) or die(mysql_error());
$totalArray=array ();
$metaArray=array ();
$logroArray=array ();
$procesoArray=array ();
$rubroArray=array ();
$marcoLogicoMeta=array ();
$marcoLogicoLogro=array ();
$gestionMeta=array ();
$gestionLogro=array ();
while($row_rubro=mysql_fetch_assoc($mostrar_rubro)){
    
    ?>
<tr align="center">
    <td align="left"><?php echo $rubroArray[]=utf8_encode($row_rubro['rubro'])?></td>
<?php
$sumaMer=0;
for($i=0;$i<count($contMunicipio);$i++){
$mer_municipio= indicador1_cantidad(0, 0, 0, $contMunicipio[$i], 0, $row_rubro['idRubro'], $gestionElegida , $database_conexion, $conexion);
?>
    <td><?php if($formalizada==0 && $mer_municipio[total]>0){echo $mer_municipio[total]; $sumaMer+=$mer_municipio[total]; $totalArray[$i]=$totalArray[$i]+$mer_municipio[total];}
if($formalizada==1 && $mer_municipio[cumple]>0){echo $mer_municipio[cumple]; $sumaMer+=$mer_municipio[cumple]; $totalArray[$i]=$totalArray[$i]+$mer_municipio[cumple];}
if($formalizada==2 && $mer_municipio[nocumple]>0){echo $mer_municipio[nocumple]; $sumaMer+=$mer_municipio[nocumple]; $totalArray[$i]=$totalArray[$i]+$mer_municipio[nocumple];}
    ?>
    </td>
<?php }?>
    <td bgcolor="#d3faa5"><?php echo $sumaMer;$totalSumaMer+=$sumaMer;?></td>
<?php for($i=$gestionInicial;$i<=$gestionFinal;$i++){
$logroMers=indicador1_cantidad(0, 0, 0, 0, 0, $row_rubro['idRubro'], $i, $database_conexion, $conexion);
    ?>
    <td><?php echo $gestionMeta[$i][]=$row_rubro['gestion'.$i]; $metaArray[$i]+=$row_rubro['gestion'.$i];?></td>
    <td><?php echo $gestionLogro[$i][]=$logroMers[cumple]; $logroArray[$i]+=$logroMers[cumple];?></td>
    <td><?php echo $logroMers[nocumple]; $procesoArray[$i]+=$logroMers[nocumple];?></td>
    <td style="background: #FDE9D9"><?php if($row_rubro['gestion'.$i]>0){printf("%0.2f",($logroMers[cumple]*100)/$row_rubro['gestion'.$i]) ;}else{echo $logroMers[cumple];}?></td>
    <?php } ?>
    <td><?php echo $marcoLogicoMeta[]=$row_rubro['totalgestion']; $metaArray[total]+=$row_rubro['totalgestion'];?></td>
    <td><?php $totalForma=indicador1_cantidad(0, 0, 0, 0, 0, $row_rubro['idRubro'], 0,$database_conexion, $conexion); echo $marcoLogicoLogro[]=$totalForma[cumple]; $logroArray[total]+=$totalForma[cumple];?></td>
    <td style="background: #FCD5B4"><?php if($row_rubro['totalgestion']>0){ printf("%0.2f", ($totalForma[cumple]*100)/$row_rubro['totalgestion']);} ?></td>
</tr>
<?php 
$contador++;
}
?>
<tr bgcolor="#aaaddd" align="center">
    <td>TOTAL</td>
    <?php
$sumaMer=0;
for($i=0;$i<count($contMunicipio);$i++){
    ?>
    <td><?php echo $totalArray[$i];?></td>
<?php }?>
    <td><?php echo $totalSumaMer;?></td>
<?php for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
    <td><?php echo $metaArray[$i];?></td>
    <td><?php echo $logroArray[$i];?></td>
    <td><?php echo $procesoArray[$i];?></td>
    <td></td>
    <?php } ?>
    <td><?php echo $metaArray[total];?></td>
    <td><?php echo $logroArray[total];?></td>
    <td></td>    
</tr>
    </thead>
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
var x_meta=<?php echo php2js($marcoLogicoMeta)?>;
var x_logro=<?php echo php2js($marcoLogicoLogro)?>;
var x_rubro=<?php echo php2js($rubroArray)?>;
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
    yaxis:{min:0,max:55,numberTicks:12}}
    });
////// fin de la imagen
<?php
for($i=$gestionInicial;$i<=$gestionFinal;$i++){ ?>
var x_meta =<?php echo php2js($gestionMeta[$i])?>;
var x_logro=<?php echo php2js($gestionLogro[$i])?>;

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
    yaxis:{min:0,max:55,numberTicks:12}}
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
x320001();
</script>
<?php
//
// Page Class
//
class creporte_rubros_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'reporte_rubros';

	// Page Object Name
	var $PageObjName = 'reporte_rubros_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $reporte_rubros;
		if ($reporte_rubros->UseTokenInUrl) $PageUrl .= "t=" . $reporte_rubros->TableVar . "&"; // add page token
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
		global $objForm, $reporte_rubros;
		if ($reporte_rubros->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($reporte_rubros->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($reporte_rubros->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function creporte_rubros_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["reporte_rubros"] = new creporte_rubros();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'reporte_rubros', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $reporte_rubros;
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
	$reporte_rubros->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $reporte_rubros->Export; // Get export parameter, used in header
	$gsExportFile = $reporte_rubros->TableVar; // Get export file, used in header
	if ($reporte_rubros->Export == "print" || $reporte_rubros->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($reporte_rubros->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $reporte_rubros;
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
		if ($reporte_rubros->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $reporte_rubros->getRecordsPerPage(); // Restore from Session
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
		$reporte_rubros->setSessionWhere($sFilter);
		$reporte_rubros->CurrentFilter = "";

		// Export data only
		if (in_array($reporte_rubros->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $reporte_rubros;
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
			$reporte_rubros->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$reporte_rubros->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $reporte_rubros;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$reporte_rubros->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$reporte_rubros->CurrentOrderType = @$_GET["ordertype"];
			$reporte_rubros->UpdateSort($reporte_rubros->idMer); // Field
			$reporte_rubros->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $reporte_rubros;
		$sOrderBy = $reporte_rubros->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($reporte_rubros->SqlOrderBy() <> "") {
				$sOrderBy = $reporte_rubros->SqlOrderBy();
				$reporte_rubros->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $reporte_rubros;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$reporte_rubros->setSessionOrderBy($sOrderBy);
				$reporte_rubros->idMer->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$reporte_rubros->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $reporte_rubros;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$reporte_rubros->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$reporte_rubros->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $reporte_rubros->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$reporte_rubros->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$reporte_rubros->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$reporte_rubros->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $reporte_rubros;

		// Call Recordset Selecting event
		$reporte_rubros->Recordset_Selecting($reporte_rubros->CurrentFilter);

		// Load list page SQL
		$sSql = $reporte_rubros->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$reporte_rubros->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $reporte_rubros;
		$sFilter = $reporte_rubros->KeyFilter();

		// Call Row Selecting event
		$reporte_rubros->Row_Selecting($sFilter);

		// Load sql based on filter
		$reporte_rubros->CurrentFilter = $sFilter;
		$sSql = $reporte_rubros->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$reporte_rubros->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $reporte_rubros;
		$reporte_rubros->idMer->setDbValue($rs->fields('idMer'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $reporte_rubros;

		// Call Row_Rendering event
		$reporte_rubros->Row_Rendering();

		// Common render codes for all row types
		// idMer

		$reporte_rubros->idMer->CellCssStyle = "";
		$reporte_rubros->idMer->CellCssClass = "";
		if ($reporte_rubros->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$reporte_rubros->idMer->ViewValue = $reporte_rubros->idMer->CurrentValue;
			$reporte_rubros->idMer->CssStyle = "";
			$reporte_rubros->idMer->CssClass = "";
			$reporte_rubros->idMer->ViewCustomAttributes = "";

			// idMer
			$reporte_rubros->idMer->HrefValue = "";
		}

		// Call Row Rendered event
		$reporte_rubros->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $reporte_rubros;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($reporte_rubros->ExportAll) {
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
		if ($reporte_rubros->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($reporte_rubros->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $reporte_rubros->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idMer', $reporte_rubros->Export);
				echo ew_ExportLine($sExportStr, $reporte_rubros->Export);
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
				$reporte_rubros->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($reporte_rubros->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idMer', $reporte_rubros->idMer->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $reporte_rubros->Export <> "csv") { // Vertical format
						echo ew_ExportField('idMer', $reporte_rubros->idMer->ExportValue($reporte_rubros->Export, $reporte_rubros->ExportOriginalValue), $reporte_rubros->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $reporte_rubros->idMer->ExportValue($reporte_rubros->Export, $reporte_rubros->ExportOriginalValue), $reporte_rubros->Export);
						echo ew_ExportLine($sExportStr, $reporte_rubros->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($reporte_rubros->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($reporte_rubros->Export);
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
