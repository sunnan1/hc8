<?php namespace _;

$caregivers = io::getData('caregivers');

$_certs		= certs::getData();

foreach( $_certs as $cert )
switch( $cert['key'] ) :

	case 'rn':
	case 'basic':
	case 'wound_simple':
	case 'wound_complicated':

		$certs[ $cert['key'] ] = $cert;

	break;

	case 'injection':

		$certs[ 'injection_im' ] = $cert;
		$certs[ 'injection_sc' ] = $cert;

	break;

endswitch;

// ADJUST PATIENT OBJECT RESPONSE
foreach( $caregivers as $caregiver ) :

	$ccerts = $caregiver['certifications'];
	
	$caregiver['certifications'] = 0;
	
	unset($caregiver['schedule']);

	$caregiver['type'] = 'caregiver';

	foreach($ccerts as $ccert)
	if( isset($certs[ $ccert ]) )
	$caregiver['certifications'] |= $certs[ $ccert ]['bit_value'];

	$staff[ $caregiver['id'] ] = $caregiver;

endforeach;

if( !has_get('staff') ) return array_values($staff);
if( !$id = filter_int('staff') ) return array_values($staff);

return $staff[ $id ] ?? [];
