<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "avance_productoinfo.php" ?>
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
$avance_producto_list = new cavance_producto_list();
$Page =& $avance_producto_list;

// Page init processing
$avance_producto_list->Page_Init();

// Page main processing
$avance_producto_list->Page_Main();
?>
<?php
$idCronograma=$_REQUEST['idCronograma'];
$idConsultoria=$_REQUEST['idConsultoria'];
mysql_select_db($database_conexion, $conexion);
$query_cronogramaReporte= "SELECT idCronogramaReporte, idCronograma,archivo,detalle,sugerencia,inesperado,fechaCreacion,(case estado when 1 then 'Corregir' when 2 then 'Revision' when 3 then 'Aprobado' end) as estado  FROM cronograma_reporte WHERE idCronograma=".$idCronograma;
$mostrar_cronogramaReporte=mysql_query($query_cronogramaReporte, $conexion) or die(mysql_error());
$total_cronogramaReporte=mysql_num_rows($mostrar_cronogramaReporte);

mysql_select_db($database_conexion, $conexion);
$query_cronogramaReporteEstado= "SELECT * FROM cronograma_reporte WHERE idCronograma=$idCronograma AND ( estado=2 OR estado=3)";
$mostrar_cronogramaReporteEstado=mysql_query($query_cronogramaReporteEstado, $conexion) or die(mysql_error());
$total_cronogramaReporteEstado=mysql_num_rows($mostrar_cronogramaReporteEstado);

?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent" id="tabla_hito">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<tr class="ewTableHeader">
    <td>Informe Consultor</td>
    <td>Sugerencia Unid. Cordinaci&oacute;n.</td>
    <td>Resultados Inesperados</td>
    <td>Descripcion del Informe</td>
    <td>Fecha Informe</td>
    <td>Estado</td>
    <td>
    </td>
</tr>
<?php
while($row_cronogramaReporte=mysql_fetch_assoc($mostrar_cronogramaReporte)){?>
<tr>
    <td><?php echo "<a href=\"files_consultoria/".utf8_encode($row_cronogramaReporte['archivo'])."\" title='Extraer archivo'>".utf8_encode($row_cronogramaReporte['archivo'])."</a>";?></td>
    <td><?php echo utf8_encode($row_cronogramaReporte['sugerencia'])?></td>
    <td><?php echo utf8_encode($row_cronogramaReporte['inesperado'])?></td>
    <td><?php echo utf8_encode($row_cronogramaReporte['detalle'])?></td>
    <td><?php echo date("d-m-Y", strtotime($row_cronogramaReporte['fechaCreacion']))?></td>
    <td><?php echo $row_cronogramaReporte['estado']?></td>
    <td>
        <input type="button" name="revisar_hito" id="revisar_hito" value="Revisar" style="cursor: pointer" onclick="func_revisar_cronograma(<?php echo $row_cronogramaReporte['idCronogramaReporte']?>)">
    </td>
</tr>
<?php } ?>
<?php if($total_cronogramaReporteEstado<1 && $Security->CanAdd()){?>
<form method="post" action="avance_producto_guardar.php" enctype="multipart/form-data" onSubmit="return validar_formulario_reporte_hito(this);">
<tr>
    <td><input type="file" name="archivo_reporte_hito" id="archivo_reporte_hito" size="35"></td>
    <td><textarea name="sugerencia_reporte_hito" id="sugerencia_reporte_hito" rows="2" cols="35"><?php echo $row_metaReporte['sugerencia'];?></textarea></td>
    <td><textarea name="inesperado_reporte_hito" id="inesperado_reporte_hito" rows="2" cols="35"><?php echo $row_metaReporte['inesperado'];?></textarea></td>
    <td><textarea name="detalle_reporte_hito" id="detalle_reporte_hito" rows="2" cols="35"><?php echo $row_metaReporte['detalle'];?></textarea></td>
    <td></td>
    <td></td>
    <!--<td>
    <?php //if($total_cronogramaReporteEstado<1){?>
    <input type="button" value="Guardar" onclick="func_reportarHito(<?php echo $idCronograma?>)" style="cursor: pointer">
    <input type="button" value="Cancelar" onclick="reporte_hito_datos_ocultar()" style="cursor: pointer">
    <?php //}?>
    </td>
    -->
    <td>
        <input type="hidden" name="x_idCronograma" value="<?php echo $idCronograma?>">
        <input type="hidden" name="x_idConsultoria" value="<?php echo $idConsultoria?>">
        <input type="submit" name="reporte_hito" value="Reportar Hito" style="cursor: pointer">
    </td>
</tr>
</form>
<?php } ?>
</table></div></td></tr></table>
<script type="text/javascript">
    //reporte_hito_datos_ocultar();
</script>
<?php

//
// Page Class
//
class cavance_producto_list {

    // Page ID
    var $PageID = 'list';

    // Table Name
    var $TableName = 'avance_producto';

    // Page Object Name
    var $PageObjName = 'avance_producto_list';

    // Page Name
    function PageName() {
        return ew_CurrentPage();
    }

    // Page Url
    function PageUrl() {
        $PageUrl = ew_CurrentPage() . "?";
        global $avance_producto;
        if ($avance_producto->UseTokenInUrl) $PageUrl .= "t=" . $avance_producto->TableVar . "&"; // add page token
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
        global $objForm, $avance_producto;
        if ($avance_producto->UseTokenInUrl) {

            //IsPageRequest = False
            if ($objForm)
                return ($avance_producto->TableVar == $objForm->GetValue("t"));
            if (@$_GET["t"] <> "")
                return ($avance_producto->TableVar == $_GET["t"]);
        } else {
            return TRUE;
        }
    }

    //
    //  Class initialize
    //  - init objects
    //  - open connection
    //
    function cavance_producto_list() {
        global $conn;

        // Initialize table object
        $GLOBALS["avance_producto"] = new cavance_producto();

        // Initialize other table object
        $GLOBALS['usuario'] = new cusuario();

        // Intialize page id (for backward compatibility)
        if (!defined("EW_PAGE_ID"))
            define("EW_PAGE_ID", 'list', TRUE);

        // Initialize table name (for backward compatibility)
        if (!defined("EW_TABLE_NAME"))
            define("EW_TABLE_NAME", 'avance_producto', TRUE);

        // Open connection to the database
        $conn = ew_Connect();

        // Initialize list options
        $this->ListOptions = new cListOptions();
    }

    //
    //  Page_Init
    //
    function Page_Init() {
        global $gsExport, $gsExportFile, $avance_producto;
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
        $avance_producto->Export = @$_GET["export"]; // Get export parameter
        $gsExport = $avance_producto->Export; // Get export parameter, used in header
        $gsExportFile = $avance_producto->TableVar; // Get export file, used in header
        if ($avance_producto->Export == "print" || $avance_producto->Export == "html") {

            // Printer friendly or Export to HTML, no action required
        }
        if ($avance_producto->Export == "excel") {
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
        global $objForm, $gsSearchError, $Security, $avance_producto;
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
        if ($avance_producto->getRecordsPerPage() <> "") {
            $this->lDisplayRecs = $avance_producto->getRecordsPerPage(); // Restore from Session
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
        $avance_producto->setSessionWhere($sFilter);
        $avance_producto->CurrentFilter = "";

        // Export data only
        if (in_array($avance_producto->Export, array("html","word","excel","xml","csv"))) {
            $this->ExportData();
            $this->Page_Terminate(); // Terminate response
            exit();
        }
    }

    // Set up number of records displayed per page
    function SetUpDisplayRecs() {
        global $avance_producto;
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
            $avance_producto->setRecordsPerPage($this->lDisplayRecs); // Save to Session

            // Reset start position
            $this->lStartRec = 1;
            $avance_producto->setStartRecordNumber($this->lStartRec);
        }
    }

    // Set up Sort parameters based on Sort Links clicked
    function SetUpSortOrder() {
        global $avance_producto;

        // Check for an Order parameter
        if (@$_GET["order"] <> "") {
            $avance_producto->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
            $avance_producto->CurrentOrderType = @$_GET["ordertype"];
            $avance_producto->UpdateSort($avance_producto->idConsultoria); // Field
            $avance_producto->UpdateSort($avance_producto->idCronograma); // Field
            $avance_producto->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load Sort Order parameters
    function LoadSortOrder() {
        global $avance_producto;
        $sOrderBy = $avance_producto->getSessionOrderBy(); // Get order by from Session
        if ($sOrderBy == "") {
            if ($avance_producto->SqlOrderBy() <> "") {
                $sOrderBy = $avance_producto->SqlOrderBy();
                $avance_producto->setSessionOrderBy($sOrderBy);
            }
        }
    }

    // Reset command based on querystring parameter cmd=
    // - RESET: reset search parameters
    // - RESETALL: reset search & master/detail parameters
    // - RESETSORT: reset sort parameters
    function ResetCmd() {
        global $avance_producto;

        // Get reset cmd
        if (@$_GET["cmd"] <> "") {
            $sCmd = $_GET["cmd"];

            // Reset sort criteria
            if (strtolower($sCmd) == "resetsort") {
                $sOrderBy = "";
                $avance_producto->setSessionOrderBy($sOrderBy);
                $avance_producto->idConsultoria->setSort("");
                $avance_producto->idCronograma->setSort("");
            }

            // Reset start position
            $this->lStartRec = 1;
            $avance_producto->setStartRecordNumber($this->lStartRec);
        }
    }

    // Set up Starting Record parameters based on Pager Navigation
    function SetUpStartRec() {
        global $avance_producto;
        if ($this->lDisplayRecs == 0)
            return;
        if ($this->IsPageRequest()) { // Validate request
            if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
                $this->lStartRec = $_GET[EW_TABLE_START_REC];
                $avance_producto->setStartRecordNumber($this->lStartRec);
            } elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
                $this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
                if (is_numeric($this->nPageNo)) {
                    $this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
                    if ($this->lStartRec <= 0) {
                        $this->lStartRec = 1;
                    } elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
                        $this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
                    }
                    $avance_producto->setStartRecordNumber($this->lStartRec);
                }
            }
        }
        $this->lStartRec = $avance_producto->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
            $this->lStartRec = 1; // Reset start record counter
            $avance_producto->setStartRecordNumber($this->lStartRec);
        } elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
            $this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
            $avance_producto->setStartRecordNumber($this->lStartRec);
        } elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
            $this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
            $avance_producto->setStartRecordNumber($this->lStartRec);
        }
    }

    // Load recordset
    function LoadRecordset($offset = -1, $rowcnt = -1) {
        global $conn, $avance_producto;

        // Call Recordset Selecting event
        $avance_producto->Recordset_Selecting($avance_producto->CurrentFilter);

        // Load list page SQL
        $sSql = $avance_producto->SelectSQL();
        if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

        // Load recordset
        $conn->raiseErrorFn = 'ew_ErrorFn';
        $rs = $conn->Execute($sSql);
        $conn->raiseErrorFn = '';

        // Call Recordset Selected event
        $avance_producto->Recordset_Selected($rs);
        return $rs;
    }

    // Load row based on key values
    function LoadRow() {
        global $conn, $Security, $avance_producto;
        $sFilter = $avance_producto->KeyFilter();

        // Call Row Selecting event
        $avance_producto->Row_Selecting($sFilter);

        // Load sql based on filter
        $avance_producto->CurrentFilter = $sFilter;
        $sSql = $avance_producto->SQL();
        if ($rs = $conn->Execute($sSql)) {
            if ($rs->EOF) {
                $LoadRow = FALSE;
            } else {
                $LoadRow = TRUE;
                $rs->MoveFirst();
                $this->LoadRowValues($rs); // Load row values

                // Call Row Selected event
                $avance_producto->Row_Selected($rs);
            }
            $rs->Close();
        } else {
            $LoadRow = FALSE;
        }
        return $LoadRow;
    }

    // Load row values from recordset
    function LoadRowValues(&$rs) {
        global $avance_producto;
        $avance_producto->idConsultoria->setDbValue($rs->fields('idConsultoria'));
        $avance_producto->idCronograma->setDbValue($rs->fields('idCronograma'));
    }

    // Render row values based on field settings
    function RenderRow() {
        global $conn, $Security, $avance_producto;

        // Call Row_Rendering event
        $avance_producto->Row_Rendering();

        // Common render codes for all row types
        // idConsultoria

        $avance_producto->idConsultoria->CellCssStyle = "";
        $avance_producto->idConsultoria->CellCssClass = "";

        // idCronograma
        $avance_producto->idCronograma->CellCssStyle = "";
        $avance_producto->idCronograma->CellCssClass = "";
        if ($avance_producto->RowType == EW_ROWTYPE_VIEW) { // View row

            // idConsultoria
            $avance_producto->idConsultoria->ViewValue = $avance_producto->idConsultoria->CurrentValue;
            $avance_producto->idConsultoria->CssStyle = "";
            $avance_producto->idConsultoria->CssClass = "";
            $avance_producto->idConsultoria->ViewCustomAttributes = "";

            // idCronograma
            $avance_producto->idCronograma->ViewValue = $avance_producto->idCronograma->CurrentValue;
            $avance_producto->idCronograma->CssStyle = "";
            $avance_producto->idCronograma->CssClass = "";
            $avance_producto->idCronograma->ViewCustomAttributes = "";

            // idConsultoria
            $avance_producto->idConsultoria->HrefValue = "";

            // idCronograma
            $avance_producto->idCronograma->HrefValue = "";
        }

        // Call Row Rendered event
        $avance_producto->Row_Rendered();
    }

    // Export data in XML or CSV format
    function ExportData() {
        global $avance_producto;
        $sCsvStr = "";

        // Default export style
        $sExportStyle = "h";

        // Load recordset
        $rs = $this->LoadRecordset();
        $this->lTotalRecs = $rs->RecordCount();
        $this->lStartRec = 1;

        // Export all
        if ($avance_producto->ExportAll) {
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
        if ($avance_producto->Export == "xml") {
            $XmlDoc = new cXMLDocument();
        } else {
            echo ew_ExportHeader($avance_producto->Export);

            // Horizontal format, write header
            if ($sExportStyle <> "v" || $avance_producto->Export == "csv") {
                $sExportStr = "";
                ew_ExportAddValue($sExportStr, 'idConsultoria', $avance_producto->Export);
                ew_ExportAddValue($sExportStr, 'idCronograma', $avance_producto->Export);
                echo ew_ExportLine($sExportStr, $avance_producto->Export);
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
                $avance_producto->RowType = EW_ROWTYPE_VIEW; // Render view
                $this->RenderRow();
                if ($avance_producto->Export == "xml") {
                    $XmlDoc->BeginRow();
                    $XmlDoc->AddField('idConsultoria', $avance_producto->idConsultoria->CurrentValue);
                    $XmlDoc->AddField('idCronograma', $avance_producto->idCronograma->CurrentValue);
                    $XmlDoc->EndRow();
                } else {
                    if ($sExportStyle == "v" && $avance_producto->Export <> "csv") { // Vertical format
                        echo ew_ExportField('idConsultoria', $avance_producto->idConsultoria->ExportValue($avance_producto->Export, $avance_producto->ExportOriginalValue), $avance_producto->Export);
                        echo ew_ExportField('idCronograma', $avance_producto->idCronograma->ExportValue($avance_producto->Export, $avance_producto->ExportOriginalValue), $avance_producto->Export);
                    }	else { // Horizontal format
                        $sExportStr = "";
                        ew_ExportAddValue($sExportStr, $avance_producto->idConsultoria->ExportValue($avance_producto->Export, $avance_producto->ExportOriginalValue), $avance_producto->Export);
                        ew_ExportAddValue($sExportStr, $avance_producto->idCronograma->ExportValue($avance_producto->Export, $avance_producto->ExportOriginalValue), $avance_producto->Export);
                        echo ew_ExportLine($sExportStr, $avance_producto->Export);
                    }
                }
            }
            $rs->MoveNext();
        }

        // Close recordset
        $rs->Close();
        if ($avance_producto->Export == "xml") {
            header("Content-Type: text/xml");
            echo $XmlDoc->XML();
        } else {
            echo ew_ExportFooter($avance_producto->Export);
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
