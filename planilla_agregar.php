<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "planillainfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php require_once('Connections/conexion.php'); ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$planilla_list = new cplanilla_list();
$Page =& $planilla_list;

// Page init processing
$planilla_list->Page_Init();

// Page main processing
$planilla_list->Page_Main();
?>

<?php
if($_GET['sw']=='tipoContratoedit') {
    mysql_select_db($database_conexion, $conexion);
    $query_tipoContrato = "SELECT * FROM tipo_contrato WHERE idTipoContrato='".$_GET['idTipoContrato']."'";
    $mostrar_tipoContrato = mysql_query($query_tipoContrato, $conexion) or die(mysql_error());
    $row_tipoContrato=mysql_fetch_assoc($mostrar_tipoContrato);
}
if($_GET['sw']=='registroContratoedit') {
    mysql_select_db($database_conexion, $conexion);
    $query_registroContrato = "SELECT * FROM registro_contrato WHERE idRegistroContrato='".$_GET['idRegistroContrato']."'";
    $mostrar_registroContrato = mysql_query($query_registroContrato, $conexion) or die(mysql_error());
    $row_registroContrato=mysql_fetch_assoc($mostrar_registroContrato);
}
if($_GET['sw']=='preguntaedit') {
    mysql_select_db($database_conexion, $conexion);
    $query_pregunta = "SELECT * FROM pregunta WHERE idPregunta='".$_GET['idPregunta']."'";
    $mostrar_pregunta = mysql_query($query_pregunta, $conexion) or die(mysql_error());
    $row_pregunta=mysql_fetch_assoc($mostrar_pregunta);
}
?>
<form method="post" action="planilla_guardar.php" id="formulario">
    <table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
                <div class="ewGridMiddlePanel">
                    <table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
                        <tr>
                        <input type="hidden" name="x_idPlanilla" id="x_idPlanilla" value="<?php echo $_GET['idPlanilla']?>">
                        <input type="hidden" name="sw" id="sw" value="<?php echo $_GET['sw']?>">
                        <?php if($_GET['sw']=='tipoContratoedit') {?>
                        <input type="hidden" name="x_idTipoContrato" id="x_idTipoContrato" value="<?php echo $row_tipoContrato['idTipoContrato']?>">
                        <td><input type="text" name="x_tipoContrato" id="x_tipoContrato" size="50" class="required" value="<?php echo utf8_encode($row_tipoContrato['tipoContrato']);?>"></td>
                        <?php } if($_GET['sw']=='tipoContrato')  { ?>
                        <td><input type="text" name="x_tipoContrato" id="x_tipoContrato" size="50" class="required"></td>
                        <?php
                        } ?>
                        <?php if($_GET['sw']=='registroContratoedit') {?>
                        <input type="hidden" name="x_idRegistroContrato" id="x_idRegistroContrato" value="<?php echo $row_registroContrato['idRegistroContrato']?>">
                        <td><input type="text" name="x_registroContrato" id="x_registroContrato" size="50" class="required" value="<?php echo utf8_encode($row_registroContrato['registroContrato']);?>"></td>
                        <?php } if($_GET['sw']=='registroContrato') {?>
                        <td><input type="text" name="x_registroContrato" id="x_registroContrato" size="50" class="required"></td>
                        <?php
                        } ?>

                         <?php if($_GET['sw']=='preguntaedit') {?>
                        <input type="hidden" name="x_idPregunta" id="x_idPregunta" value="<?php echo $row_pregunta['idPregunta']?>">
                        <td><input type="text" name="x_pregunta" id="x_pregunta" size="50" class="required" value="<?php echo utf8_encode($row_pregunta['pregunta']);?>"></td>
                        <?php } if($_GET['sw']=='pregunta') {?>
                        <td><input type="text" name="x_pregunta" id="x_pregunta" size="50" class="required"></td>
                        <?php
                        } ?>

                         <td><input type="submit" name="guardar" id="guardar" value="Guardar"><input name="cancelar" type="button" id="cancelar" value="Cancelar" <?php if($_GET['sw']=='registroContrato' || $_GET['sw']=='registroContratoedit') { ?> onclick="fn_cancelarRegistroContrato();"<?php } if($_GET['sw']=='tipoContrato' || $_GET['sw']=='tipoContratoedit') {?> onclick="fn_cancelar();"<?php;} if($_GET['sw']=='pregunta' || $_GET['sw']=='preguntaedit') {?> onclick="fn_cancelarPregunta()" <?php } ?> /></td>
                        </tr>
                    </table>
                </div></td></tr></table>
</form>
<script language="javascript" type="text/javascript">
    $(document).ready(function(){
        $("#formulario").validate({
            rules:{
                x_tipoContrato: {required: true },
                x_registroContrato: {required: true},
                x_pregunta: {required: true}
                },
            messages: {
                x_tipoContrato: "ingrese datos",
                x_registroContrato: "ingrese datos",
                x_pregunta: "ingrese datos"
            },
            onkeyup: false,
            submitHandler: function(form) {
                var respuesta = confirm('\xBFEsta seguro de realizar la operacion?')
                if (respuesta)
                    form.submit();
            }
        });
    });


</script>

<?php

//
// Page Class
//
class cplanilla_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'planilla';

	// Page Object Name
	var $PageObjName = 'planilla_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $planilla;
		if ($planilla->UseTokenInUrl) $PageUrl .= "t=" . $planilla->TableVar . "&"; // add page token
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
		global $objForm, $planilla;
		if ($planilla->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($planilla->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($planilla->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cplanilla_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["planilla"] = new cplanilla();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'planilla', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $planilla;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->TableName);
		$Security->TablePermission_Loaded();
	$planilla->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $planilla->Export; // Get export parameter, used in header
	$gsExportFile = $planilla->TableVar; // Get export file, used in header
	if ($planilla->Export == "print" || $planilla->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($planilla->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $planilla;
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
		if ($planilla->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $planilla->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$planilla->setSessionWhere($sFilter);
		$planilla->CurrentFilter = "";

		// Export data only
		if (in_array($planilla->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $planilla;
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
			$planilla->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$planilla->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $planilla;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$planilla->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$planilla->CurrentOrderType = @$_GET["ordertype"];
			$planilla->UpdateSort($planilla->idPlanilla); // Field
			$planilla->UpdateSort($planilla->Nombre); // Field
			$planilla->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $planilla;
		$sOrderBy = $planilla->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($planilla->SqlOrderBy() <> "") {
				$sOrderBy = $planilla->SqlOrderBy();
				$planilla->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $planilla;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$planilla->setSessionOrderBy($sOrderBy);
				$planilla->idPlanilla->setSort("");
				$planilla->Nombre->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$planilla->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $planilla;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$planilla->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$planilla->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $planilla->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$planilla->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$planilla->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$planilla->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $planilla;

		// Call Recordset Selecting event
		$planilla->Recordset_Selecting($planilla->CurrentFilter);

		// Load list page SQL
		$sSql = $planilla->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$planilla->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $planilla;
		$sFilter = $planilla->KeyFilter();

		// Call Row Selecting event
		$planilla->Row_Selecting($sFilter);

		// Load sql based on filter
		$planilla->CurrentFilter = $sFilter;
		$sSql = $planilla->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$planilla->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $planilla;
		$planilla->idPlanilla->setDbValue($rs->fields('idPlanilla'));
		$planilla->Nombre->setDbValue($rs->fields('Nombre'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $planilla;

		// Call Row_Rendering event
		$planilla->Row_Rendering();

		// Common render codes for all row types
		// idPlanilla

		$planilla->idPlanilla->CellCssStyle = "";
		$planilla->idPlanilla->CellCssClass = "";

		// Nombre
		$planilla->Nombre->CellCssStyle = "";
		$planilla->Nombre->CellCssClass = "";
		if ($planilla->RowType == EW_ROWTYPE_VIEW) { // View row

			// idPlanilla
			$planilla->idPlanilla->ViewValue = $planilla->idPlanilla->CurrentValue;
			$planilla->idPlanilla->CssStyle = "";
			$planilla->idPlanilla->CssClass = "";
			$planilla->idPlanilla->ViewCustomAttributes = "";

			// Nombre
			$planilla->Nombre->ViewValue = $planilla->Nombre->CurrentValue;
			$planilla->Nombre->CssStyle = "";
			$planilla->Nombre->CssClass = "";
			$planilla->Nombre->ViewCustomAttributes = "";

			// idPlanilla
			$planilla->idPlanilla->HrefValue = "";

			// Nombre
			$planilla->Nombre->HrefValue = "";
		}

		// Call Row Rendered event
		$planilla->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $planilla;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($planilla->ExportAll) {
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
		if ($planilla->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($planilla->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $planilla->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idPlanilla', $planilla->Export);
				ew_ExportAddValue($sExportStr, 'Nombre', $planilla->Export);
				echo ew_ExportLine($sExportStr, $planilla->Export);
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
				$planilla->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($planilla->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idPlanilla', $planilla->idPlanilla->CurrentValue);
					$XmlDoc->AddField('Nombre', $planilla->Nombre->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $planilla->Export <> "csv") { // Vertical format
						echo ew_ExportField('idPlanilla', $planilla->idPlanilla->ExportValue($planilla->Export, $planilla->ExportOriginalValue), $planilla->Export);
						echo ew_ExportField('Nombre', $planilla->Nombre->ExportValue($planilla->Export, $planilla->ExportOriginalValue), $planilla->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $planilla->idPlanilla->ExportValue($planilla->Export, $planilla->ExportOriginalValue), $planilla->Export);
						ew_ExportAddValue($sExportStr, $planilla->Nombre->ExportValue($planilla->Export, $planilla->ExportOriginalValue), $planilla->Export);
						echo ew_ExportLine($sExportStr, $planilla->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($planilla->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($planilla->Export);
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