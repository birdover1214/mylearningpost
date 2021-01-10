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
   .sass('resources/assets/sass/app.scss', '../resources/assets/build/css/')

   .styles(
      [
         'resources/assets/build/css/app.css',
      ],
      'public/css/app.css'
   )

   .js(
      [
         'resources/assets/js/app.js',
         'resources/assets/js/main.js',
         'resources/assets/js/checkbox.js',
         'resources/assets/js/layouts/layout.js',
         'resources/assets/js/mypage/mypage.js',
         'resources/assets/js/mypage/edit.js',
         'resources/assets/js/posts/post.js',
      ],
      'public/js/user/app.js'
      )

   .js(
      [
         'resources/assets/js/app.js',
         'resources/assets/js/layouts/layout.js',
         'resources/assets/js/admin/edit.js',
      ],
      'public/js/admin/app.js'
   )
      
   //chart.js
   .js(
      [
         'resources/assets/js/show_chart.js',
   ],
      'public/js/chart.js'
   )

   //textCounter.js
   .js(
      [
         'resources/assets/js/text_counter.js',
   ],
      'public/js/counter.js'
   )

   .sourceMaps()
   .js('node_modules/popper.js/dist/popper.js', 'public/js').sourceMaps();
