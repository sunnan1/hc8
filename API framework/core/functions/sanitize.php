<?php namespace _;

/* * *
 *
 *  FOR SANITIZATION AND PREPARATION OF REQUEST ARGUMENTS / RESPONSES
 * 
 * * */
 
function Json( $x, int $f = PRETTY_NUMERIC_CODE_SLASHES ) { return json_encode( $x, $f ); }
function Json_( $x, int $f = PRETTY_NUMERIC_CODE_SLASHES ) {

	header('Content-Type: application/json');
	echo Json( $x, $f );

}
function Json_x( $x, int $f = PRETTY_NUMERIC_CODE_SLASHES ) { Json_( $x, $f ); exit; }
function Json64( $data, int $flags = 0 ) { return base64_encode( json_encode($data, $flags) ); }
function Json64_decode( string $encoded, ...$args ) {

	if( !$json = base64_decode($encoded) ) return;
	return json_decode( $json, ...$args );

}
function filter_Json64_input( int $type, string $name, int $filter = FILTER_SANITIZE_STRING, $options = 0 ) {

	if( !$input = filter_input($type, $name, $filter, $options) ) return;
	return Json64_decode( $input, TRUE );

}
function filter_Json64_get( string $name, int $filter = FILTER_SANITIZE_STRING, $options = 0 ) { return filter_Json64_input(INPUT_GET, $name, $filter, $options); }
function filter_Json64_post( string $name, int $filter = FILTER_SANITIZE_STRING, $options = 0 ) { return filter_Json64_input(INPUT_POST, $name, $filter, $options); }
function filter_get( string $var, int $filter = FILTER_SANITIZE_STRING, $options = 0 ) { return filter_input(INPUT_GET, $var, $filter, $options); }
function filter_post( string $var, int $filter = FILTER_SANITIZE_STRING, $options = 0 ) { return filter_input(INPUT_POST, $var, $filter, $options); }

function filter_get_bool( string $var, $options = FILTER_NULL_ON_FAILURE ) { return filter_input(INPUT_GET, $var, FILTER_VALIDATE_BOOLEAN, $options); }
function filter_post_bool( string $var, $options = FILTER_NULL_ON_FAILURE ) { return filter_input(INPUT_POST, $var, FILTER_VALIDATE_BOOLEAN, $options); }
function filter_bool( string $var, $options = FILTER_NULL_ON_FAILURE ) {

	if( has_post($var) ) return filter_post_bool($var, $options);
	return filter_get_bool($var, $options);

}

function filter_get_float( string $var, $options = FILTER_FLAG_ALLOW_FRACTION ) { return filter_input(INPUT_GET, $var, FILTER_SANITIZE_NUMBER_FLOAT, $options); }
function filter_post_float( string $var, $options = FILTER_FLAG_ALLOW_FRACTION ) { return filter_input(INPUT_POST, $var, FILTER_SANITIZE_NUMBER_FLOAT, $options); }
function filter_float( string $var, $options = FILTER_FLAG_ALLOW_FRACTION ) {

	if( has_post($var) ) return filter_post_float($var, $options);
	return filter_get_float($var, $options);

}

function filter_get_int( string $var, $options = 0 ) { return  filter_input(INPUT_GET, $var, FILTER_SANITIZE_NUMBER_INT, $options); }
function filter_post_int( string $var, $options = 0 ) { return filter_input(INPUT_POST, $var, FILTER_SANITIZE_NUMBER_INT, $options); }
function filter_int( string $var, $options = 0 ) {

	if( has_post($var) ) return filter_post_int($var, $options);
	return filter_get_int($var, $options);

}

function filter_get_url( string $var, $options = 0 ) { return filter_input(INPUT_GET, $var, FILTER_SANITIZE_URL, $options); }
function filter_post_url( string $var, $options = 0 ) { return filter_input(INPUT_POST, $var, FILTER_SANITIZE_URL, $options); }
function filter_url( string $var, $options = 0 ) {

	if( has_post($var) ) return filter_post_url($var, $options);
	return filter_get_url($var, $options);

}

function filter_get_array( string $var, int $options = 0 ) : array { return filter_input(INPUT_GET, $var, FILTER_SANITIZE_STRING, $options|FILTER_REQUIRE_ARRAY ) ?? []; }
function filter_post_array( string $var, int $options = 0 ) : array { return filter_input(INPUT_POST, $var, FILTER_SANITIZE_STRING, $options|FILTER_REQUIRE_ARRAY ) ?? []; }
function filter_array( string $var, int $options = 0 ) : array {

	if( has_post($var) ) return filter_post_array($var, $options);
	return filter_get_array($var, $options);

}

function filter_get_password( string $var = 'password', $options = 0 ) { return filter_input(INPUT_GET, $var, FILTER_SANITIZE_URL, $options); }
function filter_post_password( string $var = 'password', $options = 0 ) { return filter_input(INPUT_POST, $var, FILTER_SANITIZE_URL, $options); }
function filter_password( string $var = 'password', $options = 0 ) { return filter_input(INPUT_POST, $var, FILTER_SANITIZE_URL, $options); }

function filter_get_action( $options = 0 ) { return filter_input(INPUT_GET, 'action', FILTER_SANITIZE_URL, $options); }
function filter_post_action( $options = 0 ) { return filter_input(INPUT_POST, 'action', FILTER_SANITIZE_URL, $options); }
function filter_action( $options = 0 ) {
	
	if( has_post('action') ) return filter_post_action($options);
	if( has_get('action') ) return filter_get_action($options);

	return NULL;

}

function filter_has_get( string $var ) { return filter_has_var(INPUT_GET, $var); }
function filter_has_post( string $var ) { return filter_has_var(INPUT_POST, $var); }
function has_get( string $var ) { return filter_has_var(INPUT_GET, $var); }
function has_post( string $var ) { return filter_has_var(INPUT_POST, $var); }
function has_action( string $var = NULL, $options = 0 ) {

	if( !isset($var) )
	return has_post('action') || has_get('action');

	return $var === filter_action( $options );

}

