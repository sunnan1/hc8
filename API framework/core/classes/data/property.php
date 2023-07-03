<?php namespace _;

class property extends a {

	protected
	$Type		= 'string',
	$Format		= 's',
	$Print		= '%s',
	$Read		= can::Admin,
	$Edit		= can::Admin;

	protected $__ = [];

	public function &__get($key)			{ return $this->__[ $key ] ?? NULL; }
	public function __set($key, $val) 		{ $this->__[ $key ] = $val ; }
	public function __isset($key) 			{ return array_key_exists( $key, $this->__ ); }
	public function __unset($key) 			{ unset( $this->__[ $key ] ); }
	
	public function __sleep()				{ return array_keys( $this->__ ); }

}

class_alias(Ns.'property', Ns.'prop');