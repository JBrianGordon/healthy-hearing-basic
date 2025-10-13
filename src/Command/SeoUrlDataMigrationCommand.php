<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * SeoUrlDataMigration command.
 */
class SeoUrlDataMigrationCommand extends Command
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
        $seoUrisTable = $this->fetchTable('seo_uris');
        $seoUrlsTable = $this->fetchTable('seo_urls');

        // Redirects
        $io->out('Copying redirects into SeoUrls table...');

        $redirectsTable = $this->fetchTable('seo_redirects');
        $redirects = $redirectsTable->find()->all();

        foreach ($redirects as $redirect) {
            $seoUriForRedirect = $seoUrisTable->find()->where(['id' => $redirect['seo_uri_id']])->first();
            $newRedirect = $seoUrlsTable->newEntity(
                [
                    'seo_uri_i_d' => $seoUriForRedirect['id'],
                    'url' => $seoUriForRedirect['uri'],
                    'redirect_url' => $redirect['redirect'],
                    'redirect_is_active' => $redirect['is_active']
                ]
            );

            if ($newRedirect->getErrors()) {
                $io->out(print_r($newRedirect->getErrors()));
            }

            $seoUrlsTable->save($newRedirect);
        }

        // SEO Titles
        $io->out('Copying titles into SeoUrls table...');

        $titlesTable = $this->fetchTable('seo_titles');
        $titles = $titlesTable->find()->all();

        foreach ($titles as $title) {
            $seoUriWithTitle = $seoUrisTable->find()->where(['id' => $title['seo_uri_id']])->first();
            if ($seoUriWithTitle) {
                $currentSeoUrl = $seoUrlsTable->find()->where(['seo_uri_i_d' => $seoUriWithTitle['id']])->first();
                if ($currentSeoUrl) {
                    $currentSeoUrl->seo_title = $title['title'];
                    $seoUrlsTable->save($currentSeoUrl);
                } else {
                    $newSeoUrl = $seoUrlsTable->newEntity(
                        [
                            'url' => $seoUriWithTitle['uri'],
                            'seo_title' => $title['title'],
                            'seo_uri_i_d' => $title['seo_uri_id'],
                        ]
                    );
                    $seoUrlsTable->save($newSeoUrl);
                }
            }
        }

        // SEO Status Codes
        $io->out('Copying status codes into SeoUrls table...');

        $statusCodesTable = $this->fetchTable('seo_status_codes');
        $statusCodes = $statusCodesTable->find()->all();

        foreach ($statusCodes as $statusCode) {
            $seoUriWithStatusCode = $seoUrisTable->find()->where(['id' => $statusCode['seo_uri_id']])->first();
            if ($seoUriWithStatusCode) {
                $currentSeoUrl = $seoUrlsTable->find()->where(['seo_uri_i_d' => $seoUriWithStatusCode['id']])->first();
                if ($currentSeoUrl) {
                    $currentSeoUrl->is_410 = true;
                    $seoUrlsTable->save($currentSeoUrl);
                } else {
                    $newSeoUrl = $seoUrlsTable->newEntity(
                        [
                            'url' => $seoUriWithStatusCode['uri'],
                            'is_410' => true,
                            'seo_uri_i_d' => $statusCode['seo_uri_id'],
                        ]
                    );
                    $seoUrlsTable->save($newSeoUrl);
                }
            }
        }

        // SEO Meta Descriptions
        $io->out('Copying meta descriptions into SeoUrls table...');

        $metaTagsTable = $this->fetchTable('seo_meta_tags');
        $metaTags = $metaTagsTable->find()->all();

        foreach ($metaTags as $metaTag) {
            if ($metaTag['name'] !== 'msvalidate.01') {
                $seoUriWithMetaTag = $seoUrisTable->find()->where(['id' => $metaTag['seo_uri_id']])->first();
                $io->out($metaTag['seo_uri_id']);
                if ($seoUriWithMetaTag) {
                    $currentSeoUrl = $seoUrlsTable->find()->where(['seo_uri_i_d' => $seoUriWithMetaTag['id']])->first();
                    if ($currentSeoUrl) {
                        $currentSeoUrl->seo_meta_description = $metaTag['content'];
                        $seoUrlsTable->save($currentSeoUrl);
                    } else {
                        $newSeoUrl = $seoUrlsTable->newEntity(
                            [
                                'url' => $seoUriWithMetaTag['uri'],
                                'seo_meta_description' => $metaTag['content'],
                                'seo_uri_i_d' => $metaTag['seo_uri_id'],
                            ]
                        );
                        $seoUrlsTable->save($newSeoUrl);
                    }
                }
            }
        }
    }
}