<?php
date_default_timezone_set('America/New_York');

class Util {
		
	public static function Hash($password) {
		$salt1 = 'a#*C9z_';
		$salt2 = '_^;cS6%a';
		return  hash('sha256', $salt1 . $password . $salt2);
	}

	public static function displayDateTime($dateTime) {
			// Sunday, March 9, 2008
		return date_format($dateTime, 'g:i F j, Y');
	}
		
	public static function DatabaseDateTime($dateTime) {
		// 2008-3-9 13:08:05
		return date_format($dateTime, 'Y-n-j G:i:s');
	}

	public static function JsonDate($dateTime) {
		// a JavaScript date parsable string
		// Mar 9, 2008
		return date_format($dateTime, 'M j, Y');
	}

	public static function JsonDateTime($dateTime) {
		// a JavaScript date parsable string
		// Mar 9, 2008 13:08:05
		return date_format($dateTime, 'M j, Y G:i:s');
	}
		
	public static function myUrlEncode($string) {    
		$entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
		$replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    	return str_replace($entities, $replacements, urlencode($string));
	}
}