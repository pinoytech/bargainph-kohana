<?php

class Facebooko_Base extends Facebook {

	protected static $_instance;

    public static function instance()
    {
        $facebook = Kohana::config('facebooko');

        if (self::$_instance == NULL) {
        	return self::$_instance = new FacebooKO(array(
                'appId'      => $facebook['app_id'],
                'secret'     => $facebook['secret']
            ));
        }
        return self::$_instance;
    }
}