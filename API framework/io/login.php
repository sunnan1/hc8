<?php namespace _;

static $users = [

	'pra+hc1@amnexis.com' => [
		'password'	=> 'P@$$w0rd01',
		'caregiver_id'=> 1,
		'uuid'		=> '3e6095b9-6726-11ed-be2f-c4377218d143'
	],

	'eoc+hc1@amnexis.com' => [
		'password'	=> 'P@$$w0rd02',
		'caregiver_id'=> 2,
		'uuid'		=> '3e61affb-6726-11ed-be2f-c4377218d143'
	],

	'tlf+hc1@amnexis.com' => [
		'password'	=> 'P@$$w0rd03',
		'caregiver_id'=> 3,
		'uuid'		=> '3e626c00-6726-11ed-be2f-c4377218d143'
	],

];

$error		= FALSE;
$success	= FALSE;
$message	= '';
$confirm	= FALSE;
$show		= FALSE;

$user		= filter_post('username');
$pass		= filter_post('password');

if( !isset($users[$user]) ) :

	$message	= __('user not found');
	$error		= TRUE;

	$event		= compact('error','success','message','confirm','show');

	Json_x( compact('event') );

endif;

extract($users[$user]);

if( $pass !== $password ) :

	$message	= __('invalid password');
	$error		= TRUE;

	$event		= compact('error','success','message','confirm','show');

	Json_x( compact('event') );

endif;

$success	= TRUE;
$message	= __('verified user');

$time		= (int)floor( (strtotime('now') / sec_day) );
$token		= token("$time:$uuid", 'login');

$event		= compact('error','success','message','confirm','show');
$data		= compact('uuid', 'caregiver_id', 'token');
$data['contact_id'] = $data['caregiver_id'];

Json_x( compact('event','data') );
