<?php
/**
 * @file PluginTemplatePlugin.php
 *
 * Copyright (c) 2017-2023 Simon Fraser University
 * Copyright (c) 2017-2023 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class PluginTemplatePlugin
 * @brief Plugin class for the PluginTemplate plugin.
 */

namespace APP\plugins\generic\pluginTemplate;

use APP\core\Request;
use APP\plugins\generic\pluginTemplate\classes\FrontEnd\ArticleDetails;
use APP\plugins\generic\pluginTemplate\classes\Settings\Actions;
use APP\plugins\generic\pluginTemplate\classes\Settings\Manage;
use PKP\core\JSONMessage;
use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;

class PluginTemplatePlugin extends GenericPlugin
{
    /** @copydoc GenericPlugin::register() */
    public function register($category, $path, $mainContextId = null): bool
    {
        $success = parent::register($category, $path);

        if ($success && $this->getEnabled()) {
            // Display the publication statement on the article details page
            $articleDetails = new ArticleDetails($this);
            Hook::add('Templates::Article::Main', $articleDetails->addPublicationStatement(...));
        }

        return $success;
    }

    /**
     * Provide a name for this plugin
     *
     * The name will appear in the Plugin Gallery where editors can
     * install, enable and disable plugins.
     */
    public function getDisplayName(): string
    {
        return __('plugins.generic.pluginTemplate.displayName');
    }

    /**
     * Provide a description for this plugin
     *
     * The description will appear in the Plugin Gallery where editors can
     * install, enable and disable plugins.
     */
    public function getDescription(): string
    {
        return __('plugins.generic.pluginTemplate.description');
    }

    /**
     * Add a settings action to the plugin's entry in the plugins list.
     *
     * @param Request $request
     * @param array $actionArgs
     */
    public function getActions($request, $actionArgs): array
    {
        $actions = new Actions($this);
        return $actions->execute($request, $actionArgs, parent::getActions($request, $actionArgs));
    }

    /**
     * Load a form when the `settings` button is clicked and
     * save the form when the user saves it.
     *
     * @param array $args
     * @param Request $request
     */
    public function manage($args, $request): JSONMessage
    {
        $manage = new Manage($this);
        return $manage->execute($args, $request);
    }
}

// For backwards compatibility -- expect this to be removed approx. OJS/OMP/OPS 3.6
if (!PKP_STRICT_MODE) {
    class_alias('\APP\plugins\generic\pluginTemplate\PluginTemplatePlugin', '\PluginTemplatePlugin');
}
