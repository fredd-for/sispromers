<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "indicador13info.php" ?>
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
$indicador13_list = new cindicador13_list();
$Page = & $indicador13_list;

// Page init processing
$indicador13_list->Page_Init();

// Page main processing
$indicador13_list->Page_Main();
?>


<?php include "header.php" ?>

<?php 
if (isset($_POST['x_gestion'])) 
    $x_gestion = $_POST['x_gestion'];
else $x_gestion = 0;

if(isset($_POST['x_idRubro']))
    $x_idRubro = $_POST['x_idRubro'];
else
    $x_idRubro = 0;

if(isset($_POST['x_formalizada']))
    $x_formalizada = $_POST['x_formalizada'];
else
    $x_formalizada = 0;

if(isset($_POST['x_idRegional']))
    $x_idRegional = $_POST['x_idRegional'];
else
    $x_idRegional = 0;

if(isset($_POST['x_idDepartamento']))
    $x_idDepartamento = $_POST['x_idDepartamento'];
else
    $x_idDepartamento = 0;

if(isset($_POST['x_idMunicipio']))
    $x_idMunicipio = $_POST['x_idMunicipio'];
else
    $x_idMunicipio = 0;

mysql_select_db($database_conexion, $conexion);
$query_rubro= "SELECT idRubro, rubro FROM rubro ORDER BY rubro asc";
$mostrar_rubro=mysql_query($query_rubro, $conexion) or die(mysql_error());
$total_rubro=mysql_num_rows($mostrar_rubro);

mysql_select_db($database_conexion, $conexion);
$query_regional= "SELECT idRegional, regional FROM regional ORDER BY regional asc";
$mostrar_regional=mysql_query($query_regional, $conexion) or die(mysql_error());
$total_regional=mysql_num_rows($mostrar_regional);

?>

<?php
mysql_select_db($database_conexion, $conexion);
$query = "SELECT mer.idMer,mer.mer,reg.regional,dep.departamento,mun.municipio,com.comunidad,mer.latitudUTM,mer.longitudUTM
FROM mer
INNER JOIN regional AS reg ON mer.idRegional = reg.idRegional
INNER JOIN departamento AS dep ON mer.idDepartamento = dep.idDepartamento
INNER JOIN municipio AS mun ON mer.idMunicipio = mun.idMunicipio
INNER JOIN comunidad AS com ON mer.idComunidad = com.idComunidad
WHERE mer.estado > 0 AND mer.longitudUTM <> 0 AND mer.latitudUTM <> 0";
$mostrar_mer = mysql_query($query, $conexion) or die(mysql_error());
$totalRows_mer = mysql_num_rows($mostrar_mer);
?>
<script src="http://maps.google.com/maps?file=api&v=2&key=#37cd0b69485f9d44b7f61ef6d53b614278df3c1b#" type="text/javascript"></script>
<script type="text/javascript">
    function clicMarca(marca) {
        if (GBrowserIsCompatible() && cargado) {
            GEvent.trigger(marca, "click");
        }
    }
                
    var marca_n = new Array();
    var x=0;
    var cargado=false;

    function load() {
        if (GBrowserIsCompatible()) {
            var map = new GMap2(document.getElementById("map"));
            map.addControl(new GLargeMapControl());
            map.addControl(new GMapTypeControl());
            map.setCenter(new GLatLng(-17.392579,-64.35791), 5);
            function CrearMarca(punto, html){
                var miMarca = new GMarker(punto);
                map.addOverlay(miMarca);
                GEvent.addListener(miMarca, "click", function (){
                    miMarca.openInfoWindowHtml(html);
                });
                return miMarca;
            }
            //creo marca 1
            var point;
            <?php while ($row1 = mysql_fetch_assoc($mostrar_mer)) { ?>
                point=new GLatLng(<?php echo $row1['latitudUTM'] ?>,<?php echo $row1['longitudUTM'] ?>);
                var htmlBocadillo = '<div><b>Mer: ' + '<?php echo $row1['mer'] ?>' + ' </b></div>'
                marca_n[x]=CrearMarca(point, htmlBocadillo);
                x++;
            <?php } ?>
            cargado=true;
        }
    }
    window.onload=load
    //]]>
</script>

<script type="text/javascript">
function seleccionar_departamento(){
var v_idRegional = document.getElementById("x_idRegional");
var v_idDepartamento = document.getElementById("x_idDepartamento_edit");
new Ajax.Updater('divx_idDepartamento','departamentoSelector.php?idRegional='+v_idRegional.value+'&idDepartamento='+v_idDepartamento.value,{onComplete:function(){
	seleccionar_municipio();
}});
}
function seleccionar_municipio(){
var v_idRegional = document.getElementById("x_idRegional");
var v_idDepartamento = document.getElementById("x_idDepartamento");
var v_idMunicipio = document.getElementById("x_idMunicipio_edit");
new Ajax.Updater('divx_idMunicipio','municipioSelector.php?idRegional='+v_idRegional.value+'&idDepartamento='+v_idDepartamento.value+'&idMunicipio='+v_idMunicipio.value);
}
</script>
<form method="post" action="indicador1list.php">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
    <tr style="color: blue">
        <td>Gesti&oacute;n</td>
     <td>
         <select name="x_gestion" id="x_gestion">
             <option value="0" style="color: gray">Todos...</option>
			<option value="2009" <?php if($x_gestion=='2009'){echo "selected";}?>>2009</option>
			<option value="2010" <?php if($x_gestion=='2010'){echo "selected";}?>>2010</option>
			<option value="2011" <?php if($x_gestion=='2011'){echo "selected";}?>>2011</option>
			<option value="2012" <?php if($x_gestion=='2012'){echo "selected";}?>>2012</option>
         </select>
     </td>
     <td>Rubro</td>
     <td>
         <select name="x_idRubro" id="x_idRubro">
             <option value="0" style="color: gray">Todos...</option>
             <?php
             while($row_rubro=mysql_fetch_assoc($mostrar_rubro)){?>
             <option value="<?php echo $row_rubro['idRubro']?>" <?php if($x_idRubro==$row_rubro['idRubro']){echo "selected";}?>><?php echo $row_rubro['rubro']?></option>
             <?php }
             ?>
         </select>
     </td>
     <td>Mers Formalizadas</td>
     <td>
         <select name="x_formalizada" id="x_formalizada">
             <option value="0" <?php if($x_formalizada=='0'){echo "selected";$sw='0';}?> style="color: gray">Todos...</option>
             <option value="1" <?php if(isset ($x_formalizada)){if($x_formalizada=='1'){echo "selected";$sw='1';}}else{echo "selected";$sw='1';}?>>Mers Formalizadas</option>
             <option value="2" <?php if($x_formalizada=='2'){echo "selected";$sw='2';}?>>Mers en Proceso</option>
         </select>
     </td>
     </tr>
   <tr style="color: blue">
     <td>Regional</td>
     <td>
         <select name="x_idRegional" id="x_idRegional" onchange="seleccionar_departamento();">
             <option value="0" style="color:gray" >Todos...</option>
             <?php
             while($row_regional=mysql_fetch_assoc($mostrar_regional)){?>
             <option value="<?php echo $row_regional['idRegional']?>" <?php if($x_idRegional==$row_regional['idRegional']){echo "selected";}?>><?php echo $row_regional['regional']?></option>
             <?php }
             ?>
         </select>
     </td>
     <td>Departamento</td>
     <td>
<input type="hidden" name="x_idDepartamento_edit" id="x_idDepartamento_edit" value="<?php if($x_idDepartamento>0){echo $x_idDepartamento;}else{echo "0";}?>"/>
<div id="divx_idDepartamento"></div>
     </td>
     <td>Municipio</td>
     <td>
<input type="hidden" name="x_idMunicipio_edit" id="x_idMunicipio_edit" value="<?php if($x_idMunicipio>0){echo $x_idMunicipio;}else{echo "0";}?>"/>
<div id="divx_idMunicipio"></div>
     </td>
     </tr>
 <tr>
 <td colspan="6" align="center"><input type="submit" name="filtrar" value="FILTRAR (*)"></td>
 </tr>
 </table>
</div></td></tr></table>
</form>
<table>
    <tr>
        <td>
            <table id="table_example" cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
                <thead>
                    <tr class="ewTableHeader">
                        <td>No</td>
                        <td>Departamento</td>
                        <td>Municipio</td>
                        <td>Comunidad</td>
                        <td>Mer</td>
                    </tr>
                </thead>
                <?php
                mysql_data_seek($mostrar_mer, 0);
                $c = 0;
                while ($row = mysql_fetch_assoc($mostrar_mer)) {
                    ?>
                    <tr>
                        <td><?php echo $c ?></td>
                        <td><?php echo $row['departamento'] ?></td>
                        <td><?php echo $row['municipio'] ?></td>
                        <td><?php echo $row['comunidad'] ?></td>
                        <td><a href="javascript: clicMarca(marca_n[<?php echo $c ?>])"><?php echo $row['mer'] ?></a></td>

                    </tr>    
                    <?php
                    $c++;
                }
                ?>
            </table>
        </td>
        <td><div id="map" style="width: 500px; height: 400px"></div></td>
    </tr>
</table>

<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cindicador13_list {

    // Page ID
    var $PageID = 'list';
    // Table Name
    var $TableName = 'indicador13';
    // Page Object Name
    var $PageObjName = 'indicador13_list';

    // Page Name
    function PageName() {
        return ew_CurrentPage();
    }

    // Page Url
    function PageUrl() {
        $PageUrl = ew_CurrentPage() . "?";
        global $indicador13;
        if ($indicador13->UseTokenInUrl)
            $PageUrl .= "t=" . $indicador13->TableVar . "&"; // add page token
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
        global $objForm, $indicador13;
        if ($indicador13->UseTokenInUrl) {

            //IsPageRequest = False
            if ($objForm)
                return ($indicador13->TableVar == $objForm->GetValue("t"));
            if (@$_GET["t"] <> "")
                return ($indicador13->TableVar == $_GET["t"]);
        } else {
            return TRUE;
        }
    }

    //
    //  Class initialize
    //  - init objects
    //  - open connection
    //
	function cindicador13_list() {
        global $conn;

        // Initialize table object
        $GLOBALS["indicador13"] = new cindicador13();

        // Initialize other table object
        $GLOBALS['usuario'] = new cusuario();

        // Intialize page id (for backward compatibility)
        if (!defined("EW_PAGE_ID"))
            define("EW_PAGE_ID", 'list', TRUE);

        // Initialize table name (for backward compatibility)
        if (!defined("EW_TABLE_NAME"))
            define("EW_TABLE_NAME", 'indicador13', TRUE);

        // Open connection to the database
        $conn = ew_Connect();

        // Initialize list options
        $this->ListOptions = new cListOptions();
    }

    // 
    //  Page_Init
    //
	function Page_Init() {
        global $gsExport, $gsExportFile, $indicador13;
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
        $indicador13->Export = @$_GET["export"]; // Get export parameter
        $gsExport = $indicador13->Export; // Get export parameter, used in header
        $gsExportFile = $indicador13->TableVar; // Get export file, used in header
        if ($indicador13->Export == "print" || $indicador13->Export == "html") {

            // Printer friendly or Export to HTML, no action required
        }
        if ($indicador13->Export == "excel") {
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
        global $objForm, $gsSearchError, $Security, $indicador13;
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
        if ($indicador13->getRecordsPerPage() <> "") {
            $this->lDisplayRecs = $indicador13->getRecordsPerPage(); // Restore from Session
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
        $indicador13->setSessionWhere($sFilter);
        $indicador13->CurrentFilter = "";

        // Export data only
        if (in_array($indicador13->Export, array("html", "word", "excel", "xml", "csv"))) {
            $this->ExportData();
            $this->Page_Terminate(); // Terminate response
            exit();
        }
    }

    // Set up number of records displayed per page
    function SetUpDisplayRecs() {
        global $indicador13;
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
            $indicador13->setRecordsPerPage($this->lDisplayRecs); // Save to Session
            // Reset start position
            $this->lStartRec = 1;
            $indicador13->setStartRecordNumber($this->lStartRec);
        }
    }

    // Set up Sort parameters based on Sort Links clicked
    function SetUpSortOrder() {
        global $indicador13;

        // Check for an Order parameter
        if (@$_GET["order"] <> "") {
            $indicador13->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
            $indicador13->CurrentOrderType = @$_GET["ordertype"];
            $indicador13->UpdateSort($indicador13->idMer); // Field 
            $indicador13->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load Sort Order parameters
    function LoadSortOrder() {
        global $indicador13;
        $sOrderBy = $indicador13->getSessionOrderBy(); // Get order by from Session
        if ($sOrderBy == "") {
            if ($indicador13->SqlOrderBy() <> "") {
                $sOrderBy = $indicador13->SqlOrderBy();
                $indicador13->setSessionOrderBy($sOrderBy);
            }
        }
    }

    // Reset command based on querystring parameter cmd=
    // - RESET: reset search parameters
    // - RESETALL: reset search & master/detail parameters
    // - RESETSORT: reset sort parameters
    function ResetCmd() {
        global $indicador13;

        // Get reset cmd
        if (@$_GET["cmd"] <> "") {
            $sCmd = $_GET["cmd"];

            // Reset sort criteria
            if (strtolower($sCmd) == "resetsort") {
                $sOrderBy = "";
                $indicador13->setSessionOrderBy($sOrderBy);
                $indicador13->idMer->setSort("");
            }

            // Reset start position
            $this->lStartRec = 1;
            $indicador13->setStartRecordNumber($this->lStartRec);
        }
    }

    // Set up Starting Record parameters based on Pager Navigation
    function SetUpStartRec() {
        global $indicador13;
        if ($this->lDisplayRecs == 0)
            return;
        if ($this->IsPageRequest()) { // Validate request			
            if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
                $this->lStartRec = $_GET[EW_TABLE_START_REC];
                $indicador13->setStartRecordNumber($this->lStartRec);
            } elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
                $this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
                if (is_numeric($this->nPageNo)) {
                    $this->lStartRec = ($this->nPageNo - 1) * $this->lDisplayRecs + 1;
                    if ($this->lStartRec <= 0) {
                        $this->lStartRec = 1;
                    } elseif ($this->lStartRec >= intval(($this->lTotalRecs - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1) {
                        $this->lStartRec = intval(($this->lTotalRecs - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1;
                    }
                    $indicador13->setStartRecordNumber($this->lStartRec);
                }
            }
        }
        $this->lStartRec = $indicador13->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
            $this->lStartRec = 1; // Reset start record counter
            $indicador13->setStartRecordNumber($this->lStartRec);
        } elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
            $this->lStartRec = intval(($this->lTotalRecs - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1; // Point to last page first record
            $indicador13->setStartRecordNumber($this->lStartRec);
        } elseif (($this->lStartRec - 1) % $this->lDisplayRecs <> 0) {
            $this->lStartRec = intval(($this->lStartRec - 1) / $this->lDisplayRecs) * $this->lDisplayRecs + 1; // Point to page boundary
            $indicador13->setStartRecordNumber($this->lStartRec);
        }
    }

    // Load recordset
    function LoadRecordset($offset = -1, $rowcnt = -1) {
        global $conn, $indicador13;

        // Call Recordset Selecting event
        $indicador13->Recordset_Selecting($indicador13->CurrentFilter);

        // Load list page SQL
        $sSql = $indicador13->SelectSQL();
        if ($offset > -1 && $rowcnt > -1)
            $sSql .= " LIMIT $offset, $rowcnt";

        // Load recordset
        $conn->raiseErrorFn = 'ew_ErrorFn';
        $rs = $conn->Execute($sSql);
        $conn->raiseErrorFn = '';

        // Call Recordset Selected event
        $indicador13->Recordset_Selected($rs);
        return $rs;
    }

    // Load row based on key values
    function LoadRow() {
        global $conn, $Security, $indicador13;
        $sFilter = $indicador13->KeyFilter();

        // Call Row Selecting event
        $indicador13->Row_Selecting($sFilter);

        // Load sql based on filter
        $indicador13->CurrentFilter = $sFilter;
        $sSql = $indicador13->SQL();
        if ($rs = $conn->Execute($sSql)) {
            if ($rs->EOF) {
                $LoadRow = FALSE;
            } else {
                $LoadRow = TRUE;
                $rs->MoveFirst();
                $this->LoadRowValues($rs); // Load row values
                // Call Row Selected event
                $indicador13->Row_Selected($rs);
            }
            $rs->Close();
        } else {
            $LoadRow = FALSE;
        }
        return $LoadRow;
    }

    // Load row values from recordset
    function LoadRowValues(&$rs) {
        global $indicador13;
        $indicador13->idMer->setDbValue($rs->fields('idMer'));
    }

    // Render row values based on field settings
    function RenderRow() {
        global $conn, $Security, $indicador13;

        // Call Row_Rendering event
        $indicador13->Row_Rendering();

        // Common render codes for all row types
        // idMer

        $indicador13->idMer->CellCssStyle = "";
        $indicador13->idMer->CellCssClass = "";
        if ($indicador13->RowType == EW_ROWTYPE_VIEW) { // View row
            // idMer
            $indicador13->idMer->ViewValue = $indicador13->idMer->CurrentValue;
            $indicador13->idMer->CssStyle = "";
            $indicador13->idMer->CssClass = "";
            $indicador13->idMer->ViewCustomAttributes = "";

            // idMer
            $indicador13->idMer->HrefValue = "";
        }

        // Call Row Rendered event
        $indicador13->Row_Rendered();
    }

    // Export data in XML or CSV format
    function ExportData() {
        global $indicador13;
        $sCsvStr = "";

        // Default export style
        $sExportStyle = "h";

        // Load recordset
        $rs = $this->LoadRecordset();
        $this->lTotalRecs = $rs->RecordCount();
        $this->lStartRec = 1;

        // Export all
        if ($indicador13->ExportAll) {
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
        if ($indicador13->Export == "xml") {
            $XmlDoc = new cXMLDocument();
        } else {
            echo ew_ExportHeader($indicador13->Export);

            // Horizontal format, write header
            if ($sExportStyle <> "v" || $indicador13->Export == "csv") {
                $sExportStr = "";
                ew_ExportAddValue($sExportStr, 'idMer', $indicador13->Export);
                echo ew_ExportLine($sExportStr, $indicador13->Export);
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
                $indicador13->RowType = EW_ROWTYPE_VIEW; // Render view
                $this->RenderRow();
                if ($indicador13->Export == "xml") {
                    $XmlDoc->BeginRow();
                    $XmlDoc->AddField('idMer', $indicador13->idMer->CurrentValue);
                    $XmlDoc->EndRow();
                } else {
                    if ($sExportStyle == "v" && $indicador13->Export <> "csv") { // Vertical format
                        echo ew_ExportField('idMer', $indicador13->idMer->ExportValue($indicador13->Export, $indicador13->ExportOriginalValue), $indicador13->Export);
                    } else { // Horizontal format
                        $sExportStr = "";
                        ew_ExportAddValue($sExportStr, $indicador13->idMer->ExportValue($indicador13->Export, $indicador13->ExportOriginalValue), $indicador13->Export);
                        echo ew_ExportLine($sExportStr, $indicador13->Export);
                    }
                }
            }
            $rs->MoveNext();
        }

        // Close recordset
        $rs->Close();
        if ($indicador13->Export == "xml") {
            header("Content-Type: text/xml");
            echo $XmlDoc->XML();
        } else {
            echo ew_ExportFooter($indicador13->Export);
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