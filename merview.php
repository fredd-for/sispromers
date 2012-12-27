<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "merinfo.php" ?>
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
$mer_view = new cmer_view();
$Page =& $mer_view;

// Page init processing
$mer_view->Page_Init();

// Page main processing
$mer_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($mer->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var mer_view = new ew_Page("mer_view");

// page properties
mer_view.PageID = "view"; // page ID
var EW_PAGE_ID = mer_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
mer_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
mer_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mer_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Mer
<br><br>
<?php if ($mer->Export == "") { ?>
<a href="merlist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $mer->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $mer->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $mer->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $mer_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($mer->idMer->Visible) { // idMer ?>
	<tr<?php echo $mer->idMer->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $mer->idMer->CellAttributes() ?>>
<div<?php echo $mer->idMer->ViewAttributes() ?>><?php echo $mer->idMer->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->idRegional->Visible) { // idRegional ?>
	<tr<?php echo $mer->idRegional->RowAttributes ?>>
		<td class="ewTableHeader">Regional</td>
		<td<?php echo $mer->idRegional->CellAttributes() ?>>
<div<?php echo $mer->idRegional->ViewAttributes() ?>><?php echo $mer->idRegional->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->idDepartamento->Visible) { // idDepartamento ?>
	<tr<?php echo $mer->idDepartamento->RowAttributes ?>>
		<td class="ewTableHeader">Departamento</td>
		<td<?php echo $mer->idDepartamento->CellAttributes() ?>>
<div<?php echo $mer->idDepartamento->ViewAttributes() ?>><?php echo $mer->idDepartamento->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->idMunicipio->Visible) { // idMunicipio ?>
	<tr<?php echo $mer->idMunicipio->RowAttributes ?>>
		<td class="ewTableHeader">Municipio</td>
		<td<?php echo $mer->idMunicipio->CellAttributes() ?>>
<div<?php echo $mer->idMunicipio->ViewAttributes() ?>><?php echo $mer->idMunicipio->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->idComunidad->Visible) { // idComunidad ?>
	<tr<?php echo $mer->idComunidad->RowAttributes ?>>
		<td class="ewTableHeader">Comunidad</td>
		<td<?php echo $mer->idComunidad->CellAttributes() ?>>
<div<?php echo $mer->idComunidad->ViewAttributes() ?>><?php echo $mer->idComunidad->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->idRubro->Visible) { // idRubro ?>
	<tr<?php echo $mer->idRubro->RowAttributes ?>>
		<td class="ewTableHeader">Rubro</td>
		<td<?php echo $mer->idRubro->CellAttributes() ?>>
<div<?php echo $mer->idRubro->ViewAttributes() ?>><?php echo $mer->idRubro->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->mer->Visible) { // mer ?>
	<tr<?php echo $mer->mer->RowAttributes ?>>
		<td class="ewTableHeader">Nombre de la Mer</td>
		<td<?php echo $mer->mer->CellAttributes() ?>>
<div<?php echo $mer->mer->ViewAttributes() ?>><?php echo $mer->mer->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->unidadProductivaDedica->Visible) { // unidadProductivaDedica ?>
	<tr<?php echo $mer->unidadProductivaDedica->RowAttributes ?>>
		<td class="ewTableHeader">La Unidad Productiva Dedica a</td>
		<td<?php echo $mer->unidadProductivaDedica->CellAttributes() ?>>
<div<?php echo $mer->unidadProductivaDedica->ViewAttributes() ?>><?php echo $mer->unidadProductivaDedica->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->codigo->Visible) { // codigo ?>
	<tr<?php echo $mer->codigo->RowAttributes ?>>
		<td class="ewTableHeader">Codigo</td>
		<td<?php echo $mer->codigo->CellAttributes() ?>>
<div<?php echo $mer->codigo->ViewAttributes() ?>><?php echo $mer->codigo->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->numeroSocios->Visible) { // numeroSocios ?>
	<tr<?php echo $mer->numeroSocios->RowAttributes ?>>
		<td class="ewTableHeader">Numero de Socios</td>
		<td<?php echo $mer->numeroSocios->CellAttributes() ?>>
<div<?php echo $mer->numeroSocios->ViewAttributes() ?>><?php echo $mer->numeroSocios->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->direccion->Visible) { // direccion ?>
	<tr<?php echo $mer->direccion->RowAttributes ?>>
		<td class="ewTableHeader">Direccion</td>
		<td<?php echo $mer->direccion->CellAttributes() ?>>
<div<?php echo $mer->direccion->ViewAttributes() ?>><?php echo $mer->direccion->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->zona->Visible) { // zona ?>
	<tr<?php echo $mer->zona->RowAttributes ?>>
		<td class="ewTableHeader">Zona</td>
		<td<?php echo $mer->zona->CellAttributes() ?>>
<div<?php echo $mer->zona->ViewAttributes() ?>><?php echo $mer->zona->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->referencia->Visible) { // referencia ?>
	<tr<?php echo $mer->referencia->RowAttributes ?>>
		<td class="ewTableHeader">Referencia</td>
		<td<?php echo $mer->referencia->CellAttributes() ?>>
<div<?php echo $mer->referencia->ViewAttributes() ?>><?php echo $mer->referencia->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->refTelefonica->Visible) { // refTelefonica ?>
	<tr<?php echo $mer->refTelefonica->RowAttributes ?>>
		<td class="ewTableHeader">Ref Telefonica</td>
		<td<?php echo $mer->refTelefonica->CellAttributes() ?>>
<div<?php echo $mer->refTelefonica->ViewAttributes() ?>><?php echo $mer->refTelefonica->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->refCelular->Visible) { // refCelular ?>
	<tr<?php echo $mer->refCelular->RowAttributes ?>>
		<td class="ewTableHeader">Ref Celular</td>
		<td<?php echo $mer->refCelular->CellAttributes() ?>>
<div<?php echo $mer->refCelular->ViewAttributes() ?>><?php echo $mer->refCelular->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->fechaInicio->Visible) { // fechaInicio ?>
	<tr<?php echo $mer->fechaInicio->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Inicio</td>
		<td<?php echo $mer->fechaInicio->CellAttributes() ?>>
<div<?php echo $mer->fechaInicio->ViewAttributes() ?>><?php echo $mer->fechaInicio->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->fechaFinal->Visible) { // fechaFinal ?>
	<tr<?php echo $mer->fechaFinal->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Final</td>
		<td<?php echo $mer->fechaFinal->CellAttributes() ?>>
<div<?php echo $mer->fechaFinal->ViewAttributes() ?>><?php echo $mer->fechaFinal->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mer->gestion->Visible) { // gestion ?>
	<tr<?php echo $mer->gestion->RowAttributes ?>>
		<td class="ewTableHeader">Gestion</td>
		<td<?php echo $mer->gestion->CellAttributes() ?>>
<div<?php echo $mer->gestion->ViewAttributes() ?>><?php echo $mer->gestion->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($mer->Export == "") { ?>
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
class cmer_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'mer';

	// Page Object Name
	var $PageObjName = 'mer_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $mer;
		if ($mer->UseTokenInUrl) $PageUrl .= "t=" . $mer->TableVar . "&"; // add page token
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
		global $objForm, $mer;
		if ($mer->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($mer->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($mer->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cmer_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["mer"] = new cmer();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'mer', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $mer;
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
			$this->Page_Terminate("merlist.php");
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
		global $mer;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idMer"] <> "") {
				$mer->idMer->setQueryStringValue($_GET["idMer"]);
			} else {
				$sReturnUrl = "merlist.php"; // Return to list
			}

			// Get action
			$mer->CurrentAction = "I"; // Display form
			switch ($mer->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "merlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "merlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$mer->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $mer;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$mer->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$mer->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $mer->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$mer->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$mer->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$mer->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $mer;
		$sFilter = $mer->KeyFilter();

		// Call Row Selecting event
		$mer->Row_Selecting($sFilter);

		// Load sql based on filter
		$mer->CurrentFilter = $sFilter;
		$sSql = $mer->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$mer->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $mer;
		$mer->idMer->setDbValue($rs->fields('idMer'));
		$mer->idRegional->setDbValue($rs->fields('idRegional'));
		$mer->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$mer->idMunicipio->setDbValue($rs->fields('idMunicipio'));
		$mer->idComunidad->setDbValue($rs->fields('idComunidad'));
		$mer->idRubro->setDbValue($rs->fields('idRubro'));
		$mer->mer->setDbValue($rs->fields('mer'));
		$mer->unidadProductivaDedica->setDbValue($rs->fields('unidadProductivaDedica'));
		$mer->codigo->setDbValue($rs->fields('codigo'));
		$mer->numeroSocios->setDbValue($rs->fields('numeroSocios'));
		$mer->direccion->setDbValue($rs->fields('direccion'));
		$mer->zona->setDbValue($rs->fields('zona'));
		$mer->referencia->setDbValue($rs->fields('referencia'));
		$mer->refTelefonica->setDbValue($rs->fields('refTelefonica'));
		$mer->refCelular->setDbValue($rs->fields('refCelular'));
		$mer->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$mer->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$mer->gestion->setDbValue($rs->fields('gestion'));
		$mer->estado->setDbValue($rs->fields('estado'));
		$mer->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$mer->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $mer;

		// Call Row_Rendering event
		$mer->Row_Rendering();

		// Common render codes for all row types
		// idMer

		$mer->idMer->CellCssStyle = "";
		$mer->idMer->CellCssClass = "";

		// idRegional
		$mer->idRegional->CellCssStyle = "";
		$mer->idRegional->CellCssClass = "";

		// idDepartamento
		$mer->idDepartamento->CellCssStyle = "";
		$mer->idDepartamento->CellCssClass = "";

		// idMunicipio
		$mer->idMunicipio->CellCssStyle = "";
		$mer->idMunicipio->CellCssClass = "";

		// idComunidad
		$mer->idComunidad->CellCssStyle = "";
		$mer->idComunidad->CellCssClass = "";

		// idRubro
		$mer->idRubro->CellCssStyle = "";
		$mer->idRubro->CellCssClass = "";

		// mer
		$mer->mer->CellCssStyle = "";
		$mer->mer->CellCssClass = "";

		// unidadProductivaDedica
		$mer->unidadProductivaDedica->CellCssStyle = "";
		$mer->unidadProductivaDedica->CellCssClass = "";

		// codigo
		$mer->codigo->CellCssStyle = "";
		$mer->codigo->CellCssClass = "";

		// numeroSocios
		$mer->numeroSocios->CellCssStyle = "";
		$mer->numeroSocios->CellCssClass = "";

		// direccion
		$mer->direccion->CellCssStyle = "";
		$mer->direccion->CellCssClass = "";

		// zona
		$mer->zona->CellCssStyle = "";
		$mer->zona->CellCssClass = "";

		// referencia
		$mer->referencia->CellCssStyle = "";
		$mer->referencia->CellCssClass = "";

		// refTelefonica
		$mer->refTelefonica->CellCssStyle = "";
		$mer->refTelefonica->CellCssClass = "";

		// refCelular
		$mer->refCelular->CellCssStyle = "";
		$mer->refCelular->CellCssClass = "";

		// fechaInicio
		$mer->fechaInicio->CellCssStyle = "";
		$mer->fechaInicio->CellCssClass = "";

		// fechaFinal
		$mer->fechaFinal->CellCssStyle = "";
		$mer->fechaFinal->CellCssClass = "";

		// gestion
		$mer->gestion->CellCssStyle = "";
		$mer->gestion->CellCssClass = "";
		if ($mer->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$mer->idMer->ViewValue = $mer->idMer->CurrentValue;
			$mer->idMer->CssStyle = "";
			$mer->idMer->CssClass = "";
			$mer->idMer->ViewCustomAttributes = "";

			// idRegional
			if (strval($mer->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($mer->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$mer->idRegional->ViewValue = $mer->idRegional->CurrentValue;
				}
			} else {
				$mer->idRegional->ViewValue = NULL;
			}
			$mer->idRegional->CssStyle = "";
			$mer->idRegional->CssClass = "";
			$mer->idRegional->ViewCustomAttributes = "";

			// idDepartamento
			if (strval($mer->idDepartamento->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `departamento` FROM `departamento` WHERE `idDepartamento` = " . ew_AdjustSql($mer->idDepartamento->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `departamento` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idDepartamento->ViewValue = $rswrk->fields('departamento');
					$rswrk->Close();
				} else {
					$mer->idDepartamento->ViewValue = $mer->idDepartamento->CurrentValue;
				}
			} else {
				$mer->idDepartamento->ViewValue = NULL;
			}
			$mer->idDepartamento->CssStyle = "";
			$mer->idDepartamento->CssClass = "";
			$mer->idDepartamento->ViewCustomAttributes = "";

			// idMunicipio
			if (strval($mer->idMunicipio->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `municipio` FROM `municipio` WHERE `idMunicipio` = " . ew_AdjustSql($mer->idMunicipio->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `municipio` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idMunicipio->ViewValue = $rswrk->fields('municipio');
					$rswrk->Close();
				} else {
					$mer->idMunicipio->ViewValue = $mer->idMunicipio->CurrentValue;
				}
			} else {
				$mer->idMunicipio->ViewValue = NULL;
			}
			$mer->idMunicipio->CssStyle = "";
			$mer->idMunicipio->CssClass = "";
			$mer->idMunicipio->ViewCustomAttributes = "";

			// idComunidad
			if (strval($mer->idComunidad->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `comunidad` FROM `comunidad` WHERE `idComunidad` = " . ew_AdjustSql($mer->idComunidad->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `comunidad` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idComunidad->ViewValue = $rswrk->fields('comunidad');
					$rswrk->Close();
				} else {
					$mer->idComunidad->ViewValue = $mer->idComunidad->CurrentValue;
				}
			} else {
				$mer->idComunidad->ViewValue = NULL;
			}
			$mer->idComunidad->CssStyle = "";
			$mer->idComunidad->CssClass = "";
			$mer->idComunidad->ViewCustomAttributes = "";

			// idRubro
			if (strval($mer->idRubro->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `rubro` FROM `rubro` WHERE `idRubro` = " . ew_AdjustSql($mer->idRubro->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `rubro` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$mer->idRubro->ViewValue = $rswrk->fields('rubro');
					$rswrk->Close();
				} else {
					$mer->idRubro->ViewValue = $mer->idRubro->CurrentValue;
				}
			} else {
				$mer->idRubro->ViewValue = NULL;
			}
			$mer->idRubro->CssStyle = "";
			$mer->idRubro->CssClass = "";
			$mer->idRubro->ViewCustomAttributes = "";

			// mer
			$mer->mer->ViewValue = $mer->mer->CurrentValue;
			$mer->mer->CssStyle = "";
			$mer->mer->CssClass = "";
			$mer->mer->ViewCustomAttributes = "";

			// unidadProductivaDedica
			$mer->unidadProductivaDedica->ViewValue = $mer->unidadProductivaDedica->CurrentValue;
			$mer->unidadProductivaDedica->CssStyle = "";
			$mer->unidadProductivaDedica->CssClass = "";
			$mer->unidadProductivaDedica->ViewCustomAttributes = "";

			// codigo
			$mer->codigo->ViewValue = $mer->codigo->CurrentValue;
			$mer->codigo->CssStyle = "";
			$mer->codigo->CssClass = "";
			$mer->codigo->ViewCustomAttributes = "";

			// numeroSocios
			$mer->numeroSocios->ViewValue = $mer->numeroSocios->CurrentValue;
			$mer->numeroSocios->CssStyle = "";
			$mer->numeroSocios->CssClass = "";
			$mer->numeroSocios->ViewCustomAttributes = "";

			// direccion
			$mer->direccion->ViewValue = $mer->direccion->CurrentValue;
			$mer->direccion->CssStyle = "";
			$mer->direccion->CssClass = "";
			$mer->direccion->ViewCustomAttributes = "";

			// zona
			$mer->zona->ViewValue = $mer->zona->CurrentValue;
			$mer->zona->CssStyle = "";
			$mer->zona->CssClass = "";
			$mer->zona->ViewCustomAttributes = "";

			// referencia
			$mer->referencia->ViewValue = $mer->referencia->CurrentValue;
			$mer->referencia->CssStyle = "";
			$mer->referencia->CssClass = "";
			$mer->referencia->ViewCustomAttributes = "";

			// refTelefonica
			$mer->refTelefonica->ViewValue = $mer->refTelefonica->CurrentValue;
			$mer->refTelefonica->CssStyle = "";
			$mer->refTelefonica->CssClass = "";
			$mer->refTelefonica->ViewCustomAttributes = "";

			// refCelular
			$mer->refCelular->ViewValue = $mer->refCelular->CurrentValue;
			$mer->refCelular->CssStyle = "";
			$mer->refCelular->CssClass = "";
			$mer->refCelular->ViewCustomAttributes = "";

			// fechaInicio
			$mer->fechaInicio->ViewValue = $mer->fechaInicio->CurrentValue;
			$mer->fechaInicio->ViewValue = ew_FormatDateTime($mer->fechaInicio->ViewValue, 7);
			$mer->fechaInicio->CssStyle = "";
			$mer->fechaInicio->CssClass = "";
			$mer->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$mer->fechaFinal->ViewValue = $mer->fechaFinal->CurrentValue;
			$mer->fechaFinal->ViewValue = ew_FormatDateTime($mer->fechaFinal->ViewValue, 7);
			$mer->fechaFinal->CssStyle = "";
			$mer->fechaFinal->CssClass = "";
			$mer->fechaFinal->ViewCustomAttributes = "";

			// gestion
			$mer->gestion->ViewValue = $mer->gestion->CurrentValue;
			$mer->gestion->CssStyle = "";
			$mer->gestion->CssClass = "";
			$mer->gestion->ViewCustomAttributes = "";

			// idMer
			$mer->idMer->HrefValue = "";

			// idRegional
			$mer->idRegional->HrefValue = "";

			// idDepartamento
			$mer->idDepartamento->HrefValue = "";

			// idMunicipio
			$mer->idMunicipio->HrefValue = "";

			// idComunidad
			$mer->idComunidad->HrefValue = "";

			// idRubro
			$mer->idRubro->HrefValue = "";

			// mer
			$mer->mer->HrefValue = "";

			// unidadProductivaDedica
			$mer->unidadProductivaDedica->HrefValue = "";

			// codigo
			$mer->codigo->HrefValue = "";

			// numeroSocios
			$mer->numeroSocios->HrefValue = "";

			// direccion
			$mer->direccion->HrefValue = "";

			// zona
			$mer->zona->HrefValue = "";

			// referencia
			$mer->referencia->HrefValue = "";

			// refTelefonica
			$mer->refTelefonica->HrefValue = "";

			// refCelular
			$mer->refCelular->HrefValue = "";

			// fechaInicio
			$mer->fechaInicio->HrefValue = "";

			// fechaFinal
			$mer->fechaFinal->HrefValue = "";

			// gestion
			$mer->gestion->HrefValue = "";
		}

		// Call Row Rendered event
		$mer->Row_Rendered();
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
