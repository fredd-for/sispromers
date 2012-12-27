<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "indicador_impactoinfo.php" ?>
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
$indicador_impacto_list = new cindicador_impacto_list();
$Page =& $indicador_impacto_list;

// Page init processing
$indicador_impacto_list->Page_Init();

// Page main processing
$indicador_impacto_list->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
    var x=$(document);
    x.ready(inicializarEventos);
    function inicializarEventos()
    { var x=$("#contIndicador").attr("value");
      var y=$("#num_contratos");
      y.text(x);
    }

</script>
<script type="text/javascript">
    $(function () {
        $('input#id_search').quicksearch('table table#table_example #contenidoTbody tr');
    });
</script>
<span class="phpmaker" style="white-space: nowrap;">
<?php if ($Reporte_Mers->Export == "") { ?>
<div id="linkDescargar"></div>
    <?php } ?>
<?php
if ($Reporte_Mers->Export == "") {
mysql_select_db($database_conexion, $conexion);
$query_mer = "SELECT a.idMer, b.regional, c.departamento, d.municipio, e.comunidad, a.zona, f.rubro, a.mer, a.gestion FROM mer a, regional b, departamento c, municipio d, comunidad e, rubro f WHERE a.idRegional = b.idRegional And a.idDepartamento = c.idDepartamento And a.idMunicipio = d.idMunicipio And a.idComunidad = e.idComunidad And a.idRubro = f.idRubro And a.estado > 0 ORDER BY b.regional ASC";
$mostrar_mer=mysql_query($query_mer, $conexion) or die(mysql_error());
$totalRows_mer=mysql_num_rows($mostrar_mer);
$contador=1;
}
?>
</span>
<div id="div_formulario">
    <table><tr style="background: #667120; color:#ffffff; font-size: 15px"><th colspan="2">INDICADOR IMPACTO:</th><td colspan="10">A los dos a&ntilde;os de finalizado el proyecto, al menos 80% de las 115 MERS beneficiarias mantienen sus servicios</td></tr></table>
 <br>
<?php if ($Reporte_Mers->Export == "") { ?>
 <table>
     <tr><td colspan="6">
             <div><form action="#">
 BUSCAR= <input type="text" name="search" value="" id="id_search" size="50"/>
 </form></div>
             </td>
             <td colspan="10">Numero de Mers con Contrato de Venta/Servicios: <strong id="num_contratos"></strong></td>
     </tr>
 </table>
 <?php } ?>
 <table id="table_example" width="100%" border="1" class="ewTable">
    <thead>
    <tr>
        <th bgcolor="#B8C692"></th>
        <th colspan="5" align="center" bgcolor="#B8C692">INFORME GEOGRAFICO</th>
        <th colspan="4" align="center" bgcolor="#b8c2a5">DATOS DE LA MERS</th>
        <th colspan="2" align="center" bgcolor="#b8f5e0">DOCUMENTO</th>
        <th colspan="1" align="center" bgcolor="#b89ec1">INDICADOR</th>
    </tr>
    <tr class="ewTableHeader">
        <th>Nro</th>
        <th>Regional</th>
        <th>Departamento</th>
        <th>Municipio</th>
        <th>Comunidad</th>
        <th>Zona</th>
        <th>Rubro</th>
        <th>Razon Social de la Mers</th>
        <th>Responsable de la Mers</th>
        <th>Gesti&oacute;n</th>
        <th>Nro de Contratos</th>
        <th>Contratos de Venta/Servicios</th>
        <th>Valor</th>
    </tr>
</thead>
<tbody id="contenidoTbody">
<?php if ($Reporte_Mers->Export == "") { ?>
<?php
$contIndicador=0;
while ($row_mer=mysql_fetch_assoc($mostrar_mer)){

mysql_select_db($database_conexion, $conexion);
$query_responsable = "SELECT b.nombre, b.materno, b.paterno FROM responsable a, usuario b WHERE a.idMer='".$row_mer['idMer']."' AND a.idGerente=b.idUsuario ORDER BY b.paterno asc";
$mostrar_responsable=mysql_query($query_responsable, $conexion) or die(mysql_error());
$totalRows_responsable=mysql_num_rows($mostrar_responsable);

mysql_select_db($database_conexion, $conexion);
$query_formulario1 = "SELECT * FROM formulario WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=1";
$mostrar_formulario1= mysql_query($query_formulario1, $conexion) or die(mysql_error());
$row_formulario1= mysql_fetch_assoc($mostrar_formulario1);

mysql_select_db($database_conexion, $conexion);
$query_numeroContratos = "SELECT count(completo) as completo FROM contrato_llenar WHERE idMer='".$row_mer['idMer']."' AND idPlanilla=1 AND completo='SI'";
$mostrar_numeroContratos= mysql_query($query_numeroContratos, $conexion) or die(mysql_error());
$row_numeroContratos= mysql_fetch_assoc($mostrar_numeroContratos);
?>
<tr <?php if($contador%2==0){echo "bgcolor='#F1F1F1'";}?>>
<td><?php echo $contador;?></td>
        <td><?php echo $row_mer['regional'];?></td>
        <td><?php echo $row_mer['departamento'];?></td>
        <td><?php echo $row_mer['municipio'];?></td>
        <td><?php echo $row_mer['comunidad'];?></td>
        <td><?php echo $row_mer['zona'];?></td>
        <td><?php echo $row_mer['rubro'];?></td>
        <td><?php echo $row_mer['mer'];?></td>
        <td><?php
        $color=1;
        while ($row_responsable=mysql_fetch_assoc($mostrar_responsable)){ ?>
            <div <?php if($color%2==0){echo "style='background:#d7d3c8'";}?>><?php echo $row_responsable['paterno']." ".$row_responsable['materno'].", ".$row_responsable['nombre']."</div>";
        $color++;
        }?>
        </td>
        <td><?php echo $row_mer['gestion'];?></td>
        <td><?php if($row_numeroContratos['completo']>0)echo $row_numeroContratos['completo'];?></td>
        <td><?php echo $row_formulario1['cuenta']; ?></td>
        <td><?php if($row_formulario1['cuenta']=='SI'){echo '1';$contIndicador=$contIndicador+1;}else{echo '0';}?></td>
    </tr>
<?php
$contador++;
}
?>

    <input type="hidden" name="contIndicador" id="contIndicador" value="<?php echo $contIndicador; ?>">
<?php } ?>
</tbody>
 </table>

</div>
<script type="text/javascript" language="javascript">
<!--
//Free Memory allow case
x320001();
-->
</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cindicador_impacto_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'indicador_impacto';

	// Page Object Name
	var $PageObjName = 'indicador_impacto_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $indicador_impacto;
		if ($indicador_impacto->UseTokenInUrl) $PageUrl .= "t=" . $indicador_impacto->TableVar . "&"; // add page token
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
		global $objForm, $indicador_impacto;
		if ($indicador_impacto->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($indicador_impacto->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($indicador_impacto->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cindicador_impacto_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["indicador_impacto"] = new cindicador_impacto();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'indicador_impacto', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $indicador_impacto;
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
	$indicador_impacto->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $indicador_impacto->Export; // Get export parameter, used in header
	$gsExportFile = $indicador_impacto->TableVar; // Get export file, used in header
	if ($indicador_impacto->Export == "print" || $indicador_impacto->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($indicador_impacto->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $indicador_impacto;
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
		if ($indicador_impacto->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $indicador_impacto->getRecordsPerPage(); // Restore from Session
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
		$indicador_impacto->setSessionWhere($sFilter);
		$indicador_impacto->CurrentFilter = "";

		// Export data only
		if (in_array($indicador_impacto->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $indicador_impacto;
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
			$indicador_impacto->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$indicador_impacto->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $indicador_impacto;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$indicador_impacto->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$indicador_impacto->CurrentOrderType = @$_GET["ordertype"];
			$indicador_impacto->UpdateSort($indicador_impacto->idMer); // Field 
			$indicador_impacto->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $indicador_impacto;
		$sOrderBy = $indicador_impacto->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($indicador_impacto->SqlOrderBy() <> "") {
				$sOrderBy = $indicador_impacto->SqlOrderBy();
				$indicador_impacto->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $indicador_impacto;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$indicador_impacto->setSessionOrderBy($sOrderBy);
				$indicador_impacto->idMer->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$indicador_impacto->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $indicador_impacto;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$indicador_impacto->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$indicador_impacto->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $indicador_impacto->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$indicador_impacto->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$indicador_impacto->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$indicador_impacto->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $indicador_impacto;

		// Call Recordset Selecting event
		$indicador_impacto->Recordset_Selecting($indicador_impacto->CurrentFilter);

		// Load list page SQL
		$sSql = $indicador_impacto->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$indicador_impacto->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $indicador_impacto;
		$sFilter = $indicador_impacto->KeyFilter();

		// Call Row Selecting event
		$indicador_impacto->Row_Selecting($sFilter);

		// Load sql based on filter
		$indicador_impacto->CurrentFilter = $sFilter;
		$sSql = $indicador_impacto->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$indicador_impacto->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $indicador_impacto;
		$indicador_impacto->idMer->setDbValue($rs->fields('idMer'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $indicador_impacto;

		// Call Row_Rendering event
		$indicador_impacto->Row_Rendering();

		// Common render codes for all row types
		// idMer

		$indicador_impacto->idMer->CellCssStyle = "";
		$indicador_impacto->idMer->CellCssClass = "";
		if ($indicador_impacto->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$indicador_impacto->idMer->ViewValue = $indicador_impacto->idMer->CurrentValue;
			$indicador_impacto->idMer->CssStyle = "";
			$indicador_impacto->idMer->CssClass = "";
			$indicador_impacto->idMer->ViewCustomAttributes = "";

			// idMer
			$indicador_impacto->idMer->HrefValue = "";
		}

		// Call Row Rendered event
		$indicador_impacto->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $indicador_impacto;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($indicador_impacto->ExportAll) {
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
		if ($indicador_impacto->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($indicador_impacto->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $indicador_impacto->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idMer', $indicador_impacto->Export);
				echo ew_ExportLine($sExportStr, $indicador_impacto->Export);
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
				$indicador_impacto->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($indicador_impacto->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idMer', $indicador_impacto->idMer->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $indicador_impacto->Export <> "csv") { // Vertical format
						echo ew_ExportField('idMer', $indicador_impacto->idMer->ExportValue($indicador_impacto->Export, $indicador_impacto->ExportOriginalValue), $indicador_impacto->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $indicador_impacto->idMer->ExportValue($indicador_impacto->Export, $indicador_impacto->ExportOriginalValue), $indicador_impacto->Export);
						echo ew_ExportLine($sExportStr, $indicador_impacto->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($indicador_impacto->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($indicador_impacto->Export);
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
