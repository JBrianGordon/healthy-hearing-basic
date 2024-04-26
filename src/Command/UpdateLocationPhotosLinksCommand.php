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
 * UpdateLocationPhotosLinks command.
 */
class UpdateLocationPhotosLinksCommand extends Command
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

        // Fetch all LocationPhoto entities
        $locationPhotosTable =$this->fetchTable('location_photos');
        $locationPhotosItems = $locationPhotosTable->find('all');

        foreach ($locationPhotosItems as $locationPhoto) {
            $io->out('Location Photo ID: ' . $locationPhoto->id);

            // ---- Location Photo photo_url ---- //

            $photoUrl = str_replace('https://www.healthyhearing.com', '', $locationPhoto->photo_url);
            $photoUrl = 'https://www.healthyhearing.com/cloudfiles/clinics/' . $locationPhoto->photo_url;
            $photoUrlEncoded = 'https://www.healthyhearing.com/cloudfiles/clinics/' . $this->urlEncoder($locationPhoto->photo_url);

            // Check if any old filename matches the locationPhoto record's photo_url
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (strpos($photoUrl, $oldFilename) !== false) {
                    // Update the locationPhoto record's photo_url
                    $locationPhoto->photo_url = $newFilename;
                    break; // Stop checking other old filenames
                }
            }
            // Check if any old filename matches the locationPhoto record's photo_url with encoding
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (strpos($photoUrlEncoded, $oldFilename) !== false) {
                    // Update the locationPhoto record's photo_url
                    $locationPhoto->photo_url = $newFilename;
                    break; // Stop checking other old filenames
                }
            }

            // Save the entity back to the database
            $locationPhotosTable->save($locationPhoto);
        }
    }

    public function urlEncoder($url)
    {
        if ($url === null) {
            return '';
        }
        return str_replace(
            [' ', '[', ']', ',', '(', ')'],
            ['%20', '%5B', '%5D', '%2C', '%28', '%29'], 
            $url
        );
    }
}
