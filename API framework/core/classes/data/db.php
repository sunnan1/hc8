<?php namespace _;

class db extends \mysqli {

	const
	host = db_host, 
	user = db_user,
	pass = db_pass,
	name = db_name,

	err_msgs = [
		
		'default' => "Db error (%i): %s",
		'connect' => "Connect failed (%i): %s",

	];

	protected $_stmt = NULL;

	function __construct( string ...$cd ) {
		
		[ $user, $pass, $name, $host ] = [

			$cd[0] ?? static::user,
			$cd[1] ?? static::pass,
			$cd[2] ?? static::name,
			$cd[3] ?? static::host

		];

		parent::__construct($host, $user, $pass, $name);
		
		if( $this->connect_errno ) $this->error('connect');
	
	}

	function escape( string ...$strings ) {

		if( NULL === $strings[1] ?? NULL ) return $this->escape_string( $strings[0] );

		return array_map([$this,'escape_string'], $strings);

	}
	
	// FOR DEBUGGING
	function __toString() {
		$string = print_r(get_object_vars($this),TRUE);
		return "$string";
	}

	function maybe_escape( $mixed ) { return !is_string( $mixed ) ? $mixed : $this->escape_string( $mixed ); }

	function escape_args( array $args ) : array { return array_map([$this,'maybe_escape'], $args); }

	function escape_sql( string &$sql, array $args ) : string { return $sql = sprintf( $sql, ...$this->escape_args($args) ); }

	function format_sql( string &$sql, array $args ) : string { return $sql = sprintf( $sql, ...$args ); }

	// FORMAT SQL IF ARGS ARE INCLUDED AND REQTURN RESULT
	function do_query( string $sql, ...$args ) {

		// CREATE THE FORMATTED SQL WITH REPLACED ARGUMENTS
		if( [] !== $args ) $this->format_sql( $sql, $args );

		// RETURN RESULT
		return parent::query( $sql );

	}
	// GET A SIMPLE ARRAY OF VALUES FROM THE FIRST RESULT
	function row( string $sql, ...$args ) {

		// VERIFY THERE IS A RESULT
		if( !$result = $this->do_query($sql, ...$args) ) return FALSE;

		// FETCH THE FIRST ROW
		$row = $result->fetch_row();

		// CLOSE THE RESULT
		$result->close();
		
		return $row;

	}

	// GET AN ASSOCIATIVE ARRAY FROM THE FIRST RESULT
	function arow( string $sql, ...$args ) {

		// VERIFY THERE IS A RESULT
		if(!$result = $this->do_query($sql, ...$args)) return FALSE;

		// FETCH THE FIRST ROW
		$row = $result->fetch_assoc();

		// CLOSE THE RESULT
		$result->close();
		
		return $row;

	}

	// GET AN ARRAY OF ARRAYS
	function rows( string $sql, ...$args ) {

		// VERIFY THERE IS A RESULT
		if(!$result = $this->do_query($sql, ...$args)) return FALSE;

		// FETCH EACH ROW
		while( $row = $result->fetch_row() ) :

			$rows[] = $row;

		endwhile;

		// CLOSE THE RESULT
		$result->close();
		
		return $rows ?? [];

	}

	// GET AN ARRAY OF ASSOCIATIVE ARRAYS
	function arows( string $sql, ...$args ) {

		// VERIFY THERE IS A RESULT
		if(!$result = $this->do_query($sql, ...$args)) return FALSE;

		// FETCH EACH ROW
		while( $row = $result->fetch_assoc() ) :

			$rows[] = $row;

		endwhile;


		// CLOSE THE RESULT
		$result->close();
		
		return $rows ?? [];

	}
	
	function col( string $sql, ...$args ) {

		// VERIFY THERE IS A RESULT
		if(!$result = $this->do_query($sql, ...$args)) return FALSE;

		// FETCH EACH ROW
		while( $row = $result->fetch_row() ) :

			$rows[] = $row[0];

		endwhile;

		$result->close();
		
		return $rows ?? FALSE;

	}

	// GET A SINGLE VALUE FROM RESULT
	function val( string $sql, ...$args ) {

		// RETURN NULL IF NO RESULT
		if( !$row = $this->row($sql, ...$args) ) return NULL;

		// RETURN THE RESULT VALUE
		return $row[0];

	}

	// RETURN A FIXED NUMBER OF VALUES FROM RESULT OR DEFAULT NULL
	function vals( string $sql, ...$args ) {

		// FORMAT SQL NOW SO WE ONLY DO IT ONCE
		if( [] !== $args ) $this->format_sql( $sql, $args );

		// RETURN THE ROW IF EXISTS
		if( !!$row = $this->row($sql) ) return $row;

		// GET THE COLUMNS AND THEN COLUMN COUNT
		$cols = preg_replace('/^SELECT(.*?)FROM.*$/s', '$1', $sql);

		// RETURN DEFAULT
		return fill(count(split($cols, ',')), NULL);

	}
	
	// RETURN INT TYPE VAL AND CLOSE
	function int( string $sql, ...$args ) : int {
		$val = $this->val( $sql, ...$args );
		return $this->close( $val );
	}
	
	// RETURN STR TYPE VAL AND CLOSE
	function str( string $sql, ...$args ) : string {
		$val = $this->val( $sql, ...$args );
		return $this->close( $val );
	}
	
	// RETURN BOOLEAN TYPE VAL AND CLOSE
	function bool( string $sql, ...$args ) : bool {
		$val = !$this->val( $sql, ...$args );
		return !$this->close( $val );
	}
	
	// RETURN ARRAY TYPE VAL AND CLOSE
	function aJson( string $sql, ...$args ) : array {
		$val = $this->val( $sql, ...$args );
		return $this->close( json_decode( $val, TRUE ) );
	}
	
	// RETURN OBJECT TYPE VAL AND CLOSE
	function oJson( string $sql, ...$args ) : object {
		$val = $this->val( $sql, ...$args );
		return $this->close( json_decode( $val, FALSE ) );
	}
	
	// RETURN AN INSTANCE OF THE NAMED CLASS
	function ins( string $class, string $sql, ...$args ) : _ {
		$val = $this->val( $sql, ...$args );
		$val = json_decode( $val, TRUE );
		return $this->close( new $class( $val ) );
	}

	// ALIAS OF VAL
	function value( string $sql, ...$args ) { return $this->val( $sql, ...$args ); }

	// ALIAS OF VALS
	function values( string $sql, ...$args ) { return $this->vals( $sql, ...$args ); }

	function exists( string $sql, ...$args ) : bool {

		static $SQL = "SELECT IF (EXISTS(%s),1,0) AS x";

		// INSERT QUERY TO CHECK FOR EXISTING RESULT
		$sql = sprintf($SQL, $sql);

		return $this->val( $sql, ...$args );

	}

	// GET THE LAST INSERT ID
	function insert_id() { return mysqli_insert_id( $this ); }

	function prepare(string $sql) : \mysqli_stmt|false {
		
		if( !$this->stmt( $sql ) ) return $this->error('prepare');
		return $this->_stmt;

	}

	function close( bool $return = NULL ) { 
		
		// CLOSE ANY OPEN STATEMENTS
		if($this->is('prepared')) $this->_stmt->close();

		// CLOSE THE CONNECTION IF OPEN
		//if( $this instanceof \mysqli ) @parent::close();
		//if( $this instanceof \mysqli ) @mysqli_close($this);

		// IF BOOL RETURN IS SPECIFIED RETURN THAT INSTAED OF RESULT
		return $return ?? TRUE;
	
	}

	public function stmt( string $sql = NULL ) {

		// CHECK IF STATMENT WAS CLOSED
		if( 'CLOSED' === $sql ) return $this->_stmt = NULL;

		if( !($this->_stmt instanceof stmt) ) return $this->_stmt = new stmt( $this, $sql );
		
		if( !$sql ) return $this->_stmt;

		if( !$this->is('prepared') ) return $this->_stmt->prepare( $sql );

		// COULD CONSIDER RESET HERE
		if( $sql === $this->_stmt ) return $this->_stmt;

		// NEW SQL SO CLOSE OLD INSTANCE
		$this->_stmt->close();

		// CREATE NEW INSTANCE AND RETURN IT
		return $this->_stmt = new stmt( $this, $sql );

	}

	function is( string $is, ...$args ) {

		switch($is) :

			case 'prepared':
			case 'stmt': return ($this->_stmt instanceof stmt) && (('stmt' === $is) || $this->_stmt->is($is));

		endswitch;

	}

	public function error( $type = NULL ) {

		$type ?? $type = (($errno = $this->connect_errno) ? 'connect' : ($errno = $this->errno));

		switch( $type ) :

			case 'stmt::close':
			case 'stmt::prepare':
			case 'stmt':
			
			[ $msg, $args ] = $this->stmt()->error( split($type,'::')[1] ?? '' );

			break;

			case 'connect': $error = $this->connect_error;

			default:
			$args = [ $errno, $error ?? $this->error ];
			$msg = static::err_msgs[ $type ] ?? static::err_msgs[ $errno ] ?? static::err_msgs[ 'default' ];


		endswitch;

		// ADD DEBUG LOGGING HERE
		
		return FALSE;

	}

	public function connect_err() { return $this->error('connect'); }

}

class stmt extends \mysqli_stmt {

	const
	err_template = "Stmt %s failure (%i): %s",

	err_msgs = [

		'close'		=> self::err_template,
		'prepare'	=> self::err_template,
		'default'	=> "Stmt error (%i): %s",

	];

	protected $_sql, $_db, $is_prepared = FALSE;

	function __construct( $db, string $sql = NULL ) {
		
		// SET CURRENT DB INSTANCE
		$this->_db = $db;

		// SET CURRENT SQL STATEMENT
		if( !isset($sql) ) return parent::__construct( $this->_db );
		

		// SET PREPARED STATEMENT
		$this->_sql			= $sql;
		$this->is_prepared	= TRUE;

		parent::__construct( $this->_db, $this->_sql );
		
		return $this;
	
	}

	// GET THE CONNECTION OBJECT
	function db() { return $this->_db; }

	function prepare(string $sql) : bool { 

		// CHECK IF THE CURRENT INSTANCE HAS NOT CHANGED
		if( !(!$this->is_prepared || ($this->_sql !== $sql)) ) return TRUE;

		// IF SQL HAS CHANGED CREATE NEW INSTANCE
		if( isset($this->_sql) && ($this->_sql !== $sql) ) return $this->db()->stmt( $sql );

		// PREPARE THE STATEMENT
		if( !parent::prepare( $sql ) ) error_('failure to create statement');

		// NOW PREPARED
		return $this->is_prepared = TRUE;

	}

	function is( string $is, ...$args ) {

		switch($is) :

			case 'prepared': return TRUE === $this->is_prepared;

		endswitch;

	}

	function insert_id( bool $exec = TRUE ) {

		// GET  THE PREVIOUS INSERT ID FOR COMPARISION
		$last_insert_id = $this->db()->insert_id();

		// RETURN LAST IF EXEC IS FALSE
		if( !$exec ) return $last_insert_id;

		// EXECUTE THE PREPARED STATEMENT AND RETURN ON FAILURE
		if( !$this->execute() || !$this->affected_rows ) return FALSE;

		// GET AND VERIFY THE NEW INSERT ID
		if( !$insert_id = $this->db()->insert_id() ) return FALSE;

		// VERIFY INSERT IDs ARE NOT EQUAL
		if( $last_insert_id === $insert_id ) return FALSE; 

		// RETURN THE RESULTING INSERT ID
		return $insert_id;

	}

	// RUN THE INSERT RETURN THE ID AND CLOSE STATEMENT
	function insert( bool $close_db = FALSE ) {

		// EXECUTE THE PREPARED STATEMENT AND RETURN ON FAILURE
		if( !$this->execute() || !$this->affected_rows ) return FALSE;

		// GET AND VERIFY THE NEW INSERT ID
		if( !$insert_id = $this->db()->insert_id() ) return FALSE;

		// ONLY CLOSE STATEMENT IF CLOSE_DB IS NOT FALSE
		if( !$close_db ) $this->close();
		else $this->db()->close();

		// RETURN THE RESULTING INSERT ID
		return $insert_id;

	}

	function success( bool $keep_open = NULL ) {

		// VERIFY SUCCESS
		$success = !(!$this->execute() || !$this->affected_rows);

		// ONLY CLOSE STATEMENT IF KEEP OPEN IS NOT SET
		// CLOSE ALL IF SET TO FALSE
		if( !$keep_open ) FALSE === $keep_open ? $this->db()->close() : $this->close();

		return $success;

	}

	function get_arows( bool $keep_open = NULL ) {

		// EXECUTE THE STATEMENT
		if( !$this->execute() ) return FALSE;
		
		// GET THE RESULT SET
		if( !$result = $this->get_result() ) return FALSE;
		
		// LOOP THROUGH THE SET
		while($row = $result->fetch_assoc()) :

			$rows[] = $row;

		endwhile;

		// FREE RESULT SET
		$result->free();

		// ONLY CLOSE STATEMENT IF KEEP OPEN IS NOT SET
		// CLOSE ALL IF SET TO FALSE
		if( !$keep_open ) FALSE === $keep_open ? $this->db()->close() : $this->close();

		// RETURN ARRAY OF ROWS
		return $rows ?? [];

	}

	public function close() {
		
		// LIKELY AN ERROR IF CLOSE FAILS
		if( !parent::close() ) return FALSE;
		
		// RESET STATEMENT
		$this->is_prepared = FALSE;
		$this->_sql = NULL;

		// REMOVE FROM DB
		$this->db()->stmt('CLOSED');

		return TRUE;
	
	}

	public function error( $type = NULL ) {

		$type ?? ($type = $errno = $this->errno ?? $this->_db->errno);

		switch( $type ) :

			case 'close':
			case 'prepare':
			
			$args	= [ $type, $errno, $this->error ?? $this->_db->error ];
			$msg	= static::err_msgs[$type] ?? static::err_template;

			default:
			$args = [ $errno, $error ?? $this->error ?? $this->_db->error ];
			$msg = static::err_msgs[ $type ] ?? static::err_msgs[ $errno ] ?? static::err_msgs[ 'default' ];

		endswitch;

		return [ $msg, $args ];

	}

}

class dbx extends db {

	public function row( string $sql, ...$args ) {

		$_val = parent::row( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}

	public function rows( string $sql, ...$args ) {

		$_val = parent::rows( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function arow( string $sql, ...$args ) {
	
		$_val = parent::arow( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function arows( string $sql, ...$args ) {
	
		$_val = parent::arows( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function col( string $sql, ...$args ) {
	
		$_val = parent::col( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function val( string $sql, ...$args ) {
	
		$_val = parent::val( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function vals( string $sql, ...$args ) {
	
		$_val = parent::vals( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function int( string $sql, ...$args ) : int {
	
		$_val = parent::int( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function str( string $sql, ...$args ) : string {
	
		$_val = parent::str( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function bool( string $sql, ...$args ) : bool {
	
		$_val = parent::bool( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function aJson( string $sql, ...$args ) : array {
	
		$_val = parent::aJson( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function oJson( string $sql, ...$args ) : object {
	
		$_val = parent::oJson( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function ins( string $class, string $sql, ...$args ) : _ {
	
		$_val = parent::ins( $class, $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function value( string $sql, ...$args ) {
	
		$_val = parent::value( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function values( string $sql, ...$args ) {
	
		$_val = parent::values( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function exists( string $sql, ...$args ) : bool {
	
		$_val = parent::exists( $sql, ...$args );
		$this->close();
	
		return $_val;
	
	}
	
	public function insert_id() {
	
		$_val = parent::insert_id();
		$this->close();
	
		return $_val;
	
	}

}

abstract class meta extends db {

	const 
	table	= 'meta',
	colmask	= 'id|key|name|type|bool|int|dub|real|date|time|timestamp|text|object|meta|created',
	columns	= ['id','key','name','type','bool','int','dub','real','date','time','timestamp','text','object','meta','created'];

}

function db( string ...$args ) : db { return new db( ...$args ); }
function dbx( string ...$args ) : dbx { return new dbx( ...$args ); }