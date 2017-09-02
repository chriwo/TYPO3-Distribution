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
        'sitename' => '[Produktiv]',
        'displayErrors' => false,
        'devIPmask' => '',
        'sqlDebug' => false,
        'enableDeprecationLog' => '',
        'exceptionalErrors' => E_WARNING | E_USER_ERROR | E_RECOVERABLE_ERROR | E_DEPRECATED | E_USER_DEPRECATED,
        'systemLogLevel' => 0
    ],
    'BE' => [
        'installToolPassword' => '$pbkdf2-sha256$25000$kR85CoSl03Po3npugWfv6g$hzf6R5cZjfWfqDOgUUXckGrNQmcj.2l0coPvV9z8jt8',
        'debug' => false
    ],
    'FE' => [
        'debug' => false
    ],
    'GFX' => [
        'colorspace' => 'RGB',
        'im' => '1',
        'im_mask_temp_ext_gif' => '1',
        'im_path' => '/usr/bin/',
        'im_path_lzw' => '/usr/bin/',
        'im_v5effects' => '0',
        'im_version_5' => 'im6',
        'image_processing' => '1'
    ]
];
