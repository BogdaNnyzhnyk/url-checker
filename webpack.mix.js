let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
    .css('resources/assets/css/app.css', 'public/css/app.css');
