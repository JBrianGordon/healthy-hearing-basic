<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;

/**
 * Wiki helper
 */
class WikiHelper extends Helper
{
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    protected $helpers = ['Html'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config): void
    {
        $this->Wikis = TableRegistry::getTableLocator()->get('Wikis');
    }

    /**
    * Find navigation bar of other wikis based on the given slug.
    * @param string slug.
    * @return array of navigation.
    */
    public function findNavBySlug($slug = null) {
        return $this->Wikis->findNavBySlug($slug);
    }

    public function getNavText($wiki = null) {
        if (!is_object($wiki)) {
            $wiki = $this->Wikis->get($wiki);
        }
        $text = '<div class="wiki-parent"><strong>' . $wiki->name . '</strong><br><span class="short">' . $wiki->short . '</span></div>';
        return $this->Html->link(
            $text,
            $wiki->hh_url,
            ['escape' => false]
        );
    }

    public function getNavManufText() {
        $link = '<div class="wiki-parent" style="min-height: 60px;"><strong>Hearing aid manufacturers</strong><br>
                    <span class="short short-parent">Compare products and learn more about hearing device manufacturers before you select hearing aids or cochlear implants.</span>
                </div>';
        return $this->Html->link($link, ['controller' => 'corps', 'action' => 'index'], ['escape' => false]);
    }
}
