<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "municipioinfo.php" ?>
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
$municipio_delete = new cmunicipio_delete();
$Page =& $municipio_delete;

// Page init processing
$municipio_delete->Page_Init();

// Page main processing
$municipio_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var municipio_delete = new ew_Page("municipio_delete");

// page properties
municipio_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = municipio_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
municipio_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
municipio_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
municipio_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $municipio_delete->LoadRecordset();
$municipio_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($municipio_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$municipio_delete->Page_Terminate("municipiolist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Municipio<br><br>
<a href="<?php echo $municipio->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $municipio_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="municipio">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($municipio_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $municipio->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Regional</td>
		<td valign="top">Departamento</td>
		<td valign="top">Municipio</td>
	</tr>
	</thead>
	<tbody>
<?php
$municipio_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$municipio_delete->lRecCnt++;

	// Set row properties
	$municipio->CssClass = "";
	$municipio->CssStyle = "";
	$municipio->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$municipio_delete->LoadRowValues($rs);

	// Render row
	$municipio_delete->RenderRow();
?>
	<tr<?php echo $municipio->RowAttributes() ?>>
		<td<?php echo $municipio->idMunicipio->CellAttributes() ?>>
<div<?php echo $municipio->idMunicipio->ViewAttributes() ?>><?php echo $municipio->idMunicipio->ListViewValue() ?></div></td>
		<td<?php echo $municipio->idRegional->CellAttributes() ?>>
<div<?php echo $municipio->idRegional->ViewAttributes() ?>><?php echo $municipio->idRegional->ListViewValue() ?></div></td>
		<td<?php echo $municipio->idDepartamento->CellAttributes() ?>>
<div<?php echo $municipio->idDepartamento->ViewAttributes() ?>><?php echo $municipio->idDepartamento->ListViewValue() ?></div></td>
		<td<?php echo $municipio->municipio->CellAttributes() ?>>
<div<?php echo $municipio->municipio->ViewAttributes() ?>><?php echo $municipio->municipio->ListViewValue() ?></div></td>
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
class cmunicipio_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'municipio';

	// Page Object Name
	var $PageObjName = 'municipio_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $municipio;
		if ($municipio->UseTokenInUrl) $PageUrl .= "t=" . $municipio->TableVar . "&"; // add page token
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
		global $objForm, $municipio;
		if ($municipio->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($municipio->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($municipio->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cmunicipio_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["municipio"] = new cmunicipio();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'municipio', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $municipio;
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
			$this->Page_Terminate("municipiolist.php");
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
		global $municipio;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idMunicipio"] <> "") {
			$municipio->idMunicipio->setQueryStringValue($_GET["idMunicipio"]);
			if (!is_numeric($municipio->idMunicipio->QueryStringValue))
				$this->Page_Terminate("municipiolist.php"); // Prevent SQL injection, exit
			$sKey .= $municipio->idMunicipio->QueryStringValue;
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
			$this->Page_Terminate("municipiolist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("municipiolist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idMunicipio`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in municipio class, municipioinfo.php

		$municipio->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$municipio->CurrentAction = $_POST["a_delete"];
		} else {
			$municipio->CurrentAction = "D"; // Delete record directly
		}
		switch ($municipio->CurrentAction) {
			case "D": // Delete
				$municipio->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($municipio->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $municipio;
		$DeleteRows = TRUE;
		$sWrkFilter = $municipio->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in municipio class, municipioinfo.php

		$municipio->CurrentFilter = $sWrkFilter;
		$sSql = $municipio->SQL();
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
				$DeleteRows = $municipio->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idMunicipio'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($municipio->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($municipio->CancelMessage <> "") {
				$this->setMessage($municipio->CancelMessage);
				$municipio->CancelMessage = "";
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
				$municipio->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $municipio;

		// Call Recordset Selecting event
		$municipio->Recordset_Selecting($municipio->CurrentFilter);

		// Load list page SQL
		$sSql = $municipio->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$municipio->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $municipio;
		$sFilter = $municipio->KeyFilter();

		// Call Row Selecting event
		$municipio->Row_Selecting($sFilter);

		// Load sql based on filter
		$municipio->CurrentFilter = $sFilter;
		$sSql = $municipio->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$municipio->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $municipio;
		$municipio->idMunicipio->setDbValue($rs->fields('idMunicipio'));
		$municipio->idRegional->setDbValue($rs->fields('idRegional'));
		$municipio->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$municipio->municipio->setDbValue($rs->fields('municipio'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $municipio;

		// Call Row_Rendering event
		$municipio->Row_Rendering();

		// Common render codes for all row types
		// idMunicipio

		$municipio->idMunicipio->CellCssStyle = "";
		$municipio->idMunicipio->CellCssClass = "";

		// idRegional
		$municipio->idRegional->CellCssStyle = "";
		$municipio->idRegional->CellCssClass = "";

		// idDepartamento
		$municipio->idDepartamento->CellCssStyle = "";
		$municipio->idDepartamento->CellCssClass = "";

		// municipio
		$municipio->municipio->CellCssStyle = "";
		$municipio->municipio->CellCssClass = "";
		if ($municipio->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMunicipio
			$municipio->idMunicipio->ViewValue = $municipio->idMunicipio->CurrentValue;
			$municipio->idMunicipio->CssStyle = "";
			$municipio->idMunicipio->CssClass = "";
			$municipio->idMunicipio->ViewCustomAttributes = "";

			// idRegional
			if (strval($municipio->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($municipio->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$municipio->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$municipio->idRegional->ViewValue = $municipio->idRegional->CurrentValue;
				}
			} else {
				$municipio->idRegional->ViewValue = NULL;
			}
			$municipio->idRegional->CssStyle = "";
			$municipio->idRegional->CssClass = "";
			$municipio->idRegional->ViewCustomAttributes = "";

			// idDepartamento
			if (strval($municipio->idDepartamento->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `departamento` FROM `departamento` WHERE `idDepartamento` = " . ew_AdjustSql($municipio->idDepartamento->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `departamento` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$municipio->idDepartamento->ViewValue = $rswrk->fields('departamento');
					$rswrk->Close();
				} else {
					$municipio->idDepartamento->ViewValue = $municipio->idDepartamento->CurrentValue;
				}
			} else {
				$municipio->idDepartamento->ViewValue = NULL;
			}
			$municipio->idDepartamento->CssStyle = "";
			$municipio->idDepartamento->CssClass = "";
			$municipio->idDepartamento->ViewCustomAttributes = "";

			// municipio
			$municipio->municipio->ViewValue = $municipio->municipio->CurrentValue;
			$municipio->municipio->CssStyle = "";
			$municipio->municipio->CssClass = "";
			$municipio->municipio->ViewCustomAttributes = "";

			// idMunicipio
			$municipio->idMunicipio->HrefValue = "";

			// idRegional
			$municipio->idRegional->HrefValue = "";

			// idDepartamento
			$municipio->idDepartamento->HrefValue = "";

			// municipio
			$municipio->municipio->HrefValue = "";
		}

		// Call Row Rendered event
		$municipio->Row_Rendered();
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
