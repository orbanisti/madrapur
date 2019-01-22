const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const devMode = process.env.NODE_ENV !== 'production';

module.exports  = {
    entry: {
        app: path.resolve(__dirname, './frontend/web/js/app.js'),
        style: path.resolve(__dirname, './frontend/web/css/style.less'),
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, './frontend/web/bundle'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: [/node_modules/],
                use: [
                    {
                        loader: 'babel-loader',
                        options: { presets: ['latest'] }
                    }
                ]
            },
            {
                test: /\.less$/,
                use: [
                	MiniCssExtractPlugin.loader,
                    {loader: 'css-loader', options: {minimize: true, sourceMap: true}},
                    {
                        loader: "less-loader",
                        options: {
                            minimize: true,
                            sourceMap: true
                        }
                    }
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "[name].css",
            chunkFilename: "[id].css"
        })
    ],
    devtool: 'source-map'
};
