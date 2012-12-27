<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "consultoriainfo.php" ?>
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
$consultoria_delete = new cconsultoria_delete();
$Page =& $consultoria_delete;

// Page init processing
$consultoria_delete->Page_Init();
mysql_select_db($database_conexion, $conexion);
$query_cronogramadelete= "UPDATE consultoria SET estado='0'  WHERE idConsultoria='".$_GET['idConsultoria']."'";
mysql_query($query_cronogramadelete, $conexion) or die(mysql_error());
// Page main processing
$consultoria_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var consultoria_delete = new ew_Page("consultoria_delete");

// page properties
consultoria_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = consultoria_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
consultoria_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
consultoria_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
consultoria_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $consultoria_delete->LoadRecordset();
$consultoria_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($consultoria_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$consultoria_delete->Page_Terminate("consultorialist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Consultoria<br><br>
<a href="<?php echo $consultoria->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $consultoria_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="consultoria">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($consultoria_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $consultoria->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">Nro</td>
		<td valign="top">Consultor</td>
		<td valign="top">Titulo de la Consultoria</td>
		<td valign="top">Fecha Inicio</td>
		<td valign="top">Fecha Finalizacion</td>
		<td valign="top">Estado</td>
	</tr>
	</thead>
	<tbody>
<?php
$consultoria_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$consultoria_delete->lRecCnt++;

	// Set row properties
	$consultoria->CssClass = "";
	$consultoria->CssStyle = "";
	$consultoria->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$consultoria_delete->LoadRowValues($rs);

	// Render row
	$consultoria_delete->RenderRow();
?>
	<tr<?php echo $consultoria->RowAttributes() ?>>
		<td<?php echo $consultoria->idConsultoria->CellAttributes() ?>>
<div<?php echo $consultoria->idConsultoria->ViewAttributes() ?>><?php echo $consultoria->idConsultoria->ListViewValue() ?></div></td>
		<td<?php echo $consultoria->idUsuario->CellAttributes() ?>>
<div<?php echo $consultoria->idUsuario->ViewAttributes() ?>><?php echo $consultoria->idUsuario->ListViewValue() ?></div></td>
		<td<?php echo $consultoria->consultoria->CellAttributes() ?>>
<div<?php echo $consultoria->consultoria->ViewAttributes() ?>><?php echo $consultoria->consultoria->ListViewValue() ?></div></td>
		<td<?php echo $consultoria->fechaInicio->CellAttributes() ?>>
<div<?php echo $consultoria->fechaInicio->ViewAttributes() ?>><?php echo $consultoria->fechaInicio->ListViewValue() ?></div></td>
		<td<?php echo $consultoria->fechaFinal->CellAttributes() ?>>
<div<?php echo $consultoria->fechaFinal->ViewAttributes() ?>><?php echo $consultoria->fechaFinal->ListViewValue() ?></div></td>
		<td<?php echo $consultoria->estado->CellAttributes() ?>>
<div<?php echo $consultoria->estado->ViewAttributes() ?>><?php echo $consultoria->estado->ListViewValue() ?></div></td>
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
class cconsultoria_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'consultoria';

	// Page Object Name
	var $PageObjName = 'consultoria_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $consultoria;
		if ($consultoria->UseTokenInUrl) $PageUrl .= "t=" . $consultoria->TableVar . "&"; // add page token
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
		global $objForm, $consultoria;
		if ($consultoria->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($consultoria->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($consultoria->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cconsultoria_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["consultoria"] = new cconsultoria();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'consultoria', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $consultoria;
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
			$this->Page_Terminate("consultorialist.php");
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
		global $consultoria;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idConsultoria"] <> "") {
			$consultoria->idConsultoria->setQueryStringValue($_GET["idConsultoria"]);
			if (!is_numeric($consultoria->idConsultoria->QueryStringValue))
				$this->Page_Terminate("consultorialist.php"); // Prevent SQL injection, exit
			$sKey .= $consultoria->idConsultoria->QueryStringValue;
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
			$this->Page_Terminate("consultorialist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("consultorialist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idConsultoria`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in consultoria class, consultoriainfo.php

		$consultoria->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$consultoria->CurrentAction = $_POST["a_delete"];
		} else {
			$consultoria->CurrentAction = "D"; // Delete record directly
		}
		switch ($consultoria->CurrentAction) {
			case "D": // Delete
				$consultoria->SendEmail = TRUE; // Send email on delete success
				//if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($consultoria->getReturnUrl()); // Return to caller
				//}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $consultoria;
		$DeleteRows = TRUE;
		$sWrkFilter = $consultoria->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in consultoria class, consultoriainfo.php

		$consultoria->CurrentFilter = $sWrkFilter;
		$sSql = $consultoria->SQL();
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
				$DeleteRows = $consultoria->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idConsultoria'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($consultoria->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($consultoria->CancelMessage <> "") {
				$this->setMessage($consultoria->CancelMessage);
				$consultoria->CancelMessage = "";
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
				$consultoria->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $consultoria;

		// Call Recordset Selecting event
		$consultoria->Recordset_Selecting($consultoria->CurrentFilter);

		// Load list page SQL
		$sSql = $consultoria->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$consultoria->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $consultoria;
		$sFilter = $consultoria->KeyFilter();

		// Call Row Selecting event
		$consultoria->Row_Selecting($sFilter);

		// Load sql based on filter
		$consultoria->CurrentFilter = $sFilter;
		$sSql = $consultoria->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$consultoria->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $consultoria;
		$consultoria->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$consultoria->idUsuario->setDbValue($rs->fields('idUsuario'));
		$consultoria->consultoria->setDbValue($rs->fields('consultoria'));
		$consultoria->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$consultoria->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$consultoria->estado->setDbValue($rs->fields('estado'));
		$consultoria->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$consultoria->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $consultoria;

		// Call Row_Rendering event
		$consultoria->Row_Rendering();

		// Common render codes for all row types
		// idConsultoria

		$consultoria->idConsultoria->CellCssStyle = "";
		$consultoria->idConsultoria->CellCssClass = "";

		// idUsuario
		$consultoria->idUsuario->CellCssStyle = "";
		$consultoria->idUsuario->CellCssClass = "";

		// consultoria
		$consultoria->consultoria->CellCssStyle = "";
		$consultoria->consultoria->CellCssClass = "";

		// fechaInicio
		$consultoria->fechaInicio->CellCssStyle = "";
		$consultoria->fechaInicio->CellCssClass = "";

		// fechaFinal
		$consultoria->fechaFinal->CellCssStyle = "";
		$consultoria->fechaFinal->CellCssClass = "";

		// estado
		$consultoria->estado->CellCssStyle = "";
		$consultoria->estado->CellCssClass = "";
		if ($consultoria->RowType == EW_ROWTYPE_VIEW) { // View row

			// idConsultoria
			$consultoria->idConsultoria->ViewValue = $consultoria->idConsultoria->CurrentValue;
			$consultoria->idConsultoria->CssStyle = "";
			$consultoria->idConsultoria->CssClass = "";
			$consultoria->idConsultoria->ViewCustomAttributes = "";

			// idUsuario
			if (strval($consultoria->idUsuario->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `paterno`, `nombre` FROM `usuario` WHERE `idUsuario` = " . ew_AdjustSql($consultoria->idUsuario->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `paterno` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$consultoria->idUsuario->ViewValue = $rswrk->fields('paterno');
					$consultoria->idUsuario->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('nombre');
					$rswrk->Close();
				} else {
					$consultoria->idUsuario->ViewValue = $consultoria->idUsuario->CurrentValue;
				}
			} else {
				$consultoria->idUsuario->ViewValue = NULL;
			}
			$consultoria->idUsuario->CssStyle = "";
			$consultoria->idUsuario->CssClass = "";
			$consultoria->idUsuario->ViewCustomAttributes = "";

			// consultoria
			$consultoria->consultoria->ViewValue = $consultoria->consultoria->CurrentValue;
			$consultoria->consultoria->CssStyle = "";
			$consultoria->consultoria->CssClass = "";
			$consultoria->consultoria->ViewCustomAttributes = "";

			// fechaInicio
			$consultoria->fechaInicio->ViewValue = $consultoria->fechaInicio->CurrentValue;
			$consultoria->fechaInicio->ViewValue = ew_FormatDateTime($consultoria->fechaInicio->ViewValue, 7);
			$consultoria->fechaInicio->CssStyle = "";
			$consultoria->fechaInicio->CssClass = "";
			$consultoria->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$consultoria->fechaFinal->ViewValue = $consultoria->fechaFinal->CurrentValue;
			$consultoria->fechaFinal->ViewValue = ew_FormatDateTime($consultoria->fechaFinal->ViewValue, 7);
			$consultoria->fechaFinal->CssStyle = "";
			$consultoria->fechaFinal->CssClass = "";
			$consultoria->fechaFinal->ViewCustomAttributes = "";

			// estado
			if (strval($consultoria->estado->CurrentValue) <> "") {
				switch ($consultoria->estado->CurrentValue) {
					case "0":
						$consultoria->estado->ViewValue = "borrado";
						break;
					case "1":
						$consultoria->estado->ViewValue = "Habilitado";
						break;
					case "2":
						$consultoria->estado->ViewValue = "Desabilitado";
						break;
					case "3":
						$consultoria->estado->ViewValue = "Aprobado";
						break;
					default:
						$consultoria->estado->ViewValue = $consultoria->estado->CurrentValue;
				}
			} else {
				$consultoria->estado->ViewValue = NULL;
			}
			$consultoria->estado->CssStyle = "";
			$consultoria->estado->CssClass = "";
			$consultoria->estado->ViewCustomAttributes = "";

			// idConsultoria
			$consultoria->idConsultoria->HrefValue = "";

			// idUsuario
			$consultoria->idUsuario->HrefValue = "";

			// consultoria
			$consultoria->consultoria->HrefValue = "";

			// fechaInicio
			$consultoria->fechaInicio->HrefValue = "";

			// fechaFinal
			$consultoria->fechaFinal->HrefValue = "";

			// estado
			$consultoria->estado->HrefValue = "";
		}

		// Call Row Rendered event
		$consultoria->Row_Rendered();
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
