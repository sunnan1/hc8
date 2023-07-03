<?php namespace _;

$event = [
	'success'	=> TRUE,
	'error'		=> FALSE,
	'failure'	=> FALSE,
	'message'	=> '',
	'confirm'	=> FALSE
];

if( file_exists($file = DIR."io/admin/$io".php) ) $data = require_once $file;

elseif( file_exists($file = DIR."io/$io".php) ) $data = require_once $file;

if( is_scalar($data ?? 0) ) $data = io::getData( str_replace('.','_', $io) );

return compact('event', 'data');

