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
<?php include "header.php" ?>
<script type="text/javascript">
    var x=$(document);
    x.ready(inicializarEventos);
    function inicializarEventos()
    {  $("#x_gestion").change(cargaContenido);
    }
     function cargaContenido(){
  var gestion=$("#x_gestion").attr("value");
    var pagina="reporte_mml.php?gestion="+gestion;
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
