<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Ejemplo</title>
        <?php
        if (isset($_GET['height']))
            $_SESSION["heightCaptalis"] = $_GET['height'];
        else
            $_SESSION["heightCaptalis"] = 500;
        //$_SESSION["pageOneCaptalis"] = "Captalis.php";
        $_SESSION["pageOneCaptalis"] = "http://www.ahorramovil.com/Captalis/Captalis.php";
        ?>
    </head>
    <body>
        <div align="center" style="width:100%">
            <table style="width:700px;height:100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="height:<?php echo ($_SESSION["heightCaptalis"] + 1); ?>px">
                       <!--<iframe height="100%" width="100%" src="http://www.ahorramovil.com/Captalis/captalisahorramovil.php" scrolling="auto" frameborder="0">No Frames</iframe>-->
                        <iframe height="100%" width="100%" src="captalisahorramovil.php" scrolling="auto" frameborder="0">No Frames</iframe>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>