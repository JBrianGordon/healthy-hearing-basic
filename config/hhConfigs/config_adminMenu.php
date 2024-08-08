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
        'url' => '/admin/ads',
        'icon' => 'bi bi-card-image',
    ];
}
if (Configure::read('showReports')) {
    $editorialItems['Add article'] = [
        'url' => '/admin/content/edit',
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
$locationsItems['Providers'] = [
    'url' => '/admin/providers',
    'icon' => 'bi bi-people-fill',
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
    'url' => '/login',
    'icon' => 'bi bi-box-arrow-in-right',
];
$locationsItems['Cities'] = [
    'url' => '/admin/cities',
];
$locationsItems[Inflector::pluralize(ucfirst(Configure::read('stateLabel')))] = [
    'url' => '/admin/states',
];
$zipCodes = Inflector::pluralize(ucfirst(Configure::read('zipLabel')));
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
    'url' => '/admin/seo-canonicals',
];
$seoItems['Meta tags'] = [
    'url' => '/admin/seo-meta-tags',
];
$seoItems['Redirects'] = [
    'url' => '/admin/seo-redirects',
];
$seoItems['Status codes'] = [
    'url' => '/admin/seo-status-codes',
];
$seoItems['Titles'] = [
    'url' => '/admin/seo-titles',
];
$seoToolsMenu = [
    'icon' => 'bi bi-briefcase-fill',
    'items' => $seoItems,
];

/*******************************
* Admin - Utilities
********************************/
$utilitiesItems = [];
$utilitiesItems['Users'] = [
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
$utilitiesItems['Queued Jobs'] = [
    'url' => '/admin/utils/queued-jobs',
];
$utilitiesItems['CRM searches'] = [
    'url' => '/admin/crm-searches',
];
/*
TODO: Hopefully Rsync will not be needed in Cake4
if (Configure::read('isLoadBalanced')) {
    $utilitiesItems['Rsync'] = [
        'url' => '/admin/utils/rsync',
    ];
}
*/
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


// Items for SEPARATE EDITORIAL MENU -- TESTING FOR NOW
$browseReports = [
    'url' => '/admin/content',
    'icon' => 'bi bi-file-richtext',
];
$browseHelpPages = [
    'url' => '/admin/wikis',
    'icon' => 'bi bi-file-medical',
];
$browseCompanies = [
    'url' => '/admin/corps',
    'icon' => 'bi bi-building',
];
$browseAds = [
    'url' => '/admin/ad',
    'icon' => 'bi bi-card-image',
];
$addArticle = [
    'url' => '/admin/content/edit',
    'icon' => 'bi bi-plus-lg',
];
$miscPages = [
    'url' => '/admin/pages',
    'icon' => 'bi bi-book-fill',
];
$tags = [
    'url' => '/admin/tags',
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

//**** Admin ****//
$adminMenu['adminMenu']['Admin']['permissions'] = ['admin', 'it_admin'];
$adminMenu['adminMenu']['Admin']['Editorial'] = $editorialMenu;
$adminMenu['adminMenu']['Admin']['Locations - FAC'] = $locationsMenu;
$adminMenu['adminMenu']['Admin']['Imports'] = $importsMenu;
$adminMenu['adminMenu']['Admin']['Reviews'] = $reviewsMenu;
if (Configure::read('isCallAssistEnabled')) {
    $adminMenu['adminMenu']['Admin']['Call Concierge'] = $callAssistMenu;
}
$adminMenu['adminMenu']['Admin']['Call Tracking'] = $callTrackingMenu;
$adminMenu['adminMenu']['Admin']['SEO Tools'] = $seoToolsMenu;
$adminMenu['adminMenu']['Admin']['Utilities'] = $utilitiesMenu;

//**** IT Admin ****//
$adminMenu['adminMenu']['IT Admin']['permissions'] = ['admin', 'itadmin'];
$adminMenu['adminMenu']['IT Admin']['IT - Utilities'] = $itUtilitiesMenu;

//**** Editorial ****//
$adminMenu['adminMenu']['Editorial']['permissions'] = ['admin', 'itadmin', 'editor'];
$adminMenu['adminMenu']['Editorial']['Browse Reports'] = $browseReports;
$adminMenu['adminMenu']['Editorial']['Browse help pages'] = $browseHelpPages;
$adminMenu['adminMenu']['Editorial']['Browse ads'] = $browseAds;
$adminMenu['adminMenu']['Editorial']['Add article'] = $addArticle;
$adminMenu['adminMenu']['Editorial']['Misc. pages'] = $miscPages;
$adminMenu['adminMenu']['Editorial']['Tags'] = $tags;

//**** Writer ****//
$adminMenu['adminMenu']['Writer']['permissions'] = ['writer', 'itadmin', 'admin'];
$adminMenu['adminMenu']['Writer']['Editorial'] = $writerEditorialMenu;

//**** Customer Support Assistant ****//
$adminMenu['adminMenu']['Customer Support Assistant']['permissions'] = ['admin', 'itadmin', 'csa'];
$adminMenu['adminMenu']['Customer Support Assistant']['Locations - FAC'] = $csaLocationsMenu;
$adminMenu['adminMenu']['Customer Support Assistant']['Imports'] = $csaImportsMenu;
$adminMenu['adminMenu']['Customer Support Assistant']['Reviews'] = $csaReviewsMenu;

//**** Call Concierge Agent ****//
if (Configure::read('isCallAssistEnabled')) {
    $adminMenu['adminMenu']['Call Concierge Agent']['permissions'] = ['admin', 'itadmin', 'agent', 'call_supervisor'];
    $adminMenu['adminMenu']['Call Concierge Agent']['Outbound Calls'] = $outboundCalls;
    $adminMenu['adminMenu']['Call Concierge Agent']['Add Inbound Call'] = $addInboundCall;
    $adminMenu['adminMenu']['Call Concierge Agent']['Return Call From Clinic'] = $returnCallFromClinic;
}

//**** Call Concierge Supervisor ****//
if (Configure::read('isCallAssistEnabled')) {
    $adminMenu['adminMenu']['Call Concierge Supervisor']['permissions'] = ['admin', 'itadmin', 'call_supervisor'];
    $adminMenu['adminMenu']['Call Concierge Supervisor']['Browse Call Groups'] = $browseCallGroups;
    $adminMenu['adminMenu']['Call Concierge Supervisor']['Browse Calls'] = $browseCalls;
    $adminMenu['adminMenu']['Call Concierge Supervisor']['Metrics (Calls)'] = $callMetrics;
    $adminMenu['adminMenu']['Call Concierge Supervisor']['Metrics (Forms)'] = $metricsRequestForm;
}

return $adminMenu;
