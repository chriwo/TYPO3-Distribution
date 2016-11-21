<?php
namespace Task;

use Mage\Task\AbstractTask;

/**
 * Class RmDeprecationFile
 *
 * @package Magallanes
 */
class RmIndexSymlink extends AbstractTask
{

    /**
     * Returns the task name
     *
     * @return string
     */
    public function getName()
    {
        return 'Remove symlink of index.php and add original index.php';
    }

    /**
     * Execute the task
     *
     * @return bool
     */
    public function run()
    {
        $command = 'rm -f web/index.php && cp vendor/typo3/cms/index.php web/index.php';
        $result = $this->runCommandRemote($command);

        return $result;
    }
}
