<?php
/**
 * @defgroup plugins_generic_pluginTemplate
 */
/**
 * @file plugins/generic/pluginTemplate/index.php
 *
 * Copyright (c) 2014-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_pluginTemplate
 * @brief Wrapper for the Plugin Template plugin.
 *
 */
require_once('PluginTemplatePlugin.inc.php');
return new PluginTemplatePlugin();