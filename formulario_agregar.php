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
$formulario_list = new cformulario_list();
$Page =& $formulario_list;

// Page init processing
$formulario_list->Page_Init();

// Page main processing
$formulario_list->Page_Main();
?>
<script type="text/javascript" charset="utf-8">
    Date.firstDayOfWeek = 0;
    Date.format = 'dd-mm-yyyy';
    $(function(){
        $('.date-pick').datePicker({createButton:false,startDate:'01-01-1990'})
        .bind('click',
        function(){
            $(this).dpDisplay();
            this.blur();
            return false;
        }
    );
    });
    //Formato del calendario
</script>
<script type="text/javascript">
    var x=$(document);
    x.ready(inicializarEventos);
    function inicializarEventos()
    {
        var nro,tipo,registro,fi,ff,valor;
        nro=$("#x_nroContrato");
        nro.blur(presion);
        tipo=$("#x_idTipoContrato");
        tipo.change(presion);
        registro=$("#x_idRegistroContrato");
        registro.change(presion);
        fi=$("#x_fechaInicio");
        fi.change(presion);
        ff=$("#x_fechaFinal");
        ff.change(presion);
        valor=$("#x_valor");
        valor.blur(presion);
        $(":radio").click(presion);
    }
    function presion()
    {
        var t=$("#x_nroContrato").attr("value");
        var x=$("#x_idTipoContrato").attr("value");
        var y=$("#x_idRegistroContrato").attr("value");
        var z=$("#x_fechaInicio").attr("value");
        var w=$("#x_fechaFinal").attr("value");
        var s=$("#x_valor").attr("value");
        var p=$("#x_completo");
        var q=$("#x_certConformidad");
        var contador=$("#totalPregunta").attr("value");
        var cont=0,i,str,aux2;
         if("<?php echo $_GET['idPlanilla']?>"!='20'){
         for(i=1;i<=contador;i++)
            {str = $("input[name='resp_"+i+"']:checked").val();
                if(str=='SI'){cont++;}
            }
            aux2=cont*100/contador;
          }else{aux2=100;}
            //p.attr("value",aux2);
        if(t && x && y && z && w && s && aux2=='100'){
            p.attr("value","SI");
            if("<?php echo $_GET['idPlanilla']?>"=='20'){q.attr("value",t);}
        }
        else{p.attr("value","NO");
            if("<?php echo $_GET['idPlanilla']?>"=='20')
            {q.attr("value",'');}
        }
    }
</script>
<script type="text/javascript">
    var x=$(document);
    x.ready(inicializarEventos);
    function inicializarEventos()
    {
        var nro,tipo,nombreComprador,detalle,precioUnitario,cantidad,valor,fecha;
        nro=$("#x_nro");
        nro.blur(presion17);
        tipo=$("#x_tipo");
        tipo.blur(presion17);
        nombreComprador=$("#x_nombreComprador");
        nombreComprador.blur(presion17);
        detalle=$("#x_detalle");
        detalle.blur(presion17);
        precioUnitario=$("#x_precioUnitario");
        precioUnitario.blur(presion17);
        cantidad=$("#x_cantidad");
        cantidad.blur(presion17);
//        valor=$("#x_valor");
//        valor.blur(presion);
        fecha=$("#x_fecha");
        fecha.change(presion17);
    }
    function presion17()
    {
        var t=$("#x_nro").attr("value");
        var x=$("#x_tipo").attr("value");
        var y=$("#x_nombreComprador").attr("value");
        var z=$("#x_detalle").attr("value");
        var w=$("#x_precioUnitario").attr("value");
        var s=$("#x_cantidad").attr("value");
        var r=$("#x_valor");
        var p=$("#x_fecha").attr("value");
        var q=$("#x_cumple");
        if(t && x && y && z && w && s && p){ q.attr("value","SI");}
        else{q.attr("value","NO");}
        r.attr("value",w*s);
    }
</script>
<?php 
if($_GET['idPlanilla']!='17'){

if($_GET['idPlanilla']=='16'){ 
mysql_select_db($database_conexion, $conexion);
$query_obtencionCredito = "SELECT * FROM obtencion_credito16 WHERE idObtencionCredito='".(int)$_GET['x_idObtencionCredito']."'";
$mostrar_obtencionCredito= mysql_query($query_obtencionCredito, $conexion) or die(mysql_error());
$row_obtencionCredito=mysql_fetch_assoc($mostrar_obtencionCredito);
    ?>
<form method="post" action="formulario_guardar.php" id="formulario">
    <table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
        <tr class="ewTableHeader">
            <td>Nro</td><td>Solicitud</td><td>Entidad Financiera</td><td>Prestamo</td><td>Monto Solicitado</td><td>Mora</td><td>Fecha Ultimo Recibo</td><td></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><select name="x_solicitud" id="x_solicitud">
                    <option>Seleccione...</option>
                    <option value="SI" <?php if($row_obtencionCredito['solicitud']=='SI'){echo "selected";}?>>SI</option>
                    <option value="NO" <?php if($row_obtencionCredito['solicitud']=='NO'){echo "selected";}?>>NO</option>
                </select></td>
                <td><input name="x_entidadFinanciera" id="x_entidadFinanciera" type="text" size="50" value="<?php echo $row_obtencionCredito['entidadFinanciera']?>"></td>
            <td><select name="x_prestamo" id="x_prestamo">
                    <option>Seleccione...</option>
                    <option value="SI" <?php if($row_obtencionCredito['prestamo']=='SI'){echo "selected";}?>>SI</option>
                    <option value="NO" <?php if($row_obtencionCredito['prestamo']=='NO'){echo "selected";}?>>NO</option>
                </select></td>
                <td><input name="x_montoSolicitado" id="x_montoSolicitado" type="text" size="10" value="<?php echo $row_obtencionCredito['montoSolicitado']?>"></td>
                            <td><select name="x_mora" id="x_mora">
                    <option>Seleccione...</option>
                    <option value="SI" <?php if($row_obtencionCredito['mora']=='SI'){echo "selected";}?>>SI</option>
                    <option value="NO" <?php if($row_obtencionCredito['mora']=='NO'){echo "selected";}?>>NO</option>
                </select></td>
                <td><input name="x_fechaUltimoRecibo" id="x_fechaUltimoRecibo" type="text" class="date-pick" size="12" <?php if($_GET['sw']=='obtencionCreditoedit' and $row_obtencionCredito['fechaUltimoRecibo']!='0000-00-00') {echo "value=".date("d-m-Y",strtotime($row_obtencionCredito['fechaUltimoRecibo']));}?>></td>
<input type="hidden" name="x_idPlanilla" id="x_idPlanilla" value="<?php echo $_GET['idPlanilla']?>">
<input type="hidden" name="x_idMer" id="x_idMer" value="<?php echo $_GET['idMer']?>">
<input type="hidden" name="sw" id="sw" value="<?php echo $_GET['sw']?>">
<input type="hidden" name="x_idObtencionCredito" id="x_idObtencionCredito" value="<?php echo $_GET['x_idObtencionCredito']?>">
                <td><input type="submit" name="guardar" id="guardar" value="Guardar"><input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cancelar();"></td>
        </tr>
    </table></form>

<script language="javascript" type="text/javascript">
    $(document).ready(function(){
        $("#formulario").validate({
            rules:{
                x_montoSolicitado:{number:true},
                x_fechaUltimoRecibo:{date:true}
                },
            messages: {
                x_montoSolicitado:"valor numerico",
                x_fechaUltimoRecibo:"fecha Incorrecta"
            },
            onkeyup: false,
            submitHandler: function(form) {
                //                var respuesta = confirm('\xBFEsta seguro de realizar la operacion?')
                //                if (respuesta)
                form.submit();
            }
        });
    });


</script>

<?php }
else{
mysql_select_db($database_conexion, $conexion);
$query_tipoContrato = "SELECT * FROM tipo_contrato WHERE idPlanilla='".(int)$_GET['idPlanilla']."'";
$mostrar_tipoContrato= mysql_query($query_tipoContrato, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query_registroContrato = "SELECT * FROM registro_contrato WHERE idPlanilla='".(int)$_GET['idPlanilla']."'";
$mostrar_registroContrato= mysql_query($query_registroContrato, $conexion) or die(mysql_error());

// si las preguntas todavia no estan guardados
if($_GET['sw']=="contratoadd"){
mysql_select_db($database_conexion, $conexion);
$query_pregunta = "SELECT * FROM pregunta WHERE idPlanilla='".(int)$_GET['idPlanilla']."'";
$mostrar_pregunta= mysql_query($query_pregunta, $conexion) or die(mysql_error());
$totalRows_pregunta= mysql_num_rows($mostrar_pregunta);
}

if($_GET['sw']=='contratoedit' || $_GET['sw']=='contratoview') {
    mysql_select_db($database_conexion, $conexion);
    $query_contratoLlenar1 = "SELECT * FROM contrato_llenar WHERE idCL='".(int)$_GET['x_idCL']."'";
    $mostrar_contratoLlenar1= mysql_query($query_contratoLlenar1, $conexion) or die(mysql_error());
    $row_contratoLlenar1=mysql_fetch_assoc($mostrar_contratoLlenar1);

    mysql_select_db($database_conexion, $conexion);
    $query_preguntaRespuesta1= "SELECT a.*,b.pregunta FROM pregunta_respuesta a, pregunta b WHERE a.idCL='".(int)$_GET['x_idCL']."' AND a.idPlanilla='".(int)$_GET['idPlanilla']."' AND a.idMer='".(int)$_GET['idMer']."' AND a.idPregunta>0 AND a.idPregunta=b.idPregunta";
    $mostrar_pregunta= mysql_query($query_preguntaRespuesta1, $conexion) or die(mysql_error());
    $totalRows_pregunta= mysql_num_rows($mostrar_pregunta);
    
}
?>

<form method="post" action="formulario_guardar.php" id="formulario">
    <table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
     <?php if($_GET['sw']!='contratoview'){?><tr class="ewTableHeader">
                
            <td><?php if($_GET['idPlanilla']=='1') {?>Nro.<?php } ?><?php if($_GET['idPlanilla']=='20') {?>Nro. de Empleos<?php } ?></td>
            <td>Tipo Contrato</td>
            <td>Registro por Recibos/planillas</td>
            <td>Fecha Inicio</td>
            <td>Fecha Finalizaci&oacute;n</td>
            <td>Precio Bs.</td>
            <td>Completo</td>
            <?php if($_GET['idPlanilla']=='1') {?>
            <td>Cert. conformidad</td>
                <?php } ?>
            <?php if($_GET['idPlanilla']=='20') {?>
            <td>Valor</td>
                <?php } ?>
        </tr>
        <?php } ?>
        <tr>
        <?php if($_GET['sw']!='contratoview'){?>
        <input type="hidden" name="totalPregunta" id="totalPregunta" value="<?php echo $totalRows_pregunta?>">
        <input type="hidden" name="x_idPlanilla" id="x_idPlanilla" value="<?php echo $_GET['idPlanilla']?>">
        <input type="hidden" name="x_idMer" id="x_idMer" value="<?php echo $_GET['idMer']?>">
        <input type="hidden" name="sw" id="sw" value="<?php echo $_GET['sw']?>">
        <input type="hidden" name="x_idCL" id="x_idCL" value="<?php echo $_GET['x_idCL']?>">
        <td>
        <?php if($_GET['idPlanilla']=='1' || $_GET['idPlanilla']=='14' ) {?><input type="hidden" name="x_nroContrato" id="x_nroContrato" value="99" size="5">&nbsp;<?php } ?>
        <?php if($_GET['idPlanilla']=='20') {?><input type="text" name="x_nroContrato" id="x_nroContrato" value="<?php echo $row_contratoLlenar1['nroContrato']?>" size="5"><?php } ?>
        </td>
        <td>
            <select name="x_idTipoContrato" id="x_idTipoContrato">
                <option>Seleccione...</option>
                <?php while ($row_tipoContrato= mysql_fetch_assoc($mostrar_tipoContrato)) {?>
                <option value="<?php echo $row_tipoContrato['idTipoContrato'];?>" <?php if($row_tipoContrato['idTipoContrato']==$row_contratoLlenar1['idTipoContrato']) {
                        echo 'selected';
    } ?> ><?php echo utf8_encode($row_tipoContrato['tipoContrato']);?></option>
    <?php } ?>
            </select>
        </td>
        <td>
            <select name="x_idRegistroContrato" id="x_idRegistroContrato">
                <option>Seleccione...</option>
                <?php while ($row_registroContrato= mysql_fetch_assoc($mostrar_registroContrato)) {?>
                <option value="<?php echo $row_registroContrato['idRegistroContrato'];?>" <?php if($row_registroContrato['idRegistroContrato']==$row_contratoLlenar1['idRegistroContrato']) {
        echo 'selected';
    } ?>><?php echo utf8_encode($row_registroContrato['registroContrato']);?></option>
    <?php } ?>
            </select>
        </td>
        <td><input type="text" name="x_fechaInicio" id="x_fechaInicio" class="date-pick" size="12" <?php if($_GET['sw']=='contratoedit' and $row_contratoLlenar1['fechaInicio']!='0000-00-00') {
    echo "value=".date("d-m-Y",strtotime($row_contratoLlenar1['fechaInicio']));
}?>>
        <td><input type="text" name="x_fechaFinal" id="x_fechaFinal" class="date-pick" size="12" <?php if($_GET['sw']=='contratoedit' and $row_contratoLlenar1['fechaFinal']!='0000-00-00') {
    echo "value=".date("d-m-Y",strtotime($row_contratoLlenar1['fechaFinal']));
}?>></td>
        <td><input type="text" name="x_valor" id="x_valor" <?php if($_GET['sw']=='contratoedit' and $row_contratoLlenar1['valor']!='0') {
            echo "value=".$row_contratoLlenar1['valor'];
        }?> size="10"></td>
        <td><input type="text" name="x_completo" id="x_completo" size="5" value="<?php echo $row_contratoLlenar1['completo']?>" readonly></td>
<?php if($_GET['idPlanilla']=='1') {?>
        <td>
            <select name="x_certConformidad" id="x_certConformidad">
                <option value="NO" <?php if($row_contratoLlenar1['certConformidad']=='NO') {echo 'selected';}?> >NO</option>
                <option value="SI" <?php if($row_contratoLlenar1['certConformidad']=='SI') {echo 'selected';}?>>SI</option>
            </select>
        </td>
    <?php } ?>
<?php if($_GET['idPlanilla']=='20') {?>
        <td><input type="text" name="x_certConformidad" id="x_certConformidad" size="5" value="<?php echo $row_contratoLlenar1['certConformidad'];?>" readonly></td>
    <?php } ?>
   <?php } ?>
        <td><?php if($_GET['sw']!='contratoview'){?><input type="submit" name="guardar" id="guardar" value="Guardar"><?php } ?><input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cancelar();"></td>
        </tr>
        </td></tr></table>
<?php if($_GET['idPlanilla']!='20') {?>
    <table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
            <tr class="ewTableHeader">
                <td colspan="2">check list</td>
                <td>SI</td>
                <td>NO</td>
            </tr>
<?php
$contador=1;
while($row_pregunta=mysql_fetch_assoc($mostrar_pregunta)){ ?>
            <tr>
<input type="hidden" name="pregunta_<?php echo $contador ?>" id="pregunta_<?php echo $contador ?>" value="<?php echo $row_pregunta['idPregunta'] ?>">
<td><?php echo $contador?></td>
<td><?php echo utf8_encode($row_pregunta['pregunta']);?></td>
<td><input name="resp_<?php echo $contador ?>" id="resp_<?php echo $contador?>" type="radio" value="SI" <?php if($row_pregunta['respuesta']=="SI"){echo "checked";}?>/></td>
<td><input name="resp_<?php echo $contador ?>" id="resp_<?php echo $contador?>" type="radio" value="NO" <?php if($row_pregunta['respuesta']=="NO"){echo "checked";}?>/></td>
            </tr>
<?php
$contador++;
}
?>
            </td></tr></table>
 <?php }?>
</form>
<script language="javascript" type="text/javascript">
    $(document).ready(function(){
        $("#formulario").validate({
            rules:{
                x_nroContrato:{number:true},
                x_fechaInicio:{date:true},
                x_fechaFinal:{date:true},
                x_valor:{number:true}
            },
            messages: {
                x_nroContrato:"valor numerico",
                x_fechaInicio:"fecha incorrecta",
                x_fechaFinal:"fecha incorrecta",
                x_valor:"valor numerico"
            },
            onkeyup: false,
            submitHandler: function(form) {
                //                var respuesta = confirm('\xBFEsta seguro de realizar la operacion?')
                //                if (respuesta)
                form.submit();
            }
        });
    });


</script>
<?php } } else {
if($_GET['sw']=='registroedit17') {
    mysql_select_db($database_conexion, $conexion);
    $query_registroVentas = "SELECT * FROM registroventas17 WHERE idRegistroVentas='".(int)$_GET['x_idRegistroVentas']."'";
    $mostrar_registroVentas= mysql_query($query_registroVentas, $conexion) or die(mysql_error());
    $row_registroVentas=mysql_fetch_assoc($mostrar_registroVentas);

}?>
<form method="post" action="formulario_guardar.php" id="formulario17">
    <table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
        <tr class="ewTableHeader">
            <td>Nro</td><td>Nro de Comprobante</td><td>Tipo de Comprobante</td><td>Nombres y Apellidos del Comprador</td><td>Detalle de Ventas PRODUCTO / SERVICIO</td><td>Precio Unitario</td><td>Cantidad</td><td>Valor Total Bs.</td><td>Fecha</td><td>Cumple</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <tr>
        <input type="hidden" name="x_idPlanilla" id="x_idPlanilla" value="<?php echo $_GET['idPlanilla']?>">
        <input type="hidden" name="x_idMer" id="x_idMer" value="<?php echo $_GET['idMer']?>">
        <input type="hidden" name="sw" id="sw" value="<?php echo $_GET['sw']?>">
        <input type="hidden" name="x_idRegistroVentas" id="x_idRegistroVentas" value="<?php echo $row_registroVentas['idRegistroVentas']?>">
        <td>&nbsp;</td>
        <td><input type="text" name="x_nro" id="x_nro" value="<?php echo $row_registroVentas['nro'];?>" size="8"></td>
        <td>
            <select name="x_tipo" id="x_tipo">
                <option>Seleccione...</option>
                <option value="Contrato" <?php if($row_registroVentas['tipo']=="Contrato"){echo "selected";}?>>Contrato</option>
                <option value="Factura" <?php if($row_registroVentas['tipo']=="Factura"){echo "selected";}?>>Factura</option>
                <option value="Libros de Actas" <?php if($row_registroVentas['tipo']=="Libros de Actas"){echo "selected";}?>>Libros de Actas</option>
                <option value="Recibo" <?php if($row_registroVentas['tipo']=="Recibo"){echo "selected";}?>>Recibo</option>
            </select>
        </td>
        <td><input type="text" name="x_nombreComprador" id="x_nombreComprador" value="<?php echo $row_registroVentas['nombreComprador'];?>"></td>
        <td><input type="text" name="x_detalle" id="x_detalle" value="<?php echo $row_registroVentas['detalle'];?>" size="40"></td>
        <td><input type="text" name="x_precioUnitario" id="x_precioUnitario" value="<?php if($row_registroVentas['precioUnitario']!='0') echo $row_registroVentas['precioUnitario'];?>" size="5"></td>
        <td><input type="text" name="x_cantidad" id="x_cantidad" value="<?php if($row_registroVentas['cantidad']!='0') echo $row_registroVentas['cantidad'];?>" size="5"></td>
        <td><input type="text" name="x_valor" id="x_valor" value="<?php echo $row_registroVentas['valor'];?>" size="5"></td>
        <td><input type="text" name="x_fecha" id="x_fecha" class="date-pick" size="12" <?php if($_GET['sw']=='registroedit17' and $row_registroVentas['fecha']!='0000-00-00') {
    echo "value=".date("d-m-Y",strtotime($row_registroVentas['fecha']));
}?>></td>
        <td><input type="text" name="x_cumple" id="x_cumple" value="<?php echo $row_registroVentas['cumple'] ?>" size="5"></td>
        <td><input type="submit" name="guardar" id="guardar" value="Guardar"></td><td><input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cancelar();"></td>
        </tr>
        </td></tr></table>
</form>
<script language="javascript" type="text/javascript">
    $(document).ready(function(){
        $("#formulario17").validate({
            rules:{
                x_nro:{number:true},
                x_precioUnitario:{number:true},
                x_cantidad:{number:true},
                x_valor:{number:true},
                x_fecha:{date:true}
            },
            messages: {
                x_nro:"valor numerico",
                x_precioUnitario:"valor numerico",
                x_cantidad:"valor numerico",
                x_valor:"valor numerico",
                x_fecha:"fecha Incorrecta"
            },
            onkeyup: false,
            submitHandler: function(form) {
                //                var respuesta = confirm('\xBFEsta seguro de realizar la operacion?')
                //                if (respuesta)
                form.submit();
            }
        });
    });

</script>
<?php } ?>

<?php

//
// Page Class
//
class cformulario_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'formulario';

	// Page Object Name
	var $PageObjName = 'formulario_list';

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
	function cformulario_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["formulario"] = new cformulario();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'formulario', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$formulario->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $formulario->Export; // Get export parameter, used in header
	$gsExportFile = $formulario->TableVar; // Get export file, used in header
	if ($formulario->Export == "print" || $formulario->Export == "html") {

		// Printer friendly or Export to HTML, no action required
	}
	if ($formulario->Export == "excel") {
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
	var $lDisplayRecs; // Number of display records
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs;
	var $lRecRange;
	var $sSrchWhere;
	var $lRecCnt;
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex;
	var $lOptionCnt;
	var $lRecPerRow;
	var $lColCnt;
	var $sDeleteConfirmMsg; // Delete confirm message
	var $sDbMasterFilter;
	var $sDbDetailFilter;
	var $bMasterRecordExists;
	var $ListOptions;
	var $sMultiSelectKey;

	//
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsSearchError, $Security, $formulario;
		$this->lDisplayRecs = 20;
		$this->lRecRange = 10;
		$this->lRecCnt = 0; // Record count

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		$this->sSrchWhere = ""; // Search WHERE clause
		$this->sDeleteConfirmMsg = "�Quiere borrar este registro?"; // Delete confirm message

		// Master/Detail
		$this->sDbMasterFilter = ""; // Master filter
		$this->sDbDetailFilter = ""; // Detail filter
		if ($this->IsPageRequest()) { // Validate request

			// Set up records per page dynamically
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($formulario->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $formulario->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList()) {
			$sFilter = "(0=1)"; // Filter all records
		}
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$formulario->setSessionWhere($sFilter);
		$formulario->CurrentFilter = "";

		// Export data only
		if (in_array($formulario->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $formulario;
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->lDisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->lDisplayRecs = -1;
				} else {
					$this->lDisplayRecs = 20; // Non-numeric, load default
				}
			}
			$formulario->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$formulario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $formulario;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$formulario->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$formulario->CurrentOrderType = @$_GET["ordertype"];
			$formulario->UpdateSort($formulario->idFormulario); // Field
			$formulario->UpdateSort($formulario->idMer); // Field
			$formulario->UpdateSort($formulario->idPlanilla); // Field
			$formulario->UpdateSort($formulario->archivo); // Field
			$formulario->UpdateSort($formulario->cuenta); // Field
			$formulario->UpdateSort($formulario->porcentaje); // Field
			$formulario->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $formulario;
		$sOrderBy = $formulario->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($formulario->SqlOrderBy() <> "") {
				$sOrderBy = $formulario->SqlOrderBy();
				$formulario->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $formulario;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$formulario->setSessionOrderBy($sOrderBy);
				$formulario->idFormulario->setSort("");
				$formulario->idMer->setSort("");
				$formulario->idPlanilla->setSort("");
				$formulario->archivo->setSort("");
				$formulario->cuenta->setSort("");
				$formulario->porcentaje->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$formulario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $formulario;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$formulario->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$formulario->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $formulario->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$formulario->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$formulario->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$formulario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $formulario;

		// Call Recordset Selecting event
		$formulario->Recordset_Selecting($formulario->CurrentFilter);

		// Load list page SQL
		$sSql = $formulario->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$formulario->Recordset_Selected($rs);
		return $rs;
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
		}

		// Call Row Rendered event
		$formulario->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $formulario;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($formulario->ExportAll) {
			$this->lStopRec = $this->lTotalRecs;
		} else { // Export 1 page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->lDisplayRecs < 0) {
				$this->lStopRec = $this->lTotalRecs;
			} else {
				$this->lStopRec = $this->lStartRec + $this->lDisplayRecs - 1;
			}
		}
		if ($formulario->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($formulario->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $formulario->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idFormulario', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'idMer', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'idPlanilla', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'archivo', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'cuenta', $formulario->Export);
				ew_ExportAddValue($sExportStr, 'porcentaje', $formulario->Export);
				echo ew_ExportLine($sExportStr, $formulario->Export);
			}
		}

		// Move to first record
		$this->lRecCnt = $this->lStartRec - 1;
		if (!$rs->EOF) {
			$rs->MoveFirst();
			$rs->Move($this->lStartRec - 1);
		}
		while (!$rs->EOF && $this->lRecCnt < $this->lStopRec) {
			$this->lRecCnt++;
			if (intval($this->lRecCnt) >= intval($this->lStartRec)) {
				$this->LoadRowValues($rs);

				// Render row for display
				$formulario->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($formulario->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idFormulario', $formulario->idFormulario->CurrentValue);
					$XmlDoc->AddField('idMer', $formulario->idMer->CurrentValue);
					$XmlDoc->AddField('idPlanilla', $formulario->idPlanilla->CurrentValue);
					$XmlDoc->AddField('archivo', $formulario->archivo->CurrentValue);
					$XmlDoc->AddField('cuenta', $formulario->cuenta->CurrentValue);
					$XmlDoc->AddField('porcentaje', $formulario->porcentaje->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $formulario->Export <> "csv") { // Vertical format
						echo ew_ExportField('idFormulario', $formulario->idFormulario->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('idMer', $formulario->idMer->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('idPlanilla', $formulario->idPlanilla->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('archivo', $formulario->archivo->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('cuenta', $formulario->cuenta->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportField('porcentaje', $formulario->porcentaje->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $formulario->idFormulario->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->idMer->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->idPlanilla->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->archivo->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->cuenta->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						ew_ExportAddValue($sExportStr, $formulario->porcentaje->ExportValue($formulario->Export, $formulario->ExportOriginalValue), $formulario->Export);
						echo ew_ExportLine($sExportStr, $formulario->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($formulario->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($formulario->Export);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>