<?php

/**
 * @file plugins/generic/pluginTemplate/PluginTemplateSettingsController.php
 *
 * Copyright (c) 2017-2026 Simon Fraser University
 * Copyright (c) 2017-2026 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class PluginTemplateSettingsController
 *
 * @brief API controller for PluginTemplate plugin settings
 */

namespace APP\plugins\generic\pluginTemplate;

use APP\plugins\generic\pluginTemplate\classes\Constants;
use APP\plugins\generic\pluginTemplate\formRequests\EditPluginTemplateSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PKP\plugins\PluginSettingsController;

class PluginTemplateSettingsController extends PluginSettingsController
{
    public function get(Request $illuminateRequest): JsonResponse
    {
        $contextId = $this->getRequest()->getContext()->getId();

        return response()->json(
            [Constants::PUBLICATION_STATEMENT => $this->plugin->getSetting($contextId, Constants::PUBLICATION_STATEMENT) ?? ''],
            Response::HTTP_OK
        );
    }

    public function edit(EditPluginTemplateSettings $illuminateRequest): JsonResponse
    {
        $contextId = $this->getRequest()->getContext()->getId();
        $publicationStatement = $illuminateRequest->validated()[Constants::PUBLICATION_STATEMENT];

        $this->plugin->updateSetting($contextId, Constants::PUBLICATION_STATEMENT, $publicationStatement);

        return response()->json(
            [Constants::PUBLICATION_STATEMENT => $publicationStatement],
            Response::HTTP_OK
        );
    }
}
