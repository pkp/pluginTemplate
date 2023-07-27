/**
 * @file cypress/tests/functional/PluginTemplatePlugin.cy.js
 *
 * Copyright (c) 2014-2023 Simon Fraser University
 * Copyright (c) 2000-2023 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 */

describe('Plugin template plugin tests', function() {
	it('Sets up the testing environment', function() {
		cy.login('admin', 'admin', 'publicknowledge');

		cy.get('.app__nav a').contains('Website').click();
		cy.get('button[id="plugins-button"]').click();

		// Find and enable the plugin
		cy.get('input[id^="select-cell-plugintemplateplugin-enabled"]').click();
		cy.get('div:contains(\'The plugin "Plugin Template" has been enabled.\')');
	});
	it('Configures the plugin', function() {
		cy.login('admin', 'admin', 'publicknowledge');

		cy.get('.app__nav a').contains('Website').click();
		cy.get('button[id="plugins-button"]').click();

		cy.get('a[id^="component-grid-settings-plugins-settingsplugingrid-category-generic-row-plugintemplateplugin-settings-button-"]', {timeout: 20_000}).as('settings');
		cy.waitJQuery();
		cy.wait(2000);
		cy.get('@settings').click({force: true});
		cy.get('input[id^="publicationStatement-"]').clear().type('Test publication statement', {delay: 0});
		cy.get('form[id="pluginTemplateSettings"] button[id^="submitFormButton"]').click();
		cy.waitJQuery();
	});
	it('Tests the article view', function() {
		// Visit homepage
		cy.visit('/index.php/publicknowledge/article/view/mwandenga-signalling-theory');
		cy.get('p:contains("Test publication statement")');
	});
})

