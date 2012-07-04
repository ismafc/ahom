<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<?php
    if (!isset($_SESSION["heightCaptalis"]))
        $_SESSION["heightCaptalis"] = 600;
?>
<script type="text/javascript">
function ValidaDatosFormularioAhorramovil() {
	var formulario = document.getElementById("FormularioEnviarLlamada");

	if (formulario.tipo[0].checked && formulario.duracion_minutos.selectedIndex == 0 && formulario.duracion_segundos.selectedIndex == 0){
		alert ("Debe introducir la duración");
		return false;
	}
 	else if (formulario.aceptocheck.checked==false) { 
		alert("Por favor, lee y acepta las condiciones de este cálculo");
    	return false;
	}
	else {
		var framemsg = parent.document.getElementById("fahorramovilmsg");
		var frameaho = parent.document.getElementById("fahorramovil");
		var maintable = parent.document.getElementById("maintableahorramovil");
		maintable.height="<?php echo $_SESSION["heightCaptalis"]; ?>";
		framemsg.style.visibility="visible";
		framemsg.height="<?php echo $_SESSION["heightCaptalis"]; ?>";
		frameaho.style.visibility="hidden";
		frameaho.height="0";
	}
	return true;
}

function diasEnMes (month, year)
{
	if (month == 4 || month == 6 || month == 9 || month == 11)
		return 30;
	else if (month == 2){
		if (year % 4 == 0)
			return 29;
		return 28;
	}
	return 31;
}

function recargarDias()
{
	var formulario = document.getElementById("FormularioEnviarLlamada");
	var month = formulario.month[formulario.month.selectedIndex].value;
	var year = formulario.year[formulario.year.selectedIndex].value;
	var day;
	if (formulario.day.selectedIndex >= 0)
		day = formulario.day[formulario.day.selectedIndex].value;
	else{
		var today = new Date ();
		day = today.getDate();
	}

	for (i = 0; i < formulario.day.length; i++)
		formulario.day.options[i] = null;

	var maxDay = diasEnMes (month, year);
	if (day > maxDay)
		day = 1;
	formulario.day.length = maxDay;
	for (i=0; i < maxDay ; i++){
		var x = (i+1)<10 ? "0" + String(i+1) : String(i+1);
		formulario.day.options[i] = new Option(x,x, false, day == i+1 ? true : false);
	}
}

function cargarFormulario()
{
	var today = new Date();
	var day = today.getDate();
	var month = today.getMonth();
	var year = today.getFullYear();
	var hour = today.getHours();
	var minute = today.getMinutes();
	var i = 0;
	var formulario = document.getElementById("FormularioEnviarLlamada");
	var x;
	
	for (i=2006; i <= year ; i++)
	{
		x = String(i);
		formulario.year.options[i-2006] = new Option(x,x, false, year == i ? true : false);
	}

	formulario.month.options[0] = new Option ("Enero", "01");
	formulario.month.options[1] = new Option ("Febrero", "02");
	formulario.month.options[2] = new Option ("Marzo","03");
	formulario.month.options[3] = new Option ("Abril","04");
	formulario.month.options[4] = new Option ("Mayo","05");
	formulario.month.options[5] = new Option ("Junio","06");
	formulario.month.options[6] = new Option ("Julio","07");
	formulario.month.options[7] = new Option ("Agosto","08");
	formulario.month.options[8] = new Option ("Septiembre","09");
	formulario.month.options[9] = new Option ("Octubre","10");
	formulario.month.options[10] = new Option ("Noviembre","11");
	formulario.month.options[11] = new Option ("Diciembre","12");
	formulario.month.options[month].selected = true;

	recargarDias();

	for (i = 0; i < 24; i++){
		x = i<10 ? "0" + String(i) : String(i);
		formulario.hour.options[i] = new Option (x,x, false, hour==i ? true : false);
	}

	for (i = 0; i < 60; i++){
		x = i<10 ? "0" + String(i) : String(i);
		formulario.minute.options[i] = new Option (x, x, false, minute == i ? true : false);
		formulario.duracion_minutos.options[i] = new Option (x,x);
		formulario.duracion_segundos.options[i] = new Option (x, x);
	}
}

function onClickTipo (obj)
{
	var disabled = obj.value == "VOZ" ? false : true;
	var formulario = document.getElementById("FormularioEnviarLlamada");
	formulario.duracion_minutos.disabled = disabled;
	formulario.duracion_segundos.disabled = disabled;
}

</script>
</head>
<body onLoad=cargarFormulario()>
<?php
	if (!isset($mainFolder))
		$mainFolder = "../";
	include($mainFolder . "Lib/base.inc");
	include($mainFolder . "Lib/main.inc");
	if (openDatabase() == false)
		exit();

	$operadoras = obtenerListaOperadoras ();
	$maxOperadoras = 3;//count($operadoras);
?>
    <table class="texto" cellspacing="0" cellpadding="0" border="0" width="100%" style="height:100%;font-size:11px;">
        <tr>
            <td>
    <form action="ProcesarEnvioLlamada.php" method="post" enctype="multipart/form-data" target="fahorramovil" id="FormularioEnviarLlamada" name="FormularioEnviarLlamada" onSubmit="return ValidaDatosFormularioAhorramovil();">
    <table class="texto" cellspacing="0" cellpadding="0" border="0" width="100%" style="height:100%;font-size:11px;">
        <tr>
            <td colspan="3">
                <div class="texto"><strong>¡Encuentra la mejor opción!</strong> Ahora <span style="color:#B2BB1C;">Captalis</span> te ofrece un nuevo servicio gratuito que te resolverá de forma definitiva cuál es el plan
                                tarifario que más se ajusta a tus necesidades. Solo necesitarás unos segundos para saber cuál es la opción que te ahorrará más dinero.
                </div>
            </td>
        </tr>
        <tr><td colspan="3" style="height:10px"></td></tr>
        <tr>
            <td colspan="3">
                <div class="titulo">Configura la llamada que deseas realizar</div>
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td class="texto" align="right">Selecciona tu operador</td>
            <td style="width:10px"></td>
            <td>
                <select class="textbox" name="operador_origen">
                        <?php for ($i = 0; $i < count($operadoras); $i++){ ?>
                        <option value="<?php echo $operadoras[$i]; ?>"><?php echo $operadoras[$i]; ?></option>
                        <?php }	?>
                </select>
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td class="texto" align="right">Operador al que deseas llamar</td>
            <td style="width:10px"></td>
            <td>
                <select class="textbox" name="operador_destino">
                    <?php for ($i = 0; $i < $maxOperadoras; $i++){ ?>
                    <option value="<?php echo $operadoras[$i]; ?>"><?php echo $operadoras[$i];?></option>
                    <?php }	?>
                </select>
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td class="texto" align="right">Indica el tipo de llamada</td>
            <td style="width:10px"></td>
            <td>
                <input name="tipo" type="radio" value="VOZ" checked onClick="onClickTipo(this);"/>Voz&nbsp;&nbsp;&nbsp;
                <input type="radio" name="tipo" value="SMS" onClick="onClickTipo(this);"/>SMS
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td class="texto" align="right">Fecha / hora en que se realizará la llamada</td>
            <td style="width:10px"></td>
            <td>
                <select class="textbox-small" name="day"></select> /
                <select class="textbox-small" name="month" style="width:110px;" onChange="recargarDias();"></select> /
                <select class="textbox-small" style="width:65px;" name="year"></select>&nbsp;&nbsp;
                <select class="textbox-small" name="hour"></select> :
                <select class="textbox-small" name="minute"></select>
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td class="texto" align="right">Duración de la llamada</td>
            <td style="width:10px"></td>
            <td>
                <select class="textbox-small" name="duracion_minutos"></select> :
                <select class="textbox-small" name="duracion_segundos"></select>
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td colspan="3">
                <input type="checkbox" name="aceptocheck" value="checkbox" id="aceptocheck" />Acepto los <a target="_blank" href="http://www.captalis.com/terms.php">Términos y Condiciones</a> y <a target="_blank" href="http://www.captalis.com/privacy.php">Politica de Privacidad</a> de Captalis
            </td>
        </tr>
        <tr><td colspan="3" style="height:20px"></td></tr>
        <tr>
            <td colspan="3" align="right">
                <input type="image" src="imagenes/encuentra-mejor-tarifa.gif" />
            </td>
        </tr>
    </table>
    </form>
    </td>
    </tr>
    </table>
</body>
</html>
