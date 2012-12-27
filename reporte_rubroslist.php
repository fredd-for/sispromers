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
<?php include "header.php" ?>
<script type="text/javascript">
    var x=$(document);
    x.ready(inicializarEventos);
    function inicializarEventos()
    {  $("#x_gestion").change(cargaContenido);
       $("#x_formalizada").change(cargaContenido); 
    }    
     function cargaContenido(){
  var gestion=$("#x_gestion").attr("value");
  var formalizada=$("#x_formalizada").attr("value");
  var pagina="reporte_rubro.php?gestion="+gestion+"&formalizada="+formalizada;
  var x=$("#cargaContenido");
   x.ajaxStart(inicioEnvio);
  x.load(pagina);
  return false;
     }
     function inicioEnvio()
{
  var x=$("#cargaContenido");
  x.html('<img src="images/loading.gif">');
}
 </script>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
    <tr style="color: blue">
        <td>Gesti&oacute;n</td>
     <td>
         <select name="x_gestion" id="x_gestion">
             <option value="0" style="color: gray">Todos...</option>
			<option value="2009" <?php if(date("Y")==2009){ echo selected;}?>>2009</option>
			<option value="2010" <?php if(date("Y")==2010){ echo selected;}?>>2010</option>
			<option value="2011" <?php if(date("Y")==2011){ echo selected;}?>>2011</option>
			<option value="2012" <?php if(date("Y")==2012){ echo selected;}?>>2012</option>
         </select>
     </td>
    <td>Mers Formalizadas</td>
     <td>
         <select name="x_formalizada" id="x_formalizada">
             <option value="0" <?php if($_POST['x_formalizada']=='0'){echo "selected";$sw='0';}?> style="color: gray">Todos...</option>
             <option value="1" <?php if($_POST['x_formalizada']){if($_POST['x_formalizada']=='1'){echo "selected";$sw='1';}}else{echo "selected";$sw='1';}?>>Mers Formalizadas</option>
             <option value="2" <?php if($_POST['x_formalizada']=='2'){echo "selected";$sw='2';}?>>Mers en Proceso</option>
         </select>
     </td>
     </tr>
</table>
</div></td></tr></table>

    <div id="cargaContenido"></div>

<script type="text/javascript">
cargaContenido();
</script>

<?php include "footer.php" ?>
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
