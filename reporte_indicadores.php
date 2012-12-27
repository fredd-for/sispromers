<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "reporte_mmlinfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php require_once('Connections/conexion.php'); ?>
<?php include "librerias/librerias.php"; ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php
// Define page object
$reporte_mml_list = new creporte_mml_list();
$Page = & $reporte_mml_list;

// Page init processing
$reporte_mml_list->Page_Init();

// Page main processing
$reporte_mml_list->Page_Main();
?>
<script language="javascript" type="text/javascript" src="jqplot/excanvas.js"></script>
<link rel="stylesheet" type="text/css" href="jqplot/jquery.jqplot.css" />
<link rel="stylesheet" type="text/css" href="examples.css" />
<!-- BEGIN: load jquery -->
<script language="javascript" type="text/javascript" src="jqplot/jquery-1.4.2.min.js"></script>
<!-- END: load jquery -->

<!-- BEGIN: load jqplot -->
<script language="javascript" type="text/javascript" src="jqplot/jquery.jqplot.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.dateAxisRenderer.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.barRenderer.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.categoryAxisRenderer.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.pointLabels.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.canvasTextRenderer.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/plugins/jqplot.canvasAxisTickRenderer.js"></script>

<script type="text/javascript">
    var x=$(document);
    x.ready(inicializarEventos);
    function inicializarEventos()
    {
	
    }

</script>

<?php
if ($_GET['gestion'] <> '0') {
    $gestionInicial = $_GET['gestion'];
    $gestionFinal = $_GET['gestion'];
} else {
    $gestionInicial = 2009;
    $gestionFinal = 2012;
}
$gestionElegida = $_GET['gestion'];
$indicadorElegido = $_GET['indicador'];

$metaGestion[2009] = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
$metaGestion[2010] = array(50, 150, 4, 4, 35, 35, 12, 5, 35, 30, 23, 4, 4, 4);
$metaGestion[2011] = array(50, 150, 3, 3, 35, 35, 12, 5, 35, 20, 35, 3, 3, 3);
$metaGestion[2012] = array(15, 150, 1, 1, 11, 11, 11, 2, 22, 10, 34, 1, 1, 1);
$metaMarcoLogico = array(115, 450, 8, 8, 81, 81, 35, 12, 92, 60, 92, 8, 8, 8);
$codigos = array('Proposito I.1', 'Proposito I.2', 'Proposito I.3', 'Proposito I.4', 'Indicador C.1-I.1', 'Indicador C.1-I.2', 'Indicador C.1-I.3', 'Indicador C.1-I.4', 'Indicador C.2-I.1', 'Indicador C.2-I.2', 'Indicador C.2-I.3', 'Indicador C.3-I.1', 'Indicador C.3-I.2', 'Indicador C.3-I.3');
$textIndicador = array(
    'Numero de MERS sostenibles y en funcionamiento: A&ntilde;o 2: 50; Fin proyecto: 115',
    'N&uacute;mero de empleos generados: A&ntilde;o 2:  150; Fin proyecto: 450',
    'Municipios que contratan anualmente los servicios de al menos una MERS. A&ntilde;o 2: 4; Fin de proyecto: 8',
    'Municipios que establecen una alianza publico-privada con fines de desarrollo. A&ntilde;o 2:  4; Fin de proyecto: 8.',
    'Porcentaje de MERS  formalizadas (Testimonio, Reglamentos, Estatutos, Tarjeta Empresarial, u otros). A&ntilde;o 2: 30%; Fin proyecto: 70% de las 115  MERS',
    'Porcentaje de  MERS que aplican instrumentos de gestion empresarial  (contabilidad basica, administracion y plan de negocios). A&ntilde;o 2: 30%; Fin proyecto:',
    'Porcentaje de  MERS que acceden a creditos: A&ntilde;o 2: 10%; Fin de proyecto: 30% de las 115  MERS',
    'Porcentaje maximo de MERS con problemas de mora en el financiamiento durante todo el proyecto: 10% de las 115  MERS',
    'Porcentaje de MERS que han prestado servicios a entidades publicas o privadas, con contrato formal: A&ntilde;o 2: 30%; Fin de proyecto: 80% de las 115  MERS',
    'Porcentaje de cumplimiento de venta de servicios de las MERS respecto a lo proyectado en sus planes de negocios: A&ntilde;o 2; 50%; Fin de proyecto: 70% de las 115  MERS',
    'Porcentaje de MERS que cumplen sus contratos de servicios: A&ntilde;o 2: 20%; Fin de proyecto: 80% de las 115  MERS',
    'Municipios que establecen una alianza publico-privada con fines de desarrollo. A&ntilde;o 2:  4; Fin de proyecto: 8',
    'Municipios que incorporan acciones de apoyo al sector productivo en sus Planes Anuales y los ejecutan. A&ntilde;o 2: 4; Fin de proyecto: 8',
    'Municipios que contratan anualmente los servicios de al menos una MERS. A&ntilde;o 2: 4; Fin de proyecto: 8'
);
//$marcoLogicoMeta=array ();
$marcoLogicoLogro = array();
$logroGestion = array();
?>

<!--<span class="phpmaker" style="white-space: nowrap;">
    <div id="linkDescargar"></div>
</span>-->
<div id="div_formulario">
    <table id="table_example" width="100%" border="1" class="ewTable" >
        <thead>
            <tr style="font-size: 10pt">
                <th ><?php echo $codigos[$indicadorElegido - 1] ?></th>
                <td colspan="2"><?php echo $textIndicador[$indicadorElegido - 1] ?></td>
            </tr>

        </thead>
        <tr style="color: white;background: #4F6228">
            <td>META</td>
            <td>LOGRO</td>
            <td>% CUMPLIMIENTO</td>
        </tr>
        <tr style="color: white;background: #4F6228">

            <td><?php echo $metaGestion[$gestionElegida][$indicadorElegido - 1]; ?></td>
            <td><?php $logro = indicador1_cantidad(0, 0, 0, 0, 0, 0, $gestionElegida, $database_conexion, $conexion);
echo $logro[cumple]; ?></td>
            <?php
            $porcentaje = ($logro[cumple] * 100) / $metaGestion[$gestionElegida][$indicadorElegido - 1];
            $color = color($porcentaje);
            ?>
            <td style="background: <?php echo $color; ?>"><?php printf("%0.2f", $porcentaje); ?>%</td>
        </tr>
    </table>
    <?php

    function color($porcentaje) {
        $color = "#ffffff";
        $colorRojo = "#FEB0A0";
        $colorAmarillo = "#FBFFBA";
        $colorVerde = "#D7E4BC";

        if ($porcentaje <= 90) {
            $color = $colorRojo;
        } elseif ($porcentaje > 90 && $porcentaje <= 95) {
            $color = $colorAmarillo;
        } elseif ($porcentaje > 95) {
            $color = $colorVerde;
        }
        return $color;
    }

//funcion para graficar
    function php2js($var) {

        if (is_array($var)) {
            $res = "[";
            $array = array();
            foreach ($var as $a_var) {
                $array[] = php2js($a_var);
            }
            return "[" . join(",", $array) . "]";
        } elseif (is_bool($var)) {
            return $var ? "true" : "false";
        } elseif (is_int($var) || is_integer($var) || is_double($var) || is_float($var)) {
            return $var;
        } elseif (is_string($var)) {
            return "\"" . addslashes(stripslashes($var)) . "\"";
        }
        return FALSE;
    }
    ?>

    <style type="text/css" media="screen">
        .jqplot-axis {
            font-size: 1.2em;
        }
        .jqplot-title {
            font-size: 2.2em;
            color: navy;
        }
    </style>
    <script type="text/javascript" language="javascript">
        $(document).ready(function(){
            // For horizontal bar charts, x an y values must will be "flipped"
            // from their vertical bar counterpart.
//            var x_meta =[15];
//            var x_logro=[20];
//            var ticks = ['Proposito'];
            var plot2 = $.jqplot('marcoLogico', [[[<?php echo $logro[cumple]; ?>,'LOGRO']],[[<?php echo $metaGestion[$gestionElegida][$indicadorElegido - 1]; ?>,'META']]],
            //var plot2 = $.jqplot('marcoLogico', [x_meta,x_logro],
            {
                seriesDefaults: {
                    renderer:$.jqplot.BarRenderer,
                    pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
                    shadowAngle: 135,
                    rendererOptions: {
                        barDirection: 'horizontal',
                        showDataLabels: true
                    }
                },
                series:[
                    {label:'LOGRO',
                        color:'<?php echo $color ?>'
                    },
                    {label:'META',
                        color:'<?php echo $colorVerde ?>'
                    }
                    
                ],
                legend: {
                    show: true,
                    placement: 'outsideGrid'
                },
                axesDefaults: {
                    tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                   
                    tickOptions: {
                        angle: 1,
                        fontSize: '7pt'
                    }
                },
                axes: {
                    yaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer
                        }
                }
            });
        });

        //$(document).ready(function(){
        //    var s1 = [200, 600, 700, 1000];
        //    var s2 = [460, -210, 690, 820];
        //    var s3 = [-260, -440, 320, 200];
        //    // Can specify a custom tick Array.
        //    // Ticks should match up one for each y value (category) in the series.
        //    var ticks = ['May', 'June', 'July', 'August'];
        //     
        //    var plot1 = $.jqplot('marcoLogico', [s1, s2, s3], {
        //        seriesDefaults:{
        //            renderer:$.jqplot.BarRenderer,
        //            rendererOptions: {fillToZero: true}
        //        },
        //        series:[
        //            {label:'Hotel'},
        //            {label:'Event Regristration'},
        //            {label:'Airfare'}
        //        ],
        //        legend: {
        //            show: true,
        //            placement: 'outsideGrid'
        //        },
        //        axes: {
        //            xaxis: {
        //                renderer: $.jqplot.CategoryAxisRenderer,
        //                ticks: ticks
        //            },
        //            yaxis: {
        //                pad: 1.05,
        //                tickOptions: {formatString: '$%d'}
        //            }
        //        }
        //    });
        //});
    </script>
    <div id="marcoLogico" style="margin-top:20px; margin-left:20px; width:800px; height:200px;"></div>
</div>
<script type="text/javascript" language="javascript">
    <!--
    //Free Memory allow case
    x320001();
    -->
</script>

<?php

//
// Page Class
//
class creporte_mml_list {

    // Page ID
    var $PageID = 'list';
    // Table Name
    var $TableName = 'reporte_mml';
    // Page Object Name
    var $PageObjName = 'reporte_mml_list';

    // Page Name
    function PageName() {
        return ew_CurrentPage();
    }

    // Page Url
    function PageUrl() {
        $PageUrl = ew_CurrentPage() . "?";
        global $reporte_mml;
        if ($reporte_mml->UseTokenInUrl)
            $PageUrl .= "t=" . $reporte_mml->TableVar . "&"; // add page token
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
        global $objForm, $reporte_mml;
        if ($reporte_mml->UseTokenInUrl) {

            //IsPageRequest = False
            if ($objForm)
                return ($reporte_mml->TableVar == $objForm->GetValue("t"));
            if (@$_GET["t"] <> "")
                return ($reporte_mml->TableVar == $_GET["t"]);
        } else {
            return TRUE;
        }
    }

    //
    //  Class initialize
    //  - init objects
    //  - open connection
    //
	function creporte_mml_list() {
        global $conn;

        // Initialize table object
        $GLOBALS["reporte_mml"] = new creporte_mml();

        // Initialize other table object
        $GLOBALS['usuario'] = new cusuario();

        // Intialize page id (for backward compatibility)
        if (!defined("EW_PAGE_ID"))
            define("EW_PAGE_ID", 'list', TRUE);

        // Initialize table name (for backward compatibility)
        if (!defined("EW_TABLE_NAME"))
            define("EW_TABLE_NAME", 'reporte_mml', TRUE);

        // Open connection to the database
        $conn = ew_Connect();

        // Initialize list options
        $this->ListOptions = new cListOptions();
    }

    //
    //  Page_Init
    //
	function Page_Init() {
        global $gsExport, $gsExportFile, $reporte_mml;
        global $Security;
        $Security = new cAdvancedSecurity();
        if (!$Security->IsLoggedIn())
            $Security->AutoLogin();
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
        $reporte_mml->Export = @$_GET["export"]; // Get export parameter
        $gsExport = $reporte_mml->Export; // Get export parameter, used in header
        $gsExportFile = $reporte_mml->TableVar; // Get export file, used in header
        if ($reporte_mml->Export == "print" || $reporte_mml->Export == "html") {

            // Printer friendly or Export to HTML, no action required
        }
        if ($reporte_mml->Export == "excel") {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=' . $gsExportFile . '.xls');
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
        global $objForm, $gsSearchError, $Security, $reporte_mml;
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
        if ($reporte_mml->getRecordsPerPage() <> "") {
            $this->lDisplayRecs = $reporte_mml->getRecordsPerPage(); // Restore from Session
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
            $sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sSrchWhere . ")" : $this->sSrchWhere;

        // Set up filter in Session
        $reporte_mml->setSessionWhere($sFilter);
        $reporte_mml->CurrentFilter = "";

        // Export data only
        if (in_array($reporte_mml->Export, array("html", "word", "excel", "xml", "csv"))) {
            $this->ExportData();
            $this->Page_Terminate(); // Terminate response
            exit();
        }
    }

    // Set up number of records displayed per page
    function SetUpDisplayRecs() {
        global $reporte_mml;
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
            $reporte_mml->setRecordsPerPage($this->lDisplayRecs); // Save to Session
            // Reset start position
            $this->lStartRec = 1;
            $reporte_mml->setStartRecordNumber($this->lStartRec);
        }
    }

    // Set up Sort parameters based on Sort Links clicked
    function SetUpSortOrder() {
        global $reporte_mml;

        // Check for an Order parameter
        if (@$_GET["order"] <> "") {
            $reporte_mml->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
            $reporte_mml->CurrentOrderType = @$_GET["ordertype"];
            $reporte_mml->UpdateSort($reporte_mml->idMer); // Field
            $reporte_mml->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load Sort Order parameters
    function LoadSortOrder() {
        global $reporte_mml;
        $sOrderBy = $reporte_mml->getSessionOrderBy(); // Get order by from Session
        if ($sOrderBy == "") {
            if ($reporte_mml->SqlOrderBy() <> "") {
                $sOrderBy = $reporte_mml->SqlOrderBy();
                $reporte_mml->setSessionOrderBy($sOrderBy);
            }
        }
    }

    // Reset command based on querystring parameter cmd=
    // - RESET: reset search parameters
    // - RESETALL: reset search & master/detail parameters
    // - RESETSORT: reset sort parameters
    function ResetCmd() {
        global $reporte_mml;

        // Get reset cmd
        if (@$_GET["cmd"] <> "") {
            $sCmd = $_GET["cmd"];

            // Reset sort criteria
            if (strtolower($sCmd) == "resetsort") {
                $sOrderBy = "";
                $reporte_mml->setSessionOrderBy($sOrderBy);
                $reporte_mml->idMer->setSort("");
            }

            // Reset start position
            $this->lStartRec = 1;
            $reporte_mml->setStartRecordNumber($this->lStartRec);
        }
    }

    // Set up Starting Record parameters based on Pager Navigation
    function SetUpStartRec() {
        global $reporte_mml;
        if ($this->lDisplayRecs == 0)
            return;
        if ($this->IsPageRequest()) { // Validate request
            if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
                $this->lStartRec = $_GET[EW_TABLE_START_REC];
                $reporte_mml->setStartRecordNumber($this->lStartRec);
            } elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
                $this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
                if (is_numeric($this->nPageNo)) {
                    $this->lStartRec = ($this->nPageNo - 1) * $this->lDisplayRecs + 1;
                    if ($this->lStartRec <= 0) {
                        $this->lStartRec = 1;
                    } elseif ($this->lStartRec >= intval(($this->lTotalRecs - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1) {
                        $this->lStartRec = intval(($this->lTotalRecs - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1;
                    }
                    $reporte_mml->setStartRecordNumber($this->lStartRec);
                }
            }
        }
        $this->lStartRec = $reporte_mml->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
            $this->lStartRec = 1; // Reset start record counter
            $reporte_mml->setStartRecordNumber($this->lStartRec);
        } elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
            $this->lStartRec = intval(($this->lTotalRecs - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1; // Point to last page first record
            $reporte_mml->setStartRecordNumber($this->lStartRec);
        } elseif (($this->lStartRec - 1) % $this->lDisplayRecs <> 0) {
            $this->lStartRec = intval(($this->lStartRec - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1; // Point to page boundary
            $reporte_mml->setStartRecordNumber($this->lStartRec);
        }
    }

    // Load recordset
    function LoadRecordset($offset = -1, $rowcnt = -1) {
        global $conn, $reporte_mml;

        // Call Recordset Selecting event
        $reporte_mml->Recordset_Selecting($reporte_mml->CurrentFilter);

        // Load list page SQL
        $sSql = $reporte_mml->SelectSQL();
        if ($offset > -1 && $rowcnt > -1)
            $sSql .= " LIMIT $offset, $rowcnt";

        // Load recordset
        $conn->raiseErrorFn = 'ew_ErrorFn';
        $rs = $conn->Execute($sSql);
        $conn->raiseErrorFn = '';

        // Call Recordset Selected event
        $reporte_mml->Recordset_Selected($rs);
        return $rs;
    }

    // Load row based on key values
    function LoadRow() {
        global $conn, $Security, $reporte_mml;
        $sFilter = $reporte_mml->KeyFilter();

        // Call Row Selecting event
        $reporte_mml->Row_Selecting($sFilter);

        // Load sql based on filter
        $reporte_mml->CurrentFilter = $sFilter;
        $sSql = $reporte_mml->SQL();
        if ($rs = $conn->Execute($sSql)) {
            if ($rs->EOF) {
                $LoadRow = FALSE;
            } else {
                $LoadRow = TRUE;
                $rs->MoveFirst();
                $this->LoadRowValues($rs); // Load row values
                // Call Row Selected event
                $reporte_mml->Row_Selected($rs);
            }
            $rs->Close();
        } else {
            $LoadRow = FALSE;
        }
        return $LoadRow;
    }

    // Load row values from recordset
    function LoadRowValues(&$rs) {
        global $reporte_mml;
        $reporte_mml->idMer->setDbValue($rs->fields('idMer'));
    }

    // Render row values based on field settings
    function RenderRow() {
        global $conn, $Security, $reporte_mml;

        // Call Row_Rendering event
        $reporte_mml->Row_Rendering();

        // Common render codes for all row types
        // idMer

        $reporte_mml->idMer->CellCssStyle = "";
        $reporte_mml->idMer->CellCssClass = "";
        if ($reporte_mml->RowType == EW_ROWTYPE_VIEW) { // View row
            // idMer
            $reporte_mml->idMer->ViewValue = $reporte_mml->idMer->CurrentValue;
            $reporte_mml->idMer->CssStyle = "";
            $reporte_mml->idMer->CssClass = "";
            $reporte_mml->idMer->ViewCustomAttributes = "";

            // idMer
            $reporte_mml->idMer->HrefValue = "";
        }

        // Call Row Rendered event
        $reporte_mml->Row_Rendered();
    }

    // Export data in XML or CSV format
    function ExportData() {
        global $reporte_mml;
        $sCsvStr = "";

        // Default export style
        $sExportStyle = "h";

        // Load recordset
        $rs = $this->LoadRecordset();
        $this->lTotalRecs = $rs->RecordCount();
        $this->lStartRec = 1;

        // Export all
        if ($reporte_mml->ExportAll) {
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
        if ($reporte_mml->Export == "xml") {
            $XmlDoc = new cXMLDocument();
        } else {
            echo ew_ExportHeader($reporte_mml->Export);

            // Horizontal format, write header
            if ($sExportStyle <> "v" || $reporte_mml->Export == "csv") {
                $sExportStr = "";
                ew_ExportAddValue($sExportStr, 'idMer', $reporte_mml->Export);
                echo ew_ExportLine($sExportStr, $reporte_mml->Export);
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
                $reporte_mml->RowType = EW_ROWTYPE_VIEW; // Render view
                $this->RenderRow();
                if ($reporte_mml->Export == "xml") {
                    $XmlDoc->BeginRow();
                    $XmlDoc->AddField('idMer', $reporte_mml->idMer->CurrentValue);
                    $XmlDoc->EndRow();
                } else {
                    if ($sExportStyle == "v" && $reporte_mml->Export <> "csv") { // Vertical format
                        echo ew_ExportField('idMer', $reporte_mml->idMer->ExportValue($reporte_mml->Export, $reporte_mml->ExportOriginalValue), $reporte_mml->Export);
                    } else { // Horizontal format
                        $sExportStr = "";
                        ew_ExportAddValue($sExportStr, $reporte_mml->idMer->ExportValue($reporte_mml->Export, $reporte_mml->ExportOriginalValue), $reporte_mml->Export);
                        echo ew_ExportLine($sExportStr, $reporte_mml->Export);
                    }
                }
            }
            $rs->MoveNext();
        }

        // Close recordset
        $rs->Close();
        if ($reporte_mml->Export == "xml") {
            header("Content-Type: text/xml");
            echo $XmlDoc->XML();
        } else {
            echo ew_ExportFooter($reporte_mml->Export);
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
