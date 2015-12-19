<?php

/**
 * @file
 * Shortcodes for "google_analytics" plugin.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/google_analytics/languages/[LANGUAGE]/[LANGUAGE]_front.php
e107::lan('google_analytics', false, true);


/**
 * Class google_analytics_shortcodes.
 */
class google_analytics_shortcodes extends e_shortcode
{

	/**
	 * Store forum plugin preferences.
	 *
	 * @var array
	 */
	private $plugPrefs = array();


	/**
	 * Constructor.
	 */
	function __construct()
	{
		parent::__construct();
		// Get plugin preferences.
		$this->plugPrefs = e107::getPlugConfig('google_analytics')->getPref();
	}


	function sc_title()
	{
		return $this->var['title'];
	}


	function sc_body()
	{
		return $this->var['body'];
	}


	function sc_elements()
	{
		return $this->var['elements'];
	}


	function sc_actions()
	{
		return $this->var['actions'];
	}


	function sc_element_id()
	{
		return $this->var['id'];
	}


	function sc_element_label()
	{
		return $this->var['label'];
	}


	function sc_element()
	{
		return $this->var['element'];
	}


	function sc_help()
	{
		$tp = e107::getParser();
		return $tp->toHTML($this->var['help'], true, 'USER_BODY, emotes_off');
	}

}
