const path = require('path');
const webpack = require('webpack');
const penthouse = require('penthouse');
const fs = require('fs');
const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');
const adminFolder = './webroot/js/admin/';
const commonFolder = './webroot/js/common/';
const adminFiles= fs.readdirSync(adminFolder);
const commonFiles= fs.readdirSync(commonFolder);

let entries = {};

const folderMinify = (folder, files) => {
	files.forEach(currentFile => {
		let fileName = currentFile.replace('.js','');
		if(fileName != '.DS_Store' && fileName.search(/\.min/) < 0) {
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
		extensions: [ '.tsx', '.ts', '.js' ],
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

//Create ATF CSS
//*** TODO: change these urls back to the production site once Cake 4 is live: ***/
const cssArrays = [
	['home','http://dev.hhcake.com'],
	['help','http://dev.hhcake.com/help'],
	['help-page','http://dev.hhcake.com/help/hearing-aids/aarp'],
	['report','http://dev.hhcake.com/report'],
	['report-page','http://dev.hhcake.com/report/52879-Why-do-my-ears-feel-clogged'],
	['hearing-aids','http://dev.hhcake.com/hearing-aids'],
	['state-page','http://dev.hhcake.com/hearing-aids/NY-New-York'],
	['city-page','http://dev.hhcake.com/hearing-aids/NY-New-York/New-York'],
	['clinic-page','http://dev.hhcake.com/hearing-aids/27604-hearinglife-madison-avenue'],
	['enhanced-page','http://dev.hhcake.com/hearing-aids/26872-hearinglife-olympia'],
	['about','http://dev.hhcake.com/about'],
	['online-hearing-test','http://dev.hhcake.com/help/online-hearing-test'],
	['manufacturers','http://dev.hhcake.com/hearing-aid-manufacturers'],
	['manufacturer','http://dev.hhcake.com/oticon-hearing-aids']
]

function genAtfCss () {
  const cssArray = cssArrays.pop();
  let file, url;
  if (!cssArray) {
    return Promise.resolve()
  } else {
  	file = cssArray[0];
  	url = cssArray[1];
  }
  return penthouse({
    url,
    css: './webroot/css/responsive.css'
  })
    .then(criticalCss => {
      fs.writeFileSync(`./webroot/css/atf/${file}.css`, criticalCss);
      return genAtfCss()
    })
}

//Uncomment this function when running "npm run build" locally if there are any ATF CSS updates needed
//genAtfCss();