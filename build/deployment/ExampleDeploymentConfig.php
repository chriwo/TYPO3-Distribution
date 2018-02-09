<?php

/**
 * Name of customer
 */
const CUSTOMER = '';

/**
 * Set to true, if you deploy at first time
 */
const INITIAL_DEPLOYMENT = false;

/**
 * Production, Production/Staging, Development, Testing
 */
const DEPLOYMENT_CONTEXT = '';

/**
 * Compare mode
 * "*" all updates
 * "field.*" all field updates
 * "*.add" add only new tables and fields
 * "*.change" only change updates
 * "*.add,*.change" all add and change updates
 *
 */
const DATABASE_COMPARE = '*.add';

/**
 * Define if you need a database backup
 */
const MAKE_DATABASE_BACKUP = false;

/**
 * Define exclude database tables
 */
const EXCLUDE_DATABASE_TABLES = 'fe_sessions,sys_history,sys_log';

/**
 * define how many releases are available on deployment server
 */
const MAX_RELEASES = 5;

/**
 * define the remote php binary
 *
 * mittwald: php_cli (PHP Version of domain)
 * domain_factory: /usr/local/bin/php5-56STABLE-CLI or /usr/local/bin/php7-70STABLE-CLI
 * jweiland: /usr/local/bin/php5-56STABLE-CLI or /usr/local/bin/php7-70STABLE-CLI
 * all-inkl: php (PHP Version of domain)
 * metanet: /opt/php70/bin/php
 */
const PHP_REMOTE_BINARY = '';

/**
 * define the local installed php binary
 * to get the correct path use "which php" on shell
 */
const PHP_LOCAL_BINARY = '';

/**
 * define the absolute path on server to deploy
 * if you don't know the path, change to the release path and "pwd" on shell
 */
const DEPLOYMENT_PATH = '';

/**
 * define the host url without http and www. You could also edit your ssh config to define host alias, e.g.
 *
 * Host name-of-alias
 *  ServerAliveInterval 10
 *  Hostname domain.com OR use the IP Address
 *  User ssh-username
 *  IdentityFile ~/.ssh/id_rsa
 */
const DEPLOYMENT_HOST = '';

/**
 * define the repository
 * e.g. for bitbucket: git@bitbucket.org:your-username/your-project.git
 * e.g. for github: git@github.com:your-username/your-project.git
 */
const REPOSITORY = '';

/**
 * define the ssh user to have access to the deployment server
 */
const SSH_USER = '';

/**
 * path to your composer binary
 */
const COMPOSER_PATH = '';

/*************************************************************************************************
 *
 * !!! Don't change the next lines or now what you do !!!
 *
 *************************************************************************************************/

$context = str_replace('/', '-', strtolower(DEPLOYMENT_CONTEXT));
$buildDeploymentPath = '{releasePath}/build/deployment/' . $context . '/';

$node = new \TYPO3\Surf\Domain\Model\Node(CUSTOMER);
$node->setHostname(DEPLOYMENT_HOST);

$application = new \TYPO3\Surf\Application\TYPO3\CMS(CUSTOMER);
$application->setDeploymentPath(DEPLOYMENT_PATH);
$application->setOption('initialDeployment', INITIAL_DEPLOYMENT);
$application->setContext(DEPLOYMENT_CONTEXT);
$application->setOption('username', SSH_USER);
$application->setOption('phpBinaryPathAndFilename', PHP_REMOTE_BINARY);
$application->setOption('keepReleases', MAX_RELEASES);
$application->setOption('repositoryUrl', REPOSITORY);
$application->setOption('composerCommandPath', PHP_LOCAL_BINARY . ' ' . COMPOSER_PATH);
$application->setOption('applicationRootDirectory', 'web');
$application->setOption('baseUrl', DEPLOYMENT_HOST);
$application->setOption('databaseCompareMode', DATABASE_COMPARE);
$application->setOption(
    'rsyncExcludes',
    [
        '.DS_Store',
        '/.editorconfig',
        '/.git',
        '/.gitignore',
        '/build.xml',
        '/shared',
        '/composer.json',
        '/composer.lock',
        '/web/composer.json',
        '/web/composer.lock',
        '/web/fileadmin',
        '/web/uploads'
    ]
);

setOptionDeploymentSource($application);

$application->setSymlinks(['conf' => '../../shared/conf']);
$application->addNode($node);

/** @var \TYPO3\Surf\Domain\Model\Deployment $deployment */
$deployment->addApplication($application);

$workflow = new \TYPO3\Surf\Domain\Model\SimpleWorkflow();

/**
 * Fix access rights for files and folders
 */
$fixAccessRights = [
    'command' => 'cd {releasePath} && find -type d -print0 | xargs -0 chmod 2775 && find -type f -print0 | xargs -0 chmod 0664'
];
$workflow->defineTask('fixAccessRights', 'TYPO3\\Surf\\Task\\ShellTask', $fixAccessRights);

/**
 * Fix access rights for sh files
 */
$fixAccessRightsForSh = [
    'command' => 'cd {releasePath}/build/cronjobs && find -type f -print0 | xargs -0 chmod 0750'
];
$workflow->defineTask('fixAccessRightsForSH', 'TYPO3\\Surf\\Task\\ShellTask', $fixAccessRightsForSh);

/**
 * Fix folder structure with TYPO3 console
 */
$fixFolderStructure = [
    'command' => PHP_REMOTE_BINARY . ' {releasePath}/vendor/bin/typo3cms install:fixfolderstructure',
];
$workflow->defineTask('fixFolderStructure', 'TYPO3\\Surf\\Task\\ShellTask', $fixFolderStructure);

/**
 * Update languages with TYPO3 console
 */
$updateLanguage = [
    'command' => PHP_REMOTE_BINARY . ' {releasePath}/vendor/bin/typo3cms language:update',
];
$workflow->defineTask('updateLanguage', 'TYPO3\\Surf\\Task\\ShellTask', $updateLanguage);
$workflow->addTask('updateLanguage', 'finalize');

if (INITIAL_DEPLOYMENT === false) {
    /**
     * Lock TYPO3 backend with TYPO3 console
     */
    $lockBackend = [
        'command' =>
            PHP_REMOTE_BINARY . ' {releasePath}/vendor/bin/typo3cms backend:lock && ' .
            PHP_REMOTE_BINARY . ' {currentPath}/vendor/bin/typo3cms backend:lock',
        'rollbackCommand' =>
            PHP_REMOTE_BINARY . ' {releasePath}/vendor/bin/typo3cms backend:unlock && ' .
            PHP_REMOTE_BINARY . ' {currentPath}/vendor/bin/typo3cms backend:unlock'
    ];
    $workflow->defineTask('lockBackend', 'TYPO3\\Surf\\Task\\ShellTask', $lockBackend);
    $workflow->addTask('lockBackend', 'migrate');
}

if (MAKE_DATABASE_BACKUP) {
    /**
     * Create database backup with TYPO3 console
     */
    $excludeTables = '';
    if (!empty(EXCLUDE_DATABASE_TABLES)) {
        $excludeTables = '--exclude-tables ' . EXCLUDE_DATABASE_TABLES;
    }
    $createDatabaseBackup = [
        'command' =>
            PHP_REMOTE_BINARY . ' {currentPath}/vendor/bin/typo3cms database:export '
            . $excludeTables . ' > {currentPath}/build/' . $context . '-database-backup.sql',
        'rollbackCommand' =>
            PHP_REMOTE_BINARY . ' {currentPath}/vendor/bin/typo3cms database:import '
            . '< {currentPath}/build/' . $context . '-database-backup.sql'
            . '&& rm -f {currentPath}/build/' . $context . '-database-backup.sql'
    ];
    $workflow->defineTask('createDatabaseBackup', 'TYPO3\\Surf\\Task\\ShellTask', $createDatabaseBackup);
    $workflow->addTask('createDatabaseBackup', 'migrate');
}

/**
 * Unlock TYPO3 backend with TYPO3 console
 */
$unlockBackend = [
    'command' => PHP_REMOTE_BINARY . ' {currentPath}/vendor/bin/typo3cms backend:unlock'
];
$workflow->defineTask('unlockBackend', 'TYPO3\\Surf\\Task\\ShellTask', $unlockBackend);
$workflow->addTask('unlockBackend', 'cleanup');

/**
 * Compare database
 */
$workflow->addTask('TYPO3\\Surf\\Task\\TYPO3\\CMS\\CompareDatabaseTask', 'migrate');

/**
 * Create task to remove the symlink of index.php file and get an copy from vendor directory
 */
$workflow->defineTask(
    'manageIndexFile',
    \TYPO3\Surf\Task\ShellTask::class,
    ['command' => 'rm -f {releasePath}/web/index.php && cp -f {releasePath}/vendor/typo3/cms/index.php {releasePath}/web/index.php']
);

/**
 * Remove and copy a hosting specified htaccess from shared directory
 */
$workflow->defineTask(
    'replaceHtaccess',
    \TYPO3\Surf\Task\ShellTask::class,
    ['command' => 'rm -f {releasePath}/web/.htaccess && cp -f ' . $buildDeploymentPath . '.htaccess {releasePath}/web/.htaccess']
);

/**
 * Remove and copy a htpasswd file.
 */
//$workflow->defineTask(
//    'replaceHtpasswd',
//    \TYPO3\Surf\Task\ShellTask::class,
//    ['command' => 'rm -f {releasePath}/web/typo3conf/.htpasswd && cp -f ' . $buildDeploymentPath . '.htpasswd {releasePath}/web/typo3conf/.htpasswd']
//);

/**
 * Remove and copy a hosting specified AdditionalConfiguration
 */
$workflow->defineTask(
    'replaceAdditionalConfiguration',
    \TYPO3\Surf\Task\ShellTask::class,
    ['command' => 'rm -f {releasePath}/web/typo3conf/AdditionalConfiguration.php && cp -f ' . $buildDeploymentPath . 'AdditionalConfiguration.php {releasePath}/web/typo3conf/AdditionalConfiguration.php']
);

$workflow
    ->afterStage(
        'transfer',
        ['fixAccessRights', 'fixAccessRightsForSH', 'manageIndexFile', 'replaceHtaccess', 'replaceAdditionalConfiguration'] //'replaceHtpasswd'
    )
    ->afterStage('switch', ['fixFolderStructure']);

$deployment->setWorkflow($workflow);

/**
 * This method checks whether there is a correct deployment source specified. If not, it throws an exception
 * TODO: This method is not project specific and
 * may be put into something like a Library of Surf deployment related
 * classes in the future.
 *
 * @param  \TYPO3\Surf\Application\TYPO3\CMS $application
 * @throws \Exception
 * @return void
 */
function setOptionDeploymentSource(\TYPO3\Surf\Application\TYPO3\CMS &$application)
{
    $source = getenv('DEPLOYMENT_SOURCE');

    if (!is_string($source)) {
        throw new \Exception(
            'DEPLOYMENT_SOURCE environment variable is missing. Pattern: "DEPLOYMENT_SOURCE=branch|tag|sha1:foobar"',
            1479391741322
        );
    }

    $sourceArray = explode(':', $source);

    if (count($sourceArray) === 2
        && in_array($sourceArray[0], ['sha1', 'branch', 'tag'])
    ) {
        $application->setOption($sourceArray[0], $sourceArray[1]);
    } else {
        throw new \InvalidArgumentException(
            'DEPLOYMENT_SOURCE environment variable does not meet the mandatory pattern. Pattern: "DEPLOYMENT_SOURCE=branch|tag|sha1:foobar", 1479391747337',
            1455797642
        );
    }
}
