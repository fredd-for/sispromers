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
$regional_view = new cregional_view();
$Page =& $regional_view;

// Page init processing
$regional_view->Page_Init();

// Page main processing
$regional_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($regional->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var regional_view = new ew_Page("regional_view");

// page properties
regional_view.PageID = "view"; // page ID
var EW_PAGE_ID = regional_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
regional_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
regional_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
regional_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Regional
<br><br>
<?php if ($regional->Export == "") { ?>
<a href="regionallist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $regional->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $regional->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $regional->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $regional_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($regional->idRegional->Visible) { // idRegional ?>
	<tr<?php echo $regional->idRegional->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $regional->idRegional->CellAttributes() ?>>
<div<?php echo $regional->idRegional->ViewAttributes() ?>><?php echo $regional->idRegional->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($regional->regional->Visible) { // regional ?>
	<tr<?php echo $regional->regional->RowAttributes ?>>
		<td class="ewTableHeader">Regional</td>
		<td<?php echo $regional->regional->CellAttributes() ?>>
<div<?php echo $regional->regional->ViewAttributes() ?>><?php echo $regional->regional->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($regional->Export == "") { ?>
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
class cregional_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'regional';

	// Page Object Name
	var $PageObjName = 'regional_view';

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
	function cregional_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["regional"] = new cregional();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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
		if (!$Security->CanView()) {
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
		global $regional;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idRegional"] <> "") {
				$regional->idRegional->setQueryStringValue($_GET["idRegional"]);
			} else {
				$sReturnUrl = "regionallist.php"; // Return to list
			}

			// Get action
			$regional->CurrentAction = "I"; // Display form
			switch ($regional->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "regionallist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "regionallist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$regional->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $regional;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$regional->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$regional->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $regional->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$regional->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$regional->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$regional->setStartRecordNumber($this->lStartRec);
		}
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
