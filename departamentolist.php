<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "departamentoinfo.php" ?>
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
$departamento_list = new cdepartamento_list();
$Page =& $departamento_list;

// Page init processing
$departamento_list->Page_Init();

// Page main processing
$departamento_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($departamento->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var departamento_list = new ew_Page("departamento_list");

// page properties
departamento_list.PageID = "list"; // page ID
var EW_PAGE_ID = departamento_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
departamento_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
departamento_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
departamento_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($departamento->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($departamento->Export == "" && $departamento->SelectLimit);
	if (!$bSelectLimit)
		$rs = $departamento_list->LoadRecordset();
	$departamento_list->lTotalRecs = ($bSelectLimit) ? $departamento->SelectRecordCount() : $rs->RecordCount();
	$departamento_list->lStartRec = 1;
	if ($departamento_list->lDisplayRecs <= 0) // Display all records
		$departamento_list->lDisplayRecs = $departamento_list->lTotalRecs;
	if (!($departamento->ExportAll && $departamento->Export <> ""))
		$departamento_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $departamento_list->LoadRecordset($departamento_list->lStartRec-1, $departamento_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Departamento
<?php if ($departamento->Export == "" && $departamento->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $departamento_list->PageUrl() ?>export=print">Impresi&oacute;n Amigable</a>
&nbsp;&nbsp;<a href="<?php echo $departamento_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $departamento_list->ShowMessage() ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div>
        <fieldset>
            BUSCAR= <input type="text" name="search" value="" id="id_search" size="50"/>
        </fieldset>

</div>
<div class="ewGridMiddlePanel">
<form name="fdepartamentolist" id="fdepartamentolist" class="ewForm" action="" method="post">
<?php if ($departamento_list->lTotalRecs > 0) { ?>
<table id="table_example" cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$departamento_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$departamento_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$departamento_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$departamento_list->lOptionCnt++; // Delete
}
	$departamento_list->lOptionCnt += count($departamento_list->ListOptions->Items); // Custom list options
?>
<?php echo $departamento->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($departamento->idDepartamento->Visible) { // idDepartamento ?>
	<?php if ($departamento->SortUrl($departamento->idDepartamento) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $departamento->SortUrl($departamento->idDepartamento) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($departamento->idDepartamento->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($departamento->idDepartamento->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($departamento->idRegional->Visible) { // idRegional ?>
	<?php if ($departamento->SortUrl($departamento->idRegional) == "") { ?>
		<td>Regional</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $departamento->SortUrl($departamento->idRegional) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Regional</td><td style="width: 10px;"><?php if ($departamento->idRegional->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($departamento->idRegional->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($departamento->departamento->Visible) { // departamento ?>
	<?php if ($departamento->SortUrl($departamento->departamento) == "") { ?>
		<td>Departamento</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $departamento->SortUrl($departamento->departamento) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Departamento</td><td style="width: 10px;"><?php if ($departamento->departamento->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($departamento->departamento->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($departamento->Export == "") { ?>
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
foreach ($departamento_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<tbody id="contenidoTbody">
<?php
if ($departamento->ExportAll && $departamento->Export <> "") {
	$departamento_list->lStopRec = $departamento_list->lTotalRecs;
} else {
	$departamento_list->lStopRec = $departamento_list->lStartRec + $departamento_list->lDisplayRecs - 1; // Set the last record to display
}
$departamento_list->lRecCount = $departamento_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$departamento->SelectLimit && $departamento_list->lStartRec > 1)
		$rs->Move($departamento_list->lStartRec - 1);
}
$departamento_list->lRowCnt = 0;
while (($departamento->CurrentAction == "gridadd" || !$rs->EOF) &&
	$departamento_list->lRecCount < $departamento_list->lStopRec) {
	$departamento_list->lRecCount++;
	if (intval($departamento_list->lRecCount) >= intval($departamento_list->lStartRec)) {
		$departamento_list->lRowCnt++;

	// Init row class and style
	$departamento->CssClass = "";
	$departamento->CssStyle = "";
	$departamento->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($departamento->CurrentAction == "gridadd") {
		$departamento_list->LoadDefaultValues(); // Load default values
	} else {
		$departamento_list->LoadRowValues($rs); // Load row values
	}
	$departamento->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$departamento_list->RenderRow();
?>
	<tr<?php echo $departamento->RowAttributes() ?>>
	<?php if ($departamento->idDepartamento->Visible) { // idDepartamento ?>
		<td<?php echo $departamento->idDepartamento->CellAttributes() ?>>
<div<?php echo $departamento->idDepartamento->ViewAttributes() ?>><?php echo $departamento->idDepartamento->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($departamento->idRegional->Visible) { // idRegional ?>
		<td<?php echo $departamento->idRegional->CellAttributes() ?>>
<div<?php echo $departamento->idRegional->ViewAttributes() ?>><?php echo $departamento->idRegional->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($departamento->departamento->Visible) { // departamento ?>
		<td<?php echo $departamento->departamento->CellAttributes() ?>>
<div<?php echo $departamento->departamento->ViewAttributes() ?>><?php echo $departamento->departamento->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($departamento->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $departamento->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $departamento->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $departamento_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $departamento->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($departamento_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($departamento->CurrentAction <> "gridadd")
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
<?php if ($departamento->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($departamento->CurrentAction <> "gridadd" && $departamento->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($departamento_list->Pager)) $departamento_list->Pager = new cPrevNextPager($departamento_list->lStartRec, $departamento_list->lDisplayRecs, $departamento_list->lTotalRecs) ?>
<?php if ($departamento_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">P&aacute;gina&nbsp;</span></td>
<!--first page button-->
	<?php if ($departamento_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $departamento_list->PageUrl() ?>start=<?php echo $departamento_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($departamento_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $departamento_list->PageUrl() ?>start=<?php echo $departamento_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $departamento_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($departamento_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $departamento_list->PageUrl() ?>start=<?php echo $departamento_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($departamento_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $departamento_list->PageUrl() ?>start=<?php echo $departamento_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $departamento_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $departamento_list->Pager->FromIndex ?> a <?php echo $departamento_list->Pager->ToIndex ?> de <?php echo $departamento_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($departamento_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta P&aacute;gina</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($departamento_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por P&aacute;gina&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="departamento">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($departamento_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($departamento_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($departamento->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($departamento_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $departamento->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($departamento->Export == "" && $departamento->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(departamento_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($departamento->Export == "") { ?>
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
class cdepartamento_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'departamento';

	// Page Object Name
	var $PageObjName = 'departamento_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $departamento;
		if ($departamento->UseTokenInUrl) $PageUrl .= "t=" . $departamento->TableVar . "&"; // add page token
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
		global $objForm, $departamento;
		if ($departamento->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($departamento->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($departamento->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cdepartamento_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["departamento"] = new cdepartamento();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'departamento', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $departamento;
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
	$departamento->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $departamento->Export; // Get export parameter, used in header
	$gsExportFile = $departamento->TableVar; // Get export file, used in header
	if ($departamento->Export == "print" || $departamento->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($departamento->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $departamento;
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
		if ($departamento->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $departamento->getRecordsPerPage(); // Restore from Session
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
		$departamento->setSessionWhere($sFilter);
		$departamento->CurrentFilter = "";

		// Export data only
		if (in_array($departamento->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $departamento;
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
			$departamento->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$departamento->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $departamento;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$departamento->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$departamento->CurrentOrderType = @$_GET["ordertype"];
			$departamento->UpdateSort($departamento->idDepartamento); // Field 
			$departamento->UpdateSort($departamento->idRegional); // Field 
			$departamento->UpdateSort($departamento->departamento); // Field 
			$departamento->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $departamento;
		$sOrderBy = $departamento->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($departamento->SqlOrderBy() <> "") {
				$sOrderBy = $departamento->SqlOrderBy();
				$departamento->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $departamento;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$departamento->setSessionOrderBy($sOrderBy);
				$departamento->idDepartamento->setSort("");
				$departamento->idRegional->setSort("");
				$departamento->departamento->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$departamento->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $departamento;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$departamento->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$departamento->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $departamento->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$departamento->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$departamento->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$departamento->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $departamento;

		// Call Recordset Selecting event
		$departamento->Recordset_Selecting($departamento->CurrentFilter);

		// Load list page SQL
		$sSql = $departamento->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$departamento->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $departamento;
		$sFilter = $departamento->KeyFilter();

		// Call Row Selecting event
		$departamento->Row_Selecting($sFilter);

		// Load sql based on filter
		$departamento->CurrentFilter = $sFilter;
		$sSql = $departamento->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$departamento->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $departamento;
		$departamento->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$departamento->idRegional->setDbValue($rs->fields('idRegional'));
		$departamento->departamento->setDbValue($rs->fields('departamento'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $departamento;

		// Call Row_Rendering event
		$departamento->Row_Rendering();

		// Common render codes for all row types
		// idDepartamento

		$departamento->idDepartamento->CellCssStyle = "";
		$departamento->idDepartamento->CellCssClass = "";

		// idRegional
		$departamento->idRegional->CellCssStyle = "";
		$departamento->idRegional->CellCssClass = "";

		// departamento
		$departamento->departamento->CellCssStyle = "";
		$departamento->departamento->CellCssClass = "";
		if ($departamento->RowType == EW_ROWTYPE_VIEW) { // View row

			// idDepartamento
			$departamento->idDepartamento->ViewValue = $departamento->idDepartamento->CurrentValue;
			$departamento->idDepartamento->CssStyle = "";
			$departamento->idDepartamento->CssClass = "";
			$departamento->idDepartamento->ViewCustomAttributes = "";

			// idRegional
			if (strval($departamento->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($departamento->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$departamento->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$departamento->idRegional->ViewValue = $departamento->idRegional->CurrentValue;
				}
			} else {
				$departamento->idRegional->ViewValue = NULL;
			}
			$departamento->idRegional->CssStyle = "";
			$departamento->idRegional->CssClass = "";
			$departamento->idRegional->ViewCustomAttributes = "";

			// departamento
			$departamento->departamento->ViewValue = $departamento->departamento->CurrentValue;
			$departamento->departamento->CssStyle = "";
			$departamento->departamento->CssClass = "";
			$departamento->departamento->ViewCustomAttributes = "";

			// idDepartamento
			$departamento->idDepartamento->HrefValue = "";

			// idRegional
			$departamento->idRegional->HrefValue = "";

			// departamento
			$departamento->departamento->HrefValue = "";
		}

		// Call Row Rendered event
		$departamento->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $departamento;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($departamento->ExportAll) {
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
		if ($departamento->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($departamento->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $departamento->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idDepartamento', $departamento->Export);
				ew_ExportAddValue($sExportStr, 'idRegional', $departamento->Export);
				ew_ExportAddValue($sExportStr, 'departamento', $departamento->Export);
				echo ew_ExportLine($sExportStr, $departamento->Export);
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
				$departamento->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($departamento->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idDepartamento', $departamento->idDepartamento->CurrentValue);
					$XmlDoc->AddField('idRegional', $departamento->idRegional->CurrentValue);
					$XmlDoc->AddField('departamento', $departamento->departamento->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $departamento->Export <> "csv") { // Vertical format
						echo ew_ExportField('idDepartamento', $departamento->idDepartamento->ExportValue($departamento->Export, $departamento->ExportOriginalValue), $departamento->Export);
						echo ew_ExportField('idRegional', $departamento->idRegional->ExportValue($departamento->Export, $departamento->ExportOriginalValue), $departamento->Export);
						echo ew_ExportField('departamento', $departamento->departamento->ExportValue($departamento->Export, $departamento->ExportOriginalValue), $departamento->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $departamento->idDepartamento->ExportValue($departamento->Export, $departamento->ExportOriginalValue), $departamento->Export);
						ew_ExportAddValue($sExportStr, $departamento->idRegional->ExportValue($departamento->Export, $departamento->ExportOriginalValue), $departamento->Export);
						ew_ExportAddValue($sExportStr, $departamento->departamento->ExportValue($departamento->Export, $departamento->ExportOriginalValue), $departamento->Export);
						echo ew_ExportLine($sExportStr, $departamento->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($departamento->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($departamento->Export);
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
