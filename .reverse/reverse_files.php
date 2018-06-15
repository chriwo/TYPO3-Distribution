<?php

$configuration = include_once('config.php');
$reverseDeploy = new \JoRo\Typo3ReverseDeployment();

/**
 * Set server paths
 */
$reverseDeploy->setTypo3RootPath($configuration['typo3-root']);
$reverseDeploy->setPhpPathAndBinary($configuration['php-binary']);

/**
 * Connect to Server
 */
$reverseDeploy->setUser($configuration['ssh-user']);
$ssh = $reverseDeploy->ssh($configuration['ssh-server']);

/**
 * Get fileadmin and uploads folder
 */
$reverseDeploy->setInclude($configuration['file-source']);
$reverseDeploy->setFileTarget($configuration['file-target']);
$reverseDeploy->getFiles($ssh);
