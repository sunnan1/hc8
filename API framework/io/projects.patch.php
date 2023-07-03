<?php namespace _;

$db = new \mysqli(db_host, db_user, db_pass, db_name);
if( $db->connect_errno ) return 0;

$date = date('Y-m-d');
$thirty=date('Y-m-d', strtotime('+30 days'));

$sql = "SELECT `project`, `booking`, COUNT('booking_id') AS cnt, MIN('start_time') as start_time, MAX('end_time') as end_time FROM `bookings` WHERE start_time >= '$date 00:00:00' AND end_time < '$thirty 00:00:00' GROUP BY `project`,`booking`";

if( !$pros = $db->query($sql) ) return [];


$projects[] = [

	'booking_id'	=> '00000000',
	'start_time'	=> "$date 00:00:00",
	'end_time'		=> "$date 23:59:59",
	'first_name'	=> "Please select one",
	'last_name'		=> "of the following",
	'sex'			=> NULL,
	'dob'			=> '0000-00-00',
	'metabolic_state'=>'pending',
	'screen_state'	=>'pending'
];
$b4 = 24;
while($pro = $pros->fetch_assoc()) :
	
	extract($pro);
	
	$projects[] = [

		'booking_id'	=> $project,
		'start_time'	=> $start_time,
		'end_time'		=> $end_time,
		'first_name'	=> $booking,
		'last_name'		=> "($cnt)",
		'sex'			=> NULL,
		'dob'			=> '0000-00-00',
		'metabolic_state'=>'pending',
		'screen_state'	=>'pending'
	];

	/*[
		{
			"booking_id": "LIMCC-00010",
			"start_time": "2019-10-07 08:00:00",
			"end_time": "2019-10-07 08:15:00",
			"first_name": "Kevin",
			"last_name": "Foster",
			"sex": "male",
			"dob": "1994-05-03",
			"metabolic_state": "queued",
			"screen_state": "queued"
		},
		{
			"booking_id": "LIMCC-00043",
			"start_time": "2019-10-07 08:15:00",
			"end_time": "2019-10-07 08:30:00",
			"first_name": "MARY",
			"last_name": "HYNES",
			"sex": "female",
			"dob": "1966-08-15",
			"metabolic_state": "queued",
			"screen_state": "queued"
		},
	]*/

endwhile;

while(--$b4)
$projects[] = [

	'booking_id'	=> "0000-00$b4",
	'start_time'	=> "$date 00:00:00",
	'end_time'		=> "$date 23:59:59",
	'first_name'	=> "Please select one",
	'last_name'		=> "of the following",
	'sex'			=> NULL,
	'dob'			=> '0000-00-00',
	'metabolic_state'=>'pending',
	'screen_state'	=>'pending'
];)

$pros->free();
$db->close();

return $projects ?? [];