<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Categories extends Controller_Website {

	public function before()
	{
        parent::before();
        $this->template->bind('content', $content);
		$this->category = ORM::factory('category');
		$this->template->categories = ORM::factory('category')->find_all();
	}

	public function action_index()
	{
		$this->template->content = new View('categories/index');
		$this->template->content->categories = $this->category->where('id', 'IN', array(1,2))->find_all();
		$this->template->content->categories_2 = $this->category->where('id', 'IN', array(3,4))->find_all();
		$this->template->content->categories_3 = $this->category->where('id', 'IN', array(5))->find_all();

		// $this->template->content->posts = ORM::factory('post')->find_all();
	}

} // End Categories_Controller
