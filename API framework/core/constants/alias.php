<?php namespace _;

const
ns	= __NAMESPACE__,
Ns	= ns.'\\',
aa	= '@@',
no	= FALSE,
io	= '.io',
js	= '.js',
get	= '.get',
set	= '.set',
css	= '.css',
csv	= '.csv',
img	= '.img',
xml	= '.xml',
json= '.json',
find= '.find',
style	= '.style',
script	= '.script',

// TOKEN CONTEXT TYPE NAMES
auth	= 'auth',
secure	= 'secure',
login	= 'login',
nonce	= 'nonce',

int_min		    = PHP_INT_MIN,
int_max		    = PHP_INT_MAX,
golden_factor   = 0.6180339887498547,
golden_ratio	= 1.61803398875,

// DEFAULT JSON OUTPUT 
PRETTY_NUMERIC_CODE_SLASHES	= JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_NUMERIC_CHECK|JSON_PRESERVE_ZERO_FRACTION,
HEX							= JSON_HEX_TAG,

// TEMPORARY FIX FOR DEPRECATED FILTER_SANITIZE_STRING
FILTER_SANITIZE_STRING		= FILTER_DEFAULT,

sec_min		= 60,
sec_hour	= 60 * 60,
sec_day		= 3600*24,
sec_week	= sec_day*7,
sec_month	= sec_day*30,
sec_year	= sec_day*365,

Kb			= 1024,
Mb			= Kb * 1024,
Gb			= Mb * 1024,

// SHORT HAND FORMATERS
fd			= '%d',
ff			= '%f',
fs			= "'%s'",
fu			= '%u',

// FORMATTER MAP FOR PREPARED STATEMENTS
// WILL CHANGE TO BE INCLUDED IN CLASS PROPERTY DEFINITIONS POSSIBLE IN PHP8 
fp			= [ fd=>'i', ff=>'d', fs=>'s', fu=>'i' ];

// NAMESPACED CURRENT DATE CONSTANT
define( Ns.'date', strtotime( date('Y-m-d') . ' 00:00:00 UTC' ) );

// NAMESPACED API HANDLER NAME FOR THE REQUEST
define( Ns.'EP_TYPE', filter_input(INPUT_GET, aa, FILTER_SANITIZE_STRING) );