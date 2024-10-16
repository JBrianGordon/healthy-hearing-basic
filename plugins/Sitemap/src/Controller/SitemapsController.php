<?php
declare(strict_types=1);

namespace Sitemap\Controller;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\View\XmlView;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Sitemaps Controller
 *
 * @method \Sitemap\Model\Entity\Sitemap[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SitemapsController extends AppController
{
    use LocatorAwareTrait;

    public function viewClasses(): array
    {
        if (!$this->request->getParam('_ext')) {
            return [];
        }

        return [XmlView::class];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if ($this->request->getParam('_ext') === 'xml') {
            $this->xmlSitemap();
        }

        $this->htmlSitemap();

    }

    /**
     * xmlSitemap method
     * Generates XML index sitemap (available at /sitemap.xml)
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function xmlSitemap()
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

    /**
     * htmlSitemap method
     * Generates human-readable index sitemap (available at /sitemap)
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function htmlSitemap()
    {
        $this->set(
            'wikis',
            $this->getTableLocator()->get('Wikis')->find('forSitemap')
        );
        $this->set(
            'corps',
            $this->getTableLocator()->get('Corps')->find('forSitemap')
        );
    }

    public function main()
    {
        $mainSitemapUrlInfo = [];
        $mainSitemapUrls = [];

        if (Configure::check('Sitemap.mainUrls')) {
            $mainSitemapUrlInfo = Configure::read('Sitemap.mainUrls');
        }

        foreach ($mainSitemapUrlInfo as $url => $priority) {
            $mainSitemapUrls[] = [
                'loc' => Router::url($url, true),
                'priority' => $priority,
            ];
        }

        // Define a custom root node in the generated document.
        $this->viewBuilder()
            ->setOption('rootNode', 'urlset')
            ->setOption('serialize', ['@xmlns', 'url']);
        $this->set([
            // Define an attribute on the root node.
            '@xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
            'url' => $mainSitemapUrls,
        ]);
    }

    public function view($table)
    {
        $tableSitemapUrls = [];

        $sitemapTableAliases = Configure::read('Sitemap.tableAliases');

        if (array_key_exists($table, $sitemapTableAliases)) {
            $tableToSitemap = $this->fetchTable($sitemapTableAliases[$table]);
        } else {
            $tableToSitemap = $this->fetchTable($table);
        }

        $tableItemsForSitemap = $tableToSitemap->find('forSitemap');

        foreach ($tableItemsForSitemap as $item) {
            $tableSitemapUrls[] = [
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
            'url' => $tableSitemapUrls,
        ]);
    }
}
