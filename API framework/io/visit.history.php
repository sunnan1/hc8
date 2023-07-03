<?php namespace _;

// GET PATIENT
if( has_get('patient') ) $patient = filter_int('patient');
elseif( has_get('patient_id') ) $patient = filter_int('patient_id');

$data = io::getData('visit.history');

$date = strtotime( date('Y-m-d') . ' 00:00:00' );

foreach( $data as &$visit ) :

	if( isset($patient) && ($patient != $visit['patient']) ) continue;

	if( !is_string($visit['time']) ) continue;

	[ $day, $time ] 	= split( $visit['time'] );
	$day				= strtotime( $day );

	$visit['time']		= strtotime( date('Y-m-d', $day) . ' ' . $time );
	$visit['id']		= $visit['time'] . '_' . $visit['patient'];

	$visits[]			= $visit;

endforeach;

return $visits ?? [];
