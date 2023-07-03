<?php namespace _;

$patients = io::getData('patients');

if( !has_get('patient') ) return;
if( !$id = filter_int('patient') ) return;

foreach( $patients as $patient )
if( $id == $patient['id'] ) return $patient['medications'] ?? [];
