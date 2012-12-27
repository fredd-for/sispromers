<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "formularioinfo.php" ?>
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
$formulario_list = new cformulario_list();
$Page =& $formulario_list;

// Page init processing
$formulario_list->Page_Init();

// Page main processing
$formulario_list->Page_Main();
?>
<script type="text/javascript" charset="utf-8">
    Date.firstDayOfWeek = 0;
    Date.format = 'dd-mm-yyyy';
    $(function(){
        $('.date-pick').datePicker({createButton:false,startDate:'01-01-1990'})
        .bind('click',
        function(){
            $(this).dpDisplay();
            this.blur();
            return false;
        }
    );
    });
    //Formato del calendario
</script>
<script type="text/javascript">
    var x=$(document);
    x.ready(inicializarEventos);
    function inicializarEventos()
    {
        
        var tipoContrato=$("#x_tipoContrato");
        tipoContrato.blur(presion12);
        var descripcion=$("#x_descripcion");
        descripcion.blur(presion12);
        var unidad=$("#x_unidad");
        unidad.blur(presion12);
        var precioUnitario=$("#x_precioUnitario");
        precioUnitario.blur(presion12);
        var cantidad=$("#x_cantidad");
        cantidad.blur(presion12);
        var costoTotal=$("#x_costoTotal");
        costoTotal.blur(presion12);
        var fechaInicial=$("#x_fechaInicial");
        fechaInicial.change(presion12);
        var fechaFinal=$("#x_fechaFinal");
        fechaFinal.change(presion12);

    }

    function presion12()
    {
        var t=$("#x_tipoContrato").attr("value");
        var x=$("#x_descripcion").attr("value");
        var y=$("#x_unidad").attr("value");
        var z=$("#x_precioUnitario").attr("value");
        var w=$("#x_cantidad").attr("value");
        var s=$("#x_costoTotal");
        var r=$("#x_fechaInicial").attr("value");
        var p=$("#x_fechaFinal").attr("value");
        var q=$("#x_cumple");
        if(t && x && y && z && w && s && r && p){ q.attr("value","SI");}
        else{q.attr("value","NO");}
        s.attr("value",w*z);
    }
</script>
<?php 
if($_GET['idPlanilla']=='12'){
    mysql_select_db($database_conexion, $conexion);
    $query_formulario12 = "SELECT * FROM formulario12 WHERE idFormulario12='".(int)$_GET['x_idFormulario12']."'";
    $mostrar_formulario12= mysql_query($query_formulario12, $conexion) or die(mysql_error());
    $row_formulario12=mysql_fetch_assoc($mostrar_formulario12);
    ?>
<form method="post" action="formulario_guardar.php" id="formulario12">
    <table cellspacing="0" class="ewGrid">
        <tr class="ewTableHeader">
    <td>No</td>
    <td>Tipo de Contrato</td>
    <td>Descripcion del Contrato</td>
    <td>Unid.</td>
    <td>P.U. Bs.</td>
    <td>Cant.</td>
    <td>Costo Total Bs.</td>
    <td>Fecha Inicial</td>
    <td>Fecha Finalizacion</td>
    <td>Cumple</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
        </tr>
        <tr>
        <input type="hidden" name="x_idPlanilla" id="x_idPlanilla" value="<?php echo $_GET['idPlanilla']?>">
        <input type="hidden" name="x_idMer" id="x_idMer" value="<?php echo $_GET['idMer']?>">
        <input type="hidden" name="x_idFormulario12" id="x_idFormulario12" value="<?php echo $_GET['x_idFormulario12']?>">
        <input type="hidden" name="sw" id="sw" value="<?php echo $_GET['sw']?>">
        <td>&nbsp;</td>
        <td>
            <select name="x_tipoContrato" id="x_tipoContrato">
                <option>Seleccione...</option>
                <option value="1" <?php if($row_formulario12['tipoContrato']=='1'){echo "selected";}?>>Municipio-Mers</option>
                <option value="2" <?php if($row_formulario12['tipoContrato']=='2'){echo "selected";}?>>Privado-Privado</option>
                <option value="3" <?php if($row_formulario12['tipoContrato']=='3'){echo "selected";}?>>Publico-Privado</option>
            </select>
        </td>
        <td><input type="text" size="30" name="x_descripcion" id="x_descripcion" value="<?php echo $row_formulario12['descripcion'];?>"></td>
        <td><input type="text" size="5" name="x_unidad" id="x_unidad" value="<?php echo $row_formulario12['unidad'];?>"></td>
        <td><input type="text" size="5" name="x_precioUnitario" id="x_precioUnitario" value="<?php echo $row_formulario12['precioUnitario'];?>"></td>
        <td><input type="text" size="5" name="x_cantidad" id="x_cantidad" value="<?php echo $row_formulario12['cantidad'];?>"></td>
        <td><input type="text" size="5" name="x_costoTotal" id="x_costoTotal" value="<?php echo $row_formulario12['costoTotal'];?>" readonly></td>
        <td><input type="text" name="x_fechaInicial" id="x_fechaInicial" class="date-pick" size="12" <?php if($row_formulario12['fechaInicial']!='0000-00-00' && $row_formulario12['fechaInicial']) {
    echo "value=".date("d-m-Y",strtotime($row_formulario12['fechaInicial']));
}?>></td>
        <td><input type="text" name="x_fechaFinal" id="x_fechaFinal" class="date-pick" size="12" <?php if($row_formulario12['fechaFinal']!='0000-00-00' && $row_formulario12['fechaFinal']) {
    echo "value=".date("d-m-Y",strtotime($row_formulario12['fechaFinal']));
}?>></td>
        <td><input type="text" name="x_cumple" id="x_cumple" value="<?php echo $row_formulario12['cumple'] ?>" size="5" readonly></td>
        <td><input type="submit" name="guardar" id="guardar" value="Guardar"></td><td><input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cancelar();"></td>
        </tr>
        </table>
</form>
<script language="javascript" type="text/javascript">
    $(document).ready(function(){
        $("#formulario12").validate({
            rules:{
                x_precioUnitario:{number:true},
                x_cantidad:{number:true},
                x_costoTotal:{number:true},
                x_fechaInicial:{date:true},
                x_fechaFinal:{date:true}
            },
            messages: {
                x_precioUnitario:"valor numerico",
                x_cantidad:"valor numerico",
                x_costoTotal:"valor numerico",
                x_fechaInicio:"fecha Incorrecta",
                x_fechaFinal:"fecha Incorrecta"
            },
            onkeyup: false,
            submitHandler: function(form) {
                //                var respuesta = confirm('\xBFEsta seguro de realizar la operacion?')
                //                if (respuesta)
                form.submit();
            }
        });
    });

</script>
<?php } ?>

<?php

//
// Page Class
//
class cformulario_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'formulario';

	// Page Object Name
	var $PageObjName = 'formulario_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $formulario;
		if ($formulario->UseTokenInUrl) $PageUrl .= "t=" . $formulario->TableVar . "&"; // add page token
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
		global $objForm, $formulario;
		if ($formulario->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($formulario->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($formulario->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cformulario_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["formulario"] = new cformulario();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'formulario', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $formulario;
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
	$formulario->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $formulario->Export; // Get export parameter, used in header
	$gsExportFile = $formulario->TableVar; // Get export file, used in header
	if ($formulario->Export == "print" || $formulario->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($formulario->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $formulario;
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
		if ($formulario->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $formulario->getRecordsPerPage(); // Restore from Session
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
		$formulario->setSessionWhere($sFilter);
		$formulario->CurrentFilter = "";

		// Export data only
		if (in_array($formulario->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $formulario;
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
			$formulario->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$formulario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $formulario;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$formulario->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$formulario->CurrentOrderType = @$_GET["ordertype"];
			$formulario->UpdateSort($formulario->idFormulario); // Field
			$formulario->UpdateSort($formulario->idMer); // Field
			$formulario->UpdateSort($formulario->idPlanilla); // Field
			$formulario->UpdateSort($formulario->archivo); // Field
			$formulario->UpdateSort($formulario->cuenta); // Field
			$formulario->UpdateSort($formulario->porcentaje); // Field
			$formulario->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $formulario;
		$sOrderBy = $formulario->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($formulario->SqlOrderBy() <> "") {
				$sOrderBy = $formulario->SqlOrderBy();
				$formulario->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $formulario;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$formulario->setSessionOrderBy($sOrderBy);
				$formulario->idFormulario->setSort("");
				$formulario->idMer->setSort("");
				$formulario->idPlanilla->setSort("");
				$formulario->archivo->setSort("");
				$formulario->cuenta->setSort("");
				$formulario->porcentaje->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$formulario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $formulario;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$formulario->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$formulario->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $formulario->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$formulario->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$formulario->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$formulario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $formulario;

		// Call Recordset Selecting event
		$formulario->Recordset_Selecting($formulario->CurrentFilter);

		// Load list page SQL
		$sSql = $formulario->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$formulario->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $formulario;
		$sFilter = $formulario->KeyFilter();

		// Call Row Selecting event
		$formulario->Row_Selecting($sFilter);

		// Load sql based on filter
		$formulario->CurrentFilter = $sFilter;
		$sSql = $formulario->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$formulario->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $formulario;
		$formulario->idFormulario->setDbValue($rs->fields('idFormulario'));
		$formulario->idMer->setDbValue($rs->fields('idMer'));
		$formulario->idPlanilla->setDbValue($rs->fields('idPlanilla'));
		$formulario->archivo->setDbValue($rs->fields('archivo'));
		$formulario->cuenta->setDbValue($rs->fields('cuenta'));
		$formulario->porcentaje->setDbValue($rs->fields('porcentaje'));
		$formulario->observacion->setDbValue($rs->fields('observacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $formulario;

		// Call Row_Rendering event
		$formulario->Row_Rendering();

		// Common render codes for all row types
		// idFormulario

		$formulario->idFormulario->CellCssStyle = "";
		$formulario->idFormulario->CellCssClass = "";

		// idMer
		$formulario->idMer->CellCssStyle = "";
		$formulario->idMer->CellCssClass = "";

		// idPlanilla
		$formulario->idPlanilla->CellCssStyle = "";
		$formulario->idPlanilla->CellCssClass = "";

		// archivo
		$formulario->archivo->CellCssStyle = "";
		$formulario->archivo->CellCssClass = "";

		// cuenta
		$formulario->cuenta->CellCssStyle = "";
		$formulario->cuenta->CellCssClass = "";

		// porcentaje
		$formulario->porcentaje->CellCssStyle = "";
		$formulario->porcentaje->CellCssClass = "";
		if ($formulario->RowType == EW_ROWTYPE_VIEW) { // View row

			// idFormulario
			$formulario->idFormulario->ViewValue = $formulario->idFormulario->CurrentValue;
			$formulario->idFormulario->CssStyle = "";
			$formulario->idFormulario->CssClass = "";
			$formulario->idFormulario->ViewCustomAttributes = "";

			// idMer
			$formulario->idMer->ViewValue = $formulario->idMer->CurrentValue;
			$formulario->idMer->CssStyle = "";
			$formulario->idMer->CssClass = "";
			$formulario->idMer->ViewCustomAttributes = "";

			// idPlanilla
			$formulario->idPlanilla->ViewValue = $formulario->idPlanilla->CurrentValue;
			$formulario->idPlanilla->CssStyle = "";
			$formulario->idPlanilla->CssClass = "";
			$formulario->idPlanilla->ViewCustomAttributes = "";

			// archivo
			$formulario->archivo->ViewValue = $formulario->archivo->CurrentValue;
			$formulario->archivo->CssStyle = "";
			$formulario->archivo->CssClass = "";
			$formulario->archivo->ViewCustomAttributes = "";

			// cuenta
			$formulario->cuenta->ViewValue = $formulario->cuenta->CurrentValue;
			$formulario->cuenta->CssStyle = "";
			$formulario->cuenta->CssClass = "";
			$formulario->cuenta->ViewCustomAttributes = "";

			// porcentaje
			$formulario->porcentaje->ViewValue = $formulario->porcentaje->CurrentValue;
			$formulario->porcentaje->CssStyle = "";
			$formulario->porcentaje->CssClass = "";
			$formulario->porcentaje->ViewCustomAttributes = "";

			// idFormulario
			$formulario->idFormulario->HrefValue = "";

			// idMer
			$formulario->idMer->HrefValue = "";

			// idPlanilla
			$formulario->idPlanilla->HrefValue = "";

			// archivo
			$formulario->archivo->HrefValue = "";

			// cuenta
			$formulario->cuenta->HrefValue = "";

			// porcentaje
			$formulario->porcentaje->HrefValue = "";
		}

		// Call Row Rendered event
		$formulario->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $formulario;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($formulario->ExportAll) {
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
		if ($formulario->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($formulario->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $formulario->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idFormulario', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'idMer', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'idPlanilla', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'archivo', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'cuenta', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'porcentaje', $formulario->Export);
				echo ew_ExportLine($sExportStr, $formulario->Export);
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
				$formulario->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($formulario->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idFormulario', $formulario->idFormulario->CurrentValue);
					$XmlDoc->AddField('idMer', $formulario->idMer->CurrentValue);
					$XmlDoc->AddField('idPlanilla', $formulario->idPlanilla->CurrentValue);
					$XmlDoc->AddField('archivo', $formulario->archivo->CurrentValue);
					$XmlDoc->AddField('cuenta', $formulario->cuenta->CurrentValue);
					$XmlDoc->AddField('porcentaje', $formulario->porcentaje->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $formulario->Export <> "csv") { // Vertical format
						echo ew_ExportField('idFormulario', $formulario->idFormulario->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('idMer', $formulario->idMer->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('idPlanilla', $formulario->idPlanilla->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('archivo', $formulario->archivo->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('cuenta', $formulario->cuenta->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('porcentaje', $formulario->porcentaje->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $formulario->idFormulario->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->idMer->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->idPlanilla->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->archivo->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->cuenta->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->porcentaje->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportLine($sExportStr, $formulario->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($formulario->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($formulario->Export);
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