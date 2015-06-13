<?php
function lastModifiedHeaders() {
	$headers = apache_request_headers();
	$modified = true;
	if ( isset( $headers['If-Modified-Since'] ) ) {
		$isInUK = isReedyInTheUK();
		$wasInUK = willReedyBeInTheUKAtThisTime( strtotime( $headers['If-Modified-Since'] );
		$modified = $isInUK !== $wasInUK;
	}
	header(
		'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', filemtime( 'functions.php' ) ) . ' GMT',
		true,
		$modified ? 200 : 304
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
