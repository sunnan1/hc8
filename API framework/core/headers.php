<?php namespace _;

$headers = getallheaders();
define(Ns.'HEADERS', $headers);

foreach($headers as $header => $value)
$headers[ $lower = strtolower($header) ] ?? ($headers[ $lower ] = $value);

// FIND REQUESTING DEVICE OS HEADER
foreach(['caregiver','onboarding','admin'] as $app_name)
if( array_key_exists( "{$app_name}appversion", $headers ) ) ($APPID ?? ($APPID = $app_name));

// SET THE APPID
define( Ns.'APPID', $APPID ?? '' );

// SET THE OS
switch(APPID ?? '') :

	case 'caregiver':
	case 'onboarding':	define(Ns.'APPOS', 'android');	break;

	case 'admin':		define(Ns.'APPOS', 'windows');	break;
	
	default:			define(Ns.'APPOS', NULL);		break;

endswitch;

// DEFINE DEVICE ID
define( Ns.'DEVICEID', $headers['deviceid'] ?? NULL );

// FIREBASE ID
define( Ns.'FIREBASEID', $headers['firebaseid'] ?? NULL );

// SET ORG IF AVAILABLE
define( Ns.'ORGTOKEN', $headers['orgtoken'] ?? NULL );

// SET APP VERSION 
define( Ns.'APPVERSION', $headers[APPID.'appversion'] ?? NULL );

// APP FLAVOR
define( Ns.'APPFLAVOR', $headers[APPID.'appflavor'] ?? NULL );

// APP ENV
define( Ns.'APPENV', $headers[APPID.'appenv'] ?? NULL );

// SET THE AUTH TOKEN
define( Ns.'APPTOKEN', $headers['Authorization'] ?? '' );

// SET THE API VERSION
define( Ns.'APIVERSION', api_version );

// SET IF IS CAREGIVER APP
define( Ns.'UUID', $headers['uuid'] ?? '' );
