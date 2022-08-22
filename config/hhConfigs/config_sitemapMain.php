<?php

use Cake\Core\Configure;

// URL => priority-value pairs
$sitemapMainUrls = [
    '/' => 1,
    '/hearing-aids' => 1,
    '/help' => 1,
    '/privacy-policy' => 1,
    '/terms-of-use' => 1,
    '/sitemap' => 1,
    '/about' => 1,
    '/contact-us' => 1,
    '/clinic' => 1,
];

$additionalUrlsFromCountryConfig = [
        'showNewsletter' => [
            'url' => '/newsletter',
            'priority' => 1,
        ],
        'showFeeds' => [
            'url' => '/feeds',
            'priority' => 1,
        ],
        'showHearingTest' => [
            'url' => '/help/online-hearing-test',
            'priority' => 1,
        ],
        'showManufacturers' => [
            'url' => '/hearing-aid-manufacturers',
            'priority' => 1,
        ],
        'showReports' => [
            'url' => '/report',
            'priority' => 1,
        ],
];

foreach ($additionalUrlsFromCountryConfig as $config => $urlInfo) {
    if (Configure::read($config)) {
        $sitemapMainUrls[$urlInfo['url']] = $urlInfo['priority'];
    }
}

return [
    'Sitemap.mainUrls' => $sitemapMainUrls,
];
