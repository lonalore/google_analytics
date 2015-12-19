<?php

/**
 * @file
 * Class installations to handle configuration forms on Admin UI.
 */

require_once('../../class2.php');

if(!getperms('P'))
{
	header('location:' . e_BASE . 'index.php');
	exit;
}

// [PLUGINS]/google_analytics/languages/[LANGUAGE]/[LANGUAGE]_admin.php
e107::lan('google_analytics', true, true);


/**
 * Class google_analytics_admin.
 */
class google_analytics_admin extends e_admin_dispatcher
{

	/**
	 * @var array
	 */
	protected $modes = array(
		'main' => array(
			'controller' => 'google_analytics_main_ui',
			'path'       => null,
		),
	);

	/**
	 * @var array
	 */
	protected $adminMenu = array(
		'main/config' => array(
			'caption' => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_01,
			'perm'    => 'P',
		),
	);

	/**
	 * @var string
	 */
	protected $menuTitle = LAN_PLUGIN_GOOGLE_ANALYTICS_NAME;

}


/**
 * Class google_analytics_main_ui.
 */
class google_analytics_main_ui extends e_admin_ui
{

	/**
	 * @var string
	 */
	protected $pluginTitle = LAN_PLUGIN_GOOGLE_ANALYTICS_NAME;


	/**
	 * Build a custom configuration form to handle plugin preferences.
	 */
	function configPage()
	{
		$tpl = e107::getTemplate('google_analytics');
		$sc = e107::getScBatch('google_analytics', true);
		$tp = e107::getParser();
		$form = e107::getForm();

		$prefs = e107::getPlugConfig('google_analytics')->getPref();

		// Rendered form elements.
		$elements = '';


		// Panel: Web Property ID.
		$scVars = array(
			'title' => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_02,
			'body'  => '',
		);

		// Field: Web Property ID.
		$sc->setVars(array(
			'id'      => $form->name2id('account'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_09,
			'element' => $form->text('account', vartrue($prefs['account'], ''), 80, array(
				'placeholder' => 'UA-'
			)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_10,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Render panel.
		$sc->setVars($scVars);
		$elements .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENTS'], true, $sc);


		// Panel: Domains.
		$scVars = array(
			'title' => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_03,
			'body'  => '',
		);

		// Field: What are you tracking?
		$sc->setVars(array(
			'id'      => $form->name2id('domain_mode'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_11,
			'element' => $form->radio('domain_mode', array(
				0 => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_12,
				1 => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_14,
				2 => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_16,
			), vartrue($prefs['domain_mode'], 0)),
			'help'    => implode("\n", array(
				LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_13,
				LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_15,
				LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_17,
			)),
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Field: List of top-level domains
		$sc->setVars(array(
			'id'      => $form->name2id('cross_domains'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_18,
			'element' => $form->textarea('cross_domains', vartrue($prefs['cross_domains'], ''), 3, 80, array(
				'class' => 'form-control',
			)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_19,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Render panel.
		$sc->setVars($scVars);
		$elements .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENTS'], true, $sc);


		// Render form.
		$scVars = array(
			'elements' => $elements,
			'actions'  => $form->submit('submit', LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_08),
		);
		$sc->setVars($scVars);
		$html = $tp->parseTemplate($tpl['ADMIN']['FORM'], true, $sc);

		return $html;
	}
}


new google_analytics_admin();

require_once(e_ADMIN . "auth.php");
e107::getAdminUI()->runPage();
require_once(e_ADMIN . "footer.php");
exit;
