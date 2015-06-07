<?php
function lastModifiedHeaders() {
	$headers = apache_request_headers();
	$mtime = filemtime( 'functions.php' );
	$modifiedSince = isset( $headers['If-Modified-Since'] ) && ( strtotime( $headers['If-Modified-Since'] ) == $mtime );
	header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $mtime ) . ' GMT', true, $modifiedSince ? 304 : 200 );
}

/**
 * @return bool
 */
function isReedyInTheUK() {
	return false;
}

/**
 * @return string
 */
function isReedyInTheUKMessage() {
	if ( isReedyInTheUK() ) {
		return 'Yes :)';
	} else {
		return 'No :(';
	}
}
