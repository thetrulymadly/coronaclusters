/*
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     20 April 2020
 */

const mix = require('laravel-mix');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');

mix.webpackConfig({
    plugins: [
        new CleanWebpackPlugin({
            verbose: true,
            cleanStaleWebpackAssets: true,
            protectWebpackAssets: true,
            cleanOnceBeforeBuildPatterns: ['*/*', '!vendor/*', '!*/.gitignore', '!page-cache/*']
        })
    ]
});

mix.react('resources/js/app.js', 'public/js')
    .react('resources/js/corona.js', 'public/js')
    // .extract(['bootstrap', 'jquery', 'popper.js'])
    .sass('resources/sass/covid/covid_yeti.scss', 'public/css')
    .sass('resources/sass/covid/covid_sandstone.scss', 'public/css')
    .sass('resources/sass/covid/covid_superhero.scss', 'public/css')
    .sass('resources/sass/covid/covid_boldstrap.scss', 'public/css')
    .sass('resources/sass/covid/covid_default.scss', 'public/css')
    // .styles(['node_modules/@fortawesome/fontawesome-free/css/all.css'], 'public/css/vendor.css')
    .copy('node_modules/@google/markerclustererplus/dist/markerclustererplus.min.js', 'public/js')
    .copy('node_modules/select2/dist/css/select2.min.css', 'public/css')
    .copy('node_modules/select2/dist/js/select2.min.js', 'public/js')
    // .copy('node_modules/toastr/build/toastr.min.js', 'public/js')
    .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
    .copyDirectory('resources/images', 'public/images')
    .options({processCssUrls: true})
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}

mix.browserSync({
    proxy: 'corona.localhost'
});
