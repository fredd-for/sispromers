<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "rubroinfo.php" ?>
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
$rubro_list = new crubro_list();
$Page =& $rubro_list;

// Page init processing
$rubro_list->Page_Init();

// Page main processing
$rubro_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($rubro->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var rubro_list = new ew_Page("rubro_list");

// page properties
rubro_list.PageID = "list"; // page ID
var EW_PAGE_ID = rubro_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
rubro_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
rubro_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
rubro_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($rubro->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($rubro->Export == "" && $rubro->SelectLimit);
	if (!$bSelectLimit)
		$rs = $rubro_list->LoadRecordset();
	$rubro_list->lTotalRecs = ($bSelectLimit) ? $rubro->SelectRecordCount() : $rs->RecordCount();
	$rubro_list->lStartRec = 1;
	if ($rubro_list->lDisplayRecs <= 0) // Display all records
		$rubro_list->lDisplayRecs = $rubro_list->lTotalRecs;
	if (!($rubro->ExportAll && $rubro->Export <> ""))
		$rubro_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $rubro_list->LoadRecordset($rubro_list->lStartRec-1, $rubro_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Rubro
<?php if ($rubro->Export == "" && $rubro->CurrentAction == "") { ?>
        &nbsp;&nbsp;<a href="<?php echo $rubro_list->PageUrl() ?>export=print">Impresi&oacute;n Amigable</a>
&nbsp;&nbsp;<a href="<?php echo $rubro_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $rubro_list->ShowMessage() ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div>
        <fieldset>
            BUSCAR= <input type="text" name="search" value="" id="id_search" size="50"/>
        </fieldset>
    </div>
<div class="ewGridMiddlePanel">
<form name="frubrolist" id="frubrolist" class="ewForm" action="" method="post">
<?php if ($rubro_list->lTotalRecs > 0) { ?>
<table id="table_example" cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$rubro_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$rubro_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$rubro_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$rubro_list->lOptionCnt++; // Delete
}
	$rubro_list->lOptionCnt += count($rubro_list->ListOptions->Items); // Custom list options
?>
<?php echo $rubro->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($rubro->idRubro->Visible) { // idRubro ?>
	<?php if ($rubro->SortUrl($rubro->idRubro) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $rubro->SortUrl($rubro->idRubro) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($rubro->idRubro->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($rubro->idRubro->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($rubro->rubro->Visible) { // rubro ?>
	<?php if ($rubro->SortUrl($rubro->rubro) == "") { ?>
		<td>Rubro</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $rubro->SortUrl($rubro->rubro) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Rubro</td><td style="width: 10px;"><?php if ($rubro->rubro->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($rubro->rubro->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($rubro->gestion2009->Visible) { // gestion2009 ?>
	<?php if ($rubro->SortUrl($rubro->gestion2009) == "") { ?>
		<td>No Mers Gestion 2009</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $rubro->SortUrl($rubro->gestion2009) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No Mers Gestion 2009</td><td style="width: 10px;"><?php if ($rubro->gestion2009->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($rubro->gestion2009->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($rubro->gestion2010->Visible) { // gestion2010 ?>
	<?php if ($rubro->SortUrl($rubro->gestion2010) == "") { ?>
		<td>No Mers Gestion 2010</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $rubro->SortUrl($rubro->gestion2010) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No Mers Gestion 2010</td><td style="width: 10px;"><?php if ($rubro->gestion2010->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($rubro->gestion2010->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($rubro->gestion2011->Visible) { // gestion2011 ?>
	<?php if ($rubro->SortUrl($rubro->gestion2011) == "") { ?>
		<td>No Mers Gestion 2011</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $rubro->SortUrl($rubro->gestion2011) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No Mers Gestion 2011</td><td style="width: 10px;"><?php if ($rubro->gestion2011->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($rubro->gestion2011->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($rubro->gestion2012->Visible) { // gestion2012 ?>
	<?php if ($rubro->SortUrl($rubro->gestion2012) == "") { ?>
		<td>No Mers Gestion 2012</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $rubro->SortUrl($rubro->gestion2012) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No Mers Gestion 2012</td><td style="width: 10px;"><?php if ($rubro->gestion2012->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($rubro->gestion2012->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($rubro->Export == "") { ?>
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
foreach ($rubro_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<tbody id="contenidoTbody">
<?php
if ($rubro->ExportAll && $rubro->Export <> "") {
	$rubro_list->lStopRec = $rubro_list->lTotalRecs;
} else {
	$rubro_list->lStopRec = $rubro_list->lStartRec + $rubro_list->lDisplayRecs - 1; // Set the last record to display
}
$rubro_list->lRecCount = $rubro_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$rubro->SelectLimit && $rubro_list->lStartRec > 1)
		$rs->Move($rubro_list->lStartRec - 1);
}
$rubro_list->lRowCnt = 0;
while (($rubro->CurrentAction == "gridadd" || !$rs->EOF) &&
	$rubro_list->lRecCount < $rubro_list->lStopRec) {
	$rubro_list->lRecCount++;
	if (intval($rubro_list->lRecCount) >= intval($rubro_list->lStartRec)) {
		$rubro_list->lRowCnt++;

	// Init row class and style
	$rubro->CssClass = "";
	$rubro->CssStyle = "";
	$rubro->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($rubro->CurrentAction == "gridadd") {
		$rubro_list->LoadDefaultValues(); // Load default values
	} else {
		$rubro_list->LoadRowValues($rs); // Load row values
	}
	$rubro->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$rubro_list->RenderRow();
?>
	<tr<?php echo $rubro->RowAttributes() ?>>
	<?php if ($rubro->idRubro->Visible) { // idRubro ?>
		<td<?php echo $rubro->idRubro->CellAttributes() ?>>
<div<?php echo $rubro->idRubro->ViewAttributes() ?>><?php echo $rubro->idRubro->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($rubro->rubro->Visible) { // rubro ?>
		<td<?php echo $rubro->rubro->CellAttributes() ?>>
<div<?php echo $rubro->rubro->ViewAttributes() ?>><?php echo $rubro->rubro->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($rubro->gestion2009->Visible) { // gestion2009 ?>
		<td<?php echo $rubro->gestion2009->CellAttributes() ?>>
<div<?php echo $rubro->gestion2009->ViewAttributes() ?>><?php echo $rubro->gestion2009->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($rubro->gestion2010->Visible) { // gestion2010 ?>
		<td<?php echo $rubro->gestion2010->CellAttributes() ?>>
<div<?php echo $rubro->gestion2010->ViewAttributes() ?>><?php echo $rubro->gestion2010->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($rubro->gestion2011->Visible) { // gestion2011 ?>
		<td<?php echo $rubro->gestion2011->CellAttributes() ?>>
<div<?php echo $rubro->gestion2011->ViewAttributes() ?>><?php echo $rubro->gestion2011->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($rubro->gestion2012->Visible) { // gestion2012 ?>
		<td<?php echo $rubro->gestion2012->CellAttributes() ?>>
<div<?php echo $rubro->gestion2012->ViewAttributes() ?>><?php echo $rubro->gestion2012->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($rubro->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $rubro->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $rubro->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $rubro_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $rubro->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($rubro_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($rubro->CurrentAction <> "gridadd")
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
<?php if ($rubro->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($rubro->CurrentAction <> "gridadd" && $rubro->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($rubro_list->Pager)) $rubro_list->Pager = new cPrevNextPager($rubro_list->lStartRec, $rubro_list->lDisplayRecs, $rubro_list->lTotalRecs) ?>
<?php if ($rubro_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">P�gina&nbsp;</span></td>
<!--first page button-->
	<?php if ($rubro_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $rubro_list->PageUrl() ?>start=<?php echo $rubro_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($rubro_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $rubro_list->PageUrl() ?>start=<?php echo $rubro_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $rubro_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($rubro_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $rubro_list->PageUrl() ?>start=<?php echo $rubro_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($rubro_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $rubro_list->PageUrl() ?>start=<?php echo $rubro_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $rubro_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $rubro_list->Pager->FromIndex ?> a <?php echo $rubro_list->Pager->ToIndex ?> de <?php echo $rubro_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($rubro_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta P&aacute;gina</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($rubro_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por P&aacute;gina&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="rubro">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($rubro_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($rubro_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($rubro->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($rubro_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $rubro->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($rubro->Export == "" && $rubro->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(rubro_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($rubro->Export == "") { ?>
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
class crubro_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'rubro';

	// Page Object Name
	var $PageObjName = 'rubro_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $rubro;
		if ($rubro->UseTokenInUrl) $PageUrl .= "t=" . $rubro->TableVar . "&"; // add page token
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
		global $objForm, $rubro;
		if ($rubro->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($rubro->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($rubro->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function crubro_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["rubro"] = new crubro();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rubro', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $rubro;
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
	$rubro->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $rubro->Export; // Get export parameter, used in header
	$gsExportFile = $rubro->TableVar; // Get export file, used in header
	if ($rubro->Export == "print" || $rubro->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($rubro->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $rubro;
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
		if ($rubro->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $rubro->getRecordsPerPage(); // Restore from Session
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
		$rubro->setSessionWhere($sFilter);
		$rubro->CurrentFilter = "";

		// Export data only
		if (in_array($rubro->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $rubro;
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
			$rubro->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$rubro->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $rubro;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$rubro->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$rubro->CurrentOrderType = @$_GET["ordertype"];
			$rubro->UpdateSort($rubro->idRubro); // Field 
			$rubro->UpdateSort($rubro->rubro); // Field 
			$rubro->UpdateSort($rubro->gestion2009); // Field 
			$rubro->UpdateSort($rubro->gestion2010); // Field 
			$rubro->UpdateSort($rubro->gestion2011); // Field 
			$rubro->UpdateSort($rubro->gestion2012); // Field 
			$rubro->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $rubro;
		$sOrderBy = $rubro->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($rubro->SqlOrderBy() <> "") {
				$sOrderBy = $rubro->SqlOrderBy();
				$rubro->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $rubro;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$rubro->setSessionOrderBy($sOrderBy);
				$rubro->idRubro->setSort("");
				$rubro->rubro->setSort("");
				$rubro->gestion2009->setSort("");
				$rubro->gestion2010->setSort("");
				$rubro->gestion2011->setSort("");
				$rubro->gestion2012->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$rubro->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $rubro;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$rubro->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$rubro->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $rubro->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$rubro->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$rubro->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$rubro->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $rubro;

		// Call Recordset Selecting event
		$rubro->Recordset_Selecting($rubro->CurrentFilter);

		// Load list page SQL
		$sSql = $rubro->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$rubro->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $rubro;
		$sFilter = $rubro->KeyFilter();

		// Call Row Selecting event
		$rubro->Row_Selecting($sFilter);

		// Load sql based on filter
		$rubro->CurrentFilter = $sFilter;
		$sSql = $rubro->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$rubro->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $rubro;
		$rubro->idRubro->setDbValue($rs->fields('idRubro'));
		$rubro->rubro->setDbValue($rs->fields('rubro'));
		$rubro->detalle->setDbValue($rs->fields('detalle'));
		$rubro->gestion2009->setDbValue($rs->fields('gestion2009'));
		$rubro->gestion2010->setDbValue($rs->fields('gestion2010'));
		$rubro->gestion2011->setDbValue($rs->fields('gestion2011'));
		$rubro->gestion2012->setDbValue($rs->fields('gestion2012'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $rubro;

		// Call Row_Rendering event
		$rubro->Row_Rendering();

		// Common render codes for all row types
		// idRubro

		$rubro->idRubro->CellCssStyle = "";
		$rubro->idRubro->CellCssClass = "";

		// rubro
		$rubro->rubro->CellCssStyle = "";
		$rubro->rubro->CellCssClass = "";

		// gestion2009
		$rubro->gestion2009->CellCssStyle = "";
		$rubro->gestion2009->CellCssClass = "";

		// gestion2010
		$rubro->gestion2010->CellCssStyle = "";
		$rubro->gestion2010->CellCssClass = "";

		// gestion2011
		$rubro->gestion2011->CellCssStyle = "";
		$rubro->gestion2011->CellCssClass = "";

		// gestion2012
		$rubro->gestion2012->CellCssStyle = "";
		$rubro->gestion2012->CellCssClass = "";
		if ($rubro->RowType == EW_ROWTYPE_VIEW) { // View row

			// idRubro
			$rubro->idRubro->ViewValue = $rubro->idRubro->CurrentValue;
			$rubro->idRubro->CssStyle = "";
			$rubro->idRubro->CssClass = "";
			$rubro->idRubro->ViewCustomAttributes = "";

			// rubro
			$rubro->rubro->ViewValue = $rubro->rubro->CurrentValue;
			$rubro->rubro->CssStyle = "";
			$rubro->rubro->CssClass = "";
			$rubro->rubro->ViewCustomAttributes = "";

			// gestion2009
			$rubro->gestion2009->ViewValue = $rubro->gestion2009->CurrentValue;
			$rubro->gestion2009->CssStyle = "";
			$rubro->gestion2009->CssClass = "";
			$rubro->gestion2009->ViewCustomAttributes = "";

			// gestion2010
			$rubro->gestion2010->ViewValue = $rubro->gestion2010->CurrentValue;
			$rubro->gestion2010->CssStyle = "";
			$rubro->gestion2010->CssClass = "";
			$rubro->gestion2010->ViewCustomAttributes = "";

			// gestion2011
			$rubro->gestion2011->ViewValue = $rubro->gestion2011->CurrentValue;
			$rubro->gestion2011->CssStyle = "";
			$rubro->gestion2011->CssClass = "";
			$rubro->gestion2011->ViewCustomAttributes = "";

			// gestion2012
			$rubro->gestion2012->ViewValue = $rubro->gestion2012->CurrentValue;
			$rubro->gestion2012->CssStyle = "";
			$rubro->gestion2012->CssClass = "";
			$rubro->gestion2012->ViewCustomAttributes = "";

			// idRubro
			$rubro->idRubro->HrefValue = "";

			// rubro
			$rubro->rubro->HrefValue = "";

			// gestion2009
			$rubro->gestion2009->HrefValue = "";

			// gestion2010
			$rubro->gestion2010->HrefValue = "";

			// gestion2011
			$rubro->gestion2011->HrefValue = "";

			// gestion2012
			$rubro->gestion2012->HrefValue = "";
		}

		// Call Row Rendered event
		$rubro->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $rubro;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($rubro->ExportAll) {
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
		if ($rubro->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($rubro->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $rubro->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idRubro', $rubro->Export);
				ew_ExportAddValue($sExportStr, 'rubro', $rubro->Export);
				ew_ExportAddValue($sExportStr, 'gestion2009', $rubro->Export);
				ew_ExportAddValue($sExportStr, 'gestion2010', $rubro->Export);
				ew_ExportAddValue($sExportStr, 'gestion2011', $rubro->Export);
				ew_ExportAddValue($sExportStr, 'gestion2012', $rubro->Export);
				echo ew_ExportLine($sExportStr, $rubro->Export);
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
				$rubro->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($rubro->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idRubro', $rubro->idRubro->CurrentValue);
					$XmlDoc->AddField('rubro', $rubro->rubro->CurrentValue);
					$XmlDoc->AddField('gestion2009', $rubro->gestion2009->CurrentValue);
					$XmlDoc->AddField('gestion2010', $rubro->gestion2010->CurrentValue);
					$XmlDoc->AddField('gestion2011', $rubro->gestion2011->CurrentValue);
					$XmlDoc->AddField('gestion2012', $rubro->gestion2012->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $rubro->Export <> "csv") { // Vertical format
						echo ew_ExportField('idRubro', $rubro->idRubro->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
						echo ew_ExportField('rubro', $rubro->rubro->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
						echo ew_ExportField('gestion2009', $rubro->gestion2009->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
						echo ew_ExportField('gestion2010', $rubro->gestion2010->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
						echo ew_ExportField('gestion2011', $rubro->gestion2011->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
						echo ew_ExportField('gestion2012', $rubro->gestion2012->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $rubro->idRubro->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
						ew_ExportAddValue($sExportStr, $rubro->rubro->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
						ew_ExportAddValue($sExportStr, $rubro->gestion2009->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
						ew_ExportAddValue($sExportStr, $rubro->gestion2010->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
						ew_ExportAddValue($sExportStr, $rubro->gestion2011->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
						ew_ExportAddValue($sExportStr, $rubro->gestion2012->ExportValue($rubro->Export, $rubro->ExportOriginalValue), $rubro->Export);
						echo ew_ExportLine($sExportStr, $rubro->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($rubro->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($rubro->Export);
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
