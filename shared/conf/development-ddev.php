<?php

return [
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'dbname' => 'db',
                'driver' => 'mysqli',
                'host' => 'db',
                'password' => 'db',
                'port' => 3306,
                'user' => 'db'
            ]
        ]
    ],
    'SYS' => [
        'sitename' => 'Customer [Development]',
        'displayErrors' => true,
        'devIPmask' => '*',
        'sqlDebug' => true,
        'enableDeprecationLog' => 'file',
        'exceptionalErrors' => E_WARNING | E_USER_ERROR | E_RECOVERABLE_ERROR | E_DEPRECATED | E_USER_DEPRECATED,
        'systemLogLevel' => 0,
        'trustedHostsPattern' => '.*'
    ],
    'BE' => [
        'installToolPassword' => '$pbkdf2-sha256$25000$kR85CoSl03Po3npugWfv6g$hzf6R5cZjfWfqDOgUUXckGrNQmcj.2l0coPvV9z8jt8',
        'debug' => true,
        'sessionTimeout' => 60 * 60 * 24 * 365
    ],
    'FE' => [
        'debug' => true
    ],
    'GFX' => [
        'processor' => 'ImageMagick',
        'processor_allowTemporaryMasksAsPng' => false,
        'processor_colorspace' => 'sRGB',
        'processor_effects' => 1,
        'processor_enabled' => true,
        'processor_path' => '/usr/bin/',
        'processor_path_lzw' => '/usr/bin/',
    ],
];
