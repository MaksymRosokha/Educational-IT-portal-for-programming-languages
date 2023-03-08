let mix = require('laravel-mix');
let fs = require('fs');

let getFiles = function (dir) {
    return fs.readdirSync(dir).filter(file => {
        return fs.statSync(`${dir}/${file}`).isFile();
    });
};

getFiles('resources/css/').forEach(function (filePath) {
    mix.css('resources/css/' + filePath, 'public/css');
});


getFiles('resources/scss/').forEach(function (filePath) {
    mix.sass('resources/scss/' + filePath, 'public/css');
});

getFiles('resources/js/').forEach(function (filePath) {
    mix.js('resources/js/' + filePath, 'public/js').vue();
});