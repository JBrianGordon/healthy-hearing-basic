<?php

use Cake\Utility\Inflector;

/*******************************
********** Admin Menu **********
********************************/

/*******************************
* Admin - Editorial
********************************/
$editorialItems = [];
if (true) {
    $editorialItems['Browse reports'] = [
        'url' => '/admin/content',
        'icon' => 'glyphicon glyphicon-font',
    ];
}
$editorialItems['Browse help pages'] = [
    'url' => '/admin/wikis',
    'icon' => 'glyphicon glyphicon-tasks',
];
if (true) {
    $editorialItems['Browse companies'] = [
        'url' => '/admin/corps',
        'icon' => 'glyphicon glyphicon-flag',
    ];
}
if (true) {
    $editorialItems['Browse ads'] = [
        'url' => '/admin/ad',
        'icon' => 'glyphicon glyphicon-picture',
    ];
}
if (true) {
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
if (true) {
    $locationsItems['CallSource numbers'] = [
        'url' => '/admin/call_sources',
    ];
}
if (true) {
    $locationsItems['Call tracking numbers'] = [
        'url' => '/admin/call_sources',
    ];
}
$locationsItems['Clinic portal'] = [
    'url' => '/clinic/login',
    'icon' => 'glyphicon glyphicon-log-in',
];
$locationsItems['Clinic users'] = [
    'url' => '/admin/location_users',
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
if (true) {
    $importsItems['YHN import dashboard'] = [
        'url' => '/admin/imports',
    ];
    $importsItems['YHN import stats'] = [
        'url' => '/admin/imports/stats',
    ];
} else {
    $importsItems['Import dashboard'] = [
        'url' => '/admin/imports',
    ];
    $importsItems['Import stats'] = [
        'url' => '/admin/imports/stats',
    ];
}
if (true) {
    $importsItems['Tier status change report'] = [
        'url' => '/admin/locations/tier_status_report',
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
if (true) {
    $callAssistItems = [];
    $callAssistItems['Outbound calls'] = [
        'url' => '/admin/ca_call_groups/outbound',
        'icon' => 'glyphicon glyphicon-bullhorn',
    ];
    $callAssistItems['Add inbound call'] = [
        'url' => '/admin/ca_calls/edit',
        'icon' => 'glyphicon glyphicon-plus',
    ];
    $callAssistItems['Return call from clinic'] = [
        'url' => '/admin/ca_calls/clinic_lookup',
        'icon' => 'glyphicon glyphicon-plus',
    ];
    $callAssistItems['Activation dashboard'] = [
        'url' => '/admin/locations/activation_dashboard',
        'icon' => 'glyphicon glyphicon-check',
    ];
    $callAssistItems['divider'] = true;
    $callAssistItems['Browse call groups'] = [
        'url' => '/admin/ca_call_groups',
        'icon' => 'glyphicon glyphicon-list',
    ];
    $callAssistItems['Browse calls'] = [
        'url' => '/admin/ca_calls',
        'icon' => 'glyphicon glyphicon-list',
    ];
    $callAssistItems['Metrics - Calls'] = [
        'url' => '/admin/ca_call_groups/metrics',
        'icon' => 'glyphicon glyphicon-stats',
    ];
    $callAssistItems['Metrics - Appt request forms'] = [
        'url' => '/admin/ca_call_groups/request_form_metrics',
        'icon' => 'glyphicon glyphicon-stats',
    ];
    $callAssistItems['Metrics - Appts by state'] = [
        'url' => '/admin/ca_call_groups/appts_by_state_metrics',
        'icon' => 'glyphicon glyphicon-stats',
    ];
    $callAssistItems['Metrics - Calls and appts for clinics by date range'] = [
        'url' => '/admin/ca_call_groups/calls_and_appts_by_date',
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
    'url' => '/admin/cs_calls',
    'icon' => 'glyphicon glyphicon-list',
];
$callTrackingItems['Metrics'] = [
    'url' => '/admin/cs_calls/metrics',
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
    'url' => '/admin/seo/seo_canonicals',
];
$seoItems['Meta tags'] = [
    'url' => '/admin/seo/seo_meta_tags',
];
$seoItems['Redirects'] = [
    'url' => '/admin/seo/seo_redirects',
];
$seoItems['Status codes'] = [
    'url' => '/admin/seo/seo_status_codes',
];
$seoItems['Titles'] = [
    'url' => '/admin/seo/seo_titles',
];
if (true) {
    $seoItems['Image sitemap'] = [
        'url' => '/admin/sitemaps/image_sitemap',
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
$hhUsers = 'HH' . ' Users';
$utilitiesItems[$hhUsers] = [
    'url' => '/admin/users',
    'icon' => 'glyphicon glyphicon-user',
];
$utilitiesItems['View cache'] = [
    'url' => '/admin/utils/cache',
];
$utilitiesItems['Clear cache'] = [
    'url' => '/admin/utils/clear_cache',
];
$utilitiesItems['Clear session'] = [
    'url' => '/admin/utils/clear_session',
];
$utilitiesItems['Queues'] = [
    'url' => '/admin/queue/queue_tasks',
];
if (true) {
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
    'url' => '/admin/quiz_results',
];
$itUtilitiesItems['SEO Blacklists'] = [
    'url' => '/admin/seo/seo_blacklists',
];
$itUtilitiesItems['SEO URIs'] = [
    'url' => '/admin/seo/seo_uris',
];
$itUtilitiesItems['Sitemap URLs'] = [
    'url' => '/admin/sitemap_urls',
];
$itUtilitiesItems['Cloud assets'] = [
    'url' => '/admin/cloud_assets',
];
$itUtilitiesItems['Fix cache permissions'] = [
    'url' => '/admin/utils/cache_permissions',
];
$itUtilitiesMenu = [
    'items' => $itUtilitiesItems,
];

/*******************************
* IT - Call Concierge (Legacy)
********************************/
$itConciergeLegacyItems = [];
$itConciergeLegacyItems['Survey Calls'] = [
    'url' => '/admin/ca_call_groups/surveys',
    'icon' => 'glyphicon glyphicon-bullhorn',
];
$itConciergeLegacyItems['Survey Metrics'] = [
    'url' => '/admin/ca_call_groups/survey_metrics',
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
    'url' => '/admin/ca_call_groups/outbound',
    'icon' => 'glyphicon glyphicon-bullhorn',
];

/*******************************
* CCA - Add Inbound Call
********************************/
$addInboundCall = [
    'url' => '/admin/ca_calls/edit',
    'icon' => 'glyphicon glyphicon-plus',
];

/*******************************
* CCA - Return Call From Clinic
********************************/
$returnCallFromClinic = [
    'url' => '/admin/ca_calls/clinic_lookup',
    'icon' => 'glyphicon glyphicon-plus',
];

/*******************************
* CCA - Activation Dashboard
********************************/
$activationDashboard = [
    'url' => '/admin/locations/activation_dashboard',
    'icon' => 'glyphicon glyphicon-check',
];

/***************************************************
********** Call Concierge Supervisor Menu **********
****************************************************/

/*******************************
* CCS - Browse Call Groups
********************************/
$browseCallGroups = [
    'url' => '/admin/ca_call_groups',
    'icon' => 'glyphicon glyphicon-list',
];

/*******************************
* CCS - Browse Calls
********************************/
$browseCalls = [
    'url' => '/admin/ca_calls',
    'icon' => 'glyphicon glyphicon-list',
];

/*******************************
* CCS - Metrics (Calls)
********************************/
$callMetrics = [
    'url' => '/admin/ca_call_groups/metrics',
    'icon' => 'glyphicon glyphicon-stats',
];

/*******************************
* CCS - Metrics (Forms)
********************************/
$metricsRequestForm = [
    'url' => '/admin/ca_call_groups/request_form_metrics',
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
