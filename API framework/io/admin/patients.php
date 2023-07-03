<?php namespace _;

$patients = io::getData('patients');

$risks		= warn::risks();
$allergies	= warn::allergies();
$infections	= warn::infections();

// ADJUST PATIENT OBJECT RESPONSE
foreach( $patients as $patient ) :

	unset($patient['medications']);
	unset($patient['previous_visit']);

	foreach(['risks','infections','allergies'] as $warn) :

		$warns			= $patient[$warn];
		$patient[$warn]	= 0;

		if( [] >= $warns ) continue;

		$prop	= 'risks' === $warn ? 'label' : 'key';
			
		foreach($$warn as $item)
		if( in_array($item[$prop], $warns) )
		$patient[$warn] |= $item['bit_value'];

	endforeach;

	$pats[ $patient['id'] ] = $patient;

endforeach;

if( !has_get('patient') ) return array_values($pats);
if( !$id = filter_int('patient') ) return array_values($pats);

return $pats[ $id ] ?? [];
