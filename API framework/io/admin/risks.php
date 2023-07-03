<?php namespace _;

return warn::risks();

/*
if( file_exists( DIR."data/demo/risks".json ) )
$risks = getJson( DIR."data/demo/risks".json );

foreach($risks as $risk)
	if( !!$risk['eventForm'] ) $has_form[] = $risk['id'];


$join = join($has_form, "','");

$join = "['$join']";

return compact('join');

//return compact('risks');
/*
?><pre><?php

foreach($risks as $risk) :
	
	extract($risk); //$ids[] = $risk['id'];

?>		'<?= $id ?>'	=> __('<?= $label ?>'),
<?php endforeach; ?></pre><?php exit;

//return compact('ids');

$join = join($ids, "','");

$join = "['$join']";

return compact('join');
/**/