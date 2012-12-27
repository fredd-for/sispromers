<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "municipioinfo.php" ?>
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
$municipio_list = new cmunicipio_list();
$Page =& $municipio_list;

// Page init processing
$municipio_list->Page_Init();

// Page main processing
$municipio_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($municipio->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var municipio_list = new ew_Page("municipio_list");

// page properties
municipio_list.PageID = "list"; // page ID
var EW_PAGE_ID = municipio_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
municipio_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
municipio_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
municipio_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($municipio->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($municipio->Export == "" && $municipio->SelectLimit);
	if (!$bSelectLimit)
		$rs = $municipio_list->LoadRecordset();
	$municipio_list->lTotalRecs = ($bSelectLimit) ? $municipio->SelectRecordCount() : $rs->RecordCount();
	$municipio_list->lStartRec = 1;
	if ($municipio_list->lDisplayRecs <= 0) // Display all records
		$municipio_list->lDisplayRecs = $municipio_list->lTotalRecs;
	if (!($municipio->ExportAll && $municipio->Export <> ""))
		$municipio_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $municipio_list->LoadRecordset($municipio_list->lStartRec-1, $municipio_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Municipio
<?php if ($municipio->Export == "" && $municipio->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $municipio_list->PageUrl() ?>export=print">Impresi&oacute;n Amigable</a>
&nbsp;&nbsp;<a href="<?php echo $municipio_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $municipio_list->ShowMessage() ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div>
        <fieldset>
            BUSCAR= <input type="text" name="search" value="" id="id_search" size="50"/>
        </fieldset>

</div>
<div class="ewGridMiddlePanel">
<form name="fmunicipiolist" id="fmunicipiolist" class="ewForm" action="" method="post">
<?php if ($municipio_list->lTotalRecs > 0) { ?>
<table id="table_example" cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$municipio_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$municipio_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$municipio_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$municipio_list->lOptionCnt++; // Delete
}
	$municipio_list->lOptionCnt += count($municipio_list->ListOptions->Items); // Custom list options
?>
<?php echo $municipio->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($municipio->idMunicipio->Visible) { // idMunicipio ?>
	<?php if ($municipio->SortUrl($municipio->idMunicipio) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $municipio->SortUrl($municipio->idMunicipio) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($municipio->idMunicipio->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($municipio->idMunicipio->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($municipio->idRegional->Visible) { // idRegional ?>
	<?php if ($municipio->SortUrl($municipio->idRegional) == "") { ?>
		<td>Regional</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $municipio->SortUrl($municipio->idRegional) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Regional</td><td style="width: 10px;"><?php if ($municipio->idRegional->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($municipio->idRegional->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($municipio->idDepartamento->Visible) { // idDepartamento ?>
	<?php if ($municipio->SortUrl($municipio->idDepartamento) == "") { ?>
		<td>Departamento</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $municipio->SortUrl($municipio->idDepartamento) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Departamento</td><td style="width: 10px;"><?php if ($municipio->idDepartamento->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($municipio->idDepartamento->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($municipio->municipio->Visible) { // municipio ?>
	<?php if ($municipio->SortUrl($municipio->municipio) == "") { ?>
		<td>Municipio</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $municipio->SortUrl($municipio->municipio) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Municipio</td><td style="width: 10px;"><?php if ($municipio->municipio->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($municipio->municipio->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($municipio->Export == "") { ?>
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
foreach ($municipio_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<tbody id="contenidoTbody">
<?php
if ($municipio->ExportAll && $municipio->Export <> "") {
	$municipio_list->lStopRec = $municipio_list->lTotalRecs;
} else {
	$municipio_list->lStopRec = $municipio_list->lStartRec + $municipio_list->lDisplayRecs - 1; // Set the last record to display
}
$municipio_list->lRecCount = $municipio_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$municipio->SelectLimit && $municipio_list->lStartRec > 1)
		$rs->Move($municipio_list->lStartRec - 1);
}
$municipio_list->lRowCnt = 0;
while (($municipio->CurrentAction == "gridadd" || !$rs->EOF) &&
	$municipio_list->lRecCount < $municipio_list->lStopRec) {
	$municipio_list->lRecCount++;
	if (intval($municipio_list->lRecCount) >= intval($municipio_list->lStartRec)) {
		$municipio_list->lRowCnt++;

	// Init row class and style
	$municipio->CssClass = "";
	$municipio->CssStyle = "";
	$municipio->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($municipio->CurrentAction == "gridadd") {
		$municipio_list->LoadDefaultValues(); // Load default values
	} else {
		$municipio_list->LoadRowValues($rs); // Load row values
	}
	$municipio->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$municipio_list->RenderRow();
?>
	<tr<?php echo $municipio->RowAttributes() ?>>
	<?php if ($municipio->idMunicipio->Visible) { // idMunicipio ?>
		<td<?php echo $municipio->idMunicipio->CellAttributes() ?>>
<div<?php echo $municipio->idMunicipio->ViewAttributes() ?>><?php echo $municipio->idMunicipio->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($municipio->idRegional->Visible) { // idRegional ?>
		<td<?php echo $municipio->idRegional->CellAttributes() ?>>
<div<?php echo $municipio->idRegional->ViewAttributes() ?>><?php echo $municipio->idRegional->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($municipio->idDepartamento->Visible) { // idDepartamento ?>
		<td<?php echo $municipio->idDepartamento->CellAttributes() ?>>
<div<?php echo $municipio->idDepartamento->ViewAttributes() ?>><?php echo $municipio->idDepartamento->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($municipio->municipio->Visible) { // municipio ?>
		<td<?php echo $municipio->municipio->CellAttributes() ?>>
<div<?php echo $municipio->municipio->ViewAttributes() ?>><?php echo $municipio->municipio->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($municipio->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $municipio->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $municipio->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $municipio_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $municipio->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($municipio_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($municipio->CurrentAction <> "gridadd")
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
<?php if ($municipio->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($municipio->CurrentAction <> "gridadd" && $municipio->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($municipio_list->Pager)) $municipio_list->Pager = new cPrevNextPager($municipio_list->lStartRec, $municipio_list->lDisplayRecs, $municipio_list->lTotalRecs) ?>
<?php if ($municipio_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">P&aacute;gina&nbsp;</span></td>
<!--first page button-->
	<?php if ($municipio_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $municipio_list->PageUrl() ?>start=<?php echo $municipio_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($municipio_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $municipio_list->PageUrl() ?>start=<?php echo $municipio_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $municipio_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($municipio_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $municipio_list->PageUrl() ?>start=<?php echo $municipio_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($municipio_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $municipio_list->PageUrl() ?>start=<?php echo $municipio_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $municipio_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $municipio_list->Pager->FromIndex ?> a <?php echo $municipio_list->Pager->ToIndex ?> de <?php echo $municipio_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($municipio_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta P&aacute;gina</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($municipio_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por P&aacute;gina&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="municipio">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($municipio_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($municipio_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($municipio->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($municipio_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $municipio->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($municipio->Export == "" && $municipio->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(municipio_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($municipio->Export == "") { ?>
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
class cmunicipio_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'municipio';

	// Page Object Name
	var $PageObjName = 'municipio_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $municipio;
		if ($municipio->UseTokenInUrl) $PageUrl .= "t=" . $municipio->TableVar . "&"; // add page token
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
		global $objForm, $municipio;
		if ($municipio->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($municipio->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($municipio->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cmunicipio_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["municipio"] = new cmunicipio();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'municipio', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $municipio;
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
	$municipio->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $municipio->Export; // Get export parameter, used in header
	$gsExportFile = $municipio->TableVar; // Get export file, used in header
	if ($municipio->Export == "print" || $municipio->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($municipio->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $municipio;
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
		if ($municipio->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $municipio->getRecordsPerPage(); // Restore from Session
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
		$municipio->setSessionWhere($sFilter);
		$municipio->CurrentFilter = "";

		// Export data only
		if (in_array($municipio->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $municipio;
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
			$municipio->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$municipio->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $municipio;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$municipio->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$municipio->CurrentOrderType = @$_GET["ordertype"];
			$municipio->UpdateSort($municipio->idMunicipio); // Field 
			$municipio->UpdateSort($municipio->idRegional); // Field 
			$municipio->UpdateSort($municipio->idDepartamento); // Field 
			$municipio->UpdateSort($municipio->municipio); // Field 
			$municipio->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $municipio;
		$sOrderBy = $municipio->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($municipio->SqlOrderBy() <> "") {
				$sOrderBy = $municipio->SqlOrderBy();
				$municipio->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $municipio;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$municipio->setSessionOrderBy($sOrderBy);
				$municipio->idMunicipio->setSort("");
				$municipio->idRegional->setSort("");
				$municipio->idDepartamento->setSort("");
				$municipio->municipio->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$municipio->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $municipio;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$municipio->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$municipio->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $municipio->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$municipio->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$municipio->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$municipio->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $municipio;

		// Call Recordset Selecting event
		$municipio->Recordset_Selecting($municipio->CurrentFilter);

		// Load list page SQL
		$sSql = $municipio->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$municipio->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $municipio;
		$sFilter = $municipio->KeyFilter();

		// Call Row Selecting event
		$municipio->Row_Selecting($sFilter);

		// Load sql based on filter
		$municipio->CurrentFilter = $sFilter;
		$sSql = $municipio->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$municipio->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $municipio;
		$municipio->idMunicipio->setDbValue($rs->fields('idMunicipio'));
		$municipio->idRegional->setDbValue($rs->fields('idRegional'));
		$municipio->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$municipio->municipio->setDbValue($rs->fields('municipio'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $municipio;

		// Call Row_Rendering event
		$municipio->Row_Rendering();

		// Common render codes for all row types
		// idMunicipio

		$municipio->idMunicipio->CellCssStyle = "";
		$municipio->idMunicipio->CellCssClass = "";

		// idRegional
		$municipio->idRegional->CellCssStyle = "";
		$municipio->idRegional->CellCssClass = "";

		// idDepartamento
		$municipio->idDepartamento->CellCssStyle = "";
		$municipio->idDepartamento->CellCssClass = "";

		// municipio
		$municipio->municipio->CellCssStyle = "";
		$municipio->municipio->CellCssClass = "";
		if ($municipio->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMunicipio
			$municipio->idMunicipio->ViewValue = $municipio->idMunicipio->CurrentValue;
			$municipio->idMunicipio->CssStyle = "";
			$municipio->idMunicipio->CssClass = "";
			$municipio->idMunicipio->ViewCustomAttributes = "";

			// idRegional
			if (strval($municipio->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($municipio->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$municipio->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$municipio->idRegional->ViewValue = $municipio->idRegional->CurrentValue;
				}
			} else {
				$municipio->idRegional->ViewValue = NULL;
			}
			$municipio->idRegional->CssStyle = "";
			$municipio->idRegional->CssClass = "";
			$municipio->idRegional->ViewCustomAttributes = "";

			// idDepartamento
			if (strval($municipio->idDepartamento->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `departamento` FROM `departamento` WHERE `idDepartamento` = " . ew_AdjustSql($municipio->idDepartamento->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `departamento` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$municipio->idDepartamento->ViewValue = $rswrk->fields('departamento');
					$rswrk->Close();
				} else {
					$municipio->idDepartamento->ViewValue = $municipio->idDepartamento->CurrentValue;
				}
			} else {
				$municipio->idDepartamento->ViewValue = NULL;
			}
			$municipio->idDepartamento->CssStyle = "";
			$municipio->idDepartamento->CssClass = "";
			$municipio->idDepartamento->ViewCustomAttributes = "";

			// municipio
			$municipio->municipio->ViewValue = $municipio->municipio->CurrentValue;
			$municipio->municipio->CssStyle = "";
			$municipio->municipio->CssClass = "";
			$municipio->municipio->ViewCustomAttributes = "";

			// idMunicipio
			$municipio->idMunicipio->HrefValue = "";

			// idRegional
			$municipio->idRegional->HrefValue = "";

			// idDepartamento
			$municipio->idDepartamento->HrefValue = "";

			// municipio
			$municipio->municipio->HrefValue = "";
		}

		// Call Row Rendered event
		$municipio->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $municipio;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($municipio->ExportAll) {
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
		if ($municipio->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($municipio->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $municipio->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idMunicipio', $municipio->Export);
				ew_ExportAddValue($sExportStr, 'idRegional', $municipio->Export);
				ew_ExportAddValue($sExportStr, 'idDepartamento', $municipio->Export);
				ew_ExportAddValue($sExportStr, 'municipio', $municipio->Export);
				echo ew_ExportLine($sExportStr, $municipio->Export);
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
				$municipio->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($municipio->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idMunicipio', $municipio->idMunicipio->CurrentValue);
					$XmlDoc->AddField('idRegional', $municipio->idRegional->CurrentValue);
					$XmlDoc->AddField('idDepartamento', $municipio->idDepartamento->CurrentValue);
					$XmlDoc->AddField('municipio', $municipio->municipio->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $municipio->Export <> "csv") { // Vertical format
						echo ew_ExportField('idMunicipio', $municipio->idMunicipio->ExportValue($municipio->Export, $municipio->ExportOriginalValue), $municipio->Export);
						echo ew_ExportField('idRegional', $municipio->idRegional->ExportValue($municipio->Export, $municipio->ExportOriginalValue), $municipio->Export);
						echo ew_ExportField('idDepartamento', $municipio->idDepartamento->ExportValue($municipio->Export, $municipio->ExportOriginalValue), $municipio->Export);
						echo ew_ExportField('municipio', $municipio->municipio->ExportValue($municipio->Export, $municipio->ExportOriginalValue), $municipio->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $municipio->idMunicipio->ExportValue($municipio->Export, $municipio->ExportOriginalValue), $municipio->Export);
						ew_ExportAddValue($sExportStr, $municipio->idRegional->ExportValue($municipio->Export, $municipio->ExportOriginalValue), $municipio->Export);
						ew_ExportAddValue($sExportStr, $municipio->idDepartamento->ExportValue($municipio->Export, $municipio->ExportOriginalValue), $municipio->Export);
						ew_ExportAddValue($sExportStr, $municipio->municipio->ExportValue($municipio->Export, $municipio->ExportOriginalValue), $municipio->Export);
						echo ew_ExportLine($sExportStr, $municipio->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($municipio->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($municipio->Export);
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
