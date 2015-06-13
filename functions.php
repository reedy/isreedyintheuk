<?php
function lastModifiedHeaders() {
	$headers = apache_request_headers();
	$mtime = filemtime( 'functions.php' );
	$modifiedSince = isset( $headers['If-Modified-Since'] )
		&& ( strtotime( $headers['If-Modified-Since'] ) == $mtime );
	header(
		'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $mtime ) . ' GMT',
		true,
		$modifiedSince ? 304 : 200
	);
}

/**
 * @param $time string Time to see if Reedy is/was/will be in the UK at said timestamp
 * 
 * @return bool
 */
function willReedyBeInTheUKAtThisTime( $time ) {
	$times = array();
	$times[] = array( 'from' => '2015-06-17T10:00 +1:00', 'to' => '2015-06-26T14:15 +1:00' );
	
	foreach( $times as $time ) {
		if ( $time >= strttotime( $time['from'] ) && $time <= strttotime( $time['to'] ) ) {
			return true;
		}
	}
	return false;
}

/**
 * @return bool
 */
function isReedyInTheUK() {
	return willReedyBeInTheUKAtThisTime( time() );
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
