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

endforeach;

return compact( 'id', 'date', 'visits' );
