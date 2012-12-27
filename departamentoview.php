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
$departamento_view = new cdepartamento_view();
$Page =& $departamento_view;

// Page init processing
$departamento_view->Page_Init();

// Page main processing
$departamento_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($departamento->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var departamento_view = new ew_Page("departamento_view");

// page properties
departamento_view.PageID = "view"; // page ID
var EW_PAGE_ID = departamento_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
departamento_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
departamento_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
departamento_view.ValidateRequired = false; // no JavaScript validation
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
<?php } ?>
<p><span class="phpmaker">Ver TABLA: Departamento
<br><br>
<?php if ($departamento->Export == "") { ?>
<a href="departamentolist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $departamento->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $departamento->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $departamento->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $departamento_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($departamento->idDepartamento->Visible) { // idDepartamento ?>
	<tr<?php echo $departamento->idDepartamento->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $departamento->idDepartamento->CellAttributes() ?>>
<div<?php echo $departamento->idDepartamento->ViewAttributes() ?>><?php echo $departamento->idDepartamento->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($departamento->idRegional->Visible) { // idRegional ?>
	<tr<?php echo $departamento->idRegional->RowAttributes ?>>
		<td class="ewTableHeader">Regional</td>
		<td<?php echo $departamento->idRegional->CellAttributes() ?>>
<div<?php echo $departamento->idRegional->ViewAttributes() ?>><?php echo $departamento->idRegional->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($departamento->departamento->Visible) { // departamento ?>
	<tr<?php echo $departamento->departamento->RowAttributes ?>>
		<td class="ewTableHeader">Departamento</td>
		<td<?php echo $departamento->departamento->CellAttributes() ?>>
<div<?php echo $departamento->departamento->ViewAttributes() ?>><?php echo $departamento->departamento->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($departamento->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cdepartamento_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'departamento';

	// Page Object Name
	var $PageObjName = 'departamento_view';

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
	function cdepartamento_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["departamento"] = new cdepartamento();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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
		if (!$Security->CanView()) {
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
	var $lDisplayRecs; // Number of display records
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs;
	var $lRecRange;
	var $lRecCnt;

	//
	// Page main processing
	//
	function Page_Main() {
		global $departamento;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idDepartamento"] <> "") {
				$departamento->idDepartamento->setQueryStringValue($_GET["idDepartamento"]);
			} else {
				$sReturnUrl = "departamentolist.php"; // Return to list
			}

			// Get action
			$departamento->CurrentAction = "I"; // Display form
			switch ($departamento->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "departamentolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "departamentolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$departamento->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $departamento;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$departamento->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$departamento->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $departamento->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$departamento->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$departamento->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$departamento->setStartRecordNumber($this->lStartRec);
		}
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
