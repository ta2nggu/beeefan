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
    .js('resources/js/creator.js', 'public/js')
    //21.03.23 김태영, 추가 timeline ajax 작성
    .js('resources/js/main.js', 'public/js')
    //21.03.25 김태영, 추가 owl carousel(timeline image slider)
    .js('resources/js/owl.carousel.js', 'public/js')
    .postCss('resources/css/owl.carousel.css', 'public/css')
    .postCss('resources/css/owl.theme.default.min.css', 'public/css')
    //21.04.02 kondo, 추가 style
    .sass('resources/sass/style.scss', 'public/css')
    .sass('resources/sass/style_creator.scss', 'public/css')
    .sass('resources/sass/style_admin.scss', 'public/css')
    .sass('resources/sass/style_user.scss', 'public/css')
    .js('resources/js/common.js', 'public/js');

