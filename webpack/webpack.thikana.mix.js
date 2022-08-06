const mix = require("laravel-mix");
require("laravel-mix-merge-manifest");

mix.js("resources/js/thikana/index.js", "public/js/app.js");
mix.react();

mix.postCss("resources/css/thikana/app.css", "public/css");
// mix.copyDirectory('resources/assets', 'public/assets');

mix.webpackConfig(webpack => {
    return {
        output: {
            publicPath: (process.env.APP_URL || "") + "/",
        },
        plugins: [
            new webpack.ProvidePlugin({
                $: "jquery",
                jQuery: "jquery",
                "window.jQuery": "jquery",
            }),
        ],
    };
});

mix.options({
    processCssUrls: false,
});

if (!mix.inProduction()) {
    mix.sourceMaps();
}

mix.version();
mix.disableSuccessNotifications();
mix.mergeManifest();
