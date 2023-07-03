<?php namespace _;

//header('Content-Type: application/json');

$event = [
	'success'	=> TRUE,
	'error'		=> FALSE,
	'failure'	=> FALSE,
	'message'	=> '',
	'confirm'	=> FALSE
];

$data = json_decode('[
	{
		"id": "id1",
		"type": "general",
		"description": "General notification example"
	},
	{
		"id": "id2",
		"type": "add_patient",
		"description": "Add patient to the tour",
		"patient_id": "3"
	},
	{
		"id": "id3",
		"type": "add_task",
		"description": "Add task",
		"task_id": "id1"
	}
]');

if( !UUID ) Json_x( $data );

Json_x( compact('event', 'data') );


