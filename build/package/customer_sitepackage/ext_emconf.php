<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Customer sitepackage',
    'description' => 'Customer sitepackage extension',
    'category' => 'distribution',
    'author' => '',
    'author_email' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '',
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.99',
            'php' => '7.0.0-7.0.00',
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
