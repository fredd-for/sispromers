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
$municipio_add = new cmunicipio_add();
$Page =& $municipio_add;

// Page init processing
$municipio_add->Page_Init();

// Page main processing
$municipio_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var municipio_add = new ew_Page("municipio_add");

// page properties
municipio_add.PageID = "add"; // page ID
var EW_PAGE_ID = municipio_add.PageID; // for backward compatibility

// extend page with ValidateForm function
municipio_add.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idRegional"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Regional");
//		elm = fobj.elements["x" + infix + "_idDepartamento"];
//		if (elm && !ew_HasValue(elm))
//			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Departamento");
		elm = fobj.elements["x" + infix + "_municipio"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Municipio");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
municipio_add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
municipio_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
municipio_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Agregar a TABLA: Municipio<br><br>
<a href="<?php echo $municipio->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $municipio_add->ShowMessage() ?>
<form name="fmunicipioadd" id="fmunicipioadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return municipio_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="municipio">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($municipio->idRegional->Visible) { // idRegional ?>
	<tr<?php echo $municipio->idRegional->RowAttributes ?>>
		<td class="ewTableHeader">Regional<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $municipio->idRegional->CellAttributes() ?>><span id="el_idRegional">
<select id="x_idRegional" name="x_idRegional">
<?php
if (is_array($municipio->idRegional->EditValue)) {
	$arwrk = $municipio->idRegional->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($municipio->idRegional->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $municipio->idRegional->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($municipio->idDepartamento->Visible) { // idDepartamento ?>
	<tr<?php echo $municipio->idDepartamento->RowAttributes ?>>
		<td class="ewTableHeader">Departamento<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $municipio->idDepartamento->CellAttributes() ?>><span id="el_idDepartamento">
<input type="hidden" name="x_idDepartamento_edit" id="x_idDepartamento_edit" value="-1"/>
<div id="divx_idDepartamento"></div>
</span><?php echo $municipio->idDepartamento->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($municipio->municipio->Visible) { // municipio ?>
	<tr<?php echo $municipio->municipio->RowAttributes ?>>
		<td class="ewTableHeader">Municipio<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $municipio->municipio->CellAttributes() ?>><span id="el_municipio">
<input type="text" name="x_municipio" id="x_municipio" size="30" maxlength="150" value="<?php echo $municipio->municipio->EditValue ?>"<?php echo $municipio->municipio->EditAttributes() ?>>
</span><?php echo $municipio->municipio->CustomMsg ?></td>
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
class cmunicipio_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'municipio';

	// Page Object Name
	var $PageObjName = 'municipio_add';

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
	function cmunicipio_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["municipio"] = new cmunicipio();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
	var $x_ewPriv = 0;

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $municipio;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["idMunicipio"] != "") {
		  $municipio->idMunicipio->setQueryStringValue($_GET["idMunicipio"]);
		} else {
		  $bCopy = FALSE;
		}

		// Create form object
		$objForm = new cFormObj();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $municipio->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$municipio->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $municipio->CurrentAction = "C"; // Copy Record
		  } else {
		    $municipio->CurrentAction = "I"; // Display Blank Record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($municipio->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No se encontraron registros"); // No record found
		      $this->Page_Terminate("municipiolist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$municipio->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Registro agregado satisfactoriamente"); // Set up success message
					$sReturnUrl = $municipio->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$municipio->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $municipio;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $municipio;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $municipio;
		$municipio->idRegional->setFormValue($objForm->GetValue("x_idRegional"));
		$municipio->idDepartamento->setFormValue($objForm->GetValue("x_idDepartamento"));
		$municipio->municipio->setFormValue($objForm->GetValue("x_municipio"));
		$municipio->idMunicipio->setFormValue($objForm->GetValue("x_idMunicipio"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $municipio;
		$municipio->idMunicipio->CurrentValue = $municipio->idMunicipio->FormValue;
		$municipio->idRegional->CurrentValue = $municipio->idRegional->FormValue;
		$municipio->idDepartamento->CurrentValue = $municipio->idDepartamento->FormValue;
		$municipio->municipio->CurrentValue = $municipio->municipio->FormValue;
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

			// idRegional
			$municipio->idRegional->HrefValue = "";

			// idDepartamento
			$municipio->idDepartamento->HrefValue = "";

			// municipio
			$municipio->municipio->HrefValue = "";
		} elseif ($municipio->RowType == EW_ROWTYPE_ADD) { // Add row

			// idRegional
			$municipio->idRegional->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idRegional`, `regional`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `regional`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `regional` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$municipio->idRegional->EditValue = $arwrk;

			// idDepartamento
			$municipio->idDepartamento->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idDepartamento`, `departamento`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `departamento`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `departamento` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$municipio->idDepartamento->EditValue = $arwrk;

			// municipio
			$municipio->municipio->EditCustomAttributes = "";
			$municipio->municipio->EditValue = ew_HtmlEncode($municipio->municipio->CurrentValue);
		}

		// Call Row Rendered event
		$municipio->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $municipio;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($municipio->idRegional->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Regional";
		}
		if ($municipio->idDepartamento->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Departamento";
		}
		if ($municipio->municipio->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Municipio";
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
		global $conn, $Security, $municipio;
		$rsnew = array();

		// Field idRegional
		$municipio->idRegional->SetDbValueDef($municipio->idRegional->CurrentValue, 0);
		$rsnew['idRegional'] =& $municipio->idRegional->DbValue;

		// Field idDepartamento
		$municipio->idDepartamento->SetDbValueDef($municipio->idDepartamento->CurrentValue, 0);
		$rsnew['idDepartamento'] =& $municipio->idDepartamento->DbValue;

		// Field municipio
		$municipio->municipio->SetDbValueDef($municipio->municipio->CurrentValue, "");
		$rsnew['municipio'] =& $municipio->municipio->DbValue;

		// Call Row Inserting event
		$bInsertRow = $municipio->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($municipio->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($municipio->CancelMessage <> "") {
				$this->setMessage($municipio->CancelMessage);
				$municipio->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$municipio->idMunicipio->setDbValue($conn->Insert_ID());
			$rsnew['idMunicipio'] =& $municipio->idMunicipio->DbValue;

			// Call Row Inserted event
			$municipio->Row_Inserted($rsnew);
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
