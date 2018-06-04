<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'customer_sitepackage',
    'Configuration/TypoScript',
    'Customer'
);
