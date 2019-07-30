const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const devMode = process.env.NODE_ENV !== 'production';

module.exports  = {
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, './frontend/web/react-bundle'),
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
                test: /\.css$/,
                use: [
                	MiniCssExtractPlugin.loader,
                    {loader: 'css-loader', options: {minimize: true, sourceMap: true}},
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
            chunkFilename: '[id].css'
        })
    ],
    devtool: 'source-map'
};
