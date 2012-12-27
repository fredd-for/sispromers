<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "mers_fortalecidasinfo.php" ?>
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
$mers_fortalecidas_list = new cmers_fortalecidas_list();
$Page =& $mers_fortalecidas_list;

// Page init processing
$mers_fortalecidas_list->Page_Init();

// Page main processing
$mers_fortalecidas_list->Page_Main();
?>
<?php include "header.php" ?>
<span class="phpmaker" style="white-space: nowrap;">
<?php if ($Reporte_Mers->Export == "") { ?>
<div id="linkDescargar"></div>
    <?php } ?>
<?php
if ($Reporte_Mers->Export == "") {
mysql_select_db($database_conexion, $conexion);
$query_regional = "SELECT * FROM regional";
$mostrar_regional=mysql_query($query_regional, $conexion) or die(mysql_error());
$total_regional=mysql_num_rows($mostrar_regional);
}
?>
</span>
<div id="div_formulario">
    <table id="table_example" width="100%" border="1" class="ewTable">
        <tr align="center"><td colspan="21" style="font-size: 10pt;background: #632523;color: white">REPORTE DE MERS FORTALECIDAS</td></tr>
<?php
$contador=1;
while($row_regional=mysql_fetch_assoc($mostrar_regional)) {
mysql_select_db($database_conexion, $conexion);
$query_departamento = "SELECT * FROM departamento WHERE idRegional='".$row_regional['idRegional']."'";
$mostrar_departamento=mysql_query($query_departamento, $conexion) or die(mysql_error());
$total_departamento=mysql_num_rows($mostrar_departamento);

while($row_departamento=mysql_fetch_assoc($mostrar_departamento)){
mysql_select_db($database_conexion, $conexion);
$query_mer = "SELECT a.*, b.municipio, c.rubro FROM  mer a, municipio b, rubro c WHERE a.idRegional='".$row_regional['idRegional']."' AND a.idDepartamento='".$row_departamento['idDepartamento']."' AND a.idMunicipio=b.idMunicipio AND a.idRubro=c.idRubro ORDER BY b.municipio asc ";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$total_mer=mysql_num_rows($mostrar_mer);
    ?>
<tr bgcolor="#dddfff">
    <td colspan="3"><b>Regional: </b><?php echo $row_regional['regional']?></td>
    <td colspan="3"><b>Depto: </b><?php echo $row_departamento['departamento']?></td>
    <td colspan="15"></td>
</tr>
<?php
$sw=0;
if($total_mer>0){?>
<tr>
    <th style="background:#B8C692">No</th>
    <th style="background:#B8C692">Municipio</th>
    <th style="background:#B8C692">Rubro</th>
    <th style="background:#B8C692">Nombre de la Mer</th>
    <th style="background:#B8C692">Gestion</th>

    <th style="background:#0aeea3">Plan de Negocio</th>
    <th style="background:#0aeea3">Plan Estrategico</th>
    <th style="background:#0aeea3">Plan de Produccion</th>
    <th style="background:#0aeea3">Plan Financiero</th>
    <th style="background:#0aeea3">POA</th>

    <th style="background:#0aeae0">Personeria Juridica</th>
    <th style="background:#0aeae0">Estatuto Organico</th>
    <th style="background:#0aeae0">Reglamento Interno</th>
    <th style="background:#0aeae0">Reg. Funda Empresa</th>
    <th style="background:#0aeae0">Acta Constitucion</th>
    <th style="background:#0aeae0">Tarjeta Empresarial</th>

    <th style="background:#0ab473">Producto Desarrollado</th>
    <th style="background:#0ab473">Servicio Desarrollado</th>
    <th style="background:#0ab473">Plan Marketing</th>

    <th style="background:#0ac0bf">Registro de Ventas Actualizado</th>
    <th style="background:#7DA81B">Parametros de Calidad</th>
    <th style="background:#B8C692">Valor</th>
</tr>
<?php

while($row_mer=mysql_fetch_assoc($mostrar_mer)){
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
$query_formulario7 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=7";
$mostrar_formulario7= mysql_query($query_formulario7, $conexion) or die(mysql_error());
$row_formulario7= mysql_fetch_assoc($mostrar_formulario7);

mysql_select_db($database_conexion, $conexion);
$query_formulario8 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=8";
$mostrar_formulario8= mysql_query($query_formulario8, $conexion) or die(mysql_error());
$row_formulario8= mysql_fetch_assoc($mostrar_formulario8);

mysql_select_db($database_conexion, $conexion);
$query_formulario19 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=19";
$mostrar_formulario19= mysql_query($query_formulario19, $conexion) or die(mysql_error());
$row_formulario19= mysql_fetch_assoc($mostrar_formulario19);

mysql_select_db($database_conexion, $conexion);
$query_formulario10 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=10";
$mostrar_formulario10= mysql_query($query_formulario10, $conexion) or die(mysql_error());
$row_formulario10= mysql_fetch_assoc($mostrar_formulario10);

mysql_select_db($database_conexion, $conexion);
$query_formulario11 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=11";
$mostrar_formulario11= mysql_query($query_formulario11, $conexion) or die(mysql_error());
$row_formulario11= mysql_fetch_assoc($mostrar_formulario11);

mysql_select_db($database_conexion, $conexion);
$query_formulario17 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=17";
$mostrar_formulario17= mysql_query($query_formulario17, $conexion) or die(mysql_error());
$row_formulario17= mysql_fetch_assoc($mostrar_formulario17);

mysql_select_db($database_conexion, $conexion);
$query_formulario9 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=9";
$mostrar_formulario9= mysql_query($query_formulario9, $conexion) or die(mysql_error());
$row_formulario9= mysql_fetch_assoc($mostrar_formulario9);

mysql_select_db($database_conexion, $conexion);
$query_formulario21 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=21";
$mostrar_formulario21= mysql_query($query_formulario21, $conexion) or die(mysql_error());
$row_formulario21= mysql_fetch_assoc($mostrar_formulario21);


if(($row_formulario2['cuenta']=='SI' || $row_formulario3['cuenta']=='SI' || $row_formulario4['cuenta']=='SI'|| $row_formulario5['cuenta']=='SI' || $row_formulario6['cuenta']=='SI')&& ($row_formulario19['cuenta']=='SI' || $row_formulario8['cuenta']=='SI' || $row_formulario9['cuenta']=='SI' || $row_formulario11['cuenta']=='SI' || $row_formulario7['cuenta']=='SI' || $row_formulario10['cuenta']=='SI') && ($row_formulario17['cuenta']=='SI')  && ($row_formulario21['cuenta']=='SI'))
{
    $indicador2='Fortalecida';$contIndicador=$contIndicador+1;
?>
<tr>
<td><?php echo $contador?></td>
<td><?php echo $row_mer['municipio']?></td>
<td><?php echo $row_mer['rubro']?></td>
<td><?php echo $row_mer['mer']?></td>
<td><?php echo $row_mer['gestion']?></td>

<td><?php echo $row_formulario2['cuenta'];?></td>
<td><?php echo $row_formulario3['cuenta'];?></td>
<td><?php echo $row_formulario5['cuenta'];?></td>
<td><?php echo $row_formulario4['cuenta'];?></td>
<td><?php echo $row_formulario6['cuenta'];?></td>

<td><?php echo $row_formulario19['cuenta'];?></td>
<td><?php echo $row_formulario8['cuenta'];?></td>
<td><?php echo $row_formulario9['cuenta'];?></td>
<td><?php echo $row_formulario11['cuenta'];?></td>
<td><?php echo $row_formulario7['cuenta'];?></td>
<td><?php echo $row_formulario10['cuenta'];?></td>

<td><?php if($row_formulario3['cuenta']=='SI' || $row_formulario4['cuenta']=='SI' || $row_formulario5['cuenta']=='SI' || $row_formulario6['cuenta']=='SI'){echo "SI";};?></td>
<td><?php if($row_formulario3['cuenta']=='SI' || $row_formulario4['cuenta']=='SI' || $row_formulario5['cuenta']=='SI' || $row_formulario6['cuenta']=='SI'){echo "SI";};?></td>
<td><?php echo $row_formulario2['cuenta'];?></td>

<td><?php echo $row_formulario17['cuenta'];?></td>
<td><?php echo $row_formulario21['cuenta'];?></td>
<td><?php echo $indicador2;?></td>
</tr>
<?php
$contador++;

$sw=1;
}
}
}
if($sw==0){ echo "<tr><td colspan='17'>No se encuentra ninguna mers fortalecida en esta ubicacion</td></tr>";}
}
}?>
    </table>
<br>
<table border="1" width="50px">
    <tr style="background: olive;color: #ffffff">
        <th>META DEL PROYECTO</th>
        <TH>MERS FORTALECIDAS</TH>
        <TH>PORCENTAJE</TH>
    </tr>
    <TR align="center">
        <TD> 115 </TD>
        <TD><?php echo $contador-1?></TD>
        <TD><?php printf("%0.02f",($contador-1)*100/115);?>%</TD>
    </TR>
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
class cmers_fortalecidas_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'mers_fortalecidas';

	// Page Object Name
	var $PageObjName = 'mers_fortalecidas_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $mers_fortalecidas;
		if ($mers_fortalecidas->UseTokenInUrl) $PageUrl .= "t=" . $mers_fortalecidas->TableVar . "&"; // add page token
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
		global $objForm, $mers_fortalecidas;
		if ($mers_fortalecidas->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($mers_fortalecidas->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($mers_fortalecidas->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cmers_fortalecidas_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["mers_fortalecidas"] = new cmers_fortalecidas();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'mers_fortalecidas', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $mers_fortalecidas;
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
	$mers_fortalecidas->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $mers_fortalecidas->Export; // Get export parameter, used in header
	$gsExportFile = $mers_fortalecidas->TableVar; // Get export file, used in header
	if ($mers_fortalecidas->Export == "print" || $mers_fortalecidas->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($mers_fortalecidas->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $mers_fortalecidas;
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
		if ($mers_fortalecidas->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $mers_fortalecidas->getRecordsPerPage(); // Restore from Session
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
		$mers_fortalecidas->setSessionWhere($sFilter);
		$mers_fortalecidas->CurrentFilter = "";

		// Export data only
		if (in_array($mers_fortalecidas->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $mers_fortalecidas;
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
			$mers_fortalecidas->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$mers_fortalecidas->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $mers_fortalecidas;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$mers_fortalecidas->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$mers_fortalecidas->CurrentOrderType = @$_GET["ordertype"];
			$mers_fortalecidas->UpdateSort($mers_fortalecidas->idMer); // Field 
			$mers_fortalecidas->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $mers_fortalecidas;
		$sOrderBy = $mers_fortalecidas->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($mers_fortalecidas->SqlOrderBy() <> "") {
				$sOrderBy = $mers_fortalecidas->SqlOrderBy();
				$mers_fortalecidas->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $mers_fortalecidas;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$mers_fortalecidas->setSessionOrderBy($sOrderBy);
				$mers_fortalecidas->idMer->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$mers_fortalecidas->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $mers_fortalecidas;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$mers_fortalecidas->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$mers_fortalecidas->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $mers_fortalecidas->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$mers_fortalecidas->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$mers_fortalecidas->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$mers_fortalecidas->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $mers_fortalecidas;

		// Call Recordset Selecting event
		$mers_fortalecidas->Recordset_Selecting($mers_fortalecidas->CurrentFilter);

		// Load list page SQL
		$sSql = $mers_fortalecidas->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$mers_fortalecidas->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $mers_fortalecidas;
		$sFilter = $mers_fortalecidas->KeyFilter();

		// Call Row Selecting event
		$mers_fortalecidas->Row_Selecting($sFilter);

		// Load sql based on filter
		$mers_fortalecidas->CurrentFilter = $sFilter;
		$sSql = $mers_fortalecidas->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$mers_fortalecidas->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $mers_fortalecidas;
		$mers_fortalecidas->idMer->setDbValue($rs->fields('idMer'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $mers_fortalecidas;

		// Call Row_Rendering event
		$mers_fortalecidas->Row_Rendering();

		// Common render codes for all row types
		// idMer

		$mers_fortalecidas->idMer->CellCssStyle = "";
		$mers_fortalecidas->idMer->CellCssClass = "";
		if ($mers_fortalecidas->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$mers_fortalecidas->idMer->ViewValue = $mers_fortalecidas->idMer->CurrentValue;
			$mers_fortalecidas->idMer->CssStyle = "";
			$mers_fortalecidas->idMer->CssClass = "";
			$mers_fortalecidas->idMer->ViewCustomAttributes = "";

			// idMer
			$mers_fortalecidas->idMer->HrefValue = "";
		}

		// Call Row Rendered event
		$mers_fortalecidas->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $mers_fortalecidas;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($mers_fortalecidas->ExportAll) {
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
		if ($mers_fortalecidas->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($mers_fortalecidas->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $mers_fortalecidas->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idMer', $mers_fortalecidas->Export);
				echo ew_ExportLine($sExportStr, $mers_fortalecidas->Export);
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
				$mers_fortalecidas->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($mers_fortalecidas->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idMer', $mers_fortalecidas->idMer->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $mers_fortalecidas->Export <> "csv") { // Vertical format
						echo ew_ExportField('idMer', $mers_fortalecidas->idMer->ExportValue($mers_fortalecidas->Export, $mers_fortalecidas->ExportOriginalValue), $mers_fortalecidas->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $mers_fortalecidas->idMer->ExportValue($mers_fortalecidas->Export, $mers_fortalecidas->ExportOriginalValue), $mers_fortalecidas->Export);
						echo ew_ExportLine($sExportStr, $mers_fortalecidas->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($mers_fortalecidas->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($mers_fortalecidas->Export);
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
