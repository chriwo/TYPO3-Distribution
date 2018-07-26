<?php

$contextConfiguration = [
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
        'sitename' => 'Project [Development-ddev]',
        'displayErrors' => true,
        'devIPmask' => '*',
        'sqlDebug' => true,
        'enableDeprecationLog' => 'file',
        'exceptionalErrors' => E_WARNING | E_USER_ERROR | E_RECOVERABLE_ERROR | E_DEPRECATED | E_USER_DEPRECATED,
        'systemLogLevel' => 0,
        'trustedHostsPattern' => '.*',
        'systemLog' => 'error_log',
        'syslogErrorReporting' => true,
        'belogErrorReporting' => true
    ],
    'BE' => [
        'installToolPassword' => md5(getenv('TYPO3_INSTALL_TOOL_PASSWORD')),
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
    'LOG' => [
        'writerConfiguration' => [
            \TYPO3\CMS\Core\Log\LogLevel::WARNING => [
                \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                    'logFile' => dirname(PATH_site) . '/build/log/typo3-default.log'
                ]
            ]
        ]
    ]
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$contextConfiguration);
