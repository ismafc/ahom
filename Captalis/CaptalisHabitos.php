<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Ejemplo</title>
        <?php
        if (isset($_GET['height']))
            $_SESSION["heightCaptalis"] = $_GET['height'];
        else
            $_SESSION["heightCaptalis"] = 600;
        $_SESSION["pageOneCaptalis"] = "CaptalisHabitos.php";
        //$_SESSION["pageOneCaptalis"] = "http://www.ahorramovil.com/Captalis/CaptalisHabitos.php";
        ?>
    </head>
    <body>
        <div align="center" style="width:100%">
            <table style="width:650px">
                <tr>
                    <td style="height:<?php echo ($_SESSION["heightCaptalis"] + 1); ?>px">
                        <!--<iframe height="100%" width="100%" src="http://www.ahorramovil.com/Captalis/captalisHabitosahorramovil.php" scrolling="auto" frameborder="0">No Frames</iframe>-->
                        <iframe height="100%" width="100%" src="captalisHabitosahorramovil.php" scrolling="auto" frameborder="0">No Frames</iframe>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>