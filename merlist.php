<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "merinfo.php" ?>
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
$mer_list = new cmer_list();
$Page =& $mer_list;

// Page init processing
$mer_list->Page_Init();

// Page main processing
$mer_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($mer->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var mer_list = new ew_Page("mer_list");

// page properties
mer_list.PageID = "list"; // page ID
var EW_PAGE_ID = mer_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
mer_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
mer_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mer_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script type="text/javascript">
    $(function () {
        $('input#id_search').quicksearch('table table#table_example #contenidoTbody tr');
    });
</script>
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-1.css" title="win2k-1">
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script type="text/javascript">
<!--
var ew_DHTMLEditors = [];

//-->
</script>
<script language="JavaScript" type="text/javascript">
    function ocultarMer()
    {
        var agree=confirm("Est\u00e1 seguro de eliminar esta MERS.");
        if (agree)
            return true ;
        else
            return false ;

    }

</script>
<?php } ?>
<?php if ($mer->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($mer->Export == "" && $mer->SelectLimit);
	if (!$bSelectLimit)
		$rs = $mer_list->LoadRecordset();
	$mer_list->lTotalRecs = ($bSelectLimit) ? $mer->SelectRecordCount() : $rs->RecordCount();
	$mer_list->lStartRec = 1;
	if ($mer_list->lDisplayRecs <= 0) // Display all records
		$mer_list->lDisplayRecs = $mer_list->lTotalRecs;
	if (!($mer->ExportAll && $mer->Export <> ""))
		$mer_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $mer_list->LoadRecordset($mer_list->lStartRec-1, $mer_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Mer
<?php if ($mer->Export == "" && $mer->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $mer_list->PageUrl() ?>export=print">Impresi&oacute;n Amigable</a>
&nbsp;&nbsp;<a href="<?php echo $mer_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $mer_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
            <div>
                    <fieldset>
                        BUSCAR= <input type="text" name="search" value="" id="id_search" size="50"/>
                    </fieldset>

            </div>
<div class="ewGridMiddlePanel">
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $mer->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<form name="fmerlist" id="fmerlist" class="ewForm" action="" method="post">
<?php if ($mer_list->lTotalRecs > 0) { ?>
<table id="table_example" cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$mer_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$mer_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$mer_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$mer_list->lOptionCnt++; // Delete
}
	$mer_list->lOptionCnt += count($mer_list->ListOptions->Items); // Custom list options
?>
<?php echo $mer->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($mer->idMer->Visible) { // idMer ?>
	<?php if ($mer->SortUrl($mer->idMer) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mer->SortUrl($mer->idMer) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($mer->idMer->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mer->idMer->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($mer->idRegional->Visible) { // idRegional ?>
	<?php if ($mer->SortUrl($mer->idRegional) == "") { ?>
		<td>Regional</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mer->SortUrl($mer->idRegional) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Regional</td><td style="width: 10px;"><?php if ($mer->idRegional->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mer->idRegional->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($mer->idDepartamento->Visible) { // idDepartamento ?>
	<?php if ($mer->SortUrl($mer->idDepartamento) == "") { ?>
		<td>Departamento</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mer->SortUrl($mer->idDepartamento) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Departamento</td><td style="width: 10px;"><?php if ($mer->idDepartamento->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mer->idDepartamento->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($mer->idMunicipio->Visible) { // idMunicipio ?>
	<?php if ($mer->SortUrl($mer->idMunicipio) == "") { ?>
		<td>Municipio</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mer->SortUrl($mer->idMunicipio) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Municipio</td><td style="width: 10px;"><?php if ($mer->idMunicipio->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mer->idMunicipio->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($mer->idComunidad->Visible) { // idComunidad ?>
	<?php if ($mer->SortUrl($mer->idComunidad) == "") { ?>
		<td>Comunidad</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mer->SortUrl($mer->idComunidad) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Comunidad</td><td style="width: 10px;"><?php if ($mer->idComunidad->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mer->idComunidad->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($mer->idRubro->Visible) { // idRubro ?>
	<?php if ($mer->SortUrl($mer->idRubro) == "") { ?>
		<td>Rubro</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mer->SortUrl($mer->idRubro) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Rubro</td><td style="width: 10px;"><?php if ($mer->idRubro->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mer->idRubro->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($mer->mer->Visible) { // mer ?>
	<?php if ($mer->SortUrl($mer->mer) == "") { ?>
		<td>Nombre de la Mer</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mer->SortUrl($mer->mer) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Nombre de la Mer</td><td style="width: 10px;"><?php if ($mer->mer->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mer->mer->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($mer->fechaInicio->Visible) { // fechaInicio ?>
	<?php if ($mer->SortUrl($mer->fechaInicio) == "") { ?>
		<td>Fecha Inicio</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mer->SortUrl($mer->fechaInicio) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fecha Inicio</td><td style="width: 10px;"><?php if ($mer->fechaInicio->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mer->fechaInicio->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($mer->fechaFinal->Visible) { // fechaFinal ?>
	<?php if ($mer->SortUrl($mer->fechaFinal) == "") { ?>
		<td>Fecha Final</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mer->SortUrl($mer->fechaFinal) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fecha Final</td><td style="width: 10px;"><?php if ($mer->fechaFinal->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mer->fechaFinal->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($mer->estado->Visible) { // estado ?>
	<?php if ($mer->SortUrl($mer->estado) == "") { ?>
		<td>Estado</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mer->SortUrl($mer->estado) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Estado</td><td style="width: 10px;"><?php if ($mer->estado->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mer->estado->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($mer->Export == "") { ?>
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
foreach ($mer_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<tbody id="contenidoTbody">
<?php
if ($mer->ExportAll && $mer->Export <> "") {
	$mer_list->lStopRec = $mer_list->lTotalRecs;
} else {
	$mer_list->lStopRec = $mer_list->lStartRec + $mer_list->lDisplayRecs - 1; // Set the last record to display
}
$mer_list->lRecCount = $mer_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$mer->SelectLimit && $mer_list->lStartRec > 1)
		$rs->Move($mer_list->lStartRec - 1);
}
$mer_list->lRowCnt = 0;
while (($mer->CurrentAction == "gridadd" || !$rs->EOF) &&
	$mer_list->lRecCount < $mer_list->lStopRec) {
	$mer_list->lRecCount++;
	if (intval($mer_list->lRecCount) >= intval($mer_list->lStartRec)) {
		$mer_list->lRowCnt++;

	// Init row class and style
	$mer->CssClass = "";
	$mer->CssStyle = "";
	$mer->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($mer->CurrentAction == "gridadd") {
		$mer_list->LoadDefaultValues(); // Load default values
	} else {
		$mer_list->LoadRowValues($rs); // Load row values
	}
	$mer->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$mer_list->RenderRow();
?>
	<tr<?php echo $mer->RowAttributes() ?>>
	<?php if ($mer->idMer->Visible) { // idMer ?>
		<td<?php echo $mer->idMer->CellAttributes() ?>>
<div<?php echo $mer->idMer->ViewAttributes() ?>><?php echo $mer->idMer->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($mer->idRegional->Visible) { // idRegional ?>
		<td<?php echo $mer->idRegional->CellAttributes() ?>>
<div<?php echo $mer->idRegional->ViewAttributes() ?>><?php echo $mer->idRegional->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($mer->idDepartamento->Visible) { // idDepartamento ?>
		<td<?php echo $mer->idDepartamento->CellAttributes() ?>>
<div<?php echo $mer->idDepartamento->ViewAttributes() ?>><?php echo $mer->idDepartamento->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($mer->idMunicipio->Visible) { // idMunicipio ?>
		<td<?php echo $mer->idMunicipio->CellAttributes() ?>>
<div<?php echo $mer->idMunicipio->ViewAttributes() ?>><?php echo $mer->idMunicipio->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($mer->idComunidad->Visible) { // idComunidad ?>
		<td<?php echo $mer->idComunidad->CellAttributes() ?>>
<div<?php echo $mer->idComunidad->ViewAttributes() ?>><?php echo $mer->idComunidad->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($mer->idRubro->Visible) { // idRubro ?>
		<td<?php echo $mer->idRubro->CellAttributes() ?>>
<div<?php echo $mer->idRubro->ViewAttributes() ?>><?php echo $mer->idRubro->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($mer->mer->Visible) { // mer ?>
<td<?php echo $mer->mer->CellAttributes() ?> bgcolor="#D8DBCD">
<div<?php echo $mer->mer->ViewAttributes() ?>><?php echo $mer->mer->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($mer->fechaInicio->Visible) { // fechaInicio ?>
		<td<?php echo $mer->fechaInicio->CellAttributes() ?>>
<div<?php echo $mer->fechaInicio->ViewAttributes() ?>><?php echo $mer->fechaInicio->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($mer->fechaFinal->Visible) { // fechaFinal ?>
		<td<?php echo $mer->fechaFinal->CellAttributes() ?>>
<div<?php echo $mer->fechaFinal->ViewAttributes() ?>><?php echo $mer->fechaFinal->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($mer->estado->Visible) { // estado ?>
		<td<?php echo $mer->estado->CellAttributes() ?>>
<div<?php echo $mer->estado->ViewAttributes() ?>><?php echo $mer->estado->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($mer->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $mer->ViewUrl() ?>">Formularios</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $mer->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
        <a href="<?php echo $mer->DeleteUrl() ?>&sw=ocultarMer" onclick="return ocultarMer()">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($mer_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($mer->CurrentAction <> "gridadd")
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
<?php if ($mer->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($mer->CurrentAction <> "gridadd" && $mer->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($mer_list->Pager)) $mer_list->Pager = new cPrevNextPager($mer_list->lStartRec, $mer_list->lDisplayRecs, $mer_list->lTotalRecs) ?>
<?php if ($mer_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">P&aacute;gina&nbsp;</span></td>
<!--first page button-->
	<?php if ($mer_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $mer_list->PageUrl() ?>start=<?php echo $mer_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($mer_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $mer_list->PageUrl() ?>start=<?php echo $mer_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $mer_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($mer_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $mer_list->PageUrl() ?>start=<?php echo $mer_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($mer_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $mer_list->PageUrl() ?>start=<?php echo $mer_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $mer_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $mer_list->Pager->FromIndex ?> a <?php echo $mer_list->Pager->ToIndex ?> de <?php echo $mer_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($mer_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta P&aacute;gina</span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($mer_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $mer->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($mer->Export == "") { ?>
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
class cmer_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'mer';

	// Page Object Name
	var $PageObjName = 'mer_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $mer;
		if ($mer->UseTokenInUrl) $PageUrl .= "t=" . $mer->TableVar . "&"; // add page token
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
		global $objForm, $mer;
		if ($mer->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($mer->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($mer->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cmer_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["mer"] = new cmer();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'mer', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $mer;
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
	$mer->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $mer->Export; // Get export parameter, used in header
	$gsExportFile = $mer->TableVar; // Get export file, used in header
	if ($mer->Export == "print" || $mer->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($mer->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $mer;
		$this->lDisplayRecs = -1;
		$this->lRecRange = 10;
		$this->lRecCnt = 0; // Record count

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		$this->sSrchWhere = ""; // Search WHERE clause
//		$this->sDeleteConfirmMsg = "Quiere borrar este registro?"; // Delete confirm message

		// Master/Detail
		$this->sDbMasterFilter = ""; // Master filter
		$this->sDbDetailFilter = ""; // Detail filter
		if ($this->IsPageRequest()) { // Validate request

			// Set up records per page dynamically
//			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($mer->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $mer->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = -1; // Load default
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
		$mer->setSessionWhere($sFilter);
		$mer->CurrentFilter = "";

		// Export data only
		if (in_array($mer->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $mer;
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
			$mer->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$mer->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $mer;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$mer->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$mer->CurrentOrderType = @$_GET["ordertype"];
			$mer->UpdateSort($mer->idMer); // Field 
			$mer->UpdateSort($mer->idRegional); // Field 
			$mer->UpdateSort($mer->idDepartamento); // Field 
			$mer->UpdateSort($mer->idMunicipio); // Field 
			$mer->UpdateSort($mer->idComunidad); // Field 
			$mer->UpdateSort($mer->idRubro); // Field 
			$mer->UpdateSort($mer->mer); // Field 
			$mer->UpdateSort($mer->fechaInicio); // Field 
			$mer->UpdateSort($mer->fechaFinal); // Field 
			$mer->UpdateSort($mer->estado); // Field 
			$mer->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $mer;
		$sOrderBy = $mer->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($mer->SqlOrderBy() <> "") {
				$sOrderBy = $mer->SqlOrderBy();
				$mer->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $mer;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$mer->setSessionOrderBy($sOrderBy);
				$mer->idMer->setSort("");
				$mer->idRegional->setSort("");
				$mer->idDepartamento->setSort("");
				$mer->idMunicipio->setSort("");
				$mer->idComunidad->setSort("");
				$mer->idRubro->setSort("");
				$mer->mer->setSort("");
				$mer->fechaInicio->setSort("");
				$mer->fechaFinal->setSort("");
				$mer->estado->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$mer->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $mer;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$mer->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$mer->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $mer->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$mer->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$mer->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$mer->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $mer;

		// Call Recordset Selecting event
		$mer->Recordset_Selecting($mer->CurrentFilter);

		// Load list page SQL
		$sSql = $mer->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$mer->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $mer;
		$sFilter = $mer->KeyFilter();

		// Call Row Selecting event
		$mer->Row_Selecting($sFilter);

		// Load sql based on filter
		$mer->CurrentFilter = $sFilter;
		$sSql = $mer->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$mer->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $mer;
		$mer->idMer->setDbValue($rs->fields('idMer'));
		$mer->idRegional->setDbValue($rs->fields('idRegional'));
		$mer->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$mer->idMunicipio->setDbValue($rs->fields('idMunicipio'));
		$mer->idComunidad->setDbValue($rs->fields('idComunidad'));
		$mer->idRubro->setDbValue($rs->fields('idRubro'));
		$mer->mer->setDbValue($rs->fields('mer'));
		$mer->unidadProductivaDedica->setDbValue($rs->fields('unidadProductivaDedica'));
		$mer->codigo->setDbValue($rs->fields('codigo'));
		$mer->numeroSocios->setDbValue($rs->fields('numeroSocios'));
		$mer->direccion->setDbValue($rs->fields('direccion'));
		$mer->zona->setDbValue($rs->fields('zona'));
		$mer->referencia->setDbValue($rs->fields('referencia'));
		$mer->refTelefonica->setDbValue($rs->fields('refTelefonica'));
		$mer->refCelular->setDbValue($rs->fields('refCelular'));
		$mer->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$mer->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$mer->longitudUTM->setDbValue($rs->fields('longitudUTM'));
		$mer->latitudUTM->setDbValue($rs->fields('latitudUTM'));
		$mer->gestion->setDbValue($rs->fields('gestion'));
		$mer->estado->setDbValue($rs->fields('estado'));
		$mer->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$mer->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $mer;

		// Call Row_Rendering event
		$mer->Row_Rendering();

		// Common render codes for all row types
		// idMer

		$mer->idMer->CellCssStyle = "";
		$mer->idMer->CellCssClass = "";

		// idRegional
		$mer->idRegional->CellCssStyle = "";
		$mer->idRegional->CellCssClass = "";

		// idDepartamento
		$mer->idDepartamento->CellCssStyle = "";
		$mer->idDepartamento->CellCssClass = "";

		// idMunicipio
		$mer->idMunicipio->CellCssStyle = "";
		$mer->idMunicipio->CellCssClass = "";

		// idComunidad
		$mer->idComunidad->CellCssStyle = "";
		$mer->idComunidad->CellCssClass = "";

		// idRubro
		$mer->idRubro->CellCssStyle = "";
		$mer->idRubro->CellCssClass = "";

		// mer
		$mer->mer->CellCssStyle = "";
		$mer->mer->CellCssClass = "";

		// fechaInicio
		$mer->fechaInicio->CellCssStyle = "";
		$mer->fechaInicio->CellCssClass = "";

		// fechaFinal
		$mer->fechaFinal->CellCssStyle = "";
		$mer->fechaFinal->CellCssClass = "";

		// estado
		$mer->estado->CellCssStyle = "white-space: nowrap;";
		$mer->estado->CellCssClass = "";
		if ($mer->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$mer->idMer->ViewValue = $mer->idMer->CurrentValue;
			$mer->idMer->CssStyle = "";
			$mer->idMer->CssClass = "";
			$mer->idMer->ViewCustomAttributes = "";

			// idRegional
			if (strval($mer->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($mer->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$mer->idRegional->ViewValue = $mer->idRegional->CurrentValue;
				}
			} else {
				$mer->idRegional->ViewValue = NULL;
			}
			$mer->idRegional->CssStyle = "";
			$mer->idRegional->CssClass = "";
			$mer->idRegional->ViewCustomAttributes = "";

			// idDepartamento
			if (strval($mer->idDepartamento->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `departamento` FROM `departamento` WHERE `idDepartamento` = " . ew_AdjustSql($mer->idDepartamento->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `departamento` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idDepartamento->ViewValue = $rswrk->fields('departamento');
					$rswrk->Close();
				} else {
					$mer->idDepartamento->ViewValue = $mer->idDepartamento->CurrentValue;
				}
			} else {
				$mer->idDepartamento->ViewValue = NULL;
			}
			$mer->idDepartamento->CssStyle = "";
			$mer->idDepartamento->CssClass = "";
			$mer->idDepartamento->ViewCustomAttributes = "";

			// idMunicipio
			if (strval($mer->idMunicipio->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `municipio` FROM `municipio` WHERE `idMunicipio` = " . ew_AdjustSql($mer->idMunicipio->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `municipio` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idMunicipio->ViewValue = $rswrk->fields('municipio');
					$rswrk->Close();
				} else {
					$mer->idMunicipio->ViewValue = $mer->idMunicipio->CurrentValue;
				}
			} else {
				$mer->idMunicipio->ViewValue = NULL;
			}
			$mer->idMunicipio->CssStyle = "";
			$mer->idMunicipio->CssClass = "";
			$mer->idMunicipio->ViewCustomAttributes = "";

			// idComunidad
			if (strval($mer->idComunidad->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `comunidad` FROM `comunidad` WHERE `idComunidad` = " . ew_AdjustSql($mer->idComunidad->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `comunidad` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idComunidad->ViewValue = $rswrk->fields('comunidad');
					$rswrk->Close();
				} else {
					$mer->idComunidad->ViewValue = $mer->idComunidad->CurrentValue;
				}
			} else {
				$mer->idComunidad->ViewValue = NULL;
			}
			$mer->idComunidad->CssStyle = "";
			$mer->idComunidad->CssClass = "";
			$mer->idComunidad->ViewCustomAttributes = "";

			// idRubro
			if (strval($mer->idRubro->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `rubro` FROM `rubro` WHERE `idRubro` = " . ew_AdjustSql($mer->idRubro->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `rubro` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idRubro->ViewValue = $rswrk->fields('rubro');
					$rswrk->Close();
				} else {
					$mer->idRubro->ViewValue = $mer->idRubro->CurrentValue;
				}
			} else {
				$mer->idRubro->ViewValue = NULL;
			}
			$mer->idRubro->CssStyle = "";
			$mer->idRubro->CssClass = "";
			$mer->idRubro->ViewCustomAttributes = "";

			// mer
			$mer->mer->ViewValue = $mer->mer->CurrentValue;
			$mer->mer->CssStyle = "";
			$mer->mer->CssClass = "";
			$mer->mer->ViewCustomAttributes = "";

			// fechaInicio
			$mer->fechaInicio->ViewValue = $mer->fechaInicio->CurrentValue;
			$mer->fechaInicio->ViewValue = ew_FormatDateTime($mer->fechaInicio->ViewValue, 7);
			$mer->fechaInicio->CssStyle = "";
			$mer->fechaInicio->CssClass = "";
			$mer->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$mer->fechaFinal->ViewValue = $mer->fechaFinal->CurrentValue;
			$mer->fechaFinal->ViewValue = ew_FormatDateTime($mer->fechaFinal->ViewValue, 7);
			$mer->fechaFinal->CssStyle = "";
			$mer->fechaFinal->CssClass = "";
			$mer->fechaFinal->ViewCustomAttributes = "";

			// estado
			if (strval($mer->estado->CurrentValue) <> "") {
				switch ($mer->estado->CurrentValue) {
					case "0":
						$mer->estado->ViewValue = "Borrado";
						break;
					case "1":
						$mer->estado->ViewValue = "Habilitado";
						break;
					case "2":
						$mer->estado->ViewValue = "Desabilitado";
						break;
					default:
						$mer->estado->ViewValue = $mer->estado->CurrentValue;
				}
			} else {
				$mer->estado->ViewValue = NULL;
			}
			$mer->estado->CssStyle = "";
			$mer->estado->CssClass = "";
			$mer->estado->ViewCustomAttributes = "";

			// idMer
			$mer->idMer->HrefValue = "";

			// idRegional
			$mer->idRegional->HrefValue = "";

			// idDepartamento
			$mer->idDepartamento->HrefValue = "";

			// idMunicipio
			$mer->idMunicipio->HrefValue = "";

			// idComunidad
			$mer->idComunidad->HrefValue = "";

			// idRubro
			$mer->idRubro->HrefValue = "";

			// mer
			$mer->mer->HrefValue = "";

			// fechaInicio
			$mer->fechaInicio->HrefValue = "";

			// fechaFinal
			$mer->fechaFinal->HrefValue = "";

			// estado
			$mer->estado->HrefValue = "";
		}

		// Call Row Rendered event
		$mer->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $mer;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($mer->ExportAll) {
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
		if ($mer->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($mer->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $mer->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idMer', $mer->Export);
				ew_ExportAddValue($sExportStr, 'idRegional', $mer->Export);
				ew_ExportAddValue($sExportStr, 'idDepartamento', $mer->Export);
				ew_ExportAddValue($sExportStr, 'idMunicipio', $mer->Export);
				ew_ExportAddValue($sExportStr, 'idComunidad', $mer->Export);
				ew_ExportAddValue($sExportStr, 'idRubro', $mer->Export);
				ew_ExportAddValue($sExportStr, 'mer', $mer->Export);
				ew_ExportAddValue($sExportStr, 'fechaInicio', $mer->Export);
				ew_ExportAddValue($sExportStr, 'fechaFinal', $mer->Export);
				echo ew_ExportLine($sExportStr, $mer->Export);
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
				$mer->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($mer->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idMer', $mer->idMer->CurrentValue);
					$XmlDoc->AddField('idRegional', $mer->idRegional->CurrentValue);
					$XmlDoc->AddField('idDepartamento', $mer->idDepartamento->CurrentValue);
					$XmlDoc->AddField('idMunicipio', $mer->idMunicipio->CurrentValue);
					$XmlDoc->AddField('idComunidad', $mer->idComunidad->CurrentValue);
					$XmlDoc->AddField('idRubro', $mer->idRubro->CurrentValue);
					$XmlDoc->AddField('mer', $mer->mer->CurrentValue);
					$XmlDoc->AddField('fechaInicio', $mer->fechaInicio->CurrentValue);
					$XmlDoc->AddField('fechaFinal', $mer->fechaFinal->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $mer->Export <> "csv") { // Vertical format
						echo ew_ExportField('idMer', $mer->idMer->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						echo ew_ExportField('idRegional', $mer->idRegional->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						echo ew_ExportField('idDepartamento', $mer->idDepartamento->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						echo ew_ExportField('idMunicipio', $mer->idMunicipio->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						echo ew_ExportField('idComunidad', $mer->idComunidad->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						echo ew_ExportField('idRubro', $mer->idRubro->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						echo ew_ExportField('mer', $mer->mer->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						echo ew_ExportField('fechaInicio', $mer->fechaInicio->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						echo ew_ExportField('fechaFinal', $mer->fechaFinal->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $mer->idMer->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						ew_ExportAddValue($sExportStr, $mer->idRegional->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						ew_ExportAddValue($sExportStr, $mer->idDepartamento->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						ew_ExportAddValue($sExportStr, $mer->idMunicipio->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						ew_ExportAddValue($sExportStr, $mer->idComunidad->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						ew_ExportAddValue($sExportStr, $mer->idRubro->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						ew_ExportAddValue($sExportStr, $mer->mer->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						ew_ExportAddValue($sExportStr, $mer->fechaInicio->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						ew_ExportAddValue($sExportStr, $mer->fechaFinal->ExportValue($mer->Export, $mer->ExportOriginalValue), $mer->Export);
						echo ew_ExportLine($sExportStr, $mer->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($mer->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($mer->Export);
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
