var Encore = require('@symfony/webpack-encore');

Encore
// the project directory where all compiled assets will be stored
    .setOutputPath('src/Resources/public')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/bundles/dameertfrontendcms')
    .setManifestKeyPrefix('bundles/dameertfrontendcms-cms')
    // will create web/build/app.js and web/build/app.css
    .addEntry('frontend', './assets/js/frontend-editor.js')

    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

// create hashed filenames (e.g. app.abc123.css)
// .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();