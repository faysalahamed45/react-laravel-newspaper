const mix = require("laravel-mix");
require("laravel-mix-merge-manifest");

mix.js("resources/js/classified/index.js", "public/js/classified");
mix.react();

mix.webpackConfig({
    output: {
        publicPath: (process.env.APP_URL || "") + "/",
    },
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
