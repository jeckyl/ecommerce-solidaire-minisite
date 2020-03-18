const autoprefixer = require('autoprefixer')
const purgecss = require('@fullhuman/postcss-purgecss')
const whitelister = require('purgecss-whitelister');

module.exports = {
    plugins: [
        autoprefixer(),
        purgecss({
            content: [
                './../*.html'
            ],
            whitelist: [
                'lazyloaded',
                // ...whitelister([
                //     './assets/sass/common/_syntax.scss',
                //     './assets/sass/components/_code.scss',
                // ]),
    ],
}),
],
}