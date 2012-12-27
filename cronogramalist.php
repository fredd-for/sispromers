<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "cronogramainfo.php" ?>
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
$cronograma_list = new ccronograma_list();
$Page =& $cronograma_list;

// Page init processing
$cronograma_list->Page_Init();

// Page main processing
$cronograma_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($cronograma->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cronograma_list = new ew_Page("cronograma_list");

// page properties
cronograma_list.PageID = "list"; // page ID
var EW_PAGE_ID = cronograma_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cronograma_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cronograma_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cronograma_list.ValidateRequired = false; // no JavaScript validation
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
<?php } ?>
<?php if ($cronograma->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($cronograma->Export == "" && $cronograma->SelectLimit);
	if (!$bSelectLimit)
		$rs = $cronograma_list->LoadRecordset();
	$cronograma_list->lTotalRecs = ($bSelectLimit) ? $cronograma->SelectRecordCount() : $rs->RecordCount();
	$cronograma_list->lStartRec = 1;
	if ($cronograma_list->lDisplayRecs <= 0) // Display all records
		$cronograma_list->lDisplayRecs = $cronograma_list->lTotalRecs;
	if (!($cronograma->ExportAll && $cronograma->Export <> ""))
		$cronograma_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $cronograma_list->LoadRecordset($cronograma_list->lStartRec-1, $cronograma_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Cronograma
<?php if ($cronograma->Export == "" && $cronograma->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="consultorialist.php">Volver atras</a>

<?php } ?>
</span></p>
<?php
//echo $_GET['idConsultoria'];
mysql_select_db($database_conexion, $conexion);
$query_consultoria= "SELECT a.idConsultoria, a.consultoria, a.fechaInicio, a.fechaFinal, b.paterno, b.materno,b.nombre FROM consultoria a, usuario b WHERE a.idConsultoria='".(int)$_GET['idConsultoria']."' AND a.idUsuario=b.idUsuario";
$mostrar_consultoria=mysql_query($query_consultoria, $conexion) or die(mysql_error());
$row_consultoria=mysql_fetch_assoc($mostrar_consultoria);
?>
<fieldset>
    <legend>Proyecto: Promoviendo el Desarrollo Local y la Formacion de MERS</legend>
    <table>
        <tr>
            <td><div>Consultoria:</div></td><td colspan="7"><?php echo $row_consultoria['consultoria']?></td>
        </tr>
        <tr>
            <td><div>Responsable:</div></td><td><?php echo $row_consultoria['paterno']." ".$row_consultoria['materno'].", ".$row_consultoria['nombre']?></td>
            <td><div>Desde:</div></td><td><?php echo date("d-m-Y",strtotime($row_consultoria['fechaInicio']))?></td>
            <td><div>Hasta:</div></td><td><?php echo date("d-m-Y",strtotime($row_consultoria['fechaFinal']))?></td>
        </tr>

    </table>
</fieldset>
<?php $cronograma_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fcronogramalist" id="fcronogramalist" class="ewForm" action="" method="post">
<?php if ($cronograma_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$cronograma_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$cronograma_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$cronograma_list->lOptionCnt++; // edit
}
if ($Security->CanAdd()) {
	$cronograma_list->lOptionCnt++; // copy
}
if ($Security->CanDelete()) {
	$cronograma_list->lOptionCnt++; // Delete
}
	$cronograma_list->lOptionCnt += count($cronograma_list->ListOptions->Items); // Custom list options
?>
<?php echo $cronograma->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($cronograma->idCronograma->Visible) { // idCronograma ?>
	<?php if ($cronograma->SortUrl($cronograma->idCronograma) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronograma->SortUrl($cronograma->idCronograma) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($cronograma->idCronograma->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronograma->idCronograma->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cronograma->detalle->Visible) { // detalle ?>
	<?php if ($cronograma->SortUrl($cronograma->detalle) == "") { ?>
		<td>Detalle</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronograma->SortUrl($cronograma->detalle) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Detalle</td><td style="width: 10px;"><?php if ($cronograma->detalle->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronograma->detalle->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>
<?php if ($cronograma->fechaInicio->Visible) { // fechaInicio ?>
	<?php if ($cronograma->SortUrl($cronograma->fechaInicio) == "") { ?>
		<td>Fecha Inicio</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronograma->SortUrl($cronograma->fechaInicio) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fecha Inicio</td><td style="width: 10px;"><?php if ($cronograma->fechaInicio->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronograma->fechaInicio->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cronograma->fechaFinal->Visible) { // fechaFinal ?>
	<?php if ($cronograma->SortUrl($cronograma->fechaFinal) == "") { ?>
		<td>Fecha Final</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronograma->SortUrl($cronograma->fechaFinal) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fecha Final</td><td style="width: 10px;"><?php if ($cronograma->fechaFinal->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronograma->fechaFinal->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cronograma->estado->Visible) { // estado ?>
	<?php if ($cronograma->SortUrl($cronograma->estado) == "") { ?>
		<td>Estado</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronograma->SortUrl($cronograma->estado) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Estado</td><td style="width: 10px;"><?php if ($cronograma->estado->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronograma->estado->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cronograma->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->CanAdd()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($cronograma_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($cronograma->ExportAll && $cronograma->Export <> "") {
	$cronograma_list->lStopRec = $cronograma_list->lTotalRecs;
} else {
	$cronograma_list->lStopRec = $cronograma_list->lStartRec + $cronograma_list->lDisplayRecs - 1; // Set the last record to display
}
$cronograma_list->lRecCount = $cronograma_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$cronograma->SelectLimit && $cronograma_list->lStartRec > 1)
		$rs->Move($cronograma_list->lStartRec - 1);
}
$contador=1;
$cronograma_list->lRowCnt = 0;
while (($cronograma->CurrentAction == "gridadd" || !$rs->EOF) &&
	$cronograma_list->lRecCount < $cronograma_list->lStopRec) {
	$cronograma_list->lRecCount++;
	if (intval($cronograma_list->lRecCount) >= intval($cronograma_list->lStartRec)) {
		$cronograma_list->lRowCnt++;

	// Init row class and style
	$cronograma->CssClass = "";
	$cronograma->CssStyle = "";
	$cronograma->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($cronograma->CurrentAction == "gridadd") {
		$cronograma_list->LoadDefaultValues(); // Load default values
	} else {
		$cronograma_list->LoadRowValues($rs); // Load row values
	}
	$cronograma->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$cronograma_list->RenderRow();
?>
	<tr<?php echo $cronograma->RowAttributes() ?>>
	<?php if ($cronograma->idCronograma->Visible) { // idCronograma ?>
		<td<?php echo $cronograma->idCronograma->CellAttributes() ?>>
<div<?php echo $cronograma->idCronograma->ViewAttributes() ?>><?php echo $contador //$cronograma->idCronograma->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cronograma->detalle->Visible) { // detalle ?>
		<td<?php echo $cronograma->detalle->CellAttributes() ?>>
<div<?php echo $cronograma->detalle->ViewAttributes() ?>><?php echo $cronograma->detalle->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cronograma->fechaInicio->Visible) { // fechaInicio ?>
		<td<?php echo $cronograma->fechaInicio->CellAttributes() ?>>
<div<?php echo $cronograma->fechaInicio->ViewAttributes() ?>><?php echo $cronograma->fechaInicio->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cronograma->fechaFinal->Visible) { // fechaFinal ?>
		<td<?php echo $cronograma->fechaFinal->CellAttributes() ?>>
<div<?php echo $cronograma->fechaFinal->ViewAttributes() ?>><?php echo $cronograma->fechaFinal->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cronograma->estado->Visible) { // estado ?>
		<td<?php echo $cronograma->estado->CellAttributes() ?>>
<div<?php echo $cronograma->estado->ViewAttributes() ?>><?php echo $cronograma->estado->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($cronograma->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $cronograma->ViewUrl() ?>" title="Ver o Registrar avance del producto">Avance</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<?php if ($cronograma->estado->ListViewValue()=='Proceso') { ?>
        <a href="<?php echo $cronograma->EditUrl() ?>">Editar</a>
        <?php } ?>
</span></td>
<?php } ?>
<?php if ($Security->CanAdd()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $cronograma->CopyUrl() ?>">Copiar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<?php if ($cronograma->estado->ListViewValue()=='Proceso') { ?>
        <a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $cronograma_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $cronograma->DeleteUrl() ?>">Borrar</a>
<?php } ?>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($cronograma_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($cronograma->CurrentAction <> "gridadd")
		$rs->MoveNext();

$contador++;
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
<?php if ($cronograma->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php //if ($cronograma_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $cronograma->AddUrl() ?>?idConsultoria=<?php echo $_GET['idConsultoria']?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($cronograma->Export == "" && $cronograma->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(cronograma_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($cronograma->Export == "") { ?>
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
class ccronograma_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'cronograma';

	// Page Object Name
	var $PageObjName = 'cronograma_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cronograma;
		if ($cronograma->UseTokenInUrl) $PageUrl .= "t=" . $cronograma->TableVar . "&"; // add page token
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
		global $objForm, $cronograma;
		if ($cronograma->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($cronograma->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cronograma->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccronograma_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["cronograma"] = new ccronograma();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cronograma', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $cronograma;
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
	$cronograma->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $cronograma->Export; // Get export parameter, used in header
	$gsExportFile = $cronograma->TableVar; // Get export file, used in header
	if ($cronograma->Export == "print" || $cronograma->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($cronograma->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $cronograma;
		$this->lDisplayRecs = 20;
		$this->lRecRange = 10;
		$this->lRecCnt = 0; // Record count

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		$this->sSrchWhere = ""; // Search WHERE clause
		$this->sDeleteConfirmMsg = "Esta seguro de borrar el registro?. Se perderan todos los datos de control y evaluacion del cronograma"; // Delete confirm message

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
		if ($cronograma->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $cronograma->getRecordsPerPage(); // Restore from Session
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
		$cronograma->setSessionWhere($sFilter);
		$cronograma->CurrentFilter = "";

		// Export data only
		if (in_array($cronograma->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $cronograma;
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
			$cronograma->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$cronograma->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $cronograma;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$cronograma->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$cronograma->CurrentOrderType = @$_GET["ordertype"];
			$cronograma->UpdateSort($cronograma->idCronograma); // Field 
			$cronograma->UpdateSort($cronograma->idConsultoria); // Field 
			$cronograma->UpdateSort($cronograma->fechaInicio); // Field 
			$cronograma->UpdateSort($cronograma->fechaFinal); // Field 
			$cronograma->UpdateSort($cronograma->detalle); // Field 
			$cronograma->UpdateSort($cronograma->mesAnio); // Field 
			$cronograma->UpdateSort($cronograma->estado); // Field 
			$cronograma->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $cronograma;
		$sOrderBy = $cronograma->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($cronograma->SqlOrderBy() <> "") {
				$sOrderBy = $cronograma->SqlOrderBy();
				$cronograma->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $cronograma;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$cronograma->setSessionOrderBy($sOrderBy);
				$cronograma->idCronograma->setSort("");
				$cronograma->idConsultoria->setSort("");
				$cronograma->fechaInicio->setSort("");
				$cronograma->fechaFinal->setSort("");
				$cronograma->detalle->setSort("");
				$cronograma->mesAnio->setSort("");
				$cronograma->estado->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$cronograma->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $cronograma;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$cronograma->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$cronograma->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $cronograma->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$cronograma->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$cronograma->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$cronograma->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $cronograma;

		// Call Recordset Selecting event
		$cronograma->Recordset_Selecting($cronograma->CurrentFilter);

		// Load list page SQL
		$sSql = $cronograma->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$cronograma->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cronograma;
		$sFilter = $cronograma->KeyFilter();

		// Call Row Selecting event
		$cronograma->Row_Selecting($sFilter);

		// Load sql based on filter
		$cronograma->CurrentFilter = $sFilter;
		$sSql = $cronograma->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$cronograma->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $cronograma;
		$cronograma->idCronograma->setDbValue($rs->fields('idCronograma'));
		$cronograma->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$cronograma->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$cronograma->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$cronograma->detalle->setDbValue($rs->fields('detalle'));
		$cronograma->mesAnio->setDbValue($rs->fields('mesAnio'));
		$cronograma->estado->setDbValue($rs->fields('estado'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $cronograma;

		// Call Row_Rendering event
		$cronograma->Row_Rendering();

		// Common render codes for all row types
		// idCronograma

		$cronograma->idCronograma->CellCssStyle = "";
		$cronograma->idCronograma->CellCssClass = "";

		// idConsultoria
		$cronograma->idConsultoria->CellCssStyle = "";
		$cronograma->idConsultoria->CellCssClass = "";

		// fechaInicio
		$cronograma->fechaInicio->CellCssStyle = "";
		$cronograma->fechaInicio->CellCssClass = "";

		// fechaFinal
		$cronograma->fechaFinal->CellCssStyle = "";
		$cronograma->fechaFinal->CellCssClass = "";

		// detalle
		$cronograma->detalle->CellCssStyle = "";
		$cronograma->detalle->CellCssClass = "";

		// mesAnio
		$cronograma->mesAnio->CellCssStyle = "";
		$cronograma->mesAnio->CellCssClass = "";

		// estado
		$cronograma->estado->CellCssStyle = "";
		$cronograma->estado->CellCssClass = "";
		if ($cronograma->RowType == EW_ROWTYPE_VIEW) { // View row

			// idCronograma
			$cronograma->idCronograma->ViewValue = $cronograma->idCronograma->CurrentValue;
			$cronograma->idCronograma->CssStyle = "";
			$cronograma->idCronograma->CssClass = "";
			$cronograma->idCronograma->ViewCustomAttributes = "";

			// idConsultoria
			$cronograma->idConsultoria->ViewValue = $cronograma->idConsultoria->CurrentValue;
			$cronograma->idConsultoria->CssStyle = "";
			$cronograma->idConsultoria->CssClass = "";
			$cronograma->idConsultoria->ViewCustomAttributes = "";

			// fechaInicio
			$cronograma->fechaInicio->ViewValue = $cronograma->fechaInicio->CurrentValue;
			$cronograma->fechaInicio->ViewValue = ew_FormatDateTime($cronograma->fechaInicio->ViewValue, 7);
			$cronograma->fechaInicio->CssStyle = "";
			$cronograma->fechaInicio->CssClass = "";
			$cronograma->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$cronograma->fechaFinal->ViewValue = $cronograma->fechaFinal->CurrentValue;
			$cronograma->fechaFinal->ViewValue = ew_FormatDateTime($cronograma->fechaFinal->ViewValue, 7);
			$cronograma->fechaFinal->CssStyle = "";
			$cronograma->fechaFinal->CssClass = "";
			$cronograma->fechaFinal->ViewCustomAttributes = "";

			// detalle
			$cronograma->detalle->ViewValue = $cronograma->detalle->CurrentValue;
			$cronograma->detalle->CssStyle = "";
			$cronograma->detalle->CssClass = "";
			$cronograma->detalle->ViewCustomAttributes = "";

			// mesAnio
			$cronograma->mesAnio->ViewValue = $cronograma->mesAnio->CurrentValue;
			$cronograma->mesAnio->ViewValue = ew_FormatDateTime($cronograma->mesAnio->ViewValue, 7);
			$cronograma->mesAnio->CssStyle = "";
			$cronograma->mesAnio->CssClass = "";
			$cronograma->mesAnio->ViewCustomAttributes = "";

			// estado
			if (strval($cronograma->estado->CurrentValue) <> "") {
				switch ($cronograma->estado->CurrentValue) {
					case "1":
						$cronograma->estado->ViewValue = "Proceso";
						break;
					case "2":
						$cronograma->estado->ViewValue = "Revision";
						break;
					case "3":
						$cronograma->estado->ViewValue = "Aprobado";
						break;
					default:
						$cronograma->estado->ViewValue = $cronograma->estado->CurrentValue;
				}
			} else {
				$cronograma->estado->ViewValue = NULL;
			}
			$cronograma->estado->CssStyle = "";
			$cronograma->estado->CssClass = "";
			$cronograma->estado->ViewCustomAttributes = "";

			// idCronograma
			$cronograma->idCronograma->HrefValue = "";

			// idConsultoria
			$cronograma->idConsultoria->HrefValue = "";

			// fechaInicio
			$cronograma->fechaInicio->HrefValue = "";

			// fechaFinal
			$cronograma->fechaFinal->HrefValue = "";

			// detalle
			$cronograma->detalle->HrefValue = "";

			// mesAnio
			$cronograma->mesAnio->HrefValue = "";

			// estado
			$cronograma->estado->HrefValue = "";
		}

		// Call Row Rendered event
		$cronograma->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $cronograma;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($cronograma->ExportAll) {
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
		if ($cronograma->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($cronograma->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $cronograma->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idCronograma', $cronograma->Export);
				ew_ExportAddValue($sExportStr, 'idConsultoria', $cronograma->Export);
				ew_ExportAddValue($sExportStr, 'fechaInicio', $cronograma->Export);
				ew_ExportAddValue($sExportStr, 'fechaFinal', $cronograma->Export);
				ew_ExportAddValue($sExportStr, 'detalle', $cronograma->Export);
				ew_ExportAddValue($sExportStr, 'mesAnio', $cronograma->Export);
				ew_ExportAddValue($sExportStr, 'estado', $cronograma->Export);
				echo ew_ExportLine($sExportStr, $cronograma->Export);
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
				$cronograma->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($cronograma->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idCronograma', $cronograma->idCronograma->CurrentValue);
					$XmlDoc->AddField('idConsultoria', $cronograma->idConsultoria->CurrentValue);
					$XmlDoc->AddField('fechaInicio', $cronograma->fechaInicio->CurrentValue);
					$XmlDoc->AddField('fechaFinal', $cronograma->fechaFinal->CurrentValue);
					$XmlDoc->AddField('detalle', $cronograma->detalle->CurrentValue);
					$XmlDoc->AddField('mesAnio', $cronograma->mesAnio->CurrentValue);
					$XmlDoc->AddField('estado', $cronograma->estado->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $cronograma->Export <> "csv") { // Vertical format
						echo ew_ExportField('idCronograma', $cronograma->idCronograma->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						echo ew_ExportField('idConsultoria', $cronograma->idConsultoria->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						echo ew_ExportField('fechaInicio', $cronograma->fechaInicio->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						echo ew_ExportField('fechaFinal', $cronograma->fechaFinal->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						echo ew_ExportField('detalle', $cronograma->detalle->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						echo ew_ExportField('mesAnio', $cronograma->mesAnio->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						echo ew_ExportField('estado', $cronograma->estado->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $cronograma->idCronograma->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						ew_ExportAddValue($sExportStr, $cronograma->idConsultoria->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						ew_ExportAddValue($sExportStr, $cronograma->fechaInicio->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						ew_ExportAddValue($sExportStr, $cronograma->fechaFinal->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						ew_ExportAddValue($sExportStr, $cronograma->detalle->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						ew_ExportAddValue($sExportStr, $cronograma->mesAnio->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						ew_ExportAddValue($sExportStr, $cronograma->estado->ExportValue($cronograma->Export, $cronograma->ExportOriginalValue), $cronograma->Export);
						echo ew_ExportLine($sExportStr, $cronograma->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($cronograma->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($cronograma->Export);
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
