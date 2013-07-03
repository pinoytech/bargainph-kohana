<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Posts extends Controller_Website {

	public function before()
	{
        parent::before();
        $this->template->bind('content', $content);
		$this->template->categories = ORM::factory('category')->find_all();
	}

	public function action_remove_image($uri)
	{
		$post = ORM::factory('user', Session::instance('database')->get('user_id'))->posts->where('uri', '=', $uri)->find_all();

		if ( ! (Session::instance('database')->get('user_id') AND $post->loaded()))
		{
			Session::instance('database')->set('message', 'You are not authorized to view that page');
			Request::instance()->redirect("/");
		}

		$this->_remove_image($post);

		Request::instance()->redirect(Request::$referrer);
	}

	protected function _remove_image($post)
	{
		( ! empty($post->image)) AND unlink("ad_images/{$post->image}");
		( ! empty($post->image)) AND unlink("ad_images/thumb/{$post->image}");

		$post->image = '';
		$post->save();
	}

	public function action_manage_remove_image($random_string)
	{
		$post = ORM::factory('post')->where('random_string', '=', $random_string)->find();

		if ( ! $post->loaded())
		{
			Session::instance('database')->set('message', 'You are not authorized to view that page');
			Request::instance()->redirect('/');
		}
		$this->_remove_image($post);

		Request::instance()->redirect(Request::$referrer);
	}

	public function action_destroy($uri)
	{
		$post = ORM::factory('user', Session::instance('database')->get('user_id'))->posts->where('uri', '=', $uri)->find();

		if ( ! (Session::instance('database')->get('user_id') AND $post->loaded()))
		{
			Session::instance('database')->set('message', 'You are not authorized to view that page');
			Request::instance()->redirect("/");
		}

		( ! empty($post->image)) AND unlink("ad_images/{$post->image}");
		( ! empty($post->image)) AND unlink("ad_images/thumb/{$post->image}");

		$post->delete();

		Request::instance()->redirect(Request::$referrer);
	}

	public function action_advertisements()
	{
		if (Session::instance('database')->get('user_id'))
		{
			$this->template->content = new View('posts/advertisements');
			$this->template->content->posts = ORM::factory('user', Session::instance('database')->get('user_id'))->posts->find_all();
		}
		else
		{
			Session::instance('database')->set('message', 'You are not authorized to view that page');
			Request::instance()->redirect("/");
		}
	}

	public function action_edit($uri)
	{
		$post = ORM::factory('user', Session::instance('database')->get('user_id'))->posts->where('uri', '=', $uri)->find();

		if ( ! (Session::instance('database')->get('user_id') AND $post->loaded()))
		{
			Session::instance('database')->set('message', 'You are not authorized to view that page');
			Request::instance()->redirect("/");
		}

		$this->template->content = new View('posts/edit');
		$this->template->content->post = $post;
		$this->template->content->categories = ORM::factory('category')->find_all();
		$this->template->content->subcategories = ORM::factory('subcategory')->find_all()->as_array('id', 'name');

		if ($_POST)
		{
			$post_validation = $post->check();

			if ($_FILES['userfile']['size'] > 0)
			{
				$file = Validate::factory($_FILES);
				$file->rule('userfile', 'Upload::type', array(array('jpg', 'gif', 'png', 'jpeg')));
				$file->rule('userfile', 'Upload::valid');
				$file_validation = $file->check();
				$this->template->content->file_errors = $file->errors('file_add');
			}
			else
			{
				$file_validation = TRUE;
			}

			$post->values($_POST);

			$this->template->content->post = $post;

			if ($post_validation AND $file_validation)
			{
				if ($file_validation AND $_FILES['userfile']['size'] > 0)
				{
					( ! empty($post->image)) AND unlink("ad_images/{$post->image}");
					( ! empty($post->image)) AND unlink("ad_images/thumb/{$post->image}");

					$image_location = basename($filepath = Upload::save($_FILES['userfile'], NULL, 'ad_images'));
					copy("ad_images/{$image_location}", "ad_images/thumb/{$image_location}");

					$image = Image::factory("ad_images/{$image_location}");
					$image->resize('380', NULL);
					$mark = Image::factory("images/watermark.gif");
					$image->watermark($mark, TRUE, TRUE);
					$image->save();


					$image = Image::factory("ad_images/thumb/{$image_location}");
					$image->resize('180', NULL);
					$image->save();

					$post->image = $image_location;
				}

				$post->save();
				Session::instance('database')->set('message', 'You\'re advertisement has been updated');
				Request::instance()->redirect(Request::$referrer);
			}
			else
			{
				$this->template->content->post_errors = $post->validate()->errors('post_add');
			}
		}
	}

	public function action_view($uri)
	{
		$this->template->content = new View('posts/view');
		$post = ORM::factory('post')->where("uri", "=", $uri)->find();

		$this->template->post = $post;

		$log = ORM::factory('log');
		$log->created_at = DB::expr('UTC_TIMESTAMP()');
		$log->ip_address = Request::$client_ip;
		$log->user_agent = Request::$user_agent;
		$log->referrer = Request::$referrer;
		$log->post = $post;
		$log->save();

		$this->template->content->post = $post;
	}

	public function action_search()
	{
		$this->template->content = new View('posts/search');
		$this->template->content->posts = array();
		$this->template->content->errors = array();
		$this->template->content->pagination = '';

		if ($_GET)
		{
			$get = Validate::factory($_GET)
					->filter(TRUE, 'trim')
					->rules('search',
						array(
							'not_empty'  => NULL,
							'min_length' => array(3)
						)
					);

			if ($get->check())
			{
				$offset = (Arr::get($_GET, 'page', 1) * 10) - 10;
				// $total_posts = $this->post->count_records(array('search' => $_GET['search']));
				$posts = ORM::factory('post')->where('title', 'LIKE', "%{$_GET['search']}%")->where('description', 'LIKE', "%{$_GET['search']}%")->find_all();
				$this->pagination = new Pagination(array(
					// 'base_url'       => 'welcome/pagination_example/page/', // base_url will default to current uri
					'query_string'   => 'page', // pass a string as uri_segment to trigger former 'label' functionality
					'total_items'    => count($posts), // use db count query here of course
					'items_per_page' => 10, // it may be handy to set defaults for stuff like this in config/pagination.php
				));

				$this->template->content->posts = ORM::factory('post')->limit(10)->offset($offset)->where('title', 'LIKE', "%{$_GET['search']}%")->or_where('description', 'LIKE', "%{$_GET['search']}%")->find_all();
				$this->template->content->pagination = $this->pagination->render();
			}
			else
			{
				$this->template->content->search_errors = $get->errors('post_search');
			}
		}
		$this->template->content->search = isset($_GET['search']) ? $_GET['search'] : '';
	}

	public function action_manage_destroy($random_string)
	{
		$post = ORM::factory('post')->where('random_string', '=', $random_string)->find();
		if ( ! $post->loaded())
		{
			Session::instance('database')->set('message', 'You are not authorized to view that page');
			Request::instance()->redirect('/');
		}

		foreach ($post->logs->find_all() as $log)
		{
			$log->delete();
		}

		$post->delete();

		Session::instance('database')->set('message', 'Your advertisement has been successfully deleted');
		Request::instance()->redirect('/');
	}

	public function action_manage($random_string)
	{
		$this->template->content = new View('posts/manage');
		$post = ORM::factory('post')->where('random_string', '=', $random_string)->find();

		if ( ! $post->loaded())
		{
			Session::instance('database')->set('message', 'You are not authorized to view that page');
			Request::instance()->redirect('/');
		}

		$this->template->content->post = $post;
		$this->template->content->categories = ORM::factory('category')->find_all();
		$this->template->content->subcategories = ORM::factory('subcategory')->find_all()->as_array('id', 'name');

		if ($_POST)
		{
			$post_validation = $post->check();

			if ($_FILES['userfile']['size'] > 0)
			{
				$file = Validate::factory($_FILES);
				$file->rule('userfile', 'Upload::type', array(array('jpg', 'gif', 'png', 'jpeg')));
				$file->rule('userfile', 'Upload::valid');
				$file_validation = $file->check();
				$this->template->content->file_errors = $file->errors('file_add');
			}
			else
			{
				$file_validation = TRUE;
			}

			$post->values($_POST);

			$this->template->content->post = $post;

			if ($post_validation AND $file_validation)
			{
				if ($file_validation AND $_FILES['userfile']['size'] > 0)
				{
					( ! empty($post->image)) AND unlink("ad_images/{$post->image}");
					( ! empty($post->image)) AND unlink("ad_images/thumb/{$post->image}");

					$image_location = basename($filepath = Upload::save($_FILES['userfile'], NULL, 'ad_images'));
					copy("ad_images/{$image_location}", "ad_images/thumb/{$image_location}");

					$image = Image::factory("ad_images/{$image_location}");
					$image->resize('380', NULL);
					$mark = Image::factory("images/watermark.gif");
					$image->watermark($mark, TRUE, TRUE);
					$image->save();


					$image = Image::factory("ad_images/thumb/{$image_location}");
					$image->resize('180', NULL);
					$image->save();

					$post->image = $image_location;
				}

				$post->save();
				Session::instance('database')->set('message', 'You\'re advertisement has been updated');
				Request::instance()->redirect(Request::$referrer);
			}
			else
			{
				$this->template->content->post_errors = $post->validate()->errors('post_add');
			}
		}
	}

	public function action_add()
	{
		$this->template->content = new View('posts/add');
		$this->template->content->post = ORM::factory('post');
		$this->template->content->categories = ORM::factory('category')->find_all();
		$this->template->content->subcategories = ORM::factory('subcategory')->find_all()->as_array('id', 'name');

		if ($_POST)
		{
			if (Session::instance('database')->get('user_id'))
			{
				$new_user = ORM::factory('user')->where("id", "=", Session::instance('database')->get('user_id'))->find();
			}

			$new_post = ORM::factory('post');
			$new_post->values($_POST);

			$this->template->content->post = $new_post;

			$post_validation = $new_post->check();

			if ($_FILES['userfile']['size'] > 0)
			{
				$file = Validate::factory($_FILES);
				$file->rule('userfile', 'Upload::type', array(array('jpg', 'gif', 'png', 'jpeg')));
				$file->rule('userfile', 'Upload::valid');
				$file_validation = $file->check();
				$this->template->content->file_errors = $file->errors('file_add');
			}
			else
			{
				$file_validation = TRUE;
			}

			if ($post_validation AND $file_validation)
			{
				if ($file_validation AND $_FILES['userfile']['size'] > 0)
				{
					$image_location = basename($filepath = Upload::save($_FILES['userfile'], NULL, 'ad_images'));
					copy("ad_images/{$image_location}", "ad_images/thumb/{$image_location}");

					$image = Image::factory("ad_images/{$image_location}");
					$image->resize('380', NULL);
					$mark = Image::factory("images/watermark.gif");
					$image->watermark($mark, TRUE, TRUE);
					$image->save();


					$image = Image::factory("ad_images/thumb/{$image_location}");
					$image->resize('180', NULL);
					$image->save();

					$new_post->image = $image_location;
				}

				if (Session::instance('database')->get('user_id'))
				{
					$new_post->user = $new_user;
				}

				$new_post->random_string = hash_hmac('ripemd320', Text::random(), Kohana::config('auth_encryption.salt_pattern'));
				$new_post->uri = url::title($_POST['title']) . '-' . text::random();
				$new_post->created_at = DB::expr('UTC_TIMESTAMP()');
				$new_post->save();

				if ( ! Session::instance('database')->get('user_id'))
				{
					$view = new View('email/non_registered_users_management_link');
					$view->post = $new_post;
					$email_body = (string) $view;
					try {
						Email::send($_POST['email'], 'noreply@bargainph.com', 'Advertisement details from BargainPH', $email_body, TRUE);
					}
					catch (Exception $e) {
						$to = $_POST['email'];
						$subject = 'Advertisement details from BargainPH';
						$headers = "From: noreply@bargainph.com\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
						mail($to, $subject, $email_body, $headers);
					}
				}

				Session::instance('database')->set('message', 'Your advertisement has been successfully posted');
				Request::instance()->redirect('posts/add');
			}
			else
			{
				$this->template->content->post_errors = $new_post->validate()->errors('post_add');
			}				
		}
	}
} // End Posts_Controller
