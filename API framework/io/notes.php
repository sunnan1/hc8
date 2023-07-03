<?php namespace _;

$data = io::getData('notes');

$date = strtotime( date('Y-m-d') . ' 00:00:00' );

foreach( $data as &$note ) :

	if( !is_string($note['creationTime']) ) continue;

	[ $day, $time ] 	= split( $note['creationTime'] );

	$day				= strtotime( $day );

	$note['creationTime']	= strtotime( date('Y-m-d', $day) . ' ' . $time );

endforeach;

return $data;
