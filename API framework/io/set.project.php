<?php namespace _;


$project ?? ($project = $_POST[project]) ?? ($project = $_GET[project]);

if( !is_project( $project ) ) exit;

log_var(project, $project);
setcookie(a.pro, $project, time()+(sec_hou*4),'/','amnexis.app');
	
//\apc_store( aa.is.device_id.a.pro, $project, sec_hou*2 );

return require_once DIR."io/bookings".php;
