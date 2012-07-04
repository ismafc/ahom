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
	var formulario = document.getElementById("FormularioEnviarHabitos");

	if (formulario.minutos_voz.value == ""){
		alert ("Debe introducir los minutos que habla al mes");
		return false;
	}
	else if (formulario.mensajes_SMS.value == ""){
		alert ("Debe introducir el número de SMS que envia al mes");
		return false;
	}
	else if (formulario.minutos_voz.value <= 0 && formulario.mensajes_SMS.value <=0){
		alert ("Debe introducir los minutos que hable y/o el número de SMS que envia al mes");
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

function esNumerico(ev)
{
	var keyPressed = (ev.which) ? ev.which : ev.keyCode
	return !(keyPressed > 31 && (keyPressed < 48 || keyPressed > 57));

}

</script>
</head>
<body>
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
	<form action="ProcesarEnvioHabitos.php" method="post" enctype="multipart/form-data" target="fahorramovil" id="FormularioEnviarHabitos" name="FormularioEnviarHabitos" onSubmit="return ValidaDatosFormularioAhorramovil();">
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
            	<div class="titulo">Configura tus hábitos de llamada</div>
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td class="texto" align="right">Selecciona tu operador</td>
            <td style="width:10px"></td>
            <td>
                <select class="textbox" name="operador_origen">
                    <?php for ($i = 0; $i < count($operadoras); $i++){ ?>
                    <option value=<?php echo "\"".$operadoras[$i]."\""?>><?php echo $operadoras[$i]?></option>
                    <?php }	?>
                </select>
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td class="texto" align="right">Cuantos minutos habla al mes</td>
            <td style="width:10px"></td>
            <td>
                <input type="text" class="textbox" name="minutos_voz" value="" maxlength="4" onkeypress="return esNumerico(event)"/>
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td class="texto" align="right">Cuantos SMS envía al mes</td>
            <td style="width:10px"></td>
            <td>
                <input type="text" class="textbox" name="mensajes_SMS" value="" maxlength="2" onkeypress="return esNumerico(event)"/>
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td class="texto" align="right">A que operadora llama habitualmente</td>
            <td style="width:10px"></td>
            <td>
                <select class="textbox" name="operador_destino">
                    <option value="INDIFERENTE">A cualquier operador</option>
                    <?php for ($i = 0; $i < $maxOperadoras; $i++){?>
                    <option value=<?php echo "\"SOLO_".$operadoras[$i]."\""?>>Solamente a <?php echo $operadoras[$i]?></option>
                    <?php }	?>
                    <?php for ($i = 0; $i < $maxOperadoras; $i++){?>
                    <option value=<?php echo "\"".$operadoras[$i]."\""?>>Mayoritariamente a <?php echo $operadoras[$i]?></option>
                    <?php }	?>
                </select>
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td class="texto" align="right">A que horas suele llamar</td>
            <td style="width:10px"></td>
            <td>
                <select class="textbox" name="franja">
                    <option value="INDIFERENTE">A cualquier hora</option>
                    <option value="SOLO_MANANAS">Solamente por la mañana</option>
                    <option value="SOLO_TARDES">Solamente por la tarde</option>
                    <option value="MANANAS">Mayoritariamente por la mañana</option>
                    <option value="TARDES">Mayoritariamente por la tarde</option>
                </select>
            </td>
        </tr>
        <tr><td colspan="3" style="height:15px"></td></tr>
        <tr>
            <td class="texto" align="right">Que días suele llamar</td>
            <td style="width:10px"></td>
            <td>
                <select class="textbox" name="dia">
                    <option value="INDIFERENTE">Cualquier día de la semana</option>
                    <option value="SOLO_LABORAL">Solamente de lunes a viernes</option>
                    <option value="SOLO_FESTIVOS">Solamente fines de semana y festivos</option>
                    <option value="LABORAL">Mayoritariamente de lunes a viernes</option>
                    <option value="FESTIVOS">Mayoritariamente fines de semana y festivos</option>
                </select>
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
