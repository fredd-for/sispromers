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
$rubro_edit = new crubro_edit();
$Page =& $rubro_edit;

// Page init processing
$rubro_edit->Page_Init();

// Page main processing
$rubro_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var rubro_edit = new ew_Page("rubro_edit");

// page properties
rubro_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = rubro_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
rubro_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_rubro"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Rubro");
		elm = fobj.elements["x" + infix + "_gestion2009"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - No Mers Gestion 2009");
		elm = fobj.elements["x" + infix + "_gestion2010"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - No Mers Gestion 2010");
		elm = fobj.elements["x" + infix + "_gestion2010"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - No Mers Gestion 2010");
		elm = fobj.elements["x" + infix + "_gestion2011"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - No Mers Gestion 2011");
		elm = fobj.elements["x" + infix + "_gestion2011"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - No Mers Gestion 2011");
		elm = fobj.elements["x" + infix + "_gestion2012"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - No Mers Gestion 2012");
		elm = fobj.elements["x" + infix + "_gestion2012"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - No Mers Gestion 2012");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
rubro_edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
rubro_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
rubro_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Editar TABLA: Rubro<br><br>
<a href="<?php echo $rubro->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $rubro_edit->ShowMessage() ?>
<form name="frubroedit" id="frubroedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return rubro_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="rubro">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($rubro->idRubro->Visible) { // idRubro ?>
	<tr<?php echo $rubro->idRubro->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $rubro->idRubro->CellAttributes() ?>><span id="el_idRubro">
<div<?php echo $rubro->idRubro->ViewAttributes() ?>><?php echo $rubro->idRubro->EditValue ?></div><input type="hidden" name="x_idRubro" id="x_idRubro" value="<?php echo ew_HtmlEncode($rubro->idRubro->CurrentValue) ?>">
</span><?php echo $rubro->idRubro->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($rubro->rubro->Visible) { // rubro ?>
	<tr<?php echo $rubro->rubro->RowAttributes ?>>
		<td class="ewTableHeader">Rubro<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $rubro->rubro->CellAttributes() ?>><span id="el_rubro">
<input type="text" name="x_rubro" id="x_rubro" size="30" maxlength="150" value="<?php echo $rubro->rubro->EditValue ?>"<?php echo $rubro->rubro->EditAttributes() ?>>
</span><?php echo $rubro->rubro->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($rubro->detalle->Visible) { // detalle ?>
	<tr<?php echo $rubro->detalle->RowAttributes ?>>
		<td class="ewTableHeader">Detalle</td>
		<td<?php echo $rubro->detalle->CellAttributes() ?>><span id="el_detalle">
<input type="text" name="x_detalle" id="x_detalle" size="30" maxlength="250" value="<?php echo $rubro->detalle->EditValue ?>"<?php echo $rubro->detalle->EditAttributes() ?>>
</span><?php echo $rubro->detalle->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($rubro->gestion2009->Visible) { // gestion2009 ?>
	<tr<?php echo $rubro->gestion2009->RowAttributes ?>>
		<td class="ewTableHeader">No Mers Gestion 2009</td>
		<td<?php echo $rubro->gestion2009->CellAttributes() ?>><span id="el_gestion2009">
<input type="text" name="x_gestion2009" id="x_gestion2009" size="30" value="<?php echo $rubro->gestion2009->EditValue ?>"<?php echo $rubro->gestion2009->EditAttributes() ?>>
</span><?php echo $rubro->gestion2009->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($rubro->gestion2010->Visible) { // gestion2010 ?>
	<tr<?php echo $rubro->gestion2010->RowAttributes ?>>
		<td class="ewTableHeader">No Mers Gestion 2010<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $rubro->gestion2010->CellAttributes() ?>><span id="el_gestion2010">
<input type="text" name="x_gestion2010" id="x_gestion2010" size="30" value="<?php echo $rubro->gestion2010->EditValue ?>"<?php echo $rubro->gestion2010->EditAttributes() ?>>
</span><?php echo $rubro->gestion2010->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($rubro->gestion2011->Visible) { // gestion2011 ?>
	<tr<?php echo $rubro->gestion2011->RowAttributes ?>>
		<td class="ewTableHeader">No Mers Gestion 2011<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $rubro->gestion2011->CellAttributes() ?>><span id="el_gestion2011">
<input type="text" name="x_gestion2011" id="x_gestion2011" size="30" value="<?php echo $rubro->gestion2011->EditValue ?>"<?php echo $rubro->gestion2011->EditAttributes() ?>>
</span><?php echo $rubro->gestion2011->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($rubro->gestion2012->Visible) { // gestion2012 ?>
	<tr<?php echo $rubro->gestion2012->RowAttributes ?>>
		<td class="ewTableHeader">No Mers Gestion 2012<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $rubro->gestion2012->CellAttributes() ?>><span id="el_gestion2012">
<input type="text" name="x_gestion2012" id="x_gestion2012" size="30" value="<?php echo $rubro->gestion2012->EditValue ?>"<?php echo $rubro->gestion2012->EditAttributes() ?>>
</span><?php echo $rubro->gestion2012->CustomMsg ?></td>
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
class crubro_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'rubro';

	// Page Object Name
	var $PageObjName = 'rubro_edit';

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
	function crubro_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["rubro"] = new crubro();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $rubro;

		// Load key from QueryString
		if (@$_GET["idRubro"] <> "")
			$rubro->idRubro->setQueryStringValue($_GET["idRubro"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$rubro->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$rubro->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$rubro->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($rubro->idRubro->CurrentValue == "")
			$this->Page_Terminate("rubrolist.php"); // Invalid key, return to list
		switch ($rubro->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No se encontraron registros"); // No record found
					$this->Page_Terminate("rubrolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$rubro->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Update success
					$sReturnUrl = $rubro->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$rubro->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $rubro;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $rubro;
		$rubro->idRubro->setFormValue($objForm->GetValue("x_idRubro"));
		$rubro->rubro->setFormValue($objForm->GetValue("x_rubro"));
		$rubro->detalle->setFormValue($objForm->GetValue("x_detalle"));
		$rubro->gestion2009->setFormValue($objForm->GetValue("x_gestion2009"));
		$rubro->gestion2010->setFormValue($objForm->GetValue("x_gestion2010"));
		$rubro->gestion2011->setFormValue($objForm->GetValue("x_gestion2011"));
		$rubro->gestion2012->setFormValue($objForm->GetValue("x_gestion2012"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $rubro;
		$this->LoadRow();
		$rubro->idRubro->CurrentValue = $rubro->idRubro->FormValue;
		$rubro->rubro->CurrentValue = $rubro->rubro->FormValue;
		$rubro->detalle->CurrentValue = $rubro->detalle->FormValue;
		$rubro->gestion2009->CurrentValue = $rubro->gestion2009->FormValue;
		$rubro->gestion2010->CurrentValue = $rubro->gestion2010->FormValue;
		$rubro->gestion2011->CurrentValue = $rubro->gestion2011->FormValue;
		$rubro->gestion2012->CurrentValue = $rubro->gestion2012->FormValue;
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
		} elseif ($rubro->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idRubro
			$rubro->idRubro->EditCustomAttributes = "";
			$rubro->idRubro->EditValue = $rubro->idRubro->CurrentValue;
			$rubro->idRubro->CssStyle = "";
			$rubro->idRubro->CssClass = "";
			$rubro->idRubro->ViewCustomAttributes = "";

			// rubro
			$rubro->rubro->EditCustomAttributes = "";
			$rubro->rubro->EditValue = ew_HtmlEncode($rubro->rubro->CurrentValue);

			// detalle
			$rubro->detalle->EditCustomAttributes = "";
			$rubro->detalle->EditValue = ew_HtmlEncode($rubro->detalle->CurrentValue);

			// gestion2009
			$rubro->gestion2009->EditCustomAttributes = "";
			$rubro->gestion2009->EditValue = ew_HtmlEncode($rubro->gestion2009->CurrentValue);

			// gestion2010
			$rubro->gestion2010->EditCustomAttributes = "";
			$rubro->gestion2010->EditValue = ew_HtmlEncode($rubro->gestion2010->CurrentValue);

			// gestion2011
			$rubro->gestion2011->EditCustomAttributes = "";
			$rubro->gestion2011->EditValue = ew_HtmlEncode($rubro->gestion2011->CurrentValue);

			// gestion2012
			$rubro->gestion2012->EditCustomAttributes = "";
			$rubro->gestion2012->EditValue = ew_HtmlEncode($rubro->gestion2012->CurrentValue);

			// Edit refer script
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

	// Validate form
	function ValidateForm() {
		global $gsFormError, $rubro;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($rubro->rubro->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Rubro";
		}
		if (!ew_CheckInteger($rubro->gestion2009->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - No Mers Gestion 2009";
		}
		if ($rubro->gestion2010->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - No Mers Gestion 2010";
		}
		if (!ew_CheckInteger($rubro->gestion2010->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - No Mers Gestion 2010";
		}
		if ($rubro->gestion2011->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - No Mers Gestion 2011";
		}
		if (!ew_CheckInteger($rubro->gestion2011->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - No Mers Gestion 2011";
		}
		if ($rubro->gestion2012->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - No Mers Gestion 2012";
		}
		if (!ew_CheckInteger($rubro->gestion2012->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - No Mers Gestion 2012";
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
		global $conn, $Security, $rubro;
		$sFilter = $rubro->KeyFilter();
		$rubro->CurrentFilter = $sFilter;
		$sSql = $rubro->SQL();
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

			// Field idRubro
			// Field rubro

			$rubro->rubro->SetDbValueDef($rubro->rubro->CurrentValue, "");
			$rsnew['rubro'] =& $rubro->rubro->DbValue;

			// Field detalle
			$rubro->detalle->SetDbValueDef($rubro->detalle->CurrentValue, NULL);
			$rsnew['detalle'] =& $rubro->detalle->DbValue;

			// Field gestion2009
			$rubro->gestion2009->SetDbValueDef($rubro->gestion2009->CurrentValue, NULL);
			$rsnew['gestion2009'] =& $rubro->gestion2009->DbValue;

			// Field gestion2010
			$rubro->gestion2010->SetDbValueDef($rubro->gestion2010->CurrentValue, 0);
			$rsnew['gestion2010'] =& $rubro->gestion2010->DbValue;

			// Field gestion2011
			$rubro->gestion2011->SetDbValueDef($rubro->gestion2011->CurrentValue, 0);
			$rsnew['gestion2011'] =& $rubro->gestion2011->DbValue;

			// Field gestion2012
			$rubro->gestion2012->SetDbValueDef($rubro->gestion2012->CurrentValue, 0);
			$rsnew['gestion2012'] =& $rubro->gestion2012->DbValue;

			// Call Row Updating event
			$bUpdateRow = $rubro->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($rubro->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($rubro->CancelMessage <> "") {
					$this->setMessage($rubro->CancelMessage);
					$rubro->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$rubro->Row_Updated($rsold, $rsnew);
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
