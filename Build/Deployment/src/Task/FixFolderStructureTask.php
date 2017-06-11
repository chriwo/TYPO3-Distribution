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
use TYPO3\Surf\Task\TYPO3\CMS\AbstractCliTask;

/**
 * Class FixFolderStructureTask
 */
class FixFolderStructureTask extends AbstractCliTask
{
    /**
     * Update all available languages in TYPO3 CSM via typo3_console
     *
     * @param \TYPO3\Surf\Domain\Model\Node $node
     * @param \TYPO3\Surf\Domain\Model\Application $application
     * @param \TYPO3\Surf\Domain\Model\Deployment $deployment
     * @param array $options
     * @throws \TYPO3\CMS\Core\Resource\Exception\InvalidConfigurationException
     */
    public function execute(Node $node, Application $application, Deployment $deployment, array $options = array())
    {
        $this->ensureApplicationIsTypo3Cms($application);

        try {
            $scriptFileName = $this->getConsoleScriptFileName($node, $application, $deployment, $options);
        } catch (InvalidConfigurationException $e) {
            throw new InvalidConfigurationException(
                'No typo3_console package found to update language packages. We canot proceed.',
                1496817393,
                $e
            );
        }

        $commandArguments = array($scriptFileName, 'install:fixfolderstructure');
        $this->executeCliCommand($commandArguments, $node, $application, $deployment, $options);
    }
}
