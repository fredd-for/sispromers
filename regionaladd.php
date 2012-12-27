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
$regional_add = new cregional_add();
$Page =& $regional_add;

// Page init processing
$regional_add->Page_Init();

// Page main processing
$regional_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var regional_add = new ew_Page("regional_add");

// page properties
regional_add.PageID = "add"; // page ID
var EW_PAGE_ID = regional_add.PageID; // for backward compatibility

// extend page with ValidateForm function
regional_add.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_regional"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Regional");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
regional_add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
regional_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
regional_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script type="text/javascript">
<!--
var ew_DHTMLEditors = [];

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Agregar a TABLA: Regional<br><br>
<a href="<?php echo $regional->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $regional_add->ShowMessage() ?>
<form name="fregionaladd" id="fregionaladd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return regional_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="regional">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($regional->regional->Visible) { // regional ?>
	<tr<?php echo $regional->regional->RowAttributes ?>>
		<td class="ewTableHeader">Regional<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $regional->regional->CellAttributes() ?>><span id="el_regional">
<input type="text" name="x_regional" id="x_regional" size="30" maxlength="100" value="<?php echo $regional->regional->EditValue ?>"<?php echo $regional->regional->EditAttributes() ?>>
</span><?php echo $regional->regional->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="  AGREGAR  ">
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
class cregional_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'regional';

	// Page Object Name
	var $PageObjName = 'regional_add';

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
	function cregional_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["regional"] = new cregional();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
	var $x_ewPriv = 0;

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $regional;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["idRegional"] != "") {
		  $regional->idRegional->setQueryStringValue($_GET["idRegional"]);
		} else {
		  $bCopy = FALSE;
		}

		// Create form object
		$objForm = new cFormObj();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $regional->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$regional->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $regional->CurrentAction = "C"; // Copy Record
		  } else {
		    $regional->CurrentAction = "I"; // Display Blank Record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($regional->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No se encontraron registros"); // No record found
		      $this->Page_Terminate("regionallist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$regional->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Registro agregado satisfactoriamente"); // Set up success message
					$sReturnUrl = $regional->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$regional->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $regional;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $regional;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $regional;
		$regional->regional->setFormValue($objForm->GetValue("x_regional"));
		$regional->idRegional->setFormValue($objForm->GetValue("x_idRegional"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $regional;
		$regional->idRegional->CurrentValue = $regional->idRegional->FormValue;
		$regional->regional->CurrentValue = $regional->regional->FormValue;
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

			// regional
			$regional->regional->HrefValue = "";
		} elseif ($regional->RowType == EW_ROWTYPE_ADD) { // Add row

			// regional
			$regional->regional->EditCustomAttributes = "";
			$regional->regional->EditValue = ew_HtmlEncode($regional->regional->CurrentValue);
		}

		// Call Row Rendered event
		$regional->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $regional;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($regional->regional->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Regional";
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow() {
		global $conn, $Security, $regional;
		$rsnew = array();

		// Field regional
		$regional->regional->SetDbValueDef($regional->regional->CurrentValue, "");
		$rsnew['regional'] =& $regional->regional->DbValue;

		// Call Row Inserting event
		$bInsertRow = $regional->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($regional->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($regional->CancelMessage <> "") {
				$this->setMessage($regional->CancelMessage);
				$regional->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$regional->idRegional->setDbValue($conn->Insert_ID());
			$rsnew['idRegional'] =& $regional->idRegional->DbValue;

			// Call Row Inserted event
			$regional->Row_Inserted($rsnew);
		}
		return $AddRow;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
