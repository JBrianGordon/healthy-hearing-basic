const path = require('path');
const webpack = require('webpack');
const UglifyJS = require('uglify-js');
const penthouse = require('penthouse');
const fs = require('fs');
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
	devtool: 'source-map',
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
		})
    ],
	output: {
		filename: '[name].min.js',
		path: path.resolve(__dirname, 'webroot/js/dist')
	}
};

//Create ATF CSS
const cssArrays = [
	['home','https://www.healthyhearing.com'],
	['help','https://www.healthyhearing.com/help'],
	['help-page','https://www.healthyhearing.com/help/hearing-aids/aarp'],
	['report','https://www.healthyhearing.com/report'],
	['report-page','https://www.healthyhearing.com/report/52879-Why-do-my-ears-feel-clogged'],
	['hearing-aids','https://www.healthyhearing.com/hearing-aids'],
	['state-page','https://www.healthyhearing.com/hearing-aids/NY-New-York'],
	['city-page','https://www.healthyhearing.com/hearing-aids/NY-New-York/New-York'],
	['clinic-page','https://www.healthyhearing.com/hearing-aids/27604-hearinglife-madison-avenue'],
	['enhanced-page','https://www.healthyhearing.com/hearing-aids/26872-hearinglife-olympia'],
	['about','https://www.healthyhearing.com/about'],
	['online-hearing-test','https://www.healthyhearing.com/help/online-hearing-test'],
	['manufacturers','https://www.healthyhearing.com/hearing-aid-manufacturers'],
	['manufacturer','https://www.healthyhearing.com/oticon-hearing-aids']
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