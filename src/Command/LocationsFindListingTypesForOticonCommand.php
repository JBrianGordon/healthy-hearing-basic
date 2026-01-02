<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Entity\Location;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;

/**
 * LocationsFindListingTypesForOticon command.
 */
class LocationsFindListingTypesForOticonCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'locations findListingTypesForOticon';
    }

    protected $defaultTable = 'Locations';

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

        $parser->setDescription('Generate a spreadsheet of listing types for all active Oticon clinics');

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
        $io->info('Generate a spreadsheet of listing types for all active Oticon clinics');
        $io->hr();

        // Get the Locations table
        $locationsTable = $this->fetchTable('Locations');

        // Find all locations that came in from most recent Oticon import
        $locations = $locationsTable->find()
            ->select(['id', 'id_oticon', 'oticon_tier', 'listing_type', 'is_active', 'id_sf', 'created'])
            ->where(['oticon_tier !=' => 0])
            ->disableHydration()
            ->toArray();

        $io->out(sprintf('Found %d locations from the most recent oticon import.', count($locations)));

        // Build CSV content
        $data = "\"Id\",\"SFID\",\"listing_type\"\n";
        foreach ($locations as $location) {
            // If inactive, mark as LISTING_TYPE_NONE
            $listingType = $location['is_active']
                ? $location['listing_type']
                : Location::LISTING_TYPE_NONE;

            $data .= sprintf(
                "\"%s\",\"%s\",\"%s\"\n",
                $location['id_oticon'],
                $location['id_sf'],
                $listingType
            );
        }

        // $localFilename = TMP . 'hh_listing_types.csv';
        // $serverFilename = '/DF_SF_to_HH/Prod/hh_listing_types.csv';
        // Uncomment when testing on local, dev, qa, etc.
        $localFilename = TMP . 'TEST.csv';
        $serverFilename = '/DF_SF_to_HH/Test/TEST.csv';

        $io->helper('BaseShell')->writeFile($data, $localFilename, true);

        // Only upload on production environment
        if (Configure::read('env') === 'local') {
            $server = Configure::read('oticonSharedServer');

            $success = $io->helper('BaseShell')->sftpCopyFile(
                serverName: $server['server'],
                username: $server['username'],
                localFilename: $localFilename,
                password: $server['password'],
                remoteFilename: $serverFilename
            );

            if ($success) {
                $io->success('Successfully uploaded to Oticon shared server.');
            } else {
                $io->error('Failed to upload to Oticon shared server.');
            }
        } else {
            $io->out('Only copied to Oticon shared server on prod.');
        }

        $io->out('Done.');
    }
}