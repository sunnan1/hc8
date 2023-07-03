<?php namespace _;


$db = new \mysqli(db_host, db_user, db_pass, db_name);
if( $db->connect_errno ) return 0;

//$date = date('Y-m-d');
//$thirty=date('Y-m-d', strtotime('+30 days'));

$sql = "SELECT `project`, `booking` FROM `bookings` WHERE start_time >= CURDATE() AND end_time < DATE_ADD(CURDATE(), INTERVAL 2 WEEK) GROUP BY `project`,`booking`";
//echo $sql; exit;
if( !$pros = $db->query($sql) ) return [];

while($pro = $pros->fetch_assoc()) :
	
	//extract($pro);
	
	$_projects[] = [

		'id'	=> $pro[project],
		'name'	=> $pro['booking'],
	];

endwhile;

$pros->free();
$db->close();

return $_projects ?? [];