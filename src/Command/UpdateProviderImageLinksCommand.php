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
 * UpdateProviderImageLinks command.
 */
class UpdateProviderImageLinksCommand extends Command
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

        // Fetch all Provider entities
        $providersTable =$this->fetchTable('providers');
        $providersItems = $providersTable->find('all');

        foreach ($providersItems as $provider) {
            $io->out('Provider ID: ' . $provider->id);

            // ---- Provider thumb_url ---- //

            $thumbUrl = $provider->thumb_url;
            $thumbUrlEncoded = $this->urlEncoder($provider->thumb_url);

            // Check if any old filename matches the provider record's thumb_url
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($thumbUrl) &&
                    strpos('/cloudfiles/clinicians/' . $thumbUrl, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                    // Update the provider record's photo info
                    $provider->photo_name = basename($oldFilename);
                    $provider->photo_url = $newFilename;
                    break; // Stop checking other old filenames and exit main foreach()
                }
            }

            // Check if any old filename matches the provider record's thumb_url with encoding
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($thumbUrl) &&
                    strpos('/cloudfiles/clinicians/' . $thumbUrlEncoded, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                    // Update the provider record's photo info
                    $provider->photo_name = basename($oldFilename);
                    $provider->photo_url = $newFilename;
                    break; // Stop checking other old filenames
                }
            }

            // Save the entity back to the database
            $providersTable->save($provider);
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
