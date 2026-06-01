<?php

/**
 * @file plugins/generic/pluginTemplate/PluginTemplateSettingsForm.php
 *
 * Copyright (c) 2017-2026 Simon Fraser University
 * Copyright (c) 2017-2026 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class PluginTemplateSettingsForm
 *
 * @brief Form component for PluginTemplate plugin settings
 */

namespace APP\plugins\generic\pluginTemplate;

use APP\plugins\generic\pluginTemplate\classes\Constants;
use PKP\components\forms\FieldText;
use PKP\components\forms\FormComponent;

class PluginTemplateSettingsForm extends FormComponent
{
    public $id = 'pluginTemplateSettings';
    public $method = 'PUT';

    public function __construct(string $action)
    {
        $this->action = $action;

        $this->addField(new FieldText(Constants::PUBLICATION_STATEMENT, [
            'label' => __('plugins.generic.pluginTemplate.publicationStatement'),
            'description' => __('plugins.generic.pluginTemplate.publicationStatement.description'),
            'value' => '',
        ]));
    }
}
