<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "departamentoinfo.php" ?>
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
$departamento_delete = new cdepartamento_delete();
$Page =& $departamento_delete;

// Page init processing
$departamento_delete->Page_Init();

// Page main processing
$departamento_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var departamento_delete = new ew_Page("departamento_delete");

// page properties
departamento_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = departamento_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
departamento_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
departamento_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
departamento_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $departamento_delete->LoadRecordset();
$departamento_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($departamento_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$departamento_delete->Page_Terminate("departamentolist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Departamento<br><br>
<a href="<?php echo $departamento->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $departamento_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="departamento">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($departamento_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $departamento->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Regional</td>
		<td valign="top">Departamento</td>
	</tr>
	</thead>
	<tbody>
<?php
$departamento_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$departamento_delete->lRecCnt++;

	// Set row properties
	$departamento->CssClass = "";
	$departamento->CssStyle = "";
	$departamento->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$departamento_delete->LoadRowValues($rs);

	// Render row
	$departamento_delete->RenderRow();
?>
	<tr<?php echo $departamento->RowAttributes() ?>>
		<td<?php echo $departamento->idDepartamento->CellAttributes() ?>>
<div<?php echo $departamento->idDepartamento->ViewAttributes() ?>><?php echo $departamento->idDepartamento->ListViewValue() ?></div></td>
		<td<?php echo $departamento->idRegional->CellAttributes() ?>>
<div<?php echo $departamento->idRegional->ViewAttributes() ?>><?php echo $departamento->idRegional->ListViewValue() ?></div></td>
		<td<?php echo $departamento->departamento->CellAttributes() ?>>
<div<?php echo $departamento->departamento->ViewAttributes() ?>><?php echo $departamento->departamento->ListViewValue() ?></div></td>
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
class cdepartamento_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'departamento';

	// Page Object Name
	var $PageObjName = 'departamento_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $departamento;
		if ($departamento->UseTokenInUrl) $PageUrl .= "t=" . $departamento->TableVar . "&"; // add page token
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
		global $objForm, $departamento;
		if ($departamento->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($departamento->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($departamento->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cdepartamento_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["departamento"] = new cdepartamento();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'departamento', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $departamento;
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
			$this->Page_Terminate("departamentolist.php");
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
		global $departamento;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idDepartamento"] <> "") {
			$departamento->idDepartamento->setQueryStringValue($_GET["idDepartamento"]);
			if (!is_numeric($departamento->idDepartamento->QueryStringValue))
				$this->Page_Terminate("departamentolist.php"); // Prevent SQL injection, exit
			$sKey .= $departamento->idDepartamento->QueryStringValue;
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
			$this->Page_Terminate("departamentolist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("departamentolist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idDepartamento`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in departamento class, departamentoinfo.php

		$departamento->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$departamento->CurrentAction = $_POST["a_delete"];
		} else {
			$departamento->CurrentAction = "D"; // Delete record directly
		}
		switch ($departamento->CurrentAction) {
			case "D": // Delete
				$departamento->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($departamento->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $departamento;
		$DeleteRows = TRUE;
		$sWrkFilter = $departamento->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in departamento class, departamentoinfo.php

		$departamento->CurrentFilter = $sWrkFilter;
		$sSql = $departamento->SQL();
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
				$DeleteRows = $departamento->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idDepartamento'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($departamento->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($departamento->CancelMessage <> "") {
				$this->setMessage($departamento->CancelMessage);
				$departamento->CancelMessage = "";
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
				$departamento->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $departamento;

		// Call Recordset Selecting event
		$departamento->Recordset_Selecting($departamento->CurrentFilter);

		// Load list page SQL
		$sSql = $departamento->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$departamento->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $departamento;
		$sFilter = $departamento->KeyFilter();

		// Call Row Selecting event
		$departamento->Row_Selecting($sFilter);

		// Load sql based on filter
		$departamento->CurrentFilter = $sFilter;
		$sSql = $departamento->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$departamento->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $departamento;
		$departamento->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$departamento->idRegional->setDbValue($rs->fields('idRegional'));
		$departamento->departamento->setDbValue($rs->fields('departamento'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $departamento;

		// Call Row_Rendering event
		$departamento->Row_Rendering();

		// Common render codes for all row types
		// idDepartamento

		$departamento->idDepartamento->CellCssStyle = "";
		$departamento->idDepartamento->CellCssClass = "";

		// idRegional
		$departamento->idRegional->CellCssStyle = "";
		$departamento->idRegional->CellCssClass = "";

		// departamento
		$departamento->departamento->CellCssStyle = "";
		$departamento->departamento->CellCssClass = "";
		if ($departamento->RowType == EW_ROWTYPE_VIEW) { // View row

			// idDepartamento
			$departamento->idDepartamento->ViewValue = $departamento->idDepartamento->CurrentValue;
			$departamento->idDepartamento->CssStyle = "";
			$departamento->idDepartamento->CssClass = "";
			$departamento->idDepartamento->ViewCustomAttributes = "";

			// idRegional
			if (strval($departamento->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($departamento->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$departamento->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$departamento->idRegional->ViewValue = $departamento->idRegional->CurrentValue;
				}
			} else {
				$departamento->idRegional->ViewValue = NULL;
			}
			$departamento->idRegional->CssStyle = "";
			$departamento->idRegional->CssClass = "";
			$departamento->idRegional->ViewCustomAttributes = "";

			// departamento
			$departamento->departamento->ViewValue = $departamento->departamento->CurrentValue;
			$departamento->departamento->CssStyle = "";
			$departamento->departamento->CssClass = "";
			$departamento->departamento->ViewCustomAttributes = "";

			// idDepartamento
			$departamento->idDepartamento->HrefValue = "";

			// idRegional
			$departamento->idRegional->HrefValue = "";

			// departamento
			$departamento->departamento->HrefValue = "";
		}

		// Call Row Rendered event
		$departamento->Row_Rendered();
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
