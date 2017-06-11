<?php
namespace ChriWo\Distribution\Deployment\Task;

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
use TYPO3\CMS\Core\Resource\Exception\InvalidConfigurationException;
use TYPO3\Surf\Domain\Model\Application;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Node;
use TYPO3\Surf\Task\ShellTask;

/**
 * Class CopyIndexPhpTask
 */
class CopyIndexPhpTask extends ShellTask
{
    /**
     * Remove the index.php symlink and copy this file from vendor into web root
     *
     * @param \TYPO3\Surf\Domain\Model\Node $node
     * @param \TYPO3\Surf\Domain\Model\Application $application
     * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
     * @param array $options
     * @throws \TYPO3\CMS\Core\Resource\Exception\InvalidConfigurationException
     */
    public function execute(Node $node, Application $application, Deployment $deployment, array $options = array())
    {
        $webRootPath = $deployment->getApplicationReleasePath($application)
            . '/' . $application->getOption('webDirectory');
        if (empty($webRootPath)) {
            throw new InvalidConfigurationException(
                'The release path is not defined, so the index.php can not be created',
                1496818662
            );
        }

        $this->removeIndexFile($webRootPath, $node, $deployment);
        $this->copyIndexFile($webRootPath, $node, $deployment);
    }

    /**
     * Remove the index.php symlink
     *
     * @param string $webRootPath
     * @param \TYPO3\Surf\Domain\Model\Node $node
     * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
     * @return void
     */
    private function removeIndexFile(
        $webRootPath,
        Node $node,
        Deployment $deployment
    ) {
        $command = 'rm -f ' . $webRootPath . '/index.php';
        $this->shell->executeOrSimulate($command, $node, $deployment);
    }

    /**
     * Copy the index.ph file in web root
     *
     * @param string $webRootPath
     * @param \TYPO3\Surf\Domain\Model\Node $node
     * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
     * @return void
     */
    private function copyIndexFile(
        $webRootPath,
        Node $node,
        Deployment $deployment
    ) {
        $command = 'cp ' . $webRootPath . '/../vendor/typo3/cms/index.php ' . $webRootPath . '/index.php';
        $this->shell->executeOrSimulate($command, $node, $deployment);
    }
}
