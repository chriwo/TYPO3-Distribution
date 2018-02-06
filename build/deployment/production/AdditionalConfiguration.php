<?php

$allowedContext = [
    'production' => 'production',
    'production/staging' => 'staging',
    'development' => 'development'
];
$context = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext());

$configLoader = \ChriWo\TYPO3\Distribution\ConfigLoaderFactory::buildLoader(
    $allowedContext[$context],
    $rootDir = dirname(dirname(__DIR__)),
    $fixedCacheIdentifier = getenv('CONFIGURATION_CACHE_IDENTIFIER')
);

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
    $GLOBALS['TYPO3_CONF_VARS'],
    $configLoader->load()
);
