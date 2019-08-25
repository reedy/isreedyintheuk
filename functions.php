<?php
function lastModifiedHeaders() {
	if ( php_sapi_name() === 'cli' ) {
		return;
	}
	$headers = function_exists( 'apache_request_headers' ) ? apache_request_headers() : [];
	$modified = true;
	if ( isset( $headers['If-Modified-Since'] ) ) {
		$isInUK = isReedyInTheUK();
		$wasInUK = willReedyBeInTheUKAtThisTime( strtotime( $headers['If-Modified-Since'] ) );
		$modified = $isInUK !== $wasInUK;
	}
	header(
		'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', filemtime( __DIR__ . '/absent.json' ) ) . ' GMT',
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
	$timesNotInTheUK = json_decode( file_get_contents( __DIR__ . '/absent.json' ), true );
	foreach( $timesNotInTheUK as $t ) {
		if ( $time >= strtotime( $t['from'] ) && $time <= strtotime( $t['to'] ) ) {
			return false;
		}
	}
	return true;
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
