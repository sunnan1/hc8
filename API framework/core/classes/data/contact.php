<?php namespace _;

class contact extends record {

	const table = 'contacts',
	formats = [
        'type'			=> fs,
        'first_name'    => fs,
        'last_name'     => fs,
        'sex'           => fs,
        'dob'           => fs,
        'email'         => fs,
		
		// CHANGE IN NEW DATA MODEL

		//'mobile_country'=> fs,
		//'mobile'        => fs,
        //'email_verified'=> fu,
        //'mobile_verified'=> fu,
		'phone'			=> fs,
		'address'		=> fs,
		'city'			=> fs,
		'region'		=> fs,
		'country'		=> fs,
		'zip'			=> fs,
    ],

	CD					= 'cd/contacts/',
	DIR					= DIR . 'cd/contacts/',

	AUTH_HASH_ALGO		= PASSWORD_DEFAULT,

	PASSWORD_SPECHARS	= '! @ # $ % ^ & *',
	PASSWORD_SPEC_REGEX	= '/[!@#\$%\^&\*]+/',
	PASSWORD_REGEX		= '/[^a-zA-Z0-9!@#\$%\^&\*]+/',
	REMOVE_SPECHARS		= '^§`<>="@/{}*$%?|#',
	REMOVE_SPEC_REGEX	= '/[\^§`<>="@\/\{\}\*\$%\?\|#]+/i',

	PASSWORD_MIN_LEN	= 8,
	NAMES_MIN_LEN		= 2;

	protected $_cache = [];
	
	public static function num_exists( string $num ) {

		static $SQL = "SELECT * FROM `%s` WHERE `mobile`='%s'";
		return dbx()->exists($SQL, static::table, $num);

	}

	public static function uuid_exists( string $uuid ) {

		static $SQL = "SELECT * FROM `%s` WHERE `uuid`='%s'";
		return dbx()->exists($SQL, static::table, $uuid);

	}

	public static function id_exists( int $id ) {

		$SQL = sprintf("SELECT * FROM `%s` WHERE `%s`=%s", static::table, 'id', fu);
		return dbx()->exists($SQL, $id);

	}

	/* AN ALTERNATIVE NEEDED 
	public static function add_num( string $num, string $password ) {

        
		static $sql = "INSERT INTO `%s` (`mobile`, `acchash`) VALUES (?,?)";

		if( !!static::num_exists($num) ) error_('number already exists');
		
		if( !!static::archive_exists($num) ) error_('archive already exists');

		$db = db();
		$prepare = sprintf( $sql, static::table );

        
		if( !$stmt = $db->prepare($prepare) ) error_('could not create statment');
		
		$stmt->bind_param('ss', $num, $acchash);
		
		// CREATE USER HASH
		$acchash = static::auth_hash( $password );
		
		// RETURN SUCCESS
		return $stmt->success(FALSE);

	}
	*/

	public static function by_num( string $num ) {

		if( !static::num_exists( $num ) ) return;

		$id = dbx()->val("SELECT `id` FROM `people` WHERE `mobile`='%s' LIMIT 1", $num);

		return !$id ? NULL : new static( $id );

	}

	public static function by_uuid( string $uuid ) {

		if( !static::uuid_exists( $uuid ) ) return FALSE;
		
		$id = dbx()->val("SELECT id FROM people WHERE uuid='%s' LIMIT 1", $uuid);

		if( !$id ) return FALSE;

		return new static( $id );

	}

	public static function byId( int $id = NULL ) {

		if( !$id || !static::id_exists( $id ) ) return FALSE;
		return new static( $id );

	}

	public static function by_id( int $id = NULL ) { return static::byId($id); }

	// SANITIZE USER INPUTS
	/* THIS SHOULD BE MOVED TO THE ABSTRACT CLASS */
	public static function sanitize( &$arg, string $name = NULL ) {

		// HANDLE AN ARRAY OBJECT
		if( is_iterable( $arg ) ) :

			foreach( $arg as $key => &$value )
			if( !static::sanitize( $value, $name ) ) $failed = TRUE;

			return !($failed ?? 0);

		endif;

		// SCALAR ARGS
		// SAVE ORIGINAL VALUE
		$was = "$arg";

		switch( $name ) :

		/*
		case 'password':

		
			$arg	= trim("$arg");
			$arg	= preg_replace(static::PASSWORD_REGEX, '', $arg);	// REPLACE NON ALPHA-NUMERIC & ALLOWED SPECIAL CHARS

			// FAIL IF NOT AS IT WAS
			if( $was !== $arg ) return FALSE;

			// FAIL IF NOT MINIMUM LENGTH
			if( static::PASSWORD_MIN_LEN > strlen($arg) ) return FALSE;
			
			$lower	= preg_replace('/[^a-z]+/', '', $arg);						// GET LOWERCASE ALPHA CHARS
			$upper	= preg_replace('/[^A-Z]+/', '', $arg);						// GET UPPERCASE ALPHA CHARS
			$nums	= preg_replace('/[^0-9]+/', '', $arg);						// GET NUMERIC CHARS
			$spec	= preg_replace(static::PASSWORD_SPEC_REGEX, '', $arg);		// GET ALLOWED SPECIAL CHARS
			
			$types	= compact('lower','upper','nums','spec');
			
			// VERIFY MIN LENGTH OF TYPES
			foreach($types as $type => $str)
			if( 1 > strlen($str) or ($str === $arg) ) return FALSE;

			return TRUE;
		*/

		case 'first_name':
		case 'last_name':

			$arg	= trim("$arg");
			//$arg	= preg_replace('~[^-\w]+~', '', $arg);						// REMOVE UNWANTED CHARS
			$arg	= preg_replace('/[^\\pL\\pN]+/u', ' ', $arg);				// REMOVE NON LANGUAGE CHARS
			$arg	= preg_replace('/\s\s+/', ' ', $arg);						// REMOVE EXTRA SPACES
			//$arg	= preg_replace(static::REMOVE_SPEC_REGEX, '', $arg);		// REMOVE SPECIAL CHARS
			$alpha	= preg_replace('/[^\\pL]+/u', '', $arg);					// NO PUNCTUATION

			// VERIFY LENGTH OF CHARS
			if( static::NAMES_MIN_LEN > strlen($alpha) ) return FALSE;
			
			return TRUE;

		/* NOT NEEDED
		case 'pp_country':		$regex = static::PASSPORT_CO_REGEX;
		case 'pp_number':		$regex ?? ($regex = static::PASSPORT_NUM_REGEX);

			$arg	= trim("$arg");
			$arg	= preg_replace('/\s\s+/', ' ', $arg);						// REMOVE EXTRA SPACES
			
			if( !preg_match($regex, $arg, $matches) ) return $arg = '';

			$arg = $matches[0];

			return TRUE;
			
		*/
		endswitch;

		return TRUE;

	}

	protected function mail( string $subject, string $message ) { return mail($this['email'], $subject, $message); }

	/* UPDATE FOR HOME CARE */
	public function photo_path() { return static::DIR."profile_photos/profile-{$this->uuid}.png"; }

	public function photo_hash() { return $this->_cache[__METHOD__] ?? ($this->_cache[__METHOD__] = !$this->photo_exists() ? '' : md5_file($this->photo_path())); }

	public function photo_exists() { return $this->_cache[__METHOD__] ?? ($this->_cache[__METHOD__] = file_exists($this->photo_path())); }

	public function photo_uri() { return "/contact.photo.io?uuid={$this->uuid}"; }

	public function photo_info() {

		// FIRST CCHECK IF EXISTS
		if( !$photo_exists = $this->photo_exists() ) return compact('photo_exists');

		// GET THE PHOTO URI
		$photo_uri		= $this->photo_uri();

		// GET THE PHOTO HASH
		$photo_hash		= $this->photo_hash();

		return compact('photo_exists','photo_uri','photo_hash');

	}

	// CREATE A NONCE FOR ACTION HANDLING
	public function nonce( string $action, bool $previous = FALSE ) : string {

		// CREATE A TIME BASED SALT
		$time   = (int)floor( DB['utime'] / share_expire );

		// GET PREVIOUS NONCE IF SET
		if( TRUE === $previous ) --$time;

		// RETURN A TIME BASED HASH FOR THIS USER AND ACTION
        return hashed( "$action:$time:{$this->uuid}" );

	}

	// VERIFY AN ACTION NONCE
	public function verify_nonce( string $nonce, string $action ) : string { return $nonce === $this->nonce($action) || $nonce === $this->nonce($action, TRUE); }

	/* SHOULD BE MOVED TO ABSTRACT CLASS 
	public function update( array $args ) {

		foreach( static::formats as $col => $format ) :
			
			if( !array_key_exists($col, $args) ) continue;

			$set[]	= $col;
			$frms[] = fp[ $format ];
			$keys[] = "`$col`=?";
			$vals[] = $args[$col];

		endforeach;

		if( !($keys ?? 0) ) return;

		$_set	= implode(', ', $keys);
		$vals[] = $this['id'];

		$SQL = sprintf("UPDATE  SET %s WHERE id=%d";

		if( !dbx()->query($query) ) return FALSE;

		$this->refresh();

		return TRUE;

	}
	*/

	public function update( array $_args ) {

		static $sql = "UPDATE `%s` SET %s WHERE `id`=?"; $_id = 'id';

		// ONLY ALLOW PROPERTIES FROM FORMAT LIST
		if( !$args = intersect_key(static::formats, $_args) ) return FALSE;

		// PARSE ARGUMENTS LIST TO BUILD QUERY
		foreach( $args as $col => $frm ) :

			$_set[] = "`$col`=?";
			$frms[] = fp[ $frm ];
			$vals[] = &$$col;
			$cols[] = $col;

		endforeach;

		// CREATE SET PART OF STATEMENT
		$set = join( $_set );

		// ADD ID TO FORMAT LIST AND BINDING NAMES
		$frms[] = 'i';
		$vals[] = &$$_id;

		// CREATE TYPES PARAM FOR STATEMENT
		$types = join($frms,'');

		// CREATE PREPARE STATEMENT
		$prepare = sprintf( $sql, static::table, $set );

		$db = db();

		$stmt = $db->prepare($prepare);
		$stmt->bind_param( $types, ...$vals );

		// EXTRACT ARGS TO BOUND PARAMS
		extract($_args);

		// SET ID FOR BOUND PARAM
		$id = $this->id;

		if( !$stmt->succcess(FALSE) ) return FALSE;

		foreach( $cols as $key )
		$this[$key] = $$key;

		return TRUE;

	}

	/* NEEDS TO BE ADJUSTED TO ARCHIVING WITH PROPER DATA MODEL
	// DELETE THE CURRENT USER AND ARCHIVE THE ACCOUNT DATA FOR 30 DAYS
	public function delete() {

		static $COLS = ['id','uuid','mobile','acchash','org','first_name','last_name','sex','dob','email','mobile_country','email_verified','mobile_verified','address','city','region','country','zip','pp_country','pp_number','anonymous_data','created','modified'],
		$INSERT = "INSERT INTO `people_archive` SELECT * FROM `people` WHERE `id`=?",
		$DELETE	= "DELETE FROM `people` WHERE `id`=?";

		// PREPARE AND EXECUTE ARCHIVE INSERT
		$db = db();

		$stmt = $db->prepare($INSERT);
		$stmt->bind_param('i', $id);

		$id = $this['id'];

		// EXECUTE PREPARED STATEMENT AND RETURN RESULT OF SUCCESS
		if( !$stmt->success(FALSE) ) return FALSE;

		// CHECK FOR ARCHIVED ACCOUNT BEFORE DELETE
		if( !static::archive_exists($this['mobile']) ) return FALSE;

		$db = db();

		// PREPARE AND EXECUTE DELETE
		$stmt = $db->prepare($DELETE);
		$stmt->bind_param('i', $id);

		return $stmt->success(FALSE);

	}
	*/

}
