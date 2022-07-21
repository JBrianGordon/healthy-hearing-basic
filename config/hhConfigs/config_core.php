<?php
/* Core Configurations */
$tagVersion = exec('git describe --tags');
$tagVersion = empty($tagVersion) ? 'v0.0' : $tagVersion; //temporary
return [
    'tagVersion' => $tagVersion
];
