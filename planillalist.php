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
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$planilla_list = new cplanilla_list();
$Page =& $planilla_list;

// Page init processing
$planilla_list->Page_Init();

// Page main processing
$planilla_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($planilla->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var planilla_list = new ew_Page("planilla_list");

// page properties
planilla_list.PageID = "list"; // page ID
var EW_PAGE_ID = planilla_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
planilla_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
planilla_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
planilla_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script type="text/javascript">
<!--
var ew_DHTMLEditors = [];

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php if ($planilla->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($planilla->Export == "" && $planilla->SelectLimit);
	if (!$bSelectLimit)
		$rs = $planilla_list->LoadRecordset();
	$planilla_list->lTotalRecs = ($bSelectLimit) ? $planilla->SelectRecordCount() : $rs->RecordCount();
	$planilla_list->lStartRec = 1;
	if ($planilla_list->lDisplayRecs <= 0) // Display all records
		$planilla_list->lDisplayRecs = $planilla_list->lTotalRecs;
	if (!($planilla->ExportAll && $planilla->Export <> ""))
		$planilla_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $planilla_list->LoadRecordset($planilla_list->lStartRec-1, $planilla_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Formularios
<?php if ($planilla->Export == "" && $planilla->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $planilla_list->PageUrl() ?>export=print">Impresi&oacute;n Amigable</a>
&nbsp;&nbsp;<a href="<?php echo $planilla_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $planilla_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fplanillalist" id="fplanillalist" class="ewForm" action="" method="post">
<?php if ($planilla_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$planilla_list->lOptionCnt = 0;
if ($Security->CanView()) {
        $planilla_list->lOptionCnt++; // view
}
	$planilla_list->lOptionCnt += count($planilla_list->ListOptions->Items); // Custom list options
?>
<?php echo $planilla->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($planilla->idPlanilla->Visible) { // idPlanilla ?>
	<?php if ($planilla->SortUrl($planilla->idPlanilla) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $planilla->SortUrl($planilla->idPlanilla) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($planilla->idPlanilla->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($planilla->idPlanilla->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($planilla->Nombre->Visible) { // Nombre ?>
	<?php if ($planilla->SortUrl($planilla->Nombre) == "") { ?>
		<td>Nombre del Formulario</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $planilla->SortUrl($planilla->Nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Nombre del Formulario</td><td style="width: 10px;"><?php if ($planilla->Nombre->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($planilla->Nombre->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($planilla->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($planilla_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($planilla->ExportAll && $planilla->Export <> "") {
	$planilla_list->lStopRec = $planilla_list->lTotalRecs;
} else {
	$planilla_list->lStopRec = $planilla_list->lStartRec + $planilla_list->lDisplayRecs - 1; // Set the last record to display
}
$planilla_list->lRecCount = $planilla_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$planilla->SelectLimit && $planilla_list->lStartRec > 1)
		$rs->Move($planilla_list->lStartRec - 1);
}
$planilla_list->lRowCnt = 0;
while (($planilla->CurrentAction == "gridadd" || !$rs->EOF) &&
	$planilla_list->lRecCount < $planilla_list->lStopRec) {
	$planilla_list->lRecCount++;
	if (intval($planilla_list->lRecCount) >= intval($planilla_list->lStartRec)) {
		$planilla_list->lRowCnt++;

	// Init row class and style
	$planilla->CssClass = "";
	$planilla->CssStyle = "";
	$planilla->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($planilla->CurrentAction == "gridadd") {
		$planilla_list->LoadDefaultValues(); // Load default values
	} else {
		$planilla_list->LoadRowValues($rs); // Load row values
	}
	$planilla->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$planilla_list->RenderRow();
?>
	<tr<?php echo $planilla->RowAttributes() ?>>
	<?php if ($planilla->idPlanilla->Visible) { // idPlanilla ?>
		<td<?php echo $planilla->idPlanilla->CellAttributes() ?>>
<div<?php echo $planilla->idPlanilla->ViewAttributes() ?>><?php echo $planilla->idPlanilla->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($planilla->Nombre->Visible) { // Nombre ?>
		<td<?php echo $planilla->Nombre->CellAttributes() ?>>
<div<?php echo $planilla->Nombre->ViewAttributes() ?>><?php echo $planilla->Nombre->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($planilla->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $planilla->ViewUrl() ?>">Modificar Formulario</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($planilla_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($planilla->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
</div>
</td></tr></table>
<?php if ($planilla->Export == "" && $planilla->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(planilla_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($planilla->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cplanilla_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'planilla';

	// Page Object Name
	var $PageObjName = 'planilla_list';

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
	function cplanilla_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["planilla"] = new cplanilla();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'planilla', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
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
	$planilla->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $planilla->Export; // Get export parameter, used in header
	$gsExportFile = $planilla->TableVar; // Get export file, used in header
	if ($planilla->Export == "print" || $planilla->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($planilla->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $planilla;
		$this->lDisplayRecs = 21;
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
		if ($planilla->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $planilla->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 21; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$planilla->setSessionWhere($sFilter);
		$planilla->CurrentFilter = "";

		// Export data only
		if (in_array($planilla->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $planilla;
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->lDisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->lDisplayRecs = -1;
				} else {
					$this->lDisplayRecs = 21; // Non-numeric, load default
				}
			}
			$planilla->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$planilla->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $planilla;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$planilla->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$planilla->CurrentOrderType = @$_GET["ordertype"];
			$planilla->UpdateSort($planilla->idPlanilla); // Field 
			$planilla->UpdateSort($planilla->Nombre); // Field 
			$planilla->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $planilla;
		$sOrderBy = $planilla->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($planilla->SqlOrderBy() <> "") {
				$sOrderBy = $planilla->SqlOrderBy();
				$planilla->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $planilla;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$planilla->setSessionOrderBy($sOrderBy);
				$planilla->idPlanilla->setSort("");
				$planilla->Nombre->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$planilla->setStartRecordNumber($this->lStartRec);
		}
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $planilla;

		// Call Recordset Selecting event
		$planilla->Recordset_Selecting($planilla->CurrentFilter);

		// Load list page SQL
		$sSql = $planilla->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$planilla->Recordset_Selected($rs);
		return $rs;
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

	// Export data in XML or CSV format
	function ExportData() {
		global $planilla;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($planilla->ExportAll) {
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
		if ($planilla->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($planilla->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $planilla->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idPlanilla', $planilla->Export);
				ew_ExportAddValue($sExportStr, 'Nombre', $planilla->Export);
				echo ew_ExportLine($sExportStr, $planilla->Export);
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
				$planilla->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($planilla->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idPlanilla', $planilla->idPlanilla->CurrentValue);
					$XmlDoc->AddField('Nombre', $planilla->Nombre->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $planilla->Export <> "csv") { // Vertical format
						echo ew_ExportField('idPlanilla', $planilla->idPlanilla->ExportValue($planilla->Export, $planilla->ExportOriginalValue), $planilla->Export);
						echo ew_ExportField('Nombre', $planilla->Nombre->ExportValue($planilla->Export, $planilla->ExportOriginalValue), $planilla->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $planilla->idPlanilla->ExportValue($planilla->Export, $planilla->ExportOriginalValue), $planilla->Export);
						ew_ExportAddValue($sExportStr, $planilla->Nombre->ExportValue($planilla->Export, $planilla->ExportOriginalValue), $planilla->Export);
						echo ew_ExportLine($sExportStr, $planilla->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($planilla->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($planilla->Export);
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
