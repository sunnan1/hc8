<?php namespace _;

$oldData = io::getData('patients');

foreach( $oldData as &$pat ) :

	$risks = [];
	$allergies = [];
	$infections = [];

	foreach($pat['risks'] as $risk) :

		$label = $risk;
		$is_new = !!rand(0,1);

		$risks[] = compact('label','is_new');

	endforeach;

	
	foreach($pat['allergies'] as $allergy) :

		$label = $allergy;
		$is_new = !!rand(0,1);

		$allergies[] = compact('label','is_new');

	endforeach;
	
	foreach($pat['infections'] as $infection) :

		$label = $infection;
		$is_new = !!rand(0,1);

		$risks[] = compact('label','is_new');

	endforeach;

	$pat['risks'] = $risks;
	$pat['allergies'] = $allergies;
	$pat['infections'] = $infections;

endforeach;

return $oldData;


