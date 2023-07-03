<?php namespace _;

abstract class record extends a {

	const
	table					= 'undefined',
	primary_key				= 'id',
	primary_key_format		= fu,

	// WHETHER OR NOT TO CREATE AN EMPTY INSTANCE
	allow_empty_instance	= FALSE,
	clone_empty_instance	= FALSE,

	text_time_format    = 'D M j H:i';  // LATER TO BE MOVED TO SETTINGS

	protected static $labels = [],
	$SELECT		= "SELECT * FROM `%s` WHERE `%s`=%s LIMIT 1",
	$COLUMNS	= "SHOW COLUMNS FROM `%s`";

	private static $SQL, $COLS;

	protected $_exists = FALSE, $_id = NULL;

	// IMPLEMENT WITH SETTINGS
	//public static function text_time( string $time ) { return date( setting('text_time_format'), strtotime($time) ); }

	public static function text_time( string $time ) { return date( static::text_time_format, strtotime($time) ); }

	public function __construct( $id = NULL ) {

		$this->_id		= $id;
		$this->_exists	= $this->is_record($id);

		return $this->refresh();

	}

	public function refresh() {

		$sql = sprintf(static::$SELECT, static::table,  static::primary_key, static::primary_key_format);
		
		// GET RECORD
		if( !$row = dbx()->arow($sql, $this->_id) ) return $this;

		foreach($row as $key => $val)
		$this[$key] = $val;

		return $this;

	}

	public function exists() { return TRUE === $this->_exists; }

	protected function is_record( $id = NULL ) : bool {

		static::$SQL ?? (static::$SQL = sprintf(static::$SELECT, static::table, static::primary_key, static::primary_key_format));
		return dbx()->exists(static::$SQL, $id);

	}

}
