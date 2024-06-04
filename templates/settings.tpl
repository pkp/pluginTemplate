{**
 * templates/settings.tpl
 *
 * Copyright (c) 2014-2023 Simon Fraser University
 * Copyright (c) 2003-2023 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Settings form for the pluginTemplate plugin.
 *}
<script>
	$(function() {ldelim}
		$('#pluginTemplateSettings').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form
	class="pkp_form"
	id="pluginTemplateSettings"
	method="POST"
	action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}"
>
	<!-- Always add the csrf token to secure your form -->
	{csrf}

	{fbvFormSection label="plugins.generic.pluginTemplate.publicationStatement"}
		{fbvElement
			type="text"
			id="{APP\plugins\generic\pluginTemplate\classes\Constants::PUBLICATION_STATEMENT}"
			value=${APP\plugins\generic\pluginTemplate\classes\Constants::PUBLICATION_STATEMENT}
			description="plugins.generic.pluginTemplate.publicationStatement.description"
		}
	{/fbvFormSection}
	{fbvFormButtons submitText="common.save"}
</form>
