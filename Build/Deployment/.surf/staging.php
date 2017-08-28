<?php

/**
 * define how many releases are available on deployment server
 */
const MAX_RELEASES = 5;

/**
 * define the php binary
 * mittwald: php_cli
 * domain_factory: /usr/local/bin/php5-56STABLE-CLI or /usr/local/bin/php7-70STABLE-CLI
 */
const PHP_REMOTE_BINARY = '';

/**
 * define the absulute path on server to deploy
 * if yout don't know the path create an php file on deployment server with "echo __FILE__;"
 */
const DEPLOYMENT_PATH = '';

/**
 * define the host url without http and www
 */
const DEPLOYMENT_HOST = '';

/**
 * define the repository
 * e.g. for bitbucket: git@bitbucket.org:your-username/your-project.git
 */
const REPOSITORY = '';

/**
 * define the ssh user to have access to the deployment server
 */
const SSH_USER = '';

$node = new \TYPO3\Surf\Domain\Model\Node(DEPLOYMENT_HOST);
$node->setHostname(DEPLOYMENT_HOST);

$application = new \ChriWo\Distribution\Deployment\Application\DistributionApplication(
    DEPLOYMENT_PATH,
    DEPLOYMENT_HOST
);
$application->setContext('Production/Staging');
$application->setOption('username', SSH_USER);
$application->setOption('phpBinaryPathAndFilename', PHP_REMOTE_BINARY);
$application->setOption('keepReleases', MAX_RELEASES);
$application->setOption('repositoryUrl', REPOSITORY);
$application->addNode($node);

/** @var \TYPO3\Surf\Domain\Model\Deployment $deployment */
$deployment->addApplication($application);

// enable the next 2 line, if on the deployment server an symlink of index.php is not allow
//$workflow = $deployment->getWorkflow();
//$workflow->addTask(\ChriWo\Distribution\Deployment\Task\CopyIndexPhpTask::class, 'migrate', $this);
