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
 * UpdateAdImageLinks command.
 */
class UpdateAdImageLinksCommand extends Command
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

        // Fetch all Ad entities
        $adsTable =$this->fetchTable('advertisements');
        $adsItems = $adsTable->find('all');

        foreach ($adsItems as $ad) {
            $io->out('Ad ID: ' . $ad->id);

            // ---- Ad src ---- //

            $srcUrl = $ad->src;
            $srcUrlEncoded = $this->urlEncoder($ad->src);

            // Check if any old filename matches the ad record's src
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($srcUrl) &&
                    strpos($srcUrl, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                    // Update the ad record's src
                    $ad->src = basename($oldFilename);
                    $ad->public_url = $newFilename;
                    break; // Stop checking other old filenames
                }
            }
            // Check if any old filename matches the ad record's src with encoding
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($srcUrl) &&
                    strpos($srcUrlEncoded, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                    // Update the ad record's src
                    $ad->src = basename($oldFilename);
                    $ad->public_url = $newFilename;
                    break; // Stop checking other old filenames
                }
            }

            // Save the entity back to the database
            $adsTable->save($ad);
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
