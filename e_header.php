<?php

/**
 * @file
 * Include JS files.
 */

$tp = e107::getParser();
$prefs = e107::getPlugConfig('google_analytics')->getPref();
$id = varset($prefs['account'], '');

$visibilityPages = google_analytics_visibility_pages();
$visibilityRoles = google_analytics_visibility_roles();

// 1. Check if the GA account number has a valid value.
// 2. Track page views based on visibility value.
// 3. TODO: Ignore pages visibility filter for 404 or 403 status codes.
if(preg_match('/^UA-\d+-\d+$/', $id) && $visibilityPages && $visibilityRoles)
{

	$debug = (int) varset($prefs['debug'], 0);
	$url_custom = '';

	// Add link tracking.
	$link_settings = array();

	if($track_outbound = (int) varset($prefs['track_outbound'], 1))
	{
		$link_settings['trackOutbound'] = $track_outbound;
	}

	if($track_mailto = (int) varset($prefs['track_mailto'], 1))
	{
		$link_settings['trackMailto'] = $track_mailto;
	}

	if(($track_download = (int) varset($prefs['track_files'], 1)) && ($trackfiles_extensions = varset($prefs['track_files_extensions'], '')))
	{
		$link_settings['trackDownload'] = $track_download;
		$link_settings['trackDownloadExtensions'] = $trackfiles_extensions;
	}

	if($track_domain_mode = (int) varset($prefs['domain_mode'], 0))
	{
		$link_settings['trackDomainMode'] = $track_domain_mode;
	}

	if($track_cross_domains = varset($prefs['cross_domains'], ''))
	{
		$link_settings['trackCrossDomains'] = preg_split('/(\r\n?|\n)/', $track_cross_domains);
	}

	if($track_url_fragments = (int) varset($prefs['track_url_fragments'], 0))
	{
		$link_settings['trackUrlFragments'] = $track_url_fragments;
		$url_custom = 'location.pathname + location.search + location.hash';
	}

	if(!empty($link_settings))
	{
		e107::js('settings', array('google_analytics' => $link_settings));

		// Add debugging code.
		if($debug)
		{
			e107::js('google_analytics', 'js/google_analytics.debug.js', 'jquery', 2);
		}
		else
		{
			e107::js('google_analytics', 'js/google_analytics.js', 'jquery', 2);
		}
	}

	// Build tracker code.
	$script = '(function(i,s,o,g,r,a,m){';
	$script .= 'i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){';
	$script .= '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),';
	$script .= 'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
	$script .= '})(window,document,"script",';

	// Which version of the tracking library should be used?
	$library_tracker_url = '//www.google-analytics.com/' . ($debug ? 'analytics_debug.js' : 'analytics.js');
	$library_cache_url = 'http:' . $library_tracker_url;

	$script .= '"' . $library_tracker_url . '"';
	$script .= ',"ga");';

	// Build the create only fields list.
	$create_only_fields = array('cookieDomain' => 'auto');

	// Domain tracking type.
	$cookie_domain = $_SERVER['HTTP_HOST'];
	$domain_mode = (int) varset($prefs['domain_mode'], 0);
	$googleanalytics_adsense_script = '';

	// Per RFC 2109, cookie domains must contain at least one dot other than the first. For hosts such as 'localhost'
	// or IP Addresses we don't set a cookie domain.
	if($domain_mode == 1 && count(explode('.', $cookie_domain)) > 2 && !is_numeric(str_replace('.', '', $cookie_domain)))
	{
		$create_only_fields = array_merge($create_only_fields, array('cookieDomain' => $cookie_domain));
		$googleanalytics_adsense_script .= 'window.google_analytics_domain_name = ' . $tp->toJSON($cookie_domain) . ';';
	}
	elseif($domain_mode == 2)
	{
		// Cross Domain tracking. 'autoLinker' need to be enabled in 'create'.
		$create_only_fields = array_merge($create_only_fields, array('allowLinker' => true));
		$googleanalytics_adsense_script .= 'window.google_analytics_domain_name = "none";';
	}

	// Track logged in users across all devices.
	if((int) varset($prefs['track_user_id'], 0) && USERID)
	{
		// The USERID value should be a unique, persistent, and non-personally identifiable string identifier that
		// represents a user or signed-in account across devices.
		$userID = google_analytics_hmac_base64(USERID, google_analytics_get_private_key()); // TODO: Salt private key.
		$create_only_fields['userId'] = $userID;
	}

	// Create a tracker.
	$script .= 'ga("create", ' . $tp->toJSON($id) . ', ' . $tp->toJSON($create_only_fields) . ');';

	// Prepare Adsense tracking.
	$googleanalytics_adsense_script .= 'window.google_analytics_uacct = ' . $tp->toJSON($id) . ';';

	// Add enhanced link attribution after 'create', but before 'pageview' send.
	// @see https://support.google.com/analytics/answer/2558867
	if((int) varset($prefs['track_link_id'], 0))
	{
		$script .= 'ga("require", "linkid", "linkid.js");';
	}

	// Add display features after 'create', but before 'pageview' send.
	// @see https://support.google.com/analytics/answer/2444872
	if((int) varset($prefs['track_double_click'], 0))
	{
		$script .= 'ga("require", "displayfeatures");';
	}

	// Domain tracking type.
	if($domain_mode == 2)
	{
		// Cross Domain tracking
		// https://developers.google.com/analytics/devguides/collection/upgrade/reference/gajs-analyticsjs#cross-domain
		$script .= 'ga("require", "linker");';
		$script .= 'ga("linker:autoLink", ' . $tp->toJSON($link_settings['trackCrossDomains']) . ');';
	}

	if((int) varset($prefs['tracker_anonymize_ip'], 1))
	{
		$script .= 'ga("set", "anonymizeIp", true);';
	}

	if(!empty($custom_var))
	{
		$script .= $custom_var;
	}

	if(!empty($url_custom))
	{
		$script .= 'ga("set", "page", ' . $url_custom . ');';
	}

	$script .= 'ga("send", "pageview");';

	if(!empty($message_events))
	{
		$script .= $message_events;
	}

	if((int) varset($prefs['track_adsense'], 0))
	{
		// Custom tracking. Prepend before all other JavaScript.
		// @TODO: https://support.google.com/adsense/answer/98142
		// sounds like it could be appended to $script.
		e107::js('inline', $googleanalytics_adsense_script, null, 1);
	}

	e107::js('inline', $script, null, 2);
}

/**
 * Based on visibility setting this function returns TRUE if GA code should be added to the current user class and
 * otherwise FALSE.
 */
function google_analytics_visibility_roles()
{
	$prefs = e107::getPlugConfig('google_analytics')->getPref();
	$class = (int) varset($prefs['visibility_roles'], 0);
	return check_class($class);
}

/**
 * Based on visibility setting this function returns TRUE if GA code should be added to the current page and otherwise
 * FALSE.
 */
function google_analytics_visibility_pages()
{
	$prefs = e107::getPlugConfig('google_analytics')->getPref();
	$cusPagePref = explode(PHP_EOL, varset($prefs['pages'], ''));

	$match = false;

	if(is_array($cusPagePref) && count($cusPagePref) > 0)
	{
		$c_url = str_replace(array('&amp;'), array('&'), e_REQUEST_URL);
		$c_url = rtrim(rawurldecode($c_url), '?');

		foreach($cusPagePref as $cusPage)
		{
			if($cusPage == 'FRONTPAGE' && ($c_url == SITEURL || rtrim($c_url, '/') == SITEURL . 'index.php'))
			{
				$match = true;
				break;
			}

			$matchPath = google_analytics_match_path($c_url, $cusPage);
			if(!empty($cusPage) && $matchPath)
			{
				$match = true;
				break;
			}
		}
	}

	// The listed pages only.
	if((int) varset($prefs['visibility_pages'], 0) === 1)
	{
		if($match === true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// Every page except the listed pages.
	if((int) varset($prefs['visibility_pages'], 0) === 0)
	{
		if($match === true)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	return false;
}

/**
 * Check if a path matches any pattern in a set of patterns.
 *
 * Example:
 * <code>
 * <?php
 * google_analytics_match_path('my/path/here', 'my/path/*'); // returns true
 * google_analytics_match_path('my/path/here', '*path*'); // returns true
 * ?>
 * </code>
 *
 * @param $path
 *   The path to match.
 * @param $patterns
 *   String containing a set of patterns separated by \n, \r or \r\n.
 *
 * @return bool
 *   Boolean value: TRUE if the path matches a pattern, FALSE otherwise.
 */
function google_analytics_match_path($path, $patterns)
{
	$path = str_replace(SITEURL, '', $path);
	$patterns = trim($patterns);
	$patterns = preg_quote($patterns, '/');
	$patterns = str_replace('*', '.*', $patterns);
	$patterns = str_replace('\.*', '.*', $patterns);
	$regexps = '/^(' . $patterns . ')$/';
	return (bool) preg_match($regexps, $path);
}

/**
 * Calculates a base-64 encoded, URL-safe sha-256 hmac.
 *
 * @param string $data
 *   String to be validated with the hmac.
 * @param string $key
 *   A secret string key.
 *
 * @return string
 *   A base-64 encoded sha-256 hmac, with + replaced with -, / with _ and
 *   any = padding characters removed.
 */
function google_analytics_hmac_base64($data, $key)
{
	// Casting $data and $key to strings here is necessary to avoid empty string results of the hash function if they
	// are not scalar values. As this function is used in security-critical contexts like token validation it is
	// important that it never returns an empty string.
	$hmac = base64_encode(hash_hmac('sha256', (string) $data, (string) $key, true));
	// Modify the hmac so it's safe to use in URLs.
	return strtr($hmac, array('+' => '-', '/' => '_', '=' => ''));
}

/**
 * Ensures the private key variable used to generate tokens is set.
 *
 * @return string
 *   The private key.
 */
function google_analytics_get_private_key()
{
	$prefs = e107::getPlugConfig('google_analytics')->getPref();
	$key = varset($prefs['private_key'], '');

	if(empty($key))
	{
		$key = google_analytics_random_key();
		e107::getPlugConfig('google_analytics')->set('private_key', $key)->save();
	}

	return $key;
}

/**
 * Returns a URL-safe, base64 encoded string of highly randomized bytes (over the full 8-bit range).
 *
 * @param $byte_count
 *   The number of random bytes to fetch and base64 encode.
 *
 * @return string
 *   The base64 encoded result will have a length of up to 4 * $byte_count.
 */
function google_analytics_random_key($byte_count = 32)
{
	return google_analytics_base64_encode(google_analytics_random_bytes($byte_count));
}

/**
 * Returns a URL-safe, base64 encoded version of the supplied string.
 *
 * @param $string
 *   The string to convert to base64.
 *
 * @return string
 */
function google_analytics_base64_encode($string)
{
	$data = base64_encode($string);
	// Modify the output so it's safe to use in URLs.
	return strtr($data, array('+' => '-', '/' => '_', '=' => ''));
}

/**
 * Returns a string of highly randomized bytes (over the full 8-bit range).
 *
 * This function is better than simply calling mt_rand() or any other built-in PHP function because it can return a
 * long string of bytes (compared to < 4 bytes normally from mt_rand()) and uses the best available pseudo-random source.
 *
 * @param $count
 *   The number of characters (bytes) to return in the string.
 *
 * @return string
 */
function google_analytics_random_bytes($count)
{
	static $random_state, $bytes, $has_openssl;

	$missing_bytes = $count - strlen($bytes);

	if($missing_bytes > 0)
	{
		// PHP versions prior 5.3.4 experienced openssl_random_pseudo_bytes() locking on Windows and rendered it
		// unusable.
		if(!isset($has_openssl))
		{
			$has_openssl = version_compare(PHP_VERSION, '5.3.4', '>=') && function_exists('openssl_random_pseudo_bytes');
		}

		// openssl_random_pseudo_bytes() will find entropy in a system-dependent way.
		if($has_openssl)
		{
			$bytes .= openssl_random_pseudo_bytes($missing_bytes);
		}

		// Else, read directly from /dev/urandom, which is available on many *nix systems and is considered
		// cryptographically secure.
		elseif($fh = @fopen('/dev/urandom', 'rb'))
		{
			// PHP only performs buffered reads, so in reality it will always read at least 4096 bytes. Thus, it costs
			// nothing extra to read and store that much so as to speed any additional invocations.
			$bytes .= fread($fh, max(4096, $missing_bytes));
			fclose($fh);
		}

		// If we couldn't get enough entropy, this simple hash-based PRNG will generate a good set of pseudo-random
		// bytes on any system. Note that it may be important that our $random_state is passed through hash() prior to
		// being rolled into $output, that the two hash() invocations are different, and that the extra input into the
		// first one - the microtime() - is prepended rather than appended. This is to avoid directly leaking
		// $random_state via the $output stream, which could allow for trivial prediction of further "random" numbers.
		if(strlen($bytes) < $count)
		{
			// Initialize on the first call. The contents of $_SERVER includes a mix of user-specific and system
			// information that varies a little with each page.
			if(!isset($random_state))
			{
				$random_state = print_r($_SERVER, true);
				if(function_exists('getmypid'))
				{
					// Further initialize with the somewhat random PHP process ID.
					$random_state .= getmypid();
				}
				$bytes = '';
			}

			do
			{
				$random_state = hash('sha256', microtime() . mt_rand() . $random_state);
				$bytes .= hash('sha256', mt_rand() . $random_state, true);
			}
			while(strlen($bytes) < $count);
		}
	}

	$output = substr($bytes, 0, $count);
	$bytes = substr($bytes, $count);

	return $output;
}
