const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSingleRuntimeChunk()
    .enableSourceMaps(!Encore.isProduction())
    // .enableVersioning(Encore.isProduction())
    .addEntry('app-script', './assets/js/app.js')
    .enableSassLoader()
    .addStyleEntry('app-style', './assets/scss/global.scss')


// uncomment for legacy applications that require $/jQuery as a global variable
// .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();