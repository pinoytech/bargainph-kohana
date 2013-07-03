<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Category extends ORM{

    protected $_has_many = array('subcategories' => array());

    public function __construct()
    {
    	parent::__construct();
    }

    // public function get_categories($limit = NULL, $offset = NULL)
    // {
    // 	return DB::select('categories.id', 'categories.created_at', 'categories.uri', 'categories.description', 'categories.name')
    //      ->from('categories')
    //      ->order_by('categories.id', 'DESC')
    //      ->limit($limit)
    //      ->offset($offset)
    //      ->execute();
    // }

} // End Post_Model