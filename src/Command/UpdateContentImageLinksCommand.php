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
 * UpdateContentImageLinks command.
 */
class UpdateContentImageLinksCommand extends Command
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

        // Fetch all Content entities
        $contentTable =$this->fetchTable('content');
        $contentItems = $contentTable->find('all');

        foreach ($contentItems as $content) {
            $io->out('Content ID: ' . $content->id);

            // ---- Content Body Images ---- //

            // Create a new DOMDocument and load the HTML
            $doc = new DOMDocument();
            @$doc->loadHTML($content->body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            // Find all <img> elements
            $imgs = $doc->getElementsByTagName('img');

            foreach ($imgs as $img) {
                // Get the src attribute
                $oldSrc = $img->getAttribute('src');
                $oldSrc = 'https://www.healthyhearing.com' . $this->urlEncoder($oldSrc);

                // Check if any old filename partially matches the src
                foreach ($filenameMap as $oldFilename => $newFilename) {
                    if (strpos($oldSrc, $oldFilename) !== false) {
                        // Update the src attribute
                        $img->setAttribute('src', $newFilename);
                        break; // Stop checking other old filenames
                    }
                }
            }

            // Save the updated HTML back to the entity
            $content->body = $doc->saveHTML();


            // ---- Facebook Image ---- //

            $facebookImage = 'https://www.healthyhearing.com' . $this->urlEncoder($content->facebook_image);
            // Check if any old filename matches the content record's facebook_image
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (strpos($facebookImage, $oldFilename) !== false) {
                    // Update the content record's facebook_image
                    $content->facebook_image = $newFilename;
                    break; // Stop checking other old filenames
                }
            }

            // Save the entity back to the database
            $contentTable->save($content);
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
