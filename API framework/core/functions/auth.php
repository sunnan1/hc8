<?php namespace _;


// SET THE CURRENT HTTP RESPONSE AND EXIT BY DEFAULT
function code( int $code = 403, bool $exit = TRUE ) {

	$return = match( $code ) {
	
		400, 401, 402, 403, 404 => http_response_code( $code ),

		default => http_response_code( 403 ),
	
	};

	// LOGGING COULD BE INVOKED HERE
	
	
	// RETURN RESULT IF NOT EXITING
	if( !$exit ) return $return;

	exit;

}

function hashed( string $data, string $algo = 'md5' ) {

	static $mask = [12,4,4,4,8];

	$hash	= \hash( $algo, $data );
	$length	= strlen( $hash );

	while( $length > ($start ?? ($start = $i = 0)) ) :

		$size		= $mask[ ($i++) % 5 ];
		$parts[]	= substr( $hash, $start, $size );
		$start		+= $size;

	endwhile;

	return join( $parts, '-');

}

function nonce( string $action, bool $previous = FALSE, string $context = 'default' ) : string {

	// GET EXPIRE TIME FROM CONTEXT
	// LEAVES ROOM FOR FUTURE EXPIRE DURATIONS TO BE DEFINED
	switch( $context ) :

		case 'otp':
		
		case 'default':
		default:			$expire = nonce_expire;

	endswitch;

	// CREATE A TIME BASED SALT
	$time   = (int)floor( (strtotime('now') / $expire) );

	// GET PREVIOUS NONCE IF SET
	if( TRUE === $previous ) --$time;

	// RETURN A TIME BASED HASH FOR THIS USER AND ACTION
	return hashed( nonce_salt . ":$action:$time" );

}

// VERIFY AN ACTION NONCE
function verify_nonce( string $nonce, string $action, string $context = 'default' ) : bool { return $nonce === nonce($action, FALSE, $context) || $nonce === nonce($action, TRUE, $context); }

// CREATE A NONCIFIED PATH
function nonce_uri( $mixed, string $ext, string $action, string $context = 'uri' ) : string {

	if( !is_string($mixed) ) $mixed = Json64($mixed);

	$nonce = nonce( "uri::$action", FALSE, $context );

	return "/$mixed-$nonce.$ext";

}

// CREATE A TOKEN
function token( string $data, string $context = 'auth' ) : string {
	
	switch( $context ) :

		case 'nonce':	$salt = nonce_salt;		break;
		case 'login':	$salt = login_salt;		break;
		case 'secure':	$salt = secure_salt;	break;
		case 'auth':	$salt = auth_salt;		break;
		default:		$salt = $context;		break;

	endswitch;

	return hashed("$salt:$data");

}

function verify_token( string $token, string $data, string $context = 'auth' ) : string { return $token === token($data, $context); }


/* NEEDS LOCAL SANITIZATION - USING STATIC METHOD FROM NON EXISTENET CLASS

function validate_password( string &$string = NULL, string $name = 'password' ) {

	// GET PASSWORD FROM INPUT IF NOT SET
	$string ?? ($strig = filter_password($name));

	// FIRST SANITIZE THE STRING
	if( !person::sanitize($string, 'password') ) return FALSE;

	// THEN VALIDATE THE SANITIZED IS SAME AS THE RAW INPUT
	if( $string !== filter_post($name, FILTER_UNSAFE_RAW) ) return FALSE;

	// IT IS VALID
	return TRUE;

}

*/
