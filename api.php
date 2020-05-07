<?php
require_once( __DIR__ . '/functions.php' );
lastModifiedHeaders();
header( 'Content-Type: application/json' );
$country = getCountryFromDomain();

$result = [];
$inCountry = false;
if ( $country === 'UK' ) {
	$inCountry = isReedyInTheUKNow();
} else {
	$inCountry = isReedyInThisCountryNow( $country ); 
}

$result['message'] = isReedyInCountryMessage( $inCountry );

if ( $inCountry ) {
	$result['isreedyinthe' . strtolower( $country )] = '';
}

echo json_encode( $result );
