<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "cronogramainfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php require_once('Connections/conexion.php'); ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php
// Define page object
$cronograma_add = new ccronograma_add();
$Page =& $cronograma_add;

// Page init processing
$cronograma_add->Page_Init();

// Page main processing
//$cronograma_add->Page_Main();
?>
<?php
if($_POST['btnAction']){
$fechaExplode=explode("/", $_POST['x_fechaInicio']);
$fechaInicio= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));

$fechaExplode=explode("/", $_POST['x_fechaFinal']);
$fechaFinal= date("Y-m-d", mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));

mysql_select_db($database_conexion, $conexion);
$query_cronogramaadd = "INSERT INTO cronograma VALUES ('','".$_POST['idConsultoria']."','".$fechaInicio."','".$fechaFinal."','".$_POST['x_detalle']."','".date("Y-m-d")."','1','0')";
mysql_query($query_cronogramaadd, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_maxcronograma = "SELECT max(idCronograma) as maxidCronograma FROM cronograma";
$mostrar_maxcronograma=mysql_query($query_maxcronograma, $conexion) or die(mysql_error());
$row_maxcronograma=mysql_fetch_assoc($mostrar_maxcronograma);
$maxidCronograma=$row_maxcronograma['maxidCronograma'];
//echo $_POST['idConsultoria'];
$contador=count($_POST['x_indicador']);
for($i=0;$i<$contador;$i++){
mysql_select_db($database_conexion, $conexion);
$query_indicador = "INSERT INTO indicador VALUES ('','".$maxidCronograma."','".$_POST['x_indicador'][$i]."')";
mysql_query($query_indicador, $conexion) or die(mysql_error());
}

$contador=count($_POST['x_meta']);
for($i=0;$i<$contador;$i++){
mysql_select_db($database_conexion, $conexion);
$query_meta = "INSERT INTO meta VALUES ('','".$maxidCronograma."','".$_POST['x_meta'][$i]."','".$_POST['x_metaAlcanzar'][$i]."','".$_POST['x_cabezera'][$i]."','".$_POST['x_archivoGeneral'][$i]."','1')";
mysql_query($query_meta, $conexion) or die(mysql_error());
}
}
$cronograma_add->Page_Main();
?>
<?php

//
// Page Class
//
class ccronograma_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'cronograma';

	// Page Object Name
	var $PageObjName = 'cronograma_add';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cronograma;
		if ($cronograma->UseTokenInUrl) $PageUrl .= "t=" . $cronograma->TableVar . "&"; // add page token
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
		global $objForm, $cronograma;
		if ($cronograma->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($cronograma->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cronograma->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccronograma_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["cronograma"] = new ccronograma();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cronograma', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $cronograma;
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
			$this->Page_Terminate("cronogramalist.php");
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
		global $objForm, $gsFormError, $cronograma;

		// Load key values from QueryString
//		$bCopy = TRUE;
//		if (@$_GET["idCronograma"] != "") {
//		  $cronograma->idCronograma->setQueryStringValue($_GET["idCronograma"]);
//		} else {
//		  $bCopy = FALSE;
//		}

//		// Create form object
//		$objForm = new cFormObj();
//
//		// Process form if post back
//		if (@$_POST["a_add"] <> "") {
//		   $cronograma->CurrentAction = $_POST["a_add"]; // Get form action
//		  $this->LoadFormValues(); // Load form values
//
//			// Validate Form
//			if (!$this->ValidateForm()) {
//				$cronograma->CurrentAction = "I"; // Form error, reset action
//				$this->setMessage($gsFormError);
//			}
//		} else { // Not post back
//		  if ($bCopy) {
//		    $cronograma->CurrentAction = "C"; // Copy Record
//		  } else {
//		    $cronograma->CurrentAction = "I"; // Display Blank Record
//		    $this->LoadDefaultValues(); // Load default values
//		  }
//		}

		// Perform action based on action code
		switch ("A") {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No se encontraron registros"); // No record found
		      $this->Page_Terminate("cronogramalist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$cronograma->SendEmail = TRUE; // Send email on add success
//		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Registro agregado satisfactoriamente"); // Set up success message
					$sReturnUrl = $cronograma->getReturnUrl();
					$this->Page_Terminate("cronogramalist.php?idConsultoria=".$_POST['idConsultoria']); // $sReturnUrl
//		    } else {
//		      $this->RestoreFormValues(); // Add failed, restore form values
//		    }
		}

		// Render row based on row type
		$cronograma->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $cronograma;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $cronograma;
		$cronograma->estado->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $cronograma;
		$cronograma->idConsultoria->setFormValue($objForm->GetValue("x_idConsultoria"));
		$cronograma->fechaInicio->setFormValue($objForm->GetValue("x_fechaInicio"));
		$cronograma->fechaInicio->CurrentValue = ew_UnFormatDateTime($cronograma->fechaInicio->CurrentValue, 7);
		$cronograma->fechaFinal->setFormValue($objForm->GetValue("x_fechaFinal"));
		$cronograma->fechaFinal->CurrentValue = ew_UnFormatDateTime($cronograma->fechaFinal->CurrentValue, 7);
		$cronograma->detalle->setFormValue($objForm->GetValue("x_detalle"));
		$cronograma->mesAnio->setFormValue($objForm->GetValue("x_mesAnio"));
		$cronograma->mesAnio->CurrentValue = ew_UnFormatDateTime($cronograma->mesAnio->CurrentValue, 7);
		$cronograma->estado->setFormValue($objForm->GetValue("x_estado"));
		$cronograma->idCronograma->setFormValue($objForm->GetValue("x_idCronograma"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $cronograma;
		$cronograma->idCronograma->CurrentValue = $cronograma->idCronograma->FormValue;
		$cronograma->idConsultoria->CurrentValue = $cronograma->idConsultoria->FormValue;
		$cronograma->fechaInicio->CurrentValue = $cronograma->fechaInicio->FormValue;
		$cronograma->fechaInicio->CurrentValue = ew_UnFormatDateTime($cronograma->fechaInicio->CurrentValue, 7);
		$cronograma->fechaFinal->CurrentValue = $cronograma->fechaFinal->FormValue;
		$cronograma->fechaFinal->CurrentValue = ew_UnFormatDateTime($cronograma->fechaFinal->CurrentValue, 7);
		$cronograma->detalle->CurrentValue = $cronograma->detalle->FormValue;
		$cronograma->mesAnio->CurrentValue = $cronograma->mesAnio->FormValue;
		$cronograma->mesAnio->CurrentValue = ew_UnFormatDateTime($cronograma->mesAnio->CurrentValue, 7);
		$cronograma->estado->CurrentValue = $cronograma->estado->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cronograma;
		$sFilter = $cronograma->KeyFilter();

		// Call Row Selecting event
		$cronograma->Row_Selecting($sFilter);

		// Load sql based on filter
		$cronograma->CurrentFilter = $sFilter;
		$sSql = $cronograma->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$cronograma->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $cronograma;
		$cronograma->idCronograma->setDbValue($rs->fields('idCronograma'));
		$cronograma->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$cronograma->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$cronograma->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$cronograma->detalle->setDbValue($rs->fields('detalle'));
		$cronograma->mesAnio->setDbValue($rs->fields('mesAnio'));
		$cronograma->estado->setDbValue($rs->fields('estado'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $cronograma;

		// Call Row_Rendering event
		$cronograma->Row_Rendering();

		// Common render codes for all row types
		// idConsultoria

		$cronograma->idConsultoria->CellCssStyle = "";
		$cronograma->idConsultoria->CellCssClass = "";

		// fechaInicio
		$cronograma->fechaInicio->CellCssStyle = "";
		$cronograma->fechaInicio->CellCssClass = "";

		// fechaFinal
		$cronograma->fechaFinal->CellCssStyle = "";
		$cronograma->fechaFinal->CellCssClass = "";

		// detalle
		$cronograma->detalle->CellCssStyle = "";
		$cronograma->detalle->CellCssClass = "";

		// mesAnio
		$cronograma->mesAnio->CellCssStyle = "";
		$cronograma->mesAnio->CellCssClass = "";

		// estado
		$cronograma->estado->CellCssStyle = "";
		$cronograma->estado->CellCssClass = "";
		if ($cronograma->RowType == EW_ROWTYPE_VIEW) { // View row

			// idCronograma
			$cronograma->idCronograma->ViewValue = $cronograma->idCronograma->CurrentValue;
			$cronograma->idCronograma->CssStyle = "";
			$cronograma->idCronograma->CssClass = "";
			$cronograma->idCronograma->ViewCustomAttributes = "";

			// idConsultoria
			$cronograma->idConsultoria->ViewValue = $cronograma->idConsultoria->CurrentValue;
			$cronograma->idConsultoria->CssStyle = "";
			$cronograma->idConsultoria->CssClass = "";
			$cronograma->idConsultoria->ViewCustomAttributes = "";

			// fechaInicio
			$cronograma->fechaInicio->ViewValue = $cronograma->fechaInicio->CurrentValue;
			$cronograma->fechaInicio->ViewValue = ew_FormatDateTime($cronograma->fechaInicio->ViewValue, 7);
			$cronograma->fechaInicio->CssStyle = "";
			$cronograma->fechaInicio->CssClass = "";
			$cronograma->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$cronograma->fechaFinal->ViewValue = $cronograma->fechaFinal->CurrentValue;
			$cronograma->fechaFinal->ViewValue = ew_FormatDateTime($cronograma->fechaFinal->ViewValue, 7);
			$cronograma->fechaFinal->CssStyle = "";
			$cronograma->fechaFinal->CssClass = "";
			$cronograma->fechaFinal->ViewCustomAttributes = "";

			// detalle
			$cronograma->detalle->ViewValue = $cronograma->detalle->CurrentValue;
			$cronograma->detalle->CssStyle = "";
			$cronograma->detalle->CssClass = "";
			$cronograma->detalle->ViewCustomAttributes = "";

			// mesAnio
			$cronograma->mesAnio->ViewValue = $cronograma->mesAnio->CurrentValue;
			$cronograma->mesAnio->ViewValue = ew_FormatDateTime($cronograma->mesAnio->ViewValue, 7);
			$cronograma->mesAnio->CssStyle = "";
			$cronograma->mesAnio->CssClass = "";
			$cronograma->mesAnio->ViewCustomAttributes = "";

			// estado
			if (strval($cronograma->estado->CurrentValue) <> "") {
				switch ($cronograma->estado->CurrentValue) {
					case "1":
						$cronograma->estado->ViewValue = "Habilitado";
						break;
					case "2":
						$cronograma->estado->ViewValue = "Desabilitado";
						break;
					case "3":
						$cronograma->estado->ViewValue = "Aprobado";
						break;
					default:
						$cronograma->estado->ViewValue = $cronograma->estado->CurrentValue;
				}
			} else {
				$cronograma->estado->ViewValue = NULL;
			}
			$cronograma->estado->CssStyle = "";
			$cronograma->estado->CssClass = "";
			$cronograma->estado->ViewCustomAttributes = "";

			// idConsultoria
			$cronograma->idConsultoria->HrefValue = "";

			// fechaInicio
			$cronograma->fechaInicio->HrefValue = "";

			// fechaFinal
			$cronograma->fechaFinal->HrefValue = "";

			// detalle
			$cronograma->detalle->HrefValue = "";

			// mesAnio
			$cronograma->mesAnio->HrefValue = "";

			// estado
			$cronograma->estado->HrefValue = "";
		} elseif ($cronograma->RowType == EW_ROWTYPE_ADD) { // Add row

			// idConsultoria
			$cronograma->idConsultoria->EditCustomAttributes = "";
			$cronograma->idConsultoria->EditValue = ew_HtmlEncode($cronograma->idConsultoria->CurrentValue);

			// fechaInicio
			$cronograma->fechaInicio->EditCustomAttributes = "";
			$cronograma->fechaInicio->EditValue = ew_HtmlEncode(ew_FormatDateTime($cronograma->fechaInicio->CurrentValue, 7));

			// fechaFinal
			$cronograma->fechaFinal->EditCustomAttributes = "";
			$cronograma->fechaFinal->EditValue = ew_HtmlEncode(ew_FormatDateTime($cronograma->fechaFinal->CurrentValue, 7));

			// detalle
			$cronograma->detalle->EditCustomAttributes = "";
			$cronograma->detalle->EditValue = ew_HtmlEncode($cronograma->detalle->CurrentValue);

			// mesAnio
			$cronograma->mesAnio->EditCustomAttributes = "";
			$cronograma->mesAnio->EditValue = ew_HtmlEncode(ew_FormatDateTime($cronograma->mesAnio->CurrentValue, 7));

			// estado
			$cronograma->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("1", "Habilitado");
			$arwrk[] = array("2", "Desabilitado");
			$arwrk[] = array("3", "Aprobado");
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$cronograma->estado->EditValue = $arwrk;
		}

		// Call Row Rendered event
		$cronograma->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $cronograma;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($cronograma->idConsultoria->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Id Consultoria";
		}
		if (!ew_CheckInteger($cronograma->idConsultoria->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Id Consultoria";
		}
		if ($cronograma->fechaInicio->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Inicio";
		}
		if (!ew_CheckEuroDate($cronograma->fechaInicio->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Inicio";
		}
		if ($cronograma->fechaFinal->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Final";
		}
		if (!ew_CheckEuroDate($cronograma->fechaFinal->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Final";
		}
		if ($cronograma->detalle->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Detalle";
		}
		if ($cronograma->mesAnio->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Mes Anio";
		}
		if (!ew_CheckEuroDate($cronograma->mesAnio->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Mes Anio";
		}
		if ($cronograma->estado->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Estado";
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
		global $conn, $Security, $cronograma;
		$rsnew = array();

		// Field idConsultoria
		$cronograma->idConsultoria->SetDbValueDef($cronograma->idConsultoria->CurrentValue, 0);
		$rsnew['idConsultoria'] =& $cronograma->idConsultoria->DbValue;

		// Field fechaInicio
		$cronograma->fechaInicio->SetDbValueDef(ew_UnFormatDateTime($cronograma->fechaInicio->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fechaInicio'] =& $cronograma->fechaInicio->DbValue;

		// Field fechaFinal
		$cronograma->fechaFinal->SetDbValueDef(ew_UnFormatDateTime($cronograma->fechaFinal->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fechaFinal'] =& $cronograma->fechaFinal->DbValue;

		// Field detalle
		$cronograma->detalle->SetDbValueDef($cronograma->detalle->CurrentValue, "");
		$rsnew['detalle'] =& $cronograma->detalle->DbValue;

		// Field mesAnio
		$cronograma->mesAnio->SetDbValueDef(ew_UnFormatDateTime($cronograma->mesAnio->CurrentValue, 7), ew_CurrentDate());
		$rsnew['mesAnio'] =& $cronograma->mesAnio->DbValue;

		// Field estado
		$cronograma->estado->SetDbValueDef($cronograma->estado->CurrentValue, 0);
		$rsnew['estado'] =& $cronograma->estado->DbValue;

		// Call Row Inserting event
		$bInsertRow = $cronograma->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($cronograma->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($cronograma->CancelMessage <> "") {
				$this->setMessage($cronograma->CancelMessage);
				$cronograma->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$cronograma->idCronograma->setDbValue($conn->Insert_ID());
			$rsnew['idCronograma'] =& $cronograma->idCronograma->DbValue;

			// Call Row Inserted event
			$cronograma->Row_Inserted($rsnew);
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
