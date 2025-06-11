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
 * UpdateCorpImageLinks command.
 */
class UpdateCorpImageLinksCommand extends Command
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

        $ckCategoryId = Configure::read('CK.corps-uploads');
        $ckBoxUtility = new CKBoxUtility($ckCategoryId);

        // Fetch all Corp entities
        $corpsTable =$this->fetchTable('corps');
        $corpsItems = $corpsTable->find('all');

        foreach ($corpsItems as $corp) {
            $io->out('Corp ID: ' . $corp->id);

            // ---- Corp Description Images ---- //

            // Create a new DOMDocument and load the HTML
            $doc = new DOMDocument();
            @$doc->loadHTML($corp->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            // Find all <img> elements
            $imgs = $doc->getElementsByTagName('img');

            foreach ($imgs as $img) {
                // Get the src attribute
                $oldSrc = $img->getAttribute('src');
                $oldSrcEncoded = $this->urlEncoder($oldSrc);

                // Check if any old filename partially matches the src
                foreach ($filenameMap as $oldFilename => $newFilename) {
                    if (strpos($oldSrc, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                        // Update the src attribute
                        $img->setAttribute('src', $newFilename);

                        // Move to manufacturers category in CKBox
                        preg_match("/assets\/(.*?)\/images/", $newFilename, $matches);
                        $ckBoxImageId = $matches[1];
                        $ckBoxUtility->moveImage($ckBoxImageId);

                        break 2; // Stop checking other old filenames and exit main foreach()
                    }
                }

                // Check if any old filename partially matches the src with encoding
                foreach ($filenameMap as $oldFilename => $newFilename) {
                    if (strpos($oldSrcEncoded, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                        // Update the src attribute
                        $img->setAttribute('src', $newFilename);

                        // Move to manufacturers category in CKBox
                        preg_match("/assets\/(.*?)\/images/", $newFilename, $matches);
                        $ckBoxImageId = $matches[1];
                        $ckBoxUtility->moveImage($ckBoxImageId);

                        break; // Stop checking other old filenames
                    }
                }
            }

            // Save the updated HTML back to the entity
            $corp->description = $doc->saveHTML();

            // ---- Thumb URL ---- //

            $thumbUrl = $corp->thumb_url;
            $thumbUrlEncoded = $this->urlEncoder($thumbUrl);

            // Check if any old filename matches the corp record's thumb_url
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($thumbUrl) &&
                    strpos($thumbUrl, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                    // Update the corp record's logo image information
                    $corp->logo_name = basename($oldFilename);
                    $corp->logo_url = $newFilename;

                    // Move to manufacturers category in CKBox
                    preg_match("/assets\/(.*?)\/images/", $newFilename, $matches);
                    $ckBoxImageId = $matches[1];
                    $ckBoxUtility->moveImage($ckBoxImageId);

                    break; // Stop checking other old filenames
                }
            }
            // Check if any old filename matches the corp record's thumb_url with encoding
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($thumbUrl) &&
                    strpos($thumbUrlEncoded, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                    // Update the corp record's logo image information
                    $corp->logo_name = basename($oldFilename);
                    $corp->logo_url = $newFilename;

                    // Move to manufacturers category in CKBox
                    preg_match("/assets\/(.*?)\/images/", $newFilename, $matches);
                    $ckBoxImageId = $matches[1];
                    $ckBoxUtility->moveImage($ckBoxImageId);

                    break; // Stop checking other old filenames
                }
            }

            // ---- Facebook Image ---- //

            $facebookImage = $corp->facebook_image;
            $facebookImageEncoded = $this->urlEncoder($corp->facebook_image);

            // Check if any old filename matches the corp record's facebook_image
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($facebookImage) &&
                    strpos($facebookImage, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                    // Update the corp record's facebook_image
                    $corp->facebook_image_name = basename($oldFilename);
                    $corp->facebook_image_url = $newFilename;

                    // Move to manufacturers category in CKBox
                    preg_match("/assets\/(.*?)\/images/", $newFilename, $matches);
                    $ckBoxImageId = $matches[1];
                    $ckBoxUtility->moveImage($ckBoxImageId);

                    break; // Stop checking other old filenames
                }
            }
            // Check if any old filename matches the corp record's facebook_image with encoding
            foreach ($filenameMap as $oldFilename => $newFilename) {
                if (!empty($facebookImage) &&
                    strpos($facebookImageEncoded, str_replace('https://www.healthyhearing.com', '', $oldFilename)) !== false) {
                    // Update the corp record's facebook_image
                    $corp->facebook_image_name = basename($oldFilename);
                    $corp->facebook_image_url = $newFilename;

                    // Move to manufacturers category in CKBox
                    preg_match("/assets\/(.*?)\/images/", $newFilename, $matches);
                    $ckBoxImageId = $matches[1];
                    $ckBoxUtility->moveImage($ckBoxImageId);

                    break; // Stop checking other old filenames
                }
            }

            // Save the entity back to the database
            $corpsTable->save($corp);
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
