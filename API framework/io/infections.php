<?php namespace _;

foreach(infection::KEYS as $key) :

	$data[] = ['id'=>$key,'label'=>infection::label($key)];

endforeach;

return $data;