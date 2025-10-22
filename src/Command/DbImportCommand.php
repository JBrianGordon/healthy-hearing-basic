<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

/**
 * DbImport command.
 */
class DbImportCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'db import';
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);
        $parser
            ->setDescription('Import a database backup into a local/dev/qa environment');
        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->out("Database import...");

        $environment = Configure::read('env');
        if (empty($environment)) {
            $io->error('An environment must be set (e.g. local/dev/qa/prod)');
            $this->abort();
        }
        $environment = strtolower($environment);

        if ($environment == 'prod') {
            $io->error('This command cannot be run on a production server.');
            $this->abort();
        }
        if (!in_array($environment, ['local', 'dev', 'qa'])) {
            $io->error('This command can only be run in a local/dev/qa environment');
            $this->abort();
        }
        // TO-DO from CakePHP 2.x HH application: ALLOW FOR DB NAMES AS ARGUMENTS?

        $this->loadSettings();

        $io->helper('BaseShell')->promptContinue("Would you like to import a recent database file?");

        // Retrieve database dump file
        $dbFile = $this->getDbFile($io);

        $success = false;
        // Import database dump file;
        if (!empty($dbFile)) {
            $success = $this->importDatabase($io, $dbFile);
        }
        if ($success) {
            $io->success('Import completed successfully.');
        } else {
            $io->error('Database file not downloaded successfully.');
            $this->abort();
        }

        //Run migrations
        $io->out('Running migrations...');
        $this->runUpgradeSteps($io);
    }

    private function loadSettings(): void
    {
        $fullConfig = Configure::read('DbShell');
        $this->dbFilePrefix = $fullConfig['dbFilePrefix'];
        $this->dbFileExt = $fullConfig['dbFileExt'];
        $this->localDir = $fullConfig['localDir'];
        $this->dbServer = $fullConfig['dbServer'];
        $this->remoteFolder = $fullConfig['remoteFolder'];
    }

    private function getDbFile(ConsoleIo $io, $date = '', $attempts = 1)
    {
        // Get the date of the db file we're trying to retrieve.
        $dbDate = date('Y.m.d', strtotime('Tomorrow'));
        // If we have a date sent to us, parse it
        if (!empty($date)) {
            $dbDate = date('Y.m.d', strtotime($date));
        }

        // Assemble to dbFile string
        $dbFile = $this->dbFilePrefix . '.' . $dbDate . $this->dbFileExt;

        // Let the user know what we're doing, and what attempt we're on.
        $io->out("Attempting to scp file: " . $dbFile . "  (Attempt: " . ($attempts) . ")");

        // Attempt to scp the db backup from the remote server to our local folder (usually /tmp)
        // TO-DO: TEMPORARY CP/COPY STEP FOR 'DEV' WHILE WE DON'T HAVE LIVE DB BACKUP SERVER
        if (Configure::read('env') === 'dev' || 'local') {
            $cpResult = exec('cp ' . $this->remoteFolder . $dbFile . ' ' . $this->localDir);
        } else {
            $scpResult = exec('scp ' . $this->dbServer . ':' . $this->remoteFolder . $dbFile . ' ' . $this->localDir);
        }

        // Check to see if it worked.
        if (!file_exists($this->localDir . $dbFile)) {
            $io->warning('Unable to find db file for date: ' . $dbDate);

            // Attempt up to 7 times.
            if ($attempts >= 20) {
                $io->error('No database file could be retrieved.');
                return false;
            }

            // strtotime doesn't recognize Y.m.d as a valid date format
            $dbDate  = str_replace('.', '-', $dbDate);
            // Attempt to get the db file from the day before.
            $newDate = date('Y-m-d', strtotime($dbDate . ' - 1 Day'));
            // Use recursion to attempt to get a valid db file.
            return $this->getDbFile($io, $newDate, $attempts + 1);
        } else {
            $io->success('File retrieved sucessfully!');
        }

        return $this->localDir . $dbFile;
    }

    private function importDatabase(ConsoleIo $io, $filename, $dbName = '')
    {

        $connection = ConnectionManager::get('default');
        $dbConfig = $connection->config();

        if (substr($filename, -3) == '.gz') {
            $io->out("Decompressing file...");
            exec('gunzip -f ' . $filename);
            $unzippedFilename = substr($filename, 0, -3); // remove the .gz
        }

        // Use the default db if there wasn't one passed.
        if (empty($dbName)) {
            $dbName =  $dbConfig['database'];
        }

        try {
            // Prompt the user about deleting the database.
            if ($io->helper('BaseShell')->promptContinue('Would you like to delete the current copy of ' . $dbName . '?')) {
                $this->deleteDatabase($io, $dbName);
            }

            // Import the database file
            $io->out('Importing file: ' . $unzippedFilename);

            // Start timing
            $startTime = time();

            $importCommand = 'mysql --compress -u ' . $dbConfig['username'] . ' -h ' . $dbConfig['host'] . ' --password=' . $dbConfig['password'] . ' ' . $dbName . ' < ' . $unzippedFilename;
            exec($importCommand);

            // End timing
            $endTime = time();
            $duration = $endTime - $startTime;

            $io->out("Import completed in " . $duration . " seconds.");

        } catch (Exception $e) {
            // Catch the error, so no db info will be exposed to cli
            $io->error('Unable to import database.');
            $this->abort();
        }

        $io->out('Cleaning up...');
        if (file_exists($unzippedFilename)) {
            unlink($unzippedFilename);
        }

        $io->success('Database import finished.');

        return true;
    }

    private function deleteDatabase(ConsoleIo $io, $dbName)
    {
        $connection = ConnectionManager::get('default');

        if ($io->helper('BaseShell')->promptContinue('Are you sure you want to delete the database?')) {
            $io->out('Deleting database...');
            $connection->execute('DROP DATABASE IF EXISTS `' . $dbName . '`');
            $io->out('Database deleted.');

            $io->out('Creating new database: ' . $dbName);
            $connection->execute('CREATE DATABASE `' . $dbName . '`');

            // Select the newly created database
            $connection->execute('USE ' . $dbName);
        }
    }

    private function runUpgradeSteps(ConsoleIo $io)
    {
        $io->out('Running upgrade migrations...');
        exec('bin/cake migrations migrate -s Migrations/Upgrade');

        $io->out('Mark initial schema migration as migrated...');
        exec('bin/cake migrations mark_migrated --target=20211215181346 --only');

        $io->out('Running migrations...');
        exec('bin/cake migrations migrate');

        $io->out('Run dereuromark Queue plugin migrations...');
        exec('bin/cake migrations migrate -p Queue');

        $io->out('Copy Cake 2.x locationUsers data into Cake 4.x users table...');
        exec('bin/cake copy_location_users_data');

        $io->out('Run script to populate locationsUsers table...');
        exec('bin/cake populate_locations_users');

        $io->out('Run script to copy Cake 2.x zipcodes table data into Cake 4.x zips table...');
        $this->executeCommand(CopyZipcodesDataCommand::class);

        $io->out('Update admin user roles');

        $connection = ConnectionManager::get('default');

        if (Configure::read('country') == 'US') {
            # Set Shantelle to 'active' in US
            $connection->update('users', ['active' => 1], ['id' => 1000000035]);

            $adminIds = [
                7500, # Susanne
                7597, # Becky
                8544, # Bill
                8275, # Kate
                8472, # Brittany
                1000000013, # Joy
                1000000014, # Brian
                1000000027, # April
                1000000037, # Debbie
                1000000035, # Shantelle
            ];
        } else {
            $adminIds = [
                7500, # Susanne
                7597, # Becky
                8544, # Bill
                1000000002, # Kate
                1000000007, # Joy
                1000000009, # Brian
                1000000013, # Shantelle
            ];
        }

        foreach ($adminIds as $adminId) {
            $connection->update('users', ['role' => 'admin'], ['id' => $adminId]);
        }

        $io->success('All done!');
    }
}