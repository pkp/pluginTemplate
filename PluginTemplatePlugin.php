<?php
/**
 * @file PluginTemplatePlugin.php
 *
 * Copyright (c) 2017-2026 Simon Fraser University
 * Copyright (c) 2017-2026 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class PluginTemplatePlugin
 * @brief Plugin class for the PluginTemplate plugin.
 */

namespace APP\plugins\generic\pluginTemplate;

use APP\core\Application;
use APP\plugins\generic\pluginTemplate\classes\FrontEnd\ArticleDetails;
use PKP\core\APIRouter;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\VueModal;
use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;

class PluginTemplatePlugin extends GenericPlugin
{
    private PluginTemplateSettingsController $controller;

    /** @copydoc GenericPlugin::register() */
    public function register($category, $path, $mainContextId = null): bool
    {
        $success = parent::register($category, $path, $mainContextId);

        if (Application::isUnderMaintenance()) {
            return $success;
        }

        if ($success && $this->getEnabled($mainContextId)) {
            // Display the publication statement on the article details page
            $articleDetails = new ArticleDetails($this);
            Hook::add('Templates::Article::Main', $articleDetails->addPublicationStatement(...));

            // Register the settings API controller
            $this->controller = new PluginTemplateSettingsController($this);

            Hook::add('APIHandler::endpoints::plugin', function (string $hookName, APIRouter $apiRouter): bool {
                $apiRouter->registerPluginApiControllers([
                    $this->controller,
                ]);
                return Hook::CONTINUE;
            });
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
     * @param \APP\core\Request $request
     * @param array $actionArgs
     */
    public function getActions($request, $actionArgs): array
    {
        $actions = parent::getActions($request, $actionArgs);

        if (!$this->getEnabled()) {
            return $actions;
        }

        $context = $request->getContext();
        $apiUrl = $request->getDispatcher()->url(
            $request,
            Application::ROUTE_API,
            $context->getPath(),
            $this->controller->getHandlerPath()
        );

        $form = new PluginTemplateSettingsForm($apiUrl);

        array_unshift($actions, new LinkAction(
            'settings',
            new VueModal(
                'PkpFormModal',
                [
                    'title' => $this->getDisplayName(),
                    'formConfig' => $form->getConfig(),
                    'getApiUrl' => $apiUrl,
                ]
            ),
            __('manager.plugins.settings'),
            null
        ));

        return $actions;
    }
}

