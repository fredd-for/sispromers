<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "consultoriainfo.php" ?>
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
$consultoria_list = new cconsultoria_list();
$Page =& $consultoria_list;

// Page init processing
$consultoria_list->Page_Init();

// Page main processing
$consultoria_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($consultoria->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var consultoria_list = new ew_Page("consultoria_list");

// page properties
consultoria_list.PageID = "list"; // page ID
var EW_PAGE_ID = consultoria_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
consultoria_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
consultoria_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
consultoria_list.ValidateRequired = false; // no JavaScript validation
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
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php if ($consultoria->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($consultoria->Export == "" && $consultoria->SelectLimit);
	if (!$bSelectLimit)
		$rs = $consultoria_list->LoadRecordset();
	$consultoria_list->lTotalRecs = ($bSelectLimit) ? $consultoria->SelectRecordCount() : $rs->RecordCount();
	$consultoria_list->lStartRec = 1;
	if ($consultoria_list->lDisplayRecs <= 0) // Display all records
		$consultoria_list->lDisplayRecs = $consultoria_list->lTotalRecs;
	if (!($consultoria->ExportAll && $consultoria->Export <> ""))
		$consultoria_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $consultoria_list->LoadRecordset($consultoria_list->lStartRec-1, $consultoria_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Consultoria

</span></p>
<?php $consultoria_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fconsultorialist" id="fconsultorialist" class="ewForm" action="" method="post">
<?php if ($consultoria_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$consultoria_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$consultoria_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$consultoria_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$consultoria_list->lOptionCnt++; // Delete
}
	$consultoria_list->lOptionCnt += count($consultoria_list->ListOptions->Items); // Custom list options
?>
<?php echo $consultoria->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($consultoria->idConsultoria->Visible) { // idConsultoria ?>
	<?php if ($consultoria->SortUrl($consultoria->idConsultoria) == "") { ?>
		<td>Nro</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $consultoria->SortUrl($consultoria->idConsultoria) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Nro</td><td style="width: 10px;"><?php if ($consultoria->idConsultoria->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($consultoria->idConsultoria->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($consultoria->idUsuario->Visible) { // idUsuario ?>
	<?php if ($consultoria->SortUrl($consultoria->idUsuario) == "") { ?>
		<td>Consultor</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $consultoria->SortUrl($consultoria->idUsuario) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Consultor</td><td style="width: 10px;"><?php if ($consultoria->idUsuario->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($consultoria->idUsuario->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($consultoria->consultoria->Visible) { // consultoria ?>
	<?php if ($consultoria->SortUrl($consultoria->consultoria) == "") { ?>
		<td>Titulo de la Consultoria</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $consultoria->SortUrl($consultoria->consultoria) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Titulo de la Consultoria</td><td style="width: 10px;"><?php if ($consultoria->consultoria->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($consultoria->consultoria->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($consultoria->fechaInicio->Visible) { // fechaInicio ?>
	<?php if ($consultoria->SortUrl($consultoria->fechaInicio) == "") { ?>
		<td>Fecha Inicio</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $consultoria->SortUrl($consultoria->fechaInicio) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fecha Inicio</td><td style="width: 10px;"><?php if ($consultoria->fechaInicio->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($consultoria->fechaInicio->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($consultoria->fechaFinal->Visible) { // fechaFinal ?>
	<?php if ($consultoria->SortUrl($consultoria->fechaFinal) == "") { ?>
		<td>Fecha Finalizacion</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $consultoria->SortUrl($consultoria->fechaFinal) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fecha Finalizacion</td><td style="width: 10px;"><?php if ($consultoria->fechaFinal->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($consultoria->fechaFinal->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
		
<?php if ($consultoria->Export == "") { ?>
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
foreach ($consultoria_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($consultoria->ExportAll && $consultoria->Export <> "") {
	$consultoria_list->lStopRec = $consultoria_list->lTotalRecs;
} else {
	$consultoria_list->lStopRec = $consultoria_list->lStartRec + $consultoria_list->lDisplayRecs - 1; // Set the last record to display
}
$consultoria_list->lRecCount = $consultoria_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$consultoria->SelectLimit && $consultoria_list->lStartRec > 1)
		$rs->Move($consultoria_list->lStartRec - 1);
}
$consultoria_list->lRowCnt = 0;
while (($consultoria->CurrentAction == "gridadd" || !$rs->EOF) &&
	$consultoria_list->lRecCount < $consultoria_list->lStopRec) {
	$consultoria_list->lRecCount++;
	if (intval($consultoria_list->lRecCount) >= intval($consultoria_list->lStartRec)) {
		$consultoria_list->lRowCnt++;

	// Init row class and style
	$consultoria->CssClass = "";
	$consultoria->CssStyle = "";
	$consultoria->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($consultoria->CurrentAction == "gridadd") {
		$consultoria_list->LoadDefaultValues(); // Load default values
	} else {
		$consultoria_list->LoadRowValues($rs); // Load row values
	}
	$consultoria->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$consultoria_list->RenderRow();
?>
	<tr<?php echo $consultoria->RowAttributes() ?>>
	<?php if ($consultoria->idConsultoria->Visible) { // idConsultoria ?>
		<td<?php echo $consultoria->idConsultoria->CellAttributes() ?>>
<div<?php echo $consultoria->idConsultoria->ViewAttributes() ?>><?php echo $consultoria->idConsultoria->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($consultoria->idUsuario->Visible) { // idUsuario ?>
		<td<?php echo $consultoria->idUsuario->CellAttributes() ?>>
<div<?php echo $consultoria->idUsuario->ViewAttributes() ?>><?php echo $consultoria->idUsuario->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($consultoria->consultoria->Visible) { // consultoria ?>
		<td<?php echo $consultoria->consultoria->CellAttributes() ?>>
<div<?php echo $consultoria->consultoria->ViewAttributes() ?>><?php echo $consultoria->consultoria->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($consultoria->fechaInicio->Visible) { // fechaInicio ?>
		<td<?php echo $consultoria->fechaInicio->CellAttributes() ?>>
<div<?php echo $consultoria->fechaInicio->ViewAttributes() ?>><?php echo $consultoria->fechaInicio->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($consultoria->fechaFinal->Visible) { // fechaFinal ?>
		<td<?php echo $consultoria->fechaFinal->CellAttributes() ?>>
<div<?php echo $consultoria->fechaFinal->ViewAttributes() ?>><?php echo $consultoria->fechaFinal->ListViewValue() ?></div>
</td>
	<?php } ?>

<?php if ($consultoria->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $consultoria->ViewUrl() ?>">Cronograma</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $consultoria->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $consultoria_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $consultoria->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($consultoria_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($consultoria->CurrentAction <> "gridadd")
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
<?php if ($consultoria->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($consultoria->CurrentAction <> "gridadd" && $consultoria->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($consultoria_list->Pager)) $consultoria_list->Pager = new cPrevNextPager($consultoria_list->lStartRec, $consultoria_list->lDisplayRecs, $consultoria_list->lTotalRecs) ?>
<?php if ($consultoria_list->Pager->RecordCount > 0) { ?>
                    <table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">P&aacute;gina&nbsp;</span></td>
<!--first page button-->
	<?php if ($consultoria_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $consultoria_list->PageUrl() ?>start=<?php echo $consultoria_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($consultoria_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $consultoria_list->PageUrl() ?>start=<?php echo $consultoria_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $consultoria_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($consultoria_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $consultoria_list->PageUrl() ?>start=<?php echo $consultoria_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($consultoria_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $consultoria_list->PageUrl() ?>start=<?php echo $consultoria_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $consultoria_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $consultoria_list->Pager->FromIndex ?> a <?php echo $consultoria_list->Pager->ToIndex ?> de <?php echo $consultoria_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($consultoria_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta p&aacute;gina</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($consultoria_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por p&aacute;gina&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="consultoria">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($consultoria_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($consultoria_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($consultoria->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($consultoria_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $consultoria->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($consultoria->Export == "" && $consultoria->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(consultoria_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($consultoria->Export == "") { ?>
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
class cconsultoria_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'consultoria';

	// Page Object Name
	var $PageObjName = 'consultoria_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $consultoria;
		if ($consultoria->UseTokenInUrl) $PageUrl .= "t=" . $consultoria->TableVar . "&"; // add page token
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
		global $objForm, $consultoria;
		if ($consultoria->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($consultoria->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($consultoria->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cconsultoria_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["consultoria"] = new cconsultoria();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'consultoria', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $consultoria;
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
	$consultoria->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $consultoria->Export; // Get export parameter, used in header
	$gsExportFile = $consultoria->TableVar; // Get export file, used in header
	if ($consultoria->Export == "print" || $consultoria->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($consultoria->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $consultoria;
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
		if ($consultoria->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $consultoria->getRecordsPerPage(); // Restore from Session
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
		$consultoria->setSessionWhere($sFilter);
		$consultoria->CurrentFilter = "";

		// Export data only
		if (in_array($consultoria->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $consultoria;
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
			$consultoria->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $consultoria;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$consultoria->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$consultoria->CurrentOrderType = @$_GET["ordertype"];
			$consultoria->UpdateSort($consultoria->idConsultoria); // Field 
			$consultoria->UpdateSort($consultoria->idUsuario); // Field 
			$consultoria->UpdateSort($consultoria->consultoria); // Field 
			$consultoria->UpdateSort($consultoria->fechaInicio); // Field 
			$consultoria->UpdateSort($consultoria->fechaFinal); // Field 
			$consultoria->UpdateSort($consultoria->estado); // Field 
			$consultoria->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $consultoria;
		$sOrderBy = $consultoria->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($consultoria->SqlOrderBy() <> "") {
				$sOrderBy = $consultoria->SqlOrderBy();
				$consultoria->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $consultoria;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$consultoria->setSessionOrderBy($sOrderBy);
				$consultoria->idConsultoria->setSort("");
				$consultoria->idUsuario->setSort("");
				$consultoria->consultoria->setSort("");
				$consultoria->fechaInicio->setSort("");
				$consultoria->fechaFinal->setSort("");
				$consultoria->estado->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $consultoria;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$consultoria->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$consultoria->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $consultoria->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $consultoria;

		// Call Recordset Selecting event
		$consultoria->Recordset_Selecting($consultoria->CurrentFilter);

		// Load list page SQL
		$sSql = $consultoria->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$consultoria->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $consultoria;
		$sFilter = $consultoria->KeyFilter();

		// Call Row Selecting event
		$consultoria->Row_Selecting($sFilter);

		// Load sql based on filter
		$consultoria->CurrentFilter = $sFilter;
		$sSql = $consultoria->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$consultoria->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $consultoria;
		$consultoria->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$consultoria->idUsuario->setDbValue($rs->fields('idUsuario'));
		$consultoria->consultoria->setDbValue($rs->fields('consultoria'));
		$consultoria->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$consultoria->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$consultoria->estado->setDbValue($rs->fields('estado'));
		$consultoria->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$consultoria->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $consultoria;

		// Call Row_Rendering event
		$consultoria->Row_Rendering();

		// Common render codes for all row types
		// idConsultoria

		$consultoria->idConsultoria->CellCssStyle = "";
		$consultoria->idConsultoria->CellCssClass = "";

		// idUsuario
		$consultoria->idUsuario->CellCssStyle = "";
		$consultoria->idUsuario->CellCssClass = "";

		// consultoria
		$consultoria->consultoria->CellCssStyle = "";
		$consultoria->consultoria->CellCssClass = "";

		// fechaInicio
		$consultoria->fechaInicio->CellCssStyle = "";
		$consultoria->fechaInicio->CellCssClass = "";

		// fechaFinal
		$consultoria->fechaFinal->CellCssStyle = "";
		$consultoria->fechaFinal->CellCssClass = "";

		// estado
		$consultoria->estado->CellCssStyle = "";
		$consultoria->estado->CellCssClass = "";
		if ($consultoria->RowType == EW_ROWTYPE_VIEW) { // View row

			// idConsultoria
			$consultoria->idConsultoria->ViewValue = $consultoria->idConsultoria->CurrentValue;
			$consultoria->idConsultoria->CssStyle = "";
			$consultoria->idConsultoria->CssClass = "";
			$consultoria->idConsultoria->ViewCustomAttributes = "";

			// idUsuario
			if (strval($consultoria->idUsuario->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `paterno`, `nombre` FROM `usuario` WHERE `idUsuario` = " . ew_AdjustSql($consultoria->idUsuario->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `paterno` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$consultoria->idUsuario->ViewValue = $rswrk->fields('paterno');
					$consultoria->idUsuario->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('nombre');
					$rswrk->Close();
				} else {
					$consultoria->idUsuario->ViewValue = $consultoria->idUsuario->CurrentValue;
				}
			} else {
				$consultoria->idUsuario->ViewValue = NULL;
			}
			$consultoria->idUsuario->CssStyle = "";
			$consultoria->idUsuario->CssClass = "";
			$consultoria->idUsuario->ViewCustomAttributes = "";

			// consultoria
			$consultoria->consultoria->ViewValue = $consultoria->consultoria->CurrentValue;
			$consultoria->consultoria->CssStyle = "";
			$consultoria->consultoria->CssClass = "";
			$consultoria->consultoria->ViewCustomAttributes = "";

			// fechaInicio
			$consultoria->fechaInicio->ViewValue = $consultoria->fechaInicio->CurrentValue;
			$consultoria->fechaInicio->ViewValue = ew_FormatDateTime($consultoria->fechaInicio->ViewValue, 7);
			$consultoria->fechaInicio->CssStyle = "";
			$consultoria->fechaInicio->CssClass = "";
			$consultoria->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$consultoria->fechaFinal->ViewValue = $consultoria->fechaFinal->CurrentValue;
			$consultoria->fechaFinal->ViewValue = ew_FormatDateTime($consultoria->fechaFinal->ViewValue, 7);
			$consultoria->fechaFinal->CssStyle = "";
			$consultoria->fechaFinal->CssClass = "";
			$consultoria->fechaFinal->ViewCustomAttributes = "";

			// estado
			if (strval($consultoria->estado->CurrentValue) <> "") {
				switch ($consultoria->estado->CurrentValue) {
					case "0":
						$consultoria->estado->ViewValue = "borrado";
						break;
					case "1":
						$consultoria->estado->ViewValue = "Habilitado";
						break;
					case "2":
						$consultoria->estado->ViewValue = "Desabilitado";
						break;
					case "3":
						$consultoria->estado->ViewValue = "Aprobado";
						break;
					default:
						$consultoria->estado->ViewValue = $consultoria->estado->CurrentValue;
				}
			} else {
				$consultoria->estado->ViewValue = NULL;
			}
			$consultoria->estado->CssStyle = "";
			$consultoria->estado->CssClass = "";
			$consultoria->estado->ViewCustomAttributes = "";

			// idConsultoria
			$consultoria->idConsultoria->HrefValue = "";

			// idUsuario
			$consultoria->idUsuario->HrefValue = "";

			// consultoria
			$consultoria->consultoria->HrefValue = "";

			// fechaInicio
			$consultoria->fechaInicio->HrefValue = "";

			// fechaFinal
			$consultoria->fechaFinal->HrefValue = "";

			// estado
			$consultoria->estado->HrefValue = "";
		}

		// Call Row Rendered event
		$consultoria->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $consultoria;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($consultoria->ExportAll) {
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
		if ($consultoria->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($consultoria->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $consultoria->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idConsultoria', $consultoria->Export);
				ew_ExportAddValue($sExportStr, 'idUsuario', $consultoria->Export);
				ew_ExportAddValue($sExportStr, 'fechaInicio', $consultoria->Export);
				ew_ExportAddValue($sExportStr, 'fechaFinal', $consultoria->Export);
				ew_ExportAddValue($sExportStr, 'estado', $consultoria->Export);
				echo ew_ExportLine($sExportStr, $consultoria->Export);
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
				$consultoria->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($consultoria->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idConsultoria', $consultoria->idConsultoria->CurrentValue);
					$XmlDoc->AddField('idUsuario', $consultoria->idUsuario->CurrentValue);
					$XmlDoc->AddField('fechaInicio', $consultoria->fechaInicio->CurrentValue);
					$XmlDoc->AddField('fechaFinal', $consultoria->fechaFinal->CurrentValue);
					$XmlDoc->AddField('estado', $consultoria->estado->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $consultoria->Export <> "csv") { // Vertical format
						echo ew_ExportField('idConsultoria', $consultoria->idConsultoria->ExportValue($consultoria->Export, $consultoria->ExportOriginalValue), $consultoria->Export);
						echo ew_ExportField('idUsuario', $consultoria->idUsuario->ExportValue($consultoria->Export, $consultoria->ExportOriginalValue), $consultoria->Export);
						echo ew_ExportField('fechaInicio', $consultoria->fechaInicio->ExportValue($consultoria->Export, $consultoria->ExportOriginalValue), $consultoria->Export);
						echo ew_ExportField('fechaFinal', $consultoria->fechaFinal->ExportValue($consultoria->Export, $consultoria->ExportOriginalValue), $consultoria->Export);
						echo ew_ExportField('estado', $consultoria->estado->ExportValue($consultoria->Export, $consultoria->ExportOriginalValue), $consultoria->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $consultoria->idConsultoria->ExportValue($consultoria->Export, $consultoria->ExportOriginalValue), $consultoria->Export);
						ew_ExportAddValue($sExportStr, $consultoria->idUsuario->ExportValue($consultoria->Export, $consultoria->ExportOriginalValue), $consultoria->Export);
						ew_ExportAddValue($sExportStr, $consultoria->fechaInicio->ExportValue($consultoria->Export, $consultoria->ExportOriginalValue), $consultoria->Export);
						ew_ExportAddValue($sExportStr, $consultoria->fechaFinal->ExportValue($consultoria->Export, $consultoria->ExportOriginalValue), $consultoria->Export);
						ew_ExportAddValue($sExportStr, $consultoria->estado->ExportValue($consultoria->Export, $consultoria->ExportOriginalValue), $consultoria->Export);
						echo ew_ExportLine($sExportStr, $consultoria->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($consultoria->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($consultoria->Export);
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
