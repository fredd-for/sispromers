<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "responsableinfo.php" ?>
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
$responsable_list = new cresponsable_list();
$Page =& $responsable_list;

// Page init processing
$responsable_list->Page_Init();

// Page main processing
$responsable_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($responsable->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var responsable_list = new ew_Page("responsable_list");

// page properties
responsable_list.PageID = "list"; // page ID
var EW_PAGE_ID = responsable_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
responsable_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
responsable_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
responsable_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-1.css" title="win2k-1">
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
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
<?php if ($responsable->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($responsable->Export == "" && $responsable->SelectLimit);
	if (!$bSelectLimit)
		$rs = $responsable_list->LoadRecordset();
	$responsable_list->lTotalRecs = ($bSelectLimit) ? $responsable->SelectRecordCount() : $rs->RecordCount();
	$responsable_list->lStartRec = 1;
	if ($responsable_list->lDisplayRecs <= 0) // Display all records
		$responsable_list->lDisplayRecs = $responsable_list->lTotalRecs;
	if (!($responsable->ExportAll && $responsable->Export <> ""))
		$responsable_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $responsable_list->LoadRecordset($responsable_list->lStartRec-1, $responsable_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Responsable
<?php if ($responsable->Export == "" && $responsable->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $responsable_list->PageUrl() ?>export=print">Impresi&oacute;n Amigable</a>
&nbsp;&nbsp;<a href="<?php echo $responsable_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $responsable_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div>
        <fieldset>
            BUSCAR= <input type="text" name="search" value="" id="id_search" size="50"/>
        </fieldset>
    </div>
            <div class="ewGridMiddlePanel">
<form name="fresponsablelist" id="fresponsablelist" class="ewForm" action="" method="post">
<?php if ($responsable_list->lTotalRecs > 0) { ?>
<table id="table_example" cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$responsable_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$responsable_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$responsable_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$responsable_list->lOptionCnt++; // Delete
}
	$responsable_list->lOptionCnt += count($responsable_list->ListOptions->Items); // Custom list options
?>
<?php echo $responsable->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($responsable->idResponsable->Visible) { // idResponsable ?>
	<?php if ($responsable->SortUrl($responsable->idResponsable) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $responsable->SortUrl($responsable->idResponsable) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($responsable->idResponsable->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($responsable->idResponsable->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($responsable->idGerente->Visible) { // idGerente ?>
	<?php if ($responsable->SortUrl($responsable->idGerente) == "") { ?>
		<td>Gerente</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $responsable->SortUrl($responsable->idGerente) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gerente</td><td style="width: 10px;"><?php if ($responsable->idGerente->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($responsable->idGerente->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($responsable->idMer->Visible) { // idMer ?>
	<?php if ($responsable->SortUrl($responsable->idMer) == "") { ?>
		<td>Mer</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $responsable->SortUrl($responsable->idMer) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Mer</td><td style="width: 10px;"><?php if ($responsable->idMer->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($responsable->idMer->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($responsable->fecha->Visible) { // fecha ?>
	<?php if ($responsable->SortUrl($responsable->fecha) == "") { ?>
		<td>Fecha de Asignacion</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $responsable->SortUrl($responsable->fecha) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fecha de Asignacion</td><td style="width: 10px;"><?php if ($responsable->fecha->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($responsable->fecha->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($responsable->Export == "") { ?>
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
foreach ($responsable_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<tbody id="contenidoTbody">
<?php
if ($responsable->ExportAll && $responsable->Export <> "") {
	$responsable_list->lStopRec = $responsable_list->lTotalRecs;
} else {
	$responsable_list->lStopRec = $responsable_list->lStartRec + $responsable_list->lDisplayRecs - 1; // Set the last record to display
}
$responsable_list->lRecCount = $responsable_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$responsable->SelectLimit && $responsable_list->lStartRec > 1)
		$rs->Move($responsable_list->lStartRec - 1);
}
$responsable_list->lRowCnt = 0;
while (($responsable->CurrentAction == "gridadd" || !$rs->EOF) &&
	$responsable_list->lRecCount < $responsable_list->lStopRec) {
	$responsable_list->lRecCount++;
	if (intval($responsable_list->lRecCount) >= intval($responsable_list->lStartRec)) {
		$responsable_list->lRowCnt++;

	// Init row class and style
	$responsable->CssClass = "";
	$responsable->CssStyle = "";
	$responsable->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($responsable->CurrentAction == "gridadd") {
		$responsable_list->LoadDefaultValues(); // Load default values
	} else {
		$responsable_list->LoadRowValues($rs); // Load row values
	}
	$responsable->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$responsable_list->RenderRow();
?>
	<tr<?php echo $responsable->RowAttributes() ?>>
	<?php if ($responsable->idResponsable->Visible) { // idResponsable ?>
		<td<?php echo $responsable->idResponsable->CellAttributes() ?>>
<div<?php echo $responsable->idResponsable->ViewAttributes() ?>><?php echo $responsable->idResponsable->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($responsable->idGerente->Visible) { // idGerente ?>
		<td<?php echo $responsable->idGerente->CellAttributes() ?>>
<div<?php echo $responsable->idGerente->ViewAttributes() ?>><?php echo $responsable->idGerente->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($responsable->idMer->Visible) { // idMer ?>
		<td<?php echo $responsable->idMer->CellAttributes() ?>>
<div<?php echo $responsable->idMer->ViewAttributes() ?>><?php echo $responsable->idMer->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($responsable->fecha->Visible) { // fecha ?>
		<td<?php echo $responsable->fecha->CellAttributes() ?>>
<div<?php echo $responsable->fecha->ViewAttributes() ?>><?php echo $responsable->fecha->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($responsable->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $responsable->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $responsable->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $responsable_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $responsable->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($responsable_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($responsable->CurrentAction <> "gridadd")
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
<?php if ($responsable->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($responsable->CurrentAction <> "gridadd" && $responsable->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($responsable_list->Pager)) $responsable_list->Pager = new cPrevNextPager($responsable_list->lStartRec, $responsable_list->lDisplayRecs, $responsable_list->lTotalRecs) ?>
<?php if ($responsable_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">P&aacute;gina&nbsp;</span></td>
<!--first page button-->
	<?php if ($responsable_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $responsable_list->PageUrl() ?>start=<?php echo $responsable_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($responsable_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $responsable_list->PageUrl() ?>start=<?php echo $responsable_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $responsable_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($responsable_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $responsable_list->PageUrl() ?>start=<?php echo $responsable_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($responsable_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $responsable_list->PageUrl() ?>start=<?php echo $responsable_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $responsable_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $responsable_list->Pager->FromIndex ?> a <?php echo $responsable_list->Pager->ToIndex ?> de <?php echo $responsable_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($responsable_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta P&aacute;gina</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($responsable_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por P&aacute;gina&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="responsable">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($responsable_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($responsable_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($responsable->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($responsable_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $responsable->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($responsable->Export == "" && $responsable->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(responsable_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($responsable->Export == "") { ?>
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
class cresponsable_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'responsable';

	// Page Object Name
	var $PageObjName = 'responsable_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $responsable;
		if ($responsable->UseTokenInUrl) $PageUrl .= "t=" . $responsable->TableVar . "&"; // add page token
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
		global $objForm, $responsable;
		if ($responsable->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($responsable->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($responsable->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cresponsable_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["responsable"] = new cresponsable();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'responsable', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $responsable;
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
	$responsable->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $responsable->Export; // Get export parameter, used in header
	$gsExportFile = $responsable->TableVar; // Get export file, used in header
	if ($responsable->Export == "print" || $responsable->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($responsable->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $responsable;
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
		if ($responsable->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $responsable->getRecordsPerPage(); // Restore from Session
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
		$responsable->setSessionWhere($sFilter);
		$responsable->CurrentFilter = "";

		// Export data only
		if (in_array($responsable->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $responsable;
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
			$responsable->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$responsable->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $responsable;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$responsable->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$responsable->CurrentOrderType = @$_GET["ordertype"];
			$responsable->UpdateSort($responsable->idResponsable); // Field 
			$responsable->UpdateSort($responsable->idGerente); // Field 
			$responsable->UpdateSort($responsable->idMer); // Field 
			$responsable->UpdateSort($responsable->fecha); // Field 
			$responsable->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $responsable;
		$sOrderBy = $responsable->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($responsable->SqlOrderBy() <> "") {
				$sOrderBy = $responsable->SqlOrderBy();
				$responsable->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $responsable;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$responsable->setSessionOrderBy($sOrderBy);
				$responsable->idResponsable->setSort("");
				$responsable->idGerente->setSort("");
				$responsable->idMer->setSort("");
				$responsable->fecha->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$responsable->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $responsable;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$responsable->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$responsable->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $responsable->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$responsable->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$responsable->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$responsable->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $responsable;

		// Call Recordset Selecting event
		$responsable->Recordset_Selecting($responsable->CurrentFilter);

		// Load list page SQL
		$sSql = $responsable->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$responsable->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $responsable;
		$sFilter = $responsable->KeyFilter();

		// Call Row Selecting event
		$responsable->Row_Selecting($sFilter);

		// Load sql based on filter
		$responsable->CurrentFilter = $sFilter;
		$sSql = $responsable->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$responsable->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $responsable;
		$responsable->idResponsable->setDbValue($rs->fields('idResponsable'));
		$responsable->idGerente->setDbValue($rs->fields('idGerente'));
		$responsable->idMer->setDbValue($rs->fields('idMer'));
		$responsable->fecha->setDbValue($rs->fields('fecha'));
		$responsable->habilitado->setDbValue($rs->fields('habilitado'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $responsable;

		// Call Row_Rendering event
		$responsable->Row_Rendering();

		// Common render codes for all row types
		// idResponsable

		$responsable->idResponsable->CellCssStyle = "";
		$responsable->idResponsable->CellCssClass = "";

		// idGerente
		$responsable->idGerente->CellCssStyle = "";
		$responsable->idGerente->CellCssClass = "";

		// idMer
		$responsable->idMer->CellCssStyle = "";
		$responsable->idMer->CellCssClass = "";

		// fecha
		$responsable->fecha->CellCssStyle = "";
		$responsable->fecha->CellCssClass = "";
		if ($responsable->RowType == EW_ROWTYPE_VIEW) { // View row

			// idResponsable
			$responsable->idResponsable->ViewValue = $responsable->idResponsable->CurrentValue;
			$responsable->idResponsable->CssStyle = "";
			$responsable->idResponsable->CssClass = "";
			$responsable->idResponsable->ViewCustomAttributes = "";

			// idGerente
			if (strval($responsable->idGerente->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `nombre`, `paterno`, `materno` FROM `usuario` WHERE `idUsuario` = " . ew_AdjustSql($responsable->idGerente->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `paterno` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$responsable->idGerente->ViewValue = $rswrk->fields('paterno');
                                        $responsable->idGerente->ViewValue .= " ".$rswrk->fields('materno');
					$responsable->idGerente->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('nombre');
					$rswrk->Close();
				} else {
					$responsable->idGerente->ViewValue = $responsable->idGerente->CurrentValue;
				}
			} else {
				$responsable->idGerente->ViewValue = NULL;
			}
			$responsable->idGerente->CssStyle = "";
			$responsable->idGerente->CssClass = "";
			$responsable->idGerente->ViewCustomAttributes = "";

			// idMer
			if (strval($responsable->idMer->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `mer` FROM `mer` WHERE `idMer` = " . ew_AdjustSql($responsable->idMer->CurrentValue) . "";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$responsable->idMer->ViewValue = $rswrk->fields('mer');
					$rswrk->Close();
				} else {
					$responsable->idMer->ViewValue = $responsable->idMer->CurrentValue;
				}
			} else {
				$responsable->idMer->ViewValue = NULL;
			}
			$responsable->idMer->CssStyle = "";
			$responsable->idMer->CssClass = "";
			$responsable->idMer->ViewCustomAttributes = "";

			// fecha
			$responsable->fecha->ViewValue = $responsable->fecha->CurrentValue;
			$responsable->fecha->ViewValue = ew_FormatDateTime($responsable->fecha->ViewValue, 7);
			$responsable->fecha->CssStyle = "";
			$responsable->fecha->CssClass = "";
			$responsable->fecha->ViewCustomAttributes = "";

			// idResponsable
			$responsable->idResponsable->HrefValue = "";

			// idGerente
			$responsable->idGerente->HrefValue = "";

			// idMer
			$responsable->idMer->HrefValue = "";

			// fecha
			$responsable->fecha->HrefValue = "";
		}

		// Call Row Rendered event
		$responsable->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $responsable;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($responsable->ExportAll) {
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
		if ($responsable->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($responsable->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $responsable->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idResponsable', $responsable->Export);
				ew_ExportAddValue($sExportStr, 'idGerente', $responsable->Export);
				ew_ExportAddValue($sExportStr, 'idMer', $responsable->Export);
				ew_ExportAddValue($sExportStr, 'fecha', $responsable->Export);
				echo ew_ExportLine($sExportStr, $responsable->Export);
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
				$responsable->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($responsable->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idResponsable', $responsable->idResponsable->CurrentValue);
					$XmlDoc->AddField('idGerente', $responsable->idGerente->CurrentValue);
					$XmlDoc->AddField('idMer', $responsable->idMer->CurrentValue);
					$XmlDoc->AddField('fecha', $responsable->fecha->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $responsable->Export <> "csv") { // Vertical format
						echo ew_ExportField('idResponsable', $responsable->idResponsable->ExportValue($responsable->Export, $responsable->ExportOriginalValue), $responsable->Export);
						echo ew_ExportField('idGerente', $responsable->idGerente->ExportValue($responsable->Export, $responsable->ExportOriginalValue), $responsable->Export);
						echo ew_ExportField('idMer', $responsable->idMer->ExportValue($responsable->Export, $responsable->ExportOriginalValue), $responsable->Export);
						echo ew_ExportField('fecha', $responsable->fecha->ExportValue($responsable->Export, $responsable->ExportOriginalValue), $responsable->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $responsable->idResponsable->ExportValue($responsable->Export, $responsable->ExportOriginalValue), $responsable->Export);
						ew_ExportAddValue($sExportStr, $responsable->idGerente->ExportValue($responsable->Export, $responsable->ExportOriginalValue), $responsable->Export);
						ew_ExportAddValue($sExportStr, $responsable->idMer->ExportValue($responsable->Export, $responsable->ExportOriginalValue), $responsable->Export);
						ew_ExportAddValue($sExportStr, $responsable->fecha->ExportValue($responsable->Export, $responsable->ExportOriginalValue), $responsable->Export);
						echo ew_ExportLine($sExportStr, $responsable->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($responsable->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($responsable->Export);
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
