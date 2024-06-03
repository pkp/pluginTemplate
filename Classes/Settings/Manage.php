<?php
/**
 * @file Classes/Setings/Manage.php
 *
 * Copyright (c) 2017-2023 Simon Fraser University
 * Copyright (c) 2017-2023 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class Manage
 * @brief Settings show and saving class for this plugin.
 */

namespace APP\plugins\generic\pluginTemplate\Classes\Settings;

use APP\core\Request;
use APP\plugins\generic\pluginTemplate\PluginTemplatePlugin;
use PKP\core\JSONMessage;

class Manage
{
    /** @var PluginTemplatePlugin */
    public PluginTemplatePlugin $plugin;

    /** @param PluginTemplatePlugin $plugin */
    public function __construct(PluginTemplatePlugin &$plugin)
    {
        $this->plugin = &$plugin;
    }

    /**
     * Load a form when the `settings` button is clicked and
     * save the form when the user saves it.
     *
     * @param array $args
     * @param Request $request
     */
    public function execute(array $args, Request $request): JSONMessage
    {
        switch ($request->getUserVar('verb')) {
            case 'settings':

                // Load the custom form
                $form = new SettingsForm($this->plugin);

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

        return new JSONMessage(false);
    }
}