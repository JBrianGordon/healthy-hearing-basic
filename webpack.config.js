const path = require('path');
const webpack = require('webpack');
const penthouse = require('penthouse');
const fs = require('fs');
const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');
const adminFolder = './webroot/js/admin/';
const commonFolder = './webroot/js/common/';
const adminFiles = fs.readdirSync(adminFolder);
const commonFiles = fs.readdirSync(commonFolder);

let entries = {};

const folderMinify = (folder, files) => {
  files.forEach(currentFile => {
    let fileName = currentFile.replace('.js', '');
    if (fileName != '.DS_Store' && fileName.search(/\.min/) < 0) {
      entries[`${fileName}`] = `${folder}${currentFile}`;
    }
  })
}

folderMinify(adminFolder, adminFiles);
folderMinify(commonFolder, commonFiles);

module.exports = {
  mode: 'production',
  entry: entries,
  //change this to 'source-map' if you need to debug the code
  devtool: false,
  cache: {
    type: 'filesystem',
    cacheDirectory: path.resolve('webpack_cache'),
    //Update version whenever configuration is changed to invalidate and replace previous cache
    version: '1.1',
  },
  module: {
    rules: [
      {
        test: /\.svg$/,
        use: [
          {
            loader: "raw-loader"
          }
        ]
      },
      {
        test: /\.css$/i,
        use: ["style-loader", "css-loader"],
      },
      {
        test: /\.tsx?$/, // Handles .ts and .tsx
        use: "ts-loader",
        exclude: /node_modules/,
      },
    ],
  },
  optimization: {
    minimizer: [
      "...",
      //This is a dependency of CKEditor 5, so it must be included in the build
      new ImageMinimizerPlugin({
        minimizer: {
          implementation: ImageMinimizerPlugin.svgoMinify,
          options: {
            encodeOptions: {
              // Pass over SVGs multiple times to ensure all optimizations are applied. False by default
              multipass: true,
              plugins: [
                // set of built-in plugins enabled by default
                // see: https://github.com/svg/svgo#default-preset
                "preset-default",
              ],
            },
          },
        },
      }),
    ],
  },
  resolve: {
    extensions: ['.tsx', '.ts', '.js'],
    alias: {
      jquery: "jquery/src/jquery"
    }
  },
  performance: {
    hints: false
  },
  plugins: [
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      Popper: ['dist/umd/popper.js', 'default']
    }),
  ],
  output: {
    filename: '[name].min.js',
    path: path.resolve(__dirname, 'webroot/js/dist')
  }
};