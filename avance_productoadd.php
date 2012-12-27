<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "avance_productoinfo.php" ?>
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
$avance_producto_add = new cavance_producto_add();
$Page =& $avance_producto_add;

// Page init processing
$avance_producto_add->Page_Init();

// Page main processing
$avance_producto_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var avance_producto_add = new ew_Page("avance_producto_add");

// page properties
avance_producto_add.PageID = "add"; // page ID
var EW_PAGE_ID = avance_producto_add.PageID; // for backward compatibility

// extend page with ValidateForm function
avance_producto_add.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idConsultoria"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Id Consultoria");
		elm = fobj.elements["x" + infix + "_idConsultoria"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Id Consultoria");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
avance_producto_add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
avance_producto_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
avance_producto_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Agregar a Vista personalizada: Avace Producto<br><br>
<a href="<?php echo $avance_producto->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $avance_producto_add->ShowMessage() ?>
<form name="favance_productoadd" id="favance_productoadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return avance_producto_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="avance_producto">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($avance_producto->idConsultoria->Visible) { // idConsultoria ?>
	<tr<?php echo $avance_producto->idConsultoria->RowAttributes ?>>
		<td class="ewTableHeader">Id Consultoria<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $avance_producto->idConsultoria->CellAttributes() ?>><span id="el_idConsultoria">
<input type="text" name="x_idConsultoria" id="x_idConsultoria" size="30" value="<?php echo $avance_producto->idConsultoria->EditValue ?>"<?php echo $avance_producto->idConsultoria->EditAttributes() ?>>
</span><?php echo $avance_producto->idConsultoria->CustomMsg ?></td>
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
class cavance_producto_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'avance_producto';

	// Page Object Name
	var $PageObjName = 'avance_producto_add';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $avance_producto;
		if ($avance_producto->UseTokenInUrl) $PageUrl .= "t=" . $avance_producto->TableVar . "&"; // add page token
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
		global $objForm, $avance_producto;
		if ($avance_producto->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($avance_producto->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($avance_producto->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cavance_producto_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["avance_producto"] = new cavance_producto();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'avance_producto', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $avance_producto;
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
			$this->Page_Terminate("avance_productolist.php");
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
		global $objForm, $gsFormError, $avance_producto;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["idConsultoria"] != "") {
		  $avance_producto->idConsultoria->setQueryStringValue($_GET["idConsultoria"]);
		} else {
		  $bCopy = FALSE;
		}
		if (@$_GET["idCronograma"] != "") {
		  $avance_producto->idCronograma->setQueryStringValue($_GET["idCronograma"]);
		} else {
		  $bCopy = FALSE;
		}

		// Create form object
		$objForm = new cFormObj();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $avance_producto->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$avance_producto->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $avance_producto->CurrentAction = "C"; // Copy Record
		  } else {
		    $avance_producto->CurrentAction = "I"; // Display Blank Record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($avance_producto->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No se encontraron registros"); // No record found
		      $this->Page_Terminate("avance_productolist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$avance_producto->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Registro agregado satisfactoriamente"); // Set up success message
					$sReturnUrl = $avance_producto->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$avance_producto->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $avance_producto;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $avance_producto;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $avance_producto;
		$avance_producto->idConsultoria->setFormValue($objForm->GetValue("x_idConsultoria"));
		$avance_producto->idCronograma->setFormValue($objForm->GetValue("x_idCronograma"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $avance_producto;
		$avance_producto->idCronograma->CurrentValue = $avance_producto->idCronograma->FormValue;
		$avance_producto->idConsultoria->CurrentValue = $avance_producto->idConsultoria->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $avance_producto;
		$sFilter = $avance_producto->KeyFilter();

		// Call Row Selecting event
		$avance_producto->Row_Selecting($sFilter);

		// Load sql based on filter
		$avance_producto->CurrentFilter = $sFilter;
		$sSql = $avance_producto->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$avance_producto->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $avance_producto;
		$avance_producto->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$avance_producto->idCronograma->setDbValue($rs->fields('idCronograma'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $avance_producto;

		// Call Row_Rendering event
		$avance_producto->Row_Rendering();

		// Common render codes for all row types
		// idConsultoria

		$avance_producto->idConsultoria->CellCssStyle = "";
		$avance_producto->idConsultoria->CellCssClass = "";
		if ($avance_producto->RowType == EW_ROWTYPE_VIEW) { // View row

			// idConsultoria
			$avance_producto->idConsultoria->ViewValue = $avance_producto->idConsultoria->CurrentValue;
			$avance_producto->idConsultoria->CssStyle = "";
			$avance_producto->idConsultoria->CssClass = "";
			$avance_producto->idConsultoria->ViewCustomAttributes = "";

			// idCronograma
			$avance_producto->idCronograma->ViewValue = $avance_producto->idCronograma->CurrentValue;
			$avance_producto->idCronograma->CssStyle = "";
			$avance_producto->idCronograma->CssClass = "";
			$avance_producto->idCronograma->ViewCustomAttributes = "";

			// idConsultoria
			$avance_producto->idConsultoria->HrefValue = "";
		} elseif ($avance_producto->RowType == EW_ROWTYPE_ADD) { // Add row

			// idConsultoria
			$avance_producto->idConsultoria->EditCustomAttributes = "";
			$avance_producto->idConsultoria->EditValue = ew_HtmlEncode($avance_producto->idConsultoria->CurrentValue);
		}

		// Call Row Rendered event
		$avance_producto->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $avance_producto;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($avance_producto->idConsultoria->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Id Consultoria";
		}
		if (!ew_CheckInteger($avance_producto->idConsultoria->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Id Consultoria";
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
		global $conn, $Security, $avance_producto;

		// Check if key value entered
		if ($avance_producto->idConsultoria->CurrentValue == "") {
			$this->setMessage("Valor de la llave incorrecto");
			return FALSE;
		}

		// Check for duplicate key
		$bCheckKey = TRUE;
		$sFilter = $avance_producto->KeyFilter();
		if ($bCheckKey) {
			$rsChk = $avance_producto->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, "Llave primaria duplicado: '%f'");
				$this->setMessage($sKeyErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Field idConsultoria
		$avance_producto->idConsultoria->SetDbValueDef($avance_producto->idConsultoria->CurrentValue, 0);
		$rsnew['idConsultoria'] =& $avance_producto->idConsultoria->DbValue;

		// Call Row Inserting event
		$bInsertRow = $avance_producto->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($avance_producto->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($avance_producto->CancelMessage <> "") {
				$this->setMessage($avance_producto->CancelMessage);
				$avance_producto->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$avance_producto->idCronograma->setDbValue($conn->Insert_ID());
			$rsnew['idCronograma'] =& $avance_producto->idCronograma->DbValue;

			// Call Row Inserted event
			$avance_producto->Row_Inserted($rsnew);
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
