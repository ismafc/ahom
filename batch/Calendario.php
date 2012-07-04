<html>
<head>
<title>Limpiar Base de datos!</title>
</head>
<body>
<?php
	include("../Lib/library.inc");
	include("../Lib/main.inc");
	include("../Lib/facturas.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false) {
		echo "No se puedo acceder a la base de datos!<br />";
		echo "</body></html>";
		exit();
	}

	$contador = 1;
	$tipodia = "1";
	$fechacreacion = mktime(0,0,0,1,1,2008);
	$diasemana = 1;
	while (true) {
		if ($diasemana >= 5)
			$tipodia = "2";
		else
			$tipodia = "1";
		$dt = date("Y-m-d", $fechacreacion);
		echo $dt . " (" . $tipodia . ")<br>";
		$sql = "INSERT INTO calendario (fecha, idTipoDia) VALUES ('$dt', '$tipodia')";
		echo $sql . "<br>";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "No se puedo añadir el tipo de dia al calendario!<br />";
			echo "</body></html>";
			exit();
		}
		
		$fechacreacion = $fechacreacion + 86400;
		echo $fechacreacion . "<br>";
		$diasemana++;
		$diasemana = $diasemana % 7;
		if ($contador == 366)
			break;
		$contador++;
	}

	echo "Calendario OK!";
?>
</body>
</html>