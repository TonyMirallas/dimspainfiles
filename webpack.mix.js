const mix = require('laravel-mix');
// require('./webpackconfig');
mix.disableNotifications();

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


// mix.js('resources/js/app.js', 'public/js')
// .webpackconfig()
// // .sourceMaps(false, 'source-map')
// .vue({ version: 3 })
// .sass('resources/sass/app.scss', 'public/css')

mix.js('resources/js/app.js', 'public/js')
.sourceMaps(false, 'source-map')
.webpackConfig(webpack => {
    return {
        devtool: 'source-map',
        // devtool: "inline-source-map",
        plugins: [
            new webpack.DefinePlugin({
                __VUE_OPTIONS_API__: true, // If you are using the options api.
                __VUE_PROD_DEVTOOLS__: false, // If you don't want people sneaking around your components in production.
            }),
        ],
    }
})
.vue({version: 3})

mix.sass('resources/sass/app.scss', 'public/css')