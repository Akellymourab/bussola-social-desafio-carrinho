const { defineConfig } = require("cypress");

require('dotenv').config();

module.exports = defineConfig({
    e2e: {
        baseUrl: process.env.CYPRESS_BASE_URL,

        specPattern: 'cypress/e2e/**/*.cy.js',

        setupNodeEvents(on, config) {

        },
    },
});
