<?php namespace _;


if( !$booking_id ) return (object)[];

if( !$result = get_result( $booking_id ) )

	if( !$result = new_result( $booking_id ) ) return (object)[];

$o		= (object)$result;
$data	= sanitize_post( $_POST );
$new	= [];

$hdl	= $o->cholesterol_hdl;
$ldl	= $o->cholesterol_ldl;

if( 0 < ($data['cholesterol_total'] ?? 0) ) :

	$total	= $data['cholesterol_total'];

	if( !!$hdl && !!$ldl && ($total == $hdl + $ldl) ) :
	
		unset($data['cholesterol_hdl'], $data['cholesterol_ldl']);

	elseif( (isset($data['cholesterol_hdl']) || isset($data['cholesterol_ldl']))
		&& 0 < ($ldl = ($data['cholesterol_ldl'] ?? 0) ?: $ldl)
		&& 0 < ($hdl = ($data['cholesterol_hdl'] ?? 0) ?: $hdl)
		&& ( $total == $ldl + $hdl ) ) :
		
		$data['cholesterol_ldl'] = $ldl;
		$data['cholesterol_hdl'] = $hdl;

	else : 
		
		$data['cholesterol_ldl'] = $data['cholesterol_hdl'] = 0;

	endif;

elseif( isset($data['cholesterol_hdl']) || isset($data['cholesterol_ldl']) ) :
	
	$total = $o->total;

	$ldl = ($data['cholesterol_ldl'] ?? $ldl);
	$hdl = ($data['cholesterol_hdl'] ?? $hdl);
	
	if( (!$ldl || !$hdl) and 0 < $total )
	$data['cholesterol_total'] = 0;

	elseif( !(!$ldl || !$hdl) and $total != $ldl + $hdl )
	$data['cholesterol_total'] = $ldl + $hdl;

endif;


foreach($data as $k => $val) :

	if( $val == $o->$k ) continue;

	$new[ $k ]		= $val;
	$delta[ $k ]	= ['old'=>$o->$k, 'new'=>$val];

endforeach;

$set_data = $new + $result;

sanitize_data($set_data, FALSE, Ns.'__return_self');

$set = array_keys($set_data);

// CHECK METABOLIC STATE
if( !$metabolics = array_diff(metabolics, $set, ['metabolic_notes']) )
	$metabolic_state = 'acceptable';
else
	$metabolic_state = !array_intersect(metabolics, $set) ? 'queued' : 'started';

// CHECK SCREENING STATE
$not_required = ['fasted','thyroid','prostate','screening_notes'];

if(!$screenings = array_intersect(screenings, array_diff($set, ['fasted'])))
	$screen_state = 'queued';
elseif( !array_diff(screenings, $set, ['cholesterol_ldl','cholesterol_hdl'], $not_required) || !array_diff(screenings, $set, ['cholesterol_hdl'], $not_required) )
	$screen_state = 'acceptable';
else
	$screen_state = 'started';

foreach(['metabolic_state','screen_state'] as $s) :

	if( $$s == $o->$s ) continue;
	
	$new[ $s ]	= $$s;
	$delta[ $s ]= ['old'=>$o->$s, 'new'=>$ss];

endforeach;


$delta['response'] = update_result($booking_id, $new);

log_delta( $delta );

//return compact('booking_id','sex','new','delta'); exit;

return format_result( $booking_id );
