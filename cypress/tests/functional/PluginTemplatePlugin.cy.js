/**
 * @file cypress/tests/functional/PluginTemplatePlugin.cy.js
 *
 * Copyright (c) 2014-2026 Simon Fraser University
 * Copyright (c) 2000-2026 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 */

describe('Plugin template plugin tests', function() {
	it('Sets up the testing environment', function() {
		cy.login('admin', 'admin', 'publicknowledge');

		cy.get('nav').contains('Settings').click();
		cy.get('nav').contains('Website').click({force: true});
		cy.get('button[id="plugins-button"]').click();

		// Find and enable the plugin
		cy.get('input[id^="select-cell-plugintemplateplugin-enabled"]').click();
		cy.get('div:contains(\'The plugin "Plugin Template" has been enabled.\')');
	});
	it('Configures the plugin', function() {
		cy.login('admin', 'admin', 'publicknowledge');

		cy.get('nav').contains('Settings').click();
		cy.get('nav').contains('Website').click({force: true});
		cy.get('button[id="plugins-button"]').click();

		cy.get('a[id^="component-grid-settings-plugins-settingsplugingrid-category-generic-row-plugintemplateplugin-settings-button-"]', {timeout: 20_000}).as('settings');
		cy.waitJQuery();
		cy.wait(2000);
		cy.get('@settings').click({force: true});

		// Wait for the Vue.js side modal to appear
		cy.get('[role="dialog"]').should('be.visible');

		// Fill in the publication statement field
		cy.get('[role="dialog"]').within(() => {
			cy.get('input[name="publicationStatement"]').clear().type('Test publication statement', {delay: 0});
			cy.get('button:contains("Save")').click();
		});

		// Wait for the modal to close
		cy.get('[role="dialog"]').should('not.exist');
	});
	it('Tests the article view', function() {
		// Visit homepage
		cy.visit('/index.php/publicknowledge/article/view/mwandenga-signalling-theory');
		cy.get('p:contains("Test publication statement")');
	});
})
