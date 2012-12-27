<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "reporte_seguimiento_consultoriainfo.php" ?>
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
$reporte_seguimiento_consultoria_list = new creporte_seguimiento_consultoria_list();
$Page =& $reporte_seguimiento_consultoria_list;

// Page init processing
$reporte_seguimiento_consultoria_list->Page_Init();

// Page main processing
$reporte_seguimiento_consultoria_list->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
    $(function () {
        $('input#id_search').quicksearch('#table_example #contenidoTbody #select_tr');
    });
</script>
<?php
function color_porcentaje($valor){
    if($valor>80){
        return '#D7E4BC';       //verde
    }
    if($valor<=80 && $valor>60){
        return '#fbffba';       // amarillo
    }
    if($valor<=60){
        return '#FEB0A0';       // rojo
    }
}
function color_estado($valor){
    if($valor=='Aprobado'){
        return '#D7E4BC';       //verde
    }
    if($valor=='Revision'){
        return '#fbffba';       // amarillo
    }
    if($valor=='Proceso' || $valor==''){
        return '#FEB0A0';       // rojo
    }
}
mysql_select_db($database_conexion, $conexion);
$query_consultoria= "SELECT a.idConsultoria,a.consultoria,a.fechaInicio,a.fechaFinal, b.paterno,b.materno,b.nombre
FROM consultoria AS a Inner Join usuario AS b ON a.idUsuario = b.idUsuario
WHERE a.estado>0";
$mostrar_consultoria=mysql_query($query_consultoria, $conexion) or die(mysql_error());
$total_consultoria=mysql_num_rows($mostrar_consultoria);
?>
            <div>
                    <fieldset>
                        BUSCAR= <input type="text" name="search" value="" id="id_search" size="50"/>
                    </fieldset>

            </div>
<table border='0' align='center' cellpadding='0' cellspacing='0' class='bordes' id="table_example">
    <thead>
    <tr bgcolor="#B8C692">
        <th>Nro</th>
        <th>Nombre Consultoria</th>
        <th >Resposanble</th>
        <th >Revisor(es)</th>
        <th >Cronograma</th>
        <th >%Cumplimiento</th>
        <th >Estado</th>
    </tr>
    </thead>
    <tbody id="contenidoTbody">
<?php 
$contador=1;
$blanco = '#FFFFFF';
$gris = '#F1FED8';
while($row_consultoria=mysql_fetch_assoc($mostrar_consultoria)){
 mysql_select_db($database_conexion, $conexion);
$query_cronograma= "SELECT a.idCronograma, a.detalle,(case a.estado when 1 then 'Proceso' when 2 then 'Revision' when 3 then 'Aprobado' end) as estado,a.porcentajeCumplimiento
 FROM cronograma AS a WHERE a.idConsultoria =".$row_consultoria['idConsultoria'];
$mostrar_cronograma=mysql_query($query_cronograma, $conexion) or die(mysql_error());
$row_cronograma=mysql_fetch_assoc($mostrar_cronograma);
$total_cronograma=mysql_num_rows($mostrar_cronograma);

mysql_select_db($database_conexion, $conexion);
$query_revisor= "SELECT b.nombre,b.paterno,b.materno FROM responsable_consultoria AS a Inner Join usuario AS b ON a.idUsuario = b.idUsuario WHERE a.idConsultoria =".$row_consultoria['idConsultoria'];
$mostrar_revisor=mysql_query($query_revisor, $conexion) or die(mysql_error());

                if ($contador % 2 == 0) {
                    $color = $blanco;
                }else
                    {$color=$gris;}
?>
        <tr bgcolor="<?php echo $color?>" id="select_tr">
        <td rowspan="<?php echo $total_cronograma?>"><?php echo $row_consultoria['idConsultoria']?></td>
        <td rowspan="<?php echo $total_cronograma?>"><?php echo $row_consultoria['consultoria']?></td>
        <td rowspan="<?php echo $total_cronograma?>"><?php echo $row_consultoria['paterno'].' '.$row_consultoria['materno'].' '.$row_consultoria['nombre']?></td>
        <td rowspan="<?php echo $total_cronograma?>">
<?php
while($row_revisor=mysql_fetch_assoc($mostrar_revisor)){?>
            <div> * <?php echo $row_revisor['paterno'].' '.$row_revisor['materno'].' '.$row_revisor['nombre']?></div>
<?php }
?>
        </td>
        <td><a href="avance_productolist.php?idConsultoria=<?php echo $row_consultoria['idConsultoria']?>&idCronograma=<?php echo $row_cronograma['idCronograma']?>"><?php echo $row_cronograma['detalle']?></a></td>
        <td bgcolor="<?php echo color_porcentaje($row_cronograma['porcentajeCumplimiento'])?>"><?php echo $row_cronograma['porcentajeCumplimiento']?></td>
        <td bgcolor="<?php echo color_estado($row_cronograma['estado'])?>"><?php echo $row_cronograma['estado']?></td>
    </tr>
<?php
while($row_cronograma=mysql_fetch_assoc($mostrar_cronograma)){?>
<tr bgcolor="<?php echo $color?>">
        <td><a href="avance_productolist.php?idConsultoria=<?php echo $row_consultoria['idConsultoria']?>&idCronograma=<?php echo $row_cronograma['idCronograma']?>"><?php echo $row_cronograma['detalle']?></a></td>
        <td  bgcolor="<?php echo color_porcentaje($row_cronograma['porcentajeCumplimiento'])?>"><?php echo $row_cronograma['porcentajeCumplimiento']?></td>
        <td bgcolor="<?php echo color_estado($row_cronograma['estado'])?>"><?php echo $row_cronograma['estado']?></td>
    </tr>
<?php }
?>
<?php 
$contador++;
} ?>
</tbody>
</table>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class creporte_seguimiento_consultoria_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'reporte_seguimiento_consultoria';

	// Page Object Name
	var $PageObjName = 'reporte_seguimiento_consultoria_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $reporte_seguimiento_consultoria;
		if ($reporte_seguimiento_consultoria->UseTokenInUrl) $PageUrl .= "t=" . $reporte_seguimiento_consultoria->TableVar . "&"; // add page token
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
		global $objForm, $reporte_seguimiento_consultoria;
		if ($reporte_seguimiento_consultoria->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($reporte_seguimiento_consultoria->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($reporte_seguimiento_consultoria->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function creporte_seguimiento_consultoria_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["reporte_seguimiento_consultoria"] = new creporte_seguimiento_consultoria();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'reporte_seguimiento_consultoria', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $reporte_seguimiento_consultoria;
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
	$reporte_seguimiento_consultoria->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $reporte_seguimiento_consultoria->Export; // Get export parameter, used in header
	$gsExportFile = $reporte_seguimiento_consultoria->TableVar; // Get export file, used in header
	if ($reporte_seguimiento_consultoria->Export == "print" || $reporte_seguimiento_consultoria->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($reporte_seguimiento_consultoria->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $reporte_seguimiento_consultoria;
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
		if ($reporte_seguimiento_consultoria->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $reporte_seguimiento_consultoria->getRecordsPerPage(); // Restore from Session
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
		$reporte_seguimiento_consultoria->setSessionWhere($sFilter);
		$reporte_seguimiento_consultoria->CurrentFilter = "";

		// Export data only
		if (in_array($reporte_seguimiento_consultoria->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $reporte_seguimiento_consultoria;
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
			$reporte_seguimiento_consultoria->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$reporte_seguimiento_consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $reporte_seguimiento_consultoria;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$reporte_seguimiento_consultoria->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$reporte_seguimiento_consultoria->CurrentOrderType = @$_GET["ordertype"];
			$reporte_seguimiento_consultoria->UpdateSort($reporte_seguimiento_consultoria->idConsultoria); // Field 
			$reporte_seguimiento_consultoria->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $reporte_seguimiento_consultoria;
		$sOrderBy = $reporte_seguimiento_consultoria->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($reporte_seguimiento_consultoria->SqlOrderBy() <> "") {
				$sOrderBy = $reporte_seguimiento_consultoria->SqlOrderBy();
				$reporte_seguimiento_consultoria->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $reporte_seguimiento_consultoria;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$reporte_seguimiento_consultoria->setSessionOrderBy($sOrderBy);
				$reporte_seguimiento_consultoria->idConsultoria->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$reporte_seguimiento_consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $reporte_seguimiento_consultoria;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$reporte_seguimiento_consultoria->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$reporte_seguimiento_consultoria->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $reporte_seguimiento_consultoria->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$reporte_seguimiento_consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$reporte_seguimiento_consultoria->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$reporte_seguimiento_consultoria->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $reporte_seguimiento_consultoria;

		// Call Recordset Selecting event
		$reporte_seguimiento_consultoria->Recordset_Selecting($reporte_seguimiento_consultoria->CurrentFilter);

		// Load list page SQL
		$sSql = $reporte_seguimiento_consultoria->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$reporte_seguimiento_consultoria->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $reporte_seguimiento_consultoria;
		$sFilter = $reporte_seguimiento_consultoria->KeyFilter();

		// Call Row Selecting event
		$reporte_seguimiento_consultoria->Row_Selecting($sFilter);

		// Load sql based on filter
		$reporte_seguimiento_consultoria->CurrentFilter = $sFilter;
		$sSql = $reporte_seguimiento_consultoria->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$reporte_seguimiento_consultoria->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $reporte_seguimiento_consultoria;
		$reporte_seguimiento_consultoria->idConsultoria->setDbValue($rs->fields('idConsultoria'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $reporte_seguimiento_consultoria;

		// Call Row_Rendering event
		$reporte_seguimiento_consultoria->Row_Rendering();

		// Common render codes for all row types
		// idConsultoria

		$reporte_seguimiento_consultoria->idConsultoria->CellCssStyle = "white-space: nowrap;";
		$reporte_seguimiento_consultoria->idConsultoria->CellCssClass = "";
		if ($reporte_seguimiento_consultoria->RowType == EW_ROWTYPE_VIEW) { // View row

			// idConsultoria
			$reporte_seguimiento_consultoria->idConsultoria->ViewValue = $reporte_seguimiento_consultoria->idConsultoria->CurrentValue;
			$reporte_seguimiento_consultoria->idConsultoria->CssStyle = "";
			$reporte_seguimiento_consultoria->idConsultoria->CssClass = "";
			$reporte_seguimiento_consultoria->idConsultoria->ViewCustomAttributes = "";

			// idConsultoria
			$reporte_seguimiento_consultoria->idConsultoria->HrefValue = "";
		}

		// Call Row Rendered event
		$reporte_seguimiento_consultoria->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $reporte_seguimiento_consultoria;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($reporte_seguimiento_consultoria->ExportAll) {
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
		if ($reporte_seguimiento_consultoria->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($reporte_seguimiento_consultoria->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $reporte_seguimiento_consultoria->Export == "csv") {
				$sExportStr = "";
				echo ew_ExportLine($sExportStr, $reporte_seguimiento_consultoria->Export);
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
				$reporte_seguimiento_consultoria->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($reporte_seguimiento_consultoria->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $reporte_seguimiento_consultoria->Export <> "csv") { // Vertical format
					}	else { // Horizontal format
						$sExportStr = "";
						echo ew_ExportLine($sExportStr, $reporte_seguimiento_consultoria->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($reporte_seguimiento_consultoria->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($reporte_seguimiento_consultoria->Export);
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
