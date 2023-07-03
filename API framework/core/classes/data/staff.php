<?php namespace _;

class staff extends contact {

	const
	AUTH_HASH_ALGO		= PASSWORD_DEFAULT;

	public static function auth_hash( string $secret ) { return password_hash($secret, static::AUTH_HASH_ALGO); }

	public function auth_check( string $password ) { return TRUE === password_verify($password, $this->authash); }

}