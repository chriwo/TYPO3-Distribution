<?php
namespace Task;

use Mage\Task\AbstractTask;

/**
 * Class ClearCache
 * @package Magallanes
 */
class ClearCache extends AbstractTask
{

    /**
     * Returns the task name
     *
     * @return string
     */
    public function getName()
    {
        return 'Clear all caches';
    }

    /**
     * Execute the task
     *
     * @return bool
     */
    public function run()
    {
        $command = 'cd web && php ./typo3cms cache:flush';
        $result = $this->runCommandRemote($command);

        return $result;
    }
}
