<?php
require_once( __DIR__ . '/functions.php' );
lastModifiedHeaders();
$country = getCountryFromDomain();
?>

<!DOCTYPE html>
<html lang="en-GB" dir="ltr">
<head>
<meta charset="UTF-8" />
<title>isreedyinthe<?php strtolower( $country ) ?></title>
</head>
<body>
<?php

if ( $country === 'UK' ) {
	echo isReedyInCountryMessage( isReedyInTheUKNow() );
} else {
	echo isReedyInCountryMessage( isReedyInThisCountryNow( $country ) );
}

?>
</body>
</html>
