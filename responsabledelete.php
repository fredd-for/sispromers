<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "responsableinfo.php" ?>
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
$responsable_delete = new cresponsable_delete();
$Page =& $responsable_delete;

// Page init processing
$responsable_delete->Page_Init();

// Page main processing
$responsable_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var responsable_delete = new ew_Page("responsable_delete");

// page properties
responsable_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = responsable_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
responsable_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
responsable_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
responsable_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $responsable_delete->LoadRecordset();
$responsable_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($responsable_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$responsable_delete->Page_Terminate("responsablelist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Responsable<br><br>
<a href="<?php echo $responsable->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $responsable_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="responsable">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($responsable_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $responsable->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Gerente</td>
		<td valign="top">Mer</td>
		<td valign="top">Fecha de Asignacion</td>
	</tr>
	</thead>
	<tbody>
<?php
$responsable_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$responsable_delete->lRecCnt++;

	// Set row properties
	$responsable->CssClass = "";
	$responsable->CssStyle = "";
	$responsable->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$responsable_delete->LoadRowValues($rs);

	// Render row
	$responsable_delete->RenderRow();
?>
	<tr<?php echo $responsable->RowAttributes() ?>>
		<td<?php echo $responsable->idResponsable->CellAttributes() ?>>
<div<?php echo $responsable->idResponsable->ViewAttributes() ?>><?php echo $responsable->idResponsable->ListViewValue() ?></div></td>
		<td<?php echo $responsable->idGerente->CellAttributes() ?>>
<div<?php echo $responsable->idGerente->ViewAttributes() ?>><?php echo $responsable->idGerente->ListViewValue() ?></div></td>
		<td<?php echo $responsable->idMer->CellAttributes() ?>>
<div<?php echo $responsable->idMer->ViewAttributes() ?>><?php echo $responsable->idMer->ListViewValue() ?></div></td>
		<td<?php echo $responsable->fecha->CellAttributes() ?>>
<div<?php echo $responsable->fecha->ViewAttributes() ?>><?php echo $responsable->fecha->ListViewValue() ?></div></td>
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
class cresponsable_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'responsable';

	// Page Object Name
	var $PageObjName = 'responsable_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $responsable;
		if ($responsable->UseTokenInUrl) $PageUrl .= "t=" . $responsable->TableVar . "&"; // add page token
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
		global $objForm, $responsable;
		if ($responsable->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($responsable->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($responsable->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cresponsable_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["responsable"] = new cresponsable();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'responsable', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $responsable;
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
			$this->Page_Terminate("responsablelist.php");
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
		global $responsable;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idResponsable"] <> "") {
			$responsable->idResponsable->setQueryStringValue($_GET["idResponsable"]);
			if (!is_numeric($responsable->idResponsable->QueryStringValue))
				$this->Page_Terminate("responsablelist.php"); // Prevent SQL injection, exit
			$sKey .= $responsable->idResponsable->QueryStringValue;
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
			$this->Page_Terminate("responsablelist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("responsablelist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idResponsable`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in responsable class, responsableinfo.php

		$responsable->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$responsable->CurrentAction = $_POST["a_delete"];
		} else {
			$responsable->CurrentAction = "D"; // Delete record directly
		}
		switch ($responsable->CurrentAction) {
			case "D": // Delete
				$responsable->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($responsable->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $responsable;
		$DeleteRows = TRUE;
		$sWrkFilter = $responsable->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in responsable class, responsableinfo.php

		$responsable->CurrentFilter = $sWrkFilter;
		$sSql = $responsable->SQL();
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
				$DeleteRows = $responsable->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idResponsable'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($responsable->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($responsable->CancelMessage <> "") {
				$this->setMessage($responsable->CancelMessage);
				$responsable->CancelMessage = "";
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
				$responsable->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $responsable;

		// Call Recordset Selecting event
		$responsable->Recordset_Selecting($responsable->CurrentFilter);

		// Load list page SQL
		$sSql = $responsable->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$responsable->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $responsable;
		$sFilter = $responsable->KeyFilter();

		// Call Row Selecting event
		$responsable->Row_Selecting($sFilter);

		// Load sql based on filter
		$responsable->CurrentFilter = $sFilter;
		$sSql = $responsable->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$responsable->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $responsable;
		$responsable->idResponsable->setDbValue($rs->fields('idResponsable'));
		$responsable->idGerente->setDbValue($rs->fields('idGerente'));
		$responsable->idMer->setDbValue($rs->fields('idMer'));
		$responsable->fecha->setDbValue($rs->fields('fecha'));
		$responsable->habilitado->setDbValue($rs->fields('habilitado'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $responsable;

		// Call Row_Rendering event
		$responsable->Row_Rendering();

		// Common render codes for all row types
		// idResponsable

		$responsable->idResponsable->CellCssStyle = "";
		$responsable->idResponsable->CellCssClass = "";

		// idGerente
		$responsable->idGerente->CellCssStyle = "";
		$responsable->idGerente->CellCssClass = "";

		// idMer
		$responsable->idMer->CellCssStyle = "";
		$responsable->idMer->CellCssClass = "";

		// fecha
		$responsable->fecha->CellCssStyle = "";
		$responsable->fecha->CellCssClass = "";
		if ($responsable->RowType == EW_ROWTYPE_VIEW) { // View row

			// idResponsable
			$responsable->idResponsable->ViewValue = $responsable->idResponsable->CurrentValue;
			$responsable->idResponsable->CssStyle = "";
			$responsable->idResponsable->CssClass = "";
			$responsable->idResponsable->ViewCustomAttributes = "";

			// idGerente
			if (strval($responsable->idGerente->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `nombre`, `paterno` FROM `usuario` WHERE `idUsuario` = " . ew_AdjustSql($responsable->idGerente->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `paterno` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$responsable->idGerente->ViewValue = $rswrk->fields('nombre');
					$responsable->idGerente->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('paterno');
					$rswrk->Close();
				} else {
					$responsable->idGerente->ViewValue = $responsable->idGerente->CurrentValue;
				}
			} else {
				$responsable->idGerente->ViewValue = NULL;
			}
			$responsable->idGerente->CssStyle = "";
			$responsable->idGerente->CssClass = "";
			$responsable->idGerente->ViewCustomAttributes = "";

			// idMer
			if (strval($responsable->idMer->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `mer` FROM `mer` WHERE `idMer` = " . ew_AdjustSql($responsable->idMer->CurrentValue) . "";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$responsable->idMer->ViewValue = $rswrk->fields('mer');
					$rswrk->Close();
				} else {
					$responsable->idMer->ViewValue = $responsable->idMer->CurrentValue;
				}
			} else {
				$responsable->idMer->ViewValue = NULL;
			}
			$responsable->idMer->CssStyle = "";
			$responsable->idMer->CssClass = "";
			$responsable->idMer->ViewCustomAttributes = "";

			// fecha
			$responsable->fecha->ViewValue = $responsable->fecha->CurrentValue;
			$responsable->fecha->ViewValue = ew_FormatDateTime($responsable->fecha->ViewValue, 7);
			$responsable->fecha->CssStyle = "";
			$responsable->fecha->CssClass = "";
			$responsable->fecha->ViewCustomAttributes = "";

			// idResponsable
			$responsable->idResponsable->HrefValue = "";

			// idGerente
			$responsable->idGerente->HrefValue = "";

			// idMer
			$responsable->idMer->HrefValue = "";

			// fecha
			$responsable->fecha->HrefValue = "";
		}

		// Call Row Rendered event
		$responsable->Row_Rendered();
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
