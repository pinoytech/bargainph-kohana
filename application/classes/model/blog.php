<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Blog extends ORM{

    protected $_rules = array(
        'uri' => array('not_empty' => NULL),
        'post' => array('not_empty' => NULL),
        'title' => array('not_empty' => NULL)
    );
}