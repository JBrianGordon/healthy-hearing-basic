<?php
namespace App\Command\Helper;
 
use Cake\Console\Helper;
use Cake\Core\Configure;
use Cake\Filesystem\File;
use Exception;
 
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
            $this->_io->hr();
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


    /**
     * Copy a local file to an SFTP server
     *
     * @param string $serverName Server hostname or IP
     * @param string $username SSH username
     * @param string $localFilename Path to local file
     * @param string|null $password SSH password (null if using key auth)
     * @param string|null $remoteFilename Remote path (defaults to local filename)
     * @param string|null $sshKeyPublic Path to public key file
     * @param string|null $sshKeyPrivate Path to private key file
     * @param string|null $keyPassword Password for private key (if encrypted)
     * @return bool Success status
     */
    function sftpCopyFile(
        string $serverName,
        string $username,
        string $localFilename,
        ?string $password = null,
        ?string $remoteFilename = null,
        ?string $sshKeyPublic = null,
        ?string $sshKeyPrivate = null,
        ?string $keyPassword = null
    ): bool {
        if (empty($remoteFilename)) {
            $remoteFilename = $localFilename;
        }

        $this->_io->info("Copying {$localFilename} to {$serverName}/{$remoteFilename}");

        try {
            // Verify local file exists
            if (!file_exists($localFilename) || !is_readable($localFilename)) {
                $this->_io->error("Local file not found or not readable: {$localFilename}");
                return false;
            }

            $sftp = new \phpseclib3\Net\SFTP($serverName);

            // Authenticate
            $authenticated = false;
            if (!empty($sshKeyPrivate)) {
                $key = \phpseclib3\Crypt\PublicKeyLoader::load(
                    file_get_contents($sshKeyPrivate),
                    $keyPassword
                );
                $authenticated = $sftp->login($username, $key);
            } elseif (!empty($password)) {
                $authenticated = $sftp->login($username, $password);
            } else {
                $this->_io->error("No authentication method provided");
                return false;
            }

            if (!$authenticated) {
                $this->_io->error("Failed to authenticate to {$serverName}");
                return false;
            }

            // Upload file
            $result = $sftp->put($remoteFilename, $localFilename, \phpseclib3\Net\SFTP::SOURCE_LOCAL_FILE);

            if (!$result) {
                $this->_io->error("Failed to upload file to {$serverName}");
                return false;
            }

            $this->_io->success("Successfully copied file to {$serverName}/{$remoteFilename}");
            return true;

        } catch (Exception $e) {
            $this->_io->error("Exception: {$e->getMessage()}");
            return false;
        }
    }

    /**
    * Copy a remote file to a local location via sftp
    */
    function sftpRetrieveFile($serverName, $username, $password, $remoteName, $localName){
        $this->_io->info('Copying ' . $remoteName . ' from ' . $serverName . ' to ' . $localName);
        try {
            $remoteName = rawurlencode($remoteName);
            $remote = "sftp://$serverName/$remoteName";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $remote);
            curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
            curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            file_put_contents($localName, curl_exec($curl));
            $errorCode = curl_errno($curl);
            curl_close($curl);
            if ($errorCode) {
                $this->_io->error('Curl error: '.$errorCode);
                $this->_io->error(curl_strerror($errorCode));
                return false;
            }
        } catch (Exception $e) {
            error_log('Exception: ' . $e->getMessage());
            $this->_io->error('Exception: ' . $e->getMessage());
            return false;
        }
        return true;
    }
}
