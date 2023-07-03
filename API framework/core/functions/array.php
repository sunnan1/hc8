<?php namespace _;

/* * *
 *
 *  FUNCTIONS & ALIASES FOR WORKING WITH ARRAYS
 * 
 * * */

function map( callable $fn, array ...$arrays ) { return array_map( $fn, ...$arrays ); }
function clean( array &$a, callable $fn = Ns.'__return_isset' ) { return $a = array_filter( $a, $fn ); }
function filter( array $a, ...$b ) { return array_filter($a, ...$b); }
function flip( array $a ) { return array_flip( $a ); }
function fill( $mixed, int $cnt ) { return array_fill(0, $cnt, $mixed); }
function get_keys( array $a, array ...$keys ) { return array_intersect_key( $a, array_flip( array_merge(...$keys) ) ); }
function extract_keys( array &$a, array $keys ) {

	foreach( $keys as $key )
	if( array_key_exists($key, $a) ) :
		
		$array[ $key ] = $a[ $key ];
		unset($a[ $key ]);
	
	endif;

	return $array ?? [];

}

// INTENDED FOR USE WITH ARRAY FILTERS AND MAPS
function __return_self( $self=NULL ){ return $self; }
function __return_isset( $var=NULL ){ return isset($var); }