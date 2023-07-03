<?php namespace _; !no || die('error');


// *** - STRING FUNCTIONS - ***

function split( string $str = '', string $delimiter = ',' ) { return explode( $delimiter, $str ); }
function join( array $array, string $glue = ',') : string { return implode($glue, $array); }

// VALIDATE AND/OR REPLACE STRING PARTS
function starts_with( $str, $start )					{ return substr( $str, 0, strlen( $start ) ) === $start; }
function ends_with( $str, $end )						{ return substr( $str, -strlen( $end ) ) === $end; }

function replace_start( $str, $start, $with='' )		{ return starts_with( $str, $start ) ? substr_replace( $str, $with, 0, strlen( $start ) ) : $str; }
function replace_end( $str, $end, $with='' )			{ return ends_with( $str, $end ) ? substr_replace( $str, $with, -strlen( $end ) ) : $str; }

function _replace_start( &$str, $start, $with='' )		{ return starts_with( $str, $start ) && $str = substr_replace( $str, $with, 0, strlen( $start ) ); }
function _replace_end( &$str, $end, $with='' )			{ return ends_with( $str, $end ) && $str = substr_replace( $str, $with, -strlen( $end ) ); }

function replaced_start( &$str, $start, $with='' )		{ return starts_with( $str, $start ) && $str = substr_replace( $str, $with, 0, strlen( $start ) ); }
function replaced_end( &$str, $end, $with='' )			{ return ends_with( $str, $end ) && $str = substr_replace( $str, $with, -strlen( $end ) ); }

function replace_before( $str, $before, $with='' )		{ return FALSE === ($pos = strpos( $str, $before )) ? $str : substr_replace( $str, $with, 0, $pos ); }
function replace_from( $str, $from, $with='' )			{ return FALSE === ($pos = strrpos( $str, $after )) ? $str : substr_replace( $str, $with, $pos ); }
function replace_after( $str, $after, $with='' )		{ return FALSE === ($pos = strrpos( $str, $after )) ? $str : substr_replace( $str, $with, $pos+strlen($after) ); }

function _replace_before( &$str, $before, $with='' )	{ return FALSE !== ($pos = strpos( $str, $before )) && $str = substr_replace( $str, $with, 0, $pos ); }
function _replace_from( &$str, $from, $with='' )		{ return FALSE !== ($pos = strrpos( $str, $from )) && $str = substr_replace( $str, $with, $pos ); }
function _replace_after( &$str, $after, $with='' )		{ return FALSE !== ($pos = strrpos( $str, $after )) && $str = substr_replace( $str, $with, $pos+strlen($after) ); }

function replaced_before( &$str, $before, $with='' )	{ return FALSE !== ($pos = strpos( $str, $before )) && $str = substr_replace( $str, $with, 0, $pos ); }
function replaced_from( &$str, $from, $with='' )		{ return FALSE !== ($pos = strrpos( $str, $from )) && $str = substr_replace( $str, $with, $pos ); }
function replaced_after( &$str, $after, $with='' )		{ return FALSE !== ($pos = strrpos( $str, $after )) && $str = substr_replace( $str, $with, $pos+strlen($after) ); }

// ENSURE STRINGS STARTS/ENDS WITH A STRING
function start_with( $str, $start )						{ return starts_with( $str, $start ) ? $str : "{$start}{$str}"; }
function end_with( $str, $end )							{ return ends_with( $str, $end ) ? $str : "{$str}{$end}"; }

function _start_with( &$str, $start )					{ $str = start_with( $str, $start );		return $str; }
function _end_with( &$str, $end )						{ $str = end_with( $str, $end );			return $str; }

function start_is( string $str, string $start )						{ return mb_substr( $str, 0, mb_strlen( $start ) ) === $start; }
function end_is( string $str, string $end )							{ return mb_substr( $str, -mb_strlen( $end ) ) === $end; }
function middle_is( string $str, string $middle, int $offset = 1 )	{ return mb_strpos( $str, $middle ) >= $offset; }

function start_was( &$str, $start, $with='' )			{ return start_is( $str, $start ) && $str = substr_replace( $str, $with, 0, mb_strlen( $start ) ); }
function end_was( &$str, $end, $with='' )				{ return end_is( $str, $end ) && $str = substr_replace( $str, $with, -mb_strlen( $end ) ); }

function char_is( string $char, int $i, $a, ...$args )	{ return is_string( $a ) && $char === $a[$i] || ( $args !== [] && char_is( $char, $i, ...$args ) ); }

function number_format( float $number, int $decimals = 0, string $dec_point = '.', string $thousands_sep = ',' ) : string {
	
	return \number_format( $number, $decimals, $dec_point, $thousands_sep );
		
}

function in_string( string $str, string $mask )			{ return FALSE !== mb_strpos( $mask, $str ); }

// WRAP A STRING WITH $start || $start & $end IF IT ISN'T ALREADY
function wrap( $str, $start, $end = NULL )				{
	
	// SET END TO START IF NOT SET
	if( $end === NULL )
		$end = $start;
	
	// ADD END IF NOT PRESENT AT END OF $str
	if( substr( $str, -strlen( $end ) ) !== $end )
		$str = "{$str}{$end}";
	
	// RETURN WITH ADDED START IF NOT PRESENT
	return substr( $str, 0, strlen( $start ) ) === $start ? $str : "{$start}{$str}";
	
}

function _wrap( &$str, $start, $end = NULL )			{
	
	// SET END TO START IF NOT SET
	if( $end === NULL )
		$end = $start;
	
	// ADD END IF NOT PRESENT AT END OF $str
	if( substr( $str, -strlen( $end ) ) !== $end )
		$str = "{$str}{$end}";
	
	// RETURN WITH ADDED START IF NOT PRESENT
	return substr( $str, 0, strlen( $start ) ) === $start ? $str : $str = "{$start}{$str}";
}

function unwrap( $str, $start, $end = NULL )		{
	
	// SET END TO START IF NOT SET
	if( $end === NULL )
		$end = $start;
	
	// REMOVE START IF PRESENT	
	if( substr( $str, 0, $len = strlen( $start ) ) === $start )
		$str = substr_replace( $str, '', 0, $len );
	
	// RETURN STRING WITH REMOVED END IF PRESENT
	return substr( $str, $len = -strlen( $end ) ) !== $end ? $str : substr_replace( $str, '', $len );
}
function _unwrap( &$str, $start, $end = NULL )		{
	
	// SET END TO START IF NOT SET
	if( $end === NULL )
		$end = $start;
	
	// REMOVE START IF PRESENT	
	if( substr( $str, 0, $len = strlen( $start ) ) === $start )
		$str = substr_replace( $str, '', 0, $len );
	
	// RETURN STRING WITH REMOVED END IF PRESENT
	return substr( $str, $len = -strlen( $end ) ) !== $end ? $str : $str = substr_replace( $str, '', $len );
}

//function sprintf( string $sprintf, ...$args )		{ return \sprintf( maybe_sprintf( $sprintf ), ...$args ); }

// RETURN THE LENGTH OF THE LONGEST STRING
function longest( $arg, ...$args )					{ return max( array_map( 'strlen', is_array( $arg ) ? $arg : unshift( $args, $arg ) ) ); }	


// BREAK A STRING INTO AN ARRAY OF WORDS
function words( $str, $flags = UNIQUE )				{
	
	// REPLACE ALL BUT WORD CHARACTERS
	$str	= preg_replace( '/[^ \w]+/', ' ', $str );
	
	// REPLACE EXTRA SPACES
	$str	= preg_replace( '!\s+!', ' ', $str );
	
	// CONVERT TO ALL LOWERCASE
	$str	= strtolower( trim( $str ) );
	
	// CONVERT TO ARRAY
	$words	= explode( ' ', $str );
	
	// CREATE A UNIQUE ARRAY IF FLAGGED
	if( $flags & UNIQUE )
	$words	= array_unique( $words );
	
	return $words;	
}


function tab_pad( $str, $pad_len = 12, $pad_type = STR_PAD_LEFT )								{
	
	//FIRST REPLACE TABS
	$_str = str_replace( '\t', '%%%t', $str, $cnt );
	
	//RETURN IF HAS LENGTH
	if( $pad_len < $len = strlen( $_str ) )
	return $str;
	
	// GET NEEDED TABS
	$tab_len = $pad_len + ( 4 - ( $pad_len % 4 ) );
	
	$str = str_pad( $_str, $tab_len, '%%%t', $pad_type );
	
	return str_replace( '%%%t', '\t', $str );
	
}

function str_pad( $str, $pad_len, $pad_str = " ", $pad_type = STR_PAD_RIGHT )				{
	
	// ADD THE DIFFERENCE IN MULTIBYTE STRING LENGTH AND STRING LENGTH
    $pad_len += strlen( $str ) - mb_strlen( $str );
	
	// RETURN IF NO TABS
	if( strpos( $str, '\t' ) === FALSE )
	// RETURN STR_PAD WITH ADJUSTED $pad_len
    return \str_pad( $str, $pad_len, $pad_str, $pad_type );
	
}

function maybe_sprintf( string $sprintf )													{
	
	return FALSE === strpos( $sprintf, "%" ) ? base64_decode( $sprintf ) : $sprintf;

}

// TESTS A VALUE FOR POSIBLE FORMAT STRING
function isFormat( $mixed, &$count = 0, /* OPTIONAL COUNT HOLDER VARIABLE */ int $types = Str )	{
	
	// CHECK IF IS STRING
	if( is_string( $str = $mixed ) || ( Str === ($types & Types) && [ $str = FALSE ] ) )
	return $str and 0 !== $count = substr_count($str, '%') and 0 !== $count -= substr_count($str, '%%') * 2;
	
	
	// HANDLE POSSIBLE TYPES
	switch( gettype( $str ) ) :
	
	case Nul:
	case Int:
	case Float:
	return FALSE;
	
	case Arr:	$str = $str[ format ] ?? $str[ 0 ] ?? '';
	break;
	
	case Obj:	$str instanceof Value ||
				$str instanceof \ArrayAccess || $str = NULL and
				$str = $str[ format ] ?? $str[ value ] ?? NULL;
	break;
	
	default:
	return FALSE;
	
	endswitch;
	
	return is_string( $str ) && 0 !== $count = substr_count($str, '%') and 0 !== $count -= substr_count($str, '%%') * 2;
	
}

// CONVERTS A STRING TO AN ACCEPTABLE URL SLUG													
function to__slug($str)								{
	$slug = preg_replace('~[^\\pL\d]+~u', '-', (string)$str);		// REPLACE NON ALPHA-NUMERIC
	$slug = trim($slug, '-');										// TRIM
	$slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);			// TRANSLITERATE
	$slug = strtolower($slug);										// ALL LOWERCASE
	$slug = preg_replace('~[^-\w]+~', '', $slug);					// REMOVE UNWANTED CHARS
	return str_replace( ['---', '--'], '-', $slug );
}

// CONVERTS A STRING TO AN ACCEPTABLE KEY NAME
function to__key($str)			{
	$key = preg_replace('/[^a-zA-Z0-9_]+/', '-', $str);				// REPLACE NON ALPHA-NUMERIC
	$key = trim($key, '-');											// TRIM
	$key = iconv('utf-8', 'us-ascii//TRANSLIT', $key);				// TRANSLITERATE
	$key = strtolower($key);										// ALL LOWERCASE
	$key = preg_replace('~[^-\w]+~', '', $key);						// REMOVE UNWANTED CHARS
	return str_replace( ['---', '--', '_-', '-'], ['-', '-', '_', '_'], $key );
}

// CONVERTS TO BIT CONSTANT NAME
function to_bitname($str, $upper = NULL)		{
	$key = preg_replace('/[^a-zA-Z0-9_]+/', '-', $str);				// REPLACE NON ALPHA-NUMERIC
	$key = trim($key, '-');											// TRIM
	$key = iconv('utf-8', 'us-ascii//TRANSLIT', $key);				// TRANSLITERATE
	$key = preg_replace('~[^-\w]+~', '', $key);						// REMOVE UNWANTED CHARS
	
	// HANDLE CASE
	$upper === FALSE and $key = strtolower($key) ||
	$upper === TRUE and $key = strtoupper($key);
	
	return str_replace( array('---', '--', '_-', '-'), array('-', '-', '_', '_'), $key );
}

// CREATES AN ATTRIBUTE SAFE VALUE
function to__att( string $string )					{ return esc_attr( sanitize_title( trim( $string ) ) ); }

function css_key( string &$key, string $pre = "%css", callable $encode = NULL )					{
	
	$encode ?? $encode = '\base64_encode';
	
	// CHECK IF KEY IS ALREADY ENCODED
	starts_with( $key, $pre ) || $key = $pre . $encode( $key );
	
	return $key;

}

function css_dekey( string &$key, string $pre = "%css", callable $decode = NULL )				{
	
	$decode ?? $decode = '\base64_decode';
	
	// VERIFY KEY HAS BEEN ENCODED
	replaced_start( $key, $pre ) && $key = $decode( $key );
	
	// MAKE SURE KEY IS PREFIXED
	return $key;
	
}


// CONVERT TO BYTO SPECIFIC SLUGS/KEYS
function prefix_slug( $str, $pre = SLUG_PREFIX )	{ return start_with( to__slug( $str ), $pre );								}
function prefix_key( $str, $pre = KEY_PREFIX )		{ return start_with( to__key( $str ), $pre );								}

// FUNCTION TO JOIN NOT EMPTY STRINGS
function ne_join( string $joint, string $a = '', string ...$args )				{
	
	return ( $b = $args === [] ? '' : ne_join( $joint, ...$args ) ) && $a ? "{$a}_{$b}" : "$a$b";
		
}

function _split_lines( &$str, $max = 76, $end = PHP_EOL ) {
	
	// CHECK FOR TABS
	$_str = $str and FALSE !== strpos( $str, '\t' ) and $_str = str_replace( "\t", '%%%t', $str, $tabs );
		
	// CHECK IF NO NEED FOR ADJUSTING
	if( mb_strlen( $_str ) <= $max )
	return TRUE;
	
	$str	= str_replace( [ "\r\n", "\r","\n" ], '%%s', $_str, $cnt );
	
	$lines	= explode( '%%s', $str );
	
	foreach( $lines as &$line )
	
	if( mb_strlen( $line ) > $max )
	$line = chunk_split( $line, $max, $end );
	
	$str = implode( PHP_EOL, $lines );
	
	if( $tabs )
	$str = str_replace( '%%%t', "\t", $str ); 
	
	return TRUE;
	
}
// FUNCTION FORMATS A STRING WITH LINE BREAKS AT SPACES JUST BEFORE THE SET CHARACTER LENGTH MAXIMUM
function split_lines( $str, $max = 76, $end = PHP_EOL ) {
	
	// REPLACE ALL LINE BREAKS TEMPORARILY
	$str = str_replace( [ "\r\n", "\r","\n" ], '%%s', $str, $cnt );
	
	
	// RECURSE LINE BREAKS IF ANY
	if( $cnt ) :
		
		// REMOVE EXTRA LINE BREAKS
		$str = str_replace( [ "%%s%%s%%s%s", "%%s%%s%%s" ], [ '%%s%%s' ], $str );
		$lines = explode( '%%s', $str );
		
		foreach( $lines as &$line )
		$line = split_lines( $line, $max, $end );
		
		return str_replace( [ '%%s%%s', '%%s' ], [ PHP_EOL . $end, $end ], implode( '%%s', $lines ) );
	endif;
	
	
	// REPLACE ALL TABS TEMPORARILY
	$str = str_replace( "\t", '%%%t', $str, $cnt );	
	
	// CREATE AN ARRAY OF $max CHUNKS
	$chunks = explode( ' ', str_replace( '  ', ' ', trim( $str ) ) );
	
	$length = 0;
	
	// INSERT $end AT LAST SPACE OF EACH CHUNK
	foreach( $chunks as &$chunk ) :
		
		// GET THE LENGTH
		$chunk_len = strlen( $chunk );
		
		if( $max < $length += $chunk_len ) :
			$chunk	= $end . $chunk;
			$length = $chunk_len;
		endif;
		
		$length++;
		
	endforeach;
	
	return str_replace( '%%%t', "\t", implode( ' ', $chunks ) );
}
