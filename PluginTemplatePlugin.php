<?php

/**
 * @file PluginTemplatePlugin.inc.php
 *
 * Copyright (c) 2017-2023 Simon Fraser University
 * Copyright (c) 2017-2023 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class PluginTemplatePlugin
 * @brief Plugin class for the PluginTemplate plugin.
 */

namespace APP\plugins\generic\pluginTemplate;

use APP\core\Application;
use APP\core\Request;
use PKP\core\JSONMessage;
use PKP\core\PKPString;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\AjaxModal;
use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;

class PluginTemplatePlugin extends GenericPlugin
{

    /**
     * @copydoc GenericPlugin::register()
     */
    public function register($category, $path, $mainContextId = NULL)
    {
        $success = parent::register($category, $path);
        if ($success && $this->getEnabled()) {
            // Display the publication statement on the article details page
            Hook::add('Templates::Article::Main', [$this, 'addPublicationStatement']);
        }
        return $success;
    }

    /**
     * Provide a name for this plugin
     *
     * The name will appear in the Plugin Gallery where editors can
     * install, enable and disable plugins.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return __('plugins.generic.pluginTemplate.displayName');
    }

    /**
     * Provide a description for this plugin
     *
     * The description will appear in the Plugin Gallery where editors can
     * install, enable and disable plugins.
     *
     * @return string
     */
    public function getDescription()
    {
        return __('plugins.generic.pluginTemplate.description');
    }

    /**
     * Enable the settings form in the site-wide plugins list
     *
     * @return boolean
     */
    public function isSitePlugin()
    {
        return true;
    }

    /**
     * Add a settings action to the plugin's entry in the
     * plugins list.
     *
     * @param Request $request
     * @param array $actionArgs
     * @return array
     */
    public function getActions($request, $actionArgs)
    {

        // Get the existing actions
        $actions = parent::getActions($request, $actionArgs);

        // Only add the settings action when the plugin is enabled
        if (!$this->getEnabled()) {
            return $actions;
        }

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
                        'plugin' => $this->getName(),
                        'category' => 'generic'
                    ]
                ),
                $this->getDisplayName()
            ),
            __('manager.plugins.settings'),
            null
        );

        // Add the LinkAction to the existing actions.
        // Make it the first action to be consistent with
        // other plugins.
        array_unshift($actions, $linkAction);

        return $actions;
    }

    /**
     * Load a form when the `settings` button is clicked and
     * save the form when the user saves it.
     *
     * @param array $args
     * @param Request $request
     * @return JSONMessage
     */
    public function manage($args, $request)
    {
        switch ($request->getUserVar('verb')) {
            case 'settings':

                // Load the custom form
                $form = new PluginTemplateSettingsForm($this);

                // Fetch the form the first time it loads, before
                // the user has tried to save it
                if (!$request->getUserVar('save')) {
                    $form->initData();
                    return new JSONMessage(true, $form->fetch($request));
                }

                // Validate and save the form data
                $form->readInputData();
                if ($form->validate()) {
                    $form->execute();
                    return new JSONMessage(true);
                }
        }
        return parent::manage($args, $request);
    }

    /**
     * Add the publication statement to the article details page.
     *
     * @param string $hookName string
     * @param array $params [[
     *     @option array Additional parameters passed with the hook
     *     @option TemplateManager
     *     @option string The HTML output
     * ]]
     * @return boolean
     */
    public function addPublicationStatement($hookName, $params)
    {

        // Get the publication statement for this journal or press
        $context = Application::get()->getRequest()->getContext();
        $contextId = $context ? $context->getId() : Application::CONTEXT_SITE;
        $publicationStatement = $this->getSetting($contextId, 'publicationStatement');

        // If the journal or press does not have a publication statement,
        // check if there is one saved for the site.
        if (!$publicationStatement && $contextId !== Application::CONTEXT_SITE) {
            $publicationStatement = $this->getSetting(Application::CONTEXT_SITE, 'publicationStatement');
        }

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
