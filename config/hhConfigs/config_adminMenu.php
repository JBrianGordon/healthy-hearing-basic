<?php

use Cake\Utility\Inflector;
use Cake\Core\Configure;

/*******************************
********** Admin Menu **********
********************************/

/*******************************
* Admin - Editorial
********************************/
$editorialItems = [];
if (Configure::read('showReports')) {
    $editorialItems['Browse reports'] = [
        'url' => '/admin/content',
        'icon' => 'glyphicon glyphicon-font',
    ];
}
$editorialItems['Browse help pages'] = [
    'url' => '/admin/wikis',
    'icon' => 'glyphicon glyphicon-tasks',
];
if (Configure::read('showManufacturers')) {
    $editorialItems['Browse companies'] = [
        'url' => '/admin/corps',
        'icon' => 'glyphicon glyphicon-flag',
    ];
}
if (Configure::read('showAds')) {
    $editorialItems['Browse ads'] = [
        'url' => '/admin/ad',
        'icon' => 'glyphicon glyphicon-picture',
    ];
}
if (Configure::read('showReports')) {
    $editorialItems['Add article'] = [
        'url' => '/admin/content/edit/type:article',
        'icon' => 'glyphicon glyphicon-plus',
    ];
}
$editorialItems['Misc. pages'] = [
    'url' => '/admin/pages',
    'icon' => 'glyphicon glyphicon-book',
];
$editorialItems['Tags'] = [
    'url' => '/admin/tags',
];
$editorialMenu = [
    'icon' => 'glyphicon glyphicon-font',
    'items' => $editorialItems,
];

/*******************************
* Admin - Locations / FAC
********************************/
$locationsItems = [];
$locationsItems['CRM'] = [
    'url' => '/admin/locations/index',
];
$locationsItems['CRM searches'] = [
    'url' => '/admin/crm-searches',
];
if (Configure::read('isCallAssistEnabled')) {
    $locationsItems['CallSource numbers'] = [
        'url' => '/admin/call-sources',
    ];
}
if (Configure::read('isCallTrackingEnabled')) {
    $locationsItems['Call tracking numbers'] = [
        'url' => '/admin/call-sources',
    ];
}
$locationsItems['Clinic portal'] = [
    'url' => '/clinic/login',
    'icon' => 'glyphicon glyphicon-log-in',
];
$locationsItems['Clinic users'] = [
    'url' => '/admin/location-users',
    'icon' => 'glyphicon glyphicon-user',
];
$locationsItems['Cities'] = [
    'url' => '/admin/cities',
];
$locationsItems[Inflector::pluralize(ucfirst('state'))] = [
    'url' => '/admin/states',
];
$zipCodes = Inflector::pluralize(ucfirst('zip code'));
$locationsItems[$zipCodes] = [
    'url' => '/admin/zips',
];
$locationsMenu = [
    'icon' => 'glyphicon glyphicon-map-marker',
    'items' => $locationsItems,
];

/*******************************
* Admin - Imports
********************************/
$importsItems = [];
$importsItems['Import dashboard'] = [
    'url' => '/admin/imports',
];
$importsItems['Import stats'] = [
    'url' => '/admin/imports/stats',
];
if (Configure::read('isTieringEnabled')) {
    $importsItems['Tier status change report'] = [
        'url' => '/admin/locations/tier-status-report',
    ];
}
$importsMenu = [
    'icon' => 'glyphicon glyphicon-import',
    'items' => $importsItems,
];

/*******************************
* Admin - Reviews
********************************/
$reviewsMenu = [
    'url' => '/admin/reviews',
    'icon' => 'glyphicon glyphicon-star',
];

/*******************************
* Admin - Call Concierge
********************************/
if (Configure::read('isCallAssistEnabled')) {
    $callAssistItems = [];
    $callAssistItems['Outbound calls'] = [
        'url' => '/admin/ca-call-groups/outbound',
        'icon' => 'glyphicon glyphicon-bullhorn',
    ];
    $callAssistItems['Add inbound call'] = [
        'url' => '/admin/ca-calls/edit',
        'icon' => 'glyphicon glyphicon-plus',
    ];
    $callAssistItems['Return call from clinic'] = [
        'url' => '/admin/ca-calls/clinic-lookup',
        'icon' => 'glyphicon glyphicon-plus',
    ];
    $callAssistItems['Activation dashboard'] = [
        'url' => '/admin/locations/activation-dashboard',
        'icon' => 'glyphicon glyphicon-check',
    ];
    $callAssistItems['divider'] = true;
    $callAssistItems['Browse call groups'] = [
        'url' => '/admin/ca-call-groups',
        'icon' => 'glyphicon glyphicon-list',
    ];
    $callAssistItems['Browse calls'] = [
        'url' => '/admin/ca-calls',
        'icon' => 'glyphicon glyphicon-list',
    ];
    $callAssistItems['Metrics - Calls'] = [
        'url' => '/admin/ca-call-groups/metrics',
        'icon' => 'glyphicon glyphicon-stats',
    ];
    $callAssistItems['Metrics - Appt request forms'] = [
        'url' => '/admin/ca-call-groups/request-form-metrics',
        'icon' => 'glyphicon glyphicon-stats',
    ];
    $callAssistItems['Metrics - Appts by state'] = [
        'url' => '/admin/ca-call-groups/appts-by-state-metrics',
        'icon' => 'glyphicon glyphicon-stats',
    ];
    $callAssistItems['Metrics - Calls and appts for clinics by date range'] = [
        'url' => '/admin/ca-call-groups/calls-and-appts-by-date',
        'icon' => 'glyphicon glyphicon-stats',
    ];
    $callAssistMenu = [
        'icon' => 'glyphicon glyphicon-earphone',
        'items' => $callAssistItems,
    ];
} else {
    $callAssistMenu = [];
}

/*******************************
* Admin - Call Tracking
********************************/
$callTrackingItems = [];
$callTrackingItems['Browse Calls'] = [
    'url' => '/admin/cs-calls',
    'icon' => 'glyphicon glyphicon-list',
];
$callTrackingItems['Metrics'] = [
    'url' => '/admin/cs-calls/metrics',
    'icon' => 'glyphicon glyphicon-stats',
];
$callTrackingMenu = [
    'icon' => 'glyphicon glyphicon-earphone',
    'items' => $callTrackingItems,
];

/*******************************
* Admin - SEO Tools
********************************/
$seoItems = [];
$seoItems['Canonicals'] = [
    'url' => '/admin/seo/seo-canonicals',
];
$seoItems['Meta tags'] = [
    'url' => '/admin/seo/seo-meta-tags',
];
$seoItems['Redirects'] = [
    'url' => '/admin/seo/seo-redirects',
];
$seoItems['Status codes'] = [
    'url' => '/admin/seo/seo-status-codes',
];
$seoItems['Titles'] = [
    'url' => '/admin/seo/seo-titles',
];
if (Configure::read('showImageSitemap')) {
    $seoItems['Image sitemap'] = [
        'url' => '/admin/sitemaps/image-sitemap',
    ];
}
$seoToolsMenu = [
    'icon' => 'glyphicon glyphicon-briefcase',
    'items' => $seoItems,
];

/*******************************
* Admin - Utilities
********************************/
$utilitiesItems = [];
$hhUsers = Configure::read('siteNameAbbr').' Users';
$utilitiesItems[$hhUsers] = [
    'url' => '/admin/users',
    'icon' => 'glyphicon glyphicon-user',
];
$utilitiesItems['View cache'] = [
    'url' => '/admin/utils/cache',
];
$utilitiesItems['Clear cache'] = [
    'url' => '/admin/utils/clear-cache',
];
$utilitiesItems['Clear session'] = [
    'url' => '/admin/utils/clear-session',
];
$utilitiesItems['Queues'] = [
    'url' => '/admin/queue/queue-tasks',
];
if (Configure::read('isLoadBalanced')) {
    $utilitiesItems['Rsync'] = [
        'url' => '/admin/utils/rsync',
    ];
}
$utilitiesItems['Settings'] = [
    'url' => '/admin/configurations',
];
$utilitiesMenu = [
    'icon' => 'glyphicon glyphicon-wrench',
    'items' => $utilitiesItems,
];

/**********************************
********** IT Admin Menu **********
***********************************/

/*******************************
* IT - Utilities
********************************/
$itUtilitiesItems = [];
$itUtilitiesItems['Quiz results'] = [
    'url' => '/admin/quiz-results',
];
$itUtilitiesItems['SEO Blacklists'] = [
    'url' => '/admin/seo/seo-blacklists',
];
$itUtilitiesItems['SEO URIs'] = [
    'url' => '/admin/seo/seo-uris',
];
$itUtilitiesItems['Sitemap URLs'] = [
    'url' => '/admin/sitemap-urls',
];
$itUtilitiesItems['Cloud assets'] = [
    'url' => '/admin/cloud-assets',
];
$itUtilitiesItems['Fix cache permissions'] = [
    'url' => '/admin/utils/cache-permissions',
];
$itUtilitiesMenu = [
    'items' => $itUtilitiesItems,
];

/*******************************
* IT - Call Concierge (Legacy)
********************************/
$itConciergeLegacyItems = [];
$itConciergeLegacyItems['Survey Calls'] = [
    'url' => '/admin/ca-call-groups/surveys',
    'icon' => 'glyphicon glyphicon-bullhorn',
];
$itConciergeLegacyItems['Survey Metrics'] = [
    'url' => '/admin/ca-call-groups/survey-metrics',
    'icon' => 'glyphicon glyphicon-stats',
];
$itConciergeLegacyMenu = [
    'items' => $itConciergeLegacyItems,
];

/********************************
********** Writer Menu **********
*********************************/

/*******************************
* Writer - Editorial
********************************/
$writerEditorialMenu = $editorialMenu;
unset($writerEditorialMenu['items']['Browse ads']);
unset($writerEditorialMenu['items']['Misc. pages']);

/****************************************************
********** Customer Support Assistant Menu **********
*****************************************************/

/*******************************
* CSA - Locations / FAC
********************************/
$csaLocationsMenu = $locationsMenu;

/*******************************
* CSA - Imports
********************************/
$csaImportsMenu = $importsMenu;

/*******************************
* CSA - Reviews
********************************/
$csaReviewsMenu = $reviewsMenu;

/**********************************************
********** Call Concierge Agent Menu **********
***********************************************/

/*******************************
* CCA - Outbound Calls
********************************/
$outboundCalls = [
    'url' => '/admin/ca-call-groups/outbound',
    'icon' => 'glyphicon glyphicon-bullhorn',
];

/*******************************
* CCA - Add Inbound Call
********************************/
$addInboundCall = [
    'url' => '/admin/ca-calls/edit',
    'icon' => 'glyphicon glyphicon-plus',
];

/*******************************
* CCA - Return Call From Clinic
********************************/
$returnCallFromClinic = [
    'url' => '/admin/ca-calls/clinic-lookup',
    'icon' => 'glyphicon glyphicon-plus',
];

/*******************************
* CCA - Activation Dashboard
********************************/
$activationDashboard = [
    'url' => '/admin/locations/activation-dashboard',
    'icon' => 'glyphicon glyphicon-check',
];

/***************************************************
********** Call Concierge Supervisor Menu **********
****************************************************/

/*******************************
* CCS - Browse Call Groups
********************************/
$browseCallGroups = [
    'url' => '/admin/ca-call-groups',
    'icon' => 'glyphicon glyphicon-list',
];

/*******************************
* CCS - Browse Calls
********************************/
$browseCalls = [
    'url' => '/admin/ca-calls',
    'icon' => 'glyphicon glyphicon-list',
];

/*******************************
* CCS - Metrics (Calls)
********************************/
$callMetrics = [
    'url' => '/admin/ca-call-groups/metrics',
    'icon' => 'glyphicon glyphicon-stats',
];

/*******************************
* CCS - Metrics (Forms)
********************************/
$metricsRequestForm = [
    'url' => '/admin/ca-call-groups/request-form-metrics',
    'icon' => 'glyphicon glyphicon-stats',
];

/*****************************************
********** Complete Admin Panel **********
******************************************/

return [
    'adminMenu' => [
        'Admin' => [
            'Editorial' => $editorialMenu,
            'Locations - FAC' => $locationsMenu,
            'Imports' => $importsMenu,
            'Reviews' => $reviewsMenu,
            'Call Concierge' => $callAssistMenu,
            'Call Tracking' => $callTrackingMenu,
            'SEO Tools' => $seoToolsMenu,
            'Utilities' => $utilitiesMenu,
        ],
        'IT Admin' => [
            'IT - Utilities' => $itUtilitiesMenu,
            'IT - Call Concierge' => $itConciergeLegacyMenu,
        ],
        'Writer' => [
            'Editorial' => $writerEditorialMenu,
        ],
        'Customer Support Assistant' => [
            'Locations - FAC' => $csaLocationsMenu,
            'Imports' => $csaImportsMenu,
            'Reviews' => $csaReviewsMenu,
        ],
        'Call Concierge Agent' => [
            'Outbound Calls' => $outboundCalls,
            'Add Inbound Call' => $addInboundCall,
            'Return Call From Clinic' => $returnCallFromClinic,
            'Activation Dashboard' => $activationDashboard,
        ],
        'Call Concierge Supervisor' => [
            'Browse Call Groups' => $browseCallGroups,
            'Browse Calls' => $browseCalls,
            'Metrics (Calls)' => $callMetrics,
            'Metrics (Forms)' => $metricsRequestForm,
        ],
    ],
];
