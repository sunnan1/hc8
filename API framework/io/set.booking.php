<?php namespace _;


const
qskeys = 'project_id|patient_id|product_id|products|start_time|end_time|duration|first_name|last_name|sex|dob|email|phone|street|street_2|city|county|eircode|country|note|status|type|cats|meta',
qakeys = [
	'project_id'	=> ['project','clinic_id','clinic','site_id','site'],
	'patient_id'	=> ['patient','client_id','client'],
	'product_id'	=> ['product','sku'],
	'start_time'	=> ['start','time'],
	'end_time'		=> ['end'],
	'duration'		=> [],
	'first_name'	=> ['fname','first','firstname','name'],
	'last_name'		=> ['lname','last','lastname'],
	'sex'			=> ['gender','male_female'],
	'dob'			=> ['DOB','birthday','date_of_birth'],
	'email'			=> ['eMail','mail','email_address'],
	'phone'			=> ['mobile','tel','number'],
	'street'		=> ['address','street_1','address_1','street_name'],
	'street_2'		=> ['address_2','street_name_2'],
	'city'			=> ['town'],
	'county'		=> ['region','state'],
	'eircode'		=> ['zipcode','post_code','postcode','zip'],
	'country'		=> [],
	'note'			=> ['notes','msg','message','memo','comment'],
	'status'		=> ['state'],
	'type'			=> ['types','typeof'],
	'cats'			=> ['cat','category','categories'],
	'products'		=> ['skus'],
	'meta'			=> ['data','metadata','meta_data'],
],

qfilters = [
	'booking_id'	=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'project_id'	=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'patient_id'	=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'product_id'	=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'start_time'	=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'end_time'		=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'duration'		=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'first_name'	=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_FLAG_NO_ENCODE_QUOTES|FILTER_SANITEXT ],
	'last_name'		=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_FLAG_NO_ENCODE_QUOTES|FILTER_SANITEXT ],
	'sex'			=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'dob'			=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'email'			=> FILTER_SANITIZE_EMAIL,
	'phone'			=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'street'		=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'street_2'		=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'city'			=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'county'		=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'eircode'		=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'country'		=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'note'			=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_FLAG_NO_ENCODE_QUOTES|FILTER_SANITEXT ],
	'status'		=> [ 'filter'=>FILTER_SANITIZE_STRING, 'flags'=>FILTER_SANITEXT ],
	'type'			=> FILTER_SANITIZE_NUMBER_INT,
	'cats'			=> FILTER_SANITIZE_NUMBER_INT,
	'products'		=> FILTER_SANITIZE_NUMBER_INT,
	'meta'			=> ['data','metadata','meta_data'],
],

filter_list = [
	'int',
	'boolean',
	'float',
	'validate_regexp',
	'validate_domain',
	'validate_url',
	'validate_email',
	'validate_ip',
	'validate_mac',
	'string',
	'stripped',
	'encoded',
	'special_chars',
	'full_special_chars',
	'unsafe_raw',
	'email',
	'url',
	'number_int',
	'number_float',
	'magic_quotes',
	'add_slashes',
	'callback'
],

response	= [

	1	=> "Success [%s]: the booking has been updated!",
	2	=> "No changes: the data submitted has not changed.",
	4	=> "Required field: please try again with [%s] included",
	8	=> "Database error: %s",
	16	=> "Connection error: you have exceeded our request limit, please try again later",
	32	=> "Unknown system error: please try again",

];

//dev.hfi.amnexis.app/set.booking.io?project_id=dcc&patient_id=xx1234&product_id=scrn-4445&start_time=2019-10-28+11:30&end_time=2019-10-28+11:45&duration=00:20&first_name=Sarah&last_name=La+Fazia&sex=female&email=sarah@byto.media&phone=1(401)274-5373&street98+Holden+St.&city=providence&county=Providence+Plantations&eircode2245GH&country=U.S.A.&note=

$data = filter_input_array(INPUT_GET, qfilters, FALSE);
extract($data);

if(!($booking_id??0)) return ['success'=>FALSE, 'error'=>sprintf(response[4], 'booking_id')];

$was = is_queue($booking_id) ? filter(get_queue($booking_id)) : [];


foreach( qakeys as $k => $a ) :

switch($k) :

	case 'start_time':
	case 'project_id':
	case 'first_name':
	case 'sex':
	case 'dob':
	case 'email':

	if( !($$k??0) ) :
		if( !$filtered = filter( filter_input_array( INPUT_GET, array_fill_keys($a, qfilters[$k]), FALSE) ) ) :
		
			if( !$was ) : return ['success'=>FALSE, 'error'=>sprintf(response[4], $k)]; endif;

		else:

			$$k = array_shift( $filtered );

		endif;
	endif;

	break;
	case 'patient_id':
	case 'product_id':
	case 'end_time':
	case 'duration':
	case 'last_name':
	case 'phone':
	case 'street':
	case 'street_2':
	case 'city':
	case 'county':
	case 'eircode':
	case 'country':
	case 'note':
	case 'status':
	case 'type':
	case 'cats':
	case 'products':
	case 'meta':

	if( !($$k??0) && !!$a )
		if( !!$filtered = filter( filter_input_array( INPUT_GET, array_fill_keys($a, qfilters[$k]), FALSE) ) )
			$$k = array_shift( $filtered );

endswitch;

endforeach;


if( !!$was ) :

	if( !$diff = array_diff_assoc(compact(array_keys($data)), $was) )
	return ['success'=>FALSE, 'message'=>response[2]];

	

//if( !$end_time )

endif;

