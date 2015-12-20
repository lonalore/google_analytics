<?php

/**
 * @file
 * Templates for "google_analytics" plugin.
 */

// Template for custom configuration form to handle plugin preferences on Admin UI.
$GOOGLE_ANALYTICS_TEMPLATE['ADMIN']['FORM'] = '
{ELEMENTS}
<div class="actions">
	{ACTIONS}
</div>
';

// Form elements template.
$GOOGLE_ANALYTICS_TEMPLATE['ADMIN']['FORM_ELEMENTS'] = '
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			{TITLE}
		</h3>
	</div>
	<div class="panel-body">
		{BODY}
	</div>
</div>
';

// Form element template.
$GOOGLE_ANALYTICS_TEMPLATE['ADMIN']['FORM_ELEMENT'] = '
<div class="form-group">
	<label for="{ELEMENT_ID}" class="col-sm-2 control-label">
		{ELEMENT_LABEL}
	</label>
	<div class="col-sm-10">
		{ELEMENT}
		<p class="help-block">{HELP}</p>
	</div>
	<div class="clearfix"></div>
</div>
';
