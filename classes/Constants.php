<?php
/**
 * @file classes/Constants.php
 *
 * Copyright (c) 2017-2023 Simon Fraser University
 * Copyright (c) 2017-2023 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class Constants
 * @brief Constants used in this plugin.
 */

namespace APP\plugins\generic\pluginTemplate\classes;

class Constants
{
    /**
     * The file name of the settings template
     */
    public const SETTINGS_TEMPLATE = 'settings.tpl';

    /**
     * The name of the publication statement,
     * used to save to the database and to show on the front end.
     */
    public const PUBLICATION_STATEMENT = 'publicationStatement';
}
