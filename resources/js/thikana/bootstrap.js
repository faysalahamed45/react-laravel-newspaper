try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {
    console.log(e.message);
}

// const files = require.context('./components', true, /\.js$/i);
// console.log(files.keys()[0].split('/').pop().split('.')[0]);
