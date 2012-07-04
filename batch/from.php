<html>
<head>
<title>Prueba Host desde!</title>
</head>
<body>
<?php
    $ip = getenv('REMOTE_ADDR');
    echo "Remote address: " . $ip . "<br>";
    echo "Host: " . gethostbyaddr($ip) . "<br>";
?>
</body>
</html>