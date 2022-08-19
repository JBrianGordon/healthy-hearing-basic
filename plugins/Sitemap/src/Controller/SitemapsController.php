<?php
declare(strict_types=1);

namespace Sitemap\Controller;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\View\XmlView;

/**
 * Sitemaps Controller
 *
 * @method \Sitemap\Model\Entity\Sitemap[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SitemapsController extends AppController
{
    public function viewClasses(): array
    {
        return [XmlView::class];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $tablesForSitemapIndex = [];
        $urls = [];

        if (Configure::check('Sitemap.tables')) {
            $tablesForSitemapIndex = Configure::read('Sitemap.tables');
        }

        foreach ($tablesForSitemapIndex as $table) {
            $urls[] = [
                'loc' => Router::url('sitemap_' . $table . '.xml', true),
            ];
        }

        // Define a custom root node in the generated document.
        $this->viewBuilder()
            ->setOption('rootNode', 'sitemapindex')
            ->setOption('serialize', ['@xmlns', 'sitemap']);
        $this->set([
            // Define an attribute on the root node.
            '@xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
            'sitemap' => $urls,
        ]);
    }

    public function view($table)
    {
        $itemUrls = [];
        $tableToSitemap = $this->fetchTable($table);

        $tableItemsForSitemap = $tableToSitemap->find('forSitemap');

        foreach ($tableItemsForSitemap as $item) {
            $itemUrls[] = [
                'loc' => $item['loc'],
                'priority' => $item['priority'],
            ];
        }

        // Define a custom root node in the generated document.
        $this->viewBuilder()
            ->setOption('rootNode', 'urlset')
            ->setOption('serialize', ['@xmlns', 'url']);
        $this->set([
            // Define an attribute on the root node.
            '@xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
            'url' => $itemUrls,
        ]);
    }
}
