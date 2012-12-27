<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "rubroinfo.php" ?>
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
$rubro_delete = new crubro_delete();
$Page =& $rubro_delete;

// Page init processing
$rubro_delete->Page_Init();

// Page main processing
$rubro_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var rubro_delete = new ew_Page("rubro_delete");

// page properties
rubro_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = rubro_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
rubro_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
rubro_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
rubro_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $rubro_delete->LoadRecordset();
$rubro_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($rubro_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$rubro_delete->Page_Terminate("rubrolist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Rubro<br><br>
<a href="<?php echo $rubro->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $rubro_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="rubro">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($rubro_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $rubro->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Rubro</td>
		<td valign="top">No Mers Gestion 2009</td>
		<td valign="top">No Mers Gestion 2010</td>
		<td valign="top">No Mers Gestion 2011</td>
		<td valign="top">No Mers Gestion 2012</td>
	</tr>
	</thead>
	<tbody>
<?php
$rubro_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$rubro_delete->lRecCnt++;

	// Set row properties
	$rubro->CssClass = "";
	$rubro->CssStyle = "";
	$rubro->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$rubro_delete->LoadRowValues($rs);

	// Render row
	$rubro_delete->RenderRow();
?>
	<tr<?php echo $rubro->RowAttributes() ?>>
		<td<?php echo $rubro->idRubro->CellAttributes() ?>>
<div<?php echo $rubro->idRubro->ViewAttributes() ?>><?php echo $rubro->idRubro->ListViewValue() ?></div></td>
		<td<?php echo $rubro->rubro->CellAttributes() ?>>
<div<?php echo $rubro->rubro->ViewAttributes() ?>><?php echo $rubro->rubro->ListViewValue() ?></div></td>
		<td<?php echo $rubro->gestion2009->CellAttributes() ?>>
<div<?php echo $rubro->gestion2009->ViewAttributes() ?>><?php echo $rubro->gestion2009->ListViewValue() ?></div></td>
		<td<?php echo $rubro->gestion2010->CellAttributes() ?>>
<div<?php echo $rubro->gestion2010->ViewAttributes() ?>><?php echo $rubro->gestion2010->ListViewValue() ?></div></td>
		<td<?php echo $rubro->gestion2011->CellAttributes() ?>>
<div<?php echo $rubro->gestion2011->ViewAttributes() ?>><?php echo $rubro->gestion2011->ListViewValue() ?></div></td>
		<td<?php echo $rubro->gestion2012->CellAttributes() ?>>
<div<?php echo $rubro->gestion2012->ViewAttributes() ?>><?php echo $rubro->gestion2012->ListViewValue() ?></div></td>
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
class crubro_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'rubro';

	// Page Object Name
	var $PageObjName = 'rubro_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $rubro;
		if ($rubro->UseTokenInUrl) $PageUrl .= "t=" . $rubro->TableVar . "&"; // add page token
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
		global $objForm, $rubro;
		if ($rubro->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($rubro->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($rubro->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function crubro_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["rubro"] = new crubro();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rubro', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $rubro;
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
			$this->Page_Terminate("rubrolist.php");
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
		global $rubro;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idRubro"] <> "") {
			$rubro->idRubro->setQueryStringValue($_GET["idRubro"]);
			if (!is_numeric($rubro->idRubro->QueryStringValue))
				$this->Page_Terminate("rubrolist.php"); // Prevent SQL injection, exit
			$sKey .= $rubro->idRubro->QueryStringValue;
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
			$this->Page_Terminate("rubrolist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("rubrolist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idRubro`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in rubro class, rubroinfo.php

		$rubro->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$rubro->CurrentAction = $_POST["a_delete"];
		} else {
			$rubro->CurrentAction = "D"; // Delete record directly
		}
		switch ($rubro->CurrentAction) {
			case "D": // Delete
				$rubro->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($rubro->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $rubro;
		$DeleteRows = TRUE;
		$sWrkFilter = $rubro->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in rubro class, rubroinfo.php

		$rubro->CurrentFilter = $sWrkFilter;
		$sSql = $rubro->SQL();
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
				$DeleteRows = $rubro->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idRubro'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($rubro->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($rubro->CancelMessage <> "") {
				$this->setMessage($rubro->CancelMessage);
				$rubro->CancelMessage = "";
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
				$rubro->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $rubro;

		// Call Recordset Selecting event
		$rubro->Recordset_Selecting($rubro->CurrentFilter);

		// Load list page SQL
		$sSql = $rubro->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$rubro->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $rubro;
		$sFilter = $rubro->KeyFilter();

		// Call Row Selecting event
		$rubro->Row_Selecting($sFilter);

		// Load sql based on filter
		$rubro->CurrentFilter = $sFilter;
		$sSql = $rubro->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$rubro->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $rubro;
		$rubro->idRubro->setDbValue($rs->fields('idRubro'));
		$rubro->rubro->setDbValue($rs->fields('rubro'));
		$rubro->detalle->setDbValue($rs->fields('detalle'));
		$rubro->gestion2009->setDbValue($rs->fields('gestion2009'));
		$rubro->gestion2010->setDbValue($rs->fields('gestion2010'));
		$rubro->gestion2011->setDbValue($rs->fields('gestion2011'));
		$rubro->gestion2012->setDbValue($rs->fields('gestion2012'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $rubro;

		// Call Row_Rendering event
		$rubro->Row_Rendering();

		// Common render codes for all row types
		// idRubro

		$rubro->idRubro->CellCssStyle = "";
		$rubro->idRubro->CellCssClass = "";

		// rubro
		$rubro->rubro->CellCssStyle = "";
		$rubro->rubro->CellCssClass = "";

		// gestion2009
		$rubro->gestion2009->CellCssStyle = "";
		$rubro->gestion2009->CellCssClass = "";

		// gestion2010
		$rubro->gestion2010->CellCssStyle = "";
		$rubro->gestion2010->CellCssClass = "";

		// gestion2011
		$rubro->gestion2011->CellCssStyle = "";
		$rubro->gestion2011->CellCssClass = "";

		// gestion2012
		$rubro->gestion2012->CellCssStyle = "";
		$rubro->gestion2012->CellCssClass = "";
		if ($rubro->RowType == EW_ROWTYPE_VIEW) { // View row

			// idRubro
			$rubro->idRubro->ViewValue = $rubro->idRubro->CurrentValue;
			$rubro->idRubro->CssStyle = "";
			$rubro->idRubro->CssClass = "";
			$rubro->idRubro->ViewCustomAttributes = "";

			// rubro
			$rubro->rubro->ViewValue = $rubro->rubro->CurrentValue;
			$rubro->rubro->CssStyle = "";
			$rubro->rubro->CssClass = "";
			$rubro->rubro->ViewCustomAttributes = "";

			// gestion2009
			$rubro->gestion2009->ViewValue = $rubro->gestion2009->CurrentValue;
			$rubro->gestion2009->CssStyle = "";
			$rubro->gestion2009->CssClass = "";
			$rubro->gestion2009->ViewCustomAttributes = "";

			// gestion2010
			$rubro->gestion2010->ViewValue = $rubro->gestion2010->CurrentValue;
			$rubro->gestion2010->CssStyle = "";
			$rubro->gestion2010->CssClass = "";
			$rubro->gestion2010->ViewCustomAttributes = "";

			// gestion2011
			$rubro->gestion2011->ViewValue = $rubro->gestion2011->CurrentValue;
			$rubro->gestion2011->CssStyle = "";
			$rubro->gestion2011->CssClass = "";
			$rubro->gestion2011->ViewCustomAttributes = "";

			// gestion2012
			$rubro->gestion2012->ViewValue = $rubro->gestion2012->CurrentValue;
			$rubro->gestion2012->CssStyle = "";
			$rubro->gestion2012->CssClass = "";
			$rubro->gestion2012->ViewCustomAttributes = "";

			// idRubro
			$rubro->idRubro->HrefValue = "";

			// rubro
			$rubro->rubro->HrefValue = "";

			// gestion2009
			$rubro->gestion2009->HrefValue = "";

			// gestion2010
			$rubro->gestion2010->HrefValue = "";

			// gestion2011
			$rubro->gestion2011->HrefValue = "";

			// gestion2012
			$rubro->gestion2012->HrefValue = "";
		}

		// Call Row Rendered event
		$rubro->Row_Rendered();
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
