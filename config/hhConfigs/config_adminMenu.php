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
        'icon' => 'bi bi-file-richtext',
    ];
}
$editorialItems['Browse help pages'] = [
    'url' => '/admin/wikis',
    'icon' => 'bi bi-file-medical',
];
if (Configure::read('showManufacturers')) {
    $editorialItems['Browse companies'] = [
        'url' => '/admin/corps',
        'icon' => 'bi bi-building',
    ];
}
if (Configure::read('showAds')) {
    $editorialItems['Browse ads'] = [
        'url' => '/admin/ad',
        'icon' => 'bi bi-card-image',
    ];
}
if (Configure::read('showReports')) {
    $editorialItems['Add article'] = [
        'url' => '/admin/content/edit/type:article',
        'icon' => 'bi bi-plus-lg',
    ];
}
$editorialItems['Misc. pages'] = [
    'url' => '/admin/pages',
    'icon' => 'bi bi-book-fill',
];
$editorialItems['Tags'] = [
    'url' => '/admin/tags',
];
$editorialMenu = [
    'icon' => 'bi bi-fonts',
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
    'icon' => 'bi bi-box-arrow-in-right',
];
$locationsItems['Clinic users'] = [
    'url' => '/admin/location-users',
    'icon' => 'bi bi-person-fill',
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
    'icon' => 'bi bi-geo-alt-fill',
    'items' => $locationsItems,
];

/*******************************
* Admin - Imports
********************************/
$importsItems = [];
$importsItems['Import dashboard'] = [
    'icon' => 'bi bi-speedometer',
    'url' => '/admin/import-locations',
];
$importsItems['Import stats'] = [
    'icon' => 'bi bi-bar-chart-fill',
    'url' => '/admin/imports',
];
if (Configure::read('isTieringEnabled')) {
    $importsItems['Tier status change report'] = [
        'icon' => 'bi bi-bar-chart-fill',
        'url' => '/admin/locations/tier-status-report',
    ];
}
$importsMenu = [
    'icon' => 'bi bi-journal-arrow-down',
    'items' => $importsItems,
];

/*******************************
* Admin - Reviews
********************************/
$reviewsMenu = [
    'url' => '/admin/reviews',
    'icon' => 'bi bi-star-fill',
];

/*******************************
* Admin - Call Concierge
********************************/
if (Configure::read('isCallAssistEnabled')) {
    $callAssistItems = [];
    $callAssistItems['Outbound calls'] = [
        'url' => '/admin/ca-call-groups/outbound',
        'icon' => 'bi bi-telephone-outbound',
    ];
    $callAssistItems['Add inbound call'] = [
        'url' => '/admin/ca-calls/edit',
        'icon' => 'bi bi-telephone-inbound-fill',
    ];
    $callAssistItems['Return call from clinic'] = [
        'url' => '/admin/ca-calls/clinic-lookup',
        'icon' => 'bi bi-telephone-inbound-fill',
    ];
    $callAssistItems['Activation dashboard'] = [
        'url' => '/admin/locations/activation-dashboard',
        'icon' => 'bi bi-check2-square',
    ];
    $callAssistItems['divider'] = true;
    $callAssistItems['Browse call groups'] = [
        'url' => '/admin/ca-call-groups',
        'icon' => 'bi bi-list-ul',
    ];
    $callAssistItems['Browse calls'] = [
        'url' => '/admin/ca-calls',
        'icon' => 'bi bi-list-ul',
    ];
    $callAssistItems['Metrics - Calls'] = [
        'url' => '/admin/ca-call-groups/metrics',
        'icon' => 'bi bi-bar-chart-fill',
    ];
    $callAssistItems['Metrics - Appt request forms'] = [
        'url' => '/admin/ca-call-groups/request-form-metrics',
        'icon' => 'bi bi-bar-chart-fill',
    ];
    $callAssistItems['Metrics - Appts by state'] = [
        'url' => '/admin/ca-call-groups/appts-by-state-metrics',
        'icon' => 'bi bi-bar-chart-fill',
    ];
    $callAssistItems['Metrics - Calls and appts for clinics by date range'] = [
        'url' => '/admin/ca-call-groups/calls-and-appts-by-date',
        'icon' => 'bi bi-bar-chart-fill',
    ];
    $callAssistMenu = [
        'icon' => 'bi bi-telephone-fill',
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
    'icon' => 'bi bi-list-ul',
];
$callTrackingItems['Metrics'] = [
    'url' => '/admin/cs-calls/metrics',
    'icon' => 'bi bi-bar-chart-fill',
];
$callTrackingMenu = [
    'icon' => 'bi bi-telephone-fill',
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
    'icon' => 'bi bi-briefcase-fill',
    'items' => $seoItems,
];

/*******************************
* Admin - Utilities
********************************/
$utilitiesItems = [];
$hhUsers = Configure::read('siteNameAbbr').' Users';
$utilitiesItems[$hhUsers] = [
    'url' => '/admin/users',
    'icon' => 'bi bi-person-fill',
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
    'icon' => 'bi bi-wrench',
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
    'icon' => 'bi bi-bullhorn',
];
$itConciergeLegacyItems['Survey Metrics'] = [
    'url' => '/admin/ca-call-groups/survey-metrics',
    'icon' => 'bi bi-bar-chart-fill',
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
    'icon' => 'bi bi-telephone-outbound',
];

/*******************************
* CCA - Add Inbound Call
********************************/
$addInboundCall = [
    'url' => '/admin/ca-calls/edit',
    'icon' => 'bi bi-telephone-inbound-fill',
];

/*******************************
* CCA - Return Call From Clinic
********************************/
$returnCallFromClinic = [
    'url' => '/admin/ca-calls/clinic-lookup',
    'icon' => 'bi bi-telephone-inbound-fill',
];

/*******************************
* CCA - Activation Dashboard
********************************/
$activationDashboard = [
    'url' => '/admin/locations/activation-dashboard',
    'icon' => 'bi bi-check2-square',
];

/***************************************************
********** Call Concierge Supervisor Menu **********
****************************************************/

/*******************************
* CCS - Browse Call Groups
********************************/
$browseCallGroups = [
    'url' => '/admin/ca-call-groups',
    'icon' => 'bi bi-list-ul',
];

/*******************************
* CCS - Browse Calls
********************************/
$browseCalls = [
    'url' => '/admin/ca-calls',
    'icon' => 'bi bi-list-ul',
];

/*******************************
* CCS - Metrics (Calls)
********************************/
$callMetrics = [
    'url' => '/admin/ca-call-groups/metrics',
    'icon' => 'bi bi-bar-chart-fill',
];

/*******************************
* CCS - Metrics (Forms)
********************************/
$metricsRequestForm = [
    'url' => '/admin/ca-call-groups/request-form-metrics',
    'icon' => 'bi bi-bar-chart-fill',
];

/*****************************************
********** Complete Admin Panel **********
******************************************/

return [
    'adminMenu' => [
        'Admin' => [
            'permissions' => ['admin', 'it_admin'],
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
            'permissions' => ['it_admin'],
            'IT - Utilities' => $itUtilitiesMenu,
            'IT - Call Concierge' => $itConciergeLegacyMenu,
        ],
        'Writer' => [
            'permissions' => ['writer', 'it_admin', 'admin'],
            'Editorial' => $writerEditorialMenu,
        ],
        'Customer Support Assistant' => [
            'permissions' => ['csa', 'it_admin', 'admin'],
            'Locations - FAC' => $csaLocationsMenu,
            'Imports' => $csaImportsMenu,
            'Reviews' => $csaReviewsMenu,
        ],
        'Call Concierge Agent' => [
            'permissions' => ['agent', 'call_supervisor', 'it_admin', 'admin'],
            'Outbound Calls' => $outboundCalls,
            'Add Inbound Call' => $addInboundCall,
            'Return Call From Clinic' => $returnCallFromClinic,
            'Activation Dashboard' => $activationDashboard,
        ],
        'Call Concierge Supervisor' => [
            'permissions' => ['call_supervisor', 'it_admin', 'admin'],
            'Browse Call Groups' => $browseCallGroups,
            'Browse Calls' => $browseCalls,
            'Metrics (Calls)' => $callMetrics,
            'Metrics (Forms)' => $metricsRequestForm,
        ],
    ],
];
