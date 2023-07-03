<?php namespace _;

$event = [
	'success'	=> FALSE,
	'error'		=> FALSE,
	'failure'	=> TRUE,
	'message'	=> 'no id in POST',
	'confirm'	=> FALSE
];

$data = ((object)[]);

if( !has_post('id') ) return compact('event','data');
if( !$id = filter_post('id') ) return compact('event','data');

return compact('id');
