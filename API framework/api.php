<?php namespace _;

// CHECK THE API EP HANDLER TYPE IS IN THE WHITE LIST
$type	= match( EP_TYPE ) {

	'io','get','set','find','img','doc' => EP_TYPE,
	
	'html', 'view', 'box' => 'html',

	default => 'BAD_API_REQUEST',

};

// EXIT WITH ERROR CODE IF EP TYPE IS INVALID OR DOES NOT EXIST
// NEED TO ADD LOGGING OF INVALID REQUESTS
if( !file_exists(DIR.$type.php) ) code();

// NAMESPACED EP NAME
define( Ns.'EP_NAME', filter_get( EP_TYPE ) );

// WILL NEED TO VALIDATE THE USER SESSION WHEN HEADERS ARE IMPLEMENTED NATIVELY AND WHEN THE EP IS NOT login

require_once DIR.$type.php;
