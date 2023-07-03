<?php namespace _;

/* * *
 *
 *  TYPE VALIDATION AND CONVERSION
 * 
 * * */

function int( &$var ) { return is_numeric($var) ? $var<<=0 : FALSE; }
function float( &$var ) { return is_numeric($var) ? $var=floatval($var) : FALSE; }
function is_stack( array $a ) { return ($keys = array_keys($a)) === flip($keys); }
function is_date( string $date, $format = 'Y-m-d' ) { return $date === date($format, strtotime($date)); }

function to_time( int $time, string $format = 'H:i:s' ) { return date($format, $time); }
function to_day( int $time ) { return date('w', $time); }
function to_date( int $time, string $format = 'Y-m-d' ) { return date($format, $time); }
function to_timestamp( int $time, string $format = 'Y-m-d H:i:s' ) { return date($format, $time); }

// TO JAVASCRIPT BOOL STRING
function toBool( $mixed )										{ return toJsBOOL[ $mixed ] ?? ( !$mixed ? 'false' : 'true' );					}

// GET TYPE BITWISE INT
function type( $mixed )											{ return TypeBit[ gettype($mixed) ]; }

// BYTO JSON ENCODER REPLACEMENT
function toJson( $data, callable $callback = NULL )				{
	
	switch( type($data) ) :
		
		case Str:		return "'$data'";
		case Bool: 		return $data ? 'true' : 'false';
		case Nul:		return 'null';
		case Int:
		case Dub:		return $data;
		
		case Obj:
		case Arr:
			
			// CHECK IF IS SIMPLE ARRAY
			$simple = is_stack( $data );
			$_data = [];
			
			$callback ?? $callback = __FUNCTION__;
			
			foreach( $data as $key => $value )
			$_data[] = ( $simple ? '' : "{$key}:" ) . @$callback( $value );
			
			// IMPLODE IF NOT EMPTY
			$data = $_data ? ' ' . implode( ', ', $_data ) . ' ' : '';
			
			return $simple ? '[' . $data . ']' : "{" . $data . "}";
		
	endswitch;
	
}
