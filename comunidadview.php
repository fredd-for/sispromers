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
$comunidad_view = new ccomunidad_view();
$Page =& $comunidad_view;

// Page init processing
$comunidad_view->Page_Init();

// Page main processing
$comunidad_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($comunidad->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var comunidad_view = new ew_Page("comunidad_view");

// page properties
comunidad_view.PageID = "view"; // page ID
var EW_PAGE_ID = comunidad_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
comunidad_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
comunidad_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
comunidad_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Comunidad
<br><br>
<?php if ($comunidad->Export == "") { ?>
<a href="comunidadlist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $comunidad->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $comunidad->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $comunidad->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $comunidad_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($comunidad->idComunidad->Visible) { // idComunidad ?>
	<tr<?php echo $comunidad->idComunidad->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $comunidad->idComunidad->CellAttributes() ?>>
<div<?php echo $comunidad->idComunidad->ViewAttributes() ?>><?php echo $comunidad->idComunidad->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($comunidad->idRegional->Visible) { // idRegional ?>
	<tr<?php echo $comunidad->idRegional->RowAttributes ?>>
		<td class="ewTableHeader">Regional</td>
		<td<?php echo $comunidad->idRegional->CellAttributes() ?>>
<div<?php echo $comunidad->idRegional->ViewAttributes() ?>><?php echo $comunidad->idRegional->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($comunidad->idDepartamento->Visible) { // idDepartamento ?>
	<tr<?php echo $comunidad->idDepartamento->RowAttributes ?>>
		<td class="ewTableHeader">Departamento</td>
		<td<?php echo $comunidad->idDepartamento->CellAttributes() ?>>
<div<?php echo $comunidad->idDepartamento->ViewAttributes() ?>><?php echo $comunidad->idDepartamento->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($comunidad->idMunicipio->Visible) { // idMunicipio ?>
	<tr<?php echo $comunidad->idMunicipio->RowAttributes ?>>
		<td class="ewTableHeader">Municipio</td>
		<td<?php echo $comunidad->idMunicipio->CellAttributes() ?>>
<div<?php echo $comunidad->idMunicipio->ViewAttributes() ?>><?php echo $comunidad->idMunicipio->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($comunidad->comunidad->Visible) { // comunidad ?>
	<tr<?php echo $comunidad->comunidad->RowAttributes ?>>
		<td class="ewTableHeader">Comunidad</td>
		<td<?php echo $comunidad->comunidad->CellAttributes() ?>>
<div<?php echo $comunidad->comunidad->ViewAttributes() ?>><?php echo $comunidad->comunidad->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($comunidad->Export == "") { ?>
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
class ccomunidad_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'comunidad';

	// Page Object Name
	var $PageObjName = 'comunidad_view';

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
	function ccomunidad_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["comunidad"] = new ccomunidad();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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
		if (!$Security->CanView()) {
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
		global $comunidad;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idComunidad"] <> "") {
				$comunidad->idComunidad->setQueryStringValue($_GET["idComunidad"]);
			} else {
				$sReturnUrl = "comunidadlist.php"; // Return to list
			}

			// Get action
			$comunidad->CurrentAction = "I"; // Display form
			switch ($comunidad->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "comunidadlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "comunidadlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$comunidad->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $comunidad;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$comunidad->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$comunidad->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $comunidad->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$comunidad->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$comunidad->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$comunidad->setStartRecordNumber($this->lStartRec);
		}
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
