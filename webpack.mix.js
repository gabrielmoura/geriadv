const mix = require('laravel-mix');
//const path = require('path');
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
/*
const {exec} = require('child_process');

mix.extend('ziggy', new class {
    register(config = {}) {
        this.watch = config.watch ?? ['routes/**.php'];
        this.path = config.path ?? '';
        this.enabled = config.enabled ?? !Mix.inProduction();
    }

    boot() {
        if (!this.enabled) return;

        const command = () => exec(
            `php artisan ziggy:generate ${this.path}`,
            (error, stdout, stderr) => console.log(stdout)
        );

        command();

        if (Mix.isWatching() && this.watch) {
            ((require('chokidar')).watch(this.watch))
                .on('change', (path) => {
                    console.log(`${path} changed...`);
                    command();
                });
        }
        ;
    }
}()); */


mix.webpackConfig(webpack => {
    return {
        plugins: [
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                'window.jQuery': 'jquery',
                Popper: ['popper.js', 'default'],
            })
        ],
        resolve: {
            alias: {
                'jquery': path.join(__dirname, 'node_modules/jquery/dist/jquery'),
               // ziggy: path.resolve('vendor/tightenco/ziggy/dist'),
            }
        }
    };
});







mix.js('resources/js/app.js', 'public/js')

    //.js('node_modules/jquery-mask-plugin', 'public')

    .sass('resources/sass/app.scss', 'public/css')
    .copy('resources/css/front', 'public/css/front')
    .copy('resources/js/front', 'public/js/front')
    .copy('node_modules/tinymce/skins', 'public/js/skins')
    .copy('resources/js/web-push1/sw.js','public/sw.js')
    .copy('resources/js/web-push1/main.js','public/js/webPush.js')
    .styles(['resources/css/client.css'],'public/css/client.css')
    .sass('resources/sass/rtl.scss', 'public/css')
    //.purgeCss()
    .copyDirectory('resources/static/images', 'public/images')
    .copyDirectory('resources/static/icons', 'public/icons')
    .copy('resources/static/fonts/icons/fontawesome', 'public/fonts')
    .copy('resources/static/fonts/icons/front', 'public/fonts')
    .browserSync(process.env.APP_URL)
    .version()
    .extract(['jquery','toastr','tinymce','datatables.net','jquery-datetimepicker','bootstrap-v4-rtl','bootstrap-toggle'])
   // .ziggy()
    .sourceMaps();

