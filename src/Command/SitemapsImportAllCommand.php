<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Routing\Router;

/**
 * SitemapsImportAll command.
 */
class SitemapsImportAllCommand extends Command
{
    protected $defaultTable = 'SitemapUrls';
    private $io;

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

        $parser->addArgument('noPrompt', [
            'noPrompt' => 'Add \'noPrompt\' to run without human interaction.'
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
        $this->io = $io;

        $noPrompt = $args->getArgument('noPrompt');

        $choice = 'n';
        if ($noPrompt !== 'noPrompt') {
            $choice = $io->askChoice('Do you want to import all sitemaps?', ['y', 'n'], 'n');
        }

        if ($noPrompt === 'noPrompt' || $choice === 'y') {
            $io->out("Importing all sitemaps...");

            $sitemapsTable = $this->fetchTable();

            $adds = [
                '/' => 1,
                '/hearing-aids' => 1,
                '/help' => 1,
                '/privacy-policy' => 1,
                '/terms-of-use' => 1,
                '/sitemap' => 1,
                '/about' => 1,
                '/contact-us' => 1,
                '/clinic' => 1,
            ];

            foreach($adds as $url => $priority){
                $newSitemapUrl = $sitemapsTable->newEntity([
                    'url' => $url,
                    'priority' => $priority
                ]);
                $sitemapsTable->save($newSitemapUrl);
            }

            $imports = [
                'wikis' => [
                    'priority' => .9,
                    'sitemapModel' => 'Help',
                ],
                'content' => [
                    'priority' => .8,
                    'sitemapModel' => 'Content',
                ],
                'locations'  => [
                    'priority' => .7,
                    'sitemapModel' => 'Clinic',
                ],
                'cities' => [
                    'priority' => .9,
                    'sitemapModel' => 'City',
                ],
                'states' => [
                    'priority' => .6,
                    'sitemapModel' => 'State'
                ],
                'corps'      => [
                    'priority' => .7,
                    'sitemapModel' => 'Corp'
                ]
            ];

            foreach ($imports as $type => $typeParams) {
                $this->import($type, $typeParams);
            }

        } else {
            $io->out("No sitemaps were imported.");
        }
    }

    public function import($type, $typeParams)
    {
        $io = $this->io;
        $io->out("Importing {$typeParams['sitemapModel']} sitemap...");
        $sitemapsTable = $this->fetchTable();

        if ($type === 'states') {
            $sitemapData = $this->fetchTable('locations')->allStatesForSiteMap();
        }   else {
            $sitemapData = $this->fetchTable($type)->find('forSitemap')->all();
        }

        foreach ($sitemapData as $item) {
            $newSitemapUrl = $sitemapsTable->newEntity([
                'model' => $typeParams['sitemapModel'],
                'url' => Router::url($item['hh_url']),
                'priority' => $typeParams['priority'],
            ]);

            $sitemapsTable->save($newSitemapUrl);

        }
    }

}
