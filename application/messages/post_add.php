<?php defined('SYSPATH') or die('No direct script access.');
 
return array
(
	'title' => array
	(
		// 'not_empty' => 'Title must not be empty.',
		// 'default'  => 'Title Input.',
	),

	'price' => array
	(
		'not_empty' => 'Price must not be empty',
		// 'default'  => 'Price is invalid.',
	),

	'description' => array
	(
		// 'not_empty' => 'Description must not be empty',
		// 'default'  => 'Description is invalid.',
	),

	'userfile' => array
	(
		'valid'    => 'Ad Image 1 is not a valid filename',
		'size'     => 'Ad Image 1 exceeds 2MB',
		'default'  => 'Description text is invalid.',
	),

	'subcategory_id' => array(
		'valid_ids' => 'category must be one of the available options',
		'not_empty' => 'category must not be empty'
	)
);