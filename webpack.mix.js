if (process.env.npm_config_project) {
    require(`${__dirname}/webpack/webpack.${process.env.npm_config_project}.mix.js`);
} else {
    require(`${__dirname}/webpack/webpack.thikana.mix.js`);
}
