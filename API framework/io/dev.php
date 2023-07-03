<?php namespace _;

/*
static $target = 'patients';

$name	= filter_get('n') ?: 'risks';

return warn::$name();
*/

/*
$care = (array)io::getData('care_modules');

$bits = array_keys(care::BITS);
$codes= array_values(care::BITS);

foreach( $codes as $i => $code ) :

	$module = (array)$care[ $i ];

	?>'<?= $codes[ $i ] ?>'	=> '<?= $module[ 'id' ] ?>',<br><?php

endforeach;

exit;

*/

/*
foreach( care::BITS as $bit_value => $code ) :

	$duration	= care::DURATIONS[ $code ];
	$label		= care::description( $code );

	$data[] = compact('code','label','bit_value','duration');

endforeach;

$data ?? ($data = NULL);

if( 'care' === $target )
return compact('event', 'data');
*/

/*
$patients	= io::getData('patients');
echo '<pre>';
foreach( $patients[0] as $name => $val ) :
?>
<?= "$name: " ?><?php if(!is_numeric($val)) : echo '"[?= $' . $name. ' ?]"'; else : echo '[?= $'.$name.' ?]'; endif; ?>,<br><?php endforeach;
echo '</pre>';

exit;
//return $data;

*/

$_patients	= io::getData('patients');
echo '<pre>';
foreach( $_patients as $pat ) : ?>
<?= "{$pat['last_name']}, {$pat['first_name']}" ?><br><?php endforeach;
echo '</pre>';

exit;

