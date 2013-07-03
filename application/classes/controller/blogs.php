<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Blogs extends Controller_Website {

	public function before()
	{
        parent::before();
        $this->template->bind('content', $content);
	}

	public function action_index()
	{
		echo 'fsadfsdf';
		$this->template->content = new View('blogs/index');
		$blog = ORM::factory('blog');

		$offset = (Arr::get($_GET, 'page', 1) * 10) - 10;
		$this->pagination = new Pagination(array(
			// 'base_url'       => 'welcome/pagination_example/page/', // base_url will default to current uri
			'query_string'   => 'page', // pass a string as uri_segment to trigger former 'label' functionality
			'total_items'    => count($blog->find_all()), // use db count query here of course
			'items_per_page' => 10, // it may be handy to set defaults for stuff like this in config/pagination.php
		));

		$this->template->content->posts = $blog->limit(10)->offset($offset)->find_all();
		$this->template->content->pagination = $this->pagination->render();
		// $this->template->content->posts = ORM::factory('post')->find_all();
	}

	public function action_view($uri)
	{
		$this->template->content = new View('blogs/index');
		$blog = ORM::factory('blog')->where('uri', '=', $uri)->find();
		$this->template->post = $blog;
	}

} // End Blogs_Controller
