<?php namespace _;


foreach(measure::KEYS as $key) :

	$class = Ns.'app_'.($lower = strtolower( $key ));

	$RC = new \ReflectionClass($class);

	foreach(measure::APP_PROPERTIES as $const)
	$data[ $lower ][ $const ] = $RC->getConstant($const);

endforeach;

return $data;