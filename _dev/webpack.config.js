const path = require('path');
const UnCSSPlugin = require('uncss-webpack-plugin');


module.exports = {
    // watch: true,

    entry: {
        app: ['./js/app.js','./css/app.scss']

    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, '../assets'),

    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].css',
                        }
                    },
                    {
                        loader: 'extract-loader'
                    },
                    {
                        loader: 'css-loader?-url'
                    },
                    {
                        loader: 'postcss-loader',
                    },
                    {
                        loader: 'sass-loader'
                    }
                ]
            }
        ]
    }
    // externals: {
    //     $: '$',
    //     jquery: 'jQuery',

    // }
};