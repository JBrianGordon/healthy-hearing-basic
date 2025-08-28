<?php
declare(strict_types=1);

namespace Sitemap\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;
use Cake\Routing\Router;

/**
 * Sitemap behavior
 */
class SitemapBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'cacheConfigKey' => 'default',
        'conditions' => [],
        'fields' => [],
        'order' => [],
    ];

    public function findForSitemap(Query $query, array $options)
    {
        $query = $query
            ->where($this->_config['conditions'])
            ->select($this->_config['fields'])
            ->order($this->_config['order'])
            ->formatResults(function ($results) {
                return $results->map(function ($row) {
                    if (!empty($row->hh_url)) {
                        $row['loc'] = Router::url($row->hh_url, true);
                    } else {
                        $row['loc'] = '';
                    }

                    // Check for 'last_modified' field
                    if ($row->has('last_modified')) {
                        $row['lastmod'] = $row->get('last_modified')->format('Y-m-d');
                    }

                    return $row;
                });
            });

        return $query;
    }
}
