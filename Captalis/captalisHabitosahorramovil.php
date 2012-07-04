<?php header('P3P: CP="CAO PSA OUR"'); session_start(); session_regenerate_id();
	if (!isset($mainFolder))
		$mainFolder = "../";
	include($mainFolder . "Lib/library.inc");
	include($mainFolder . "Lib/main.inc");
	include($mainFolder . "Lib/facturas.inc");
	include($mainFolder . "Lib/base.inc");
	if (openDatabase() == false)
		exit();
	unset($_SESSION['miembroCAPTALIS'], $_SESSION['passwordCAPTALIS']);
	$_SESSION['miembroCAPTALIS'] = session_id();
	$_SESSION['passwordCAPTALIS'] = session_id();
	crearUsuarioProvisionalFrom($_SESSION['miembroCAPTALIS'], $_SESSION['passwordCAPTALIS'], "CAPTALIS");
        if (!isset($_SESSION["heightCaptalis"]))
            $_SESSION["heightCaptalis"] = 500;
?>
<html>
<head>
<title>Frame Ahorramovil</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>
<table id="maintableahorramovil" width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td>
<iframe src="procesandoAhorramovil.php" id="fahorramovilmsg" name="fahorramovilmsg" width="100%" height="0" scrolling="auto" frameborder="0" style="visibility:hidden">No soporta Frames
</iframe>
		</td>
    </tr>
	<tr>
    	<td>
<iframe src="formularioHabitosAhorramovil.php" id="fahorramovil" name="fahorramovil" width="100%" height="<?php echo $_SESSION["heightCaptalis"]; ?>" scrolling="auto" frameborder="0">No soporta Frames
</iframe>
		</td>
    </tr>    
</table>
</body>
</html>
