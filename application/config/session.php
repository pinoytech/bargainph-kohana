<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'database' => array(
		'name' => 'fuelcid',
		'encrypted' => FALSE,
		'lifetime' => 43200,
		'group' => 'default',
		'table' => 'sessions',
		'columns' => array(
			'session_id'  => 'session_id',
			'last_active' => 'last_active',
			'contents'    => 'contents'
		),
		'gc' => 500,
	),
	'cookie' => array(
		'name'       => 'session',
		'encrypted'  => FALSE,
		'lifetime'   => 0,
	),
	'native' => array(
		'name' => 'session_native',
		'encrypted' => TRUE,
		'lifetime' => 108000,
	),
);
