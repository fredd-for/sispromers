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
$municipio_view = new cmunicipio_view();
$Page =& $municipio_view;

// Page init processing
$municipio_view->Page_Init();

// Page main processing
$municipio_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($municipio->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var municipio_view = new ew_Page("municipio_view");

// page properties
municipio_view.PageID = "view"; // page ID
var EW_PAGE_ID = municipio_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
municipio_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
municipio_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
municipio_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Municipio
<br><br>
<?php if ($municipio->Export == "") { ?>
<a href="municipiolist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $municipio->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $municipio->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $municipio->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $municipio_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($municipio->idMunicipio->Visible) { // idMunicipio ?>
	<tr<?php echo $municipio->idMunicipio->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $municipio->idMunicipio->CellAttributes() ?>>
<div<?php echo $municipio->idMunicipio->ViewAttributes() ?>><?php echo $municipio->idMunicipio->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($municipio->idRegional->Visible) { // idRegional ?>
	<tr<?php echo $municipio->idRegional->RowAttributes ?>>
		<td class="ewTableHeader">Regional</td>
		<td<?php echo $municipio->idRegional->CellAttributes() ?>>
<div<?php echo $municipio->idRegional->ViewAttributes() ?>><?php echo $municipio->idRegional->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($municipio->idDepartamento->Visible) { // idDepartamento ?>
	<tr<?php echo $municipio->idDepartamento->RowAttributes ?>>
		<td class="ewTableHeader">Departamento</td>
		<td<?php echo $municipio->idDepartamento->CellAttributes() ?>>
<div<?php echo $municipio->idDepartamento->ViewAttributes() ?>><?php echo $municipio->idDepartamento->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($municipio->municipio->Visible) { // municipio ?>
	<tr<?php echo $municipio->municipio->RowAttributes ?>>
		<td class="ewTableHeader">Municipio</td>
		<td<?php echo $municipio->municipio->CellAttributes() ?>>
<div<?php echo $municipio->municipio->ViewAttributes() ?>><?php echo $municipio->municipio->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($municipio->Export == "") { ?>
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
class cmunicipio_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'municipio';

	// Page Object Name
	var $PageObjName = 'municipio_view';

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
	function cmunicipio_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["municipio"] = new cmunicipio();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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
		if (!$Security->CanView()) {
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
		global $municipio;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idMunicipio"] <> "") {
				$municipio->idMunicipio->setQueryStringValue($_GET["idMunicipio"]);
			} else {
				$sReturnUrl = "municipiolist.php"; // Return to list
			}

			// Get action
			$municipio->CurrentAction = "I"; // Display form
			switch ($municipio->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "municipiolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "municipiolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$municipio->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $municipio;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$municipio->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$municipio->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $municipio->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$municipio->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$municipio->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$municipio->setStartRecordNumber($this->lStartRec);
		}
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
