<?php
require_once( __DIR__ . '/functions.php' );
lastModifiedHeaders();
header( 'Content-Type: application/json' );

$result = array();

if ( isReedyInTheUK() ) {
	$result['isreedyintheuk'] = '';
}

$result['message'] = isReedyInTheUKMessage();
echo json_encode( $result );

