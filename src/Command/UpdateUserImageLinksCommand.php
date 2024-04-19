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
 * UpdateUserImageLinks command.
 */
class UpdateUserImageLinksCommand extends Command
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

        // Fetch all User entities
        $usersTable =$this->fetchTable('users');
        $usersItems = $usersTable->find('all');

        foreach ($usersItems as $user) {
            $io->out('User ID: ' . $user->id);

            // ---- User image_url ---- //

            $imageUrl = 
                'https://www.healthyhearing.com' . 
                str_replace('/img/about', '/images', $this->urlEncoder($user->image_url));

            // Check if any old filename matches the user record's image_url
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (strpos($imageUrl, $oldFilename) !== false) {
                    // Update the user record's image_url
                    $user->image_url = $newFilename;
                    break; // Stop checking other old filenames
                }
            }

            // Save the entity back to the database
            $usersTable->save($user);
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
