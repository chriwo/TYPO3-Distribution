<?php
namespace Task;

use Mage\Task\AbstractTask;

/**
 * Class RewriteHtaccess
 *
 * @package Magallanes
 * @author Christian Wolfram <c.wolfram@chriwo.de>
 */
class RewriteHtaccess extends AbstractTask
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
        return 'Rewrite the backups of htaccess and htpasswd if their exits';
    }

    /**
     * Main function of the task
     *
     * @return bool
     */
    public function run()
    {
        $this->setRootPath();
        $this->rewriteHtaccess();
        $this->rewriteHtpasswd();
        return $this->executionResult;
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

    /**
     * Rewrite the htaccess file from a backup, if the file exits
     *
     * @return void
     */
    private function rewriteHtaccess()
    {
        if (file_exists($this->getRootPath() . '.htaccess_backup')) {
            if (file_exists($this->getRootPath() . '.htaccess')) {
                $command = 'rm -f web/.htaccess';
                $this->executionResult = $this->runCommandRemote($command);
            }

            $command = 'mv .htaccess_backup web/.htaccess';
            $this->executionResult = $this->runCommandRemote($command);
        }
    }

    /**
     * Rewrite the htpasswd file from a backup, if the file exits
     */
    private function rewriteHtpasswd()
    {
        if (file_exists($this->getRootPath() . '.htpasswd_backup')) {
            if (file_exists($this->getRootPath() . '.htpasswd')) {
                $command = 'rm -f web/.htpasswd';
                $this->executionResult = $this->runCommandRemote($command);
            }

            $command = 'mv .htpasswd_backup web/.htpasswd';
            $this->executionResult = $this->runCommandRemote($command);
        }
    }
}
