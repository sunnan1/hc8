<?php namespace _;

$lang = $headers['lang'] ?? (filter_get('lang') ?: '');

switch( $lang ) :

	case 'de_DE':

		$language = $lang;

	break;

	default:

		if( 2 > count($split = split($lang, '_')) ) $split[] = NULL;

		[ $language, $region ] = $split;

endswitch;

if( $lang !== $language )
switch( $language ) :

	case 'de': $language .= '_DE'; break;

endswitch;

// DEFINE LOCALIZATION
define(Ns.'LANG', $language);

putenv('LANG='.LANG);
setlocale(LC_MESSAGES, LANG . '.UTF-8');
setlocale(LC_TIME, LANG) . '.UTF-8';

bindtextdomain("messages", DIR."core/locale");
textdomain("messages");