<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * CopyZipcodesData command.
 */
class CopyZipcodesDataCommand extends Command
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
        $io->out('Copying zipcodes data into zips table...');

        $connection = $this->fetchTable('zips')->getConnection();
        $connection->begin();
        try {
            $connection->execute("
                INSERT INTO zips (zip, lat, lon, city, state, areacode, country_code)
                SELECT zip, lat, lon, city, state, areacode, country_code
                FROM zipcodesorig
                ORDER BY zip
            ");
            $connection->commit();
        } catch (\Throwable $e) {
            $connection->rollback();
            throw $e;
        }
    }


        // ORIGINAL

        // $zipcodesTable = $this->fetchTable('zipcodesorig');
        // $zipsTable = $this->fetchTable('zips');
        // $zipcodesQuery = $zipcodesTable->find()->all();

        // $progress = $io->helper('Progress');
        // $progress->init([
        //     'total' => count($zipcodesQuery),
        // ]);
        // foreach ($zipcodesQuery as $zipcode) {
        //     $copiedZip = $zipsTable->newEntity(
        //         $zipcode->toArray(),
        //         ['validate' => false]
        //     );

        //     if ($copiedZip->getErrors()) {
        //         $io->out(print_r($copiedZip->getErrors()));
        //     }

        //     if (!$zipsTable->save($copiedZip)) {
        //         $io->err(
        //             sprintf(
        //                 'Error saving zip record: %s',
        //                 $copiedZip->zip
        //             )
        //         );
        //         $error = json_encode($copiedZip->getErrors(), JSON_PRETTY_PRINT);
        //         $io->out($error);
        //         $io->out();
        //     }
        //     $progress->increment(1);
        //     $progress->draw();
        // } 
}
