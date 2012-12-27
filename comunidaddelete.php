<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "comunidadinfo.php" ?>
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
$comunidad_delete = new ccomunidad_delete();
$Page =& $comunidad_delete;

// Page init processing
$comunidad_delete->Page_Init();

// Page main processing
$comunidad_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var comunidad_delete = new ew_Page("comunidad_delete");

// page properties
comunidad_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = comunidad_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
comunidad_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
comunidad_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
comunidad_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $comunidad_delete->LoadRecordset();
$comunidad_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($comunidad_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$comunidad_delete->Page_Terminate("comunidadlist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Comunidad<br><br>
<a href="<?php echo $comunidad->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $comunidad_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="comunidad">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($comunidad_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $comunidad->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Regional</td>
		<td valign="top">Departamento</td>
		<td valign="top">Municipio</td>
		<td valign="top">Comunidad</td>
	</tr>
	</thead>
	<tbody>
<?php
$comunidad_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$comunidad_delete->lRecCnt++;

	// Set row properties
	$comunidad->CssClass = "";
	$comunidad->CssStyle = "";
	$comunidad->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$comunidad_delete->LoadRowValues($rs);

	// Render row
	$comunidad_delete->RenderRow();
?>
	<tr<?php echo $comunidad->RowAttributes() ?>>
		<td<?php echo $comunidad->idComunidad->CellAttributes() ?>>
<div<?php echo $comunidad->idComunidad->ViewAttributes() ?>><?php echo $comunidad->idComunidad->ListViewValue() ?></div></td>
		<td<?php echo $comunidad->idRegional->CellAttributes() ?>>
<div<?php echo $comunidad->idRegional->ViewAttributes() ?>><?php echo $comunidad->idRegional->ListViewValue() ?></div></td>
		<td<?php echo $comunidad->idDepartamento->CellAttributes() ?>>
<div<?php echo $comunidad->idDepartamento->ViewAttributes() ?>><?php echo $comunidad->idDepartamento->ListViewValue() ?></div></td>
		<td<?php echo $comunidad->idMunicipio->CellAttributes() ?>>
<div<?php echo $comunidad->idMunicipio->ViewAttributes() ?>><?php echo $comunidad->idMunicipio->ListViewValue() ?></div></td>
		<td<?php echo $comunidad->comunidad->CellAttributes() ?>>
<div<?php echo $comunidad->comunidad->ViewAttributes() ?>><?php echo $comunidad->comunidad->ListViewValue() ?></div></td>
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
class ccomunidad_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'comunidad';

	// Page Object Name
	var $PageObjName = 'comunidad_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $comunidad;
		if ($comunidad->UseTokenInUrl) $PageUrl .= "t=" . $comunidad->TableVar . "&"; // add page token
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
		global $objForm, $comunidad;
		if ($comunidad->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($comunidad->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($comunidad->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccomunidad_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["comunidad"] = new ccomunidad();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'comunidad', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $comunidad;
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
			$this->Page_Terminate("comunidadlist.php");
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
		global $comunidad;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idComunidad"] <> "") {
			$comunidad->idComunidad->setQueryStringValue($_GET["idComunidad"]);
			if (!is_numeric($comunidad->idComunidad->QueryStringValue))
				$this->Page_Terminate("comunidadlist.php"); // Prevent SQL injection, exit
			$sKey .= $comunidad->idComunidad->QueryStringValue;
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
			$this->Page_Terminate("comunidadlist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("comunidadlist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idComunidad`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in comunidad class, comunidadinfo.php

		$comunidad->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$comunidad->CurrentAction = $_POST["a_delete"];
		} else {
			$comunidad->CurrentAction = "D"; // Delete record directly
		}
		switch ($comunidad->CurrentAction) {
			case "D": // Delete
				$comunidad->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($comunidad->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $comunidad;
		$DeleteRows = TRUE;
		$sWrkFilter = $comunidad->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in comunidad class, comunidadinfo.php

		$comunidad->CurrentFilter = $sWrkFilter;
		$sSql = $comunidad->SQL();
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
				$DeleteRows = $comunidad->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idComunidad'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($comunidad->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($comunidad->CancelMessage <> "") {
				$this->setMessage($comunidad->CancelMessage);
				$comunidad->CancelMessage = "";
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
				$comunidad->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $comunidad;

		// Call Recordset Selecting event
		$comunidad->Recordset_Selecting($comunidad->CurrentFilter);

		// Load list page SQL
		$sSql = $comunidad->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$comunidad->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $comunidad;
		$sFilter = $comunidad->KeyFilter();

		// Call Row Selecting event
		$comunidad->Row_Selecting($sFilter);

		// Load sql based on filter
		$comunidad->CurrentFilter = $sFilter;
		$sSql = $comunidad->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$comunidad->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $comunidad;
		$comunidad->idComunidad->setDbValue($rs->fields('idComunidad'));
		$comunidad->idRegional->setDbValue($rs->fields('idRegional'));
		$comunidad->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$comunidad->idMunicipio->setDbValue($rs->fields('idMunicipio'));
		$comunidad->comunidad->setDbValue($rs->fields('comunidad'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $comunidad;

		// Call Row_Rendering event
		$comunidad->Row_Rendering();

		// Common render codes for all row types
		// idComunidad

		$comunidad->idComunidad->CellCssStyle = "";
		$comunidad->idComunidad->CellCssClass = "";

		// idRegional
		$comunidad->idRegional->CellCssStyle = "";
		$comunidad->idRegional->CellCssClass = "";

		// idDepartamento
		$comunidad->idDepartamento->CellCssStyle = "";
		$comunidad->idDepartamento->CellCssClass = "";

		// idMunicipio
		$comunidad->idMunicipio->CellCssStyle = "";
		$comunidad->idMunicipio->CellCssClass = "";

		// comunidad
		$comunidad->comunidad->CellCssStyle = "";
		$comunidad->comunidad->CellCssClass = "";
		if ($comunidad->RowType == EW_ROWTYPE_VIEW) { // View row

			// idComunidad
			$comunidad->idComunidad->ViewValue = $comunidad->idComunidad->CurrentValue;
			$comunidad->idComunidad->CssStyle = "";
			$comunidad->idComunidad->CssClass = "";
			$comunidad->idComunidad->ViewCustomAttributes = "";

			// idRegional
			if (strval($comunidad->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($comunidad->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$comunidad->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$comunidad->idRegional->ViewValue = $comunidad->idRegional->CurrentValue;
				}
			} else {
				$comunidad->idRegional->ViewValue = NULL;
			}
			$comunidad->idRegional->CssStyle = "";
			$comunidad->idRegional->CssClass = "";
			$comunidad->idRegional->ViewCustomAttributes = "";

			// idDepartamento
			if (strval($comunidad->idDepartamento->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `departamento` FROM `departamento` WHERE `idDepartamento` = " . ew_AdjustSql($comunidad->idDepartamento->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `departamento` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$comunidad->idDepartamento->ViewValue = $rswrk->fields('departamento');
					$rswrk->Close();
				} else {
					$comunidad->idDepartamento->ViewValue = $comunidad->idDepartamento->CurrentValue;
				}
			} else {
				$comunidad->idDepartamento->ViewValue = NULL;
			}
			$comunidad->idDepartamento->CssStyle = "";
			$comunidad->idDepartamento->CssClass = "";
			$comunidad->idDepartamento->ViewCustomAttributes = "";

			// idMunicipio
			if (strval($comunidad->idMunicipio->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `municipio` FROM `municipio` WHERE `idMunicipio` = " . ew_AdjustSql($comunidad->idMunicipio->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `municipio` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$comunidad->idMunicipio->ViewValue = $rswrk->fields('municipio');
					$rswrk->Close();
				} else {
					$comunidad->idMunicipio->ViewValue = $comunidad->idMunicipio->CurrentValue;
				}
			} else {
				$comunidad->idMunicipio->ViewValue = NULL;
			}
			$comunidad->idMunicipio->CssStyle = "";
			$comunidad->idMunicipio->CssClass = "";
			$comunidad->idMunicipio->ViewCustomAttributes = "";

			// comunidad
			$comunidad->comunidad->ViewValue = $comunidad->comunidad->CurrentValue;
			$comunidad->comunidad->CssStyle = "";
			$comunidad->comunidad->CssClass = "";
			$comunidad->comunidad->ViewCustomAttributes = "";

			// idComunidad
			$comunidad->idComunidad->HrefValue = "";

			// idRegional
			$comunidad->idRegional->HrefValue = "";

			// idDepartamento
			$comunidad->idDepartamento->HrefValue = "";

			// idMunicipio
			$comunidad->idMunicipio->HrefValue = "";

			// comunidad
			$comunidad->comunidad->HrefValue = "";
		}

		// Call Row Rendered event
		$comunidad->Row_Rendered();
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
