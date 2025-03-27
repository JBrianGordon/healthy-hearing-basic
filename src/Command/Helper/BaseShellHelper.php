<?php
namespace App\Command\Helper;
 
use Cake\Console\Helper;
use Cake\Core\Configure;
use Cake\Filesystem\File;
 
class BaseShellHelper extends Helper
{
    public function output(array $args): void
    {
        $this->_io->out($args);
    }

    public function title($text = '') {
        $this->_io->out();
        $this->_io->hr();
        $this->_io->warning($text);
        $this->_io->hr();
    }

    /**
    * Get site host
    * @return site host name
    */
    public function getSiteHost() {
        if (Configure::read('env') == 'prod') {
            if (getHostName() == 'hhapp4') {
                return 'https://www4.healthyhearing.com';
            } elseif (getHostName() == 'hhapp2') {
                return 'https://www2.healthyhearing.com';
            } elseif (getHostName() == 'hhapp1') {
                return 'https://www1.healthyhearing.com';
            } elseif (getHostName() == 'caapp18') {
                return 'https://www.hearingdirectory.ca';
            }
        } else {
            return 'https://'.Configure::read('host');
        }
    }

    /**
    * Delete file
    * @param string filename to delete
    * @return boolean success. exit if fails
    */
    public function deleteFile($filename) {
        if (empty($filename)) {
            $this->_io->out("No filename given");
            return false;
        }
        $File = new File($filename);
        $this->_io->out();
        if ($File->delete()) {
            $this->_io->out("$filename deleted.");
            return true;
        }
        return false;
    }

    /**
    * Write file
    * @param data to write to file
    * @param string filename to write to
    * @param boolean bypass, if true bypass the overwrite prompt (default false)
    * @return boolean success. exit if fails
    */
    public function writeFile($data = null, $filename = 'output.csv', $bypass = false) {
        if (empty($data)) {
            $this->errorAndExit("No data to write to file.");
        }
        while(empty($filename)) {
            $filename = trim($this->in("Enter filename"));
        }
        $File = new File($filename);
        if ($File->exists() && !$bypass) {
            $this->promptContinue("$filename exists, are you sure you want to overwrite?");
        }
        $this->_io->out();
        if ($File->write($data)) {
            $this->_io->out("$filename written.");
            return true;
        } else {
            $this->errorAndExit("Unable to write to $filename");
        }
    }

    /**
    * Prompt the user with a yes no question
    * @param string text
    * @param string default answer
    * @return result strlowered
    */
    protected function promptYesNo($text, $default = "Y") {
        return trim(strtolower($this->_io->askChoice($text, ['Y','n','q'], $default)));
    }

    /**
    * Prompt to continue, helper method, will exit if answer is n or q, returns true otherwise
    * @param string text to prompt
    */
    public function promptContinue($text = null) {
        switch ($this->promptYesNo($text)) {
            case 'q':
            case 'n':
                $this->errorAndExit("Exiting.");
        }
        return true;
    }

    /**
    * Set an error message and exit
    * @param message
    */
    protected function errorAndExit($message = null) {
        $this->_io->out($message);
        exit();
    }
}
