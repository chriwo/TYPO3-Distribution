<?php
namespace Task;

use Mage\Task\AbstractTask;

/**
 * Class ChangeLocalConfiguration
 *
 * @package Magallanes
 */
class ChangeLocalConfiguration extends AbstractTask
{
    /**
     * Returns the name of the task
     *
     * @return string
     */
    public function getName()
    {
        return 'Move and delete LocalConfiguration';
    }

    /**
     * Execute the task
     *
     * @return bool
     */
    public function run()
    {
        $command = 'cd web/typo3conf && rm -f LocalConfiguration.php';
        $this->runCommandRemote($command);

        $instance = $this->getParameter('env', 'stag');
        $command = 'cd web/typo3conf && mv LocalConfiguration_' . $instance . '.php LocalConfiguration.php';
        $this->runCommandRemote($command);

        $command = 'cd web/typo3conf && rm -f LocalConfiguration_*';
        $result = $this->runCommandRemote($command);

        return $result;
    }
}
