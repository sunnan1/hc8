<?php namespace _;

class _ {
	
	protected $__ = [];
	
	/*public function __construct( array $a = [], array ...$args ) {
		
		$args === [] || $a = array_merge_recursive($a, ...$args);
		
		return $this->add( $a );
		
	}
	
	public function add( $a = [] )			{
		
		foreach( $a as $key => $val )
		$this->__set( $key, $val );
		
		return $this;
	
	}*/
	
	public function &__get($key)			{ return $this->__[ $key ] ?? NULL; }
	public function __set($key, $val) 		{ $this->__[ $key ] = $val ; }
	public function __isset($key) 			{ return array_key_exists( $key, $this->__ ); }
	public function __unset($key) 			{ unset( $this->__[ $key ] ); }
	
	public function __sleep()				{ return array_keys( $this->__ ); }
	
}

class a extends _ implements \ArrayAccess, \Iterator, \Countable {
	
	public static function Array( $val )						{ return $val instanceof a ? $val->toArray() : $val; }
	
	public function &offsetGet(mixed $key) : mixed				{ return $this->__[ $key ] ?? $temp = NULL ?? $temp; }
	public function offsetSet(mixed $key, mixed $val) : void	{ $key ?? ( $this->__[] = $val and 0 ) and $this->__[ $key ] = $val; }
    public function offsetExists(mixed $key) : bool				{ return array_key_exists( $key, $this->__ ); }
    public function offsetUnset(mixed $offset) : void			{ unset( $this->__[ $key ] ); }
	
	public function keys( $search = NULL, bool $strict = FALSE ) { return array_keys( $this->__, $search, $strict ); }
	
	public function count()	: int 								{ return count( $this->__ ); }
	public function key() : mixed								{ return key( $this->__ ); }
	public function current() : mixed							{ return current( $this->__ ); }
	public function next()	: void								{ next( $this->__ ); }
	public function rewind() : void								{ reset( $this->__ ); }
	public function valid()	: bool								{ return array_key_exists( $this->key(), $this->__ ); }
	
	public function map( callable $fn, array $keys = [] ) {
		
		if( !$keys ) $keys = $this->keys();
		
		else intersect($keys, $this->keys());
		
		foreach( $keys as $key ) yield $key => $fn( $this[ $key ] );
		
	}
	
	public function toArray( string ...$keys ) {
		
		$a = $this->map( [static::class, 'Array'], $keys ); 
		
		foreach( $a as $k => $v )
		$array[ $k ] = $v;
		
		return $array ?? [];
		
	}
	
}

function a( array &$a = NULL, ...$args ) {
	
	if( !$a and $a = new a() ) return $a;
	
}

function bind( _ $_, \Closure $fn ) {
	
	return $fn->bindTo( $_, $_ );
	
}


class filter extends a {

	public static function in( array $a, int $filter = FILTER_SANITIZE_STRING, $opts = NULL ) {


		$fn = new filter( $filter, $opts );

		if( FILTER_SANITIZE_STRING & $filter ) $fn->sanitize( Ns.'in_string', '|'.join($a,'|').'|' );

		else $fn->sanitize( '\in_array', $a );

		return $fn;

	}


	protected $filter_key=0, $flags=0, $opts=[], $var=NULL;

	public function __invoke( $var ) {

		if( !isset( $var ) ) return;
		
		if( $this->filter_key  ) $this->filter_var( $var );
		
		$this->sanitize();

		return $this->var;

	}

	public function filter_var(  $var = NULL ) { return $this->var = filter_var( $var ?? $this->var, $this->filter_key, $this->opts ); }

	public function sanitize( callable $fn = NULL, ...$args ) {

		static $fn_args = [];
	
		if( !!$fn ) return ($fn_args[] = [ $fn, $args ]);
	
		while( ([] !== $fn_args) && !!$this->var ) :
		
			list($_fn, $_args) = array_shift( $fn_args );
		
			($this->var = $_fn( $this->var, ...$_args ));

		endwhile;
	
		return $this->var;
	
	}

}


abstract class html extends a {

	

}

abstract class tag extends html {



}

abstract class atts extends tag {

	private $atts, $tag;

	protected function __construct( atts $atts = NULL ) {

		if( $this instanceof tag )
		return $this->tag = $this and $this->atts = ($atts ?? $this); 

	}

}

abstract class _input extends tag {



}

abstract class care extends a {

	const
	QUALIFICATIONS = ['BASIC','DECUBITUS','INJECTION'],
	BITS = [

		4 => 'CM0001',
		8 => 'CM0002',
		16 => 'CM0003',
		32 => 'CM0004',
		64 => 'CM0005',
		128 => 'CM0006',
		256 => 'CM0007',
		512 => 'CM0008',
		1024 => 'CM0009',
		2048 => 'CM0010',
		4096 => 'CM0011',
		8192 => 'CM0012',
		16384 => 'CM0013',
		32768 => 'CM0014',
		65536 => 'CM0015',
		131072 => 'CM0016',
		262144 => 'CM0017',
		524288 => 'CM0018',
		1048576 => 'CM0019',
		2097152 => 'CM0020',
		4194304 => 'CM0021',
		8388608 => 'CM0022',
		16777216 => 'CM0023',
		33554432 => 'CM0024',
		67108864 => 'CM0025',
		134217728 => 'CM0026',
		268435456 => 'CM0027',
		536870912 => 'CM0028',


	],
	DURATIONS		= [

		'CM0001' => 480,
		'CM0002' => 600,
		'CM0003' => 720,
		'CM0004' => 420,
		'CM0005' => 600,
		'CM0006' => 360,
		'CM0007' => 420,
		'CM0008' => 1200,
		'CM0009' => 900,
		'CM0010' => 1200,
		'CM0011' => 1800,
		'CM0012' => 720,
		'CM0013' => 720,
		'CM0014' => 720,
		'CM0015' => 900,
		'CM0016' => 600,
		'CM0017' => 1200,
		'CM0018' => 1800,
		'CM0019' => 300,
		'CM0020' => 600,
		'CM0021' => 1500,
		'CM0022' => 900,
		'CM0023' => 900,
		'CM0024' => 1800,
		'CM0025' => 1200,
		'CM0026' => 600,
		'CM0027' => 1800,
		'CM0028' => 300,

	],
	MODULES = [

		'CM0001' => 'transfer_to_from_bed',
		'CM0002' => 'assist_getting_un_dressed',
		'CM0003' => 'partial_bathing',
		'CM0004' => 'oral_dental_denture_care',
		'CM0005' => 'shaving_facial_care',
		'CM0006' => 'comb_hair',
		'CM0007' => 'skin_care',
		'CM0008' => 'complex_task',
		'CM0009' => 'hair_nail_care',
		'CM0010' => 'thorough_bathing',
		'CM0011' => 'complete_bathing_only',
		'CM0012' => 'stationary_mobilization',
		'CM0013' => 'assist_with_eating',
		'CM0014' => 'administer_tube_feeding',
		'CM0015' => 'aid_defecation_urination',
		'CM0016' => 'void_colostomy_bag',
		'CM0017' => 'help_depart_return_to_residence',
		'CM0018' => 'accompany_in_activities',
		'CM0019' => 'manage_heating_of_residence',
		'CM0020' => 'minor_residence_care',
		'CM0021' => 'major_residence_care',
		'CM0022' => 'wash_dry_laundry',
		'CM0023' => 'fold_deposit_laundry',
		'CM0024' => 'groceries_shopping',
		'CM0025' => 'cook_warm_meal',
		'CM0026' => 'prepare_other_meal',
		'CM0027' => 'first_visit',
		'CM0028' => 'modify_care_plan',

	];

	public static function description( string $code ) {

		static $descs; $descs ?? ($descs = [

			'CM0001' => __('transfer to / from bed'),
			'CM0002' => __('assist getting (un)dressed'),
			'CM0003' => __('partial bathing'),
			'CM0004' => __('oral, dental denture care'),
			'CM0005' => __('shaving & facial care'),
			'CM0006' => __('comb hair'),
			'CM0007' => __('skin care'),
			'CM0008' => __('complex task'),
			'CM0009' => __('hair & nail care'),
			'CM0010' => __('thorough bathing'),
			'CM0011' => __('complete bathing (only)'),
			'CM0012' => __('stationary mobilization'),
			'CM0013' => __('assist with eating'),
			'CM0014' => __('administer tube feeding'),
			'CM0015' => __('aid defecation & urination'),
			'CM0016' => __('void colostomy bag'),
			'CM0017' => __('help depart / return to residence'),
			'CM0018' => __('accompany in activities'),
			'CM0019' => __('manage heating of residence'),
			'CM0020' => __('minor residence care'),
			'CM0021' => __('major residence care'),
			'CM0022' => __('wash & dry laundry'),
			'CM0023' => __('fold & deposit laundry'),
			'CM0024' => __('groceries & shopping'),
			'CM0025' => __('cook warm meal'),
			'CM0026' => __('prepare other meal'),
			'CM0027' => __('first visit'),
			'CM0028' => __('modify care plan'),

		]);

		return $descs[ $code ] ?? NULL;

	}
	
}