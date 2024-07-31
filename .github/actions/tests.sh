#!/bin/bash

set -e

npx cypress run  --headless --browser chrome  --config '{"specPattern":["plugins/generic/pluginTemplate/cypress/tests/functional/*.cy.js"]}'


