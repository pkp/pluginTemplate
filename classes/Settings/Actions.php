<?php
/**
 * @file classes/Setings/Actions.php
 *
 * Copyright (c) 2017-2023 Simon Fraser University
 * Copyright (c) 2017-2023 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class Actions
 * @brief Settings actions class for this plugin.
 */

namespace APP\plugins\generic\pluginTemplate\classes\Settings;

use APP\core\Request;
use APP\plugins\generic\pluginTemplate\PluginTemplatePlugin;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\AjaxModal;

class Actions
{
    /** @var PluginTemplatePlugin */
    public PluginTemplatePlugin $plugin;

    /** @param PluginTemplatePlugin $plugin */
    public function __construct(PluginTemplatePlugin &$plugin)
    {
        $this->plugin = &$plugin;
    }

    /**
     * Add a settings action to the plugin's entry in the plugins list.
     *
     * @param Request $request
     * @param array $actionArgs
     * @param array $parentActions
     */
    public function execute(Request $request, array $actionArgs, array $parentActions): array
    {
        // Only add the settings action when the plugin is enabled
        if (!$this->plugin->getEnabled()) return $parentActions;

        // Create a LinkAction that will make a request to the
        // plugin's `manage` method with the `settings` verb.
        $router = $request->getRouter();

        $linkAction = new LinkAction(
            'settings',
            new AjaxModal(
                $router->url(
                    $request,
                    null,
                    null,
                    'manage',
                    null,
                    [
                        'verb' => 'settings',
                        'plugin' => $this->plugin->getName(),
                        'category' => 'generic'
                    ]
                ),
                $this->plugin->getDisplayName()
            ),
            __('manager.plugins.settings'),
            null
        );

        // Add the LinkAction to the existing actions.
        // Make it the first action to be consistent with
        // other plugins.
        array_unshift($parentActions, $linkAction);

        return $parentActions;
    }
}
