<?php

use Cake\Core\Configure;

// Wiki/Help Page categories
$wikiCategories = [
    'hearing-loss',
    'hearing-aids',
];
if (Configure::read('showTinnitus')) {
    $wikiCategories[] = 'tinnitus';
}
if (Configure::read('showAssistiveListening')) {
    $wikiCategories[] = 'assistive-listening-devices';
}
$wikiCategoriesRegex = '(?i:' . implode('|', $wikiCategories) . ')';

// Corp/manufacturer slugs
$corps = [
    'testcompany',
    'starkey-hearing-aids',
    'phonak-hearing-aids',
    'oticon-hearing-aids',
    'beltone-hearing-aids',
    'bernafon-hearing-aids',
    'microtech-hearing-aids',
    'signia-hearing-aids',
    'widex-hearing-aids',
    'unitron-hearing-aids',
    'sonic-innovations-hearing-aids',
    'rayovac-hearing-aid-batteries',
    'resound-hearing-aids',
    'energizer-hearing-aid-batteries',
    'cochlear-americas-cochlear-implants',
    'advanced-bionics-cochlear-implants',
    'oticon-medical-hearing-implants',
    'starkey',
    'oticon-medical',
    'oticon',
    'phonak',
    'resound',
    'beltone',
    'cochlear-americas',
    'unitron',
    'widex',
    'signia',
    'sonic-innovations',
    'sonic',
    'advanced-bionics',
];
$corpsRegex = '(?i:' . implode('|', $corps) . ')';

return [
    'corps' => $corps,
    'corpsRegex' => $corpsRegex,
    'wikiCategories' => $wikiCategories,
    'wikiCategoriesRegex' => $wikiCategoriesRegex,
];
