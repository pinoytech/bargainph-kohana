<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_User extends ORM{

	protected $_has_many = array('posts' => array());

	protected $_rules = array(
				'username' => array(
					'not_empty' => NULL
				),
				'email' =>  array(
					'not_empty' => NULL,
					'email'     => NULL,
				),
				'password' =>  array(
					'not_empty'  => NULL,
					'min_length' => array(6),
				)
			);

	protected $_callbacks = array(
				'email' => array('email_available'),
				'username' => array('username_available')
			);

	public static function valid_random_string($random_string)
	{
		$valid_random_string = (bool) DB::select(array('COUNT("*")', 'total_users'))
				->from('users')
				->where('random_string', '=', $random_string)
				->execute()
				->get('total_users');

		return $valid_random_string ? TRUE : FALSE;
	}

	public static function valid_email($email)
	{
		$valid_email = (bool) DB::select(array('COUNT("*")', 'total_users'))
				->from('users')
				->where('email', '=', $email)
				->execute()
				->get('total_users');

		return $valid_email ? TRUE : FALSE;
	}

	public static function valid_user($array, $fields)
	{
		$valid_user = (bool) DB::select(array('COUNT("*")', 'total_users'))
				->from('users')
				->where('username', '=', $fields[0])
				->where('password', '=', hash_hmac('ripemd320', $fields[1], Kohana::config('auth_encryption.salt_pattern')))
				->execute()
				->get('total_users');

		if ($valid_user)
		{
			return TRUE;
		}
		// return TRUE;
		return FALSE;
	}

	public function email_available(Validate $array, $field)
	{
		if ($this->unique_key_exists($array[$field])) {
			$array->error($field, 'email_available', array($array[$field]));
		}
	}

	public function username_available(Validate $array, $field)
	{
		if ($this->unique_key_exists($array[$field])) {
			$array->error($field, 'username_available', array($array[$field]));
		}
	}

	/**
	 * Tests if a unique key value exists in the database
	 *
	 * @param   mixed        value  the value to test
	 * @return  boolean
	 */
	public function unique_key_exists($value)
	{
		return (bool) DB::select(array('COUNT("*")', 'total_count'))
						->from($this->_table_name)
						->where($this->unique_key($value), '=', $value)
						->execute($this->_db)
						->get('total_count');
	}
 
	/**
	 * Allows a model use both email and username as unique identifiers for login
	 *
	 * @param  string    $value   unique value
	 * @return string             field name
	 */
	public function unique_key($value)
	{
		return Validate::email($value) ? 'email' : 'username';
	}

} // End User_Model