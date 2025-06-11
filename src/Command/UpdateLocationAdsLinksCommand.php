<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\TableRegistry;
use DOMDocument;
use App\Utility\CKBoxUtility;
use Cake\Core\Configure;

/**
 * UpdateLocationAdsLinks command.
 */
class UpdateLocationAdsLinksCommand extends Command
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

        $ckCategoryId = Configure::read('CK.locationAds-uploads');
        $ckBoxUtility = new CKBoxUtility($ckCategoryId);

        // Fetch all LocationAd entities
        $locationAdsTable =$this->fetchTable('location_ads');
        $locationAdsItems = $locationAdsTable->find('all');

        foreach ($locationAdsItems as $locationAd) {
            $io->out('Location Ad ID: ' . $locationAd->id);

            // ---- Location Ad photo_url ---- //

            $photoUrl = $locationAd->photo_url;
            $photoUrlEncoded = $this->urlEncoder($locationAd->photo_url);

            // Check if any old filename matches the locationAd record's photo_url
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($photoUrl) &&
                    strpos('/cloudfiles/clinics/' . $photoUrl, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                        // Update the locationAd record's image info
                        $locationAd->image_name = basename($oldFilename);
                        $locationAd->image_url = $newFilename;

                        // Move to LocationAds category in CKBox
                        preg_match("/assets\/(.*?)\/images/", $newFilename, $matches);
                        $ckBoxImageId = $matches[1];
                        $ckBoxUtility->moveImage($ckBoxImageId);

                        break; // Stop checking other old filenames
                }
            }
            // Check if any old filename matches the locationAd record's photo_url with encoding
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($photoUrl) &&
                    strpos('/cloudfiles/clinics/' . $photoUrlEncoded, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                        // Update the locationAd record's image info
                        $locationAd->image_name = basename($oldFilename);
                        $locationAd->image_url = $newFilename;

                        // Move to LocationAds category in CKBox
                        preg_match("/assets\/(.*?)\/images/", $newFilename, $matches);
                        $ckBoxImageId = $matches[1];
                        $ckBoxUtility->moveImage($ckBoxImageId);

                        break; // Stop checking other old filenames
                }
            }

            // Save the entity back to the database
            $locationAdsTable->save($locationAd);
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
