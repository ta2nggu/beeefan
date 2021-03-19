const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [

    ])//21.03.09 김태영, postCss추가 css 파일 추가 하고 싶으면 이렇게
    .sass('resources/sass/app.scss', 'public/css')
    //21.03.14 김태영, 추가
    .js('resources/js/creator.js', 'public/js');
