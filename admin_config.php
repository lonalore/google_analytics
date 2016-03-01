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
	 * Process submitted form data.
	 */
	function init()
	{
		if(isset($_POST['saveConfig']) && (int) $_POST['saveConfig'] === 1)
		{
			$prefs = e107::getPlugConfig('google_analytics');
			$prefs->set('account', varset($_POST['account'], ''))->save();
			$prefs->set('domain_mode', (int) vartrue($_POST['domain_mode'], 0))->save();
			$prefs->set('cross_domains', varset($_POST['cross_domains'], ''))->save();
			$prefs->set('visibility_pages', (int) vartrue($_POST['visibility_pages'], 0))->save();
			$prefs->set('pages', varset($_POST['pages'], ''))->save();
			$prefs->set('visibility_roles', (int) vartrue($_POST['visibility_roles'], 0))->save();
			$prefs->set('track_user_id', (int) vartrue($_POST['track_user_id'], 0))->save();
			$prefs->set('track_outbound', (int) vartrue($_POST['track_outbound'], 0))->save();
			$prefs->set('track_mailto', (int) vartrue($_POST['track_mailto'], 0))->save();
			$prefs->set('track_files', (int) vartrue($_POST['track_files'], 0))->save();
			$prefs->set('track_files_extensions', varset($_POST['track_files_extensions']))->save();
			$prefs->set('track_link_id', (int) vartrue($_POST['track_link_id'], 0))->save();
			$prefs->set('track_url_fragments', (int) vartrue($_POST['track_url_fragments'], 0))->save();
			$prefs->set('track_adsense', (int) vartrue($_POST['track_adsense'], 0))->save();
			$prefs->set('track_double_click', (int) vartrue($_POST['track_double_click'], 0))->save();
			$prefs->set('tracker_anonymize_ip', (int) vartrue($_POST['tracker_anonymize_ip'], 0))->save();
			$prefs->set('privacy_do_not_track', (int) vartrue($_POST['privacy_do_not_track'], 0))->save();
			$prefs->set('cache', (int) vartrue($_POST['cache'], 0))->save();
			$prefs->set('debug', (int) vartrue($_POST['debug'], 0))->save();
		}
	}


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

		// ---------- Panel: Web Property ID ----------
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


		// ---------- Panel: Domains ----------
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


		// ---------- Panel: Pages ----------
		$scVars = array(
			'title' => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_20,
			'body'  => '',
		);

		// Field: Add tracking to specific pages
		$sc->setVars(array(
			'id'      => $form->name2id('visibility_pages'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_24,
			'element' => $form->radio('visibility_pages', array(
				0 => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_21,
				1 => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_22,
			), vartrue($prefs['visibility_pages'], 0)),
			'help'    => '',
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		$sc->setVars(array(
			'id'      => $form->name2id('pages'),
			'label'   => '',
			'element' => $form->textarea('pages', vartrue($prefs['pages'], ''), 3, 80, array(
				'class' => 'form-control',
			)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_23,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Render panel.
		$sc->setVars($scVars);
		$elements .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENTS'], true, $sc);


		// ---------- Panel: User Classes ----------
		$scVars = array(
			'title' => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_04,
			'body'  => '',
		);

		// Field: Add tracking to specific pages
		$sc->setVars(array(
			'id'      => $form->name2id('visibility_roles'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_25,
			'element' => $form->userclass('visibility_roles', vartrue($prefs['visibility_roles'], 0)),
			'help'    => '',
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Render panel.
		$sc->setVars($scVars);
		$elements .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENTS'], true, $sc);


		// ---------- Panel: Users ----------
		$scVars = array(
			'title' => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_26,
			'body'  => '',
		);

		// Field: Add tracking to specific pages
		$sc->setVars(array(
			'id'      => $form->name2id('track_user_id'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_27,
			'element' => $form->checkbox('track_user_id', 1, (bool) vartrue($prefs['track_user_id'], false)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_28,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Render panel.
		$sc->setVars($scVars);
		$elements .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENTS'], true, $sc);


		// ---------- Panel: Links and Downloads ----------
		$scVars = array(
			'title' => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_05,
			'body'  => '',
		);

		// Field: Track clicks on outbound links
		$sc->setVars(array(
			'id'      => $form->name2id('track_outbound'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_29,
			'element' => $form->checkbox('track_outbound', 1, (bool) vartrue($prefs['track_outbound'], false)),
			'help'    => '',
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Field: Track clicks on mailto links
		$sc->setVars(array(
			'id'      => $form->name2id('track_mailto'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_30,
			'element' => $form->checkbox('track_mailto', 1, (bool) vartrue($prefs['track_mailto'], false)),
			'help'    => '',
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Field: Track downloads (clicks on file links) for the following extensions
		$sc->setVars(array(
			'id'      => $form->name2id('track_files'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_31,
			'element' => $form->checkbox('track_files', 1, (bool) vartrue($prefs['track_files'], false)),
			'help'    => '',
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Field: Track downloads (clicks on file links) for the following extensions
		$sc->setVars(array(
			'id'      => $form->name2id('track_files_extensions'),
			'label'   => '',
			'element' => $form->text('track_files_extensions', vartrue($prefs['track_files_extensions'], ''), 512),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_32,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Field: Track enhanced link attribution
		$sc->setVars(array(
			'id'      => $form->name2id('track_link_id'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_33,
			'element' => $form->checkbox('track_link_id', 1, (bool) vartrue($prefs['track_link_id'], false)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_34,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Field: Track changing URL fragments as pageviews
		$sc->setVars(array(
			'id'      => $form->name2id('track_url_fragments'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_35,
			'element' => $form->checkbox('track_url_fragments', 1, (bool) vartrue($prefs['track_url_fragments'], false)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_36,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Render panel.
		$sc->setVars($scVars);
		$elements .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENTS'], true, $sc);


		// ---------- Panel: Advertising ----------
		$scVars = array(
			'title' => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_06,
			'body'  => '',
		);

		// Field: Track AdSense ads
		$sc->setVars(array(
			'id'      => $form->name2id('track_adsense'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_37,
			'element' => $form->checkbox('track_adsense', 1, (bool) vartrue($prefs['track_adsense'], false)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_38,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Field: Track display features
		$sc->setVars(array(
			'id'      => $form->name2id('track_double_click'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_39,
			'element' => $form->checkbox('track_double_click', 1, (bool) vartrue($prefs['track_double_click'], false)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_40,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Render panel.
		$sc->setVars($scVars);
		$elements .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENTS'], true, $sc);


		// ---------- Panel: Privacy ----------
		$scVars = array(
			'title' => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_07,
			'body'  => '',
		);

		// Field: Anonymize visitors IP address
		$sc->setVars(array(
			'id'      => $form->name2id('tracker_anonymize_ip'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_41,
			'element' => $form->checkbox('tracker_anonymize_ip', 1, (bool) vartrue($prefs['tracker_anonymize_ip'], false)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_42,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Field: Universal web tracking opt-out
		$sc->setVars(array(
			'id'      => $form->name2id('privacy_do_not_track'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_43,
			'element' => $form->checkbox('privacy_do_not_track', 1, (bool) vartrue($prefs['privacy_do_not_track'], false)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_44,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Render panel.
		$sc->setVars($scVars);
		$elements .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENTS'], true, $sc);


		// ---------- Panel: Advanced settings ----------
		$scVars = array(
			'title' => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_45,
			'body'  => '',
		);

		// Field: Locally cache tracking code file
		/*
		$sc->setVars(array(
			'id'      => $form->name2id('cache'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_46,
			'element' => $form->checkbox('cache', 1, (bool) vartrue($prefs['cache'], false)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_47,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);
		*/

		// Field: Enable debugging
		$sc->setVars(array(
			'id'      => $form->name2id('debug'),
			'label'   => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_48,
			'element' => $form->checkbox('debug', 1, (bool) vartrue($prefs['debug'], false)),
			'help'    => LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_49,
		));
		$scVars['body'] .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENT'], true, $sc);

		// Render panel.
		$sc->setVars($scVars);
		$elements .= $tp->parseTemplate($tpl['ADMIN']['FORM_ELEMENTS'], true, $sc);


		// ---------- Render form ----------
		$scVars = array(
			'elements' => $elements,
			'actions'  => $form->submit('submit', LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_08),
		);
		$sc->setVars($scVars);

		$html = $form->open('', 'post', e_SELF);
		$html .= $form->hidden('saveConfig', 1);
		$html .= $tp->parseTemplate($tpl['ADMIN']['FORM'], true, $sc);
		$html .= $form->close();

		return $html;
	}
}


new google_analytics_admin();

require_once(e_ADMIN . "auth.php");
e107::getAdminUI()->runPage();
require_once(e_ADMIN . "footer.php");
exit;
