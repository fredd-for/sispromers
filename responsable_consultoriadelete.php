<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "responsable_consultoriainfo.php" ?>
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
$responsable_consultoria_delete = new cresponsable_consultoria_delete();
$Page =& $responsable_consultoria_delete;

// Page init processing
$responsable_consultoria_delete->Page_Init();

$idRC=$_GET['idRC'];
mysql_select_db($database_conexion, $conexion);
$sqlRC= "SELECT idRC, idConsultoria
    FROM responsable_consultoria
    WHERE idRC NOT IN (".$idRC.") AND idConsultoria IN (SELECT idConsultoria FROM responsable_consultoria WHERE idRC=".$idRC.")";
$mostrar_responsable_consultoria=mysql_query($sqlRC, $conexion) or die(mysql_error());
$row_responsable_consultoria=  mysql_fetch_assoc($mostrar_responsable_consultoria);

mysql_select_db($database_conexion, $conexion);
$sqlCR= "SELECT a.idCronograma, Max(b.idCronogramaReporte) as idCronogramaReporte
FROM cronograma AS a Inner Join cronograma_reporte AS b ON a.idCronograma = b.idCronograma
WHERE a.idConsultoria =  '".$row_responsable_consultoria['idConsultoria']."' GROUP BY a.idCronograma";
$mostrar_cronogramaReporte=mysql_query($sqlCR, $conexion) or die(mysql_error());

while($row_cronogramaReporte=  mysql_fetch_assoc($mostrar_cronogramaReporte)) {
    mysql_select_db($database_conexion, $conexion);
    $mostrar_responsable_consultoria=mysql_query($sqlRC, $conexion) or die(mysql_error());
    
    $sw=1;
    while(($row_responsable_consultoria =  mysql_fetch_assoc($mostrar_responsable_consultoria)) && ($sw==1)) {
        mysql_select_db($database_conexion, $conexion);
        $sql= "SELECT idCronogramaReporteControl
            FROM cronograma_reporte_control
            WHERE idRC='".$row_responsable_consultoria['idRC']."' AND idCronogramaReporte='".$row_cronogramaReporte['idCronogramaReporte']."' AND estado=3";
        $mostrar_crc=mysql_query($sql, $conexion) or die(mysql_error());
        $total=mysql_num_rows($mostrar_crc);
        if($total<1) {
            $sw=0;
        }
    }
    if($sw==1){
mysql_select_db($database_conexion, $conexion);
$query_cronogramaUpdate = "UPDATE cronograma SET estado=3 WHERE idCronograma=".$row_cronogramaReporte['idCronograma'];
mysql_query($query_cronogramaUpdate, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_cronogramaReporteUpdate = "UPDATE cronograma_reporte SET estado=3 WHERE idCronogramaReporte=".$row_cronogramaReporte['idCronogramaReporte'];
mysql_query($query_cronogramaReporteUpdate, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_metaUpdate = "UPDATE meta SET estado=3 WHERE idCronograma=".$row_cronogramaReporte['idCronograma'];
mysql_query($query_metaUpdate, $conexion) or die(mysql_error());
    }
}
// Page main processing
$responsable_consultoria_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
    <!--

    // Create page object
    var responsable_consultoria_delete = new ew_Page("responsable_consultoria_delete");

    // page properties
    responsable_consultoria_delete.PageID = "delete"; // page ID
    var EW_PAGE_ID = responsable_consultoria_delete.PageID; // for backward compatibility

    // extend page with Form_CustomValidate function
    responsable_consultoria_delete.Form_CustomValidate =
        function(fobj) { // DO NOT CHANGE THIS LINE!

        // Your custom validation code here, return false if invalid.
        return true;
    }
<?php if (EW_CLIENT_VALIDATE) { ?>
    responsable_consultoria_delete.ValidateRequired = true; // uses JavaScript validation
    <?php } else { ?>
    responsable_consultoria_delete.ValidateRequired = false; // no JavaScript validation
    <?php } ?>

    //-->
</script>
<script language="JavaScript" type="text/javascript">
    <!--

    // Write your client script here, no need to add script tags.
    // To include another .js script, use:
    // ew_ClientScriptInclude("my_javascript.js");
    //-->

</script>
<?php

// Load records for display
$rs = $responsable_consultoria_delete->LoadRecordset();
$responsable_consultoria_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($responsable_consultoria_deletelTotalRecs <= 0) { // No record found, exit
    $rs->Close();
    $responsable_consultoria_delete->Page_Terminate("responsable_consultorialist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Responsable Consultoria<br><br>
        <a href="<?php echo $responsable_consultoria->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $responsable_consultoria_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
    <p>
        <input type="hidden" name="t" id="t" value="responsable_consultoria">
        <input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($responsable_consultoria_delete->arRecKeys as $key) { ?>
        <input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
    <?php } ?>
    <table class="ewGrid"><tr><td class="ewGridContent">
                <div class="ewGridMiddlePanel">
                    <table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $responsable_consultoria->TableCustomInnerHtml ?>
                        <thead>
                            <tr class="ewTableHeader">
                                <td valign="top">No</td>
                                <td valign="top">Usuario (Revisor)</td>
                                <td valign="top">Consultoria</td>
                                <td valign="top">Fecha de Asignacion</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $responsable_consultoria_delete->lRecCnt = 0;
                            $i = 0;
                            while (!$rs->EOF) {
                                $responsable_consultoria_delete->lRecCnt++;

                                // Set row properties
                                $responsable_consultoria->CssClass = "";
                                $responsable_consultoria->CssStyle = "";
                                $responsable_consultoria->RowType = EW_ROWTYPE_VIEW; // View

                                // Get the field contents
                                $responsable_consultoria_delete->LoadRowValues($rs);

                                // Render row
                                $responsable_consultoria_delete->RenderRow();
    ?>
                            <tr<?php echo $responsable_consultoria->RowAttributes() ?>>
                                <td<?php echo $responsable_consultoria->idRC->CellAttributes() ?>>
                                    <div<?php echo $responsable_consultoria->idRC->ViewAttributes() ?>><?php echo $responsable_consultoria->idRC->ListViewValue() ?></div></td>
                                <td<?php echo $responsable_consultoria->idUsuario->CellAttributes() ?>>
                                    <div<?php echo $responsable_consultoria->idUsuario->ViewAttributes() ?>><?php echo $responsable_consultoria->idUsuario->ListViewValue() ?></div></td>
                                <td<?php echo $responsable_consultoria->idConsultoria->CellAttributes() ?>>
                                    <div<?php echo $responsable_consultoria->idConsultoria->ViewAttributes() ?>><?php echo $responsable_consultoria->idConsultoria->ListViewValue() ?></div></td>
                                <td<?php echo $responsable_consultoria->fecha->CellAttributes() ?>>
                                    <div<?php echo $responsable_consultoria->fecha->ViewAttributes() ?>><?php echo $responsable_consultoria->fecha->ListViewValue() ?></div></td>
                            </tr>
                                <?php
                                $rs->MoveNext();
                            }
                            $rs->Close();
?>
                        </tbody>
                    </table>
                </div>
            </td></tr></table>
    <p>
        <input type="submit" name="Action" id="Action" value="CONFIRMAR BORRADO">
</form>
<script language="JavaScript" type="text/javascript">
    <!--

    // Write your table-specific startup script here
    // document.write("page loaded");
    //-->

</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cresponsable_consultoria_delete {

    // Page ID
    var $PageID = 'delete';

    // Table Name
    var $TableName = 'responsable_consultoria';

    // Page Object Name
    var $PageObjName = 'responsable_consultoria_delete';

    // Page Name
    function PageName() {
        return ew_CurrentPage();
    }

    // Page Url
    function PageUrl() {
        $PageUrl = ew_CurrentPage() . "?";
        global $responsable_consultoria;
        if ($responsable_consultoria->UseTokenInUrl) $PageUrl .= "t=" . $responsable_consultoria->TableVar . "&"; // add page token
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
        global $objForm, $responsable_consultoria;
        if ($responsable_consultoria->UseTokenInUrl) {

            //IsPageRequest = False
            if ($objForm)
                return ($responsable_consultoria->TableVar == $objForm->GetValue("t"));
            if (@$_GET["t"] <> "")
                return ($responsable_consultoria->TableVar == $_GET["t"]);
        } else {
            return TRUE;
        }
    }

    //
    //  Class initialize
    //  - init objects
    //  - open connection
    //
    function cresponsable_consultoria_delete() {
        global $conn;

        // Initialize table object
        $GLOBALS["responsable_consultoria"] = new cresponsable_consultoria();

        // Initialize other table object
        $GLOBALS['usuario'] = new cusuario();

        // Intialize page id (for backward compatibility)
        if (!defined("EW_PAGE_ID"))
            define("EW_PAGE_ID", 'delete', TRUE);

        // Initialize table name (for backward compatibility)
        if (!defined("EW_TABLE_NAME"))
            define("EW_TABLE_NAME", 'responsable_consultoria', TRUE);

        // Open connection to the database
        $conn = ew_Connect();
    }

    //
    //  Page_Init
    //
    function Page_Init() {
        global $gsExport, $gsExportFile, $responsable_consultoria;
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
        if (!$Security->CanDelete()) {
            $Security->SaveLastUrl();
            $this->Page_Terminate("responsable_consultorialist.php");
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
    var $lTotalRecs;
    var $lRecCnt;
    var $arRecKeys = array();

    // Page main processing
    function Page_Main() {
        global $responsable_consultoria;

        // Load Key Parameters
        $sKey = "";
        $bSingleDelete = TRUE; // Initialize as single delete
        $nKeySelected = 0; // Initialize selected key count
        $sFilter = "";
        if (@$_GET["idRC"] <> "") {
            $responsable_consultoria->idRC->setQueryStringValue($_GET["idRC"]);
            if (!is_numeric($responsable_consultoria->idRC->QueryStringValue))
                $this->Page_Terminate("responsable_consultorialist.php"); // Prevent SQL injection, exit
            $sKey .= $responsable_consultoria->idRC->QueryStringValue;
        } else {
            $bSingleDelete = FALSE;
        }
        if ($bSingleDelete) {
            $nKeySelected = 1; // Set up key selected count
            $this->arRecKeys[0] = $sKey;
        } else {
            if (isset($_POST["key_m"])) { // Key in form
                $nKeySelected = count($_POST["key_m"]); // Set up key selected count
                $this->arRecKeys = ew_StripSlashes($_POST["key_m"]);
            }
        }
        if ($nKeySelected <= 0)
            $this->Page_Terminate("responsable_consultorialist.php"); // No key specified, return to list

        // Build filter
        foreach ($this->arRecKeys as $sKey) {
            $sFilter .= "(";

            // Set up key field
            $sKeyFld = $sKey;
            if (!is_numeric($sKeyFld))
                $this->Page_Terminate("responsable_consultorialist.php"); // Prevent SQL injection, return to list
            $sFilter .= "`idRC`=" . ew_AdjustSql($sKeyFld) . " AND ";
            if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
        }
        if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

        // Set up filter (SQL WhHERE clause) and get return SQL
        // SQL constructor in SQL constructor in responsable_consultoria class, responsable_consultoriainfo.php

        $responsable_consultoria->CurrentFilter = $sFilter;

        // Get action
        if (@$_POST["a_delete"] <> "") {
            $responsable_consultoria->CurrentAction = $_POST["a_delete"];
        } else {
            $responsable_consultoria->CurrentAction = "D"; // Delete record directly
        }
        switch ($responsable_consultoria->CurrentAction) {
            case "D": // Delete
                $responsable_consultoria->SendEmail = TRUE; // Send email on delete success
                if ($this->DeleteRows()) { // delete rows
                    $this->setMessage("Borrado Exitoso"); // Set up success message
                    $this->Page_Terminate($responsable_consultoria->getReturnUrl()); // Return to caller
                }
        }
    }

    //
    //  Function DeleteRows
    //  - Delete Records based on current filter
    //
    function DeleteRows() {
        global $conn, $Security, $responsable_consultoria;
        $DeleteRows = TRUE;
        $sWrkFilter = $responsable_consultoria->CurrentFilter;

        // Set up filter (Sql Where Clause) and get Return SQL
        // SQL constructor in responsable_consultoria class, responsable_consultoriainfo.php

        $responsable_consultoria->CurrentFilter = $sWrkFilter;
        $sSql = $responsable_consultoria->SQL();
        $conn->raiseErrorFn = 'ew_ErrorFn';
        $rs = $conn->Execute($sSql);
        $conn->raiseErrorFn = '';
        if ($rs === FALSE) {
            return FALSE;
        } elseif ($rs->EOF) {
            $this->setMessage("No se encontraron registros"); // No record found
            $rs->Close();
            return FALSE;
        }
        $conn->BeginTrans();

        // Clone old rows
        $rsold = ($rs) ? $rs->GetRows() : array();
        if ($rs) $rs->Close();

        // Call row deleting event
        if ($DeleteRows) {
            foreach ($rsold as $row) {
                $DeleteRows = $responsable_consultoria->Row_Deleting($row);
                if (!$DeleteRows) break;
            }
        }
        if ($DeleteRows) {
            $sKey = "";
            foreach ($rsold as $row) {
                $sThisKey = "";
                if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
                $sThisKey .= $row['idRC'];
                $conn->raiseErrorFn = 'ew_ErrorFn';
                $DeleteRows = $conn->Execute($responsable_consultoria->DeleteSQL($row)); // Delete
                $conn->raiseErrorFn = '';
                if ($DeleteRows === FALSE)
                    break;
                if ($sKey <> "") $sKey .= ", ";
                $sKey .= $sThisKey;
            }
        } else {

            // Set up error message
            if ($responsable_consultoria->CancelMessage <> "") {
                $this->setMessage($responsable_consultoria->CancelMessage);
                $responsable_consultoria->CancelMessage = "";
            } else {
                $this->setMessage("borrado cancelado");
            }
        }
        if ($DeleteRows) {
            $conn->CommitTrans(); // Commit the changes
        } else {
            $conn->RollbackTrans(); // Rollback changes
        }

        // Call recordset deleted event
        if ($DeleteRows) {
            foreach ($rsold as $row) {
                $responsable_consultoria->Row_Deleted($row);
            }
        }
        return $DeleteRows;
    }

    // Load recordset
    function LoadRecordset($offset = -1, $rowcnt = -1) {
        global $conn, $responsable_consultoria;

        // Call Recordset Selecting event
        $responsable_consultoria->Recordset_Selecting($responsable_consultoria->CurrentFilter);

        // Load list page SQL
        $sSql = $responsable_consultoria->SelectSQL();
        if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

        // Load recordset
        $conn->raiseErrorFn = 'ew_ErrorFn';
        $rs = $conn->Execute($sSql);
        $conn->raiseErrorFn = '';

        // Call Recordset Selected event
        $responsable_consultoria->Recordset_Selected($rs);
        return $rs;
    }

    // Load row based on key values
    function LoadRow() {
        global $conn, $Security, $responsable_consultoria;
        $sFilter = $responsable_consultoria->KeyFilter();

        // Call Row Selecting event
        $responsable_consultoria->Row_Selecting($sFilter);

        // Load sql based on filter
        $responsable_consultoria->CurrentFilter = $sFilter;
        $sSql = $responsable_consultoria->SQL();
        if ($rs = $conn->Execute($sSql)) {
            if ($rs->EOF) {
                $LoadRow = FALSE;
            } else {
                $LoadRow = TRUE;
                $rs->MoveFirst();
                $this->LoadRowValues($rs); // Load row values

                // Call Row Selected event
                $responsable_consultoria->Row_Selected($rs);
            }
            $rs->Close();
        } else {
            $LoadRow = FALSE;
        }
        return $LoadRow;
    }

    // Load row values from recordset
    function LoadRowValues(&$rs) {
        global $responsable_consultoria;
        $responsable_consultoria->idRC->setDbValue($rs->fields('idRC'));
        $responsable_consultoria->idUsuario->setDbValue($rs->fields('idUsuario'));
        $responsable_consultoria->idConsultoria->setDbValue($rs->fields('idConsultoria'));
        $responsable_consultoria->fecha->setDbValue($rs->fields('fecha'));
        $responsable_consultoria->habilitado->setDbValue($rs->fields('habilitado'));
    }

    // Render row values based on field settings
    function RenderRow() {
        global $conn, $Security, $responsable_consultoria;

        // Call Row_Rendering event
        $responsable_consultoria->Row_Rendering();

        // Common render codes for all row types
        // idRC

        $responsable_consultoria->idRC->CellCssStyle = "";
        $responsable_consultoria->idRC->CellCssClass = "";

        // idUsuario
        $responsable_consultoria->idUsuario->CellCssStyle = "";
        $responsable_consultoria->idUsuario->CellCssClass = "";

        // idConsultoria
        $responsable_consultoria->idConsultoria->CellCssStyle = "";
        $responsable_consultoria->idConsultoria->CellCssClass = "";

        // fecha
        $responsable_consultoria->fecha->CellCssStyle = "";
        $responsable_consultoria->fecha->CellCssClass = "";
        if ($responsable_consultoria->RowType == EW_ROWTYPE_VIEW) { // View row

            // idRC
            $responsable_consultoria->idRC->ViewValue = $responsable_consultoria->idRC->CurrentValue;
            $responsable_consultoria->idRC->CssStyle = "";
            $responsable_consultoria->idRC->CssClass = "";
            $responsable_consultoria->idRC->ViewCustomAttributes = "";

            // idUsuario
            if (strval($responsable_consultoria->idUsuario->CurrentValue) <> "") {
                $sSqlWrk = "SELECT `nombre`, `paterno` FROM `usuario` WHERE `idUsuario` = " . ew_AdjustSql($responsable_consultoria->idUsuario->CurrentValue) . "";
                $sSqlWrk .= " ORDER BY `paterno` Asc";
                $rswrk = $conn->Execute($sSqlWrk);
                if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
                    $responsable_consultoria->idUsuario->ViewValue = $rswrk->fields('nombre');
                    $responsable_consultoria->idUsuario->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('paterno');
                    $rswrk->Close();
                } else {
                    $responsable_consultoria->idUsuario->ViewValue = $responsable_consultoria->idUsuario->CurrentValue;
                }
            } else {
                $responsable_consultoria->idUsuario->ViewValue = NULL;
            }
            $responsable_consultoria->idUsuario->CssStyle = "";
            $responsable_consultoria->idUsuario->CssClass = "";
            $responsable_consultoria->idUsuario->ViewCustomAttributes = "";

            // idConsultoria
            if (strval($responsable_consultoria->idConsultoria->CurrentValue) <> "") {
                $sSqlWrk = "SELECT `consultoria`, `idUsuario` FROM `consultoria` WHERE `idConsultoria` = " . ew_AdjustSql($responsable_consultoria->idConsultoria->CurrentValue) . "";
                $sSqlWrk .= " ORDER BY `consultoria` Asc";
                $rswrk = $conn->Execute($sSqlWrk);
                if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
                    $responsable_consultoria->idConsultoria->ViewValue = $rswrk->fields('consultoria');
                    $responsable_consultoria->idConsultoria->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('idUsuario');
                    $rswrk->Close();
                } else {
                    $responsable_consultoria->idConsultoria->ViewValue = $responsable_consultoria->idConsultoria->CurrentValue;
                }
            } else {
                $responsable_consultoria->idConsultoria->ViewValue = NULL;
            }
            $responsable_consultoria->idConsultoria->CssStyle = "";
            $responsable_consultoria->idConsultoria->CssClass = "";
            $responsable_consultoria->idConsultoria->ViewCustomAttributes = "";

            // fecha
            $responsable_consultoria->fecha->ViewValue = $responsable_consultoria->fecha->CurrentValue;
            $responsable_consultoria->fecha->ViewValue = ew_FormatDateTime($responsable_consultoria->fecha->ViewValue, 7);
            $responsable_consultoria->fecha->CssStyle = "";
            $responsable_consultoria->fecha->CssClass = "";
            $responsable_consultoria->fecha->ViewCustomAttributes = "";

            // idRC
            $responsable_consultoria->idRC->HrefValue = "";

            // idUsuario
            $responsable_consultoria->idUsuario->HrefValue = "";

            // idConsultoria
            $responsable_consultoria->idConsultoria->HrefValue = "";

            // fecha
            $responsable_consultoria->fecha->HrefValue = "";
        }

        // Call Row Rendered event
        $responsable_consultoria->Row_Rendered();
    }

    // Page Load event
    function Page_Load() {

        //echo "Page Load";
    }

    // Page Unload event
    function Page_Unload() {

        //echo "Page Unload";
    }
}
?>
