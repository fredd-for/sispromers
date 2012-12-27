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
$rubro_view = new crubro_view();
$Page =& $rubro_view;

// Page init processing
$rubro_view->Page_Init();

// Page main processing
$rubro_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($rubro->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var rubro_view = new ew_Page("rubro_view");

// page properties
rubro_view.PageID = "view"; // page ID
var EW_PAGE_ID = rubro_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
rubro_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
rubro_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
rubro_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Rubro
<br><br>
<?php if ($rubro->Export == "") { ?>
<a href="rubrolist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $rubro->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $rubro->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $rubro->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $rubro_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($rubro->idRubro->Visible) { // idRubro ?>
	<tr<?php echo $rubro->idRubro->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $rubro->idRubro->CellAttributes() ?>>
<div<?php echo $rubro->idRubro->ViewAttributes() ?>><?php echo $rubro->idRubro->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($rubro->rubro->Visible) { // rubro ?>
	<tr<?php echo $rubro->rubro->RowAttributes ?>>
		<td class="ewTableHeader">Rubro</td>
		<td<?php echo $rubro->rubro->CellAttributes() ?>>
<div<?php echo $rubro->rubro->ViewAttributes() ?>><?php echo $rubro->rubro->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($rubro->detalle->Visible) { // detalle ?>
	<tr<?php echo $rubro->detalle->RowAttributes ?>>
		<td class="ewTableHeader">Detalle</td>
		<td<?php echo $rubro->detalle->CellAttributes() ?>>
<div<?php echo $rubro->detalle->ViewAttributes() ?>><?php echo $rubro->detalle->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($rubro->gestion2009->Visible) { // gestion2009 ?>
	<tr<?php echo $rubro->gestion2009->RowAttributes ?>>
		<td class="ewTableHeader">No Mers Gestion 2009</td>
		<td<?php echo $rubro->gestion2009->CellAttributes() ?>>
<div<?php echo $rubro->gestion2009->ViewAttributes() ?>><?php echo $rubro->gestion2009->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($rubro->gestion2010->Visible) { // gestion2010 ?>
	<tr<?php echo $rubro->gestion2010->RowAttributes ?>>
		<td class="ewTableHeader">No Mers Gestion 2010</td>
		<td<?php echo $rubro->gestion2010->CellAttributes() ?>>
<div<?php echo $rubro->gestion2010->ViewAttributes() ?>><?php echo $rubro->gestion2010->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($rubro->gestion2011->Visible) { // gestion2011 ?>
	<tr<?php echo $rubro->gestion2011->RowAttributes ?>>
		<td class="ewTableHeader">No Mers Gestion 2011</td>
		<td<?php echo $rubro->gestion2011->CellAttributes() ?>>
<div<?php echo $rubro->gestion2011->ViewAttributes() ?>><?php echo $rubro->gestion2011->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($rubro->gestion2012->Visible) { // gestion2012 ?>
	<tr<?php echo $rubro->gestion2012->RowAttributes ?>>
		<td class="ewTableHeader">No Mers Gestion 2012</td>
		<td<?php echo $rubro->gestion2012->CellAttributes() ?>>
<div<?php echo $rubro->gestion2012->ViewAttributes() ?>><?php echo $rubro->gestion2012->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($rubro->Export == "") { ?>
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
class crubro_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'rubro';

	// Page Object Name
	var $PageObjName = 'rubro_view';

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
	function crubro_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["rubro"] = new crubro();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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
		if (!$Security->CanView()) {
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
		global $rubro;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idRubro"] <> "") {
				$rubro->idRubro->setQueryStringValue($_GET["idRubro"]);
			} else {
				$sReturnUrl = "rubrolist.php"; // Return to list
			}

			// Get action
			$rubro->CurrentAction = "I"; // Display form
			switch ($rubro->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "rubrolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "rubrolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$rubro->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $rubro;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$rubro->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$rubro->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $rubro->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$rubro->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$rubro->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$rubro->setStartRecordNumber($this->lStartRec);
		}
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

		// detalle
		$rubro->detalle->CellCssStyle = "";
		$rubro->detalle->CellCssClass = "";

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

			// detalle
			$rubro->detalle->ViewValue = $rubro->detalle->CurrentValue;
			$rubro->detalle->CssStyle = "";
			$rubro->detalle->CssClass = "";
			$rubro->detalle->ViewCustomAttributes = "";

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

			// detalle
			$rubro->detalle->HrefValue = "";

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
