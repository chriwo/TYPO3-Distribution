<?php
namespace ChriWo\Distribution\Deployment\Application;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Christian Wolfram <c.wolfram@chriwo.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use ChriWo\Distribution\Deployment\Task\FixFolderStructureTask;
use ChriWo\Distribution\Deployment\Task\LanguageUpdateTask;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Workflow;
use TYPO3\Surf\Task\Php\WebOpcacheResetCreateScriptTask;
use TYPO3\Surf\Task\Php\WebOpcacheResetExecuteTask;

/**
 * Class DistributionApplication
 */
class DistributionApplication extends \TYPO3\Surf\Application\TYPO3\CMS
{
    /**
     * DistributionApplication constructor.
     *
     * @param string $deploymentPath
     * @param string $baseUrl
     * @throws \Exception
     */
    public function __construct($deploymentPath, $baseUrl)
    {
        if (!$deploymentPath) {
            throw new \Exception(
                'Deployment path was not set in Surf deployment configuration file',
                '1496339499'
            );
        }

        if (!$baseUrl) {
            throw new \Exception(
                'Base URL was not set in Surf deployment configuration file',
                '1496339565'
            );
        }

        parent::__construct();

        $this->setOptionDeploymentSource();
        $this->setOption('composerCommandPath', 'composer');
        $this->setOption('scriptFileName', 'typo3cms');
        $this->setOption('applicationRootDirectory', 'web');
        $this->setOption('baseUrl', $baseUrl);
        $this->setOption('databaseCompareMode', '*.add');
        $this->setOption(
            'rsyncExcludes',
            [
                '.DS_Store',
                '/.editorconfig',
                '/.git',
                '/.gitignore',
                '/build',
                '/build.xml',
                '/web/composer.json',
                '/web/composer.lock',
                '/web/fileadmin',
                '/web/uploads'
            ]
        );

        // The folders "fileadmin", "uploads" and "AdditionalConfiguration" must not be part
        // of your repository as they contain user generated content or contain node specific
        // settings in the "AdditionalConfiguration".
        $this->setSymlinks(
            [
                $this->getOption('applicationRootDirectory') . '/fileadmin' => '../../../shared/data/fileadmin',
                $this->getOption('applicationRootDirectory') . '/uploads' => '../../../shared/data/uploads',
                'conf' => '../../shared/conf'
            ]
        );

        $this->setDeploymentPath($deploymentPath);
    }

    /**
     * @param Workflow $workflow
     * @param Deployment $deployment
     */
    public function registerTasks(Workflow $workflow, Deployment $deployment)
    {
        parent::registerTasks($workflow, $deployment);
        $workflow->addTask(WebOpcacheResetCreateScriptTask::class, 'package', $this);
        $workflow->addTask(FixFolderStructureTask::class, 'migrate', $this);
        $workflow->addTask(LanguageUpdateTask::class, 'finalize', $this);
        $workflow->addTask(WebOpcacheResetExecuteTask::class, 'switch', $this);
    }

    /**
     * This method checks whether there is a correct deployment source specified. If not, it throws an exception
     * TODO: This method is not project specific and
     * may be put into something like a Library of Surf deployment related
     * classes in the future.
     *
     * @throws \Exception
     * @return void
     */
    protected function setOptionDeploymentSource()
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
            $this->setOption($sourceArray[0], $sourceArray[1]);
        } else {
            throw new \InvalidArgumentException(
                'DEPLOYMENT_SOURCE environment variable does not meet the mandatory pattern. Pattern: "DEPLOYMENT_SOURCE=branch|tag|sha1:foobar", 1479391747337',
                1455797642
            );
        }
    }
}
