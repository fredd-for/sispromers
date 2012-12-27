<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "regionalinfo.php" ?>
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
$regional_list = new cregional_list();
$Page =& $regional_list;

// Page init processing
$regional_list->Page_Init();

// Page main processing
$regional_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($regional->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var regional_list = new ew_Page("regional_list");

// page properties
regional_list.PageID = "list"; // page ID
var EW_PAGE_ID = regional_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
regional_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
regional_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
regional_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script type="text/javascript">
<!--
var ew_DHTMLEditors = [];

//-->
</script>
<script type="text/javascript">
    $(function () {
        $('input#id_search').quicksearch('table table#table_example #contenidoTbody tr');
    });
</script>
<?php } ?>
<?php if ($regional->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($regional->Export == "" && $regional->SelectLimit);
	if (!$bSelectLimit)
		$rs = $regional_list->LoadRecordset();
	$regional_list->lTotalRecs = ($bSelectLimit) ? $regional->SelectRecordCount() : $rs->RecordCount();
	$regional_list->lStartRec = 1;
	if ($regional_list->lDisplayRecs <= 0) // Display all records
		$regional_list->lDisplayRecs = $regional_list->lTotalRecs;
	if (!($regional->ExportAll && $regional->Export <> ""))
		$regional_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $regional_list->LoadRecordset($regional_list->lStartRec-1, $regional_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Regional
<?php if ($regional->Export == "" && $regional->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $regional_list->PageUrl() ?>export=print">Impresi&oacute;n Amigable</a>
&nbsp;&nbsp;<a href="<?php echo $regional_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>

<?php $regional_list->ShowMessage() ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div>
        <fieldset>
            BUSCAR= <input type="text" name="search" value="" id="id_search" size="50"/>
        </fieldset>
    </div>
<div class="ewGridMiddlePanel">
<form name="fregionallist" id="fregionallist" class="ewForm" action="" method="post">
<?php if ($regional_list->lTotalRecs > 0) { ?>
<table id="table_example" cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$regional_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$regional_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$regional_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$regional_list->lOptionCnt++; // Delete
}
	$regional_list->lOptionCnt += count($regional_list->ListOptions->Items); // Custom list options
?>
<?php echo $regional->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($regional->idRegional->Visible) { // idRegional ?>
	<?php if ($regional->SortUrl($regional->idRegional) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $regional->SortUrl($regional->idRegional) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($regional->idRegional->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($regional->idRegional->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($regional->regional->Visible) { // regional ?>
	<?php if ($regional->SortUrl($regional->regional) == "") { ?>
		<td>Regional</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $regional->SortUrl($regional->regional) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Regional</td><td style="width: 10px;"><?php if ($regional->regional->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($regional->regional->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($regional->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($regional_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<tbody id="contenidoTbody">
<?php
if ($regional->ExportAll && $regional->Export <> "") {
	$regional_list->lStopRec = $regional_list->lTotalRecs;
} else {
	$regional_list->lStopRec = $regional_list->lStartRec + $regional_list->lDisplayRecs - 1; // Set the last record to display
}
$regional_list->lRecCount = $regional_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$regional->SelectLimit && $regional_list->lStartRec > 1)
		$rs->Move($regional_list->lStartRec - 1);
}
$regional_list->lRowCnt = 0;
while (($regional->CurrentAction == "gridadd" || !$rs->EOF) &&
	$regional_list->lRecCount < $regional_list->lStopRec) {
	$regional_list->lRecCount++;
	if (intval($regional_list->lRecCount) >= intval($regional_list->lStartRec)) {
		$regional_list->lRowCnt++;

	// Init row class and style
	$regional->CssClass = "";
	$regional->CssStyle = "";
	$regional->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($regional->CurrentAction == "gridadd") {
		$regional_list->LoadDefaultValues(); // Load default values
	} else {
		$regional_list->LoadRowValues($rs); // Load row values
	}
	$regional->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$regional_list->RenderRow();
?>
	<tr<?php echo $regional->RowAttributes() ?>>
	<?php if ($regional->idRegional->Visible) { // idRegional ?>
		<td<?php echo $regional->idRegional->CellAttributes() ?>>
<div<?php echo $regional->idRegional->ViewAttributes() ?>><?php echo $regional->idRegional->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($regional->regional->Visible) { // regional ?>
		<td<?php echo $regional->regional->CellAttributes() ?>>
<div<?php echo $regional->regional->ViewAttributes() ?>><?php echo $regional->regional->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($regional->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $regional->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $regional->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $regional_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $regional->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($regional_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($regional->CurrentAction <> "gridadd")
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
<?php if ($regional->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($regional->CurrentAction <> "gridadd" && $regional->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($regional_list->Pager)) $regional_list->Pager = new cPrevNextPager($regional_list->lStartRec, $regional_list->lDisplayRecs, $regional_list->lTotalRecs) ?>
<?php if ($regional_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">P&aacute;gina&nbsp;</span></td>
<!--first page button-->
	<?php if ($regional_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $regional_list->PageUrl() ?>start=<?php echo $regional_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($regional_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $regional_list->PageUrl() ?>start=<?php echo $regional_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $regional_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($regional_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $regional_list->PageUrl() ?>start=<?php echo $regional_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($regional_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $regional_list->PageUrl() ?>start=<?php echo $regional_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $regional_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $regional_list->Pager->FromIndex ?> a <?php echo $regional_list->Pager->ToIndex ?> de <?php echo $regional_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($regional_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta P&aacute;gina</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($regional_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por P&aacute;gina&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="regional">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($regional_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($regional_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($regional->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($regional_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $regional->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($regional->Export == "" && $regional->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(regional_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($regional->Export == "") { ?>
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
class cregional_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'regional';

	// Page Object Name
	var $PageObjName = 'regional_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $regional;
		if ($regional->UseTokenInUrl) $PageUrl .= "t=" . $regional->TableVar . "&"; // add page token
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
		global $objForm, $regional;
		if ($regional->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($regional->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($regional->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cregional_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["regional"] = new cregional();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'regional', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $regional;
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
	$regional->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $regional->Export; // Get export parameter, used in header
	$gsExportFile = $regional->TableVar; // Get export file, used in header
	if ($regional->Export == "print" || $regional->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($regional->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $regional;
		$this->lDisplayRecs = 20;
		$this->lRecRange = 10;
		$this->lRecCnt = 0; // Record count

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		$this->sSrchWhere = ""; // Search WHERE clause
		$this->sDeleteConfirmMsg = "Quiere borrar este registro?"; // Delete confirm message

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
		if ($regional->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $regional->getRecordsPerPage(); // Restore from Session
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
		$regional->setSessionWhere($sFilter);
		$regional->CurrentFilter = "";

		// Export data only
		if (in_array($regional->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $regional;
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
			$regional->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$regional->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $regional;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$regional->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$regional->CurrentOrderType = @$_GET["ordertype"];
			$regional->UpdateSort($regional->idRegional); // Field 
			$regional->UpdateSort($regional->regional); // Field 
			$regional->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $regional;
		$sOrderBy = $regional->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($regional->SqlOrderBy() <> "") {
				$sOrderBy = $regional->SqlOrderBy();
				$regional->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $regional;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$regional->setSessionOrderBy($sOrderBy);
				$regional->idRegional->setSort("");
				$regional->regional->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$regional->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $regional;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$regional->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$regional->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $regional->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$regional->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$regional->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$regional->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $regional;

		// Call Recordset Selecting event
		$regional->Recordset_Selecting($regional->CurrentFilter);

		// Load list page SQL
		$sSql = $regional->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$regional->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $regional;
		$sFilter = $regional->KeyFilter();

		// Call Row Selecting event
		$regional->Row_Selecting($sFilter);

		// Load sql based on filter
		$regional->CurrentFilter = $sFilter;
		$sSql = $regional->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$regional->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $regional;
		$regional->idRegional->setDbValue($rs->fields('idRegional'));
		$regional->regional->setDbValue($rs->fields('regional'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $regional;

		// Call Row_Rendering event
		$regional->Row_Rendering();

		// Common render codes for all row types
		// idRegional

		$regional->idRegional->CellCssStyle = "";
		$regional->idRegional->CellCssClass = "";

		// regional
		$regional->regional->CellCssStyle = "";
		$regional->regional->CellCssClass = "";
		if ($regional->RowType == EW_ROWTYPE_VIEW) { // View row

			// idRegional
			$regional->idRegional->ViewValue = $regional->idRegional->CurrentValue;
			$regional->idRegional->CssStyle = "";
			$regional->idRegional->CssClass = "";
			$regional->idRegional->ViewCustomAttributes = "";

			// regional
			$regional->regional->ViewValue = $regional->regional->CurrentValue;
			$regional->regional->CssStyle = "";
			$regional->regional->CssClass = "";
			$regional->regional->ViewCustomAttributes = "";

			// idRegional
			$regional->idRegional->HrefValue = "";

			// regional
			$regional->regional->HrefValue = "";
		}

		// Call Row Rendered event
		$regional->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $regional;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($regional->ExportAll) {
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
		if ($regional->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($regional->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $regional->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idRegional', $regional->Export);
				ew_ExportAddValue($sExportStr, 'regional', $regional->Export);
				echo ew_ExportLine($sExportStr, $regional->Export);
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
				$regional->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($regional->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idRegional', $regional->idRegional->CurrentValue);
					$XmlDoc->AddField('regional', $regional->regional->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $regional->Export <> "csv") { // Vertical format
						echo ew_ExportField('idRegional', $regional->idRegional->ExportValue($regional->Export, $regional->ExportOriginalValue), $regional->Export);
						echo ew_ExportField('regional', $regional->regional->ExportValue($regional->Export, $regional->ExportOriginalValue), $regional->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $regional->idRegional->ExportValue($regional->Export, $regional->ExportOriginalValue), $regional->Export);
						ew_ExportAddValue($sExportStr, $regional->regional->ExportValue($regional->Export, $regional->ExportOriginalValue), $regional->Export);
						echo ew_ExportLine($sExportStr, $regional->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($regional->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($regional->Export);
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
