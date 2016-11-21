<?php
namespace Task;

use Mage\Task\AbstractTask;

/**
 * Class RmDeprecationFile
 *
 * @package Magallanes
 */
class RmDeprecationFile extends AbstractTask
{

    /**
     * Returns the task name
     *
     * @return string
     */
    public function getName()
    {
        return 'Remove the deprecation file(s)';
    }

    /**
     * Execute the task
     *
     * @return bool
     */
    public function run()
    {
        $command = 'cd web/typo3conf && rm -f deprecation_*';
        $result = $this->runCommandRemote($command);

        return $result;
    }
}
