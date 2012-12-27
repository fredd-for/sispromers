<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "formularioinfo.php" ?>
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
$formulario_edit = new cformulario_edit();
$Page =& $formulario_edit;

// Page init processing
$formulario_edit->Page_Init();

// Page main processing
$formulario_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var formulario_edit = new ew_Page("formulario_edit");

// page properties
formulario_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = formulario_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
formulario_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idMer"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Id Mer");
		elm = fobj.elements["x" + infix + "_idMer"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Id Mer");
		elm = fobj.elements["x" + infix + "_idPlanilla"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Id Planilla");
		elm = fobj.elements["x" + infix + "_idPlanilla"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Id Planilla");
		elm = fobj.elements["x" + infix + "_cuenta"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Cuenta");
		elm = fobj.elements["x" + infix + "_porcentaje"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Porcentaje");
		elm = fobj.elements["x" + infix + "_porcentaje"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "Número de Punto Flotante Incorrecto - Porcentaje");
		elm = fobj.elements["x" + infix + "_observacion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Observacion");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
formulario_edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
formulario_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
formulario_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Editar TABLA: Formulario<br><br>
<a href="<?php echo $formulario->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $formulario_edit->ShowMessage() ?>
<form name="fformularioedit" id="fformularioedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return formulario_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="formulario">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($formulario->idFormulario->Visible) { // idFormulario ?>
	<tr<?php echo $formulario->idFormulario->RowAttributes ?>>
		<td class="ewTableHeader">Id Formulario</td>
		<td<?php echo $formulario->idFormulario->CellAttributes() ?>><span id="el_idFormulario">
<div<?php echo $formulario->idFormulario->ViewAttributes() ?>><?php echo $formulario->idFormulario->EditValue ?></div><input type="hidden" name="x_idFormulario" id="x_idFormulario" value="<?php echo ew_HtmlEncode($formulario->idFormulario->CurrentValue) ?>">
</span><?php echo $formulario->idFormulario->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($formulario->idMer->Visible) { // idMer ?>
	<tr<?php echo $formulario->idMer->RowAttributes ?>>
		<td class="ewTableHeader">Id Mer<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $formulario->idMer->CellAttributes() ?>><span id="el_idMer">
<input type="text" name="x_idMer" id="x_idMer" size="30" value="<?php echo $formulario->idMer->EditValue ?>"<?php echo $formulario->idMer->EditAttributes() ?>>
</span><?php echo $formulario->idMer->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($formulario->idPlanilla->Visible) { // idPlanilla ?>
	<tr<?php echo $formulario->idPlanilla->RowAttributes ?>>
		<td class="ewTableHeader">Id Planilla<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $formulario->idPlanilla->CellAttributes() ?>><span id="el_idPlanilla">
<input type="text" name="x_idPlanilla" id="x_idPlanilla" size="30" value="<?php echo $formulario->idPlanilla->EditValue ?>"<?php echo $formulario->idPlanilla->EditAttributes() ?>>
</span><?php echo $formulario->idPlanilla->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($formulario->archivo->Visible) { // archivo ?>
	<tr<?php echo $formulario->archivo->RowAttributes ?>>
		<td class="ewTableHeader">Archivo</td>
		<td<?php echo $formulario->archivo->CellAttributes() ?>><span id="el_archivo">
<input type="text" name="x_archivo" id="x_archivo" size="30" maxlength="255" value="<?php echo $formulario->archivo->EditValue ?>"<?php echo $formulario->archivo->EditAttributes() ?>>
</span><?php echo $formulario->archivo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($formulario->cuenta->Visible) { // cuenta ?>
	<tr<?php echo $formulario->cuenta->RowAttributes ?>>
		<td class="ewTableHeader">Cuenta<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $formulario->cuenta->CellAttributes() ?>><span id="el_cuenta">
<input type="text" name="x_cuenta" id="x_cuenta" size="30" maxlength="150" value="<?php echo $formulario->cuenta->EditValue ?>"<?php echo $formulario->cuenta->EditAttributes() ?>>
</span><?php echo $formulario->cuenta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($formulario->porcentaje->Visible) { // porcentaje ?>
	<tr<?php echo $formulario->porcentaje->RowAttributes ?>>
		<td class="ewTableHeader">Porcentaje<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $formulario->porcentaje->CellAttributes() ?>><span id="el_porcentaje">
<input type="text" name="x_porcentaje" id="x_porcentaje" size="30" value="<?php echo $formulario->porcentaje->EditValue ?>"<?php echo $formulario->porcentaje->EditAttributes() ?>>
</span><?php echo $formulario->porcentaje->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($formulario->observacion->Visible) { // observacion ?>
	<tr<?php echo $formulario->observacion->RowAttributes ?>>
		<td class="ewTableHeader">Observacion<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $formulario->observacion->CellAttributes() ?>><span id="el_observacion">
<textarea name="x_observacion" id="x_observacion" cols="35" rows="4"<?php echo $formulario->observacion->EditAttributes() ?>><?php echo $formulario->observacion->EditValue ?></textarea>
</span><?php echo $formulario->observacion->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="  EDITAR  ">
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
class cformulario_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'formulario';

	// Page Object Name
	var $PageObjName = 'formulario_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $formulario;
		if ($formulario->UseTokenInUrl) $PageUrl .= "t=" . $formulario->TableVar . "&"; // add page token
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
		global $objForm, $formulario;
		if ($formulario->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($formulario->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($formulario->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cformulario_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["formulario"] = new cformulario();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'formulario', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $formulario;
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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("formulariolist.php");
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

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $formulario;

		// Load key from QueryString
		if (@$_GET["idFormulario"] <> "")
			$formulario->idFormulario->setQueryStringValue($_GET["idFormulario"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$formulario->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$formulario->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$formulario->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($formulario->idFormulario->CurrentValue == "")
			$this->Page_Terminate("formulariolist.php"); // Invalid key, return to list
		switch ($formulario->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No se encontraron registros"); // No record found
					$this->Page_Terminate("formulariolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$formulario->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Update success
					$sReturnUrl = $formulario->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$formulario->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $formulario;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $formulario;
		$formulario->idFormulario->setFormValue($objForm->GetValue("x_idFormulario"));
		$formulario->idMer->setFormValue($objForm->GetValue("x_idMer"));
		$formulario->idPlanilla->setFormValue($objForm->GetValue("x_idPlanilla"));
		$formulario->archivo->setFormValue($objForm->GetValue("x_archivo"));
		$formulario->cuenta->setFormValue($objForm->GetValue("x_cuenta"));
		$formulario->porcentaje->setFormValue($objForm->GetValue("x_porcentaje"));
		$formulario->observacion->setFormValue($objForm->GetValue("x_observacion"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $formulario;
		$this->LoadRow();
		$formulario->idFormulario->CurrentValue = $formulario->idFormulario->FormValue;
		$formulario->idMer->CurrentValue = $formulario->idMer->FormValue;
		$formulario->idPlanilla->CurrentValue = $formulario->idPlanilla->FormValue;
		$formulario->archivo->CurrentValue = $formulario->archivo->FormValue;
		$formulario->cuenta->CurrentValue = $formulario->cuenta->FormValue;
		$formulario->porcentaje->CurrentValue = $formulario->porcentaje->FormValue;
		$formulario->observacion->CurrentValue = $formulario->observacion->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $formulario;
		$sFilter = $formulario->KeyFilter();

		// Call Row Selecting event
		$formulario->Row_Selecting($sFilter);

		// Load sql based on filter
		$formulario->CurrentFilter = $sFilter;
		$sSql = $formulario->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$formulario->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $formulario;
		$formulario->idFormulario->setDbValue($rs->fields('idFormulario'));
		$formulario->idMer->setDbValue($rs->fields('idMer'));
		$formulario->idPlanilla->setDbValue($rs->fields('idPlanilla'));
		$formulario->archivo->setDbValue($rs->fields('archivo'));
		$formulario->cuenta->setDbValue($rs->fields('cuenta'));
		$formulario->porcentaje->setDbValue($rs->fields('porcentaje'));
		$formulario->observacion->setDbValue($rs->fields('observacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $formulario;

		// Call Row_Rendering event
		$formulario->Row_Rendering();

		// Common render codes for all row types
		// idFormulario

		$formulario->idFormulario->CellCssStyle = "";
		$formulario->idFormulario->CellCssClass = "";

		// idMer
		$formulario->idMer->CellCssStyle = "";
		$formulario->idMer->CellCssClass = "";

		// idPlanilla
		$formulario->idPlanilla->CellCssStyle = "";
		$formulario->idPlanilla->CellCssClass = "";

		// archivo
		$formulario->archivo->CellCssStyle = "";
		$formulario->archivo->CellCssClass = "";

		// cuenta
		$formulario->cuenta->CellCssStyle = "";
		$formulario->cuenta->CellCssClass = "";

		// porcentaje
		$formulario->porcentaje->CellCssStyle = "";
		$formulario->porcentaje->CellCssClass = "";

		// observacion
		$formulario->observacion->CellCssStyle = "";
		$formulario->observacion->CellCssClass = "";
		if ($formulario->RowType == EW_ROWTYPE_VIEW) { // View row

			// idFormulario
			$formulario->idFormulario->ViewValue = $formulario->idFormulario->CurrentValue;
			$formulario->idFormulario->CssStyle = "";
			$formulario->idFormulario->CssClass = "";
			$formulario->idFormulario->ViewCustomAttributes = "";

			// idMer
			$formulario->idMer->ViewValue = $formulario->idMer->CurrentValue;
			$formulario->idMer->CssStyle = "";
			$formulario->idMer->CssClass = "";
			$formulario->idMer->ViewCustomAttributes = "";

			// idPlanilla
			$formulario->idPlanilla->ViewValue = $formulario->idPlanilla->CurrentValue;
			$formulario->idPlanilla->CssStyle = "";
			$formulario->idPlanilla->CssClass = "";
			$formulario->idPlanilla->ViewCustomAttributes = "";

			// archivo
			$formulario->archivo->ViewValue = $formulario->archivo->CurrentValue;
			$formulario->archivo->CssStyle = "";
			$formulario->archivo->CssClass = "";
			$formulario->archivo->ViewCustomAttributes = "";

			// cuenta
			$formulario->cuenta->ViewValue = $formulario->cuenta->CurrentValue;
			$formulario->cuenta->CssStyle = "";
			$formulario->cuenta->CssClass = "";
			$formulario->cuenta->ViewCustomAttributes = "";

			// porcentaje
			$formulario->porcentaje->ViewValue = $formulario->porcentaje->CurrentValue;
			$formulario->porcentaje->CssStyle = "";
			$formulario->porcentaje->CssClass = "";
			$formulario->porcentaje->ViewCustomAttributes = "";

			// observacion
			$formulario->observacion->ViewValue = $formulario->observacion->CurrentValue;
			$formulario->observacion->CssStyle = "";
			$formulario->observacion->CssClass = "";
			$formulario->observacion->ViewCustomAttributes = "";

			// idFormulario
			$formulario->idFormulario->HrefValue = "";

			// idMer
			$formulario->idMer->HrefValue = "";

			// idPlanilla
			$formulario->idPlanilla->HrefValue = "";

			// archivo
			$formulario->archivo->HrefValue = "";

			// cuenta
			$formulario->cuenta->HrefValue = "";

			// porcentaje
			$formulario->porcentaje->HrefValue = "";

			// observacion
			$formulario->observacion->HrefValue = "";
		} elseif ($formulario->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idFormulario
			$formulario->idFormulario->EditCustomAttributes = "";
			$formulario->idFormulario->EditValue = $formulario->idFormulario->CurrentValue;
			$formulario->idFormulario->CssStyle = "";
			$formulario->idFormulario->CssClass = "";
			$formulario->idFormulario->ViewCustomAttributes = "";

			// idMer
			$formulario->idMer->EditCustomAttributes = "";
			$formulario->idMer->EditValue = ew_HtmlEncode($formulario->idMer->CurrentValue);

			// idPlanilla
			$formulario->idPlanilla->EditCustomAttributes = "";
			$formulario->idPlanilla->EditValue = ew_HtmlEncode($formulario->idPlanilla->CurrentValue);

			// archivo
			$formulario->archivo->EditCustomAttributes = "";
			$formulario->archivo->EditValue = ew_HtmlEncode($formulario->archivo->CurrentValue);

			// cuenta
			$formulario->cuenta->EditCustomAttributes = "";
			$formulario->cuenta->EditValue = ew_HtmlEncode($formulario->cuenta->CurrentValue);

			// porcentaje
			$formulario->porcentaje->EditCustomAttributes = "";
			$formulario->porcentaje->EditValue = ew_HtmlEncode($formulario->porcentaje->CurrentValue);

			// observacion
			$formulario->observacion->EditCustomAttributes = "";
			$formulario->observacion->EditValue = ew_HtmlEncode($formulario->observacion->CurrentValue);

			// Edit refer script
			// idFormulario

			$formulario->idFormulario->HrefValue = "";

			// idMer
			$formulario->idMer->HrefValue = "";

			// idPlanilla
			$formulario->idPlanilla->HrefValue = "";

			// archivo
			$formulario->archivo->HrefValue = "";

			// cuenta
			$formulario->cuenta->HrefValue = "";

			// porcentaje
			$formulario->porcentaje->HrefValue = "";

			// observacion
			$formulario->observacion->HrefValue = "";
		}

		// Call Row Rendered event
		$formulario->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $formulario;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($formulario->idMer->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Id Mer";
		}
		if (!ew_CheckInteger($formulario->idMer->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Id Mer";
		}
		if ($formulario->idPlanilla->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Id Planilla";
		}
		if (!ew_CheckInteger($formulario->idPlanilla->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Id Planilla";
		}
		if ($formulario->cuenta->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Cuenta";
		}
		if ($formulario->porcentaje->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Porcentaje";
		}
		if (!ew_CheckNumber($formulario->porcentaje->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Número de Punto Flotante Incorrecto - Porcentaje";
		}
		if ($formulario->observacion->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Observacion";
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $formulario;
		$sFilter = $formulario->KeyFilter();
		$formulario->CurrentFilter = $sFilter;
		$sSql = $formulario->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// Field idFormulario
			// Field idMer

			$formulario->idMer->SetDbValueDef($formulario->idMer->CurrentValue, 0);
			$rsnew['idMer'] =& $formulario->idMer->DbValue;

			// Field idPlanilla
			$formulario->idPlanilla->SetDbValueDef($formulario->idPlanilla->CurrentValue, 0);
			$rsnew['idPlanilla'] =& $formulario->idPlanilla->DbValue;

			// Field archivo
			$formulario->archivo->SetDbValueDef($formulario->archivo->CurrentValue, NULL);
			$rsnew['archivo'] =& $formulario->archivo->DbValue;

			// Field cuenta
			$formulario->cuenta->SetDbValueDef($formulario->cuenta->CurrentValue, "");
			$rsnew['cuenta'] =& $formulario->cuenta->DbValue;

			// Field porcentaje
			$formulario->porcentaje->SetDbValueDef($formulario->porcentaje->CurrentValue, 0);
			$rsnew['porcentaje'] =& $formulario->porcentaje->DbValue;

			// Field observacion
			$formulario->observacion->SetDbValueDef($formulario->observacion->CurrentValue, "");
			$rsnew['observacion'] =& $formulario->observacion->DbValue;

			// Call Row Updating event
			$bUpdateRow = $formulario->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($formulario->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($formulario->CancelMessage <> "") {
					$this->setMessage($formulario->CancelMessage);
					$formulario->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$formulario->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
