<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Subcategories extends Controller_Website {

	public function before()
	{
		parent::before();
		$this->template->bind('content', $content);
		$this->template->categories = ORM::factory('category')->find_all();
	}

	public function action_view($uri)
	{
		Session::instance('database')->set('subcategory', ORM::factory('subcategory')->where('uri', '=', $uri)->find());
		$this->template->content = new View('subcategories/view');
		$subcategory = ORM::factory('subcategory')->where('uri', '=', $uri)->find();

		$offset = (Arr::get($_GET, 'page', 1) * 10) - 10;
		$this->pagination = new Pagination(array(
			// 'base_url'       => 'welcome/pagination_example/page/', // base_url will default to current uri
			'query_string'   => 'page', // pass a string as uri_segment to trigger former 'label' functionality
			'total_items'    => count($subcategory->posts->find_all()), // use db count query here of course
			'items_per_page' => 10, // it may be handy to set defaults for stuff like this in config/pagination.php
		));

		$this->template->content->posts = $subcategory->posts->limit(10)->offset($offset)->find_all();
		$this->template->content->subcategory = $subcategory;
		$this->template->content->categories = ORM::factory('category')->find_all();
		$this->template->content->pagination = $this->pagination->render();
	}

} // End Subcategories_Controller
