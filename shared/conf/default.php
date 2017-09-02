<?php

return [
    'BE' => [
        'explicitADmode' => 'explicitAllow',
        'loginSecurityLevel' => 'rsa',
        'versionNumberInFilename' => '0'
    ],
    'FE' => [
        'compressionLevel' => '5',
        'loginSecurityLevel' => 'rsa'
    ],
    'SYS' => [
        'phpTimeZone' => 'Europe/Berlin',
        'ddmmyy' => 'd.m.Y',
        'curlUse' => '1',
        'clearCacheSystem' => '1'
    ],
    'EXTCONF' => [
        'lang' => [
            'availableLanguages' => [
                'de'
            ]
        ]
    ],
    'HTTP' => [
        'adapter' => 'curl'
    ]
];
