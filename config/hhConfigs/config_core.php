<?php
/* Core Configurations */
$tagVersion = exec('git describe --tags');
$tagVersion = empty($tagVersion) ? 'v0.0' : $tagVersion; //temporary
return [
    'tagVersion' => $tagVersion,
    'oticonCountries' => [
        'US' => [
            'countryName' => 'the United States',
            'countrySiteName' => 'Healthy Hearing',
            'countrySiteURL' => 'https://www.healthyhearing.com/hearing-aids',
            'isOticonSite' => false
        ],
        'CA' => [
            'countryName' => 'Canada',
            'countrySiteName' => 'Hearing Directory',
            'countrySiteURL' => 'https://www.hearingdirectory.ca/hearing-aids',
            'isOticonSite' => false
        ],
    ],
    // CallSource API
    'callSourceUsername' => 'xmluser_hh', // dev/test account
    'callSourcePassword' => 'xmlapihh1' // dev/test account
];
