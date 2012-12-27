<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "regionalinfo.php" ?>
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
$regional_delete = new cregional_delete();
$Page =& $regional_delete;

// Page init processing
$regional_delete->Page_Init();

// Page main processing
$regional_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var regional_delete = new ew_Page("regional_delete");

// page properties
regional_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = regional_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
regional_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
regional_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
regional_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $regional_delete->LoadRecordset();
$regional_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($regional_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$regional_delete->Page_Terminate("regionallist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Regional<br><br>
<a href="<?php echo $regional->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $regional_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="regional">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($regional_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $regional->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Regional</td>
	</tr>
	</thead>
	<tbody>
<?php
$regional_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$regional_delete->lRecCnt++;

	// Set row properties
	$regional->CssClass = "";
	$regional->CssStyle = "";
	$regional->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$regional_delete->LoadRowValues($rs);

	// Render row
	$regional_delete->RenderRow();
?>
	<tr<?php echo $regional->RowAttributes() ?>>
		<td<?php echo $regional->idRegional->CellAttributes() ?>>
<div<?php echo $regional->idRegional->ViewAttributes() ?>><?php echo $regional->idRegional->ListViewValue() ?></div></td>
		<td<?php echo $regional->regional->CellAttributes() ?>>
<div<?php echo $regional->regional->ViewAttributes() ?>><?php echo $regional->regional->ListViewValue() ?></div></td>
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
class cregional_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'regional';

	// Page Object Name
	var $PageObjName = 'regional_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $regional;
		if ($regional->UseTokenInUrl) $PageUrl .= "t=" . $regional->TableVar . "&"; // add page token
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
		global $objForm, $regional;
		if ($regional->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($regional->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($regional->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cregional_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["regional"] = new cregional();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'regional', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $regional;
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
			$this->Page_Terminate("regionallist.php");
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
		global $regional;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idRegional"] <> "") {
			$regional->idRegional->setQueryStringValue($_GET["idRegional"]);
			if (!is_numeric($regional->idRegional->QueryStringValue))
				$this->Page_Terminate("regionallist.php"); // Prevent SQL injection, exit
			$sKey .= $regional->idRegional->QueryStringValue;
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
			$this->Page_Terminate("regionallist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("regionallist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idRegional`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in regional class, regionalinfo.php

		$regional->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$regional->CurrentAction = $_POST["a_delete"];
		} else {
			$regional->CurrentAction = "D"; // Delete record directly
		}
		switch ($regional->CurrentAction) {
			case "D": // Delete
				$regional->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($regional->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $regional;
		$DeleteRows = TRUE;
		$sWrkFilter = $regional->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in regional class, regionalinfo.php

		$regional->CurrentFilter = $sWrkFilter;
		$sSql = $regional->SQL();
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
				$DeleteRows = $regional->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idRegional'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($regional->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($regional->CancelMessage <> "") {
				$this->setMessage($regional->CancelMessage);
				$regional->CancelMessage = "";
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
				$regional->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $regional;

		// Call Recordset Selecting event
		$regional->Recordset_Selecting($regional->CurrentFilter);

		// Load list page SQL
		$sSql = $regional->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$regional->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $regional;
		$sFilter = $regional->KeyFilter();

		// Call Row Selecting event
		$regional->Row_Selecting($sFilter);

		// Load sql based on filter
		$regional->CurrentFilter = $sFilter;
		$sSql = $regional->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$regional->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $regional;
		$regional->idRegional->setDbValue($rs->fields('idRegional'));
		$regional->regional->setDbValue($rs->fields('regional'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $regional;

		// Call Row_Rendering event
		$regional->Row_Rendering();

		// Common render codes for all row types
		// idRegional

		$regional->idRegional->CellCssStyle = "";
		$regional->idRegional->CellCssClass = "";

		// regional
		$regional->regional->CellCssStyle = "";
		$regional->regional->CellCssClass = "";
		if ($regional->RowType == EW_ROWTYPE_VIEW) { // View row

			// idRegional
			$regional->idRegional->ViewValue = $regional->idRegional->CurrentValue;
			$regional->idRegional->CssStyle = "";
			$regional->idRegional->CssClass = "";
			$regional->idRegional->ViewCustomAttributes = "";

			// regional
			$regional->regional->ViewValue = $regional->regional->CurrentValue;
			$regional->regional->CssStyle = "";
			$regional->regional->CssClass = "";
			$regional->regional->ViewCustomAttributes = "";

			// idRegional
			$regional->idRegional->HrefValue = "";

			// regional
			$regional->regional->HrefValue = "";
		}

		// Call Row Rendered event
		$regional->Row_Rendered();
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
