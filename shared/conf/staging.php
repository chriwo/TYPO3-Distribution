<?php

return [
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'dbname' => '',
                'driver' => 'mysqli',
                'host' => '',
                'password' => '',
                'port' => 3306,
                'user' => ''
            ]
        ]
    ],
    'SYS' => [
        'sitename' => '[Staging]',
        'displayErrors' => false,
        'devIPmask' => '',
        'sqlDebug' => false,
        'enableDeprecationLog' => '',
        'exceptionalErrors' => E_WARNING | E_USER_ERROR | E_RECOVERABLE_ERROR | E_DEPRECATED | E_USER_DEPRECATED,
        'systemLogLevel' => 0,
        'clearCacheSystem' => '1',
        'curlUse' => '1'
    ],
    'BE' => [
        'debug' => false
    ],
    'FE' => [
        'debug' => false
    ],
    'HTTP' => [
        'adapter' => 'curl'
    ]
];
