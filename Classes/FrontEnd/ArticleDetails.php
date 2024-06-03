<?php
/**
 * @file Classes/FrontEnd/ArticleDetails.php
 *
 * Copyright (c) 2017-2023 Simon Fraser University
 * Copyright (c) 2017-2023 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class ArticleDetails
 * @brief Front end article details page class for the plugin.
 */

namespace APP\plugins\generic\pluginTemplate\Classes\FrontEnd;

use APP\core\Application;
use APP\plugins\generic\pluginTemplate\Classes\Constants;
use APP\plugins\generic\pluginTemplate\PluginTemplatePlugin;
use PKP\core\PKPString;

class ArticleDetails
{
    /** @var PluginTemplatePlugin */
    public PluginTemplatePlugin $plugin;

    /** @param PluginTemplatePlugin $plugin */
    public function __construct(PluginTemplatePlugin &$plugin)
    {
        $this->plugin = &$plugin;
    }

    /**
     * Add the publication statement to the article details page.
     *
     * @param array $params [[
     * @option array Additional parameters passed with the hook
     * @option TemplateManager
     * @option string The HTML output
     * ]]
     */
    public function addPublicationStatement(string $hookName, array $params): bool
    {
        // Get the publication statement for this journal or press
        $context = Application::get()->getRequest()->getContext();
        $publicationStatement = $this->plugin->getSetting($context->getId(), Constants::settingsNamePublicationStatement);

        // Do not modify the output if there is no publication statement
        if (!$publicationStatement) {
            return false;
        }

        // Add the publication statement to the output
        $output = &$params[2];
        $output .= '<p class="publication-statement">' . PKPString::stripUnsafeHtml($publicationStatement) . '</p>';

        return false;
    }
}