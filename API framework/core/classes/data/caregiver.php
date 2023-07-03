<?php namespace _;

class caregiver extends staff {

	const table = 'caregivers';

	// CHECK IF UUID EXISTS
	public static function uuidExists( string $uuid = NULL ) {

		return dbx()->exists("SELECT * FROM `contacts` WHERE `uuid`='%s'", $uuid);

	}

	// GET THE CAREGIVER BY A UUID
	public static function byUuid( string $uuid = NULL ) {

		// USE CURRENT UUID IF NOT PROVIDED
		if( !$uuid && !($uuid = UUID) ) return FALSE;

		// VERIFY THE UUID EXISTS
		if( !static::uuidExists($uuid) ) return FALSE;

		// GET THE CONTACT ID
		$contact_id = dbx()->val("SELECT `id` FROM `contacts` WHERE `uuid`='%s' LIMIT 1", $uuid);

		// CHECK IF CONTACT IS CAREGIVER
		if( !dbx()->exists("SELECT * FROM `caregivers` WHERE `id`=%u", $contact_id) ) return FALSE;

		// GET THE CAREGIVER ID
		$id = dbx()->val("SELECT `id` FROM `caregivers` WHERE `id`=%u LIMIT 1", $contact_id);

		// RETURN THE CAREGIVER INSTANCE
		return new static($id);

	}

	// UPDATE THE CAREGIVER ACTIVE STATUS
	public function heartbeat( string $stamp, string $action, string $lat, string $lng, int $rel_id = 0 ) {

		static
		$INSERT		= "INSERT INTO `activity`(`caregiver`) VALUES (?)",
		$UPDATE		= "UPDATE `activity` SET `device`=?,`firebase`=?,`appos`=?,`appversion`=?,`action`=?,`rel_id`=?,`lat`=?,`lng`=?,`stamp`=? WHERE `caregiver`=?";
		//$HISTORY	= "UPDATE `wallet_history` SET `name`=? WHERE `id`=?";

		// MAKE SURE THE CAREGIVER EXISTS
		if( !$this->exists() ) return FALSE;

		// CREATE A NEW ACTIVITY RECORD FOR THE CAREGIVER IF NEEDED
		if( !dbx()->exists("SELECT * FROM `activity` WHERE `caregiver`=%u", $this['id']) ) :

			// PREPARE THE INSERT STATEMENT
			$stmt = db()->prepare($INSERT);

			// BIND PARAMETERS TO PREPARED STATEMENT
			$stmt->bind_param('i', $caregiver_id);

			// GET CAREGIVER ID FROM INSTANCE
			$caregiver_id = $this['id'];

			// EXECUTE AND RETURN ON FAILURE
			if( !$stmt->insert(TRUE) ) return FALSE;

		endif;

		// PREPARE THE UPDATE STATEMENT
		$stmt = db()->prepare($UPDATE);

		// BIND PARAMETERS TO PREPARED STATEMENT
		$stmt->bind_param('sssssiddsi', $device, $firebase, $appos, $appversion, $action, $rel_id, $lat, $lng, $stamp, $caregiver);

		// SET VALUE OF BOUND PARAMETERS
		$device 	= DEVICEID;
		$firebase 	= FIREBASEID;
		$appos 		= APPOS;
		$appversion = APPVERSION;

		$caregiver	= $this['id'];
		
		// EXECUTE AND RETURN SUCCESS
		return $stmt->success(FALSE);

	}

}