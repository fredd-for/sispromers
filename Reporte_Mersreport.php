<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php

// PHPMaker 6 configuration for Table Reporte Mers
$Reporte_Mers = NULL; // Initialize table object

// Define table class
class cReporte_Mers {

	// Define table level constants
	var $TableVar;
	var $TableName;
	var $SelectLimit = FALSE;
	var $idMer;
	var $idRegional;
	var $idDepartamento;
	var $idMunicipio;
	var $idComunidad;
	var $idRubro;
	var $mer;
	var $unidadProductivaDedica;
	var $codigo;
	var $numeroSocios;
	var $direccion;
	var $zona;
	var $referencia;
	var $refTelefonica;
	var $refCelular;
	var $fechaInicio;
	var $fechaFinal;
	var $gestion;
	var $estado;
	var $fechaCreacion;
	var $fechaModificacion;
	var $fields = array();
	var $UseTokenInUrl = EW_USE_TOKEN_IN_URL;
	var $Export; // Export
	var $ExportOriginalValue = EW_EXPORT_ORIGINAL_VALUE;
	var	$ExportAll = EW_EXPORT_ALL;
	var $SendEmail; // Send Email
	var $TableCustomInnerHtml; // Custom Inner Html

	function cReporte_Mers() {
		$this->TableVar = "Reporte_Mers";
		$this->TableName = "Reporte Mers";
		$this->idMer = new cField('Reporte_Mers', 'x_idMer', 'idMer', "`idMer`", 3, -1, FALSE);
		$this->fields['idMer'] =& $this->idMer;
		$this->idRegional = new cField('Reporte_Mers', 'x_idRegional', 'idRegional', "`idRegional`", 3, -1, FALSE);
		$this->fields['idRegional'] =& $this->idRegional;
		$this->idDepartamento = new cField('Reporte_Mers', 'x_idDepartamento', 'idDepartamento', "`idDepartamento`", 3, -1, FALSE);
		$this->fields['idDepartamento'] =& $this->idDepartamento;
		$this->idMunicipio = new cField('Reporte_Mers', 'x_idMunicipio', 'idMunicipio', "`idMunicipio`", 3, -1, FALSE);
		$this->fields['idMunicipio'] =& $this->idMunicipio;
		$this->idComunidad = new cField('Reporte_Mers', 'x_idComunidad', 'idComunidad', "`idComunidad`", 3, -1, FALSE);
		$this->fields['idComunidad'] =& $this->idComunidad;
		$this->idRubro = new cField('Reporte_Mers', 'x_idRubro', 'idRubro', "`idRubro`", 3, -1, FALSE);
		$this->fields['idRubro'] =& $this->idRubro;
		$this->mer = new cField('Reporte_Mers', 'x_mer', 'mer', "`mer`", 200, -1, FALSE);
		$this->fields['mer'] =& $this->mer;
		$this->unidadProductivaDedica = new cField('Reporte_Mers', 'x_unidadProductivaDedica', 'unidadProductivaDedica', "`unidadProductivaDedica`", 200, -1, FALSE);
		$this->fields['unidadProductivaDedica'] =& $this->unidadProductivaDedica;
		$this->codigo = new cField('Reporte_Mers', 'x_codigo', 'codigo', "`codigo`", 200, -1, FALSE);
		$this->fields['codigo'] =& $this->codigo;
		$this->numeroSocios = new cField('Reporte_Mers', 'x_numeroSocios', 'numeroSocios', "`numeroSocios`", 3, -1, FALSE);
		$this->fields['numeroSocios'] =& $this->numeroSocios;
		$this->direccion = new cField('Reporte_Mers', 'x_direccion', 'direccion', "`direccion`", 200, -1, FALSE);
		$this->fields['direccion'] =& $this->direccion;
		$this->zona = new cField('Reporte_Mers', 'x_zona', 'zona', "`zona`", 200, -1, FALSE);
		$this->fields['zona'] =& $this->zona;
		$this->referencia = new cField('Reporte_Mers', 'x_referencia', 'referencia', "`referencia`", 200, -1, FALSE);
		$this->fields['referencia'] =& $this->referencia;
		$this->refTelefonica = new cField('Reporte_Mers', 'x_refTelefonica', 'refTelefonica', "`refTelefonica`", 3, -1, FALSE);
		$this->fields['refTelefonica'] =& $this->refTelefonica;
		$this->refCelular = new cField('Reporte_Mers', 'x_refCelular', 'refCelular', "`refCelular`", 3, -1, FALSE);
		$this->fields['refCelular'] =& $this->refCelular;
		$this->fechaInicio = new cField('Reporte_Mers', 'x_fechaInicio', 'fechaInicio', "`fechaInicio`", 133, 7, FALSE);
		$this->fields['fechaInicio'] =& $this->fechaInicio;
		$this->fechaFinal = new cField('Reporte_Mers', 'x_fechaFinal', 'fechaFinal', "`fechaFinal`", 133, 7, FALSE);
		$this->fields['fechaFinal'] =& $this->fechaFinal;
		$this->gestion = new cField('Reporte_Mers', 'x_gestion', 'gestion', "`gestion`", 3, -1, FALSE);
		$this->fields['gestion'] =& $this->gestion;
		$this->estado = new cField('Reporte_Mers', 'x_estado', 'estado', "`estado`", 3, -1, FALSE);
		$this->fields['estado'] =& $this->estado;
		$this->fechaCreacion = new cField('Reporte_Mers', 'x_fechaCreacion', 'fechaCreacion', "`fechaCreacion`", 133, 7, FALSE);
		$this->fields['fechaCreacion'] =& $this->fechaCreacion;
		$this->fechaModificacion = new cField('Reporte_Mers', 'x_fechaModificacion', 'fechaModificacion', "`fechaModificacion`", 133, 7, FALSE);
		$this->fields['fechaModificacion'] =& $this->fechaModificacion;
	}

	// Report Detail Level SQL
	function SqlDetailSelect() { // Select
		return "SELECT * FROM `mer`";
	}

	function SqlDetailWhere() { // Where
		return "";
	}

	function SqlDetailGroupBy() { // Group By
		return "";
	}

	function SqlDetailHaving() { // Having
		return "";
	}

	function SqlDetailOrderBy() { // Order By
		return "";
	}

	// SQL variables
	var $CurrentFilter; // Current filter
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type

	// Return report detail SQL
	function DetailSQL() {
		$sFilter = $this->CurrentFilter;
		$sSort = "";
		return ew_BuildSelectSql($this->SqlDetailSelect(), $this->SqlDetailWhere(),
			$this->SqlDetailGroupBy(), $this->SqlDetailHaving(),
			$this->SqlDetailOrderBy(), $sFilter, $sSort);
	}

	// Return url
	function getReturnUrl() {

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] <> "") {
			return $_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL];
		} else {
			return "Reporte_Mersreport.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("", $this->UrlParm());
	}

	// Add url
	function AddUrl() {
		$AddUrl = "";
		$sUrlParm = $this->UrlParm();
		if ($sUrlParm <> "")
			$AddUrl .= "?" . $sUrlParm;
		return $AddUrl;
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("", $this->UrlParm());
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("", $this->UrlParm());
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("", $this->UrlParm());
	}

	// Key url
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idMer->CurrentValue)) {
			$sUrl .= "idMer=" . urlencode($this->idMer->CurrentValue);
		} else {
			return "javascript:alert('Llave incorrecta es nula');";
		}
		return $sUrl;
	}

	// Sort Url
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			($fld->FldType == 205)) { // Unsortable data type
			return "";
		} else {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		}
	}

	// URL parm
	function UrlParm($parm = "") {
		$UrlParm = ($this->UseTokenInUrl) ? "t=Reporte_Mers" : "";
		if ($parm <> "") {
			if ($UrlParm <> "")
				$UrlParm .= "&";
			$UrlParm .= $parm;
		}
		return $UrlParm;
	}

	// Function LoadRs
	// - Load rows based on filter
	function LoadRs($sFilter) {
		global $conn;

		// Set up filter (Sql Where Clause) and get Return Sql
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		return $conn->Execute($sSql);
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->idMer->setDbValue($rs->fields('idMer'));
		$this->idRegional->setDbValue($rs->fields('idRegional'));
		$this->idDepartamento->setDbValue($rs->fields('idDepartamento'));
		$this->idMunicipio->setDbValue($rs->fields('idMunicipio'));
		$this->idComunidad->setDbValue($rs->fields('idComunidad'));
		$this->idRubro->setDbValue($rs->fields('idRubro'));
		$this->mer->setDbValue($rs->fields('mer'));
		$this->unidadProductivaDedica->setDbValue($rs->fields('unidadProductivaDedica'));
		$this->codigo->setDbValue($rs->fields('codigo'));
		$this->numeroSocios->setDbValue($rs->fields('numeroSocios'));
		$this->direccion->setDbValue($rs->fields('direccion'));
		$this->zona->setDbValue($rs->fields('zona'));
		$this->referencia->setDbValue($rs->fields('referencia'));
		$this->refTelefonica->setDbValue($rs->fields('refTelefonica'));
		$this->refCelular->setDbValue($rs->fields('refCelular'));
		$this->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$this->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$this->gestion->setDbValue($rs->fields('gestion'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$this->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// idMer
		$Reporte_Mers->idMer->ViewValue = $Reporte_Mers->idMer->CurrentValue;
		$Reporte_Mers->idMer->CssStyle = "";
		$Reporte_Mers->idMer->CssClass = "";
		$Reporte_Mers->idMer->ViewCustomAttributes = "";

		// mer
		$Reporte_Mers->mer->ViewValue = $Reporte_Mers->mer->CurrentValue;
		$Reporte_Mers->mer->CssStyle = "";
		$Reporte_Mers->mer->CssClass = "";
		$Reporte_Mers->mer->ViewCustomAttributes = "";

		// unidadProductivaDedica
		$Reporte_Mers->unidadProductivaDedica->ViewValue = $Reporte_Mers->unidadProductivaDedica->CurrentValue;
		$Reporte_Mers->unidadProductivaDedica->CssStyle = "";
		$Reporte_Mers->unidadProductivaDedica->CssClass = "";
		$Reporte_Mers->unidadProductivaDedica->ViewCustomAttributes = "";

		// codigo
		$Reporte_Mers->codigo->ViewValue = $Reporte_Mers->codigo->CurrentValue;
		$Reporte_Mers->codigo->CssStyle = "";
		$Reporte_Mers->codigo->CssClass = "";
		$Reporte_Mers->codigo->ViewCustomAttributes = "";

		// numeroSocios
		$Reporte_Mers->numeroSocios->ViewValue = $Reporte_Mers->numeroSocios->CurrentValue;
		$Reporte_Mers->numeroSocios->CssStyle = "";
		$Reporte_Mers->numeroSocios->CssClass = "";
		$Reporte_Mers->numeroSocios->ViewCustomAttributes = "";

		// direccion
		$Reporte_Mers->direccion->ViewValue = $Reporte_Mers->direccion->CurrentValue;
		$Reporte_Mers->direccion->CssStyle = "";
		$Reporte_Mers->direccion->CssClass = "";
		$Reporte_Mers->direccion->ViewCustomAttributes = "";

		// zona
		$Reporte_Mers->zona->ViewValue = $Reporte_Mers->zona->CurrentValue;
		$Reporte_Mers->zona->CssStyle = "";
		$Reporte_Mers->zona->CssClass = "";
		$Reporte_Mers->zona->ViewCustomAttributes = "";

		// referencia
		$Reporte_Mers->referencia->ViewValue = $Reporte_Mers->referencia->CurrentValue;
		$Reporte_Mers->referencia->CssStyle = "";
		$Reporte_Mers->referencia->CssClass = "";
		$Reporte_Mers->referencia->ViewCustomAttributes = "";

		// refTelefonica
		$Reporte_Mers->refTelefonica->ViewValue = $Reporte_Mers->refTelefonica->CurrentValue;
		$Reporte_Mers->refTelefonica->CssStyle = "";
		$Reporte_Mers->refTelefonica->CssClass = "";
		$Reporte_Mers->refTelefonica->ViewCustomAttributes = "";

		// refCelular
		$Reporte_Mers->refCelular->ViewValue = $Reporte_Mers->refCelular->CurrentValue;
		$Reporte_Mers->refCelular->CssStyle = "";
		$Reporte_Mers->refCelular->CssClass = "";
		$Reporte_Mers->refCelular->ViewCustomAttributes = "";

		// fechaInicio
		$Reporte_Mers->fechaInicio->ViewValue = $Reporte_Mers->fechaInicio->CurrentValue;
		$Reporte_Mers->fechaInicio->ViewValue = ew_FormatDateTime($Reporte_Mers->fechaInicio->ViewValue, 7);
		$Reporte_Mers->fechaInicio->CssStyle = "";
		$Reporte_Mers->fechaInicio->CssClass = "";
		$Reporte_Mers->fechaInicio->ViewCustomAttributes = "";

		// fechaFinal
		$Reporte_Mers->fechaFinal->ViewValue = $Reporte_Mers->fechaFinal->CurrentValue;
		$Reporte_Mers->fechaFinal->ViewValue = ew_FormatDateTime($Reporte_Mers->fechaFinal->ViewValue, 7);
		$Reporte_Mers->fechaFinal->CssStyle = "";
		$Reporte_Mers->fechaFinal->CssClass = "";
		$Reporte_Mers->fechaFinal->ViewCustomAttributes = "";

		// gestion
		$Reporte_Mers->gestion->ViewValue = $Reporte_Mers->gestion->CurrentValue;
		$Reporte_Mers->gestion->CssStyle = "";
		$Reporte_Mers->gestion->CssClass = "";
		$Reporte_Mers->gestion->ViewCustomAttributes = "";

		// estado
		if (strval($Reporte_Mers->estado->CurrentValue) <> "") {
			switch ($Reporte_Mers->estado->CurrentValue) {
				case "0":
					$Reporte_Mers->estado->ViewValue = "Borrado";
					break;
				case "1":
					$Reporte_Mers->estado->ViewValue = "Habilitado";
					break;
				case "2":
					$Reporte_Mers->estado->ViewValue = "Desabilitado";
					break;
				default:
					$Reporte_Mers->estado->ViewValue = $Reporte_Mers->estado->CurrentValue;
			}
		} else {
			$Reporte_Mers->estado->ViewValue = NULL;
		}
		$Reporte_Mers->estado->CssStyle = "";
		$Reporte_Mers->estado->CssClass = "";
		$Reporte_Mers->estado->ViewCustomAttributes = "";

		// fechaCreacion
		$Reporte_Mers->fechaCreacion->ViewValue = $Reporte_Mers->fechaCreacion->CurrentValue;
		$Reporte_Mers->fechaCreacion->ViewValue = ew_FormatDateTime($Reporte_Mers->fechaCreacion->ViewValue, 7);
		$Reporte_Mers->fechaCreacion->CssStyle = "";
		$Reporte_Mers->fechaCreacion->CssClass = "";
		$Reporte_Mers->fechaCreacion->ViewCustomAttributes = "";

		// fechaModificacion
		$Reporte_Mers->fechaModificacion->ViewValue = $Reporte_Mers->fechaModificacion->CurrentValue;
		$Reporte_Mers->fechaModificacion->ViewValue = ew_FormatDateTime($Reporte_Mers->fechaModificacion->ViewValue, 7);
		$Reporte_Mers->fechaModificacion->CssStyle = "";
		$Reporte_Mers->fechaModificacion->CssClass = "";
		$Reporte_Mers->fechaModificacion->ViewCustomAttributes = "";

		// idMer
		$Reporte_Mers->idMer->HrefValue = "";

		// mer
		$Reporte_Mers->mer->HrefValue = "";

		// unidadProductivaDedica
		$Reporte_Mers->unidadProductivaDedica->HrefValue = "";

		// codigo
		$Reporte_Mers->codigo->HrefValue = "";

		// numeroSocios
		$Reporte_Mers->numeroSocios->HrefValue = "";

		// direccion
		$Reporte_Mers->direccion->HrefValue = "";

		// zona
		$Reporte_Mers->zona->HrefValue = "";

		// referencia
		$Reporte_Mers->referencia->HrefValue = "";

		// refTelefonica
		$Reporte_Mers->refTelefonica->HrefValue = "";

		// refCelular
		$Reporte_Mers->refCelular->HrefValue = "";

		// fechaInicio
		$Reporte_Mers->fechaInicio->HrefValue = "";

		// fechaFinal
		$Reporte_Mers->fechaFinal->HrefValue = "";

		// gestion
		$Reporte_Mers->gestion->HrefValue = "";

		// estado
		$Reporte_Mers->estado->HrefValue = "";

		// fechaCreacion
		$Reporte_Mers->fechaCreacion->HrefValue = "";

		// fechaModificacion
		$Reporte_Mers->fechaModificacion->HrefValue = "";
	}
	var $RowType; // Row Type
	var $CssClass; // Css class
	var $CssStyle; // Css style
	var $RowClientEvents; // Row client events

	// Row Attribute
	function RowAttributes() {
		$sAtt = "";
		if (trim($this->CssStyle) <> "") {
			$sAtt .= " style=\"" . trim($this->CssStyle) . "\"";
		}
		if (trim($this->CssClass) <> "") {
			$sAtt .= " class=\"" . trim($this->CssClass) . "\"";
		}
		if ($this->Export == "") {
			if (trim($this->RowClientEvents) <> "") {
				$sAtt .= " " . trim($this->RowClientEvents);
			}
		}
		return $sAtt;
	}

	// Field objects
	function fields($fldname) {
		return $this->fields[$fldname];
	}
}
?>
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
$Reporte_Mers_report = new cReporte_Mers_report();
$Page =& $Reporte_Mers_report;

// Page init processing
$Reporte_Mers_report->Page_Init();

// Page main processing
$Reporte_Mers_report->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($Reporte_Mers->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php if ($Reporte_Mers->Export == "") { ?>
<?php } ?>
<p><span class="phpmaker">REPORTE: Reporte Mers
<?php if ($Reporte_Mers->Export == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $Reporte_Mers_report->PageUrl() ?>export=print">Impresi&oacute;n Amigable</a>
&nbsp;&nbsp;<a href="<?php echo $Reporte_Mers_report->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<form method="post">
<table class="ewReportTable" cellspacing="-1">
<?php
$Reporte_Mers_report->lRecCount = 1; // No grouping
if ($Reporte_Mers_report->sDbDetailFilter <> "") {
	if ($Reporte_Mers_report->sFilter <> "") $Reporte_Mers_report->sFilter .= " AND ";
	$Reporte_Mers_report->sFilter .= "(" . $Reporte_Mers_report->sDbDetailFilter . ")";
}

	// Get detail records
	$Reporte_Mers_report->sFilter = "";
	if ($Reporte_Mers_report->sDbDetailFilter <> "") {
		if ($Reporte_Mers_report->sFilter <> "")
			$Reporte_Mers_report->sFilter .= " AND ";
		$Reporte_Mers_report->sFilter .= "(" . $Reporte_Mers_report->sDbDetailFilter . ")";
	}
	if (!$Security->CanReport()) {
		if ($sFilter <> "") $sFilter .= " AND ";
		$sFilter .= "(0=1)";
	}

	// Set up detail SQL
	$Reporte_Mers->CurrentFilter = $Reporte_Mers_report->sFilter;
	$Reporte_Mers_report->sSql = $Reporte_Mers->DetailSQL();

	// Load detail records
	$rsdtl = $conn->Execute($Reporte_Mers_report->sSql);
	$Reporte_Mers_report->nDtlRecs = $rsdtl->RecordCount();

	// Initialize Aggregate
	if (!$rsdtl->EOF) {
		$Reporte_Mers_report->lRecCount++;
	}
	if ($Reporte_Mers_report->lRecCount == 1) {
		$Reporte_Mers_report->nCntRecs[0] = 0;
	}
	$Reporte_Mers_report->nCntRecs[0] += $Reporte_Mers_report->nDtlRecs;
?>
	<tr>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">No</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Nombre de la Mer</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">La Unidad Productiva Dedica a</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Codigo</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Numero de Socios</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Direccion</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Zona</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Referencia</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Ref Telefonica</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Ref Celular</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Fecha Inicio</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Fecha Final</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Gestion</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Estado</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Fecha Creacion</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Fecha Modificacion</span></td>
	</tr>
<?php
	while (!$rsdtl->EOF) {
		$Reporte_Mers->idMer->setDbValue($rsdtl->fields('idMer'));
		$Reporte_Mers->mer->setDbValue($rsdtl->fields('mer'));
		$Reporte_Mers->unidadProductivaDedica->setDbValue($rsdtl->fields('unidadProductivaDedica'));
		$Reporte_Mers->codigo->setDbValue($rsdtl->fields('codigo'));
		$Reporte_Mers->numeroSocios->setDbValue($rsdtl->fields('numeroSocios'));
		$Reporte_Mers->direccion->setDbValue($rsdtl->fields('direccion'));
		$Reporte_Mers->zona->setDbValue($rsdtl->fields('zona'));
		$Reporte_Mers->referencia->setDbValue($rsdtl->fields('referencia'));
		$Reporte_Mers->refTelefonica->setDbValue($rsdtl->fields('refTelefonica'));
		$Reporte_Mers->refCelular->setDbValue($rsdtl->fields('refCelular'));
		$Reporte_Mers->fechaInicio->setDbValue($rsdtl->fields('fechaInicio'));
		$Reporte_Mers->fechaFinal->setDbValue($rsdtl->fields('fechaFinal'));
		$Reporte_Mers->gestion->setDbValue($rsdtl->fields('gestion'));
		$Reporte_Mers->estado->setDbValue($rsdtl->fields('estado'));
		$Reporte_Mers->fechaCreacion->setDbValue($rsdtl->fields('fechaCreacion'));
		$Reporte_Mers->fechaModificacion->setDbValue($rsdtl->fields('fechaModificacion'));

		// Render for view
		$Reporte_Mers->RowType = EW_ROWTYPE_VIEW;
		$Reporte_Mers_report->RenderRow();
?>
	<tr>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->idMer->ViewAttributes() ?>><?php echo $Reporte_Mers->idMer->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->mer->ViewAttributes() ?>><?php echo $Reporte_Mers->mer->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->unidadProductivaDedica->ViewAttributes() ?>><?php echo $Reporte_Mers->unidadProductivaDedica->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->codigo->ViewAttributes() ?>><?php echo $Reporte_Mers->codigo->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->numeroSocios->ViewAttributes() ?>><?php echo $Reporte_Mers->numeroSocios->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->direccion->ViewAttributes() ?>><?php echo $Reporte_Mers->direccion->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->zona->ViewAttributes() ?>><?php echo $Reporte_Mers->zona->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->referencia->ViewAttributes() ?>><?php echo $Reporte_Mers->referencia->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->refTelefonica->ViewAttributes() ?>><?php echo $Reporte_Mers->refTelefonica->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->refCelular->ViewAttributes() ?>><?php echo $Reporte_Mers->refCelular->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->fechaInicio->ViewAttributes() ?>><?php echo $Reporte_Mers->fechaInicio->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->fechaFinal->ViewAttributes() ?>><?php echo $Reporte_Mers->fechaFinal->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->gestion->ViewAttributes() ?>><?php echo $Reporte_Mers->gestion->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->estado->ViewAttributes() ?>><?php echo $Reporte_Mers->estado->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->fechaCreacion->ViewAttributes() ?>><?php echo $Reporte_Mers->fechaCreacion->ViewValue ?></div></span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_Mers->fechaModificacion->ViewAttributes() ?>><?php echo $Reporte_Mers->fechaModificacion->ViewValue ?></div></span></td>
	</tr>
<?php
		$rsdtl->MoveNext();
	}
	$rsdtl->Close();
?>
	<tr><td colspan=16><span class="phpmaker">&nbsp;<br></span></td></tr>
	<tr><td colspan=16 class="ewGrandSummary"><span class="phpmaker">Gran Total (<?php echo ew_FormatNumber($Reporte_Mers_report->nCntRecs[0], 0) ?> Registros de Detalle)</span></td></tr>
	<tr><td colspan=16><span class="phpmaker">&nbsp;<br></span></td></tr>
</table>
</form>
<?php if ($Reporte_Mers->Export == "") { ?>
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
class cReporte_Mers_report {

	// Page ID
	var $PageID = 'report';

	// Table Name
	var $TableName = 'Reporte Mers';

	// Page Object Name
	var $PageObjName = 'Reporte_Mers_report';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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
		return TRUE;
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cReporte_Mers_report() {
		global $conn;

		// Initialize table object
		$GLOBALS["Reporte_Mers"] = new cReporte_Mers();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'report', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'Reporte Mers', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $Reporte_Mers;
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
		if (!$Security->CanReport()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$Reporte_Mers->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $Reporte_Mers->Export; // Get export parameter, used in header
	$gsExportFile = $Reporte_Mers->TableVar; // Get export file, used in header
	if ($Reporte_Mers->Export == "print" || $Reporte_Mers->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($Reporte_Mers->Export == "excel") {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
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
	var $lRecCnt = 0;
	var $sSql = "";
	var $sFilter = "";
	var $sDbMasterFilter = "";
	var $sDbDetailFilter = "";
	var $bMasterRecordExists;
	var $sCmd = "";
	var $lDtlRecs;
	var $vGrps;
	var $nCntRecs;
	var $bLvlBreak;
	var $nTotals;
	var $nMaxs;
	var $nMins;

	//
	// Page main processing
	//
	function Page_Main() {
		global $Reporte_Mers;
		$this->vGrps = ew_InitArray(1, NULL);
		$this->nCntRecs = ew_InitArray(1, 0);
		$this->bLvlBreak = ew_InitArray(1, FALSE);
		$this->nTotals = ew_Init2DArray(1, 17, 0);
		$this->nMaxs = ew_Init2DArray(1, 17, 0);
		$this->nMins = ew_Init2DArray(1, 17, 0);
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Reporte_Mers;

		// Common render codes for all row types
		// idMer

		$Reporte_Mers->idMer->CellCssStyle = "";
		$Reporte_Mers->idMer->CellCssClass = "";

		// mer
		$Reporte_Mers->mer->CellCssStyle = "";
		$Reporte_Mers->mer->CellCssClass = "";

		// unidadProductivaDedica
		$Reporte_Mers->unidadProductivaDedica->CellCssStyle = "";
		$Reporte_Mers->unidadProductivaDedica->CellCssClass = "";

		// codigo
		$Reporte_Mers->codigo->CellCssStyle = "";
		$Reporte_Mers->codigo->CellCssClass = "";

		// numeroSocios
		$Reporte_Mers->numeroSocios->CellCssStyle = "";
		$Reporte_Mers->numeroSocios->CellCssClass = "";

		// direccion
		$Reporte_Mers->direccion->CellCssStyle = "";
		$Reporte_Mers->direccion->CellCssClass = "";

		// zona
		$Reporte_Mers->zona->CellCssStyle = "";
		$Reporte_Mers->zona->CellCssClass = "";

		// referencia
		$Reporte_Mers->referencia->CellCssStyle = "";
		$Reporte_Mers->referencia->CellCssClass = "";

		// refTelefonica
		$Reporte_Mers->refTelefonica->CellCssStyle = "";
		$Reporte_Mers->refTelefonica->CellCssClass = "";

		// refCelular
		$Reporte_Mers->refCelular->CellCssStyle = "";
		$Reporte_Mers->refCelular->CellCssClass = "";

		// fechaInicio
		$Reporte_Mers->fechaInicio->CellCssStyle = "";
		$Reporte_Mers->fechaInicio->CellCssClass = "";

		// fechaFinal
		$Reporte_Mers->fechaFinal->CellCssStyle = "";
		$Reporte_Mers->fechaFinal->CellCssClass = "";

		// gestion
		$Reporte_Mers->gestion->CellCssStyle = "";
		$Reporte_Mers->gestion->CellCssClass = "";

		// estado
		$Reporte_Mers->estado->CellCssStyle = "";
		$Reporte_Mers->estado->CellCssClass = "";

		// fechaCreacion
		$Reporte_Mers->fechaCreacion->CellCssStyle = "";
		$Reporte_Mers->fechaCreacion->CellCssClass = "";

		// fechaModificacion
		$Reporte_Mers->fechaModificacion->CellCssStyle = "";
		$Reporte_Mers->fechaModificacion->CellCssClass = "";
		if ($Reporte_Mers->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMer
			$Reporte_Mers->idMer->ViewValue = $Reporte_Mers->idMer->CurrentValue;
			$Reporte_Mers->idMer->CssStyle = "";
			$Reporte_Mers->idMer->CssClass = "";
			$Reporte_Mers->idMer->ViewCustomAttributes = "";

			// idRegional
			if (strval($Reporte_Mers->idRegional->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `regional` FROM `regional` WHERE `idRegional` = " . ew_AdjustSql($Reporte_Mers->idRegional->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `regional` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$Reporte_Mers->idRegional->ViewValue = $rswrk->fields('regional');
					$rswrk->Close();
				} else {
					$Reporte_Mers->idRegional->ViewValue = $Reporte_Mers->idRegional->CurrentValue;
				}
			} else {
				$Reporte_Mers->idRegional->ViewValue = NULL;
			}
			$Reporte_Mers->idRegional->CssStyle = "";
			$Reporte_Mers->idRegional->CssClass = "";
			$Reporte_Mers->idRegional->ViewCustomAttributes = "";

			// idDepartamento
			if (strval($Reporte_Mers->idDepartamento->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `departamento` FROM `departamento` WHERE `idDepartamento` = " . ew_AdjustSql($Reporte_Mers->idDepartamento->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `departamento` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$Reporte_Mers->idDepartamento->ViewValue = $rswrk->fields('departamento');
					$rswrk->Close();
				} else {
					$Reporte_Mers->idDepartamento->ViewValue = $Reporte_Mers->idDepartamento->CurrentValue;
				}
			} else {
				$Reporte_Mers->idDepartamento->ViewValue = NULL;
			}
			$Reporte_Mers->idDepartamento->CssStyle = "";
			$Reporte_Mers->idDepartamento->CssClass = "";
			$Reporte_Mers->idDepartamento->ViewCustomAttributes = "";

			// idMunicipio
			if (strval($Reporte_Mers->idMunicipio->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `municipio` FROM `municipio` WHERE `idMunicipio` = " . ew_AdjustSql($Reporte_Mers->idMunicipio->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `municipio` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$Reporte_Mers->idMunicipio->ViewValue = $rswrk->fields('municipio');
					$rswrk->Close();
				} else {
					$Reporte_Mers->idMunicipio->ViewValue = $Reporte_Mers->idMunicipio->CurrentValue;
				}
			} else {
				$Reporte_Mers->idMunicipio->ViewValue = NULL;
			}
			$Reporte_Mers->idMunicipio->CssStyle = "";
			$Reporte_Mers->idMunicipio->CssClass = "";
			$Reporte_Mers->idMunicipio->ViewCustomAttributes = "";

			// idComunidad
			if (strval($Reporte_Mers->idComunidad->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `comunidad` FROM `comunidad` WHERE `idComunidad` = " . ew_AdjustSql($Reporte_Mers->idComunidad->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `comunidad` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$Reporte_Mers->idComunidad->ViewValue = $rswrk->fields('comunidad');
					$rswrk->Close();
				} else {
					$Reporte_Mers->idComunidad->ViewValue = $Reporte_Mers->idComunidad->CurrentValue;
				}
			} else {
				$Reporte_Mers->idComunidad->ViewValue = NULL;
			}
			$Reporte_Mers->idComunidad->CssStyle = "";
			$Reporte_Mers->idComunidad->CssClass = "";
			$Reporte_Mers->idComunidad->ViewCustomAttributes = "";

			// idRubro
			if (strval($Reporte_Mers->idRubro->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `rubro` FROM `rubro` WHERE `idRubro` = " . ew_AdjustSql($Reporte_Mers->idRubro->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `rubro` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$Reporte_Mers->idRubro->ViewValue = $rswrk->fields('rubro');
					$rswrk->Close();
				} else {
					$Reporte_Mers->idRubro->ViewValue = $Reporte_Mers->idRubro->CurrentValue;
				}
			} else {
				$Reporte_Mers->idRubro->ViewValue = NULL;
			}
			$Reporte_Mers->idRubro->CssStyle = "";
			$Reporte_Mers->idRubro->CssClass = "";
			$Reporte_Mers->idRubro->ViewCustomAttributes = "";

			// mer
			$Reporte_Mers->mer->ViewValue = $Reporte_Mers->mer->CurrentValue;
			$Reporte_Mers->mer->CssStyle = "";
			$Reporte_Mers->mer->CssClass = "";
			$Reporte_Mers->mer->ViewCustomAttributes = "";

			// unidadProductivaDedica
			$Reporte_Mers->unidadProductivaDedica->ViewValue = $Reporte_Mers->unidadProductivaDedica->CurrentValue;
			$Reporte_Mers->unidadProductivaDedica->CssStyle = "";
			$Reporte_Mers->unidadProductivaDedica->CssClass = "";
			$Reporte_Mers->unidadProductivaDedica->ViewCustomAttributes = "";

			// codigo
			$Reporte_Mers->codigo->ViewValue = $Reporte_Mers->codigo->CurrentValue;
			$Reporte_Mers->codigo->CssStyle = "";
			$Reporte_Mers->codigo->CssClass = "";
			$Reporte_Mers->codigo->ViewCustomAttributes = "";

			// numeroSocios
			$Reporte_Mers->numeroSocios->ViewValue = $Reporte_Mers->numeroSocios->CurrentValue;
			$Reporte_Mers->numeroSocios->CssStyle = "";
			$Reporte_Mers->numeroSocios->CssClass = "";
			$Reporte_Mers->numeroSocios->ViewCustomAttributes = "";

			// direccion
			$Reporte_Mers->direccion->ViewValue = $Reporte_Mers->direccion->CurrentValue;
			$Reporte_Mers->direccion->CssStyle = "";
			$Reporte_Mers->direccion->CssClass = "";
			$Reporte_Mers->direccion->ViewCustomAttributes = "";

			// zona
			$Reporte_Mers->zona->ViewValue = $Reporte_Mers->zona->CurrentValue;
			$Reporte_Mers->zona->CssStyle = "";
			$Reporte_Mers->zona->CssClass = "";
			$Reporte_Mers->zona->ViewCustomAttributes = "";

			// referencia
			$Reporte_Mers->referencia->ViewValue = $Reporte_Mers->referencia->CurrentValue;
			$Reporte_Mers->referencia->CssStyle = "";
			$Reporte_Mers->referencia->CssClass = "";
			$Reporte_Mers->referencia->ViewCustomAttributes = "";

			// refTelefonica
			$Reporte_Mers->refTelefonica->ViewValue = $Reporte_Mers->refTelefonica->CurrentValue;
			$Reporte_Mers->refTelefonica->CssStyle = "";
			$Reporte_Mers->refTelefonica->CssClass = "";
			$Reporte_Mers->refTelefonica->ViewCustomAttributes = "";

			// refCelular
			$Reporte_Mers->refCelular->ViewValue = $Reporte_Mers->refCelular->CurrentValue;
			$Reporte_Mers->refCelular->CssStyle = "";
			$Reporte_Mers->refCelular->CssClass = "";
			$Reporte_Mers->refCelular->ViewCustomAttributes = "";

			// fechaInicio
			$Reporte_Mers->fechaInicio->ViewValue = $Reporte_Mers->fechaInicio->CurrentValue;
			$Reporte_Mers->fechaInicio->ViewValue = ew_FormatDateTime($Reporte_Mers->fechaInicio->ViewValue, 7);
			$Reporte_Mers->fechaInicio->CssStyle = "";
			$Reporte_Mers->fechaInicio->CssClass = "";
			$Reporte_Mers->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$Reporte_Mers->fechaFinal->ViewValue = $Reporte_Mers->fechaFinal->CurrentValue;
			$Reporte_Mers->fechaFinal->ViewValue = ew_FormatDateTime($Reporte_Mers->fechaFinal->ViewValue, 7);
			$Reporte_Mers->fechaFinal->CssStyle = "";
			$Reporte_Mers->fechaFinal->CssClass = "";
			$Reporte_Mers->fechaFinal->ViewCustomAttributes = "";

			// gestion
			$Reporte_Mers->gestion->ViewValue = $Reporte_Mers->gestion->CurrentValue;
			$Reporte_Mers->gestion->CssStyle = "";
			$Reporte_Mers->gestion->CssClass = "";
			$Reporte_Mers->gestion->ViewCustomAttributes = "";

			// estado
			if (strval($Reporte_Mers->estado->CurrentValue) <> "") {
				switch ($Reporte_Mers->estado->CurrentValue) {
					case "0":
						$Reporte_Mers->estado->ViewValue = "Borrado";
						break;
					case "1":
						$Reporte_Mers->estado->ViewValue = "Habilitado";
						break;
					case "2":
						$Reporte_Mers->estado->ViewValue = "Desabilitado";
						break;
					default:
						$Reporte_Mers->estado->ViewValue = $Reporte_Mers->estado->CurrentValue;
				}
			} else {
				$Reporte_Mers->estado->ViewValue = NULL;
			}
			$Reporte_Mers->estado->CssStyle = "";
			$Reporte_Mers->estado->CssClass = "";
			$Reporte_Mers->estado->ViewCustomAttributes = "";

			// fechaCreacion
			$Reporte_Mers->fechaCreacion->ViewValue = $Reporte_Mers->fechaCreacion->CurrentValue;
			$Reporte_Mers->fechaCreacion->ViewValue = ew_FormatDateTime($Reporte_Mers->fechaCreacion->ViewValue, 7);
			$Reporte_Mers->fechaCreacion->CssStyle = "";
			$Reporte_Mers->fechaCreacion->CssClass = "";
			$Reporte_Mers->fechaCreacion->ViewCustomAttributes = "";

			// fechaModificacion
			$Reporte_Mers->fechaModificacion->ViewValue = $Reporte_Mers->fechaModificacion->CurrentValue;
			$Reporte_Mers->fechaModificacion->ViewValue = ew_FormatDateTime($Reporte_Mers->fechaModificacion->ViewValue, 7);
			$Reporte_Mers->fechaModificacion->CssStyle = "";
			$Reporte_Mers->fechaModificacion->CssClass = "";
			$Reporte_Mers->fechaModificacion->ViewCustomAttributes = "";

			// idMer
			$Reporte_Mers->idMer->HrefValue = "";

			// mer
			$Reporte_Mers->mer->HrefValue = "";

			// unidadProductivaDedica
			$Reporte_Mers->unidadProductivaDedica->HrefValue = "";

			// codigo
			$Reporte_Mers->codigo->HrefValue = "";

			// numeroSocios
			$Reporte_Mers->numeroSocios->HrefValue = "";

			// direccion
			$Reporte_Mers->direccion->HrefValue = "";

			// zona
			$Reporte_Mers->zona->HrefValue = "";

			// referencia
			$Reporte_Mers->referencia->HrefValue = "";

			// refTelefonica
			$Reporte_Mers->refTelefonica->HrefValue = "";

			// refCelular
			$Reporte_Mers->refCelular->HrefValue = "";

			// fechaInicio
			$Reporte_Mers->fechaInicio->HrefValue = "";

			// fechaFinal
			$Reporte_Mers->fechaFinal->HrefValue = "";

			// gestion
			$Reporte_Mers->gestion->HrefValue = "";

			// estado
			$Reporte_Mers->estado->HrefValue = "";

			// fechaCreacion
			$Reporte_Mers->fechaCreacion->HrefValue = "";

			// fechaModificacion
			$Reporte_Mers->fechaModificacion->HrefValue = "";
		}
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
