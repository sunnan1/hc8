<?php namespace _;

$plans	= (array)io::getData('care_plans');
$_codes	= array_flip(care::MODULES);
$bits	= array_flip(care::BITS);

foreach( $plans as $plan ) :

	extract( (array)$plan );

	$codes		= [];
	$bit_value	= 0;
	$duration	= 0;

	foreach( $modules as $module ) :

		$code		= $_codes[ $module ];
		$codes[]	= $code;

		$bit_value |= $bits[ $code ];
		$duration += care::DURATIONS[ $code ];

	endforeach;

	$data[] = compact('id','bit_value','duration','codes');

endforeach;

return $data ?? NULL;