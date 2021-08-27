let mix = require('laravel-mix')

mix
    .setPublicPath('dist')
/*    .options({
        processCssUrls: false
    })*/
/*    .sourceMaps()
    .webpackConfig({
        devtool: 'inline-source-map'
    })*/
    .js('resources/js/field.js', 'js')
    .sass('resources/sass/field.scss', 'css')
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery'],
    })
/*    .copy(
        'node_modules/@fortawesome/fontawesome-free/webfonts',
        'public/fonts/vendor/@fortawesome/fontawesome-free/'
    )*/
/* .version()
 .copy([
     'node_modules/jstree/dist/themes/default/!*.png',
     'node_modules/jstree/dist/themes/default/!*.gif'
 ], 'dist/css/images/vendor/jstree/dist/themes/default')*/
