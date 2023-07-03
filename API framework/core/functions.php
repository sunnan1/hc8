<?php namespace _;


require_once DIR.'core/functions/types'.php;
require_once DIR.'core/functions/strings'.php;
require_once DIR.'core/functions/array'.php;
require_once DIR.'core/functions/auth'.php;
require_once DIR.'core/functions/sanitize'.php;
require_once DIR.'core/functions/event'.php;

function __( string $string ) { return _( $string ); }

function is_record( string $tbl, string $where ) {  

	$db = new db(db_host, db_user, db_pass, db_name);

	if( !!$db->connect_errno ) return FALSE;
	
	$is = $db->query("SELECT IF (EXISTS( SELECT * FROM $tbl WHERE $where),1,0) AS x");

	$a = $is->fetch_assoc();
	
	$is->free();
	$db->close();

	return !!$a['x'];

}

function is_option( string $key = NULL ) { return is_record( 'options', "key=$key" ); }

function get_option( string $key = NULL ) {
	
	$db = new \mysqli(db_host, db_user, db_pass, db_name);
	if( $db->connect_errno ) return;

	if(!$stmt = $db->prepare("SELECT * FROM `options` WHERE `key`=? LIMIT 1")) return;
	if(!$stmt->bind_param('s', $key) || !$stmt->execute()) return;
	
	if(!$rows = $stmt->get_result()) return;
	$stmt->close();

	if(!$option = $rows->fetch_assoc()) return;

	$rows->free();
	$db->close();

	return $option;

}

function set_option( string $key, array $vals = NULL ) {

	foreach($vals as $col => $val)
	switch( $col ) :

		case 'name':
		case 'type':
		case 'bool':
		case 'int':
		case 'dub':
		case 'real':
		case 'date':
		case 'time':
		case 'timestamp':
		case 'text':
		case 'object':
		case 'meta':  $new[] = "$col=$val";
		break;

	endswitch;

	if( !($new??0) ) return;

	if( !is_option($key) && !new_option($key) ) return;

	$db = new \mysqli(db_host, db_user, db_pass, db_name);
	if( $db->connect_errno ) return 0;

	$set = join($new);

	$result = $db->query("UPDATE options SET $set WHERE key='%s'", $key);

	$db->close();

	return TRUE;

}

function getPatient( int $id ) : array {

	static $patients = [];

	if( [] === $patients )
	foreach( io::getData('patients') as $patient )
	$patients[ (int)$patient['id'] ] = $patient;

	return $patients[$id] ?? [];

}

function getRisk( string $key ) : array {

	static $risks = [];

	if( [] === $risks )
	foreach( io::getData('risks') as $risk )
	$risks[ $risk['id'] ] = $risk;

	return $risks[$key] ?? [];

}

function getInfection( string $key ) : array {

	static $infections = [];

	if( [] === $infections )
	foreach( io::getData('infections') as $infection )
	$infections[ $infection['id'] ] = $infection;

	return $infections[$key] ?? [];

}

function getAllergy( string $key ) : array {

	static $allergies = [];

	if( [] === $allergies )
	foreach( io::getData('allergies') as $allergy )
	$allergies[ $allergy['id'] ] = $allergy;

	return $allergies[$key] ?? [];

}

function new_option( string $key ) {

	$db = new \mysqli(db_host, db_user, db_pass, db_name);
	if( $db->connect_errno ) return;

	if(!$stmt = $db->prepare("INSERT INTO options (key) VALUES ('?')")) return;
	if(!$stmt->bind_param('s', $key) || !$stmt->execute()) return;

	$stmt->close();
	$db->close();

	return TRUE;

}

function get_data( string $key ) {

	if( !$opt = get_option($key) ) return(object)[];

	return json_decode( $opt['object'] ?? '{}' );

}

function set_data( string $key, $val ) { return set_option($key, ['object' => json_encode($val)]); }

function is( string $id ) {
	
	static $is=[];
	
	if( !isset($is[ $id ]) )
	switch($id) :
	
	// CASE OF COOKIES
	case sooper: $is[ $id ] = check( $id, $_COOKIE[a.is] ?? NULL );
	
	endswitch;
	
	return TRUE === $is[ $id ];
	
}

function cookie( string $c ) { return $_COOKIE[ $c ] ?? NULL; }

function check( string $data, string $hash=NULL, string $scope=auth, int $algo=18 ) {
	
	isset(ukeys[$scope]) or $scope = auth;
	
	return NULL !== $hash && $hash === hash_hmac( hmac_algos[ $algo ], usalts[ $scope ].'sooper', ukeys[ $scope ] );
	
}

function iamsooper() { 
	
	setcookie('@::is', hash_hmac(hmac_algos[18],auth_salt.'sooper',auth_key),time()+sec_month,'/','amnexis.dev');

}

function setuser() {

	setcookie('@::ua', hash_hmac(hmac_algos[18],auth_salt.'current',auth_key),time()+sec_month,'/','amnexis.dev');

}

function getcsv( string $path ) {
	
	static $_ = [], $dir = DIR.'data/';
	
	//if(!end_is($path, csv)) 
	$path.=csv;
	
	//if(isset($_[ $path ])) return $_[ $path ];
	
	if(file_exists($path))			$file = file($path);
	elseif(file_exists($dir.$path))	$file = file($dir.$path);
	else return [];
	
	$data = array_map('str_getcsv', $file);
	$keys = array_shift($data);
	
	
	foreach($data as &$row)
	$row = array_combine($keys, $row);
	
	return $_[ $path ] = $data;
	
}

function csv( string $path, string $index = NULL ) {
	
	static $_ = [], $dir = DIR.'data/';
	
	if(file_exists($dir.$path.csv))	$file = file($dir.$path.csv);
	else return [];
	
	$data = array_map('str_getcsv', $file);
	$keys = array_shift($data);
	
	foreach($data as &$row)
	$row = array_combine($keys, $row);

	if(!!$index && in_array($index,$keys))
	$data = array_column($data, NULL, $index);
	
	return $_[ $path ] = $data;
	
}

function getJson( string $path, bool $array = TRUE ) {

	if( !file_exists($path) )			return FALSE;
	
	$contents = file_get_contents( $path );

	return json_decode( $contents, $array );
	
}

function check_post_headers() {

	static $headers, $post;
	if( !isset($headers) ) :

		foreach($_POST as $key => $val) :

			$keys[]     = $key;
			$$key       = $val;

		endforeach;

		$post       = compact($keys ?? []);
		$headers    = HEADERS;

	endif;

	return compact('headers','post');

}
