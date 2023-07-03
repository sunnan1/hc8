<?php namespace _;

$notifications[] = [
	
	'icon'			=> 'info',
	'message'		=> 'patient medication modified',
	'button_text'	=> 'View Changes',
	'screen'		=> 'patient.medication',
	'id'			=> 3,
	'action'		=> '',
	'timestamp'		=> strtotime('-10 minutes')

];

return compact('notifications');