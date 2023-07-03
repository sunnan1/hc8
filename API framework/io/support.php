<?php namespace _;

$support	= '[
	{
		"id": 1001,
		"type": "url",
		"text": "A support link"
	},
	{
		"id": 1002,
		"type": "pdf",
		"text": "A support document"
	},
	{
		"id": 1003,
		"type": "video",
		"text": "A support video"
	}
]';

if( !UUID ) :
	
	header('Content-Type: application/json');

	echo '{
		
		"support": ' . $support . '

	}';

	exit;

endif;

$event = [
	'success'	=> TRUE,
	'error'		=> FALSE,
	'failure'	=> FALSE,
	'message'	=> '',
	'confirm'	=> FALSE
];

$data = json_decode( $support );

Json_x( compact('event', 'data') );


