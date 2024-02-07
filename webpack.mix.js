const mix = require('laravel-mix');
const webpackConfig = require('./webpack.config');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')

mix.extend('vuetify', new class {
    webpackConfig(config) {
        config.plugins.push(new VuetifyLoaderPlugin())
    }
})
mix.vuetify();
mix.webpackConfig(webpackConfig);

mix.js('resources/js/app.js', 'public/js')
    .vue();


