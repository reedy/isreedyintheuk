<?php
require_once( __DIR__ . '/functions.php' );
lastModifiedHeaders();
header( 'Content-Type: application/json' );
echo json_encode( array ( 'isreedyintheuk' => isReedyInTheUK() ) );

