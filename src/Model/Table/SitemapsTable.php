<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\Routing\Router;

class SitemapsTable extends Table
{
    public function fetchSitemapData()
    {
        //*** This will need to be replaced */
        // $tablesForSitemapIndex = [];
        // $urls = [];

        // if (Configure::check('Sitemap.tables')) {
        //     $tablesForSitemapIndex = Configure::read('Sitemap.tables');
        // }

        // foreach ($tablesForSitemapIndex as $table) {
        //     $urls[] = [
        //         'loc' => Router::url('sitemap_' . $table . '.xml', true),
        //     ];
        // }

        // return $urls;
    }
}
?>