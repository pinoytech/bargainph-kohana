<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Users extends Controller_Website {

	public function before()
	{
		parent::before();
		$this->template->bind('content', $content);
		$this->template->categories = ORM::factory('category')->find_all();
	}

	public function action_facebook()
	{
		$this->template->content = new View('users/facebook');

		$facebook = Facebooko::instance();
		$me = $facebook->api('/me', 'GET');

		$user = ORM::factory('user')->where('email', '=', $me['email'])->find();

		if ( ! $user->loaded())
		{
			$user = ORM::factory('user');
			$user->username = hash_hmac('ripemd320', Text::random(), Kohana::config('auth_encryption.salt_pattern'));
			$user->password = hash_hmac('ripemd320', Text::random(), Kohana::config('auth_encryption.salt_pattern'));
			$user->email = $me['email'];
			$user->save();

			Session::instance('database')->set('user_id', $user->id);
			Session::instance('database')->set('from_facebook', TRUE);
		}
		else
		{
			Session::instance('database')->set('user_id', $user->id);
			Session::instance('database')->set('from_facebook', TRUE);
		}

		// Request::instance()->redirect('/');
	}

	public function action_send_password($random_string)
	{
		$this->template->content = new View('users/send_password');

		$fields['random_string'] = $random_string;

		$user = Validate::factory($fields)
			->rule('random_string', 'Model_User::valid_random_string', array($fields['random_string']));

		if ($user->check())
		{
			$user = ORM::factory('user')
				->where('random_string', '=', $random_string)
				->find();

			$user->password = hash_hmac('ripemd320', $user->tmp_password, Kohana::config('auth_encryption.salt_pattern'));
			$user->save();

			$view = new View('email/send_password');
			$view->user = $user;
			$email_body = (string) $view;

			try {
				Email::send($_POST['email'], 'noreply@bargainph.com', 'Your User details from BargainPH', $email_body, TRUE);
			}
			catch (Exception $e) {
				$to = $user->email;
				$subject = 'Your User details from BargainPH';
				$headers = "From: noreply@bargainph.com\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				mail($to, $subject, $email_body, $headers);
			}
		}
		else
		{
			$this->template->content->errors = $user->errors('reset_password');
		}
	}

	public function action_reset_password()
	{
		$this->template->content = new View('users/reset_password');

		$user = ORM::factory('user');
		$this->template->content->user = $user;
		$this->template->content->errors = array();

		if ($_POST)
		{
			$user = Validate::factory($_POST)
				->rules('email', array(
						'not_empty' => NULL,
						'email' => NULL,
						'Model_User::valid_email' => array($_POST['email'])
					)
			);

			if ($user->check())
			{
				$parsed_string = Kohana::config('passwords')->as_array();
				$random_string = $parsed_string[array_rand($parsed_string)];
				$tmp_password = $parsed_string[array_rand($parsed_string)];

				$user = ORM::factory('user')->where('email', '=', $_POST['email'])->find();
				$user->random_string = hash_hmac('ripemd320', Text::random(), Kohana::config('auth_encryption.salt_pattern'));
				$user->tmp_password = $tmp_password.Text::random();
				$user->save();

				$view = new View('email/reset_password');
				$view->user = $user;
				$email_body = (string) $view;

				try {
					Email::send($_POST['email'], 'noreply@bargainph.com', 'Recover your user details from BargainPH', $email_body, TRUE);
				}
				catch (Exception $e) {
					$to = $_POST['email'];
					$subject = 'Recover your user details from BargainPH';
					$headers = "From: noreply@bargainph.com\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					mail($to, $subject, $email_body, $headers);
				}

				Session::instance('database')->set('message', 'Details on how to reset your password has been sent to your email.');
				Request::instance()->redirect(Request::$referrer);
			}
			else
			{
				$this->template->content->errors = $user->errors('reset_password');
			}
		}
	}

	public function action_logout()
	{
		Session::instance('database')->delete('user_id');

		if (Session::instance('database')->get('from_facebook'))
		{
			$facebook = Facebooko::instance();
			Session::instance('database')->destroy();
			// Request::instance()->redirect($facebook->getLogoutUrl(array('next' => URL::site('/', TRUE))));
			// return;
		}

		Session::instance('database')->delete('user_id');
		Session::instance('database')->destroy();
		Session::instance('database')->set('message', "You've been logged out");
		Request::instance()->redirect('/');
	}

	public function action_login()
	{
		if (Session::instance('database')->get('user_id'))
		{
			Session::instance('database')->set('message', 'You are already logged in');
			Request::instance()->redirect('/');
		}

		$this->template->content = new View('users/login');

		$facebook = Facebooko::instance();

		$this->template->content->bind('login_url', $login_url);

		$login_url = $facebook->getLoginUrl(Kohana::config('facebooko.login_url'));	

		$user = ORM::factory('user');
		$this->template->content->user = $user;

		if ($_POST)
		{
			$post = Validate::factory($_POST)
						->filter(TRUE, 'trim')
						->rule('username', 'not_empty')
						->rule('password', 'not_empty')
						->rule('username', 'Model_User::valid_user', array(array($_POST['username'], $_POST['password'])));

			if ($post->check())
			{
				$logged_in_user = ORM::factory('user')
									->where('username', '=', $_POST['username'])
									->where('password', '=', hash_hmac('ripemd320', $_POST['password'], Kohana::config('auth_encryption.salt_pattern')))->find();

				Session::instance('database')->set('user_id', $logged_in_user->id);
				Session::instance('database')->set('message', 'You have successfully logged in');
				Request::instance()->redirect('/');
			}
			else
			{
				$this->template->content->errors = $post->errors('login_user');
			}
		}
		$this->template->content->categories = ORM::factory('category')->find_all();
	}

	public function action_register()
	{
		$this->template->content = new View('users/register');
		$new_user = ORM::factory('user');
		$this->template->content->user = $new_user;

		if ($_POST)
		{
			$new_user->values($_POST);
			$this->template->content->user = $new_user;
			if ($new_user->check())
			{
				$new_user->password = hash_hmac('ripemd320', $new_user->password, Kohana::config('auth_encryption.salt_pattern'));
				$new_user->save();
				Session::instance('database')->get('message', 'You have been registered');
				Request::instance()->redirect('users/login');
			}
			else
			{
				$this->template->content->errors = $new_user->validate()->errors('register_user');
			}

		}
		$this->template->content->categories = ORM::factory('category')->find_all();
	}

} // End Posts_Controller
