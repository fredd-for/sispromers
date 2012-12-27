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
$mer_add = new cmer_add();
$Page =& $mer_add;

// Page init processing
$mer_add->Page_Init();

// Page main processing
$mer_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var mer_add = new ew_Page("mer_add");

// page properties
mer_add.PageID = "add"; // page ID
var EW_PAGE_ID = mer_add.PageID; // for backward compatibility

// extend page with ValidateForm function
mer_add.ValidateForm = function(fobj) {
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
//		elm = fobj.elements["x" + infix + "_idMunicipio"];
//		if (elm && !ew_HasValue(elm))
//			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Municipio");
//		elm = fobj.elements["x" + infix + "_idComunidad"];
//		if (elm && !ew_HasValue(elm))
//			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Comunidad");
		elm = fobj.elements["x" + infix + "_idRubro"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Rubro");
		elm = fobj.elements["x" + infix + "_mer"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Nombre de la Mer");
		elm = fobj.elements["x" + infix + "_codigo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Codigo");
		elm = fobj.elements["x" + infix + "_numeroSocios"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Numero de Socios");
		elm = fobj.elements["x" + infix + "_refTelefonica"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Ref Telefonica");
		elm = fobj.elements["x" + infix + "_refCelular"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Ref Celular");
		elm = fobj.elements["x" + infix + "_fechaInicio"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Inicio");
		elm = fobj.elements["x" + infix + "_fechaInicio"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Inicio");
		elm = fobj.elements["x" + infix + "_fechaFinal"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Final");
		elm = fobj.elements["x" + infix + "_fechaFinal"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Final");
		elm = fobj.elements["x" + infix + "_longitudUTM"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "Numero de Punto Flotante Incorrecto - Longitud UTM");
		elm = fobj.elements["x" + infix + "_latitudUTM"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "Numero de Punto Flotante Incorrecto - Latitud UTM");
		elm = fobj.elements["x" + infix + "_gestion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Gestion");
		elm = fobj.elements["x" + infix + "_gestion"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Gestion");
		elm = fobj.elements["x" + infix + "_fechaCreacion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Creacion");
		elm = fobj.elements["x" + infix + "_fechaCreacion"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Creacion");
		elm = fobj.elements["x" + infix + "_fechaModificacion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Modificacion");
		elm = fobj.elements["x" + infix + "_fechaModificacion"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Modificacion");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
mer_add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
mer_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mer_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-1.css" title="win2k-1">
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script type="text/javascript">
<!--
var ew_DHTMLEditors = [];

//-->
</script>

<script type="text/javascript">
  function yyyy_mm_dd(dmy)
  {var fecha_dd_mm_yyyy=dmy;
    var dia_aux = parseInt(fecha_dd_mm_yyyy.substring(0, 2),10);
    var mes_aux = parseInt(fecha_dd_mm_yyyy.substring(3, 5),10);
    var ano_aux = parseInt(fecha_dd_mm_yyyy.substring(6, 10),10);
    var fecha = new Date();

    fecha.setDate(dia_aux);
    fecha.setMonth(mes_aux-1);
    fecha.setFullYear(ano_aux);
    fecha.setHours(0);
    fecha.setMinutes(0);
    fecha.setSeconds(0);
    fecha.setMilliseconds(0);
    var timestamp = parseInt(fecha.getTime(),10);

    return fecha1 = new Date(timestamp);
  }

function gestion(gestion){
  var fecha=yyyy_mm_dd(gestion);
  if(fecha.getMonth()+1<13){ return(fecha.getFullYear());}
  else{return (fecha.getFullYear()+1);}

}
</script>
<p><span class="phpmaker">Agregar a TABLA: Mer<br><br>
<a href="<?php echo $mer->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $mer_add->ShowMessage() ?>
<form name="fmeradd" id="fmeradd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return mer_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="mer">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($mer->idRegional->Visible) { // idRegional ?>
	<tr<?php echo $mer->idRegional->RowAttributes ?>>
		<td class="ewTableHeader">Regional<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $mer->idRegional->CellAttributes() ?>><span id="el_idRegional">
<select id="x_idRegional" name="x_idRegional"<?php echo $mer->idRegional->EditAttributes() ?>>
<?php
if (is_array($mer->idRegional->EditValue)) {
	$arwrk = $mer->idRegional->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($mer->idRegional->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $mer->idRegional->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->idDepartamento->Visible) { // idDepartamento ?>
	<tr<?php echo $mer->idDepartamento->RowAttributes ?>>
		<td class="ewTableHeader">Departamento<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $mer->idDepartamento->CellAttributes() ?>><span id="el_idDepartamento">
<input type="hidden" name="x_idDepartamento_edit" id="x_idDepartamento_edit" value="-1"/>
<div id="divx_idDepartamento"></div>
</span><?php echo $mer->idDepartamento->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->idMunicipio->Visible) { // idMunicipio ?>
	<tr<?php echo $mer->idMunicipio->RowAttributes ?>>
		<td class="ewTableHeader">Municipio<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $mer->idMunicipio->CellAttributes() ?>><span id="el_idMunicipio">
<input type="hidden" name="x_idMunicipio_edit" id="x_idMunicipio_edit" value="-1"/>
<div id="divx_idMunicipio"></div>
</span><?php echo $mer->idMunicipio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->idComunidad->Visible) { // idComunidad ?>
	<tr<?php echo $mer->idComunidad->RowAttributes ?>>
		<td class="ewTableHeader">Comunidad<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $mer->idComunidad->CellAttributes() ?>><span id="el_idComunidad">
<input type="hidden" name="x_idComunidad_edit" id="x_idComunidad_edit" value="-1"/>
<div id="divx_idComunidad"></div>
</span><?php echo $mer->idComunidad->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->idRubro->Visible) { // idRubro ?>
	<tr<?php echo $mer->idRubro->RowAttributes ?>>
		<td class="ewTableHeader">Rubro<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $mer->idRubro->CellAttributes() ?>><span id="el_idRubro">
<select id="x_idRubro" name="x_idRubro"<?php echo $mer->idRubro->EditAttributes() ?>>
<?php
if (is_array($mer->idRubro->EditValue)) {
	$arwrk = $mer->idRubro->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($mer->idRubro->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $mer->idRubro->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->mer->Visible) { // mer ?>
	<tr<?php echo $mer->mer->RowAttributes ?>>
		<td class="ewTableHeader">Nombre de la Mer<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $mer->mer->CellAttributes() ?>><span id="el_mer">
<input type="text" name="x_mer" id="x_mer" size="50" maxlength="255" value="<?php echo $mer->mer->EditValue ?>"<?php echo $mer->mer->EditAttributes() ?>>
</span><?php echo $mer->mer->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->unidadProductivaDedica->Visible) { // unidadProductivaDedica ?>
	<tr<?php echo $mer->unidadProductivaDedica->RowAttributes ?>>
		<td class="ewTableHeader">La Unidad Productiva se Dedica a</td>
		<td<?php echo $mer->unidadProductivaDedica->CellAttributes() ?>><span id="el_unidadProductivaDedica">
<input type="text" name="x_unidadProductivaDedica" id="x_unidadProductivaDedica" size="50" maxlength="255" value="<?php echo $mer->unidadProductivaDedica->EditValue ?>"<?php echo $mer->unidadProductivaDedica->EditAttributes() ?>>
</span><?php echo $mer->unidadProductivaDedica->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->codigo->Visible) { // codigo ?>
	<tr<?php echo $mer->codigo->RowAttributes ?>>
		<td class="ewTableHeader">Codigo<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $mer->codigo->CellAttributes() ?>><span id="el_codigo">
<input type="text" name="x_codigo" id="x_codigo" size="30" maxlength="255" value="<?php echo $mer->codigo->EditValue ?>"<?php echo $mer->codigo->EditAttributes() ?>>
</span><?php echo $mer->codigo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->numeroSocios->Visible) { // numeroSocios ?>
	<tr<?php echo $mer->numeroSocios->RowAttributes ?>>
		<td class="ewTableHeader">Numero de Socios</td>
		<td<?php echo $mer->numeroSocios->CellAttributes() ?>><span id="el_numeroSocios">
<input type="text" name="x_numeroSocios" id="x_numeroSocios" size="30" value="<?php echo $mer->numeroSocios->EditValue ?>"<?php echo $mer->numeroSocios->EditAttributes() ?>>
</span><?php echo $mer->numeroSocios->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->direccion->Visible) { // direccion ?>
	<tr<?php echo $mer->direccion->RowAttributes ?>>
            <td class="ewTableHeader">Direcci&oacute;n</td>
		<td<?php echo $mer->direccion->CellAttributes() ?>><span id="el_direccion">
<input type="text" name="x_direccion" id="x_direccion" size="50" maxlength="255" value="<?php echo $mer->direccion->EditValue ?>"<?php echo $mer->direccion->EditAttributes() ?>>
</span><?php echo $mer->direccion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->zona->Visible) { // zona ?>
	<tr<?php echo $mer->zona->RowAttributes ?>>
		<td class="ewTableHeader">Zona</td>
		<td<?php echo $mer->zona->CellAttributes() ?>><span id="el_zona">
<input type="text" name="x_zona" id="x_zona" size="30" maxlength="255" value="<?php echo $mer->zona->EditValue ?>"<?php echo $mer->zona->EditAttributes() ?>>
</span><?php echo $mer->zona->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->referencia->Visible) { // referencia ?>
	<tr<?php echo $mer->referencia->RowAttributes ?>>
		<td class="ewTableHeader">Referencia</td>
		<td<?php echo $mer->referencia->CellAttributes() ?>><span id="el_referencia">
<input type="text" name="x_referencia" id="x_referencia" size="50" maxlength="255" value="<?php echo $mer->referencia->EditValue ?>"<?php echo $mer->referencia->EditAttributes() ?>>
</span><?php echo $mer->referencia->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->refTelefonica->Visible) { // refTelefonica ?>
	<tr<?php echo $mer->refTelefonica->RowAttributes ?>>
		<td class="ewTableHeader">Ref Telefonica</td>
		<td<?php echo $mer->refTelefonica->CellAttributes() ?>><span id="el_refTelefonica">
<input type="text" name="x_refTelefonica" id="x_refTelefonica" size="30" value="<?php echo $mer->refTelefonica->EditValue ?>"<?php echo $mer->refTelefonica->EditAttributes() ?>>
</span><?php echo $mer->refTelefonica->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->refCelular->Visible) { // refCelular ?>
	<tr<?php echo $mer->refCelular->RowAttributes ?>>
		<td class="ewTableHeader">Ref Celular</td>
		<td<?php echo $mer->refCelular->CellAttributes() ?>><span id="el_refCelular">
<input type="text" name="x_refCelular" id="x_refCelular" size="30" value="<?php echo $mer->refCelular->EditValue ?>"<?php echo $mer->refCelular->EditAttributes() ?>>
</span><?php echo $mer->refCelular->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->fechaInicio->Visible) { // fechaInicio ?>
	<tr<?php echo $mer->fechaInicio->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Inicio<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $mer->fechaInicio->CellAttributes() ?>><span id="el_fechaInicio">
<input type="text" name="x_fechaInicio" id="x_fechaInicio" value="<?php echo $mer->fechaInicio->EditValue ?>"<?php echo $mer->fechaInicio->EditAttributes() ?> onchange="document.fmeradd.x_gestion.value=gestion(this.value)">
&nbsp;<img src="images/calendar.png" id="cal_x_fechaInicio" name="cal_x_fechaInicio" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x_fechaInicio", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "cal_x_fechaInicio" // ID of the button
});
</script>
</span><?php echo $mer->fechaInicio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->fechaFinal->Visible) { // fechaFinal ?>
	<tr<?php echo $mer->fechaFinal->RowAttributes ?>>
            <td class="ewTableHeader">Fecha Finalizaci&oacute;n<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $mer->fechaFinal->CellAttributes() ?>><span id="el_fechaFinal">
<input type="text" name="x_fechaFinal" id="x_fechaFinal" value="<?php echo $mer->fechaFinal->EditValue ?>"<?php echo $mer->fechaFinal->EditAttributes() ?>>
&nbsp;<img src="images/calendar.png" id="cal_x_fechaFinal" name="cal_x_fechaFinal" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x_fechaFinal", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "cal_x_fechaFinal" // ID of the button
});
</script>
</span><?php echo $mer->fechaFinal->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->longitudUTM->Visible) { // longitudUTM ?>
	<tr<?php echo $mer->longitudUTM->RowAttributes ?>>
		<td class="ewTableHeader">Longitud UTM<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $mer->longitudUTM->CellAttributes() ?>><span id="el_longitudUTM">
<input type="text" name="x_longitudUTM" id="x_longitudUTM" size="30" value="<?php echo $mer->longitudUTM->EditValue ?>"<?php echo $mer->longitudUTM->EditAttributes() ?>>
</span><?php echo $mer->longitudUTM->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->latitudUTM->Visible) { // latitudUTM ?>
	<tr<?php echo $mer->latitudUTM->RowAttributes ?>>
		<td class="ewTableHeader">Latitud UTM<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $mer->latitudUTM->CellAttributes() ?>><span id="el_latitudUTM">
<input type="text" name="x_latitudUTM" id="x_latitudUTM" size="30" value="<?php echo $mer->latitudUTM->EditValue ?>"<?php echo $mer->latitudUTM->EditAttributes() ?>>
</span><?php echo $mer->latitudUTM->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->gestion->Visible) { // gestion ?>
	<tr<?php echo $mer->gestion->RowAttributes ?>>
            <td class="ewTableHeader">Gesti&oacute;n</td>
		<td<?php echo $mer->gestion->CellAttributes() ?>><span id="el_gestion">
                        <input type="text" name="x_gestion" id="x_gestion" size="30" value="<?php echo $mer->gestion->EditValue ?>"<?php echo $mer->gestion->EditAttributes() ?> >
</span><?php echo $mer->gestion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mer->fechaCreacion->Visible) { // fechaCreacion ?>
	<?php echo $mer->fechaCreacion->CellAttributes() ?><span id="el_fechaCreacion">
            <input type="hidden" name="x_fechaCreacion" id="x_fechaCreacion" value="<?php echo date("d/m/Y"); ?>"<?php echo $mer->fechaCreacion->EditAttributes() ?>>
</span><?php echo $mer->fechaCreacion->CustomMsg ?>
	</tr>
<?php } ?>
<?php if ($mer->fechaModificacion->Visible) { // fechaModificacion ?>
	<tr<?php echo $mer->fechaModificacion->RowAttributes ?>>
		<?php echo $mer->fechaModificacion->CellAttributes() ?><span id="el_fechaModificacion">
                    <input type="hidden" name="x_fechaModificacion" id="x_fechaModificacion" value="<?php echo date("d/m/Y"); ?>"<?php echo $mer->fechaModificacion->EditAttributes() ?>>
</span><?php echo $mer->fechaModificacion->CustomMsg ?>
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
class cmer_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'mer';

	// Page Object Name
	var $PageObjName = 'mer_add';

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
	function cmer_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["mer"] = new cmer();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
	var $x_ewPriv = 0;

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $mer;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["idMer"] != "") {
		  $mer->idMer->setQueryStringValue($_GET["idMer"]);
		} else {
		  $bCopy = FALSE;
		}

		// Create form object
		$objForm = new cFormObj();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $mer->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$mer->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $mer->CurrentAction = "C"; // Copy Record
		  } else {
		    $mer->CurrentAction = "I"; // Display Blank Record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($mer->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No se encontraron registros"); // No record found
		      $this->Page_Terminate("merlist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$mer->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Registro agregado satisfactoriamente"); // Set up success message
					$sReturnUrl = $mer->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$mer->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $mer;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $mer;
		$mer->longitudUTM->CurrentValue = 0;
		$mer->latitudUTM->CurrentValue = 0;
		
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $mer;
		$mer->idRegional->setFormValue($objForm->GetValue("x_idRegional"));
		$mer->idDepartamento->setFormValue($objForm->GetValue("x_idDepartamento"));
		$mer->idMunicipio->setFormValue($objForm->GetValue("x_idMunicipio"));
		$mer->idComunidad->setFormValue($objForm->GetValue("x_idComunidad"));
		$mer->idRubro->setFormValue($objForm->GetValue("x_idRubro"));
		$mer->mer->setFormValue($objForm->GetValue("x_mer"));
		$mer->unidadProductivaDedica->setFormValue($objForm->GetValue("x_unidadProductivaDedica"));
		$mer->codigo->setFormValue($objForm->GetValue("x_codigo"));
		$mer->numeroSocios->setFormValue($objForm->GetValue("x_numeroSocios"));
		$mer->direccion->setFormValue($objForm->GetValue("x_direccion"));
		$mer->zona->setFormValue($objForm->GetValue("x_zona"));
		$mer->referencia->setFormValue($objForm->GetValue("x_referencia"));
		$mer->refTelefonica->setFormValue($objForm->GetValue("x_refTelefonica"));
		$mer->refCelular->setFormValue($objForm->GetValue("x_refCelular"));
		$mer->fechaInicio->setFormValue($objForm->GetValue("x_fechaInicio"));
		$mer->fechaInicio->CurrentValue = ew_UnFormatDateTime($mer->fechaInicio->CurrentValue, 7);
		$mer->fechaFinal->setFormValue($objForm->GetValue("x_fechaFinal"));
		$mer->fechaFinal->CurrentValue = ew_UnFormatDateTime($mer->fechaFinal->CurrentValue, 7);
		$mer->longitudUTM->setFormValue($objForm->GetValue("x_longitudUTM"));
		$mer->latitudUTM->setFormValue($objForm->GetValue("x_latitudUTM"));
		$mer->gestion->setFormValue($objForm->GetValue("x_gestion"));
		//$mer->estado->setFormValue($objForm->GetValue("x_estado"));
		$mer->fechaCreacion->setFormValue($objForm->GetValue("x_fechaCreacion"));
		$mer->fechaCreacion->CurrentValue = ew_UnFormatDateTime($mer->fechaCreacion->CurrentValue, 7);
		$mer->fechaModificacion->setFormValue($objForm->GetValue("x_fechaModificacion"));
		$mer->fechaModificacion->CurrentValue = ew_UnFormatDateTime($mer->fechaModificacion->CurrentValue, 7);
		$mer->idMer->setFormValue($objForm->GetValue("x_idMer"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $mer;
		$mer->idMer->CurrentValue = $mer->idMer->FormValue;
		$mer->idRegional->CurrentValue = $mer->idRegional->FormValue;
		$mer->idDepartamento->CurrentValue = $mer->idDepartamento->FormValue;
		$mer->idMunicipio->CurrentValue = $mer->idMunicipio->FormValue;
		$mer->idComunidad->CurrentValue = $mer->idComunidad->FormValue;
		$mer->idRubro->CurrentValue = $mer->idRubro->FormValue;
		$mer->mer->CurrentValue = $mer->mer->FormValue;
		$mer->unidadProductivaDedica->CurrentValue = $mer->unidadProductivaDedica->FormValue;
		$mer->codigo->CurrentValue = $mer->codigo->FormValue;
		$mer->numeroSocios->CurrentValue = $mer->numeroSocios->FormValue;
		$mer->direccion->CurrentValue = $mer->direccion->FormValue;
		$mer->zona->CurrentValue = $mer->zona->FormValue;
		$mer->referencia->CurrentValue = $mer->referencia->FormValue;
		$mer->refTelefonica->CurrentValue = $mer->refTelefonica->FormValue;
		$mer->refCelular->CurrentValue = $mer->refCelular->FormValue;
		$mer->fechaInicio->CurrentValue = $mer->fechaInicio->FormValue;
		$mer->fechaInicio->CurrentValue = ew_UnFormatDateTime($mer->fechaInicio->CurrentValue, 7);
		$mer->fechaFinal->CurrentValue = $mer->fechaFinal->FormValue;
		$mer->fechaFinal->CurrentValue = ew_UnFormatDateTime($mer->fechaFinal->CurrentValue, 7);
		$mer->longitudUTM->CurrentValue = $mer->longitudUTM->FormValue;
		$mer->latitudUTM->CurrentValue = $mer->latitudUTM->FormValue;
		$mer->gestion->CurrentValue = $mer->gestion->FormValue;
		//$mer->estado->CurrentValue = $mer->estado->FormValue;
		$mer->fechaCreacion->CurrentValue = $mer->fechaCreacion->FormValue;
		$mer->fechaCreacion->CurrentValue = ew_UnFormatDateTime($mer->fechaCreacion->CurrentValue, 7);
		$mer->fechaModificacion->CurrentValue = $mer->fechaModificacion->FormValue;
		$mer->fechaModificacion->CurrentValue = ew_UnFormatDateTime($mer->fechaModificacion->CurrentValue, 7);
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
		$mer->longitudUTM->setDbValue($rs->fields('longitudUTM'));
		$mer->latitudUTM->setDbValue($rs->fields('latitudUTM'));
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

		// longitudUTM
		$mer->longitudUTM->CellCssStyle = "";
		$mer->longitudUTM->CellCssClass = "";

		// latitudUTM
		$mer->latitudUTM->CellCssStyle = "";
		$mer->latitudUTM->CellCssClass = "";

		// gestion
		$mer->gestion->CellCssStyle = "";
		$mer->gestion->CellCssClass = "";

		// estado
		//$mer->estado->CellCssStyle = "";
		//$mer->estado->CellCssClass = "";

		// fechaCreacion
		$mer->fechaCreacion->CellCssStyle = "";
		$mer->fechaCreacion->CellCssClass = "";

		// fechaModificacion
		$mer->fechaModificacion->CellCssStyle = "";
		$mer->fechaModificacion->CellCssClass = "";
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

			// longitudUTM
			$mer->longitudUTM->ViewValue = $mer->longitudUTM->CurrentValue;
			$mer->longitudUTM->CssStyle = "";
			$mer->longitudUTM->CssClass = "";
			$mer->longitudUTM->ViewCustomAttributes = "";

			// latitudUTM
			$mer->latitudUTM->ViewValue = $mer->latitudUTM->CurrentValue;
			$mer->latitudUTM->CssStyle = "";
			$mer->latitudUTM->CssClass = "";
			$mer->latitudUTM->ViewCustomAttributes = "";

			// gestion
			$mer->gestion->ViewValue = $mer->gestion->CurrentValue;
			$mer->gestion->CssStyle = "";
			$mer->gestion->CssClass = "";
			$mer->gestion->ViewCustomAttributes = "";

			// fechaCreacion
			$mer->fechaCreacion->ViewValue = $mer->fechaCreacion->CurrentValue;
			$mer->fechaCreacion->ViewValue = ew_FormatDateTime($mer->fechaCreacion->ViewValue, 7);
			$mer->fechaCreacion->CssStyle = "";
			$mer->fechaCreacion->CssClass = "";
			$mer->fechaCreacion->ViewCustomAttributes = "";

			// fechaModificacion
			$mer->fechaModificacion->ViewValue = $mer->fechaModificacion->CurrentValue;
			$mer->fechaModificacion->ViewValue = ew_FormatDateTime($mer->fechaModificacion->ViewValue, 7);
			$mer->fechaModificacion->CssStyle = "";
			$mer->fechaModificacion->CssClass = "";
			$mer->fechaModificacion->ViewCustomAttributes = "";

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

			// longitudUTM
			$mer->longitudUTM->HrefValue = "";

			// latitudUTM
			$mer->latitudUTM->HrefValue = "";

			// gestion
			$mer->gestion->HrefValue = "";

			// estado
			//$mer->estado->HrefValue = "";

			// fechaCreacion
			$mer->fechaCreacion->HrefValue = "";

			// fechaModificacion
			$mer->fechaModificacion->HrefValue = "";
		} elseif ($mer->RowType == EW_ROWTYPE_ADD) { // Add row

			// idRegional
			$mer->idRegional->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idRegional`, `regional`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `regional`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `regional` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$mer->idRegional->EditValue = $arwrk;

			// idDepartamento
			$mer->idDepartamento->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idDepartamento`, `departamento`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `departamento`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `departamento` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$mer->idDepartamento->EditValue = $arwrk;

			// idMunicipio
			$mer->idMunicipio->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idMunicipio`, `municipio`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `municipio`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `municipio` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$mer->idMunicipio->EditValue = $arwrk;

			// idComunidad
			$mer->idComunidad->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idComunidad`, `comunidad`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `comunidad`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `comunidad` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$mer->idComunidad->EditValue = $arwrk;

			// idRubro
			$mer->idRubro->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idRubro`, `rubro`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `rubro`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `rubro` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$mer->idRubro->EditValue = $arwrk;

			// mer
			$mer->mer->EditCustomAttributes = "";
			$mer->mer->EditValue = ew_HtmlEncode($mer->mer->CurrentValue);

			// unidadProductivaDedica
			$mer->unidadProductivaDedica->EditCustomAttributes = "";
			$mer->unidadProductivaDedica->EditValue = ew_HtmlEncode($mer->unidadProductivaDedica->CurrentValue);

			// codigo
			$mer->codigo->EditCustomAttributes = "";
			$mer->codigo->EditValue = ew_HtmlEncode($mer->codigo->CurrentValue);

			// numeroSocios
			$mer->numeroSocios->EditCustomAttributes = "";
			$mer->numeroSocios->EditValue = ew_HtmlEncode($mer->numeroSocios->CurrentValue);

			// direccion
			$mer->direccion->EditCustomAttributes = "";
			$mer->direccion->EditValue = ew_HtmlEncode($mer->direccion->CurrentValue);

			// zona
			$mer->zona->EditCustomAttributes = "";
			$mer->zona->EditValue = ew_HtmlEncode($mer->zona->CurrentValue);

			// referencia
			$mer->referencia->EditCustomAttributes = "";
			$mer->referencia->EditValue = ew_HtmlEncode($mer->referencia->CurrentValue);

			// refTelefonica
			$mer->refTelefonica->EditCustomAttributes = "";
			$mer->refTelefonica->EditValue = ew_HtmlEncode($mer->refTelefonica->CurrentValue);

			// refCelular
			$mer->refCelular->EditCustomAttributes = "";
			$mer->refCelular->EditValue = ew_HtmlEncode($mer->refCelular->CurrentValue);

			// fechaInicio
			$mer->fechaInicio->EditCustomAttributes = "";
			$mer->fechaInicio->EditValue = ew_HtmlEncode(ew_FormatDateTime($mer->fechaInicio->CurrentValue, 7));

			// fechaFinal
			$mer->fechaFinal->EditCustomAttributes = "";
			$mer->fechaFinal->EditValue = ew_HtmlEncode(ew_FormatDateTime($mer->fechaFinal->CurrentValue, 7));

			// longitudUTM
			$mer->longitudUTM->EditCustomAttributes = "";
			$mer->longitudUTM->EditValue = ew_HtmlEncode($mer->longitudUTM->CurrentValue);

			// latitudUTM
			$mer->latitudUTM->EditCustomAttributes = "";
			$mer->latitudUTM->EditValue = ew_HtmlEncode($mer->latitudUTM->CurrentValue);

			// gestion
			$mer->gestion->EditCustomAttributes = "";
			$mer->gestion->EditValue = ew_HtmlEncode($mer->gestion->CurrentValue);

			// estado
			
			// fechaCreacion
			$mer->fechaCreacion->EditCustomAttributes = "";
			$mer->fechaCreacion->EditValue = ew_HtmlEncode(ew_FormatDateTime($mer->fechaCreacion->CurrentValue, 7));

			// fechaModificacion
			$mer->fechaModificacion->EditCustomAttributes = "";
			$mer->fechaModificacion->EditValue = ew_HtmlEncode(ew_FormatDateTime($mer->fechaModificacion->CurrentValue, 7));
		}

		// Call Row Rendered event
		$mer->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $mer;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($mer->idRegional->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Regional";
		}
		if ($mer->idDepartamento->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Departamento";
		}
		if ($mer->idMunicipio->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Municipio";
		}
		if ($mer->idComunidad->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Comunidad";
		}
		if ($mer->idRubro->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Rubro";
		}
		if ($mer->mer->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Nombre de la Mer";
		}
		if ($mer->codigo->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Codigo";
		}
		if (!ew_CheckInteger($mer->numeroSocios->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Numero de Socios";
		}
		if (!ew_CheckInteger($mer->refTelefonica->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Ref Telefonica";
		}
		if (!ew_CheckInteger($mer->refCelular->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Ref Celular";
		}
		if ($mer->fechaInicio->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Inicio";
		}
		if (!ew_CheckEuroDate($mer->fechaInicio->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Inicio";
		}
		if ($mer->fechaFinal->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Final";
		}
		if (!ew_CheckEuroDate($mer->fechaFinal->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Final";
		}
		if (!ew_CheckNumber($mer->longitudUTM->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Numero de Punto Flotante Incorrecto - Longitud UTM";
		}
		if (!ew_CheckNumber($mer->latitudUTM->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Numero de Punto Flotante Incorrecto - Latitud UTM";
		}
		if ($mer->gestion->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Gestion";
		}
		if (!ew_CheckInteger($mer->gestion->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Gestion";
		}
		if ($mer->fechaCreacion->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Creacion";
		}
		if (!ew_CheckEuroDate($mer->fechaCreacion->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Creacion";
		}
		if ($mer->fechaModificacion->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Modificacion";
		}
		if (!ew_CheckEuroDate($mer->fechaModificacion->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Modificacion";
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
		global $conn, $Security, $mer;
		if ($mer->codigo->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(codigo = '" . ew_AdjustSql($mer->codigo->CurrentValue) . "')";
			$rsChk = $mer->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", "codigo", "Valor duplicado '%v' de la lista '%f'");
				$sIdxErrMsg = str_replace("%v", $mer->codigo->CurrentValue, $sIdxErrMsg);
				$this->setMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Field idRegional
		$mer->idRegional->SetDbValueDef($mer->idRegional->CurrentValue, 0);
		$rsnew['idRegional'] =& $mer->idRegional->DbValue;

		// Field idDepartamento
		$mer->idDepartamento->SetDbValueDef($mer->idDepartamento->CurrentValue, 0);
		$rsnew['idDepartamento'] =& $mer->idDepartamento->DbValue;

		// Field idMunicipio
		$mer->idMunicipio->SetDbValueDef($mer->idMunicipio->CurrentValue, 0);
		$rsnew['idMunicipio'] =& $mer->idMunicipio->DbValue;

		// Field idComunidad
		$mer->idComunidad->SetDbValueDef($mer->idComunidad->CurrentValue, 0);
		$rsnew['idComunidad'] =& $mer->idComunidad->DbValue;

		// Field idRubro
		$mer->idRubro->SetDbValueDef($mer->idRubro->CurrentValue, 0);
		$rsnew['idRubro'] =& $mer->idRubro->DbValue;

		// Field mer
		$mer->mer->SetDbValueDef($mer->mer->CurrentValue, "");
		$rsnew['mer'] =& $mer->mer->DbValue;

		// Field unidadProductivaDedica
		$mer->unidadProductivaDedica->SetDbValueDef($mer->unidadProductivaDedica->CurrentValue, NULL);
		$rsnew['unidadProductivaDedica'] =& $mer->unidadProductivaDedica->DbValue;

		// Field codigo
		$mer->codigo->SetDbValueDef($mer->codigo->CurrentValue, NULL);
		$rsnew['codigo'] =& $mer->codigo->DbValue;

		// Field numeroSocios
		$mer->numeroSocios->SetDbValueDef($mer->numeroSocios->CurrentValue, NULL);
		$rsnew['numeroSocios'] =& $mer->numeroSocios->DbValue;

		// Field direccion
		$mer->direccion->SetDbValueDef($mer->direccion->CurrentValue, NULL);
		$rsnew['direccion'] =& $mer->direccion->DbValue;

		// Field zona
		$mer->zona->SetDbValueDef($mer->zona->CurrentValue, NULL);
		$rsnew['zona'] =& $mer->zona->DbValue;

		// Field referencia
		$mer->referencia->SetDbValueDef($mer->referencia->CurrentValue, NULL);
		$rsnew['referencia'] =& $mer->referencia->DbValue;

		// Field refTelefonica
		$mer->refTelefonica->SetDbValueDef($mer->refTelefonica->CurrentValue, NULL);
		$rsnew['refTelefonica'] =& $mer->refTelefonica->DbValue;

		// Field refCelular
		$mer->refCelular->SetDbValueDef($mer->refCelular->CurrentValue, NULL);
		$rsnew['refCelular'] =& $mer->refCelular->DbValue;

		// Field fechaInicio
		$mer->fechaInicio->SetDbValueDef(ew_UnFormatDateTime($mer->fechaInicio->CurrentValue, 7), NULL);
		$rsnew['fechaInicio'] =& $mer->fechaInicio->DbValue;

		// Field fechaFinal
		$mer->fechaFinal->SetDbValueDef(ew_UnFormatDateTime($mer->fechaFinal->CurrentValue, 7), NULL);
		$rsnew['fechaFinal'] =& $mer->fechaFinal->DbValue;

		// Field longitudUTM
		$mer->longitudUTM->SetDbValueDef($mer->longitudUTM->CurrentValue, 0);
		$rsnew['longitudUTM'] =& $mer->longitudUTM->DbValue;

		// Field latitudUTM
		$mer->latitudUTM->SetDbValueDef($mer->latitudUTM->CurrentValue, 0);
		$rsnew['latitudUTM'] =& $mer->latitudUTM->DbValue;

		// Field gestion
		$mer->gestion->SetDbValueDef($mer->gestion->CurrentValue, NULL);
		$rsnew['gestion'] =& $mer->gestion->DbValue;

		// Field estado
		
		// Field fechaCreacion
		$mer->fechaCreacion->SetDbValueDef(ew_UnFormatDateTime($mer->fechaCreacion->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fechaCreacion'] =& $mer->fechaCreacion->DbValue;

		// Field fechaModificacion
		$mer->fechaModificacion->SetDbValueDef(ew_UnFormatDateTime($mer->fechaModificacion->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fechaModificacion'] =& $mer->fechaModificacion->DbValue;

		// Call Row Inserting event
		$bInsertRow = $mer->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($mer->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($mer->CancelMessage <> "") {
				$this->setMessage($mer->CancelMessage);
				$mer->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$mer->idMer->setDbValue($conn->Insert_ID());
			$rsnew['idMer'] =& $mer->idMer->DbValue;

			// Call Row Inserted event
			$mer->Row_Inserted($rsnew);
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
