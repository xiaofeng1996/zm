var webpack = require('webpack');
var jquery = require('jquery');

const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// for api
elixir(mix => {

    Elixir.webpack.mergeConfig({
        resolveLoader: {
            // root: path.join(__dirname, 'node_modules'),
            root: './node_modules'
        },
        module: {
            loaders: [
                {
                    test: /\.css$/,
                    loader: 'style!css'
                },
                // {
                //     test: require.resolve('jquery'), 
                //     loader: 'expose?$!expose?jQuery!'
                // },
            ],
        },
        plugins: [
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: "jquery"
            })
        ]
    });

    mix.webpack('api/app.js', './public/js/api')
        .webpack('web/app.js', './public/js/web')
        .webpack('admin/app.js', './public/js/admin')
        .version([
            'js/api/app.js',
            'js/web/app.js',
            'js/admin/app.js',
            'doc/js/config/config.js', 
            'doc/js/config/host.js',
            'doc/css/main.css'
        ]);
});

