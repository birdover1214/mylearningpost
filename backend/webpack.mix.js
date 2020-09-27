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

mix
   //ビルドしたsassをbuildディレクトリへ出力
   .sass('resources/assets/sass/app.scss', '../resources/assets/build/css/')
   // .sass('resources/assets/sass/layouts/_mixins.scss', '../resources/assets/build/css/')
   // .sass('resources/assets/sass/layouts/_layout.scss', '../resources/assets/build/css/')

   //publicディレクトリへまとめて出力
   .styles(
      [
         'resources/assets/build/css/app.css',
         // 'resources/assets/build/css/_mixins.css',
         // 'resources/assets/build/css/_layout.css',
      ],
      'public/css/app.css'
   )

   .js(
      [
         'resources/assets/js/app.js',
         'resources/assets/js/bootstrap.js',
         'resources/assets/js/layouts/layout.js',
      ],
      'public/js/app.js'
   )
