<?php namespace _;


function error( string $msg ) {

	$event = [
		'success'	=> FALSE,
		'error'		=> TRUE,
		'failure'	=> FALSE,
		'message'	=> $msg,
		'confirm'	=> FALSE
	];

	$data	= NULL;

	Json_x( compact('event', 'data') );

}

function fail( string $msg ) {

	$event = [
		'success'	=> FALSE,
		'error'		=> FALSE,
		'failure'	=> TRUE,
		'message'	=> $msg,
		'confirm'	=> FALSE
	];

	$data	= NULL;

	Json_x( compact('event', 'data') );

}

function success( string $msg, array $data = NULL ) {

	$event = [
		'success'	=> TRUE,
		'error'		=> FALSE,
		'failure'	=> FALSE,
		'message'	=> $msg,
		'confirm'	=> FALSE
	];

	if( !$data ) $data = (object)[];

	Json_x( compact('event', 'data') );

}
