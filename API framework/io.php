<?php namespace _;

// THIS NEEDS TO BE REWRITTEN TO USE MATCH (PHP8) AND NATIVE CHECK WE BE DONE VIA HEADERS WHEN THEY ARE IN PLACE
$io = EP_NAME;

// SWITCH TO HEADER CHECK
$isWin = start_was($io, 'win.');

// CHECK IF CAREGIVER - SWITCH TO HEADER CHECK
$isCaregiver = !$isWin && start_was($io, 'caregiver.');

switch( $io ) :

	case 'care.medmodules':
	case 'care.measures':				$io = 'measures';
	case 'caregiver.heartbeat':
	case 'measures':

	case 'login':
	
	case 'staff':
	case 'caregivers':
	case 'care.modules':
	case 'care.plans':
	case 'infections':
	case 'certifications':
	case 'heartbeat':
	case 'infections.active':
	case 'risks':
	case 'risks.active':
	case 'patient.risks.add':    		// ADD or REMOVE
	case 'patient.risks.remove':    	// ADD or REMOVE
	case 'allergies':
	case 'allergies.active':
	case 'patient.allergies.add':    	// ADD or REMOVE
	case 'patient.allergies.remove':    // ADD or REMOVE
	case 'medication':
	case 'tour':
	case 'tour.reschedule':
	case 'contacts':
	case 'patients':
	case 'patients.test':
	case 'notes':
	case 'tasks':
	case 'notes.add':     				// ADD | REMOVE | UPDATE
	case 'notes.update':    			// ADD | REMOVE | UPDATE
	case 'tasks.add':    				// ADD | REMOVE | UPDATE
	case 'tasks.update':
		
		if( in_array($io, ['notes.add','notes.update','tasks.add','tasks.update']) ) $io = 'set.note';
		    			// ADD | REMOVE | UPDATE
	case 'patient.infections.remove':   // ADD or REMOVE
	case 'patient.infections.add':    	// ADD or REMOVE
	case 'visits':
	case 'abort.visit':    				// ADD | REMOVE | UPDATE
	case 'abort.tour':    				// ADD or REMOVE
	case 'visit.care.add':    			// ADD | REMOVE | UPDATE
	case 'visit.care.remove':   		// ADD or REMOVE
	case 'visit.audio':
	case 'visit.history':
	case 'patient.coords':
	case 'vehicles':
	case 'support':
	case 'notifications':

	// FOR DEV TASKS
	case 'headers.test':
	case 'dev':

		// THIS FILE WILL CHANGE TO NATIVE SPECIFIC HANDLING WHEN HEADERS ARE IN PLACE
		if( $isWin ) $out = require_once DIR.'io/admin'.php;

		elseif( $isCaregiver && file_exists($file = DIR."io/caregiver/$io".php) ) $out = require_once $file;

		elseif( file_exists($file = DIR.'io/' . APPID . "/$io".php) ) $out = require_once $file;
		elseif( file_exists($file = DIR."io/$io".php) ) $out = require_once $file;

		if( is_scalar($out ?? 0) ) $out = io::getData( str_replace('.','_', $io) );

		// REMOVE WITH HEADER CHECK
		if( !UUID ) Json_x( $out ?? [] );

		if( isset($out) && isset($out['event']) ) Json_x( $out );

		$event = [
			'success'	=> TRUE,
			'error'		=> FALSE,
			'failure'	=> FALSE,
			'message'	=> '',
			'confirm'	=> FALSE
		];

		$data	= $out ?? ((object)[]);

		Json_x( compact('event', 'data') );

endswitch;

code();

exit;