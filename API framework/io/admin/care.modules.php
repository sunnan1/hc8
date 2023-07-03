<?php namespace _;

foreach( care::BITS as $bit_value => $code ) :

	$duration	= care::DURATIONS[ $code ];
	$label		= care::description( $code );

	$data[] = compact('code','label','bit_value','duration');

endforeach;

return $data ?? NULL;
