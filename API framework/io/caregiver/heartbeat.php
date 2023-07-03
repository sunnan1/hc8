<?php namespace _;

//Json_x( check_post_headers() );

// VERIFY CAREGIVER UUID
if( !$caregiver = caregiver::byUuid() ) fail('caregiver not found');

// CHECK FOR EXPECTED POST VALUES
if( !$stamp = filter_post_int('timestamp') ) fail('timestamp not set');

if( !$action = filter_action() ) fail('action not set');

// CHECK FOR coordinates (lat, lng)
if( !$lat = filter_post('lat') ) fail('lat not set');
if( !$lng = filter_post('lng') ) fail('lng not set');

// CHECK FOR rel_id - NOT REQUIRED
if( has_post('rel_id') ) $rel_id = filter_int('rel_id');

// CONVERT THE TIMESTAMP TO PROPER FORMAT
$stamp = to_timestamp($stamp);

// UPDATE THE CAREGIVER STATUS
if( !$caregiver->heartbeat($stamp, $action, $lat, $lng, $rel_id ?? 0) ) fail('failed to update heartbeat status');

// RETURN SUCCESS OBJECT
success('heartbeat status updated');
