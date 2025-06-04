<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\TableRegistry;
use DOMDocument;

/**
 * UpdateLocationProfileImageLinks command.
 */
class UpdateLocationProfileImageLinksCommand extends Command
{
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

        $parser->addArgument('csv', [
            'help' => 'Path to the CSV file with the old and new filenames.',
            'required' => true,
        ]);

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
        $csvPath = $args->getArgument('csv');

        // Read the CSV file into an array
        $filenameMap = [];
        if (($handle = fopen($csvPath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $filenameMap[$data[0]] = $data[1];
            }
            fclose($handle);
        }

        // Fetch all Location entities
        $locationsTable =$this->fetchTable('locations');
        $locationsItems = $locationsTable->find('all');

        foreach ($locationsItems as $location) {
            $io->out('Location ID: ' . $location->id);

            // ---- Location logo_url ---- //

            $logoUrl = $location->logo_url;
            $logoUrlEncoded = $this->urlEncoder($location->logo_url);

            // Check if any old filename matches the location record's logo_url
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($logoUrl) &&
                    strpos('/cloudfiles/clinics/' . $logoUrl, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                    // Update the location record's logo
                    $location->logo_name = basename($oldFilename);
                    $location->logo_url = $newFilename;
                    break; // Stop checking other old filenames
                }
            }
            // Check if any old filename matches the location record's logo_url with encoding
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($logoUrl) &&
                    strpos('/cloudfiles/clinics/' . $logoUrlEncoded, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                    // Update the location record's logo
                    $location->logo_name = basename($oldFilename);
                    $location->logo_url = $newFilename;
                    break; // Stop checking other old filenames
                }
            }

            // Save the entity back to the database
            $locationsTable->save($location);
        }
    }

    public function urlEncoder($url)
    {
        if ($url == null) {
            return '';
        }
        return str_replace(
            [' ', '[', ']', ',', '(', ')'],
            ['%20', '%5B', '%5D', '%2C', '%28', '%29'], 
            $url
        );
    }
}
