<?php
function lastModifiedHeaders() {
	if ( PHP_SAPI === 'cli' ) {
		return;
	}

	$headers = function_exists( 'apache_request_headers' ) ? apache_request_headers() : [];
	$modified = true;
	if ( isset( $headers['If-Modified-Since'] ) ) {
		$modifiedTime = strtotime( $headers['If-Modified-Since'] );
		$domainCountry = getCountryFromDomain();

		if ( $domainCountry === 'UK' ) {
			$isInUK = isReedyInTheUKNow();
			$wasInUK = isReedyInTheUKAtThisTime( $modifiedTime );
			$modified = $isInUK !== $wasInUK;
		} else {
			$isInCountry = isReedyInACountryAtThisTime( time(), $domainCountry );
			$wasInCountry = isReedyInACountryAtThisTime( $modifiedTime, $domainCountry );
			$modified = $isInCountry !== $wasInCountry;
		}
	}
	header(
		'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', filemtime( __DIR__ . '/absent.json' ) ) . ' GMT',
		true,
		$modified ? 200 : 304
	);
}

/**
 * @return string
 */
function getCountryFromDomain(): string {
	$domains = [
		// domain => country
		'isreedyintheuk.com' => 'UK',
		'isreedyinthe.uk' => 'UK',
		'isreedyinthe.us' => 'US',
	];

	return $domains[$_SERVER['HTTP_HOST']] ?? 'UK';
}

/**
 * @param $time string Time to see if Reedy is/was/will be in the UK at said timestamp
 *
 * @return bool
 */
function isReedyInTheUKAtThisTime( string $time ): bool {
	$timesNotInTheUK = json_decode( file_get_contents( __DIR__ . '/absent.json' ), true );
	foreach( $timesNotInTheUK as $t ) {
		if (
			$time >= strtotime( $t['from'] ) &&
			$time <= strtotime( $t['to'] )
		) {
			return false;
		}
	}
	return true;
}

/**
 * @param $time string Time to see if Reedy is/was/will be in $country at said timestamp
 * @param $country string Country
 *
 * @return bool
 */
function isReedyInACountryAtThisTime( string $time, string $country ): bool {
	$timesNotInTheCountry = json_decode(
        file_get_contents( __DIR__ . '/absent.json' ),
        true
    );

    // Newer entries are at the bottom, so makes sense to start at the bottom...
	foreach( array_reverse( $timesNotInTheCountry ) as $t ) {
		if (
			in_array( $country, $t['loc'] ) &&
			$time >= strtotime( $t['from'] ) &&
			$time <= strtotime( $t['to'] )
		) {
			return true;
		}
	}
	return false;
}

/**
 * @return bool
 */
function isReedyInTheUKNow(): bool {
	return isReedyInTheUKAtThisTime( time() );
}


/**
 * @param $country string Country
 * @return bool
 */
function isReedyInThisCountryNow( string $country ): bool {
	return isReedyInACountryAtThisTime( time(), $country );
}

/**
 * @param $bool bool In the country?
 *
 * @return string
 */
function isReedyInCountryMessage( bool $bool ): string {
	return $bool ? 'Yes :)' : 'No :(';
}
