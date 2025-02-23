const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const config = {
  entry: {
    admin: [
      './assets/source/js/admin/shopper-weather-api-admin.js',
      './assets/source/sass/admin/shopper-weather-api-admin.scss'
    ],
    front: [
      './assets/source/js/front/shopper-weather-api.js',
      './assets/source/sass/front/shopper-weather-api.scss'
    ]
  },
  output: {
    path: path.resolve(__dirname, 'assets'),
    filename: '[name].js'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        use: 'babel-loader',
        exclude: /node_modules/
      },
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'sass-loader'
        ]
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin()
  ]
};

module.exports = config;