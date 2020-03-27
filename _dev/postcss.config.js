const autoprefixer = require('autoprefixer')
const purgecss = require('@fullhuman/postcss-purgecss')
const whitelister = require('purgecss-whitelister');

module.exports = {
    plugins: [
        autoprefixer(),
        ...process.env.NODE_ENV === 'production' ?
            purgecss({
                content: [
                    './../*.html'
                ],
                whitelist: [
                    //'lazyloaded', 'fade', 'show', 'modal-backdrop'
                ],
            })
        : [],
    ],
}