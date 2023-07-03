<?php namespace _;

class warn extends record {

	private static $bitVal = 8, $all = [], $byClass = [];

	final protected static function nextWarn( string $key, array $args = [] ) {

		$class		= static::class;
		$name		= replace_start(static::class, Ns);

		if( !(self::$byClass[$name] ?? 0) || !(self::$byClass[$name][$key] ?? 0) ) : 
		
			$label		= $class::label( $key );
			$bit_value 	= self::$bitVal <<= 1;
			
			self::$all[ $bit_value ] = compact('class','key','label','bit_value');
			self::$byClass[ $name ][ $key ] = compact('key','label','bit_value');

			switch( $name ) :

				case 'risk':
				case 'risks':

					$has_protocol	= in_array($key, risk::PROTOCOLS, TRUE);
					$args			+= compact('has_protocol');
					
				break;

			endswitch;

		endif;

		if( [] < $args ) :

			self::$all[ $bit_value ] += $args;
			self::$byClass[ $name ][ $key ] += $args;

		endif;

		return self::$byClass[ $name ][ $key ];

	}

	final public static function __callStatic($name, $args) {

		static $names = ['risk','infection','allergies']; 

		if( !isset(self::$byClass[$name]) )
		switch( $name ) :

			case 'infections':	$name = 'infection';	break;  
			case 'risks':		$name = 'risk';			break;

		endswitch;

		if( isset(self::$byClass[$name]) ) return self::$byClass[$name];

		$keys[ 'infection' ]	= infection::KEYS;
		$keys[ 'allergies' ]	= allergies::SET;
		$keys[ 'risk' ]			= risk::KEYS;

		foreach($names as $_name) :

			$class = Ns.$_name;

			foreach( $keys[ $_name ] as $key ) $class::nextWarn( $key );

		endforeach;

		return array_values(self::$byClass[ $name ]);

	}


}

class allergies extends warn {

	const table = 'allergies', primary_key = 'patient', SET = ['latex','milk','peanut','penicillin','soy','wheat'];

	public static function label( string $key ) {

		static $labels; $labels ?? ($labels = [

			'latex'			=> __('latex'),
			'milk'			=> __('milk'),
			'peanut'		=> __('peanut'),
			'penicillin'	=> __('penicillin'),
			'soy'			=> __('soy'),
			'wheat'			=> __('wheat'),

		]);

		return $labels[ $key ] ?? NULL;

	}

}

class infection extends warn {

	const table = 'infections', primary_key = 'id', KEYS = ['3mrgn','4mrgn','clostridium_d','covid19','esbl','gastroenteritis','hepatitis_a_e','meningitis','mrsa','salmonellen','tbc','vre'];

	public static function label( string $key ) {

		static $labels; $labels ?? ($labels = [

			'3mrgn'				=> __('3MRGN'),
			'4mrgn'				=> __('4MRGN'),
			'clostridium_d'		=> __('Clostridium D'),
			'covid19'			=> __('COVID-19'),
			'esbl'				=> __('ESBL'),
			'gastroenteritis'	=> __('Gastroenteritis'),
			'hepatitis_a_e'		=> __('Hepatitis A+E'),
			'meningitis'		=> __('Meningitis'),
			'mrsa'				=> __('MRSA'),
			'salmonellen'		=> __('Salmonellen'),
			'tbc'				=> __('Tuberculosis'),
			'vre'				=> __('VRE'),

		]);

		return $labels[ $key ] ?? NULL;

	}

}

class risk extends warn {

	const table = 'risk_profiles', primary_key = 'id', SET = ['DECUBITUS','DEHYDRATION','FALLING','INCONTINENCE','MALNUTRITION','MOBILITY'], KEYS = ['dehydration','falling','malnutrition','decubitus','mobility','incontinence','pain','pneumonia','constipation','catheter','intertrigo','dementia'], PROTOCOLS = ['dehydration','falling','malnutrition','decubitus','incontinence'];

	public static function label( string $key ) {

		static $labels; $labels ?? ($labels = [

			'dehydration'	=> __('Dehydration'),
			'falling'		=> __('Falling'),
			'malnutrition'	=> __('Malnutrition'),
			'decubitus'		=> __('Decubitus'),
			'mobility'		=> __('Mobility'),
			'incontinence'	=> __('Incontinence'),
			'pain'			=> __('Pain'),
			'pneumonia'		=> __('Pneumonia'),
			'constipation'	=> __('Constipation'),
			'catheter'		=> __('Catheter'),
			'intertrigo'	=> __('Intertrigo'),
			'dementia'		=> __('Dementia'),

		]);

		return $labels[ $key ] ?? NULL;

	}

}

class certs extends record {

	const table = 'certs', primary_key = 'id';

	public static function getData() { return [

			[
				'bit_value'	=> 128,
				'key'		=> 'basic',
				'label'		=> 'Basic',
			],
			[
				'bit_value'	=> 256,
				'key'		=> 'rn',
				'label'		=> 'Registered Nurse',
			],
			[
				'bit_value'	=> 512,
				'key'		=> 'wound_simple',
				'label'		=> 'Wound (Simple)',
			],
			[
				'bit_value'	=> 1024,
				'key'		=> 'wound_complicated',
				'label'		=> 'Wound (Complex)',
			],
			[
				'bit_value'	=> 2048,
				'key'		=> 'injection',
				'label'		=> 'Injection',
			],
		];

	}
}

class visits extends record {

	const table = 'visits', primary_key = 'patient', STATUSES = ['GOOD','AVERAGE','BAD'];

}

class medication extends record {

	const table = 'medication';

}

class note extends record {

	const table = 'notes';

}

class infections extends warn {

	const table = 'infections', primary_key = 'patient';

	public function __construct( $id ) {

		if(!$this->is_record($id)) return;

		$this->_exists = TRUE;

		$db = new db();
		if( !!$db->connect_errno ) return;

		$sql = sprintf("SELECT * FROM %s WHERE %s=%s AND status='ACTIVE'", static::table,  static::primary_key, static::primary_key_format);
		
		$rec = $db->query(sprintf($sql, $id));
		
		while( $a = $rec->fetch_assoc() ) :

			$infection = new infection( $a['id'] );

			if( $infection->exists() )
			$this[ $a['íd'] ] = $infection;

		endwhile;
		
		$rec->free();
		$db->close();

		return $this;

	}


}

class medications extends record {

	const table = 'medication', primary_key = 'patient';

	public function __construct( $id ) {

		if(!$this->is_record($id)) return;

		$this->_exists = TRUE;

		$db = new db();
		if( !!$db->connect_errno ) return;

		$sql = sprintf("SELECT * FROM %s WHERE %s=%s", static::table,  static::primary_key, static::primary_key_format);
		
		$rec = $db->query(sprintf($sql, $id));
		
		while( $a = $rec->fetch_assoc() ) :

			$med = new medication( $a['id'] );

			if( $med->exists() )
			$this[ $a['íd'] ] = $med;

		endwhile;
		
		$rec->free();
		$db->close();

		return $this;

	}


}

class patient_notes extends record {

	const table = 'notes', primary_key = 'patient';

	public function __construct( $id ) {

		if(!$this->is_record($id)) return;

		$this->_exists = TRUE;

		$db = new db();
		if( !!$db->connect_errno ) return;

		$sql = sprintf("SELECT * FROM %s WHERE %s=%s AND FIND_IN_SET('PRIVATE', tags)=0", static::table,  static::primary_key, static::primary_key_format);
		
		$rec = $db->query(sprintf($sql, $id));
		
		while( $a = $rec->fetch_assoc() ) :

			$note = new note( $a['id'] );

			if( $note->exists() )
			$this[ $a['íd'] ] = $note;

		endwhile;
		
		$rec->free();
		$db->close();

		return $this;

	}

}

/*
class contact extends record {

	const
	table = 'contacts',
	SEXES = ['male','female'],
	TYPES = ['PATIENT','EMERGENCY','CAREGIVER','DOCTOR','PHARMACY','NETWORK','OTHER'],
	FORMATS = ['id'=>'%u','type'=>"'%s'",'first_name'=>"'%s'",'last_name'=>"'%s'",'sex'=>"'%s'",'dob'=>"'%s'",'email'=>"'%s'",'phone'=>"'%s'",'address'=>"'%s'",'city'=>"'%s'",'region'=>"'%s'",'country'=>"'%s'",'zip'=>"'%s'"];

	protected $_id;

	public function label( string $key ) {

		if( !(static::$labels[ $key ] ?? 0) )
		switch( $key ) :

			case 'id': static::$labels[ 'id' ]					= __('id');						break;
			case 'type': static::$labels[ 'type' ]				= __('type');					break;
			case 'name': static::$labels[ 'name' ]				= __('name');					break;
			case 'first_name': static::$labels[ 'first_name' ]	= __('first name');				break;
			case 'last_name': static::$labels[ 'last_name' ]	= __('last name');				break;
			case 'sex': static::$labels[ 'sex' ]				= __('sex');					break;
			case 'dob': static::$labels[ 'dob' ]				= __('dob');					break;
			case 'email': static::$labels[ 'email' ]			= __('email');					break;
			case 'phone': static::$labels[ 'phone' ]			= __('phone');					break;
			case 'address': static::$labels[ 'address' ]		= __('address');				break;
			case 'city': static::$labels[ 'city' ]				= __('city');					break;
			case 'region': static::$labels[ 'region' ]			= __('region');					break;
			case 'country': static::$labels[ 'country' ]		= __('country');				break;
			case 'zip': static::$labels[ 'zip' ]				= __('post code');				break;
			case 'created': static::$labels[ 'created' ]		= __('created');				break;
			case 'modified': static::$labels[ 'modified' ]		= __('modified');				break;
			
			default: parent::label( $key );

		endswitch;

		return static::$labels[ $key ] ?? $key;

	}

	public function sanitized( string $key ) {

		switch( $key ) :

			case 'email':			return filter_input( INPUT_POST, $key, FILTER_SANITIZE_EMAIL );

			case 'type':			return !($var = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING )) || !in_array( $var, static::TYPES ) ? NULL : $var;

			case 'sex':				return !($var = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING )) || !in_array( $var, static::SEXES ) ? NULL : $var;

			case 'dob':				return !($var = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING )) || !($var = date('Y-m-d', strtotime($var))) ? NULL : $var;

			case 'first_name':
			case 'last_name':
			case 'phone':
			case 'address':
			case 'city':
			case 'region':
			case 'country':
			case 'zip':				return filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
		
		endswitch;

	}

	public function input( string $key ) {

		switch( $key ) :

			case 'first_name':
			case 'last_name': ?><input type=text id="<?= $key ?>" name="<?= $key ?>" value="<?= $this->output($key) ?>" required><?php break;

			case 'email': ?><input type=email id="<?= $key ?>" name="<?= $key ?>" value="<?= $this->output($key) ?>"><?php break;
			
			case 'sex': ?><span><?php foreach(static::SEXES as $o) : ?><input type=radio id=<?= $o ?> name=sex value=<?= $o ?><?php if($o === $this['sex']) : echo ' checked'; endif; ?> required><label for=<?= $o ?>><?= $o ?></label><?php endforeach; ?></span><?php break;
			
			case 'dob': ?><input type=date id=dob name=dob value="<?= $this[$key] ?>" required><?php break;

			case 'type':
			case 'phone':
			case 'address':
			case 'city':
			case 'region':
			case 'country':
			case 'zip': ?><input type=text id="<?= $key ?>" name="<?= $key ?>" value="<?= $this->output($key) ?>"><?php break;
		
		endswitch;

	}

	public function output( string $key ) {

		switch( $key ) :

			case 'name': return $this['first_name'] . ' ' . $this['last_name'];
			break;


			case 'id':
			case 'type':
			case 'first_name':
			case 'last_name':
			case 'sex':
			case 'dob':
			case 'email':
			case 'phone':
			case 'address':
			case 'city':
			case 'region':
			case 'country':
			case 'zip':
			case 'created':
			case 'modified': return $this[ $key ];
			break;

			default: return parent::output( $key );
		
		endswitch;

	}


}

/*
class patient extends contact {

	const INSURANCE = ['AMH','CM','MPG','MPG Plus','Unicare'], STATUSES = ['ACTIVE','INACTIVE'], FORMATS = ['insurance'=>"'%s'",'key_no'=>"'%s'",'status'=>"'%s'",'primary'=>'%u','emergency'=>'%u','doctor'=>'%u'] + contact::FORMATS;

	public function __construct( $id = NULL ) {

		$this->_id = $id;

		if(!$this->is_record($id)) return;

		$this->_exists = TRUE;

		$db = new db();
		if( !!$db->connect_errno ) return;

		$rec = $db->query(sprintf("SELECT * FROM `contacts` AS t1 JOIN `patients` AS t2 ON t1.id=t2.contact WHERE t2.id=%u LIMIT 1", $id));
		$a = $rec->fetch_assoc();
		
		$rec->free();
		$db->close();

		foreach($a as $key => $val)
		$this[$key] = $val;
		
		return $this;

	}

	protected function is_record( $id ) {

		$db = new db();
		if( !!$db->connect_errno ) return FALSE;

		$is = $db->query(sprintf("SELECT IF (EXISTS(SELECT * FROM patients WHERE id=%u),1,0) AS x", $id));

		$a = $is->fetch_assoc();
		
		$is->free();
		$db->close();

		return !!$a['x'];

	}

	public function label( string $key ) {

		if( !(static::$labels[ $key ] ?? 0) )
		switch( $key ) :

			case 'id': static::$labels[ 'id' ]					= __('id');						break;
			case 'contact': static::$labels[ 'contact' ]		= __('contact');				break;
			case 'primary': static::$labels[ 'primary' ]		= __('primary caregiver');		break;
			case 'emergency': static::$labels[ 'emergency' ]	= __('emergency contact');		break;
			case 'doctor': static::$labels[ 'doctor' ]			= __('doctor');					break;
			case 'insurance': static::$labels[ 'insurance' ]	= __('insurance');				break;
			case 'key_no': static::$labels[ 'key_no' ]			= __('key no.');				break;
			case 'status': static::$labels[ 'status' ]			= __('status');					break;
			case 'created': static::$labels[ 'created' ]		= __('created');				break;
			case 'modified': static::$labels[ 'modified' ]		= __('modified');				break;
			
			default: parent::label( $key );

		endswitch;

		return static::$labels[ $key ] ?? $key;

	}

	public function sanitized( string $key ) {

		switch( $key ) :
			
			case 'id':
			case 'contact':
			case 'primary':
			case 'emergency':
			case 'doctor':			return filter_input( INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT );

			case 'insurance':		return !($var = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING )) || !in_array( $var, static::INSURANCE ) ? NULL : $var;
			case 'status':			return !($var = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING )) || !in_array( $var, static::STATUSES ) ? NULL : $var;

			case 'key_no':			return filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );

			default:				return parent::sanitized($key);

		endswitch;

	}

	public function input( string $key ) {

		switch( $key ) :

			case 'insurance': ?><select id=insurance name=insurance><?php foreach(static::INSURANCE as $ins) : ?><option <?php if( $ins == $this[$key] ) : echo ' selected'; endif; ?>><?= $ins ?></option><?php endforeach; ?></select><?php break;

			case 'status':
			
			list($is, $not) = ('ACTIVE' == $this['status'] ? ['checked',''] : ['','checked']);
			
			?>
			<span>
				<input type=radio id=ACTIVE name=status value=ACTIVE <?= $is ?>>
				<input type=radio id=INACTIVE name=status value=INACTIVE <?= $not ?>>
				<label for=ACTIVE><i con>toggle_on</i></label>
				<label for=INACTIVE><i con>toggle_off</i></label>
			</span>
			<?php
			
			break;
			
			case 'primary':  	$type = 'CAREGIVER';
			case 'emergency':	$type ?? ($type = 'EMERGENCY');
			case 'doctor':		$type ?? ($type = 'DOCTOR');

			$sql = "SELECT id FROM contacts WHERE FIND_IN_SET('$type', type)";

			$db = new db();
			if( !!$db->connect_errno ) return;

			$result = $db->query($sql);

			?>
			<select id=<?= $key ?> name=<?= $key ?>><?php

			while($d = $result->fetch_array()) : ?>

				<option value="<?= $d[0] ?>"<?php if( $ins == $this[$key] ) : echo ' selected'; endif; ?>><?= (new contact($d[0]))->output('name'); ?></option><?php
			
			endwhile; ?>
			
			</select>
			<?php

			$result->close();
			$db->close();

			$type = NULL;
			
			break;
			
			case 'key_no':
			case 'created':
			case 'modified':?>
			
			<input type=text id="<?= $key ?>" name="<?= $key ?>" value="<?= $this->output($key) ?>">

			<?php

			default: parent::input( $key );
		
		endswitch;

	}

	public function output( string $key ) {

		switch( $key ) :

			case 'contact':
			case 'primary':
			case 'emergency':
			case 'doctor':

				$contact = new contact( $this[ $key ] );
				if( !$contact->exists() ) return 'does not exist';

				return $contact->output('name');

			break;

			case 'status': ?><i con <?= $this['status'] ?>>toggle_<?= 'ACTIVE' === $this['status'] ? 'on' : 'off' ?></i><?php break;
			
			case 'id':
			case 'insurance':
			case 'key_no':
			case 'created':
			case 'modified': return $this[ $key ];
			break;

			default: return parent::output( $key );

		endswitch;

	}

	public function title( string $section ) {

		static $titles; $titles ?? ($titles = [
			'contact'	=> __('contact info'),
			'patient'	=> __('patient info'),
			'last_visit'=> __('last visit'),
			'notes'		=> __('notes'),
			'allergies'	=> __('allergies'),
			'infections'=> __('infections'),
			'medication'=> __('medication'),
			'schedule'	=> __('schedule')
		]);

		return $titles[ $section ] ?? $section;

	}

	public function can_edit( string $section ) {

		static $can; $can ?? ($can = [
			'contact'	=> TRUE,
			'patient'	=> TRUE,
			'allergies'	=> TRUE,
			'infections'=> TRUE,
			'medication'=> TRUE,
			'schedule'	=> TRUE,
		]);

		return $can[ $section ] ?? FALSE;

	}

	public function section( string $section ) {
		
		if( file_exists( DIR."dash/patient/$section".php ) )
		return include DIR."dash/patient/$section".php;

		if( file_exists( DIR."dash/templates/$section".php ) )
		return include DIR."dash/templates/$section".php;

	}

	public function section_edit( string $section ) {
		
		if( file_exists( DIR."dash/patient/$section.edit".php ) )
		return include DIR."dash/patient/$section.edit".php;

		if( file_exists( DIR."dash/templates/$section.edit".php ) )
		return include DIR."dash/templates/$section.edit".php;

	}

	public function section_update( string $section ) {
		
		if( file_exists( DIR."dash/patient/$section.update".php ) )
		return include DIR."dash/patient/$section.update".php;

		if( file_exists( DIR."dash/templates/$section.update".php ) )
		return include DIR."dash/templates/$section.update".php;

	}

}*/

class vehicle extends record {

	const
	table = 'vehicles',
	STATUSES	= ['ACTIVE','INACTIVE'],
	FORMATS = ['id'=>'%u','reigistration'=>"'%s'",'make'=>"'%s'",'model'=>"'%s'",'year'=>'%u','status'=>"'%s'"];

	protected $_id;

	public function label( string $key ) {

		if( !(static::$labels[ $key ] ?? 0) )
		switch( $key ) :

			case 'id': static::$labels[ 'id' ]						= __('id');						break;
			case 'registration': static::$labels[ 'registration' ]	= __('registration');			break;
			case 'make': static::$labels[ 'make' ]					= __('make');					break;
			case 'model': static::$labels[ 'model' ]				= __('model');					break;
			case 'year': static::$labels[ 'year' ]					= __('year');					break;
			case 'status': static::$labels[ 'status' ]				= __('status');					break;
			
			default: parent::label( $key );

		endswitch;

		return static::$labels[ $key ] ?? $key;

	}

	public function sanitized( string $key ) {

		switch( $key ) :

			case 'id':
			case 'year':											return filter_input( INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT );

			case 'registration':
			case 'make':
			case 'model':
			case 'status':											return filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
		
		endswitch;

	}

	public function input( string $key ) {

		switch( $key ) :

		case 'id': ?><input type=hidden id="id_<?= $this->id ?>" name=vehicle[<?= $this->id ?>][id] value=<?= $this->output('id') ?>><?php break;

		case 'year': ?><input type=number id="year_<?= $this->id ?>" name=vehicle[<?= $this->id ?>][year] value=<?= $this->output('year') ?>><?php break;

		case 'status':
			
			list($is, $not) = ('ACTIVE' == $this['status'] ? ['checked',''] : ['','checked']);
			
			?>
			<span>
				<input type=radio id=ACTIVE_<?= $this->id ?> name=vehicle[<?= $this->id ?>][status] value=ACTIVE <?= $is ?>>
				<input type=radio id=INACTIVE_<?= $this->id ?> name=vehicle[<?= $this->id ?>][status] value=INACTIVE <?= $not ?>>
				<label for=ACTIVE_<?= $this->id ?>><i con>toggle_on</i></label>
				<label for=INACTIVE_<?= $this->id ?>><i con>toggle_off</i></label>
			</span>
			<?php
			
		break;

		case 'registration':
		case 'make':
		case 'model': ?><input type=text id="<?= $key . '_' . $this->id ?>" name=vehicle[<?= $this->id ?>][<?= $key ?>] value="<?= $this->output($key) ?>"><?php break;
		
		endswitch;

	}

	public function output( string $key ) {

		switch( $key ) :

			case 'id':
			case 'year':
			case 'registration':
			case 'make':
			case 'model':
			case 'status':	 return $this[ $key ];

			default: return parent::output( $key );
		
		endswitch;

	}


}

class Json extends a {

	const date = date;

	public static function getData( string $name ) {
	
		if( 'patient_coords' === $name ) return static::getCoords();

		/* ADD A CHECK FOR LOCALIZATION */
		if( start_is(LANG, 'de') && file_exists( DIR."data/demo/DE/$name".json ) ) return getJson( DIR."data/demo/DE/$name".json );

		// CHECK FOR JSON FILE
		if( file_exists( DIR."data/demo/$name".json ) ) return getJson( DIR."data/demo/$name".json );

		// CHECK FOR STATIC PROPERTY
		if( !property_exists( static::class, $name ) ) return;

		return json_decode( static::$$name );

	}
	
	protected static function getCoords() {
	
		$patients = json_decode( static::$patients );
		
		foreach($patients as $p)
		echo "$p->address $p->city $p->country $p->post_code
		
		<br/><br/>";
		
		exit;
	
	}

}


class io extends Json {

	protected static $caregivers = '[
		{
			"id": "1",
			"first_name": "Emma",
			"last_name": "Schmidt",
			"phone": "+49 1234567890",
			"certifications": [ "wound_simple", "injection_im"],
			"schedule": {
				"mon": "08:00 - 16:00",
				"tue": "08:00 - 16:00",
				"wed": "08:00 - 12:00",
				"thu": "08:00 - 16:00",
				"fri": "08:00 - 16:00",
				"sat": "Day Off",
				"sun": "Day Off"
			}
		},
		{
			"id": "2",
			"first_name": "Sofia",
			"last_name": "Schwarz",
			"phone": "+49 2345678901",
			"certifications": [ "wound_simple", "wound_complicated", "injection_im", "injection_sc"],
			"schedule": {
				"mon": "08:00 - 16:00",
				"tue": "08:00 - 16:00",
				"wed": "08:00 - 12:00",
				"thu": "08:00 - 16:00",
				"fri": "08:00 - 16:00",
				"sat": "Day Off",
				"sun": "Day Off"
			}
		}
	]';

	protected static $rescheduled_tour = '{
		"id": "tour_001",
		"date": '.self::date.',
		"visits": [
			{
				"id": "1563097500_6",
				"patient": {
					"id": "6",
					"modified": 1562137200,
					"status": "good"
				},
				"eta": 1563097500,
				"care_plan": "3",
				"pending_care": [
					"skin_care",
					"administer_tube_feeding",
					"groceries_shopping"
				]
			},
			{
				"id": "1563106500_4",
				"patient": {
					"id": "4",
					"modified": 1562004000,
					"status": "good"
				},
				"eta": 1563106500,
				"care_plan": "2",
				"pending_care": []
			},
			{
				"id": "1563109200_8",
				"patient": {
					"id": "8",
					"modified": 1562058000,
					"status": "good"
				},
				"eta": 1563101000,
				"care_plan": "3",
				"pending_care": []
			},
					{
				"id": "1563094800_3",
				"patient": {
					"id": "3",
					"modified": 1562018400,
					"status": "average"
				},
				"eta": 1563094800,
				"care_plan": "3",
				"pending_care": [
					"skin_care"
				]
			}
		]
	}';

	protected static $visit_history = '[
		{
			"id": "1563357600_1",
			"time": 1653645600,
			"care_giver": "2",
			"patient": "6",
			"care_plan": "5",
			"added_care": ["skin_care", "comb_hair"],
			"care_notes": [],
			"actions": [],
			"modified": 1653645600
		},
		{
			"id": "1563271200_1",
			"time": 1653646920,
			"care_giver": "1",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1653646920
		},
		{
			"id": "1563184800_1",
			"time": 1653729300,
			"care_giver": "2",
			"patient": "1",
			"care_plan": "5",
			"added_care": ["skin_care", "comb_hair"],
			"care_notes": [
				{
					"care_module": "stationary_mobilization",
					"care_given": false,
					"note": "patient refused treatment, he also was angry, nervous and thrilled that day. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. "
				},
				{
					"care_module": "skin_care",
					"care_given": true,
					"note": "needed additional help"
				}
			],
			"actions": [
				{
					"type": "infection",
					"action": "removed",
					"id": "mrsa"
				}
			],
			"modified": 1563189000
		},
		{
			"id": "1563098400_1",
			"time": 1563098400,
			"care_giver": "1",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1563102600
		},
		{
			"id": "1563012000_1",
			"time": 1563012000,
			"care_giver": "2",
			"patient": "2",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1563016200
		},
		{
			"id": "1562925600_1",
			"time": 1562925600,
			"care_giver": "1",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1562929800
		},
		{
			"id": "1562839200_1",
			"time": 1562839200,
			"care_giver": "2",
			"patient": "1",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1562843400
		},
		{
			"id": "1562752800_1",
			"time": 1562752800,
			"care_giver": "1",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1562757000
		},
		{
			"id": "1562666400_1",
			"time": 1562666400,
			"care_giver": "2",
			"patient": "4",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1562670600
		},
		{
			"id": "1562580000_1",
			"time": 1562580000,
			"care_giver": "1",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [
				{
					"type": "infection",
					"action": "added",
					"id": "mrsa"
				}
			],
			"modified": 1562584200
		},
		{
			"id": "1562493600_1",
			"time": 1562493600,
			"care_giver": "2",
			"patient": "7",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1562497800
		},
		{
			"id": "1562407200_1",
			"time": 1562407200,
			"care_giver": "1",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1562411400
		},
		{
			"id": "1562320800_1",
			"time": 1562320800,
			"care_giver": "2",
			"patient": "6",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1562325000
		},
		{
			"id": "1562234400_1",
			"time": 1562234400,
			"care_giver": "1",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1562238600
		},
		{
			"id": "1562148000_1",
			"time": 1562148000,
			"care_giver": "1",
			"care_plan": "5",
			"added_care": [],
			"care_notes": [],
			"actions": [],
			"modified": 1562152200
		}
	]';

	protected static $patients = '[
		{
			"id": "1",
			"first_name": "Anna",
			"last_name": "Handle",
			"gender": "female",
			"dob": -417315600,
			"key_number": "B231",
			"phone": "+44 2403789078",
			"gp_contact_id": 3,
			"emergency_contact_id": 8,
			"insurance": "MPG Plus",
			"address": "Frühlingstraße 16",
			"primary_care_giver_id": "2",
			"city": "Kissing",
			"country": "Germany",
			"post_code": "86438",
			"lat": "48.3030730",
			"long": "10.9705498",
			"status": "average",
			"risks": [
				"falling"
			],
			"infections": [],
			"modified": 1562122800,
			"previous_visit": {
				"status": "good",
				"note":	"Patient was in good spirits"
			},
			"medications": [
				{
					"id": "id1",
					"label": "Paracetomol",
					"dosage": "250 mg",
					"notes": "Take as needed",
					"am": false,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id2",
					"label": "Encomcore",
					"dosage": "5 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id3",
					"label": "Tetracyline",
					"dosage": "500 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": true,
					"with_food": true
				}
			]
		},
		{
			"id": "2",
			"first_name": "Carl",
			"last_name": "Müller",
			"gender": "male",
			"dob": -802918800,
			"key_number": "A440",
			"phone": "+44 2404789080",
			"gp_contact_id": 3,
			"emergency_contact_id": 8,
			"insurance": "MPG",
			"address": "Geistbeckstraße 6",
			"primary_care_giver_id": "2",
			"city": "Friedberg",
			"country": "Germany",
			"post_code": "86316",
			"lat": "48.3555773",
			"long": "10.9915528",
			"status": "poor",
			"risks": [
				"malnutrition",
				"decubitus"
			],
			"infections": [
				"tbc"
			],
			"modified": 1562040000,
			"previous_visit": {
				"status": "poor",
				"note":	"Carl had low energy and difficulty getting out of bed"
			},
			"medications": []
		},
		{
			"id": "3",
			"first_name": "Heinz",
			"last_name": "Schmidt",
			"gender": "male",
			"dob": -1155949200,
			"key_number": "A191",
			"phone": "+44 2403789011",
			"gp_contact_id": 1,
			"emergency_contact_id": 8,
			"insurance": "CM",
			"address": "Alte Str. 1",
			"primary_care_giver_id": "1",
			"city": "Pöttmes",
			"country": "Germany",
			"post_code": "86554",
			"lat": "48.5618693",
			"long": "11.0665490",
			"status": "average",
			"risks": [
				"dehydration",
				"decubitus"
			],
			"infections": [
				"mrsa"
			],
			"modified": 1562018400,
			"previous_visit": {
				"status": "average",
				"note":	"Care went as planned"
			},
			"medications": [
				{
					"id": "id1",
					"label": "Paracetomol",
					"dosage": "250 mg",
					"notes": "Take as needed",
					"am": false,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id2",
					"label": "Encomcore",
					"dosage": "5 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id3",
					"label": "Tetracyline",
					"dosage": "500 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": true,
					"with_food": true
				}
			]
		},
		{
			"id": "4",
			"first_name": "Karla",
			"last_name": "Hampel",
			"gender": "female",
			"dob": -332125200,
			"key_number": "B090",
			"phone": "+44 2404784420",
			"gp_contact_id": 2,
			"emergency_contact_id": 8,
			"insurance": "UniCare",
			"address": "Hauptstraße 81",
			"primary_care_giver_id": "2",
			"city": "Prittriching",
			"country": "Germany",
			"post_code": "86931",
			"lat": "48.2070043",
			"long": "10.9289402",
			"status": "good",
			"risks": [],
			"infections": [],
			"modified": 1562004000,
			"previous_visit": {
				"status": "good",
				"note":	"Karla was feeling better than usual"
			},
			"medications": [
				{
					"id": "id1",
					"label": "Paracetomol",
					"dosage": "250 mg",
					"notes": "Take as needed",
					"am": false,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id2",
					"label": "Encomcore",
					"dosage": "5 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id3",
					"label": "Tetracyline",
					"dosage": "500 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": true,
					"with_food": true
				}
			]
		},
		{
			"id": "5",
			"first_name": "Gerd",
			"last_name": "Müller",
			"gender": "male",
			"dob": -335581200,
			"key_number": "B025",
			"phone": "+44 2403785609",
			"gp_contact_id": 2,
			"emergency_contact_id": 8,
			"insurance": "AMH",
			"address": "Kalkofenstraße 26",
			"primary_care_giver_id": "2",
			"city": "Kissing",
			"country": "Germany",
			"post_code": "86438",
			"lat": "48.2970022",
			"long": "10.9661718",
			"status": "poor",
			"risks": [
				"dehydration",
				"falling",
				"muscle_contracture"
			],
			"infections": [
				"gastroenteritis"
			],
			"modified": 1562068800,
			"previous_visit": {
				"status": "good",
				"note":	"Patient care was uneventful"
			},
			"medications": [
				{
					"id": "id1",
					"label": "Paracetomol",
					"dosage": "250 mg",
					"notes": "Take as needed",
					"am": false,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id2",
					"label": "Encomcore",
					"dosage": "5 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id3",
					"label": "Tetracyline",
					"dosage": "500 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": true,
					"with_food": true
				}
			]
		},
		{
			"id": "6",
			"first_name": "Katharina",
			"last_name": "Vogt",
			"gender": "female",
			"dob": -893120400,
			"key_number": "A411",
			"phone": "+44 2404780033",
			"gp_contact_id": 1,
			"emergency_contact_id": 8,
			"insurance": "MPG",
			"address": "Hattenhofener Str. 10",
			"primary_care_giver_id": "2",
			"city": "Prittriching",
			"country": "Germany",
			"post_code": "86931",
			"lat": "48.1758188",
			"long": "10.9233702",
			"status": "good",
			"risks": [],
			"infections": [],
			"modified": 1562137200,
			"previous_visit": {
				"status": "good",
				"note":	"Patient was in good spirits"
			},
			"medications": [
				{
					"id": "id1",
					"label": "Paracetomol",
					"dosage": "250 mg",
					"notes": "Take as needed",
					"am": false,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id2",
					"label": "Encomcore",
					"dosage": "5 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id3",
					"label": "Tetracyline",
					"dosage": "500 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": true,
					"with_food": true
				}
			]
		},
		{
			"id": "7",
			"first_name": "Helga",
			"last_name": "Webber",
			"gender": "female",
			"dob": -1172538000,
			"key_number": "B102",
			"phone": "+44 2403783344",
			"gp_contact_id": 3,
			"emergency_contact_id": 8,
			"insurance": "AMH",
			"address": "Badangerstraße 43",
			"primary_care_giver_id": "1",
			"city": "Kissing",
			"country": "Germany",
			"post_code": "86438",
			"lat": "48.2968700",
			"long": "10.9841300",
			"status": "average",
			"risks": [],
			"infections": [],
			"modified": 1561975200,
			"previous_visit": {
				"status": "average",
				"note":	"Nothing significant to report"
			},
			"medications": [
				{
					"id": "id1",
					"label": "Paracetomol",
					"dosage": "250 mg",
					"notes": "Take as needed",
					"am": false,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id2",
					"label": "Encomcore",
					"dosage": "5 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": false,
					"with_food": false
				},
				{
					"id": "id3",
					"label": "Tetracyline",
					"dosage": "500 mg",
					"notes": "",
					"am": true,
					"noon": false,
					"pm": true,
					"with_food": true
				}
			]
		},
		{
			"id": "8",
			"first_name": "Rudolph",
			"last_name": "Kießl",
			"gender": "male",
			"dob": -1122944400,
			"key_number": "A133",
			"phone": "+44 2404788709",
			"gp_contact_id": 3,
			"emergency_contact_id": 8,
			"insurance": "CM",
			"address": "VdK-Straße 5",
			"primary_care_giver_id": "2",
			"city": "Kissing",
			"country": "Germany",
			"post_code": "86438",
			"lat": "48.30626481",
			"long": "10.9668001",
			"status": "good",
			"risks": [],
			"infections": [],
			"modified": 1562058000,
			"previous_visit": {
				"status": "good",
				"note":	"Patient care was uneventful"
			},
			"medications": []
		}
	]';

	protected static $contacts = '[
	{
		"id":"1",
		"first_name":"John",
		"last_name":"Miller",
		"prefix":"Dr.",
		"phone_country":"BE",
		"phone_number":"+32 579123450",
		"contact_group":"DOCTOR"
	},
	{
		"id":"2",
		"first_name":"Sam",
		"last_name":"Smith",
		"prefix":"Dr.",
		"phone_country":"BE",
		"phone_number":"+32 579123451",
		"contact_group":"DOCTOR"
	},
	{
		"id":"3",
		"first_name":"Jessica",
		"last_name":"Wild",
		"prefix":"Dr.",
		"phone_country":"BE",
		"phone_number":"+32 579123452",
		"contact_group":"DOCTOR"
	},
	{
		"id":"4",
		"first_name":"Jack",
		"last_name":"Baker",
		"prefix":"Mr.",
		"phone_country":"BE",
		"phone_number":"+32 579123453",
		"contact_group":"COLLEAGUE"
	},
	{
		"id":"5",
		"first_name":"Lena",
		"last_name":"Hiddi",
		"prefix":"Mrs.",
		"phone_country":"BE",
		"phone_number":"+32 579123454",
		"contact_group":"COLLEAGUE"
	},
	{
		"id":"6",
		"first_name":"Kate",
		"last_name":"Manson",
		"prefix":"Ms.",
		"phone_country":"BE",
		"phone_number":"+32 579123455",
		"contact_group":"COLLEAGUE"
	},
	{
		"id":"7",
		"first_name":"Jacky",
		"last_name":"Bridge",
		"prefix":"",
		"phone_country":"BE",
		"phone_number":"+32 579123456",
		"contact_group":"SUPPLIER"
	},
	{
		"id":"10",
		"first_name":"Jimmy",
		"last_name":"James",
		"prefix":"",
		"phone_country":"DE",
		"phone_number":"+49 123444567",
		"contact_group":"SUPPLIER"
	},
	{
		"id":"11",
		"first_name":"Joseph",
		"last_name":"Smith",
		"prefix":"",
		"phone_country":"DE",
		"phone_number":"+49 234555678",
		"contact_group":"SUPPLIER"
	},
	{
		"id":"8",
		"first_name":"Moritz",
		"last_name":"Vogt",
		"prefix":"",
		"phone_country":"BE",
		"phone_number":"+32 579123457",
		"contact_group":"PATIENT"
	},
	{
		"id":"12",
		"first_name":"Marti",
		"last_name":"Fisher",
		"prefix":"",
		"phone_country":"DE",
		"phone_number":"+49 345666789",
		"contact_group":"PATIENT"
	},
	{
		"id":"13",
		"first_name":"Owen",
		"last_name":"Müller",
		"prefix":"",
		"phone_country":"DE",
		"phone_number":"+49 456777890",
		"contact_group":"PATIENT"
	},
	{
		"id":"9",
		"first_name":"Care",
		"last_name":"Net1",
		"prefix":"",
		"phone_country":"BE",
		"phone_number":"+32 579123458",
		"contact_group":"CARENETWORK"
	},
	{
		"id":"14",
		"first_name":"Amazing",
		"last_name":"Health",
		"prefix":"",
		"phone_country":"BE",
		"phone_number":"+32 123444560",
		"contact_group":"CARENETWORK"
	},
	{
		"id":"15",
		"first_name":"Care",
		"last_name":"Straße 1",
		"prefix":"",
		"phone_country":"DE",
		"phone_number":"+49 012333456",
		"contact_group":"CARENETWORK"
	}
]';/*,
	{
		"id":"16",
		"first_name":"Mark",
		"last_name":"Wilson",
		"prefix":"",
		"phone_country":"BE",
		"phone_number":"+32 111222334",
		"contact_group":"HEADOFCARE"
	}
	]';*/

	protected static $infections = '[
		{
			"id": "mrsa",
			"label": "MRSA"
		},
		{
			"id": "vre",
			"label": "VRE"
		},
		{
			"id": "4mrgn",
			"label": "4MRGN"
		},
		{
			"id": "3mrgn",
			"label": "3MRGN"
		},
		{
			"id": "tbc",
			"label": "TBC"
		},
		{
			"id": "clostridium_d",
			"label": "Clostridium D"
		},
		{
			"id": "hepatitis_a_e",
			"label": "Hepatitis A+E"
		},
		{
			"id": "meningitis",
			"label": "Meningitis"
		},
		{
			"id": "gastroenteritis",
			"label": "Gastroenteritis"
		},
		{
			"id": "esbl",
			"label": "ESBL"
		},
		{
			"id": "salmonellen",
			"label": "Salmonellen"
		}
	]';

	protected static $active_infections = '[
		{
			"id": "mrsa",
			"patient_id": "3",
			"created_by": "creatorId1",
			"created": 1654586321,
			"is_waiting_confirmation": false
		},
		{
			"id": "esbl",
			"patient_id": "3",
			"created_by": "creatorId1",
			"created": 1654586321,
			"is_waiting_confirmation": false
		}
	]';

	protected static $risks = '[
		{
			"id": "dehydration",
			"label": "Dehydration",
			"eventForm": true
		},
		{
			"id": "falling",
			"label": "Falling",
			"eventForm": true
		},
		{
			"id": "malnutrition",
			"label": "Malnutrition",
			"eventForm": true
		},
		{
			"id": "decubitus",
			"label": "Decubitus",
			"eventForm": true
		},
		{
			"id": "mobility",
			"label": "Mobility",
			"eventForm": false
		},
		{
			"id": "incontinence",
			"label": "Incontinence",
			"eventForm": true
		}
	]';

	protected static $patient_risks = '[
		{
			"id": "dehydration",
			"patient_id": "3",
			"created_by": "creatorId1",
			"created": 1564989537386,
			"is_waiting_confirmation": false,
			"profile": {
				"drinking_quantity_observation":"by_relatives",
				"drinking_quantity":1500,
				"drinking_quantity_measure":"exact",
				"drinking_quantity_target":1400,
				"is_quantity_achieved":true,
				"is_measures_to_be_taken":true,
				"measures_observation":"by_caregiver",
				"measures_option":"hydrate_each_visit",
				"advice":[ 
					"log_drinking_quantity",
					"take_note"
				],
				"caregiver_opinion":"Drink more green tea",
				"edited":1564989537386,
				"implementation_of_advice":"maybe",
				"extension_support":"no"
			}
		},
		{
			"id": "falling",
			"patient_id": "3",
			"created_by": "creatorId1",
			"created": 1564989537387,
			"is_waiting_confirmation": false,
			"profile": {}
		},
		{
			"id": "malnutrition",
			"patient_id": "3",
			"created_by": "creatorId2",
			"created": 1564989537388,
			"is_waiting_confirmation": false,
			"profile": {}
		}
	]';

	protected static $allergies = '[
		{
			"id": "latex",
			"label": "Latex"
		},
		{
			"id": "peanut",
			"label": "Peanut"
		},
		{
			"id": "milk",
			"label": "Milk"
		},
		{
			"id": "soy",
			"label": "Soy"
		},
		{
			"id": "penicillin",
			"label": "Penicillin"
		},
		{
			"id": "wheat",
			"label": "Wheat"
		}
	]';

	protected static $patient_allergies = '[
		{
			"id": "milk",
			"patient_id": "3",
			"created_by": "creatorId1",
			"created": 1564989537386,
			"is_waiting_confirmation": false
		},
		{
			"id": "penicillin",
			"patient_id": "3",
			"created_by": "creatorId1",
			"created": 1564989537387,
			"is_waiting_confirmation": false
		}
	]';

	protected static $care_plans = '[
		{
			"id": "1",
			"modules": [
				"first_visit"
			]
		},
		{
			"id": "2",
			"modules": [
				"skin_care",
				"hair_nail_care",
				"oral_dental_denture_care"
			]
		},
		{
			"id": "3",
			"modules": [
				"transfer_to_from_bed",
				"assist_getting_un_dressed",
				"partial_bathing"
			]
		},
		{
			"id": "4",
			"modules": [
				"complete_bathing_only"
			]
		},
		{
			"id": "5",
			"modules": [
				"stationary_mobilization",
				"transfer_to_from_bed",
				"assist_with_eating"
			]
		},
		{
			"id": "6",
			"modules": [
				"minor_residence_care",
				"prepare_other_meal",
				"assist_with_eating"
			]
		},
		{
			"id": "7",
			"modules": [
				"thorough_bathing",
				"shaving_facial_care"
			]
		}
	]';

	protected static $care_modules = '[
		{
			"id": "transfer_to_from_bed",
			"label": "Transfer to / from bed",
			"time": "8"
		},
		{
			"id": "assist_getting_un_dressed",
			"label": "Assist getting  (un)dressed",
			"time": "10"
		},
		{
			"id": "partial_bathing",
			"label": "Partial bathing",
			"time": "12"
		},
		{
			"id": "oral_dental_denture_care",
			"label": "Oral, Dental Denture Care",
			"time": "7"
		},
		{
			"id": "shaving_facial_care",
			"label": "Shaving & facial care",
			"time": "10"
		},
		{
			"id": "comb_hair",
			"label": "Comb hair",
			"time": "6"
		},
		{
			"id": "skin_care",
			"label": "Skin care",
			"time": "7"
		},
		{
			"id": "complex_task",
			"label": "Complex task",
			"time": "20"
		},
		{
			"id": "hair_nail_care",
			"label": "Hair & nail care",
			"time": "15"
		},
		{
			"id": "thorough_bathing",
			"label": "Thorough bathing",
			"time": "20"
		},
		{
			"id": "complete_bathing_only",
			"label": "Complete bathing (only)",
			"time": "30"
		},
		{
			"id": "stationary_mobilization",
			"label": "Stationary mobilization",
			"time": "12"
		},
		{
			"id": "assist_with_eating",
			"label": "Assist with eating",
			"time": "12"
		},
		{
			"id": "administer_tube_feeding",
			"label": "Administer tube feeding",
			"time": "12"
		},
		{
			"id": "aid_defecation_urination",
			"label": "Aid defecation & urination",
			"time": "15"
		},
		{
			"id": "void_colostomy_bag",
			"label": "Void colostomy bag",
			"time": "10"
		},
		{
			"id": "help_depart_return_to_residence",
			"label": "Help depart / return to residence",
			"time": "20"
		},
		{
			"id": "accompany_in_activities",
			"label": "Accompany in activities",
			"time": "30"
		},
		{
			"id": "manage_heating_of_residence",
			"label": "Manage heating of residence",
			"time": "5"
		},
		{
			"id": "minor_residence_care",
			"label": "Minor residence care",
			"time": "10"
		},
		{
			"id": "major_residence_care",
			"label": "Major residence care",
			"time": "25"
		},
		{
			"id": "wash_dry_laundry",
			"label": "Wash & dry laundry",
			"time": "15"
		},
		{
			"id": "fold_deposit_laundry",
			"label": "Fold & deposit laundry",
			"time": "15"
		},
		{
			"id": "groceries_shopping",
			"label": "Groceries & shopping",
			"time": "30"
		},
		{
			"id": "cook_warm_meal",
			"label": "Cook warm meal",
			"time": "20"
		},
		{
			"id": "prepare_other_meal",
			"label": "Prepare other meal",
			"time": "10"
		},
		{
			"id": "first_visit",
			"label": "First visit",
			"time": "30"
		},
		{
			"id": "modify_care_plan",
			"label": "Modify care plan",
			"time": "5"
		}
	]';

	protected static $tour = '{
		"id": "tour_001",
		"date": '.self::date.',
		"visits": [
			{
				"id": "1563097500_6",
				"patient": {
					"id": "6",
					"modified": 1562137200,
					"status": "good"
				},
				"eta": 1563097500,
				"care_plan": "3",
				"pending_care": [
					"skin_care",
					"hair_nail_care"
				]
			},
			{
				"id": "1563101100_2",
				"patient": {
					"id": "2",
					"modified": 1562040000,
					"status": "poor"
				},
				"eta": 1563101100,
				"care_plan": "4",
				"pending_care": []
			},
			{
				"id": "1563103800_1",
				"patient": {
					"id": "1",
					"modified": 1562122800,
					"status": "average"
				},
				"eta": 1563103800,
				"care_plan": "5",
				"pending_care": []
			},
			{
				"id": "1563106500_4",
				"patient": {
					"id": "4",
					"modified": 1562004000,
					"status": "good"
				},
				"eta": 1563106500,
				"care_plan": "2",
				"pending_care": []
			},
			{
				"id": "1563109200_8",
				"patient": {
					"id": "8",
					"modified": 1562058000,
					"status": "good"
				},
				"eta": 1563109200,
				"care_plan": "3",
				"pending_care": []
			}
		]
	}';

	protected static $notes = '[
	{
		"id": "id1",
		"creatorId": "creatorId1",
		"description": "Patient seemed angry with me today",
		"creationTime": 1654597800000,
		"audioFileUrl": null,
		"noteCategory": [
		{
			"type": "GENERAL",
			"categoryId": ""
		}
		],
		"noteVisibility": "PRIVATE",
		"isHighPriority": false
	},
	{
		"id": "id2",
		"creatorId": "creatorId1",
		"description": "Patient refused to be washed",
		"creationTime": 1653912000000,
		"audioFileUrl": null,
		"noteCategory": [
		{
			"type": "PATIENT",
			"categoryId": "3"
		}
		],
		"noteVisibility": "PUBLIC",
		"isHighPriority": false
	},
	{
		"id": "id3",
		"creatorId": "creatorId2",
		"description": "Show more interest when listening to him",
		"creationTime": 1654088800000,
		"noteCategory": [
		{
			"type": "PATIENT",
			"categoryId": "3"
		}
		],
		"noteVisibility": "PUBLIC",
		"isHighPriority": true
	}
	]';

	protected static $update_note = '{
		"id": "newNoteId1",
		"creatorId": "creatorId1",
		"description": "Patient seemed angry with me today",
		"creationTime": 1654086147950,
		"audioFileUrl": null,
		"noteCategory": [
		{
			"type": "GENERAL",
			"categoryId": ""
		}
		],
		"noteVisibility": "PRIVATE",
		"isHighPriority": false
	}';

	protected static $tasks = '[
	{
		"id": "id1",
		"creatorId": "creatorId1",
		"description": "Meeting with Dr.Kurtz",
		"creationTime": 1654086147950,
		"completionTime": 1655216520000,
		"completionStatus": false,
		"audioFileUrl": null,
		"taskCategory": [
		{
			"type": "GENERAL",
			"categoryId": ""
		}
		],
		"visibility": "PRIVATE",
		"isHighPriority": false
	},
	{
		"id": "id2",
		"creatorId": "creatorId1",
		"description": "Wash patient carefully",
		"creationTime": 1654086147950,
		"completionTime": 1655202600000,
		"completionStatus": false,
		"audioFileUrl": null,
		"taskCategory": [
		{
			"type": "PATIENT",
			"categoryId": "1"
		}
		],
		"visibility": "PUBLIC",
		"isHighPriority": false
	},
	{
		"id": "id3",
		"creatorId": "creatorId2",
		"description": "Have a short chat with the patient",
		"creationTime": 1654088800000,
		"completionTime": 1654086147950,
		"completionStatus": true,
		"taskCategory": [
		{
			"type": "PATIENT",
			"categoryId": "3"
		}
		],
		"visibility": "PUBLIC",
		"isHighPriority": true
	}
	]';

	protected static $update_task = '{ "id":"newTaskId1" }';

	protected static $care_medmodules = '{
		"height": {
			"id": "heightModule",
			"label": "Height",
			"measure": "cm",
			"required": true,
			"male_active": true,
			"male_default": 180,
			"female_active": true,
			"female_default": 165,
			"options": [{ "value": 70 }, { "value": 71 }, { "value": 72 }, { "value": 73 }, { "value": 74 }, { "value": 75 }, { "value": 76 }, { "value": 77 }, { "value": 78 }, { "value": 79 }, { "value": 80 }, { "value": 81 }, { "value": 82 }, { "value": 83 }, { "value": 84 }, { "value": 85 }, { "value": 86 }, { "value": 87 }, { "value": 88 }, { "value": 89 }, { "value": 90 }, { "value": 91 }, { "value": 92 }, { "value": 93 }, { "value": 94 }, { "value": 95 }, { "value": 96 }, { "value": 97 }, { "value": 98 }, { "value": 99 }, { "value": 100 }, { "value": 101 }, { "value": 102 }, { "value": 103 }, { "value": 104 }, { "value": 105 }, { "value": 106 }, { "value": 107 }, { "value": 108 }, { "value": 109 }, { "value": 110 }, { "value": 111 }, { "value": 112 }, { "value": 113 }, { "value": 114 }, { "value": 115 }, { "value": 116 }, { "value": 117 }, { "value": 118 }, { "value": 119 }, { "value": 120 }, { "value": 121 }, { "value": 122 }, { "value": 123 }, { "value": 124 }, { "value": 125 }, { "value": 126 }, { "value": 127 }, { "value": 128 }, { "value": 129 }, { "value": 130 }, { "value": 131 }, { "value": 132 }, { "value": 133 }, { "value": 134 }, { "value": 135 }, { "value": 136 }, { "value": 137 }, { "value": 138 }, { "value": 139 }, { "value": 140 }, { "value": 141 }, { "value": 142 }, { "value": 143 }, { "value": 144 }, { "value": 145 }, { "value": 146 }, { "value": 147 }, { "value": 148 }, { "value": 149 }, { "value": 150 }, { "value": 151 }, { "value": 152 }, { "value": 153 }, { "value": 154 }, { "value": 155 }, { "value": 156 }, { "value": 157 }, { "value": 158 }, { "value": 159 }, { "value": 160 }, { "value": 161 }, { "value": 162 }, { "value": 163 }, { "value": 164 }, { "value": 165 }, { "value": 166 }, { "value": 167 }, { "value": 168 }, { "value": 169 }, { "value": 170 }, { "value": 171 }, { "value": 172 }, { "value": 173 }, { "value": 174 }, { "value": 175 }, { "value": 176 }, { "value": 177 }, { "value": 178 }, { "value": 179 }, { "value": 180 }, { "value": 181 }, { "value": 182 }, { "value": 183 }, { "value": 184 }, { "value": 185 }, { "value": 186 }, { "value": 187 }, { "value": 188 }, { "value": 189 }, { "value": 190 }, { "value": 191 }, { "value": 192 }, { "value": 193 }, { "value": 194 }, { "value": 195 }, { "value": 196 }, { "value": 197 }, { "value": 198 }, { "value": 199 }, { "value": 200 }, { "value": 201 }, { "value": 202 }, { "value": 203 }, { "value": 204 }, { "value": 205 }, { "value": 206 }, { "value": 207 }, { "value": 208 }, { "value": 209 }, { "value": 210 }, { "value": 211 }, { "value": 212 }, { "value": 213 }, { "value": 214 }, { "value": 215 }, { "value": 216 }, { "value": 217 }, { "value": 218 }, { "value": 219 }, { "value": 220 }, { "value": 221 }, { "value": 222 }, { "value": 223 }, { "value": 224 }, { "value": 225 }, { "value": 226 }, { "value": 227 }, { "value": 228 }, { "value": 229 }, { "value": 230 }, { "value": 231 }, { "value": 232 }, { "value": 233 }, { "value": 234 }, { "value": 235 }, { "value": 236 }, { "value": 237 }, { "value": 238 }, { "value": 239 }, { "value": 240 }]
		},
		"weight": {
			"id": "weightModule",
			"label": "Weight",
			"measure": "Kg",
			"required": true,
			"male_active": true,
			"male_default": 85,
			"female_active": true,
			"female_default": 70,
			"options": [{ "value": 20 }, { "value": 21 }, { "value": 22 }, { "value": 23 }, { "value": 24 }, { "value": 25 }, { "value": 26 }, { "value": 27 }, { "value": 28 }, { "value": 29 }, { "value": 30 }, { "value": 31 }, { "value": 32 }, { "value": 33 }, { "value": 34 }, { "value": 35 }, { "value": 36 }, { "value": 37 }, { "value": 38 }, { "value": 39 }, { "value": 40 }, { "value": 41 }, { "value": 42 }, { "value": 43 }, { "value": 44 }, { "value": 45 }, { "value": 46 }, { "value": 47 }, { "value": 48 }, { "value": 49 }, { "value": 50 }, { "value": 51 }, { "value": 52 }, { "value": 53 }, { "value": 54 }, { "value": 55 }, { "value": 56 }, { "value": 57 }, { "value": 58 }, { "value": 59 }, { "value": 60 }, { "value": 61 }, { "value": 62 }, { "value": 63 }, { "value": 64 }, { "value": 65 }, { "value": 66 }, { "value": 67 }, { "value": 68 }, { "value": 69 }, { "value": 70 }, { "value": 71 }, { "value": 72 }, { "value": 73 }, { "value": 74 }, { "value": 75 }, { "value": 76 }, { "value": 77 }, { "value": 78 }, { "value": 79 }, { "value": 80 }, { "value": 81 }, { "value": 82 }, { "value": 83 }, { "value": 84 }, { "value": 85 }, { "value": 86 }, { "value": 87 }, { "value": 88 }, { "value": 89 }, { "value": 90 }, { "value": 91 }, { "value": 92 }, { "value": 93 }, { "value": 94 }, { "value": 95 }, { "value": 96 }, { "value": 97 }, { "value": 98 }, { "value": 99 }, { "value": 100 }, { "value": 101 }, { "value": 102 }, { "value": 103 }, { "value": 104 }, { "value": 105 }, { "value": 106 }, { "value": 107 }, { "value": 108 }, { "value": 109 }, { "value": 110 }, { "value": 111 }, { "value": 112 }, { "value": 113 }, { "value": 114 }, { "value": 115 }, { "value": 116 }, { "value": 117 }, { "value": 118 }, { "value": 119 }, { "value": 120 }, { "value": 121 }, { "value": 122 }, { "value": 123 }, { "value": 124 }, { "value": 125 }, { "value": 126 }, { "value": 127 }, { "value": 128 }, { "value": 129 }, { "value": 130 }, { "value": 131 }, { "value": 132 }, { "value": 133 }, { "value": 134 }, { "value": 135 }, { "value": 136 }, { "value": 137 }, { "value": 138 }, { "value": 139 }, { "value": 140 }, { "value": 141 }, { "value": 142 }, { "value": 143 }, { "value": 144 }, { "value": 145 }, { "value": 146 }, { "value": 147 }, { "value": 148 }, { "value": 149 }, { "value": 150 }, { "value": 151 }, { "value": 152 }, { "value": 153 }, { "value": 154 }, { "value": 155 }, { "value": 156 }, { "value": 157 }, { "value": 158 }, { "value": 159 }, { "value": 160 }, { "value": 161 }, { "value": 162 }, { "value": 163 }, { "value": 164 }, { "value": 165 }, { "value": 166 }, { "value": 167 }, { "value": 168 }, { "value": 169 }, { "value": 170 }, { "value": 171 }, { "value": 172 }, { "value": 173 }, { "value": 174 }, { "value": 175 }, { "value": 176 }, { "value": 177 }, { "value": 178 }, { "value": 179 }, { "value": 180 }, { "value": 181 }, { "value": 182 }, { "value": 183 }, { "value": 184 }, { "value": 185 }, { "value": 186 }, { "value": 187 }, { "value": 188 }, { "value": 189 }, { "value": 190 }, { "value": 191 }, { "value": 192 }, { "value": 193 }, { "value": 194 }, { "value": 195 }, { "value": 196 }, { "value": 197 }, { "value": 198 }, { "value": 199 }, { "value": 200 }]
		},
		"lung_capacity": {
			"id": "lungCapacityModule",
			"label": "Lung Capacity",
			"measure": "%",
			"required": true,
			"male_active": true,
			"male_default": 100,
			"female_active": true,
			"female_default": 100,
			"options": [{ "value": 50 }, { "value": 51 }, { "value": 52 }, { "value": 53 }, { "value": 54 }, { "value": 55 }, { "value": 56 }, { "value": 57 }, { "value": 58 }, { "value": 59 }, { "value": 60 }, { "value": 61 }, { "value": 62 }, { "value": 63 }, { "value": 64 }, { "value": 65 }, { "value": 66 }, { "value": 67 }, { "value": 68 }, { "value": 69 }, { "value": 70 }, { "value": 71 }, { "value": 72 }, { "value": 73 }, { "value": 74 }, { "value": 75 }, { "value": 76 }, { "value": 77 }, { "value": 78 }, { "value": 79 }, { "value": 80 }, { "value": 81 }, { "value": 82 }, { "value": 83 }, { "value": 84 }, { "value": 85 }, { "value": 86 }, { "value": 87 }, { "value": 88 }, { "value": 89 }, { "value": 90 }, { "value": 91 }, { "value": 92 }, { "value": 93 }, { "value": 94 }, { "value": 95 }, { "value": 96 }, { "value": 97 }, { "value": 98 }, { "value": 99 }, { "value": 100 }, { "value": 101 }, { "value": 102 }, { "value": 103 }, { "value": 104 }, { "value": 105 }, { "value": 106 }, { "value": 107 }, { "value": 108 }, { "value": 109 }, { "value": 110 }, { "value": 111 }, { "value": 112 }, { "value": 113 }, { "value": 114 }, { "value": 115 }, { "value": 116 }, { "value": 117 }, { "value": 118 }, { "value": 119 }, { "value": 120 }, { "value": 121 }, { "value": 122 }, { "value": 123 }, { "value": 124 }, { "value": 125 }, { "value": 126 }, { "value": 127 }, { "value": 128 }, { "value": 129 }, { "value": 130 }, { "value": 131 }, { "value": 132 }, { "value": 133 }, { "value": 134 }, { "value": 135 }, { "value": 136 }, { "value": 137 }, { "value": 138 }, { "value": 139 }, { "value": 140 }, { "value": 141 }, { "value": 142 }, { "value": 143 }, { "value": 144 }, { "value": 145 }, { "value": 146 }, { "value": 147 }, { "value": 148 }, { "value": 149 }, { "value": 150 }]
		},
		"bp_systolic": {
			"id": "bpSystolicModule",
			"label": "Blood Pressure",
			"measure": "mmHg",
			"required": true,
			"male_active": true,
			"male_default": 120,
			"female_active": true,
			"female_default": 120,
			"options": [{ "value": 70 }, { "value": 71 }, { "value": 72 }, { "value": 73 }, { "value": 74 }, { "value": 75 }, { "value": 76 }, { "value": 77 }, { "value": 78 }, { "value": 79 }, { "value": 80 }, { "value": 81 }, { "value": 82 }, { "value": 83 }, { "value": 84 }, { "value": 85 }, { "value": 86 }, { "value": 87 }, { "value": 88 }, { "value": 89 }, { "value": 90 }, { "value": 91 }, { "value": 92 }, { "value": 93 }, { "value": 94 }, { "value": 95 }, { "value": 96 }, { "value": 97 }, { "value": 98 }, { "value": 99 }, { "value": 100 }, { "value": 101 }, { "value": 102 }, { "value": 103 }, { "value": 104 }, { "value": 105 }, { "value": 106 }, { "value": 107 }, { "value": 108 }, { "value": 109 }, { "value": 110 }, { "value": 111 }, { "value": 112 }, { "value": 113 }, { "value": 114 }, { "value": 115 }, { "value": 116 }, { "value": 117 }, { "value": 118 }, { "value": 119 }, { "value": 120 }, { "value": 121 }, { "value": 122 }, { "value": 123 }, { "value": 124 }, { "value": 125 }, { "value": 126 }, { "value": 127 }, { "value": 128 }, { "value": 129 }, { "value": 130 }, { "value": 131 }, { "value": 132 }, { "value": 133 }, { "value": 134 }, { "value": 135 }, { "value": 136 }, { "value": 137 }, { "value": 138 }, { "value": 139 }, { "value": 140 }, { "value": 141 }, { "value": 142 }, { "value": 143 }, { "value": 144 }, { "value": 145 }, { "value": 146 }, { "value": 147 }, { "value": 148 }, { "value": 149 }, { "value": 150 }, { "value": 151 }, { "value": 152 }, { "value": 153 }, { "value": 154 }, { "value": 155 }, { "value": 156 }, { "value": 157 }, { "value": 158 }, { "value": 159 }, { "value": 160 }, { "value": 161 }, { "value": 162 }, { "value": 163 }, { "value": 164 }, { "value": 165 }, { "value": 166 }, { "value": 167 }, { "value": 168 }, { "value": 169 }, { "value": 170 }, { "value": 171 }, { "value": 172 }, { "value": 173 }, { "value": 174 }, { "value": 175 }, { "value": 176 }, { "value": 177 }, { "value": 178 }, { "value": 179 }, { "value": 180 }, { "value": 181 }, { "value": 182 }, { "value": 183 }, { "value": 184 }, { "value": 185 }, { "value": 186 }, { "value": 187 }, { "value": 188 }, { "value": 189 }, { "value": 190 }]
		},
		"bp_diastolic": {
			"id": "bpDiastolicModule",
			"label": "BloodPressure",
			"measure": "mmHg",
			"required": true,
			"male_active": true,
			"male_default": 80,
			"female_active": true,
			"female_default": 80,
			"options": [{ "value": 40 }, { "value": 41 }, { "value": 42 }, { "value": 43 }, { "value": 44 }, { "value": 45 }, { "value": 46 }, { "value": 47 }, { "value": 48 }, { "value": 49 }, { "value": 50 }, { "value": 51 }, { "value": 52 }, { "value": 53 }, { "value": 54 }, { "value": 55 }, { "value": 56 }, { "value": 57 }, { "value": 58 }, { "value": 59 }, { "value": 60 }, { "value": 61 }, { "value": 62 }, { "value": 63 }, { "value": 64 }, { "value": 65 }, { "value": 66 }, { "value": 67 }, { "value": 68 }, { "value": 69 }, { "value": 70 }, { "value": 71 }, { "value": 72 }, { "value": 73 }, { "value": 74 }, { "value": 75 }, { "value": 76 }, { "value": 77 }, { "value": 78 }, { "value": 79 }, { "value": 80 }, { "value": 81 }, { "value": 82 }, { "value": 83 }, { "value": 84 }, { "value": 85 }, { "value": 86 }, { "value": 87 }, { "value": 88 }, { "value": 89 }, { "value": 90 }, { "value": 91 }, { "value": 92 }, { "value": 93 }, { "value": 94 }, { "value": 95 }, { "value": 96 }, { "value": 97 }, { "value": 98 }, { "value": 99 }, { "value": 100 }, { "value": 101 }, { "value": 102 }, { "value": 103 }, { "value": 104 }, { "value": 105 }, { "value": 106 }, { "value": 107 }, { "value": 108 }, { "value": 109 }, { "value": 110 }, { "value": 111 }, { "value": 112 }, { "value": 113 }, { "value": 114 }, { "value": 115 }, { "value": 116 }, { "value": 117 }, { "value": 118 }, { "value": 119 }, { "value": 120 }, { "value": 121 }, { "value": 122 }, { "value": 123 }, { "value": 124 }, { "value": 125 }, { "value": 126 }, { "value": 127 }, { "value": 128 }, { "value": 129 }, { "value": 130 }, { "value": 131 }, { "value": 132 }, { "value": 133 }, { "value": 134 }, { "value": 135 }, { "value": 136 }, { "value": 137 }, { "value": 138 }, { "value": 139 }, { "value": 140 }]
		},
		"glucose_fasted": {
			"id": "glucoseFastedModule",
			"genders": { "male": { "active": true, "default": 5.5 }, "female": { "active": true, "default": 5.5 } },
			"label": "Glucose (fasted)",
			"measure": "mmol/L",
			"required": true,
			"male_active": true,
			"male_default": 5.5,
			"female_active": true,
			"female_default": 5.5,
			"options": [{ "value": 3.5 }, { "value": 3.6 }, { "value": 3.7 }, { "value": 3.8 }, { "value": 3.9 }, { "value": 4 }, { "value": 4.1 }, { "value": 4.2 }, { "value": 4.3 }, { "value": 4.4 }, { "value": 4.5 }, { "value": 4.6 }, { "value": 4.7 }, { "value": 4.8 }, { "value": 4.9 }, { "value": 5 }, { "value": 5.1 }, { "value": 5.2 }, { "value": 5.3 }, { "value": 5.4 }, { "value": 5.5 }, { "value": 5.6 }, { "value": 5.7 }, { "value": 5.8 }, { "value": 5.9 }, { "value": 6 }, { "value": 6.1 }, { "value": 6.2 }, { "value": 6.3 }, { "value": 6.4 }, { "value": 6.5 }, { "value": 6.6 }, { "value": 6.7 }, { "value": 6.8 }, { "value": 6.9 }, { "value": 7 }, { "value": 7.1 }, { "value": 7.2 }, { "value": 7.3 }, { "value": 7.4 }, { "value": 7.5 }, { "value": 7.6 }, { "value": 7.7 }, { "value": 7.8 }, { "value": 7.9 }, { "value": 8 }, { "value": 8.1 }, { "value": 8.2 }, { "value": 8.3 }, { "value": 8.4 }, { "value": 8.5 }, { "value": 8.6 }, { "value": 8.7 }, { "value": 8.8 }, { "value": 8.9 }, { "value": 9 }, { "value": 9.1 }, { "value": 9.2 }, { "value": 9.3 }, { "value": 9.4 }, { "value": 9.5 }, { "value": 9.6 }, { "value": 9.7 }, { "value": 9.8 }, { "value": 9.9 }, { "value": 10 }, { "value": 10.1 }, { "value": 10.2 }, { "value": 10.3 }, { "value": 10.4 }, { "value": 10.5 }, { "value": 10.6 }, { "value": 10.7 }, { "value": 10.8 }, { "value": 10.9 }, { "value": 11 }, { "value": 11.1 }, { "value": 11.2 }, { "value": 11.3 }, { "value": 11.4 }, { "value": 11.5 }, { "value": 11.6 }, { "value": 11.7 }, { "value": 11.8 }, { "value": 11.9 }, { "value": 12 }, { "value": 12.1 }, { "value": 12.2 }, { "value": 12.3 }, { "value": 12.4 }, { "value": 12.5 }, { "value": 12.6 }, { "value": 12.7 }, { "value": 12.8 }, { "value": 12.9 }, { "value": 13 }, { "value": 13.1 }, { "value": 13.2 }, { "value": 13.3 }, { "value": 13.4 }, { "value": 13.5 }, { "value": 13.6 }, { "value": 13.7 }, { "value": 13.8 }, { "value": 13.9 }, { "value": 14 }, { "value": 14.1 }, { "value": 14.2 }, { "value": 14.3 }, { "value": 14.4 }, { "value": 14.5 }, { "value": 14.6 }, { "value": 14.7 }, { "value": 14.8 }, { "value": 14.9 }, { "value": 15 }, { "value": 15.1 }, { "value": 15.2 }, { "value": 15.3 }, { "value": 15.4 }, { "value": 15.5 }, { "value": 15.6 }, { "value": 15.7 }, { "value": 15.8 }, { "value": 15.9 }, { "value": 16 }]
		},
		"glucose_not_fasted": {
			"id": "glucoseNotFastedModule",
			"label": "Glucose (not fasted)",
			"measure": "mmol/L",
			"required": true,
			"male_active": true,
			"male_default": 7.2,
			"female_active": true,
			"female_default": 7.2,
			"options": [{ "value": 3.5 }, { "value": 3.6 }, { "value": 3.7 }, { "value": 3.8 }, { "value": 3.9 }, { "value": 4 }, { "value": 4.1 }, { "value": 4.2 }, { "value": 4.3 }, { "value": 4.4 }, { "value": 4.5 }, { "value": 4.6 }, { "value": 4.7 }, { "value": 4.8 }, { "value": 4.9 }, { "value": 5 }, { "value": 5.1 }, { "value": 5.2 }, { "value": 5.3 }, { "value": 5.4 }, { "value": 5.5 }, { "value": 5.6 }, { "value": 5.7 }, { "value": 5.8 }, { "value": 5.9 }, { "value": 6 }, { "value": 6.1 }, { "value": 6.2 }, { "value": 6.3 }, { "value": 6.4 }, { "value": 6.5 }, { "value": 6.6 }, { "value": 6.7 }, { "value": 6.8 }, { "value": 6.9 }, { "value": 7 }, { "value": 7.1 }, { "value": 7.2 }, { "value": 7.3 }, { "value": 7.4 }, { "value": 7.5 }, { "value": 7.6 }, { "value": 7.7 }, { "value": 7.8 }, { "value": 7.9 }, { "value": 8 }, { "value": 8.1 }, { "value": 8.2 }, { "value": 8.3 }, { "value": 8.4 }, { "value": 8.5 }, { "value": 8.6 }, { "value": 8.7 }, { "value": 8.8 }, { "value": 8.9 }, { "value": 9 }, { "value": 9.1 }, { "value": 9.2 }, { "value": 9.3 }, { "value": 9.4 }, { "value": 9.5 }, { "value": 9.6 }, { "value": 9.7 }, { "value": 9.8 }, { "value": 9.9 }, { "value": 10 }, { "value": 10.1 }, { "value": 10.2 }, { "value": 10.3 }, { "value": 10.4 }, { "value": 10.5 }, { "value": 10.6 }, { "value": 10.7 }, { "value": 10.8 }, { "value": 10.9 }, { "value": 11 }, { "value": 11.1 }, { "value": 11.2 }, { "value": 11.3 }, { "value": 11.4 }, { "value": 11.5 }, { "value": 11.6 }, { "value": 11.7 }, { "value": 11.8 }, { "value": 11.9 }, { "value": 12 }, { "value": 12.1 }, { "value": 12.2 }, { "value": 12.3 }, { "value": 12.4 }, { "value": 12.5 }, { "value": 12.6 }, { "value": 12.7 }, { "value": 12.8 }, { "value": 12.9 }, { "value": 13 }, { "value": 13.1 }, { "value": 13.2 }, { "value": 13.3 }, { "value": 13.4 }, { "value": 13.5 }, { "value": 13.6 }, { "value": 13.7 }, { "value": 13.8 }, { "value": 13.9 }, { "value": 14 }, { "value": 14.1 }, { "value": 14.2 }, { "value": 14.3 }, { "value": 14.4 }, { "value": 14.5 }, { "value": 14.6 }, { "value": 14.7 }, { "value": 14.8 }, { "value": 14.9 }, { "value": 15 }, { "value": 15.1 }, { "value": 15.2 }, { "value": 15.3 }, { "value": 15.4 }, { "value": 15.5 }, { "value": 15.6 }, { "value": 15.7 }, { "value": 15.8 }, { "value": 15.9 }, { "value": 16 }]
		},
		"spo2": {
			"id": "temperatureModule",
			"label": "SpO2 (Oxygen saturation)",
			"measure": "%",
			"required": true,
			"male_active": true,
			"male_default": 36.6,
			"female_active": true,
			"female_default": 36.6,
			"options": [{ "value": 35.0 }, { "value": 35.1 }, { "value": 35.2 }, { "value": 35.3 }, { "value": 35.4 }, { "value": 35.5 }, { "value": 35.6 }, { "value": 35.7 }, { "value": 35.8 }, { "value": 35.9 }, { "value": 36.0 }, { "value": 36.1 }, { "value": 36.2 }, { "value": 36.3 }, { "value": 36.4 }, { "value": 36.5 }, { "value": 36.6 }, { "value": 36.7 }, { "value": 36.8 }, { "value": 36.9 }, { "value": 37.0 }, { "value": 37.1 }, { "value": 37.2 }, { "value": 37.3 }, { "value": 37.4 }, { "value": 37.5 }, { "value": 37.6 }, { "value": 37.7 }, { "value": 37.8 }, { "value": 37.9 }, { "value": 38.0 }, { "value": 38.1 }, { "value": 38.2 }, { "value": 38.3 }, { "value": 38.4 }, { "value": 38.5 }, { "value": 38.6 }, { "value": 38.7 }, { "value": 38.8 }, { "value": 38.9 }, { "value": 39.0 }, { "value": 39.1 }, { "value": 39.2 }, { "value": 39.3 }, { "value": 39.4 }, { "value": 39.5 }, { "value": 39.6 }, { "value": 39.7 }, { "value": 39.8 }, { "value": 39.9 }, { "value": 40.0 }, { "value": 40.1 }, { "value": 40.2 }, { "value": 40.3 }, { "value": 40.4 }, { "value": 40.5 }, { "value": 40.6 }, { "value": 40.7 }, { "value": 40.8 }, { "value": 40.9 }, { "value": 41.0 }, { "value": 41.1 }, { "value": 41.2 }, { "value": 41.3 }, { "value": 41.4 }, { "value": 41.5 }, { "value": 41.6 }, { "value": 41.7 }, { "value": 41.8 }, { "value": 41.9 }, { "value": 42.0 }]
		},
		"temp": {
			"id": "temperatureModule",
			"label": "Temperature",
			"measure": "°C",
			"required": true,
			"male_active": true,
			"male_default": 36.6,
			"female_active": true,
			"female_default": 36.6,
			"options": [{ "value": 35.0 }, { "value": 35.1 }, { "value": 35.2 }, { "value": 35.3 }, { "value": 35.4 }, { "value": 35.5 }, { "value": 35.6 }, { "value": 35.7 }, { "value": 35.8 }, { "value": 35.9 }, { "value": 36.0 }, { "value": 36.1 }, { "value": 36.2 }, { "value": 36.3 }, { "value": 36.4 }, { "value": 36.5 }, { "value": 36.6 }, { "value": 36.7 }, { "value": 36.8 }, { "value": 36.9 }, { "value": 37.0 }, { "value": 37.1 }, { "value": 37.2 }, { "value": 37.3 }, { "value": 37.4 }, { "value": 37.5 }, { "value": 37.6 }, { "value": 37.7 }, { "value": 37.8 }, { "value": 37.9 }, { "value": 38.0 }, { "value": 38.1 }, { "value": 38.2 }, { "value": 38.3 }, { "value": 38.4 }, { "value": 38.5 }, { "value": 38.6 }, { "value": 38.7 }, { "value": 38.8 }, { "value": 38.9 }, { "value": 39.0 }, { "value": 39.1 }, { "value": 39.2 }, { "value": 39.3 }, { "value": 39.4 }, { "value": 39.5 }, { "value": 39.6 }, { "value": 39.7 }, { "value": 39.8 }, { "value": 39.9 }, { "value": 40.0 }, { "value": 40.1 }, { "value": 40.2 }, { "value": 40.3 }, { "value": 40.4 }, { "value": 40.5 }, { "value": 40.6 }, { "value": 40.7 }, { "value": 40.8 }, { "value": 40.9 }, { "value": 41.0 }, { "value": 41.1 }, { "value": 41.2 }, { "value": 41.3 }, { "value": 41.4 }, { "value": 41.5 }, { "value": 41.6 }, { "value": 41.7 }, { "value": 41.8 }, { "value": 41.9 }, { "value": 42.0 }]
		}
	}';

	protected static $vehicles = '[
		{"id":1,"registration":"J14 68 H91","odometer":141336},
		{"id":2,"registration":"R67 24 G97","odometer":563091},
		{"id":3,"registration":"K13 84 W48","odometer":666536},
		{"id":4,"registration":"E23 50 A49","odometer":595696},
		{"id":5,"registration":"I36 73 I90","odometer":404689}]';/*,
		{"id":6,"registration":"N36 76 U80","odometer":193109},
		{"id":7,"registration":"Y29 56 V64","odometer":280846},
		{"id":8,"registration":"M49 84 R53","odometer":130871},
		{"id":9,"registration":"A98 64 K62","odometer":334852},
		{"id":10,"registration":"T95 61 P75","odometer":578622}
	]';*/

}