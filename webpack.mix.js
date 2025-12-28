const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.postCss("resources/css/app.css", "public/css", [require("tailwindcss")]);

mix.ts('resources/js/app.tsx', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        postCss: [tailwindcss('./tailwind.config.js')],
    })
    .webpackConfig({
        resolve: {
            extensions: ['.tsx', '.ts', '.js'],
            alias: {
                '@': path.resolve(__dirname, 'resources/js'),
                '@blog': path.resolve(__dirname, 'resources/js/blog'),
                '@frontend': path.resolve(__dirname, 'resources/js/frontend'),
                'ziggy': path.resolve(__dirname, "vendor/tightenco/ziggy/dist") //path.resolve('vendor/tightenco/ziggy/dist'), // or 'vendor/tightenco/ziggy/dist/vue' if you're using the Vue plugin
            },
        }
    })
    .react();

if (mix.inProduction()) {
    mix.version();
}