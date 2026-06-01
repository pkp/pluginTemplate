<?php

/**
 * @file plugins/generic/pluginTemplate/formRequests/EditPluginTemplateSettings.php
 *
 * Copyright (c) 2017-2026 Simon Fraser University
 * Copyright (c) 2017-2026 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class EditPluginTemplateSettings
 *
 * @brief Handle validation for updating PluginTemplate plugin settings
 */

namespace APP\plugins\generic\pluginTemplate\formRequests;

use APP\plugins\generic\pluginTemplate\classes\Constants;
use Illuminate\Foundation\Http\FormRequest;

class EditPluginTemplateSettings extends FormRequest
{
    public function rules(): array
    {
        return [
            Constants::PUBLICATION_STATEMENT => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }
}
