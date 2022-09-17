const mix = require('laravel-mix');
const path = require('path');
const {extract} = require("laravel-mix");

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
mix.alias({ziggy: path.resolve('vendor/tightenco/ziggy/vue')});
mix.ts('resources/js/app.ts', 'public/js')
    .vue({version: 3})
    .extract(['ziggy-js', 'lodash'])
    .sass('resources/sass/app.scss', 'public/css');
