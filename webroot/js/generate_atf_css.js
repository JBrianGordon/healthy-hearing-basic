/***TODO: run this after Cake 4 launch (check package.json for terminal command) */
const penthouse = require('penthouse');
const fs = require('fs');

const cssArrays = [
    ['home', 'https://www.healthyhearing.com'],
    ['help', 'https://www.healthyhearing.com/help'],
    ['help-page', 'https://www.healthyhearing.com/help/hearing-aids/aarp'],
    ['report', 'https://www.healthyhearing.com/report'],
    ['report-page', 'https://www.healthyhearing.com/report/52879-Why-do-my-ears-feel-clogged'],
    ['hearing-aids', 'https://www.healthyhearing.com/hearing-aids'],
    ['state-page', 'https://www.healthyhearing.com/hearing-aids/NY-New-York'],
    ['city-page', 'https://www.healthyhearing.com/hearing-aids/NY-New-York/New-York'],
    ['clinic-page', 'https://www.healthyhearing.com/hearing-aids/27604-hearinglife-madison-avenue'],
    ['enhanced-page', 'https://www.healthyhearing.com/hearing-aids/26872-hearinglife-olympia'],
    ['about', 'https://www.healthyhearing.com/about'],
    ['online-hearing-test', 'https://www.healthyhearing.com/help/online-hearing-test'],
    ['manufacturers', 'https://www.healthyhearing.com/hearing-aid-manufacturers'],
    ['manufacturer', 'https://www.healthyhearing.com/oticon-hearing-aids']
];

async function genAtfCss() {
    const cssArray = cssArrays.pop();

    if (!cssArray) {
        console.log('✅ All ATF CSS files generated');
        return Promise.resolve();
    }

    const [file, url] = cssArray;
    console.log(`Generating ATF CSS for: ${file} (${url})`);

    try {
        const criticalCss = await penthouse({
            url,
            css: './webroot/css/responsive.css'
        });

        fs.writeFileSync(`./webroot/css/atf/${file}.css`, criticalCss);
        console.log(`✅ Generated: ${file}.css`);

        // Continue with next file
        return genAtfCss();
    } catch (error) {
        console.error(`❌ Failed to generate ${file}.css:`, error.message);
        // Continue despite errors
        return genAtfCss();
    }
}

// Run it
genAtfCss().catch(console.error);