<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "consultoriainfo.php" ?>
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
if($_POST['btnAction']){

mysql_select_db($database_conexion, $conexion);
$query_ubicacion_consultoriadelete = "DELETE FROM ubicacion_consultoria WHERE idConsultoria=".(int)$_POST['x_idConsultoria'];
mysql_query($query_ubicacion_consultoriadelete, $conexion) or die(mysql_error());

$num_mers=count($_POST['x_idMer']);
for($i=0;$i<$num_mers;$i++){
mysql_select_db($database_conexion, $conexion);
$query_ubicacion_consultoriaadd = "INSERT INTO ubicacion_consultoria VALUES ('','".(int)$_POST['x_idConsultoria']."','".$_POST['idRegional'][$_POST['x_idMer'][$i]]."','".$_POST['idMunicipio'][$_POST['x_idMer'][$i]]."','".$_POST['x_idMer'][$i]."')";
mysql_query($query_ubicacion_consultoriaadd, $conexion) or die(mysql_error());
}
}
// Define page object
$consultoria_edit = new cconsultoria_edit();
$Page =& $consultoria_edit;

// Page init processing
$consultoria_edit->Page_Init();

// Page main processing
$consultoria_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var consultoria_edit = new ew_Page("consultoria_edit");

// page properties
consultoria_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = consultoria_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
consultoria_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idUsuario"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Consultor");
		elm = fobj.elements["x" + infix + "_consultoria"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Titulo de la Consultoria");
		elm = fobj.elements["x" + infix + "_fechaInicio"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Inicio");
		elm = fobj.elements["x" + infix + "_fechaInicio"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Inicio");
		elm = fobj.elements["x" + infix + "_fechaFinal"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Finalizacion");
		elm = fobj.elements["x" + infix + "_fechaFinal"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Finalizacion");
		elm = fobj.elements["x" + infix + "_estado"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Estado");
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
consultoria_edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
consultoria_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
consultoria_edit.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
var x;
x=$(document).ready(inicializarEventos)
function inicializarEventos()
{
    var v_contador=$("#contador").attr("value");
    var v_cont_reg=$("#cont_reg").attr("value");
    //alert (v_cont_reg);
    var i,v_municipio,v_regional;
    for(i=1;i<v_contador;i++){
       // v_municipio=$("#x_idMunicipio_"+i).attr("value");
        v_municipio=$("input[name='x_idMunicipio["+i+"]']:checked").val();
        if(v_municipio!='on'){
        $("#xdiv_"+i).hide();
        }
    }

    for(i=1;i<v_cont_reg;i++){
       // v_municipio=$("#x_idMunicipio_"+i).attr("value");
        v_regional=$("input[name='x_idRegional["+i+"]']:checked").val();
        if(v_regional!='on'){
        $("#table_municipios"+i).hide();
        }
    }
}
function func_habilitar_mers(x){
//var v_municipio=$("#x_idMunicipio_"+x).attr("checkbox");
var v_municipio=$("input[name='x_idMunicipio["+x+"]']:checked").val();
//alert(v_municipio);
if(v_municipio=='on'){
var mostrar=$("#xdiv_"+x);
mostrar.show();
}else{
var mostrar=$("#xdiv_"+x);
mostrar.hide();
}
}
function func_habilitar_municipios(x){
//var v_municipio=$("#x_idMunicipio_"+x).attr("checkbox");
var v_regional=$("input[name='x_idRegional["+x+"]']:checked").val();
//alert(v_municipio);
if(v_regional=='on'){
var mostrar=$("#table_municipios"+x);
mostrar.show();
}else{
var mostrar=$("#table_municipios"+x);
mostrar.hide();
}
}
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
<p><span class="phpmaker">Editar TABLA: Consultoria<br><br>
<a href="<?php echo $consultoria->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $consultoria_edit->ShowMessage() ?>
<form name="fconsultoriaedit" id="fconsultoriaedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return consultoria_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="consultoria">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($consultoria->idConsultoria->Visible) { // idConsultoria ?>
	<tr<?php echo $consultoria->idConsultoria->RowAttributes ?>>
		<td class="ewTableHeader">Nro</td>
		<td<?php echo $consultoria->idConsultoria->CellAttributes() ?>><span id="el_idConsultoria">
<div<?php echo $consultoria->idConsultoria->ViewAttributes() ?>><?php echo $consultoria->idConsultoria->EditValue ?></div>
<input type="hidden" name="x_idConsultoria" id="x_idConsultoria" value="<?php echo ew_HtmlEncode($consultoria->idConsultoria->CurrentValue) ?>">
</span><?php echo $consultoria->idConsultoria->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($consultoria->idUsuario->Visible) { // idUsuario ?>
	<tr<?php echo $consultoria->idUsuario->RowAttributes ?>>
		<td class="ewTableHeader">Consultor<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $consultoria->idUsuario->CellAttributes() ?>><span id="el_idUsuario">
<select id="x_idUsuario" name="x_idUsuario"<?php echo $consultoria->idUsuario->EditAttributes() ?>>
<?php
if (is_array($consultoria->idUsuario->EditValue)) {
	$arwrk = $consultoria->idUsuario->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($consultoria->idUsuario->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1]." ".$arwrk[$rowcntwrk][2] ?>
<?php if ($arwrk[$rowcntwrk][3] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][3] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $consultoria->idUsuario->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($consultoria->consultoria->Visible) { // consultoria ?>
	<tr<?php echo $consultoria->consultoria->RowAttributes ?>>
		<td class="ewTableHeader">Titulo de la Consultoria<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $consultoria->consultoria->CellAttributes() ?>><span id="el_consultoria">
<textarea name="x_consultoria" id="x_consultoria" cols="70" rows="2"<?php echo $consultoria->consultoria->EditAttributes() ?>><?php echo $consultoria->consultoria->EditValue ?></textarea>
</span><?php echo $consultoria->consultoria->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($consultoria->fechaInicio->Visible) { // fechaInicio ?>
	<tr<?php echo $consultoria->fechaInicio->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Inicio<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $consultoria->fechaInicio->CellAttributes() ?>><span id="el_fechaInicio">
<input type="text" name="x_fechaInicio" id="x_fechaInicio" value="<?php echo $consultoria->fechaInicio->EditValue ?>"<?php echo $consultoria->fechaInicio->EditAttributes() ?>>
&nbsp;<img src="images/calendar.png" id="cal_x_fechaInicio" name="cal_x_fechaInicio" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x_fechaInicio", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "cal_x_fechaInicio" // ID of the button
});
</script>
</span><?php echo $consultoria->fechaInicio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($consultoria->fechaFinal->Visible) { // fechaFinal ?>
	<tr<?php echo $consultoria->fechaFinal->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Finalizacion<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $consultoria->fechaFinal->CellAttributes() ?>><span id="el_fechaFinal">
<input type="text" name="x_fechaFinal" id="x_fechaFinal" value="<?php echo $consultoria->fechaFinal->EditValue ?>"<?php echo $consultoria->fechaFinal->EditAttributes() ?>>
&nbsp;<img src="images/calendar.png" id="cal_x_fechaFinal" name="cal_x_fechaFinal" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x_fechaFinal", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "cal_x_fechaFinal" // ID of the button
});
</script>
</span><?php echo $consultoria->fechaFinal->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($consultoria->estado->Visible) { // estado ?>
        <input type="hidden" name="x_estado" id="x_estado" value="<?php echo strval($consultoria->estado->CurrentValue) ?>">
<?php } ?>
<?php if ($consultoria->fechaModificacion->Visible) { // fechaModificacion ?>
<input type="hidden" name="x_fechaModificacion" id="x_fechaModificacion" value="<?php echo date("d/m/Y") ?>">
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<thead>
<tr class="ewTableHeader">
    <td>Regional</td>
    <td>&nbsp;</td>
</tr>
</thead>
<tbody align="right">
<?php
mysql_select_db($database_conexion, $conexion);
$query_mostrar_regional = "SELECT * FROM regional ORDER BY regional ASC";
$mostrar_regional= mysql_query($query_mostrar_regional, $conexion) or die(mysql_error());
$totalRows_regional= mysql_num_rows($mostrar_regional);
$cont_reg=1;
$contador=1;
while($row_regional=mysql_fetch_assoc($mostrar_regional)){
mysql_select_db($database_conexion, $conexion);
$query_mostrar_municipio = "SELECT idMunicipio,municipio FROM municipio WHERE idRegional = ".(int)$row_regional['idRegional']." ORDER BY municipio ASC";
$mostrar_municipio = mysql_query($query_mostrar_municipio, $conexion) or die(mysql_error());
$totalRows_municipio = mysql_num_rows($mostrar_municipio);
//$municipio_mers=array();
mysql_select_db($database_conexion, $conexion);
$query_idRegional = "SELECT idRegional FROM ubicacion_consultoria WHERE idConsultoria = ".(int)$_GET['idConsultoria']." AND idRegional=".$row_regional['idRegional']."";
$mostrar_idRegional= mysql_query($query_idRegional, $conexion) or die(mysql_error());
$row_idRegional= mysql_fetch_assoc($mostrar_idRegional);
$total_idRegional= mysql_num_rows($mostrar_idRegional);
?>
    <tr>
    <td><?php echo $row_regional['regional'];?>
    <input type="checkbox" id="x_idRegional<?php echo $cont_reg?>" name="x_idRegional[<?php echo $cont_reg?>]" onclick="func_habilitar_municipios('<?php echo $cont_reg?>')" <?php if($total_idRegional>0){echo "checked";} ?>/>
    </td>
    <td>
        <table id="table_municipios<?php echo $cont_reg?>" cellspacing="0" class="ewTable">
<?php if($totalRows_municipio>0){?>
    <tr class="ewTableHeader">
        <td>Municipio</td>
        <td>Mers</td>
    </tr>
<?php

while($row_municipio = mysql_fetch_assoc($mostrar_municipio)){
mysql_select_db($database_conexion, $conexion);
$query_mostrar_mers = "SELECT idMer,mer FROM mer WHERE idRegional = ".(int)$row_regional['idRegional']." AND idMunicipio=".$row_municipio['idMunicipio']." AND estado>'0' ORDER BY mer ASC";
$mostrar_mers = mysql_query($query_mostrar_mers, $conexion) or die(mysql_error());
$totalRows_mers = mysql_num_rows($mostrar_mers);
if($totalRows_mers>0){
mysql_select_db($database_conexion, $conexion);
$query_idMunicipio = "SELECT idMunicipio FROM ubicacion_consultoria WHERE idConsultoria = ".(int)$_GET['idConsultoria']." AND idMunicipio=".$row_municipio['idMunicipio']."";
$mostrar_idMunicipio= mysql_query($query_idMunicipio, $conexion) or die(mysql_error());
$row_idMunicipio= mysql_fetch_assoc($mostrar_idMunicipio);
$total_idMunicipio= mysql_num_rows($mostrar_idMunicipio);
    ?>
    <tr>
    <td><?php echo $row_municipio['municipio'];?>
<input type="checkbox" id="x_idMunicipio_<?php echo $contador?>" name="x_idMunicipio[<?php echo $contador?>]" onclick="func_habilitar_mers('<?php echo $contador?>')" <?php if($total_idMunicipio>0){echo "checked";} ?>/>
</td>
<td>
<div id="xdiv_<?php echo $contador?>">
<?php while($row_mers=mysql_fetch_assoc($mostrar_mers)){
mysql_select_db($database_conexion, $conexion);
$query_idMer= "SELECT idMer FROM ubicacion_consultoria WHERE idConsultoria = ".(int)$_GET['idConsultoria']." AND idMer=".$row_mers['idMer']."";
$mostrar_idMer= mysql_query($query_idMer, $conexion) or die(mysql_error());
$row_idMer= mysql_fetch_assoc($mostrar_idMer);
$total_idMer= mysql_num_rows($mostrar_idMer);

?>
            <div><?php echo $row_mers['mer']?>
                <input type="checkbox" name="x_idMer[]" value="<?php echo $row_mers['idMer']?>" <?php if($total_idMer>0){echo "checked";} ?>/>
                <input type="hidden" name="idMunicipio[<?php echo $row_mers['idMer'];?>]" value="<?php echo $row_municipio['idMunicipio']?>"/>
                <input type="hidden" name="idRegional[<?php echo $row_mers['idMer'];?>]" value="<?php echo $row_regional['idRegional']?>"/>
            </div>
                <?php } ?>
        </div>
        </td>
    </tr>
    <?php
      $contador++;
    }
    } ?>
<?php }?>
</table>
</td>
</tr>
<?php
$cont_reg++;
} ?>
</tbody></table></div></td></tr></table>
<input type="hidden" name="contador" id="contador" value="<?php echo $contador?>">
<input type="hidden" name="cont_reg" id="cont_reg" value="<?php echo $cont_reg?>">
<input type="submit" name="btnAction" id="btnAction" value="  EDITAR  ">
</form>
<script language="JavaScript" type="text/javascript">
func_municipio_mer();
</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cconsultoria_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'consultoria';

	// Page Object Name
	var $PageObjName = 'consultoria_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $consultoria;
		if ($consultoria->UseTokenInUrl) $PageUrl .= "t=" . $consultoria->TableVar . "&"; // add page token
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
		global $objForm, $consultoria;
		if ($consultoria->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($consultoria->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($consultoria->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cconsultoria_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["consultoria"] = new cconsultoria();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'consultoria', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $consultoria;
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
			$this->Page_Terminate("consultorialist.php");
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
		global $objForm, $gsFormError, $consultoria;

		// Load key from QueryString
		if (@$_GET["idConsultoria"] <> "")
			$consultoria->idConsultoria->setQueryStringValue($_GET["idConsultoria"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$consultoria->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$consultoria->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$consultoria->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($consultoria->idConsultoria->CurrentValue == "")
			$this->Page_Terminate("consultorialist.php"); // Invalid key, return to list
		switch ($consultoria->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No se encontraron registros"); // No record found
					$this->Page_Terminate("consultorialist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$consultoria->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Update success
					$sReturnUrl = $consultoria->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$consultoria->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $consultoria;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $consultoria;
		$consultoria->idConsultoria->setFormValue($objForm->GetValue("x_idConsultoria"));
		$consultoria->idUsuario->setFormValue($objForm->GetValue("x_idUsuario"));
		$consultoria->consultoria->setFormValue($objForm->GetValue("x_consultoria"));
		$consultoria->fechaInicio->setFormValue($objForm->GetValue("x_fechaInicio"));
		$consultoria->fechaInicio->CurrentValue = ew_UnFormatDateTime($consultoria->fechaInicio->CurrentValue, 7);
		$consultoria->fechaFinal->setFormValue($objForm->GetValue("x_fechaFinal"));
		$consultoria->fechaFinal->CurrentValue = ew_UnFormatDateTime($consultoria->fechaFinal->CurrentValue, 7);
		$consultoria->estado->setFormValue($objForm->GetValue("x_estado"));
		$consultoria->fechaModificacion->setFormValue($objForm->GetValue("x_fechaModificacion"));
		$consultoria->fechaModificacion->CurrentValue = ew_UnFormatDateTime($consultoria->fechaModificacion->CurrentValue, 7);
	}

	// Restore form values
	function RestoreFormValues() {
		global $consultoria;
		$this->LoadRow();
		$consultoria->idConsultoria->CurrentValue = $consultoria->idConsultoria->FormValue;
		$consultoria->idUsuario->CurrentValue = $consultoria->idUsuario->FormValue;
		$consultoria->consultoria->CurrentValue = $consultoria->consultoria->FormValue;
		$consultoria->fechaInicio->CurrentValue = $consultoria->fechaInicio->FormValue;
		$consultoria->fechaInicio->CurrentValue = ew_UnFormatDateTime($consultoria->fechaInicio->CurrentValue, 7);
		$consultoria->fechaFinal->CurrentValue = $consultoria->fechaFinal->FormValue;
		$consultoria->fechaFinal->CurrentValue = ew_UnFormatDateTime($consultoria->fechaFinal->CurrentValue, 7);
		$consultoria->estado->CurrentValue = $consultoria->estado->FormValue;
		$consultoria->fechaModificacion->CurrentValue = $consultoria->fechaModificacion->FormValue;
		$consultoria->fechaModificacion->CurrentValue = ew_UnFormatDateTime($consultoria->fechaModificacion->CurrentValue, 7);
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $consultoria;
		$sFilter = $consultoria->KeyFilter();

		// Call Row Selecting event
		$consultoria->Row_Selecting($sFilter);

		// Load sql based on filter
		$consultoria->CurrentFilter = $sFilter;
		$sSql = $consultoria->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$consultoria->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $consultoria;
		$consultoria->idConsultoria->setDbValue($rs->fields('idConsultoria'));
		$consultoria->idUsuario->setDbValue($rs->fields('idUsuario'));
		$consultoria->consultoria->setDbValue($rs->fields('consultoria'));
		$consultoria->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$consultoria->fechaFinal->setDbValue($rs->fields('fechaFinal'));
		$consultoria->estado->setDbValue($rs->fields('estado'));
		$consultoria->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$consultoria->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $consultoria;

		// Call Row_Rendering event
		$consultoria->Row_Rendering();

		// Common render codes for all row types
		// idConsultoria

		$consultoria->idConsultoria->CellCssStyle = "";
		$consultoria->idConsultoria->CellCssClass = "";

		// idUsuario
		$consultoria->idUsuario->CellCssStyle = "";
		$consultoria->idUsuario->CellCssClass = "";

		// consultoria
		$consultoria->consultoria->CellCssStyle = "";
		$consultoria->consultoria->CellCssClass = "";

		// fechaInicio
		$consultoria->fechaInicio->CellCssStyle = "";
		$consultoria->fechaInicio->CellCssClass = "";

		// fechaFinal
		$consultoria->fechaFinal->CellCssStyle = "";
		$consultoria->fechaFinal->CellCssClass = "";

		// estado
		$consultoria->estado->CellCssStyle = "";
		$consultoria->estado->CellCssClass = "";

		// fechaModificacion
		$consultoria->fechaModificacion->CellCssStyle = "";
		$consultoria->fechaModificacion->CellCssClass = "";
		if ($consultoria->RowType == EW_ROWTYPE_VIEW) { // View row

			// idConsultoria
			$consultoria->idConsultoria->ViewValue = $consultoria->idConsultoria->CurrentValue;
			$consultoria->idConsultoria->CssStyle = "";
			$consultoria->idConsultoria->CssClass = "";
			$consultoria->idConsultoria->ViewCustomAttributes = "";

			// idUsuario
			if (strval($consultoria->idUsuario->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `paterno`, `nombre` FROM `usuario` WHERE `idUsuario` = " . ew_AdjustSql($consultoria->idUsuario->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `paterno` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$consultoria->idUsuario->ViewValue = $rswrk->fields('paterno');
					$consultoria->idUsuario->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('nombre');
					$rswrk->Close();
				} else {
					$consultoria->idUsuario->ViewValue = $consultoria->idUsuario->CurrentValue;
				}
			} else {
				$consultoria->idUsuario->ViewValue = NULL;
			}
			$consultoria->idUsuario->CssStyle = "";
			$consultoria->idUsuario->CssClass = "";
			$consultoria->idUsuario->ViewCustomAttributes = "";

			// consultoria
			$consultoria->consultoria->ViewValue = $consultoria->consultoria->CurrentValue;
			$consultoria->consultoria->CssStyle = "";
			$consultoria->consultoria->CssClass = "";
			$consultoria->consultoria->ViewCustomAttributes = "";

			// fechaInicio
			$consultoria->fechaInicio->ViewValue = $consultoria->fechaInicio->CurrentValue;
			$consultoria->fechaInicio->ViewValue = ew_FormatDateTime($consultoria->fechaInicio->ViewValue, 7);
			$consultoria->fechaInicio->CssStyle = "";
			$consultoria->fechaInicio->CssClass = "";
			$consultoria->fechaInicio->ViewCustomAttributes = "";

			// fechaFinal
			$consultoria->fechaFinal->ViewValue = $consultoria->fechaFinal->CurrentValue;
			$consultoria->fechaFinal->ViewValue = ew_FormatDateTime($consultoria->fechaFinal->ViewValue, 7);
			$consultoria->fechaFinal->CssStyle = "";
			$consultoria->fechaFinal->CssClass = "";
			$consultoria->fechaFinal->ViewCustomAttributes = "";

			// estado
			if (strval($consultoria->estado->CurrentValue) <> "") {
				switch ($consultoria->estado->CurrentValue) {
					case "0":
						$consultoria->estado->ViewValue = "borrado";
						break;
					case "1":
						$consultoria->estado->ViewValue = "Habilitado";
						break;
					case "2":
						$consultoria->estado->ViewValue = "Desabilitado";
						break;
					case "3":
						$consultoria->estado->ViewValue = "Aprobado";
						break;
					default:
						$consultoria->estado->ViewValue = $consultoria->estado->CurrentValue;
				}
			} else {
				$consultoria->estado->ViewValue = NULL;
			}
			$consultoria->estado->CssStyle = "";
			$consultoria->estado->CssClass = "";
			$consultoria->estado->ViewCustomAttributes = "";

			// fechaModificacion
			$consultoria->fechaModificacion->ViewValue = $consultoria->fechaModificacion->CurrentValue;
			$consultoria->fechaModificacion->ViewValue = ew_FormatDateTime($consultoria->fechaModificacion->ViewValue, 7);
			$consultoria->fechaModificacion->CssStyle = "";
			$consultoria->fechaModificacion->CssClass = "";
			$consultoria->fechaModificacion->ViewCustomAttributes = "";

			// idConsultoria
			$consultoria->idConsultoria->HrefValue = "";

			// idUsuario
			$consultoria->idUsuario->HrefValue = "";

			// consultoria
			$consultoria->consultoria->HrefValue = "";

			// fechaInicio
			$consultoria->fechaInicio->HrefValue = "";

			// fechaFinal
			$consultoria->fechaFinal->HrefValue = "";

			// estado
			$consultoria->estado->HrefValue = "";

			// fechaModificacion
			$consultoria->fechaModificacion->HrefValue = "";
		} elseif ($consultoria->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idConsultoria
			$consultoria->idConsultoria->EditCustomAttributes = "";
			$consultoria->idConsultoria->EditValue = $consultoria->idConsultoria->CurrentValue;
			$consultoria->idConsultoria->CssStyle = "";
			$consultoria->idConsultoria->CssClass = "";
			$consultoria->idConsultoria->ViewCustomAttributes = "";

			// idUsuario
			$consultoria->idUsuario->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idUsuario`, `paterno`,`materno`, `nombre`, '' AS SelectFilterFld FROM `usuario`";
			$sWhereWrk = "idRol='3'";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `paterno` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione", ""));
			$consultoria->idUsuario->EditValue = $arwrk;

			// consultoria
			$consultoria->consultoria->EditCustomAttributes = "";
			$consultoria->consultoria->EditValue = ew_HtmlEncode($consultoria->consultoria->CurrentValue);

			// fechaInicio
			$consultoria->fechaInicio->EditCustomAttributes = "";
			$consultoria->fechaInicio->EditValue = ew_HtmlEncode(ew_FormatDateTime($consultoria->fechaInicio->CurrentValue, 7));

			// fechaFinal
			$consultoria->fechaFinal->EditCustomAttributes = "";
			$consultoria->fechaFinal->EditValue = ew_HtmlEncode(ew_FormatDateTime($consultoria->fechaFinal->CurrentValue, 7));

			// estado
			$consultoria->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("0", "borrado");
			$arwrk[] = array("1", "Habilitado");
			$arwrk[] = array("2", "Desabilitado");
			$arwrk[] = array("3", "Aprobado");
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$consultoria->estado->EditValue = $arwrk;

			// fechaModificacion
			$consultoria->fechaModificacion->EditCustomAttributes = "";
			$consultoria->fechaModificacion->EditValue = ew_HtmlEncode(ew_FormatDateTime($consultoria->fechaModificacion->CurrentValue, 7));

			// Edit refer script
			// idConsultoria

			$consultoria->idConsultoria->HrefValue = "";

			// idUsuario
			$consultoria->idUsuario->HrefValue = "";

			// consultoria
			$consultoria->consultoria->HrefValue = "";

			// fechaInicio
			$consultoria->fechaInicio->HrefValue = "";

			// fechaFinal
			$consultoria->fechaFinal->HrefValue = "";

			// estado
			$consultoria->estado->HrefValue = "";

			// fechaModificacion
			$consultoria->fechaModificacion->HrefValue = "";
		}

		// Call Row Rendered event
		$consultoria->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $consultoria;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($consultoria->idUsuario->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Consultor";
		}
		if ($consultoria->consultoria->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Titulo de la Consultoria";
		}
		if ($consultoria->fechaInicio->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Inicio";
		}
		if (!ew_CheckEuroDate($consultoria->fechaInicio->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Inicio";
		}
		if ($consultoria->fechaFinal->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Finalizacion";
		}
		if (!ew_CheckEuroDate($consultoria->fechaFinal->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Finalizacion";
		}
		if ($consultoria->estado->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Estado";
		}
		if ($consultoria->fechaModificacion->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Modificacion";
		}
		if (!ew_CheckEuroDate($consultoria->fechaModificacion->FormValue)) {
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $consultoria;
		$sFilter = $consultoria->KeyFilter();
		$consultoria->CurrentFilter = $sFilter;
		$sSql = $consultoria->SQL();
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

			// Field idConsultoria
			// Field idUsuario

			$consultoria->idUsuario->SetDbValueDef($consultoria->idUsuario->CurrentValue, 0);
			$rsnew['idUsuario'] =& $consultoria->idUsuario->DbValue;

			// Field consultoria
			$consultoria->consultoria->SetDbValueDef($consultoria->consultoria->CurrentValue, "");
			$rsnew['consultoria'] =& $consultoria->consultoria->DbValue;

			// Field fechaInicio
			$consultoria->fechaInicio->SetDbValueDef(ew_UnFormatDateTime($consultoria->fechaInicio->CurrentValue, 7), ew_CurrentDate());
			$rsnew['fechaInicio'] =& $consultoria->fechaInicio->DbValue;

			// Field fechaFinal
			$consultoria->fechaFinal->SetDbValueDef(ew_UnFormatDateTime($consultoria->fechaFinal->CurrentValue, 7), ew_CurrentDate());
			$rsnew['fechaFinal'] =& $consultoria->fechaFinal->DbValue;

			// Field estado
			$consultoria->estado->SetDbValueDef($consultoria->estado->CurrentValue, 0);
			$rsnew['estado'] =& $consultoria->estado->DbValue;

			// Field fechaModificacion
			$consultoria->fechaModificacion->SetDbValueDef(ew_UnFormatDateTime($consultoria->fechaModificacion->CurrentValue, 7), ew_CurrentDate());
			$rsnew['fechaModificacion'] =& $consultoria->fechaModificacion->DbValue;

			// Call Row Updating event
			$bUpdateRow = $consultoria->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($consultoria->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($consultoria->CancelMessage <> "") {
					$this->setMessage($consultoria->CancelMessage);
					$consultoria->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$consultoria->Row_Updated($rsold, $rsnew);
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
