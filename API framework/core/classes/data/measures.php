<?php namespace _; !no || die('eroor');




class measure extends record {

	const
	table			= 'visit_measures',
	primary_key		= 'id',
	KEYS			= [/* */'BP_SYSTOLIC','BP_DIASTOLIC',/*  - REMOVED TILL NATIVE FIX IS IMPLEMENTED */'GLUCOSE_FASTED','GLUCOSE_NOT_FASTED','GLUCOSE_INSULIN','HEART_RATE','HEIGHT','LUNG_CAPACITY','SPO2','TEMP','WEIGHT'],
	TYPES			= ['BP','GLUCOSE','HEART_RATE','HEIGHT','LUNG_CAPACITY','SPO2','TEMP','WEIGHT'],
	SUB_TYPES		= ['','SYSTOLIC','DIASTOLIC','FASTED','NOT_FASTED','INSULIN'],
	TAGS			= ['REQUESTED','ADDED'],
	STATUSES		= ['QUEUED','DONE','SKIPPED'],
	APP_PROPERTIES	= ['NAME','TYPE','SUB_TYPE','APP_ROW','APP_PARENT','LABEL','SYMBOL','INTERVAL','DEFAULTS','MIN','MAX','STEP','OPTIONS'],

	NAME		= '',
	TYPE		= '',
	SUB_TYPE	= '',
	APP_ROW		= '',
	APP_PARENT	= NULL,
	LABEL		= '',
	SYMBOL		= '',
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> NULL,
		'female'	=> NULL,
	],
	MIN			= NULL,
	MAX			= NULL,
	STEP		= NULL,
	OPTIONS		= [];

	public static function label( string $key ) {

		static $labels; $labels ?? ($labels = [

			'BP'					=> __('Blood Pressure'),
			'BP_DIASTOLIC'			=> __('BP Diastolic'),
			'BP_SYSTOLIC'			=> __('BP Systolic'),
			'GLUCOSE'				=> __('Glucose'),
			'GLUCOSE_FASTED'		=> __('Glucose (fasted)'),
			'GLUCOSE_NOT_FASTED'	=> __('Glucose (not fasted)'),
			'HEART_RATE'			=> __('Heart Rate'),
			'HEIGHT'				=> __('Height'),
			'INSULIN'				=> __('Insulin'),
			'LUNG_CAPACITY'			=> __('Lung Capacity'),
			'SPO2'					=> __('SpO2'),
			'TEMP'					=> __('Temperature'),
			'WEIGHT'				=> __('Weight'),

		]);

		return $labels[ $key ] ?? NULL;

	}

	public static function symbol( string $key ) {

		static $labels; $labels ?? ($labels = [

			'BP'					=> __('mmHg'),
			'BP_DIASTOLIC'			=> __('mmHg'),
			'BP_SYSTOLIC'			=> __('mmHg'),
			'GLUCOSE'				=> __('mmol/L'),
			'GLUCOSE_FASTED'		=> __('mmol/L'),
			'GLUCOSE_NOT_FASTED'	=> __('mmol/L'),
			'GLUCOSE_INSULIN'		=> __('units'),
			'HEART_RATE'			=> __('bpm'),
			'HEIGHT'				=> __('cm'),
			'INSULIN'				=> __('units'),
			'LUNG_CAPACITY'			=> __('%'),
			'SPO2'					=> __('%'),
			'TEMP'					=> __('°C'),
			'WEIGHT'				=> __('Kg'),

		]);

		return $labels[ $key ] ?? NULL;

	}

}

foreach(measure::KEYS as $m)
$msr_strings[$m] = ['label'=>measure::label($m),'symbol'=>measure::symbol($m)];

define(Ns.'MSR_STRINGS', $msr_strings);

abstract class bp_diastolic extends measure {

	const
	NAME		= 'BP_DIASTOLIC',
	TYPE		= 'BP',
	SUB_TYPE	= 'DIASTOLIC',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> 80,
		'female'	=> 80,
	],
	MIN			= 40,
	MAX			= 140,
	STEP		= 1,
	OPTIONS		= [40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140];

}

abstract class bp_systolic extends measure {

	const
	NAME		= 'BP_SYSTOLIC',
	TYPE		= 'BP',
	SUB_TYPE	= 'SYSTOLIC',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> 120,
		'female'	=> 120,
	],
	MIN			= 70,
	MAX			= 190,
	STEP		= 1,
	OPTIONS		= [70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190];

}

abstract class app_bp_systolic extends bp_systolic {

	const
	LABEL		= 'Blood Pressure',
	SYMBOL		= 'mmHg',
	APP_ROW		= 'BP';

}

abstract class app_bp_diastolic extends bp_diastolic {

	const
	APP_ROW		= 'BP';

}

class bp extends bp_diastolic {

	const
	NAME		= 'BP',
	SUB_TYPE	= '',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30;

}

abstract class glucose_fasted extends measure {

	const
	NAME		= 'GLUCOSE_FASTED',
	TYPE		= 'GLUCOSE',
	SUB_TYPE	= 'FASTED',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> 5.5,
		'female'	=> 5.5,
	],
	MIN			= 3.5,
	MAX			= 16,
	STEP		= 0.1,
	OPTIONS		= [3.5,3.6,3.7,3.8,3.9,4,4.1,4.2,4.3,4.4,4.5,4.6,4.7,4.8,4.9,5,5.1,5.2,5.3,5.4,5.5,5.6,5.7,5.8,5.9,6,6.1,6.2,6.3,6.4,6.5,6.6,6.7,6.8,6.9,7,7.1,7.2,7.3,7.4,7.5,7.6,7.7,7.8,7.9,8,8.1,8.2,8.3,8.4,8.5,8.6,8.7,8.8,8.9,9,9.1,9.2,9.3,9.4,9.5,9.6,9.7,9.8,9.9,10,10.1,10.2,10.3,10.4,10.5,10.6,10.7,10.8,10.9,11,11.1,11.2,11.3,11.4,11.5,11.6,11.7,11.8,11.9,12,12.1,12.2,12.3,12.4,12.5,12.6,12.7,12.8,12.9,13,13.1,13.2,13.3,13.4,13.5,13.6,13.7,13.8,13.9,14,14.1,14.2,14.3,14.4,14.5,14.6,14.7,14.8,14.9,15,15.1,15.2,15.3,15.4,15.5,15.6,15.7,15.8,15.9,16];

}

abstract class glucose_not_fasted extends measure {

	const
	NAME		= 'GLUCOSE_NOT_FASTED',
	TYPE		= 'GLUCOSE',
	SUB_TYPE	= 'NOT_FASTED',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> 7.2,
		'female'	=> 7.2,
	],
	MIN			= 3.5,
	MAX			= 16,
	STEP		= 0.1,
	OPTIONS		= [3.5,3.6,3.7,3.8,3.9,4,4.1,4.2,4.3,4.4,4.5,4.6,4.7,4.8,4.9,5,5.1,5.2,5.3,5.4,5.5,5.6,5.7,5.8,5.9,6,6.1,6.2,6.3,6.4,6.5,6.6,6.7,6.8,6.9,7,7.1,7.2,7.3,7.4,7.5,7.6,7.7,7.8,7.9,8,8.1,8.2,8.3,8.4,8.5,8.6,8.7,8.8,8.9,9,9.1,9.2,9.3,9.4,9.5,9.6,9.7,9.8,9.9,10,10.1,10.2,10.3,10.4,10.5,10.6,10.7,10.8,10.9,11,11.1,11.2,11.3,11.4,11.5,11.6,11.7,11.8,11.9,12,12.1,12.2,12.3,12.4,12.5,12.6,12.7,12.8,12.9,13,13.1,13.2,13.3,13.4,13.5,13.6,13.7,13.8,13.9,14,14.1,14.2,14.3,14.4,14.5,14.6,14.7,14.8,14.9,15,15.1,15.2,15.3,15.4,15.5,15.6,15.7,15.8,15.9,16];

}

abstract class glucose_insulin extends measure {

	const
	NAME		= 'GLUCOSE_INSULIN',
	TYPE		= 'GLUCOSE',
	SUB_TYPE	= 'INSULIN',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> 1,
		'female'	=> 1,
	],
	MIN			= 0,
	MAX			= 500,
	STEP		= 1,
	OPTIONS		= [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,30,40,50,60,70,80,90,100,120,140,160,180,200,220,240,260,280,300,320,340,360,380,400,420,440,460,480,500];

}

abstract class app_glucose_fasted extends glucose_fasted {

	const
	LABEL		= 'Glucose (fasted)',
	SYMBOL		= 'mmHg',
	APP_ROW		= 'GLUCOSE';

}

abstract class app_glucose_not_fasted extends glucose_not_fasted {

	const
	LABEL		= "Glucose (̶f̶a̶s̶t̶e̶d)",
	SYMBOL		= 'mmHg',
	APP_ROW		= 'GLUCOSE';

}

abstract class app_glucose_insulin extends glucose_insulin {

	const
	LABEL		= "Insulin",
	SYMBOL		= 'units',
	APP_ROW		= 'INSULIN',
	APP_PARENT	= 'GLUCOSE';

}

class insulin extends glucose_insulin {



}

class glucose extends insulin {

	const
	NAME		= 'GLUCOSE',
	SUB_TYPE	= '',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30;

}

abstract class heart_rate extends measure {

	const
	NAME		= 'HEART_RATE',
	TYPE		= 'HEART_RATE',
	SUB_TYPE	= '',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> 72,
		'female'	=> 80,
	],
	MIN			= 40,
	MAX			= 240,
	STEP		= 1,
	OPTIONS		= [40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240];

}

abstract class app_heart_rate extends heart_rate {

	const
	LABEL		= "Heart Rate",
	SYMBOL		= 'bpm',
	APP_ROW		= 'HEART_RATE';

}

class height extends measure {

	const
	NAME		= 'HEIGHT',
	TYPE		= 'HEIGHT',
	SUB_TYPE	= '',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> 180,
		'female'	=> 165,
	],
	MIN			= 70,
	MAX			= 240,
	STEP		= 1,
	OPTIONS		= [70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240];

}

abstract class app_height extends height {

	const
	LABEL		= 'Height',
	SYMBOL		= 'cm',
	APP_ROW		= 'HEIGHT';

}

class lung_capacity extends measure {

	const
	NAME		= 'LUNG_CAPACITY',
	TYPE		= 'LUNG_CAPACITY',
	SUB_TYPE	= '',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> 100,
		'female'	=> 100,
	],
	MIN			= 50,
	MAX			= 150,
	STEP		= 1,
	OPTIONS		= [50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150];

}

abstract class app_lung_capacity extends lung_capacity {
	
	const
	LABEL		= 'Lung Capacity',
	SYMBOL		= '%',
	APP_ROW		= 'LUNG_CAPACITY';

}

class spo2 extends measure {

	const
	NAME		= 'SPO2',
	TYPE		= 'SPO2',
	SUB_TYPE	= '',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> 99.5,
		'female'	=> 99.5,
	],
	MIN			= 75,
	MAX			= 100,
	STEP		= 0.1,
	OPTIONS		= [75.0,75.1,75.2,75.3,75.4,75.5,75.6,75.7,75.8,75.9,76.0,76.1,76.2,76.3,76.4,76.5,76.6,76.7,76.8,76.9,77.0,77.1,77.2,77.3,77.4,77.5,77.6,77.7,77.8,77.9,78.0,78.1,78.2,78.3,78.4,78.5,78.6,78.7,78.8,78.9,79.0,79.1,79.2,79.3,79.4,79.5,79.6,79.7,79.8,79.9,80.0,80.1,80.2,80.3,80.4,80.5,80.6,80.7,80.8,80.9,81.0,81.1,81.2,81.3,81.4,81.5,81.6,81.7,81.8,81.9,82.0,82.1,82.2,82.3,82.4,82.5,82.6,82.7,82.8,82.9,83.0,83.1,83.2,83.3,83.4,83.5,83.6,83.7,83.8,83.9,84.0,84.1,84.2,84.3,84.4,84.5,84.6,84.7,84.8,84.9,85.0,85.1,85.2,85.3,85.4,85.5,85.6,85.7,85.8,85.9,86.0,86.1,86.2,86.3,86.4,86.5,86.6,86.7,86.8,86.9,87.0,87.1,87.2,87.3,87.4,87.5,87.6,87.7,87.8,87.9,88.0,88.1,88.2,88.3,88.4,88.5,88.6,88.7,88.8,88.9,89.0,89.1,89.2,89.3,89.4,89.5,89.6,89.7,89.8,89.9,90.0,90.1,90.2,90.3,90.4,90.5,90.6,90.7,90.8,90.9,91.0,91.1,91.2,91.3,91.4,91.5,91.6,91.7,91.8,91.9,92.0,92.1,92.2,92.3,92.4,92.5,92.6,92.7,92.8,92.9,93.0,93.1,93.2,93.3,93.4,93.5,93.6,93.7,93.8,93.9,94.0,94.1,94.2,94.3,94.4,94.5,94.6,94.7,94.8,94.9,95.0,95.1,95.2,95.3,95.4,95.5,95.6,95.7,95.8,95.9,96.0,96.1,96.2,96.3,96.4,96.5,96.6,96.7,96.8,96.9,97.0,97.1,97.2,97.3,97.4,97.5,97.6,97.7,97.8,97.9,98.0,98.1,98.2,98.3,98.4,98.5,98.6,98.7,98.8,98.9,99.0,99.1,99.2,99.3,99.4,99.5,99.6,99.7,99.8,99.9,100];

}

abstract class app_spo2 extends spo2 {

	const
	APP_ROW		= 'SPO2';

}

class temp extends measure {

	const
	NAME		= 'TEMP',
	TYPE		= 'TEMP',
	SUB_TYPE	= '',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> 36.7,
		'female'	=> 37,
	],
	MIN			= 35,
	MAX			= 42,
	STEP		= 0.1,
	OPTIONS		= [35,35.1,35.2,35.3,35.4,35.5,35.6,35.7,35.8,35.9,36,36.1,36.2,36.3,36.4,36.5,36.6,36.7,36.8,36.9,37,37.1,37.2,37.3,37.4,37.5,37.6,37.7,37.8,37.9,38,38.1,38.2,38.3,38.4,38.5,38.6,38.7,38.8,38.9,39,39.1,39.2,39.3,39.4,39.5,39.6,39.7,39.8,39.9,40,40.1,40.2,40.3,40.4,40.5,40.6,40.7,40.8,40.9,41,41.1,41.2,41.3,41.4,41.5,41.6,41.7,41.8,41.9,42];

}

abstract class app_temp extends temp {

	const
	LABEL		= 'Temperature',
	SYMBOL		= '°C',
	APP_ROW		= 'TEMP';

}

class weight extends measure {

	const
	NAME		= 'WEIGHT',
	TYPE		= 'WEIGHT',
	SUB_TYPE	= '',
	LABEL		= MSR_STRINGS[ self::NAME ]['label'],
	SYMBOL		= MSR_STRINGS[ self::NAME ]['symbol'],
	INTERVAL	= 30,
	DEFAULTS	= [
		'male'		=> 85,
		'female'	=> 70,
	],
	MIN			= 20,
	MAX			= 200,
	STEP		= 1,
	OPTIONS		= [20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200];

}

abstract class app_weight extends weight {

	const
	LABEL		= 'Weight',
	SYMBOL		= 'Kg',
	APP_ROW		= 'WEIGHT';

}
