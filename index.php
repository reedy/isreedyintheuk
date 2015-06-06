<?php
$headers = apache_request_headers();
$mtime = filemtime( 'index.php' );
$modifiedSince = isset( $headers['If-Modified-Since'] ) && ( strtotime( $headers['If-Modified-Since'] ) == $mtime );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $mtime ) . ' GMT', true, $modifiedSince ? 304 : 200 );
?>

<!DOCTYPE html>
<html lang="en-GB" dir="ltr">
<head>
<meta charset="UTF-8" />
<title>isreedyintheuk?</title>
</head>
<body>
<?php

echo "No :(";

?>
</body>
</html>
