<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "responsable_consultoriainfo.php" ?>
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
$responsable_consultoria_list = new cresponsable_consultoria_list();
$Page =& $responsable_consultoria_list;

// Page init processing
$responsable_consultoria_list->Page_Init();

// Page main processing
$responsable_consultoria_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($responsable_consultoria->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var responsable_consultoria_list = new ew_Page("responsable_consultoria_list");

// page properties
responsable_consultoria_list.PageID = "list"; // page ID
var EW_PAGE_ID = responsable_consultoria_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
responsable_consultoria_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
responsable_consultoria_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
responsable_consultoria_list.ValidateRequired = false; // no JavaScript validation
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
<script type="text/javascript">
    $(function () {
        $('input#id_search').quicksearch('table table#table_example #contenidoTbody tr');
    });
</script>
<?php } ?>
<?php if ($responsable_consultoria->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($responsable_consultoria->Export == "" && $responsable_consultoria->SelectLimit);
	if (!$bSelectLimit)
		$rs = $responsable_consultoria_list->LoadRecordset();
	$responsable_consultoria_list->lTotalRecs = ($bSelectLimit) ? $responsable_consultoria->SelectRecordCount() : $rs->RecordCount();
	$responsable_consultoria_list->lStartRec = 1;
	if ($responsable_consultoria_list->lDisplayRecs <= 0) // Display all records
		$responsable_consultoria_list->lDisplayRecs = $responsable_consultoria_list->lTotalRecs;
	if (!($responsable_consultoria->ExportAll && $responsable_consultoria->Export <> ""))
		$responsable_consultoria_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $responsable_consultoria_list->LoadRecordset($responsable_consultoria_list->lStartRec-1, $responsable_consultoria_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Responsable Consultoria

</span></p>
<?php $responsable_consultoria_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
            <div>
                    <fieldset>
                        BUSCAR= <input type="text" name="search" value="" id="id_search" size="50"/>
                    </fieldset>

            </div>
<div class="ewGridMiddlePanel">
<form name="fresponsable_consultorialist" id="fresponsable_consultorialist" class="ewForm" action="" method="post">
<?php if ($responsable_consultoria_list->lTotalRecs > 0) { ?>
<table id="table_example" cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$responsable_consultoria_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$responsable_consultoria_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$responsable_consultoria_list->lOptionCnt++; // edit
}
if ($Security->CanAdd()) {
	$responsable_consultoria_list->lOptionCnt++; // copy
}
if ($Security->CanDelete()) {
	$responsable_consultoria_list->lOptionCnt++; // Delete
}
	$responsable_consultoria_list->lOptionCnt += count($responsable_consultoria_list->ListOptions->Items); // Custom list options
?>
<?php echo $responsable_consultoria->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($responsable_consultoria->idRC->Visible) { // idRC ?>
	<?php if ($responsable_consultoria->SortUrl($responsable_consultoria->idRC) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $responsable_consultoria->SortUrl($responsable_consultoria->idRC) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($responsable_consultoria->idRC->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($responsable_consultoria->idRC->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($responsable_consultoria->idUsuario->Visible) { // idUsuario ?>
	<?php if ($responsable_consultoria->SortUrl($responsable_consultoria->idUsuario) == "") { ?>
		<td>Usuario (Revisor)</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $responsable_consultoria->SortUrl($responsable_consultoria->idUsuario) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Usuario (Revisor)</td><td style="width: 10px;"><?php if ($responsable_consultoria->idUsuario->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($responsable_consultoria->idUsuario->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($responsable_consultoria->idConsultoria->Visible) { // idConsultoria ?>
	<?php if ($responsable_consultoria->SortUrl($responsable_consultoria->idConsultoria) == "") { ?>
		<td>Consultoria</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $responsable_consultoria->SortUrl($responsable_consultoria->idConsultoria) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Consultoria</td><td style="width: 10px;"><?php if ($responsable_consultoria->idConsultoria->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($responsable_consultoria->idConsultoria->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($responsable_consultoria->fecha->Visible) { // fecha ?>
	<?php if ($responsable_consultoria->SortUrl($responsable_consultoria->fecha) == "") { ?>
		<td>Fecha de Asignacion</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $responsable_consultoria->SortUrl($responsable_consultoria->fecha) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fecha de Asignacion</td><td style="width: 10px;"><?php if ($responsable_consultoria->fecha->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($responsable_consultoria->fecha->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($responsable_consultoria->Export == "") { ?>
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
foreach ($responsable_consultoria_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<tbody id="contenidoTbody">
<?php
if ($responsable_consultoria->ExportAll && $responsable_consultoria->Export <> "") {
	$responsable_consultoria_list->lStopRec = $responsable_consultoria_list->lTotalRecs;
} else {
	$responsable_consultoria_list->lStopRec = $responsable_consultoria_list->lStartRec + $responsable_consultoria_list->lDisplayRecs - 1; // Set the last record to display
}
$responsable_consultoria_list->lRecCount = $responsable_consultoria_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$responsable_consultoria->SelectLimit && $responsable_consultoria_list->lStartRec > 1)
		$rs->Move($responsable_consultoria_list->lStartRec - 1);
}
$responsable_consultoria_list->lRowCnt = 0;
while (($responsable_consultoria->CurrentAction == "gridadd" || !$rs->EOF) &&
	$responsable_consultoria_list->lRecCount < $responsable_consultoria_list->lStopRec) {
	$responsable_consultoria_list->lRecCount++;
	if (intval($responsable_consultoria_list->lRecCount) >= intval($responsable_consultoria_list->lStartRec)) {
		$responsable_consultoria_list->lRowCnt++;

	// Init row class and style
	$responsable_consultoria->CssClass = "";
	$responsable_consultoria->CssStyle = "";
	$responsable_consultoria->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($responsable_consultoria->CurrentAction == "gridadd") {
		$responsable_consultoria_list->LoadDefaultValues(); // Load default values
	} else {
		$responsable_consultoria_list->LoadRowValues($rs); // Load row values
	}
	$responsable_consultoria->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$responsable_consultoria_list->RenderRow();
?>
	<tr<?php echo $responsable_consultoria->RowAttributes() ?>>
	<?php if ($responsable_consultoria->idRC->Visible) { // idRC ?>
		<td<?php echo $responsable_consultoria->idRC->CellAttributes() ?>>
<div<?php echo $responsable_consultoria->idRC->ViewAttributes() ?>><?php echo $responsable_consultoria->idRC->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($responsable_consultoria->idUsuario->Visible) { // idUsuario ?>
		<td<?php echo $responsable_consultoria->idUsuario->CellAttributes() ?>>
<div<?php echo $responsable_consultoria->idUsuario->ViewAttributes() ?>><?php echo $responsable_consultoria->idUsuario->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($responsable_consultoria->idConsultoria->Visible) { // idConsultoria ?>
		<td<?php echo $responsable_consultoria->idConsultoria->CellAttributes() ?>>
<div<?php echo $responsable_consultoria->idConsultoria->ViewAttributes() ?>><?php echo $responsable_consultoria->idConsultoria->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($responsable_consultoria->fecha->Visible) { // fecha ?>
		<td<?php echo $responsable_consultoria->fecha->CellAttributes() ?>>
<div<?php echo $responsable_consultoria->fecha->ViewAttributes() ?>><?php echo $responsable_consultoria->fecha->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($responsable_consultoria->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $responsable_consultoria->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $responsable_consultoria->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $responsable_consultoria_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $responsable_consultoria->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($responsable_consultoria_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($responsable_consultoria->CurrentAction <> "gridadd")
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
<?php if ($responsable_consultoria->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($responsable_consultoria->CurrentAction <> "gridadd" && $responsable_consultoria->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($responsable_consultoria_list->Pager)) $responsable_consultoria_list->Pager = new cPrevNextPager($responsable_consultoria_list->lStartRec, $responsable_consultoria_list->lDisplayRecs, $responsable_consultoria_list->lTotalRecs) ?>
<?php if ($responsable_consultoria_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">P�gina&nbsp;</span></td>
<!--first page button-->
	<?php if ($responsable_consultoria_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $responsable_consultoria_list->PageUrl() ?>start=<?php echo $responsable_consultoria_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($responsable_consultoria_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $responsable_consultoria_list->PageUrl() ?>start=<?php echo $responsable_consultoria_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $responsable_consultoria_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($responsable_consultoria_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $responsable_consultoria_list->PageUrl() ?>start=<?php echo $responsable_consultoria_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($responsable_consultoria_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $responsable_consultoria_list->PageUrl() ?>start=<?php echo $responsable_consultoria_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $responsable_consultoria_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $responsable_consultoria_list->Pager->FromIndex ?> a <?php echo $responsable_consultoria_list->Pager->ToIndex ?> de <?php echo $responsable_consultoria_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($responsable_consultoria_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta p�gina</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($responsable_consultoria_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por p�gina&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="responsable_consultoria">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($responsable_consultoria_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($responsable_consultoria_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($responsable_consultoria->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($responsable_consultoria_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $responsable_consultoria->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($responsable_consultoria->Export == "" && $responsable_consultoria->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(responsable_consultoria_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($responsable_consultoria->Export == "") { ?>
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
class cresponsable_consultoria_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'responsable_consultoria';

	// Page Object Name
	var $PageObjName = 'responsable_consultoria_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $responsable_consultoria;
		if ($responsable_consultoria->UseTokenInUrl) $PageUrl .= "t=" . $responsable_consultoria->TableVar . "&"; // add page token
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
		global $objForm, $responsable_consultoria;
		if ($responsable_consultoria->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($responsable_consultoria->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($responsable_consultoria->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cresponsable_consultoria_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["responsable_consultoria"] = new cresponsable_consultoria();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'responsable_consultoria', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $responsable_consultoria;
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
	$responsable_consultoria->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $responsable_consultoria->Export; // Get export parameter, used in header
	$gsExportFile = $responsable_consultoria->TableVar; // Get export file, used in header
	if ($responsable_consultoria->Export == "print" || $responsable_consultoria->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($responsable_consultoria->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $responsable_consultoria;
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
		if ($responsable_consultoria->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $responsable_consultoria->getRecordsPerPage(); // Restore from Session
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
		$responsable_consultoria->setSessionWhere($sFilter);
		$responsable_consultoria->CurrentFilter = "";

		// Export data only
		if (in_array($responsable_consultoria->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $responsable_consultoria;
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
			$responsable_consultoria->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$responsable_consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $responsable_consultoria;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$responsable_consultoria->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$responsable_consultoria->CurrentOrderType = @$_GET["ordertype"];
			$responsable_consultoria->UpdateSort($responsable_consultoria->idRC); // Field 
			$responsable_consultoria->UpdateSort($responsable_consultoria->idUsuario); // Field 
			$responsable_consultoria->UpdateSort($responsable_consultoria->idConsultoria); // Field 
			$responsable_consultoria->UpdateSort($responsable_consultoria->fecha); // Field 
			$responsable_consultoria->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $responsable_consultoria;
		$sOrderBy = $responsable_consultoria->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($responsable_consultoria->SqlOrderBy() <> "") {
				$sOrderBy = $responsable_consultoria->SqlOrderBy();
				$responsable_consultoria->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $responsable_consultoria;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$responsable_consultoria->setSessionOrderBy($sOrderBy);
				$responsable_consultoria->idRC->setSort("");
				$responsable_consultoria->idUsuario->setSort("");
				$responsable_consultoria->idConsultoria->setSort("");
				$responsable_consultoria->fecha->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$responsable_consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $responsable_consultoria;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$responsable_consultoria->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$responsable_consultoria->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $responsable_consultoria->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$responsable_consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$responsable_consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$responsable_consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $responsable_consultoria;

		// Call Recordset Selecting event
		$responsable_consultoria->Recordset_Selecting($responsable_consultoria->CurrentFilter);

		// Load list page SQL
		$sSql = $responsable_consultoria->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$responsable_consultoria->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $responsable_consultoria;
		$sFilter = $responsable_consultoria->KeyFilter();

		// Call Row Selecting event
		$responsable_consultoria->Row_Selecting($sFilter);

		// Load sql based on filter
		$responsable_consultoria->CurrentFilter = $sFilter;
		$sSql = $responsable_consultoria->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$responsable_consultoria->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $responsable_consultoria;
		$responsable_consultoria->idRC->setDbValue($rs->fields('idRC'));
		$responsable_consultoria->idUsuario->setDbValue($rs->fields('idUsuario'));
		$responsable_consultoria->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$responsable_consultoria->fecha->setDbValue($rs->fields('fecha'));
		$responsable_consultoria->habilitado->setDbValue($rs->fields('habilitado'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $responsable_consultoria;

		// Call Row_Rendering event
		$responsable_consultoria->Row_Rendering();

		// Common render codes for all row types
		// idRC

		$responsable_consultoria->idRC->CellCssStyle = "";
		$responsable_consultoria->idRC->CellCssClass = "";

		// idUsuario
		$responsable_consultoria->idUsuario->CellCssStyle = "";
		$responsable_consultoria->idUsuario->CellCssClass = "";

		// idConsultoria
		$responsable_consultoria->idConsultoria->CellCssStyle = "";
		$responsable_consultoria->idConsultoria->CellCssClass = "";

		// fecha
		$responsable_consultoria->fecha->CellCssStyle = "";
		$responsable_consultoria->fecha->CellCssClass = "";
		if ($responsable_consultoria->RowType == EW_ROWTYPE_VIEW) { // View row

			// idRC
			$responsable_consultoria->idRC->ViewValue = $responsable_consultoria->idRC->CurrentValue;
			$responsable_consultoria->idRC->CssStyle = "";
			$responsable_consultoria->idRC->CssClass = "";
			$responsable_consultoria->idRC->ViewCustomAttributes = "";

			// idUsuario
			if (strval($responsable_consultoria->idUsuario->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `nombre`,paterno,materno  FROM `usuario` WHERE `idUsuario` = " . ew_AdjustSql($responsable_consultoria->idUsuario->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `paterno` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$responsable_consultoria->idUsuario->ViewValue = $rswrk->fields('paterno');
                                        $responsable_consultoria->idUsuario->ViewValue .= " ".$rswrk->fields('materno');
					$responsable_consultoria->idUsuario->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('nombre');
					$rswrk->Close();
				} else {
					$responsable_consultoria->idUsuario->ViewValue = $responsable_consultoria->idUsuario->CurrentValue;
				}
			} else {
				$responsable_consultoria->idUsuario->ViewValue = NULL;
			}
			$responsable_consultoria->idUsuario->CssStyle = "";
			$responsable_consultoria->idUsuario->CssClass = "";
			$responsable_consultoria->idUsuario->ViewCustomAttributes = "";

			// idConsultoria
			if (strval($responsable_consultoria->idConsultoria->CurrentValue) <> "") {
				$sSqlWrk = "SELECT a.consultoria, b.nombre, b.paterno, b.materno FROM consultoria a, usuario b WHERE a.idConsultoria = " . ew_AdjustSql($responsable_consultoria->idConsultoria->CurrentValue) . " AND a.idUsuario=b.idUsuario";
				$sSqlWrk .= " ORDER BY a.consultoria Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$responsable_consultoria->idConsultoria->ViewValue = $rswrk->fields('consultoria');
					$responsable_consultoria->idConsultoria->ViewValue .= ew_ValueSeparator(0) . " ".strtoupper($rswrk->fields('paterno'));
                                        $responsable_consultoria->idConsultoria->ViewValue .= " ".strtoupper($rswrk->fields('materno'));
                                        $responsable_consultoria->idConsultoria->ViewValue .= " ".strtoupper($rswrk->fields('nombre'));
					$rswrk->Close();
				} else {
					$responsable_consultoria->idConsultoria->ViewValue = $responsable_consultoria->idConsultoria->CurrentValue;
				}
			} else {
				$responsable_consultoria->idConsultoria->ViewValue = NULL;
			}
			$responsable_consultoria->idConsultoria->CssStyle = "";
			$responsable_consultoria->idConsultoria->CssClass = "";
			$responsable_consultoria->idConsultoria->ViewCustomAttributes = "";

			// fecha
			$responsable_consultoria->fecha->ViewValue = $responsable_consultoria->fecha->CurrentValue;
			$responsable_consultoria->fecha->ViewValue = ew_FormatDateTime($responsable_consultoria->fecha->ViewValue, 7);
			$responsable_consultoria->fecha->CssStyle = "";
			$responsable_consultoria->fecha->CssClass = "";
			$responsable_consultoria->fecha->ViewCustomAttributes = "";

			// idRC
			$responsable_consultoria->idRC->HrefValue = "";

			// idUsuario
			$responsable_consultoria->idUsuario->HrefValue = "";

			// idConsultoria
			$responsable_consultoria->idConsultoria->HrefValue = "";

			// fecha
			$responsable_consultoria->fecha->HrefValue = "";
		}

		// Call Row Rendered event
		$responsable_consultoria->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $responsable_consultoria;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($responsable_consultoria->ExportAll) {
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
		if ($responsable_consultoria->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($responsable_consultoria->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $responsable_consultoria->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idRC', $responsable_consultoria->Export);
				ew_ExportAddValue($sExportStr, 'idUsuario', $responsable_consultoria->Export);
				ew_ExportAddValue($sExportStr, 'idConsultoria', $responsable_consultoria->Export);
				ew_ExportAddValue($sExportStr, 'fecha', $responsable_consultoria->Export);
				echo ew_ExportLine($sExportStr, $responsable_consultoria->Export);
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
				$responsable_consultoria->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($responsable_consultoria->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idRC', $responsable_consultoria->idRC->CurrentValue);
					$XmlDoc->AddField('idUsuario', $responsable_consultoria->idUsuario->CurrentValue);
					$XmlDoc->AddField('idConsultoria', $responsable_consultoria->idConsultoria->CurrentValue);
					$XmlDoc->AddField('fecha', $responsable_consultoria->fecha->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $responsable_consultoria->Export <> "csv") { // Vertical format
						echo ew_ExportField('idRC', $responsable_consultoria->idRC->ExportValue($responsable_consultoria->Export, $responsable_consultoria->ExportOriginalValue), $responsable_consultoria->Export);
						echo ew_ExportField('idUsuario', $responsable_consultoria->idUsuario->ExportValue($responsable_consultoria->Export, $responsable_consultoria->ExportOriginalValue), $responsable_consultoria->Export);
						echo ew_ExportField('idConsultoria', $responsable_consultoria->idConsultoria->ExportValue($responsable_consultoria->Export, $responsable_consultoria->ExportOriginalValue), $responsable_consultoria->Export);
						echo ew_ExportField('fecha', $responsable_consultoria->fecha->ExportValue($responsable_consultoria->Export, $responsable_consultoria->ExportOriginalValue), $responsable_consultoria->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $responsable_consultoria->idRC->ExportValue($responsable_consultoria->Export, $responsable_consultoria->ExportOriginalValue), $responsable_consultoria->Export);
						ew_ExportAddValue($sExportStr, $responsable_consultoria->idUsuario->ExportValue($responsable_consultoria->Export, $responsable_consultoria->ExportOriginalValue), $responsable_consultoria->Export);
						ew_ExportAddValue($sExportStr, $responsable_consultoria->idConsultoria->ExportValue($responsable_consultoria->Export, $responsable_consultoria->ExportOriginalValue), $responsable_consultoria->Export);
						ew_ExportAddValue($sExportStr, $responsable_consultoria->fecha->ExportValue($responsable_consultoria->Export, $responsable_consultoria->ExportOriginalValue), $responsable_consultoria->Export);
						echo ew_ExportLine($sExportStr, $responsable_consultoria->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($responsable_consultoria->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($responsable_consultoria->Export);
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
