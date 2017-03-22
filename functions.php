<?php
function lastModifiedHeaders() {
	if ( php_sapi_name() === 'cli' ) {
		return;
	}
	$headers = apache_request_headers();
	$modified = true;
	if ( isset( $headers['If-Modified-Since'] ) ) {
		$isInUK = isReedyInTheUK();
		$wasInUK = willReedyBeInTheUKAtThisTime( strtotime( $headers['If-Modified-Since'] ) );
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
	$timesNotInTheUK = [
		// New (times not in the UK)
		[ 'from' => '2015-02-07T14:50 +1:00', 'to' => '2015-06-17T10:00 +1:00', 'loc' => [ 'US', 'CA' ] ],
		[ 'from' => '2015-06-26T14:15 +1:00', 'to' => '2015-08-02T09:49 +1:00', 'loc' => [ 'US' ] ],
		[ 'from' => '2015-08-06T13:05 +1:00', 'to' => '2015-08-17T15:25 +1:00', 'loc' => [ 'SE', 'NO' ] ],
		[ 'from' => '2015-09-03T14:30 +1:00', 'to' => '2015-09-30T13:35 +1:00', 'loc' => [ 'FR', 'ES' ] ],
		[ 'from' => '2016-01-29T14:50 +0:00', 'to' => '2016-02-02T12:45 +0:00', 'loc' => [ 'FR', 'BE', 'NL', 'DE' ] ],
		[ 'from' => '2016-03-31T12:55 +0:00', 'to' => '2016-04-05T00:35 +0:00', 'loc' => [ 'IL' ] ],
		[ 'from' => '2016-05-10T19:35 +1:00', 'to' => '2016-05-12T12:05 +1:00', 'loc' => [ 'ES' ] ],
		[ 'from' => '2016-06-24T17:30 +1:00', 'to' => '2016-07-05T17:45 +1:00', 'loc' => [ 'SE', 'NO' ] ],
		[ 'from' => '2016-08-17T21:20 +1:00', 'to' => '2016-09-14T05:30 +1:00', 'loc' => [ 'ZA', 'ZM', 'ZW' ] ],
		[ 'from' => '2016-09-25T10:25 +1:00', 'to' => '2016-09-29T17:00 +1:00', 'loc' => [ 'SE', 'FI' ] ],
		[ 'from' => '2017-01-06T16:55 +0:00', 'to' => '2017-01-08T09:10 +0:00', 'loc' => [ 'NO', 'FI' ] ],
		[ 'from' => '2017-01-08T11:10 +0:00', 'to' => '2017-01-25T08:10 +0:00', 'loc' => [ 'US' ] ],
		[ 'from' => '2017-01-25T10:20 +0:00', 'to' => '2017-01-30T15:40 +0:00', 'loc' => [ 'NO', 'FI' ] ],
		[ 'from' => '2017-03-02T07:30 +0:00', 'to' => '2017-03-05T16:05 +0:00', 'loc' => [ 'CZ' ] ],
		[ 'from' => '2017-04-19T14:40 +1:00', 'to' => '2017-04-19T18:05 +1:00', 'loc' => [ 'NL' ] ],
		[ 'from' => '2017-04-25T21:25 +1:00', 'to' => '2017-05-04T06:55 +1:00', 'loc' => [ 'ZA', 'ZM' ] ],
		[ 'from' => '2017-05-26T13:15 +1:00', 'to' => '2017-05-28T21:50 +1:00', 'loc' => [ 'GR' ] ],
		[ 'from' => '2017-09-23T10:25 +1:00', 'to' => '2017-09-27T07:20 +1:00', 'loc' => [ 'FI', 'FR', 'US' ] ],
	];
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
