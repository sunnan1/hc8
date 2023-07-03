<?php namespace _;

$data = io::getData('tasks');

$date = strtotime( date('Y-m-d') . ' 00:00:00' );

foreach( $data as &$task ) :
	foreach( ['creationTime','completionTime'] as $key ) :

		if( !is_string($task[$key]) ) continue;

		[ $day, $time ] = split( $task[$key] );

		$day			= strtotime( $day ?: 'now' );

		$task[$key]		= strtotime( date('Y-m-d', $day) . ' ' . $time );

	endforeach;
endforeach;

return $data;
