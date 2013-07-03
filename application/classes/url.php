<?php defined('SYSPATH') or die('No direct script access.');
// Just use this file in application/classes/url.php for a fix until 3.2.2 is out

class URL extends Kohana_URL {

	/**
	 * Fetches an absolute site URL based on a URI segment.
	 *
	 *     echo URL::site('foo/bar');
	 *
	 * @param   string  $uri        Site URI to convert
	 * @param   mixed   $protocol   Protocol string or [Request] class to use protocol from
	 * @param   boolean $index		Include the index_page in the URL
	 * @return  string
	 * @uses    URL::base
	 */
	public static function site($uri = '', $protocol = NULL, $index = TRUE)
	{
		// Chop off possible scheme, host, port, user and pass parts
		$path = preg_replace('~^[-a-z0-9+.]++://[^/]++/?~', '', trim($uri, '/'));

		if ( ! UTF8::is_ascii($path))
		{
			// Encode all non-ASCII characters, as per RFC 1738
			$path = preg_replace_callback('~([^/]+)~', 'URL::_rawurlencode_callback', $path);
		}

		// Concat the URL
		return URL::base($protocol, $index).$path;
	}

	/**
	 * Callback used for encoding all non-ASCII characters, as per RFC 1738
	 * Used by URL::site()
	 * 
	 * @param  array $matches  Array of matches from preg_replace_callback()
	 * @return string          Encoded string
	 */
	protected static function _rawurlencode_callback($matches)
	{
		return rawurlencode($matches[0]);
	}
}