<html>
<head>

    <title>
aaaa
    </title>
</head>
<body>

<?php
$file = "http://support.kaspersky.com/resources/img/top_logo.png";
$name =basename($file);
copy($file,__DIR__.'\\'.$name);
?>

</body>
</html>