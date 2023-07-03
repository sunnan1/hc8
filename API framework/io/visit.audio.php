<?php namespace _;

if( !has_get('visit') && !has_get($get = 'visit_id') ) return;
if( !$visit = filter_get($get ?? 'visit') ) return;

$date	= strtotime( date('Y-m-d') . ' 00:00:00' );

// REMOVE DATE FROM VISITID TO GET THE PATIENT
if( start_was($visit, "{$date}_") ) $pid = $visit;
else [ $time, $pid ] = split($visit, '_');

// TRY TO GET THE PATIENT
if( !$patient = getPatient($pid) ) return ["Patient ($pid) not found"];

// EXTRACT ALL PATIENT DATA
extract( $patient );

// ADD PATIENT INFO
$sections[] = [
	'id'	=> 'identity_section',
	'text'	=> 'This is information regarding your next patient;',
	'items'	=> [
		[
			'id'	=> 'names',
			'text'	=> "Patient name: $first_name $last_name."
		]
	]
];

// RESET ITEMS
$items = [];

// CHECK FOR INFECTIONS
if( [] < $infections )
foreach( $infections as $infection ) :

	if( !$item = getInfection( $infection ) ) continue;
	[ $id, $text ] = array_values( $item );
	
	$items[] = compact('id','text');

endforeach;

//if( [] < ($items ?? []) )
$sections[] = [
	'id'	=> 'infections_section',
	'text'	=> 'Take precaution as your patient has the following active infections;',
	'items'	=> $items ?? [],
];

// RESET ITEMS
$items = [];

// CHECK FOR ALLERGIES
if( [] < $allergies )
foreach( $allergies as $allergy ) :

	if( !$item = getAllergy( $allergy ) ) continue;
	[ $id, $text ] = array_values( $item );
	
	$items[] = compact('id','text');

endforeach;

$sections[] = [
	'id'	=> 'allergies_section',
	'text'	=> 'Take precaution as your patient has the following active allergies;',
	'items'	=> $items ?? [],
];

// RESET ITEMS
$items = [];

// PREVIOUS VISIT
extract( $previous_visit );

$sections[] = [
	'id'	=> 'last_visit_section',
	'text'	=> 'This is the patients status and note following the patient\'s last visit;',
	'items'	=> [
		[
			'id'	=> 'status',
			'text'	=> "Patient status: $status."
		],
		[
			'id'	=> 'note',
			'text'	=> "End of care note: $note."
		]
	]
];

// MEDICATION
if( 0 < ($cnt = count($medications)) )
$sections[] = [
	'id'	=> 'medication_section',
	'text'	=> 'Medication note:',
	'items'	=> [
		[
			'id'	=> 'meds',
			'text'	=> "Your patient has $cnt active prescriptions."
		]
	]
];


// CHECK FOR RISKS
if( [] < $risks )
foreach( $risks as $risk ) :

	if( !$item = getRisk( $risk ) ) continue;
	[ $id, $text ] = array_values( $item );
	
	$items[] = compact('id','text');

endforeach;

//if( [] < ($items ?? []) )
$sections[] = [
	'id'	=> 'risks_section',
	'text'	=> 'Take precaution as your patient was assessed with the following risks;',
	'items'	=> $items ?? [],
];

// RESET ITEMS
$items = [];

return compact('sections');
