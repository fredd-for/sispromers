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
$cronograma_delete = new ccronograma_delete();
$Page =& $cronograma_delete;

// Page init processing
$cronograma_delete->Page_Init();
///////////////////
function borrar_meta_cascada($idMeta,$database_conexion, $conexion){
/////////////////////////////////////////
//Borramos idMeta de la tabla Meta+
$value=$idMeta;
mysql_select_db($database_conexion, $conexion);
$query_item_costodelete = "DELETE FROM meta WHERE idMeta='".$value."'";
//$query_item_costodelete = "DELETE a,b,c,d FROM meta AS a INNER JOIN meta_reporte AS b ON a.idMeta=b.idMeta INNER JOIN meta_reporte_control AS c ON b.idMetaReporte=c.idMetaReporte INNER JOIN meta_reporte_unitario AS d ON a.idMeta=d.idMeta WHERE a.idMeta='".$value."'";
mysql_query($query_item_costodelete, $conexion) or die(mysql_error());

// borramos la tabla meta_reporte_unitario y sus archivos adjuntos
mysql_select_db($database_conexion, $conexion);
$query_meta_reporte_unitario = "SELECT idMetaReporteUnitario,archivo FROM meta_reporte_unitario WHERE idMeta=$value";
$mostrar_meta_reporte_unitario=mysql_query($query_meta_reporte_unitario, $conexion) or die(mysql_error());
while($row_meta_reporte_unitario=  mysql_fetch_assoc($mostrar_meta_reporte_unitario)){
mysql_select_db($database_conexion, $conexion);
$query_archivodelete = "DELETE FROM meta_reporte_unitario WHERE idMetaReporteUnitario=".$row_meta_reporte_unitario['idMetaReporteUnitario'];
mysql_query($query_archivodelete, $conexion) or die(mysql_error());
unlink("files_consultoria/".$row_meta_reporte_unitario['archivo']);
}
// Borramos la tabla meta_reporte_control
mysql_select_db($database_conexion, $conexion);
$query_meta_reporte_control = "SELECT b.idMetaReporteControl, b.archivo FROM meta_reporte a, meta_reporte_control b WHERE a.idMeta=$value AND a.idMetaReporte=b.idMetaReporte";
$mostrar_meta_reporte_control=mysql_query($query_meta_reporte_control, $conexion) or die(mysql_error());
while($row_meta_reporte_control=  mysql_fetch_assoc($mostrar_meta_reporte_control)){
mysql_select_db($database_conexion, $conexion);
$query_archivodelete = "DELETE FROM meta_reporte_control WHERE idMetaReporteControl=".$row_meta_reporte_control['idMetaReporteControl'];
mysql_query($query_archivodelete, $conexion) or die(mysql_error());
unlink("files_consultoria/".$row_meta_reporte_control['archivo']);
}
// borramos la tabla meta_control
mysql_select_db($database_conexion, $conexion);
$query_meta_reporte = "SELECT idMetaReporte, archivo FROM meta_reporte WHERE idMeta=$value";
$mostrar_meta_reporte=mysql_query($query_meta_reporte, $conexion) or die(mysql_error());
while($row_meta_reporte=  mysql_fetch_assoc($mostrar_meta_reporte)){
mysql_select_db($database_conexion, $conexion);
$query_archivodelete = "DELETE FROM meta_reporte WHERE idMetaReporte=".$row_meta_reporte['idMetaReporte'];
mysql_query($query_archivodelete, $conexion) or die(mysql_error());
unlink("files_consultoria/".$row_meta_reporte['archivo']);
}
////////////
}

// realizar un delete inner join de las siguientes tablas (cronograma,cronograma_reporte,cronograma_reporte_control,indicador,meta,meta_reporte,meta_reporte_control,meta_reporte_unitario)
mysql_select_db($database_conexion, $conexion);
$query_cronogramadelete= "DELETE FROM indicador WHERE idCronograma='".$_GET['idCronograma']."'";
mysql_query($query_cronogramadelete, $conexion) or die(mysql_error());

// Borramos la tabla cronograma_reporte_control
mysql_select_db($database_conexion, $conexion);
$query_meta_reporte_control = "SELECT b.idCronogramaReporteControl, b.archivo FROM cronograma_reporte a, cronograma_reporte_control b WHERE a.idCronograma='".$_GET['idCronograma']."' AND a.idCronogramaReporte=b.idCronogramaReporte";
$mostrar_meta_reporte_control=mysql_query($query_meta_reporte_control, $conexion) or die(mysql_error());
while($row_meta_reporte_control=  mysql_fetch_assoc($mostrar_meta_reporte_control)){
mysql_select_db($database_conexion, $conexion);
$query_archivodelete = "DELETE FROM cronograma_reporte_control WHERE idCronogramaReporteControl=".$row_meta_reporte_control['idCronogramaReporteControl'];
mysql_query($query_archivodelete, $conexion) or die(mysql_error());
unlink("files_consultoria/".$row_meta_reporte_control['archivo']);
}
// borramos la tabla meta_control
mysql_select_db($database_conexion, $conexion);
$query_meta_reporte = "SELECT idCronogramaReporte, archivo FROM cronograma_reporte WHERE idCronograma='".$_GET['idCronograma']."'";
$mostrar_meta_reporte=mysql_query($query_meta_reporte, $conexion) or die(mysql_error());
while($row_meta_reporte=  mysql_fetch_assoc($mostrar_meta_reporte)){
mysql_select_db($database_conexion, $conexion);
$query_archivodelete = "DELETE FROM cronograma_reporte WHERE idCronogramaReporte=".$row_meta_reporte['idCronogramaReporte'];
mysql_query($query_archivodelete, $conexion) or die(mysql_error());
unlink("files_consultoria/".$row_meta_reporte['archivo']);
}

mysql_select_db($database_conexion, $conexion);
$query_metadelete= "SELECT idMeta FROM meta WHERE idCronograma='".$_GET['idCronograma']."'";
$mostrar_metadelete=mysql_query($query_metadelete, $conexion) or die(mysql_error());
while($row_metadelete=  mysql_fetch_assoc($mostrar_metadelete)){
    borrar_meta_cascada($row_metadelete['idMeta'],$database_conexion, $conexion);
}
// Page main processing
$cronograma_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var cronograma_delete = new ew_Page("cronograma_delete");

// page properties
cronograma_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = cronograma_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cronograma_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cronograma_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cronograma_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<?php

// Load records for display
$rs = $cronograma_delete->LoadRecordset();
$cronograma_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($cronograma_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$cronograma_delete->Page_Terminate("cronogramalist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Cronograma<br><br>
<a href="<?php echo $cronograma->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $cronograma_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="cronograma">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cronograma_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $cronograma->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Id Consultoria</td>
		<td valign="top">Fecha Inicio</td>
		<td valign="top">Fecha Final</td>
		<td valign="top">Detalle</td>
		<td valign="top">Mes Anio</td>
		<td valign="top">Estado</td>
	</tr>
	</thead>
	<tbody>
<?php
$cronograma_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$cronograma_delete->lRecCnt++;

	// Set row properties
	$cronograma->CssClass = "";
	$cronograma->CssStyle = "";
	$cronograma->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cronograma_delete->LoadRowValues($rs);

	// Render row
	$cronograma_delete->RenderRow();
?>
	<tr<?php echo $cronograma->RowAttributes() ?>>
		<td<?php echo $cronograma->idCronograma->CellAttributes() ?>>
<div<?php echo $cronograma->idCronograma->ViewAttributes() ?>><?php echo $cronograma->idCronograma->ListViewValue() ?></div></td>
		<td<?php echo $cronograma->idConsultoria->CellAttributes() ?>>
<div<?php echo $cronograma->idConsultoria->ViewAttributes() ?>><?php echo $cronograma->idConsultoria->ListViewValue() ?></div></td>
		<td<?php echo $cronograma->fechaInicio->CellAttributes() ?>>
<div<?php echo $cronograma->fechaInicio->ViewAttributes() ?>><?php echo $cronograma->fechaInicio->ListViewValue() ?></div></td>
		<td<?php echo $cronograma->fechaFinal->CellAttributes() ?>>
<div<?php echo $cronograma->fechaFinal->ViewAttributes() ?>><?php echo $cronograma->fechaFinal->ListViewValue() ?></div></td>
		<td<?php echo $cronograma->detalle->CellAttributes() ?>>
<div<?php echo $cronograma->detalle->ViewAttributes() ?>><?php echo $cronograma->detalle->ListViewValue() ?></div></td>
		<td<?php echo $cronograma->mesAnio->CellAttributes() ?>>
<div<?php echo $cronograma->mesAnio->ViewAttributes() ?>><?php echo $cronograma->mesAnio->ListViewValue() ?></div></td>
		<td<?php echo $cronograma->estado->CellAttributes() ?>>
<div<?php echo $cronograma->estado->ViewAttributes() ?>><?php echo $cronograma->estado->ListViewValue() ?></div></td>
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
class ccronograma_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'cronograma';

	// Page Object Name
	var $PageObjName = 'cronograma_delete';

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
	function ccronograma_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["cronograma"] = new ccronograma();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cronograma', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("cronogramalist.php");
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
		global $cronograma;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idCronograma"] <> "") {
			$cronograma->idCronograma->setQueryStringValue($_GET["idCronograma"]);
			if (!is_numeric($cronograma->idCronograma->QueryStringValue))
				$this->Page_Terminate("cronogramalist.php"); // Prevent SQL injection, exit
			$sKey .= $cronograma->idCronograma->QueryStringValue;
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
			$this->Page_Terminate("cronogramalist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("cronogramalist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idCronograma`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in cronograma class, cronogramainfo.php

		$cronograma->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$cronograma->CurrentAction = $_POST["a_delete"];
		} else {
			$cronograma->CurrentAction = "D"; // Delete record directly
		}
		switch ($cronograma->CurrentAction) {
			case "D": // Delete
				$cronograma->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($cronograma->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $cronograma;
		$DeleteRows = TRUE;
		$sWrkFilter = $cronograma->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in cronograma class, cronogramainfo.php

		$cronograma->CurrentFilter = $sWrkFilter;
		$sSql = $cronograma->SQL();
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
				$DeleteRows = $cronograma->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idCronograma'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($cronograma->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($cronograma->CancelMessage <> "") {
				$this->setMessage($cronograma->CancelMessage);
				$cronograma->CancelMessage = "";
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
				$cronograma->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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
						$cronograma->estado->ViewValue = "Habilitado";
						break;
					case "2":
						$cronograma->estado->ViewValue = "Desabilitado";
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
