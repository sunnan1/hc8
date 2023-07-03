<?php namespace _;

$oldData = io::getData('patients');

//var_export($oldData);

//exit;

$caData		= csv('ca/patients');

foreach( $caData as $i => &$patient ) :

	//unset($patient['id']);
	unset($patient['gp_contact_id']);
	unset($patient['emergency_contact_id']);
	unset($patient['insurance']);
	unset($patient['infections']);
	unset($patient['risks']);
	unset($patient['post_code']);

	//$patient['id']		= (string)$patient['id'];
	$patient['lat']		= (string)$patient['lat'];
	$patient['long']	= (string)$patient['long'];

	$patients[] = array_replace((array)$oldData[$i], (array)$patient);

	//$patients2[] = ['id' => $patients[$i]['id'], 'key_number' => $patients[$i]['key_number'] ];

	//$patients[] = (array)$patient;

endforeach;

return $patients;

/*

//return $caData;

foreach( $oldData as $i => $opatient )
$data[] = array_replace($opatient, (array)($patient[$i+1]));

return $data;

*/