<?php namespace _;

$data = io::getData('tour');

extract( $data );

$add	= 0;

$day	= strtotime( "+$add day" );
$date	= strtotime( date('Y-m-d', $day) . ' 00:00:00' );

//$date	= strtotime( date('Y-m-d') . ' 00:00:00' );

//$id		= "{$date}_2";
$id		= "tour_0002";

foreach( $visits as &$visit ) :

	$eta			= strtotime( date('Y-m-d', $day) . ' ' . $visit['eta'] );
	//$eta			= strtotime( date('Y-m-d') . ' ' . $visit['eta'] );
	$visit['id']	= "{$eta}_" . $visit['patient']['id'];
	$visit['eta']	= $eta;
	
	if( !isset($care_notes) ) :
	    
	    $care_notes['transfer_to_from_bed'][] = [
	        'author'    => 2,
	        'timestamp' => $eta - sec_day,
	        'note_text' => "It was difficult to convince the patient to get out of bed today",
	    ];
	    
	    $care_notes['transfer_to_from_bed'][] = [
	        'author'    => 3,
	        'timestamp' => $eta - (sec_day * 2),
	        'note_text' => "Patient almost refused to leave the bed today",
	    ];
	    
	    $visit['care_notes'] = $care_notes;
	    
	endif;

endforeach;

return compact( 'id', 'date', 'visits' );
