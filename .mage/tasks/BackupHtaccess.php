<?php
namespace Task;

use Mage\Task\AbstractTask;

/**
 * Class RewriteHtaccess
 *
 * @package Magallanes
 * @author Christian Wolfram <c.wolfram@chriwo.de>
 */
class BackupHtaccess extends AbstractTask
{
    /**
     * RootPath
     *
     * @var string
     */
    protected $rootPath = '';

    /**
     * Extecution result
     *
     * @var bool
     */
    protected $executionResult = false;

    /**
     * Get task name function
     *
     * @return string
     */
    public function getName()
    {
        return 'Backup htaccess and htpasswd';
    }

    /**
     * Main function of task
     *
     * @return bool
     */
    public function run()
    {
        $result = false;
        $this->setRootPath();

        if (file_exists($this->getRootPath() . '.htaccess')) {
            $command = 'cp web/.htaccess .htaccess_backup';
            $this->runCommandRemote($command);
        }

        if (file_exists($this->getRootPath() . '.htpasswd')) {
            $command = 'cp web/.htpasswd .htpasswd_backup';
            $result = $this->runCommandRemote($command);
        }

        return $result;
    }

    /**
     * Sets the rootPath from deployment configuration
     *
     * @return string
     */
    private function setRootPath()
    {
        if ($this->getConfig()->release('enabled', false) === true) {
            return $this->rootPath = $this->getConfig()->deployment('to')
                . '/' . $this->getConfig()->release('symlink', 'current')
                . '/web/';
        }

        return $this->getConfig()->deployment('to') . '/web/';
    }

    /**
     * Returns the rootPath
     *
     * @return string
     */
    private function getRootPath()
    {
        return $this->rootPath;
    }
}
