<?php
require_once( __DIR__ . '/functions.php' );
lastModifiedHeaders();
echo json_encode( array ( 'isreedyintheuk' => isReedyInTheUK() ) );

