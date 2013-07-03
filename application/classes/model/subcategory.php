<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Subcategory extends ORM{

	protected $_belongs_to = array('category' => array());
	protected $_has_many = array('posts' => array());

	public static function valid_ids(Validate $array, $field)
	{
		$valid_ids = array();

		foreach (ORM::factory('subcategory')->find_all() as $rows)
		{
			$valid_ids[] = $rows->id;
		}

		if ( ! in_array($array[$field], $valid_ids))
		{
			$array->error($field, 'valid_ids', array($array[$field]));
		}
	}

} // End Model_Subcategory