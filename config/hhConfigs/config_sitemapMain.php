<?php

use Cake\Core\Configure;

$sitemapMainUrls = [
    '/',
    '/hearing-aids',
    '/help',
    '/privacy-policy',
    '/terms-of-use',
    '/sitemap',
    '/about',
    '/contact-us',
    '/clinic',
];

$additionalUrlsFromCountryConfig = [
        'showNewsletter' => [
            'url' => '/newsletter',
        ],
        'showFeeds' => [
            'url' => '/feeds',
        ],
        'showHearingTest' => [
            'url' => '/help/online-hearing-test',
        ],
        'showManufacturers' => [
            'url' => '/hearing-aid-manufacturers',
        ],
        'showReports' => [
            'url' => '/report',
        ],
];

foreach ($additionalUrlsFromCountryConfig as $config => $urlInfo) {
    if (Configure::read($config)) {
        $sitemapMainUrls[] = $urlInfo['url'];
    }
}

return [
    'Sitemap.mainUrls' => $sitemapMainUrls,
];
