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
                    if (is_array($row->hh_url)) {
                        $row['loc'] = Router::url(
                            array_merge(
                                ['plugin' => null, '_full' => true],
                                $row->hh_url
                            )
                        );
                     } else {
                        $row['loc'] = $row->hh_url;
                     }

                    return $row;
                });
            });

        return $query;
    }
}
