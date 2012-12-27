<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "comunidadinfo.php" ?>
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
$comunidad_list = new ccomunidad_list();
$Page =& $comunidad_list;

// Page init processing
$comunidad_list->Page_Init();

// Page main processing
$comunidad_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($comunidad->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var comunidad_list = new ew_Page("comunidad_list");

// page properties
comunidad_list.PageID = "list"; // page ID
var EW_PAGE_ID = comunidad_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
comunidad_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
comunidad_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
comunidad_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($comunidad->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($comunidad->Export == "" && $comunidad->SelectLimit);
	if (!$bSelectLimit)
		$rs = $comunidad_list->LoadRecordset();
	$comunidad_list->lTotalRecs = ($bSelectLimit) ? $comunidad->SelectRecordCount() : $rs->RecordCount();
	$comunidad_list->lStartRec = 1;
	if ($comunidad_list->lDisplayRecs <= 0) // Display all records
		$comunidad_list->lDisplayRecs = $comunidad_list->lTotalRecs;
	if (!($comunidad->ExportAll && $comunidad->Export <> ""))
		$comunidad_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $comunidad_list->LoadRecordset($comunidad_list->lStartRec-1, $comunidad_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Comunidad
<?php if ($comunidad->Export == "" && $comunidad->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $comunidad_list->PageUrl() ?>export=print">Impresi&oacute;n Amigable</a>
&nbsp;&nbsp;<a href="<?php echo $comunidad_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $comunidad_list->ShowMessage() ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div>
        <fieldset>
            BUSCAR= <input type="text" name="search" value="" id="id_search" size="50"/>
        </fieldset>
    
</div>
<div class="ewGridMiddlePanel">
<form name="fcomunidadlist" id="fcomunidadlist" class="ewForm" action="" method="post">
<?php if ($comunidad_list->lTotalRecs > 0) { ?>
<table id="table_example" cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$comunidad_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$comunidad_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$comunidad_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$comunidad_list->lOptionCnt++; // Delete
}
	$comunidad_list->lOptionCnt += count($comunidad_list->ListOptions->Items); // Custom list options
?>
<?php echo $comunidad->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($comunidad->idComunidad->Visible) { // idComunidad ?>
	<?php if ($comunidad->SortUrl($comunidad->idComunidad) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $comunidad->SortUrl($comunidad->idComunidad) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($comunidad->idComunidad->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($comunidad->idComunidad->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($comunidad->idRegional->Visible) { // idRegional ?>
	<?php if ($comunidad->SortUrl($comunidad->idRegional) == "") { ?>
		<td>Regional</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $comunidad->SortUrl($comunidad->idRegional) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Regional</td><td style="width: 10px;"><?php if ($comunidad->idRegional->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($comunidad->idRegional->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($comunidad->idDepartamento->Visible) { // idDepartamento ?>
	<?php if ($comunidad->SortUrl($comunidad->idDepartamento) == "") { ?>
		<td>Departamento</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $comunidad->SortUrl($comunidad->idDepartamento) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Departamento</td><td style="width: 10px;"><?php if ($comunidad->idDepartamento->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($comunidad->idDepartamento->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($comunidad->idMunicipio->Visible) { // idMunicipio ?>
	<?php if ($comunidad->SortUrl($comunidad->idMunicipio) == "") { ?>
		<td>Municipio</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $comunidad->SortUrl($comunidad->idMunicipio) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Municipio</td><td style="width: 10px;"><?php if ($comunidad->idMunicipio->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($comunidad->idMunicipio->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($comunidad->comunidad->Visible) { // comunidad ?>
	<?php if ($comunidad->SortUrl($comunidad->comunidad) == "") { ?>
		<td>Comunidad</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $comunidad->SortUrl($comunidad->comunidad) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Comunidad&nbsp;(*)</td><td style="width: 10px;"><?php if ($comunidad->comunidad->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($comunidad->comunidad->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($comunidad->Export == "") { ?>
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
foreach ($comunidad_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<tbody id="contenidoTbody">
<?php
if ($comunidad->ExportAll && $comunidad->Export <> "") {
	$comunidad_list->lStopRec = $comunidad_list->lTotalRecs;
} else {
	$comunidad_list->lStopRec = $comunidad_list->lStartRec + $comunidad_list->lDisplayRecs - 1; // Set the last record to display
}
$comunidad_list->lRecCount = $comunidad_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$comunidad->SelectLimit && $comunidad_list->lStartRec > 1)
		$rs->Move($comunidad_list->lStartRec - 1);
}
$comunidad_list->lRowCnt = 0;
while (($comunidad->CurrentAction == "gridadd" || !$rs->EOF) &&
	$comunidad_list->lRecCount < $comunidad_list->lStopRec) {
	$comunidad_list->lRecCount++;
	if (intval($comunidad_list->lRecCount) >= intval($comunidad_list->lStartRec)) {
		$comunidad_list->lRowCnt++;

	// Init row class and style
	$comunidad->CssClass = "";
	$comunidad->CssStyle = "";
	$comunidad->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($comunidad->CurrentAction == "gridadd") {
		$comunidad_list->LoadDefaultValues(); // Load default values
	} else {
		$comunidad_list->LoadRowValues($rs); // Load row values
	}
	$comunidad->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$comunidad_list->RenderRow();
?>
	<tr<?php echo $comunidad->RowAttributes() ?>>
	<?php if ($comunidad->idComunidad->Visible) { // idComunidad ?>
		<td<?php echo $comunidad->idComunidad->CellAttributes() ?>>
<div<?php echo $comunidad->idComunidad->ViewAttributes() ?>><?php echo $comunidad->idComunidad->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($comunidad->idRegional->Visible) { // idRegional ?>
		<td<?php echo $comunidad->idRegional->CellAttributes() ?>>
<div<?php echo $comunidad->idRegional->ViewAttributes() ?>><?php echo $comunidad->idRegional->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($comunidad->idDepartamento->Visible) { // idDepartamento ?>
		<td<?php echo $comunidad->idDepartamento->CellAttributes() ?>>
<div<?php echo $comunidad->idDepartamento->ViewAttributes() ?>><?php echo $comunidad->idDepartamento->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($comunidad->idMunicipio->Visible) { // idMunicipio ?>
		<td<?php echo $comunidad->idMunicipio->CellAttributes() ?>>
<div<?php echo $comunidad->idMunicipio->ViewAttributes() ?>><?php echo $comunidad->idMunicipio->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($comunidad->comunidad->Visible) { // comunidad ?>
		<td<?php echo $comunidad->comunidad->CellAttributes() ?>>
<div<?php echo $comunidad->comunidad->ViewAttributes() ?>><?php echo $comunidad->comunidad->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($comunidad->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $comunidad->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $comunidad->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $comunidad_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $comunidad->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($comunidad_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($comunidad->CurrentAction <> "gridadd")
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
<?php if ($comunidad->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($comunidad->CurrentAction <> "gridadd" && $comunidad->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($comunidad_list->Pager)) $comunidad_list->Pager = new cPrevNextPager($comunidad_list->lStartRec, $comunidad_list->lDisplayRecs, $comunidad_list->lTotalRecs) ?>
<?php if ($comunidad_list->Pager->RecordCount > 0) { ?>
                    <table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">P&aacute;gina&nbsp;</span></td>
<!--first page button-->
	<?php if ($comunidad_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $comunidad_list->PageUrl() ?>start=<?php echo $comunidad_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($comunidad_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $comunidad_list->PageUrl() ?>start=<?php echo $comunidad_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $comunidad_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($comunidad_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $comunidad_list->PageUrl() ?>start=<?php echo $comunidad_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($comunidad_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $comunidad_list->PageUrl() ?>start=<?php echo $comunidad_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $comunidad_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $comunidad_list->Pager->FromIndex ?> a <?php echo $comunidad_list->Pager->ToIndex ?> de <?php echo $comunidad_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($comunidad_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta P&aacute;gina</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($comunidad_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por P&aacute;gina&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="comunidad">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($comunidad_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($comunidad_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($comunidad->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($comunidad_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $comunidad->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($comunidad->Export == "" && $comunidad->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(comunidad_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($comunidad->Export == "") { ?>
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
class ccomunidad_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'comunidad';

	// Page Object Name
	var $PageObjName = 'comunidad_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $comunidad;
		if ($comunidad->UseTokenInUrl) $PageUrl .= "t=" . $comunidad->TableVar . "&"; // add page token
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
		global $objForm, $comunidad;
		if ($comunidad->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($comunidad->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($comunidad->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccomunidad_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["comunidad"] = new ccomunidad();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'comunidad', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $comunidad;
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
	$comunidad->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $comunidad->Export; // Get export parameter, used in header
	$gsExportFile = $comunidad->TableVar; // Get export file, used in header
	if ($comunidad->Export == "print" || $comunidad->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($comunidad->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $comunidad;
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
		if ($comunidad->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $comunidad->getRecordsPerPage(); // Restore from Session
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
		$comunidad->setSessionWhere($sFilter);
		$comunidad->CurrentFilter = "";

		// Export data only
		if (in_array($comunidad->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $comunidad;
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
			$comunidad->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$comunidad->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $comunidad;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$comunidad->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$comunidad->CurrentOrderType = @$_GET["ordertype"];
			$comunidad->UpdateSort($comunidad->idComunidad); // Field 
			$comunidad->UpdateSort($comunidad->idRegional); // Field 
			$comunidad->UpdateSort($comunidad->idDepartamento); // Field 
			$comunidad->UpdateSort($comunidad->idMunicipio); // Field 
			$comunidad->UpdateSort($comunidad->comunidad); // Field 
			$comunidad->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $comunidad;
		$sOrderBy = $comunidad->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($comunidad->SqlOrderBy() <> "") {
				$sOrderBy = $comunidad->SqlOrderBy();
				$comunidad->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $comunidad;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$comunidad->setSessionOrderBy($sOrderBy);
				$comunidad->idComunidad->setSort("");
				$comunidad->idRegional->setSort("");
				$comunidad->idDepartamento->setSort("");
				$comunidad->idMunicipio->setSort("");
				$comunidad->comunidad->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$comunidad->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $comunidad;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$comunidad->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$comunidad->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $comunidad->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$comunidad->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$comunidad->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$comunidad->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $comunidad;

		// Call Recordset Selecting event
		$comunidad->Recordset_Selecting($comunidad->CurrentFilter);

		// Load list page SQL
		$sSql = $comunidad->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$comunidad->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $comunidad;
		$sFilter = $comunidad->KeyFilter();

		// Call Row Selecting event
		$comunidad->Row_Selecting($sFilter);

		// Load sql based on filter
		$comunidad->CurrentFilter = $sFilter;
		$sSql = $comunidad->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$comunidad->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $comunidad;
		$comunidad->idComunidad->setDbValue($rs->fields('idComunidad'));
		$comunidad->idRegional->setDbValue($rs->fields('idRegional'));
		$comunidad->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$comunidad->idMunicipio->setDbValue($rs->fields('idMunicipio'));
		$comunidad->comunidad->setDbValue($rs->fields('comunidad'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $comunidad;

		// Call Row_Rendering event
		$comunidad->Row_Rendering();

		// Common render codes for all row types
		// idComunidad

		$comunidad->idComunidad->CellCssStyle = "";
		$comunidad->idComunidad->CellCssClass = "";

		// idRegional
		$comunidad->idRegional->CellCssStyle = "";
		$comunidad->idRegional->CellCssClass = "";

		// idDepartamento
		$comunidad->idDepartamento->CellCssStyle = "";
		$comunidad->idDepartamento->CellCssClass = "";

		// idMunicipio
		$comunidad->idMunicipio->CellCssStyle = "";
		$comunidad->idMunicipio->CellCssClass = "";

		// comunidad
		$comunidad->comunidad->CellCssStyle = "";
		$comunidad->comunidad->CellCssClass = "";
		if ($comunidad->RowType == EW_ROWTYPE_VIEW) { // View row

			// idComunidad
			$comunidad->idComunidad->ViewValue = $comunidad->idComunidad->CurrentValue;
			$comunidad->idComunidad->CssStyle = "";
			$comunidad->idComunidad->CssClass = "";
			$comunidad->idComunidad->ViewCustomAttributes = "";

			// idRegional
			if (strval($comunidad->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($comunidad->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$comunidad->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$comunidad->idRegional->ViewValue = $comunidad->idRegional->CurrentValue;
				}
			} else {
				$comunidad->idRegional->ViewValue = NULL;
			}
			$comunidad->idRegional->CssStyle = "";
			$comunidad->idRegional->CssClass = "";
			$comunidad->idRegional->ViewCustomAttributes = "";

			// idDepartamento
			if (strval($comunidad->idDepartamento->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `departamento` FROM `departamento` WHERE `idDepartamento` = " . ew_AdjustSql($comunidad->idDepartamento->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `departamento` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$comunidad->idDepartamento->ViewValue = $rswrk->fields('departamento');
					$rswrk->Close();
				} else {
					$comunidad->idDepartamento->ViewValue = $comunidad->idDepartamento->CurrentValue;
				}
			} else {
				$comunidad->idDepartamento->ViewValue = NULL;
			}
			$comunidad->idDepartamento->CssStyle = "";
			$comunidad->idDepartamento->CssClass = "";
			$comunidad->idDepartamento->ViewCustomAttributes = "";

			// idMunicipio
			if (strval($comunidad->idMunicipio->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `municipio` FROM `municipio` WHERE `idMunicipio` = " . ew_AdjustSql($comunidad->idMunicipio->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `municipio` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$comunidad->idMunicipio->ViewValue = $rswrk->fields('municipio');
					$rswrk->Close();
				} else {
					$comunidad->idMunicipio->ViewValue = $comunidad->idMunicipio->CurrentValue;
				}
			} else {
				$comunidad->idMunicipio->ViewValue = NULL;
			}
			$comunidad->idMunicipio->CssStyle = "";
			$comunidad->idMunicipio->CssClass = "";
			$comunidad->idMunicipio->ViewCustomAttributes = "";

			// comunidad
			$comunidad->comunidad->ViewValue = $comunidad->comunidad->CurrentValue;
			$comunidad->comunidad->CssStyle = "";
			$comunidad->comunidad->CssClass = "";
			$comunidad->comunidad->ViewCustomAttributes = "";

			// idComunidad
			$comunidad->idComunidad->HrefValue = "";

			// idRegional
			$comunidad->idRegional->HrefValue = "";

			// idDepartamento
			$comunidad->idDepartamento->HrefValue = "";

			// idMunicipio
			$comunidad->idMunicipio->HrefValue = "";

			// comunidad
			$comunidad->comunidad->HrefValue = "";
		}

		// Call Row Rendered event
		$comunidad->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $comunidad;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($comunidad->ExportAll) {
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
		if ($comunidad->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($comunidad->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $comunidad->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idComunidad', $comunidad->Export);
				ew_ExportAddValue($sExportStr, 'idRegional', $comunidad->Export);
				ew_ExportAddValue($sExportStr, 'idDepartamento', $comunidad->Export);
				ew_ExportAddValue($sExportStr, 'idMunicipio', $comunidad->Export);
				ew_ExportAddValue($sExportStr, 'comunidad', $comunidad->Export);
				echo ew_ExportLine($sExportStr, $comunidad->Export);
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
				$comunidad->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($comunidad->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idComunidad', $comunidad->idComunidad->CurrentValue);
					$XmlDoc->AddField('idRegional', $comunidad->idRegional->CurrentValue);
					$XmlDoc->AddField('idDepartamento', $comunidad->idDepartamento->CurrentValue);
					$XmlDoc->AddField('idMunicipio', $comunidad->idMunicipio->CurrentValue);
					$XmlDoc->AddField('comunidad', $comunidad->comunidad->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $comunidad->Export <> "csv") { // Vertical format
						echo ew_ExportField('idComunidad', $comunidad->idComunidad->ExportValue($comunidad->Export, $comunidad->ExportOriginalValue), $comunidad->Export);
						echo ew_ExportField('idRegional', $comunidad->idRegional->ExportValue($comunidad->Export, $comunidad->ExportOriginalValue), $comunidad->Export);
						echo ew_ExportField('idDepartamento', $comunidad->idDepartamento->ExportValue($comunidad->Export, $comunidad->ExportOriginalValue), $comunidad->Export);
						echo ew_ExportField('idMunicipio', $comunidad->idMunicipio->ExportValue($comunidad->Export, $comunidad->ExportOriginalValue), $comunidad->Export);
						echo ew_ExportField('comunidad', $comunidad->comunidad->ExportValue($comunidad->Export, $comunidad->ExportOriginalValue), $comunidad->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $comunidad->idComunidad->ExportValue($comunidad->Export, $comunidad->ExportOriginalValue), $comunidad->Export);
						ew_ExportAddValue($sExportStr, $comunidad->idRegional->ExportValue($comunidad->Export, $comunidad->ExportOriginalValue), $comunidad->Export);
						ew_ExportAddValue($sExportStr, $comunidad->idDepartamento->ExportValue($comunidad->Export, $comunidad->ExportOriginalValue), $comunidad->Export);
						ew_ExportAddValue($sExportStr, $comunidad->idMunicipio->ExportValue($comunidad->Export, $comunidad->ExportOriginalValue), $comunidad->Export);
						ew_ExportAddValue($sExportStr, $comunidad->comunidad->ExportValue($comunidad->Export, $comunidad->ExportOriginalValue), $comunidad->Export);
						echo ew_ExportLine($sExportStr, $comunidad->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($comunidad->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($comunidad->Export);
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
