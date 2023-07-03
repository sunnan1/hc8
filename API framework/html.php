<?php namespace _;

// WEB VIEWS CURRENTLY IN DEVELOPMENT
// CLASSES WILL BE BUILT FOR THE WEBVIEW INTEGRATION AND USE THE REQUEST EP TYPE (view,box, etc)

switch( $html = EP_NAME ) :

	case 'map.tours':
	case 'map.tours.working':
	case 'test.form':
	case 'test.decubitus':
	case 'win.test.decubitus':
	
	// EXIT WITH 403 IF HANDLER DOES NOT EXIST
	if( !file_exists(DIR."html/$html".php) ) code();

	header('Content-Type: text/html');
	require_once DIR."html/$html".php;

endswitch;

exit;